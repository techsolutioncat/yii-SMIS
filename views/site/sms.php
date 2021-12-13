 <?php
 use yii\helpers\Html;
use yii\widgets\ActiveForm;
  $form = ActiveForm::begin([
  'action'=>'send',
  
  
  ]); ?>
  <label>From</label>
  <input type="text" name="from" class="form-control" /><br />
  <label>Phone:</label>
    <input type="text" name="number" class="form-control" /><br />
    <label>Msg</label>
    <textarea cols="10" rows="10" name="msg" class="form-control"></textarea>
    <div class="form-group">
	       <input type="submit" name="submit" value="Submit"/>
	    </div>
        
 <?php ActiveForm::end(); ?>