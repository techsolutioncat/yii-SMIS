<?php use yii\helpers\Url;
use yii\bootstrap\Modal;
 ?> 
<?php 

/*$query=yii::$app->db->createCommand("
                select fcr.transaction_amount,fhw.fk_branch_id,CAST(fcr.transaction_date AS DATE) AS DATE_PURCHASED,dayname(fcr.transaction_date), sum(fhw.payment_received) as `fee_received` from fee_head_wise fhw inner join fee_transaction_details fcr on fcr.id=fhw.fk_chalan_id where fhw.fk_branch_id=".yii::$app->common->getBranch()." and CAST(fcr.transaction_date AS DATE) >= '".$startcnvrt."' and CAST(fcr.transaction_date AS DATE) <= '".$endcnvrt."' GROUP by fhw.fk_branch_id , CAST(fcr.transaction_date AS DATE),dayname(fcr.transaction_date)
            ")->getRawSql();
echo $query;die;

          foreach ($query as $quers) {
            echo $quers['transaction_amount'];
            echo '<br />';
          }*/


        

          /*$getTransport=yii::$app->db->createCommand("SELECT fee_head_wise.fk_chalan_id, fee_transaction_details.transaction_date,fee_head_wise.transport_fare
        FROM fee_head_wise
        INNER JOIN fee_transaction_details ON fee_head_wise.fk_chalan_id=fee_transaction_details.id where fee_head_wise.fk_branch_id=".yii::$app->common->getBranch()." and CAST(fee_transaction_details.transaction_date AS DATE) >= '".$startcnvrt."' and CAST(fee_transaction_details.transaction_date AS DATE) <= '".$endcnvrt."' GROUP BY fk_chalan_id,fee_head_wise.id,fee_head_wise.transport_fare")->queryAll();

*/


              

 ?>

                  <table class="table table-striped">
                        <thead>
                           <tr>
                            <th>SR</th>
                            <th>Date Received</th>
                            <th>Day Received</th>
                            <th>Amount</th>
                            
                            </tr>
                        </thead>
                            <tbody>
                            <?php 

             
               

                            $count=0;
                            $total=0;
                            $totals=0;
                            foreach ($query as $queryy) {

                               $getTransport=yii::$app->db->createCommand("SELECT fee_head_wise.id,fee_head_wise.fk_chalan_id, fee_transaction_details.transaction_date,fee_transaction_details.id,fee_head_wise.transport_fare
        FROM fee_head_wise
        INNER JOIN fee_transaction_details ON fee_head_wise.fk_chalan_id=fee_transaction_details.id where fee_transaction_details.transaction_date='".$queryy['DATE_PURCHASED']."' GROUP BY(fk_chalan_id),fee_head_wise.id")->queryAll();
                               $array=[];
                foreach ($getTransport as $tr) {
                  
                

               $array[$queryy["MIN(fhw.fk_chalan_id)"]]=$tr['transport_fare'];
               

               $totals+=$tr['transport_fare'];
              }
             // print_r($array);die;
                              $count++;
                              //$total=$total+$queryy['fee_received'] + $queryy['transport_fare'];
                              $ar=$array[$queryy['MIN(fhw.fk_chalan_id)']];
                              
                             // print_r($array);
                              ?>
                            <tr>
                                <td><?= $count; ?></td>
                                <td><a id="cashInflowclasswise" href="javascript:void(0)" data-date="<?= $queryy['DATE_PURCHASED']?>" data-url="<?= Url::to(['reports/daily-cashflow-claswise'])?>"><?= $queryy['DATE_PURCHASED'];?></a></td>
                                <td><?= $queryy['dayname(fcr.transaction_date)'];?></td>
                                <td>
                                  <?php $service_charges_total = $queryy['fee_received'] + $ar ;
                                  echo 'Rs '. $service_charges_total ;
                                   $total+=$service_charges_total;
                                  ?>
                                </td>
                                <!-- <td>Rs. <?//= $queryy['fee_received'] + $queryy['transport_fare'];?></td> -->
                                
                            </tr>
                            <?php } ?>
                            <tr><th></th><td></td>


                            <th>Total: </th><td>Rs. <?php echo $total; ?></td></tr>

                            </tbody>
                     </table>

                      <?php 
         Modal::begin([
            'header'=>'<h4>Daily Cash In Flow Class Wise</h4>',
            'id'=>'modal',
            'size'=>'modal-lg',
         ]);

        echo "<div id='modalContents'></div>";
        Modal::end();
        ?>
                



