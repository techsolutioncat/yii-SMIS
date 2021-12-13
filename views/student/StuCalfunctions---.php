<?php 
use yii\helpers\Url;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\grid\GridView;
use app\models\ExamType;
use app\models\StudentAttendance;
use yii\widgets\ActiveForm;
use app\models\StudentInfo;
use app\models\WorkingDays;
$this->registerCss(" select {
    -webkit-appearance: none;
    -moz-appearance: none;
    text-indent: 1px;
    text-overflow: '';
    height: 40px;
}");
$this->registerJsFile(Yii::getAlias('@web').'/js/studentCalender.js',['depends' => [yii\web\JqueryAsset::className()]]);
/*
 * Function requested by Ajax
 */

if(isset($_POST['func']) && !empty($_POST['func'])){
    switch($_POST['func']){
        case 'getCalender':
            getCalender($_POST['year'],$_POST['month'],$_POST['class_id'],$_POST['group_id'],$_POST['section_id']);
            break;
      
            default:
            break;
    }
}

/*
 * Get calendar full HTML
 */
  
function getCalender($year = '',$month = '',$class,$group,$section)
{

    $dateYear = ($year != '')?$year:date("Y");
    $dateMonth = ($month != '')?$month:date("m");
    $date = $dateYear.'-'.$dateMonth.'-01';
    $currentMonthFirstDay = date("N",strtotime($date));
    $totalDaysOfMonth = cal_days_in_month(CAL_GREGORIAN,$dateMonth,$dateYear);
    $totalDaysOfMonthDisplay = ($currentMonthFirstDay == 7)?($totalDaysOfMonth):($totalDaysOfMonth + $currentMonthFirstDay);
    $boxDisplay = ($totalDaysOfMonthDisplay <= 35)?35:42;
?>
    <div id="calender_section" class="fullCalendar">
    
        <div class="row">
<div class="col-md-12">     
<div id="calender_section">
        <h2>

            <a class="newyear" href="javascript:void(0);" onclick="getCalendar('calendar_div','<?php echo date("Y",strtotime($date.' - 1 Month')); ?>','<?php echo date("m",strtotime($date.' - 1 Month')); ?>','<?php echo $class; ?>','<?php echo $group; ?>','<?php echo $section; ?>');">&lt;&lt;</a>
            <select name="month_dropdown" class="month_dropdown dropdown" disabled="disabled"><?php echo getAllMonths($dateMonth); ?></select>
            <select name="year_dropdown" class="year_dropdown dropdown" disabled="disabled"><?php echo getYearList($dateYear); ?></select>
            <a href="javascript:void(0);" onclick="getCalendar('calendar_div','<?php echo date("Y",strtotime($date.' + 1 Month')); ?>','<?php echo date("m",strtotime($date.' + 1 Month')); ?>','<?php echo $class; ?>','<?php echo $group; ?>','<?php echo $section; ?>');">&gt;&gt;</a>
        </h2>
        </div>
        </div>
        </div> 
        <!-- <div id="event_list" class="none"></div> -->
        
        <div class="row">
        <div class="col-md-12">
    
        <table class="table table-striped table-bordered" cellspacing="0" width="100%" style="margin-left: -210px;">
        <div> <!--remove id id="calender_section_bot" -->
            <tr>
        <th>Full Name</th>
            <?php 
                $dayCount = 1; 
                for($cb=1;$cb<=$boxDisplay;$cb++){
                    if(($cb >= $currentMonthFirstDay+1 || $currentMonthFirstDay == 7) && $cb <= ($totalDaysOfMonthDisplay)){
                        //Current date
                        $currentDate = $dateYear.'-'.$dateMonth.'-'.$dayCount;
                        $eventNum = 0;
                        
                        if(strtotime($currentDate) == strtotime(date("Y-m-d"))){
                            echo '<th date="'.$currentDate.'" class="grey date_cell">';
                        }elseif($eventNum > 0){
                            echo '<th date="'.$currentDate.'" class="light_sky date_cell">';
                        }else{
                            echo '<th date="'.$currentDate.'" class="date_cell">';
                        }
                        //Date cell
                        echo '<span>';
                        echo $dayCount;
                        //echo date('D',strtotime($currentDate));
                        echo '</span>';
                        
                        echo '</div></div>';
                        echo '</th>';
                        $dayCount++;
            ?>
            <?php }else{ ?>
                <!-- <li><span>&nbsp;</span></li> -->
            <?php } } ?>
            </tr>

            <!-- //geting day name -->
            <tr>
        <th></th>
            <?php 
                $dayCount = 1; 
                for($cb=1;$cb<=$boxDisplay;$cb++){
                    if(($cb >= $currentMonthFirstDay+1 || $currentMonthFirstDay == 7) && $cb <= ($totalDaysOfMonthDisplay)){
                        //Current date
                        $currentDate = $dateYear.'-'.$dateMonth.'-'.$dayCount;
                        $eventNum = 0;
                        
                        if(strtotime($currentDate) == strtotime(date("Y-m-d"))){
                            echo '<th date="'.$currentDate.'" class="grey date_cell">';
                        }elseif($eventNum > 0){
                            echo '<th date="'.$currentDate.'" class="light_sky date_cell">';
                        }else{
                            echo '<th date="'.$currentDate.'" class="date_cell">';
                        }
                        //Date cell
                        echo '<span>';
                        //echo $dayCount;
                        echo date('D',strtotime($currentDate));
                        echo '</span>';
                        
                        echo '</div></div>';
                        echo '</th>';
                        $dayCount++;
            ?>
            <?php }else{ ?>
                <!-- <li><span>&nbsp;</span></li> -->
            <?php } } ?>
            </tr>
            <!-- end of day name -->

            <?php

            //$class_id = $_POST['class_id'];
            //$group_id = $_POST['group_id'];
           // $section_id = $_POST['section_id'];
            

            $emp=StudentInfo::find()->where([
                        'fk_branch_id'  =>Yii::$app->common->getBranch(),
                        'is_active'=>1,
                        'class_id'   => $class,
                        'group_id'   => ($group)?$group:null,
                        'section_id' => $section,
                ])->All();
            foreach ($emp as $q) { ?>

            <tr>
            <td><?php echo Yii::$app->common->getName($q->user_id);?> 
            </td>
            
            <?php 
                $dayCount = 1; 
                for($cb=1;$cb<=$boxDisplay;$cb++){
                    if(($cb >= $currentMonthFirstDay+1 || $currentMonthFirstDay == 7) && $cb <= ($totalDaysOfMonthDisplay)){
                        //Current date
                        $currentDate = $dateYear.'-'.$dateMonth.'-'.$dayCount;
                        $eventNum = 0;
                        
                        if(strtotime($currentDate) == strtotime(date("Y-m-d"))){
                            echo '<th date="'.$currentDate.'" class="grey date_cell">';
                        }elseif($eventNum > 0){
                            echo '<th date="'.$currentDate.'" class="light_sky date_cell">';
                        }else{
                            echo '<th date="'.$currentDate.'" class="date_cell">';
                        }
                        //Date cell
                        echo '<span class="popup" emp_id="'.$q->stu_id.'" date="'.$currentDate.'">';


                $attendance =StudentAttendance::find()->where(['fk_stu_id'=>$q->stu_id]) 
               ->andWhere(['between', 'date', $currentDate.' 00:00:00', $currentDate.' 23:59:59'])->orderBy(['id' => SORT_DESC])->limit(1)
               ->all();
             $GetWorkingdays=WorkingDays::find()->select('title')->where(['is_active'=>1,'fk_branch_id'=>Yii::$app->common->getBranch()])->All();
             foreach($GetWorkingdays as $working){
                        ?>

                    <span>
                    <?php 
                   // echo date_default_timezone_get();
                    //echo date("H:i"); 
                    //echo $currentDate .' '. date("H:i:s") ;
                    $ss=$Compare_date=date('d');
                    $dd=date('d',strtotime($currentDate));
                    $offSettingDay=date('D',strtotime($currentDate));

                    $mm=$Compare_date=date('m');
                    $mcalendr=date('m',strtotime($currentDate));
                    $offdayscheck=$working->title;
                    $curdate=date('Y-m-d');
                    $c_datess= strtotime($curdate);
                    $s_datess=  strtotime($currentDate);
                    // echo $mydate=date('Y-m-d',strtotime($currentDate));
                    if($c_datess < $s_datess && $offdayscheck == $offSettingDay)
                    {?>
                    <a href="" data-stu_name=<?php echo Yii::$app->common->getName($q->user_id);?> data-toggle="modal" data-target="#myModal" data-empid="<?php echo $q->stu_id;?>" data-date="<?php echo $currentDate .' '. date('H:i:s')?>" class="studentAttendance" id="emp_<?php echo $q->stu_id.date('d',strtotime($currentDate))?>" data-urls=<?php echo yii\helpers\Url::to(['student/save-stu-id'])?>>&nbsp; &nbsp;&nbsp;</a>
                    <?php }?>
                    <?php if($ss <= $dd && $mm >= $mcalendr && $offdayscheck == $offSettingDay){ ?>
                    
                    
                    <a href="" data-stu_name=<?php echo Yii::$app->common->getName($q->user_id);?> data-toggle="modal" data-target="#myModal" data-empid="<?php echo $q->stu_id;?>" data-date="<?php echo $currentDate .' '. date('H:i:s')?>" class="studentAttendance" id="emp_<?php echo $q->stu_id.date('d',strtotime($currentDate))?>" data-urls=<?php echo yii\helpers\Url::to(['student/save-stu-id'])?>>
                    
                    &nbsp; &nbsp;&nbsp;</a>

                    

                    <?php }else{
                        
                    }
                    }
                     ?>
                        <?php 
                            foreach ($attendance as $attend) {
                                $getCurrentD= date('d',strtotime($currentDate));
                                  $date= date('d',strtotime($attend->date));
                                    if($getCurrentD == $date){
                                         if($attend->leave_type == 'absent'){
                                            
                                            echo '<span style="color:red">A</span>';
                                            
                                         }else if($attend->leave_type == 'leave'){?>
                                            
                                            <span class="leaveid" id="emp_<?php echo $q->stu_id.date('d',strtotime($currentDate))?>"  style="color:green">L</span>
                                           
                                            
                                       <?php }else if($attend->leave_type == 'latecomer'){
                                           
                                          echo '<span style="color:#800000" >LC</span>';
        
                                         }else if($attend->leave_type == 'present'){
                                            
                                            echo '<span class="policies" style="color:green">P</span>';
                                         }
                                    }
                                    

                            }
                        //echo $dayCount;
                        //echo $currentDate;
                        //echo date('D',strtotime($currentDate));

                        echo '</span>';
                        
                        //Hover event popup
                        echo '<div id="date_popup_'.$currentDate.'" class="date_popup_wrap none">';
                        echo '<div class="date_window">';
                        echo '<div class="popup_event">Events ('.$eventNum.')</div>';
                        echo ($eventNum > 0)?'<a href="javascript:;" onclick="getEvents(\''.$currentDate.'\');">view events</a>':'';
                        echo '</div></div>';
                        
                        echo '</th>';
                        $dayCount++;
            ?>
            <?php }else{ ?>
                <!-- <li><span>&nbsp;</span></li> -->
            <?php } } ?>

            <?php }
            ?>
            </table>
            </div>
            </div>
        </div>
    </div>

 
  <!-- Modal -->
  <div id="div1"></div>
  <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Student Attendance</h4>
          <input type="hidden" id="input_stu_id" value="" class="getId">
          <input type="hidden" id="input_stu_date" value="" class="getdate">
          <input type="hidden" id="input_date" value="" class="getdate">
          <input type="hidden" id="input_nameStu" value="">
          <input type="hidden" id="unique_id" value="">
        </div>
        <div class="modal-body">
        <!-- <label for="">Leave Type</label>
          <select name="leave_type" id="leave_type" class="form-control leaveSelect">
            <option value="">Select Leave Type</option>
            <option value="absent">Absent</option>
            <option value="leave">Leave</option>
            <option value="shortleave">Short Leave</option>
          </select> -->


           <?php
      
          echo Html::label('Leave Type');
          $a= ['absent' => 'Absent', 'leave' => 'Leave', 'latecomer' => 'Late Commer','present'=>'Present'];
          echo Html::DropDownList('leave_type',null,$a,['prompt'=>'Select Leave Type','class'=>'form-control leaveSelect','id'=>'leaveid']) ;
         

        ?>
          <div>
          <label for="">Remarks</label>
          <textarea name="remarks" id="remarks" cols="30" rows="5" class="remarks form-control"></textarea>
          <label for="" class="displayvalidation"></label>
            </div>    
        </div>
        <div id="getValues"></div>
        <div class="modal-footer">
        <button type="button" dates="<?php echo $currentDate;?>" data-url="<?= Url::to(['student/save-leave']) ?>" class="student_pop btn green-btn" data-dismiss="modal">Save</button>
          <button type="button" class="btn green-btn closemodel" data-dismiss="modal">Close</button>
        </div>
      </div>
      
    </div>
  </div>
 
  


   <script type="text/javascript">
		function getCalendar(target_div,year,month,class_id,group_id,section_id){
			//var classValue= $('.newyear').data('data-c');

		   //alert(classValue);
			$.ajax({
				type:'POST',
				url:'functions',
				data:'func=getCalender&year='+year+'&month='+month+'&class_id='+class_id+'&group_id='+group_id+'&section_id='+section_id,
				success:function(html){
					//$('#'+calendar_div).html(html);
					$('#'+target_div).html(html);
				}
			});
		}


	</script>
	<?php
	 
	}
/*
 * Get months options list.
 */
function getAllMonths($selected = ''){
    $options = '';
    for($i=1;$i<=12;$i++)
    {
        $value = ($i < 01)?'0'.$i:$i;
        $selectedOpt = ($value == $selected)?'selected':'';
        $options .= '<option value="'.$value.'" '.$selectedOpt.' >'.date("F", mktime(0, 0, 0, $i+1, 0, 0)).'</option>';
    }
    return $options;
}

/*
 * Get years options list.
 */
function getYearList($selected = ''){
    $options = '';
    for($i=2015;$i<=2025;$i++)
    {
        $selectedOpt = ($i == $selected)?'selected':'';
        $options .= '<option value="'.$i.'" '.$selectedOpt.' >'.$i.'</option>';
    }
    return $options;
}

?>