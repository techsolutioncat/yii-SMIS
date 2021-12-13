<?php
use yii\grid\GridView;
use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\Pjax;
use kartik\date\DatePicker;

?> 
<style>
    table{
        width: 100%;
        max-width: 100%;
        margin-bottom: 20px;
        border: 1px solid black;
    }
   
    tr{
        display: table-row;
        vertical-align: inherit;
        border-color: inherit;
    }
    th{
        vertical-align: bottom;
        border-bottom: 2px solid #CCCCCC;
        border: 1px solid black;
    }
    td{
        padding: 8px;
        line-height: 1.42857143;
        vertical-align: top;
        border-bottom: 1px solid #CCCCCC;
        border: 1px solid black;
    }
</style>
<div class="col-md-12"> 
<?= GridView::widget([
    'dataProvider' => $dataProvider,
   // 'filterModel' => $searchModel,
    'columns' => [
        ['class' => 'yii\grid\SerialColumn'],
        [
            
            'filter'=>null,
            'label'     =>'Student Registration No.',
            'value'     => function($data){
                return $data->user->username;
            }
        ],
        [
            'label'=>'Full Name',
            'format'=>'raw',
            'value'=>function($data){
               return Yii::$app->common->getName($data->user_id);
            }

        ],
        [
            'label'=>'Present',
            'value' =>function($data)  use ($attendance_type){
                $query = \app\models\StudentAttendance::find()->where(['fk_stu_id'=>$data->stu_id,'leave_type'=>'present']);

               

                $presentCount = $query->count();
                return $presentCount;
            }
        ],
        [
            'label'=>'Absent',
            'value' =>function($data)  use ($attendance_type){
                $query = \app\models\StudentAttendance::find()->where(['fk_stu_id'=>$data->stu_id,'leave_type'=>'absent']);

                /*if type is year mont that follwoing query will be executed*/
               

                $absentCount = $query->count();

                return $absentCount;
            }
        ],
        [
            'label'=>'Late Comer',
            'value' =>function($data)  use ($attendance_type){
                $query = \app\models\StudentAttendance::find()->where(['fk_stu_id'=>$data->stu_id,'leave_type'=>'latecomer']);


                $sleaveCount = $query->count();

                return $sleaveCount;
            }
        ],
        [
            'label'=>'Leave',
            'value' =>function($data) use ($attendance_type){
                $query = \app\models\StudentAttendance::find()->where(['fk_stu_id'=>$data->stu_id,'leave_type'=>'leave']);


               
                $leaveCount = $query->count(); 
                return $leaveCount;

            }
        ],
        [
            'label'=>'registration_date',
            'filter'=>'',
            'value'     => function($data){
                return date('d M,Y',strtotime($data->registration_date));
            }
        ],
       

        //['class' => 'yii\grid\ActionColumn'],
    ],
]); ?>
</div>