<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\widgets\ActiveForm;

$examtype_array = ArrayHelper::map(\app\models\ExamType::find()->where(['fk_branch_id'=>Yii::$app->common->getBranch()])->all(), 'id', 'type');
/* @var $this yii\web\View */
/* @var $searchModel app\models\search\ExamsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

?>
<style>
    table{
        width: 99%;
        max-width: 99%;
        margin-bottom: 20px;
	border-collapse: collapse;
	margin-left: 5px;
	margin-right: 5px;
    }
    tbody{
        display: table-row-group;
        vertical-align: middle;
        border-color: inherit;
    }
    thead{
        display: table-header-group;
        vertical-align: middle;
        border-color: inherit;
	border:1px solid black;

    }
    tr{
        display: table-row;
        vertical-align: inherit;
        border:1px solid black;
    }
    th{
        vertical-align: bottom;
        border:1px solid black;

    }
    td{
        padding: 5px;
        line-height: 1;
        vertical-align: top;
        border: 1px solid black;
    }
</style>
<h3 style="text-align: center;"><?=$modelExam->fkExamType->type.'-'.$modelExam->fkClass->title.'-'.$modelExam->fkSection->title.'-'.$modelExam->fkSubject->title?><?=($modelExam->fk_subject_division_id)?'-'.$modelExam->fkSubjectDivision->title:''?></h3>
<div class="create-award-list-form ">
    <input type="hidden" id="total-marks" value="<?=$modelExam->total_marks?>"/>
    <div class="table-responsive" >
        <table class="table" >
            <thead>
            <tr>
                <th>#</th>
                <th ><?=Yii::t('app','Reg. No')?>.</th>
                <th><?=Yii::t('app','Roll No.')?></th>
                <th><?=Yii::t('app','Student Name')?></th>
                <th><?=Yii::t('app','Parent Name')?></th>
                <th><?=Yii::t('app','Obtained Marks')?></th>
                <th><?=Yii::t('app','Signature')?></th>
            </tr>
            </thead>
            <tbody>
            <?php
                $i=1;
                foreach ($dataprovider as $key=>$data){
                    $student = \app\models\StudentInfo::findOne($data['stu_id']);
                    $current = \app\models\StudentMarks::find()->where(['fk_exam_id'=>$modelExam->id,'fk_student_id'=>$student->stu_id])->One();
                    //return $student->user->first_name.' '.$student->user->last_name;
                ?>
                    <tr >
                        <td><?=$i?></td>
                        <td>
                            <?=$student->user->username;?>
                        </td>
						 <td>
                           
                        </td>
                        <td>
                            <?=$student->user->first_name.' '.$student->user->last_name;?>
                        </td>

                        <td>
                            <?php
                            $studentParent = \app\models\StudentParentsInfo::find()->where(['stu_id'=>$data['stu_id']])->One();
                            if($studentParent->first_name){
                                $student_parent = $studentParent->first_name.' '.$studentParent->last_name;
                            }else{
                                $student_parent = 'N/A';
                            }
                            ?>
                            <?=$student_parent;?>
                        </td>
                        <td>
                            
                        </td>
                        <td>

                        </td>
                    </tr>
                    <?php
                    $i++;
                }

            ?>
            </tbody>
        </table>
    </div>
</div>

