<?php use yii\helpers\Url;
 ?> 


                  <table class="table table-striped">
                        <thead>
                           <tr>
                            <th>SR</th>
                            <th>Title</th>
                            <th>Payment Received</th>
                            
                            </tr>
                        </thead>
                            <tbody>
                            <?php 
                            $count=0;
                            $total=0;
                            foreach ($query as $queryy) {
                              $count++;
                              $total=$total+$queryy['payment_received'];
                              ?>
                            <tr>
                                <td><?= $count; ?></td>
                                <td><?= $queryy['title'];?></td>
                                <td><?= $queryy['payment_received'];?></td>
                                
                            </tr>
                            <?php }
                            foreach ($extrahead_query as $query_extrahead) {
                            $count++;
                            $total=$total+$query_extrahead['payment_received'];
                            ?>
                            <tr>
                                <td><?= $count; ?></td>
                                <td><?= $query_extrahead['title'];?></td>
                                <td><?= $query_extrahead['payment_received'];?></td>

                            </tr>
                           
                            <?php } ?>
                              <tr>
                               <td><?= $count + 1;?></td>
                               <td>transport fare</td>
                               <td><?= $transportFare['transport_fare'];?></td>
                               
                           
                           </tr> 
                            <tr><th></th><td></td>
                            <th>Total: Rs. <?php echo $total + $transportFare['transport_fare']; ?></th></tr>

                            </tbody>
                     </table>
                



