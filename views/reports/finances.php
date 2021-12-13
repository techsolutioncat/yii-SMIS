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
use kartik\select2\Select2;
/* @var $this yii\web\View */

$this->title = 'Reports :: Finances';
?> 
<div class="filter_wrap content_col tabs grey-form">
    <h1 class="p_title">Reports Finances</h1>
    <div class="reports_wrap form-middle">
        <!--Reports Graphs-->
        <div class="rep_graphs" id="rep_graphs">
            <img src="<?= Url::to('@web/img/graphs.png') ?>" alt="MIS">
        </div>  
        <div class="shade fee-gen none_c">  
            <div class="bhoechie-tab-container">
                <div class="bhoechie-tab-menu">
                	<div class="list-group tabs_green"> 
                         <a href="/new-student" class="list-group-item active text-center">Daily Cash In Flow &nbsp;&nbsp;&nbsp;</a>
                        <a href="/old-student" class="list-group-item text-center">Student Ledger &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</a>
                        <a href="/acadamic" class="list-group-item text-center">Head Wise Payment Rec</a> 
                        <a href="/std-wise-report" class="list-group-item text-center">Students Overall Report</a>
                        <a href="/std-wise-report" class="list-group-item text-center">Students Class Wise Report</a> 
                    </div>
                </div>
                <div class="bhoechie-tab">
                    <!-- flight section -->
                    <div class="bhoechie-tab-content active">
                         <!-- tab 1  content-->
    
                        <div class="tab-content">
                          <div class="pad15 row" id="cashflowCalendar">
                            
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
                            <div class="col-md-4 sg_btns">
                                <input type="submit" name="submit" class="cashflow btn green-btn" data-url="<?php echo Url::to(['reports/overll-cash-flow'])?>" />
                                <input type="submit" name="Generate Report" value="Generate Report" class="cashflow btn green-btn" data-url="<?php echo Url::to(['reports/overll-cash-flow-pdf'])?>" />
                            </div> 
                             
                            </div>
                            <div class="nopad pad_cntent"><div id="cashflowhere"></div></div>
                        
                       </div>
                       </div> <!-- end of tab1 -->
                    <!-- train section -->
                    <div class="bhoechie-tab-content">
                       <!-- tab 2 content -->
                       <div class="row pad15">
                            <div class="col-md-3">
                           <label>Class</label>
                           <?= Html::dropDownList('ref_class', null,
                             ArrayHelper::map(RefClass::find()->where(['fk_branch_id'=>yii::$app->common->getBranch(),'status'=>'active'])->all(), 'class_id', 'title'),['prompt'=>'Select Class','class'=>'form-control','id'=>'getStuClassWise','data-url'=>Url::to(['reports/get-stu-classwise'])]) ?>
        
                        </div>
                            <div class="col-md-3 showStu" style="display: none">
                            <?php /*echo Html::label('Student');
                              echo Html::dropDownList('student',null,['prompt'=>'Select Student'],['class'=>'form-control stu','data-url'=>Url::to(['reports/show-stu-data'])]);
                             */ ?>
                            <?php echo Html::label('Student');?>
                              <?php
                                echo Select2::widget([
                                  'name' => 'state_2',
                                  'value' => '',
                                  //'data' => $stuQuery,
                                  'options' => ['multiple' => false, 'placeholder' => 'Select states ...','class'=>'stu','data-url'=>Url::to(['reports/show-stu-data'])]
                              ]);
                              ?>
                        </div>
                           <br/><br/>
                           <a href="" id="generate-std-ledger-pdf" class="headWise btn green-btn"   style ="display:none;" data-url = "<?php echo Url::to(['reports/student-ledger-pdf'])?>">Generate Report</a>
                       </div> 
                    <div class="nopad">
                        <div class="studentdata"></div>
                    </div>
                    
                    </div> <!-- end of tab2 --> 
                    <!-- hotel search -->
                    <div class="bhoechie-tab-content">
                        <!-- tab 3 content -->
                        <div class="pad15 clearfix"> 
                            <div class="col-md-3">
                        
                                <?php 
                                     echo '<label>Start Date:</label>';
                                            echo DatePicker::widget([
                                            'name' => 'overallstart', 
                                            'value' => date('01-m-Y'),
                                            'options' => ['placeholder' => ' ','id'=>'startDates'],
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
                                        'options' => ['placeholder' => ' ','id'=>'endDates'],
                                        'pluginOptions' => [
                                            'format' => 'dd-m-yyyy',
                                            'todayHighlight' => true,
                                            'autoclose'=>true,
                                        ]
                                      ]);
                                                                                   
                                
                              ?>

                        </div><br />
                            <div class="col-md-4 sg_btns">
                                <input type="submit" name="submit" class="headWise btn green-btn" data-url="<?php echo Url::to(['reports/headwise-payment-recv'])?>" />

                                   <input type="submit" name="Generate Report" value="Generate Report" class="headWise btn green-btn" data-url="<?php echo Url::to(['reports/headwise-payment-recv-pdf'])?>" />
                                <!-- <input type="submit" name="Generate Report" value="Generate Report" class="cashflow btn btn-success" data-url="<?php // echo Url::to(['reports/overll-cash-flow-pdf'])?>" /> -->
                            </div> 
                            </div> 
                        <div class="nopad">
                            <div class="headwise-pay"></div>
                        </div>
                    </div> <!-- end of tab3 -->
                    <div class="bhoechie-tab-content"> 
                        <div class="nopad table-responsive">
                         <div class="col-md-3">
                        
                                <?php 
                                     echo '<label>Start Date:</label>';
                                            echo DatePicker::widget([
                                            'name' => 'overallstart', 
                                            'value' => date('01-m-Y'),
                                            'options' => ['placeholder' => ' ','id'=>'startDatess'],
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
                                            'options' => ['placeholder' => ' ','id'=>'endDatess'],
                                            'pluginOptions' => [
                                                'format' => 'dd-m-yyyy',
                                                'todayHighlight' => true,
                                                'autoclose'=>true,
                                            ]
                                          ]);
                                                                                       
                                    
                                  ?>
                                  </div>
                                  <div style="height: 30px"></div>
                                  <div class="col-md-4">
                                  <input type="submit" name="submit" class="studentOverlReport btn green-btn" data-url="<?php echo Url::to(['reports/student-overll-report'])?>" />
                                  <input type="submit" name="Generate Report" value="Generate Report" class="studentOverlReport btn green-btn" data-url="<?php echo Url::to(['reports/students-overall-report-pdf'])?>" />
                                  </div>
                            <!-- over all student reports code here -->
                                </div>
                                <br />
                           <div class="showOverallStudent"></div>

                    </div> <!-- end of tab2 -->    
<div class="bhoechie-tab-content">
                        <!-- tab 2 content -->
                        <div class="row pad15">
                            <div class="col-md-3">
                                <label>Class</label>
                                <?= Html::dropDownList('ref_class', null,
                                    ArrayHelper::map(RefClass::find()->where(['fk_branch_id'=>yii::$app->common->getBranch(),'status'=>'active'])->all(), 'class_id', 'title'),['prompt'=>'Select Class','class'=>'form-control','id'=>'getAnotherStuClassWise','data-url'=>Url::to(['reports/get-stu-receipt-wise'])]) ?>

                            </div>
                            <br/><br/>

                        </div>
                        <div class="nopad">
                            <div class="anotherstudentdata"></div>
                        </div>

                    </div> <!-- end of tab2 -->            
                  </div>
            </div>
        </div>
    </div>
</div>