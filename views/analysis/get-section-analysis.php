<?php
use yii\grid\GridView;
use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\Pjax;
use kartik\date\DatePicker;
use app\models\StudentParentsInfo;
/* @var $this yii\web\View */
/* @var $model app\models\Exam */
?>

<div class="student-info-view shade table-details">

<!--<h1><?= Html::encode($this->title) ?></h1>-->
<div id="exTab3">
    <ul  class="nav nav-pills">
        <li class="active">
            <a  href="#student-details" data-toggle="tab" class="studentdetails">Students List</a>
        </li>
        <li>
            <a href="#analysis-exams" data-toggle="tab" class="analysis-exams">Exam Details</a>
        </li>
        <li>
            <a href="#attendance-detail" data-toggle="tab" class="attendance-detail">Attendance</a>
        </li>
        <li>
            <a href="#class-subjects" data-toggle="tab" class="class-subjects">Subjects</a>
        </li>
        <li>
            <a href="#sms-detail" data-toggle="tab">Send Sms</a>
        </li>
        <li class="pull-right">
             <input style=" margin-top: 7px;" type="submit" name="Generate Report" value="Generate Report" class="btn green-btn sectionpdf" data-url="<?=Url::to(['analysis/get-section-pdf']) ?>" />
             <input style=" margin-top: 7px; display: none" type="submit" name="Generate Report" value="Generate Report" class="btn green-btn examdetails" data-url="<?=Url::to(['analysis/get-exam-pdf']) ?>" />

               <input style=" margin-top: 7px; display: none" type="submit" name="Generate Report" value="Generate Report" class="btn green-btn subjectsclas" "<?=Url::to(['analysis/get-subject-pdf']) ?>" />
        </li>
    </ul>

    <input type="hidden" name="" id="classval" value="<?= $class_id?>">
    <input type="hidden" name="" id="groupval" value="<?= $group_id?>">
    <input type="hidden" name="" id="sectionval" value="<?= $section_id?>">

    <div class="tab-content clearfix">
        
        <div class="tab-pane active" id="student-details">
            <div class="col-md-12">

                <?php Pjax::begin(['id' => 'pjax-container']) ?>
                <div class="table-responsive">
                <?= GridView::widget([
                    'dataProvider' => $dataProvider,
                    //'filterModel' => $searchModel,
                    
                    'columns' => [
                        ['class' => 'yii\grid\SerialColumn'],
                        [
                            //'attribute'=>'stu_id',
                            'label'=>'Student Registration No.',
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
                                return Html::a(Yii::$app->common->getName($data->user_id),['student/profile','id'=>$data->stu_id],['target'=>'_blank','data-pjax'=>"0"]);
                            }

                        ],
                        [
                            'label'=>'Father Name',
                            'value' =>function($data){
                                if(Yii::$app->common->getParentName($data->stu_id)){
                                    return Yii::$app->common->getParentName($data->stu_id);
                                }else{
                                    return 'N/A';
                                }
                            }
                        ],

                        [
                            'label'=>'Contact',
                            'value' =>function($data,$key){
                             $p_contact = StudentParentsInfo::find()->where(['stu_id'=>$key])->one();

                                if($p_contact->contact_no){
                                    return $p_contact->contact_no;
                                }else{
                                    return 'N/A';
                                }
                            }
                        ],
                        /*'user.first_name',
                        'user.middle_name',
                        'user.last_name',*/

                        //'cnic',
                        [
                            'attribute'=>'dob',
                            'filter'=>'',
                            'label'     =>'Date of birth',
                            'value'     => function($data){
                                return date('d M,Y',strtotime($data->dob));
                            }
                        ],
                        /*[
                            'label'     =>'Email',
                            'value'     => function($data){
                                return $data->user->email;
                            }
                        ],*/
                        [
                            'attribute'=>'registration_date',
                            'filter'=>'',
                            'value'     => function($data){
                                return date('d M,Y',strtotime($data->registration_date));
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

                        /*[
                           'header'=>'Actions',
                            'class' => 'yii\grid\ActionColumn',
                            'template' => "{update}",
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
                        ],*/

                           ['class' => 'yii\grid\ActionColumn',
                           'template'=>'{update}',
                           //'label'=>'Action',
 
                            'buttons'=>[
                              'update' => function ($url, $model, $key)
                                {
                                   

                        return Html::a('<span class="glyphicon  glyphicon-pencil toltip" data-placement="bottom" width="20"  title="Update Student"></span>', ['student/update','id'=>$key],['target'=>'_blank','data-pjax'=>"0"]); 
                                },
                            ]                            
                            ],

                        //['class' => 'yii\grid\ActionColumn'],
                    ],
                ]); ?>
                </div>
                <?php Pjax::end() ?>
            </div>
        </div>

        <!-- education -->
        <div class="tab-pane" id="analysis-exams">
        	<div class="col-md-12">
            <?= GridView::widget([
                'dataProvider' => $dataProviderExams,
                'columns' => [
                    //['class' => 'yii\grid\SerialColumn'],
                    [
                        'attribute'=>'fk_exam_type',
                        'label'=>'Exam',
                        'format'=>'raw',
                        'value'=>function($data){

                            $link= Html::a($data->fkExamType->type,'javascript:void(0);',[
                                'id'=>'get-exam-subjects',
                                'data-class_id'     =>$data->fk_class_id,
                                'data-group_id'     =>$data->fk_group_id,
                                'data-section_id'   =>$data->fk_section_id,
                                'data-exam_type_id' =>$data->fk_exam_type,
                                'data-url' =>url::to(['/analysis/get-exam-analysis']),
                            ]);
                            return $link;
                        }
                    ],
                ],
            ]);
            ?>
            <div id="exam-inner"></div>
        </div>
        </div>
        <!-- end of education -->

        <!-- attendance details-->
        <div class="tab-pane" id="attendance-detail">
            <div class="col-md-4 form-md">
                    <?=Html::dropDownList('attendence_type',null,['overall'=>'Overall','monthly'=>'Monthly'],
                        [
                            'prompt'=>'select attendance type',
                            'id'=>'attendance_type',
                            'class'=>'form-control',
                            'data-url'=>Url::to(['analysis/get-attendance-analysis']),
                            'data-class-id'=>$class_id,
                            'data-group-id'=>$group_id,
                            'data-section-id'=>$section_id,
                            'data-type'=>'overall'
                        ])
                    ?>
                </div> 
            <div class="col-md-4 form-md year-month" style="display: none;">
                <?php
                echo DatePicker::widget([
                    'name' => 'start_date',
                    'options' => [
                        'placeholder' => 'Select Month',
                        'id'=>'attendance-data-picker',
                        'data-url'=>Url::to(['analysis/get-attendance-analysis']),
                        'data-class-id'=>$class_id,
                        'data-group-id'=>$group_id,
                        'data-section-id'=>$section_id,
                        'data-type'=>'year-month'
                    ],
                    'type' => DatePicker::TYPE_COMPONENT_PREPEND,
                    'pluginOptions' => [
                        'format' => 'yyyy-mm',
                        'autoclose' => true,
                        'minViewMode' => 1,
                    ]
                ]);
                ?>
                <input type="hidden" name="" value="monthly" id="monthly">
            </div> 
            <div class="col-md-2">
                <input style=" margin-top: 7px; display: none" type="submit" name="Generate Report" value="Generate Report" class="btn green-btn attendanceOverall" data-url="<?=Url::to(['analysis/get-attendance-analysis-pdf']) ?>" />

                <input style=" margin-top: 7px; display: none" type="submit" name="Generate Report" value="Generate Report" class="btn green-btn attendanceMonthly" data-url="<?=Url::to(['analysis/get-attendance-analysis-monthly-pdf']) ?>" />
            </div>
            <div class="row"> 
            	<div class="col-sm-12"> 
                	<div id="attendance-inner"></div>
                </div>
            </div>

        </div>
        <!-- attendance details ends--> 

        <!--subjects of calss and section-->
        <div class="tab-pane" id="class-subjects">
        	<div class="col-md-12">
            <?php Pjax::begin(['id' => 'pjax-container']) ?>
            <?= GridView::widget([
                'dataProvider' => $dataProviderSubj,
                'columns' => [
                    //['class' => 'yii\grid\SerialColumn'],
                    [
                        'attribute'=>'title',
                        'filter'=>null,
                        'label'     =>'Subject',
                    ],
                    [
                        'filter'=>null,
                        'label'     =>'Sub subject',
                        'format'=>'raw',
                        'value'     => function($data){
                            $sub_division='';
                            if($data->is_division){
                                $subdiv= \app\models\SubjectDivision::find()->where(['fk_subject_id'=>$data->id])->all();
                                foreach ($subdiv as $item) {
                                    $sub_division .= $item->title.'<br/>';
                                }
                                return $sub_division;
                            }else{
                                return 'N/A';
                            }
                        }
                    ],
                    /*[
                        'header'=>'Actions',
                        'class' => 'yii\grid\ActionColumn',
                        'template' => "{view}",
                        'buttons' => [

                            'view' => function ($url, $model, $key)
                            {
                                return Html::a('<span class="glyphicon glyphicon-eye-open toltip" data-placement="bottom" width="20"  title="View Student"></span>', ['student/view','id'=>$key]);
                            },
                        ],
                    ],*/

                    //['class' => 'yii\grid\ActionColumn'],
                ],
            ]); ?>
            <?php Pjax::end() ?>
        </div>
        </div>
        <!--subjects of calss and section--> 
        <!--sms detail-->
        <div class="tab-pane" id="sms-detail">
        <div class="col-md-12">
        <div style="height: 20px;"></div>
            <?php Pjax::begin(['id' => 'pjax-container']) ?>
            <div class="row">
            <div class="col-md-8">
            <label>Message:</label>
            <!-- <textarea class="form-control" name="smsWhole" id="smsWholescholl"></textarea> -->
            <textarea class="form-control" name="smsWhole" id="smsWhole"></textarea>
            </div>
            </div>
            <div style="height: 20px;"></div>
            <div class="row">
            <div class="col-md-4">
            <input type="submit" name="submit" id="smsStudentClass" class="btn green-btn" data-section="<?php echo $section_id;?>" data-class="<?php echo $class_id;?>" data-group="<?php echo $group_id;?>" data-url=<?php echo Url::to(['analysis/send-whole'])?>/> 
            </div>
            </div>
            <div class="row">
                <div class="col-md-8" id="sucmsg" style="color: green;"> </div>
                <br />
            </div>	
            <?php Pjax::end() ?>
            
        
       
       </div>
       </div>












