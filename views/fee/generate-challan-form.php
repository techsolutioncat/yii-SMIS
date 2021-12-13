<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\date\DatePicker;
use \app\models\FeeParticulars;
use app\models\FeeChallanRecord;


?>
<div class="row">
    <div class="col-md-6"><strong>Name</strong>: <?=ucfirst($query_std_plan['name'])?></div>
    <div class="col-md-6"><strong>Plan Type : </strong>: <?=ucfirst($query_std_plan['plan_type'])?></div>
</div>
<div class="row">
    <div class="col-md-12">
        <?php
        if(count($query_std_plan)>0) {
            ?>
            <?php
            $form = ActiveForm::begin(['id'=>'challan-form']);
            echo  $form->field($feeTranscModel, 'id')->hiddenInput(['placeholder' => 'Transaction Amount'])->label(false);
            ?>
            <div class="table-responsive">
                <table class="table">
                    <thead>
                    <tr>
                        <th class="fst_center">No.</th>
                        <th>Heads</th>
                        <!--<th>Discount</th>-->
                        <th >Amount</th>
                    </tr>
                    </thead>
                    <?php
                    $i = 1;
                    $sum_total = 0;
                    $amount = 0;
                    $transport_amt=0;
                    $remaining_amount=0;
                    foreach ($query as $item) {
                        /*partical challan record query*/
                        $feeChallanRecord  = FeeChallanRecord::find()->where([
                            'fk_branch_id'=>Yii::$app->common->getBranch(),
                            'challan_id'    => $challan_id,
                            'fk_stu_id'     => $student_id,
                            'fk_head_id'    => $item['fee_head_id'],
                            'fk_fee_plan_id'=> $query_std_plan['plan_id'],
                            'status'        => 1
                        ])->One();

                        /*total head wise received till date.*/
                        $feeHeadWise_received = FeeParticulars::find()
                            ->innerJoin('fee_head_wise fhw','fhw.fk_fee_particular_id = fee_particulars.id')
                            ->where([
                                'fee_particulars.fk_branch_id'        => Yii::$app->common->getBranch(),
                                'fee_particulars.fk_stu_id'           => $student_id,
                                'fee_particulars.fk_fee_plan_type'    => $query_std_plan['plan_id'],
                                'fee_particulars.fk_fee_head_id'      => $item['fee_head_id']
                            ])
                            ->sum('fhw.payment_received');
                        $amount = $feeChallanRecord->head_amount;
                        /*if no_months is 1 dont divide by the installment*/
                        /*if ($item['no_months'] == 1) {
                            $amount = $item['fee_head_amount'] * $item['no_months'];
                        } else {
                            $amount = $item['fee_head_amount'] * $item['no_months'] / $query_std_plan['no_of_installments'];
                            //$item['amount'].' '.$item['no_months'].' '.$query_std_plan['no_of_installments'];
                        }*/

                        if(!empty($item['fcp_transport_fare']) || $item['fcp_transport_fare'] != null){
                            $transport_amt = $item['fcp_transport_fare'];
                        }

                        $sum_total = $sum_total + $amount;

                        ?>
                        <tr>
                            <td valign="bottom"><?= $i ?></td>
                            <td valign="bottom"><?= ucfirst($item['fee_head'])?></td>
                           <!-- <td>
                                discount
                            </td>-->
                            <td valign="bottom">
                                <?php
                                if ($item['no_months'] == 1) {
                                   $totalHeadAmt  =  Yii::$app->formatter->asCurrency($amount, 'RS.');
                                   $totalHeadAmt_without_currency  =  $amount;
                                } else {
                                    $totalHeadAmt =  Yii::$app->formatter->asCurrency($amount, 'RS.') ;
                                    $totalHeadAmt_without_currency =  $amount ;
                                    /*$item['amount'].' '.$item['no_months'].' '.$query_std_plan['no_of_installments'];*/
                                }
                                //$totalHeadAmt_without_currency = $head_amount_with_discount = $totalHeadAmt_without_currency - $item['head_discount'];

                                /*if total headwise receive is not empty it will diduct tht total recieved amount from total along with head discount*/
                               if($feeHeadWise_received !=''){
                                    //$totalHeadAmt_without_currency =   $item['fee_head_amount']-$feeHeadWise_received - $item['head_discount'];
                                    //$totalHeadAmt_without_currency =   round($amount,0) -$feeHeadWise_received - $item['head_discount'];
                                    $totalHeadAmt_without_currency =   round($amount,0) - $feeHeadWise_received;
                                }else{
                                    if($item['head_discount'] !=''){
                                        //$totalHeadAmt_without_currency = (round($amount,0) - $item['head_discount']);
                                        $totalHeadAmt_without_currency = (round($amount,0));
                                    }
                                }
                                $remaining_amount = $remaining_amount+ $totalHeadAmt_without_currency;

                                ?>
                                <span class="pull-left currency-head"> Rs. </span>
                                <div class="form-group field-transaction-head-amount pull-right width_88">
                                    <input type="text" id="transaction-head-amount_<?=$i?>" class="form-control" name="transaction_head_amount[<?=$item['fee_head_id']?>]" value="<?=round($totalHeadAmt_without_currency, 0)?>"  aria-invalid="false" placeholder="<?=round($totalHeadAmt_without_currency, 0)?>">
                                    <div class="help-block"></div>
                                </div>
                                <!--<span class="pull-left currency-head"> Amount Received </span>
                                <span class="pull-left currency-head"><?/*= Yii::$app->formatter->asCurrency($item['payment_rec'], 'RS.')*/?></span>-->
                            </td> 
                        </tr> 
                        <?php
                        $i++;
                    }
                    ?>
                    <tr>
                        <th colspan="2"><span class="pull-right">Total Amount</span></th>
                        <td><span
                                id="total-amount" data-total="<?=round($item['total_fee_amount'],0)?>"><?='RS.'.round($item['total_fee_amount'],0)?>
                            </span>
                        </td>
                    </tr>
                    <tr style="<?= (!empty($item['fcp_transport_fare']) || $item['fcp_transport_fare'] != null)?'visibility:visible;':'display:none;' ?> width: 100%;">
                        <th colspan="2"><span class="pull-right">Transport Fare</span></th>
                        <td colspan="1"><span id="total-transport-fare" data-totaltrnsprt="<?=(!empty($item['fcp_transport_fare']) || $item['fcp_transport_fare'] != null)? $item['fcp_transport_fare']:0 ?>">
                                <span class="pull-left"> Rs. </span>
                                <div class="form-group field-transaction-head-amount pull-right width_88">
                                     <input type="text" id="transaction-transport_fare" class="form-control" name="FeeTransactionDetails[transaction-transport_fare]" value="<?=$item['fcp_transport_fare']?>"  aria-invalid="false" placeholder="<?=$item['fcp_transport_fare']?>">
                                    <div class="help-block"></div>
                                </div>
                                </span></td>
                    </tr>
                    <tr style="<?= (!empty($item['discount_amount']) || $item['discount_amount'] != null)?'visibility:visible;':'display:none;' ?> width: 100%;">
                        <th colspan="2"><span class="pull-right">Discount Amount</span></th>
                        <td colspan="1"><span id="total-discount" data-totaldiscount="<?=(!empty($item['discount_amount']) || $item['discount_amount'] != null)? round($item['discount_amount'],0):0 ?>"><?='RS.'.round($item['discount_amount'],0)?></span></td>
                    </tr>
                    <tr style="<?= (!empty($feeTranscModel->transaction_amount) || $feeTranscModel->transaction_amount != null)?'visibility:visible;':'display:none;' ?> width: 100%;">
                        <th colspan="2"><span class="pull-right">Amount Paid</span></th>
                        <td>
                            <span id="amount-paid" data-amtpaid="<?=round($feeTranscModel->transaction_amount,0)?>"><?='RS.'.round($feeTranscModel->transaction_amount,0)?>
                            </span>
                        </td>
                    </tr>
                    <!--discount amount is commented can be used in future.-->
                    <!--<tr>
                        <th colspan="2"><span class="pull-right">Discount</span></th>
                        <td colspan="2">
                            <span class="pull-right">
                                <div class="form-group field-discount_radolist has-success">
                                        <input type="hidden" name="FeeTransactionDetails[discount_amount]" value=""><div id="discount_radolist" aria-invalid="false"><label class="modal-radio"><input type="radio" name="FeeTransactionDetails[discount_amount]" value="1" tabindex="3"><i></i><span>1%</span></label>
                                        <label class="modal-radio"><input type="radio" name="FeeTransactionDetails[discount_amount]" value="2" tabindex="3"><i></i><span>2%</span></label>
                                        <label class="modal-radio"><input type="radio" name="FeeTransactionDetails[discount_amount]" value="3" tabindex="3"><i></i><span>3%</span></label>
                                        <label class="modal-radio"><input type="radio" name="FeeTransactionDetails[discount_amount]" value="4" tabindex="3"><i></i><span>4%</span></label>
                                        <label class="modal-radio"><input type="radio" name="FeeTransactionDetails[discount_amount]" value="5" tabindex="3"><i></i><span>5%</span></label>
                                        <label class="modal-radio"><input type="radio" name="FeeTransactionDetails[discount_amount]" value="0" tabindex="3"><i></i><span>Other</span></label></div>
                                    <div class="help-block"></div>
                                </div>
                            </span>
                                <span class="pull-right" id="discount-input" style="display: none;">
                                    <div class="form-group field-feetransactiondetails-id">
                                        <input type="text" id="custom_discount" class="form-control" name="FeeTransactionDetails[custom_discount]" value="">
                                    <div class="help-block"></div>
                                    </div>
                                </span>
                        </td>
                    </tr>-->

                    <tr>
                        <th colspan="2"><span class="pull-right">Amount Payable</span></th>
                        <td>
                            <?php
                            if($item['fee_payable'] == 0){
                                $payable  = round($remaining_amount,0);
                            }else{
                                $payable = round($item['fee_payable'],0);
                            }
                            ?>
                            <span id="net-amount" data-net="<?=round($payable)?>"><?php
                                echo  'RS.'. $payable;
                                 ?>
                            </span>
                            <!--<input type="text" id="input_total_amount_payable" class="form-control" name="FeeTransactionDetails[input_total_amount_payable]" value="<?/*=$net_total_amt;*/?>" disabled="disabled">-->
                        </td>
                    </tr>

                    <tr class="payment-tr">
                        <td colspan="2">
                        <?= $form->field($feeTranscModel, 'transaction_amount')->textInput(['value'=>$payable,'id'=>'transaction-amount','placeholder' => 'Transaction Amount','readonly'=>'readonly'])->label('Pay Amount'); ?>
                        </td>
                        <td>
                            <?= $form->field($feeTranscModel, 'transaction_date')->widget(DatePicker::classname(), [
                                'options' => ['value' => ($feeTranscModel->transaction_date)?date('Y-m-d',strtotime($feeTranscModel->transaction_date)):date('Y-m-d')],
                                'type' => DatePicker::TYPE_INPUT,
                                'pluginOptions' => [
                                    'autoclose'=>true,
                                    'format' => 'yyyy-mm-dd',
                                    'todayHighlight' => true,
                                ]
                            ]);
                            ?>
                        </td>

                    </tr>
                    <tr>
                        <td colspan="3">
                            <?= Html::submitButton('Submit', ['value'=>'submit-challan','id'=>'chalan-form-btn','class' => 'btn green-btn pull-right','style'=>'margin-left:10px;','disabled'=>($payable <= 0)?true:false]) ?>
                            <?= Html::submitButton('Partial challan', [ 'value'=>'partial-challan','id'=>'chalan-form-btn','class' =>'btn green-btn pull-right','disabled'=>($payable <= 0)?true:false]) ?>
                        </td>

                    </tr>
                    <tbody>
                    </tbody>
                </table>
            </div>
            <?php ActiveForm::end(); ?>
            <?php
        }else{
            ?>
            <div class="alert alert-warning"><strong>Note!</strong>Record not found.</div>
            <?php
        }
        ?>
    </div>
</div>


