<?php use yii\helpers\Url;
use app\models\User;
use app\models\StudentInfo;
  ?>
<table class="table table-striped">
    <thead>
    <tr>
        <th>Student Name</th>
        <th>Admission</th>
        <th>Tuition</th>
        <th>Annual</th>
        <th>Misc</th>
        <th>Transport Received</th>
        <th>Advance</th>

        <!--<th>Hostel</th>-->
        <th>Advance Transport</th>

    </tr>
    </thead>


<?php
$totalAdmission = 0;
$totalTution = 0;
$totalAnnual = 0;
$totalMisc = 0;
$total_transport = 0;
$total_hostel = 0;
$total_advance=0;
$overallAdvance = 0;
$overalltransportAdvance = 0;
 foreach ($students as $key => $student) {

      $getStudentInfo=StudentInfo::find()->where([
        'fk_branch_id'=>yii::$app->common->getBranch(),
        'stu_id'=>$student['stu_id']])->one();
        $userid=$getStudentInfo->user_id;

        $getChalans=Yii::$app->db->createCommand("select fhw.fk_branch_id,fhw.fk_stu_id,ftd.manual_recept_no,ftd.id,ftd.manual_recept_no,ftd.transaction_date as `fee_submission_date` from fee_head_wise fhw inner join fee_transaction_details ftd on ftd.id=fhw.fk_chalan_id where fhw.fk_stu_id=".$student['stu_id']." and fhw.fk_branch_id=".Yii::$app->common->getBranch()." GROUP BY fhw.fk_branch_id,ftd.id,ftd.manual_recept_no, ftd.transaction_date")->queryAll();

         if(count($getStudentInfo)>0){
            ?>


         <?php
         $countgrand=0;
         $payrcvGrnd=0;
         $total_advance_balance = 0 ;
         $arearscount=0;

             if(count($getChalans) > 0) {
                 foreach ($getChalans as $getChalan) { ?>
                     <?php
                     if($getChalan['id']){
                         $fee_challan_record = \app\models\FeeChallanRecord::find()->where(['fk_branch_id'=>Yii::$app->common->getBranch(),'challan_id'=>$getChalan['id']])->one();
                     }
                     $query = yii::$app->db->createCommand("
                    select fhw.id,fhw.fk_branch_id,fhw.fk_stu_id,fh.id head_id,fh.title,fhw.payment_received,fcr.arrears,fhw.transport_fare,fhw.hostel_fee 
                    from fee_head_wise fhw left join fee_particulars fp on fp.id=fhw.fk_fee_particular_id 
                    inner join fee_heads fh on fh.id=fp.fk_fee_head_id 
                    inner join fee_transaction_details ftd on ftd.id=fhw.fk_chalan_id left join fee_challan_record fcr on fcr.challan_id=fhw.fk_chalan_id and fp.fk_fee_head_id=fcr.fk_head_id where fhw.fk_stu_id=" . $student['stu_id'] . " and fhw.fk_branch_id=" . Yii::$app->common->getBranch() . " and ftd.id= '" . $getChalan['id'] . "'
                    ")->queryAll();
                     ?>
                     <tbody>
                     <tr>
                         <td><?=Yii::$app->common->getName($userid)?></td>
                         <td>
                             <?php
                             $admission_received = \app\models\search\FeeHeadWise::find()->where(['fk_branch_id'=>Yii::$app->common->getBranch(),'fk_stu_id'=>$student['stu_id'],'fk_chalan_id'=>$getChalan['id'],'fk_fee_head_id'=>1])->one();
                             if(count($admission_received)>0){
                                 echo $admission_received->payment_received;
                                 $totalAdmission=$totalAdmission+$admission_received->payment_received;
                             }else{
                                 echo '0';
                             }
                             ?>
                         </td>
                         <td>
                             <?php
                             $tution_received = \app\models\search\FeeHeadWise::find()->where(['fk_branch_id'=>Yii::$app->common->getBranch(),'fk_stu_id'=>$student['stu_id'],'fk_chalan_id'=>$getChalan['id'],'fk_fee_head_id'=>2])->one();
                             if(count($tution_received)>0){
                                 echo $tution_received->payment_received;
                                 $totalTution=$totalTution+$tution_received->payment_received;
                             }else{
                                 echo '0';
                             }
                             ?>
                         </td>
                         <td>
                             <?php
                             $annual_received = \app\models\search\FeeHeadWise::find()->where(['fk_branch_id'=>Yii::$app->common->getBranch(),'fk_stu_id'=>$student['stu_id'],'fk_chalan_id'=>$getChalan['id'],'fk_fee_head_id'=>4])->one();
                             if(count($annual_received)>0){
                                 echo $annual_received->payment_received;
                                 $totalAnnual=$totalAnnual+$annual_received->payment_received;
                             }else{
                                 echo '0';
                             }
                             ?>
                         </td>
                         <td>
                             <?php
                             $mise_received = \app\models\search\FeeHeadWise::find()->where(['fk_branch_id'=>Yii::$app->common->getBranch(),'fk_stu_id'=>$student['stu_id'],'fk_chalan_id'=>$getChalan['id'],'fk_fee_head_id'=>3])->one();
                             if(count($mise_received)>0){
                                 echo $mise_received->payment_received;
                                 $totalMisc=$totalMisc+$mise_received->payment_received;
                             }else{
                                 echo '0';
                             }
                             ?>
                         </td>
                         <td>
                             <?php
                             if(count($tution_received)>0){
                                 echo $tution_received->transport_fare;
                                 $total_transport=$total_transport+$tution_received->transport_fare;
                             }else{
                                 echo '0';
                             }
                             ?>
                         </td>
                         <!--<td>
                             <?php
/*                             if(count($tution_received)>0){
                                 echo $tution_received->hostel_fee;
                                 $total_hostel=$total_hostel+$tution_received->hostel_fee;
                             }else{
                                 echo '0';
                             }
                             */?>
                         </td>-->
                         <td>
                             <?php
                             $advance_admission = \app\models\SundryAccount::find()->select('total_advance_bal')->where(['stu_id'=>$student['stu_id'],'fk_branch_id'=>Yii::$app->common->getBranch(),'status'=>1])->sum('total_advance_bal');

                             if(count($advance_admission)>0){
                                 echo $advance_admission;
                                 $overallAdvance=$overallAdvance+$advance_admission;
                             }else{
                                 echo '0';
                             }
                             ?>

                         </td>
                         <td>
                             <?php 
                             $advance_transport = \app\models\SundryAccount::find()->select('transport_fare')->where(['stu_id'=>$student['stu_id'],'fk_branch_id'=>Yii::$app->common->getBranch(),'status'=>1])->one();

                             if(count($advance_admission)>0){
                                 echo $advance_transport->transport_fare;
                                 $overalltransportAdvance=$overalltransportAdvance+ $advance_transport->transport_fare;
                             }else{
                                 echo '0';
                             }
                             ?>
                         </td>
                     </tr>



                 <?php } ?>

                 <?php
             }
             ?>

             <?php
        }?>

         <?php
 }

?>
                     <tr>
                         <th>Total</th>
                         <th>Rs.<?=$totalAdmission?></th>
                         <th>Rs.<?=$totalTution?></th>
                         <th>Rs.<?=$totalAnnual?></th>
                         <th>Rs.<?=$totalMisc?></th>
                         <th>Rs.<?=$total_transport?></th>
                         <!--<td>Rs.<?/*=$total_hostel*/?></td>-->
                         <th>Rs.<?=$overallAdvance?></th>
                         <th>Rs.<?=$overalltransportAdvance?></th>
                     </tr>
                     </tbody>
</table>
