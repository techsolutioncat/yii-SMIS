<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use app\models\EmplEducationalHistoryInfo;
use yii\helpers\Url;


$parent_name =  $model->getStudentParentsInfos()->where(['stu_id'=>$model->stu_id])->one();

$this->registerCss(" 
@page {

    /* this affects the margin in the printer settings */ 
    margin: 0;  
     -webkit-print-color-adjust: exact;
} 
    
}
@media print{    
    table{
        font-size:18px; 
         margin : 0;
         padding : 0;
          -webkit-print-color-adjust: exact;
    } 
        @media print and (-webkit-min-device-pixel-ratio:0) {
             {
              color: #ccc;
              -webkit-print-color-adjust: exact;
            }
          }
    body  
    { 
        /* this affects the margin on the content before sending to printer */ 
        margin: 0px; 
         padding:0px;
         -webkit-print-color-adjust: exact; 
    } 
    .chart-wrapper {
        position: relative;
        padding-bottom: 84%;
        width:90%;
        float:left;
    }
    
    .chart-inner {
        position: absolute;
        width: 50%; height: 40%;
    }

     
}

.row-center-text{
   width: 100%; 
   display: inline-block; 
   text-align: center;
   
}
.row-three-col{
    width:33.33%; 
}
.footer{
    display:none;
}
.container-fluid{
    display:none;
    }
.navbar-inverse navbar-fixed-top navbar{
    display:none;
}
/*#container {
    min-width: 300px;
    max-width: 800px;
    height: 300px;
    margin: 1em auto;
}*/
.highcharts-credits{
    display:none;
}

");

 ?>

    <div class="row-center-text"><img width="50%" src="<?=Url::to(['uploads/school-logo/trillium-logo.jpg'])?>"/></div>
    <div class="row-center-text"><h4><Strong>Detailed Marks Certificate (AS-2016)</Strong></h4></div>
<table class="table table-condensed" border="0">
    <tbody>
        <tr>
            <td>
                <?php
                if($model->user->Image)
                {
                    $avatar = Url::to(['/uploads/']).'/'.$model->user->Image;
                }else
                    {
                    if($model->gender_type ==1){
                        $avatar = Url::to(['/img/']).'/male.jpg';
                    }else{
                        $avatar = Url::to(['/img/']).'/female.png';
                    }
                }
                ?>
                <img src="<?=$avatar;?>" width="120" hight="120"/>
            </td>
            <td>
                <?php
                $fname='';
                $name = '';
                if($model->user->first_name){
                    $name = $model->user->first_name;
                }
                if($model->user->middle_name){
                    $name .= ' '.$model->user->middle_name;
                }
                if($model->user->last_name){
                    $name .= ' '.$model->user->last_name;
                }

                if($parent_name->first_name){
                    $fname = $parent_name->first_name;
                }
                if($parent_name->middle_name){
                    $fname .= ' '.$parent_name->middle_name;
                }
                if($parent_name->last_name){
                    $fname .= ' '.$parent_name->last_name;
                }
                ?>

                <?=Yii::t('app','Name')?>: <strong><?=$name?></strong><br/>
                <?=Yii::t('app','Father Name')?>: <strong><?=$fname?></strong><br/>
                <?=Yii::t('app','Reg #')?> <strong><?=$model->user->username?></strong><br/>
                <?=Yii::t('app','Class')?> : <strong><?=$model->class->title?></strong><br/>
                <?=Yii::t('app','Section')?> : <strong><?=$model->section->title?></strong><br/>
                <?=Yii::t('app','Class Teacher')?> : <strong><?=$data['class-teacher'];?></strong>
            </td>
            <td>

                <div class="chart">
                    <div id="container"  style="min-width: 300px; height:180px; margin: 0 auto"></div>
                </div>
                <!-- /.box-body -->
            </td>
        </tr>
        <tr>
            <td colspan="3">
                <div style="width: 49%; float: left;">
                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th>Sr #</th>
                            <th>Subject Name</th>
                            <th>Letter Grade</th>
                            <th>Performance</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        $i=1;
                        $sum=0;
                        $total_marks=0;
                        $json = [];
                        foreach ($subjects_data as $key=>$sdata){

                            ?>
                            <tr>
                                <td><?=$i?></td>
                                <td><?=$sdata['subject']?></td>

                                    <?php
                                    $total_marks= $total_marks+$sdata['total_marks'];
                                    $obtain_marks= number_format((float)$sdata['marks_obtained'], 2, '.', '');
                                    $sum= $sum+$obtain_marks;
                                    if($sdata['total_marks'] >0){
                                        $avg_sub= ($obtain_marks*100)/$sdata['total_marks'];
                                    }else{
                                        $avg_sub= 0;
                                    }


                                   ?>
                                <td><?=Yii::$app->common->getLegends($avg_sub)?></td>
                                <td style="padding:3px;">
                                    <?php
                                    $sub_subject_data =  Yii::$app->db->createCommand('select sd.title as `sub-subject`, ex.total_marks,ex.passing_marks,sm.marks_obtained,sm.remarks from exam ex inner join exam_type et on et.id=ex.fk_exam_type inner join ref_class c on c.class_id=ex.fk_class_id 
left join ref_group g on g.fk_class_id=ex.fk_group_id left join ref_section s on s.section_id=ex.fk_section_id  inner join subjects sb on sb.id=ex.fk_subject_id inner join subject_division sd on sd.id=ex.fk_subject_division_id left join student_marks sm on sm.fk_exam_id=ex.id inner join student_info st on st.stu_id=sm.fk_student_id inner join user u on u.id=st.user_id where sb.id='.$sdata["subject_id"].'  and st.stu_id='.$model->stu_id)->queryAll();
                                    $subjects=[];
                                    $subject_short=[];
                                    $marks=[];
                                    if(count($sub_subject_data)>0){
                                        foreach ($sub_subject_data as $sub=>$sub_subj){
                                            $subjects[]=$sub_subj['sub-subject'].'<br/>';
                                            $subject_short[]=ucfirst(substr($sub_subj['sub-subject'], 0,1));
                                            $marks[]=$sub_subj['marks_obtained'];

                                        }
                                    }else{
                                        $subjects[]     =   $sdata['subject'];
                                        $subject_short[]=ucfirst(substr($sdata['subject'], 0,1));
                                        $marks[]=$obtain_marks;

                                    }
                                    ?>
                                    <div class="chart-wrapper"><div class="chart-inner">
                                            <div id="container-<?=$key?>" style="width:100%; height: 100%;"></div>
                                        </div>
                                    </div>
                                </td>
                            </tr>

                        <?php
                            $json['series'][$key]= [
                                'subject'=>$subjects,
                                'subjectShort'=>$subject_short,
                                'marks'=>$marks,
                            ];
                            $i++;
                        }
                        ?>
                        <tr>
                            <td colspan="2">
                                <strong>Overall Grade</strong>
                            </td>
                            <td colspan="2">
                                <?php

                                    $avg = ($sum*100)/$total_marks;
                                    echo Yii::$app->common->getLegends(number_format((float)$avg, 2, '.', ''));
                                ?>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
                <div style="width: 49%; float: right;padding: 10px;">
                    <div style=" border: 1px solid #3c3c3c; padding: 10px; margin-bottom: 40px;">
                        <strong class="red" style="margin-bottom: 6px; color: red; -webkit-print-color-adjust: exact; ">Important to Read</strong>
                        <p>
                            <?=$data['imp-to-read'];?>
                        </p>
                        <br/>
                    </div>
                    
                    <p style="margin-bottom: 60px;"><strong>Sig Class Teacher</strong> : ________________________</p>
                    <p><strong>Principal Comments</strong> : <br/><br/><br/>__________________________________________________________________<br/><br/><br/><br/>__________________________________________________________________<br/><br/><br/><br/>__________________________________________________________________</p>
                    <p style="margin-bottom: 60px; float: right; margin-top: 100px;"><strong>Signature</strong> : ________________________</p>
		    <div style="display: inline-block;width: 100%;">
			<strong>Legends</strong>
			<table border ="0" cellpadding="20">
			<tr>
			<td>
			Acadamics
			</td>
<td>
			<img src="<?=Url::to(['/img/']).'/green-circle.png';?>" width="32" height="32"/>

			</td>
			</tr>
<tr>
			<td>
			Manners
			</td>
<td>
			<img src="<?=Url::to(['/img/']).'/blue-circle.png';?>" width="32" height="32"/>

			</td>
			</tr>
<tr>
			<td>
			Confidence
			</td>
<td>
			<img src="<?=Url::to(['/img/']).'/red-circle.png';?>" width="32" height="32"/>
			</td>
			</tr>

			</table>
                    </div>

                </div>
            </td>
        </tr>
        <tr>
            <td colspan="3">
                <strong>Coordinator's Comments :</strong>
                <p>
                    <?=$data['comment-cordinator']?>
                </p>
            </td>
        </tr>
        <tr>
            <td colspan="3">
                <strong>Areas to focus :</strong>&nbsp;&nbsp;1: <span style="text-decoration: underline;margin: 10px;  margin-right: 200px;"><?=$data['area-to-focus-1']?></span>2: <span style="text-decoration: underline;margin: 10px; margin-right: 200px;"><?=$data['area-to-focus-2']?></span>3:<span style="text-decoration: underline;margin: 10px;"><?=$data['area-to-focus-3']?></span>
            </td>
        </tr>
    </tbody>
</table>
<?php
if($model->class->title  == 'Junior-Montessori'){
    $subGraphWidth = 8;
}else{
    $subGraphWidth = 10;
}
$this->registerJS("
    var data = ".json_encode($json,JSON_NUMERIC_CHECK).";
    var totalCharts = ".count($subjects_data).";
    var subChartWidth = ".$subGraphWidth.";
    var acadamicTotal= ".number_format((float)$avg, 2, '.', '').";
    var manners= ".($data['manners']*10).";
    var confidence = ".($data['confidence']*10)."
         ", \yii\web\View::POS_BEGIN);
$this->registerJsFile(Yii::getAlias('@web').'/js/highcharts.js',['depends' => [yii\web\JqueryAsset::className()]]);
$this->registerJsFile(Yii::getAlias('@web').'/js/highcharts-details.js',['depends' => [yii\web\JqueryAsset::className()]]);
//$this->registerJsFile(Yii::getAlias('@web').'/js/exporting.js',['depends' => [yii\web\JqueryAsset::className()]]);

?>

