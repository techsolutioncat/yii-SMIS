<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use app\models\EmplEducationalHistoryInfo;


?>
<div class="employee-info-view">

    <h1><?= Html::encode($this->title) ?></h1>
    <div id="exTab3">
        <strong>Employee Profile</strong>
        
        <div class="tab-content clearfix">
        <div class="tab-pane active" id="student-details">
                <div class="col-md-12">
  

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
                          
            ['attribute'=>'emp_id',
             'label'     =>'Employee Name.',
             'value'     => function($data){
             return $data->user->first_name;
                                }
                            ],
            //'fk_branch_id',
            'user.first_name',
            'user.middle_name',
            'user.last_name',
            'dob',
            //'email:email',
            'user.email',
            'contact_no',
            'emergency_contact_no',
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
            'hire_date',
             [
                                'attribute'=>'designation_id',
                                'value'     => function($data){

                                    return ucfirst($data->designation->Title);
                                }
                            ],
                              [
                                'attribute'=>'marital_status',
                                'value'     => function($data){
                                    if($data->marital_status == 1){
                                        $marital_status="Single";
                                    }else if($data->marital_status == 2){
                                        $marital_status="Married";
                                    }else{
                                        $marital_status="Divorced";
                                    }
                                    return $marital_status;
                                }
                            ],
                            [
                                 'attribute'=>'department_type_id',
                                 'label'=>'Department',
                                   'value'  => function($data){

                                    return ucfirst($data->departmentType->Title);
                                
                                }
                            ],
           
            'salary',
                               [
                                 'attribute'=>'religion_type_id',
                                 'label'=>'Department',
                                   'value'  => function($data){

                                    return ucfirst($data->religionType->Title);
                                
                                }
                            ],
                            
            'location1',
            'Nationality',
            'location2',
            'cnic',
            
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
        ],
    ]) ?>

 </div>
            </div>
            <div class="tab-pane" id="2b">
                <?php
        if(count($model)>0){
            echo DetailView::widget([
                'model' => $model,
                'attributes' => [
                ['attribute'=>'user_id',
                  'label'=>'Biometric ID',
                   'user_id',
                ],
                    // 'emp_id'
                ],
            ]); 
        }else{
            ?>
            <strong>
                Employe Id Not Found.
            </strong>
            <?php
        }
        ?> 
            </div>
            <div class="tab-pane" id="3b">
           
        <?php
        if(count($model2)>0){
            echo DetailView::widget([
                'model' => $model2,
                'attributes' => [
                    
                   'degree_name',
                   /*[
                     'attribute'=>'degree_type_id',
                     'label'=>'Degree Type',
                       'value'  => function($data){ 
                        return ucfirst($data->degreeType->Title); 
                    }
                   ], */
                   'Institute_name', 
                   /*[
                     'attribute'=>'institute_type_id',
                       'value'  => function($data){ 
                        return ucfirst($data->degreeType0->Title); 
                    }
                   ], */
                    'grade',
                    'total_marks',
                    'start_date',
                    'end_date', 
                    'marks_obtained',               
                ],
            ]); 
        }else{
            ?>
            
            <?php
        }
        ?> 
            </div>
        </div>
    </div>

