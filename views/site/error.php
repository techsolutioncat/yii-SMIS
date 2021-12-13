<?php

/* @var $this yii\web\View */
/* @var $name string */
/* @var $message string */
/* @var $exception Exception */

use yii\helpers\Html;

$this->title = $name;
?>

<div class="psite-error form-midd fee-gen">
  <img src="<?=Yii::getAlias('@web')?>/img/im404.svg" alt="Momentum Technologies"><br />
<br />
  <div class="erro-header">
  	<span><?= nl2br(Html::encode($message))?></span>
  	<h1>404</h1>
    <b>error</b>
  </div>
  <div class="alerterr">
    <p>The above error occured while the web server was processing your request.<br />
      Please contact us if you think this is a server error.</p>
    <!--<p><?/*= nl2br(Html::encode($message)) */?></p>-->

    <br />
    <a href="<?= Yii::$app->homeUrl ?>" class="btn green-btn">GO BACK</a> </div>
  <div class="error-footer">
    <p>© Mashal MIS <?=date('Y')?></p>
    <p>Product by Momentum Technologies</p>
  </div>
</div>
