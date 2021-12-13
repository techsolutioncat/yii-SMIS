<?php 
  use yii\helpers\Url;
 ?>

 <a href="javascript:void(0)" class="YearCals" data-year="<?= $getyear; ?>" data-url="<?php echo Url::to(['reports/yearly-admission']) ?>">Yearly Admission</a>

 <input type="submit" data-year="<?= $getyear; ?>" name="Generate Report"  value="Generate Report" class="classwiseYearAdmisn btn btn-success" data-url="<?php echo Url::to(['reports/classwise-pdf'])?>" />
                  <table class="table table-striped">
                          <thead>
                          <tr>
                            <th>SR</th>
                            <th>Class</th>
                          
                            <th>No Of Students</th>

                            
                           </tr>
                           </thead>
                           <tbody>
                            <?php
                            $count=0;
                            $sum=0;
                           // echo '<pre>';print_r($year);die;
                             foreach ($years as $years) {
                              $count++;
                              $sum=$sum+$years['No_of_students'];

                              ?>
                            <tr>
                                <td><?php echo $count; ?></td>
                                <td><?php echo $years['class_wise']; ?></td>

  
                                <td>
                                <a data-classid=<?= $years['class_id']; ?> class="classwiseYearAdmisnStudents" href="javaScrip:Void(0)" data-url=<?= Url::to(['reports/yearlyadmission-studentsno-classwise-student'])?> data-year=<?= $getyear;?>>
                                <?php echo $years['No_of_students']; ?>
                                </a>
                                </td>
                                <td></td>

                                 <td></td>
                            </tr>
                            <?php } ?>
                            </tbody>
                            <tfoot>
                              <tr>
                                <td></td>
                                <td></td>
                                <td>Total Students: <?= $sum; ?></td>
                              </tr>
                            </tfoot>
                     </table>