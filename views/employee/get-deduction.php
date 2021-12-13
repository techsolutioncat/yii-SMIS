<?php 

use app\models\SalaryDeductionType;
 ?> 
 <fieldset>
   <legend>Deduction</legend>

        
  <table class="table table-striped">
    <thead>
    
      <tr>
        <th>Deduction</th>
        <th>Amount</th>
        
      </tr>
    </thead>
    <tbody>
    <?php
    //print_r($stageid);die;
    if(count($stageid) > 0){

      $amount=0;
     foreach ($stageid as $stage) {
      $stageamount= SalaryDeductionType::find()->where(['id'=>$stage])->one();
      //print_r($stageamount);die;
      $amount=$amount+$stageamount->amount;
      ?>
      
    
      <tr>
      <td><?= $stageamount->title ?></td>
      <td><?= $stageamount->amount ?></td>
      
      </tr>
      <?php } } else{ ?>
        <tr>
      <td colsapn="2">Not Found!</td>
      </tr>
        <?php }?>

        <tr>
          
          <td>Total</td>
          <td><?= $amount?>
            
            <input type="hidden" id="getdeductionamount" value="<?= $amount?>">
          </td>
        </tr>
        <tr>
          
          <th>
            Net Ammount
          </th>
          <td><?php echo $netAmount= $gettotalAlwnc-$amount ?></td>
        </tr>

        
        
      
      
      
    </tbody>
  </table>

  </fieldset>  