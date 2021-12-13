<?php 
use app\models\SalaryDeductionType;
use app\models\SalaryAllownces;
 ?> 
 <div class="row">
   <div class="col-md-6">
     
   
 <fieldset>
   <legend>Earning</legend>

        
  <table class="table table-striped">
    <thead>
    <tr>
      <th>Basic Salary</th>
      <td><?php if(!empty($stagevl->amount)){
        echo $stagevl->amount;?>
        <input type="hidden" name="" id="emplBasicSal" value="<?= $stagevl->amount?>">
        <?php }else{
          } ?></td>
    </tr>
      <tr>
        <th>Allownce</th>
        <th>Amount</th>


        
      </tr>
    </thead>
    <tbody>
    <?php
    //print_r($stageid);die;
    if(!empty($stageid)){
    if(count($stageid) > 0){

      $amount=0;
     foreach ($stageid as $stage) {
      $stageamount= SalaryAllownces::find()->where(['id'=>$stage,'status'=>1])->one();
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
          <input type="hidden" id="totalAlwnxes" value="<?= $amount?>">
          <td><?= $tttlalwnc=$amount +$stagevl->amount?>
            <input type="hidden" id="getalownceamount" value="<?= $amount +$stagevl->amount?>">

          </td>
        </tr>

        
        
      
      <?php } ?>


      
    </tbody>
  </table>

  </fieldset> 
  </div>
 




  <!-- deductions -->

 
  <div class="col-md-6">
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
    //print_r($deductions);die;
    if(!empty($deductions)){
    if(count($deductions) > 0){

      $amounts=0;

     foreach ($deductions as $stages) {
      $stageamounts= SalaryDeductionType::find()->where(['id'=>$stages,'status'=>1])->one();
      //print_r($stageamount);die;
      $amounts=$amounts+$stageamounts->amount;
      
      ?>
      
    
      <tr>
      <td><?= $stageamounts->title ?></td>
      <td><?= $stageamounts->amount ?></td>
      
      </tr>
      <?php } }  else{ ?>
        <tr>
      <td colsapn="2">Not Found!</td>
      </tr>
        <?php }?>

        <tr>
          
          <td>Total</td>
          <td><?= $amounts?>
          <input type="hidden" name="" id="pasTotlDeductn" value="<?= $amounts?>">
            
            <input type="hidden" id="getdeductionamount" value="<?= $amounts?>">
          </td>
        </tr>
        
        <tr>
          <th>
            Net Ammount
          </th>
          <td>
          <?php
          if(!empty($tttlalwnc)){
           echo $netAmount= $tttlalwnc-$amounts;?>
           <input type="hidden" name="" id="netAmntPass" value="<?= $netAmount= $tttlalwnc-$amounts?>">
         <?php }
          else{
            echo $stagevl->amount-$amounts;?>

          <?php }
          ?>
         </td>
        </tr>
       
<?php } ?>
         <tr>
          
        </tr>
        
      
      
      
    </tbody>
  </table>
  <!-- <input type="hidden" name="" id="netAmntPassTotal" value="<?php//s if(empty($netAmount)){
             // echo $tttlalwnc=$amount +$stagevl->amount;
            //}else{
            //  echo $netAmount;
              } ?>"> -->

  </fieldset>  
  </div>
  </div>
    