                 
                  <table class="table table-striped">
                        <thead>
                          <tr>
                            <th>SR</th>
                            <th>Title</th>
                            <th>Group Title</th>
                            <th>Section Title</th>
                            <th>Leave Type</th>
                            <th>Total</th>

                            
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
                                <td><?php echo $queryy['title']; ?></td>
                                <td><?php if(empty($queryy['group_title'])){
                                  echo "N/A";
                                  }else{
                                    echo $queryy['group_title'];
                                    } ?></td>
                                <td><?php echo $queryy['section_title']; ?></td>
                                <td><?php echo $queryy['leave_type']; ?></td>
                                <td><?php echo $queryy['total']; ?></td>
                                <td></td>

                                 <td></td>
                            </tr>
                            <?php } ?>
                            </tbody>
                     </table>