<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
use yii\widgets\LinkPager;
use kartik\export\ExportMenu;
use yii\widgets\Pjax;
use app\models\EmployeeParentsInfo;
/* @var $this yii\web\View */
/* @var $searchModel app\models\EmployeeInfoSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Employee Details';
//$this->params['breadcrumbs'][] = $this->title;

?>
<div class="exam-index content_col grey-form"> 
	<h1 class="p_title">Employee Details</h1>
    
	<?php Pjax::begin(['id' => 'pjax-container']) ?> <!-- ajax --> 
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
	<div class="pad btn-head pull-right">
    	<?= Html::a('Create Employee', ['create'], ['class' => 'btn green-btn']) ?>&nbsp;<?= Html::a('Generate PDF', ['generate-pdf-empb'], 
		['class' => 'btn green-btn','id'=>'generate-employee-pdf']) ?>
    </div> 
	<div class="subjects-index shade"> 
    <?= \kartik\grid\GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

             [
            'label'=>'Full Name',
            'value'=>function($data){
             return Yii::$app->common->getName($data->user_id);
            }

            ],
           /* [
            'label'=>'Parent Name',
            'value'=>function($data){
                return $data->emp_id;
            //return Yii::$app->common->getParentName($data->emp_id);
            }

            ],*/

                   [
                    'label'=>'Parent Name',
                    'value'=>function($data){
                        //return $data->emp_id;
                    $prntName=EmployeeParentsInfo::find()->where(['emp_id'=>$data->emp_id])->one();
                    if(!empty($prntName->first_name)){
                     return $prntName->first_name .' '.$prntName->middle_name .' '.$prntName->last_name;
                    }
                    else{
                        return "N/A";
                    }
                    }
                
                    ],
             
            // 'employeeParentsInfos.first_name',
            //  [
            //     'attribute'=>'first_name',
            //     'label'     =>'Parent Name',
            //     'value'=> function ($data){
            //      return $data->employeeParentsInfos->first_name;
                    
            //     }
            //    // 'value'=>'employeeParentsInfos.first_name',
                
                
            // ],
    //          [
    //     'attribute'=>'parent.first_name',
    //     'value'=>function ($model, $key, $index, $column) {
    //         return $model->parent->first_name;
    //     },
    // ],
             'dob',
            'user.email',
             'contact_no',
            // 'emergency_contact_no',
            // 'gender_type',
            // 'guardian_type_id',
            // 'country_id',
            // 'province_id',
            // 'city_id',
            // 'hire_date',
            // 'designation_id',
             //'marital_status',
             // 'rowOptions'=>function($model){
             //    if($model->marital_status == 1){
             //        echo 'Married';
             //    }else{
             //        echo 'Single';
             //    }
             // },
            // 'department_type_id',
            // 'salary',
            // 'religion_type_id',
            // 'location1',
            // 'Nationality',
            // 'location2',
             'cnic',
            // 'district_id',
        //      [
        //     'attribute'=>'Image',
        //     'format'=>'raw',
        //     'value'     => function($data){
        //         if(!empty($data->user->Image)){
        //         $img= '<img width="40" height="40" src="'.Yii::$app->request->BaseUrl.'/uploads/'.$data->user->Image.'">';
        //         return $img;
        //     }else{
        //         return 'N/A';
        //     }
        // }
        //     ],
           

             [
                'header'=>'Actions',
                'class' => 'yii\grid\ActionColumn',
                'template' => "{addEducation} {view} {update} {delete} {pdf}",
                'buttons' => [
                    'addEducation'=>function($url, $model, $key){
                       // return Html::a('<span class="glyphicon glyphicon-education toltip" data-placement="bottom" width="20"  title="Add Student Education"></span>', ['education/create','id'=>$key]);
                    },
                    'view' => function ($url, $model, $key)
                    {
                        return Html::a('<span class="glyphicon glyphicon-eye-open toltip" data-placement="bottom" width="20"  title="View Student"></span>', ['employee/view','id'=>$key]);
                    },
                    'update' => function ($url, $model, $key)
                    {
                        return Html::a('<span class="glyphicon glyphicon-pencil toltip" data-placement="bottom" width="20"  title="Update Student"></span>',Url::to(['employee/update','id'=>$key]));
                    },
                   
                    'delete' => function ($url, $model, $key)
                    {

                        return Html::a(Yii::t('yii', '<span class="glyphicon glyphicon-trash toltip" data-placement="bottom" width="20" title="In Active Employee"></span>'), 'update-status/'.$model->emp_id.'', [
                            '	title' => Yii::t('yii', 'update-status'),
                            'aria-label' => Yii::t('yii', 'update-status'),
                            'onclick' => "
                                if (confirm('Are You Sure You Want To In active this Employee...?')) {
                                    $.ajax('$url', {
                                        type: 'POST'
                                    }).done(function(data) {
                                        $.pjax.reload({container: '#pjax-container'});
                                    });
                                }
                                return false;
                            ",
                        ]);

                        /*return Html::a('<span class="glyphicon glyphicon-trash toltip" data-placement="bottom" width="20" title="Delete Student"></span>', ['employee/update-status','id'=>$model->user->id],['data'=>['placement'=>'bottom','confirm'=>'Are you sure you want to In Active this Employee?','method'=>'post']
                        ]);*/
                    },
                     'pdf'=>function($url, $model, $key){
                        return Html::a('<span class="glyphicon glyphicon-file" data-placement="bottom" width="20"  title="Generate pdf"></span>', ['employee/create-mpdf','id'=>$key]);
                    },

                ],
            ],
        ],
    ]); ?>
     <?php Pjax::end() ?>   <!-- end of ajax -->
</div>
</div>
