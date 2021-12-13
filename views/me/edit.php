<?php

use yii\helpers\Html;
use app\components\UIKit;

/* @var $this yii\web\View */
/* @var $model app\models\Users */

$this->title = Yii::t('app', 'Update User ', [
            'name' => $model->getfullName(),
        ]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Profile'), 'url' => ['view']];
$this->params['breadcrumbs'][] = Yii::t('app', 'Edit');
?>
 
        <div class="users-update">
            <div class="row">
                <div class="col-md-9">
                    <h4 class="mt-0 mb-0 "><b><i class="fa fa-edit"></i> <?php echo ucfirst($model->getfullName()); ?></b><small> edit profile</small></h4>
                </div>
                
            </div>

            <hr class="  mt-4 mb-4 g-brd-gray-light-v4 g-mx-minus-20">
            
            <?=
            $this->render('_form', [
                'model' => $model,
            ])
            ?>

        </div> 
