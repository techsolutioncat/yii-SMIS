<?php

namespace app\controllers;

use app\models\FeeCollectionParticular;
use app\models\FeeDiscounts;
use app\models\FeeChallanRecord;
use app\models\FeeHeadWise;
use app\models\FeeParticulars;
use app\models\FeePlanType;
use app\models\FeeTransactionDetails;
use app\models\FineType;
use app\models\Hostel;
use app\models\search\FeeHeads;
use app\models\SmsLog;
use app\models\StudentLeaveInfo;
use app\models\StuRegLogAssociation;
use Yii;
use app\models\User;
use app\models\StudentInfo;
use app\models\search\StudentInfoSearch;
use app\models\StudentParentsInfo;
use app\models\EmployeeAttendance;
use app\models\RefProvince;
use app\models\RefDistrict;
use app\models\RefCities;
use app\models\Exam;
use app\models\RefClass;
use app\models\HostelBed;
use app\models\HostelRoom;
use app\models\HostelFloor;
use app\models\RefGroup;
use app\models\RefSection;
use app\models\Route;
use app\models\Stop;
use app\models\HostelDetail;
use app\models\StudentEducationalHistoryInfo;
use app\models\StudentAttendance;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;
use yii\data\ActiveDataProvider;
use app\models\FeePaymentMode;
use arogachev\excel\import\basic\Importer; // for excel
use PHPExcel;
use PHPExcel_IOFactory;
use app\models\UploadExcelForm;
use mPDF;

/**
 * StudentInfoController implements the CRUD actions for StudentInfo model.
 */
class StudentController extends Controller {

    public $enableCsrfValidation = false;

    /**
     * @inheritdoc
     */
    public function behaviors() {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    public function actionTest1() {
        $request = Yii::$app->request;
        $model = new StudentInfo();
        /*
         *   Process for non-ajax request
         */
        return $this->render('test1', [
                    'model' => $model,
        ]);
    }

    public function actionTest() {
        return $this->render('test');
    }

    public function actionFunctions() {

        return $this->renderAjax('StuCalfunctions');
    }

    //send sms to student parent

    public function actionSendSmsParent() {
        $smsModel = new SmsLog();
        $studentId = Yii::$app->request->post('studentId');
        $textarea = Yii::$app->request->post('textarea');
        $getparentcontact = StudentParentsInfo::find()->select('contact_no')->where(['stu_id' => $studentId])->one();

        $sendParentContact = $getparentcontact->contact_no;
        $s = Yii::$app->common->SendSms($sendParentContact, $textarea, $studentId);

        /*
          $smsModel->SMS_body=$textarea;
          $smsModel->fk_user_id=$studentId;
          $smsModel->fk_branch_id=yii::$app->common->getBranch();
          $smsModel->sent_date_time=date("Y:m:d H:i:s");
          $smsModel->status='y';
          if($smsModel->save()){}else{print_r($smsModel->getErrors());}
         */
    }

    //end of send sms to student parent

    /**
     * Lists all StudentInfo models.
     * @return mixed
     */
    public function actionIndex() {
        if (Yii::$app->user->isGuest) {
            return $this->goHome();
        } else {
            $model = new StudentInfo();
            $searchModel = new StudentInfoSearch();
            $searchModel->is_active = 1;
            $sectionId = Yii::$app->request->get('sid');
            if ($sectionId) {
                $searchModel->group_id = $sectionId;
            }
            $searchModel->fk_branch_id = Yii::$app->common->getBranch();
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

            return $this->render('index', [
                        'searchModel' => $searchModel,
                        'dataProvider' => $dataProvider,
                        'model' => $model,
            ]);
        }
    }

    /* get all students on basis of section and group. */

    public function actionGetStu() {
        if (Yii::$app->user->isGuest) {
            return $this->goHome();
        } else {
            if (Yii::$app->request->isAjax) {
                $stuModel = new StudentInfo();
                $data = Yii::$app->request->post();
                $class_id = $data['class_id'];
                $group_id = $data['group_id'];
                $section_id = $data['section_id'];
                /* query */
                $StudentQuery = StudentInfo::find()
                                ->select(['class_id', 'group_id', 'section_id'])
                                ->where([
                                    'fk_branch_id' => Yii::$app->common->getBranch(),
                                    'class_id' => $class_id,
                                    'group_id' => ($group_id) ? $group_id : null,
                                    'section_id' => $section_id,
                                ])->groupBy(['class_id', 'group_id', 'section_id']);
                $dataprovider = $StudentQuery->all();
                $details = $this->renderAjax('get-stu-data', [
                    'dataprovider' => $dataprovider,
                    'model' => $stuModel,
                    'class_id' => $class_id,
                    'group_id' => $group_id,
                    'section_id' => $section_id
                ]);

                return json_encode(['status' => 1, 'details' => $details]);
            }
        }
    }

    public function actionGetSearch() {
        if (Yii::$app->user->isGuest) {
            return $this->goHome();
        } else {
            if (Yii::$app->request->isAjax) {
                if (Yii::$app->request->isPjax) {
                    //echo '1';
                    $data = Yii::$app->request->get();
                } else {
                    //echo "2";
                    $data = Yii::$app->request->post();
                }
                //echo "<pre>";print_r($data['getVal']);exit;
                $stuModel = new StudentInfo();


                $input_id = $data['getVal'];
                $getdropVal = $data['getinput'];
                $class_val = $data['classval'];
                $status = $data['status'];
                if ($status == 1) {
                    $word = 'active';
                } else {
                    $word = 'inactive';
                }
                //echo $getdropVal; exit;
                /* query */
                if ($getdropVal == 'contact') {
                    /* $where="contact_no like '%$input_id%'";
                      $StudentQuery=StudentParentsInfo::find()
                      //->where(['contact_no'=>$input_id]);
                      ->where($where); */

                    $StudentQuery = StudentParentsInfo::find()
                            ->select(['student_parents_info.*', 'student_info.fk_branch_id'])
                            ->innerJoin('student_info', 'student_info.stu_id = student_parents_info.stu_id')
                            ->where(['student_parents_info.contact_no' => $input_id, 'student_info.fk_branch_id' => yii::$app->common->getBranch(), 'student_info.is_active' => 1]);


                    //->where($where);
                    // echo '<pre>';print_r($input_id);die;
                    /* $where = "spi.contact_no like '%$input_id%' and student_info.fk_branch_id='".Yii::$app->common->getBranch()."' and u.status ='".$status."'";
                      $StudentQuery = StudentInfo::find()
                      ->select(['rc.title class_title','spi.cnic','student_info.user_id','student_info.stu_id','u.status','u.username','student_info.dob','u.email','student_info.registration_date'])
                      ->innerJoin('student_parents_info spi','spi.stu_id=student_info.stu_id')
                      ->innerJoin('ref_class rc','rc.class_id=student_info.class_id')
                      ->innerJoin('user u','u.id=student_info.user_id ')
                      ->where($where)
                      ->orderBy(['student_info.stu_id'=>SORT_DESC])->asArray(); */
                } else if ($getdropVal == 'reg') {
                    $where = "username like '%$input_id%'  and fk_role_id = 3 and fk_branch_id=" . Yii::$app->common->getBranch() . " and status='" . $word . "'";
                    $StudentQuery = User::find()
                            ->where($where)
                            //  ->orderBy(['id'=>SORT_DESC]);
                            ->orderBy(['username' => SORT_ASC]);
                } else if ($getdropVal == 'name') {
                    $where = "first_name like '%$input_id%' and fk_branch_id='" . Yii::$app->common->getBranch() . "' and fk_role_id = 3  and status='" . $word . "'";
                    $StudentQuery = User::find()
                            ->where($where)
                            //->orderBy(['id'=>SORT_DESC]);
                            ->orderBy(['username' => SORT_ASC]);
                } else if ($getdropVal == 'class') {
                    //$where = "class_id like '%$class_val%' and fk_branch_id='".Yii::$app->common->getBranch()."' and is_active=$status";
                    $where = "class_id = '$class_val' and fk_branch_id='" . Yii::$app->common->getBranch() . "' and is_active=$status";

                    $StudentQuery = StudentInfo::find()
                            ->where($where)
                            ->orderBy(['user_id' => SORT_ASC]);
                    // ->orderBy(['username'=>SORT_ASC]);
                } else if ($getdropVal == 'overall') {
                    //$where = "class_id like '%$class_val%' and fk_branch_id='".Yii::$app->common->getBranch()."' and is_active=$status";
                    $where = "fk_branch_id='" . Yii::$app->common->getBranch() . "' and is_active=$status";

                    $StudentQuery = StudentInfo::find()
                            ->where($where)
                            ->orderBy(['user_id' => SORT_ASC]);
                    // ->orderBy(['username'=>SORT_ASC]);
                }
                //echo "<pre>";print_r($StudentQuery->all());exit;
                //$dataprovider = $StudentQuery;
                $dataprovider = new ActiveDataProvider([
                    'query' => $StudentQuery,
                    'pagination' => [
                        'pageSize' => 500,
                    ],
                        // 'pagination'=>false,
                        /* 'pagination' => [
                          'pageSize' => 20,
                          'params' => [
                          'getinput' => $getdropVal,
                          'getVal' => $input_id,
                          'classval'=>$class_val

                          ],
                          ] */
                ]);


                //print_r($dataprovider);die;
                $details = $this->renderAjax('getsearch', [
                    'dataprovider' => $dataprovider,
                    'model' => $stuModel,
                    'input_id' => $input_id,
                    'getdropVal' => $getdropVal,
                    'class_val' => $class_val,
                    'status' => $status,
                        // 'contact_no'=>$class_id,
                ]);

                return json_encode(['status' => 1, 'details' => $details]);
            }
        }
    }

    public function actionTestLeave() {
        echo 'here';
    }

    public function actionLeaveInfo() {
        //echo '<pre>';print_r($_POST);
        $stu_id = yii::$app->request->post('stu_id');
        $remove = yii::$app->request->post('removeVal');
        if ($remove == 1) {
            $remove = 0;
        }
        $remarks = yii::$app->request->post('remarks');
        $nextSchool = yii::$app->request->post('nextSchool');
        $reason = yii::$app->request->post('reason');
        // $model=new studentInfo;
        //$model2=new User;
        $getstuid = studentInfo::find()->where(['stu_id' => $stu_id])->one();
        $clasId = $getstuid->class_id;
        $grpd = $getstuid->group_id;
        $sctnid = $getstuid->section_id;
        $newmodel = new StudentLeaveInfo();
        $newmodel->stu_id = $stu_id;
        $newmodel->remarks = $remarks;
        $newmodel->next_school = $nextSchool;
        $newmodel->reason_for_leavingschool = $reason;
        $newmodel->created_date = date("Y-m-d", strtotime(yii::$app->request->post('date')));
        $newmodel->class_id = $clasId;
        $newmodel->group_id = $grpd;
        $newmodel->section_id = $sctnid;

        if ($newmodel->save()) {
            
        } else {
            print_r($newmodel->getErrors());
        }

        $studnt = studentInfo::findOne($stu_id);
        $studnt->is_active = $remove;
        $studnt->school_leave = yii::$app->request->post('removeVal');

        //$name->filedname2 = "about information";
        if ($studnt->update()) {
            // deactivating student after leaving the school- burhan
            $user = User::findOne($getstuid->user_id);
            $user->status = 'inactive';
            if ($user->save(false)) {
                
            }
        } else {
            
        }
    }

    public function actionLeaveInfoName() {
        //echo '<pre>';print_r($_POST);
        /* generate PDF of challan */




        $stu_id = yii::$app->request->post('stu_id');
        //Yii::$app->response->redirect(['student/leaving-pdf','id' => $stu_id]);

        $remove = yii::$app->request->post('removeVal');
        if ($remove == 1) {
            $remove = 0;
        }
        $remarks = yii::$app->request->post('remarks');
        $nextSchool = yii::$app->request->post('nextSchool');
        $reason = yii::$app->request->post('reason');
        // $model=new studentInfo;
        //$model2=new User;
        $getstuid = studentInfo::find()->where(['stu_id' => $stu_id])->one();
        $clasId = $getstuid->class_id;
        $grpd = $getstuid->group_id;
        $sctnid = $getstuid->section_id;
        $newmodel = new StudentLeaveInfo();
        $newmodel->stu_id = $stu_id;
        $newmodel->remarks = $remarks;
        $newmodel->next_school = $nextSchool;
        $newmodel->reason_for_leavingschool = $reason;
        $newmodel->created_date = date("Y-m-d", strtotime(yii::$app->request->post('date')));
        $newmodel->class_id = $clasId;
        $newmodel->group_id = $grpd;
        $newmodel->section_id = $sctnid;

        if ($newmodel->save()) {
            
        } else {
            print_r($newmodel->getErrors());
        }



        $userid = $getstuid->user_id;
        $user = User::findOne($userid);
        $user->status = 'inactive';

        /* $studnt = studentInfo::findOne($stu_id);
          $studnt->is_active = $remove; */
        //$name->filedname2 = "about information";
        if ($user->update()) {
            $studnt = studentInfo::findOne($stu_id);
            $studnt->is_active = $remove;
            $studnt->school_leave = yii::$app->request->post('removeVal');

            /* $userid=$getstuid->user_id;
              $user = User::findOne($userid);
              $user->status = 'inactive'; */
            if ($studnt->update()) {


                //$studnt->update
                // echo $stu_id;
                // return json_encode(['id'=>$stu_id]);
                //Yii::$app->response->redirect(['student/leaving-pdf','id' => $stu_id]);
            } else {
                
            }
        } else {
            
        }




        /* if($remove == 1){
          Yii::$app->response->redirect(['student/leaving-pdf','id' => $stu_id]);

          } */
    }

    public function actionNames() {
        $id = yii::$app->request->post('stu_id');
        Yii::$app->response->redirect(['student/leaving-pdf', 'id' => $id]);
    }

    public function actionLeavingPdf() {
        $id = yii::$app->request->get('id');
        $chalan_html = $this->renderPartial('leaving-pdf', [
            /* 'query_std_plan' => $query_std_plan,
              'due_date'=> $feecollectionModel->due_date,
              'query' => $query,
              'student_data'=>$student_data,
              'fee_plan_Model'=>$fee_plan_Model,
              'transport_fare'=>$transport_fare,
              'challan_details'=>$fee_challan,
              'cnic_count'     => $stuparent_info */
            'id' => $id
        ]);


        $this->layout = 'pdf';
        //$mpdf = new mPDF('', 'A4');
        $mpdf = new mPDF('', '', 0, '', 2, 2, 3, 3, 2, 2, 'A4');
        $mpdf->AddPage();
        $mpdf->WriteHTML($chalan_html);

        $mpdf->Output('Student-challan.pdf', 'D');
    }

    public function actionGetSearchPdf() {

        $class_val = Yii::$app->request->get('classval');
        $thisinputname = Yii::$app->request->get('inputhid');
        $parntclass = Yii::$app->request->get('parntclass');
        $inputclass = Yii::$app->request->get('inputclass');
        $grpclass = Yii::$app->request->get('grpclass');
        $sectinclass = Yii::$app->request->get('sectinclass');
        $dobclass = Yii::$app->request->get('dobclass');
        $regclass = Yii::$app->request->get('regclass');
        $adrsclass = Yii::$app->request->get('adrsclass');
        $classcntct = Yii::$app->request->get('classcntct');



        $StudentQueryPdf = StudentInfo::find()
                ->where(['fk_branch_id' => Yii::$app->common->getBranch(), 'is_active' => 1])
                ->andWhere(['like', 'class_id', $class_val])
                // ->orderBy(['stu_id'=>SORT_DESC])
                ->all();

        $classname = RefClass::find()->where(['fk_branch_id' => Yii::$app->common->getBranch(), 'class_id' => $class_val])->one();
        $clsname = $classname->title;

        /* $dataprovider = new ActiveDataProvider([
          'query' => $StudentQueryPdf,

          ]); */

        $viewx = $this->renderPartial('class-pdf', ['dataprovider' => $StudentQueryPdf, 'thisinputname' => $thisinputname, 'parntclass' => $parntclass, 'inputclass' => $inputclass, 'grpclass' => $grpclass, 'sectinclass' => $sectinclass, 'dobclass' => $dobclass, 'regclass' => $regclass, 'adrsclass' => $adrsclass, 'classcntct' => $classcntct]);
        // echo $viewx;die;
        $this->layout = 'pdf';
        $mpdf = new mPDF();
        $mpdf->WriteHTML("<h3 style='text-align:center'>$clsname Wise Report </h3>");
        $mpdf->WriteHTML($viewx);
        $mpdf->Output('class-pdf-' . date("d-m-Y") . '.pdf', 'D');
    }

    public function actionGetSearchnamePdf() {



        $input_id = Yii::$app->request->get('getVal');
        $getdropVal = Yii::$app->request->get('getinput');
        $thisinputname = Yii::$app->request->get('inputhid');
        $parntclass = Yii::$app->request->get('parntclass');
        $inputclass = Yii::$app->request->get('inputclass');
        $grpclass = Yii::$app->request->get('grpclass');
        $sectinclass = Yii::$app->request->get('sectinclass');
        $dobclass = Yii::$app->request->get('dobclass');
        $regclass = Yii::$app->request->get('regclass');
        $adrsclass = Yii::$app->request->get('adrsclass');
        $classcntct = Yii::$app->request->get('classcntct');

        if ($getdropVal == 'reg') {
            $StudentQueryPdfreg = User::find()
                            ->where(['fk_branch_id' => Yii::$app->common->getBranch(), 'status' => 'active', 'fk_role_id' => 3])
                            ->andWhere(['like', 'username', $input_id])
                            ->orderBy(['id' => SORT_DESC])->all();

            $viewxxreg = $this->renderPartial('class-pdf-reg', ['dataproviders' => $StudentQueryPdfreg, 'thisinputname' => $thisinputname, 'parntclass' => $parntclass, 'inputclass' => $inputclass, 'grpclass' => $grpclass, 'sectinclass' => $sectinclass, 'dobclass' => $dobclass, 'regclass' => $regclass, 'adrsclass' => $adrsclass, 'classcntct' => $classcntct]);
            //echo $viewxx;die;
            $this->layout = 'pdf';
            $mpdf = new mPDF();
            $mpdf->WriteHTML("<h3 style='text-align:center'>Registration Number Wise Report </h3>");
            $mpdf->WriteHTML($viewxxreg);
            $mpdf->Output('class-pdf-' . date("d-m-Y") . '.pdf', 'D');
        } else {
            $StudentQueryPdfName = User::find()
                            ->where(['fk_branch_id' => Yii::$app->common->getBranch(), 'status' => 'active', 'fk_role_id' => 3])
                            ->andWhere(['like', 'first_name', $input_id])
                            ->orderBy(['id' => SORT_DESC])->all();
            //echo $StudentQueryPdfName;die;

            $viewxx = $this->renderPartial('class-pdf-name', ['dataprovider' => $StudentQueryPdfName, 'thisinputname' => $thisinputname, 'parntclass' => $parntclass, 'inputclass' => $inputclass, 'grpclass' => $grpclass, 'sectinclass' => $sectinclass, 'dobclass' => $dobclass, 'regclass' => $regclass, 'adrsclass' => $adrsclass, 'classcntct' => $classcntct]);
            //echo $viewxx;die;
            $this->layout = 'pdf';
            $mpdf = new mPDF();
            $mpdf->WriteHTML("<h3 style='text-align:center'>Name Wise Report </h3>");
            $mpdf->WriteHTML($viewxx);
            $mpdf->Output('class-pdf-' . date("d-m-Y") . '.pdf', 'D');
        }
    }

    /*   end of get student acording to sesssion and class */

    public function actionGetStudents($id) {
        if (Yii::$app->user->isGuest) {
            return $this->goHome();
        } else {
            $searchModel = new StudentInfoSearch();

            $searchModel->fk_branch_id = Yii::$app->common->getBranch();
            $searchModel->section_id = $id;
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
            // print_r(Yii::$app->request->queryParams);die;

            /* return $this->render('getStudents', [
              'searchModel' => $searchModel,
              'dataProvider' => $dataProvider,
              ]); */

            return $this->render('getStudents', [
                        'searchModel' => $searchModel,
                        'dataProvider' => $dataProvider,
            ]);
        }
    }

    // start of calendar
    public function actionSaveStuId() {

        $ids = Yii::$app->request->post('emp_is');
        $dat = Yii::$app->request->post('d');
        $dats = date('Y-m-d', strtotime($dat));
        $query = StudentAttendance::find()->where(['fk_stu_id' => $ids])
                ->andWhere(['between', 'date', $dats . ' 00:00:00', $dats . ' 23:59:59'])
                ->one();


        $query1 = StudentAttendance::find()->where(['fk_stu_id' => $ids])
                ->andWhere(['between', 'date', $dats . ' 00:00:00', $dats . ' 23:59:59']);
        $provider = new ActiveDataProvider([
            'query' => $query1,
        ]);


        if ($query) {
            $getVal = $this->renderAjax('getdetails', ['passvalue' => $provider]);
            return json_encode(['type' => $query->leave_type, 'remarks' => $query->remarks, 'newprovide' => $getVal]);
        } else {
            return 'false';
        }
    }

//end of empId

    public function actionCalendar() {
        $model = new Exam();
        $model2 = new StudentAttendance();
        return $this->render('Studentcalendar', [
                    'attendanceModel' => $model2,
                    'model' => $model,
        ]);
    }

    /* public function actionParentCnic(){
      $cnic=yii::$app->request->post('cnic');
      $getParentCnic=StudentParentsInfo::find()->where(['cnic'=>$cnic])->All();

      foreach($getParentCnic as $cnic){

      if(empty($cnic->cnic)){
      }else{
      echo $cnic->stu->user->first_name .' '.$cnic->stu->user->last_name;
      echo ' class:';
      echo $cnic->stu->class->title;

      echo ' Group:';
      echo $cnic->stu->group->title;
      echo ' Section:';
      echo $cnic->stu->section->title;
      echo  ' <br /> ';
      }
      }
      } */

    public function actionParentCnic() {

        $cnic = yii::$app->request->post('cnic');
        $branch = yii::$app->request->post('branch');
        //$getParentCnic=StudentParentsInfo::find()->where(['cnic'=>$cnic])->All();
        $getParentCnic = yii::$app->db->createCommand("
        select st.stu_id as `student id`,concat(u.first_name,' ',u.middle_name,' ' ,u.last_name) as `student_name`, st.class_id as `class_id`,rc.title as `class_name`,st.group_id as `group id`,rg.title as `group_name`,st.section_id as `section_id`,rs.title as `section_name` from student_info st inner join student_parents_info spi on spi.stu_id=st.stu_id inner join ref_class rc on rc.class_id = st.class_id left join ref_group rg on rg.group_id=st.group_id left join ref_section rs on rs.section_id=st.section_id inner join user u on u.id=st.user_id where spi.cnic='" . $cnic . "' and st.fk_branch_id='" . $branch . "' and st.is_active='1'
        ")->queryAll();
        //print_r($getParentCnic);die;

        if (count($getParentCnic) > 0) {
            $renderViews = $this->renderAjax('parent-cnic', ['parntcnic' => $getParentCnic, 'pcnic' => $cnic]);
        } else {
            $renderViews = 'Not Found';
        }

        return json_encode(['viewtabl' => $renderViews]);
    }

    public function actionSaveLeave() {
        $post_date = date('Y-m-d', strtotime($_POST['getDate']));
        $post_stu = $_POST['student'];
        $postName = $_POST['nameStu'];
        // $_POST['select'];die;
        $exists = StudentAttendance::find()->where(['fk_stu_id' => $post_stu])
                ->andWhere(['between', 'date', $post_date . ' 00:00:00', $post_date . ' 23:59:59'])
                ->one();

        $getparentcontact = StudentParentsInfo::find()->select('contact_no')->where(['stu_id' => $post_stu])->one();
        $sendParentContact = $getparentcontact->contact_no;

        if (count($exists) > 0) {
            $model = StudentAttendance::findOne($exists->id);
        } else {
            $model = new StudentAttendance();
        }

        $stud_id = $model->fk_stu_id = $_POST['student'];
        $model->leave_type = $_POST['select'];
        $model->remarks = $_POST['remark'];
        $model->date = $_POST['getDate'];
        $msg = 'Respectfull Sir..! Your Son ' . $postName . ' ' . $_POST['select'] . ' today';
        if ($model->save()) {

            /* send sms */
            /* $ch = curl_init();
              curl_setopt($ch, CURLOPT_URL,"http://221.132.117.58:7700/sendsms_url.html");
              curl_setopt($ch, CURLOPT_POST, 1);
              curl_setopt($ch, CURLOPT_POSTFIELDS,'Username=03028501396&Password=123.123&From=MesaqDir&To='.$sendParentContact.'&Message='.$msg);
              curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
              $server_output = curl_exec ($ch);
              curl_close ($ch);
              if ($server_output == 'Message Sent Successfully!') {
              // echo 'Successfully Send';
              } else {
              //echo 'fail';
              } */

            Yii::$app->common->SendSms($sendParentContact, $msg, $stud_id);
            /* end of sms */
            //echo 'saved';
            $get_leave_type = $model->leave_type;
            if ($get_leave_type == 'absent') {
                echo '<span class="at_absent at_sp">A</span>';
            } else if ($get_leave_type == 'leave') {
                echo '<span class="leaveid at_sp at_leave">L</span>';
            } else if ($get_leave_type == 'latecomer') {
                //echo '<span style="color:#800000">'.date('H:i',strtotime($model->date)).'</span>';
                echo '<span class="leaveid at_sp at_leave_com">LC</span>';
            } else if ($get_leave_type == 'present') {
                echo '<span class="policies at_sp at_leave_present">P</span>';
            }
        } else {
            print_r($model->getErrors());
        }
    }

    // end of calendar

    /**
     * Displays a single StudentInfo model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id) {
        $model2 = StudentEducationalHistoryInfo::findOne(['stu_id' => $id]);

        if (Yii::$app->user->isGuest) {
            return $this->goHome();
        } else {
            return $this->render('view', [
                        'model' => $this->findModel($id),
                        'model2' => $model2
            ]);
        }
    }

    /**
     * Creates a new StudentInfo model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionGetClass() {

        $id = Yii::$app->request->post('id');
        $class = RefClass::find()->where(['fk_session_id' => $id, 'fk_branch_id' => Yii::$app->common->getBranch()])->all();

        echo "<option selected='selected'>Select Class</option>";
        foreach ($class as $class) {

            echo "<option value='" . $class->class_id . "'>" . $class->title . "</option>";
        }
    }

//end of class
    //========= get route ==============//
    public function actionGetRoute() {
        $id = Yii::$app->request->post('id');
        $route = Route::find()->where(['fk_zone_id' => $id])->all();
        echo "<option>Select Route</option>";
        foreach ($route as $route) {
            echo "<option value='" . $route->id . "'>" . $route->title . "</option>";
        }
    }

// ===============end of route and start of stop======//

    public function actionGetStop() {
        $id = Yii::$app->request->post('id');
        $stop = Stop::find()->where(['fk_route_id' => $id])->all();
        echo "<option value=''>Select Stop</option>";
        foreach ($stop as $stop) {
            echo "<option value='" . $stop->id . "'>" . $stop->title . "</option>";
        }
    }

// ===============end of route======//
    // country
    public function actionCountry() {

        $id = Yii::$app->request->post('id');
        $provinces = RefProvince::find()->where(['country_id' => $id])->all();

        echo "<option selected='selected'>Select Provinces</option>";
        foreach ($provinces as $province) {

            echo "<option value='" . $province->province_id . "'>" . $province->province_name . "</option>";
        }
    }

//end of country

    public function actionProvince() {
        $id = Yii::$app->request->post('id');
        $District = RefDistrict::find()->where(['province_id' => $id])->all();
        echo "<option selected='selected'>Select District</option>";
        foreach ($District as $district) {
            echo "<option value='" . $district->district_id . "'>" . $district->District_Name . "</option>";
        }
    }

//end of Province

    public function actionDistrict() {

        $id = Yii::$app->request->post('id');
        $city = RefCities::find()->where(['district_id' => $id])->all();

        echo "<option selected='selected'>Select City</option>";
        foreach ($city as $city) {

            echo "<option value='" . $city->city_id . "'>" . $city->city_name . "</option>";
        }
    }

//end of District
    //======== country 2 for admission============//
    public function actionCountry2() {

        $id = Yii::$app->request->post('id');
        $provinces = RefProvince::find()->where(['country_id' => $id])->all();

        echo "<option selected='selected'>Select Provinces</option>";
        foreach ($provinces as $province) {

            echo "<option value='" . $province->province_id . "'>" . $province->province_name . "</option>";
        }
    }

//end of country

    public function actionProvince2() {
        $id = Yii::$app->request->post('id');
        $District = RefDistrict::find()->where(['province_id' => $id])->all();
        echo "<option selected='selected'>Select District</option>";
        foreach ($District as $district) {
            echo "<option value='" . $district->district_id . "'>" . $district->District_Name . "</option>";
        }
    }

//end of Province

    public function actionDistrict2() {

        $id = Yii::$app->request->post('id');
        $city = RefCities::find()->where(['district_id' => $id])->all();

        echo "<option selected='selected'>Select City</option>";
        foreach ($city as $city) {

            echo "<option value='" . $city->city_id . "'>" . $city->city_name . "</option>";
        }
    }

//end of District
    //======== end of country 2 for admission============//

    public function actionGroup() {

        $id = Yii::$app->request->post('id');
        $group = RefGroup::find()->where(['fk_class_id' => $id])->all();

        $options = "<option selected='selected'>Select Group</option>";
        foreach ($group as $group) {
            $options .= "<option value='" . $group->group_id . "'>" . $group->title . "</option>";
        }
        return $options;
    }

//end of group

    public function actionSection() {

        $id = Yii::$app->request->post('id');
        $section = RefSection::find()->where(['fk_group_id' => $id])->all();
        echo "<option selected='selected'>Select Section</option>";
        foreach ($section as $section) {
            echo "<option value='" . $section->section_id . "'>" . $section->title . "</option>";
        }
    }

//end of Section


    /*  =====================  get bed of room ===== */

    public function actionGetHostelFloor() {
        $id = Yii::$app->request->post('id');
        $floor = HostelFloor::find()->where(['fk_hostel_info_id' => $id])->all();
        echo "<option selected='selected'>Select Floor</option>";
        foreach ($floor as $floor) {
            echo "<option value='" . $floor->id . "'>" . $floor->title . "</option>";
        }
    }

    public function actionGetFloorRoom() {
        $id = Yii::$app->request->post('id');
        $floorRoom = HostelRoom::find()->where(['fk_FLOOR_id' => $id])->all();
        echo "<option selected='selected'>Select Room</option>";
        foreach ($floorRoom as $floorRoom) {
            echo "<option value='" . $floorRoom->id . "'>" . $floorRoom->title . "</option>";
        }
    }

    public function actionGetBed() {

        $id = Yii::$app->request->post('id');
        $bed = HostelBed::find()->where(['fk_room_id' => $id])->all();
        echo "<option selected='selected' value=''>Select Bed</option>";
        foreach ($bed as $bed) {
            echo "<option value='" . $bed->id . "'>" . $bed->title . "</option>";
        }
    }

    /*  =====================  end of get bed of room ===== */

    //wizard
    public function actionAdmission() {
        if (Yii::$app->user->isGuest) {
            //      if user is not logged in go to home page.
            return $this->goHome();
        }
        $p_c = yii::$app->request->post('StudentParentsInfo');
        $prnt_cnic = $p_c['cnic'];
        $model = new StudentInfo();
        $model->scenario = 'admission';
        $model2 = new StudentParentsInfo();
        $userModel = new User();
        $feePlanModel = new FeePlanType();
        $hostelDetailModel = new HostelDetail();
        $StudentEducationalHistoryInfo = new StudentEducationalHistoryInfo();
        $model->gender_type = 1;
        $model2->gender_type = 1;
        $model->parent_status = 1;
        //$model->fk_stop_id=0;
        $model->is_hostel_avail = 0;
        $row = [];
        $head_wise = [];
        $studentInfoData = Yii::$app->request->post('StudentInfo');
        $parentsData = Yii::$app->request->post('StudentParentsInfo');
        $studentFinance = Yii::$app->request->post('StudentDisount');
        $studentHeadDescAmt = Yii::$app->request->post('head_hidden_discount_amount');
        $studentHeadDescTyp = Yii::$app->request->post('head_hidden_discount_type');
        $studentHeadAmt = Yii::$app->request->post('head_hidden_amount');

        $stu_fee_heads = (!empty($studentInfoData['student_fee_plan_array']))? unserialize($studentInfoData['student_fee_plan_array']): array();
        $stu_total_fee = (!empty($studentInfoData['student_fee_total_amount']))? $studentInfoData['student_fee_total_amount']: array();
        $stu_fee_plan = $studentInfoData['fk_fee_plan_type'];
        $due_date = date('Y-m-' . Yii::$app->common->getBranchSettings()->fee_due_date);

        $userRegstr = Yii::$app->request->post('User');
        $userRegester = $userRegstr['username'];
        $branch_std_counter = User::find()->where(['fk_branch_id' => Yii::$app->common->getBranch(), 'fk_role_id' => 3])->count();

        $parentContact = $parentsData['contact_no'];
        $count = count($parentsData['first_name']);
        /* load data into User model. */
        if ($userModel->load(Yii::$app->request->post())) {
            /*  echo "<pre>";
              print_r(Yii::$app->request->post());exit; */
            $file = UploadedFile::getInstance($userModel, 'Image');
            if ($file) {
                $userModel->Image = $file;
            }
            /* generate passoword */
            $random_password = Yii::$app->getSecurity()->generateRandomString($length = 7);
            /* $userModel->setPassword($random_password);
              $userModel->generateAuthKey(); */
            $random_password = '@moment2016';
            $userModel->setPassword($random_password);
            $userModel->generateAuthKey();
            $userModel->fk_role_id = 3;
            $userModel->status = 'inactive';
            $userModel->fk_branch_id = Yii::$app->common->getBranch();
            if ($userModel->save()) {
                if (!empty($file)) {
                    $file->saveAs(\Yii::$app->basePath . '/uploads/' . $file);
                }
                /* load data into student model. */
                if ($model->load(Yii::$app->request->post())) {
                    // echo '<pre>';print_r($_POST);die;
                    $model->fk_branch_id = Yii::$app->common->getBranch();
                    $stu_id = $model->user_id = $userModel->id;
                    $model->is_active = 0;
                    $model->fee_generation_date = date('Y-m-d');
                    $model->monthly_fee_gen_date = date('Y-m-d');
                    $model->fk_ref_province_id2 = $_POST['StudentInfo']['fk_ref_province_id3'];
                    $model->is_transport_avail = $_POST['StudentInfo']['is_transport_avail'];
                    if ($model->save()) {
                        /* save education history */
                        if ($StudentEducationalHistoryInfo->load(Yii::$app->request->post())) {
                            $StudentEducationalHistoryInfo->stu_id = $model->stu_id;
                            if ($StudentEducationalHistoryInfo->save()) {
                                
                            } else {
                                print_r($StudentEducationalHistoryInfo->getErrors());
                                die;
                            }
                        }

                        /* end of save education history */
                        /* load data into student parent model. */
                        if ($model2->load(Yii::$app->request->post())) {

                            $model2->stu_id = $model->stu_id;
                            /* $p_cx=$prnt_cnic;
                              $stu_ids=$model->stu_id;
                              $userModel->fk_branch_id= Yii::$app->common->getBranch();

                              for($i=1; $i<=$count;$i++){
                              if($parentsData['first_name'][$i]){
                              $row[]=[
                              $parentsData['first_name'][$i],

                              $parentsData['organisation'][$i],
                              $parentsData['designation'][$i],
                              $parentsData['profession'][$i],
                              $parentsData['contact_no'][$i],
                              $parentsData['email'][$i],
                              $parentsData['facebook_id'][$i],
                              $parentsData['twitter_id'][$i],
                              $parentsData['linkdin_id'][$i],
                              $stu_ids,
                              $p_cx,

                              ];
                              }

                              } */

                            /* $parentsSave= Yii::$app->db->createCommand()->batchInsert('student_parents_info', ['first_name','organisation','designation','profession','contact_no','email','facebook_id','twitter_id','linkdin_id','stu_id','cnic'],$row)->execute();
                              if($parentsSave){ */
                            if ($model2->save()) {
                                /* email will be composed here */

                                /* sms */

                                $msg = 'Welcome To ' . Yii::$app->common->getBranchDetail()->name . ' Your User Name is ' . $userRegester . ' and password is @moment2016';

                                Yii::$app->common->SendSms($parentContact, $msg, $stu_id);
                                /* end of sms */

                                if ($model->is_hostel_avail == 1) {
                                    if ($hostelDetailModel->load(Yii::$app->request->post())) {
                                        // $hostelDetailModel->fk_student_id=$userModel->id;
                                        $hostelDetailModel->fk_student_id = $model->stu_id;
                                        if ($hostelDetailModel->save()) {
                                            
                                        } else {
                                            print_r($hostelDetailModel->getErrors());
                                            die;
                                        }
                                    }
                                }
                            } else {
                                echo "<pre>";
                                print_r($model2->getErrors());
                                die;
                                return $this->render('admission', [
                                            'model' => $model,
                                            'model2' => $model2,
                                            'userModel' => $userModel,
                                            'hostelDetailModel' => $hostelDetailModel,
                                            'feePlanModel' => $feePlanModel,
                                            'StudentEducationalHistoryInfo' => $StudentEducationalHistoryInfo,
                                            'branch_std_counter' => $branch_std_counter
                                ]);
                            }//end of model2 else
                        }

                        /* fee particulars */
                        /* attendance submission in particulars and further. */
                        $feeCollectionPartModel = new FeeCollectionParticular();
                        $feeCollectionPartModel->fk_branch_id = Yii::$app->common->getBranch();
                        $feeCollectionPartModel->fk_stu_id = $model->stu_id; //$model->stu_id;
                        $feeCollectionPartModel->total_fee_amount = $stu_total_fee;
                        $feeCollectionPartModel->transport_fare = ($studentFinance['input_total_transport_fare']) ? $studentFinance['input_total_transport_fare'] : null;
                        $feeCollectionPartModel->hostel_fare = ($studentFinance['input_total_hostel_fare']) ? $studentFinance['input_total_hostel_fare'] : null;
                        $feeCollectionPartModel->discount_amount = ($studentFinance['input_total_discount']) ? $studentFinance['input_total_discount'] : null;
                        $feeCollectionPartModel->fee_payable = round($studentFinance['input_total_amount_payable'], 0);
                        $feeCollectionPartModel->due_date = $due_date;
                        if (!$feeCollectionPartModel->save()) {
                            print_r($feeCollectionPartModel->getErrors());
                        };

                        /* fee transection details */
                        $feeTransectionModel = new FeeTransactionDetails();
                        $feeTransectionModel->fk_branch_id = Yii::$app->common->getBranch();
                        $feeTransectionModel->stud_id = $model->stu_id;
                        $feeTransectionModel->fk_fee_collection_particular = $feeCollectionPartModel->id;
                        $feeTransectionModel->transaction_date = null;
                        $feeTransectionModel->transaction_amount = null;
                        $feeTransectionModel->opening_balance = $feeCollectionPartModel->fee_payable;
                        if (!$feeTransectionModel->save()) {
                            print_r($feeTransectionModel->getErrors());
                            exit;
                        };

                        /* fee particulars */
                        foreach ($stu_fee_heads as $key => $head) {
                            $feePrticularModal = new FeeParticulars();
                            $feePrticularModal->fk_branch_id = Yii::$app->common->getBranch();
                            $feePrticularModal->fk_stu_id = $model->stu_id;
                            $feePrticularModal->fk_fee_plan_type = $stu_fee_plan;
                            $feePrticularModal->is_paid = 0;
                            $feePrticularModal->fk_fee_head_id = $head;
                            if (!$feePrticularModal->save()) {
                                print_r($feePrticularModal->getErrors());
                                exit;
                            } else {
                                if ($studentHeadDescAmt[$feePrticularModal->fk_fee_head_id] > 0) {
                                    $modelFeeDescountIndv = new FeeDiscounts();
                                    $modelFeeDescountIndv->fk_stud_id = $model->stu_id;
                                    $modelFeeDescountIndv->fk_fee_discounts_type_id = ($studentHeadDescTyp[$feePrticularModal->fk_fee_head_id] != 0) ? $studentHeadDescTyp[$feePrticularModal->fk_fee_head_id] : null;
                                    $modelFeeDescountIndv->fk_fee_head_id = $head;
                                    $modelFeeDescountIndv->amount = $studentHeadDescAmt[$feePrticularModal->fk_fee_head_id];
                                    $modelFeeDescountIndv->is_active = 1;
                                    $modelFeeDescountIndv->save();
                                    if (!$modelFeeDescountIndv->save()) {
                                        print_r($modelFeeDescountIndv->getErrors());
                                        exit;
                                    }
                                    $head_wise[] = [
                                        'fk_particular_id' => $feePrticularModal->id,
                                        'head_amount' => $studentHeadDescAmt[$feePrticularModal->fk_fee_head_id],
                                    ];
                                }
                            }

                            /* creating fee challan record. */
                            $fee_challan_recordModel = New FeeChallanRecord();
                            $fee_challan_recordModel->challan_id = $feeTransectionModel->id;
                            $fee_challan_recordModel->fk_stu_id = $model->stu_id;
                            $fee_challan_recordModel->fk_fee_plan_id = $stu_fee_plan;
                            $fee_challan_recordModel->fk_head_id = $head;
                            $fee_challan_recordModel->head_amount = round($studentHeadAmt[$feePrticularModal->fk_fee_head_id] - $studentHeadDescAmt[$feePrticularModal->fk_fee_head_id], 0);
                            $fee_challan_recordModel->fare_amount = ($studentFinance['input_total_transport_fare']) ? $studentFinance['input_total_transport_fare'] : null;
                            $fee_challan_recordModel->hostel_fare = ($studentFinance['input_total_hostel_fare']) ? $studentFinance['input_total_hostel_fare'] : null;
                            if (!$fee_challan_recordModel->save()) {
                                print_r($fee_challan_recordModel->getErrors());
                                exit;
                            }
                        }


                        /* returning to the detail view of stuednt. */
                        Yii::$app->session->setFlash('success', 'Student has been save successfully.');
                        $this->redirect(['student/profile', 'id' => $model->stu_id, 'ch_id' => $feeTransectionModel->id]);
                    } else {
                        echo "<pre>";
                        print_r($model->getErrors());
                        die;
                        return $this->render('admission', [
                                    'model' => $model,
                                    'model2' => $model2,
                                    'userModel' => $userModel,
                                    'hostelDetailModel' => $hostelDetailModel,
                                    'feePlanModel' => $feePlanModel,
                                    'StudentEducationalHistoryInfo' => $StudentEducationalHistoryInfo,
                                    'branch_std_counter' => $branch_std_counter
                        ]);
                    }
                } else {
                    echo "<pre>";
                    print_r($model->getErrors());
                    exit;
                    return $this->render('admission', [
                                'model' => $model,
                                'model2' => $model2,
                                'userModel' => $userModel,
                                'hostelDetailModel' => $hostelDetailModel,
                                'feePlanModel' => $feePlanModel,
                                'StudentEducationalHistoryInfo' => $StudentEducationalHistoryInfo,
                    ]);
                }
            } else {
                /* print_r($userModel->getErrors());die; */
                echo "<pre>";
                print_r($userModel->getErrors());
                exit;
                return $this->render('admission', [
                            'model' => $model,
                            'model2' => $model2,
                            'userModel' => $userModel,
                            'hostelDetailModel' => $hostelDetailModel,
                            'feePlanModel' => $feePlanModel,
                            'StudentEducationalHistoryInfo' => $StudentEducationalHistoryInfo,
                            'branch_std_counter' => $branch_std_counter
                ]);
            }
        } else {
            // print_r($userModel->getErrors());die;
            return $this->render('admission', [
                        'model' => $model,
                        'model2' => $model2,
                        'userModel' => $userModel,
                        'hostelDetailModel' => $hostelDetailModel,
                        'feePlanModel' => $feePlanModel,
                        'StudentEducationalHistoryInfo' => $StudentEducationalHistoryInfo,
                        'branch_std_counter' => $branch_std_counter
            ]);
        }
    }

    //end of wizard
    public function actionCreate() {
        if (Yii::$app->user->isGuest) {
            //      if user is not logged in go to home page.
            return $this->goHome();
        }

        $model = new StudentInfo();
        //$model->scenario = 'admission';
        $model2 = new StudentParentsInfo();
        $userModel = new User();
        $hostelDetailModel = new HostelDetail();
        $model->gender_type = 1;
        $model2->gender_type = 1;
        $model->parent_status = 1;
        $model->stop = 0;
        $model->is_hostel_avail = 0;
        $branch_std_counter = User::find()->where(['fk_branch_id' => Yii::$app->common->getBranch(), 'fk_role_id' => 3])->count();

        /* load data into User model. */
        if ($userModel->load(Yii::$app->request->post())) {
            // print_r(Yii::$app->request->post());die;
            //['HostelDetail']['fk_hostel_id'];die;
            //echo '<pre>';print_r($_POST);die;
            $file = UploadedFile::getInstance($userModel, 'Image');
            //$userModel->Image = UploadedFile::getInstance($userModel, 'Image');
            if ($file) {
                $userModel->Image = $file;
            }
            /* generate passoword */
            $random_password = Yii::$app->getSecurity()->generateRandomString($length = 7);
            $userModel->setPassword($random_password);
            $userModel->generateAuthKey();
            $userModel->fk_role_id = 3;
            if ($userModel->save()) {
                if (!empty($file)) {
                    $file->saveAs(\Yii::$app->basePath . '/uploads/' . $file);
                }
                /* load data into student model. */
                if ($model->load(Yii::$app->request->post())) {
                    // echo '<pre>';print_r($_POST);die;
                    $model->user_id = $userModel->id;
                    if ($model->save()) {
                        /* load data into student parent model. */
                        if ($model2->load(Yii::$app->request->post())) {
                            $model2->stu_id = $model->stu_id;
                            if ($model2->save()) {
                                /* sms */

                                /* end of sms */
                                /* email will be composed here */
                                if ($model->is_hostel_avail == 1) {
                                    if (!empty($hostelDetailModel->load(Yii::$app->request->post()))) {
                                        // $hostelDetailModel->fk_student_id=$userModel->id;
                                        $hostelDetailModel->fk_student_id = $model->stu_id;
                                        if ($hostelDetailModel->save()) {
                                            
                                        } else {
                                            //  print_r($hostelDetailModel->getErrors());die;
                                        }
                                    }
                                }
                                /* returning to the detail view of stuednt. */
                                if (Yii::$app->request->post('submit') === 'create_continue') {
                                    //employe education info form.
                                    return $this->redirect(['student-education/create', 'id' => $model->stu_id]);
                                } else {
                                    return $this->redirect(['student/view', 'id' => $model->stu_id]);
                                }
                            } else {
                                //  print_r($model2->getErrors());die;
                                return $this->render('create', [
                                            'model' => $model,
                                            'model2' => $model2,
                                            'userModel' => $userModel,
                                            'hostelDetailModel' => $hostelDetailModel,
                                            'branch_std_counter' => $branch_std_counter
                                ]);
                            }
                        }
                    } else {
                        // print_r($model->getErrors());die;
                        return $this->render('create', [
                                    'model' => $model,
                                    'model2' => $model2,
                                    'userModel' => $userModel,
                                    'hostelDetailModel' => $hostelDetailModel,
                                    'branch_std_counter' => $branch_std_counter
                        ]);
                    }
                } else {
                    return $this->render('create', [
                                'model' => $model,
                                'model2' => $model2,
                                'userModel' => $userModel,
                                'hostelDetailModel' => $hostelDetailModel,
                                'branch_std_counter' => $branch_std_counter
                    ]);
                }
            } else {
                // print_r($userModel->getErrors());die;
                return $this->render('create', [
                            'model' => $model,
                            'model2' => $model2,
                            'userModel' => $userModel,
                            'hostelDetailModel' => $hostelDetailModel,
                            'branch_std_counter' => $branch_std_counter
                ]);
            }
        } else {
            //  print_r($userModel->getErrors());die;
            return $this->render('create', [
                        'model' => $model,
                        'model2' => $model2,
                        'userModel' => $userModel,
                        'hostelDetailModel' => $hostelDetailModel,
                        'branch_std_counter' => $branch_std_counter
            ]);
        }
    }

    /**
     * Updates an existing StudentInfo model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id) {

        if (Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        //echo '<pre>';print_r($_POST);die;




        $model = $this->findModel($id);
        $model2 = StudentParentsInfo::find()->where(['stu_id' => $id])->one();
        $userModel = User::find()->where(['id' => $model->user_id])->one();
        //$hostelDetail  = HostelDetail::find()->where(['fk_student_id'=>$id])->one();
        //$model->is_transport_avail=1;
        if ($model->is_hostel_avail == 1) {
            $hostelDetailModel = HostelDetail::find()->where(['fk_student_id' => $id])->one();
        } else {
            $hostelDetailModel = new HostelDetail();
        }
        $old_image = $userModel->Image;
        $old_transport = $model->fk_stop_id;
        $old_hostel = $model->is_hostel_avail;
        $branch_std_counter = User::find()->where(['fk_branch_id' => Yii::$app->common->getBranch(), 'fk_role_id' => 3])->count();

        /* load data into student model. model */
        if ($model->load(Yii::$app->request->post())) {
            //update is hostel avail

            if ($old_hostel == 0 && $model->is_hostel_avail == 1) {
                $model->hostel_updated = 1;
            }
            //update is transport avail
            if ($old_transport == 0 && $model->fk_stop_id > 0) {
                $model->transport_updated = 1;
            }
            if ($model->save()) {
                $p_c = yii::$app->request->post('StudentParentsInfo');
                $parentsData = Yii::$app->request->post('StudentParentsInfo');
                //echo '<pre>';print_r($p_c);die;
                //$prnt_cnic=$p_c['cnic'];
                //$parentContact     = $parentsData['contact_no'][1];
                $count = count($parentsData['first_name']);
                if ($userModel->load(Yii::$app->request->post())) {
                    if (!empty($_FILES['User']['name']['Image'])) {
                        $file = UploadedFile::getInstance($userModel, 'Image');

                        $file->saveAs(\Yii::$app->basePath . '/uploads/' . $file);
                        $userModel->Image = $file;
                    } else {
                        $userModel->Image = $old_image;
                    }
                    if ($userModel->save()) {
                        if ($model->is_hostel_avail == 1) {
                            if ($hostelDetailModel->load(Yii::$app->request->post())) {
                                // $hostelDetailModel->fk_student_id=$userModel->id;
                                $hostelDetailModel->is_booked = "1";

                                $hostelDetailModel->fk_student_id = $id;
                                if ($hostelDetailModel->save()) {
                                    
                                } else {
                                    print_r($hostelDetailModel->getErrors());
                                    die;
                                }
                            }
                        }
                        //print_r($userModel->getErrors());die;

                        /* laod data to student parent model */
                        if ($model2->load(Yii::$app->request->post())) {
                            // $p_cx=$prnt_cnic;
                            $stu_ids = $model->stu_id;
                            $userModel->fk_branch_id = Yii::$app->common->getBranch();
                            /* for($i=1; $i<=$count;$i++){
                              if($parentsData['first_name'][$i]){
                              $row[]=[
                              $parentsData['first_name'][$i],
                              // $parentsData['middle_name'][$i],
                              //$parentsData['last_name'][$i],
                              // $parentsData['cnic'][$i],
                              $parentsData['organisation'][$i],
                              $parentsData['designation'][$i],
                              $parentsData['profession'][$i],
                              $parentsData['contact_no'][$i],
                              $parentsData['email'][$i],
                              $parentsData['facebook_id'][$i],
                              $parentsData['twitter_id'][$i],
                              $parentsData['linkdin_id'][$i],
                              $stu_ids,
                              $p_cx,

                              ];
                              }

                              } */
                            // print_r($row);die;

                            /* $parentsSave= Yii::$app->db->createCommand()->batchUpdate('student_parents_info', ['first_name','organisation','designation','profession','contact_no','email','facebook_id','twitter_id','linkdin_id','stu_id','cnic'],$row)->execute(); */

                            if ($model2->save()) {
                                
                            } else {
                                echo "<pre>";
                                print_r($model2->getErrors());
                                exit;
                            }
                            return $this->redirect(['profile', 'id' => $model->stu_id]);
                        }
                    } else {
                        //print_r($model2->getErrors());die;
                        echo "<pre>";
                        print_r($model2->getErrors());
                        exit;
                        return $this->render('update', [
                                    'model' => $model,
                                    'model2' => $model2,
                                    'userModel' => $userModel,
                                    'branch_std_counter' => $branch_std_counter
                        ]);
                    }
                }
            } else {
                return $this->render('update', [
                            'model' => $model,
                            'model2' => $model2,
                            'userModel' => $userModel,
                            'hostelDetailModel' => $hostelDetailModel,
                            'branch_std_counter' => $branch_std_counter
                ]);
            }
        } else {
            return $this->render('update', [
                        'model' => $model,
                        'model2' => $model2,
                        'userModel' => $userModel,
                        'hostelDetailModel' => $hostelDetailModel,
                        'branch_std_counter' => $branch_std_counter
            ]);
        }
    }

    /**
     * Deletes an existing StudentInfo model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    // public function actionDelete($id)
    // {
    //     if (Yii::$app->user->isGuest) {
    //         return $this->goHome();
    //     }
    //      this id is user id and it will delete from user table and
    //      * according to defined relations student,student info table data will
    //      * delete automatically.
    //     $userModel= User::findOne($id);
    //     $userModel->delete();
    //     return $this->redirect(['index']);
    // }
    public function actionInactive($id) {
        //echo $id;
        $model = User::findOne($id);
        //$model2= StudentInfo::findOne($id);
        //print_r($model);
        $model->status = 'inactive';
        // $model2->is_active = '0';
        $model->save();
        if (!Yii::$app->request->isAjax) {
            return $this->redirect(['index']);
        }
    }

    public function actionDelete($id) {

        // print_r($_POST);die;
        //echo 'here';die;
        $model = StudentInfo::findOne($id);
        $model->is_active = '0';
        $model->save();
        if (!Yii::$app->request->isAjax) {
            return $this->redirect(['index']);
        }
    }

    /**
     * Finds the StudentInfo model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return StudentInfo the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = StudentInfo::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionGenerateDmcPdf() {
        if (Yii::$app->user->isGuest) {
            return $this->redirect(['site/login']);
        } else {
            if (Yii::$app->request->post()) {
                $data = Yii::$app->request->post();
                $student_id = $data['student_id'];
                $exam_type = $data['exam_type'];
                $stuModel = StudentInfo::find()->where(['fk_branch_id' => Yii::$app->common->getBranch(), 'stu_id' => $student_id])->one();

                /*
                 * $subjects_data =  Yii::$app->db->createCommand('select  sb.id as subject_id,sb.title as `subject`,sum(ex.total_marks) as `total marks`, sum(ex.passing_marks) as `passing marks`,sum(sm.marks_obtained) as `marks obtained`from exam ex
                  inner join exam_type et on et.id=ex.fk_exam_type
                  inner join ref_class c on c.class_id=ex.fk_class_id
                  left join ref_group g on g.fk_class_id=ex.fk_class_id
                  left join ref_section s on s.class_id=ex.fk_class_id
                  inner join subjects sb on sb.id=ex.fk_subject_id
                  left join student_marks sm on sm.fk_exam_id=ex.id
                  inner join student_info st on st.stu_id=sm.fk_student_id
                  inner join user u on u.id=st.user_id
                  where et.id=5 and st.stu_id='.$stuModel->stu_id.'
                  GROUP by st.stu_id,et.type ,sb.title,sb.id')
                  ->queryAll();
                 */
                $subjects_data = Exam::find()
                                ->select([
                                    'sb.id subject_id',
                                    'sb.title subject',
                                    'sum(exam.total_marks) total_marks',
                                    'sum(exam.passing_marks) passing_marks',
                                    'sum(sm.marks_obtained) marks_obtained'
                                ])
                                ->innerJoin('exam_type et', 'et.id=exam.fk_exam_type')
                                ->innerJoin('ref_class c', 'c.class_id=exam.fk_class_id')
                                ->leftJoin('ref_group g', 'g.fk_class_id=exam.fk_class_id ')
                                ->leftJoin('ref_section s', 's.class_id=exam.fk_class_id ')
                                ->innerJoin('subjects sb', 'sb.id=exam.fk_subject_id')
                                ->leftJoin('student_marks sm', 'sm.fk_exam_id=exam.id ')
                                ->innerJoin('student_info st', 'st.stu_id=sm.fk_student_id')
                                ->innerJoin('user u', 'u.id=st.user_id')
                                ->where(['et.id' => $exam_type, 'st.stu_id' => $stuModel->stu_id])
                                ->groupBy(['st.stu_id', 'et.type', 'sb.title', 'sb.id'])->asArray()->all();



                if (count($subjects_data) > 0) {
                    return $this->render('generate-std-pdf', [
                                'model' => $stuModel,
                                'data' => $data,
                                'subjects_data' => $subjects_data
                    ]);

                    /*
                      $this->layout = 'pdf';
                      $mpdf=new mPDF('','A4');
                      $mpdf->WriteHTML($html);
                      $mpdf->Output(); */
                } else {
                    Yii::$app->session->setFlash('warning', 'Student Subjects marks Not found.');
                    return $this->redirect(['student/']);
                }
            } else {
                return $this->redirect(['site/login']);
            }
        }
    }

    /* get student fee challan. */

    public function actionGetFeeChallan() {
        if (Yii::$app->user->isGuest) {
            return $this->redirect(['site/login']);
        } else {
            if (Yii::$app->request->post()) {
                $data = Yii::$app->request->post();

                $fineTypeModel = new FineType();
                $fee_plan_id = $data['plan_id'];
                $parent_cnic = $data['parent_cnic'];
                $transport_fare = 0;
                $hostel_fee = 0;
                $stuparent_info = 0;
                $fee_plan_Model = FeePlanType::findOne($fee_plan_id);
                if (!empty($parent_cnic)) {
                    $stuparent_info = StudentParentsInfo::find()
                            ->select(['student_parents_info.stu_id', 'si.fk_branch_id', 'student_parents_info.stu_parent_id'])
                            ->innerJoin('student_info si', 'si.stu_id = student_parents_info.stu_id')
                            ->where(['si.fk_branch_id' => Yii::$app->common->getBranch(), 'student_parents_info.cnic' => $parent_cnic])
                            ->count();
                }

                if (!empty($data['stop_id'])) {
                    $stopModel = Stop::findOne($data['stop_id']);
                    $transport_fare = $stopModel->fare;
                }
                if (!empty($data['hostel_id'])) {
                    $HostelModel = Hostel::findOne(['id' => $data['hostel_id'], 'fk_branch_id' => Yii::$app->common->getBranch()]);
                    $hostel_fee = $HostelModel->amount;
                }
                $query = FeeHeads::find()
                                ->select([
                                    'fpm.time_span as no_months',
                                    'fee_heads.id as head_id',
                                    'fee_heads.title',
                                    'fee_heads.promotion_head',
                                    'fee_heads.discount_head_status as discount_head_status',
                                    'fee_heads.description',
                                    'fg.amount',
                                    'fg.is_active',
                                    'rc.title as class',
                                    'rg.title as group'
                                ])
                                ->innerJoin('fee_payment_mode fpm', 'fpm.id=fee_heads.fk_fee_method_id')
                                ->leftJoin('fee_group fg', 'fg.fk_fee_head_id=fee_heads.id')
                                ->innerJoin('ref_class rc', 'rc.class_id=fg.fk_class_id')
                                ->leftJoin('ref_group rg', 'rg.group_id=fg.fk_group_id')
                                ->where(['fg.is_active' => 'yes', 'rc.class_id' => $data['class_id'], 'rg.group_id' => ($data['group_id']) ? $data['group_id'] : null])->asArray()->all();

                /* fee plan type */
                $html = $this->renderAjax('get-fee-challan', [
                    'query' => $query,
                    'fineTypeModel' => $fineTypeModel,
                    'fee_plan_Model' => $fee_plan_Model,
                    'transport_fare' => $transport_fare,
                    'hostel_fee' => $hostel_fee,
                    'cnic_count' => $stuparent_info,
                    'parent_cnic' => $parent_cnic
                ]);
                return json_encode(['status' => 1, 'html' => $html]);
            }
        }
    }

    /* generate student fee challan on view page. */

    public function actionGenerateStudentFeeChallan() {
        if (Yii::$app->user->isGuest) {
            $this->redirect(['site/login']);
        } else {
            if (Yii::$app->request->get('challan_id')) {
                $query_std_plan = User::find()
                                ->select(['CONCAT(user.first_name," ",user.last_name) as name', 'fp.no_of_installments as no_of_installments', 'fp.title as plan_type', 'si.class_id', 'spi.cnic'])
                                ->innerJoin('student_info si', 'si.user_id = user.id')
                                ->innerJoin('student_parents_info spi', 'spi.stu_id = si.stu_id')
                                ->innerJoin('fee_plan_type fp', 'fp.id = si.fk_fee_plan_type')
                                ->where(['user.fk_branch_id' => Yii::$app->common->getBranch(), 'si.stu_id' => Yii::$app->request->get('stu_id')])->asArray()->one();
                $stuparent_info = 0;
                if (!empty($query_std_plan['cnic'])) {
                    $stuparent_info = StudentParentsInfo::find()
                            ->innerJoin('student_info si', 'si.stu_id = student_parents_info.stu_id')
                            ->where(['si.fk_branch_id' => Yii::$app->common->getBranch(), 'student_parents_info.cnic' => $query_std_plan['cnic']])
                            ->count();
                }
                $student_id = Yii::$app->request->get('stu_id');
                $student_data = Yii::$app->common->getStudent($student_id);
                $challan_id = Yii::$app->request->get('challan_id');
                $std_plan_type = $student_data->fk_fee_plan_type;
                $class_id = $student_data->class_id;
                $group_id = $student_data->group_id;
                $section_id = $student_data->section_id;
                $stop_id = $student_data->fk_stop_id;
                $transport_fare = 0;
                $fee_challan = FeeTransactionDetails::findOne($challan_id);
                $feecollectionModel = \app\models\FeeCollectionParticular::findOne(['id' => $fee_challan->fk_fee_collection_particular, 'is_active' => 1]);

                $fee_plan_Model = FeePlanType::findOne($std_plan_type);
                if (!empty($stop_id)) {
                    $stopModel = Stop::findOne($stop_id);
                    $transport_fare = $stopModel->fare;
                }
                $query = FeeHeads::find()->select([
                                    'fg.amount  fee_head_amount',
                                    'fpm.time_span as no_months',
                                    'fee_heads.id as head_id',
                                    'fee_heads.title',
                                    'fee_heads.promotion_head',
                                    'fee_heads.discount_head_status',
                                    'fee_heads.description',
                                    'fg.amount',
                                    'fg.is_active',
                                    'rc.title as class',
                                    'rg.title as group'
                                ])
                                ->innerJoin('fee_payment_mode fpm', 'fpm.id=fee_heads.fk_fee_method_id')
                                ->leftJoin('fee_group fg', 'fg.fk_fee_head_id=fee_heads.id')
                                ->innerJoin('ref_class rc', 'rc.class_id=fg.fk_class_id')
                                ->leftJoin('ref_group rg', 'rg.group_id=fg.fk_group_id')
                                ->where(['fg.is_active' => 'yes', 'rc.class_id' => $class_id, 'rg.group_id' => ($group_id) ? $group_id : null])->asArray()->all();
                
                    //Get fk_fee_head_id from fk_fee_plan_tpe.
                    $fee_head = yii::$app->db->createCommand("SELECT c.head_amount, f.title FROM fee_challan_record AS c LEFT JOIN fee_heads AS f ON c.fk_head_id = f.id WHERE c.fk_stu_id=".$student_id)->queryAll();

                    $strQuery = User::find()->select([
                    'user.id',
                    'user.first_name',
                    'user.last_name',
                    'user.middle_name',
                    'user.username',
                    's.cnic',
                    's.is_hostel_avail',
                    's.transport_updated',
                    's.country_id',
                    's.district_id',
                    's.gender_type',
                    's.withdrawl_no',
                    's.location1',
                    'c.title AS class_title',
                    'g.title AS group_title',
                    'se.title AS section_title',
                    'shift.title AS shift_title' 
                    ])
                    ->leftJoin('student_info AS s', 'user.id = s.user_id') 
                    ->leftJoin('ref_class AS c', 'c.class_id = s.class_id' )
                    ->leftJoin('ref_group AS g', 'g.group_id = s.group_id' )
                    ->leftJoin('ref_section AS se', 'se.section_id = s.section_id' )
                    ->leftJoin('ref_shift AS shift', 'shift.shift_id = s.shift_id')
                    ->where(['user.id' => $student_data->user_id])->asArray()->all();

                $parent_info = Yii::$app->common->getParentInfo($student_id);
                $student_ed_info = Yii::$app->common->getStudentEducationInfo($student_id);
                $hostel =  yii::$app->db->createCommand("SELECT hostel.Name AS hostel, f.title AS FLOOR, r.title AS room, b.title AS bed, d.create_date AS Allotment FROM hostel_detail AS d LEFT JOIN hostel ON hostel.id = d.fk_hostel_id LEFT JOIN hostel_floor AS f ON f.id = d.fk_floor_id LEFT JOIN hostel_room AS r ON r.id = d.fk_room_id LEFT JOIN hostel_bed AS b ON b.id = d.fk_bed_id WHERE d.fk_student_id=".$student_id)->queryAll();
                $branch = yii::$app->db->createCommand("SELECT * FROM branch WHERE id = ".$student_data->fk_branch_id)->queryOne();

                $country_id = ($student_data->country_id == "")? 1: $student_data->country_id;
                $province_id = ($student_data->province_id == "")? 1: $student_data->province_id;
                $city_id = ($student_data->city_id == "")? 1: $student_data->city_id;
                $religion_id = ($student_data->religion_id == "")? 1: $student_data->religion_id;
                $district_id = ($student_data->district_id == "")? 1: $student_data->district_id;
                
                /* generate PDF of challan */
                $chalan_html = $this->render('get-chalan-pdf', [
                    'query_std_plan' => $query_std_plan,
                    'due_date' => $feecollectionModel->due_date,
                    'query' => $query,
                    'student_data' => $student_data,
                    'fee_plan_Model' => $fee_plan_Model,
                    'transport_fare' => $transport_fare,
                    'challan_details' => $fee_challan,
                    'cnic_count' => $stuparent_info,
                    'parent_cnic' => $query_std_plan['cnic'],
                    'detail' => $strQuery,
                    'parent_info' => $parent_info,
                    'student_ed_info' => $student_ed_info,
                    'fee_head' => $fee_head,
                    'branch' => $branch,
                    'country' =>  yii::$app->db->createCommand("SELECT country_name FROM ref_countries WHERE country_id = ".$country_id)->queryAll(),
                    'province' => yii::$app->db->createCommand("SELECT province_name FROM ref_province WHERE province_id = ".$province_id)->queryAll(),
                    'city' => yii::$app->db->createCommand("SELECT city_name FROM ref_cities WHERE city_id = ".$city_id)->queryAll(),
                    'religion' => yii::$app->db->createCommand("SELECT Title FROM ref_religion WHERE religion_type_id = ".$religion_id)->queryAll(),
                    'District' => yii::$app->db->createCommand("SELECT District_Name FROM ref_district WHERE district_id = ".$district_id)->queryAll()
                ]);
                
                $this->layout = 'pdf';
                $mpdf = new mPDF('', 'A4');
                $mpdf = new mPDF('', '', 0, '', 2, 2, 3, 3, 2, 2, 'A4');
                $mpdf->WriteHTML($chalan_html);
                $mpdf->Output('Student-challan.pdf', 'D');
            }
        }
    }

    /* generate student partial fee challan on view page. */

    public function actionGenerateStudentPartialFeeChallan() {
        if (Yii::$app->user->isGuest) {
            $this->redirect(['site/login']);
        } else {
            if (Yii::$app->request->get('challan_id')) {
                $query_std_plan = User::find()
                                ->select(['CONCAT(user.first_name," ",user.last_name) as name', 'fp.no_of_installments as no_of_installments', 'fp.title as plan_type', 'si.class_id'])
                                ->innerJoin('student_info si', 'si.user_id = user.id')
                                ->innerJoin('fee_plan_type fp', 'fp.id = si.fk_fee_plan_type')
                                ->where(['user.fk_branch_id' => Yii::$app->common->getBranch(), 'si.stu_id' => Yii::$app->request->get('stu_id')])->asArray()->one();



                $student_id = Yii::$app->request->get('stu_id');
                $student_data = Yii::$app->common->getStudent($student_id);
                $challan_id = Yii::$app->request->get('challan_id');
                $std_plan_type = $student_data->fk_fee_plan_type;
                $class_id = $student_data->class_id;
                $group_id = $student_data->group_id;
                $section_id = $student_data->section_id;
                $stop_id = $student_data->fk_stop_id;
                $is_hostel_avail = $student_data->is_hostel_avail;
                $transport_fare = 0;
                $fee_challan = FeeTransactionDetails::findOne($challan_id);
                $feecollectionModel = \app\models\FeeCollectionParticular::findOne(['id' => $fee_challan->fk_fee_collection_particular, 'is_active' => 1]);
                $fee_plan_Model = FeePlanType::findOne($std_plan_type);

                $query = FeeHeads::find()->select([
                                    'fg.amount  fee_head_amount',
                                    'fpm.time_span as no_months',
                                    'fee_heads.id as head_id',
                                    'fee_heads.title',
                                    'fee_heads.promotion_head',
                                    'fee_heads.description',
                                    'fg.amount',
                                    'fg.is_active',
                                    'rc.title as class',
                                    'rg.title as group'
                                ])
                                ->innerJoin('fee_payment_mode fpm', 'fpm.id=fee_heads.fk_fee_method_id')
                                ->leftJoin('fee_group fg', 'fg.fk_fee_head_id=fee_heads.id')
                                ->innerJoin('ref_class rc', 'rc.class_id=fg.fk_class_id')
                                ->leftJoin('ref_group rg', 'rg.group_id=fg.fk_group_id')
                                ->where(['rc.class_id' => $class_id, 'rg.group_id' => ($group_id) ? $group_id : null])->asArray()->all();

                /* transport fee paid or not if availble. */
                $transport_hostel_received = \app\models\FeeHeadWise::find()
                                ->select(['transport_fare', 'hostel_fee'])
                                ->where([
                                    'fk_branch_id' => Yii::$app->common->getBranch(),
                                    'fk_chalan_id' => $challan_id,
                                    'fk_stu_id' => $student_id,
                                ])->asArray()->one();

                /* generate PDF of challan */
                $chalan_partial_html = $this->render('get-partial-chalan-pdf', [
                    'query_std_plan' => $query_std_plan,
                    'due_date' => $feecollectionModel->due_date,
                    'query' => $query,
                    'student_data' => $student_data,
                    'fee_plan_Model' => $fee_plan_Model,
                    'transport_fare' => $feecollectionModel->transport_fare,
                    'hostel_fare' => $feecollectionModel->hostel_fare,
                    'challan_details' => $fee_challan,
                    'transport_hostel_received' => $transport_hostel_received
                ]);
                $this->layout = 'pdf';
                //$mpdf = new mPDF('', 'A4');
                $mpdf = new mPDF('', '', 0, '', 2, 2, 3, 3, 2, 2, 'A4');
                $mpdf->WriteHTML($chalan_partial_html);
                $mpdf->Output('Student-partial-challan.pdf', 'D');
            }
        }
    }

    /* validate username */

    public function actionValidateUsrname() {
        if (Yii::$app->user->isGuest) {
            $this->redirect(['site/login']);
        } else {
            if (Yii::$app->request->isAjax) {
                $userModel = User::find()->where(['fk_branch_id' => Yii::$app->common->getBranch(), 'username' => Yii::$app->request->post('username')])->count();
                return json_encode(['status' => 1, 'detail' => $userModel]);
            }
        }
    }

    /* promote student module. */

    public function actionPromoteStudents() {
        if (Yii::$app->user->isGuest) {
            return $this->redirect(['site/login']);
        } else {
            $model = new StudentInfo();
            /*
             *   Process for non-ajax request
             */
            return $this->render('promote-students', [
                        'model' => $model,
            ]);
        }
    }

    /* branch student list for promotion */

    public function actionBranchStudentList() {
        if (Yii::$app->user->isGuest) {
            return $this->redirect(['site/login']);
        } else {
            if (Yii::$app->request->isAjax) {
                $model = new StudentInfo();
                $data = Yii::$app->request->post();
                if (Yii::$app->request->post()) {
                    if ($data['section_id']) {
                        $class_id = $data['class_id'];
                        $group_id = $data['group_id'];
                        $section_id = $data['section_id'];
                        /* query */
                        $query = StudentInfo::find()->where([
                            'fk_branch_id' => Yii::$app->common->getBranch(),
                            'class_id' => $class_id,
                            'group_id' => ($group_id) ? $group_id : null,
                            'section_id' => $section_id,
                            'is_active' => 1
                        ]);
                        $searchModel = new \app\models\search\StudentInfoSearch();

                        //$searchModel->patient_id = $post_data['pat_id'];
                        //$dataProvider = $searchModel->search(Yii::$app->request->queryParams);
                        $dataProvider = new ActiveDataProvider([
                            'query' => $query,
                            'sort' => [
                                'defaultOrder' => [
                                    'stu_id' => SORT_DESC
                                ]
                            ],
                            'pagination' => [
                                'pageSize' => 100,
                                'params' => [
                                    'class_id' => $class_id,
                                    'group_id' => ($group_id) ? $group_id : null,
                                    'section_id' => $section_id,
                                ],
                            ]
                        ]);
                        // print_r(Yii::$app->request->queryParams);die;

                        $details = $this->renderAjax('branch-students-list', [
                            'searchModel' => $searchModel,
                            'dataProvider' => $dataProvider,
                            'model' => $model,
                        ]);

                        return json_encode(['status' => 1, 'details' => $details]);
                    } else {
                        return json_encode(['status' => 1, 'details' => '<div class="alert alert-warning"><strong>Note!</strong>Record Not Found.</div>']);
                    }
                } else {
                    /* geting data on pagination. */
                    $post_data = Yii::$app->request->get();
                    $class_id = $post_data['class_id'];
                    $group_id = $post_data['group_id'];
                    $section_id = $post_data['section_id'];
                    /* query */
                    $query = StudentInfo::find()->where([
                        'fk_branch_id' => Yii::$app->common->getBranch(),
                        'class_id' => $class_id,
                        'group_id' => ($group_id) ? $group_id : null,
                        'section_id' => $section_id,
                    ]);
                    $countQuery = clone $query;

                    $pages = new \yii\data\Pagination(['totalCount' => $countQuery->count()]);
                    $dataProvider = new ActiveDataProvider([
                        'query' => $query,
                        'sort' => [
                            'defaultOrder' => [
                                'stu_id' => SORT_DESC
                            ]
                        ]
                    ]);

                    return $this->renderAjax('branch-students-list', [
                                'dataProvider' => $dataProvider,
                                'pages' => $pages,
                                'model' => $model,
                    ]);
                }
            }
        }
    }

    /* Get Group */

    public function actionGetGroup() {
        $type = '';
        if (Yii::$app->request->post('class_id')) {
            $groups = Yii::$app->common->getGroup(Yii::$app->request->post('class_id'));
            if (count($groups) > 0) {
                $options = "<option selected='selected'>Select Group</option>";
                foreach ($groups as $group) {
                    $options .= "<option value='" . $group['id'] . "'>" . $group['name'] . "</option>";
                }
                $type = 'group';
            } else {
                $options = "<option selected='selected'>Select Section</option>";

                $type = 'section';
                $sections = Yii::$app->common->getSection(Yii::$app->request->post('class_id'), Null);
                foreach ($sections as $section) {
                    $options .= "<option value='" . $section['id'] . "'>" . $section['name'] . "</option>";
                }
            }
        }
        return Json_encode(['type' => $type, 'html' => $options]);
    }

    //end of group
    /* get section */
    public function actionGetSection() {

        $options = "<option selected='selected'>Select Section</option>";
        if (Yii::$app->request->post('class_id')) {
            $class_id = Yii::$app->request->post('class_id');
            $group_id = Yii::$app->request->post('group_id');
            $sections = Yii::$app->common->getSection($class_id, $group_id);
            foreach ($sections as $section) {
                $options .= "<option value='" . $section['id'] . "'>" . $section['name'] . "</option>";
            }
        }
        return $options;
    }

    //end of Section

    public function actionProfile() {
        if (Yii::$app->user->isGuest) {
            return $this->redirect(['site/login']);
        } else {
            $model = new StudentInfo();
            /*
             *   Process for non-ajax request
             */
            if (yii::$app->request->get('id')) {

                $student_id = yii::$app->request->get('id');
                $studentInfo = Yii::$app->common->getStudent($student_id);
                $total_time_line = [];
                if (Yii::$app->request->get('old_class')) {
                    
                } else {
                    /* student timeline  query */
                    $Stdtimeline = \app\models\StuRegLogAssociation::find()
                            ->select([
                                'rc.title class_name',
                                'rg.title group_name',
                                'rs.title section_name',
                                'stu_reg_log_association.current_class_id old_class',
                                'stu_reg_log_association.current_group_id old_group',
                                'stu_reg_log_association.current_section_id old_section',
                                'stu_reg_log_association.promoted_date',
                            ])
                            ->innerJoin('ref_class rc', 'rc.class_id=stu_reg_log_association.current_class_id')
                            ->leftJoin('ref_group rg', 'rg.group_id=stu_reg_log_association.current_group_id')
                            ->leftJoin('ref_section rs', 'rs.section_id=stu_reg_log_association.current_section_id')
                            ->where(['stu_reg_log_association.fk_stu_id' => $student_id])
                            // ->orderBy(['stu_reg_log_association.id'=>SORT_DESC])
                            ->asArray()
                            ->all();
                    $existing_class[] = [
                        'class_name' => $studentInfo->class->title,
                        'group_name' => ($studentInfo->group_id) ? $studentInfo->group->title : '',
                        'section_name' => $studentInfo->section->title,
                        'old_class' => $studentInfo->class_id,
                        'old_group' => ($studentInfo->group_id) ? $studentInfo->group_id : null,
                        'old_section' => $studentInfo->section_id,
                        'promoted_date' => date('Y-m-d'),
                    ];
                    if (count($Stdtimeline) > 0) {
                        $last_pointer = count($Stdtimeline) - 1;
                        $start_date = $Stdtimeline[$last_pointer]['promoted_date'];
                        $total_time_line = array_merge($Stdtimeline, $existing_class);
                    } else {
                        $start_date = date('Y-m-d', strtotime($studentInfo->registration_date));
                        $total_time_line = $existing_class;
                    }
                    /* get exams. */
                    $query = Exam::find()
                                    ->select(['exam.fk_exam_type id', 'et.type title'])
                                    ->innerJoin('exam_type et', 'et.id=exam.fk_exam_type')
                                    ->where([
                                        'exam.fk_branch_id' => Yii::$app->common->getBranch(),
                                        'exam.fk_class_id' => $studentInfo->class_id,
                                        'exam.fk_group_id' => ($studentInfo->group_id) ? $studentInfo->group_id : null,
                                        'exam.fk_section_id' => $studentInfo->section_id
                                    ])
                                    ->groupBy('fk_exam_type')
                                    ->asArray()->all();


                    $exam_array = \yii\helpers\ArrayHelper::map($query, 'id', 'title');

                    /* student Attendance */
                    $attendance_query = StudentAttendance::find()->select(['count(*) as total', 'leave_type'])
                                    ->where(['fk_stu_id' => $student_id])
                                    ->andWhere(['between', 'date', $start_date, date('Y-m-d H:i:s')])
                                    ->groupBy('leave_type')->asArray()->all();


                    /* FEE DATA COLLECTION */
                    $std_plan_type = $studentInfo->fk_fee_plan_type;
                    $class_id = $studentInfo->class_id;
                    $group_id = $studentInfo->group_id;
                    $section_id = $studentInfo->section_id;
                    $stop_id = $studentInfo->fk_stop_id;
                    $is_hostel_avail = $studentInfo->is_hostel_avail;
                    $sum_total = 0;
                    $total_payment_received = 0;
                    $total_payment_arrears = 0;

                    $transport_fare = 0;
                    $hostel_fare = 0;

                    $fee_plan_Model = FeePlanType::findOne($std_plan_type);
                    if (!empty($stop_id)) {
                        $stopModel = Stop::findOne($stop_id);
                        $transport_fare = $stopModel->fare;
                    }
                    if ($is_hostel_avail) {
                        $hostelDetail = HostelDetail::find()
                                        ->select('h.amount amount')
                                        ->innerJoin('hostel h', 'h.id=hostel_detail.fk_hostel_id')
                                        ->where(['hostel_detail.fk_branch_id' => Yii::$app->common->getBranch(), 'hostel_detail.fk_student_id' => $studentInfo->stu_id])->asArray()->one();
                        $hostel_fare = $hostelDetail['amount'];
                    }
                    $query_fee = FeeHeads::find()->select([
                                        'fpm.time_span as no_months',
                                        'fee_heads.id as head_id',
                                        'fee_heads.title',
                                        'fee_heads.promotion_head',
                                        'fee_heads.discount_head_status as discount_head_status',
                                        'fee_heads.one_time_only as one_time',
                                        'fee_heads.description',
                                        'fg.amount', 'fg.is_active',
                                        'rc.title as class',
                                        'rg.title as group'
                                    ])
                                    ->innerJoin('fee_payment_mode fpm', 'fpm.id=fee_heads.fk_fee_method_id')
                                    ->leftJoin('fee_group fg', 'fg.fk_fee_head_id=fee_heads.id')
                                    ->innerJoin('ref_class rc', 'rc.class_id=fg.fk_class_id')
                                    ->leftJoin('ref_group rg', 'rg.group_id=fg.fk_group_id')
                                    ->where(['fg.is_active' => 'yes', 'rc.class_id' => $class_id, 'rg.group_id' => ($group_id) ? $group_id : null])->asArray()->all();
                    foreach ($query_fee as $items) {
                        if ($items['no_months'] == 1) {
                            $amount = $items['amount'] * $items['no_months'];
                        } else {
                            $amount = $items['amount'] * $items['no_months'] / 12;
                        }
                        ///echo $amount."<br/>";
                        $sum_total = $sum_total + $amount;
                    }

                    $total_months_amount = $sum_total * 12;


                    /* fee paid  by student graph */
                    $payment_received = FeeHeadWise::find()
                                    ->select(['fk_chalan_id'])
                                    ->where(['fk_branch_id' => Yii::$app->common->getBranch(), 'fk_stu_id' => $student_id])
                                    ->andWhere(['between', 'date(created_date)', $start_date, date('Y-m-d')])->groupBy(['fk_chalan_id'])->all();
                    if (count($payment_received) > 0) {


                        foreach ($payment_received as $challan_id) {
                            $payment_received = FeeHeadWise::find()
                                    ->where(['fk_chalan_id' => $challan_id])
                                    ->sum('payment_received');
                            $total_payment_received = $total_payment_received + $payment_received;

                            /* fee remaing graph */
                            $payment_arrears = FeeChallanRecord::find()
                                    ->where(['challan_id' => $challan_id])
                                    ->sum('head_amount');
                            $total_payment_arrears = $total_payment_arrears + $payment_arrears;
                        }
                    }
                    if ($total_payment_arrears > 0) {
                        $arrears = $total_payment_arrears - $total_payment_received;
                    } else {
                        $arrears = 0;
                    }

                    $total_Year_amount = $total_months_amount - $total_payment_received;
                    $pi_array_fee = [
                        ['name' => "Total Amount", 'data' => $total_Year_amount],
                        ['name' => "Total Received", 'data' => $total_payment_received],
                        ['name' => "Total Arrears", 'data' => $arrears]
                    ];

                    return $this->render('profile', [
                                'model' => $model,
                                'studentInfo' => $studentInfo,
                                'fee_query' => $query_fee,
                                'fee_plan_Model' => $fee_plan_Model,
                                'transport_fare' => $transport_fare,
                                'hostel_fare' => $hostel_fare,
                                'attendance_array' => $attendance_query,
                                'total_time_line' => $total_time_line,
                                'start_date' => $start_date,
                                'end_date' => date('Y-m-d'),
                                'pi_array_fee' => $pi_array_fee,
                                'exam_array' => $exam_array
                    ]);
                }
            }
        }
    }

    /* student profile exam */

    public function actionProfileExam() {
        if (Yii::$app->user->isGuest) {
            return $this->redirect('site/login');
        } else {
            if (Yii::$app->request->post()) {
                $data = yii::$app->request->post();
                $examId = $data['examId'];
                $class = $data['classid'];
                $sectionid = $data['sectionid'];
                $stdid = $data['stdid'];
                $examdivid = $data['examdivid'];


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
                                ->innerJoin('exam_type et', 'et.id=exam.fk_exam_type')
                                ->innerJoin('ref_class c', 'c.class_id=exam.fk_class_id')
                                ->innerJoin('subjects sb', 'sb.id=exam.fk_subject_id')
                                ->leftJoin('student_marks sm', 'sm.fk_exam_id=exam.id')
                                ->leftJoin('student_info st', ' st.stu_id=sm.fk_student_id')
                                ->leftJoin('ref_group g', 'g.group_id=exam.fk_group_id')
                                ->leftJoin('ref_section s', 's.class_id=exam.fk_class_id')
                                ->innerJoin('user u', 'u.id=st.user_id')
                                ->where(['exam.fk_branch_id' => Yii::$app->common->getBranch(), 'c.class_id' => $class, 'g.group_id' => ($data['groupid']) ? $data['groupid'] : null, 's.section_id' => $sectionid, 'st.stu_id' => $stdid, 'et.id' => $examId])
                                ->groupBy(['st.stu_id', 'c.class_id', 'c.title', 'g.group_id', 'g.title', 's.section_id', 's.title', 'sb.title'])->asArray()->all();

                $pichart_arr = [];
                foreach ($subjects_data as $kay => $sub_data) {
                    $pichart_arr[] = [$sub_data['subject'], $sub_data['marks_obtained']];
                }

                $html = $this->renderAjax('profile-exam', [
                    'subjects_data' => $subjects_data
                ]);

                return json_encode(['status' => 1, 'details' => $html, 'examdivid' => $examdivid, 'piExamArr' => $pichart_arr], JSON_NUMERIC_CHECK);
            }
        }
    }

    /* save promoted studen */

    public function actionSavePromotedStudent() {
        if (Yii::$app->user->isGuest) {
            return $this->redirect(['site/login']);
        } else {
            if (Yii::$app->request->isAjax) {
                $data = Yii::$app->request->post();
                $c_cid = $data['c_cid'];
                $c_gid = $data['c_gid'];
                $c_sid = $data['c_sid'];
                $selected_students = $data['selected_students'];
                $new_cid = $data['new_cid'];
                $new_gid = $data['new_gid'];
                $new_sid = $data['new_sid'];

                /* promote individual studen loop */
                foreach ($selected_students as $key => $student_id) {
                    $StdRegLogAssoc = new StuRegLogAssociation();
                    $studentInfoModel = StudentInfo::findOne($student_id);
                    $studentInfoModel->class_id = $new_cid;
                    $studentInfoModel->group_id = ($new_gid) ? $new_gid : null;
                    $studentInfoModel->section_id = $new_sid;
                    $studentInfoModel->save(false);

                    $FeeStructure = \app\models\FeeGroup::find()->where(['fk_branch_id' => Yii::$app->common->getBranch(), 'fk_class_id' => $studentInfoModel->class_id, 'fk_group_id' => ($studentInfoModel->group_id) ? $studentInfoModel->group_id : null])->all();

                    if (count($FeeStructure) > 0) {
                        foreach ($FeeStructure as $head_item) {
                            $feeParticularModel = new FeeParticulars();
                            $feeParticularModel->fk_fee_head_id = $head_item->fk_fee_head_id;
                            $feeParticularModel->fk_fee_plan_type = $studentInfoModel->fk_fee_plan_type;
                            $feeParticularModel->is_paid = 0;
                            $feeParticularModel->fk_stu_id = $studentInfoModel->stu_id;
                            if (!$feeParticularModel->save()) {
                                echo "<pre>";
                                print_r($feeParticularModel->getErrors());
                                exit;
                            }
                        }
                    }

                    /* new entery to std reg log */
                    $StdRegLogAssoc->fk_stu_id = $student_id;
                    $StdRegLogAssoc->fk_class_id = $new_cid;
                    $StdRegLogAssoc->fk_group_id = ($new_gid) ? $new_gid : null;
                    $StdRegLogAssoc->fk_section_id = $new_sid;
                    $StdRegLogAssoc->fk_stu_id = $student_id;
                    $StdRegLogAssoc->current_class_id = $c_cid;
                    $StdRegLogAssoc->current_group_id = ($c_gid) ? $c_gid : null;
                    $StdRegLogAssoc->current_section_id = $c_sid;
                    if (!$StdRegLogAssoc->save()) {
                        echo "<pre>";
                        print_r($StdRegLogAssoc->getErrors());
                        exit;
                    }
                }
                Yii::$app->session->setFlash('success', 'Students Promoted Successfully');
                return json_encode(['status' => 1, 'returnUrl' => \yii\helpers\Url::to(['student/promote-students'], true)]);
            }
        }
    }

    /* get profile stats */

    public function actionGetProfileStats() {
        if (Yii::$app->user->isGuest) {
            return $this->redirect(['site/login']);
        } else {
            if (Yii::$app->request->isAjax) {
                $data = Yii::$app->request->post();
                if ($data) {
                    /* student Attendance */
                    $attendance_query = StudentAttendance::find()->select(['count(*) as total', 'leave_type'])
                            ->where(['fk_stu_id' => $data['student_id']])
                            ->andWhere(['between', 'date(date)', $data['start_date'], $data['end_date']])
                            ->groupBy('leave_type')
                            ->asArray()
                            ->all();

                    /* student attedance array */
                    $attenance_data = [];
                    foreach ($attendance_query as $key => $attendance_details) {
                        $attenance_data['leave_type'][] = $attendance_details['leave_type'];
                        $attenance_data['total'][] = $attendance_details['total'];
                    }
                    $array = $attenance_data;
                    return json_encode([
                        'attenance_data' => $array,
                        'start_date' => $data['start_date'],
                        'end_date' => $data['end_date']
                    ]);
                }
            }
        }
    }

    /* check bed assigned */

    public function actionCheckBedAssigned() {
        if (Yii::$app->request->post()) {
            $bed_id = Yii::$app->request->post('bed_id');
            $hostelAvailCount = HostelDetail::find()->where(['fk_branch_id' => Yii::$app->common->getBranch(), 'fk_bed_id' => $bed_id])->count();
            if ($hostelAvailCount > 0) {
                return json_encode(['status' => 1]);
            } else {
                return json_encode(['status' => 0]);
            }
        }
    }

    /*
      reports student
     */
    /* get exam type options */

    public function actionGetExamOptions() {
        if (Yii::$app->request->isAjax) {
            $data = Yii::$app->request->post();
            $student_detail = Yii::$app->common->getStudent($data['student_id']);
            $class = $student_detail->class_id;
            $group = $student_detail->group_id;
            $section_id = $student_detail->section_id;

            $exams = Exam::find()
                            ->select(['et.id', 'et.type'])
                            ->innerJoin('exam_type et', 'et.id=exam.fk_exam_type')
                            ->where(['fk_class_id' => $class, 'fk_group_id' => ($group) ? $group : null, 'fk_section_id' => $section_id])
                            ->asArray()->all();
            $options = "<option value=''>Select Exam..</option>";
            foreach ($exams as $examtype) {
                $options .= "<option value =" . $examtype['id'] . ">" . $examtype['type'] . "</option>";
            }

            return json_encode(['status' => 1, 'options' => $options, 'counter' => count($exams)]);
        }
    }

    ///////////////// bed condition

    public function actionCheckBed() {
        $bed = yii::$app->request->post('bedid');
        $room = yii::$app->request->post('roomid');
        $checkbed = HostelDetail::find()->where(['fk_room_id' => $room, 'fk_bed_id' => $bed])->one();
        //echo count($checkbed);
        if ($checkbed) {
            return json_encode(['assign' => 'This bed is already assign']);
        } else {
            return json_encode(['assign' => '']);
        }
    }

    //////////////// end of bed condition
    //student parent profile.
    public function actionParentProfile() {
        return $this->render('parent-profile');
    }

    public function actionShowInactiveStudent() {

        if (Yii::$app->user->isGuest) {
            return $this->goHome();
        } else {


            $query1 = StudentInfo::find()->where(['is_active' => 1])->where(['is_active' => 0])->all();
            $provider = new ActiveDataProvider([
                'query' => $query1,
            ]);
            return $this->render('show-inactive-student', [

                        'dataProvider' => $query1,
            ]);
        }
    }

    public function actionInactiveStudent() {
        //$searchModel = new StudentInfoSearch(); 
        //$searchModel->fk_branch_id = Yii::$app->common->getBranch();
        // $searchModel->is_active=0;

        $query1 = StudentInfo::find()->where(['fk_branch_id' => yii::$app->common->getBranch(), 'is_active' => 0, 'school_leave' => 0]);





        /* $query1 = StudentInfo::find()
          ->select(['student_info.*','student_leave_info.stu_id'])
          ->innerJoin('student_leave_info','student_leave_info.stu_id !=student_info.stu_id')
          ->where(['student_info.is_active'=>0,'student_info.fk_branch_id'=>yii::$app->common->getBranch()])->all();
         */


        // echo $getstu;die;

        $dataprovider = new ActiveDataProvider([
            'query' => $query1,
            'pagination' => [
                'pageSize' => 500,
            ],
        ]);



        //$dataProvider = $searchModel->search(Yii::$app->request->queryParams); 


        return $this->render('inactive', [
                    //'searchModel' => $searchModel, 
                    'dataProvider' => $dataprovider,
        ]);
    }

    public function actionActiveStatus($id) {
        // echo $id;die;
        $model = StudentInfo::findOne($id);
        $model->is_active = '1';
        if ($model->save(false)) {
            $user = User::findOne($id);
            $user->status = 'active';
            $user->save(false);
        }
        if (!Yii::$app->request->isAjax) {
            return $this->redirect(['inactive-student']);
        }
    }

    public function actionShuffleStudents() {
        if (Yii::$app->user->isGuest) {
            return $this->redirect(['site/login']);
        } else {
            $model = new StudentInfo();
            /*
             *   Process for non-ajax request
             */
            return $this->render('shuffle-students', [
                        'model' => $model,
            ]);
        }
    }

    /* branch student list for promotion */

    public function actionBranchStudentListShuffle() {
        if (Yii::$app->user->isGuest) {
            return $this->redirect(['site/login']);
        } else {
            if (Yii::$app->request->isAjax) {
                $model = new StudentInfo();
                $data = Yii::$app->request->post();
                if (Yii::$app->request->post()) {
                    if ($data['section_id']) {
                        $class_id = $data['class_id'];
                        $group_id = $data['group_id'];
                        $section_id = $data['section_id'];
                        /* query */
                        $section = RefSection::find()->where(['fk_branch_id' => yii::$app->common->getBranch(), 'class_id' => $class_id, 'status' => 'active'])->all();

                        $query = StudentInfo::find()->where([
                            'fk_branch_id' => Yii::$app->common->getBranch(),
                            'class_id' => $class_id,
                            'group_id' => ($group_id) ? $group_id : null,
                            'section_id' => $section_id,
                            'is_active' => 1
                        ]);
                        $searchModel = new \app\models\search\StudentInfoSearch();

                        //$searchModel->patient_id = $post_data['pat_id'];
                        //$dataProvider = $searchModel->search(Yii::$app->request->queryParams);
                        $dataProvider = new ActiveDataProvider([
                            'query' => $query,
                            'sort' => [
                                'defaultOrder' => [
                                    'stu_id' => SORT_DESC
                                ]
                            ],
                            'pagination' => [
                                'pageSize' => 100,
                                'params' => [
                                    'class_id' => $class_id,
                                    'group_id' => ($group_id) ? $group_id : null,
                                    'section_id' => $section_id,
                                ],
                            ]
                        ]);
                        // print_r(Yii::$app->request->queryParams);die;

                        $details = $this->renderAjax('branch-students-list-shuffle', [
                            'searchModel' => $searchModel,
                            'dataProvider' => $dataProvider,
                            'model' => $model,
                            'section' => $section,
                        ]);

                        return json_encode(['status' => 1, 'details' => $details]);
                    } else {
                        return json_encode(['status' => 1, 'details' => '<div class="alert alert-warning"><strong>Note!</strong>Record Not Found.</div>']);
                    }
                } else {
                    /* geting data on pagination. */
                    $post_data = Yii::$app->request->get();
                    $class_id = $post_data['class_id'];
                    $group_id = $post_data['group_id'];
                    $section_id = $post_data['section_id'];
                    /* query */
                    $query = StudentInfo::find()->where([
                        'fk_branch_id' => Yii::$app->common->getBranch(),
                        'class_id' => $class_id,
                        'group_id' => ($group_id) ? $group_id : null,
                        'section_id' => $section_id,
                    ]);
                    $countQuery = clone $query;

                    $pages = new \yii\data\Pagination(['totalCount' => $countQuery->count()]);
                    $dataProvider = new ActiveDataProvider([
                        'query' => $query,
                        'sort' => [
                            'defaultOrder' => [
                                'stu_id' => SORT_DESC
                            ]
                        ]
                    ]);

                    return $this->renderAjax('branch-students-list-shuffle', [
                                'dataProvider' => $dataProvider,
                                'pages' => $pages,
                                'model' => $model,
                                'section' => $section,
                    ]);
                }
            }
        }
    }

    /* save shuffle studen */

    public function actionSaveShuffleStudent() {

        if (Yii::$app->user->isGuest) {
            return $this->redirect(['site/login']);
        } else {
            if (Yii::$app->request->isAjax) {
                $data = Yii::$app->request->post();
                $c_cid = $data['c_cid'];
                $c_gid = $data['c_gid'];
                //$c_sid   =   $data['c_sid'];
                $selected_students = $data['selected_students'];
                //$new_cid = $data['new_cid'];
                //$new_gid = $data['new_gid'];
                $new_sid = $data['new_sid'];

                /* promote individual studen loop */
                foreach ($selected_students as $key => $student_id) {
                    $StdRegLogAssoc = new StuRegLogAssociation();
                    $studentInfoModel = StudentInfo::findOne($student_id);
                    //$studentInfoModel->class_id = $new_cid;
                    //$studentInfoModel->group_id = ($new_gid)?$new_gid:null;
                    $studentInfoModel->section_id = $new_sid;
                    $studentInfoModel->save(false);

                    /* $FeeStructure = \app\models\FeeGroup::find()->where(['fk_branch_id'=>Yii::$app->common->getBranch(),'fk_class_id'=>$studentInfoModel->class_id,'fk_group_id'=>($studentInfoModel->group_id)?$studentInfoModel->group_id:null])->all();

                      if(count($FeeStructure)>0){
                      foreach($FeeStructure as $head_item){
                      $feeParticularModel = new FeeParticulars();
                      $feeParticularModel->fk_fee_head_id     = $head_item->fk_fee_head_id;
                      $feeParticularModel->fk_fee_plan_type   = $studentInfoModel->fk_fee_plan_type;
                      $feeParticularModel->is_paid            = 0;
                      $feeParticularModel->fk_stu_id          = $studentInfoModel->stu_id;
                      if(!$feeParticularModel->save()){
                      echo "<pre>";
                      print_r($feeParticularModel->getErrors());
                      exit;
                      }
                      }
                      } */

                    /* new entery to std reg log */
                    /* $StdRegLogAssoc->fk_stu_id      =   $student_id;
                      $StdRegLogAssoc->fk_class_id    =  $new_cid;
                      $StdRegLogAssoc->fk_group_id    =  ($new_gid)?$new_gid:null;
                      $StdRegLogAssoc->fk_section_id  =   $new_sid;
                      $StdRegLogAssoc->fk_stu_id      =   $student_id;
                      $StdRegLogAssoc->current_class_id   = $c_cid;
                      $StdRegLogAssoc->current_group_id   = ($c_gid)?$c_gid:null;
                      $StdRegLogAssoc->current_section_id = $c_sid;
                      if(!$StdRegLogAssoc->save()){
                      echo "<pre>";
                      print_r($StdRegLogAssoc->getErrors());
                      exit;
                      } */
                }
                Yii::$app->session->setFlash('success', 'Students Shuffle Successfully');
                return json_encode(['status' => 1, 'returnUrl' => \yii\helpers\Url::to(['student/shuffle-students'], true)]);
            }
        }
    }
    
    // Import Strudents Data From Excel
    public function actionImportStudents()
    {
        $model = new UploadExcelForm();
        if (Yii::$app->request->isPost) {
            $model->file = UploadedFile::getInstance($model,'file');
            //      if ($model->upload()) {
            //        print <<<EOT
            //< script > alert ('upload succeeded ') < / script >
            //EOT;
            //      } else {
            //        print <<<EOT
            //< script > alert ('upload failed ') < / script >
            //EOT;
            //}
            if (!$model->upload()) {
                print "< script > alert ('upload failed ') < / script >";
            }   
        }

        $ok = 0;
        // print_r($model->load(Yii::$app->request->post()));exit;
        if ($model->load(Yii::$app->request->post())) {
            $file = UploadedFile::getInstance($model,'file');

            if ($file) {
                $tmp_file = date('YmdHis') . '.' . $file->extension; // $file->name;
                $path = 'uploads/excel/';
                $filename = $path . $tmp_file;
                $file->saveAs($filename);

                if (in_array($file->extension,array('xls','xlsx'))) {
                    $fileType = PHPExcel_IOFactory::identify($filename); // the filenamee automatically determines the type
                    $ExcelReader = PHPExcel_IOFactory::createReader($fileType);

                    $phpexcel = $ExcelReader->Load($filename)->getsheet(0); // load the file and get the first sheet
                    $total_line = $phpexcel->gethighestrow(); // total number of rows
                    $total_column = $phpexcel->gethighestcolumn(); // total number of columns

                    
                    if (1 < $total_line) {
                        for ($row = 2;$row <= $total_line;$row++) {
                            $data = [];

                            for ($column = 'A';$column <= $total_column;$column++) {
                                $arr = trim($phpexcel->getCell($column.$row));
                                array_push($data, $arr);
                            }
                            //INSERT user
                            //user table fields: (first_name, last_name, middle_name, username, password, status, fk_role_id);
                            //user table data: (data[1], data[2], '', data[0], @moment2016, active, 3);
                            $password='@moment2016';
                            $password_hash = Yii::$app->security->generatePasswordHash($password);
                            $val= array( $data[1],$data[2], '', '', $password_hash, 'active', 3, 1,date('Y-m-d H:i:s'),4);
                            $set = array('username','first_name', 'middle_name','last_name',  'password_hash', 'status', 'fk_role_id', 'gender_type''created_at','fk_branch_id');
                            $where = array();
                            foreach ($set as $i => $key) {
                                $where[$key] = $val[$i];
                            }

                            $info = Yii::$app->db->createCommand()->insert('user', $where)->execute();
                            $user_id = Yii::$app->db->getLastInsertID();

                            // INSERT student_info
                            $set = array('user_id', 'fk_branch_id', 'dob', 'shift_id', 'religion_id', 'class_id', 'section_id', 'location1', 'is_active', 'registration_date');
                            $reg_date = strtotime($data[10]);
                            $dob = strtotime($data[9]);
                            $val = array($user_id, 4, date('Y-m-d H:i:s', $dob), 3, 1, $data[6],  $data[7], $data[12], 1, date('Y-m-d H:i:s', $reg_date));
                            $where = array();
                            foreach ($set as $i => $key) {
                                $where[$key] = $val[$i];
                            }

                            $info = Yii::$app->db->createCommand()->insert('student_info', $where)->execute();
                            $std_id = Yii::$app->db->getLastInsertID();

                            // INSERT student_parents_info
                            $set = array('first_name', 'cnic', 'profession', 'contact_no', 'stu_id');
                            $val = array($data[3], $data[4], 1, $data[10], $std_id);
                            $where = array();
                            foreach ($set as $i => $key) {
                                $where[$key] = $val[$i];
                            }

                            $info = Yii::$app->db->createCommand()->insert('student_parents_info', $where)->execute();
                            $std_paid = Yii::$app->db->getLastInsertID();

                            if ($info) {
                                $ok = 1;
                            }
                        }
                    }
                                    
                    if(file_exists($filename))
                        unlink($filename);

                    if ($ok == 1) {
                        return $this->redirect('import-students');
                    } else {
                        Echo "< script > alert ('operation failed '); window.history.back ();</script>";
                    }
                }
            }
        } else {
            return $this->render('import-students',['model' => $model]);
        }
    }
}
// end of main class
