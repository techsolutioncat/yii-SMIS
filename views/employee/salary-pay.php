<?php 
use app\models\LeaveSettings;
      
 ?>
<table class="table">
    <thead>
    
      <tr >
        <th>Basic Salary:</th>
        <th>Gross Salary</th>
        <th>Group</th>
        <th>Stage</th>
        
      </tr>
      <tr class="Info">
        <td><?php if(empty($basic)){echo "N/A";}else{echo $basic;} ?></td>
        <td><?php if(empty($gross)){echo "N/A";}else{echo $gross;} ?></td>
        <td><?php if(empty($group)){echo "N/A";}else{echo $group;} ?></td>
      	<td><?php if(empty($stage)){echo "N/A";}else{echo $stage;} ?></td>
      	
      </tr>
    </thead>
    <tbody>
    </tbody>
    </table>

<div class="row">
	<div class="col-md-6">
<legend>Allownces</legend>

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
      		<td><?= $total_alwnc;?></td>
      	</tr>




    </thead>
    <tbody>
    </tbody>
    </table>
    </div>

<div class="col-md-6">
<legend>Deductions</legend>
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
      		<td><?= $total_deducn;?></td>
      	</tr>
    </thead>
    <tbody>
    </tbody>
    </table>


</div>
</div>




<div class="row">
  <div class="col-sm-12">
  <table class="table">
    <thead>
    
      <tr>
        <th>Total Leave</th>
        <th>Total Late Comming</th>
        <th>Total Short Leave</th>
        <th>Total Absent</th>
        
        
      </tr>
      </thead>
       <tbody>
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
        echo '<th>';
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


        echo '<th>';
        echo "Total After Allowed";
        echo "&nbsp;";
        if($totlCountLeaves > $alowdLevs){
        echo $totlaftralwd=round($totlCountLeaves-$alowdLevs,2);
        }else{
          echo '0';
        }
        ?>
        <input type="hidden" name="SalaryMain[total_after_alowed_leaves]" value="<?= round($totlCountLeaves-$alowdLevs,2);  ?>">
          
        <?php echo '</th>';


           $perdaysalary=$gross/30;
       
         $ttlaftralowd=round($totlCountLeaves-$alowdLevs,2);
         echo '<th>';
         echo "Absent Deduction"; 
         echo "&nbsp;";
         if($totlCountLeaves > $alowdLevs){
         echo round($absntdeductnx=$ttlaftralowd*$perdaysalary,2);?>
         <input type="hidden" class="absntdeduction" value="<?php echo $absntdeductnx;?>">
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
         
          echo '<th>';
          echo "Net Amount ";
          echo "&nbsp";
         if($totlCountLeaves > $alowdLevs){
          echo round($net_amount = $gross - $absnttotaldeductions,2);

         }else{echo $gross;}
         // echo $net_amount;
        
          echo '</th>';

          echo "</table>";

        //echo '<br />';

       //echo 'Net Amount '.$gross-$absentdeduction;



       // echo '<br />';
       // echo  $slcount= $leavequery->shortleave_policy;
       // echo '<br />';

       // echo $leavequery->latecommer_policy;

        ?>

  </div>
</div>