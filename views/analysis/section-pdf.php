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
//echo '<pre>';print_r($dataprovider);die;
//echo 'herealdsjhklakjkdshfalksjddfhalskjdfhlaksjdfhlaksdfasdfsa';
/* @var $this yii\web\View */


?>
<style>


.logos{
    margin-top:-50px;
    margin-left:10px;
}



#img_span{
margin-top:-10px;
width: 1100px;
height:250px;
margin-left:-10px;

}

table{

/* width:950px;
margin-left:19%;
border-collapse: separate;
border-spacing: 5px; */

}

th, tr, td  {
border:1px solid #469DC8;
padding:10px;
font-size:1.5em;
}

tr:nth-child(even){background-color: #f2f2f2}

#h3_custom{
margin-top:-40px;
float:right; 
color:#39538A;
font-size:23px;
text-align:center;

}

#stud_details{
padding:5px;

background-color: #469DC8;
font-size:19px;
font-weight:bold;

}

#listing{
cell-padding:1;
cell-spacing:1;
}

#centered{
margin-left:200px !important;
margin-top:80px;
color:#39538A;
font-size:19px;
width:800px;

}

#footer_table{
border:0;
margin-top:0px;
}



#dmc_footer{
margin-top:0px;

font-size:19px;
font-weight:bold;
text-align:center;
border:0px !important;
}

  
</style>

 <?= GridView::widget([
                    'dataProvider' => $dataProvider,
                    //'layout' => "{items}\n{pager}",
                    //'filterModel' => $searchModel,
                     //'template' => '{items}{pager}',
                    'layout' => '{items}{pager}',
                    
                    'columns' => [
                        ['class' => 'yii\grid\SerialColumn'],
                        [
                            //'attribute'=>'stu_id',
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
                               /* return Html::a(Yii::$app->common->getName($data->user_id),['student/profile','id'=>$data->stu_id],['target'=>'_blank','data-pjax'=>"0"]);*/
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
                            //'attribute'=>'dob',
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
                            'label'=>'registration_date',
                            'filter'=>'',
                            'value'     => function($data){
                                return date('d M,Y',strtotime($data->registration_date));
                            }
                        ],
                        
                    ],
                ]); ?>