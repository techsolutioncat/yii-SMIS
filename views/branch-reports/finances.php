<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use yii\grid\GridView;
use app\models\StudentInfo;
use kartik\date\DatePicker;
use app\models\RefClass;
use app\models\RefSection;
use app\models\RefGroup;
use yii\widgets\ActiveForm;
use kartik\depdrop\DepDrop;
/* @var $this yii\web\View */

$this->title = 'Reports :: Finances';
?>
 
<div class="container">
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-8 col-xs-9 bhoechie-tab-container">
            <div class="col-lg-1 col-md-2 col-sm-3 col-xs-3 bhoechie-tab-menu">
              <div class="list-group">
                <a href="/new-student" class="list-group-item active text-center">
                  Daily Cash In Flow
                </a>
                <a href="/old-student" class="list-group-item text-center">
                 Train
                </a>
                <a href="/acadamic" class="list-group-item text-center">
                  Hotel
                </a>
                <a href="/new-acadamic" class="list-group-item text-center">
                  Restaurant
                </a>
                <a href="/new-asacadamic" class="list-group-item text-center">
                  Credit Card
                </a>
              </div>
            </div>
            <div class="col-lg-11 col-md-10 col-sm-9 col-xs-9 bhoechie-tab">
                <!-- flight section -->
                <div class="bhoechie-tab-content active">
                     <!-- tab 1  content-->
                      

                    <div class="tab-content">
                      <div class="row">
                        
                        <div class="col-md-3">
                    
                            <?php 
                                 echo '<label>Start Date:</label>';
                                        echo DatePicker::widget([
                                        'name' => 'overallstart', 
                                        'value' => date('01-m-Y'),
                                        'options' => ['placeholder' => ' ','id'=>'startDate'],
                                        'pluginOptions' => [
                                            'format' => 'dd-m-yyyy',
                                            'todayHighlight' => true,
                                            'autoclose'=>true,
                                        ]
                                      ]);?>

                            </div>
                            <!-- start of class -->
                           <div class="col-md-3">

                               <?php echo '<label>End Date:</label>';
                                        echo DatePicker::widget([
                                        'name' => 'overallEnd', 
                                        'value' => date('d-m-Y'),
                                        'options' => ['placeholder' => ' ','id'=>'endDate'],
                                        'pluginOptions' => [
                                            'format' => 'dd-m-yyyy',
                                            'todayHighlight' => true,
                                            'autoclose'=>true,
                                        ]
                                      ]);
                                                                                   
                                
                              ?>
                                  
                        </div><br />
                        <div class="col-md-4">
                            <input type="submit" name="submit" class="cashflow btn btn-success" data-url="<?php echo Url::to(['reports/overll-cash-flow'])?>" />
                            <input type="submit" name="Generate Report" value="Generate Report" class="cashflow btn btn-success" data-url="<?php echo Url::to(['reports/overll-cash-flow-pdf'])?>" />
                        </div> 
                         
                        </div>
                        <div class="col-md-12"><div id="cashflowhere"></div></div>
                    
                   </div> <!-- end of tab1 -->
                <!-- train section -->
                <div class="bhoechie-tab-content">
                   <!-- tab 2 content -->
                </div>
    
                <!-- hotel search -->
                <div class="bhoechie-tab-content">
                    <!-- tab 3 content -->
                </div>
                <div class="bhoechie-tab-content">
                    <!-- tab 4 content -->
                </div>
                <div class="bhoechie-tab-content">
                    asdfasdf
                </div>
            </div>
        </div>
  </div>
</div>