<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm; 
use yii\helpers\ArrayHelper;
use kartik\date\DatePicker;
/* @var $this yii\web\View */
/* @var $model app\models\SundryAmount */
/* @var $form yii\widgets\ActiveForm */

?>

<div id="calendar_div" class="fee-challan-result  shade">

    <?php $form = ActiveForm::begin(['id'=>'student-update-form','enableClientValidation'=>false]); ?>
        <table class="table">
            <thead>
            <tr>
		<th width="10%">S.No</th>
                <th width="40%">Name</th>
                <th width="50%">Account #</th>
            </tr>
            </thead>
            <tbody>
            <?php
	$counter = 1;
        foreach ($query as $student){
            ?>
            <tr >
		<td><?=$counter?></td>
                <td width="50%"><?=Yii::$app->common->getName($student->user_id)?></td>
                <td width="50%"><?= $form->field($model, 'acc_no['.$student->stu_id.']')->textInput(['maxlength' => true,'type'=>'number','value'=>$student->acc_no,'data-id'=>$student->stu_id])->label(false) ?></td>
            </tr>

            <?php
	$counter++;
        }
        ?>
            </tbody>
        </table>
    <?php ActiveForm::end(); ?>

</div>
<?php
$this->registerJS("$('.cscroll').mCustomScrollbar({theme:'minimal-dark'});", \yii\web\View::POS_LOAD);
?>