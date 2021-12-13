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
use kartik\date\DatePicker;

/* @var $this yii\web\View */
/* @var $searchModel app\models\StudentInfoSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Student Details';
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="student-search-index">
<input type="hidden" class="thisinputname" value="" />
<input type="hidden" class="parntclass" value="" />
<input type="hidden" class="inputclass" value="" />
<input type="hidden" class="grpclass" value="" />
<input type="hidden" class="sectinclass" value="" />
<input type="hidden" class="dobclass" value="" />
<input type="hidden" class="regclass" value="" />
<input type="hidden" class="adrsclass" value="" />
<input type="hidden" class="classcntct" value="" />
    <?= Alert::widget() ?> 
    <!-- <div class="alert_si"> 
        <p> <?//= Html::a('Create Student Info', ['create'], ['class' => 'btn green-btn']) ?> </p>
    </div> -->
    <div class="shade table-details pad_15"> 
    <?php Pjax::begin([
        'enablePushState' => false,
        'id'=>'pjax-container-student-search'
    ]); ?>
  <?php $data=Yii::$app->request->post();
  //echo '<pre>';print_r($query);die;
  //echo $getdropVal;die;
        if($getdropVal == 'contact'){
            ?>
            <?= GridView::widget([
                'dataProvider' => $dataprovider,

                 'id'=>'grid-search',
               // 'filterModel' => $searchModel,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],

                    [
                        //'attribute'=>'username',
                        'label'     =>'Student Registration No.',
                        'contentOptions' => ['class' => 'regClass'],
                        'headerOptions' => ['class' => 'regClassHeader'],
                        'value'     => function($data){
                            return $data->stu->user->username;
                        }
                    ],
                    [
                    'label'=>'Name',
                    'format'=>'raw',
                    'contentOptions' => ['class' => 'fullnameClass'],
                    'headerOptions' => ['class' => 'fullnameClassHeader'],
                    'value'=>function($data){
                      return $data->stu->user->first_name;
                    },
                     'visible' => true,
                    ],

                    [
                    'label'=>'Parent Name',
                    'contentOptions' => ['class' => 'parntClass'],
                    'headerOptions' => ['class' => 'parntClassHeader'],
                    'value'=>function($data){
                     return Yii::$app->common->getParentName($data->stu_id);
                    }

                    ],
                    [
                    'label'=>'Class',
                    'contentOptions' => ['class' => 'parntClass'],
                    'headerOptions' => ['class' => 'parntClassHeader'],
                    'value'=>function($data){
                     return $data->stu->class->title;
                    }

                    ],
                    [
                    'label'=>'Group',
                    'contentOptions' => ['class' => 'parntClass'],
                    'headerOptions' => ['class' => 'parntClassHeader'],
                    'value'=>function($data){
                        if($data->stu->group == NULL){
                            return "N/A";

                        }else{
                           return $data->stu->group->title;


                        }
                    }

                    ],
                    
                    [
                    'label'=>'Section',
                    'contentOptions' => ['class' => 'parntClass'],
                    'headerOptions' => ['class' => 'parntClassHeader'],
                    'value'=>function($data){
                     return $data->stu->section->title;
                    }

                    ],
                    'contact_no',
                     [
                    'label'=>'DOB',
                    'contentOptions' => ['class' => 'sectionClasses'],
                    'headerOptions' => ['class' => 'sectionClassHeader'],
                    'value'=>function($data){

                      if($data){
                      return $data->stu->dob;

                        }else{
                            return "N/A";
                        }
                    }

                    ],
                    /*[
                        'label'=>'Status',
                        'format'=>'raw',
                        'attribute'=>'status',
                        'value'=>function($data){
                            if($data['status'] == 'active'){
                                $status = '<span class="glyphicon glyphicon-ok-circle"></span>&nbsp; Active';
                            }else{
                                $status = '<span class="glyphicon glyphicon-remove-sign"></span>&nbsp; Inactive';
                            }

                            return $status;
                        }

                    ],*/
                    //'contact_no',
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
                    [
                        'header'=>'Actions',
                        'class' => 'yii\grid\ActionColumn',
                        'template' => "{addEducation}&nbsp;{update}&nbsp;&nbsp;{SendSms}&nbsp;{ViewProfile}&nbsp;{leaving}",
                        'buttons' => [
                            /*'addEducation'=>function($url, $model, $key){
                                return Html::a('<span class="glyphicon glyphicon-education toltip" data-placement="bottom" width="20"  title="Add Student Education"></span>', ['student-education/create','id'=>$key]);
                            },*/
                           /* 'view' => function ($url, $model, $key)
                            {
                                return Html::a('<span class="glyphicon glyphicon-eye-open toltip" data-placement="bottom" width="20"  title="View Student"></span>', ['student/view','id'=>$key]);
                            },*/
                            'ViewProfile' => function ($url, $model, $key)
                            {
                                return Html::a('<span class="glyphicon  glyphicon-user toltip" data-placement="bottom" width="20"  title="View Student"></span>', ['student/profile','id'=>$model->stu_id],['target'=>'_blank','data-pjax'=>"0"]);
                            },
                            'update' => function ($url, $model, $key)
                            {
                                return Html::a('<span class="glyphicon glyphicon-pencil toltip" data-placement="bottom" width="20"  title="Update Student"></span>',Url::to(['student/update','id'=>$key],['target'=>'_blank','data-pjax'=>"0"]));
                            },
                            'delete' => function ($url, $model, $key)
                            {
                                 return Html::a(Yii::t('yii', '<span class="glyphicon glyphicon-trash toltip" data-placement="bottom" width="20" title="In Active Student"></span>'), 'update-status/'.$key, [
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

                            /*'leaving' => function ($url, $model, $key)
                            {
                                return Html::a('<span class="glyphicon glyphicon-remove" data-placement="bottom" width="20"  title="Leaving Institution"></span>',Url::to(['student/update','id'=>$key],['target'=>'_blank','data-pjax'=>"0"]));
                            },*/

                          
                             
                            
                            'pdf' => function ($url, $model, $key)
                             {
                                 $student_name= Yii::$app->common->getName($model['user_id']);
                                return Html::a('<i class="fa fa-file-pdf-o" aria-hidden="true"  title="Generate PDF"></i>','javascript:void(0);',['data-toggle'=>"modal" ,'data-target'=>"#pdf-details",'data-std_name'=>$student_name,'data-std_id'=>$key,'id'=>'modal-pdf-detail','data-url'=>Url::to('student/get-exam-options')]);
                            },
                            
                            'SendSms' => function ($url, $model, $key)
                            {
                                return Html::a('<i class="fa fa-envelope-o data-toggle="modal" data-target="#myModal" title="Send SMS"></i>','javascript:void(0);',['data-toggle'=>'modal','data-target'=>'#myModal','data-stu_id'=>$key,'id'=>'stu']);
                            }, 
                        ],
                    ],

                    //['class' => 'yii\grid\ActionColumn'],
                ],
            ]); ?>
             <!-- end of ajax -->
            <?php
         }// end of contact and start of registeration
        if($getdropVal == 'class'){
            ?>
            <input type="submit" name="Generate Report" value="Generate Report" class="btn green-btn classpdf" data-url="<?=Url::to(['student/get-search-pdf']) ?>" />
            <?= GridView::widget([
                'dataProvider' => $dataprovider,
                 'id'=>'grid-search',

               // 'filterModel' => $searchModel,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],
                    [
                        //'attribute'=>'username',
                        'label'     =>'Student Registration No.',
                        'contentOptions' => ['class' => 'regClass'],
                        'headerOptions' => ['class' => 'regClassHeader'],
                        'value'     => function($data){
                            return $data->user->username;
                        }
                    ],
                    [
                    'label'=>'Full Name',
                    'format'=>'raw',
                    'contentOptions' => ['class' => 'fullnameClass'],
                    'headerOptions' => ['class' => 'fullnameClassHeader'],
                    'value'=>function($data){
                     return Yii::$app->common->getName($data->user_id);
                    },
                     'visible' => true,
                    ],








                    [
                    'label'=>'Parent Name',
                    'contentOptions' => ['class' => 'parntClass'],
                    'headerOptions' => ['class' => 'parntClassHeader'],
                    'value'=>function($data){
                     return Yii::$app->common->getParentName($data->stu_id);
                    }

                    ],
                   /* [
                    'label'=>'Parent Name',
                    'value'=>function($data){
                     return Yii::$app->common->getName($data->user_id);
                    }

                    ],*/
                    [
                    'label'=>'Class',
                    'contentOptions' => ['class' => 'classClass'],
                    'headerOptions' => ['class' => 'classClassHeader'],
                    'value'=>function($data){
                        if($data->class_id){
                      return $data->class->title;

                        }else{
                            return "N/A";
                        }
                    }

                    ],

                    [
                    'label'=>'Group',
                    'contentOptions' => ['class' => 'groupClass'],
                    'headerOptions' => ['class' => 'groupClassHeader'],
                    'value'=>function($data){

                      if($data->group_id){
                      return $data->group->title;

                        }else{
                            return "N/A";
                        }
                    }

                    ],

                    [
                    'label'=>'Section',
                    'contentOptions' => ['class' => 'sectionClasses'],
                    'headerOptions' => ['class' => 'sectionClassHeader'],
                    'value'=>function($data){

                      if($data->section_id){
                      return $data->section->title;

                        }else{
                            return "N/A";
                        }
                    }

                    ],
                    // 'contact_no',
                     [
                       // 'attribute' => 'contact_no',
                        'label'=>'Parent Contact',
                        'contentOptions' => ['class' => 'contactClass'],
                        'headerOptions' => ['class' => 'contactClassHeader'],
                        'value'=>function($data,$key){
                            $name = StudentParentsInfo::find()->where(['stu_id'=>$key])->one();
                            if($name){
                                return $name->contact_no;

                            }else{
                                return 'N/A';
                            }

                        }
                     ],

                    
                    
                    [
                        'attribute'=>'dob',
                        'filter'=>'',
                        'label'     =>'Date of birth',
                        'contentOptions' => ['class' => 'dobClass'],
                        'headerOptions' => ['class' => 'dobClassHeader'],
                        'value'     => function($data){
                            return date('d M,Y',strtotime($data->dob));
                        }
                    ],


                    [
                        'attribute'=>'location1',
                        'filter'=>'',
                        'label'     =>'Address',
                        'contentOptions' => ['class' => 'addressClass'],
                        'headerOptions' => ['class' => 'addressClassHeader'],
                        'value'     => function($data){
                            if($data->location1){
                            return $data->location1;

                            }else{
                                return "N/A";
                            }
                        }
                    ],
                    
                   
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
                    [
                        'header'=>'Actions',
                        'class' => 'yii\grid\ActionColumn',
                        'template' => "{addEducation}&nbsp;{update}&nbsp;&nbsp;{SendSms}&nbsp;{ViewProfile}&nbsp;{leaving}",
                        'buttons' => [
                            /*'addEducation'=>function($url, $model, $key){
                                return Html::a('<span class="glyphicon glyphicon-education toltip" data-placement="bottom" width="20"  title="Add Student Education"></span>', ['student-education/create','id'=>$key],['target'=>'_blank','data-pjax'=>"0"]);
                            },*/
                           /* 'view' => function ($url, $model, $key)
                            {
                                return Html::a('<span class="glyphicon glyphicon-eye-open toltip" data-placement="bottom" width="20"  title="View Student"></span>', ['student/view','id'=>$key]);
                            },*/
                            'ViewProfile' => function ($url, $model, $key)
                            {
                                return Html::a('<span class="glyphicon  glyphicon-user toltip" data-placement="bottom" width="20"  title="View Student"></span>', ['student/profile','id'=>$key],['target'=>'_blank','data-pjax'=>"0"]);
                            },
                            'update' => function ($url, $model, $key)
                            {
                                return Html::a('<span class="glyphicon glyphicon-pencil toltip" data-placement="bottom" width="20"  title="Update Student"></span>',['student/update','id'=>$key],['target'=>'_blank','data-pjax'=>"0"]);

                            },
                            'delete' => function ($url, $model, $key)
                            {
                                 return Html::a(Yii::t('yii', '<span class="glyphicon glyphicon-trash toltip" data-placement="bottom" width="20" title="In Active Student"></span>'), 'update-status/'.$key, [
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
                                return Html::a('<i class="fa fa-file-pdf-o" aria-hidden="true"  title="Generate PDF"></i>','javascript:void(0);',['data-toggle'=>"modal" ,'data-target'=>"#pdf-details",'data-std_name'=>$student_name,'data-std_id'=>$key,'id'=>'modal-pdf-detail','data-url'=>Url::to('student/get-exam-options')]);
                            },

                            'SendSms' => function ($url, $model, $key)
                            {
                                return Html::a('<i class="fa fa-envelope-o data-toggle="modal" data-target="#myModal" title="Send SMS"></i>','javascript:void(0);',['data-toggle'=>'modal','data-target'=>'#myModal','data-stu_id'=>$key,'id'=>'stu']);
                            },

                            'leaving' => function ($url, $model, $key)
                            {
                                 if($model->is_active == '1'){
                                ?>
                            <?php return '<span class="glyphicon glyphicon-remove leavingBtn" data-placement="bottom" width="20"  title="Leaving Institution" data-toggle="modal" data-target="#myModalClass" data-stuid="'.$key.'"></span>' ?>
                            <?php
                                /*return Html::a('<span class="glyphicon glyphicon-remove" data-placement="bottom" width="20"  title="Leaving Institution" data-toggle="modal" data-target="#myModalClass"></span>',Url::to(['student/updatess','id'=>$key],['target'=>'_blank','data-pjax'=>"0"]));*/


                                ///////////////////
                               /* return Html::a(Yii::t('yii', '<span class="glyphicon glyphicon-remove toltip" data-placement="bottom" width="20" title="Leaving Institution" data-toggle="modal" data-target="#myModalClass"></span>'), 'leave-info/'.$key.'', [
                            '   title' => Yii::t('yii', 'leave-info'),
                            'aria-label' => Yii::t('yii', 'leave-info'),
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
                        ]);*/


                                //////////////
                             } },
                        ],
                    ],

                    //['class' => 'yii\grid\ActionColumn'],
                ],
            ]); ?>


            <!-- Trigger the modal with a button -->
<!-- <button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModal">Open Modal</button> -->

<!-- Modal -->
<!-- <?php //Pjax::begin(); ?>

<?php //$form = ActiveForm::begin(['action' =>['student/test-leave'],'options' => ['data-pjax' => true ]]); ?> -->
<div id="myModalClass" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Student Status</h4>
      </div>
      <div class="modal-body">
        <p>
    <input type="hidden" name="" id="getStudid" value="">
           <input class="leavingInstitute" type="radio" name="leavinginfo" value="0"><label>Remove Student Record</label><br />
           <input class="leavingInstitute" type="radio" name="leavinginfo" value="1"><label>Student Leaving Institution</label>
           <br />
           <label id="labelRemoves" style="color: red"></label>
                <span class="info" style="display: none;">
                <label for="">Remarks</label>
            <textarea name="" class="form-control remarks" id="" cols="30" rows="5"></textarea>
                <br />
                <label for="">Next School</label>
                <input type="text" class="form-control nextSchool">  <br />
                <label for="">Reason for leaving school</label>
                 <input type="text" class="form-control reason">  
                 <div style="display: none;" class="info col-sm-5">
                  <?php 
                    

                     echo '<label>Date:</label>';
                                                    echo DatePicker::widget([
                                                    'name' => 'overallstart', 
                                                    'value' => date('01-m-Y'),
                                                    'options' => ['placeholder' => ' ','id'=>'startDate'],
                                                    'pluginOptions' => [
                                                        'format' => 'dd-m-yyyy',
                                                        'todayHighlight' => true,
                                                        'autoclose'=>true,
                                                    ]]);

                  ?>           
                  </div>            
           </span>
       </p>

      </div>
      <br /><br /><br />
      <div class="modal-footer">
        <button type="button" class="btn btn-success saveLeaving" data-url="<?php echo Url::to(['student/leave-info'])?>">Submit</button>

        <!-- ajax button -->
        <?php
/* echo  Html::a(Yii::t('yii', '<span class="glyphicon glyphicon-remove toltip" data-placement="bottom" width="20" title="Leaving Institution" data-toggle="modal" data-target="#myModalClass"></span>'), 'leave-info/'.$model->stu_id.'', [
                            '   title' => Yii::t('yii', 'leave-info'),
                            'aria-label' => Yii::t('yii', 'leave-info'),
                            'onclick' => "
                               // if (confirm('Are You Sure You Want To In active this Employee...?')) {
                                    $.ajax('student/test-leave', {
                                        type: 'POST'
                                    }).done(function(data) {
                                        $.pjax.reload({container: '#pjax-container'});
                                    });
                               // }
                                return false;
                            ",
                        ]);*/

         ?>

         <!-- end of ajax button -->

        


        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>

<!-- <?php //ActiveForm::end(); ?> -->
             <!-- end of ajax -->
            <?php
         }// end of contact and start of registeration
        if($getdropVal == 'reg' ||  $getdropVal == 'name'){?>
    <input type="submit" name="Generate Report" value="Generate Report" class="btn green-btn classNamepdf" data-url="<?=Url::to(['student/get-searchname-pdf']) ?>" />
            <?php echo  GridView::widget([
            'dataProvider' => $dataprovider,
                'id'=>'grid-search',
            //'filterModel' => $searchModel,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],

                //'id',
                //'fk_branch_id',
                [
                        //'attribute'=>'username',
                        'label'     =>'Student Registration No.',
                        'contentOptions' => ['class' => 'regClass'],
                        'headerOptions' => ['class' => 'regClassHeader'],
                        'value'     => function($data){
                            return $data->username;
                        }
                    ],
                [
                'label'=>'Full Name',
                'contentOptions' => ['class' => 'fullnameClass'],
                'headerOptions' => ['class' => 'fullnameClassHeader'],
                'value'=>function($data){
                 return Yii::$app->common->getName($data->id);
                }

                ],
                [
                'label'=>'Parent Name',
                'contentOptions' => ['class' => 'parntClass'],
                'headerOptions' => ['class' => 'parntClassHeader'],
                'value'=>function($data){
                    $student = StudentInfo::find()->where(['user_id'=>$data->id])->one();
                    if($student){
                        return Yii::$app->common->getParentName($student->stu_id);
                    }else{
                        return 'N/A';
                    }
                }

                ],
                 //'username',
                 

                    [
                    'label'=>'Class',
                    'contentOptions' => ['class' => 'classClass'],
                    'headerOptions' => ['class' => 'classClassHeader'],
                    'value'=>function($data,$key){
                     $cls = StudentInfo::find()->where(['user_id'=>$key])->one();
                     if(!empty($cls)){
                      return $cls->class->title;

                     }else{
                        return "N/A";
                     }
                    }

                    ],

                    [
                    'label'=>'Group',
                    'contentOptions' => ['class' => 'groupClass'],
                    'headerOptions' => ['class' => 'groupClassHeader'],
                    'value'=>function($data,$key){
                    $grp = StudentInfo::find()->where(['user_id'=>$key])->one();
                    if(count($grp)>0){
                      return $grp->group['title'];

                     }else{
                        return "N/A";
                     }

                    }

                    ],

                    [
                    'label'=>'Section',
                    'contentOptions' => ['class' => 'sectionClasses'],
                    'headerOptions' => ['class' => 'sectionClassHeader'],
                    'value'=>function($data,$key){
                     $sctn = StudentInfo::find()->where(['user_id'=>$key])->one();
                     if(count($sctn)>0){
                      return $sctn->section->title;

                     }else{
                        return "N/A";
                     }

                    }

                    ],

                     [
                       // 'attribute' => 'contact_no',
                        'label'=>'Parent Contact',
                        'contentOptions' => ['class' => 'contactClass'],
                        'headerOptions' => ['class' => 'contactClassHeader'],
                        'value'=>function($data,$key){
                            $stu = StudentInfo::find()->where(['user_id'=>$key])->one();
                           
                            $name = StudentParentsInfo::find()->where(['stu_id'=>$stu['stu_id']])->one();
                            if(count($name)>0){
                            return $name->contact_no;

                            }else{
                                return "N/A";
                            }

                        }
                     ],

                    [
                        'attribute'=>'dob',
                        'filter'=>'',
                        'label'     =>'Date of birth',
                        'contentOptions' => ['class' => 'dobClass'],
                        'headerOptions' => ['class' => 'dobClassHeader'],
                        'value'     => function($data,$key){
                        $dob = StudentInfo::find()->where(['user_id'=>$key])->one();
                        if(count($dob) > 0){
                        return date('d M,Y',strtotime($dob->dob));

                        }else{
                        return "N/A";

                        }
                        }
                    ],

                    [
                        'attribute'=>'location1',
                        'filter'=>'',
                        'label'     =>'Address',
                        'contentOptions' => ['class' => 'addressClass'],
                        'headerOptions' => ['class' => 'addressClassHeader'],
                        'value'     => function($data,$key){
                        $locatn1 = StudentInfo::find()->where(['user_id'=>$key])->one();
                        if(count($locatn1) > 0){
                         return $locatn1->location1;
                        }else{
                            return "N/A";
                        }
                        }
                    ],

                    /* [
                        'label'=>'Parent Contact',
                        'contentOptions' => ['class' => 'contactClass'],
                        'headerOptions' => ['class' => 'contactClassHeader'],
                        'value'=>function($data,$key){
                            $cntact = StudentInfo::find()->where(['user_id'=>$key])->one();
                            return $cntact->class->contact_no;

                        }
                     ],*/

                // 'auth_key',
                // 'password_hash',
                // 'password_reset_token',
                // 'avatar',
                
                //     'contact_no',
                // 'fk_role_id',
                // 'last_ip_address',
                // 'last_login',
                // 'created_at',
                // 'updated_at',

                [
                    'header'=>'Actions',
                    'class' => 'yii\grid\ActionColumn',
                    'template' => "{addEducation}&nbsp;{update}&nbsp&nbsp;{SendSms}&nbsp;{ViewProfile}&nbsp;{leaving}",
                    'buttons' => [
                        /*'addEducation'=>function($url, $model, $key){
                            $stu_id=StudentInfo::find()->select('stu_id')->where(['fk_branch_id'=>Yii::$app->common->getBranch(),'user_id'=>$model->id])->one();
                            if(count($stu_id)>0) {
                                return Html::a('<span class="glyphicon glyphicon-education toltip" data-placement="bottom" width="20"  title="Add Student Education"></span>', ['student-education/create', 'id' => $stu_id->stu_id]);

                            }else{
                                return Html::a('<span class="glyphicon glyphicon-education toltip" data-placement="bottom" width="20"  title="Add Student Education"></span>', ['student-education/create', 'id' => $key]);
                            }
                        },*/

                        'update' => function ($url, $model, $key)
                        {
                            $stu_id=StudentInfo::find()->select('stu_id')->where(['fk_branch_id'=>Yii::$app->common->getBranch(),'user_id'=>$model->id])->one();
                            //echo '<pre>';print_r($stu_id);die;

                            return Html::a('<span class="glyphicon glyphicon-pencil toltip" data-placement="bottom" width="20"  title="Update Student"></span>',['student/update','id'=>$stu_id['stu_id']],['target'=>'_blank','data-pjax'=>"0"]);
                        },
                        'leaving' => function ($url, $model, $key)
                            {
                                 $stu_id=StudentInfo::find()->where(['fk_branch_id'=>Yii::$app->common->getBranch(),'user_id'=>$model->id])->one();
                                // echo '<pre>';print_r($stu_id);
                                // echo $stu_id->stu_id;
                                 if($model->status == 'active'){
                                ?>
                            <?php return '<span class="glyphicon glyphicon-remove leavingBtnName" data-placement="bottom" width="20"  title="Leaving Institution" data-toggle="modal" data-target="#myModalName" data-stuid="'.$stu_id['stu_id'].'"></span>' ?>
                            <?php  } },
                        'delete' => function ($url, $model, $key)
                        {
                            $stu_id=StudentInfo::find()->select('user_id')->where(['fk_branch_id'=>Yii::$app->common->getBranch(),'user_id'=>$model->id])->one();
                            //echo $stu_id->user_id;die;
                             return Html::a(Yii::t('yii', '<span class="glyphicon glyphicon-trash toltip" data-placement="bottom" width="20" title="In Active Student"></span>'), Url::to(['student/inactive','id'=>$model->id]), [
                                    'title' => Yii::t('yii', 'update-status'),
                                    'aria-label' => Yii::t('yii', 'update-status'),
                                    'onclick' => "
                                        if (confirm('Are You Sure You Want To In active this user...?')) {
                                            $.ajax(Url::to(['student/inactive','id'=>$model->id]), {
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
                             $student_name= $model->first_name.' '.$model->last_name;
                            return Html::a('<i class="fa fa-file-pdf-o" aria-hidden="true"  title="Generate PDF"></i>','javascript:void(0);',['data-toggle'=>"modal" ,'data-target'=>"#pdf-details",'data-std_name'=>$student_name,'data-std_id'=>$key,'id'=>'modal-pdf-detail','data-url'=>Url::to('student/get-exam-options')]);
                        },
                        'SendSms' => function ($url, $model, $key)
                            {
                                $stu_id=StudentInfo::find()->where(['fk_branch_id'=>Yii::$app->common->getBranch(),'user_id'=>$model->id])->one();
                                 if(count($stu_id)>0){
                                     return Html::a('<i class="fa fa-envelope-o data-toggle="modal" data-target="#myModal" title="Send SMS"></i>','javascript:void(0);',['data-toggle'=>'modal','data-target'=>'#myModal','data-stu_id'=>$stu_id->stu_id,'id'=>'stu']);
                                 }else{
                                     return Html::a('<i class="fa fa-envelope-o data-toggle="modal" data-target="#myModal" title="Send SMS"></i>','javascript:void(0);',['data-toggle'=>'modal','data-target'=>'#myModal','data-stu_id'=>$key,'id'=>'stu']);
                                 }

                            },

                        'ViewProfile' => function ($url, $model, $key)
                        {
                            $stu_id=StudentInfo::find()->select('stu_id')->where(['fk_branch_id'=>Yii::$app->common->getBranch(),'user_id'=>$key])->one();
                            if(count($stu_id)>0){
                                return Html::a('<span class="glyphicon  glyphicon-user toltip" data-placement="bottom" width="20"  title="View Profile"></span>', ['student/profile','id'=>$stu_id->stu_id],['target'=>'_blank','data-pjax'=>"0"]);
                            }else{
                                return Html::a('<span class="glyphicon  glyphicon-user toltip" data-placement="bottom" width="20"  title="View Profile"></span>', ['student/profile','id'=>$key],['target'=>'_blank','data-pjax'=>"0"]);
                            }

                        },


                    ],
                ],
            ],
        ]);

        }//end of registeration and start of name
     ?>

<?php if($getdropVal == 'overall'){
            ?>
            <input type="submit" name="Generate Report" value="Generate Report" class="btn green-btn classpdf" data-url="<?=Url::to(['student/get-search-pdf']) ?>" />
            <?= GridView::widget([
                'dataProvider' => $dataprovider,
                 'id'=>'grid-search',

               // 'filterModel' => $searchModel,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],
                    [
                        //'attribute'=>'username',
                        'label'     =>'Student Registration No.',
                        'contentOptions' => ['class' => 'regClass'],
                        'headerOptions' => ['class' => 'regClassHeader'],
                        'value'     => function($data){
                            return $data->user->username;
                        }
                    ],
                    [
                    'label'=>'Full Name',
                    'format'=>'raw',
                    'contentOptions' => ['class' => 'fullnameClass'],
                    'headerOptions' => ['class' => 'fullnameClassHeader'],
                    'value'=>function($data){
                     return Yii::$app->common->getName($data->user_id);
                    },
                     'visible' => true,
                    ],








                    [
                    'label'=>'Parent Name',
                    'contentOptions' => ['class' => 'parntClass'],
                    'headerOptions' => ['class' => 'parntClassHeader'],
                    'value'=>function($data){
                     return Yii::$app->common->getParentName($data->stu_id);
                    }

                    ],
                   /* [
                    'label'=>'Parent Name',
                    'value'=>function($data){
                     return Yii::$app->common->getName($data->user_id);
                    }

                    ],*/
                    [
                    'label'=>'Class',
                    'contentOptions' => ['class' => 'classClass'],
                    'headerOptions' => ['class' => 'classClassHeader'],
                    'value'=>function($data){
                        if($data->class_id){
                      return $data->class->title;

                        }else{
                            return "N/A";
                        }
                    }

                    ],

                    [
                    'label'=>'Group',
                    'contentOptions' => ['class' => 'groupClass'],
                    'headerOptions' => ['class' => 'groupClassHeader'],
                    'value'=>function($data){

                      if($data->group_id){
                      return $data->group->title;

                        }else{
                            return "N/A";
                        }
                    }

                    ],

                    [
                    'label'=>'Section',
                    'contentOptions' => ['class' => 'sectionClasses'],
                    'headerOptions' => ['class' => 'sectionClassHeader'],
                    'value'=>function($data){

                      if($data->section_id){
                      return $data->section->title;

                        }else{
                            return "N/A";
                        }
                    }

                    ],
                    // 'contact_no',
                     [
                       // 'attribute' => 'contact_no',
                        'label'=>'Parent Contact',
                        'contentOptions' => ['class' => 'contactClass'],
                        'headerOptions' => ['class' => 'contactClassHeader'],
                        'value'=>function($data,$key){
                            $name = StudentParentsInfo::find()->where(['stu_id'=>$key])->one();
                            return $name->contact_no;

                        }
                     ],

                    
                    
                    [
                        'attribute'=>'dob',
                        'filter'=>'',
                        'label'     =>'Date of birth',
                        'contentOptions' => ['class' => 'dobClass'],
                        'headerOptions' => ['class' => 'dobClassHeader'],
                        'value'     => function($data){
                            return date('d M,Y',strtotime($data->dob));
                        }
                    ],


                    [
                        'attribute'=>'location1',
                        'filter'=>'',
                        'label'     =>'Address',
                        'contentOptions' => ['class' => 'addressClass'],
                        'headerOptions' => ['class' => 'addressClassHeader'],
                        'value'     => function($data){
                            if($data->location1){
                            return $data->location1;

                            }else{
                                return "N/A";
                            }
                        }
                    ],
                    
                   
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
                    [
                        'header'=>'Actions',
                        'class' => 'yii\grid\ActionColumn',
                        'template' => "{addEducation}&nbsp;{update}&nbsp;&nbsp;{SendSms}&nbsp;{ViewProfile}&nbsp;{leaving}",
                        'buttons' => [
                            /*'addEducation'=>function($url, $model, $key){
                                return Html::a('<span class="glyphicon glyphicon-education toltip" data-placement="bottom" width="20"  title="Add Student Education"></span>', ['student-education/create','id'=>$key],['target'=>'_blank','data-pjax'=>"0"]);
                            },*/
                           /* 'view' => function ($url, $model, $key)
                            {
                                return Html::a('<span class="glyphicon glyphicon-eye-open toltip" data-placement="bottom" width="20"  title="View Student"></span>', ['student/view','id'=>$key]);
                            },*/
                            'ViewProfile' => function ($url, $model, $key)
                            {
                                return Html::a('<span class="glyphicon  glyphicon-user toltip" data-placement="bottom" width="20"  title="View Student"></span>', ['student/profile','id'=>$key],['target'=>'_blank','data-pjax'=>"0"]);
                            },
                            'update' => function ($url, $model, $key)
                            {
                                return Html::a('<span class="glyphicon glyphicon-pencil toltip" data-placement="bottom" width="20"  title="Update Student"></span>',['student/update','id'=>$key],['target'=>'_blank','data-pjax'=>"0"]);

                            },
                            'delete' => function ($url, $model, $key)
                            {
                                 return Html::a(Yii::t('yii', '<span class="glyphicon glyphicon-trash toltip" data-placement="bottom" width="20" title="In Active Student"></span>'), 'update-status/'.$key, [
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
                                return Html::a('<i class="fa fa-file-pdf-o" aria-hidden="true"  title="Generate PDF"></i>','javascript:void(0);',['data-toggle'=>"modal" ,'data-target'=>"#pdf-details",'data-std_name'=>$student_name,'data-std_id'=>$key,'id'=>'modal-pdf-detail','data-url'=>Url::to('student/get-exam-options')]);
                            },

                            'SendSms' => function ($url, $model, $key)
                            {
                                return Html::a('<i class="fa fa-envelope-o data-toggle="modal" data-target="#myModal" title="Send SMS"></i>','javascript:void(0);',['data-toggle'=>'modal','data-target'=>'#myModal','data-stu_id'=>$key,'id'=>'stu']);
                            },

                            'leaving' => function ($url, $model, $key)
                            {
                                 if($model->is_active == '1'){
                                ?>
                            <?php return '<span class="glyphicon glyphicon-remove leavingBtn" data-placement="bottom" width="20"  title="Leaving Institution" data-toggle="modal" data-target="#myModalClass" data-stuid="'.$key.'"></span>' ?>
                            <?php
                                /*return Html::a('<span class="glyphicon glyphicon-remove" data-placement="bottom" width="20"  title="Leaving Institution" data-toggle="modal" data-target="#myModalClass"></span>',Url::to(['student/updatess','id'=>$key],['target'=>'_blank','data-pjax'=>"0"]));*/


                                ///////////////////
                               /* return Html::a(Yii::t('yii', '<span class="glyphicon glyphicon-remove toltip" data-placement="bottom" width="20" title="Leaving Institution" data-toggle="modal" data-target="#myModalClass"></span>'), 'leave-info/'.$key.'', [
                            '   title' => Yii::t('yii', 'leave-info'),
                            'aria-label' => Yii::t('yii', 'leave-info'),
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
                        ]);*/


                                //////////////
                             } },
                        ],
                    ],

                    //['class' => 'yii\grid\ActionColumn'],
                ],
            ]); }?>




    <?php Pjax::end() ?>
</div>

     <!-- Trigger the modal with a button -->
<!-- <button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModal">Open Modal</button> -->

<!-- Modal -->
<!-- <?php //Pjax::begin(); ?>

<?php //$form = ActiveForm::begin(['action' =>['student/test-leave'],'options' => ['data-pjax' => true ]]); ?> -->
<div id="myModalName" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Student Status</h4>
      </div>
      <div class="modal-body">

        <p>
    <input type="hidden" name="" id="getStudids" value="">
    
           <input class="leavingInstitute" type="radio" name="leavinginfo" value="0"><label>Remove Student Record</label><br />
           <input class="leavingInstitute" type="radio" name="leavinginfo" value="1"><label>Student Leaving Institution</label>

           <br />
           <label id="labelRemove" style="color: red"></label>
                <span class="info" style="display: none;">
                <label for="">Remarks</label>
            <textarea name="" class="form-control remarks" id="" cols="30" rows="5"></textarea>
                <br />
                <label for="">Next School</label>
                <input type="text" class="form-control nextSchool">  <br />
                <label for="">Reason for leaving school</label>
                 <input type="text" class="form-control reason"> 
                 <div style="display: none;" class="info col-sm-5">
                  <?php 
                    

                     echo '<label>Date:</label>';
                                                    echo DatePicker::widget([
                                                    'name' => 'overallstart', 
                                                    'value' => date('01-m-Y'),
                                                    'options' => ['placeholder' => ' ','id'=>'startDates'],
                                                    'pluginOptions' => [
                                                        'format' => 'dd-m-yyyy',
                                                        'todayHighlight' => true,
                                                        'autoclose'=>true,
                                                    ]]);

                  ?>           
                  </div>              
           </span>
       </p>
      </div>
      <br /><br /><br />
      <div class="modal-footer">
        <button type="button" class="btn btn-success saveLeavingBtn"  data-url="<?php echo Url::to(['student/leave-info-name'])?>">Submit</button>

        <!-- ajax button -->
        <?php
/* echo  Html::a(Yii::t('yii', '<span class="glyphicon glyphicon-remove toltip" data-placement="bottom" width="20" title="Leaving Institution" data-toggle="modal" data-target="#myModalClass"></span>'), 'leave-info/'.$model->stu_id.'', [
                            '   title' => Yii::t('yii', 'leave-info'),
                            'aria-label' => Yii::t('yii', 'leave-info'),
                            'onclick' => "
                               // if (confirm('Are You Sure You Want To In active this Employee...?')) {
                                    $.ajax('student/test-leave', {
                                        type: 'POST'
                                    }).done(function(data) {
                                        $.pjax.reload({container: '#pjax-container'});
                                    });
                               // }
                                return false;
                            ",
                        ]);*/

         ?>

         <!-- end of ajax button -->

        


        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>



<?php

/*generate pdf model containin deneral data.*/
Modal::begin([
    'header'=>'<h4><span id="student-name"></span> Reputation Details</h4>',
    'footer'=>'<button type="button" class="btn green-btn pull-left" id="close-generate-pdf" data-dismiss="modal">Close</button><button class="btn green-btn pull-right" id="print-pdf" data-url="'.Url::to(['student/generate-dmc-pdf']).'">Generate Pdf</button>',
    'clientOptions' => ['backdrop' => 'static', 'keyboard' => false],
    'id' => 'pdf-details',
    'size'=>'modal-lg',
    'class' => '',
]);
?>
<?php $form = ActiveForm::begin(['id'=>'generate-dmc-form','action'=>Url::to(['student/generate-dmc-pdf'])]); ?>
    <input  type="hidden" name="student_id" id="std_id" value=""/>
    <div class="main-modal">
        <div class="row">
            <?=Html::label('Exam*')?>
            <?= Html::dropDownList('exam_type', null,[],['class'=>'form-control','prompt'=>'Select Exam..','id'=>'exam_type_option']) ?>

        </div>
        <div class="row">
            <div class="form-group field-imp-to-read required">
                <label for="imp-to-read" class="control-label">Important to read.</label>
                <textarea type="text" class="form-control"  rows="7" cols="80" id="imp-to-read" name="imp-to-read">Examinations are merely for testing the annual proceedings. By no means we can be judgmental to a kid's creativity by grades. Every human being is a creation of Allah Almighty and has some unique talent. By comparisons with other children, self esteem of our kid is destroyed.

<span style="color:red"><strong>Be Cautious !!!</strong></span>  About that.</textarea>
                <div class="help-block"></div>
            </div>
        </div>
        <div class="row">
             <div class="form-group field-manners required">
                 <label for="manners" class="control-label">Manners</label>
                <input type="text" id="manners" name="manners" class="rating rating-loading" data-size="xs" min=0 data-max=10 step=0.5 data-show-clear="false" data-show-caption="true">
                <div class="help-block"></div>
            </div>
        </div>

        <div class="row">
            <div class="form-group field-confidence required">
                <label for="manners" class="control-label">Confidence</label>
                <input type="text" id="confidence" name="confidence" class="rating rating-loading" data-size="xs" min=0 data-max=10 step=0.5 data-show-clear="false" data-show-caption="true">
                <div class="help-block"></div>
            </div>
        </div>

        <div class="row">
            <div class="form-group field-cmt-crdntr required">
                <label for="comment-cordinator" class="control-label">Coordinator's Comments </label>
                <textarea type="text" class="form-control"  rows="4" cols="50" id="comment-cordinator" name="comment-cordinator"></textarea>
                <div class="help-block"></div>
            </div>
        </div>
        <div class="row">
            <div class="form-group field-class-teacher required">
                <label for="class-teacher" class="control-label">Class teacher name</label>
                <input type="text" class="form-control" id="class_teacher" name="class-teacher"/>
                <div class="help-block"></div>
            </div>
        </div>
        <label for="comment-cordinator" class="control-label">Area to focus</label>
        <div class="row">
            <div class="col-md-4"><input type="text" class="form-control" id = "area-to-focus-1" name="area-to-focus-1" value="" ></div>
            <div class="col-md-4"><input type="text" class="form-control" id = "area-to-focus-2" name="area-to-focus-2" value="" ></div>
            <div class="col-md-4"><input type="text" class="form-control" id = "area-to-focus-3" name="area-to-focus-3" value="" ></div>
        </div>
    </div>
<?php ActiveForm::end(); ?>
<?php
Modal::end();
?>

<?php $form = ActiveForm::begin(['action'=>Url::to(['student/Send'])]); ?>
    
<div class="container">
  
  <!-- Modal -->
  <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Send SMS</h4>
          <input type="hidden" name="getstudent_id" id="stu_id" value=""/>
        </div>
        <div class="modal-body">
        <textarea class="form-control" name="text" id="textareasms"></textarea>
          <div id="sucmsg" style="color: green;"></div>
        </div>
        <div class="modal-footer">
        <button type="button" class="btn green-btn" id="sendSms" data-url="<?php echo Url::to(['student/send-sms-parent'])?>">Send</button>
          <button type="button" class="btn green-btn" data-dismiss="modal">Close</button>
        </div>
      </div>
      
    </div>
  </div>
  
</div>
</div>

<input type="hidden" class="secondUrl" data-urls="<?php echo Url::to(['student/names'])?>">
<?php ActiveForm::end(); ?>


<?php
$script = <<< JS
 
$(document).on('click','.leavingInstitute',function(){
  
   var status= $('.leavingInstitute:checked').val();
   // alert(statusValue);
    if(status== 1){ 
        $('.info').slideDown('slow');
    }else{
        $('.info').slideUp('slow');
    } 
});


$(document).on('click','.saveLeaving',function(){
    //var stu_id=$('.leavingBtn').data('stuid');
    var stu_id=$('#getStudid').val();
     var date=$('#startDate').val();
    var removeVal=$('.leavingInstitute:checked').val();
    var remarks=$('.remarks').val();
    var nextSchool=$('.nextSchool').val();
    var reason=$('.reason').val();
    var getUrl=$(this).data('url');

    if(removeVal == undefined){
        $("#labelRemoves").html('please fill one option');
    }else{
 
    $.ajax({
            type: "POST",
            data: {stu_id:stu_id,removeVal:removeVal,remarks:remarks,nextSchool:nextSchool,reason:reason,date:date},
            url: getUrl,
            cache: false,
            success: function(result){
                $('#myModalClass').modal('hide');

                $(".searchShow").trigger('click');
            }
    });
}
});






$(document).on('click','.saveLeavingBtn',function(){
//alert('here');
    var stu_id=$('#getStudids').val();
     var date=$('#startDates').val();

   // alert(stu_id);
    var removeVal=$('.leavingInstitute:checked').val();
    var remarks=$('.remarks').val();
    var nextSchool=$('.nextSchool').val();
    var reason=$('.reason').val();
    var getUrl=$(this).data('url');  
    // alert(removeVal);
    // return false;
    if(removeVal == undefined){
        $("#labelRemove").html('please fill one option');
    }else{
    //$('#myModalName').modal('hide');
     //$(".searchShow").trigger('click');


 
    $.ajax({
            type: "POST",
            //dataType:"JSON",
            data: {stu_id:stu_id,removeVal:removeVal,remarks:remarks,nextSchool:nextSchool,reason:reason,date:date},
            url: getUrl,
            cache: false,
            success: function(result){
                console.log(result);
                $('#myModalName').modal('hide');
                $(".searchShow").trigger('click');
                
               
            }
    });
}
});



// class
$(document).on('click','.leavingBtn',function(){
var stuid=$(this).data('stuid');
//alert(stuid);
$('#getStudid').val(stuid);

});


//name


$(document).on('click','.leavingBtnName',function(){
var stuid=$(this).data('stuid');
//alert(stuid);
$('#getStudids').val(stuid);

});







// name
$(document).on('click','.saveLeavingBtn',function(){

    var stu_id=$('#getStudids').val();

    var removeVal=$('.leavingInstitute:checked').val();
    var getUrls=$('.secondUrl').data('urls');  
    //alert(getUrls);

    if(removeVal == 1){
  

 
    $.ajax({
            type: "POST",
            //dataType:"JSON",
            data: {stu_id:stu_id,removeVal:removeVal},
            url: getUrls,
            cache: false,
            success: function(result){
                console.log(result);
                 $('#myModalName').modal('hide');
                 $(".searchShow").trigger('click');
              
               
               
            }
    });

}

});










$(document).on('click','.saveLeaving',function(){
    var stu_id=$('#getStudid').val();
    //alert(stu_id);
    var removeVal=$('.leavingInstitute:checked').val();
    var getUrl=$('.secondUrl').data('urls');

    if(removeVal == 1){
        
 
    $.ajax({
            type: "POST",
            data: {stu_id:stu_id,removeVal:removeVal},
            url: getUrl,
            cache: false,
            success: function(result){
                $('#myModalClass').modal('hide');

                $(".searchShow").trigger('click');
            }
    });
}
});


JS;
$this->registerJs($script);
?>