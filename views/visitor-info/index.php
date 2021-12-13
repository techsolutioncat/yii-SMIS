<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\search\VisitorInfoSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
$visitor = ['3' => 'Admission','1' => 'Job', '2' => 'Advertisement'];
$this->title = 'Visitor Info';
//$this->params['breadcrumbs'][] = $this->title;
?> 
<div class="visitor-info-index content_col grey-form">
    <div class="form-center">
    	<h1 class="p_title"><?= Html::encode($this->title) ?></h1>
    	<div class="btn-heads">
			<?= Html::a('Add Visitor Info', ['create'], ['class' => 'btn green-btn']) ?>
        </div>
    </div> 
    <div class="form-center shade fee-gen pad15">  
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?> 
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'id',
           
            [
            'attribute'=>'fk_vistor_category',
            'filter'=>Html::activeDropDownList ($searchModel,'fk_vistor_category',$visitor,['prompt' => 'Select Category','class' => 'form-control']),
            'value'=>function($data){
             if($data->fk_vistor_category == 3){
                        return 'Admission';
                    }else if($data->fk_vistor_category == 1){
                        return 'Job';
                    }else if($data->fk_vistor_category == 2){
                        return 'Advertisement';
                    }

                    else{
                        return 'N/A';
                    }
            }
            ],
            'name',
            'cnic',
            'contact_no',
        
            

            //'fk_country_id',
            // 'fk_province_id',
            // 'fk_district_id',
            // 'fk_city_id',
            // 'fk_adv_med_id',
            // 'fk_class_id',
            // 'fk_group_id',
            // 'fd_section_id',
            // 'date_of_visit',
            // 'is_active',
            // 'fk_vistor_category',
            // 'product_name',
            // 'product_description',
            // 'last_degree',
            // 'experiance',
            // 'last_organization',
            // 'qualification',
            // 'reference',
            // 'designation',
            // 'organization',
            // 'address',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
</div>