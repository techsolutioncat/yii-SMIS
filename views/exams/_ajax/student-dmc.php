<?php
use yii\helpers\Url;
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
    $s_d= 'S/O';
    $gender_name = 'Male';
}else{
    $s_d= 'D/O';
    $imageName = 'female.png';
}
?>

<div class="fs_student shade">
    <div class="col-sm-6 dmc-logo">
        <div class="row">
          <div class="col-sm-3 dm-thumb">
              <img width="250" src="<?= Url::to('@web/uploads/school-logo/').$branch_details->logo?>" alt="DMC">
            </div>
            <div class="col-sm-9 thumb">
             <!-- <h2><?/*=ucfirst(str_replace('-',' ',$branch_details->name));*/?></h2>
                <p>Peshawar Road Campus</p>
                <p>Rawalpindi</p>-->
            </div>
        </div>
    </div>
    <div class="col-sm-6 sd_col">
        <a class="sd_print" href="<?=Url::to(['exams/student-dmc',
            'exam_id'    => $exam_details->id,
            'stu_id'     => $student->stu_id,
            'class_id'   => $student->class_id,
            'group_id'   => ($student->group_id)?$student->group_id:null,
            'section_id' => $student->section_id,
            'position'=> (isset($position))?$position:'N/A'
        ]);?>"><img src="<?= Url::to('@web/img/print.png') ?>" alt="print <?=ucfirst(Yii::$app->common->getName($student->user_id))?> DMC"></a>
        <div class="col-sm-4 sd-thumb">
            <div class="sdt_in">
              <img src="<?= $web_path.$imageName?>" alt="<?=ucfirst(Yii::$app->common->getName($student->user_id))?>">
            </div>
        </div>
        <div class="col-sm-8 sd_thumb">
            <h2><?=ucfirst(Yii::$app->common->getName($student->user_id))?></h2>
            <span><?=$s_d?> <?=Yii::$app->common->getParentName($student->stu_id)?></span>
            <p>Class: <b><?=Yii::$app->common->getCGSName($student->class_id,($student->group_id)?$student->group_id:null,$student->section_id)?></b></p>
            <p>Reg No: <b><?=$student->user->username?></b></p>
        </div>
    </div>
    <div class="col-sm-12 dmc_tcontent">
        <div class="col-sm-12 dmc_head">
          <p>Detailed Marks Certificate</p>
            <span><?=ucfirst($exam_details->type)?> | <stong style="color:#fff;">Position <b><?=(isset($position))?$position:'N/A'?></b></stong></span>
        </div>
        <div class="table-dmc">
          <table class="table table-striped">
              <thead>
                  <tr>
                      <th>S.No</th>
                        <th>Subject</th>
                        <th>Total Marks</th>
                        <th>Obtained Marks</th>
                        <th>Percentage</th>
                        <th>Grade</th>
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
                  <tr>
                      <th class="tt_l" colspan="3">Total <?=$total_marks?></th>
                        <th class="tt_pls"><?=$total_obt_marks?></th>
                        <th class="tt_prcnt"><?=$overall_percentage?>%</th>
                        <th class="tt_prcnt"><?=Yii::$app->common->getLegends($overall_percentage)?></th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>

