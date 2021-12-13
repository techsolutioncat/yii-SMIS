<?php 
  use yii\helpers\Url;
 
 ?>     

           <div class="row">
    
                  <div class="col-md-12">
                  <table class="table table-striped">
                          <thead>
                          <tr>
                            <th>SR</th>
                          
                            <th>Total students issued SLC</th>
                          </tr>
                           </thead>
                           <tbody>
                            <?php
                           // $count=0;
                           // echo '<pre>';print_r($year);die;
                             //foreach ($leaveInfo as $leaveInfo) {
                            //  $count++;

                              ?>
                            <tr>
                                <td><?php echo '1'; ?></td>
  
                                <td>
                                <a class="leaveYear" href="javascript:void(0)" data-url=<?= Url::to(['reports/leave-scholl-class'])?> data-year=<?= $year;?>>
                                <?php echo $leaveInfo; ?>
                                </a>
                                </td>
                                <td></td>

                                 <td></td>
                            </tr>
                            <?php //} ?>
                            </tbody>
                     </table>
                     </div>
                     </div>