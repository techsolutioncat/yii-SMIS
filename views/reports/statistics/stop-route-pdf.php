
                  <table class="table table-striped">
                        <thead>
                           <tr>
                            <th>SR</th>
                            <th>Stop</th>
                            <th>Total Students</th>
                            </tr>
                        </thead>
                            <tbody>
                            <?php 
                            $count=0;
                            foreach ($stop as $queryy) {
                              $count++;
                              ?>
                            <tr>
                            <td><?= $count; ?></td>
                                <td>
                               
                                <?= $queryy['stop_name']?>


                                <!-- <input type="text" name="" id="passtoptostudent" value="<?//= $queryy['stop_name']?>" data-routeid=<?//= $queryy['stop_id'];?> data-url= <?//= Url::to(['reports/getstop-routewise']) ?> style="border: none;cursor: pointer;background: none!important;text-decoration: underline;" readonly/> -->
                                </td>
                                <td><?php echo  $queryy['no_of_students_availed_transport'];?></td>
                            </tr>
                            <?php } ?>
                            </tbody>
                     </table>