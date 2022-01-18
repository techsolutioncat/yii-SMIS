<?php 

use app\models\Expense;
use yii\helpers\Url;

$this->registerCssFile( Yii::getAlias('@web/css/plugins/bootstrap.min.css'));
$this->registerCssFile( Yii::getAlias('@web/css/plugins/jquery.dataTables.min.css'));
$this->registerCssFile( Yii::getAlias('@web/css/expense.css'));
$this->registerJsFile(Yii::getAlias('@web').'/js/plugins/jquery.min.js',['depends' => [yii\web\JqueryAsset::className()]]);
$this->registerJsFile(Yii::getAlias('@web').'/js/plugins/jquery.dataTables.min.js',['depends' => [yii\web\JqueryAsset::className()]]);
$this->registerJsFile(Yii::getAlias('@web').'/js/plugins/bootstrap.min.js',['depends' => [yii\web\JqueryAsset::className()]]);
$this->registerJsFile(Yii::getAlias('@web').'/js/plugins/jquery.validate.min.js',['depends' => [yii\web\JqueryAsset::className()]]);
$this->registerJsFile(Yii::getAlias('@web').'/js/expense.js',['depends' => [yii\web\JqueryAsset::className()]]);

 ?> 
<div class="bhoechie-tab-content active">
    <!-- tab 2 content -->
    <div class="row pad15">
        <div class="col-md-12">
            <div class="button-group pull-right">
                <a id="add_expense_head" class="btn btn-info btn-md" href="Javascript:;">+ Expense Head</a>
                <a id="add_expense" class="btn btn-success btn-md" href="Javascript:;">+ Add Expense</a>
            </div>    
        </div>
        <br><br>
    </div>
    <div class="nopad">
        <div class="anotherstudentdata">
            <table class="table table-striped" id="expense_table">
                <thead>
                    <tr>
                        <th>Expense Head</th>
                        <th>Expense Type</th>
                        <th>Amount</th>
                        <th>Description</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        if (!empty($data)) {
                            foreach ($data as $key => $row) {
                    ?>
                    <tr>
                        <td><?php echo $row['head'];?></td>
                        <td><?php echo $row['type'];?></td>
                        <td><?php echo $row['amount'];?></td>
                        <td><?php echo $row['description'];?></td>
                    </tr>
                    <?php
                            }
                        }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- BEGIN EXPENSE HEAD MODAL -->
<div class="modal fade" id="expense_head_modal" tabindex="-1" data-backdrop="static" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <hh2 class="modal-title">Add Expense Head</hh2>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="head_modal_form">
                    <div class="form-group">
                        <label for="head">Expense Head:</label>
                        <input type="text" class="form-control" name="head" id="head" placeholder="Enter Expense Head" />
                        <input type="hidden" id="data_id" value="" />
                        <input type="hidden" id="url" value="<?php echo Url::to(['expense/expense-head-save']);?>" />
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <a href="Javascript:;" class="btn btn-action" data-dismiss="modal">Close</a>
                <a href="Javascript:;" class="btn btn-action" id="save_head">Add Expense Head</a>
            </div>
        </div>
    </div>
</div>
<!-- END EXPENSE HEAD MODAL -->

<!-- BEGIN EXPENSE HEAD MODAL -->
<div class="modal fade" id="expense_modal" tabindex="-1" data-backdrop="static" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <hh2 class="modal-title">Add Expense</hh2>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="expense_modal_form">
                    <input type="hidden" id="expense_id" value="" />
                    <input type="hidden" id="url" value="<?php echo Url::to(['expense/expense-save']);?>" />
                    <input type="hidden" id="get_head_url" value="<?php echo Url::to(['expense/get-head']);?>" />

                    <div class="form-group">
                        <label for="expense_head">Expense Head:</label>
                        <select type="text" class="form-control" name="expense_head" id="expense_head" placeholder="Expense Head">
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="expense_type">Expense Type:</label>
                        <select type="text" class="form-control" name="expense_type" id="expense_type" placeholder="Expense Type">
                            <option value="personal expenses">personal expenses</option>
                            <option value="business expenses">business expenses</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="expense_amount">Amount:</label>
                        <input type="number" class="form-control" name="expense_amount" id="expense_amount" placeholder="Amount" />
                    </div>
                    <div class="form-group">
                        <label for="expense_description">Amount:</label>
                        <textarea type="text" class="form-control" name="expense_description" id="expense_description" placeholder="Description"></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <a href="<?php echo Url::to(['/expense']);?>" class="btn btn-action">Close</a>
                <a href="Javascript:;" class="btn btn-action" id="save_expense">Add Expense Head</a>
            </div>
        </div>
    </div>
</div>
<!-- END EXPENSE HEAD MODAL -->

<div id="toast"><div id="img">Success!</div><div id="desc">Just saved successfully!</div></div>