<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use app\models\EmplEducationalHistoryInfo;
use app\models\EmployeeSalarySelection;
use yii\helpers\Url;
use yii\grid\GridView;
use app\models\EmployeeAllowances;
use app\models\EmployeeDeductions;
use app\models\EmployeePayroll;
use app\models\EmployeeParentsInfo;

/* @var $this yii\web\View */
/* @var $model app\models\EmployeeInfo */

//$this->title =  $model->user->first_name.' '.$model->user->middle_name.' '.$model->user->last_name;
$this->title=Yii::$app->common->getName($model->user_id);
//$this->params['breadcrumbs'][] = ['label' => 'Employee Info', 'url' => ['index']];
//$this->params['breadcrumbs'][] = $this->title; 

?>
<?php 
$this->registerCss(" 


.addres_infos{
   color:green;
   font-weight:bold;
   font-size:20px;
   
}



");

 ?>


<div class="container-wrap pad">
<div class="employee-info-view content_col grey-form tabs" style=" padding: 20px 130px  !important"> 

<!-- <h1 class="p_title"><?//= Html::encode($this->title) ?></h1>  -->
<div class="row">
<div class="col-lg-12">
  
  
  
<div class="col-sm-3"></div>
  
  <div class="col-lg-2 col-md-2 col-2 child2 child">
  <label>Full Name :</label><br>
  <label>Registration No :</label><br>
  <label>Department :</label><br>
  <label>Designation :</label><br>
  
  
  </div>
  
  <div class="col-lg-3 col-md-3  child2 child">
  <label><?php echo Yii::$app->common->getName($model->user_id); ?></label><br>
  <label><?php echo $model->user->username; ?></label><br>
  <label><?php echo ucfirst($model->departmentType->Title); ?></label><br>
  <label><?php echo $model->designation->Title?></label></br>
  
  
  </div>
<div class="col-sm-3" style="padding-bottom: 20px">
    <?php 
       if(!empty($model->user->Image)){
       echo $img= '<img width="100" height="100" src="'.Yii::$app->request->BaseUrl.'/uploads/'.$model->user->Image.'">';
                   }
       ?>
</div>



  </div>
  
</div>





    <div class="pad btn-head pull-right">
        <!-- <?//= Html::a('Update', ['update', 'id' => $model->emp_id], ['class' => 'btn green-btn']) ?> -->
    </div> 
<div id="exTab3">
    <ul  class="nav nav-pills">
        <li class="active">
            <a  href="#student-details" data-toggle="tab">Personnel Information</a>
        </li>
        <li><a href="#3b" data-toggle="tab">Education History</a>
        </li>
        <li><a href="#2b" data-toggle="tab">Attendance</a>
        </li>
        <li><a href="#4b" data-toggle="tab">Salary Details</a>
        </li>
        <li><a href="#5b" data-toggle="tab">Sms Communications</a>
        </li>
        <li class="pull-right">
    <?php echo Html::a('Update', ['update', 'id' => $model->emp_id], ['class' => 'btn green-btn pull-right']); ?>     
            
        </li>
    </ul> 
    <div class="subjects-index shade ">
     	<div class="tab-content clearfix employee-details">
        <div class="tab-pane active" id="student-details">
            <div class="col-sm-12">  
       
    <?= DetailView::widget([
    'model' => $model,
    'attributes' => [
                    /*[
                    'attribute'=>'Image',
                    'label'=>'Photo',
                    'format'=>'raw',
                     'value'     => function($data){
                      if(!empty($data->user->Image)){
                     $img= '<img width="100" height="100" src="'.Yii::$app->request->BaseUrl.'/uploads/'.$data->user->Image.'">';
                      return $img;
                  }else{
                    return "N/A";
                  }
                      }],*/

                    /*[
                    'label'=>'Employee Registration No',
                    'value'=>function($data){
                     if($data){
                        return $data->user->username;
                     }else{
                        return "N/A";
                     }
                    }
                
                    ],*/
                     [
                    'label'=>'',
                    'format'=>'html',
                   // 'contentOptions' =>['class' => 'fullname_class'],
                    'contentOptions' =>['class' => 'addres_infos'],
                    'value'=>'Personnel',
                    
                
                    ],
                
                    [
                    'attribute'=>'hire_date',
                    'value'=>function($data){
                        if($data->hire_date){
                     return $data->hire_date;
                 }else{
                    return "N/A";
                 }
                    }
                
                    ],
                    //'Name_in_urdu',
                      
                    [
                    'label'=>'Urdu Name',
                    'value'=>function($data){
                        if($data->user->name_in_urdu){
                     return $data->user->name_in_urdu;
                 }else{
                    return "N/A";
                 }
                    }
                
                    ],

                    


        
        //'email:email',
        
        
                 [
                    'attribute'=>'contact_no',
                    'value'=>function($data){
                        if($data->contact_no){
                     return $data->contact_no;
                 }else{
                    return "N/A";
                 }
                    }
                
                    ],
                    [
                    'attribute'=>'emergency_contact_no',
                    'value'=>function($data){
                        if($data->emergency_contact_no){
                     return $data->emergency_contact_no;
                 }else{
                    return "N/A";
                 }
                    }
                
                    ],

        
        //'user.email',
                   [
                    'label'=>'Email',
                    'value'=>function($data){
                     if($data->user->email){
                        return $data->user->email;
                     }else{
                        return "N/A";
                     }
                    }
                
                    ],
               [
                    'attribute'=>'cnic',
                    'value'=>function($data){
                        if($data->cnic){
                     return $data->cnic;
                 }else{
                    return "N/A";
                 }
                    }
                
                    ],

                    [
                    'attribute'=>'dob',
                    'value'=>function($data){
                        if($data->dob){
                     return $data->dob;
                 }else{
                    return "N/A";
                 }
                    }
                
                    ],
        
        

            [
                'attribute'=>'religion_id',
                'label'=>'Religion',
                'value'     => function($data){

                    return ucfirst($data->religionType->Title);
                }
            ],
             /*[
              'attribute'=>'department_type_id',
                'label'=>'Department',
                'value'  => function($data){
                 return ucfirst($data->departmentType->Title);
                            
                            }
             ],*/
/*
            [
                'attribute'=>'designation_id',
                'value'     => function($data){

                    return ucfirst($data->designation->Title);
                }
            ],*/
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
        
        [
                    'attribute'=>'Nationality',
                    'format'=>'html',
                    'value'=>function($data){
                        if($data->Nationality){
                     return $data->Nationality ."<br />";
                 }else{
                    return "N/A";
                 }
                    }
                
                    ],
                    [
                    'label'=>'',
                    'format'=>'html',
                    'contentOptions' =>['class' => 'addres_infos'],
                    'value'=>'Address',
                    
                
                    ],
                    
        [
                                'attribute'=>'location2',
                                'value'     => function($data){
                                    if(!empty($data->location2)){
                                        return strtoupper($data->location2) .' , '. $data->city->city_name .' ,  '. $data->district->District_Name .' ,  '. $data->province->province_name .' ,  '. $data->country->country_name;
                                    }else{
                                        return 'N/A';
                                    }
                                }
                            ],
                            [
                                'attribute'=>'location1',
                                'value'     => function($data){
                                    if($data->location1){
                                       // return $data->fkRefCountryId2['country_name'];
                                        return strtoupper($data->location1) .' , '.'  '. $data->fkRefCityId2['city_name'] .', '. $data->fkRefDistrictId2['District_Name'] .' ,  '. $data->fkRefProvinceId2['province_name'] .' ,  '. $data->fkRefCountryId2['country_name'];
                                    }else{
                                        return 'N/A';
                                    }
                                }
                            ],
                            
                    [
                    'label'=>'',
                    'format'=>'html',
                   // 'contentOptions' =>['class' => 'fullname_class'],
                    'contentOptions' =>['class' => 'addres_infos'],
                    'value'=>'Marital',
                    
                
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
                            'label'     =>'Spouse Name',
                            'value'     => function($data){
                                $prntcontact=EmployeeParentsInfo::find()->where(['emp_id'=>$data->emp_id])->one();
                                if($prntcontact->spouse_name){
                                    
                                     return $prntcontact->spouse_name;
                                }else{
                                   return "N/A";
                                }
                            }
                           ],

                           [
                            'label'     =>'Number of Children',
                            'value'     => function($data){
                                $prntcontact=EmployeeParentsInfo::find()->where(['emp_id'=>$data->emp_id])->one();
                                if($prntcontact->no_of_children){
                                    
                                     return $prntcontact->no_of_children;
                                }else{
                                   return "N/A";
                                }
                            }
                           ],
                           [
                    'label'=>'',
                    'format'=>'html',
                    'contentOptions' =>['class' => 'addres_infos'],
                    'value'=>'Parent',
                    
                
                    ],
        [
                    'label'=>'Parent Name',
                    'value'=>function($data){
                        //return $data->emp_id;
                    $prntName=EmployeeParentsInfo::find()->where(['emp_id'=>$data->emp_id])->one();
                     return $prntName->first_name .' '.$prntName->middle_name .' '.$prntName->last_name  ;
                    }
                
                    ],

        [
            'label'     =>'Parent CNIC',
            'value'     => function($data){
                $prntcnic=EmployeeParentsInfo::find()->where(['emp_id'=>$data->emp_id])->one();
                if($prntcnic->cnic){
                    
                     return $prntcnic->cnic;
                }else{
                   return "N/A";
                }
            }
        ],

        [
            'label'     =>'Parent Email',
            'value'     => function($data){
                $prntemail=EmployeeParentsInfo::find()->where(['emp_id'=>$data->emp_id])->one();
                if($prntemail->email){
                    
                     return $prntemail->email;
                }else{
                   return "N/A";
                }
            }
        ],

        [
            'label'     =>'Parent Contact',
            'value'     => function($data){
                $prntcontact=EmployeeParentsInfo::find()->where(['emp_id'=>$data->emp_id])->one();
                if($prntcontact->contact_no){
                    
                     return $prntcontact->contact_no;
                }else{
                   return "N/A";
                }
            }
        ],

         [
            'label'     =>'Parent Contact Number 2',
            'value'     => function($data){
                $prntcontact=EmployeeParentsInfo::find()->where(['emp_id'=>$data->emp_id])->one();
                if($prntcontact->contact_no2){
                    
                     return $prntcontact->contact_no2;
                }else{
                   return "N/A";
                }
            }
        ],

        [
            'label'     =>'Parent Gender',
            'value'     => function($data){
                $prntgendr=EmployeeParentsInfo::find()->where(['emp_id'=>$data->emp_id])->one();
                if($prntgendr->gender == 1){
                    return 'Male';
                    }else{
                        return "Female";
                    }
                  // return $gender;
                
                
            }
        ],

       // 'location2',

                           


        

        


        /*[
            'attribute'=>'guardian_type_id',
            'label'     =>'Guardian',
            'value'     => function($data){
                return ucfirst($data->guardianType->Title);
            }
        ],*/
        /*[
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
                            'attribute'=>'city_id',
                            'value'     => function($data){
                                if($data->city_id) {
                                    return ucfirst($data->city->city_name);
                                }else{
                                    return 'N/A';
                                }
                            }
                        ],*/
        
                        
                          
                          // 'location1',

                           

                            

                          


                           /*[
            'attribute'=>'fk_ref_country_id2',
            'value'     => function($data){
                if($data->fk_ref_country_id2){
                    return ucfirst($data->country->country_name);
                }else{
                    return 'N/A';
                }
            }
        ],
    
                        [
                            'attribute'=>'fk_ref_province_id2',
                            'value'     => function($data){
                                if($data->fk_ref_province_id2){
                                    return ucfirst($data->province->province_name);
                                }else{
                                    return 'N/A';
                                }
                            }
                        ],
                        [
                            'attribute'=>'fk_ref_district_id2',
                            'value'     => function($data){ 
                                if($data->fk_ref_district_id2){
                                    return ucfirst($data->district->District_Name);
                                }else{
                                    return 'N/A';
                                }
                            }
                          ],
    
                        
    
                        [
                            'attribute'=>'fk_ref_city_id2',
                            'value'     => function($data){
                                if($data->fk_ref_city_id2) {
                                    return ucfirst($data->city->city_name);
                                }else{
                                    return 'N/A';
                                }
                            }
                        ],*/
        
        
                           
    ],
    ]) ?>

    </div>
        </div> 

        <div class="tab-pane" id="2b"> 
            <div class="col-sm-12">
                <?php 
        if(count($model)>0){
           
            echo DetailView::widget([
                'model' => $model,
                'attributes' => [
                ['attribute'=>'user_id',
                  'label'=>'Biometric ID',
                   'user_id',
                ],
                [
                'label'=>'Present',
                'value' =>function($data){
                    $query = \app\models\EmployeeAttendance::find()->where(['fk_empl_id'=>$data->emp_id,'leave_type'=>'present']);
                    $presentCount = $query->count();
                    return $presentCount;
                    
                    
                    
                }
            ],
             [
                'label'=>'Leave',
                'value' =>function($data){
                    $query = \app\models\EmployeeAttendance::find()->where(['fk_empl_id'=>$data->emp_id,'leave_type'=>'leave']);
        
                    /*if type is year mont that follwoing query will be executed*/
                    //if($attendance_type == 'year-month'){
                    //    $query->andWhere(['=','DATE_FORMAT(date, "%Y-%m")',$year_month]);
                   // };
        
                    $presentCount = $query->count();
                    return $presentCount;
                }
            ],
             [
                'label'=>'Short Leave',
                'value' =>function($data){
                    $query = \app\models\EmployeeAttendance::find()->where(['fk_empl_id'=>$data->emp_id,'leave_type'=>'shortleave']);
        
                    /*if type is year mont that follwoing query will be executed*/
                    //if($attendance_type == 'year-month'){
                    //    $query->andWhere(['=','DATE_FORMAT(date, "%Y-%m")',$year_month]);
                   // };
        
                    $presentCount = $query->count();
                    return $presentCount;
                }
            ],
            [
                'label'=>'Absent',
                'value' =>function($data){
                    $query = \app\models\EmployeeAttendance::find()->where(['fk_empl_id'=>$data->emp_id,'leave_type'=>'absent']);
        
                    /*if type is year mont that follwoing query will be executed*/
                    //if($attendance_type == 'year-month'){
                    //    $query->andWhere(['=','DATE_FORMAT(date, "%Y-%m")',$year_month]);
                   // };
        
                    $presentCount = $query->count();
                    return $presentCount;
                }
            ],
            
             [
                'label'=>'Chart',
                'format'=>'raw',
                'value' =>function($data){
                    
                        return  '<div id="chartContainer" style="height:280px; padding:0px !important;"></div>';
                    
                     
                }
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
        </div>
        <div class="tab-pane" id="3b">  
            <div class="col-sm-12">
       <!-- <p>
                    <?php //$getEduId=EmplEducationalHistoryInfo::find()->where(['emp_id'=>$model->emp_id])->one();
                        //print_r($getEduId);die;
                    ?>
                   
                    <?php /*echo Html::a('Delete', ['delete', 'id' => $model->stu_id], [
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => 'Are you sure you want to delete this item?',
                    'method' => 'post',
                ],
            ])*/ ?>
                </p>-->
    <?php
    // print_r($model2);
    echo  Html::a('Add', [Url::to(['../education/create']), 'id' => $model->emp_id], ['class' => 'btn green-btn','style'=>'margin-right:5px']);
    if(count($model2)>0){
         /*echo  Html::a('Update', [Url::to(['../education/update']), 'id' => $model2->edu_history_id], ['class' => 'btn green-btn']);  
         echo DetailView::widget([
            'model' => $model2,
            'attributes' => [
                
               'degree_name',
              
               'Institute_name', 
                'grade',
                'total_marks',
                'start_date',
                'end_date', 
                'marks_obtained',               
            ],
        ]);*/
     echo  GridView::widget([
    'dataProvider' => $dataProvider,
    'columns' => [
        ['class' => 'yii\grid\SerialColumn'],
    
       // 'edu_history_id',
        //'fk_branch_id',
        [
        //'attribute'=>'degree_type_id',
        'label'=>'Employee',
        'value'=>function($data){
            if($data->emp_id){
                return $data->emp->user->first_name;
            }else{
                return "N/A";
            }
        }
        ],
        'degree_name',
        
        /*[
        //'attribute'=>'degree_type_id',
        'label'=>'Degree Type',
        'value'=>function($data){
            if($data->degree_type_id){
                return $data->degreeType->Title;
            }else{
                return "N/A";
            }
        }
        ],*/
        'Institute_name',
        // 'institute_type_id',
        // 'grade',
        // 'total_marks',
         'start_date',
         'end_date',
         
        // 'marks_obtained',
    
        //['class' => 'yii\grid\ActionColumn'],
        [
                        'header'=>'Actions',
                        'class' => 'yii\grid\ActionColumn',
                        'template' => "{update}",
                        'buttons' => [
                            'addEducation'=>function($url, $model, $key){
                                return Html::a('<span class="glyphicon glyphicon-education toltip" data-placement="bottom" width="20"  title="Add Student Education"></span>', ['student-education/create','id'=>$key]);
                            },
                            'view' => function ($url, $model, $key)
                            {
                                return Html::a('<span class="glyphicon glyphicon-eye-open toltip" data-placement="bottom" width="20"  title="View Student"></span>', ['education/view','id'=>$key]);
                            },
                            'update' => function ($url, $model, $key)
                            {
                                return Html::a('<span class="glyphicon glyphicon-pencil toltip" data-placement="bottom" width="20"  title="Update Student"></span>',Url::to(['education/update','id'=>$key,'u_id'=>$_GET['id']]));
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
    ],
    ]);  
    }else{
        ?>
        <strong>
            Employe Education history not found.
        </strong>
        
        <?php
    }
    ?> 
        </div>
        </div>
        <div id="4b" class="tab-pane">
            <div class="col-sm-12">
                <?php  
                    /*$payroll = EmployeeAllowances::find()->select(['fk_allownces_id'])->where(['fk_emp_id'=>$_GET['id'],'status'=>1])->All();
        */
                /*$payroll=Yii::$app->db->createCommand("
                    SELECT CONCAT(u.first_name,' ', u.last_name) as `employee name` , ess.fk_emp_id,spg.title as `salary_pay_group`,sps.title as `salary_pay_stages`,sps.amount `Basic_Salary`,sum(sa.amount) as `total_allownces`,sum(efdd.amount) as `total_fix_deduction`,sa.title as sa_title ,efdd.title as ded_title FROM `employee_salary_selection` ess 
                    inner join salary_pay_groups spg on spg.id = ess.fk_group_id 
                    inner join salary_pay_stages sps on sps.id= ess.fk_pay_stages 
                    left join salary_allownces sa on sa.id=ess.fk_allownces_id 
                    left join salary_deduction_type efdd ON efdd.id =ess.fk_fix_deduction_detail 
                    inner join employee_info ei on ei.emp_id=ess.fk_emp_id 
                    inner join user u on u.id=ei.user_id where ess.fk_emp_id='".$_GET['id']."' group by ess.fk_emp_id,spg.title,sps.title,sps.amount,efdd.title")->queryAll();*/
        
                
        // $payroll=Yii::$app->db->createCommand("SELECT CONCAT(u.first_name,' ', u.last_name) as `employee name` , ess.fk_emp_id,spg.title as `salary_pay_group`,sps.title as `salary_pay_stages`,sps.amount `Basic_Salary`,sum(sa.amount) as `total_allownces`,sum(efdd.amount) as `total_fix_deduction`,sa.title as sa_title ,efdd.title as ded_title FROM `employee_salary_selection` ess
        //                 inner join salary_pay_groups spg on spg.id = ess.fk_group_id
        //                 inner join salary_pay_stages sps on sps.id= ess.fk_pay_stages
        //                 left join salary_allownces sa on sa.id=ess.fk_allownces_id
        //                 left join salary_deduction_type efdd ON efdd.id =ess.fk_fix_deduction_detail
        //                 inner join employee_info ei on ei.emp_id=ess.fk_emp_id
        //                 inner join user u on u.id=ei.user_id where ess.fk_emp_id='".$_GET['id']."' 
        //                 group by ess.fk_emp_id,spg.title,sps.title,sps.amount,sa.title,efdd.title")->queryAll();
               // echo '<pre>';print_r($payroll);
              
        
                /*$payroll= EmployeeSalarySelection::find()
                    ->select(['CONCAT(u.first_name," ", u.last_name)  employee_name' , 'employee_salary_selection.fk_emp_id','spg.title  salary_pay_group','sps.title salary_pay_stages','sps.amount Basic_Salary','sum(sa.amount) total_allownces','sum(efdd.amount) total_fix_deduction','sa.title sa_title','efdd.title ded_title'])
                    ->innerJoin('salary_pay_groups spg' , 'spg.id = employee_salary_selection.fk_group_id')
                    ->innerJoin('salary_pay_stages sps' , 'sps.id= employee_salary_selection.fk_pay_stages')
                    ->leftJoin('salary_allownces sa' ,'sa.id=employee_salary_selection.fk_allownces_id')
                    ->leftJoin('salary_deduction_type efdd' , 'efdd.id =employee_salary_selection.fk_fix_deduction_detail')
                    ->innerJoin('employee_info ei' , 'ei.emp_id=employee_salary_selection.fk_emp_id')
                    ->innerJoin('user u' , 'u.id=ei.user_id')
                    ->where(['employee_salary_selection.fk_emp_id'=>$_GET['id']])->groupBy(['employee_salary_selection.fk_emp_id','spg.title','sps.title','sps.amount','efdd.title'])->asArray()->all();*/
        
                //echo '<pre>';print_r($payroll);
                
                    
        
         $payrollDeduction = EmployeeDeductions::find()->select(['fk_deduction_id'])->where(['fk_emp_id'=>$_GET['id'],'status'=>1])->All();
        
                   // print_r($emplyoe_payroll);
                    //echo  $emplyoe_payroll->fk_group_id;
                    $employee_payroll = EmployeePayroll::find()->where(['fk_emp_id'=>$_GET['id']])->one();
                    $emply_alwnc = EmployeeAllowances::find()->where(['fk_emp_id'=>$_GET['id'],'status'=>1])->All();
                    ?>
        
        <table class="table table-bordered">
        <tbody>
        <tr>          
                
                <th style="width:322px">Group : <?php if(empty($employee_payroll->fkGroup->title)){
        
                }else{
                   echo  $employee_payroll->fkGroup->title;
                }
                ?></th>
                <th style="width:322px">Stage : <?php if(empty($employee_payroll->fkPayStages->title)){
        
                }else{
                echo  $employee_payroll->fkPayStages->title;
                }
                ?></th>
                <th>Basic Salary : <?php if(empty($employee_payroll->fkPayStages->amount)){}else{
                    echo $employee_payroll->fkPayStages->amount;?></th>
                    
                    
                    <?php } ?>
                
        </tr>
        <tr>
            
        </tr>
        <tbody>       
        
        </table>
        <div class="col-md-6">
        <table class="table table-striped">
               
        <thead>
        
        <tr>
        <!-- <th>Salary Pay Group</th>
        <th>Salary Pay Stage</th>
        <th>Basic Salary</th> -->
         
        <th>Total Allownces</th>
        
        </tr>
        </thead>
        <tbody>
        <?php
        //print_r($payroll);
        if(count($emply_alwnc) > 0){
        
        $amount=0;
        $sum=0;
        foreach ($emply_alwnc as $pay) {
        
        // $sum+=$pay->fkAllownces->amount;
        ?>
        
        
        <tr>
        <td><strong>
        <?=$pay->fkAllownces->title?></strong>: <?= $totlalwnc=$pay->fkAllownces->amount?>
        </td>
        
        <!--    <td><strong><?//=$pay['ded_title']?></strong>: <?//= $pay['total_fix_deduction'] ?></td> -->
        
        </tr>
        <?php  }?>
        
        <tr>
        <td><strong>Total Allownces: <?=$employee_payroll->total_allownce ?></strong></td>
        </tr>
        <tr>
        
        </tr>
        
        <?php } else{ ?>
        
        <tr>
        <td colsapn="2">N/A</td>
        </tr>
        <?php }?>
        <?php 
        if(count($employee_payroll) > 0){
        if($employee_payroll->total_allownce == '' && $employee_payroll->total_deductions == '' ){?>
           <tr>
            <th>Net Amount:<?php echo $employee_payroll->basic_salary?></th>
        </tr> 
        <?php } }?>
        
        
        
        
        </tbody>
        </table>
                </div>
        
                <div class="col-md-6">
        <table class="table table-striped">
               
        <thead>
        
        <tr>
        <!-- <th>Salary Pay Group</th>
        <th>Salary Pay Stage</th>
        <th>Basic Salary</th> -->
         
        
        
        </tr>
        </thead>
        <tbody>
        <?php
        //print_r($payroll);
        if(count($payrollDeduction) > 0){
        
        //$amount=0;
        // $deducts=0;
        foreach ($payrollDeduction as $deduction) {
        // print_r($deduction);die;
        // $deducts+=$deduction->fkDeduction->amount;
        ?>
        
        
        <tr>
        <td><strong><?=$deduction->fkDeduction->title?></strong>: <?=$deduction->fkDeduction->amount?></td>
        
        </tr>
        
        
        <?php }?>
        
        <tr>
        <td><strong>Total Deductions:</strong> <?php if(!empty($employee_payroll->total_deductions)){
        echo $employee_payroll->total_deductions;
        }?></td>
        </tr>
        
        <tr>
          <td><strong>Net Amount: </strong><?php if(!empty($employee_payroll->total_amount)){
            echo $employee_payroll->total_amount;} ?></td>
        </tr>
        <?php } else{ ?>
        <tr>
        <strong>Total Deductions</strong>
        <br>
        <td colsapn="2">N/A</td>
        </tr>
        <?php }?>
        
        
        
        </tbody>
        </table>
                </div>
               <?php  
            //     $stuQuery = User::find()
            // ->select(['employee_info.emp_id',"concat(user.first_name, ' ' ,  user.last_name) as name"])
            // ->innerJoin('employee_info','employee_info.user_id = user.id')
            // ->where(['user.fk_role_id'=>4])->asArray()->all();
            //  $stuArray = ArrayHelper::map($stuQuery,'emp_id','name');
                 
             
                 ?>
            </div>
        </div> 
        <div id="5b" class="tab-pane"> 
        </div> 
    </div>
     </div>
</div>

</div>


<?php $this->registerJsFile(Yii::getAlias('@web').'/js/jquery.canvasjs.min.js',['depends' => [yii\web\JqueryAsset::className()]]);?>
<?php
  $leave=count($leave);
  $absent=count($absent);
  $shortleave=count($shortleave);
  $present=count($present);
  $script = <<< JS
window.onload = function() { 
    $("#chartContainer").CanvasJSChart({ 
        /*title: { 
            text: "records of ",
            fontSize: 24
        }, */
        axisY: { 
            title: "Products in %" 
        }, 
        legend :{ 
            verticalAlign: "center", 
            horizontalAlign: "right" 
        }, 
        data: [ 
        { 
            type: "pie", 
            showInLegend: true, 
            toolTipContent: "{label} <br/> {y} %", 
            indexLabel: "{y} %", 
            dataPoints: [  
                { label: "Short Leave",    y: $shortleave, legendText: "Short Leave"  },
                { label: "leave",  y: $leave, legendText: "Leave"}, 
                { label: "Absent",y: $absent,  legendText: "Absent" }, 
                { label: "present",y: $present,  legendText: "Present"}, 
            
            ] 
        } 
        ] 
    }); 
}

JS;
$this->registerJs($script);
?>