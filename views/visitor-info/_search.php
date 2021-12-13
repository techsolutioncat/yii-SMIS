<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\search\VisitorInfoSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="visitor-info-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'name') ?>

    <?= $form->field($model, 'cnic') ?>

    <?= $form->field($model, 'contact_no') ?>

    <?= $form->field($model, 'fk_country_id') ?>

    <?php // echo $form->field($model, 'fk_province_id') ?>

    <?php // echo $form->field($model, 'fk_district_id') ?>

    <?php // echo $form->field($model, 'fk_city_id') ?>

    <?php // echo $form->field($model, 'fk_adv_med_id') ?>

    <?php // echo $form->field($model, 'fk_class_id') ?>

    <?php // echo $form->field($model, 'fk_group_id') ?>

    <?php // echo $form->field($model, 'fd_section_id') ?>

    <?php // echo $form->field($model, 'date_of_visit') ?>

    <?php // echo $form->field($model, 'is_active') ?>

    <?php // echo $form->field($model, 'fk_vistor_category') ?>

    <?php // echo $form->field($model, 'product_name') ?>

    <?php // echo $form->field($model, 'product_description') ?>

    <?php // echo $form->field($model, 'last_degree') ?>

    <?php // echo $form->field($model, 'experiance') ?>

    <?php // echo $form->field($model, 'last_organization') ?>

    <?php // echo $form->field($model, 'qualification') ?>

    <?php // echo $form->field($model, 'reference') ?>

    <?php // echo $form->field($model, 'designation') ?>

    <?php // echo $form->field($model, 'organization') ?>

    <?php // echo $form->field($model, 'address') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn green-btn']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn green-btn']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
