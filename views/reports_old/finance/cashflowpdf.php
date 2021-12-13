<?php use yii\helpers\Url;
use yii\bootstrap\Modal;
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
    $cashflow_exthead= 0;
    $day_arr = [];
    $transport = 0;
    $total_transport = 0;
    foreach ($extra_head as $extrahead){
        $day_arr[$extrahead['DATE_PURCHASED']] = $extrahead['fee_received'];
        //$total=$total+$extrahead['fee_received'];
    }
    //echo '<pre>';print_r($extra_head);
    //echo '<pre>';print_r($query);
    //exit;
    foreach ($query as $queryy) {

        $count++;
        $total=$total+$queryy['fee_received'];
        if(isset($day_arr[$queryy['DATE_PURCHASED']]) && $queryy['DATE_PURCHASED'] == $day_arr[$queryy['DATE_PURCHASED']]){
            $cashflow_exthead=  $day_arr[$queryy['DATE_PURCHASED']];
        }else{
            $cashflow_exthead = 0 ;
        }
        if($queryy['transport_fare'] >0 ){
            $transport = $queryy['transport_fare'];

        }else{
            $transport= 0;
        }
        $total_transport = $total_transport+$transport;
        ?>
        <tr>
            <td><?= $count; ?></td>
            <td><?= $queryy['DATE_PURCHASED'];?></td>
            <td><?= $queryy['dayname(fcr.transaction_date)'];?></td>
            <!-- <td><?//= $queryy['dayname(fhw.created_date)'];?></td> -->
            <td>Rs. <?= $queryy['fee_received']+$cashflow_exthead+$transport;?></td>

        </tr>
    <?php }
    ?>
    <tr><th></th><td></td>
        <th>Total: </th><td>Rs. <?php echo $total+$total_transport; ?></td></tr>

    </tbody>
</table>
