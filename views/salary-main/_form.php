<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use kartik\date\DatePicker;
use app\models\SalaryMain;

/* @var $this yii\web\View */
/* @var $model app\models\SalaryMain */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="salary-main-form">

    <?php $form = ActiveForm::begin(); ?>
    <?php if($model->isNewRecord !=1){
        $slaryMain=SalaryMain::find()->where(['id'=>$model->id])->one();
        $id=$slaryMain->fk_emp_id;
        $basic= Yii::$app->db->createCommand("SELECT CONCAT(u.first_name,' ', u.last_name) as `employee_name` , ess.fk_emp_id,spg.id as `group_id`,spg.title as `salary_pay_group`,sps.id as `stage_id`,sps.title as `salary_pay_stages`,sps.amount `Basic_Salary`,sum(sa.amount) as `total_allownces`,sum(efdd.amount) as `total_fix_deduction`, (sps.amount + ifnull(sum(sa.amount),0) - ifnull(sum(efdd.amount),0)) as `gros_salary` FROM `employee_salary_selection` ess inner join salary_pay_groups spg on spg.id = ess.fk_group_id inner join salary_pay_stages sps on sps.id= ess.fk_pay_stages left join salary_allownces sa on sa.id=ess.fk_allownces_id left join salary_deduction_type efdd ON efdd.id =ess.fk_fix_deduction_detail inner join employee_info ei on ei.emp_id=ess.fk_emp_id inner join user u on u.id=ei.user_id where ess.fk_emp_id='".$slaryMain->fk_emp_id."' group by ess.fk_emp_id,spg.id,sps.id,spg.title,sps.title,sps.amount")->queryOne();
        $emp=Yii::$app->db->createCommand("SELECT CONCAT(u.first_name,' ', u.last_name) as `employee name` , ess.fk_emp_id,spg.title as `salary_pay_group`,sps.title as `salary_pay_stages`,sps.amount `Basic_Salary`,sum(sa.amount) as `total_allownces`,sum(efdd.amount) as `total_fix_deduction`,sa.title as sa_title ,efdd.title as ded_title FROM `employee_salary_selection` ess
                   inner join salary_pay_groups spg on spg.id = ess.fk_group_id
                   inner join salary_pay_stages sps on sps.id= ess.fk_pay_stages
                   left join salary_allownces sa on sa.id=ess.fk_allownces_id
                   left join salary_deduction_type efdd ON efdd.id =ess.fk_fix_deduction_detail
                   inner join employee_info ei on ei.emp_id=ess.fk_emp_id
                   inner join user u on u.id=ei.user_id where ess.fk_emp_id='".$id."' 
                   group by ess.fk_emp_id,spg.title,sps.title,sps.amount,sa.title,efdd.title")->queryAll();
        } ?>
        
    <div class="row">
    <div class="col-md-6">
    <?php //$employee = ArrayHelper::map(\app\models\RefReligion::find()->all(), 'religion_type_id', 'Title');
    if($model->isNewRecord == 1){
       echo $form->field($model, 'fk_emp_id')->widget(Select2::classname(), [
                        'data' => Yii::$app->common->getBranchEmployee(),
                        'options' => ['placeholder' => 'Select Employee ...','class'=>'getEmployee','data-url'=>Url::to(['employee/salary-pay'])],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ]);
    }else{
        echo $form->field($model, 'fk_emp_id')->widget(Select2::classname(), [
                        'data' => Yii::$app->common->getBranchEmployee(),
                        'options' => ['placeholder' => 'Select Employee ...','class'=>'getEmployee','data-url'=>Url::to(['employee-salary-selection/get-employee']),'disabled'=>'disabled'],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ]);
     }
                    ?>
      <div class="row" id="getBscs">
        <div class="col-md-12">
          
        </div>
      </div>
                    <div class="row" id="geAll">
                      <div class="col-md-12">
                    
                      </div>
                    </div>               
                    
                    
    <?php 
                    
    ?>
    <div class="showExist" style="color: red"></div>
    <div class="displayallownces"></div>
    
    
     <?php
       echo $form->field($model, 'allownces_amount')->hiddenInput()->label(false);

       echo $form->field($model, 'fk_pay_stages')->hiddenInput()->label(false);
        /*$stage = ArrayHelper::map(\app\models\SalaryPayStages::find()->all(), 'id', 'title');
                    echo $form->field($model, 'fk_pay_stages')->widget(Select2::classname(), [
                        //'data' => $groups,
                        'options' => ['placeholder' => 'Select stages ...','class'=>'getstage getstageamnt','data-url'=>Url::to(['salary-allownces/get-salary'])],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
       ]);*/
       ?>

    

    
    
     
       
       <?= $form->field($model, 'deduction_amount')->hiddenInput(['class'=>'deductnamnt form-control'])->label(false) ?>
      
     

 
    
    <?= $form->field($model, 'salary_payable')->textInput(['readonly'=>'readonly']) ?>
    
    <?= $form->field($model, 'payment_date')->widget(DatePicker::classname(), [
                     'options' => ['value' => date('Y/m/d')],
                     'pluginOptions' => [
                         'autoclose'=>true,
                         'format' => 'yyyy/mm/dd',
                         'todayHighlight' => true,
                         //'endDate' => '+0d',
                         //'startDate' => '-2y',
                     ]
                 ]);?>
    </div> <!--end of one col-->
    
    <div class="col-md-6">
    
      
    <?php /*$stage = ArrayHelper::map(\app\models\SalaryPayStages::find()->all(), 'id', 'title');
                    echo $form->field($model, 'basic_salary')->widget(Select2::classname(), [
                        'data' => $groups,
                        'options' => ['class'=>'getammount','disabled'=>'disabled','data-url'=>Url::to(['salary-allownces/get-stage-amount'])],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ]);*/
    //echo $form->field($model, 'bonus')->textInput();
      
    echo $form->field($model, 'basic_salary')->hiddenInput(['data-url'=>Url::to(['salary-allownces/get-stage-amount','class'=>'getammount','disabled'=>'disabled','id'=>'salarymain-basic_salary'])])->label(false);
    ?>
    
      
     <div id="amountdisplay" style="display: none;">
     <label>No Of Days</label>
     <input type="text" id="getdeductamnt" class="form-control" data-url=<?php echo Url::to(['salary-allownces/sa']);?> />
    
     
     </div>
    <!-- <p id="salarymain-gross_salary"></p> -->
   
    <?php 
           //if($model->isNewRecord == 1){
           echo $form->field($model, 'gross_salary')->hiddenInput(['readonly'=>'readonly'])->label(false);

        //}
        /*else{
           echo $form->field($model, 'gross_salary')->textInput(['readonly'=>'readonly']);
             }*/
    ?>

    <?php $tax = ArrayHelper::map(\app\models\SalaryTax::find()->all(), 'id', 'tax_rate');
                    echo $form->field($model, 'fk_tax_id')->widget(Select2::classname(), [
                        'data' => $tax,
                        'options' => ['prompt'=>'Select Tax'],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ]);
     
      ?>
    <?= $form->field($model, 'tax_amount')->textInput(['readonly'=>'readonly']) ?>
    
    <?= $form->field($model, 'salary_month')->widget(DatePicker::classname(), [
                     'options' => ['value' => date('Y/m/d')],
                     'pluginOptions' => [
                         'autoclose'=>true,
                         'format' => 'yyyy/mm/dd',
                         'todayHighlight' => true,
                         //'endDate' => '+0d',
                         //'startDate' => '-2y',
                     ]
                 ]);?>

    <?= $form->field($model, 'is_paid')->hiddenInput(['value'=>'1'])->label(false) ?>
    

    </div> <!-- end of scnd col!-->
    </div> <!-- end of row !-->
     

    
    
    

    

    

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Save' : 'Update', ['class' => $model->isNewRecord ? 'btn green-btn' : 'btn green-btn']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>






