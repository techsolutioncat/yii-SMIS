<table width="100%">
                        <thead>
                          <tr>
                            <th>SR</th>
                            <th>Zone</th>
                            <th>Total Students</th>
                            

                            
                          </tr>
                        </thead>
                            <tbody>
                            <?php 
                            $count=0;
                            foreach ($zone as $queryy) {
                              $count++;
                              ?>
                            <tr>
                            <td><?= $count; ?></td>
                                <td>
                                <?php echo $queryy['zone_name']?>
                                </td>
                                <td><?php echo $queryy['no_of_students_availed_transport'];?></td>
                            </tr>
                            <?php } ?>
                            </tbody>
                     </table>