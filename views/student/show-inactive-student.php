<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
use yii\bootstrap\Modal;
use yii\widgets\ActiveForm;
use app\widgets\Alert;
use yii\widgets\Pjax;
use yii\widgets\LinkPager;
use app\models\StudentInfo;
use app\models\StudentParentsInfo;
echo '<pre>';print_r($dataProvider);

die;
 echo GridView::widget([
        'dataProvider' => $dataProvider,
        /*'filterModel' => $searchModel,*/
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'class' => 'yii\grid\CheckboxColumn',
                // you may configure additional properties here
            ],

            

            
           //'stu_id',
           

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
    ]);