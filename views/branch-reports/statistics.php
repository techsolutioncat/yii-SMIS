<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use yii\grid\GridView;
use app\models\StudentInfo;
use kartik\date\DatePicker;
use app\models\RefClass;
use app\models\RefSection;
use app\models\RefGroup;
use yii\widgets\ActiveForm;
use kartik\depdrop\DepDrop;



/* @var $this yii\web\View */

$this->title = 'Branch Reports :: Statistics';
?>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-8 col-xs-9 bhoechie-tab-container">
        <div class="col-lg-1 col-md-2 col-sm-3 col-xs-3 bhoechie-tab-menu">
            <div class="list-group">
                <a href="/new-student"  class="list-group-item active text-center">
                    Admission
                </a>
                <a href="<?= url::to(['/branch-reports/transport'])?>" class="list-group-item text-center">
                    Transport
                </a>
                <a href="/acadamic" class="list-group-item text-center">
                    Student Attendance
                </a>
                <a href="/new-acadamic" class="list-group-item text-center">
                    Withdrawal student
                </a>
            </div>
        </div>
        <div class="col-lg-11 col-md-10 col-sm-9 col-xs-9 bhoechie-tab">
            <!-- flight section -->
            <div class="bhoechie-tab-content active">
                <!-- tab 1  content-->

       <ul class="nav nav-tabs">
        <li class="active"><a data-toggle="tab" href="#home">New Admission Class wise</a></li>
        <li><a data-toggle="tab" href="#menu1">Promoted Class Wise</a></li>
        <li><a data-toggle="tab" href="#menu2">New Admission Average</a></li>
        <li><a data-toggle="tab" href="#menu3">Promoted Student Average</a></li>
      </ul> 
       <div class="tab-content">
            <div id="home" class="tab-pane fade in active">
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
            <div id="menu1" class="tab-pane fade">
              <p>
            <table class="table table-striped">
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
          </table>
              </p>
            </div>
            <div id="menu2" class="tab-pane fade">
              
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
            <div id="menu3" class="tab-pane fade">
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


            </div> <!-- end of tab 1 admission -->
            <!-- train section -->
            <div class="bhoechie-tab-content">
                <!-- tab 2 content -->
        <ul class="nav nav-tabs">
    <li class="active"><a data-toggle="tab" href="#homes">OverAll Transport</a></li>
    <li><a data-toggle="tab" href="#menus">Zone Wise Transport</a></li>
    <li><a data-toggle="tab" href="#menuss">Transport user class, group, section wise</a></li>
  </ul>

  <div class="tab-content">
    <div id="homes" class="tab-pane fade in active">
      <p>
          <?php
          //echo '<pre>';print_r($availTransport);?>
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
    foreach ($transport as $transports) {
   //echo '<pre>';print_r($withdrawlStud);
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
    </tbody>
  </table>
      </p>
    </div>
  
  <!-- start of overall transport -->
    <div id="menus" class="tab-pane fade">
      <p>
        <div class="showalltransport"></div>
      </p>
    </div>

  <!-- end of overall transport -->


    <div id="menuss" class="tab-pane fade">
      <p>
          
      </p>
    </div>
    
  </div>
</div>


                <!-- ///////////////////////////// -->
      

            <!-- hotel search -->
            <div class="bhoechie-tab-content">
                <!-- tab 3 content -->
                <ul class="nav nav-tabs">
                    <li class="active"><a data-toggle="tab" href="#attendance1">Over All Attendance Report In School</a></li>
                    <li><a data-toggle="tab" href="#attendance2">No Of Student Present In Class Wise</a></li>
                    <li><a data-toggle="tab" href="#attendance3">No Of Student Present In Group Wise</a></li>
                    <li><a data-toggle="tab" href="#attendance4">No Of Student Present In Section Wise</a></li>
                    <li><a data-toggle="tab" href="#attendance5">Date Wise Attendance Reports</a></li>
               </ul>
             <div class="tab-content">
                
                <div id="attendance1" class="tab-pane fade in active">
                <?php 
                $attendance_std_query = \app\models\StudentAttendance::find()
                ->select(['count(*) as total','student_attendance.leave_type'])
                ->innerJoin('student_info si','si.stu_id=student_attendance.fk_stu_id')
                ->where(['si.fk_branch_id'=>Yii::$app->common->getBranch(),'date(student_attendance.date)'=>date('Y-m-d'),'si.is_active'=>1])
                ->groupBy('student_attendance.leave_type')
                ->asArray()
                ->all();
                 ?>

                 <table class="table table-striped">
                    <thead>
                      <tr>
                        <th>Leave Type</th>
                        <th>Total Students</th>
                      </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($attendance_std_query as $overall) { ?>
                        <tr>
                            <td><?php echo ucfirst($overall['leave_type']); ?></td>
                            <td><?php echo $overall['total']; ?></td>

                        </tr>
                        <?php } ?>
                        </tbody>
                </table>

                 </div> <!-- end of attendance1 -->
                <div id="attendance2" class="tab-pane fade">
                   <?php $classwise=yii::$app->db->createCommand("select count(DISTINCT(sa.fk_stu_id)) as total,rc.class_id,rc.title,sa.leave_type from student_attendance sa inner join student_info si on si.stu_id=sa.fk_stu_id inner join ref_class rc on rc.class_id=si.class_id where si.fk_branch_id='".yii::$app->common->getBranch()."' and si.is_active=1 and date(sa.date)='".date("Y-m-d")."' group by rc.class_id,sa.leave_type")->queryAll();
                        
                            $class_wise_array=[];
                            $cls='';
                             foreach ($classwise as $claswise) {
                             // echo '<pre>';print_r($claswise);die;
                              $classid= $claswise['class_id'];
                              $leave_type = $claswise['leave_type'];
                                if($cls==''){
                                 if(isset($leave_type)){
                                     $class_wise_array[$classid][$leave_type] = $claswise['total'];
                                    }
                                
                                    $class_wise_array[$claswise['class_id']]['title'] = $claswise['title'];

                                }else if($cls == $classid){

                                    if(isset($leave_type)){
                                       $class_wise_array[$classid][$leave_type] = $claswise['total'];
                                    }
                                
                                    $class_wise_array[$claswise['class_id']]['title'] = $claswise['title'];
                                }else{
                                  if(isset($leave_type)){
                                      $class_wise_array[$classid][$leave_type] = $claswise['total'];
                                    }
                                
                                     $class_wise_array[$claswise['class_id']]['title'] = $claswise['title'];
                                    }


                                
                             ?>
                             
                            <?php 
                                $cls=$classid;

                            }
                           // echo "<pre>";print_r($class_wise_array);die;
                            ?>
                            <table class="table table-striped">
                            <thead>
                             <tr>
                            <th>Class</th>
                            <!-- <th>Leave Type</th> -->
                            <th>Present</th>
                            <th>Absent</th>
                            <th>Leave</th>
                            <th>Late Commer</th>
                            <!-- <th>Total Students</th> -->

                              </tr>
                            </thead>
                            <tbody>
                            
                            <?php 
                            //$sum=0;
                            foreach ($class_wise_array as $displayclass) {
                             // echo '<pre>';print_r($displayclass);
                             // continue;
                                 //$sum+= $displayclass;
                              ?>
                            <tr>
                              <td><?php echo $displayclass['title']; ?></td>
                              <td><?php if(isset($displayclass['present'])){
                                    echo  $displayclass['present']; ?>
                             <?php }else{
                                    echo "0";
                              }?>
                              </td>
                              <td><?php if(isset($displayclass['absent'])){
                              echo  $displayclass['absent'] ?>
                             <?php }else{
                                    echo "0";
                              }?>
                              </td>
                              <td><?php if(isset($displayclass['leave'])){
                              echo  $displayclass['leave']; ?>
                             <?php }else{
                                    echo "0";
                              }?>
                              </td>

                              <td><?php if(isset($displayclass['latecomer'])){
                              echo $displayclass['latecomer']; ?>
                             <?php }else{
                                    echo "0";
                              }?>
                              </td>
                              
                            </tr>
                              
                           <?php }
                           //echo $sum;
                          // die;
                            //echo "<pre>";print_r($class_wise_array);die;
                            ?>

                            </tbody>
                     </table>

                </div> <!-- end of attendance 2 -->
                <div id="attendance3" class="tab-pane fade">
                     <?php $groupwise=yii::$app->db->createCommand("select rc.class_id,rc.title,rg.group_id,rg.title as group_title, count(*) as `no_of_students_in_school`,leave_type from `student_attendance` st inner join student_info si on si.stu_id=st.fk_stu_id inner join ref_class rc on rc.class_id=si.class_id left join ref_group rg on rg.group_id=si.group_id where date(st.date)='".date('Y-m-d')."' and si.fk_branch_id='".yii::$app->common->getBranch()."' AND si.is_active=1 group by rc.class_id,rg.group_id,leave_type")->queryAll();

                        $groups_array=[];
                        $groupsVar='';
                        foreach ($groupwise as $grp) {
                            $cls_id=$grp['class_id'];
                            $g_group_type=$grp['leave_type'];
                            //echo 'pre>';print_r($grp);
                            if($groupsVar == ''){
                                if(isset($g_group_type)){

                                     $groups_array[$cls_id][$g_group_type] = $grp['no_of_students_in_school'];

                               }
                                     $groups_array[$grp['class_id']]['title'] = $grp['title'];
                                     $groups_array[$grp['class_id']]['group_title'] = $grp['group_title'];

                            }else if($groupsVar == $cls_id){
                                if(isset($g_group_type)){
                                       $groups_array[$cls_id][$g_group_type] = $grp['no_of_students_in_school'];
                                    }
                                     $groups_array[$grp['class_id']]['title'] = $grp['title'];
                                     $groups_array[$grp['class_id']]['group_title'] = $grp['group_title'];


                            }else{
                                if(isset($g_group_type)){
                                      $groups_array[$cls_id][$g_group_type] = $grp['no_of_students_in_school'];
                                    }
                                
                                     $groups_array[$grp['class_id']]['title'] = $grp['title'];
                                     $groups_array[$grp['class_id']]['group_title'] = $grp['group_title'];

                            }
                            
                            $groupsVar=$cls_id;
                        }
                           // echo "<pre>";print_r($groups_array);die;


                        
                        ?>
                     <table class="table table-striped">
                        <thead>
                          <tr>
                            <th>Class</th>
                            <th>Group</th>
                            <!-- <th>No Of student In school</th>
                            <th>Leave Type</th> -->
                            <th>Present</th>
                            <th>Absent</th>
                            <th>Leave</th>
                            <th>Late Commer</th>
                          </tr>
                        </thead>
                            <tbody>
                            <?php foreach ($groups_array as $group) {
                              //  echo '<pre>';print_r($group);
                               // continue;
                                if($group['group_title'] == NULL){

                                }else{
                             ?>
                            <tr>
                                <td><?php echo $group['title']; ?></td>
                                <td><?php if($group['group_title'] == ''){echo "N/A";}else{
                                echo $group['group_title'];
                                }
                                 ?></td>
                                <td><?php if(isset($group['present'])){
                                    echo  $group['present']; ?>
                             <?php }else{
                                    echo "0";
                              }?>
                              </td>
                                <td><?php if(isset($group['absent'])){
                                    echo  $group['absent']; ?>
                             <?php }else{
                                    echo "0";
                              }?>
                              </td>
                               <td><?php if(isset($group['leave'])){
                                    echo  $group['leave']; ?>
                             <?php }else{
                                    echo "0";
                              }?>
                              </td>
                              <td><?php if(isset($group['latecomer'])){
                                    echo  $group['latecomer']; ?>
                             <?php }else{
                                    echo "0";
                              }?>
                              </td>
                            </tr>
                            <?php } 
                           // die;
                            }
                            ?>
                            </tbody>
                     </table>
                </div> <!-- end of attendance 3 -->

                <div id="attendance4" class="tab-pane fade">
                <?php 
                $sectionQuery=yii::$app->db->createCommand("select count(DISTINCT(sa.fk_stu_id)) as total,rc.class_id,rc.title,rg.group_id,rg.title as group_title,rs.section_id,rs.title as section_title,sa.leave_type from student_attendance sa 
                    inner join student_info si on si.stu_id=sa.fk_stu_id
                    inner join ref_class rc on rc.class_id=si.class_id 
                    left join ref_group rg on rg.group_id=si.group_id
                    left join ref_section rs on rs.section_id=si.section_id
                    where si.fk_branch_id='".yii::$app->common->getBranch()."' and si.is_active=1 and date(sa.date)='".date("Y-m-d")."' 
                    group by rc.class_id,rc.title,rg.group_id,rg.title,rs.section_id,rs.title,sa.leave_type")->queryAll();
                  $section_array=[];
                $sectionId="";
                $classId="";
                //echo count($sectionQuery);
                foreach ($sectionQuery as $key=>$section) {
                    $section_leave_type=$section['leave_type'];
                    $class_id= $section['class_id'];
                    $section_id= $section['section_id'];

                    if($classId == '' && $sectionId ==''){
                        //echo '1<br/>';
                        if(isset($section_leave_type)){
                         $section_array[$class_id.'_'.$section['section_id']][$section_leave_type] = $section['total'];
                        }
                        $section_array[$section['class_id'].'_'.$section['section_id']]['title'] = $section['title'];
                        $section_array[$section['class_id'].'_'.$section['section_id']]['group_title'] = $section['group_title'];
                        $section_array[$section['class_id'].'_'.$section['section_id']]['section_title'] = $section['section_title'];
                    }
                    else if($classId == $class_id && $sectionId == $section_id ){
                        //echo '2<br/>';
                        if(isset($section_leave_type)){
                               $section_array[$class_id.'_'.$section['section_id']][$section_leave_type] = $section['total'];
                        }
                        $section_array[$section['class_id'].'_'.$section['section_id']]['title'] = $section['title'];
                        $section_array[$section['class_id'].'_'.$section['section_id']]['group_title'] = $section['group_title'];
                        $section_array[$section['class_id'].'_'.$section['section_id']]['section_title'] = $section['section_title'];
                    }else{
                        //echo '3<br/>';
                        if(isset($section_leave_type)){
                            $section_array[$class_id.'_'.$section['section_id']][$section_leave_type] = $section['total'];
                        }
                        $section_array[$section['class_id'].'_'.$section['section_id']]['title'] = $section['title'];
                        $section_array[$section['class_id'].'_'.$section['section_id']]['group_title'] = $section['group_title'];
                        $section_array[$section['class_id'].'_'.$section['section_id']]['section_title'] = $section['section_title'];
                    }

                   //echo $classId."---".$class_id.'----'.$sectionId."<br/>";

                    $classId    = $section['class_id'];
                    $sectionId  = $section['section_id'];

                 }

               // die; 
                // echo '<pre>';print_r($section_array);die;
                 ?>

                 <table class="table table-striped">
                        <thead>
                          <tr>
                            <th>Class</th>
                            <th>Group</th>
                            <th>Section</th>
                           
                            <th>Present</th>
                            <th>Absent</th>
                            <th>Leave</th>
                            <th>Late Commer</th>
                          </tr>
                        </thead>
                            <tbody>
                            <?php foreach ($section_array as $sections) {
                               // echo $sections['present'];

                               // echo '<pre>';print_r($sections);
                               // continue;
                                
                             ?>
                            <tr>
                                <td><?php echo $sections['title']; ?></td>
                                <td><?php if($sections['group_title'] == ''){echo "N/A";}else{
                                      echo $sections['group_title'];
                                }
                                 ?></td>

                                 <td><?php if($sections['section_title'] == ''){echo "N/A";}else{
                                echo $sections['section_title'];
                                }
                                 ?></td>
                                <td><?php if(isset($sections['present'])){
                                    echo  $sections['present']; ?>
                             <?php }else{
                                    echo "0";
                              }?>
                              </td>
                                <td><?php if(isset($sections['absent'])){
                                    echo  $sections['absent']; ?>
                             <?php }else{
                                    echo "0";
                              }?>
                              </td>
                               <td><?php if(isset($sections['leave'])){
                                    echo  $sections['leave']; ?>
                             <?php }else{
                                    echo "0";
                              }?>
                              </td>
                              <td><?php if(isset($sections['latecomer'])){
                                    echo  $sections['latecomer']; ?>
                             <?php }else{
                                    echo "0";
                              }?>
                              </td>
                            </tr>
                            <?php 
                            }
                            //die;
                            ?>
                            </tbody>
                     </table>
                </div> <!-- end of attendance4 -->

                <div id="attendance5" class="tab-pane fade">
                <p>
                    <div class="row">
                        <div class="col-md-6">
                            <label>OverAll</label>
                            <input type="radio" name="overall" id="overallAtt" checked="checked" />&nbsp;&nbsp;
                            <label>Other</label>
                            <input type="radio" name="overall" id="other" />&nbsp;&nbsp;
                            
                        </div>
                        </div>
                        <div class="row">
                        
                        <div class="col-md-2">
                    
                            <?php 
                                 echo '<label>Start Date:</label>';
                                        echo DatePicker::widget([
                                        'name' => 'overallstart', 
                                        'value' => date('d-m-Y'),
                                        'options' => ['placeholder' => ' ','id'=>'startDate'],
                                        'pluginOptions' => [
                                            'format' => 'dd-m-yyyy',
                                            'todayHighlight' => true,
                                            'autoclose'=>true,
                                        ]
                                      ]);?>

                            </div>
                            <!-- start of class -->
                           <div class="col-md-2">

                               <?php echo '<label>End Date:</label>';
                                        echo DatePicker::widget([
                                        'name' => 'overallEnd', 
                                        'value' => date('d-m-Y'),
                                        'options' => ['placeholder' => ' ','id'=>'endDate'],
                                        'pluginOptions' => [
                                            'format' => 'dd-m-yyyy',
                                            'todayHighlight' => true,
                                            'autoclose'=>true,
                                        ]
                                      ]);
                                                                                   
                                
                              ?>
                        </div>
                      <!-- end of class -->

                      <!-- testing -->
    <div class="form-center shade fee-gen" style="display: none">
         <?php $form = ActiveForm::begin(); ?> 
        <div class="row">
            <div class="col-sm-3">
            <?php 
            $class_array = ArrayHelper::map(\app\models\RefClass::find()->where(['fk_branch_id'=>Yii::$app->common->getBranch()])->all(), 'class_id', 'title'); 
             ?>
                <?= $form->field($model, 'class_id')->dropDownList($class_array, ['id'=>'class-id','prompt' => 'Select Class ...']); ?>
            </div>
            <div class="col-sm-3"> 
                <?php
                // Dependent Dropdown
                echo $form->field($model, 'group_id')->widget(DepDrop::classname(), [
                    'options' => ['id'=>'group-id'],
                    'pluginOptions'=>[
                        'depends'=>['class-id'],
                        'prompt' => 'Select Group...',
                        'url' => Url::to(['/site/get-group'])
                    ]
                ]);
                ?>
            </div>
            <div class="col-sm-3">
                <?php
                
                // Dependent Dropdown
                echo $form->field($model, 'section_id')->widget(DepDrop::classname(), [
                    'options' => ['id'=>'section-ids'],
                    'pluginOptions'=>[
                        'depends'=>[
                            'group-id','class-id'
                        ],
                        'prompt' => 'Select section',
                        'url' => Url::to(['/site/get-section'])
                    ]
                ]);
                ?>
            </div>
        </div> 
        <?php ActiveForm::end(); ?>
    </div>  
    <div id="subject-inner"></div>
                      <!-- end of testing -->
                        <br>
                        <div class="col-md-2">

                            <input type="submit" name="submit" class="submitAttendance btn btn-success" data-url="<?php echo Url::to(['reports/show-overall'])?>" />

                            <input type="submit" name="submits" id="submitcls" class="submitcls btn btn-success" data-url="<?php echo Url::to(['reports/show-cls'])?>" style="display: none" />
                        </div>
                    </div>

                    <div class="row">
                        <div id="overalls"></div><br />
                        <div id="overallsCls"></div>
                        <div id="overallsGrps"></div>

                    </div>
                  

                </p>
                </div>

            </div>

            </div>  
            <!-- end of tab 3 -->
            </div>
            <div class="bhoechie-tab-content">
                <!-- tab 4 content -->

                
            </div>
            <div class="bhoechie-tab-content">
               
            </div>
        </div>
    </div>
</div>

<input type="hidden" id="zone" data-url=<?php echo Url::to(['branch-reports/get-all-zone-generic']) ?>>

<?php 
$script= <<< JS
$(document).ready(function() {

var url=$('#zone').data('url');
//alert(url);
$.ajax
        ({
            type: "POST",
            dataType:"JSON",
            //data: dataString,
            url: url,
            cache: false,
            success: function(html)
            {
              //console.log(html.zonegenric);
                $(".showalltransport").html(html.zonegenric);
            } 
        });
});

JS;
$this->registerJs($script);

?>