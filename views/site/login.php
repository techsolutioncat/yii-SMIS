<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

//$this->title = 'Login';
//$this->params['breadcrumbs'][] = $this->title;
?>
<div class="login-wrap">
    <div class="login-col col-sm-6">
        <img src="img/mashal.svg" alt="Mashal">
        <h1>Management Information System</h1>
        <?php /*?><?= Html::encode($this->title) ?><?php */?>
        <h5>For</h5>
        <div class="comp-logo">
            <img src="img/logo-150.png" alt="Momentum Technologies">
        </div>
        <div class="login-form">
            <p class="lf-heading">Login</p>
            <?php $form = ActiveForm::begin([
				'id' => 'login-form',
				'layout' => 'horizontal',
				'fieldConfig' => [
					'template' => "<div class=\"col-lg-12\">{label}\n{input}</div>\n<div class=\"col-lg-12\">{error}</div>",
					'labelOptions' => ['class' => 'control-label'],
				],
			]); ?>
		
				<?= $form->field($model, 'username')->textInput(['autofocus' => true]) ?> 
				<?= $form->field($model, 'password')->passwordInput() ?> 
				<!-- <?//= $form->field($model, 'rememberMe')->checkbox([
				 	//'template' => "<div class=\"checkbox\">{input} {label}</div>\n<div class=\"col-lg-12\">{error}</div>",
				 //]) ?> --> 
				<div class="form-group">
					<div class="col-lg-12">
						<?= Html::submitButton('Login', ['class' => 'btn green-btn', 'name' => 'login-button']) ?>
					</div>
				</div> 
			<?php ActiveForm::end(); ?>
 
        </div>
        <div class="login-footer">
            <p>© Mashal MIS 2017</p>
            <p>Product by Momentum Technologies</p>
        </div>
    </div>
</div> 
