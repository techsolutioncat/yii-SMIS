<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
use yii\widgets\Pjax;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $searchModel app\models\StudentInfoSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Student Info';
$this->params['breadcrumbs'][] = $this->title;
$class_array = ArrayHelper::map(\app\models\RefClass::find()->where(['fk_branch_id'=>Yii::$app->common->getBranch(),'status'=>'active'])->all(), 'class_id', 'title');
?>


<div class="student-info-index">

     <?php Pjax::begin(['enablePushState' => false, 'timeout'=>false, 'id'=>'pjax-container']); ?>
    
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        /*'filterModel' => $searchModel,*/
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'class' => 'yii\grid\CheckboxColumn',
                // you may configure additional properties here
            ],

             [
            'label'=>'Full Name',
            'value'=>function($data){
                return Yii::$app->common->getName($data->user->id);
            }
            ],

            [
                'label'=>'Father Name',
                'value'     => function($data){
                    $father_record = $data->getStudentParentsInfos()->limit(1)->one();
                    if(count($father_record) >0){
                        return Yii::$app->common->getParentName($father_record->stu_id);
                    }else{
                        return 'N/A';
                    }

                }
            ],[
                'label'=>'Registration#',
                'value'     => function($data){
                    return $data->user->username;
                }
            ],
            [
                'attribute'=>'registration_date',
                'filter'=>'',
                'value'     => function($data){
                    return date('d M,Y',strtotime($data->registration_date));
                }
            ],
            [
                'label'=>'Status',
                'filter'=>'',
                'format'=>'raw',
                'value'     => function($data){
                    return '<span class="bg bg-green">Pass</span>';
                }
            ],

            // 'contact_no',
            // 'emergency_contact_no',
            // 'gender_type',
            // 'guardian_type_id',
            // 'country_id',
            // 'province_id',
            // 'city_id',
            // 'session_id',
            // 'group_id',
            // 'shift_id',
            // 'class_id',
            // 'section_id',
            // 'location1',
            // 'location2',
            // 'withdrawl_no',
            // 'district_id',
            // 'religion_id',
            //['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

    <?php Pjax::end() ?>
     <!--upcoming class selection-->
    <?php $form = ActiveForm::begin(); ?>
    <div class="col-md-12">
        <div class="alert alert-warning" id="success-alert" style="display: none;">
            <button type="button" class="close" data-dismiss="alert">x</button>
            <strong>Note! </strong>Please Select Student to promote
        </div>
    </div>
    <div class="col-md-12">

        <div class="col-md-3">
       
            <!-- <?//= $form->field($model, 'section_id[next]')->dropDownList([], ['id'=>'section-id-promo','prompt' => 'Select Section ...','disabled'=>true]); ?> -->


            <!-- <?//= $form->field($model, 'section_id[next]')->dropDownList([], ['id'=>'section-id-promos']); ?> -->

<label>Section</label>
<select name="StudentInfo[section_id][next]" id="section-id-promo" class="form-control">
<option>Select Section</option>
<?php foreach ($section as $sections) {?>
    <option value="<?php echo $sections->section_id?>"><?php echo $sections->title?></option>
<?php }?>
    <option value=""></option>
</select>
        </div>

        <div class="col-md-3">
        	<br />
            <?=Html::submitButton('Shuffle Students',['class'=>'btn green-btn btn-promote-std','id'=>'btn-promote-std','data-url'=>Url::to(['student/save-shuffle-student'])])?>
        </div>
    </div>




    <?php $form = ActiveForm::end(); ?>
</div>
