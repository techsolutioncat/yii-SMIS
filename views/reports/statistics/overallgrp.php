                  <table class="table table-striped">
                        <thead>
                          <tr>
                            <th>Title</th>
                            <th>Leave Type</th>
                            <th>Total</th>

                            
                          </tr>
                        </thead>
                            <tbody>
                            <?php foreach ($query as $queryy) {?>
                            <tr>
                                <td><?php echo $queryy['title']; ?></td>
                                <td><?php echo $queryy['leave_type']; ?></td>
                                <td><?php echo $queryy['total']; ?></td>
                                <td></td>

                                 <td></td>
                            </tr>
                            <?php } ?>
                            </tbody>
                     </table>