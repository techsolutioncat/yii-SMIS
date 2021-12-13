                  <table class="table table-striped">
                        <thead>
                          <tr>
                            <th>SR</th>
                          
                            <th>Leave Type</th>
                            <th>Total Students</th>

                            
                          </tr>
                        </thead>
                            <tbody>
                            <?php
                            $count=0;
                             foreach ($query as $queryy) {
                              $count++;

                              ?>
                            <tr>
                            <td><?php echo $count; ?></td>

                                <td><?php echo $queryy['leave_type']; ?></td>
                                <td><?php echo $queryy['total']; ?></td>
                                <td></td>

                                 <td></td>
                            </tr>
                            <?php } ?>
                            </tbody>
                     </table>