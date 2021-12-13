<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use app\widgets\Alert;
use app\models\StudentParentsInfo;


/* @var $this yii\web\View */
/* @var $model app\models\StudentInfo */

$this->title =  $model->user->first_name.' '.$model->user->middle_name.' '.$model->user->last_name;
//$this->params['breadcrumbs'][] = ['label' => 'Student Information', 'url' => ['index']];
//$this->params['breadcrumbs'][] = $this->title;
if(Yii::$app->request->get('ch_id')) {
    $this->registerJs("$('#generate-challan-view')[0].click();",\Yii\web\View::POS_LOAD);
}
?>
<div class="container-wrap content_col">
	<h1 class="p_title"><?= Html::encode($this->title) ?></h1>
	<div class="student-info-view">
    	<div class="shade">
		<?php
        if(Yii::$app->request->get('ch_id')) {
            ?>
            <?= Html::a('generate fee challan.',['student/generate-student-fee-challan', 'challan_id' => Yii::$app->request->get('ch_id'),'stu_id' => Yii::$app->request->get('id')],['style'=>'visibility:hidden;','id'=>'generate-challan-view'])?>
            <?php
        }
        ?>
        <?= Alert::widget()?>  
        <div id="exTab3">
            <ul  class="nav nav-pills">
                <li class="active">
                    <a  href="#student-details" data-toggle="tab">Personnel Information</a>
                </li>
                <li><a href="#3b" data-toggle="tab">Education History</a>
                </li>
                <li><a href="#2b" data-toggle="tab">Attendance</a>
                </li>
            </ul>
    
            <div class="tab-content clearfix">
                <div class="tab-pane active" id="student-details">
                    <div class="col-md-12">
                        <p>
                            <?= Html::a('Update', ['update', 'id' => $model->stu_id], ['class' => 'btn green-btn']) ?>
                            <?php /*echo Html::a('Delete', ['delete', 'id' => $model->stu_id], [
                        'class' => 'btn btn-danger',
                        'data' => [
                            'confirm' => 'Are you sure you want to delete this item?',
                            'method' => 'post',
                        ],
                    ])*/ ?>
                        </p>
    
                        <?= DetailView::widget([
                            'model' => $model,
                            'attributes' => [
    
                                [
                            'attribute'=>'Image',
                            'label'=>'Photo',
                            'format'=>'raw',
                             'value'     => function($data){
                              if(!empty($data->user->Image)){
                             $img= '<img width="100" height="100" src="'.Yii::$app->request->BaseUrl.'/uploads/'.$data->user->Image.'">';
                              return $img;
                          }
                              }],
    
    
                                [
                                    'attribute'=>'stu_id',
                                    'label'     =>'Student Registration No.',
                                    'value'     => function($data){
                                        return $data->user->username;
                                    }
                                ],
                               
                                
                               [
                'label'=>'Full Name',
                'value'=>function($data){
                 return Yii::$app->common->getName($data->user_id);
                }
    
                ],
                [
                'label'=>'Parent Name',
                'value'=>function($data){
                 return Yii::$app->common->getParentName($data->stu_id);
                }
    
                ],
                 [
                                    //'attribute'=>'gender_type',
                                    'label'     =>'Parent Contact No',
                                    'value'     => function($data){
                                    $parntContact=StudentParentsInfo::find()->where(['stu_id'=>$data->stu_id])->one();
                                    return $parntContact->contact_no;
                                     
                                        
                                    }
                                ],
                                [
                                    //'attribute'=>'gender_type',
                                    'label'     =>'Parent Emergency Contact No',
                                    'value'     => function($data){
                                    $parntContact=StudentParentsInfo::find()->where(['stu_id'=>$data->stu_id])->one();
                                    return $parntContact->contact_no2;
                                     
                                        
                                    }
                                ],
                                [
                                    'attribute'=>'dob',
                                    'label'     =>'Date of birth',
                                    'value'     => function($data){
                                        return date('d M,Y',strtotime($data->dob));
                                    }
                                ],
                               // 'contact_no',
                               // 'emergency_contact_no',
                                [
                                    'attribute'=>'gender_type',
                                    'label'     =>'Gender',
                                    'value'     => function($data){
                                        if($data->gender_type == 1){
                                            $gender="Male";
                                        }else{
                                            $gender="Female";
                                        }
                                        return $gender;
                                    }
                                ],

                               

                                
                                /*[
                                    'attribute'=>'guardian_type_id',
                                    'label'     =>'Guardian',
                                    'value'     => function($data){
    
                                        return ucfirst($data->guardianType->Title);
                                    }
                                ],*/
                                [
                                    'attribute'=>'country_id',
                                    'value'     => function($data){
                                        if($data->country_id){
                                            return ucfirst($data->country->country_name);
                                        }else{
                                            return 'N/A';
                                        }
                                    }
                                ],
                                [
                                    'attribute'=>'province_id',
                                    'value'     => function($data){
                                        if($data->province_id){
                                            return ucfirst($data->province->province_name);
                                        }else{
                                            return 'N/A';
                                        }
                                    }
                                ],
                                [
                                    'attribute'=>'city_id',
                                    'value'     => function($data){
                                        if($data->city_id) {
                                            return ucfirst($data->city->city_name);
                                        }else{
                                            return 'N/A';
                                        }
                                    }
                                ],
                                [
                                    'attribute'=>'district_id',
                                    'value'     => function($data){
                                        if($data->district_id){
                                            return ucfirst($data->district->District_Name);
                                        }else{
                                            return 'N/A';
                                        }
                                    }
                                ],
                                [
                                    'attribute'=>'registration_date',
                                    'value'     => function($data){
                                        return date('d M,Y',strtotime($data->registration_date));
                                    }
                                ],
                                [
                                    'attribute'=>'session_id',
                                    'value'     => function($data){
    
                                        return ucfirst($data->session->title);
                                    }
                                ],
                                [
                                    'attribute'=>'group_id',
                                    'value'     => function($data){
                                        if($data->group_id){
                                            return ucfirst($data->group->title);
                                        }else{
                                            return 'N/A';
    
                                        }
    
                                    }
                                ],
                                [
                                    'attribute'=>'shift_id',
                                    'value'     => function($data){
                                        if($data->shift_id) {
                                            return ucfirst($data->shift->title);
                                        }else{
                                            return 'N/A';
                                        }
                                    }
                                ],
                                [
                                    'attribute'=>'class_id',
                                    'value'     => function($data){
                                        if($data->class_id){
                                            return ucfirst($data->class->title);
                                        }else{
                                            return 'N/A';
                                        }
                                    }
                                ],
                                [
                                    'attribute'=>'section_id',
                                    'value'     => function($data){
                                        if($data->section_id) {
                                            return ucfirst($data->section->title);
                                        }else{
                                            return 'N/A';
                                        }
                                    }
                                ],
                                
                                [
                                    //'attribute'=>'gender_type',
                                    'label'     =>'CNIC',
                                    'value'     => function($data){
                                    $parntContact=StudentParentsInfo::find()->where(['stu_id'=>$data->stu_id])->one();
                                    return $parntContact->cnic;
                                     
                                        
                                    }
                                ],
                                'location1',
                               // 'location2',
                                'withdrawl_no',
                                
                                [
                                    'attribute'=>'religion_id',
                                    'value'     => function($data){
    
                                        return ucfirst($data->religion->Title);
                                    }
                                ],
                            ],
                        ]) ?>
                    </div>
                </div>
    
            <!-- education -->
            <div class="tab-pane" id="3b">
               
            <?php
            if(count($model2)>0){
                echo DetailView::widget([
                    'model' => $model2,
                    'attributes' => [
                        
                       'degree_name',
                        [
                         'attribute'=>'degree_type_id',
                           'value'  => function($data){
                            if($data->degree_type_id){
                                return ucfirst($data->degreeType->Title);
                            }else{
                                return 'N/A';
                            }
                        }
                       ], 
                       'Institute_name',
                       // [
                       //   'attribute'=>'institute_type_id',
                       //     'value'  => function($data){ 
                       //      return ucfirst($data->instituteType->Title); 
                       //  }
                       // ],
                       'grade',
                    'total_marks',
                    'start_date',
                    'end_date',
                    'marks_obtained',          
                    ],
                ]); 
            }else{
                ?>
                <strong>
                    Student Education history not found.
                </strong>
                <?php
            }
            ?> 
                </div>
    
            <!-- end of education -->
    
    
                <div class="tab-pane" id="2b">
                    <h3>We use the class nav-pills instead of nav-tabs which automatically creates a background color for the tab</h3>
                </div>
            </div>
        </div>
	</div>
</div>
</div>











