<?php
/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\ContactForm */

use yii\helpers\Html;
use kartik\form\ActiveForm;
use yii\captcha\Captcha;

$this->title = 'Import';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="fee-heads-index form-center shade fee-gen pad15 hideFooter">
    <div id="ajaxCrudDatatable">
        <?php if (Yii::$app->session->hasFlash('msg')): ?>

            <div class="alert alert-success">
                File has been imported successfully;
            </div>
        <?php else: ?>
            <div class="row">
                <div class="col-md-12">
                    <p> <strong>Note: </strong> Only excel files with specific formats are accepted.</p>
                    
                    <br>
                    <?php
                    $form = ActiveForm::begin([
                                'id' => 'users-form',
                                'type' => ActiveForm::TYPE_HORIZONTAL,
//                                'tooltipStyleFeedback' => true,
//                                'enableAjaxValidation' => true,
//                                'fieldConfig' => ['options' => ['class' => 'form-group mb-0']],
//                                'formConfig' => ['showErrors' => true],
                                'options' => ['style' => 'align-items: flex-start', 'enctype' => 'multipart/form-data']
                    ]);
                    ?>
                    <?= $form->field($model, 'file')->fileInput() ?>
                    <hr class="    mb-3 g-brd-gray-light-v4 g-mx-minus-30">
                    <div class="form-group text-center mb-0">
                        <?= Html::submitButton('Upload Now', ['class' => 'btn green-btn', 'name' => 'contact-button']) ?>
                    </div>
                    <?php ActiveForm::end(); ?>

                </div>
            </div>

        <?php endif; ?>
    </div>
</div>
