<?php

use yii\grid\GridView;
use yii\helpers\Html;
/* @var $this yii\web\View */

$this->title = 'Group Section';
?>
<div class="student-info-view">

    <h1><?= Html::encode($this->title) ?></h1>
    <div id="exTab3">
        <ul  class="nav nav-pills">
            <li class="active">
                <a  href="#group-section" data-toggle="tab">Group Section</a>
            </li>
            <li><a href="#group-subjects" data-toggle="tab">Group Subjects</a>
            </li>
        </ul>

        <div class="tab-content clearfix">
            <div class="tab-pane active" id="group-section">
                <div class="col-md-12">
                    <?=
                    GridView::widget([
                        'dataProvider' => $dataprovider1,
                        'columns'=>[
                            //'section_id',         
                            [
                                'format'=>'raw',
                                'attribute'=>'title',
                                'value'=>function($data){
                                   /* return Html::a($data->title,['/student/get-students','id'=>$data->section_id,'cid'=>$_GET['cid'],'gid'=>$_GET['gid']]);*/

                                    return Html::a($data->title,['/analysis','id'=>$data->section_id,'cid'=>$_GET['cid'],'gid'=>$_GET['gid']]);

                                }
                            ],
                            [
                                'format'=>'raw',
                                'attribute'=>'fk_group_id',
                                'value'=>function($data){
                                    return ucfirst($data->fkGroup->title);

                                }
                            ],
                            [
                                'attribute'=>'class_id',
                                'value'=>function($data){
                                    return ucfirst($data->class->title);
                                }
                            ],
                        ],
                    ]);
                    ?>

                </div>
            </div>
            <div class="tab-pane" id="group-subjects">
                <div class="col-md-12">
                    <?=
                    GridView::widget([
                        'dataProvider' => $dataprovider2,
                        'columns'=>[
                            'title',
                            'code',
                            [
                                'attribute'=>'fk_group_id',
                                'value'=>function($data){
                                    return ucfirst($data->fkGroup->title);
                                }
                            ],
                            [
                                'attribute'=>'fk_class_id',
                                'value'=>function($data){
                                    return ucfirst($data->fkClass->title);
                                }
                            ],
                        ],
                    ]);
                    ?>
                </div>
            </div>

        </div>
    </div>











