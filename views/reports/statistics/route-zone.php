<?php use yii\helpers\Url; ?>
 <style type="text/css">#pasroutetostop:hover{color:blue;}</style>
                 <div id="routex"><a href="javascript:void(0)" id="zonebacktrack" data-url=<?php echo Url::to(['reports/get-zone-generic']) ?>>Zone</a></div>
                 <input type="submit" name="Generate Report" data-zoneid="<?php echo $zoneid;?>" id="overalltransportroute" class="btn btn-default pull-right" value="Generate Report" data-url=<?php echo Url::to(['reports/getroutewise-pdf']) ?> />
                  <table class="table table-striped">
                        <thead>
                          <tr>
                            <th>SR</th>
                            <th>Route</th>
                            <th>Total Students</th>
                            

                            
                          </tr>
                        </thead>
                            <tbody>
                            <?php 
                            $count=0;
                            foreach ($route as $queryy) {
                              $count++;
                              ?>
                            <tr>
                            <td><?= $count; ?></td>
                                <td><input type="text" name="" id="pasroutetostop" value="<?= $queryy['route_name']?>" data-routeid=<?= $queryy['route_id'];?> data-zoneid=<?= $queryy['zone_id'];?> data-url= <?= Url::to(['reports/getstop-routewise']) ?> style="border: none;cursor: pointer;background: none!important;text-decoration: underline;" readonly/>
                                </td>
                                <td><?= $queryy['no_of_students_availed_transport'];?></td>
                            </tr>
                            <?php } ?>
                            </tbody>
                     </table>