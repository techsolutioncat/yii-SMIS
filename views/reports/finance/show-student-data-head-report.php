<?php use yii\helpers\Url;
use app\models\User;
 ?> 
    <table class="table table-striped">
        <thead>
       <tr>
        <th>Student Name</th>
        <th>Class</th>
        <th>Group</th>
        <th>Section</th>

        </tr>
    </thead>
        <tbody>
        <?php
        $getstudetails=User::find()->where(['id'=>$userid])->one();
        //foreach ($getStudentInfo as $getStudentInf) { ?>
         <tr>
           <!--  <td><?//= $getStudentInf['student_name'];?></td>
           <td><?//= $getStudentInf['class_name'];?></td>
           <td><?//= $getStudentInf['group_name'];?></td>
           <td><?//= $getStudentInf['section_name'];?></td> -->

           <td><?= $getstudetails->first_name .' '. $getstudetails->last_name?></td>
           <td><?= $getStudentInfo->class->title;?></td>
           <td><?php if(!empty($getStudentInfo->group->title)){echo $getStudentInfo->group->title;}else{echo "N/A";}?></td>
           <td><?= $getStudentInfo->section->title;?></td>


        </tr>
        <?php// } ?>

        </tbody>
    </table>
         <?php
         $countgrand=0;
         $payrcvGrnd=0;
         $total_advance_balance = 0 ;
         $arearscount=0;
         if(count($getChalans) > 0) {
             foreach ($getChalans as $getChalan) { ?>
                 <tr>
                     <td><strong><?= Yii::t('app', 'Manual Receipt #') ?>: </strong><span
                             style="color: red"><?php echo $getChalan['manual_recept_no']; ?></span></td>
                     
                     <td><strong>Fee Submission Date: </strong>
                         <span
                             style="color:blue"><?php echo date("d-m-Y", strtotime($getChalan['fee_submission_date'])); ?></span>
                     </td>
                 </tr>


                 <?php
                 if($getChalan['id']){
                     $fee_challan_record = \app\models\FeeChallanRecord::find()->where(['fk_branch_id'=>Yii::$app->common->getBranch(),'challan_id'=>$getChalan['id']])->one();
                 }
                 $query = yii::$app->db->createCommand("
                select fhw.id,fhw.fk_branch_id,fhw.fk_stu_id,fh.id head_id,fh.title,fhw.payment_received,fcr.arrears,fhw.transport_fare,fhw.hostel_fee 
                from fee_head_wise fhw left join fee_particulars fp on fp.id=fhw.fk_fee_particular_id 
                inner join fee_heads fh on fh.id=fp.fk_fee_head_id 
                inner join fee_transaction_details ftd on ftd.id=fhw.fk_chalan_id left join fee_challan_record fcr on fcr.challan_id=fhw.fk_chalan_id and fp.fk_fee_head_id=fcr.fk_head_id where fhw.fk_stu_id=" . $stu_id . " and fhw.fk_branch_id=" . Yii::$app->common->getBranch() . " and ftd.id= '" . $getChalan['id'] . "'
                ")->queryAll()
                 //echo "<pre>"; print_r($query);exit;
                 ?>


                 <table class="table table-striped">
                     <thead>
                     <tr>
                         <th>SR</th>
                         <!-- <th>Challan No.</th> -->
                         <th>Title</th>
                         <th>Total</th>
                         <th>Payment Received</th>
                         <th>Advance payment</th>
                         <th>Arrears</th>
                         <!-- <th>Fee Submission Date</th> -->

                     </tr>
                     </thead>
                     <tbody>
                     <?php
                     $count = 0;
                     $total = 0;
                     $arrears = 0;
                     $sumboth = 0;
                     $total_ext=0;
                     $advanceTransport = 0;
                     $total_fareamount=0;
                     $transport_fare_received=0;
                     foreach ($query as $queryy) {
                        //echo $queryy['transport_fare'];

                         $count++;
                         $total = $total + $queryy['payment_received'];
                         $arrears = $arrears + $queryy['arrears'];
                         $sumboth = $sumboth + $queryy['payment_received'];

                         $hostel_fee = $queryy['hostel_fee'];
                         $transport_fare_received = $queryy['transport_fare'];
                         ?>
                         <?php
                         if($queryy['head_id'] ==1 || $queryy['head_id'] ==2 ){
                             $sundryAccount = \app\models\SundryAccount::find()->where(['fk_branch_id'=>Yii::$app->common->getBranch(),'fk_head_id'=>$queryy['head_id'],'stu_id'=> $stu_id,'status'=>1])->one();
                             $countgrand = $countgrand + $queryy['payment_received'];
                             $payrcvGrnd = $payrcvGrnd + $queryy['payment_received'];
                             $arearscount = $arrears + $queryy['arrears'];
                             if ($queryy['payment_received'] > 0) {
                                 ?>
                                 <tr>
                                     <td><?= $count; ?></td>
                                     <td><?= $queryy['title'] ?></td>
                                     <td><?= $queryy['payment_received'] + $queryy['arrears']; ?></td>
                                     <td><?= $queryy['payment_received']; ?></td>
                                     <td><?php
                                         if(count($sundryAccount)>0){
                                             echo $sundryAccount->total_advance_bal;
                                             $total_advance_balance = $total_advance_balance+ $sundryAccount->total_advance_bal;
                                             $advanceTransport =  $sundryAccount->transport_fare;
                                             $total_advance_balance= $total_advance_balance+$advanceTransport;
                                         }else{
                                             echo '0';
                                         }?>
                                     </td>
                                     <td>Rs. <?php if ($queryy['arrears'] == '') {
                                             echo "0";
                                         } else {
                                             echo $queryy['arrears'];
                                         }; ?>
                                     </td>
                                 </tr>
                                 <?php
                             }
                         }

                     }
                     ?>
                     <tr>
                        <th><?php echo $count + 1;?></th>
                        <td>Transport fare </td>
                        <th> Rs. <?php echo $queryy['transport_fare']; ?></th>
                        <th> <?php echo $queryy['transport_fare']; ?></th>
                         <td><?=
                                 $advanceTransport;

                             ?></td>
                         <td></td>
                    </tr>

                     </tbody>
                 </table>

             <?php } ?>

                <table class="table table-striped">

                 <tr>
                     <th></th>
                     <th></th>
                     <th></th>
                     <th></th>
                     <th></th>
                     <th></th>
                     <th></th>
                     <th></th>

                     <th style="color: green">Due: Rs. <?php echo $countgrand+$total_fareamount + $queryy['transport_fare']; ?></th>
                     <th style="color: blue">Received: Rs. <?php echo $payrcvGrnd+$queryy['transport_fare']; ?></th>
                     <th style="color: blue">Advance: Rs. <?php echo $total_advance_balance; ?></th>
                     <th style="color: red">Arears: Rs. <?php echo $arearscount; ?></th>
                 </tr>
             </table>
             <?php
         }else{
          ?>
             <div class="col-md-12">
                 <div class="alert alert-warning">
                     Receipt Not found.
                 </div>
             </div>
            <?php
         }
         ?>



