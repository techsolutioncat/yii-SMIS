<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\date\DatePicker;
use kartik\datetime\DateTimePicker;
use yii\helpers\ArrayHelper;

$examtype_array = ArrayHelper::map(\app\models\ExamType::find()->where(['fk_branch_id'=>Yii::$app->common->getBranch()])->all(), 'id', 'type');
/* @var $this yii\web\View */
/* @var $searchModel app\models\search\ExamsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
	
?>
<div class="student-info-index">
    <?php
    if (count($dataprovider)> 0) {
        ?>
        <?php $form = ActiveForm::begin(['id' => 'exam-form', 'enableClientValidation' => false, 'action' => Url::to(['exams/save-exams'])]); ?>
        <div class="table-responsive">
            <table class="table exam-data table-striped">
                <thead>
                <tr>
                    <th>#</th>
                   <!-- <th>Class</th>
                    <th>Group</th>
                    <th>Section</th>-->
                    <th>Subject</th>
                    <th>Total Marks</th>
                    <th>Passing Marks</th>
                    <th>Start Date</th>
                    <th>End Date</th>
                    <th class="lst-tr">Don't Create</th>
                    <!--<th>Is Exam</th>-->
                </tr>

                </thead>
                <tbody>
               <!-- <tr>
                    <th> </th>
                    <th> </th>
                    <th> </th>
                    <th> </th>
                    <th> </th>
                    <th> </th>
                    <th> </th>
                    <th> </th>
                    <th> </th>
                    <th>
                        <input type="checkbox" name="select-all" id="select-all" />
                    </th>
                </tr>-->
                <?php
                $i = 1;
                foreach ($dataprovider as $key => $data) {

                    echo $form->field($model, 'fk_class_id[' . $key . ']')->hiddenInput(['value' => $data['class_id']])->label(false);
                    echo  $form->field($model, 'fk_group_id[' . $key . ']')->hiddenInput(['value' => $data['group_id']])->label(false);
                    echo $form->field($model, 'fk_section_id[' . $key . ']')->hiddenInput(['value' => $data['section_id']])->label(false);

                    ?>
                    <tr>
                        <td><?= $i ?></td>
                        <!--<td></td>
                        <td></td>
                        <td></td>-->
                        <td>
                            <?= $form->field($model, 'fk_subject_id[' . $key . ']')->hiddenInput(['value' => $data['subject_id']])->label(false); ?>

                            <?= $data['subject_name'] ?>
                            <?= $form->field($model, 'fk_subject_division_id[' . $key . ']')->hiddenInput(['value' => ($data['sub_div_id']) ? $data['sub_div_id'] : null])->label(false); ?>
                            <?= ($data['sub_div_title']) ? ' - ' . $data['sub_div_title'] : '' ?></td>
                        <td><?= $form->field($model, 'total_marks[' . $key . ']')->textInput(['type' => 'number','step'=>'any'])->label(false) ?></td>
                        <td><?= $form->field($model, 'passing_marks[' . $key . ']')->textInput(['type' => 'number','step'=>'any'])->label(false) ?></td>
                        <td><?= $form->field($model, 'start_date[' . $key . ']')->widget(DateTimePicker::classname(), [
                                'type' => DateTimePicker::TYPE_INPUT,
                                'options' => ['value' => date('Y-m-d h:i A')],
                                'pluginOptions' => [
                                    'autoclose' => true,
                                    'format' => 'yyyy-mm-dd HH:ii P',
                                    'todayHighlight' => true,
                                ]
                            ])->label(false); ?>
                        </td>
                        <td>  <?= $form->field($model, 'end_date[' . $key . ']')->widget(DateTimePicker::classname(), [
                                'type' => DateTimePicker::TYPE_INPUT,
                                'options' => ['value' => date('Y-m-d h:i A')],
                                'pluginOptions' => [
                                    'autoclose' => true,
                                    'format' => 'yyyy-mm-dd HH:ii P',
                                    'todayHighlight' => true,
                                ]
                            ])->label(false); ?>
                        </td>
                        <td>
                            <?= $form->field($model, 'do_not_create[' . $key . ']')->checkbox()->label(false); ?>
                        </td>
                    </tr>
                    <?php
                    $i++;
                }
                ?>
                </tbody>
            </table>

        </div>
        <div class="col-md-6">
			<?php /*echo  $form->field($model, 'fk_exam_type')->dropDownList($examtype_array, ['prompt' => 'Select Exam type ...']);*/ ?>
            <div class="form-group field-exam-fk_exam_type required">
                <label class="control-label" for="exam-fk_exam_type">Exam Name</label>
                <input type="text" id="exam-fk_exam_type" class="form-control" name="Exam[fk_exam_type]" placeholder="Exam Name" aria-required="true" aria-invalid="true">
                <div class="help-block"></div>
            </div>

            <?php

            /* $grp = ArrayHelper::map(\app\models\Subjects::find()->all(), 'id', 'title');
             // Dependent Dropdown
             echo $form->field($model, 'fk_subject_id')->widget(DepDrop::classname(), [
                 'options' => ['id'=>'subject-id'],
                 'pluginOptions'=>[
                     'depends'=>['section-id','class-id','group-id'],
                     'prompt' => 'Select Subjects...',
                     'url' => Url::to(['/site/get-subjects'])
                 ]
             ]);*/
            ?>
        </div>
        <div class="col-md-12 submit-action">
            <div class="form-group">
                <?= Html::button('Save', ['class' => 'btn green-btn', 'id' => 'save-form']) ?>
    
            </div>
        </div>
        <?php ActiveForm::end(); ?>
        <?php
    }else{
        ?>
        <div class="alert alert-warning">
            <strong>Warning!</strong> Subject Details Not found.
        </div>
        <?php
    }
    ?>
</div>


