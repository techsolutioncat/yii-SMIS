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
         $arearscount=0;
         if(count($getChalans) > 0) {
             foreach ($getChalans as $getChalan) { ?>
                 <tr>
                     <td><strong>Challan No: </strong><span
                             style="color: red"><?php echo $getChalan['challan_no']; ?></span></td>
                     <?php
                     if(!empty($getChalan['manual_recept_no'])) {
                         ?>
                         <td><strong><?= Yii::t('app', 'Manual Receipt #') ?>: </strong><span
                                 style="color: red"><?php echo $getChalan['manual_recept_no']; ?></span></td>
                         <?php
                     }
                         ?>
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
                select fhw.id,fhw.fk_branch_id,fhw.fk_stu_id,fh.title,fhw.payment_received,fcr.arrears,fhw.transport_fare,fhw.hostel_fee from fee_head_wise fhw left join fee_particulars fp on fp.id=fhw.fk_fee_particular_id inner join fee_heads fh on fh.id=fp.fk_fee_head_id inner join fee_transaction_details ftd on ftd.id=fhw.fk_chalan_id left join fee_challan_record fcr on fcr.challan_id=fhw.fk_chalan_id and fp.fk_fee_head_id=fcr.fk_head_id where fhw.fk_stu_id=" . $stu_id . " and fhw.fk_branch_id=" . Yii::$app->common->getBranch() . " and ftd.challan_no = '" . $getChalan['challan_no'] . "'
                ")->queryAll();
                 //echo $query;exit;
                 $query_extrahead = yii::$app->db->createCommand("select fhw.id,fhw.fk_branch_id,fhw.fk_stu_id,fh.title,fhw.payment_received,fcr.arrears from fee_head_wise fhw  
inner join fee_heads fh on fh.id=fhw.fk_fee_head_id 
inner join fee_transaction_details ftd on ftd.id=fhw.fk_chalan_id 
left join fee_challan_record fcr on fcr.challan_id=fhw.fk_chalan_id and fhw.fk_fee_head_id=fcr.fk_head_id 
where fhw.fk_stu_id=" . $stu_id . " and fhw.fk_branch_id=" . Yii::$app->common->getBranch() . " and fhw.fk_fee_particular_id IS NULL and ftd.challan_no = '" . $getChalan['challan_no'] . "'")
                     ->queryAll();

                 ?>


                 <table class="table table-striped">
                     <thead>
                     <tr>
                         <th>SR</th>
                         <!-- <th>Challan No.</th> -->
                         <th>Title</th>
                         <th>Total</th>
                         <th>Payment Received</th>
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
                     $total_fareamount=0;
                     $transport_fare_received=0;
                     foreach ($query as $queryy) {
                        //echo $queryy['transport_fare'];

                         $count++;
                         $total = $total + $queryy['payment_received'];
                         $arrears = $arrears + $queryy['arrears'];
                         $sumboth = $sumboth + $queryy['payment_received'];
                         $countgrand = $countgrand + $queryy['payment_received'];
                         $payrcvGrnd = $payrcvGrnd + $queryy['payment_received'];
                         $arearscount = $arrears + $queryy['arrears'];
                         $hostel_fee = $queryy['hostel_fee'];
                         $transport_fare_received = $queryy['transport_fare'];
                         ?>
                         <?php
                         if ($queryy['payment_received'] > 0) {
                             ?>
                             <tr>
                                 <td><?= $count; ?></td>
                                 <!-- <td><?//= $queryy['challan_no'];
                                 ?></td> -->
                                 <td><?= $queryy['title'] ?></td>
                                 <td><?= $queryy['payment_received'] + $queryy['arrears']; ?></td>
                                 <td><?= $queryy['payment_received']; ?></td>
                                 <td>Rs. <?php if ($queryy['arrears'] == '') {
                                         echo "0";
                                     } else {
                                         echo $queryy['arrears'];
                                     }; ?></td>
                                 <!-- <td><?//= $queryy['fee submission date'];
                                 ?></td> -->

                             </tr>
                             <?php
                         }
                     }
                     if(count($query_extrahead)>0) {
                         foreach ($query_extrahead as $query_extra) { }
                             $count++;
                             $total_ext = $total_ext + $query_extra['payment_received'];
                             $arrears = $arrears + $query_extra['arrears'];
                             $sumboth = $sumboth + $query_extra['payment_received'];
                             $countgrand = $countgrand + $query_extra['payment_received'];
                             $payrcvGrnd = $payrcvGrnd + $query_extra['payment_received'];
                             $arearscount = $arrears + $query_extra['arrears'];

                             ?>
                             <?php
                             if ($query_extra['payment_received'] > 0) {
                                 ?>
                                 <tr>
                                     <td><?= $count; ?></td>
                                     <!-- <td><?//= $queryy['challan_no'];
                                     ?></td> -->
                                     <td><?= $query_extra['title']; ?></td>
                                     <td><?php echo $query_extra['payment_received'] + $queryy['arrears']; ?></td>
                                     <td><?= $query_extra['payment_received']; ?></td>
                                     <td>Rs. <?php if ($query_extra['arrears'] == '') {
                                             echo "0";
                                         } else {
                                             echo $query_extra['arrears'];
                                         }; ?></td>
                                     <!-- <td><?//= $queryy['fee submission date'];
                                     ?></td> -->

                                 </tr>
                                 <?php
                             }
                             $hostel_fee = $queryy['hostel_fee'];
                             $transport_fare = $queryy['transport_fare'];
                             if(count($fee_challan_record)>0){
                                 $total_fareamount =$fee_challan_record->fare_amount;
                                 $sumboth = $sumboth+$total_fareamount;

                                 $total_hostel_fare = $fee_challan_record->fare_amount;
                             }
                            // if($transport_fare>0) {
                                 ?>
                                <!--  <tr>
                                    <td><?= $count + 1; ?></td>
                                    <td><?//= $queryy['challan_no'];
                                    ?></td>
                                    <td>transport Fee</td>
                                    <td><?//= ($total_fareamount > 0) ? $total_fareamount : 0 ?></td>
                                    <td><?//= ($transport_fare) ? $transport_fare : 0; ?></td>
                                    <td></td>
                                    <td><?//= $queryy['fee submission date'];
                                    ?></td>
                                
                                </tr> -->

                                 <?php
                             //}

                         //}
                     }?>
                     


                     <?php 
                       

                     ?>
                     <tr>
                        <th><?php echo $count + 1;?></th>
                        <td>Transport fare </td>
                        <th> Rs. <?php echo $queryy['transport_fare']; ?></th>
                        <th> <?php echo $queryy['transport_fare']; ?></th>
                        
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
                     <th style="color: red">Arears: Rs. <?php echo $arearscount; ?></th>
                 </tr>
             </table>
             <?php
         }else{
          ?>
             <div class="col-md-12">
                 <div class="alert alert-warning">
                     Challan Not found.
                 </div>
             </div>
            <?php
         }
         ?>



