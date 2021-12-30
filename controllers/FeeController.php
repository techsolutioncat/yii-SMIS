<?php

namespace app\controllers;
ini_set('max_execution_time', 300);
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
use app\models\SmsLog;
use app\models\StudentParentsInfo;
use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use mPDF;
use yii\helpers\ArrayHelper;

/**
 * ExamsController implements the CRUD actions for Exam model.
 */
class FeeController extends Controller
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
        return $this->render('index', [
            'message'=>'Fee Generator',
        ]);
    }

    
    /*fee challan details*/
    public function actionGetFeeDetails(){
        if(Yii::$app->user->isGuest){
            $this->redirect(['site/login']);
        }else{
            if(Yii::$app->request->isAjax){
                if(Yii::$app->request->post()){
                    $data = Yii::$app->request->post();
                    $username = User::find()
                        ->innerjoin('student_info si','si.user_id=user.id')
                        ->innerjoin('fee_transaction_details ftd','ftd.stud_id=si.stu_id')
                        ->where([
                            'user.fk_branch_id'=>Yii::$app->common->getBranch(),
                            'user.first_name'=>$data['search_string'],
                            'ftd.status'=> 1
                        ])/*->andWhere(['like','first_name',$data['search_string']])*/;

                        $challan_no = FeeTransactionDetails::find()
                            ->innerjoin('student_info si','si.stu_id = fee_transaction_details.stud_id')
                            ->innerjoin('user u','u.id = si.user_id')
                            ->where(['fee_transaction_details.fk_branch_id'=>Yii::$app->common->getBranch()])->andWhere(['like','fee_transaction_details.challan_no',$data['search_string'], 'ftd.status'=> 1]);
		                $student_account = StudentInfo::find()->where(['fk_branch_id'=>Yii::$app->common->getBranch(),'acc_no'=>$data['search_string']])->one();

                        if($username->count() > 0){
                            $query = User::find()
                                ->select(['si.stu_id','CONCAT(user.first_name," ",user.last_name) as  name','ftd.challan_no as challan_no','ftd.id as challan_id'])
                                ->innerjoin('student_info si','si.user_id=user.id')
                                ->innerjoin('fee_transaction_details ftd','ftd.stud_id=si.stu_id')
                                ->where(['user.fk_branch_id'=>Yii::$app->common->getBranch(),'user.first_name'=>$data['search_string'], 'ftd.status'=> 1])/*->andWhere(['like','first_name',$data['search_string']])*/;
                            $html = $this->renderAjax('get-fee-details',['query'=>$query->asArray()->all()]);
                            return json_encode(['status'=>1,'details'=>$html]);
                        }else if($challan_no->count() > 0){
                            $query = FeeTransactionDetails::find()
                                ->select(['si.stu_id','CONCAT(u.first_name," ",u.last_name) as  name','fee_transaction_details.challan_no as challan_no','fee_transaction_details.id as challan_id'])
                                ->innerjoin('student_info si','si.stu_id = fee_transaction_details.stud_id')
                                ->innerjoin('user u','u.id = si.user_id')
                                ->where([
                                        'fee_transaction_details.fk_branch_id'=>Yii::$app->common->getBranch(),
                                        'fee_transaction_details.status'=> 1
                                ])
                                ->andWhere([
                                        'like','fee_transaction_details.challan_no', $data['search_string']
                                ])->orderBy(['fee_transaction_details.id'=> SORT_DESC]);
                            $html = $this->renderAjax('get-fee-details',['query'=>$query->asArray()->all()]);
                            return json_encode(['status'=>1,'details'=>$html]);

                        }else if(count($student_account)>0) {
                            $query = User::find()
                                ->select(['si.stu_id','CONCAT(user.first_name," ",user.last_name) as  name','ftd.challan_no as challan_no','ftd.id as challan_id'])
                                ->innerjoin('student_info si','si.user_id=user.id')
                                ->innerjoin('fee_transaction_details ftd','ftd.stud_id=si.stu_id')
                                ->where(['si.fk_branch_id'=>Yii::$app->common->getBranch(),'si.stu_id'=>$student_account->stu_id, 'ftd.status'=> 1])/*->andWhere(['like','first_name',$data['search_string']])*/;
                            $html = $this->renderAjax('get-fee-details',['query'=>$query->asArray()->all()]);
                            return json_encode(['status'=>1,'details'=>$html]);
                        }else{
                            return json_encode(['status'=>0,'error'=>'<div class="alert alert-warning"><strong>Note!</strong>Challan not found.</div>']);
                        }
                }
            }
            else{
                /*form post submit.*/
            }
        }
    }


    /*get challan details.*/
    public function actionChallanDetailsForm()
    {
        if (Yii::$app->user->isGuest) {
            $this->redirect(['site/login']);
        }
        else {
            if (Yii::$app->request->isAjax) {
                if (Yii::$app->request->post()) {
                    $data = Yii::$app->request->post();
                    $challan_Id = $data['challan_id'];
                    $stu_Id     = $data['std_id'];
                    $transport_fare = 0;
                    $hostel_fare=0;
                    $feeTranscModel  = FeeTransactionDetails::find()->where(['fk_branch_id'=>Yii::$app->common->getBranch(),'id'=>$challan_Id])->one();
                    $sundry_account  = SundryAccount::find()->where(['fk_branch_id'=>Yii::$app->common->getBranch(),'stu_id'=>$stu_Id,'status'=>1])->one();

                    $query_std_plan = User::find()
                        ->select(['CONCAT(user.first_name," ",user.last_name) as name','fp.no_of_installments as no_of_installments','fp.title as plan_type','fp.id as plan_id','si.class_id'])
                        ->innerJoin('student_info si','si.user_id = user.id')
                        ->innerJoin('fee_plan_type fp','fp.id = si.fk_fee_plan_type')
                        ->where(['user.fk_branch_id'=>Yii::$app->common->getBranch(),'si.stu_id'=>$stu_Id])->asArray()->one();


                    $active_fee_challan_record = \app\models\FeeChallanRecord::find()->select(['challan_id','fare_amount','hostel_fare'])->where(
                        [
                            'fk_stu_id'=>$stu_Id,
                            'fk_fee_plan_id'=>$query_std_plan['plan_id'],
                            'status'=>1
                        ])->one();
		            /*transport fee paid or not if availble.*/
                    $transport_hostel_received = \app\models\FeeHeadWise::find()
                        ->select(['transport_fare','hostel_fee'])
                        ->where([
                            'fk_branch_id'              => Yii::$app->common->getBranch(),
                            'fk_chalan_id'              => $challan_Id,
                            'fk_stu_id'                 => $stu_Id,
                        ])->asArray()->one();

                    $transport_fare = $active_fee_challan_record->fare_amount -$transport_hostel_received['transport_fare'];
                    $hostel_fare = $active_fee_challan_record->hostel_fare-$transport_hostel_received['hostel_fee'];

                    /*query here*/
                    $std_discount = \app\models\FeeDiscounts::find()->where(['fk_stud_id'=>$stu_Id,'is_active'=>1])->count();

                    if($std_discount >0){
                        $where = [
                            'ftd.fk_branch_id' => Yii::$app->common->getBranch(),
                            'fg.fk_class_id'=>$query_std_plan['class_id'],
                            'ftd.stud_id' =>$stu_Id ,'ftd.id' => $challan_Id,
                            //'fd.is_active' =>1,
                            'ftd.id' => $challan_Id
                        ];
                    }else{
                        $where = [
                            'ftd.fk_branch_id' => Yii::$app->common->getBranch(),
                            'fg.fk_class_id'=>$query_std_plan['class_id'],
                            'ftd.stud_id' =>$stu_Id ,'ftd.id' => $challan_Id,
                            'ftd.id' => $challan_Id
                        ];
                    }

                    $query = FeePaymentMode::find()
                        ->select([
                            'fcp.discount_amount discount_amount',
                            'fcp.transport_fare fcp_transport_fare',
                            'fcp.hostel_fare fcp_hostel_fare',
                            'fcp.fee_payable fee_payable',
                            'fcp.total_fee_amount',
                            'fee_payment_mode.time_span no_months',
                            'fee_payment_mode.title payment_mode',
                            'fh.title fee_head',
                            'fh.id as fee_head_id',
                            'fh.description fee_description',
                            'fg.amount fee_head_amount',
                            'fdt.title fee_discount_type',
                            'ftd.id chalan_id',
                            'fdt.description fee_discount_description',
                            'fd.amount head_discount',
                            's.fare transport_fare'
                        ])
                        ->innerJoin('fee_heads fh', 'fh.fk_fee_method_id = fee_payment_mode.id')
                        ->innerJoin('fee_group fg', 'fg.fk_fee_head_id = fh.id')
                        ->innerJoin('student_info st', 'st.class_id = fg.fk_class_id')
                        ->leftJoin('fee_discounts fd','fd.fk_fee_head_id=fh.id and fd.fk_stud_id=st.stu_id')
                        ->leftJoin('fee_discount_types fdt', 'fdt.id = fd.fk_fee_discounts_type_id')
                        ->leftJoin('stop s', 's.id=st.fk_stop_id')
                        ->innerJoin('fee_transaction_details ftd', 'ftd.stud_id=st.stu_id')
                        ->innerJoin('fee_collection_particular fcp', 'fcp.id = ftd.fk_fee_collection_particular')
                        ->where($where)
                        ->groupBy([
                            'fcp.discount_amount',
                            'fcp.transport_fare',
                            'fcp.fee_payable',
                            'fcp.total_fee_amount',
                            'fee_payment_mode.time_span',
                            'fee_payment_mode.title',
                            'fh.title',
                            'fh.id',
                            'fg.amount',
                            'fdt.title',
                            'ftd.id',
                            'fdt.description',
                            'fd.amount',
                            's.fare'
                        ])
                        ->asArray()->all();
                    $html = $this->renderAjax('challan-details-form',
                        [
                            'query_std_plan'                => $query_std_plan,
                            'query'                         => $query,
                            'feeTranscModel'                => $feeTranscModel,
                            'student_id'                    => $stu_Id,
                            'challan_id'                    => $challan_Id,
 			                'transport_hostel_received'     => $transport_hostel_received,
                            'transport_amt'                 => $transport_fare,
                            'hostel_amt'                    => $hostel_fare,
                            'sundry_account'                =>$sundry_account,
                        ]);
                    return json_encode(['status'=>1,'details'=>$html]);

                }

            }
            else{
                if (Yii::$app->request->post()) {


                    $id = Yii::$app->request->post('FeeTransactionDetails')['id'];
                    $sundry_account_details         = Yii::$app->request->post('StudentAdvance');

                    $manual_receipt_no              = Yii::$app->request->post('FeeTransactionDetails')['manual_recept_no'];
                    $entered_transport_fare         = Yii::$app->request->post('FeeTransactionDetails')['transaction-transport_fare'];
                    $entered_hostel_fare            = Yii::$app->request->post('FeeTransactionDetails')['transaction-hostel_fare'];
                    $head_amount_array              = Yii::$app->request->post('transaction_head_amount');
                    $feeTranscModel                 = FeeTransactionDetails::findOne($id);
                    $feeCollectionParticular        = FeeCollectionParticular::findOne($feeTranscModel->fk_fee_collection_particular);
                    $old_transport_fare_amt         = $feeCollectionParticular->transport_fare;
                    $old_hostel_fare_amt            = $feeCollectionParticular->hostel_fare;
                    $new_tarnsport_fare             = $old_transport_fare_amt - $entered_transport_fare;
                    $new_hostel_fare                = $old_hostel_fare_amt - $entered_hostel_fare;


                    /*activate student.*/
                    $student= StudentInfo::findOne($feeTranscModel->stud_id);

                    if($student->is_active == 0){
                        $user = User::findOne($student->user_id);
                        if($user->status == 'inactive'){
                            $user->status = 'active';
                            $user->save();
                        }
                        $student->is_active = 1;
                        $student->save();
                    }

                    /*add transection.*/
                    $old_opening_bal     = $feeTranscModel->opening_balance;
                    $old_transectionamt  = $feeTranscModel->transaction_amount;

                    if(Yii::$app->request->post('submitValue') == 'submit-challan'){
                        /*echo "<pre>";
                        print_r($sundry_account_details);
                        exit;*/
                        if($feeTranscModel->load(Yii::$app->request->post())){
                            // ============END SEND MESSAGE TO STUDENTS PARENTS =========================//
                            $success = false;
                            $post_data = Yii::$app->request->post();
                            $fee_head_ids = array_keys($post_data['transaction_head_arrears_amount']);
                            $message = '';
                            if(!empty($fee_head_ids)){
                                $message .= 'Name: '.$post_data['std_name']."<br />";
                                $total_arrears = 0;
                                foreach ($fee_head_ids as $id) {
                                    $row = yii::$app->db->createCommand("SELECT title FROM fee_heads WHERE id = ".$id)->queryOne();
                                    $message .= $row['title'].': '.'Rs.'.$post_data['transaction_head_amount'][$id].",&nbsp&nbsp&nbsp";
                                    $message .= 'Arrears: '.'Rs.'.$post_data['transaction_head_arrears_amount'][$id]."<br />";
                                    $total_arrears = $total_arrears + $post_data['transaction_head_arrears_amount'][$id];
                                }
                                $message .= '-------------------------------<br />';
                                $message .= 'Paid Amount: Rs.'.$post_data['FeeTransactionDetails']['transaction_amount']."<br />";
                                $message .= 'Total Arrears: Rs.'.$total_arrears."<br />";
                                $message .= '-------------------------------<br />';
                                // $message .= 'Manual Receipt #: '.$post_data['FeeTransactionDetails']['manual_recept_no']."<br />";
                                $message .= 'Submission Date: '.$post_data['FeeTransactionDetails']['transaction_date']."<br />";
                                $message .= 'Challan #: '.$post_data['Challan'];

                                $student_row_data = yii::$app->db->createCommand("SELECT stud_id FROM fee_transaction_details WHERE id = ".$post_data['FeeTransactionDetails']['id'])->queryOne();
                                $studentId = $student_row_data['stud_id'];
                                $smsModel = new SmsLog();
                                $getparentcontact = StudentParentsInfo::find()->select('contact_no')->where(['stu_id' => $studentId])->one();
                                $sendParentContact = $getparentcontact->contact_no;
                                $success = Yii::$app->common->SendSms($sendParentContact, $message, $studentId);
                            }
                            // ============END SEND MESSAGE TO STUDENTS PARENTS =========================//

                            $new_opening_balance        = $old_opening_bal - $feeTranscModel->transaction_amount;
                            $new_transection_amt        = $old_transectionamt+$feeTranscModel->transaction_amount;
                            $feeTranscModel->opening_balance    = ($new_opening_balance < 0)?0:$new_opening_balance;
                            $feeTranscModel->manual_recept_no    = ($manual_receipt_no)?$manual_receipt_no:null;
                            $feeTranscModel->status = ($new_opening_balance <= 0)?0:1;
                            if($feeTranscModel->save()){

                                /*updating fee collection particular.*/
                                $feeCollectionParticular->fee_payable    = ($new_opening_balance < 0)?0:$new_opening_balance;
                                $feeCollectionParticular->transport_fare = ($new_tarnsport_fare > 0)?$new_tarnsport_fare:0;
                                $feeCollectionParticular->hostel_fare    = ($new_hostel_fare > 0)?$new_hostel_fare:0;
                                $feeCollectionParticular->save();
                                if(isset($head_amount_array)){
                                    foreach ($head_amount_array as $key=>$head_amount){

                                        /*head fee particular*/
                                        $feeparticular = FeeParticulars::find()
                                            ->where([
                                                'fk_branch_id'=>Yii::$app->common->getBranch(),
                                                'fk_fee_head_id'=>$key,
                                                'fk_stu_id'=>$student->stu_id
                                            ])
                                            ->one();


                                        /*updating fee head Amount.*/
                                        $headAmountTotal = FeeGroup::find()->where(['fk_branch_id'=>Yii::$app->common->getBranch(),'fk_fee_head_id'=>$key,'fk_class_id'=>$student->class_id,'fk_group_id'=>$student->group_id])->one();
                                        /*total head received till date*/
                                        $feeHeadWise_received = FeeParticulars::find()
                                            ->innerJoin('fee_head_wise fhw','fhw.fk_fee_particular_id = fee_particulars.id')
                                            ->where([
                                                'fee_particulars.fk_branch_id'        => Yii::$app->common->getBranch(),
                                                'fee_particulars.fk_stu_id'           => $student->stu_id,
                                                'fee_particulars.fk_fee_plan_type'    => $student->fk_fee_plan_type,
                                                'fee_particulars.fk_fee_head_id'      => $key
                                            ])
                                            ->sum('fhw.payment_received');
                                        $total_received_amt = $feeHeadWise_received+$head_amount;

                                        /*fee headwise*/
                                        $feeHeadWiseModal                       = new FeeHeadWise();
                                        $feeHeadWiseModal->fk_branch_id         = Yii::$app->common->getBranch();
                                        $feeHeadWiseModal->fk_stu_id            = $student->stu_id;
                                        $feeHeadWiseModal->fk_fee_head_id      = $key;
                                        $feeHeadWiseModal->fk_fee_particular_id = (count($feeparticular)>0)?$feeparticular->id:null;
                                        $feeHeadWiseModal->fk_chalan_id         = $feeTranscModel->id;
                                        $feeHeadWiseModal->transport_fare       = $entered_transport_fare;
                                        $feeHeadWiseModal->hostel_fee           = $entered_hostel_fare;

                                        if(count($headAmountTotal)>0){
                                            if($total_received_amt == $headAmountTotal->amount){
                                                $feeHeadWiseModal->is_paid          = 1;
                                            }
                                        }
                                        $feeHeadWiseModal->payment_received = $head_amount;
                                        if (!$feeHeadWiseModal->save()) {
                                            print_r($feeHeadWiseModal->getErrors());exit;
                                        }

                                    }
                                }

                                /* if($sundry_account_details['input_sundry_status']==1) {
                                    //inactive old sundry
                                    $update_old_sundry_rec = "UPDATE sundry_account  SET status = 0 WHERE fk_branch_id = " . Yii::$app->common->getBranch() . " and stu_id =" . $student->stu_id;
                                    \Yii::$app->db->createCommand($update_old_sundry_rec)->execute();
                                    $new_sundary = new SundryAccount();
                                    $new_sundary->fk_branch_id = Yii::$app->common->getBranch();
                                    $new_sundary->stu_id = $student->stu_id;
                                    $new_sundary->total_advance_bal = $sundry_account_details['input_total_advance_remaining_payment'];
                                    $new_sundary->fk_chalan_id = $feeTranscModel->id;
                                    if(!$new_sundary->save()){echo "<pre>"; print_r($new_sundary->getErrors());}

                                }*/
                                Yii::$app->session->setFlash('success', 'Transaction has been added your remaining amount is : '.Yii::$app->formatter->asCurrency((($new_opening_balance < 0)?0:$new_opening_balance), 'RS.'));
                                $this->redirect(['fee/index']);
                            }
                        }
                    }
                    else{
                        /*echo "<pre>";
                        print_r($head_amount_array);exit;*/
                        $feeTransData = Yii::$app->request->post('FeeTransactionDetails');
                
                        /* new partial challan generation in particulars and further.*/
                        $feeCollectionPartModel = new FeeCollectionParticular();
                        $feeCollectionPartModel->fk_branch_id      =  Yii::$app->common->getBranch();
                        $feeCollectionPartModel->fk_stu_id         =  $student->stu_id;//$model->stu_id;
                        $feeCollectionPartModel->total_fee_amount  =  $feeCollectionParticular->total_fee_amount;
                        $feeCollectionPartModel->transport_fare    =  $entered_transport_fare;//($new_tarnsport_fare > 0)?$new_tarnsport_fare:0;
                        $feeCollectionPartModel->discount_amount   =  ($feeCollectionParticular->discount_amount)?$feeCollectionParticular->discount_amount:null;
                        $feeCollectionPartModel->fee_payable       =  $feeTransData['transaction_amount'];
                        $feeCollectionPartModel->due_date          =  $feeCollectionParticular->due_date;
                        /*set previous collection particular status to inactive = 0*/
                        $feeCollectionParticular->is_active = 0;
                        $feeCollectionParticular->save();

                        if($feeCollectionPartModel->save()){

                            /*set previous transection details status to inactive = 0*/
                            $feeTranscModel->status = 0;
                            $feeTranscModel->save();
                            /*creating new fee colection particualr */
                            $newFeeTranscModel = new FeeTransactionDetails();
                            $newFeeTranscModel->opening_balance = $feeTransData['transaction_amount'];
                            $newFeeTranscModel->fk_branch_id = Yii::$app->common->getBranch();
                            $newFeeTranscModel->stud_id = $student->stu_id;
                            $newFeeTranscModel->transaction_date = null;
                            $newFeeTranscModel->transaction_amount = null;
                            $newFeeTranscModel->fk_fee_collection_particular = $feeCollectionPartModel->id;
                            if(!$newFeeTranscModel->save()){$newFeeTranscModel->getErrors();exit;}  
                            Yii::$app->session->setFlash('success', 'Partial Challan Has been generated for '.ucfirst($student->user->first_name).' '.ucfirst($student->user->last_name));
                            $this->redirect(['fee/index','stu_id'=>$student->stu_id,'ch_id'=>$newFeeTranscModel->id]);

                        }
                        else{
                            print_r($feeCollectionPartModel->getErrors());exit;
                        }


                    }
                }
            }

        }
    }

    /*fee structure */
    public function actionStructure(){
        
        if (Yii::$app->user->isGuest) {
            $this->redirect(['site/login']);
        }
        else {
            $feestructure = new FeeGroup();
            if(Yii::$app->request->post()){
                $data =  Yii::$app->request->post('FeeGroup');
                
                $class  = isset($data['fk_class_id']) ? $data['fk_class_id'] : null;
                $group  = isset($data['fk_group_id']) ?$data['fk_group_id'] : null;
                $feestructure->fk_group_id=$group;
                $feestructure->fk_class_id=$class;
                
                
                $searchModel = new \app\models\search\FeeGroup();
                if ($class) {
                    $searchModel->fk_class_id=$class;
                }
                if($group){
                    $searchModel->fk_group_id = $group;
                }

                $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

                return $this->render('structure', [
                    'type'          => 'post',
                    'model'     => $feestructure,
                    'searchModel'   => $searchModel,
                    'dataProvider'  => $dataProvider,
                ]);
            }else{
                return $this->render('structure', [
                    'type'      => '',
                    'model'     => $feestructure
                ]);
            }
        }
    }

    /*generate fee challan PAGE*/
    public function actionGenerateFeeChallan(){

        if (Yii::$app->user->isGuest) {
            $this->redirect(['site/login']);
        }
        else {
            $model = new StudentInfo();

            /*
            *   Process for non-ajax request
            */
            return $this->render('generate-fee-challan', [
                'model' => $model,
            ]);
        }
    }


    /*generate challan student list*/

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
                        $query = StudentInfo::find()->where([
                            'fk_branch_id'  => Yii::$app->common->getBranch(),
                            'class_id'      => $class_id,
                            //'group_id'      => ($group_id)?$group_id:null,
                            //'section_id'    => $section_id,
                            /*'is_active'     => 1*/
                        ]);
                        $searchModel = new \app\models\search\StudentInfoSearch();

                        //$searchModel->patient_id = $post_data['pat_id'];
                        //$dataProvider = $searchModel->search(Yii::$app->request->queryParams);
                        $dataProvider= new ActiveDataProvider([
                            'query'=>$query,
                            'sort' => [
                                'defaultOrder' => [
                                    'stu_id' => SORT_DESC
                                ]
                            ],
                            'pagination' => [
                                'pageSize' => 5000,
                                'params' => [
                                    'class_id'      => $class_id,
                                    'group_id'      => ($group_id)?$group_id:null,
                                    'section_id'    => $section_id,
                                ],
                            ]
                        ]);
                        // print_r(Yii::$app->request->queryParams);die;

                        $details =  $this->renderAjax('getStudents', [
                            'searchModel' => $searchModel,
                            'dataProvider' => $dataProvider,
                        ]);

                        return json_encode(['status'=>1 ,'details'=>$details]);
                    }
                    else{
                        return json_encode(['status'=>1,'details'=>'<div class="alert alert-warning"><strong>Note!</strong>Record Not Found.</div>']);
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
                        /*query*/
                        $query = StudentInfo::find()->where([
                            'fk_branch_id'  => Yii::$app->common->getBranch(),
                            'class_id'      => $class_id,
                            'group_id'      => ($group_id)?$group_id:null,
                            'section_id'    => $section_id,
                            /*'is_active'     => 1*/
                        ]);
                        $searchModel = new \app\models\search\StudentInfoSearch();

                        //$searchModel->patient_id = $post_data['pat_id'];
                        //$dataProvider = $searchModel->search(Yii::$app->request->queryParams);
                        $dataProvider= new ActiveDataProvider([
                            'query'=>$query,
                            'sort' => [
                                'defaultOrder' => [
                                    'stu_id' => SORT_DESC
                                ]
                            ],
                            'pagination' => [
                                'pageSize' => 5000,
                                'params' => [
                                    'class_id'      => $class_id,
                                    'group_id'      => ($group_id)?$group_id:null,
                                    'section_id'    => $section_id,
                                ],
                            ]
                        ]);
                        // print_r(Yii::$app->request->queryParams);die;

                        $details =  $this->renderAjax('getStudents', [
                            'searchModel' => $searchModel,
                            'dataProvider' => $dataProvider,
                        ]);
                    
                        return json_encode(['status'=>1 ,'details'=>$details]);
                    }
                    else{
                        return json_encode(['status'=>1,'details'=>'<div class="alert alert-warning"><strong>Note!</strong>Record Not Found.</div>']);
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
        }
    }


    /*generate challan form */
    public function actionGenerateChallanForm(){
        if (Yii::$app->user->isGuest) {
            return  $this->redirect(['site/login']);
        }
        else {
            if(Yii::$app->request->isAjax){
                $data=Yii::$app->request->post();

                $feeTranscModel = new \app\models\FeeTransactionDetails();
                $student_id         = $data['stu_id'];
                $student_data       = Yii::$app->common->getStudent($student_id);
                $std_plan_type      = $student_data->fk_fee_plan_type;
                $class_id           = $student_data->class_id;
                $group_id           = $student_data->group_id;
                $section_id         = $student_data->section_id;
                $stop_id            = $student_data->fk_stop_id;
                $is_hostel_avail    = $student_data->is_hostel_avail;
                $transport_hostel_received=[];
                $challan_type           = '';
                $is_month_metured       = 0;
                $total_multiplyer       = 0;
                $fee_generation_date    = '';
                $transport_fare=0;
                $hostel_fare=0;
                $fee_plan_Model = FeePlanType::findOne($std_plan_type);
                $sundry_account = SundryAccount::find()->where(['fk_branch_id'=>Yii::$app->common->getBranch(),'stu_id'=>$student_id,'status'=>1])->all();
                $sundry_hostel_tansport  = SundryAccount::find()->where(['fk_branch_id'=>Yii::$app->common->getBranch(),'stu_id'=>$student_id,'status'=>1])->one();

                /*check fee meturity */
                /*formula 1*/
                //echo "12/".$fee_plan_type->no_of_installments.'<br/>';
                $plan_counter = 12/$fee_plan_Model->no_of_installments;
               /*monthly meturity coutner check*/
                $plan_monthly_counter = 1;

                /*formula 2 get month counter*/
                $plan_month_counter = Yii::$app->common->getMonthInterval($student_data->fee_generation_date,date('Y-m-d'));
                $monthly_counter    = Yii::$app->common->getMonthInterval($student_data->monthly_fee_gen_date,date('Y-m-d'));


                $active_fee_challan_record = FeeChallanRecord::find()->select(['challan_id','fare_amount','hostel_fare'])->where(['fk_stu_id'=>$student_id,'fk_fee_plan_id'=>$student_data->fk_fee_plan_type,'status'=>1])->one();




                /*check challan if if it's month is metured or not.*/
                if($plan_month_counter >= $plan_counter){
                    $challan_type = 'new';
                    $total_multiplyer =  floor($plan_month_counter/$plan_counter);
                    if($total_multiplyer>0){
                        // returns timestamp
                        $fee_generation_strtotime = strtotime("+".($total_multiplyer*$plan_counter)." months", strtotime($student_data->fee_generation_date));
                        $fee_generation_date = date('Y-m-d',$fee_generation_strtotime); // formatted version

                    }
                    $due_date          = date('Y-m-'.Yii::$app->common->getBranchSettings()->fee_due_date) ;
                }
                else{
                    $challan_type = 'old';
                    $due_date          = date('Y-m-d') ;
                }

                /*check month is metured or not.*/
                if($monthly_counter == $plan_monthly_counter){
                    $is_month_metured = 1;
                }

                $query = FeeHeads::find()->select([
                    'fpm.time_span as no_months',
                    'fee_heads.id as head_id',
                    'fee_heads.title',
                    'fee_heads.promotion_head',
                    'fee_heads.discount_head_status as discount_head_status',
                    'fee_heads.one_time_only as one_time',
                    'fee_heads.description',
                    'fg.amount','fg.is_active',
                    'rc.title as class',
                    'rg.title as group'
                ])
                    ->innerJoin('fee_payment_mode fpm','fpm.id=fee_heads.fk_fee_method_id')
                    ->leftJoin('fee_group fg','fg.fk_fee_head_id=fee_heads.id')
                    ->innerJoin('ref_class rc','rc.class_id=fg.fk_class_id')
                    ->leftJoin('ref_group rg','rg.group_id=fg.fk_group_id')
                    ->where(['fg.is_active'=>'yes','rc.class_id'=>$class_id,'rg.group_id'=>($group_id)?$group_id:null])->asArray()->all();


                /*transport fee paid or not if availble.*/
                if(count($active_fee_challan_record)>0) {
                    $transport_hostel_received = \app\models\FeeHeadWise::find()
                        ->select(['transport_fare', 'hostel_fee'])
                        ->where([
                            'fk_branch_id' => Yii::$app->common->getBranch(),
                            'fk_chalan_id' => $active_fee_challan_record->challan_id,
                            'fk_stu_id' => $student_data->stu_id,
                        ])->asArray()->one();
                }
                if(!empty($stop_id)){
                    $stopModel = Stop::findOne($stop_id);
                    $transport_fare=$stopModel->fare;
                }else{
                    if(count($active_fee_challan_record)>0){
                        $transport_fare = $active_fee_challan_record->fare_amount -$transport_hostel_received['transport_fare'];
                    }
                }

                if($is_hostel_avail){
                    $hostelDetail = HostelDetail::find()
                        ->select('h.amount amount')
                        ->innerJoin('hostel h','h.id=hostel_detail.fk_hostel_id')
                        ->where(['hostel_detail.fk_branch_id'=>Yii::$app->common->getBranch(),'hostel_detail.fk_student_id'=>$student_id])->asArray()->one();
                    //$hostel_fare = $hostelDetail['amount'];
                     $hostel_fare = $active_fee_challan_record->hostel_fare;
                }else{
                    if(count($active_fee_challan_record)>0){
                        $hostel_fare = $active_fee_challan_record->hostel_fare-$transport_hostel_received['hostel_fee'];
                    }
                }




                $html =  $this->renderAjax('get-fee-challan',[
                    'query'=>$query,
                    'feeTranscModel'=>$feeTranscModel,
                    'student_data'=>$student_data,
                    'fee_plan_Model'=>$fee_plan_Model,
                    'transport_fare'=>$transport_fare,
                    'hostel_fare'=>$hostel_fare,
                    'transport_hostel_received'=>$transport_hostel_received,
                    'challan_id'=>(count($active_fee_challan_record)>0)?$active_fee_challan_record->challan_id:'',
                    'due_date'=>$due_date,
                    'challan_type'=>$challan_type,
                    'is_month_metured'=>$is_month_metured,
                    'fee_generation_date'=>($fee_generation_date)?$fee_generation_date:'',
                    'total_multiplyer'=>$total_multiplyer,
                    'sundry_account'=>$sundry_account,
                    'sundry_hosel_transport'=>$sundry_hostel_tansport
                ]);
                return json_encode(['status'=>1,'html'=>$html]);

            }
            else{
                if(Yii::$app->request->Post()){
                    $data               = Yii::$app->request->Post();
                    $Student_advance           = Yii::$app->request->Post('StudentAdvance');
                    $heads_amount           = Yii::$app->request->Post('transaction_head_amount');
                    $heads_arrears_amount   = Yii::$app->request->Post('transaction_head_arrears_amount');
                    /*
		    echo "<pre>";
                    print_r($data);exit;*/

                    $transectionDetails = Yii::$app->request->Post('FeeTransactionDetails');
                    $headDiscounts      = Yii::$app->request->Post('head_hidden_discount_amount');
                    $headDiscountsType  = Yii::$app->request->Post('head_hidden_discount_type');
                    $studentDisount     = Yii::$app->request->Post('StudentDisount');
                    $studentInfo        = Yii::$app->request->Post('StudentInfo');
                    $due_date           = date('Y-m-'.Yii::$app->common->getBranchSettings()->fee_due_date) ;
                   /* echo "<pre>";
                    print_r($studentInfo['fee_generation_date']);
                    exit;*/
                    $update_discount_inactive   = "UPDATE fee_discounts  SET is_active= 0 WHERE fk_branch_id = ".Yii::$app->common->getBranch()." and fk_stud_id =".$studentInfo['id'];
                    $update_challan_inactive    = "UPDATE fee_transaction_details  SET status = 0 WHERE fk_branch_id = ".Yii::$app->common->getBranch()." and stud_id =".$studentInfo['id'];
                    $update_fee_collection      = "UPDATE fee_collection_particular  SET is_active = 0 WHERE fk_branch_id = ".Yii::$app->common->getBranch()." and fk_stu_id =".$studentInfo['id'];
                    $update_fee_challan_rec     = "UPDATE fee_challan_record  SET status = 0 WHERE fk_branch_id = ".Yii::$app->common->getBranch()." and fk_stu_id =".$studentInfo['id'];

                    \Yii::$app->db->createCommand($update_discount_inactive)->execute();
                    \Yii::$app->db->createCommand($update_challan_inactive)->execute();
                    \Yii::$app->db->createCommand($update_fee_collection)->execute();
                    \Yii::$app->db->createCommand($update_fee_challan_rec)->execute();

                    /*inserting data into fee collection particular.*/
                    $feeCollectionParticularModel = New FeeCollectionParticular();
                    $feeCollectionParticularModel->fk_stu_id            = $studentInfo['id'];
                    $feeCollectionParticularModel->fee_payable          = $transectionDetails['transaction_amount'];
                    $feeCollectionParticularModel->total_fee_amount     = $studentDisount['input_total_amount_payable'];
                    $feeCollectionParticularModel->transport_fare       = ($studentDisount['input_total_transport_fare'])?$studentDisount['input_total_transport_fare']:null;
                    $feeCollectionParticularModel->hostel_fare          = ($studentDisount['input_total_hostel_fare'])?$studentDisount['input_total_hostel_fare']:null;
                    $feeCollectionParticularModel->discount_amount      = ($studentDisount['input_total_discount'])?$studentDisount['input_total_discount']:null;
                    $feeCollectionParticularModel->due_date             =  $due_date;

                    if($feeCollectionParticularModel->save()){
                        /*submit fee transection details to get challan id.*/
                        $feeTranscModel  =  new \app\models\FeeTransactionDetails();
                        $feeTranscModel->fk_fee_collection_particular   =  $feeCollectionParticularModel->id;
                        $feeTranscModel->transaction_date               =  null;
                        $feeTranscModel->transaction_amount             =  null;
                        $feeTranscModel->opening_balance                =  $feeCollectionParticularModel->fee_payable;
                        $feeTranscModel->stud_id                        =  $studentInfo['id'];
                        if($feeTranscModel->save()){
                            /*saving head wise discount if any and fee challan record*/
                            if(isset($heads_amount)){
                                foreach ($heads_amount as $key=>$item){
                                    $feeChallanRecordModel  = new FeeChallanRecord();
                                    $feeChallanRecordModel->fk_head_id          = $key;
                                    $feeChallanRecordModel->fk_fee_plan_id      = $studentInfo['plan_type_id'];
                                    $feeChallanRecordModel->fk_stu_id           = $studentInfo['id'];
                                    $feeChallanRecordModel->fare_amount         = ($studentDisount['input_total_transport_fare'])?$studentDisount['input_total_transport_fare']:null;
                                    $feeChallanRecordModel->hostel_fare         = ($studentDisount['input_total_hostel_fare'])?$studentDisount['input_total_hostel_fare']:null;
                                    $feeChallanRecordModel->head_amount         = $item;
                                    $feeChallanRecordModel->arrears             = (!empty($heads_arrears_amount[$key]))?$heads_arrears_amount[$key]:0;
                                    $feeChallanRecordModel->challan_id          = $feeTranscModel->id;
                                    if(!$feeChallanRecordModel->save()){print_r($feeChallanRecordModel->getErrors());exit;};

                                   if(isset($headDiscounts[$key])  && $headDiscounts[$key] >0 ){
                                         $feeHeadDiscount  =  new FeeDiscounts();
                                         $feeHeadDiscount->amount                    = $headDiscounts[$key];
                                         $feeHeadDiscount->fk_fee_discounts_type_id  = ($headDiscountsType[$key] !=0)?$headDiscountsType[$key]:null;
                                         $feeHeadDiscount->fk_fee_head_id            = $key;
                                         $feeHeadDiscount->is_active                 = 1;
                                         $feeHeadDiscount->fk_stud_id                = $studentInfo['id'];
                                         if(!$feeHeadDiscount->save()){print_r($feeHeadDiscount->getErrors());exit;};
                                   }
                                }
                            }
                            /*if($Student_advance['input_total_advance_remaining_payment']>0){
                                $sundry_account = new SundryAccount();
                                $sundry_account->stu_id = $studentInfo['id'];
                                $sundry_account->fk_chalan_id = $feeTranscModel->id;
                                $sundry_account->fk_branch_id = Yii::$app->common->getBranch();
                                $sundry_account->total_advance_bal = $Student_advance['input_total_advance_payment'];
                                if(!$sundry_account->save()){echo "<pre>";print_r($sundry_account->getErrors());exit;}
                            }*/
                            $student  = Yii::$app->common->getStudent($studentInfo['id']);
                            if($studentInfo['challan_type'] == 'new'){
                                $student->fee_generation_date = $studentInfo['fee_generation_date'];
                            }
                            if($studentInfo['is_month_metured']==1){
                                $student->monthly_fee_gen_date = date('Y-m-d');
                            }
                            if($student->transport_updated == 1){
                                $student->transport_updated = 0;
                            }

                            if($student->hostel_updated == 1){
                                $student->hostel_updated = 0;
                            }
                            $student->save(false);
                        }else{print_r($feeTranscModel->getErrors());exit; }



                    }else{print_r($feeCollectionParticularModel->getErrors());exit; }

                    /*returning to the detail view of stuednt.*/
                    Yii::$app->session->setFlash('success', 'Challan has been Generated successfully. Challan No is : '. $feeTranscModel->challan_no);
                    $this->redirect(['fee/generate-fee-challan', 'id' => $studentInfo['id'],'ch_id'=>$feeTranscModel->id]);
                }
            }
        }
    }

   /*generate fee challan monthly*/
    public function actionGenerateMonthlyChallan(){
        if (Yii::$app->user->isGuest) {
            return  $this->redirect(['site/login']);
        }
        else {

            if(Yii::$app->request->post()){
                $data = Yii::$app->request->post();
                $due_date          = date('Y-m-'.Yii::$app->common->getBranchSettings()->fee_due_date);
                /*get all students against the selected class id, group_id and section_id*/
                 
		        if(!empty($data['section_id'])){
                    $where = ['class_id'=>$data['class_id'],'group_id'=>($data['group_id'])?$data['group_id']:null,'section_id'=>$data['section_id'],'is_active'=>1];
                }else{
                    $where = ['class_id'=>$data['class_id'],'group_id'=>($data['group_id'])?$data['group_id']:null,'is_active'=>1];
                }
                $query = StudentInfo::find()
                    ->where($where)->all();

                if(count($query)>0){
                    $this->layout = 'pdf';
                    //$mpdf = new mPDF('', 'A4');
                    $mpdf = new mPDF('','', 0, '', 2, 2, 3, 3, 2, 2, 'A4');
                    $std_key =1;
                    $store_array_particular=[];

                    /*loop on class,section students.*/
                    foreach ($query as $key=>$student){ 
                        //echo $student->stu_id."<br/>";
                        $promotionModel = StuRegLogAssociation::find()->where(['fk_branch_id'=>Yii::$app->common->getBranch(),'fk_stu_id'=>$student->stu_id])->orderBy(['id'=>SORT_DESC])->limit(1)->one();
                        $sundry_account = SundryAccount::find()->where(['fk_branch_id'=>Yii::$app->common->getBranch(),'stu_id'=>$student->stu_id,'status'=>1])->all();
                        $sundry_hostel_tansport  = SundryAccount::find()->where(['fk_branch_id'=>Yii::$app->common->getBranch(),'stu_id'=>$student->stu_id,'status'=>1])->one();

                        $fee_plan_type = FeePlanType::findOne   ($student->fk_fee_plan_type);
                        if(count($promotionModel)>0){
                            $std_add_promo_date = strtotime($promotionModel->promoted_date);
                        }else{
                            $std_add_promo_date = strtotime($student->registration_date);
                        }


                        if($student->fk_fee_plan_type  != 0 && $student->fee_generation_date != null){

                            $FeeStructure = FeeGroup::find()->where([
                                'fk_branch_id'=>Yii::$app->common->getBranch(),
                                'fk_class_id'=>$student->class_id,
                                'fk_group_id'=>($student->group_id)?$student->group_id:null
                            ])->all();
                            $is_month_metured       = 0;
                            $total_multiplyer       = 0; 
                            $stop_id            = $student->fk_stop_id;
                            $is_hostel_avail    = $student->is_hostel_avail;

                            /*formula 1*/
                            //echo "12/".$fee_plan_type->no_of_installments.'<br/>';
                            $plan_counter = 12/$fee_plan_type->no_of_installments;
                            /*monthly meturity coutner check*/
                            $plan_monthly_counter = 1;

                            /*formula 2 get month counter*/
                            $plan_month_counter      = Yii::$app->common->getMonthInterval($student->fee_generation_date,date('Y-m-d'));
                            $monthly_counter    = Yii::$app->common->getMonthInterval($student->monthly_fee_gen_date,date('Y-m-d'));

                            /*check month is metured or not.*/
                            if($monthly_counter == $plan_monthly_counter){
                                $is_month_metured = 1;
                            }

                            //echo $plan_month_counter.' >= '.$plan_counter."<br/>";continue;
                            /*plan is matured or greater than the given plan*/
                            if($plan_month_counter >= $plan_counter){
                                $total_multiplyer =  floor($plan_month_counter/$plan_counter);
				                if($total_multiplyer>0){
                                    //echo $student->stu_id."<br/>";
                                    // returns timestamp
                                    $fee_generation_strtotime = strtotime("+".($total_multiplyer*$plan_counter)." months", strtotime($student->fee_generation_date));
                                    $fee_generation_date = date('Y-m-d',$fee_generation_strtotime); // formatted version

                                }
                                $challan_type           = ''; 
                                $challan_type = 'new'; 
                                $due_date          = date('Y-m-'.Yii::$app->common->getBranchSettings()->fee_due_date) ;
                                $feeTranscModel = new \app\models\FeeTransactionDetails();
                                $student_id         = $student->stu_id;
                                $student_data       = Yii::$app->common->getStudent($student->stu_id);
                                $std_plan_type      = $student->fk_fee_plan_type;
                                $class_id           = $student->class_id;
                                $group_id           = $student->group_id;
                                $section_id         = $student->section_id;
                                $stop_id            = $student->fk_stop_id;
                                $is_hostel_avail    = $student->is_hostel_avail;
                                $transport_hostel_received=[];
                                $sum_total=0;
                                $discount_amount=0; 
                                $transport_fare=0;
                                $hostel_fare=0;
                                                                
                                $transport_fare=0;
                                $hostel_fare=0;
                                $fee_plan_Model = FeePlanType::findOne($std_plan_type);  

                                $active_fee_challan_record = FeeChallanRecord::find()->select(['challan_id','fare_amount','hostel_fare'])->where(['fk_stu_id'=>$student_id,'fk_fee_plan_id'=>$student->fk_fee_plan_type,'status'=>1])->one();   
            
                                $query = FeeHeads::find()->select([
                                    'fpm.time_span as no_months',
                                    'fee_heads.id as head_id',
                                    'fee_heads.title',
                                    'fee_heads.promotion_head',
                                    'fee_heads.discount_head_status as discount_head_status',
                                    'fee_heads.one_time_only as one_time',
                                    'fee_heads.description',
                                    'fg.amount','fg.is_active',
                                    'rc.title as class',
                                    'rg.title as group'
                                ])
                                    ->innerJoin('fee_payment_mode fpm','fpm.id=fee_heads.fk_fee_method_id')
                                    ->leftJoin('fee_group fg','fg.fk_fee_head_id=fee_heads.id')
                                    ->innerJoin('ref_class rc','rc.class_id=fg.fk_class_id')
                                    ->leftJoin('ref_group rg','rg.group_id=fg.fk_group_id')
                                    ->where(['fg.is_active'=>'yes','rc.class_id'=>$class_id,'rg.group_id'=>($group_id)?$group_id:null])->asArray()->all();


                                /*transport fee paid or not if availble.*/
                                if(count($active_fee_challan_record)>0) {
                                    $transport_hostel_received = \app\models\FeeHeadWise::find()
                                        ->select(['transport_fare', 'hostel_fee'])
                                        ->where([
                                            'fk_branch_id' => Yii::$app->common->getBranch(),
                                            'fk_chalan_id' => $active_fee_challan_record->challan_id,
                                            'fk_stu_id' => $student->stu_id,
                                        ])->asArray()->one();
                                }
                                if(!empty($stop_id)){
                                    $stopModel = Stop::findOne($stop_id);
                                    $transport_fare=$stopModel->fare;
                                }else{
                                    if(count($active_fee_challan_record)>0){
                                        $transport_fare = $active_fee_challan_record->fare_amount -$transport_hostel_received['transport_fare'];
                                    }
                                }

                                if($is_hostel_avail){
                                    $hostelDetail = HostelDetail::find()
                                        ->select('h.amount amount')
                                        ->innerJoin('hostel h','h.id=hostel_detail.fk_hostel_id')
                                        ->where(['hostel_detail.fk_branch_id'=>Yii::$app->common->getBranch(),'hostel_detail.fk_student_id'=>$student->stu_id])->asArray()->one();
                                    //$hostel_fare = $hostelDetail['amount'];
                                    $hostel_fare = $active_fee_challan_record->hostel_fare;
                                }else{
                                    if(count($active_fee_challan_record)>0){
                                        $hostel_fare = $active_fee_challan_record->hostel_fare-$transport_hostel_received['hostel_fee'];
                                    }
                                }


                                $store_array_particular[$student->stu_id] =  $this->getFeeDetails(
                                    $query,
                                    $feeTranscModel,
                                    $student,
                                    $fee_plan_Model,
                                    $transport_fare,
                                    $hostel_fare,
                                    $transport_hostel_received,
                                    (count($active_fee_challan_record)>0)?$active_fee_challan_record->challan_id:'',
                                    $due_date,
                                    $challan_type,
                                    $is_month_metured,
                                    ($fee_generation_date)?$fee_generation_date:'',
                                    $total_multiplyer,
                                    $sundry_account,
                                    $sundry_hostel_tansport
                                );

 

                                /*sumtotal*/
                                $sum_total      =  $store_array_particular[$student->stu_id]['total_head_amount'][0];
                                $transport_fare =  $store_array_particular[$student->stu_id]['transport_fare'][0];
                                $hostel_fare    =  $store_array_particular[$student->stu_id]['hostel_fare'][0];
                                                /*echo "<pre>";
                                                print_r($store_array_particular);
                                echo "<br/>";
                                echo $sum_total." ".$transport_fare." ".$hostel_fare; 
                                if($student->stu_id==35){exit;}else{continue;}   */
                                //echo $sum_total.' transport: '.$transport_fare.' discount_amount: '.$discount_amount.'<br/>';
                                /*inactive previous challan from FTD, FCP And Fee Challan Record.*/
                                $update_challan_inactive = "UPDATE fee_transaction_details  SET status = 0 WHERE fk_branch_id = ".Yii::$app->common->getBranch()." and stud_id =".$student->stu_id;
                                $update_fee_collection = "UPDATE fee_collection_particular  SET is_active = 0 WHERE fk_branch_id = ".Yii::$app->common->getBranch()." and fk_stu_id =".$student->stu_id;
                                $update_fee_challan_rec = "UPDATE fee_challan_record  SET status = 0 WHERE fk_branch_id = ".Yii::$app->common->getBranch()." and fk_stu_id =".$student->stu_id;
                                \Yii::$app->db->createCommand($update_challan_inactive)->execute();
                                \Yii::$app->db->createCommand($update_fee_collection)->execute();
                                \Yii::$app->db->createCommand($update_fee_challan_rec)->execute();
                                
                                $feeCollectionPartModel = new FeeCollectionParticular();
                                $feeCollectionPartModel->fk_branch_id      =  Yii::$app->common->getBranch();
                                $feeCollectionPartModel->fk_stu_id         =  $student->stu_id;//$model->stu_id;
                                $feeCollectionPartModel->total_fee_amount  =  round($sum_total,0);
                                $feeCollectionPartModel->transport_fare    =  ($transport_fare > 0)?$transport_fare:null;
                                $feeCollectionPartModel->hostel_fare       =  ($hostel_fare > 0)?$hostel_fare:null;
                                $feeCollectionPartModel->discount_amount   =  ($discount_amount >0)?$discount_amount:null;
                                $feeCollectionPartModel->fee_payable       =  round($sum_total+$transport_fare+$hostel_fare,0);
                                $feeCollectionPartModel->due_date          =  $due_date;
                                if(!$feeCollectionPartModel->save()){print_r($feeCollectionPartModel->getErrors());echo 'feeCollectionPartModel';exit;}

                                /*fee transection details*/
                                $feeTransectionModel       =  new FeeTransactionDetails();
                                $feeTransectionModel->fk_branch_id = Yii::$app->common->getBranch();
                                $feeTransectionModel->stud_id = $student->stu_id;
                                $feeTransectionModel->fk_fee_collection_particular = $feeCollectionPartModel->id;
                                $feeTransectionModel->transaction_date = null;
                                $feeTransectionModel->transaction_amount = null;
                                $feeTransectionModel->opening_balance = round($feeCollectionPartModel->fee_payable,0);
                                $feeTransectionModel->status = 1;
                                if(!$feeTransectionModel->save()){print_r($feeTransectionModel->getErrors());echo 'feeTransectionModel';exit;}

                                /*populate monthly fee challan record*/ 
                                foreach($store_array_particular[$student->stu_id] as $std_monthly_challan_rec){
 				    if(isset($std_monthly_challan_rec[head_id])){
                                    $fee_challan_recordModel = New FeeChallanRecord();
                                    $fee_challan_recordModel->challan_id         = $feeTransectionModel->id;
                                    $fee_challan_recordModel->fk_stu_id          = $std_monthly_challan_rec['stu_id'];
                                    $fee_challan_recordModel->fk_fee_plan_id     = $std_monthly_challan_rec['fee_plan_id'];
                                    $fee_challan_recordModel->fk_head_id         = $std_monthly_challan_rec['head_id'];
                                    $fee_challan_recordModel->head_amount        = round($std_monthly_challan_rec['total_amount'],0);
                                    //$fee_challan_recordModel->arrears          = round($std_monthly_challan_rec['arrears'],0);
                                    $fee_challan_recordModel->fare_amount        = ($transport_fare > 0)?$transport_fare:null;
                                    $fee_challan_recordModel->hostel_fare        = ($hostel_fare > 0)?$hostel_fare:null;
				     //echo "<pre>";
				     //print_r($std_monthly_challan_rec);continue;
			             //print_r($fee_challan_recordModel);exit;
                                    if(!$fee_challan_recordModel->save()){print_r($fee_challan_recordModel->getErrors());echo 'challan_Record_model';exit;}
			            } 
                                } 

                                /*query here*/
                                $std_discount = \app\models\FeeDiscounts::find()->where(['fk_stud_id'=>$student->stu_id,'is_active'=>1])->count();

                                if($std_discount >0){
                                    $where = [
                                        'ftd.fk_branch_id' => Yii::$app->common->getBranch(),
                                        'st.class_id'=>$student->class_id,
                                        'ftd.stud_id' =>$student->stu_id ,
                                        'ftd.id' => $feeTransectionModel->id,
                                        'fcr.status' => 1,
                                        'fd.is_active' => 1
                                    ];
                                }else{
                                    $where = [
                                        'ftd.fk_branch_id' => Yii::$app->common->getBranch(),
                                        'st.class_id'=>$student->class_id,
                                        'ftd.stud_id' =>$student->stu_id ,
                                        'ftd.id' => $feeTransectionModel->id,
                                        'fcr.status' => 1
                                    ];
                                }
                                $query = FeePaymentMode::find()
                                    ->select([
                                        'fcp.discount_amount discount_amount',
                                        'fcp.transport_fare fcp_transport_fare',
                                        'fcp.fee_payable fee_payable',
                                        'fcp.total_fee_amount',
                                        'fee_payment_mode.time_span no_months',
                                        'fee_payment_mode.title payment_mode',
                                        'fh.title fee_head',
                                        'fh.id as fee_head_id',
                                        'fh.description fee_description',
                                        'fcr.head_amount fee_head_amount',
                                        'fdt.title fee_discount_type',
                                        'ftd.id chalan_id',
                                        'fdt.description fee_discount_description',
                                        'fd.amount head_discount',
                                        's.fare transport_fare'
                                    ])
                                    ->innerJoin('fee_heads fh', 'fh.fk_fee_method_id = fee_payment_mode.id')
                                    ->innerJoin('fee_challan_record fcr','fcr.fk_head_id = fh.id')
                                    ->innerJoin('student_info st', 'st.stu_id = fcr.fk_stu_id')
                                    ->leftJoin('fee_discounts fd','fd.fk_fee_head_id=fh.id and fd.fk_stud_id=st.stu_id')
                                    ->leftJoin('fee_discount_types fdt', 'fdt.id = fd.fk_fee_discounts_type_id')
                                    ->leftJoin('stop s', 's.id=st.fk_stop_id')
                                    ->innerJoin('fee_transaction_details ftd', 'ftd.stud_id=st.stu_id')
                                    ->innerJoin('fee_collection_particular fcp', 'fcp.id = ftd.fk_fee_collection_particular')
                                    ->where($where)->asArray()->all();


                                //generate PDF of challan 
                                $chalan_monthly_html = $this->render('get-monthly-chalan-pdf', [
                                    'student' => $student,
                                    'due_date'=> $feeCollectionPartModel->due_date,
                                    'challan_no'=> $feeTransectionModel->challan_no,
                                    'plan_title'=>$fee_plan_type->title,
                                    'no_of_installments'=>$fee_plan_type->no_of_installments,
                                    'plan_id'=>$fee_plan_type->id,
                                    'student_name'=>Yii::$app->common->getName($student->user_id),
                                    'query'=>$query,
                                    'transport_fare'=>$transport_fare,
                                    'hostel_fare'=>$hostel_fare,
                                    'sundry_account'=>$sundry_account,
                                    'sundry_hosel_transport'=>$sundry_hostel_tansport
                                ]);                                //echo $chalan_monthly_html;

                                $student->fee_generation_date = $fee_generation_date;
                                if($is_month_metured ==1){
                                    $student->monthly_fee_gen_date = date('Y-m-d');
                                }
                                if(!$student->save(false)){echo "<pre>";print_r($student->getErrors());exit;}

                                //fee challan will generate here
				
                                $mpdf->WriteHTML($chalan_monthly_html);


                				if ($std_key % 3 === 0){ 
                                                    	$mpdf->AddPage();
                 
                				} 
                                 	
                            }
                            else{
                                /*download current active forms.*/
                                $feeTransectionModel_cur    = \app\models\FeeTransactionDetails::findOne(['stud_id'=>$student->stu_id,'status'=>1]);
                                $feeheadwise_received       = \app\models\FeeHeadWise::find()->select('payment_received')->where(['fk_chalan_id'=>$feeTransectionModel_cur->id,'fk_branch_id'=>Yii::$app->common->getBranch()])->sum('payment_received');
                                $feecollectionModel         = \app\models\FeeCollectionParticular::findOne(['id'=>$feeTransectionModel_cur->fk_fee_collection_particular,'is_active'=>1]);
                                $transport_amt   = 0;
                                $discount_amount = 0;
                                /*query here*/
                                if(count($feeTransectionModel_cur) > 0){
                                    $std_discount = \app\models\FeeDiscounts::find()->where(['fk_stud_id'=>$student->stu_id,'is_active'=>1])->count();

                                    if($std_discount >0){
                                        $where = [
                                            'ftd.fk_branch_id' => Yii::$app->common->getBranch(),
                                            'st.class_id'=>$student->class_id,
                                            'ftd.stud_id' =>$student->stu_id ,
                                            'ftd.id' => $feeTransectionModel_cur->id,
                                            'fcr.status' => 1,
                                            'fd.is_active' => 1
                                        ];
                                    }else{
                                        $where = [
                                            'ftd.fk_branch_id' => Yii::$app->common->getBranch(),
                                            'st.class_id'=>$student->class_id,
                                            'ftd.stud_id' =>$student->stu_id ,
                                            'ftd.id' => $feeTransectionModel_cur->id,
                                            'fcr.status' => 1
                                        ];
                                    }
                                    $query = FeePaymentMode::find()
                                        ->select([
                                            'fcp.discount_amount discount_amount',
                                            'fcp.transport_fare fcp_transport_fare',
                                            'fcp.fee_payable fee_payable',
                                            'fcp.total_fee_amount',
                                            'fee_payment_mode.time_span no_months',
                                            'fee_payment_mode.title payment_mode',
                                            'fh.title fee_head',
                                            'fh.id as fee_head_id',
                                            'fh.description fee_description',
                                            'fcr.head_amount fee_head_amount',
                                            'fdt.title fee_discount_type',
                                            'ftd.id chalan_id',
                                            'fdt.description fee_discount_description',
                                            'fd.amount head_discount',
                                            's.fare transport_fare'
                                        ])
                                        ->innerJoin('fee_heads fh', 'fh.fk_fee_method_id = fee_payment_mode.id')
                                        ->innerJoin('fee_challan_record fcr','fcr.fk_head_id = fh.id')
                                        ->innerJoin('student_info st', 'st.stu_id = fcr.fk_stu_id')
                                        ->leftJoin('fee_discounts fd','fd.fk_fee_head_id=fh.id and fd.fk_stud_id=st.stu_id')
                                        ->leftJoin('fee_discount_types fdt', 'fdt.id = fd.fk_fee_discounts_type_id')
                                        ->leftJoin('stop s', 's.id=st.fk_stop_id')
                                        ->innerJoin('fee_transaction_details ftd', 'ftd.stud_id=st.stu_id')
                                        ->innerJoin('fee_collection_particular fcp', 'fcp.id = ftd.fk_fee_collection_particular')
                                        ->where($where)->asArray()->all();

                                    //generate PDF of challan
                                    $chalan_monthly_html = $this->render('get-monthly-chalan-pdf', [
                                        'student' => $student,
                                        'due_date'=> $feecollectionModel->due_date,
                                        'challan_no'=> $feeTransectionModel_cur->challan_no,
                                        'challan_id'=> $feeTransectionModel_cur->id,
                                        'plan_title'=>$fee_plan_type->title,
                                        'no_of_installments'=>$fee_plan_type->no_of_installments,
                                        'student_name'=>Yii::$app->common->getName($student->user_id),
                                        'plan_id'=>$fee_plan_type->id,
                                        'query'=>$query,
                                        'feeheadwise_received'=>$feeheadwise_received,
                                        'transport_fare'=>$feecollectionModel->transport_fare,
                                        'hostel_fare'=>$feecollectionModel->hostel_fare,
                                    'sundry_account'=>$sundry_account,
                                    'sundry_hosel_transport'=>$sundry_hostel_tansport

                                    ]);
 
                                    //fee challan will generate here
				   $mpdf->WriteHTML($chalan_monthly_html);
 
                                   if ($std_key % 3 === 0){ 
			             $mpdf->AddPage();
				   } 
                                }
                            }
                        }
				$std_key++;

                    }  
                    $mpdf->Output('Student-monthly-challan-'.date('Y-m-d H:i:s').'.pdf', 'D');
                    return $this->redirect('generate-fee-challan');
                }
                else{

                    Yii::$app->session->setFlash('warning',"There's no active students in this class at the moment.");
                    return $this->redirect('generate-fee-challan');
                }
            }
        }
    }



    /*generate-next-month-challan*/
    public function actionGenerateNextMonthChallan(){
        if (Yii::$app->user->isGuest) {
            return  $this->redirect(['site/login']);
        }
        else {

            if(Yii::$app->request->post()){
                
                
                
                
                $data = Yii::$app->request->post();
                $due_date          = date('Y-m-'.Yii::$app->common->getBranchSettings()->fee_due_date, strtotime('+1 months'));
                //$due_date            = date('Y-m-10', strtotime('+1 months')); 
                /*get all students against the selected class id, group_id and section_id*/
                if(!empty($data['section_id'])){
                    $where = ['class_id'=>$data['class_id'],'group_id'=>($data['group_id'])?$data['group_id']:null,'section_id'=>$data['section_id'],'is_active'=>1];
                }else{
                    $where = ['class_id'=>$data['class_id'],'group_id'=>($data['group_id'])?$data['group_id']:null,'is_active'=>1];
                }
                $query = StudentInfo::find()
                    ->where($where)->all();

                if(count($query)>0){
                    $this->layout = 'pdf';
                    //$mpdf = new mPDF('', 'A4');
                    $mpdf = new mPDF('','', 0, '', 2, 2, 3, 3, 2, 2, 'A4');
                    $i=0;
                    $store_array_particular=[];

                    /*loop on class,section students.*/
                    foreach ($query as $key=>$student){
                        //echo $student->stu_id."<br/>";
                        $promotionModel = StuRegLogAssociation::find()->where(['fk_branch_id'=>Yii::$app->common->getBranch(),'fk_stu_id'=>$student->stu_id])->orderBy(['id'=>SORT_DESC])->limit(1)->one();
                        $sundry_account = SundryAccount::find()->where(['fk_branch_id'=>Yii::$app->common->getBranch(),'stu_id'=>$student_id,'status'=>1])->all();
                        $sundry_hostel_tansport  = SundryAccount::find()->where(['fk_branch_id'=>Yii::$app->common->getBranch(),'stu_id'=>$student_id,'status'=>1])->one();
                        $fee_plan_type = FeePlanType::findOne($student->fk_fee_plan_type);
                        if(count($promotionModel)>0){
                            $std_add_promo_date = strtotime($promotionModel->promoted_date);
                        }else{
                            $std_add_promo_date = strtotime($student->registration_date);
                        }


                        if($student->fk_fee_plan_type  != 0 && $student->fee_generation_date != null){


                            $FeeStructure = FeeGroup::find()->where([
                                'fk_branch_id'=>Yii::$app->common->getBranch(),
                                'fk_class_id'=>$student->class_id,
                                'fk_group_id'=>($student->group_id)?$student->group_id:null
                            ])->all();
                            $is_month_metured       = 0;
                            $total_multiplyer       = 0;
                            $fee_generation_date    = '';
                            $stop_id            = $student->fk_stop_id;
                            $is_hostel_avail    = $student->is_hostel_avail;

                            /*formula 1*/
                            //echo "12/".$fee_plan_type->no_of_installments.'<br/>';
                            $plan_counter = 12/$fee_plan_type->no_of_installments;
                            /*monthly meturity coutner check*/
                            $plan_monthly_counter = 1;

                            /*formula 2 get month counter*/
                            $plan_month_counter = Yii::$app->common->getMonthInterval($student->fee_generation_date,date('Y-m-01', strtotime('+1 months')));
                            $monthly_counter    = Yii::$app->common->getMonthInterval($student->monthly_fee_gen_date, date('Y-m-01', strtotime('+1 months')));

                            /*check month is metured or not.*/
                            if($monthly_counter == $plan_monthly_counter){
                                $is_month_metured = 1;
                            }


                            /*plan is matured or greater than the given plan*/
                            if($plan_month_counter >= $plan_counter){

                                $total_multiplyer =  floor($plan_month_counter/$plan_counter);
                                if($total_multiplyer>0){
                                    // echo $student->stu_id."<br/>";
                                    // returns timestamp
                                    $fee_generation_strtotime = strtotime("+".($total_multiplyer*$plan_counter)." months", strtotime($student->fee_generation_date));
                                    $fee_generation_date = date('Y-m-01',$fee_generation_strtotime); // formatted version

                                }
                                /*echo "+".($total_multiplyer*$plan_counter)." months" .($student->fee_generation_date)."<br/>";*/
                                //echo $student->fee_generation_date.'  '.$fee_generation_date."<br/>";exit;

                                $fetch_std_data_query = FeeHeads::find()->select([
                                    'fpm.time_span time_span',
                                    'fee_heads.id as fee_head_id',
                                    'fee_heads.title',
                                    'fee_heads.promotion_head',
                                    'fee_heads.discount_head_status as discount_head_status',
                                    'fee_heads.one_time_only as one_time',
                                    'fee_heads.description',
                                    'fg.amount head_amount',
                                    'fg.is_active',
                                    'rc.title as class',
                                    'rg.title as group'
                                ])
                                    ->innerJoin('fee_payment_mode fpm','fpm.id=fee_heads.fk_fee_method_id')
                                    ->leftJoin('fee_group fg','fg.fk_fee_head_id=fee_heads.id')
                                    ->innerJoin('ref_class rc','rc.class_id=fg.fk_class_id')
                                    ->leftJoin('ref_group rg','rg.group_id=fg.fk_group_id')
                                    ->where(['fg.is_active'=>'yes','rc.class_id'=>$student->class_id,'rg.group_id'=>($student->group_id)?$student->group_id:null])->asArray()->all();


                                $i=1;
                                $sum_total       = 0;
                                $amount          = 0;
                                $transport_amt   = 0;
                                $transport_fare  = 0;
                                $discount_amount = 0;
                                $hostel_fare     = 0;
                                $transport_hostel_received=[];
                                $arrears= 0;
                                foreach ($fetch_std_data_query as $items){

                                    $fee_challan_record = \app\models\FeeChallanRecord::find()->where(['fk_stu_id'=>$student->stu_id,'fk_fee_plan_id'=>$fee_plan_type->id ,'fk_head_id'=>$items['fee_head_id'],'status'=>1])->one();

                                    $feeHeadWise_received = \app\models\FeeParticulars::find()
                                        ->innerJoin('fee_head_wise fhw','fhw.fk_fee_particular_id = fee_particulars.id')
                                        ->where([
                                            'fee_particulars.fk_branch_id'        => Yii::$app->common->getBranch(),
                                            'fee_particulars.fk_stu_id'           => $student->stu_id,
                                            'fee_particulars.fk_fee_plan_type'    => $fee_plan_type->id,
                                            'fee_particulars.fk_fee_head_id'      => $items['fee_head_id'],
                                            'fhw.fk_chalan_id'                    => $fee_challan_record->challan_id
                                        ])
                                        ->sum('fhw.payment_received');
                                   /* echo 'head_amount'.$fee_challan_record->head_amount."<br/>";
                                    echo $feeHeadWise_received."<br/>";*/
                                    /*student head discount*/
                                    $discountAmount = \app\models\FeeDiscounts::find()
                                        ->where([
                                            'fk_branch_id'        => Yii::$app->common->getBranch(),
                                            'fk_stud_id'          => $student->stu_id,
                                            'fk_fee_head_id'      => $items['head_id']
                                        ])->one();

                                    /*transport fee paid or not if availble.*/
                                    $transport_hostel_received = \app\models\FeeHeadWise::find()
                                        ->select(['transport_fare','hostel_fee'])
                                        ->where([
                                            'fk_branch_id'              => Yii::$app->common->getBranch(),
                                            'fk_chalan_id'              => $feeHeadWise_received->challan_id,
                                            'fk_stu_id'                 => $student->stu_id,
                                        ])->asArray()->one();

                                    if(!empty($fee_challan_record)){
                                        //echo 'challan record'.$fee_challan_record->head_amount.'head_id'.$items['head_id'];
                                        /*if head is availabel head amount will be shown from fee challan record.*/
                                        $amount = $fee_challan_record->head_amount;
                                    }else {
                                        if ($items['one_time'] == 1) {
                                            $amount = 0;
                                        } else {
                                            if ($total_multiplyer > 0) {
                                                $amount = $items['head_amount'] * ($items['time_span'] * $total_multiplyer) / $fee_plan_type->no_of_installments;

                                            } else {
                                                if ($items['time_span'] == 1) {
                                                    if ($items['promotion_head'] == 1) {
                                                        $stu_reg_log = \app\models\StuRegLogAssociation::find()->where(['fk_stu_id' => $student->stu_id, 'fk_branch_id' => Yii::$app->common->getBranch()])->count();
                                                        if ($stu_reg_log > 0) {
                                                            $amount = $items['head_amount'] * $items['time_span'];
                                                        } else {
                                                            $amount = 0;
                                                        }
                                                    } else {
                                                        //$amount = $items['head_amount'] * $items['time_span'];

							$amount = 0;
                                                    }
                                                } else {

                                                    $amount = $items['head_amount'] * $items['time_span'] / $fee_plan_type->no_of_installments;
                                                }
                                            }
                                        }
                                    }
                                    /*new heads*/
                                    if($items['one_time'] == 1){
                                        $new_head_amount = 0;
                                    }else{
                                        //if $total_multiplyer is greater than 0  means months due amount is more than the current plan
                                        if($total_multiplyer > 0){
                                            if($items['time_span']==1){
                                                if($items['promotion_head']==1){
                                                    $stu_reg_log = \app\models\StuRegLogAssociation::find()->where(['fk_stu_id'=>$student->stu_id,'fk_branch_id'=>Yii::$app->common->getBranch()])->count();
                                                    if($stu_reg_log > 0){
                                                        $new_head_amount = $items['head_amount']*$items['time_span'];
                                                    }else{
                                                        $new_head_amount = 0;
                                                    }
                                                }else{
                                                    //$new_head_amount = $items['head_amount']*$items['time_span'];
						    $new_head_amount = 0;
                                                }
                                            }else{
                                                $new_head_amount = $items['head_amount']* ($items['time_span']*$total_multiplyer)/$fee_plan_type->no_of_installments;
                                            }
                                        }
                                    }
                                    //echo $amount.'<br/>';
                                    /*if total headwise receive is not empty it will diduct tht total recieved amount from total along with head discount*/
                                    if($feeHeadWise_received !=''){
                                        $amount =   $amount - $feeHeadWise_received;

                                        if( $amount > 0) {
                                            if (!empty($items['discount_amount'])) {
                                                $amount = $amount - $items['discount_amount'];
                                                $discount_amount = $discount_amount + $items['discount_amount'];
                                            }
                                        }

                                        if(!empty($fee_challan_record->arrears)){
                                            $amount = $amount + $fee_challan_record->arrears;
                                        }

                                    }else{
                                        if(!empty($items['discount_amount'])){
                                            $amount = $amount - $items['discount_amount'];
                                            $discount_amount = $discount_amount + $items['discount_amount'];
                                        }
                                        if  (!empty($fee_challan_record->arrears)){
                                            $amount = $amount + $fee_challan_record->arrears;
                                        }
                                    }

                                    /*after diduction*/

                                    $amount= $amount + $new_head_amount;

                                    $store_array_particular[$student->stu_id][] =[
                                        'fee_plan_id'=>$fee_plan_type->id ,
                                        'stu_id'=>$student->stu_id,
                                        'head_id'=>$items['fee_head_id'],
                                        'total_amount'=>$amount,
                                        //'arrears'=>($fee_challan_record->arrears)?$fee_challan_record->arrears:0
                                    ];
                                    /*$items['amount'].' '.$items['no_months'].' '.$fee_plan_Model->no_of_installments;*/

                                    $sum_total= $sum_total + $amount;

                                }


                                /* if student hostel is applicatble hostel_fare*/
                                if(!empty($stop_id) && $is_month_metured === 1){
                                    $stopModel = Stop::findOne($stop_id);
                                    $transport_fare  = $stopModel->fare;
                                }else{
                                    $transport_fare = $fee_challan_record->fare_amount - $transport_hostel_received['transport_fare'];
                                }



                                /*hostel transport*/
                                if($is_hostel_avail  && $is_month_metured ===1){
                                    $hostelDetail = HostelDetail::find()
                                        ->select('h.amount amount')
                                        ->innerJoin('hostel h','h.id=hostel_detail.fk_hostel_id')
                                        ->where(['hostel_detail.fk_branch_id'=>Yii::$app->common->getBranch(),'hostel_detail.fk_student_id'=>$student->stu_id])->asArray()->one();
                                    $hostel_fare = $hostelDetail['amount'];
                                }else{
                                    $hostel_fare = $fee_challan_record->hostel_fare-$transport_hostel_received['hostel_fee'];
                                }

                               /* echo "hostel :".$hostel_fare."transport :".$transport_fare."<br/>";
                                echo "<pre>";
                                print_r($store_array_particular);
                                if($student->stu_id ==1113){exit;}else{continue;}*/

                                //echo $sum_total.' transport: '.$transport_fare.' discount_amount: '.$discount_amount.'<br/>';
                                /*inactive previous challan from FTD, FCP And Fee Challan Record.*/
                                $update_challan_inactive = "UPDATE fee_transaction_details  SET status = 0 WHERE fk_branch_id = ".Yii::$app->common->getBranch()." and stud_id =".$student->stu_id;
                                $update_fee_collection = "UPDATE fee_collection_particular  SET is_active = 0 WHERE fk_branch_id = ".Yii::$app->common->getBranch()." and fk_stu_id =".$student->stu_id;
                                $update_fee_challan_rec = "UPDATE fee_challan_record  SET status = 0 WHERE fk_branch_id = ".Yii::$app->common->getBranch()." and fk_stu_id =".$student->stu_id;
                                \Yii::$app->db->createCommand($update_challan_inactive)->execute();
                                \Yii::$app->db->createCommand($update_fee_collection)->execute();
                                \Yii::$app->db->createCommand($update_fee_challan_rec)->execute();

                                $feeCollectionPartModel = new FeeCollectionParticular();
                                $feeCollectionPartModel->fk_branch_id      =  Yii::$app->common->getBranch();
                                $feeCollectionPartModel->fk_stu_id         =  $student->stu_id;//$model->stu_id;
                                $feeCollectionPartModel->total_fee_amount  =  round($sum_total,0);
                                $feeCollectionPartModel->transport_fare    =  ($transport_fare > 0)?$transport_fare:null;
                                $feeCollectionPartModel->hostel_fare       =  ($hostel_fare > 0)?$hostel_fare:null;
                                $feeCollectionPartModel->discount_amount   =  ($discount_amount >0)?$discount_amount:null;
                                $feeCollectionPartModel->fee_payable       =  round($sum_total+$transport_fare+$hostel_fare,0);
                                $feeCollectionPartModel->due_date          =  $due_date;
                                if(!$feeCollectionPartModel->save()){print_r($feeCollectionPartModel->getErrors());};

                                /*fee transection details*/
                                $feeTransectionModel       =  new FeeTransactionDetails();
                                $feeTransectionModel->fk_branch_id = Yii::$app->common->getBranch();
                                $feeTransectionModel->stud_id = $student->stu_id;
                                $feeTransectionModel->fk_fee_collection_particular = $feeCollectionPartModel->id;
                                $feeTransectionModel->transaction_date = null;
                                $feeTransectionModel->transaction_amount = null;
                                $feeTransectionModel->opening_balance = round($feeCollectionPartModel->fee_payable,0);
                                $feeTransectionModel->status = 1;
                                if(!$feeTransectionModel->save()){print_r($feeTransectionModel->getErrors());exit;};

                                /*populate monthly fee challan record*/
                                /*
                                 * echo "<pre>";
                                    print_r($store_array_particular[$student->stu_id]);
                                    exit;
                                */

                                foreach($store_array_particular[$student->stu_id] as $std_monthly_challan_rec){
                                    $fee_challan_recordModel = New FeeChallanRecord();
                                    $fee_challan_recordModel->challan_id         = $feeTransectionModel->id;
                                    $fee_challan_recordModel->fk_stu_id          = $std_monthly_challan_rec['stu_id'];
                                    $fee_challan_recordModel->fk_fee_plan_id     = $std_monthly_challan_rec['fee_plan_id'];
                                    $fee_challan_recordModel->fk_head_id         = $std_monthly_challan_rec['head_id'];
                                    $fee_challan_recordModel->head_amount        = round($std_monthly_challan_rec['total_amount'],0);
                                    //$fee_challan_recordModel->arrears          = round($std_monthly_challan_rec['arrears'],0);
                                    $fee_challan_recordModel->fare_amount        = ($transport_amt > 0)?$transport_amt:null;;
                                    $fee_challan_recordModel->hostel_fare        = ($hostel_fare > 0)?$hostel_fare:null;;
                                    if(!$fee_challan_recordModel->save()){print_r($fee_challan_recordModel->getErrors());exit;}

                                }

                                /*query here*/
                                $std_discount = \app\models\FeeDiscounts::find()->where(['fk_stud_id'=>$student->stu_id,'is_active'=>1])->count();

                                if($std_discount >0){
                                    $where = [
                                        'ftd.fk_branch_id' => Yii::$app->common->getBranch(),
                                        'st.class_id'=>$student->class_id,
                                        'ftd.stud_id' =>$student->stu_id ,
                                        'ftd.id' => $feeTransectionModel->id,
                                        'fcr.status' => 1,
                                        'fd.is_active' => 1
                                    ];
                                }else{
                                    $where = [
                                        'ftd.fk_branch_id' => Yii::$app->common->getBranch(),
                                        'st.class_id'=>$student->class_id,
                                        'ftd.stud_id' =>$student->stu_id ,
                                        'ftd.id' => $feeTransectionModel->id,
                                        'fcr.status' => 1
                                    ];
                                }
                                $query = FeePaymentMode::find()
                                    ->select([
                                        'fcp.discount_amount discount_amount',
                                        'fcp.transport_fare fcp_transport_fare',
                                        'fcp.fee_payable fee_payable',
                                        'fcp.total_fee_amount',
                                        'fee_payment_mode.time_span no_months',
                                        'fee_payment_mode.title payment_mode',
                                        'fh.title fee_head',
                                        'fh.id as fee_head_id',
                                        'fh.description fee_description',
                                        'fcr.head_amount fee_head_amount',
                                        'fdt.title fee_discount_type',
                                        'ftd.id chalan_id',
                                        'fdt.description fee_discount_description',
                                        'fd.amount head_discount',
                                        's.fare transport_fare'
                                    ])
                                    ->innerJoin('fee_heads fh', 'fh.fk_fee_method_id = fee_payment_mode.id')
                                    ->innerJoin('fee_challan_record fcr','fcr.fk_head_id = fh.id')
                                    ->innerJoin('student_info st', 'st.stu_id = fcr.fk_stu_id')
                                    ->leftJoin('fee_discounts fd','fd.fk_fee_head_id=fh.id and fd.fk_stud_id=st.stu_id')
                                    ->leftJoin('fee_discount_types fdt', 'fdt.id = fd.fk_fee_discounts_type_id')
                                    ->leftJoin('stop s', 's.id=st.fk_stop_id')
                                    ->innerJoin('fee_transaction_details ftd', 'ftd.stud_id=st.stu_id')
                                    ->innerJoin('fee_collection_particular fcp', 'fcp.id = ftd.fk_fee_collection_particular')
                                    ->where($where)->asArray()->all();




                                //generate PDF of challan
                                $chalan_monthly_html = $this->render('get-monthly-chalan-pdf', [
                                    'student' => $student,
                                    'due_date'=> $feeCollectionPartModel->due_date,
                                    'challan_no'=> $feeTransectionModel->challan_no,
                                    'plan_title'=>$fee_plan_type->title,
                                    'no_of_installments'=>$fee_plan_type->no_of_installments,
                                    'plan_id'=>$fee_plan_type->id,
                                    'student_name'=>Yii::$app->common->getName($student->user_id),
                                    'query'=>$query,
                                    'transport_fare'=>$transport_fare,
                                    'hostel_fare'=>$hostel_fare,
                                    'sundry_account'=>$hostel_fare,
                                    'sundry_account'=>$sundry_account,
                                    'sundry_hosel_transport'=>$sundry_hostel_tansport
                                ]);
                                $student->fee_generation_date = $fee_generation_date;
                                if($is_month_metured ==1){
                                    $student->monthly_fee_gen_date = date('Y-m-d');
                                }
                                if(!$student->save(false)){echo "<pre>";print_r($student->getErrors());exit;};

                                //fee challan will generate here
                                $mpdf->AddPage();
                                $mpdf->WriteHTML($chalan_monthly_html);

                                $i++;
                            }
                            else{

                                /*download current active forms.*/
                                $feeTransectionModel_cur    = \app\models\FeeTransactionDetails::findOne(['stud_id'=>$student->stu_id,'status'=>1]);
                                $feeheadwise_received       = \app\models\FeeHeadWise::find()->select('payment_received')->where(['fk_chalan_id'=>$feeTransectionModel_cur->id,'fk_branch_id'=>Yii::$app->common->getBranch()])->sum('payment_received');
                                $feecollectionModel         = \app\models\FeeCollectionParticular::findOne(['id'=>$feeTransectionModel_cur->fk_fee_collection_particular,'is_active'=>1]);
                                $transport_amt   = 0;
                                $discount_amount = 0;
                                /*query here*/
                                if(count($feeTransectionModel_cur) > 0){
                                    $std_discount = \app\models\FeeDiscounts::find()->where(['fk_stud_id'=>$student->stu_id,'is_active'=>1])->count();

                                    if($std_discount >0){
                                        $where = [
                                            'ftd.fk_branch_id' => Yii::$app->common->getBranch(),
                                            'st.class_id'=>$student->class_id,
                                            'ftd.stud_id' =>$student->stu_id ,
                                            'ftd.id' => $feeTransectionModel_cur->id,
                                            'fcr.status' => 1,
                                            'fd.is_active' => 1
                                        ];
                                    }else{
                                        $where = [
                                            'ftd.fk_branch_id' => Yii::$app->common->getBranch(),
                                            'st.class_id'=>$student->class_id,
                                            'ftd.stud_id' =>$student->stu_id ,
                                            'ftd.id' => $feeTransectionModel_cur->id,
                                            'fcr.status' => 1
                                        ];
                                    }
                                    $query = FeePaymentMode::find()
                                        ->select([
                                            'fcp.discount_amount discount_amount',
                                            'fcp.transport_fare fcp_transport_fare',
                                            'fcp.fee_payable fee_payable',
                                            'fcp.total_fee_amount',
                                            'fee_payment_mode.time_span no_months',
                                            'fee_payment_mode.title payment_mode',
                                            'fh.title fee_head',
                                            'fh.id as fee_head_id',
                                            'fh.description fee_description',
                                            'fcr.head_amount fee_head_amount',
                                            'fdt.title fee_discount_type',
                                            'ftd.id chalan_id',
                                            'fdt.description fee_discount_description',
                                            'fd.amount head_discount',
                                            's.fare transport_fare'
                                        ])
                                        ->innerJoin('fee_heads fh', 'fh.fk_fee_method_id = fee_payment_mode.id')
                                        ->innerJoin('fee_challan_record fcr','fcr.fk_head_id = fh.id')
                                        ->innerJoin('student_info st', 'st.stu_id = fcr.fk_stu_id')
                                        ->leftJoin('fee_discounts fd','fd.fk_fee_head_id=fh.id and fd.fk_stud_id=st.stu_id')
                                        ->leftJoin('fee_discount_types fdt', 'fdt.id = fd.fk_fee_discounts_type_id')
                                        ->leftJoin('stop s', 's.id=st.fk_stop_id')
                                        ->innerJoin('fee_transaction_details ftd', 'ftd.stud_id=st.stu_id')
                                        ->innerJoin('fee_collection_particular fcp', 'fcp.id = ftd.fk_fee_collection_particular')
                                        ->where($where)->asArray()->all();

                                    //generate PDF of challan
                                    $chalan_monthly_html = $this->render('get-monthly-chalan-pdf', [
                                        'student' => $student,
                                        'due_date'=> $feecollectionModel->due_date,
                                        'challan_no'=> $feeTransectionModel_cur->challan_no,
                                        'challan_id'=> $feeTransectionModel_cur->id,
                                        'plan_title'=>$fee_plan_type->title,
                                        'no_of_installments'=>$fee_plan_type->no_of_installments,
                                        'student_name'=>Yii::$app->common->getName($student->user_id),
                                        'plan_id'=>$fee_plan_type->id,
                                        'query'=>$query,
                                        'feeheadwise_received'=>$feeheadwise_received,
                                        'transport_fare'=>$transport_amt,
                                        'hostel_fare'=>$hostel_fare,
                                        'sundry_account'=>$hostel_fare,
                                        'sundry_account'=>$sundry_account,
                                        'sundry_hosel_transport'=>$sundry_hostel_tansport
                                    ]);

                                    //fee challan will generate here
                                    $mpdf->AddPage();
                                    $mpdf->WriteHTML($chalan_monthly_html);
                                }
                            }
                        }
                    }
                    $mpdf->Output('Student-monthly-challan-'.date('Y-m-d H:i:s').'.pdf', 'D');
                    return $this->redirect('generate-fee-challan');
                }
                else{

                    Yii::$app->session->setFlash('warning',"There's no active students in this class at the moment.");
                    return $this->redirect('generate-fee-challan');
                }




            }
        }
    }
    function getFeeDetails($query,$feeTranscModel,
                                    $student_data,
                                    $fee_plan_Model,
                                    $transport_fare,
                                    $hostel_fare,
                                    $transport_hostel_received,
                                    $challan_id,
                                    $due_date,
                                    $challan_type,
                                    $is_month_metured,
                                    $fee_generation_date,
                                    $total_multiplyer,
                                    $sundry_account,
                                    $sundry_hosel_transport){
                                            $exteraHeadArrayMap = \app\models\FeeHeads::find()->select(['id','title'])->where(['fk_branch_id'=>Yii::$app->common->getBranch(),'extra_head'=>1])->asArray()->all();
                                            $discount_type= ArrayHelper::map(\app\models\FeeDiscountTypes::find()->where(['fk_branch_id'=>Yii::$app->common->getBranch(),'is_active'=>1])->all(),'id','title');
                                    if(count($sundry_account) > 0 ) {
                                        $sundary_list= ArrayHelper::map($sundry_account,'fk_head_id','total_advance_bal');
                                    }
                                    ?>
 
 
            <?php
            $i=1;
            $sum_total= 0;
            $new_head_amount= 0;
            $net_total_amt=0;
            $amount=0;
            $transport_amt=0;
            $total_discount = 0;
            $remaining_amount=0;
            $totalHeadAmt_without_currency =0;
            $total_advance_amount = 0;
            $total_remaining_advance_amount = 0;
            $head_advance = 0;
            $remaining_advance = 0;
            $store_array_particular=[];
            $fee_challan_record ='';
            $custom_ext_head_arr=[];
 
            if($challan_id){
                $extraheads = \app\models\FeeChallanRecord::find()
                    ->select([
                        'fh.title',
                        'fh.id head_id',
                        'fee_challan_record.head_amount',
                        'fee_challan_record.arrears'
                    ])
                    ->innerJoin('fee_heads fh','fh.id=fee_challan_record.fk_head_id')
                    ->where([
                        'fee_challan_record.fk_stu_id'=>$student_data->stu_id,
                        'fee_challan_record.fk_fee_plan_id'=>$fee_plan_Model->id,
                        'fh.extra_head'=>1,
                        'fee_challan_record.status'=>1
                    ])->asArray()->all();
            }
            foreach ($query as $items){
                $fee_challan_record ='';
                if($challan_id){
                    $fee_challan_record = \app\models\FeeChallanRecord::find()->where(['fk_stu_id'=>$student_data->stu_id,'fk_fee_plan_id'=>$fee_plan_Model->id,'fk_head_id'=>$items['head_id'],'status'=>1])->one();
                }
                /*total head wise received till date.*/
                $feeHeadWise_received = \app\models\FeeHeadWise::find() 
                    ->where([
                        'fee_head_wise.fk_branch_id'        => Yii::$app->common->getBranch(),
                        'fee_head_wise.fk_stu_id'           => $student_data->stu_id,
                        //'fee_head_wise.fk_fee_plan_type'  => $fee_plan_Model->id,
                        'fee_head_wise.fk_fee_head_id'      => $items['head_id'],
                        'fee_head_wise.fk_chalan_id'        => $challan_id
                    ])
                    ->sum('fee_head_wise.payment_received'); 

                /*student head discount*/
                $discountAmount = \app\models\FeeDiscounts::find()
                    ->where([
                        'fk_branch_id'        => Yii::$app->common->getBranch(),
                        'fk_stud_id'          => $student_data->stu_id,
                        'fk_fee_head_id'      => $items['head_id']
                    ])->one();
                if(!empty($fee_challan_record)){
                    //echo 'challan record'.$fee_challan_record->head_amount.'head_id'.$items['head_id'];
                    /*if head is availabel head amount will be shown from fee challan record.*/
                    $amount = $fee_challan_record->head_amount; 
                    $totalHeadAmt_without_currency  =  $amount;
                }else{
                    //echo 'totalamount:'.$amount.'head_id'.$items['head_id']."<br/>";
                    /**********************************************************************************/
                    /**                if Challan type is new means plan is metured                  **/
                    /**********************************************************************************/
                    if($challan_type =='new'){
                        /*if fee challan record amount is empoty that it will get head amount from actual heads.*/
                        if($items['one_time'] == 1){
                            //$amount = $items['amount']* $items['no_months'];
                        $amount = 0; 
                            $totalHeadAmt_without_currency  =  $amount;
                        }else{
                            if($total_multiplyer > 0){

                                if($items['no_months']==1){
                                    if($items['promotion_head']==1){
                                        $stu_reg_log = \app\models\StuRegLogAssociation::find()->where(['fk_stu_id'=>$student_data->stu_id,'fk_branch_id'=>Yii::$app->common->getBranch()])->count();
                                        if($stu_reg_log > 0){
                           if($feeHeadWise_received>0){
                                                $amount = 0;
                        }else{
                            $amount  = $amount = $items['amount']* $items['no_months'];
                        } 
 
                                        }else{
                                            $amount = 0;
                                        }
                                    }else{
                                        //$amount = $items['amount']*$items['no_months'];
                        if($feeHeadWise_received>0){
                                                $amount = 0;
                        }else{
                            $amount  = $amount = $items['amount']* $items['no_months'];
                        }

                                    }
                                }else{
                                    $amount = $items['amount']* ($items['no_months']*$total_multiplyer)/$fee_plan_Model->no_of_installments;
                                }
                            }else{
                                $amount = $items['amount']*$items['no_months']/$fee_plan_Model->no_of_installments;
                            }
                            $totalHeadAmt_without_currency  =  $amount;

                        }
                    }
                    else{
                        if($items['one_time'] == 1){
                            //$amount = $items['amount']* $items['no_months'];
                            $amount =0;
                            $totalHeadAmt_without_currency  =  $amount;
                        }else{
                            if($total_multiplyer > 0){
                                $amount = $items['amount']* ($items['no_months']*$total_multiplyer)/$fee_plan_Model->no_of_installments;
                            }else{
                                if($items['no_months']==1){
                                    if($items['promotion_head']==1){
                                        $stu_reg_log = \app\models\StuRegLogAssociation::find()->where(['fk_stu_id'=>$student_data->stu_id,'fk_branch_id'=>Yii::$app->common->getBranch()])->count();
                                       if($stu_reg_log > 0){
                                           //$amount = $items['amount']*$items['no_months'];
                                            $amount = 0;
                                       }else{
                                           $amount = 0;
                                       }
                                    }else{
                                        //$amount = $items['amount']*$items['no_months'];
                    $amount = 0;
                                    }
                                }else{
                                    $amount = $items['amount']*$items['no_months']/$fee_plan_Model->no_of_installments;
                                }
                            }
                            $totalHeadAmt_without_currency  =  $amount;

                        }
                        //echo "old ".$items['title']."<br/>";
                        //$amount = $items['amount']*$items['no_months']/$fee_plan_Model->no_of_installments;
                        //$totalHeadAmt_without_currency  =  $amount;
                    }
                }


                /*if total headwise receive is not empty it will diduct tht total recieved amount from total along with head discount*/
                if($feeHeadWise_received !=''){
                    //$totalHeadAmt_without_currency =   $item['fee_head_amount']-$feeHeadWise_received - $item['head_discount'];
                    //$totalHeadAmt_without_currency =   round($amount,0) -$feeHeadWise_received - $item['head_discount'];
                    $totalHeadAmt_without_currency =   round($amount,0) - $feeHeadWise_received;

                    if($challan_type =='new'){

                        if( $totalHeadAmt_without_currency > 0){
                            if(count($discountAmount) > 0 ){
                                $totalHeadAmt_without_currency =   $totalHeadAmt_without_currency - $discountAmount->amount;
                            }
                        }

                    }

                    if(!empty($fee_challan_record->arrears)){
                        $totalHeadAmt_without_currency = $totalHeadAmt_without_currency + $fee_challan_record->arrears;
                    }


                }
                else{
                    if($challan_type =='new') {

                        if (count($discountAmount) > 0 && $items['no_months'] != 1) {
                            $totalHeadAmt_without_currency = (round($amount, 0) - $discountAmount->amount);
                            $total_discount = $total_discount + $discountAmount->amount;

                        }
                    }else {
                        if (isset($discountAmount)) {
			    if(round($amount, 0)>0){
                              $total_discount = $total_discount + $discountAmount->amount;
			    } 
                        }
                    }
                    if  (!empty($fee_challan_record->arrears)){
                        $totalHeadAmt_without_currency = $totalHeadAmt_without_currency + $fee_challan_record->arrears;
                    }
                }

                //$remaining_amount = $remaining_amount + $totalHeadAmt_without_currency;
                /**********************************************************************************/
                /**                if Challan type is new means plan is metured                  **/
                /**                the following code will run if backdated or fee is metured    **/
                /**********************************************************************************/
                if($challan_type =='new' && $is_month_metured ==1){
                     if($items['one_time'] == 1){
                         $new_head_amount = 0;
                     }else{
                         //if $total_multiplyer is greater than 0  means months due amount is more than the current plan
                         if($total_multiplyer > 0){
                             if($items['no_months']==1){
                                 if($items['promotion_head']==1){
                                     $stu_reg_log = \app\models\StuRegLogAssociation::find()->where(['fk_stu_id'=>$student_data->stu_id,'fk_branch_id'=>Yii::$app->common->getBranch()])->count();
                                     if($stu_reg_log > 0){
                                         //$amount = $items['amount']*$items['no_months'];
                     $amount = 0;
                                     }else{
                                         $amount = 0;
                                     }
                                 }else{
                                     //$amount = $items['amount']*$items['no_months'];
                    $amount = 0;
                                 }
                             }else{
                                 $amount = $items['amount']* ($items['no_months']*$total_multiplyer)/$fee_plan_Model->no_of_installments;
                                  if (count($discountAmount) > 0 && $items['no_months'] != 1) {
                            		$amount = (round($amount, 0) - $discountAmount->amount);  

                        	 }

                             }
                             $new_head_amount = $amount;
                         }else{
                             if($items['no_months']==1){
                                 if($items['promotion_head']==1){
                                     $stu_reg_log = \app\models\StuRegLogAssociation::find()->where(['fk_stu_id'=>$student_data->stu_id,'fk_branch_id'=>Yii::$app->common->getBranch()])->count();
                                     if($stu_reg_log > 0){
                                         //$amount = $items['amount']*$items['no_months'];
$amount =0;
                                     }else{
                                         $amount = 0;
                                     }
                                 }else{
                                     //$amount = $items['amount']*$items['no_months'];
                    $amount = 0;
                                 }
                             }else{
                                 $amount = $items['amount']*$items['no_months']/$fee_plan_Model->no_of_installments;
if (count($discountAmount) > 0 && $items['no_months'] != 1) {
                            		$amount = (round($amount, 0) - $discountAmount->amount);  

                        	 }

                             }
                             $new_head_amount = $amount;

                         }
                     }
 
                     $totalHeadAmt_without_currency =  $totalHeadAmt_without_currency+round($new_head_amount,0);


                }

                $sum_total= $sum_total+$totalHeadAmt_without_currency;

                //$store_array_particular[]= $items['head_id'];

                if($totalHeadAmt_without_currency > 0) {
                    $store_array_particular []=[
                'head_id'=>$items['head_id'],
                                'total_amount'=>round($totalHeadAmt_without_currency, 0),
                'fee_plan_id'=>$fee_plan_Model->id,
                'stu_id'=>$student_data->stu_id,
                'discount_amount'=>(count($discountAmount) > 0)?$discountAmount->amount:0 
                ];  
                        
                    $i++;
                }
                else{
           $store_array_particular []=[
                'head_id'=>$items['head_id'],
                                'total_amount'=>0,
                'fee_plan_id'=>$fee_plan_Model->id,
                'stu_id'=>$student_data->stu_id,
                'discount_amount'=>(count($discountAmount) > 0)?$discountAmount->amount:0 
                ];  
                     
                }

            }
            if(isset($extraheads) && count($extraheads )>0){
                foreach($extraheads as $ex_heads) {
                    /*total head wise received till date.*/
                    $ex_head_received=0;
                    $extra_head_receive = \app\models\FeeHeadWise::find()
                        ->where([
                            'fk_branch_id'        => Yii::$app->common->getBranch(),
                            'fk_stu_id'           => $student_data->stu_id,
                            'fk_fee_head_id'      => $ex_heads['head_id'],
                            'fk_chalan_id'        => $challan_id
                        ])
                        ->sum('payment_received');
                    if(!empty($extra_head_receive)){
                        $ex_head_received = $extra_head_receive;
                    }
                    if($ex_heads['head_amount'] - $ex_head_received > 0) {  
                                
                                $store_array_particular []=[
                        'head_id'=>$items['head_id'],
                                                'total_amount'=>round($ex_heads['head_amount'] + $ex_heads['arrears'] - $extra_head_receive, 0),
                        'fee_plan_id'=>$fee_plan_Model->id,
                        'stu_id'=>$student_data->stu_id
                ];
 
                    }
                    $sum_total = $sum_total+$ex_heads['head_amount']+$ex_heads['arrears']-$extra_head_receive;
                    $custom_ext_head_arr[] = $ex_heads['head_id'];
                    $i++;
                }
            }
            $net_total_amt = $sum_total;

            /**********************************************************************************/
            /**     23  if Challan type  is monthly means month is metured not plan          **/
            /**********************************************************************************/
            /*transprt received or not*/
            if(count($transport_hostel_received)>0){
                if (!empty($transport_hostel_received['transport_fare']) || $transport_hostel_received['transport_fare'] != null){
                    $transport_received = $transport_hostel_received['transport_fare'];
                }else{
                    $transport_received = 0;
                }

                /*hostel received or not*/
                if ($transport_hostel_received['hostel_fee']) {
                    $hostel_received = $transport_hostel_received['hostel_fee'];
                }else{
                    $hostel_received =0;
                }
            }
            else{
                $transport_received = 0;
                $hostel_received =0;
            }



            if($fee_challan_record){
                $old_hostel_fare = $fee_challan_record->hostel_fare - $hostel_received;
                $old_transport_fare = $fee_challan_record->fare_amount - $transport_received;
            }
            else{
                $old_hostel_fare = 0;
                $old_transport_fare = 0;
            }


            if($is_month_metured == 1){
                /*if transport fere is applicable than */
                if(!empty($transport_fare) || $transport_fare != null) {

                    if($transport_fare >0){
                        // echo 'in transport'.$transport_fare.'+'.$old_transport_fare."<br/>";
                        $transport_fare = $transport_fare+$old_transport_fare;
                    }
                    $net_total_amt = $sum_total+$transport_fare;
                }

                /*if hostel fare is applicable than*/
                if(!empty($hostel_fare) || $hostel_fare != null){
                    if($hostel_fare >0){
                        $hostel_fare = $hostel_fare+$old_hostel_fare;
                    }
                    $net_total_amt = $net_total_amt+$hostel_fare;
                }
            }
            else{
                /*if transport fere is applicable than */
                $registration_year = date('Y',strtotime($student_data->registration_date));
                $current_year = date('Y');
                //if($old_transport_fare == 0 && $registration_year >= $current_year) {
                if($old_transport_fare == 0 && $student_data->transport_updated ==0) {
                    $transport_fare = 0;
                    $net_total_amt = $sum_total+$transport_fare;
                }else{
                    $net_total_amt = $sum_total+$transport_fare;
                }


                /*if hostel fare is applicable than*/
                if($old_hostel_fare== 0 && $student_data->hostel_updated ==0){
                    $hostel_fare = 0;
                    $net_total_amt = $net_total_amt+$hostel_fare;
                }else{
                    $net_total_amt = $net_total_amt+$hostel_fare;
                }                //$net_total_amt = $sum_total+$old_transport_fare;
                //$net_total_amt = $net_total_amt+$old_hostel_fare;
            }

            /**********************************************************************************/
            /**     23  if Challan type  is monthly means month is metured not plan          **/
            /**********************************************************************************/


            /*total amount minus total discount.*/
           // echo 'payable  :'.$payable = $net_total_amt;
            
        if((!empty($transport_fare) || $transport_fare != null) && $transport_fare >0 ){
         //echo 'transport'.round($transport_fare,0);
         } 
 
                    if(count($sundry_hosel_transport) > 0 ) {
                        if($sundry_hosel_transport->transport_fare){
                            $total_advance_amount = $total_advance_amount + $sundry_hosel_transport->transport_fare;
                            ?>
                            <span>Rs. <?=$sundry_hosel_transport->transport_fare?></span>
                            <?php
                        }
                    } 
                    /*remaining transport*/
                    if(count($sundry_hosel_transport) > 0 ) {
                        if($sundry_hosel_transport->transport_fare){
                        ?>
                            <span>Rs. <?=$sundry_hosel_transport->transport_fare-$transport_fare?></span>
                        <?php
                        }
                    } 
             if((!empty($hostel_fare) || $hostel_fare != null) && $hostel_fare >0 ){
?>
        <input type="text" id="input_total_hostel_fare" class="form-control" name="StudentDisount[input_total_hostel_fare]" value="<?=$hostel_fare?>"  onkeyup="hostelAdjust(event,this);" data-totalhostl="<?=(!empty($hostel_fare) || $hostel_fare != null)?round($hostel_fare,0):0 ?>"aria-invalid="false" placeholder="<?=$hostel_fare?>" >
<?php
        }
/*hostel sundry remaining*/
if(count($sundry_hosel_transport) > 0 ) {
                        if($sundry_hosel_transport->hostel_fare){
                            $total_advance_amount = $total_advance_amount + $sundry_hosel_transport->hostel_fare;
                            ?>
                            <span>Rs. <?=$sundry_hosel_transport->hostel_fare?></span>
                            <?php
                        }
                    }
        if(!empty($total_discount) || $total_discount != null){
?>
<?php //echo 'RS.'.round($total_discount,0)?>
<?php

}
/*total amount payable*/
//echo "payable".round($net_total_amt,0);
  
 if(count($sundry_account) > 0 ) {

//Total Advance Payment
 //$total_advance_amount 
      
}       
  
$store_array_particular['total_head_amount']=[round($sum_total,0)];
$store_array_particular['transport_fare']=[$transport_fare];
$store_array_particular['hostel_fare']=[$hostel_fare];


return ($store_array_particular); 

    }
}
