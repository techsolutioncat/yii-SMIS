<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use app\models\VisitorResponseInfo;

/* @var $this yii\web\View */
/* @var $model app\models\VisitorInfo */

$this->title = $model->name;
//$this->params['breadcrumbs'][] = ['label' => 'Visitor Infos', 'url' => ['index']];
//$this->params['breadcrumbs'][] = $this->title;
?>
<div class="visitor-info-index content_col grey-form"> 
	<h1 class="p_title">New Visitors</h1>
    <div class="subjects-index shade">  
    <div class="visitor-info-view">  
    	<div class="pad btn-head pull-right">
			 <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn green-btn']) ?>
                <?= Html::a('Delete', ['delete', 'id' => $model->id], [
                    'class' => 'btn btn-danger',
                    'data' => [
                        'confirm' => 'Are you sure you want to delete this item?',
                        'method' => 'post',
                    ],
                ]);
                //$response=VisitorResponseInfo::find()->where(['fk_admission_vistor_id'=>$_GET['id']])->one();
               //echo $response->first_attempt_date;
                //print_r($response);
                
                 ?>
        </div>  
    <?php if($model->fk_vistor_category == '3'){?>
        <?= DetailView::widget([
            'model' => $model,
            'attributes' => [
            [
            'attribute'=>'fk_adv_med_id',
            'label'=>'Mode of Knowing',
            'value'=>function($data){
                if($data->fk_adv_med_id){
                return $data->fkAdvMed->title;
            }else{
                return 'N/A';
            }
            }
            ],
                'name',
            [
            'attribute'=>'fk_class_id',
            'value'=>function($data){
                if($data->fk_class_id){
                return $data->fkClass->title;
            }else{
                return 'N/A';
            }
            }
            ],
                'cnic',
                'contact_no',
                'date_of_visit',
                [
                'attribute'=>'is_active',
                'value'=>function($data){
                    if($data->is_active==1){
                        return 'Yes';
                    }else{
                        return 'No';
                    }
                }
                ],
                [
                    'label'=>'Visitor Category',
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
                'address',
                'coordinator_comments',
                // 'product_name',
                // 'product_description',
                // 'last_degree',
                // 'experiance',
                // 'last_organization',
                // 'qualification',
                 'reference',
                // 'designation',
                // 'organization',
                 'address',
                 'admin_personel_observation',
                 [
                 'attribute'=>'is_admitted',
                 'value'=>function($data){
                    if($data->is_admitted == 0){
                        return "No";
                    }else{
                        return "Yes";
                    }
                    
                 }
                 ],
                
                  [
                   'label'=>'First Call Back',
                   'value'=> function($data){
                    $visitorFirst = VisitorResponseInfo::find()->where(['fk_admission_vistor_id'=>$_GET['id']])->one();
                    if($visitorFirst){
                   return date('d:m:Y',strtotime("$visitorFirst->first_attempt_date"));
                   }else{
                    return "N/A";
                   }
                    
                    
                   }
                   
                  ],
                  
                  [
                   'label'=>'Second Call Back',
                   'value'=> function($data){
                    $visitorSecond = VisitorResponseInfo::find()->where(['fk_admission_vistor_id'=>$_GET['id']])->one();
                    if($visitorSecond){
                    return date("d:m:Y",strtotime("$visitorSecond->second_attempt_date"));
                    }else{
                        return "N/A";
                    }
                    
                   }
                   
                  ],
                  
                  [
                   'label'=>'Third Call Back',
                   'value'=> function($data){
                    $visitorThird = VisitorResponseInfo::find()->where(['fk_admission_vistor_id'=>$_GET['id']])->one();
                    if($visitorThird){
                      return date("d:m:Y",strtotime("$visitorThird->third_attempt_date"));
                      }else{
                        return "N/A";
                      }
                    
                    
                   }
                   
                  ],
     
            ],
        ]);
    
        } ?>
    
    
        <!-- job -->
    <?php if($model->fk_vistor_category == '1'){?>
        <?= DetailView::widget([
            'model' => $model,
            'attributes' => [
                //'id',
            [
            'attribute'=>'fk_adv_med_id',
            'label'=>'Advertisement Mode',
            'value'=>function($data){
                return $data->fkAdvMed->title;
            }
            ],
                'name',
                'cnic',
                'contact_no',
                //'date_of_visit',
                [
                'attribute'=>'is_active',
                'value'=>function($data){
                    if($data->is_active==1){
                        return 'Yes';
                    }else{
                        return 'No';
                    }
                }
                ],
                [
                    'label'=>'Vistor Category',
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
                // 'product_name',
                // 'product_description',
                 'last_degree',
                 'experiance',
                 'last_organization',
                 'qualification',
                // 'reference',
                 [
                 'attribute'=>'designation',
                 'value'=>function($data){
                    if($data->designation){
                        return $data->designation0->Title;
                    }else{
                            return 'N/A';
                    }
            }
                 ],
                 //'organization',
                 'address',
            ],
        ]);
    
        } ?>
        <!-- end of job -->
    
    
        <!-- advertisement -->
    <?php if($model->fk_vistor_category == '2'){?>
        <?= DetailView::widget([
            'model' => $model,
            'attributes' => [
                [
            'attribute'=>'fk_adv_med_id',
            'value'=>function($data){
                return $data->fkAdvMed->title;
            }
            ],
                'name',
                'cnic',
                'contact_no',
                //'date_of_visit',
                [
                'attribute'=>'is_active',
                'value'=>function($data){
                    if($data->is_active==1){
                        return 'Yes';
                    }else{
                        return 'No';
                    }
                }
                ],
                [
                    'label'=>'Vistor Category',
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
                // 'product_name',
                // 'product_description',
                // 'reference',
                 
                 'organization',
                 'address',
            ],
        ]);
    
        } ?>
        <!-- end of Advertisement -->
    
    </div>
</div>
</div>