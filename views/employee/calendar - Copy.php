<?php 

use yii\helpers\Url;
use app\models\User;
use app\models\EmployeeAttendance;
use app\models\EmployeeInfo;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
?>
<?php
$this->registerJsFile(Yii::getAlias('@web').'/js/calendar.js',['depends' => [yii\web\JqueryAsset::className()]]);
?>


<div id="calendar_div">
	<?php echo getCalender(); ?>
</div>
<?php
/*
 * Function requested by Ajax
 */
if(isset($_POST['func']) && !empty($_POST['func'])){
	switch($_POST['func']){
		case 'getCalender':
			getCalender($_POST['year'],$_POST['month']);
			break;
		case 'getEvents':
			getEvents($_POST['date']);
			break;
		default:
			break;
	}
}

/*
 * Get calendar full HTML
 */
function getCalender($year = '',$month = '')
{
	$dateYear = ($year != '')?$year:date("Y");
	$dateMonth = ($month != '')?$month:date("m");
	$date = $dateYear.'-'.$dateMonth.'-01';
	$currentMonthFirstDay = date("N",strtotime($date));
	$totalDaysOfMonth = cal_days_in_month(CAL_GREGORIAN,$dateMonth,$dateYear);
	$totalDaysOfMonthDisplay = ($currentMonthFirstDay == 7)?($totalDaysOfMonth):($totalDaysOfMonth + $currentMonthFirstDay);
	$boxDisplay = ($totalDaysOfMonthDisplay <= 35)?35:42;
?>
	<div id="calender_section">

		<div class="row">
<div class="col-md-12">		
<div id="calender_section">
		<h2>
        	<a href="javascript:void(0);" onclick="getCalendar('calendar_div','<?php echo date("Y",strtotime($date.' - 1 Month')); ?>','<?php echo date("m",strtotime($date.' - 1 Month')); ?>');">&lt;&lt;</a>
            <select name="month_dropdown" class="month_dropdown dropdown"><?php echo getAllMonths($dateMonth); ?></select>
			<select name="year_dropdown" class="year_dropdown dropdown"><?php echo getYearList($dateYear); ?></select>
            <a href="javascript:void(0);" onclick="getCalendar('calendar_div','<?php echo date("Y",strtotime($date.' + 1 Month')); ?>','<?php echo date("m",strtotime($date.' + 1 Month')); ?>');">&gt;&gt;</a>
        </h2>
        </div>
        </div>
        </div>
		<!-- <div id="event_list" class="none"></div> -->
		
		<div class="row">
		<div class="col-md-12">
	
		<table class="table table-striped table-bordered" cellspacing="0" width="100%" style="margin-left: -350px;">
		<div> <!--remove id id="calender_section_bot" -->
			<tr>
		<th>Name</th>
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

			$emp=EmployeeInfo::find()->where(['fk_branch_id'=>1])->All();
			foreach ($emp as $q) {
				//$attendance=EmployeeAttendance::find()->where(['fk_empl_id'=>$q->emp_id])->all();
			//	$attendance = EmployeeAttendance::find()->where(['fk_empl_id'=>$q->emp_id,'date'=>$currentDate])->orderBy(['id' => SORT_DESC])->limit(1)->all();
				
				//echo $attendance;die;

				?>
			<tr>
			<td><?php echo $q->user->first_name;?> 
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
						echo '<span class="popup" emp_id="'.$q->emp_id.'" date="'.$currentDate.'">';
						//echo $currentDate;
			  $attendance =EmployeeAttendance::find()->where(['fk_empl_id'=>$q->emp_id]) 
		      ->andWhere(['between', 'date', $currentDate.' 00:00:00', $currentDate.' 23:59:59'])->orderBy(['id' => SORT_DESC])->limit(1)->all();
					
			$lateJoin =EmployeeAttendance::find()->where(['fk_empl_id'=>$q->emp_id]) 
		      ->andWhere(['between', 'date', $currentDate.' 00:00:00', $currentDate.' 23:59:59'])->orderBy(['id' => SORT_DESC])->limit(1)->one();
				
					?>

					<span>
					<?php  
					$Compare_date=date('d');
					$dd=date('d',strtotime($currentDate));
					//echo $dd;
					?>
					<?php if($Compare_date <= $dd){ ?>
					<a href="" data-toggle="modal" data-target="#myModal" data-empid="<?php echo $q->emp_id;?>" data-date="<?php echo $currentDate .' '. date('H:i:s')?>" class="popups" id="emp_<?php echo $q->emp_id.date('d',strtotime($currentDate))?>" data-urls=<?php echo yii\helpers\Url::to(['employee/save-emp-id'])?>>&nbsp; &nbsp;&nbsp;</a>
					<?php } 
						?>
						<?php 
							foreach ($attendance as $attend) {
							//echo $currentDate;
								 $getCurrentD= date('d',strtotime($currentDate));
								 $date= date('d',strtotime($attend->date));
								 if($getCurrentD == $date){
								 	
										 $newd=$attend->date;
										 $latetime=date('H:i:s',strtotime($newd));
										 if($attend->leave_type == 'absent'){
										 	echo '<span id="emp_'.$q->emp_id.date('d').'" style="color:red">A </span>';
										 }else if($attend->leave_type == 'leave'){
										 	echo '<span id="apends" id="emp_'.$q->emp_id.date('d').'" style="color:green">L </span>';
										 }else if($attend->leave_type == 'shortleave'){
										 	echo '<span id="apends" id="emp_'.$q->emp_id.date('d').'" style="color:#800000">SL </span>';
										 }
										 else if($attend->leave_type == 'present' and strtotime($latetime) > '9:00:00'){
										 	echo '<span style="color:#800000">'.date('H:i',strtotime($attend->date)).'</span>';
										 }
										 
									}
									

							}
							// if($Compare_date > $dd){
							// 	$ll=date('d',strtotime($q->hire_date));
							// 	    //$ll=date('d',strtotime($lateJoin['date']));
							// 	  $c_d=date('d',strtotime($currentDate));
							// 	 if($c_d > $ll){ 
							// 	 	echo '<span style="color:red">A</span>';
							// 	 }
							// }
						
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
  
  <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Employee Attendance</h4>
          <input type="hidden" id="input_id" value="" class="getId">
          <input type="hidden" id="unique_id" value="">
          <input type="hidden" id="input_date" value="" class="getdate">
        </div>
        <div class="modal-body">
        
       
        <?php
      
          echo Html::label('Leave Type');
          $a= ['absent' => 'Absent', 'leave' => 'Leave', 'shortleave' => 'Short Leave','present'=>'Present'];
          echo Html::DropDownList('leave_type',null,$a,['prompt'=>'Select Leave Type','class'=>'form-control leaveSelect','id'=>'leaveid']) ;
         

        ?>
        
          <div>
		<?php echo Html::label('Remarks'); ?>
          <textarea name="remarks" id="remarks" cols="30" rows="5" class="remarks form-control"></textarea>
            </div>    
        </div>
        <div id="getValues"></div>
        <div class="modal-footer">
        <button type="button" dates="<?php echo $currentDate;?>" data-url="<?= Url::to(['employee/save-leave']) ?>" class="pop btn green-btn">Save</button>
          <!-- <button type="button" id="deleteEmployee" class="btn btn-warning" dates="<?php // echo $currentDate;?>" data-urli="<?//= Url::to(['employee/delete']) ?>">Delete</button> -->
          <button type="button" class="btn green-btn closemodel" data-dismiss="modal">Close</button>

        </div>
      </div>
      
    </div>
  </div>
 
  <!-- end of modal-->




<script type="text/javascript">
		function getCalendar(target_div,year,month){
			$.ajax({
				type:'POST',
				url:'Employee/functions',
				data:'func=getCalender&year='+year+'&month='+month,
				success:function(html){
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
