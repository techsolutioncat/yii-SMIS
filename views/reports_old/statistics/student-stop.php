<?php use yii\helpers\Url;
 ?> 


                  <table class="table table-striped">
                        <thead>
                           <tr>
                            <th>SR</th>
                            <th>Name</th>
                            <th>Father</th>
                            <th>Class Name</th>
                            <th>Group Name</th>
                            <th>Section Name</th>
                            <th>Contact No</th>
                            <th>Emergency Contact No</th>
                            <th>Zone</th>
                            <th>Route</th>
                            <th>Stop</th>
                            </tr>
                        </thead>
                            <tbody>
                            <?php 
                            $count=0;
                            foreach ($student as $queryy) {
                              $count++;
                              ?>
                            <tr>
                                <td><?= $count; ?></td>
                                <td><?= $queryy['student_name'];?></td>
                                <td><?= $queryy['father_name'];?></td>
                                <td><?= $queryy['class_name'];?></td>
                                <td><?= $queryy['group_name'];?></td>
                                <td><?= $queryy['section_name'];?></td>
                                <td><?= $queryy['contact_no'];?></td>
                                <td><?= $queryy['emergency_contact_no'];?></td>
                                <td><?= $queryy['zone_name'];?></td>
                                <td><?= $queryy['route_name'];?></td>
                                <td><?= $queryy['stop_name'];?></td>
                            </tr>
                            <?php } ?>
                            </tbody>
                     </table>



