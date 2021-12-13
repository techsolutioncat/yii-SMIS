<?php
$this->registerJsFile(Yii::getAlias('@web').'/js/calendar.js',['depends' => [yii\web\JqueryAsset::className()]]);
?>
<?php include_once('EmpCalfunctions.php'); ?>
<div class="content_col exam-form grey-form student-calendar">
<h1 class="p_title">Employee Attendance</h1>
<div id="calendar_div">
	<?php echo getCalender(); ?>
</div>
</div>
<?php
