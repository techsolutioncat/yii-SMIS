<?php 
use app\models\EmployeeAttendance;
use app\models\employeeLeaveCount;
use app\models\LeaveSettings;
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use kartik\date\DatePicker;
use app\models\SalaryMain;
use app\models\EmployeeInfo;

     $employeeLeaveCount=EmployeeAttendance::find()->where(['fk_empl_id'=>$empid,'leave_type'=>'leave'])->all();
     $employeelatecomingCount=EmployeeAttendance::find()->where(['fk_empl_id'=>$empid,'leave_type'=>'latecomer'])->all();
     $employeeslCount=EmployeeAttendance::find()->where(['fk_empl_id'=>$empid,'leave_type'=>'shortleave'])->all();
     $employeeabsentCount=EmployeeAttendance::find()->where(['fk_empl_id'=>$empid,'leave_type'=>'absent'])->all();
 ?>
<div class="row">
<div class="col-sm-12">
<div class="erros" style="color: red"></div>
<div class="alert alert-success alert-dismissable" style="display:none" id="sucessubmit">
    <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
    
  </div>


  <table class="table">
    <thead>
    
      <tr class="success">
        
        <th>Group</th>
        <th>Stage</th>
        <th>Basic Salary:</th>
        <th>Gross Salary</th>
        
      </tr>
      <tr>
        
        <td><?php if(empty($employee_payroll->fkGroup->title)){echo "N/A";}else{echo $employee_payroll->fkGroup->title;} ?></td>
        <td><?php if(empty($employee_payroll->fkPayStages->title)){echo "N/A";}else{
          echo $employee_payroll->fkPayStages->title;?>
          <input type="hidden" id="fk_pay_stages" name="SalaryMain[fk_pay_stages]" value="<?= $employee_payroll->fk_pay_stages?>">
          <input type="hidden" id="fk_emp_id" name="SalaryMain[fk_emp_id]" value="<?= $empid;?>">
          <input type="hidden" id="basic_salary" name="SalaryMain[basic_salary]" value="<?= $employee_payroll->basic_salary;?>">
          <input type="hidden" id="gross_salary" name="SalaryMain[gross_salary]" value="<?= $employee_payroll->total_amount;?>">
         <?php } ?></td>
         <td><?php if(empty($employee_payroll->basic_salary)){echo "N/A";}else{echo $employee_payroll->basic_salary;} ?></td>
        <td><?php if(empty($employee_payroll->total_amount)){echo "N/A";}else{
          echo $employee_payroll->total_amount;?>
          <input type="hidden" id="salarymain-gross_salary" value="<?= $employee_payroll->total_amount;?>">
          <?php } ?></td>
        
      </tr>
    </thead>
    <tbody>
    </tbody>
    </table>
</div>

</div>
<div class="row">
	<div class="col-md-6">
<h3 style="text-align: center;">Allownces</h3>

 <table class="table">
    <thead>
    
      <tr>
        <th>Title</th>
        <th>Amount</th>
        
        
      </tr>
      <?php 
      	//print_r($emply_alwnc);
      if(count($emply_alwnc)>0){


      foreach($emply_alwnc as $alwnc){
      	?>
      <tr class="Info">
      	<td><?php echo $alwnc->fkAllownces->title; ?></td>
      	<td><?php echo $alwnc->fkAllownces->amount; ?></td>
      	
      </tr>
      <?php }  }else{?>
		<tr><th>N/A</th></tr>
      	<?php }?>

      	<tr>
      	<th>Total Allownces</th>
      		<td><?php if(!empty($employee_payroll->total_allownce)){echo $employee_payroll->total_allownce;}else{echo "N/A";};?></td>
      	</tr>




    </thead>
    <tbody>
    </tbody>
    </table>
    </div>
                                                    
<div class="col-md-6">
<h3 style="text-align: center;">Deductions</h3>
    <table class="table">
    <thead>
    
      <tr>
        <th>Title</th>
        <th>Amount</th>
        
        
      </tr>
      <?php 
      	//print_r($emply_alwnc);
if(count($payrollDeduction)>0){
      foreach($payrollDeduction as $deductn){
      	?>
      <tr>
      	<td><?php echo $deductn->fkDeduction->title; ?></td>
      	<td><?php echo $deductn->fkDeduction->amount; ?></td>
      	
      </tr>
      <?php } }else{?>
		<tr><th>N/A</th></tr>
      	<?php }?>

      	<tr>
      	<th>Total Deductions</th>
      		<td><?php if(!empty($employee_payroll->total_deductions)){echo $employee_payroll->total_deductions;}else{echo "N/A";}?></td>
      	</tr>
    </thead>
    <tbody>
    </tbody>
    </table>


</div>
</div>


<div class="row">
  <div class="col-sm-12">
  <?php 

  if(!empty($employee_payroll->total_amount)){$gross=$employee_payroll->total_amount;}else{echo $gross;}; ?>
  <table class="table">
    <thead>
    
      <tr class="info">
        <th>Total Leave</th>
        <th>Total Late Comming</th>
        <th>Total Short Leave</th>
        <th>Total Absent</th>
        
        
      </tr>
      </thead>
       <tbody>
       <tr>
       <td>
       <?= count($employeeLeaveCount); ?>
         
       </td>
       <td>
         <?=count($employeelatecomingCount); ?>
       </td>

       <td>
         <?=count($employeeslCount); ?>
       </td>

       <td>
         <?=count($employeeabsentCount); ?>
       </td>
       </tr>

       </tbody>
       </table>

       <?php 
        $levcountx=count($employeeLeaveCount);
        if($levcountx >0){
           $levcountx=count($employeeLeaveCount);
        }else{
           $levcountx='0';
        }


        $absntcount=count($employeeabsentCount);
        if($absntcount >0){
           $absntcount=count($employeeabsentCount);
        }else{
           $absntcount='0';
        }


        $latecomngcount=count($employeelatecomingCount);
        if($latecomngcount >0){
           $latecomngcount=count($employeelatecomingCount);
        }else{
           $latecomngcount='0';
        }


        $shorllevcount=count($employeeslCount);
        if($shorllevcount >0){
           $shorllevcount=count($employeeslCount);
        }else{
           $shorllevcount='0';
        }

        


       


        $leavequery=LeaveSettings::find()->where(['branch_id'=>yii::$app->common->getBranch()])->one();
        $alowdLevs= $leavequery->allowed_leaves;
        $latecmrplcy= $leavequery->latecommer_policy;
        $shrtlevplcy= $leavequery->shortleave_policy;
        
       
        $ttlatecomng=$latecomngcount/$latecmrplcy;
        $totlshrtlv=$shorllevcount/$shrtlevplcy;

        echo "<table class='table'>";
        echo '<th class="danger">';
        echo 'Total Leaves Taken '.round($totlCountLeaves=$levcountx+$absntcount+$ttlatecomng+$totlshrtlv,2);
        echo '</th>';

        if($totlCountLeaves == 0){
          $totlCountLeaves='0';
        }else{
          $totlCountLeaves= $totlCountLeaves;
        }

        //$twosl=1;
       // $sixlc=1;

        


        if($alowdLevs == 0){
          $alowdLevs='0';
        }else{
          $alowdLevs= $alowdLevs;
        }


        echo '<th class="danger">';
        echo "Total After Allowed";
        echo "&nbsp;";
        if($totlCountLeaves > $alowdLevs){
        echo $totlaftralwd=round($totlCountLeaves-$alowdLevs,2);
        }else{
          echo '0';
        }
        ?>
        <input type="hidden" id="afterallowed" name="SalaryMain[total_after_alowed_leaves]" value="<?= round($totlCountLeaves-$alowdLevs,2);  ?>">
          
        <?php echo '</th>';

        

        $checkempSalarymain=salaryMain::find()->where(['fk_emp_id'=>$empid])->one();

        if(count($checkempSalarymain) > 0){
          
          $perdaysalary=$gross/30;
          $ttlaftralowd=round($totlCountLeaves-$alowdLevs,2);

          /////////////////////
          echo '<th class="danger">';
         echo "Absent Deduction"; 
         echo "&nbsp;";
         if($totlCountLeaves > $alowdLevs){
         echo round($absntdeductnx=$ttlaftralowd*$perdaysalary);?>
         <input type="hidden" class="absntdeduction" value="<?php echo round($ttlaftralowd*$perdaysalary);?>">
         <?php }else{
          echo "0";?>
           <input type="hidden" class="absntdeduction" value="<?php echo "0"?>">
        <?php }
         ?>
           <input type="hidden" name="SalaryMain[absent_deduction]" value="<?php 
           if($totlCountLeaves > $alowdLevs){
           echo $ttlaftralowd*$perdaysalary;
           }else{
           echo "0";
           }
        ?>">
         <?php echo '</th>';
         $absnttotaldeductions=$ttlaftralowd*$perdaysalary;
          
          //echo "Net amount ".$gross;
         
          echo '<th class="danger">';
          echo "Net Amount ";
          echo "&nbsp";
         if($totlCountLeaves > $alowdLevs){
          echo round($net_amount = $gross - $absnttotaldeductions);

         }else{echo $gross;}
        
          echo '</th>';

          echo "</table>";

        





          ////////////////////

        }else{
         
          $employeeHiringDate=EmployeeInfo::find()->where(['emp_id'=>$empid])->one();
            $empHireday=date('d',strtotime($employeeHiringDate->hire_date));
          // echo '<br />';
          
              $minusdays=30-$empHireday;
             echo '<br />';
            
              $perdaysalaryis=$gross/30;
           //echo '<br />';
              $perdaysalarymultiply=$perdaysalaryis*$minusdays;
              echo '<br />';

               $ttlaftralowd=$totlCountLeaves-$alowdLevs;

              // echo $perdaysalaryis*$ttlaftralowd;

               //echo $alowdLevs;

          //echo '<br />';
         // echo $ttlaftralowd;
         // echo '<br />';

          
           $absntdeductnx=round($perdaysalaryis*$ttlaftralowd);
           $perdaysalary=$perdaysalarymultiply-$absntdeductnx;?>

  

          <?php
          /////////////////////////////
            echo '<th class="danger">';
         echo "Absent Deduction"; 
         echo "&nbsp;";
         if($totlCountLeaves > $alowdLevs){
         echo round($absntdeductnx);?>
         <input type="hidden" class="absntdeduction" value="<?php echo round($absntdeductnx);?>">
         <?php }else{
          echo "0";?>
           <input type="hidden" class="absntdeduction" value="<?php echo "0"?>">
        <?php }
         ?>
           <input type="hidden" name="SalaryMain[absent_deduction]" value="<?php 
           if($totlCountLeaves > $alowdLevs){
           echo $ttlaftralowd*$perdaysalary;
           }else{
           echo "0";
           }
        ?>">
         <?php echo '</th>';
         $absnttotaldeductions=$ttlaftralowd*$perdaysalary;
          
         
          echo '<th class="danger">';
          echo "Net Amount ";
          echo "&nbsp";
         if($totlCountLeaves > $alowdLevs){
          
          echo round($net_amount = $perdaysalary=$perdaysalarymultiply-$absntdeductnx); ?>
           
         <input type="hidden" class="hiredateslry" value="<?php echo round($perdaysalary);?>">

           <input type="hidden" class="showHiredateslry" value="">

        
          <?php 

         }else{echo $gross;}
        
          echo '</th>';

          echo "</table>";




          ///////////////////////////
        

          }

          //echo $employeeHiringDate->hire_date;
          
          //$perdaysalary=$gross/30;
       
         // $ttlaftralowd=round($totlCountLeaves-$alowdLevs,2);
         /*echo '<th class="danger">';
         echo "Absent Deduction"; 
         echo "&nbsp;";
         if($totlCountLeaves > $alowdLevs){
         echo round($absntdeductnx=$ttlaftralowd*$perdaysalary);?>
         <input type="hidden" class="absntdeduction" value="<?php echo round($ttlaftralowd*$perdaysalary);?>">
         <?php }else{
          echo "0";?>
           <input type="hidden" class="absntdeduction" value="<?php echo "0"?>">
        <?php }
         ?>
           <input type="hidden" name="SalaryMain[absent_deduction]" value="<?php 
           if($totlCountLeaves > $alowdLevs){
           echo $ttlaftralowd*$perdaysalary;
           }else{
           echo "0";
           }
        ?>">
         <?php echo '</th>';
         $absnttotaldeductions=$ttlaftralowd*$perdaysalary;
          
         
          echo '<th class="danger">';
          echo "Net Amount ";
          echo "&nbsp";
         if($totlCountLeaves > $alowdLevs){
          echo round($net_amount = $gross - $absnttotaldeductions);

         }else{echo $gross;}
        
          echo '</th>';

          echo "</table>";
*/
        

        ?>

  </div>
</div>
<?php $form = ActiveForm::begin(); ?>
<div class="row">
  <div class="col-sm-6">
   <!-- <?php 
   /*$tax = ArrayHelper::map(\app\models\SalaryTax::find()->all(), 'id', 'tax_rate');
                    echo $form->field($model, 'fk_tax_id')->widget(Select2::classname(), [
                        'data' => $tax,
                        'options' => ['prompt'=>'Select Tax'],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ]);*/
     
      ?> -->
      <?= $form->field($model, 'salary_payable')->textInput(['readonly'=>'readonly'])->label('Net Salary') ?>
      <?= $form->field($model, 'salary_month')->widget(DatePicker::classname(), [
                     'options' => ['value' => date('Y/m/d')],
                     'pluginOptions' => [
                         'autoclose'=>true,
                         'format' => 'yyyy/mm/dd',
                         'todayHighlight' => true,
                        // 'urls'=>Url::to(['salary-main/salary-month-message']),
                         //'endDate' => '+0d',
                         //'startDate' => '-2y',
                     ]
                 ]);?>

                 <input type="hidden" id="slrymonthcalendar" data-url="<?= Url::to(['salary-main/salary-month-message'])?>">

    

                 <?= $form->field($model, 'is_paid')->hiddenInput(['value'=>'1'])->label(false) ?>
  </div>
  <div class="col-sm-6">
   <!-- <?//= $form->field($model, 'tax_amount')->textInput(['readonly'=>'readonly']) ?> -->
   <?= $form->field($model, 'payment_date')->widget(DatePicker::classname(), [
                     'options' => ['value' => date('Y/m/d')],
                     'pluginOptions' => [
                         'autoclose'=>true,
                         'format' => 'yyyy/mm/dd',
                         'todayHighlight' => true,
                         //'endDate' => '+0d',
                         //'startDate' => '-2y',
                     ]
                 ]);?>

     <?php ActiveForm::end(); ?>
  </div>
</div>
<div class="showExist" style="color: red;font-weight: bold;text-align: center"></div>
<input type="hidden" name="" id="anothers" data-urls="<?php echo Url::to(['salary-main/Create-mpdf-payroll']) ?>">
<div class="row">
  <div class="col-sm-3">
    <input type="button" name="submit" id="submitpayroll" value="Submit" class="btn btn-success" data-url="<?= Url::to(['salary-main/save-payroll'])?>" />

  </div>

</div>
<br />

