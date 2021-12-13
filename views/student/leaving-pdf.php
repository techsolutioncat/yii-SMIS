<?php 
use app\models\StudentInfo;

$getstuid=studentInfo::find()->where(['stu_id'=>$id])->one();

?>




<div style="width:800px; height:600px; padding:20px; text-align:center; border: 10px solid #787878">
<div style="width:750px; height:550px; padding:20px; text-align:center; border: 5px solid #787878">
       <span style="font-size:50px; font-weight:bold">School Leaving Certificate</span>
       <br><br>
       <span style="font-size:25px"><i>This is to certify that</i></span>
       <br><br>
       <span style="font-size:30px"><b><?php echo Yii::$app->common->getName($getstuid->user_id);?> S/O <?php echo Yii::$app->common->getParentName($getstuid->stu_id);?></b></span><br/><br/>
       <!-- <span style="font-size:25px"><i>has completed the course</i></span> <br/><br/>
       <span style="font-size:30px">$course.getName()</span> <br/><br/>
       <span style="font-size:20px">with score of <b>$grade.getPoints()%</b></span> <br/><br/><br/><br/>
       <span style="font-size:25px"><i>dated</i></span><br>
             #set ($dt = $DateFormatter.getFormattedDate($grade.getAwardDate(), "MMMM dd, yyyy"))
             <span style="font-size:30px">$dt</span> -->
</div>
</div>