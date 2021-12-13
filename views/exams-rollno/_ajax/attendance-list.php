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
<h3><?=$modelExam->fkExamType->type.'-'.$modelExam->fkClass->title.'-'.$modelExam->fkSection->title.'-'.$modelExam->fkSubject->title?><?=($modelExam->fk_subject_division_id)?'-'.$modelExam->fkSubjectDivision->title:''?></h3>
<div class="create-award-list-form ">
    <?php $form = ActiveForm::begin(['id' => 'award-list-form', 'action' => Url::to(['exams/save-award-list']),'enableClientValidation' => false]); ?>
    <?=$form->field($model, 'fk_exam_id')->hiddenInput(['value'=>$modelExam->id])->label(false)?>
    <input type="hidden" id="total-marks" value="<?=$modelExam->total_marks?>"/>
    <div class="table-responsive">
        <table class="table">
            <thead>
            <tr>
                <th>#</th>
                <th>Registration No.</th>
                <th>Student</th>
                <th>Parent Name</th>
                <th>Signature</th>
                
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
                    <td><?=$i?></td>
                    <td>
                        <?=$student->user->username;?>
                    </td>
                    <td>
                        <?=$student->user->first_name.' '.$student->user->last_name;?>
                        <?=$form->field($model, 'fk_student_id['.$key.']')->hiddenInput(['value'=>$data['stu_id']])->label(false)?>
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
                        <?=$form->field($model, 'marks_obtained['.$key.']')->textInput(['value'=>(isset($current->marks_obtained))?$current->marks_obtained:''])->label(false)?>
                    </td>
                    
                    </tr>
                    <?php
                    $i++;
                }

            ?>
            </tbody>
        </table>
		<?php
         if (count($modelExam)>0) {
             ?>
            <div class="form-group">
                <?= Html::button('Save', ['class' => 'teaser btn green-btn', 'id' => 'save-award-list']) ?>
                <?= Html::a('Generate Blank Awardlist',[
                    'generate-blank-awardlist',
                    'exam_id'=>$modelExam->id,
                    /*'class_id'=>$modelExam->fk_class_id,
                    'group_id'=>($modelExam->fk_group_id)?$modelExam->fk_group_id:null,
                    'group_id'=>$modelExam->fk_section_id,*/
                ], ['class' => 'teaser btn green-btn', 'id' => 'generate-blank-awardlist']) ?>
				<?= Html::a('Generate Attendance List',[
                    'attendance-list',
                    'exam_id'=>$modelExam->id,
                    /*'class_id'=>$modelExam->fk_class_id,
                    'group_id'=>($modelExam->fk_group_id)?$modelExam->fk_group_id:null,
                    'group_id'=>$modelExam->fk_section_id,*/
                ], ['class' => 'teaser btn green-btn', 'id' => 'attendance-list']) ?>
            </div>
            <?php
         }
         ActiveForm::end();
        ?>
    </div>
</div>

