<?php use yii\helpers\Url;
use app\models\StudentInfo;
?>


<?php
$advanceTransport=yii::$app->db->createCommand("SELECT SUM(transport_fare) FROM sundry_account")->queryOne();
$getStudents=StudentInfo::find()->where(['fk_branch_id'=>yii::$app->common->getBranch(),'is_active'=>1])->all();

$getTransportSundary=yii::$app->db->createCommand("SELECT SUM(DISTINCT transport_fare)
FROM `sundry_account`
WHERE (`created_date` BETWEEN '".$startcnvrt."' AND '".$endcnvrt." 23:59:59.999')")->queryOne();
//echo $getTransportSundary;die;




$total_advance_bal=yii::$app->db->createCommand("SELECT SUM(total_advance_bal)
FROM `sundry_account`
WHERE (`created_date` BETWEEN '".$startcnvrt."' AND '".$endcnvrt." 23:59:59.999')")->queryOne();

//echo $total_advance_bal['SUM(total_advance_bal)'];
//echo '<pre>';print_r($getStudents);die;
$trans=0;
//echo $startcnvrt;die;
foreach ($getStudents as $stu) {

 //$sumtranports=yii::$app->db->createCommand("SELECT sum(DISTINCT transport_fare) FROM `fee_head_wise` WHERE fk_stu_id=".$stu->stu_id." and 'fk_branch_id'=".yii::$app->common->getBranch()." and created_date BETWEEN '".$startcnvrt."' and '".$endcnvrt." 23:59:59.999' ")->getRawSql();

  $sumtranports=yii::$app->db->createCommand("SELECT sum(DISTINCT transport_fare) FROM `fee_head_wise` WHERE fk_stu_id=".$stu->stu_id." and (`created_date` BETWEEN '".$startcnvrt."' AND '".$endcnvrt." 23:59:59.999')")->queryOne();

    /*$sumtranports= yii::$app->db->createCommand("select sum(DISTINCT transport_fare) as transport_fare from fee_head_wise where fk_stu_id=".$stu->stu_id." and fk_branch_id=".yii::$app->common->getBranch()." and created_date BETWEEN '".$startcnvrt."' and '".$endcnvrt." 23:59:59.999' ")->getRawSql();*/
     //echo $sumtranports;die;
 $trans+=$sumtranports['sum(DISTINCT transport_fare)'];
 // echo $sumtranports['sum(DISTINCT transport_fare)'];
 
}


$getHead=yii::$app->db->createCommand("SELECT * from fee_heads 
WHERE fk_branch_id=".yii::$app->common->getBranch()."")->queryAll();

 ?> 


                  <table class="table table-striped">
                        <thead>
                           <tr>
                            <th>SR</th>
                            <th>Title</th>
                            <th>Payment Received</th>
                            <!-- <th>Advance Payment</th> -->
                            
                            </tr>
                        </thead>
                            <tbody>
                            <?php 
                            $count=0;
                            $total=0;
                            $sum=0;
                            $counts=0;


                            foreach ($getHead as $headId) {
                              $counts++;
                  $headIds= $headId['id'];

                    $getHeadRecv=yii::$app->db->createCommand("SELECT sum(payment_received) FROM `fee_head_wise` WHERE fk_fee_head_id=".$headIds." and (`created_date` BETWEEN '".$startcnvrt."' AND '".$endcnvrt." 23:59:59.999')")->queryOne();
		//echo $getHeadRecv;continue;
			?>
                            <?php if($getHeadRecv['sum(payment_received)'] == 0){}else{
                              $sum=$sum+$getHeadRecv['sum(payment_received)'];
                              ?>
                              <tr>
                                <td><?= $counts; ?></td>
                                 <td><?= $headId['title'];?></td>
                                <td><?= $getHeadRecv['sum(payment_received)'];?></td>
                                <td><?php //echo $advancPayment['total_advance_bal']?></td>
                            <?php }?>
                                

                                
                            </tr>
                <?php  }//exit;
                         foreach ($query as $queryy) {
                              $count++;
                              $total=$total+$queryy['payment_received'];
                              ?>
                           <!--  <tr>
                                <td><?//= $count; ?></td>
                                <td><?//= $queryy['title'];?></td>
                                <td><?//= $queryy['payment_received'];?></td>
                                <td><?php //echo $advancPayment['total_advance_bal']?></td>
                                

                                
                            </tr> -->
                            <?php }
                            // extra header
                            //foreach ($extrahead_query as $query_extrahead) {
                              
                            //$count++;
                            //$total=$total+$query_extrahead['payment_received'];
                            ?>
                            <!-- <tr>
                                <td><?//= $count; ?></td>
                                <td><?//= $query_extrahead['title'];?></td>
                                <td><?//= $query_extrahead['payment_received'];?></td>

                            </tr> -->
                           
                            <?php //} end of extra head ?>
                              <tr>
                               <td><?= $counts + 1;?></td>
                               <td>Transport fare</td>
                               <td><?php echo $trans;?></td>

                           </tr> 

                           <tr>
                               <td><?= $counts + 2;?></td>
                               <td>Advance Transport fare</td>
                               <td><?php echo $advanceTransport['SUM(transport_fare)']; ?></td>
                                
                           
                           </tr>


                          <!--  <tr>
                               <td><?//= $counts + 3;?></td>
                               <td>Net Transport Amount</td>
                               <td><?php //echo $trans + $advanceTransport['SUM(transport_fare)']; ?></td>
                                <td><?//= $transportFare['sum(fhw.transport_fare)'];?>
                               </td>
                           
                           </tr> -->

                            <tr>
                               <td><?= $counts + 4;?></td>
                               <td>Advance Monthly Fee</td>
                               <td><?php echo $total_advance_bal['SUM(total_advance_bal)']; ?></td>
                               
                               </td>
                           
                           </tr>

                           

                           
                            <tr><th></th>
                            <!-- <th>Total: Rs. <?php //echo $total + $transportFare['sum(fhw.transport_fare)']; ?></th></tr> -->
                            <th>Total</th>
                            <th><?php echo $sum + $trans + $advanceTransport['SUM(transport_fare)'] + $total_advance_bal['SUM(total_advance_bal)'];?></th>
                          <!--   <th><?php // echo $sum + $queryy['payment_received'] + $query_extrahead['payment_received']  + $advanceTransport['SUM(transport_fare)'] + $total_advance_bal['SUM(total_advance_bal)'];?></th> -->
                            </tr>

                            </tbody>
                     </table>
                



