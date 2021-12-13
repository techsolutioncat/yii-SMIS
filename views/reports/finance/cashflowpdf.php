<?php use yii\helpers\Url;
use yii\bootstrap\Modal;
 ?> 
  <style>
 table{


/* width:950px;
margin-left:19%;
border-collapse: separate;
border-spacing: 5px; */

}

th, tr, td  {
border:1px solid #469DC8;
padding:10px;
font-size:1.5em;
}

tr:nth-child(even){background-color: #f2f2f2}
</style>
<?php 

/*$query=yii::$app->db->createCommand("
                select fcr.transaction_amount,fhw.fk_branch_id,CAST(fcr.transaction_date AS DATE) AS DATE_PURCHASED,dayname(fcr.transaction_date), sum(fhw.payment_received) as `fee_received` from fee_head_wise fhw inner join fee_transaction_details fcr on fcr.id=fhw.fk_chalan_id where fhw.fk_branch_id=".yii::$app->common->getBranch()." and CAST(fcr.transaction_date AS DATE) >= '".$startcnvrt."' and CAST(fcr.transaction_date AS DATE) <= '".$endcnvrt."' GROUP by fhw.fk_branch_id , CAST(fcr.transaction_date AS DATE),dayname(fcr.transaction_date)
            ")->getRawSql();
echo $query;die;

          foreach ($query as $quers) {
            echo $quers['transaction_amount'];
            echo '<br />';
          }*/

 ?>

                  <table class="table table-striped" align="center">
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
                            foreach ($query as $queryy) {
                              $count++;
                              $total=$total+$queryy['fee_received'] + $queryy['transport_fare'];
                              ?>
                            <tr>
                                <td><?= $count; ?></td>
                                <td><a id="cashInflowclasswise" href="javascript:void(0)" data-date="<?= $queryy['DATE_PURCHASED']?>" data-url="<?= Url::to(['reports/daily-cashflow-claswise'])?>"><?= $queryy['DATE_PURCHASED'];?></a></td>
                                <td><?= $queryy['dayname(fcr.transaction_date)'];?></td>
                                <td>Rs. <?= $queryy['fee_received'] + $queryy['transport_fare'];?></td>
                                
                            </tr>
                            <?php } ?>
                            <tr><th></th><td></td>
                            <th>Total: </th><td>Rs. <?php echo $total; ?></td></tr>

                            </tbody>
                     </table>

                     
                



