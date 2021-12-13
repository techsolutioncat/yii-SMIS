<?php

namespace app\controllers;

use app\models\FeeChallanRecord;
use app\models\FeeDiscounts;
use app\models\HostelDetail;
use app\models\StuRegLogAssociation;
use app\models\SundryAccount;
use yii\data\ActiveDataProvider;
use app\models\FeeCollectionParticular;
use app\models\FeeGroup;
use app\models\FeePlanType;
use app\models\FeeHeads;
use app\models\Stop;
use app\models\FeeHeadWise;
use app\models\FeeParticulars;
use app\models\FeePaymentMode;
use app\models\search\FeeTransactionDetails;
use app\models\StudentInfo;
use app\models\User;
use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use mPDF;

/**
 * SundryAccountController implements the CRUD actions for Exam model.
 */
class UpdateAccountController extends Controller
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

    /**
     * Lists all Exam models.
     * @return mixed
     */
    public function actionIndex()
    {
    	 $model = new StudentInfo();

            /*
            *   Process for non-ajax request
            */
        return $this->render('index', [
            'model'=>$model,
        ]);
    }

    /*generate Sundary student list*/

    public function actionGenerateChallanStdListClass(){
        if (Yii::$app->user->isGuest) {
            $this->redirect(['site/login']);
        }
        else {
            if(Yii::$app->request->isAjax){
                $data  =  Yii::$app->request->post();
                if(Yii::$app->request->post()){
                    if($data['section_id']){
                        $class_id = $data['class_id'];
                        $group_id = $data['group_id'];
                        $section_id = $data['section_id'];
                        /*query*/
                        $model = new \app\models\StudentInfo;
                        /*query*/
                        if($data['section_id'] != 'Loading ...' && $data['section_id'] >0){
                            $where = [
                                'fk_branch_id'  => Yii::$app->common->getBranch(),
                                'class_id'      => $class_id,
                                'group_id'      => ($group_id)?$group_id:null,
                                'section_id'    => ($section_id != 'Loading ...' || $section_id != null)?$section_id:null ,
                                /*'is_active'     => 1*/
                            ];
                        }else{
                            $where = [
                                'fk_branch_id'  => Yii::$app->common->getBranch(),
                                'class_id'      => $class_id,

                            ];
                        }

                        $query = StudentInfo::find()
                            ->where($where)->all();

                        // print_r(Yii::$app->request->queryParams);die;

                        $details = $this->renderAjax('getStudents', [
                            'model' => $model,
                            'query' => $query,
                        ]);

                        return json_encode(['status'=>1 ,'details'=>$details]);
                    }
                    else{
                        return json_encode(['status'=>1,'details'=>'<div class="alert alert-warning">
  <strong>Note!</strong>Record Not Found.</div>']);
                    }
                }
                else{
                    /*geting data on pagination.*/
                    $post_data  = Yii::$app->request->get();
                    $class_id   = $post_data['class_id'];
                    $group_id   = (isset($post_data['group_id']))?$post_data['group_id']:null;
                    $section_id = $post_data['section_id'];
                    /*query*/
                    $query = StudentInfo::find()->where([
                        'fk_branch_id'  => Yii::$app->common->getBranch(),
                        'class_id'      => $class_id,
                        'group_id'      => $group_id,
                        'section_id'    => $section_id,
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

                    return $this->renderAjax('getStudents',
                        [
                            'dataProvider' => $dataProvider,
                            'pages' => $pages,
                        ]);
                }
            }
            else{
                $data  =  Yii::$app->request->post();
                $student_account = $data['StudentInfo']['acc_no'];
                if(count($student_account)>0){
                    foreach($student_account as $std_id=>$account_no){
                        $student  =  Yii::$app->common->getStudent($std_id);
                        $student->acc_no = $account_no;
                            $student->save(false);
                    }
                    Yii::$app->session->setFlash('success', 'Student Account Updated Successfully');
                    return $this->redirect('index');
                }
            }
        }
    }

    public function actionGenerateChallanStdList(){
        if (Yii::$app->user->isGuest) {
            $this->redirect(['site/login']);
        }
        else {
            if(Yii::$app->request->isAjax){
                $data  =  Yii::$app->request->post();
                if(Yii::$app->request->post()){
                    if($data['section_id']){
                        $class_id = $data['class_id'];
                        $group_id = $data['group_id'];
                        $section_id = $data['section_id'];
                        $model = new \app\models\StudentInfo();
                        /*query*/
                        $query = StudentInfo::find()->where([
                            'fk_branch_id'  => Yii::$app->common->getBranch(),
                            'class_id'      => $class_id,
                            'group_id'      => ($group_id)?$group_id:null,
                            'section_id'    => $section_id,
                            /*'is_active'     => 1*/
                        ])->all();

                        $details =  $this->renderAjax('getStudents', [
                            'model' => $model,
                            'query' => $query,
                        ]);

                        return json_encode(['status'=>1 ,'details'=>$details]);
                    }
                    else{
                        return json_encode(['status'=>1,'details'=>'<div class="alert alert-warning">
  <strong>Note!</strong>Record Not Found.</div>']);
                    }
                }
                else{
                    /*geting data on pagination.*/
                    $post_data  = Yii::$app->request->get();
                    $class_id   = $post_data['class_id'];
                    $group_id   = (isset($post_data['group_id']))?$post_data['group_id']:null;
                    $section_id = $post_data['section_id'];
                    $model = new \app\models\StudentInfo;
                    /*query*/
                    $query = StudentInfo::find()->where([
                        'fk_branch_id'  => Yii::$app->common->getBranch(),
                        'class_id'      => $class_id,
                        'group_id'      => ($group_id)?$group_id:null,
                        'section_id'    => $section_id,
                        /*'is_active'     => 1*/
                    ])->all();



                    return $this->renderAjax('getStudents', [
                        'model' => $model,
                        'query' => $query,
                    ]);
                }
            }
        }
    }

    /*add-advance-amount*/
    public function actionAddAdvanceAmount(){
        if (Yii::$app->user->isGuest) {
            return $this->redirect(['site/login']);
        }
        if(Yii::$app->request->isAjax){

            $stu_id = Yii::$app->request->post('stu_id');
            $student_info = Yii::$app->common->getStudent($stu_id);
            $activeHeads =  FeeHeads::find()
                ->select(['fee_heads.title','fee_heads.id'])
                ->innerJoin('fee_group fg','fg.fk_fee_head_id=fee_heads.id')
                ->innerJoin('fee_payment_mode fpm','fpm.id=fee_heads.fk_fee_method_id')
                ->innerJoin('ref_class rc','rc.class_id=fg.fk_class_id')
                ->where(['fee_heads.fk_branch_id'=>Yii::$app->common->getBranch(),'fg.is_active'=>'yes' ,'rc.class_id'=>$student_info->class_id,'fpm.time_span'=>'12'])->asArray()->all();

            //echo "<pre>";print_r($activeHeads);exit;
            $model = SundryAccount::find()->where(['fk_branch_id'=>Yii::$app->common->getBranch(),'stu_id'=>$stu_id,'status'=>1])->One();
            if(count($model)==0){
                $model= new SundryAccount();
            }

            $html = $this->renderAjax('_form', [
                    'model' => $model,
                    'stu_id' => $stu_id,
                    'active_heads'=>$activeHeads
                ]);
            return json_encode(['status'=>1 ,'html'=>$html]);
        }else{
            $data = Yii::$app->request->post('SundryAccount');
            foreach($data['total_advance_bal'] as $head_id =>$total_adv_amount){
                if($data['record_status']==1){
                    $model = new SundryAccount();
                }else{
                    $model = SundryAccount::find()->where(['fk_branch_id'=>Yii::$app->common->getBranch(),'stu_id'=>$data['student_id'],'status'=>1,'fk_head_id'=>$head_id])->One();
                }
                $old_amount = $model->total_advance_bal;
                $old_transport = $model->transport_fare;
		$old_hostel = $model->hostel_fare;
                if(!empty($old_amount)){
                    $model->total_advance_bal  = $old_amount + $total_adv_amount;
                }else{
                    $model->total_advance_bal = $total_adv_amount;
                }
                if($data['transport_fare']>0){
                    if(!empty($old_transport) && $old_transport > 0){
                        $model->transport_fare = $old_transport + $data['transport_fare'];
                    }else{
                        $model->transport_fare = $data['transport_fare'];
                    }
                }
		if($data['hostel_fare']>0){
                    if(!empty($old_hostel) && $old_hostel > 0){
                        $model->hostel_fare = $old_hostel + $data['hostel_fare'];
                    }else{
                        $model->hostel_fare = $data['hostel_fare'];
                    }
                }
                $model->fk_chalan_id =null;
                $model->fk_head_id =$head_id;
                $model->receipt_no =  $data['receipt_no'];
                $model->fee_submission_date =  $data['fee_submission_date'];
                $model->stu_id =$data['student_id'];
                $model->fk_branch_id = Yii::$app->common->getBranch();
                $model->status = 1;
                if(!$model->save()){
                    echo "<pre>";print_r($model->getErrors());exit;

                }
            }
            Yii::$app->session->setFlash('success', 'Advance Amount Added Successfully');
            return $this->redirect('index');
        }
    }

}
