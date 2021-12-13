        <?php 
        use yii\helpers\Url;
        use yii\widgets\ActiveForm;
        use yii\helpers\Html;
         ?>         
                  <div class="row">
                  <div class="col-sm-6">
                  <div class="table-responsive student-info-index" id="tablesalary">
                  <table class="table table-striped table-bordered">
                        <thead>
                          <tr class="success">
                            <th>SR</th>
                          
                            <th>Employee</th>
                            <th></th>

                            
                          </tr>
                        </thead>
                            <tbody>
                            <?php
                            $count=0;
                             //echo '<pre>';print_r($salry);die;
                             foreach ($salry as $queryy) {
                             // echo '<pre>';print_r($queryy);
                              $count++;

                              ?>
                                <tr>
                                <td><?php echo $count; ?></td>
                                <td><?php echo $queryy['name']; ?></td>
                                <td><a id="salaryPayShow" data-empid="<?= $queryy['emp_id']; ?>" data-url="<?php echo Url::to(['salary-main/show-salary-pay'])?>" href="javascript:void(0)">
                                <!-- <i class="fa fa-arrow-right" aria-hidden="true" title="Show Pay Slip"></i> -->
                               <!-- <span class="glyphicon glyphicon-chevron-right" title="Show Pay Slip"></span> -->
                                
                                <span class="glyphicon glyphicon-send toltip" data-placement="bottom" width="20" title="Show Pay Slip"></span>



                                </a>
                                </td>
                                
                            </tr>
                            <?php } ?>

                            <tr>
                            <td></td>
                            <td></td>
                             <td>
                             <div id="thisss">
                             <input type="hidden" id="dep-id" value="<?php echo $dep_id; ?>">
  <?= Html::a('Monthly Salary Slip', ['salary-main/generate-monthly-salary-slip','id'=>$dep_id],['class'=>'btn green-btn pull-right montly-challan-btn'])?>
  </div>
  </td>
                            </tr>
                            </tbody>
                     </table>
                 
    <?php 
   // $form = ActiveForm::begin(['id'=>'generate-monthly-challan-form-salary','action'=>Url::to(['salary-main/generate-monthly-salary-slip'])]);?>

     <?php 
     //ActiveForm::end(); ?>
     
    <!-- <input type="submit" name="submit" id="submitpayroll" value="Submit" class="btn btn-success" data-url="<?//= Url::to(['salary-main/save-payroll'])?>" /> -->   
   
                     </div>

                     </div>
                  <div class="col-sm-6">
                  <div class="table-responsive student-info-index" id="showsalarypay">

                  </div>
                  </div>
                     </div>

                     
                  