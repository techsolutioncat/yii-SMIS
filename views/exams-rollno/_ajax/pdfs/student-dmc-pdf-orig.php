<?php
use yii\helpers\Url;

/*$this->registerCssFile( Yii::getAlias('@web/css/site.css'));
$this->registerCssFile( Yii::getAlias('@web/css/std-dmc-pdf.css'));*/
$logo = $branch_details->logo;
if($logo){
    /* $temp =explode('_',$branch_details->logo);
     $logo= $temp[0];
     $path_info = pathinfo(Url::to('@webroot/uploads/school-logo/').$branch_details->logo);
    $logo.'.'.$path_info['extension'] */

}
/*s/o of d/o*/
$parentInfo = $student->studentParentsInfos;
$file_name = $student->user->Image;
$file_path = Yii::getAlias('@webroot').'/uploads/';

if(!empty($file_name) && file_exists($file_path.$file_name)) {
    $web_path = Yii::getAlias('@web').'/uploads/';
    $imageName = $student->user->Image;

}else{
    $web_path = Yii::getAlias('@web').'/img/';
    if($student->gender_type == 1){
        $imageName = 'male.jpg';
    }else{
        $imageName = 'female.png';

    }
}
if($student->gender_type = 1){
    $s_d= 'F/N';
    $gender_name = 'Male';
}else{
    $s_d= 'F/N';
    $imageName = 'female.png';
}
?>
<div class="col-12 fs_content">
    <div class="fs_student shade">
        <div class="row" style="   display: inline-block;">
            <div class="logo" style="margin-left:8px !important; margin-right: 8px !important;margin-top:-20px ">
                <img src="http://localhost/mis/uploads/frontier-banner.png" alt="DMC" style=" width: 98%;">
            </div>
            <div class="dmc-logo left" style="width:250px; box-shadow: none; float: left; margin-left: 25px; margin-bottom: 0px; margin-top: -50px">
                <div class="thumb right">
                 
                    <div style="width:100px; float:none; box-shadow: none;">
                        <img src="<?= $web_path.$imageName?>" alt="<?=ucfirst(Yii::$app->common->getName($student->user_id))?>">
                    </div>
                </div>
            </div>
            <div class=" sd_col right" style="width:250px; float: right; margin-right: 15px; ">
                <!--<a class="sd_print" target="_blank" href="<?/*=Url::to(['exams/student-dmc',
                                'exam_id'    => $exam_details->id,
                                'stu_id'     => $student->stu_id,
                                'class_id'   => $student->class_id,
                                'group_id'   => ($student->group_id)?$student->group_id:null,
                                'section_id' => $student->section_id,
                            ]);*/?>"><img src="<?/*= Url::to('@web/img/print.png') */?>" alt="print <?/*=ucfirst(Yii::$app->common->getName($student->user_id))*/?> DMC"></a>-->
                      <div class="sd_thumb right" style ="margin-top: -120px" >
                    <h2><?=ucfirst(Yii::$app->common->getName($student->user_id))?></h2>
                    <p style="color:f00"><?=$s_d?> <?=Yii::$app->common->getParentName($student->stu_id)?></p>
                    <p style="color:000">Class: <b><?=Yii::$app->common->getCGSName($student->class_id,($student->group_id)?$student->group_id:null,$student->section_id)?></b></p>
                    <p style="color:000">Reg No: <b><?=$student->user->username?></b></p>
                </div>
            </div>
        </div>
        <div style="width:90%; margin-left:5%">
            <div class="dmc_head" style="background-color: #2e3c54;    padding: 0px 3px; width:100%;">
                <div style="width:49%; float:left; color: #fff;"><b>DETAILED MARKS CERTIFICATE<b></div>
                <div style="width:49%; float:right; text-align: right;">
                    <span style=" color:#fff;"><b><?=ucfirst($exam_details->type)?></b> |</span>
                    <span style="color:#fff;">Position <b><?=(isset($position))?$position:'N/A'?></b></span>
                </div>
            </div>
            <div class="table-dmc col-12">
                <table class="table table-striped">
                    <thead >
                    <tr style="background: #bfe9d1;color: #2e3c54;">
                        <th>S.No</th>
                        <th><?=Yii::t('app','Subject')?></th>
                        <th><?=Yii::t('app','Total Marks')?></th>
                        <th><?=Yii::t('app','Obtained Marks')?></th>
                        <th><?=Yii::t('app','Percentage')?></th>
                        <th><?=Yii::t('app','Grade')?></th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    $i=1;
                    $total_marks      = 0;
                    $total_obt_marks  = 0;

                    foreach($query as $sub_data){
                        $subject_percentage = round($sub_data['marks_obtained']*100/$sub_data['total_marks'],2);
                        ?>
                        <tr>
                            <td><?=$i?></td>
                            <td><?= ucfirst($sub_data['subject'])?></td>
                            <td><?= $sub_data['total_marks']?></td>
                            <td><?= $sub_data['marks_obtained']?></td>
                            <td><?= $subject_percentage?> % </td>
                            <td><?= Yii::$app->common->getLegends($subject_percentage)?> </td>
                        </tr>
                        <?php
                        $total_marks = $total_marks+$sub_data['total_marks'];
                        $total_obt_marks = $total_obt_marks+$sub_data['marks_obtained'];
                        $i++;
                    }
                    $overall_percentage = round($total_obt_marks *100 / $total_marks,2);
                    ?>
                    </tbody>
                    <tfoot>
                    <tr >
                        <th class="tt_l" colspan="3" style="text-align: right;background: #6dd8a0; padding: 3px;font-size: 15px;text-align: center;color: #000;">Total <?=$total_marks?></th>
                        <th class="tt_pls" style="background: #2e3c54;  padding: 3px;font-size: 15px;text-align: center;color: #fff;"><?=$total_obt_marks?></th>
                        <th class="tt_prcnt" style=" background: #404040;  padding: 3px;font-size: 15px;text-align: center;color: #fff;"><?=$overall_percentage?>%</th>
                        <th class="tt_prcnt" style=" background: #404040;  padding: 3px;font-size: 15px;text-align: center;color: #fff;"><?=Yii::$app->common->getLegends($overall_percentage)?></th>
                    </tr>
                    </tfoot>
                </table>






				
		<div style="margin-top: 30px; margin-left: 30px">
		<h4>  Date Of Birth : <u><?=$student->dob?></u>
			
			&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;  Controller Of Examination </h4>
		</div>
				
            </div>
        </div>
    </div>
    <!-- <div class="performance-graphs">
                        <h3>Performance Graphs</h3>
                        <img src="<?/*= Url::to('@web/img/ppgraph.png') */?>" alt="DMC">
                    </div>-->
</div>