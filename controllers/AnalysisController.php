<?php

namespace app\controllers;

use app\models\StudentAttendance;
use app\models\Subjects;
use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\StudentInfo;
use app\models\search\StudentInfoSearch;
use app\models\Exam;
use yii\data\ActiveDataProvider;
use app\models\RefClass;
use app\models\RefGroup;
use app\models\RefSection;
use app\models\StudentParentsInfo;

use mPDF;

/**
 * ExamsController implements the CRUD actions for Exam model.
 */
class AnalysisController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Index
     * @return mixed
     */
    public function actionIndex()
    {
        $request = Yii::$app->request;
        $model = new StudentInfo();
        /*
        *   Process for non-ajax request
        */
        return $this->render('index', [
            'model' => $model,
        ]);
    }

    /*get section analysis */

    public function actionGetSectionAnalysis()
    {

        if(Yii::$app->user->isGuest){
            return $this->redirect('site/login');
        }else{
            if(Yii::$app->request->post()){
                $data= Yii::$app->request->post();
                $searchModel = new StudentInfoSearch();

                $searchModel->is_active=1;
                $class      = $data['class_id'];
                $group      = $data['group_id'];
                $section    = $data['section_id'];

                /*filter for students details.*/
                if($class){
                    $searchModel->class_id = $class;
                }
                if($group){
                    $searchModel->group_id = $group;
                }
                if($section){
                    $searchModel->section_id = $section;
                }

                /*get exams. details*/
                $examQuery = Exam::find()
                    ->select(['fk_class_id','fk_group_id','fk_section_id','fk_exam_type'])
                    ->where([
                        'fk_branch_id'  =>Yii::$app->common->getBranch(),
                        'fk_class_id'   => $class,
                        'fk_group_id'   => ($group)?$group:null,
                        'fk_section_id' => $section,
                    ])->groupBy(['fk_class_id','fk_group_id','fk_section_id','fk_exam_type']);



                $dataproviderExams = new ActiveDataProvider([
                    'query'=>$examQuery,
                     'pagination' => false,
                ]);

                /* get subjects details*/
                $subjectsQuery = Subjects::find()
                    ->leftJoin('subject_division', 'subject_division.fk_subject_id = subjects.id')
                    ->leftJoin('ref_section','ref_section.class_id=subjects.fk_class_id')
                    ->where([
                        'subjects.fk_class_id'=>$class,
                        'subjects.fk_group_id'=>($group)?$group:null,
                        'ref_section.section_id'=>$section,
                        'subjects.fk_branch_id'=>Yii::$app->common->getBranch()
                    ]);


                $dataproviderSubjects = new ActiveDataProvider([
                    'query'=>$subjectsQuery,
                    'pagination' => [
                     'pageSize' => 100,
                    ],
                ]);

                    /*SELECT sb.*,sd.title from subjects sb
                    left JOIN subject_division sd ON sd.fk_subject_id=sb.id
                    LEFT JOIN ref_section rs ON rs.class_id=sb.fk_class_id
                    WHERE sb.fk_class_id =11 AND sb.fk_group_id=7 AND rs.section_id=16*/

                $searchModel->fk_branch_id = Yii::$app->common->getBranch();
                $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

                $dataProvider->pagination  = false;






                $data= $this->renderAjax('get-section-analysis', [
                    'searchModel'       => $searchModel,
                    'dataProvider'      => $dataProvider,
                    'dataProviderSubj'  => $dataproviderSubjects,
                    'dataProviderExams' => $dataproviderExams,
                    'class_id'          => $class,
                    'section_id'        => $section,
                    'group_id'          => $group,
                ]);
                return json_encode(['status'=>1,'details'=>$data]);
            }else{
                return $this->redirect('site/index');
            }
        }
    }


    public function actionGetSectionPdf(){
       $searchModel = new StudentInfoSearch();
       $class_val= Yii::$app->request->get('classval');
       $groupval= Yii::$app->request->get('groupval');
       $sectionval= Yii::$app->request->get('sectionval');
       $searchModel->is_active=1;
                $class      = $class_val;
                $group      = $groupval;
                $section    = $sectionval;

                /*filter for students details.*/
                if($class){
                    $searchModel->class_id = $class;
                }
                if($group){
                    $searchModel->group_id = $group;
                }
                if($section){
                    $searchModel->section_id = $section;
                }

        /*query*/
                $StudentQuery = StudentInfo::find()
                    ->select(['class_id','group_id','section_id'])
                    ->where([
                        'fk_branch_id'  =>Yii::$app->common->getBranch(),
                        'class_id'   => $class_val,
                        'group_id'   => ($groupval)?$groupval:null,
                        'section_id' => $sectionval,
                    ])->groupBy(['class_id','group_id','section_id']);

                      $dataprovider = $StudentQuery->all();



                $searchModel->fk_branch_id = Yii::$app->common->getBranch();
                $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
                 $dataProvider->pagination  = false;

                $viewx= $this->renderPartial('section-pdf', [
                    'searchModel'       => $searchModel,
                    'dataProvider'      => $dataProvider,
                    'class_val'          => $class_val,
                    'sectionval'        => $sectionval,
                    'groupval'          => $groupval,
                ]);

                $getClass=RefClass::find()->where(['class_id'=>$class_val])->one();
                $getGroup=RefGroup::find()->where(['group_id'=>$groupval])->one();
                $getSection=RefSection::find()->where(['section_id'=>$sectionval])->one();
                



       // $viewx=$this->renderAjax('section-pdf',['dataprovider'=>$dataprovider]);
        $this->layout = 'pdf';
        $mpdf = new mPDF();
       
        $mpdf->WriteHTML("<h3 style='text-align:center'>Section Wise Report($getClass->title - $getGroup->title - $getSection->title ) </h3>");
        $mpdf->WriteHTML($viewx);
        $mpdf->Output('section-pdf-'.date("d-m-Y").'.pdf', 'D');
      
    }

    public function actionGetExamPdf(){
        $searchModel = new StudentInfoSearch();
       $class_val= Yii::$app->request->get('classval');
       $groupval= Yii::$app->request->get('groupval');
       $sectionval= Yii::$app->request->get('sectionval');
       
       $searchModel->is_active=1;
                $class      = $class_val;
                $group      = $groupval;
                $section    = $sectionval;

                /*filter for students details.*/
                if($class){
                    $searchModel->class_id = $class;
                }
                if($group){
                    $searchModel->group_id = $group;
                }
                if($section){
                    $searchModel->section_id = $section;
                }

                 /*get exams. details*/
                $examQuery = Exam::find()
                    ->select(['fk_class_id','fk_group_id','fk_section_id','fk_exam_type'])
                    ->where([
                        'fk_branch_id'  =>Yii::$app->common->getBranch(),
                        'fk_class_id'   => $class,
                        'fk_group_id'   => ($group)?$group:null,
                        'fk_section_id' => $section,
                    ])->groupBy(['fk_class_id','fk_group_id','fk_section_id','fk_exam_type']);



                $dataproviderExams = new ActiveDataProvider([
                    'query'=>$examQuery,
                     'pagination' => false,
                ]);

                $data= $this->renderAjax('get-exam-analysis-pdf', [
                    'searchModel'       => $searchModel,
                    'dataProviderExams' => $dataproviderExams,
                    'class_id'          => $class,
                    'section_id'        => $section,
                    'group_id'          => $group,
                ]);

                $getClass=RefClass::find()->where(['class_id'=>$class_val])->one();
                $getGroup=RefGroup::find()->where(['group_id'=>$groupval])->one();
                $getSection=RefSection::find()->where(['section_id'=>$sectionval])->one();

                

       $this->layout = 'pdf';
        $mpdf = new mPDF();
        $mpdf->WriteHTML("<h3 style='text-align:center'>Exam Details Report($getClass->title - $getGroup->title - $getSection->title ) </h3>");
        $mpdf->WriteHTML($data);
        $mpdf->Output('section-exam-pdf-'.date("d-m-Y").'.pdf', 'D');
    }


    public function actionGetSubjectPdf(){
        $searchModel = new StudentInfoSearch();
       $class_val= Yii::$app->request->get('classval');
       $groupval= Yii::$app->request->get('groupval');
       $sectionval= Yii::$app->request->get('sectionval');
       
       $searchModel->is_active=1;
                $class      = $class_val;
                $group      = $groupval;
                $section    = $sectionval;

                /*filter for students details.*/
                if($class){
                    $searchModel->class_id = $class;
                }
                if($group){
                    $searchModel->group_id = $group;
                }
                if($section){
                    $searchModel->section_id = $section;
                }

                /* get subjects details*/
                $subjectsQuery = Subjects::find()
                    ->leftJoin('subject_division', 'subject_division.fk_subject_id = subjects.id')
                    ->leftJoin('ref_section','ref_section.class_id=subjects.fk_class_id')
                    ->where([
                        'subjects.fk_class_id'=>$class,
                        'subjects.fk_group_id'=>($group)?$group:null,
                        'ref_section.section_id'=>$section,
                        'subjects.fk_branch_id'=>Yii::$app->common->getBranch()
                    ]);


                $dataproviderSubjects = new ActiveDataProvider([
                    'query'=>$subjectsQuery,
                    
                ]);

                $data= $this->renderAjax('get-subject-analysis-pdf', [
                    'searchModel'       => $searchModel,
                    'dataProviderSubj'  => $dataproviderSubjects,
                    'class_id'          => $class,
                    'section_id'        => $section,
                    'group_id'          => $group,
                ]);

                $getClass=RefClass::find()->where(['class_id'=>$class_val])->one();
                $getGroup=RefGroup::find()->where(['group_id'=>$groupval])->one();
                $getSection=RefSection::find()->where(['section_id'=>$sectionval])->one();
                /*$mpdf->WriteHTML("<h3 style='text-align:center'>Subject Details Report($getClass->title - $getGroup->title - $getSection->title ) </h3>");*/
                

                $this->layout = 'pdf';
        $mpdf = new mPDF();
        $mpdf->WriteHTML("<h3 style='text-align:center'>Subject Details Report($getClass->title - $getGroup->title - $getSection->title ) </h3>");
        $mpdf->WriteHTML($data);
        $mpdf->Output('section-subject-pdf-'.date("d-m-Y").'.pdf', 'D');
    }

    /*get exam ananlysis*/

    public function actionGetExamAnalysis(){
        if(Yii::$app->user->isGuest){
            return $this->redirect('site/login');
        }else{
            if(Yii::$app->request->post()) {
                $data = Yii::$app->request->post();
                $subjects_Query =  Yii::$app->db->createCommand('select c.class_id,c.title,s.section_id,s.title, sb.title as subject,((sum(sm.marks_obtained))/(sum(ex.total_marks)))*100 as marks_obtained from exam ex inner join exam_type et on et.id=ex.fk_exam_type inner join ref_class c on c.class_id=ex.fk_class_id left join ref_group g on g.group_id=ex.fk_group_id inner join ref_section s on s.section_id=ex.fk_section_id inner join subjects sb on sb.id=ex.fk_subject_id left join student_marks sm on sm.fk_exam_id=ex.id inner join student_info st on st.stu_id=sm.fk_student_id inner join user u on u.id=st.user_id where et.id='.$data["exam_type_id"].' and c.class_id='.$data["class_id"].' and s.section_id='.$data["section_id"].' and st.is_active =1 GROUP by  sb.title order by marks_obtained desc')->queryAll();

                $pi_query = Yii::$app->db->createCommand("select count(sa.marks_obtained) as marks_obtain, 
                    case 
                        when sa.marks_obtained >=90 THEN 'A+'
                        when sa.marks_obtained >=85 then 'A'
                        when sa.marks_obtained >=80 then 'A-'
                        when sa.marks_obtained >=75 then 'B+'
                        when sa.marks_obtained >=70 then 'B'
                        when sa.marks_obtained >=65 then 'B-'
                        when sa.marks_obtained >=60 then 'C+'
                        when sa.marks_obtained >=55 then 'C'
                        when sa.marks_obtained >=50 then 'D' 
                        else 'F'
                        end as grade
                    from 
                    (
                    select st.stu_id,concat(u.first_name,'',u.last_name) as `student name`,et.type as `exam type`, c.title as `class`, g.title as `group`, s.title as `section`, ((sum(sm.marks_obtained))/(sum(ex.total_marks)))*100 as marks_obtained from exam ex inner join exam_type et on et.id=ex.fk_exam_type inner join ref_class c on c.class_id=ex.fk_class_id left join ref_group g on g.fk_class_id=ex.fk_class_id left join ref_section s on s.class_id=ex.fk_class_id inner join subjects sb on sb.id=ex.fk_subject_id left join student_marks sm on sm.fk_exam_id=ex.id inner join student_info st on st.stu_id=sm.fk_student_id inner join user u on u.id=st.user_id where et.id=".$data["exam_type_id"]." and c.class_id=".$data["class_id"]."  GROUP by st.stu_id,`student name`,et.type , c.title , g.title , s.title)sa GROUP by grade")->queryAll();

                $details= $this->renderAjax('exam-analysis', [
                    'data'            => $data,
                    'pi_query'        => $pi_query,
                    'subjects_Query'  => $subjects_Query
                ]);
                return json_encode(['status' => 1, 'details' => $details]);
            }
        }
    }

    /*get attendance analysis*/
    public function actionGetAttendanceAnalysis(){
        if(Yii::$app->user->isGuest){
            return $this->redirect('site/login');
        }else{
            if(Yii::$app->request->post()) {
                $data       = Yii::$app->request->post();
                /*get exams.*/
                $searchModel = new StudentInfoSearch();

                $searchModel->is_active=1;
                $class              = $data['class_id'];
                $group              = $data['group_id'];
                $section            = $data['section_id'];
                $yearMonth          = $data['year_month'];
                $attendacne_type    = $data['attendance_type'];


                /*filter for students details.*/
                if($class){
                    $searchModel->class_id = $class;
                }
                if($group){
                    $searchModel->group_id = $group;
                }
                if($section){
                    $searchModel->section_id = $section;
                }


                $searchModel->fk_branch_id = Yii::$app->common->getBranch();
                $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

                /*render view*/
                $data = $this->renderAjax('attendance-analysis', [
                    'searchModel'       => $searchModel,
                    'dataProvider'      => $dataProvider,
                    'class_id'          => $class,
                    'section_id'        => $section,
                    'group_id'          => $group,
                    'year_month'        => ($yearMonth)?$yearMonth:'',
                    'attendance_type'   => $attendacne_type,
                ]);
                return json_encode(['status'=>1,'details'=>$data]);

            }else{
                return $this->redirect('site/login');
            }
        }

    }

    public function actionGetAttendanceAnalysisPdf(){
        $searchModel = new StudentInfoSearch();
        $class_val= Yii::$app->request->get('classId');
        $groupval= Yii::$app->request->get('groupId');
        $sectionval= Yii::$app->request->get('sectionId');
        $attendanceType= Yii::$app->request->get('attendanceType');
                $searchModel->is_active=1;
                $class      = $class_val;
                $group      = $groupval;
                $section    = $sectionval;
                $attendacne_type    = $attendanceType;


                /*filter for students details.*/
                if($class){
                    $searchModel->class_id = $class;
                }
                if($group){
                    $searchModel->group_id = $group;
                }
                if($section){
                    $searchModel->section_id = $section;
                }


                $searchModel->fk_branch_id = Yii::$app->common->getBranch();
                $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
                $dataProvider->pagination=false;

                $getClass=RefClass::find()->where(['class_id'=>$class_val])->one();
                $getGroup=RefGroup::find()->where(['group_id'=>$groupval])->one();
                $getSection=RefSection::find()->where(['section_id'=>$sectionval])->one();


                /*render view*/
                $data = $this->renderAjax('attendance-analysis-overall-pdf', [
                    'searchModel'       => $searchModel,
                    'dataProvider'      => $dataProvider,
                    'class_id'          => $class,
                    'section_id'        => $section,
                    'group_id'          => $group,
                    'attendance_type'   => $attendacne_type,
                ]);

                $this->layout = 'pdf';
        $mpdf = new mPDF();
        $mpdf->WriteHTML("<h3 style='text-align:center'>Over All attendance Report($getClass->title - $getGroup->title - $getSection->title ) </h3>");
        $mpdf->WriteHTML($data);
        $mpdf->Output('ovell-attendance-report-pdf-'.date("d-m-Y").'.pdf', 'D');
    } 

    public function actionGetAttendanceAnalysisMonthlyPdf(){
        if(Yii::$app->user->isGuest){
            return $this->redirect('site/login');
        }else{
            if(Yii::$app->request->get()) {
                $data       = Yii::$app->request->get();
                /*get exams.*/
                $searchModel = new StudentInfoSearch();

                $searchModel->is_active=1;
                $class              = $data['classId'];
                $group              = $data['groupId'];
                $section            = $data['sectionId'];
               $yearMonth          = $data['month'];
               $attendacne_type    = $data['attendanceType'];


                /*filter for students details.*/
                if($class){
                    $searchModel->class_id = $class;
                }
                if($group){
                    $searchModel->group_id = $group;
                }
                if($section){
                    $searchModel->section_id = $section;
                }


                $searchModel->fk_branch_id = Yii::$app->common->getBranch();
                $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
                $dataProvider->pagination=false;
                /*render view*/
                $data = $this->renderAjax('attendance-analysis-monthly-pdf', [
                    'searchModel'       => $searchModel,
                    'dataProvider'      => $dataProvider,
                    'class_id'          => $class,
                    'section_id'        => $section,
                    'group_id'          => $group,
                    'year_month'        => ($yearMonth)?$yearMonth:'',
                    'attendance_type'   => $attendacne_type,
                ]);

                $getClass=RefClass::find()->where(['class_id'=>$class])->one();
                $getGroup=RefGroup::find()->where(['group_id'=>$group])->one();
                $getSection=RefSection::find()->where(['section_id'=>$section])->one();
             
                $this->layout = 'pdf';
        $mpdf = new mPDF();
        $mpdf->WriteHTML("<h3 style='text-align:center'>Monthly attendance Report($getClass->title - $getGroup->title - $getSection->title ) </h3>");
        $mpdf->WriteHTML($data);
        $mpdf->Output('Monthly-attendance-report-pdf-'.date("d-m-Y").'.pdf', 'D');
                return json_encode(['status'=>1,'details'=>$data]);


            }else{
                return $this->redirect('site/login');
            }
        }
    }

     public function actionGetAttendanceAnalysisMonthlyPdf1(){
        /*$searchModel = new StudentInfoSearch();
        $class_val= Yii::$app->request->get('classId');
        $groupval= Yii::$app->request->get('groupId');
        $sectionval= Yii::$app->request->get('sectionId');
        $month= Yii::$app->request->get('month');
        $attendanceType= Yii::$app->request->get('attendanceType');
        */

            $data       = Yii::$app->request->get();
                /*get exams.*/
                $searchModel = new StudentInfoSearch();

                $searchModel->is_active=1;
                $class              = $data['classId'];
                $group              = $data['groupId'];
                $section            = $data['sectionId'];
                $yearMonth          = $data['month'];
                $attendacne_type    = $data['attendanceType'];


                /*filter for students details.*/
                if($class){
                    $searchModel->class_id = $class;
                }
                if($group){
                    $searchModel->group_id = $group;
                }
                if($section){
                    $searchModel->section_id = $section;
                }

                 $searchModel->fk_branch_id = Yii::$app->common->getBranch();
                $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

                $searchModel->fk_branch_id = Yii::$app->common->getBranch();
                $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
                $getClass=RefClass::find()->where(['class_id'=>$class])->one();
                $getGroup=RefGroup::find()->where(['group_id'=>$group])->one();
                $getSection=RefSection::find()->where(['section_id'=>$section])->one();
                $dataProvider->pagination=false;

                /*render view*/
                


                $data = $this->renderAjax('attendance-analysis-monthly-pdf', [
                    'searchModel'       => $searchModel,
                    'dataProvider'      => $dataProvider,
                    'class_id'          => $class,
                    'section_id'        => $section,
                    'group_id'          => $group,
                    'year_month'        => ($yearMonth)?$yearMonth:'',
                    'attendance_type'   => $attendacne_type,
                ]);

                $this->layout = 'pdf';
        $mpdf = new mPDF();
        $mpdf->WriteHTML("<h3 style='text-align:center'>Monthly attendance Report($getClass->title - $getGroup->title - $getSection->title ) </h3>");
        $mpdf->WriteHTML($data);
        $mpdf->Output('Monthly-attendance-report-pdf-'.date("d-m-Y").'.pdf', 'D');
    } 
    
    /*send whole class sms*/
    
    public function actionSendWhole(){
       $getclassId=Yii::$app->request->post('classid'); 
       $getgroupId=Yii::$app->request->post('group');
       $getSectionId=Yii::$app->request->post('sectionid'); 
       $textArea=Yii::$app->request->post('textarea');  
                 
       $stuQuery = StudentInfo::find()
            ->select(["student_info.stu_id stu_id","student_info.user_id user_id","student_parents_info.contact_no contact"])
            ->innerJoin('student_parents_info','student_parents_info.stu_id = student_info.stu_id')
            ->where([
            'student_info.fk_branch_id'  =>Yii::$app->common->getBranch(),
            'student_info.is_active' =>1,
            'student_info.class_id'   => $getclassId,
            'student_info.group_id'   => ($getgroupId)?$getgroupId:null,
            'student_info.section_id' => $getSectionId,
            ])->asArray()->all();
            //createCommand()->getRawSql();
            //echo '<pre>';print_r($stuQuery);die;

                    
        //echo '<pre>';print_r($stuQuery); 
        
        foreach ($stuQuery as $query){
             $contct= $query['contact'];
              
              $stu_id= $query['stu_id'];
              Yii::$app->common->SendSms($contct,$textArea,$stu_id);
        }  
       // die;    
    
    } //end of function


     /*send whole class sms*/
    
    public function actionSendWholeSchool(){
        $textArea=Yii::$app->request->post('textarea');  
                
        /*$stuQuery = StudentInfo::find()
        ->select(["student_info.stu_id stu_id","student_info.user_id user_id","student_parents_info.contact_no contact"])
        ->innerJoin('student_parents_info','student_parents_info.stu_id = student_info.stu_id')
        ->where([
        'student_info.fk_branch_id'  =>Yii::$app->common->getBranch(),
        'student_info.is_active'  =>1,
        //'student_info.class_id'   => $getclassId,
        //'student_info.group_id'   => ($getgroupId)?$getgroupId:null,
        // 'student_info.section_id' => $getSectionId,
        ])->all();*/
        $stuQuery=yii::$app->db->createCommand("
            SELECT `student_info`.`stu_id` AS `stu_id`, `student_info`.`user_id` AS `user_id`, `student_parents_info`.`contact_no` AS `contact` FROM `student_info` INNER JOIN `student_parents_info` ON student_parents_info.stu_id = student_info.stu_id WHERE (`student_info`.`fk_branch_id`=".yii::$app->common->getBranch().") AND (`student_info`.`is_active`=1)
            ")->queryAll();

        foreach ($stuQuery as $query){
            //Send sms to students
            $contct= $query['contact'];
            $stu_id= $query['stu_id'];
            Yii::$app->common->SendSms($contct,$textArea,$stu_id);
          
            //Send sms to parents
            $getparentcontact = StudentParentsInfo::find()->select('contact_no')->where(['stu_id' => $stu_id])->one();
            if(!isset($getparentcontact->contact_no) || !$getparentcontact->contact_no){
                if(!$success){
                    Yii::$app->session->setFlash('error', 'There is no parent contact phone number.');
                    $this->redirect(['dashboard']);
                    exit;
                }
            }
            $sendParentContact = $getparentcontact->contact_no;
            $success = Yii::$app->common->SendSms($sendParentContact, $textArea, $stu_id);
        }       

        return $this->render('index');
        echo true;
        exit;
    } //end of function
} // end of class
