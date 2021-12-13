<?php

namespace app\controllers;

use Yii;
use app\models\SalaryMain;
use app\models\User;
use app\models\search\SalaryMainSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use kartik\mpdf\Pdf;
use mPDF;
use yii\helpers\ArrayHelper;
use app\models\EmployeeAllowances;
use app\models\EmployeePayroll;
use app\models\EmployeeDeductions;
use app\models\EmployeeAttendance;
use app\models\LeaveSettings;

/**
 * SalaryMainController implements the CRUD actions for SalaryMain model.
 */
class SalaryMainController extends Controller
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

    public function actionSalarySettings(){
        return $this->render('salary-settings');
    }

    /**
     * Lists all SalaryMain models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new SalaryMainSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    
   

    /**
     * Displays a single SalaryMain model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new SalaryMain model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new SalaryMain();
       
         //echo '<pre>';print_r($_POST);die;
        //$salry_array=yii::$app->request->post();die;

       

        if ($model->load(Yii::$app->request->post())) {
           $model->absent_deduction=$_POST['SalaryMain']['absent_deduction'];
           $model->total_after_alowed_leaves=$_POST['SalaryMain']['total_after_alowed_leaves'];
            
            if($model->save()){
                
            }else{
                print_r($model->getErrors());die;
            }
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }
    
     public function actionCreateMpdf(){
        $id=Yii::$app->request->get('salary_id');
        
        $this->layout = 'pdf';
         $mpdf=new mPDF();
        
         $mpdf->WriteHTML($this->renderPartial('generatePdf', [
            'model' => $this->findModel($id),
         ]));

        //$mpdf->Output();
        $mpdf->Output('employee-salary.pdf', 'D');

    }
    

    /**
     * Updates an existing SalaryMain model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing SalaryMain model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the SalaryMain model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return SalaryMain the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = SalaryMain::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionLeaveDepartment(){
         $model = new SalaryMain();
       return $this->render('leave-department',['model'=>$model]);
    }


    /*====== get warden on basis of department====*/
    public function actionGetEmployee(){

            $id=Yii::$app->request->post('id');

            $warden = User::find()
            ->select(['employee_info.emp_id',"concat(user.first_name, ' ' ,  user.last_name) as name"])
            ->innerJoin('employee_info','employee_info.user_id = user.id')
            ->where(['user.fk_role_id'=>4,'user.fk_branch_id'=>yii::$app->common->getBranch(),'status'=>'active','employee_info.department_type_id'=>$id])->asArray()->all();
            $stuArray = ArrayHelper::map($warden,'emp_id','name');
            //echo '<pre>';print_r($warden);die;

           // $warden= EmployeeInfo::find()->where(['fk_branch_id'=>yii::$app->common->getBranch(),'department_type_id'=>$id,'is_active'=>1])->all();
         
            $viewdepartment=$this->renderAjax('getemloyee-salary',['salry'=>$warden,'dep_id'=>$id]);
            return json_encode(['department'=>$viewdepartment]);
        
       }

   /*====== end of get warden on basis of department====*/

   /*====== show salary of employee====*/
    public function actionShowSalaryPay(){

     $model = new SalaryMain();
     $empid=Yii::$app->request->post('empid');

     $exist=SalaryMain::find()->where(['fk_emp_id'=>$empid])->one();

    if(count($exist)>0){
            //$e=$exist->fk_emp_id;
           $c_date=date('m');
           $mon=date('m',strtotime($exist->salary_month));
           if($c_date == $mon){
            $exist= 'This Employee has already been taken salary this month';

           }

          }


     $emply_alwnc = EmployeeAllowances::find()->where(['fk_emp_id'=>$empid,'status'=>1])->all();
     $payrollDeduction = EmployeeDeductions::find()->select(['fk_deduction_id'])->where(['fk_emp_id'=>$empid,'status'=>1])->All();
     $employee_payroll = EmployeePayroll::find()->where(['fk_emp_id'=>$empid])->one();
         
            $payrollView=$this->renderAjax('emp-payrollshow',['empid'=>$empid,'emply_alwnc'=>$emply_alwnc,'employee_payroll'=>$employee_payroll,'payrollDeduction'=>$payrollDeduction,'model'=>$model]);
            return json_encode(['payrollView'=>$payrollView,'exist'=>$exist]);
        
       }


       public function actionSavePayroll(){
             
         // $s=yii::$app->db->createCommand("select * from salary_main where salary_month between '".$fmonth."'")->queryOne();

       //echo '<pre>';print_r($s);die;
        
     $model = new SalaryMain();
     $model->fk_emp_id=Yii::$app->request->post('emp_id');
     $model->fk_pay_stages=$fk_pay_stages=Yii::$app->request->post('fk_pay_stages');
     $model->basic_salary=$basic_salary=Yii::$app->request->post('basic_salary');
     $model->gross_salary=$gross_salary=Yii::$app->request->post('gross_salary');
     $model->tax_amount=$tax_amount=Yii::$app->request->post('tax_amount');
     $model->salary_payable=$salary_payble=Yii::$app->request->post('salary_payble');
     $model->salary_month=$salary_month=Yii::$app->request->post('salary_month');
     $model->payment_date=$salary_date=Yii::$app->request->post('salary_date');
     $model->fk_tax_id=$tax_id=Yii::$app->request->post('tax_id');

     $model->absent_deduction=$tax_id=Yii::$app->request->post('absntdeduction');
     $model->total_after_alowed_leaves=$tax_id=Yii::$app->request->post('afterallowed');

     $curntDate= date('m');
         
     $salryMonth=date("m",strtotime(Yii::$app->request->post('salary_month')));

       
   
     //$exist=SalaryMain::find()->where(['fk_emp_id'=>Yii::$app->request->post('emp_id'),'salary_month'=>$salryMonth])->one();
     $exist=SalaryMain::find()->where(['fk_emp_id'=>Yii::$app->request->post('emp_id')])->one();


      $month=date('m',strtotime(Yii::$app->request->post('salary_month')));
      $year=date('Y',strtotime(Yii::$app->request->post('salary_month')));

      $fmonth=Yii::$app->request->post('salary_month');
     $s=yii::$app->db->createCommand("SELECT salary_month FROM salary_main Where fk_emp_id = ".Yii::$app->request->post('emp_id')." AND  MONTH(salary_month) = $month")->queryOne();
     //echo '<pre>';print_r($s);die;
       $monthx=date('Y/m',strtotime(Yii::$app->request->post('salary_month')));
     
      $g_datx=date('Y/m',strtotime($s['salary_month']));
     //echo $s['salary_month'];
   //  die;
     //echo $s;die;

     //$s=yii::$app->db->createCommand("SELECT * FROM salary_main WHERE MONTH(salary_month) = $month")->queryOne();
     
     if($monthx == $g_datx){
        
     //$dbDate=$exist->salary_month;
     //echo date('m',strtotime($dbDate));die;
    // if($dbDate){
            //$e=$exist->fk_emp_id;
          // $c_date=date('m');
           //$mon=date('m',strtotime($exist->salary_month));
          
            //Yii::$app->session->setFlash('warning',"This Employee Has Already Been Taken Salary This Month.");
            //Yii::$app->getSession()->setFlash('error', 'This Employee Has Already Been Taken Salary This Month.');
            //$exist= 'This Employee Has Already Been Taken Salary This Month';

           //return $errors;
            return json_encode(['errors'=>'This Employee Has Already Been Taken Salary This Month']);

        
        }else{
           
            //return json_encode(['suces'=>'Successfully Issued..!']);
        


          

     if($model->save()){

        $this->redirect(['create-mpdf-payroll','id'=>$model->id]);
        
     }else{
        print_r($model->getErrors());die;
     }

 }
 
     
        
       }



        public function actionCreateMpdfPayroll(){
        $id=Yii::$app->request->get('id');
        
        $this->layout = 'pdf';
         $mpdf=new mPDF();
        
         $mpdf->WriteHTML($this->renderPartial('generatePdf', [
            'model' => $this->findModel($id),
         ]));

        //$mpdf->Output();
        $mpdf->Output('employee-salary.pdf', 'D');

    }

   /*====== end of show salary of employee====*/



   /*generate monthly pay slip empoyee*/
   public function actionGenerateMonthlySalarySlip($id){
  
    
    //$store_array_particular=[];

   $employee = User::find()
            ->select(['employee_info.emp_id',"concat(user.first_name, ' ' ,  user.last_name) as name"])
            ->innerJoin('employee_info','employee_info.user_id = user.id')
            ->where(['user.fk_role_id'=>4,'user.fk_branch_id'=>yii::$app->common->getBranch(),'status'=>'active','employee_info.department_type_id'=>$id])->asArray()->all();
  $i=0;
    $this->layout = 'pdf';
    $mpdf = new mPDF('','', 0, '', 2, 2, 3, 3, 2, 2, 'A4');
  foreach ($employee as $getEmp) {
     $model = new SalaryMain();
     
   

     // count
     $employeeLeaveCount=EmployeeAttendance::find()->where(['fk_empl_id'=>$getEmp['emp_id'],'leave_type'=>'leave'])->all();
      $employeelatecomingCount=EmployeeAttendance::find()->where(['fk_empl_id'=>$getEmp['emp_id'],'leave_type'=>'latecomer'])->all();
     $employeeslCount=EmployeeAttendance::find()->where(['fk_empl_id'=>$getEmp['emp_id'],'leave_type'=>'shortleave'])->all();
     $employeeabsentCount=EmployeeAttendance::find()->where(['fk_empl_id'=>$getEmp['emp_id'],'leave_type'=>'absent'])->all();

     $levcount=count($employeeLeaveCount);
     $latecount=count($employeelatecomingCount);
     $slcount=count($employeeslCount);
     $absentcount=count($employeeabsentCount);
     $leavequery=LeaveSettings::find()->where(['branch_id'=>yii::$app->common->getBranch()])->one();
     $alowdLevs= $leavequery->allowed_leaves;
     $latecmrplcy= $leavequery->latecommer_policy;
     $shrtlevplcy= $leavequery->shortleave_policy;

     $ttlatecomng=$latecount/$latecmrplcy;
     $totlshrtlv=$slcount/$shrtlevplcy;

     $totlCountLeaves=round($levcount+$absentcount+$latecount+$slcount,2);
     $totlaftralwd=round($totlCountLeaves-$alowdLevs,2);
      // end of count
   $model->fk_emp_id=$getEmp['emp_id'];
   $model->salary_month=date('Y-m-d H:i:s');
   $model->payment_date=date('Y-m-d H:i:s');
   $employee_payroll = EmployeePayroll::find()->where(['fk_emp_id'=>$getEmp['emp_id']])->one();
   if(count($employee_payroll)>0){ 

     $model->basic_salary=$employee_payroll->basic_salary;
     $model->fk_pay_stages=$employee_payroll->fk_pay_stages;
     $gross=$model->gross_salary=$employee_payroll->total_amount;
     $perdaysalary=$employee_payroll->total_amount/30;

     $ttlaftralowd=round($totlCountLeaves-$alowdLevs,2);

     $absntdeductn=$model->absent_deduction=round($absntdeductnx=$ttlaftralowd*$perdaysalary,2);

     $model->is_paid=1;
     $model->salary_payable=$gross - $absntdeductn;

     $model->total_after_alowed_leaves=$totlCountLeaves-$alowdLevs;

     //generate PDF of challan
        
        
   if($model->save()){

    $empsalaryview= $this->renderPartial('generatePdf', [
            'model' => $this->findModel($model->id),
        ]);

     $mpdf->AddPage();
     $mpdf->WriteHTML($empsalaryview);
     $i++;
   

   }else{
    print_r($model->getErrors());die;
   }

   }// end of count
   
    
   } //end of foreach
     $mpdf->Output('emloyee-'.date('Y-m-d H:i:s').'.pdf', 'D');

    
   }

   /*end of generate monthly pay slip empoyee*/

   public function actionSalaryMonthMessage(){
    $date=yii::$app->request->post('date');
    $month=date('m',strtotime($date));
    $empid=yii::$app->request->post('empid');

    $compredate=yii::$app->db->createCommand("SELECT salary_month FROM salary_main Where fk_emp_id = ".$empid." AND  MONTH(salary_month) = $month")->queryOne();
    $monthx=date('Y/m',strtotime(Yii::$app->request->post('date')));
     
      $g_datx=date('Y/m',strtotime($compredate['salary_month']));
    if($monthx == $g_datx){
        return json_encode(['compredate'=>'This Employee has already been taken salary this month..!']);

    }else{
        return json_encode(['compredate'=>'']);


    }
    

   }


}  // end of main class
