<?php use yii\helpers\Url;
use yii\bootstrap\Modal;
 ?> 
<div id="routex">
<a href="javascript:void(0)" id="zonebacktrack" data-url=<?php echo Url::to(['reports/get-zone-generic']) ?>>Zone</a> ->
<a href="javascript:void(0)" id="routebacktrack" data-url=<?php echo Url::to(['reports/getroute-zonewise']) ?>>Route</a>
</div>

<input type="submit" name="Generate Report" data-zoneid="<?php echo $zoneid;?>" data-route="<?php echo $routeid?>" id="stopwise" class="btn btn-default pull-right" value="Generate Report" data-url=<?php echo Url::to(['reports/getstop-routewise-pdf']) ?> />

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
                                <a href="javascript:void(0)" id="passtoptostudent" data-stopid=<?= $queryy['stop_id']?> data-url= <?= Url::to(['reports/getstudent-stopwise']) ?>><?= $queryy['stop_name']?></a>
                                <input type="hidden" name="" id="zoneId" value="<?= $queryy['zone_id'];?>">


                                <!-- <input type="text" name="" id="passtoptostudent" value="<?//= $queryy['stop_name']?>" data-routeid=<?//= $queryy['stop_id'];?> data-url= <?//= Url::to(['reports/getstop-routewise']) ?> style="border: none;cursor: pointer;background: none!important;text-decoration: underline;" readonly/> -->
                                </td>
                                <td><?= $queryy['no_of_students_availed_transport'];?></td>
                            </tr>
                            <?php } ?>
                            </tbody>
                     </table>



      <?php 
         Modal::begin([
            'header'=>'<h4>Stop Students</h4>',
            'id'=>'modal',
            'size'=>'modal-lg',
         ]);

        echo "<div id='modalContent'></div>";
        Modal::end();
        ?>

