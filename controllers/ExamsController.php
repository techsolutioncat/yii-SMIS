<?php

namespace app\controllers;

use app\models\ExamType;
use app\models\RefClass;
use app\models\StudentInfo;
use app\models\StudentMarks;
use Yii;
use app\models\Exam;
use app\models\search\ExamsSearch;
use yii\data\ActiveDataProvider;
use yii\db\Query;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use \yii\web\Response;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use mPDF;

/**
 * ExamsController implements the CRUD actions for Exam model.
 */
class ExamsController extends Controller
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
                    'delete' => ['post'],
                    'bulk-delete' => ['post'],
                ],
            ],
        ];
    }


    /*search exam details*/
    public function actionExamDetails()
    {
        $model = new Exam();
        /*
          *   Process for non-ajax request
          */
        return $this->render('exam-details', [
            'model' => $model,
        ]);
    }
    /**
     * Lists all Exam models.
     * @return mixed
     */
    public function actionIndex()
    {    
        $searchModel = new ExamsSearch();
        $searchModel->fk_branch_id = Yii::$app->common->getBranch();
        if(count(Yii::$app->request->get())== 0 ){
            $searchModel->id = 0;
        }else{
            if(empty(Yii::$app->request->get('ExamsSearch')['fk_exam_type']) && empty(Yii::$app->request->get('ExamsSearch')['fk_class_id'])){
                $searchModel->id = 0;
            }
        }
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }


    /**
     * Displays a single Exam model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {   
        $request = Yii::$app->request;
        $model= $this->findModel($id);
        if($request->isAjax){
            Yii::$app->response->format = Response::FORMAT_JSON;
            return [
                    'title'=> "Exam : ".$model->fkExamType->type,
                    'content'=>$this->renderAjax('view', [
                        'model' => $model,
                    ]),
                    'footer'=> Html::button('Close',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                            Html::a('Edit',['update','id'=>$id],['class'=>'btn btn-primary','role'=>'modal-remote'])
                ];    
        }else{
            return $this->render('view', [
                'model' => $this->findModel($id),
            ]);
        }
    }


    public function actionCreateExam(){
        $request = Yii::$app->request;
        $model = new Exam();
        /*
           *   Process for non-ajax request
           */
        if ($model->load($request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create-exam', [
                'model' => $model,
            ]);
        }
    }


    /**
     * Creates a new Exam model.
     * For ajax request will return json object
     * and for non-ajax request if creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $request = Yii::$app->request;
        $model = new Exam();  

        if($request->isAjax){
            /*
            *   Process for ajax request
            */
            Yii::$app->response->format = Response::FORMAT_JSON;
            if($request->isGet){
                return [
                    'title'=> "Create new Exam",
                    'content'=>$this->renderAjax('create', [
                        'model' => $model,
                    ]),
                    'footer'=> Html::button('Close',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                                Html::button('Save',['class'=>'btn btn-primary','type'=>"submit"])
        
                ];         
            }else if($model->load($request->post()) && $model->save()){
                return [
                    'forceReload'=>'#crud-datatable-pjax',
                    'title'=> "Create new Exam",
                    'content'=>'<span class="text-success">Create Exam success</span>',
                    'footer'=> Html::button('Close',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                            Html::a('Create More',['create'],['class'=>'btn btn-primary','role'=>'modal-remote'])
        
                ];         
            }else{           
                return [
                    'title'=> "Create new Exam",
                    'content'=>$this->renderAjax('create', [
                        'model' => $model,
                    ]),
                    'footer'=> Html::button('Close',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                                Html::button('Save',['class'=>'btn btn-primary','type'=>"submit"])
        
                ];         
            }
        }else{
            /*
            *   Process for non-ajax request
            */
            if ($model->load($request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            } else {
                return $this->render('create', [
                    'model' => $model,
                ]);
            }
        }
       
    }

    /**
     * Updates an existing Exam model.
     * For ajax request will return json object
     * and for non-ajax request if update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $request = Yii::$app->request;
        $model = $this->findModel($id);       

        if($request->isAjax){
            /*
            *   Process for ajax request
            */
            Yii::$app->response->format = Response::FORMAT_JSON;
            if($request->isGet){
                return [
                    'title'=> "Update Exam #".$id,
                    'content'=>$this->renderAjax('update', [
                        'model' => $model,
                    ]),
                    'footer'=> Html::button('Close',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                                Html::button('Save',['class'=>'btn btn-primary','type'=>"submit"])
                ];         
            }else if($model->load($request->post()) && $model->save()){
                return [
                    'forceReload'=>'#crud-datatable-pjax',
                    'title'=> "Exam #".$id,
                    'content'=>$this->renderAjax('view', [
                        'model' => $model,
                    ]),
                    'footer'=> Html::button('Close',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                            Html::a('Edit',['update','id'=>$id],['class'=>'btn btn-primary','role'=>'modal-remote'])
                ];    
            }else{
                 return [
                    'title'=> "Update Exam #".$id,
                    'content'=>$this->renderAjax('update', [
                        'model' => $model,
                    ]),
                    'footer'=> Html::button('Close',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                                Html::button('Save',['class'=>'btn btn-primary','type'=>"submit"])
                ];        
            }
        }else{
            /*
            *   Process for non-ajax request
            */
            if ($model->load($request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            } else {
                return $this->render('update', [
                    'model' => $model,
                ]);
            }
        }
    }

    /**
     * Delete an existing Exam model.
     * For ajax request will return json object
     * and for non-ajax request if deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $request = Yii::$app->request;
        $this->findModel($id)->delete();

        if($request->isAjax){
            /*
            *   Process for ajax request
            */
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ['forceClose'=>true,'forceReload'=>'#crud-datatable-pjax'];
        }else{
            /*
            *   Process for non-ajax request
            */
            return $this->redirect(['index']);
        }


    }

     /**
     * Delete multiple existing Exam model.
     * For ajax request will return json object
     * and for non-ajax request if deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionBulkDelete()
    {        
        $request = Yii::$app->request;
        $pks = explode(',', $request->post( 'pks' )); // Array or selected records primary keys
        foreach ( $pks as $pk ) {
            $model = $this->findModel($pk);
            $model->delete();
        }

        if($request->isAjax){
            /*
            *   Process for ajax request
            */
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ['forceClose'=>true,'forceReload'=>'#crud-datatable-pjax'];
        }else{
            /*
            *   Process for non-ajax request
            */
            return $this->redirect(['index']);
        }
       
    }

    /**
     * Finds the Exam model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Exam the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Exam::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    /*get all subjects.*/
    public function actionAllSubjects(){
        if(Yii::$app->user->isGuest){
            return $this->goHome();
        }else{
            if(Yii::$app->request->isAjax)
            {
                $examModel = new Exam();
                $data= Yii::$app->request->post();
                // print_r($data);exit;
                $class_id = $data['class_id'];
                $group_id = $data['group_id'];
                $section_id = $data['section_id'];

                $query = RefClass::find()->select([
                    'ref_class.title as `class_name`',
                    'ref_class.class_id as `class_id`',
                    'g.group_id as `group_id`',
                    'g.title as `group_name`',
                    's.section_id as `section_id`',
                    's.title as `section_name`',
                    'sb.id as `subject_id`',
                    'sb.title as `subject_name`',
                    'sd.id as `sub_div_id`',
                    'sd.title as `sub_div_title`'
                ])
                ->leftJoin('ref_group g', 'g.fk_class_id = ref_class.class_id')
                ->leftJoin('ref_section s', 's.class_id = ref_class.class_id')
                ->innerJoin('subjects sb', 'sb.fk_class_id = ref_class.class_id')
                ->leftJoin('subject_division sd', 'sd.fk_subject_id = sb.id')
                ->where([
                    'ref_class.class_id'=>$class_id,
                    'g.group_id'=>($group_id)?$group_id:null,
                    's.section_id'=>($section_id)?$section_id:null
                ]);
                $model= $query->createCommand()->queryAll();
                $details = $this->renderAjax('_ajax/get-subjects-data',['dataprovider'=>$model,'model'=>$examModel]);
                return json_encode(['status'=>1 ,'details'=>$details]);
            }
        }
    }

    /*save exams*/
    public function actionSaveExams(){
        if(Yii::$app->request->isAjax){
            $exam_data = Yii::$app->request->post('Exam');
            $exam_type = Yii::$app->request->post('Exam')['fk_exam_type'];

            $modalExamType = new ExamType();
            $row=[];
            $count = count($exam_data['fk_class_id']);
            if(!empty($exam_type)){
                $modalExamType->fk_branch_id=Yii::$app->common->getBranch();
                $modalExamType->type = $exam_type;
                $modalExamType->save();
                if(!$modalExamType->save()){echo "<pre>";print_r($modalExamType->getErrors());exit;}
                $new_examtype_id = $modalExamType->id;
            }
            for($i=0; $i<$count;$i++){
                if($exam_data['do_not_create'][$i] == 0){
                    $row[]=[
                        Yii::$app->common->getBranch(),
                        $exam_data['fk_class_id'][$i],
                        ($exam_data['fk_group_id'][$i])?$exam_data['fk_group_id'][$i]:null,
                        $exam_data['fk_section_id'][$i],
                        $exam_data['fk_subject_id'][$i],
                        ($exam_data['fk_subject_division_id'][$i])?$exam_data['fk_subject_division_id'][$i]:null,
                        $exam_data['total_marks'][$i],
                        $exam_data['passing_marks'][$i],
                        date('Y-m-d H:i:s',strtotime($exam_data['start_date'][$i])),
                        date('Y-m-d H:i:s',strtotime($exam_data['end_date'][$i])),
                        $new_examtype_id,
                        $exam_data['do_not_create'][$i],
                        date('Y-m-d H:i:s')
                    ];
                }
            }
            Yii::$app->db->createCommand()->batchInsert('exam', ['fk_branch_id','fk_class_id', 'fk_group_id', 'fk_section_id','fk_subject_id','fk_subject_division_id','total_marks','passing_marks','start_date','end_date','fk_exam_type','do_not_create','created_date'],$row)->execute();
            return json_encode(['status'=>1,'redirect_url'=>Url::to(['/exams/exam-details'],true)]);
        }
    }

    /*Award List Index page.*/
    public function actionAwardList(){
        $request = Yii::$app->request;
        $model = new Exam();
        /*
           *   Process for non-ajax request
           */
        return $this->render('award-list', [
            'model' => $model,
        ]);

    }

    /*get all exams.*/
    public function actionGetExams(){
        if(Yii::$app->user->isGuest){
            return $this->goHome();
        }else{
            if(Yii::$app->request->isAjax){
                $examModel = new Exam();
                $data= Yii::$app->request->post();
                $class_id = $data['class_id'];
                $group_id = $data['group_id'];
                $section_id = $data['section_id'];
                /*query*/
                $examQuery = Exam::find()
                    ->select(['fk_class_id','fk_group_id','fk_section_id','fk_exam_type'])
                    ->where([
                        'fk_branch_id'  =>Yii::$app->common->getBranch(),
                        'fk_class_id'   => $class_id,
                        'fk_group_id'   => ($group_id)?$group_id:null,
                        'fk_section_id' => $section_id,
                    ])->groupBy(['fk_class_id','fk_group_id','fk_section_id','fk_exam_type']);
                $dataprovider = new ActiveDataProvider([
                   'query'=>$examQuery,
                ]);
                $details = $this->renderAjax('_ajax/get-exam-data',[
                    'dataprovider'=>$dataprovider,
                    'model'=>$examModel,
                    'class_id'=>$class_id,
                    'group_id'=>$group_id,
                    'section_id'=>$section_id
                ]);

                return json_encode(['status'=>1 ,'details'=>$details]);
            }
        }
    }

    /*get subjects from fk_exams_Type*/
    public function actionGetExamsSubjects(){
        if(Yii::$app->user->isGuest){
            return $this->goHome();
        }else {
            if (Yii::$app->request->isAjax) {
                $data = Yii::$app->request->post();
                //print_r($data);exit;
                $exam_model= Exam::find()->where([
                    'fk_branch_id'  =>Yii::$app->common->getBranch(),
                    'fk_class_id'   =>$data['class_id'],
                    'fk_group_id'   =>(isset($data['group_id']))?$data['group_id']:null,
                    'fk_section_id' =>$data['section_id'],
                    'fk_exam_type'  =>$data['exam_type_id'],
                ]);
                $dataprovider = new ActiveDataProvider([
                    'query'=>$exam_model,
                    /*'pagination' => [
                        'pageSize' => 2,
                    ],*/
                ]);
                $details = $this->renderAjax('_ajax/get-exam-subjects',['dataprovider'=>$dataprovider]);

                return json_encode(['status'=>1 ,'details'=>$details]);

            }
        }
    }

    /*create Award list*/
    /**
     * @return Action
     */
    public function actionGetAwardList(){
        if(Yii::$app->user->isGuest){
            return $this->goHome();
        }
        else
        {
            if (Yii::$app->request->isAjax) {
                $modelExam = $this->findModel(Yii::$app->request->post('exam_id'));
                $model = new StudentMarks();
                $where=[];
                if($modelExam->fk_subject_division_id){
                    $where= [
                        'sd.id'=>$modelExam->fk_subject_division_id,
                        'se.section_id'=>$modelExam->fk_section_id,
                        'sb.id'=>$modelExam->fk_subject_id,
                        'student_info.fk_branch_id'=>Yii::$app->common->getBranch(),
                    ];
                }
                else{
                    $where= [
                        'sb.id'=>$modelExam->fk_subject_id,
                        'sd.id'=>null,
                        'se.section_id'=>$modelExam->fk_section_id,
                        'student_info.fk_branch_id'=>Yii::$app->common->getBranch(),
                    ];
                }
                $query= StudentInfo::find()
                    ->select(['student_info.stu_id'])
                    ->innerJoin('user u', 'u.id=student_info.user_id')
                    ->innerJoin('ref_section se', 'se.section_id=student_info.section_id')
                    ->innerJoin('subjects sb', 'sb.fk_class_id=student_info.class_id')
                    ->leftJoin('subject_division sd', 'sd.fk_subject_id=sb.id')
                    ->where($where);

                $exam_model= $query->createCommand()->queryAll();
                //$exam_model= $query->createCommand()->getRawSql();
                //echo $exam_model;exit;
                /*$dataprovider = new ActiveDataProvider([
                    'query'=>$exam_model,

                ]);*/

                $examDetails = $this->renderAjax('_ajax/award-list-form',[
                    'dataprovider'  =>$exam_model,
                    'modelExam'     =>$modelExam,
                    'model'         =>$model
                ]);
                return json_encode(['status'=>1,'details'=>$examDetails]);
            }
        }
    }


    /*Save Award list*/
    /**
     * @return Action
     */
    public function actionSaveAwardList(){
        if(Yii::$app->request->isAjax){
            $award_list_data = Yii::$app->request->post('StudentMarks');
            $exam_id = $award_list_data['fk_exam_id'];
            $row=[];
            $count = count($award_list_data['fk_student_id']);
            for($i=0; $i<$count;$i++){
                $student_id=$award_list_data['fk_student_id'][$i];
                $find = StudentMarks::find()->where(['fk_exam_id'=>$exam_id,'fk_student_id'=>$student_id])->one();
                if(count($find)>0){
                    $find->marks_obtained = $award_list_data['marks_obtained'][$i];
                    $find->remarks = $award_list_data['remarks'][$i];
                    $find->save();
                }else{
                    $row[]=[
                        $exam_id,
                        $student_id,
                        $award_list_data['marks_obtained'][$i],
                        $award_list_data['remarks'][$i],
                    ];
                }
            }
            if(count($row)>0){
                Yii::$app->db->createCommand()->batchInsert('student_marks', ['fk_exam_id','fk_student_id','marks_obtained','remarks'],$row)->execute();
            }
            return json_encode(['status'=>1,'redirect_url'=>Url::to(['/exams/award-list'],true)]);
        }
    }

    /*get exams list*/
    public function actionGetExamsList(){
        if(Yii::$app->user->isGuest){
            return $this->goHome();
        }
        else {
            if (Yii::$app->request->isAjax) {
               $data    = Yii::$app->request->post();
               $group   =  (isset($data['group_id']))?$data['group_id']:null;

                $searchModel = new ExamsSearch();
                $searchModel->fk_branch_id  = Yii::$app->common->getBranch();
                $searchModel->fk_class_id   = $data['class_id'];
                $searchModel->fk_group_id   = (empty($group))?null:$group;
                $searchModel->fk_section_id = $data['section_id'];
                $searchModel->fk_exam_type  = $data['exam_id'];

                $exam_check = Exam::find()->where([
                    'fk_class_id'   => $data['class_id'],
                    'fk_group_id'   => (empty($group))?null:$group,
                    'fk_section_id' => $data['section_id'],
                    'fk_exam_type'  => $data['exam_id']
                ])->count();

                $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
                if($exam_check>0){
                    $html =  $this->renderAjax('index', [
                        'searchModel' => $searchModel,
                        'dataProvider' => $dataProvider,
                    ]);
                }else{
                    $html = '<div class="col-md-12"><div class="alert alert-warning">No Records Found.</div></div>';
                }



                return json_encode(['views'=>$html]);
            }
        }
    }

    /*exams dmc*/
    public function actionDmc(){
        $request = Yii::$app->request;
        $model = new Exam();
        /*
           *   Process for non-ajax request
           */
        return $this->render('dmc', [
            'model' => $model,
        ]);
    }

    /*clsass group section wise dmc*/
    public function actionCgsDmc(){
        if(Yii::$app->user->isGuest){
            return $this->redirect(['site/login']);
        }else{
            $examsModel = new Exam();
            $data = Yii::$app->request->Post();
            if($data){
                $query = Exam::find()
                    ->select(['exam.fk_exam_type id','et.type title'])
                    ->innerJoin('exam_type et','et.id=exam.fk_exam_type')
                    ->where([
                        'exam.fk_branch_id'=>Yii::$app->common->getBranch(),
                        'exam.fk_class_id'=>$data['class_id'],
                        'exam.fk_group_id'=>($data['group_id'])?$data['group_id']:null,
                        'exam.fk_section_id'=>$data['section_id']
                    ])
                    ->groupBy('fk_exam_type')
                    ->asArray()->all();

                $exam_array = ArrayHelper::map($query, 'id', 'title');


                $details = $this->renderAjax('_ajax/cgs-dmc',[
                    'examModel'=>$examsModel,
                    'exams'=>$exam_array,
                    'class_id'=>$data['class_id'],
                    'group_id'=>($data['group_id'])?$data['group_id']:null,
                    'section_id'=>$data['section_id']
                ]);

                return json_encode(['status'=>1 ,'details'=>$details]);
            }
        }
    }

    /*std dmc*/
    public function actionStdDmc(){
        if(Yii::$app->request->isAjax){
            $dataUnserialized = parse_str(Yii::$app->request->post('data'), $serialize_data);
            $class_id = $serialize_data['class_id'];
            $group_id = $serialize_data['group_id'];
            $section_id = $serialize_data['section_id'];
            $exam = $serialize_data['Exam']['fk_exam_type'];
            $status = 0;
            $tabId = '';
            $details_html='';
            if($serialize_data['tab_type']=='#Single-Examination'){
                $examid =  $exam[1];
                $tabId = 'Single-Examination';
                /*total students in class*/
                $students= StudentInfo::find()
                    ->select(['student_info.stu_id','u.username roll_no','u.id user_id'])
                    ->innerJoin('user u','u.id=student_info.user_id')
                    ->where(['student_info.fk_branch_id'=>Yii::$app->common->getBranch(),'student_info.class_id'=>$class_id,'student_info.group_id'=>($group_id)?$group_id:null,'student_info.section_id'=>$section_id])
                    ->asArray()
                    ->all();

                /*selected student resutl.*/
                $exams_students = Exam::find()
                    ->select([
                        'st.stu_id','concat(u.first_name," ",u.middle_name," ",u.last_name) student_name'
                    ])
                    ->innerJoin('exam_type et','et.id=exam.fk_exam_type')
                    ->innerJoin('ref_class c','c.class_id=exam.fk_class_id')
                    ->innerJoin('subjects sb','sb.id=exam.fk_subject_id')
                    ->leftJoin('student_marks sm','sm.fk_exam_id=exam.id')
                    ->leftJoin('student_info st',' st.stu_id=sm.fk_student_id')
                    ->leftJoin('ref_group g','g.group_id=exam.fk_group_id')
                    ->leftJoin('ref_section s','s.class_id=exam.fk_class_id')
                    ->innerJoin('user u','u.id=st.user_id')
                    ->where(['et.id'=>$examid,'exam.fk_branch_id'=>Yii::$app->common->getBranch(),'c.class_id'=>$class_id,'g.group_id'=>($group_id)?$group_id:null,'s.section_id'=>$section_id])
                    ->groupBy(['st.stu_id'])
                    ->asArray()
                    ->all();

                /*get all students marks and position*/
                if(count($students)){
                    $studentexam_arr=[];
                    $examsubjects_arr=[];
                    foreach ($students as  $skey=>$stu_id){
                        $subjects_data = Exam::find()
                            ->select([
                                'st.stu_id',
                                'concat(u.first_name," ",u.last_name) student_name',
                                'c.class_id',
                                'c.title',
                                'g.group_id',
                                'g.title',
                                's.section_id',
                                's.title',
                                'sb.title subject',
                                'sum(exam.total_marks) total_marks',
                                'sum(exam.passing_marks) passing_marks',
                                'round(sum(sm.marks_obtained),2) marks_obtained'
                            ])
                            ->innerJoin('exam_type et','et.id=exam.fk_exam_type')
                            ->innerJoin('ref_class c','c.class_id=exam.fk_class_id')
                            ->innerJoin('subjects sb','sb.id=exam.fk_subject_id')
                            ->leftJoin('student_marks sm','sm.fk_exam_id=exam.id')
                            ->leftJoin('student_info st',' st.stu_id=sm.fk_student_id')
                            ->leftJoin('ref_group g','g.group_id=exam.fk_group_id')
                            ->leftJoin('ref_section s','s.class_id=exam.fk_class_id')
                            ->innerJoin('user u','u.id=st.user_id')
                            ->where(['et.id'=>$exam,'exam.fk_branch_id'=>Yii::$app->common->getBranch(),'c.class_id'=>$class_id,'g.group_id'=>($group_id)?$group_id:null,'s.section_id'=>$section_id,'st.stu_id'=>$stu_id['stu_id'] ])
                            ->groupBy(['st.stu_id','c.class_id','c.title','g.group_id','g.title','s.section_id','s.title','sb.title'])->asArray()->all();


                        if(count($subjects_data)>0){
                            $sumTotalMarks = 0;
                            $studentexam_arr[$stu_id['stu_id']]['student_id']=$stu_id['roll_no'];
                            $studentexam_arr[$stu_id['stu_id']]['name']=$stu_id['user_id'];
                            $std = $stu_id['stu_id'];
                            foreach ($subjects_data as $indata){
                                if($std == $stu_id['stu_id']){
                                    $sumTotalMarks  =  $sumTotalMarks + $indata['marks_obtained'];
                                    $studentToralMarks [$stu_id['stu_id']] = $sumTotalMarks;
                                }
                                $studentexam_arr[$stu_id['stu_id']][] = $indata['marks_obtained'];
                                if($skey==0){
                                    $examsubjects_arr['heads'][] = $indata['subject'];
                                    $examsubjects_arr['total_marks'][] = $indata['total_marks'];
                                }

                                /*sum condition*/
                                if($std != $stu_id['stu_id']){
                                    $sumTotalMarks  = 0;
                                }
                            }
                        }
                    }

                    /*maintain student id's and sort desc.*/
                    natcasesort($studentToralMarks);
                    $sortArr = array_reverse($studentToralMarks, true);
                    $position  = [];
                    $counter= 1;
                    $stdMarks = 0;
                    /*custom sort*/
                    foreach($sortArr as $key=>$totalStdObtainMarks){
                        if($stdMarks ==0){
                            $stdMarks = $totalStdObtainMarks;
                        }
                        if($stdMarks == $totalStdObtainMarks){
                            //echo $stdMarks.'----'.$totalStdObtainMarks.'----' .$counter."<br/>";
                            $position[] = ['position'=>$counter,'student_id'=>$key,'marks'=>$totalStdObtainMarks];
                        }else{
                            $counter = $counter+1;
                            $position[] = ['position'=>$counter,'student_id'=>$key,'marks'=>$totalStdObtainMarks];
                            //echo $stdMarks.'----'.$totalStdObtainMarks.'----' .$counter."-No pos - <br/>";
                        }
                        $stdMarks = $totalStdObtainMarks;
                    }
                }
                if(count($exams_students)>0){
                    $status = 1;
                }
                $details_html = $this->renderAjax('_ajax/std-dmc-list',[
                    'exam_std_query'=>$exams_students,
                    'tab_type'       => 'single',
                    'class_id'       => $class_id,
                    'group_id'       => $group_id,
                    'section_id'     => $section_id,
                    'exam_id'        => $examid,
                    'positions'      => $position
                ]);

            }
            if($serialize_data['tab_type']=='#Multiple-Examination'){
               $exam_Arr = $exam[2];
                $tabId = 'Multiple-Examination';
                $status = 1;
               /* $details_html = $this->renderAjax('_ajax/std-dmc',[
                    'exam_std_query'=>$exams_students,
                    'tab_type'       =>'multiple',
                    'class_id'       =>$class_id,
                    'group_id'       =>$group_id,
                    'section_id'     =>$section_id,
                    'exam_id'      =>$section_id,
                ]);*/
            }
            if($serialize_data['tab_type']=='#Class-Wise-Examination'){
                $tabId = 'Class-Wise-Examination';
                $studentToralMarks = [];
                if($class_id){
                    $students= StudentInfo::find()
                        ->select(['student_info.stu_id','u.username roll_no','u.id user_id'])
                        ->innerJoin('user u','u.id=student_info.user_id')
                        ->where(['student_info.fk_branch_id'=>Yii::$app->common->getBranch(),'student_info.class_id'=>$class_id,'student_info.group_id'=>($group_id)?$group_id:null,'student_info.section_id'=>$section_id])
                        ->asArray()
                        ->all();

                    /*total subjects*/
                    $subjects = Exam::find()
                        ->select([
                            'sb.id subject_id',
                            'sb.title subject',
                            'sum(exam.total_marks) total_marks'
                        ])
                        ->innerJoin('exam_type et','et.id=exam.fk_exam_type')
                        ->innerJoin('ref_class c','c.class_id=exam.fk_class_id')
                        ->leftJoin('ref_group g','g.group_id=exam.fk_group_id ')
                        ->leftJoin('ref_section s','s.section_id=exam.fk_section_id')
                        ->innerJoin('subjects sb','sb.id=exam.fk_subject_id and c.class_id = sb.fk_class_id and g.group_id=sb.fk_group_id')
                        ->where(['et.id'=>$exam, 'c.class_id'=>$class_id,'g.group_id'=>($group_id)?$group_id:null,'s.section_id'=>$section_id])
                        ->groupBy(['sb.title','sb.id'])->asArray()->all();

                    if(count($students)){
                        $studentexam_arr=[];
                        $examsubjects_arr=[];
                        foreach ($students as  $skey=>$stu_id){
                            $subjects_data = Exam::find()
                                ->select([
                                    'st.stu_id',
                                    'concat(u.first_name," ",u.last_name) student_name',
                                    'c.class_id',
                                    'c.title',
                                    'g.group_id',
                                    'g.title',
                                    's.section_id',
                                    's.title',
                                    'sb.title subject',
                                    'sum(exam.total_marks) total_marks',
                                    'sum(exam.passing_marks) passing_marks',
                                    'round(sum(sm.marks_obtained),2) marks_obtained'
                                ])
                                ->innerJoin('exam_type et','et.id=exam.fk_exam_type')
                                ->innerJoin('ref_class c','c.class_id=exam.fk_class_id')
                                ->innerJoin('subjects sb','sb.id=exam.fk_subject_id')
                                ->leftJoin('student_marks sm','sm.fk_exam_id=exam.id')
                                ->leftJoin('student_info st',' st.stu_id=sm.fk_student_id')
                                ->leftJoin('ref_group g','g.group_id=exam.fk_group_id')
                                ->leftJoin('ref_section s','s.class_id=exam.fk_class_id')
                                ->innerJoin('user u','u.id=st.user_id')
                                ->where(['et.id'=>$exam,'exam.fk_branch_id'=>Yii::$app->common->getBranch(),'c.class_id'=>$class_id,'g.group_id'=>($group_id)?$group_id:null,'s.section_id'=>$section_id,'st.stu_id'=>$stu_id['stu_id'] ])
                                ->groupBy(['st.stu_id','c.class_id','c.title','g.group_id','g.title','s.section_id','s.title','sb.title'])->asArray()->all();


                            if(count($subjects_data)>0){
                                $sumTotalMarks = 0;
                                $studentexam_arr[$stu_id['stu_id']]['student_id']=$stu_id['roll_no'];
                                $studentexam_arr[$stu_id['stu_id']]['name']=$stu_id['user_id'];
                                $std = $stu_id['stu_id'];
                                foreach ($subjects_data as $indata){
                                    if($std == $stu_id['stu_id']){
                                        $sumTotalMarks  =  $sumTotalMarks + $indata['marks_obtained'];
                                        $studentToralMarks [$stu_id['stu_id']] = $sumTotalMarks;
                                    }
                                    $studentexam_arr[$stu_id['stu_id']][] = $indata['marks_obtained'];
                                    if($skey==0){
                                        $examsubjects_arr['heads'][] = $indata['subject'];
                                        $examsubjects_arr['total_marks'][] = $indata['total_marks'];
                                    }

                                    /*sum condition*/
                                    if($std != $stu_id['stu_id']){
                                        $sumTotalMarks  = 0;
                                    }
                                }
                            }
                        }

                        /*maintain student id's and sort desc.*/
                        natcasesort($studentToralMarks);
                        $sortArr = array_reverse($studentToralMarks, true);
                        $position  = [];
                        $counter= 1;
                        $stdMarks = 0;
                        /*custom sort*/
                        foreach($sortArr as $key=>$totalStdObtainMarks){
                            if($stdMarks ==0){
                                $stdMarks = $totalStdObtainMarks;
                            }
                            if($stdMarks == $totalStdObtainMarks){
                                //echo $stdMarks.'----'.$totalStdObtainMarks.'----' .$counter."<br/>";
                                $position[] = ['position'=>$counter,'student_id'=>$key,'marks'=>$totalStdObtainMarks];
                            }else{
                                $counter = $counter+1;
                                $position[] = ['position'=>$counter,'student_id'=>$key,'marks'=>$totalStdObtainMarks];
                                //echo $stdMarks.'----'.$totalStdObtainMarks.'----' .$counter."-No pos - <br/>";
                            }
                            $stdMarks = $totalStdObtainMarks;
                        }
                        //echo Yii::$app->common->multidimensional_search($position, ['student_id'=>276]);
                        $examtype = ExamType::findOne($exam);
                        $details_html = $this->renderAjax('/reports/academics/class_wise_resultsheet',[
                            'query'=>$studentexam_arr,
                            'subjects'=>$subjects,
                            'class_id'=>$class_id,
                            'group_id'=>($group_id)?$group_id:null,
                            'section_id'=>$group_id,
                            'examtype'=>$examtype,
                            'heads_marks'=>$examsubjects_arr,
                            'positions'=>$position
                        ]);
                        if(count($studentexam_arr)>0){
                            $status = 1;
                        }
                    }
                }
            }
            if($status == 1){
                return json_encode(['status'=>$status,'html'=>$details_html,'tabId'=>$tabId]);
            }else{
                return json_encode(['status'=>$status,'html'=>'<strong>Records Not found</strong>','tabId'=>$tabId]);
            }

        }
    }


    /*exam->dmc->student-dmc*/
    public function actionStudentDmc(){
        if(Yii::$app->request->isAjax){
            $data= Yii::$app->request->post();
            $student = Yii::$app->common->getStudent($data['stu_id']);
            $branch_details = Yii::$app->common->getBranchDetail();
            $status = 0;
            $subjects_data = Exam::find()
                ->select([
                    'st.stu_id',
                    'concat(u.first_name," ",u.last_name) student_name',
                    'c.class_id',
                    'c.title',
                    'g.group_id',
                    'g.title',
                    's.section_id',
                    's.title',
                    'sb.title subject',
                    'sum(exam.total_marks) total_marks',
                    'sum(exam.passing_marks) passing_marks',
                    'round(sum(sm.marks_obtained),2) marks_obtained'
                ])
                ->innerJoin('exam_type et','et.id=exam.fk_exam_type')
                ->innerJoin('ref_class c','c.class_id=exam.fk_class_id')
                ->innerJoin('subjects sb','sb.id=exam.fk_subject_id')
                ->leftJoin('student_marks sm','sm.fk_exam_id=exam.id')
                ->leftJoin('student_info st',' st.stu_id=sm.fk_student_id')
                ->leftJoin('ref_group g','g.group_id=exam.fk_group_id')
                ->leftJoin('ref_section s','s.class_id=exam.fk_class_id')
                ->innerJoin('user u','u.id=st.user_id')
                ->where(['exam.fk_branch_id'=>Yii::$app->common->getBranch(),'c.class_id'=>$data['class_id'],'g.group_id'=>($data['group_id'])?$data['group_id']:null,'s.section_id'=>$data['section_id'],'st.stu_id'=>$data['stu_id'],'et.id'=>$data['exam_id'] ])
                ->groupBy(['st.stu_id','c.class_id','c.title','g.group_id','g.title','s.section_id','s.title','sb.title'])->asArray()->all();



            /*graph Query*/
            $class_data = Exam::find()
                ->select([
                    'c.title class','g.title group_name',
                    's.title section_name',
                    'sb.title subject',
                    'sum(exam.total_marks) total_marks',
                    'sum(exam.passing_marks) passing_marks',
                    'sum(sm.marks_obtained) marks_obtained',
                    '(sum(sm.marks_obtained) /  sum(exam.total_marks)) * 100 percentage_marks_obtain'
                ])
                ->innerJoin('exam_type et','et.id=exam.fk_exam_type')
                ->innerJoin('ref_class c','c.class_id=exam.fk_class_id')
                ->innerJoin('subjects sb','sb.id=exam.fk_subject_id')
                ->leftJoin('student_marks sm','sm.fk_exam_id=exam.id')
                ->leftJoin('student_info st',' st.stu_id=sm.fk_student_id')
                ->leftJoin('ref_group g','g.group_id=exam.fk_group_id')
                ->leftJoin('ref_section s','s.class_id=exam.fk_class_id')
                ->innerJoin('user u','u.id=st.user_id')
                ->where([
                    'exam.fk_branch_id'=>Yii::$app->common->getBranch(),
                    'c.class_id'=>$data['class_id'],
                    'g.group_id'=>($data['group_id'])?$data['group_id']:null,
                    's.section_id'=>$data['section_id'],
                    'et.id'=>$data['exam_id']
                ])
                ->groupBy(['c.title','g.title','s.title','sb.title'])->asArray()->all();

            $examtype = ExamType::findOne($data['exam_id']);

            if(count($subjects_data)>0){

                $details_html = $this->renderAjax('_ajax/student-dmc',[
                    'student'=>$student,
                    'query' =>$subjects_data,
                    'exam_details'=>$examtype,
                    'branch_details'=>$branch_details,
                    'position'=>$data['stdPosition'],

                ]);
                $status =1;

            }else{
                $details_html = "<strong>Records not found.</strong>";
            }
            $total_class_subjects =[];
            $total_marks_subjects =[];
            foreach ($class_data as $key=>$total_class){
                if(isset($subjects_data[$key])){
                    $percentage = $subjects_data[$key]['marks_obtained']/$subjects_data[$key]['total_marks']*100;
                    $total_marks_subjects [] = [round($percentage,2)];
                    $total_class_subjects [] = $total_class['subject'];
                }
            }

            return json_encode([
                'status'=>$status,
                'html'=>$details_html,
                'class_data'=>$class_data,
                'subject_data'=>$subjects_data,
                'total_subjects'=>$total_class_subjects,
                'total_marks_subjects'=>$total_marks_subjects,
                'position'=>$total_marks_subjects,
                'total_count'=>count($class_data)
            ]);
        }else{
            if(Yii::$app->request->get()){
                $data= Yii::$app->request->get();
                $student = Yii::$app->common->getStudent($data['stu_id']);
                $branch_details = Yii::$app->common->getBranchDetail();

                $subjects_data = Exam::find()
                    ->select([
                        'st.stu_id',
                        'concat(u.first_name," ",u.last_name) student_name',
                        'c.class_id',
                        'c.title',
                        'g.group_id',
                        'g.title',
                        's.section_id',
                        's.title',
                        'sb.title subject',
                        'sum(exam.total_marks) total_marks',
                        'sum(exam.passing_marks) passing_marks',
                        'round(sum(sm.marks_obtained),2) marks_obtained'
                    ])
                    ->innerJoin('exam_type et','et.id=exam.fk_exam_type')
                    ->innerJoin('ref_class c','c.class_id=exam.fk_class_id')
                    ->innerJoin('subjects sb','sb.id=exam.fk_subject_id')
                    ->leftJoin('student_marks sm','sm.fk_exam_id=exam.id')
                    ->leftJoin('student_info st',' st.stu_id=sm.fk_student_id')
                    ->leftJoin('ref_group g','g.group_id=exam.fk_group_id')
                    ->leftJoin('ref_section s','s.class_id=exam.fk_class_id')
                    ->innerJoin('user u','u.id=st.user_id')
                    ->where(['exam.fk_branch_id'=>Yii::$app->common->getBranch(),'c.class_id'=>$data['class_id'],'g.group_id'=>(isset($data['group_id']))?$data['group_id']:null,'s.section_id'=>$data['section_id'],'st.stu_id'=>$data['stu_id'],'et.id'=>$data['exam_id'] ])
                    ->groupBy(['st.stu_id','c.class_id','c.title','g.group_id','g.title','s.section_id','s.title','sb.title'])->asArray()->all();
                $examtype = ExamType::findOne($data['exam_id']);

                if(count($subjects_data)>0){
                    $resultsheet = Yii::$app->common->getName($student->user_id).'-'.Yii::$app->common->getCGSName($data['class_id'],(isset($data['group_id']))?$data['group_id']:null,$data['section_id']).' - '.ucfirst($examtype->type);
                    if(Yii::$app->common->getBranch()== 64 || Yii::$app->common->getBranch()== 65) {
                        $details_html = $this->renderPartial('_ajax/pdfs/student-dmc-pdf-meesaq', [
                            'student' => $student,
                            'query' => $subjects_data,
                            'exam_details' => $examtype,
                            'branch_details' => $branch_details,
                            'position'=>$data['position']

                        ]);
                    }else{
                        $details_html = $this->renderPartial('_ajax/pdfs/student-dmc-pdf', [
                            'student' => $student,
                            'query' => $subjects_data,
                            'exam_details' => $examtype,
                            'branch_details' => $branch_details,
                            'position'=>$data['position']

                        ]);
                    }
                    /*$directoryAsset = Yii::$app->assetManager->getPublishedUrl('@webroot/vendor/bower/bootstrap/dist').'/css/bootstrap.css';
                    $dash = explode('/mis/',$directoryAsset);*/
                    $this->layout = 'pdf';
                    //$mpdf = new mPDF('', 'A4');
                    $mpdf = new mPDF('','', 0, '', 2, 2, 3, 3, 2, 2, 'A4');
                    $stylesheet = file_get_contents('css/site.css');
                    $stylesheet .= file_get_contents('css/std-dmc-pdf.css');
                    $mpdf->WriteHTML($stylesheet,1);
                    $mpdf->WriteHTML($details_html,2);

                    $mpdf->Output('Result-sheet-'.$resultsheet.'.pdf', 'D');

                }
            }
        }
    }

    /*export all dmc*/
    public function actionExportAllDmc(){
        if(Yii::$app->user->isGuest){
            return $this->redirect('site/login');
        }else{
            if(Yii::$app->request->get()){
                $data= Yii::$app->request->get();
                $examid = $data['exam_id'];
                $class_id = $data['class_id'];
                $group_id = (isset($data['group_id']))?$data['group_id']:null;
                $section_id = $data['section_id'];
               
                /*$student = Yii::$app->common->getStudent($data['stu_id']);*/
                $branch_details = Yii::$app->common->getBranchDetail();
                /*exam students*/
                $exams_students = Exam::find()
                    ->select([
                        'st.stu_id','concat(u.first_name," ",u.middle_name," ",u.last_name) student_name'
                    ])
                    ->innerJoin('exam_type et','et.id=exam.fk_exam_type')
                    ->innerJoin('ref_class c','c.class_id=exam.fk_class_id')
                    ->innerJoin('subjects sb','sb.id=exam.fk_subject_id')
                    ->leftJoin('student_marks sm','sm.fk_exam_id=exam.id')
                    ->leftJoin('student_info st',' st.stu_id=sm.fk_student_id')
                    ->leftJoin('ref_group g','g.group_id=exam.fk_group_id')
                    ->leftJoin('ref_section s','s.class_id=exam.fk_class_id')
                    ->innerJoin('user u','u.id=st.user_id')
                    ->where(['et.id'=>$examid,'exam.fk_branch_id'=>Yii::$app->common->getBranch(),'c.class_id'=>$class_id,'g.group_id'=>($group_id)?$group_id:null,'s.section_id'=>$section_id])
                    ->groupBy(['st.stu_id'])->asArray()->all();

                if(count($exams_students)>0){
                    $resultsheet = Yii::$app->common->getCGSName($class_id,$group_id,$section_id).' - '.ucfirst($examid);
                    $this->layout = 'pdf';
                    //$mpdf = new mPDF('', 'A4');
                    $mpdf = new mPDF('','', 0, '', 2, 2, 3, 3, 2, 2, 'A4');
                    $position = json_decode($data['position']);
                    foreach($exams_students as $i => $students){
                        $student = Yii::$app->common->getStudent($students['stu_id']);
                        $subjects_data = Exam::find()
                            ->select([
                                'st.stu_id',
                                'concat(u.first_name," ",u.last_name) student_name',
                                'c.class_id',
                                'c.title',
                                'g.group_id',
                                'g.title',
                                's.section_id',
                                's.title',
                                'sb.title subject',
                                'sum(exam.total_marks) total_marks',
                                'sum(exam.passing_marks) passing_marks',
                                'round(sum(sm.marks_obtained),2) marks_obtained'
                            ])
                            ->innerJoin('exam_type et','et.id=exam.fk_exam_type')
                            ->innerJoin('ref_class c','c.class_id=exam.fk_class_id')
                            ->innerJoin('subjects sb','sb.id=exam.fk_subject_id')
                            ->leftJoin('student_marks sm','sm.fk_exam_id=exam.id')
                            ->leftJoin('student_info st',' st.stu_id=sm.fk_student_id')
                            ->leftJoin('ref_group g','g.group_id=exam.fk_group_id')
                            ->leftJoin('ref_section s','s.class_id=exam.fk_class_id')
                            ->innerJoin('user u','u.id=st.user_id')
                            ->where(['exam.fk_branch_id'=>Yii::$app->common->getBranch(),'c.class_id'=>$class_id,'g.group_id'=>($group_id)?$group_id:null,'s.section_id'=>$section_id,'st.stu_id'=>$students['stu_id'],'et.id'=>$examid ])
                            ->groupBy(['st.stu_id','c.class_id','c.title','g.group_id','g.title','s.section_id','s.title','sb.title'])->asArray()->all();
                        $examtype = ExamType::findOne($examid);

                        if(count($subjects_data)>0){
                            if(Yii::$app->common->getBranch()== 64 || Yii::$app->common->getBranch()== 65) {
                                $details_html = $this->renderPartial('_ajax/pdfs/student-dmc-pdf-meesaq', [
                                    'student' => $student,
                                    'query' => $subjects_data,
                                    'exam_details' => $examtype,
                                    'branch_details' => $branch_details,
                                    'position' => $position[$i]

                                ]);
                            }else{
                                $details_html = $this->renderPartial('_ajax/pdfs/student-dmc-pdf', [
                                    'student' => $student,
                                    'query' => $subjects_data,
                                    'exam_details' => $examtype,
                                    'branch_details' => $branch_details,
                                    'position' => $position[$i]
                                ]);
                            }
                            $mpdf->AddPage();
                            $stylesheet = file_get_contents('css/site.css');
                            $stylesheet .= file_get_contents('css/std-dmc-pdf.css');
                            $mpdf->WriteHTML($stylesheet,1);
                            $mpdf->WriteHTML($details_html,2);
                        }

                    }
                    $mpdf->Output('Result-sheet-'.$resultsheet.'.pdf', 'D');
                    /*$directoryAsset = Yii::$app->assetManager->getPublishedUrl('@webroot/vendor/bower/bootstrap/dist').'/css/bootstrap.css';
                    $dash = explode('/mis/',$directoryAsset);*/
                }
            }
        }
    }

    /*generate blank awardlist*/
    public function actionGenerateBlankAwardlist(){ 
        if(Yii::$app->user->isGuest){
            return $this->goHome();
        }
        else
        {
            if (Yii::$app->request->get()) {
                $modelExam = $this->findModel(Yii::$app->request->get('exam_id'));
                $model = new StudentMarks();
                $where=[];
                if($modelExam->fk_subject_division_id){
                    $where= [
                        'sd.id'=>$modelExam->fk_subject_division_id,
                        'se.section_id'=>$modelExam->fk_section_id,
                        'sb.id'=>$modelExam->fk_subject_id,
                        'student_info.fk_branch_id'=>Yii::$app->common->getBranch(),
                    ];
                }
                else{
                    $where= [
                        'sb.id'=>$modelExam->fk_subject_id,
                        'sd.id'=>null,
                        'se.section_id'=>$modelExam->fk_section_id,
                        'student_info.fk_branch_id'=>Yii::$app->common->getBranch(),
                    ];
                }
                $query= StudentInfo::find()
                    ->select(['student_info.stu_id'])
                    ->innerJoin('user u', 'u.id=student_info.user_id')
                    ->innerJoin('ref_section se', 'se.section_id=student_info.section_id')
                    ->innerJoin('subjects sb', 'sb.fk_class_id=student_info.class_id')
                    ->leftJoin('subject_division sd', 'sd.fk_subject_id=sb.id')
                    ->where($where);

                $exam_model= $query->createCommand()->queryAll();
                //$exam_model= $query->createCommand()->getRawSql();
                //echo $exam_model;exit;
                /*$dataprovider = new ActiveDataProvider([
                    'query'=>$exam_model,

                ]);*/

                $examDetails = $this->renderPartial('_ajax/pdfs/generate-blank-awardlist',[
                    'dataprovider'  =>$exam_model,
                    'modelExam'     =>$modelExam,
                    'model'         =>$model
                ]);
                $this->layout = 'pdf';
                //$mpdf = new mPDF('', 'A4');
                $mpdf = new mPDF('','', 0, '', 2, 2, 3, 3, 2, 2, 'A4');

                $mpdf->WriteHTML($examDetails);
                $mpdf->Output('Blank Award list.pdf', 'D');
                //return json_encode(['status'=>1,'details'=>$examDetails]);
            }
        }
    }

    public function actionTest(){
        return $this->render('test');
    }
} // end of main class
