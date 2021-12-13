<?php use yii\helpers\Url; ?>    
        <a href="javascript:void(0)" class="cashflow" data-url=<?php echo Url::to(['reports/overll-cash-flow']) ?>>Cash Flow</a>
                  <table class="table table-striped">
                        <thead>
                          <tr>
                            <th>SR</th>
                          
                            <th>Class</th>
                            <th>Total Payment Received</th>

                            
                          </tr>
                        </thead>
                            <tbody>
                            <?php
                            $count=0;
                            $sum=0;
                             foreach ($query as $queryy) {
                              $count++;
                              $sum=$sum+$queryy['sum(fhw.payment_received)'] + $queryy['MAX(fhw.transport_fare)'];

                              ?>
                            <tr>
                            <td><?php echo $count; ?></td>

                                <td><a data-dates="<?php echo $date; ?>" id="classwiseDetail" href="javascript:void(0)" data-url="<?php echo Url::to(['reports/class-wise-fee']) ?>" data-classid=<?= $queryy['class_id'] ?>><?php echo $queryy['title']; ?></td>
                                <td><?php echo $queryy['sum(fhw.payment_received)'] + $queryy['MAX(fhw.transport_fare)']; ?></a></td>
                                <td></td>

                                 <td></td>
                            </tr>
                            <?php } ?>
                            <tr><th></th>
                            <th><td>Total Rs:<?php echo $sum ?></td></th>
                            </tr>
                            </tbody>    
                     </table> 