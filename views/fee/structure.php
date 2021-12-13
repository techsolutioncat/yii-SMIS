<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\depdrop\DepDrop;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $model app\models\Exam */
/* @var $form yii\widgets\ActiveForm */

$class_array = ArrayHelper::map(\app\models\RefClass::find()->where(['fk_branch_id'=>Yii::$app->common->getBranch(),'status'=>'active'])->all(), 'class_id', 'title');

$this->title = 'Fee Structure';
$this->title = 'Search Fee Structure';
//$this->params['breadcrumbs'][] = $this->title;
?>
 
<div class="filter_wrap content_col tabs grey-form">  
    <h1 class="p_title">Fee Structure</h1>
    <div class="form-center shade fee-gen">
        <div class="exam-form filters_head"> 
        <?php $form = ActiveForm::begin(); ?>
        <div class="row">
           <div class="col-sm-3"> 
           </div>
           <div class="col-sm-9">
           		<div class="form-group col-sm-2 fh_item pull-right"> 
					<?= Html::submitButton('Search', ['class' => 'btn green-btn'])?>
                </div> 
                <div class="col-sm-4 fh_item pull-right">
                    <?php
                    // Dependent Dropdown
                    echo $form->field($model, 'fk_group_id')->widget(DepDrop::classname(), [
                        'options' => ['id'=>'group-id','onchange'=>"this.form.submit()"],
                        'pluginOptions'=>[
                            'depends'=>['class-id'],
                            'prompt' => 'Select '.Yii::t('app','Group').'...',
                            'url' => Url::to(['/site/get-group'])
                        ]
                    ]);
                    ?>
        
                </div>
                <div class="col-sm-4 fh_item pull-right">
                    <?= $form->field($model, 'fk_class_id')->dropDownList($class_array, ['id'=>'class-id','prompt' => 'Select '.Yii::t('app','Class').'...']); ?>
                </div> 
           </div> 
        </div>   
        <?php ActiveForm::end(); ?> 
        </div>
        <div id="subject-details">
             <div class="col-sm-12">
            <?php
            if(!empty($type) && $type =='post'){
                echo GridView::widget([
                    'dataProvider' => $dataProvider,
                    'id'=>'grid-search',
                    // 'filterModel' => $searchModel,
                    'columns' => [
                        ['class' => 'yii\grid\SerialColumn'],
                        [
                            'attribute'=>'fk_fee_head_id',
                            'label'=>'Head',
                            'value'=>function($data){
                                return ucfirst($data->fkFeeHead->title);
                            }
                        ],
                        [
                            'attribute'=>'fk_class_id',
                            'label'=>'Class',
                            'value'=>function($data){
                                if($data->fk_class_id){
                                    return ucfirst($data->fkClass->title);
                                }else{
                                    return "N/A";
                                }
                            }
                        ],
                        [
                            'attribute'=>'fk_group_id',
                            'label'=>'Group',
                            'value'=>function($data){
        
                                if($data->fk_group_id){
                                    return ucfirst($data->fkGroup->title);
                                }else{
                                    return "N/A";
                                }
                            }
                        ],
                        [
                            'attribute' =>'amount',
                            'label'     =>'Amount',
                            'value'     =>function($data){
                                return 'Rs. '.$data->amount;
                            }
        
                        ],
                        /*[
                            'header'=>'Actions',
                            'class' => 'yii\grid\ActionColumn',
                            'template' => "{view} {update}",
                            'buttons' => [
                                'view' => function ($url, $model, $key)
                                {
        
                                    return Html::a('<span class="glyphicon glyphicon-eye-open toltip" data-placement="bottom" width="20"  title="View"></span>', ['fee-group/view','id'=>$key]);
                                },
                                'update' => function ($url, $model, $key)
                                {
                                    return Html::a('<span class="glyphicon glyphicon-pencil toltip" data-placement="bottom" width="20"  title="Update"></span>',Url::to(['fee-group/update','id'=>$key]));
                                },
                            ],
                        ],*/
        
                    ],
                ]);
            }
            ?>
        </div>
        </div> 
    </div>
</div>  
