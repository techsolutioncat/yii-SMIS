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
                            foreach ($query as $queryy) {
                              $count++;
                              $total=$total+$queryy['fee_received'];
                              ?>
                            <tr>
                                <td><?= $count; ?></td>
                                <td><a id="cashInflowclasswise" href="javascript:void(0)" data-date="<?= $queryy['DATE_PURCHASED']?>" data-url="<?= Url::to(['reports/daily-cashflow-claswise'])?>"><?= $queryy['DATE_PURCHASED'];?></a></td>
                                <td><?= $queryy['dayname(fcr.transaction_date)'];?></td>
                                <td>Rs. <?= $queryy['fee_received'];?></td>
                                
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
                



