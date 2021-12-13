<?php 
  use yii\helpers\Url;
 ?>
 <a href="javascript:void(0)" class="YearCals" data-year="<?= $years; ?>" data-url="<?php echo Url::to(['reports/yearly-admission']) ?>">Newly Admission</a>-->

 <a href="javascript:void(0)" class="classwiseYearAdmisn" data-url=<?php echo Url::to(['reports/yearlyadmission-studentsno-classwise']) ?> data-year=<?= $years; ?>>Class Wise</a>

 <input type="submit" data-classid="<?= $classid; ?>"  data-year="<?= $years; ?>" value="Generate Report" class="classwiseYearAdmisnStudents btn btn-success" data-url="<?php echo Url::to(['reports/yearlyadmission-studentsno-classwise-studentpdf'])?>" name="Generate Report" />
                  <table class="table table-striped">

                  <table class="table table-striped">
                          <thead>
                          <tr>
                            <th>SR</th>
                            <th>Name</th>
                            <th>Father Name</th>
                            <th>Class Name</th>
                            <th>Group Name</th>
                            <th>Section Name</th>
                            <th>Registeration No.</th>
                            <th>Registeration Date</th>
                          

                            
                           </tr>
                           </thead>
                           <tbody>
                            <?php
                            $count=0;
                            $sum=0;
                           // echo '<pre>';print_r($year);die;
                             foreach ($yearAdmissionstudents as $years) {
                              $count++;

                              ?>
                            <tr>
                                <td><?php echo $count; ?></td>
                                <td><?php echo $years['student_name']; ?></td>
                                <td><?php echo $years['father_name']; ?></td>
                                <td><?php echo $years['class_name']; ?></td>
                                <td><?php echo $years['group_name']; ?></td>
                                <td><?php echo $years['section_name']; ?></td>
                                <td><?php echo $years['registration_no']; ?></td>
                                <td><?php echo $years['registration_date']; ?></td>
                                <td></td>

                                 <td></td>
                            </tr>
                            <?php } ?>
                            </tbody>
                            
                     </table>