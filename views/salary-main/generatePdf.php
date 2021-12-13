<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use app\models\EmployeePayroll;
use app\models\EmployeeAllowances;
use app\models\EmployeeDeductions;
use app\models\EmployeeParentsInfo;
use yii\helpers\Url;


/* @var $this yii\web\View */
/* @var $model app\models\SalaryMain */
$employee_payroll = EmployeePayroll::find()->where(['fk_emp_id'=>$model->fk_emp_id])->one();
$employee_parent = EmployeeParentsInfo::find()->where(['emp_id'=>$model->fk_emp_id])->one();

 
?>
<style>
tr.noBorder td {
  border: 0;
  border-bottom: 0;
}
table, td, th {
    border: 1px solid black;
    padding: 10px;
}

table {
    border-collapse: collapse;
    width: 100%;
}

th {
    height: 50px;
}
</style>
<div id="wrapper">
 <?php 

if(!empty(Yii::$app->common->getBranchDetail()->logo)){
    $logo = '/uploads/school-logo/'.Yii::$app->common->getBranchDetail()->logo;
}else{
    $logo = '/img/logo.png';
}
?>
<div class="container">
 <span><img src="<?= Url::to('@web').$logo ?>" alt="<?=Yii::$app->common->getBranchDetail()->name.'-logo'?>"></span>

 <h3 style="text-align: center;">Pay Slip For The Month Of <?php echo date('M Y',strtotime($model->salary_month)) ?></h3>
    
       

  </h3>
 

    <div>
      <strong>Name:  <?php echo $model->fkEmp->user->first_name?></strong><br />
      <strong>Father Name :<?php echo $employee_parent->first_name?></strong><br />
      <strong>Department :<?php echo $model->fkEmp->departmentType->Title?></strong><br />

      <strong>Designation :<?php echo $model->fkEmp->designation->Title?></strong><br />
      
      <strong>Group:  <?php echo $employee_payroll->fkGroup->title;?></strong><br />
      <strong>Stage:  <?php echo $model->fkPayStages->title?></strong><br />

    </div> 
               
            
  <table class="table">
    <thead>
      <tr>
        <th>Earnings</th>
        
        <th>Deductions</th>
      </tr>
    </thead>
    <tbody>
      <tr class="noBorder">
        <td class="noBorder">
        <label>Basic Salary</label> :<?php echo $model->basic_salary?>
          
        </td>
          


              <?php $payrollDeduction = EmployeeDeductions::find()->select(['fk_deduction_id'])->where(['fk_emp_id'=>$model->fk_emp_id,'status'=>1])->All();?>
              <?php 

              
              

                ?>
             <td>
               <?php
               foreach ($payrollDeduction as $deductn) {
                if(count($deductn)>0){
                  //echo '<pre>';print_r($alwnc);
                ?>
            <?php echo $deductn->fkDeduction->title; ?>
            <?php echo $deductn->fkDeduction->amount; ?>
             <?php }else{echo "N/A";}?> <br /> <?php } ?>
             
              </td>
         
             
             

             

            
        
      </tr>
      <tr class="noBorder">
      <?php $emply_alwnc = EmployeeAllowances::find()->where(['fk_emp_id'=>$model->fk_emp_id,'status'=>1])->all();?>
           
          
               <td style="border-top: 1px solid black; ">   
             <?php 
              foreach ($emply_alwnc as $alwnc) {
             if(count($alwnc)>0){
             echo $alwnc->fkAllownces->title .': '; 
             echo $alwnc->fkAllownces->amount; 
            }else{
            echo 'N/A';
                 }?><br /> <?php }?>
                 <strong>Total Allowance:</strong> <?php if(empty($employee_payroll->total_allownce)){echo "N/A";}else{echo $employee_payroll->total_allownce;} ?>
             </td>
             <td style="border-top: 1px solid black; ">
               
               <strong>Total Deduction: </strong><?php

         $total_deducn=$employee_payroll->total_deductions; 

        if($total_deducn = 0){
          echo "0";
           }else{
            echo $employee_payroll->total_deductions;};

         ?>
             </td>

        
       
        

      </tr>
      <tr>
        <td>
               <?php
         //$checkempSalarymain=salaryMain::find()->where(['fk_emp_id'=>$empid])->one();
         $a_deductn=round($model->absent_deduction);?>
        <strong>Absent Deduction</strong>
         <?php if($a_deductn == 0){echo $a_deductn="0";}else{echo $a_deductn;}?>
             </td>
              <td></td>
      </tr>
      <tr>
      <td>
         <!-- <strong>Net Salary: </strong> <?php //echo round($employee_payroll->total_allownce+$model->basic_salary - $model->absent_deduction);?> -->
         <strong>Net Salary: </strong> <?php echo round($model->salary_payable);?>
      </td>
      <td></td>
        
      </tr>
      
      
    </tbody>
  </table>
  <h5 style=" float: left;width: 65%; overflow: hidden;">Signature __________________</h5>
</div>
 
  
  


 

</div>

   
        
   