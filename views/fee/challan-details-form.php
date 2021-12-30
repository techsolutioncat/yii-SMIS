<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\date\DatePicker;
use \app\models\FeeParticulars;
use app\models\FeeChallanRecord;


?> 
<div class="fee-challan-result fee-ch-right shade">
    <div class="head_row">
        <div class="col-md-12">
        	<h3><strong>Name</strong>: <?=ucfirst($query_std_plan['name'])?></h3>
        	<span class="pull-right monthly_p"><strong>Plan Type: </strong><?=ucfirst($query_std_plan['plan_type'])?></span>
        </div> 
    </div>
   <div class="row">
    <div class="col-md-12">
        <?php
        if(count($query_std_plan) >0) {
            $form = ActiveForm::begin(['id'=>'challan-form']);
            echo  $form->field($feeTranscModel, 'id')->hiddenInput(['placeholder' => 'Transaction Amount'])->label(false);
            ?>
            <div class="table-responsive">
                <input type="hidden" name="std_name" value="<?=ucfirst($query_std_plan['name'])?>">
                <input type="hidden" name="Challan" value="<?=ucfirst($feeTranscModel['challan_no'])?>">
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th class="fst_center">No.</th>
                        <th>Heads</th>
                        <!--<th>Discount</th>-->
                        <th >Amount</th>
                        <th >Arrears</th>
                    </tr>
                    </thead>
                    <?php
                    $i = 1;
		    $payable=0;
                    $sum_total = 0;
                    $amount = 0;
                    $remaining_amount=0;
                    $sum_arrears = 0;
                    $ex_head_arrears = 0;
                    $fee_payable = 0;
                    $discount_amt = 0;

                    /*if challan id exisits get extra head for submission.*/
                    if($challan_id){
                        $feeCollectionParticular  = \app\models\FeeCollectionParticular::find()->where([ 'fk_branch_id'=>Yii::$app->common->getBranch(),'fk_stu_id'=>$student_id,'is_active'=> 1
])->one();
                        $extraheads = \app\models\FeeChallanRecord::find()
                            ->select([
                                'fh.title',
                                'fh.id head_id',
                                'fee_challan_record.head_amount',
                                'fee_challan_record.arrears'
                            ])
                            ->innerJoin('fee_heads fh','fh.id=fee_challan_record.fk_head_id')
                            ->where([
                                'fee_challan_record.fk_stu_id'=>$student_id,
                                'fee_challan_record.fk_fee_plan_id'=>$query_std_plan['plan_id'],
                                'fh.extra_head'=>1,
                                'fee_challan_record.status'=>1
                            ])->asArray()->all();
                    }
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
                                'fee_particulars.fk_fee_head_id'      => $item['fee_head_id'],
                                'fk_chalan_id'    => $challan_id,
                            ])
                            ->sum('fhw.payment_received');
                        $amount = (count($feeChallanRecord)>0)?$feeChallanRecord->head_amount:0;
                        $arrears = (count($feeChallanRecord)>0 && !empty($feeChallanRecord->arrears))?$feeChallanRecord->arrears:0;

                        /*if no_months is 1 dont divide by the installment*/
                        /*if ($item['no_months'] == 1) {
                            $amount = $item['fee_head_amount'] * $item['no_months'];
                        } else {
                            $amount = $item['fee_head_amount'] * $item['no_months'] / $query_std_plan['no_of_installments'];
                            //$item['amount'].' '.$item['no_months'].' '.$query_std_plan['no_of_installments'];
                        }*/
			            if($feeHeadWise_received >0){
                           $total = $amount - $feeHeadWise_received; 
                        }else{
                           $sum_total = $sum_total + $amount;			
                        }
 
                        $sum_arrears = $sum_arrears+$arrears;
                        if(($amount - $feeHeadWise_received)>0 || $arrears > 0){
                            ?>
                            <tr>
                                <td class="fst_center"><?= $i ?></td>
                                <td><?= ucfirst($item['fee_head'])?></td>
                               <!-- <td>
                                    discount
                                </td>-->
                                <td>
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
                                        //$totalHeadAmt_without_currency = $item['fee_head_amount']-$feeHeadWise_received - $item['head_discount'];
                                        //$totalHeadAmt_without_currency = round($amount,0) -$feeHeadWise_received - $item['head_discount'];
                                        if(count($feeChallanRecord)>0){
                                        $totalHeadAmt_without_currency =   round($amount,0)- $feeHeadWise_received ;
                                        }else{
                                        $totalHeadAmt_without_currency =   0 ;
                                        }

                                    }else{
                                        if($item['head_discount'] !=''){
                                            //$totalHeadAmt_without_currency = (round($amount,0) - $item['head_discount']);
                                            if(count($feeChallanRecord)>0){
                                             $totalHeadAmt_without_currency = (round($amount,0));
                                            }else{
                                            $totalHeadAmt_without_currency =   0 ;
                                            }
                                        }
                                    }
                                    $remaining_amount = $remaining_amount+ $totalHeadAmt_without_currency;

                                    ?>
                                    <span class="pull-left currency-head"> Rs. </span>
                                    <div class="form-group field-transaction-head-amount pull-right width_88">
                                        <input type="text"  class="form-control" name="transaction_head_amount[<?=$item['fee_head_id']?>]" value="<?=round($totalHeadAmt_without_currency, 0)?>"  aria-invalid="false" placeholder="<?=round($totalHeadAmt_without_currency, 0)?>" readonly>
                                        <div class="help-block"></div>
                                    </div>
                                    <!--<span class="pull-left currency-head"> Amount Received </span>
                                    <span class="pull-left currency-head"><?/*= Yii::$app->formatter->asCurrency($item['payment_rec'], 'RS.')*/?></span>-->
                                </td>
                                <td>
                                    <span class="pull-left currency-head"> Rs. </span>
                                    <div class="form-group field-transaction-head-arrears-amount pull-right width_88 no-margin">
                                        <input type="text"  class="form-control" name="transaction_head_arrears_amount[<?=$item['fee_head_id']?>]" value="<?=$arrears?>"  aria-invalid="false"  readonly>
                                        <div class="help-block"></div>
                                    </div>
                                    </span>
                                </td>

                            </tr>

                            <?php

                            $i++;
                        }
                        else{
                            ?>
                            <input type="text"  class="form-control" name="transaction_head_amount[<?=$item['fee_head_id']?>]" value="0"  aria-invalid="false" placeholder="0"  style="visibility: hidden;position: absolute;">
                            <?php
                        }
                    }


                    /*if(!empty($item['fcp_transport_fare']) || $item['fcp_transport_fare'] != null){
                        if($transport_hostel_received['transport_fare']){
                            $transport_amt = $item['fcp_transport_fare']-$transport_hostel_received['transport_fare'];
                        }else{
                            $transport_amt = $item['fcp_transport_fare'];
                        }

                    }
                    if(!empty($item['fcp_hostel_fare']) || $item['fcp_hostel_fare'] != null) {
                        if ($transport_hostel_received['hostel_fee']) {
                            $hostel_amt = $item['fcp_hostel_fare'] - $transport_hostel_received['hostel_fee'];
                        } else {
                            $hostel_amt = $item['fcp_hostel_fare'];
                        }
                    }*/
                    if(isset($extraheads) && count($extraheads )>0){
                        foreach($extraheads as $ex_heads) {
                            ?>
                            <tr>
                                <td class="fst_center"><?= $i ?></td>
                                <td><?= $ex_heads['title'] ?></td>
                                <td>
                                    <span class="pull-left currency-head"> Rs. </span>
                                    <div class="form-group field-transaction-head-amount pull-right width_88">
                                        <input type="number"  class="form-control"
                                               name="transaction_head_amount[<?= $ex_heads['head_id'] ?>]"
                                               value="<?= round($ex_heads['head_amount'], 0) ?>" aria-invalid="false"
                                               placeholder="<?= round($ex_heads['head_amount'], 0) ?>" min="0"
                                               onkeypress="return isNumberKey(event)" readonly>
                                        <div class="help-block"></div>
                                    </div>
                                </td>

                                <td>
                                    <span class="pull-left currency-head"> Rs. </span>
                                    <div class="form-group field-transaction-head-amount pull-right width_88">
                                        <input type="text" id="transaction-head-arrears_<?= $i?>" class="form-control"
                                               name="transaction_head_arrears_amount[<?= $ex_heads['head_id'] ?>]" value="<?=$ex_heads['arrears']?>"
                                               aria-invalid="false" placeholder="" readonly>
                                        <div class="help-block"></div>
                                    </div>
                                </td>

                            </tr>
                            <?php
                            $ex_head_arrears = $ex_head_arrears+$ex_heads['arrears'];
                            $discount_amt = $item['discount_amount'];
                            $sum_total = $sum_total+$ex_heads['head_amount'];
                            $i++;
                        }
                    }
                            $fee_payable = $feeCollectionParticular->fee_payable;
                    ?>
                    <tr>
                        <th></th>
                       <th><span class="res_total">Total Arrears</span></th>
                        <!-- <td><span class="res_total" id="total-amount" data-total="<?/*=round($sum_total,0)*/?>"><?/*='RS.'.round($sum_total,0)*/?> </span>-->
                        <td><span class="res_total" id="total-amount" data-total="<?=round($sum_arrears+$ex_head_arrears,0)?>"><?='RS.'.round($sum_arrears+$ex_head_arrears,0)?> </span>
                        </td>
                    </tr>
                    <tr style="<?= ($transport_amt>0)?'visibility:visible;':'display:none;' ?> width: 100%;">
                        <th></th>
                        <th colspan="1"><span class="trans_fare">Transport Fare</span></th>
                        <td colspan="1"><span id="total-transport-fare" data-totaltrnsprt="<?=($transport_amt>0)?$transport_amt:0 ?>">
                                <span class="pull-left currency-head"> Rs. </span>
                                <div class="form-group field-transaction-head-amount pull-right width_88 no-margin">
                                     <input type="text" id="transaction-transport_fare" class="form-control" name="FeeTransactionDetails[transaction-transport_fare]" value="<?=$transport_amt?>"  aria-invalid="false" placeholder="<?=$transport_amt?>" readonly>
                                    <div class="help-block"></div>
                                </div>
                                </span></td>
                    </tr>
                    <tr style="<?= ($hostel_amt> 0)?'visibility:visible;':'display:none;' ?> width: 100%;">
                        <th></th>
                        <th colspan="1"><span class="trans_fare">Hostel Fare</span></th>
                        <td colspan="1"><span id="total-hostel-fare" data-totaltrnsprt="<?=($hostel_amt>0)? $hostel_amt:0 ?>">
                                <span class="pull-left currency-head"> Rs. </span>
                                <div class="form-group field-transaction-head-amount pull-right width_88 no-margin">
                                     <input type="text" id="transaction-hostel_fare" class="form-control" name="FeeTransactionDetails[transaction-hostel_fare]" value="<?=$hostel_amt?>"  aria-invalid="false" placeholder="<?=$hostel_amt?>" readonly>
                                    <div class="help-block"></div>
                                </div>
                                </span></td>
                    </tr>
                    <tr style="<?= (!empty($discount_amt) || $discount_amt != null)?'visibility:visible;':'display:none;' ?> width: 100%;">
                        <th></th>
                        <th colspan="1"><span class="trans_fare">Discount Amount</span></th>
                        <td colspan="1"><span id="total-discount" data-totaldiscount="<?=(!empty($discount_amt) || $discount_amt != null)? round($discount_amt,0):0 ?>"><?='RS.'.round($discount_amt,0)?></span></td>
                    </tr>
                    <tr style="<?= (!empty($feeTranscModel->transaction_amount) || $feeTranscModel->transaction_amount != null)?'visibility:visible;':'display:none;' ?> width: 100%;">
                        <th></th>
                        <th colspan="1"><span class="am-right">Amount Paid</span></th>
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
                        <th class="green"></th>
                        <th class="green"><span class="payable">Amount Payable</span></th>
                        <td class="dblue" colspan="2">
                            <?php 
                            if($fee_payable == 0){
                                $payable  = round($remaining_amount,0);
                            }else{
                                $payable = round($fee_payable,0);
                            }
                            /*if($transport_amt>0){
                                $payable = $payable+$transport_amt;
                            }
                            if($hostel_amt >0){
                                $payable = $payable+$hostel_amt;
                            }*/
                            ?>
                            <span id="net-amount" data-net="<?=round($payable)?>"><?php
                                echo  'RS.'. $payable;
                                 ?>
                            </span>
                            <!--<input type="text" id="input_total_amount_payable" class="form-control" name="FeeTransactionDetails[input_total_amount_payable]" value="<?/*=$net_total_amt;*/?>" disabled="disabled">-->
                        </td>
                    </tr>
                    <?php
                    if(count($sundry_account)>0){
                        ?>
                        <tr>
                            <th></th>
                            <th colspan="1"><span class="am-right">Advance Payment</span></th>
                            <td>
                                <div class="form-group field-transaction-head-amount pull-right width_88 no-margin">
                                <input type="text" id="input_total_advance_fee" class="form-control" name="StudentAdvance[input_total_advance_payment]" value="<?=$sundry_account->total_advance_bal?>"  aria-invalid="false" placeholder="<?=$sundry_account->total_advance_bal?>" readonly>
                                    <div class="help-block"></div>
                                </div>

                            </td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <th></th>
                            <th colspan="1"><span class="am-right">Remaining Advance</span></th>
                            <td>
                                <div class="form-group field-transaction-head-amount pull-right width_88 no-margin">
                                <input type="text" id="input_total_remaining_fare" class="form-control" name="StudentAdvance[input_total_advance_remaining_payment]" value="<?=$sundry_account->total_advance_bal-$payable?>"  aria-invalid="false" placeholder="<?=$sundry_account->total_advance_bal-$payable?>" readonly>
                                    <div class="help-block"></div>
                                    </div>
                            </td>
                            <td><input type="hidden" id="input_sundry_status" class="form-control" name="StudentAdvance[input_sundry_status]" value=1 ></td>
                            <td></td>
                        </tr>
                        <?php
                    }else{
                        ?>
                        <input type="hidden" id="input_sundry_status" class="form-control" name="StudentAdvance[input_sundry_status]" value=0 >
                        <?php
                    }

                    ?>

                    <tr class="payment-tr">
                        <td colspan="4">
                            <div class="col-sm-3 efidl">
                                <?= $form->field($feeTranscModel, 'transaction_amount')->textInput(['value'=>$payable,'id'=>'transaction-amount','placeholder' => 'Transaction Amount','readonly'=>'readonly'])->label('Pay Amount'); ?>
                            </div>
                            <div class="col-sm-3 efidl">
                                <?= $form->field($feeTranscModel, 'manual_recept_no')->textInput(['placeholder' => 'Manual Receipt #']); ?>
                            </div>
                            <div class="col-sm-3 efidl">
                                 <?= $form->field($feeTranscModel, 'transaction_date')->widget(DatePicker::classname(), [
                                    'options' => [
                                        'value' => ($feeTranscModel->transaction_date)?date('Y-m-d',strtotime($feeTranscModel->transaction_date)):date('Y-m-d'),
                                        'disabled'=>($payable <= 0)?true:false
                                    ],
                                    'type' => DatePicker::TYPE_INPUT,
                                    'pluginOptions' => [
                                        'autoclose'=>true,
                                        'format' => 'yyyy-mm-dd',
                                        'todayHighlight' => true,
                                    ]
                                ]);
                                ?>
                            </div>
                            <div class="col-sm-2 resbt" >
                                <?= Html::submitButton('Submit', ['value'=>'submit-challan','id'=>'chalan-form-btn','class' => 'btn green-btn green-btn pull-right','style'=>'margin-left:10px;','disabled'=>($payable <= 0)?true:false]) ?>
                                <?php /*echo  Html::submitButton('Partial challan', [ 'value'=>'partial-challan','id'=>'chalan-form-btn','class' =>'btn green-btn pull-right','disabled'=>($payable <= 0)?true:false])*/ ?>
                            </div> 
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
</div>




