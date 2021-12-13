<?php

//use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;
use kartik\depdrop\DepDrop;
//use yii\helpers\Url;
use yii\helpers\Url;
use yii\helpers\Html;
use yii\bootstrap\Modal;
use kartik\grid\GridView;
use johnitvn\ajaxcrud\CrudAsset;
use johnitvn\ajaxcrud\BulkButtonWidget;
use dosamigos\multiselect\MultiSelect;

//use dosamigos\multiselect\MultiSelect;

/* @var $this yii\web\View */
/* @var $model app\models\FeeGroup */
/* @var $form yii\widgets\ActiveForm */
CrudAsset::register($this);

$feeHeadArray = ArrayHelper::map(\app\models\FeeHeads::find()->where(['fk_branch_id' => Yii::$app->common->getBranch()])->all(), 'id', 'title');
$classArray = ArrayHelper::map(\app\models\RefClass::find()->where(['fk_branch_id' => Yii::$app->common->getBranch(), 'status' => 'active', 'class_id' => $_GET['id']])->all(), 'class_id', 'title');
$classArrayEdit = ArrayHelper::map(\app\models\RefClass::find()->where(['fk_branch_id' => Yii::$app->common->getBranch(), 'status' => 'active'])->all(), 'class_id', 'title');
?>
<?php
$this->registerJs(
        '$("document").ready(function(){ 
        $("#new_country").on("pjax:end", function() {
            $.pjax.reload({container:"#countries"});  //Reload GridView
        });
    });'
);
?>
<?php yii\widgets\Pjax::begin(['id' => 'new_country']) ?>
<div class="fee-group-form">


    <?php
    if (true) {

        $form = ActiveForm::begin(['options' => ['data-pjax' => true]]);
        ?>




        <div class="row">
            <div class="col-md-12">
                <?php
                //    $form->field($model, 'id')->widget(MultiSelect::className(),[
//    'data' => ['super', 'natural'],
//]);
                if ($model->isNewRecord) {
                    $grpArray = ArrayHelper::map(\app\models\RefGroup::find()->where(['fk_branch_id' => Yii::$app->common->getBranch(), 'status' => 'active', 'fk_class_id' => $_GET['id']])->all(), 'group_id', 'title');
                } else {
                    $grpArray = ArrayHelper::map(\app\models\RefGroup::find()->where(['fk_branch_id' => Yii::$app->common->getBranch(), 'status' => 'active', 'fk_class_id' => $model->fk_class_id])->all(), 'group_id', 'title');
                }

                // show if having some data otherwise nothing
                if ($model->isNewRecord) {
                    if (!empty($grpArray)) {

                        echo MultiSelect::widget([
                            'id' => "mgroups",
                            "options" => ['multiple' => "multiple"], // for the actual multiselect
                            'data' => $grpArray, // data as array
//    'value' => [ 0, 2], // if preselected
                            'name' => 'mgroups', // name for the form
                            "clientOptions" =>
                            [
                                "includeSelectAllOption" => true,
                                'numberDisplayed' => 2
                            ],
                        ]);
                    } else {

                        echo '<em>*no groups found.</em>';
                    }
                } else {
                    echo $form->field($model, 'fk_group_id')->dropDownList($grpArray, ['prompt' => 'Select Group']);
                }

                // Dependent Dropdown
                /* echo $form->field($model, 'fk_group_id')->widget(DepDrop::classname(), [
                  'options' => ['id'=>'group-id'],
                  'pluginOptions'=>[
                  'depends'=>['class-id'],
                  'placeholder' => 'Select Group',
                  'url' => Url::to(['/site/get-group'])
                  ]
                  ]); */
                ?>

                <?php
                if ($model->isNewRecord) {
                    // adding class b/c we have already selected it while clicking on gridview
                    echo $form->field($model, 'fk_class_id')->hiddenInput(['value' => yii::$app->request->get('id')])->label(false);
                }

//       echo   $form->field($model, 'fk_class_id')->hiddenInput(['value'=>$model->fk_class_id])->label(false);
//        if($model->isNewRecord == 1){
//        echo $form->field($model, 'fk_class_id')->dropDownList($classArray, ['id'=>'class-id','required'=>'required']);    
//    }else{
//        echo $form->field($model, 'fk_class_id')->dropDownList($classArray, ['prompt'=>'Select class','id'=>'class-id','disabled'=>'disabled']);
//    }
                ?>



            </div>


        </div>
        <div class="row">
            <div class="col-md-6">
                <?=
                $form->field($model, 'fk_fee_head_id')->widget(Select2::classname(), [
                    'data' => $feeHeadArray,
                    'options' => ['placeholder' => 'Select Fee Head ...', 'required' => 'required'],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ]);
                ?>
            </div>
            <div class="col-md-6"><?= $form->field($model, 'amount')->textInput() ?></div>

        </div>

        <div class="row">
            <div class="col-md-6">
                <?php
                if ($model->isNewRecord == 1) {
                    echo $form->field($model, 'is_active')->hiddenInput(['value' => 'yes'])->label(false);
                } else {
                    echo $form->field($model, 'is_active')->dropDownList([ 'yes' => 'Yes', 'no' => 'No'], ['prompt' => 'Select Status']);
                }
                ?>

            </div>
            <div class="col-md-6"></div>
        </div>











        <!-- <div class="form-group">
            <?//= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn green-btn' : 'btn green-btn']) ?>
        </div> -->

        <?php
        ActiveForm::end();
    }
    ?>
    <?php yii\widgets\Pjax::end() ?>

</div>
