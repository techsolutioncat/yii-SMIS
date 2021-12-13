        <?php use yii\helpers\Url; ?>  
        <a href="javascript:void(0)" class="cashflow" data-url=<?php echo Url::to(['reports/overll-cash-flow']) ?>>Cash Flow</a>-->
        <a href="javascript:void(0)" data-date="<?php echo $date; ?>" id="cashInflowclasswise" data-url=<?php echo Url::to(['reports/daily-cashflow-claswise']) ?> data-classid=<?= $class_id?>>Cash Flow Class Wise</a>       
                  <table class="table table-striped">
                        <thead>
                          <tr>
                            <th>SR</th>
                          
                            <th>Name</th>
                            <th>Group Name</th>
                            <th>Section Name</th>
                            <th>Total Payment Received</th>

                            
                          </tr>
                        </thead>
                            <tbody>
                            <?php
                            $count=0;
                            $sum=0;
                             foreach ($query as $queryy) {
                              $count++;
                              $sum=$sum+$queryy['sum(fhw.payment_received)'] + $sumHead['transport_fare'];

                              ?>
                            <tr>
                            <td><?php echo $count; ?></td>

                                <td>
                                <?= Yii::$app->common->getName($queryy['id'])?>
                                <!-- <a id="classwiseDetail" href="javascript:void(0)" data-url="<?php // echo Url::to(['reports/class-wise-fee']) ?>" data-classid=<?//= $queryy['class_id'] ?>><?php // echo $queryy['title']; ?> -->
                                </td>
                                <td><?php if($queryy['group_name'] == ''){echo "N/A";}else{echo $queryy['group_name'];}; ?></a></td>

                               <td><?php if($queryy['section_name'] == ''){echo "N/A";}else{echo $queryy['section_name'];}; ?></a></td>

                                <td><?php echo $queryy['sum(fhw.payment_received)'] + $sumHead['transport_fare']?></a></td>
                            </tr>
                            <?php } ?>
                            <tr><th><td></td></th>
                            <th><td></td><td>Total:<?php echo $sum; ?></td></th>
                            </tr>
                            </tbody>
                     </table>        