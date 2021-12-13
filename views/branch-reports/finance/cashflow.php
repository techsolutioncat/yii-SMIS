<?php use yii\helpers\Url;
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
                          foreach ($query as $queryy) {
                            $count++;
                            ?>
                          <tr>
                              <td><?= $count; ?></td>
                              <td><?= $queryy['DATE_PURCHASED'];?></td>
                              <td><?= $queryy['dayname(fhw.created_date)'];?></td>
                              <td>Rs. <?= $queryy['fee_received'];?></td>
                              
                          </tr>
                          <?php } ?>
                          </tbody>
                   </table>



