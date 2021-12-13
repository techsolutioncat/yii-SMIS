<?php
use yii\helpers\Html;
use yii\bootstrap\Modal;
use Yii\helpers\ArrayHelper;

$discount_type= ArrayHelper::map(\app\models\FeeDiscountTypes::find()->where(['fk_branch_id'=>Yii::$app->common->getBranch(),'is_active'=>1])->all(),'id','title');

?>

<div id="calendar_div">

    <div class="table-responsive" id="table-new-std-challan">
        <table class="table">
            <thead>
            <tr>
                <th>#</th>
                <th>Heads</th>
                <th>Discount</th>
                <th>Amount</th>
            </tr>
            </thead>

            <tbody>
            <?php
            $i=1;
            $sum_total= 0;
            $amount=0;
            $transport_amt=0;
            $discount_sibling=0;
            $store_array_particular=[];
            $settings = Yii::$app->common->getBranchSettings();
            foreach ($query as $items){
                if($items['promotion_head'] == 1){
                    continue;
                }
                if($items['no_months'] == 1){
                    $amount = $items['amount']* $items['no_months'];
                }else{
                    $amount = $items['amount']* $items['no_months']/$fee_plan_Model->no_of_installments;
                    /*$items['amount'].' '.$items['no_months'].' '.$fee_plan_Model->no_of_installments;*/
                }
                if(!empty($parent_cnic)){
                    /*if sibling is more than provided in settings*/
                    if(($cnic_count+1) >= $settings->sibling_no_childs  && $settings->sibling_discount_head == $items['head_id'] ){
                        if(!empty($settings->sibling_discount)){
                            $discount_sibling = $amount*$settings->sibling_discount/100;
                            $amount = $amount-round($discount_sibling,0);
                        }
                    }
                }
                $sum_total= $sum_total+$amount;
                $store_array_particular[]= $items['head_id'];
                ?>
                <tr>
                    <td><?=$i?></td>
                    <td><?=$items['title']?></td>
                    <td>
                        <?php

                        if($items['discount_head_status'] ==1){
                            echo Html::a('<i class="fa fa-money fa-2" aria-hidden="true"></i>','javascript:void(0);',['data-head_id'=>$items['head_id'],'data-head_name'=>$items['title'],'data-head_amount'=>$amount,'data-toggle'=>"modal" ,'data-target'=>"#discount-details",'id'=>'discount-modal']);
                        }else{
                            echo 'N/A';
                        }
                        ?>
                        <div id="show_head_<?=$items['head_id']?>" class="show-head">
                            <input type="hidden" name="head_hidden_discount_amount[<?=$items['head_id']?>]" id="head_hidden_discount_amount" value="0"/>
                            <input type="hidden" name="head_hidden_discount_type[<?=$items['head_id']?>]" id="head_hidden_discount_type" value="0"/>
                            <span></span>
                        </div>
                    </td>
                    <td>
                        <input type="hidden" name="head_hidden_amount[<?=$items['head_id']?>]" id="head_hidden_discount_amount" value="<?=round($amount,0)?>"/>
                        <?='Rs. '.round($amount,0)?>
                    </td>

                </tr>
                <?php
                $i++;
            }
            /*if transport fere is applicable than */
            if(!empty($transport_fare) || $transport_fare != null){
                $net_total_amt = $sum_total+$transport_fare;
            }else{
                $net_total_amt = $sum_total;
            }
            /*if  hostel fee is applicable than */
            if(!empty($hostel_fee) || $hostel_fee != null){
                $net_total_amt = $net_total_amt+$hostel_fee;
            }
            ?>
            <tr>
                <th colspan="3"><span class="pull-right">Total</span></th>
                <td colspan="1"><span  id="total-amount" data-total="<?=$sum_total?>"><?=round($sum_total+$discount_sibling,0);?></span> </td>
            </tr>
            <tr style="<?= (!empty($transport_fare) || $transport_fare != null)?'visibility:visible;':'display:none;' ?> width: 90%;">
                <th colspan="3"><span class="pull-right">Transport Fare</span></th>
                <td ><!--<span id="total-transport-fare" data-totaltrnsprt="<?/*=(!empty($transport_fare) || $transport_fare != null)?round($transport_fare,0):0 */?>"><?/*='Rs. '.round($transport_fare,0)*/?></span>--><span class="pull-left" style="padding: 13px 0px 0px 0;">Rs. </span>
                    <input type="number" id="input_total_transport_fare" onkeyup="transportAdjust(event,this);" data-totaltrnsprt="<?=(!empty($transport_fare) || $transport_fare != null)?round($transport_fare,0):0 ?>" class="form-control" name="StudentDisount[input_total_transport_fare]" value="<?=$transport_fare?>"  style="width: 100px;">
                </td>
            </tr>
            <tr style="<?= (!empty($hostel_fee) || $hostel_fee != null)?'visibility:visible;':'display:none;' ?> width: 100%;">
                <th colspan="3"><span class="pull-right">Hostel Fare</span></th>
                <td ><span id="total-hostel-fare" data-totalhostel="<?=(!empty($hostel_fee) || $hostel_fee != null)?round($hostel_fee,0):0 ?>"><?='Rs. '.round($hostel_fee,0)?></span>
                </td>
            </tr>
            <tr>
                <th colspan="3"><span class="pull-right">Discount</span></th>
                <td colspan="1"><span class="total-discount">Rs. 0</span></td>
            </tr>
            <tr <?=($discount_sibling == 0)?'style="display:none"':''?>>
                <th colspan="3"><span class="pull-right">Sibling Discount(<?=$settings->sibling_discount.'%'?>)</span></th>
                <td colspan="1"><span class="sibling-discount">Rs. <?=$discount_sibling?></span></td>
            </tr>
            <!--<tr>
                <th colspan="2"><span class="pull-right">Discount</span></th>
                <td colspan="1" id="discount_td">
                            <span class="pull-left">
                                <div class="form-group field-discount_radolist has-success">
                                        <input type="hidden" name="StudentDisount[discount_amount]" value=""><div id="discount_radolist" aria-invalid="false"><label class="modal-radio"><input type="radio" name="StudentDisount[discount_amount]" value="1" tabindex="3"><i></i><span>1%</span></label>
                                        <label class="modal-radio"><input type="radio" name="StudentDisount[discount_amount]" value="2" tabindex="3"><i></i><span>2%</span></label>
                                        <label class="modal-radio"><input type="radio" name="StudentDisount[discount_amount]" value="3" tabindex="3"><i></i><span>3%</span></label>
                                        <label class="modal-radio"><input type="radio" name="StudentDisount[discount_amount]" value="4" tabindex="3"><i></i><span>4%</span></label>
                                        <label class="modal-radio"><input type="radio" name="StudentDisount[discount_amount]" value="5" tabindex="3"><i></i><span>5%</span></label>
                                        <label class="modal-radio"><input type="radio" name="StudentDisount[discount_amount]" value="0" tabindex="3"><i></i><span>Other</span></label></div>
                                    <div class="help-block"></div>
                                </div>
                            </span>
                    <div class="pull-left" id="discount-input" style="display: none; clear: both;">
                        <div class="form-group field-feetransactiondetails-id">
                            <input type="text" id="std_custom_discount" class="form-control" name="StudentDisount[custom_discount]" value="">
                        <div class="help-block"></div>
                        </div>
                    </div>
                </td>
            </tr>-->
            <tr>
                <th colspan="3"><span class="pull-right">Net Amount</span></th>
                <td><span id="net-amount" data-net="<?=round($net_total_amt,0)?>"><?php

                        echo 'Rs. '. round($net_total_amt,0); ?>
                            </span>

                    <input type="hidden" id="input_total_hostel_fare" class="form-control" name="StudentDisount[input_total_hostel_fare]" value="<?=$hostel_fee?>" >
                    <input type="hidden" id="input_total_discount" class="form-control" name="StudentDisount[input_total_discount]" value="" >
                    <input type="hidden" id="input_total_amount_payable" class="form-control" name="StudentDisount[input_total_amount_payable]" value="<?=$net_total_amt;?>">
                </td>
            </tr>

            </tbody>
        </table>
        <input type="hidden" value="<?= htmlentities(serialize($store_array_particular)); ?>" name="StudentInfo[student_fee_plan_array]"/>
        <input type="hidden" value="<?= round($sum_total,0) ?>" name="StudentInfo[student_fee_total_amount]"/>
    </div>
</div>
<?php

/*generate pdf model containin deneral data.*/
Modal::begin([
    'header'=>'<h4><span id="discount"></span>Add Discount</h4>',
    'footer'=>'<button type="button" class="btn green-btn pull-left" id="close-disount-modal" data-dismiss="modal">Close</button><button class="btn green-btn pull-right" id="add-discount-head">Add Discount</button>',
    'clientOptions' => ['backdrop' => 'static', 'keyboard' => false],
    'id' => 'discount-details',
    'size'=>'modal-md',
    'class' => '',
]);
?>
    <input type="hidden" name="head-modal-id" id="hidden-head-id"/>
    <input type="hidden" name="head-modal-amount" id="hidden-head-amount"/>
    <div class="row">
        <div class="col-md-3" id="head-name"></div>
        <div class="col-md-4">
            <div id="discount_radolist" aria-invalid="false">
                <label class="modal-radio">
                    <input type="radio" name="amount_type" value="percent" tabindex="3" checked><i></i><span>%age</span>
                </label>
                <label class="modal-radio">
                    <input type="radio" name="amount_type" value="amount" tabindex="3"><i></i><span>Amount</span>
                </label>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <?= Html::dropDownList('discount_type', null, $discount_type,['prompt'=>'Select Discount Type','class'=>'form-control','id'=>'discount-type']) ?>
                <div class="help-block"></div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <input type="number" class="form-control" name="amount" id="head-amount" placeholder="Enter Amount in Percentage"/>
                <div class="help-block"></div>
            </div>
        </div>
    </div>
<?php
Modal::end();
?>