<?php 
use yii\helpers\Url;
 ?>
<ul class="nav nav-pills">
		    <li class="active"><a data-toggle="tab" href="#Admission">Admission</a></li>
		    <li><a data-toggle="tab" href=".Transport">Transport</a></li>
		    
		  </ul>
    <div id="Admission" class="tab-pane fade in active">
    <br />
  <ul class="nav nav-tabs">
    <li class="active"><a data-toggle="tab" href=".home">New Admission Class Wise</a></li>
    <li><a data-toggle="tab" href=".promotedclass">Promoted Class Wise</a></li>
    <li><a data-toggle="tab" href=".admaverage">New Admission Average</a></li>
    <li><a data-toggle="tab" href=".promotedaverage">Promoted Student Average</a></li>
  </ul>

  <div class="tab-content">
    <div class="tab-pane fade in active home">

      <p>
      	<div class="row">
              <div class="col-md-6">
              <table class="table table-striped">
            <thead>
              <tr>
                  <th>S.No</th>
                  <th>Class</th>
                <th>No Of Confirmed New Admission</th>
              </tr>
            </thead>
            <tbody>
            <?php
            $classwise_counter=1;
            //echo '<pre>';print_r($getclaswise);
             foreach ($getclaswise as $clswise) { ?>
              <tr>
                <td><?php echo $classwise_counter; ?></td>
                <td><?php echo $clswise['class_name']; ?></td>
                <td><?php echo $clswise['No_of_new_admission_class_wise']; ?></td>
              </tr>
              <?php
                 $classwise_counter++;
             } ?>
            </tbody>
          </table>
          </div>
          <div class="col-md-6">
              <table class="table table-striped">
            <thead>
              <tr>
              <th>S.No</th>
              <th>Class</th>
                <th>Not Confirmed</th>
              </tr>
            </thead>
            <tbody>
            <?php
            $getclaswiseDeactive_counter = 1;
            //echo '<pre>';print_r($getclaswise);
             foreach ($getclaswiseDeactive as $clswiseDeactive) { ?>
              <tr>
                <td><?php echo $getclaswiseDeactive_counter; ?></td>
                <td><?php echo $clswiseDeactive['class_name']; ?></td>

                <td><?php echo $clswiseDeactive['No_of_new_admission_class_wise']; ?></td>
              </tr>
              <?php
                 $getclaswiseDeactive_counter++;
             } ?>
            </tbody>
          </table>
          </div>
          </div>
      </p>
    </div>
    <div class="tab-pane fade promotedclass">
      
      <p><table class="table table-striped">
            <thead>
              <tr>
                  <th>S.No</th>
                  <th>Class</th>
                <th>No of promoted class wise</th>
              </tr>
            </thead>
            <tbody>
            <?php
            $promotedclaswise_counter= 1;
            foreach ($promotedclaswise as $promotedclaswis) { ?>
              <tr>
                <td><?php echo $promotedclaswise_counter; ?></td>
                <td><?php echo $promotedclaswis['class_name']; ?></td>
                <td><?php echo $promotedclaswis['No_of_new_promoted_class_wise']; ?></td>
              </tr>
              <?php
                $promotedclaswise_counter++;
            } ?>
            </tbody>
          </table></p>
    </div>
    <div class="tab-pane fade admaverage">
      
      <p>
      	<table class="table table-striped">
            <thead>
              <tr>
                  <th>S.No</th>
                <th>Class</th>
                <th>No of Students</th>
                <th>Average</th>
              </tr>
            </thead>
            <tbody>
            <?php
            $newadmisnAvg_counter= 1;
            foreach ($newadmisnAvg as $newadmisnAvgx) { ?>
              <tr>
                <td><?php echo $newadmisnAvg_counter; ?></td>
                <td><?php echo $newadmisnAvgx['class_name']; ?></td>
                <td><?php echo $newadmisnAvgx['No_Of_Student']; ?></td>
                <td><?php echo round($newadmisnAvgx['Average_Newly_Admitted_Students_per_Class'],2).' %'; ?></td>
              </tr>
              <?php
                $newadmisnAvg_counter++;
            } ?>
            </tbody>
          </table>
      </p>
    </div>
    <div class="tab-pane fade promotedaverage">
      
      <p>
      	<table class="table table-striped">
            <thead>
              <tr>
                <th>Class</th>
                <th>No of Students</th>
                <th>Average</th>
              </tr>
            </thead>
            <tbody>
            <?php foreach ($promtedclasswixeAvg as $promtedclasswixeAvg) { ?>
              <tr>
                <td><?php echo $promtedclasswixeAvg['class_name']; ?></td>
                <td><?php echo $promtedclasswixeAvg['No_Of_Student']; ?></td>
                <td><?php echo round($promtedclasswixeAvg['Average_Promoted_Students_per_Class'],2).' %'; ?></td>
              </tr>
              <?php } ?>
            </tbody>
          </table>
      </p>
    </div>
  </div>
    </div>
    <div class="tab-pane fade Transport">
      <ul class="nav nav-tabs">
	    <li class="active"><a data-toggle="tab" href=".homes">OverAll Transport</a></li>
	    <li><a data-toggle="tab" href=".zonewise">Zone Wise Transport</a></li>
	    <li><a data-toggle="tab" href=".truser">Transport user class, group, section wise</a></li>
	  </ul>


	  <div id="" class="tab-pane fade in active homes">
       
      <p>
      	<table class="table table-striped" style="width:20%;">
            <thead>
            <tr>
                <th>No of Students who Avail Transport</th>
                <th><?php echo $availTransport; ?></th>

            </tr>
            </thead>
        </table>

        <h3>Over All Transport Student Wise</h3>
        <table class="table table-striped">
    <thead>
      <tr>
        <th>S.No</th>
        <th>Student Name</th>
        <th>Zone</th>
        <th>Route</th>
        <th>Stop</th>
        <th>Fare</th>
      </tr>
    </thead>
    <tbody>
    <?php
    $transport_counter=1;
    $sum=0;
    foreach ($transport as $transports) {
   //echo '<pre>';print_r($withdrawlStud);
    	$sum=$sum+$transports['fare'];

    ?>
      <tr>
        <td><?= $transport_counter; ?></td>
        <td><?= $transports['student_name'] ?></td>
        <td><?= $transports['zone_name'] ?></td>
        <td><?= $transports['route_name'] ?></td>
        <td><?= $transports['stop_name'] ?></td>
        <td><?= $transports['fare'] ?></td>
      </tr>
      <?php
        $transport_counter++;
    } ?>
    <tr><th></th><th></th><th></th><th></th><th></th><th>Total Rs:<?= $sum;?></th></tr>
    </tbody>
  </table>
      </p>
    </div>

    <div id="" class="tab-pane fade zonewise">
       <div class="row xone">
      <p>
      <table class="table table-striped">
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
                            // echo '<pre>';print_r($zone);
                            foreach ($zone as $queryy) {
                              $count++;
                              ?>
                            <tr>
                            <td><?= $count; ?></td>
                                <td><input type="text" name="" id="paszonetoroute" value="<?= $queryy['zone_name']?>" data-zoneid=<?= $queryy['zone_id'];?> data-url= <?= Url::to(['branch-reports/getroute-zonewise']) ?> style="border: none;cursor: pointer;background: none!important;text-decoration: underline;" readonly/>
                                </td>
                                <td><?= $queryy['no_of_students_availed_transport'];?></td>
                            </tr>
                            <?php } ?>
                            </tbody>
                     </table>
                     </div>
                     <div class="showalltransport"></div>
                     
      	
      </p>
    </div>

    <div id="" class="tab-pane fade truser">
       
      <p>
      users
      	
      </p>
    </div>

    </div>
    
    
  </div>



  