<?php
use yii\grid\GridView;
use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\Pjax;
use kartik\date\DatePicker;
/* @var $this yii\web\View */
/* @var $model app\models\Exam */

?> 
<div class="col-md-12"> 
<?php Pjax::begin(['id' => 'pjax-container']) ?>
<?= GridView::widget([
    'dataProvider' => $dataProvider,
    //'filterModel' => $searchModel,
    'columns' => [
        ['class' => 'yii\grid\SerialColumn'],
        [
            'attribute'=>'stu_id',
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

                return Html::a(Yii::$app->common->getName($data->user_id),['student/view','id'=>$data->stu_id]);
            }

        ],
        [
            'label'=>'Present',
            'value' =>function($data)  use ($attendance_type,$year_month){
                // $query = \app\models\StudentAttendance::find()->where(['fk_stu_id'=>$data->stu_id,'leave_type'=>'present']);
                $query = "SELECT a.* FROM student_attendance AS a LEFT JOIN student_info AS i ON a.fk_stu_id = i.stu_id LEFT JOIN ref_session AS se ON se.session_id = i.session_id WHERE a.fk_stu_id = ".$data->stu_id." AND a.leave_type = 'present' AND a.date BETWEEN se.start_date AND se.end_date";

                /*if type is year mont that follwoing query will be executed*/
                if($attendance_type == 'year-month'){
                    // $query->andWhere(['=','DATE_FORMAT(date, "%Y-%m")',$year_month]);
                    $query .= " AND FORMAT (a.date, 'yyyy-MM-dd') = ".$year_month;
                };
                $presentCount = yii::$app->db->createCommand($query)->queryAll();
                // $presentCount = $query->count();
                return count($presentCount);;
            }
        ],
        [
            'label'=>'Absent',
            'value' =>function($data)  use ($attendance_type,$year_month){
                // $query = \app\models\StudentAttendance::find()->where(['fk_stu_id'=>$data->stu_id,'leave_type'=>'absent']);
                $query = "SELECT a.* FROM student_attendance AS a LEFT JOIN student_info AS i ON a.fk_stu_id = i.stu_id LEFT JOIN ref_session AS se ON se.session_id = i.session_id WHERE a.fk_stu_id = ".$data->stu_id." AND a.leave_type = 'absent' AND a.date BETWEEN se.start_date AND se.end_date";
                // ->andWhere(['between', 'date', $dats.' 00:00:00', $dats.' 23:59:59'])
                // ->one();
                /*if type is year mont that follwoing query will be executed*/
                if($attendance_type == 'year-month'){
                    // $query->andWhere(['=','DATE_FORMAT(date, "%Y-%m")',$year_month]);
                    $query .= " AND FORMAT (a.date, 'yyyy-MM-dd') = ".$year_month;
                };
                $absentCount = yii::$app->db->createCommand($query)->queryAll();
                // $absentCount = $query->count();

                return count($absentCount);
            }
        ],
        [
            'label'=>'Late Comer',
            'value' =>function($data)  use ($attendance_type,$year_month){
                // $query = \app\models\StudentAttendance::find()->where(['fk_stu_id'=>$data->stu_id,'leave_type'=>'latecomer']);

                $query = "SELECT a.* FROM student_attendance AS a LEFT JOIN student_info AS i ON a.fk_stu_id = i.stu_id LEFT JOIN ref_session AS se ON se.session_id = i.session_id WHERE a.fk_stu_id = ".$data->stu_id." AND a.leave_type = 'latecomer' AND a.date BETWEEN se.start_date AND se.end_date";

                /*if type is year mont that follwoing query will be executed*/
                if($attendance_type == 'year-month'){
                    // $query->andWhere(['=','DATE_FORMAT(date, "%Y-%m")',$year_month]);
                    $query .= " AND FORMAT (a.date, 'yyyy-MM-dd') = ".$year_month;
                };

                // $sleaveCount = $query->count();
                $sleaveCount = yii::$app->db->createCommand($query)->queryAll();

                return count($sleaveCount);
            }
        ],
        [
            'label'=>'Leave',
            'value' =>function($data) use ($attendance_type,$year_month){
                // $query = \app\models\StudentAttendance::find()->where(['fk_stu_id'=>$data->stu_id,'leave_type'=>'leave']);
                $query = "SELECT a.* FROM student_attendance AS a LEFT JOIN student_info AS i ON a.fk_stu_id = i.stu_id LEFT JOIN ref_session AS se ON se.session_id = i.session_id WHERE a.fk_stu_id = ".$data->stu_id." AND a.leave_type = 'leave' AND a.date BETWEEN se.start_date AND se.end_date";


                /*if type is year mont that follwoing query will be executed*/
                if($attendance_type == 'year-month'){
                    // $query->andWhere(['=','DATE_FORMAT(date, "%Y-%m")',$year_month]);
                    $query .= " AND FORMAT (a.date, 'yyyy-MM-dd') = ".$year_month;
                }; 
                // $leaveCount = $query->count(); 
                $leaveCount = yii::$app->db->createCommand($query)->queryAll();
                return count($leaveCount);

            }
        ],
        [
            'attribute'=>'registration_date',
            'filter'=>'',
            'value'     => function($data){
                return date('d M,Y',strtotime($data->registration_date));
            }
        ],
        // [
        //     'label'=>'Total Working Days',
        //     'value' =>function($data)  use ($attendance_type,$year_month){
        //         $query = "SELECT DATEDIFF(se.start_date, se.end_date) AS days FROM student_attendance AS a LEFT JOIN student_info AS i ON a.fk_stu_id = i.stu_id LEFT JOIN ref_session AS se ON se.session_id = i.session_id WHERE a.fk_stu_id = ".$data->stu_id;
        //         // DATEDIFF(expiration_date, purchase_date) AS days
                
        //         /*if type is year mont that follwoing query will be executed*/
        //         if($attendance_type == 'year-month'){
        //             $query .= " AND FORMAT (a.date, 'yyyy-MM-dd') = ".$year_month;
        //         }; 
        //         $query .= " GROUP BY a.fk_stu_id";
        //         $totalDays = yii::$app->db->createCommand($query)->queryOne();
        //         return (isset($totalDays->days))? $totalDays->days: 0;

        //     }
        // ],
        [
            'header'=>'Actions',
            'class' => 'yii\grid\ActionColumn',
            'template' => "{view}",
            'buttons' => [
                'addEducation'=>function($url, $model, $key){
                    return Html::a('<span class="glyphicon glyphicon-education toltip" data-placement="bottom" width="20"  title="Add Student Education"></span>', ['student-education/create','id'=>$key]);
                },
                'view' => function ($url, $model, $key)
                {
                    return Html::a('<span class="glyphicon glyphicon-eye-open toltip" data-placement="bottom" width="20"  title="View Student"></span>', ['student/view','id'=>$key]);
                },
                'update' => function ($url, $model, $key)
                {
                    return Html::a('<span class="glyphicon glyphicon-pencil toltip" data-placement="bottom" width="20"  title="Update Student"></span>',Url::to(['student/update','id'=>$key]));
                },
                'delete' => function ($url, $model, $key)
                {
                    return Html::a(Yii::t('yii', '<span class="glyphicon glyphicon-trash toltip" data-placement="bottom" width="20" title="In Active Student"></span>'), 'update-status/'.$model->stu_id.'', [
                        'title' => Yii::t('yii', 'update-status'),
                        'aria-label' => Yii::t('yii', 'update-status'),
                        'onclick' => "
                if (confirm('Are You Sure You Want To In active this user...?')) {
                    $.ajax('$url', {
                        type: 'POST'
                    }).done(function(data) {
                        $.pjax.reload({container: '#pjax-container'});
                    });
                }
                return false;
            ",
                    ]);
                },
                'pdf' => function ($url, $model, $key)
                {
                    $student_name= $model->user->first_name.' '.$model->user->last_name;
                    return Html::a('<i class="fa fa-file-pdf-o" aria-hidden="true"  title="Generate PDF"></i>','javascript:void(0);',['data-toggle'=>"modal" ,'data-target'=>"#pdf-details",'data-std_name'=>$student_name,'data-std_id'=>$key,'id'=>'modal-pdf-detail']);
                },
            ],
        ],

        //['class' => 'yii\grid\ActionColumn'],
    ],
]); ?>
<?php Pjax::end() ?>
</div>