<?php 
  use yii\helpers\Url;
 ?>
                  <table class="table table-striped">
                          <thead>
                          <tr>
                            <th>SR</th>
                          
                            <th>Newly Confirmed Students</th>
                          </tr>
                           </thead>
                           <tbody>
                            <?php
                            $count=0;
                           // echo '<pre>';print_r($year);die;
                             foreach ($year as $years) {
                              $count++;

                              ?>
                            <tr>
                                <td><?php echo $count; ?></td>
  
                                <td>
                                <a class="classwiseYearAdmisn" href="javascript:void(0)" data-url=<?= Url::to(['reports/yearlyadmission-studentsno-classwise'])?> data-year=<?= $getyear;?>>
                                <?php echo $years['Total_No_of_students_Newly_confirmed_admitted']; ?>
                                </a>
                                </td>
                                <td></td>

                                 <td></td>
                            </tr>
                            <?php } ?>
                            </tbody>
                     </table>