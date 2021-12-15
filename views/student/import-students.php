<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->registerCssFile( Yii::getAlias('@web/css/students/import-students.css'));
$this->registerJsFile(Yii::getAlias('@web').'/js/students/import-students.js',['depends' => [yii\web\JqueryAsset::className()]]);

$model = new app\models\UploadExcelForm();

?>

<div class="loading">
  <div class="loadingWrapper">
    <div id="loading"> </div>
    <h1>Loading . . .</h1>
  </div>
</div>

<div class="filter_wrap content_col tabs grey-form">  
    <h1 class="p_title">Import Students Data</h1> 
    <div class="form-center shade fee-gen">
        <div class="exam-form filters_head"> 
            <div class="row">
                <div class="col-me-12">
                     <?php
                        $form = ActiveForm::begin([
                            'id' => 'upload-form',
                            'method' => 'post',
                            'options' => ['enctype' => 'multipart/form-data'],
                        ])
                    ?>
                    <?= $form->field($model,'file')->fileInput(['multiple'=>'multiple', 'accept'=>'application/vnd.ms-excel, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', 'onchange'=>'checkfile(this);']) ?>
                    
                    <div class="form-group">
                        <?= Html::submitButton('Submit', ['class' => 'btn green-btn', 'id' => 'btn_import_data']) ?>
                    <?php ActiveForm::end() ?>
                </div>
            </div>
        </div>
    </div>
</div>