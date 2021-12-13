<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use app\models\EmplEducationalHistoryInfo;
use yii\helpers\Url;
use app\models\FeeChallanRecord;
if(!empty(Yii::$app->common->getBranchDetail()->logo)){
    $imgaeUrl =  Yii::getAlias('@web').'/uploads/school-logo/'.Yii::$app->common->getBranchDetail()->logo;
}else{
    $imgaeUrl = '';
}
$copies = Yii::$app->common->getBranchSettings()->challan_copies;
$this->registerCss(" 

@media print{    
    .footer{
        display:none;
    }
    header {
        display:none;
    }
} 

");
for ($itrration=1;$itrration<=$copies;$itrration++) {
    if ($itrration == 1) {
        $copy = 'Student Copy';
    } else if ($itrration == 2) {
        $copy = 'School Copy';
    } else {
        $copy = 'Bank Copy';
    }
        if((Yii::$app->common->getBranch() == 64 || Yii::$app->common->getBranch() == 65 || Yii::$app->common->getBranch() == 66) && $copy == 'Bank Copy'){
            continue;
        }
        ?>
        <div style="border-bottom:1px dashed #3f3c8b; background: url('<?= $imgaeUrl ?>'); background-repeat: no-repeat; background-position: center center;padding-bottom: 8px;
            margin-bottom: 8px;">
            <div style="width: 100%; text-align: center; background-color: #3f3c8b; color: #fff; font-size:14px;">
                <h2 style="font-size:16px; font-weight:600; color:#FFFFFF; text-transform:capitalize;margin: 0;padding: 15px 0 8px 0;"><?=strtoupper(str_replace('-',' ',Yii::$app->common->getBranchDetail()->name))?>&nbsp;<?=strtoupper(str_replace('-',' ',Yii::$app->common->getBranchDetail()->address))?></h2>
            </div>

                <div style="padding:8px 10px;width: 75%; margin-top:5px; float:left; font-size:13px;">
                    <?php
                    if(!empty(Yii::$app->common->getBranchSettings()->fee_bank_name) && !empty(Yii::$app->common->getBranchSettings()->fee_bank_account)) {
                    ?>
                    <?= Yii::$app->common->getBranchSettings()->fee_bank_name ?>
                    A/C No:: <?= Yii::$app->common->getBranchSettings()->fee_bank_account ?>
                        <?php
                    }
                    ?>
                </div>

            <div style="width: auto%; margin-top:5px; float:right; padding:4px; border:1px solid #000;">
				<span><?=$challan_details->challan_no?></span>
            </div>  
            <div style="width: 100%; text-align: center; padding-bottom:10px;">
                <h2 style="font-size:17px; width: 100%; text-transform:capitalize;margin: 0;padding:5px 0;"><?=$copy?></h2>
            </div>
            <div style="width: 50%; float:left;">
            	<table class="table table-striped" style="background:none; font-size:13px;">
                    <thead>
                    <tr> 
                        <th style="background:none;"><strong>Name</strong></th>
                        <th style="background:none;">:: <?= ucfirst($query_std_plan['name']) ?></th>
                    </tr>
                    </thead>
        				<tr> 
                        	<td style="background:none;">Student ID</td>
                            <td style="background:none;">:<?=$student_data->user->username?></td>
                        </tr>
                        <tr> 
                        	<td style="background:none;"><?=Yii::t('app','Class')?></td>
                            <td style="background:none;">:<?= Yii::$app->common->getStudentCGSection($student_data->stu_id) ?></td>
                        </tr>
                        <tr> 
                        	<td style="background:none;">Plan Type</td>
                            <td style="background:none;">:<?= ucfirst($query_std_plan['plan_type']) ?></td>
                        </tr> 
                    <tbody>
                    
                    </tbody>
                </table> 
            </div> 
            <div style="width: 46%; float:right background:none; font-size:13px;">
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th style="background:none;" class="fst_center">No.</th>
                        <th style="background:none;">Heads</th>
                        <th style="background:none;">Amount</th>
                    </tr>
                    </thead> 
                    <tbody>
                    <?php
                    $i=1;
                    $sum_total= 0;
                    $amount=0;
                    $transport_amt=0;
                    $total_discount = 0;
                    $remaining_amount=0;
                    $store_array_particular=[];
                    $discount_sibling=0;
                    $settings = Yii::$app->common->getBranchSettings();
                    foreach ($query as $items){
                        /*partical challan record query*/
                        $feeChallanRecord  = FeeChallanRecord::find()
                            ->select([
                                'fd.amount discount_amount',
                                'fee_challan_record.challan_id challan_id',
                                'fee_challan_record.fk_head_id head_id',
                                'fee_challan_record.head_amount head_amount',
                                'fee_challan_record.hostel_fare hostel_fare',
                                'fee_challan_record.fare_amount transport_fare'
                            ])
                            ->leftJoin('fee_discounts fd','fd.fk_fee_head_id=fee_challan_record.fk_head_id and fd.fk_stud_id=fee_challan_record.fk_stu_id')
                            ->where([
                                'fee_challan_record.fk_branch_id'=>Yii::$app->common->getBranch(),
                                'fee_challan_record.challan_id'    => $challan_details->id,
                                'fee_challan_record.fk_stu_id'     => $student_data->stu_id,
                                'fee_challan_record.fk_head_id'    => $items['head_id'],
                                'fee_challan_record.fk_fee_plan_id'=> $fee_plan_Model->id,
                                'fee_challan_record.status'        => 1
                            ])->asArray()->one();
        
                        /*total head wise received till date.*/
                        $feeHeadWise_received = \app\models\FeeParticulars::find()
                            ->innerJoin('fee_head_wise fhw','fhw.fk_fee_particular_id = fee_particulars.id')
                            ->where([
                                'fee_particulars.fk_branch_id'        => Yii::$app->common->getBranch(),
                                'fee_particulars.fk_stu_id'           => $student_data->stu_id,
                                'fee_particulars.fk_fee_plan_type'    => $fee_plan_Model->id,
                                'fee_particulars.fk_fee_head_id'      => $items['head_id']
                            ])
                            ->sum('fhw.payment_received');
                        $amount = $feeChallanRecord['head_amount'];
        
        
                        /*if there's any discount wit this head add other else as it is*/
                        if($feeChallanRecord['discount_amount']){
                            $amount = $amount + $feeChallanRecord['discount_amount'];
                            $total_discount = $total_discount + $feeChallanRecord['discount_amount'];
                        }
        
                        $sum_total = $sum_total + $amount;
                        if(!empty($parent_cnic)) {
                            /*if sibling is more than provided in settings*/
                            if ($cnic_count >= $settings->sibling_no_childs && $settings->sibling_discount_head == $items['head_id']) {
                                if (!empty($settings->sibling_discount)) {
                                    $head_amount = $items['fee_head_amount'];
                                    $discount_sibling = $head_amount * $settings->sibling_discount / 100;
                                }
                            }
                        }
                        if($items['promotion_head'] != 1) {
                            ?>
                            <tr>
                                <td style="background:none;" class="fst_center"><?= $i ?></td>
                                <td style="background:none;"><?= $items['title'] ?></td>
                                <td style="background:none;">
                                    <?php
                                    if ($items['no_months'] == 1) {
                                        $totalHeadAmt = Yii::$app->formatter->asCurrency($amount, 'RS.');
                                        $totalHeadAmt_without_currency = $amount;
                                    } else {
                                        $totalHeadAmt = Yii::$app->formatter->asCurrency($amount, 'RS.');
                                        $totalHeadAmt_without_currency = $amount;
                                        /*$item['amount'].' '.$item['no_months'].' '.$query_std_plan['no_of_installments'];*/
                                    }
                                    //$totalHeadAmt_without_currency = $head_amount_with_discount = $totalHeadAmt_without_currency - $item['head_discount'];

                                    /*if total headwise receive is not empty it will diduct tht total recieved amount from total along with head discount*/

                                    $remaining_amount = $remaining_amount + $totalHeadAmt_without_currency;

                                    ?>
                                    <span
                                        class="pull-left currency-head"> Rs. <?= round($totalHeadAmt_without_currency, 0) ?></span>
                                    <!--<span class="pull-left currency-head"> Amount Received </span>
                                        <span class="pull-left currency-head"><?/*= Yii::$app->formatter->asCurrency($item['payment_rec'], 'RS.')*/
                                    ?></span>-->
                                </td>
                            </tr>
                            <?php
                            $i++;
                        }
                    }
                    /*if transport fere is applicable than */
                    if(!empty($feeChallanRecord['transport_fare']) || $feeChallanRecord['transport_fare'] != null){
                        $net_total_amt = $sum_total+$feeChallanRecord['transport_fare'];
                    }else{
                        $net_total_amt = $sum_total;
                    }

                    /*hostel fare*/
                    if($feeChallanRecord['hostel_fare'] != null &&  $feeChallanRecord['hostel_fare'] >0){
                        $net_total_amt = $net_total_amt+$feeChallanRecord['hostel_fare'];
                    }
                    /*total amount minus total discount.*/
                    $payable = $net_total_amt-$total_discount;
                    ?>
                   <!-- <tr>
                        <th style="background:none;" colspan="1"></th>
                        <th style="background:none;" colspan="1"><span class="res_total">Total</span></th>
                        <td style="background:none;" colspan="1"><span class="res_total" id="total-amount">Rs.&nbsp;<?/*=round($sum_total+$discount_sibling,0);*/?></span> </td>
                    </tr>-->
                    <?php
                    if((!empty($feeChallanRecord['transport_fare']) || $feeChallanRecord['transport_fare'] != null) && $feeChallanRecord['transport_fare'] != 0) {
                        ?>
                        <tr style="width: 100%;">
                            <th style="background:none;"></th>
                            <th style="background:none;"><span style="font-weight:normal;">Transport Fare</span></th>
                            <td style="background:none;"><span id="total-transport-fare"  data-totaltrnsprt="<?= (!empty($feeChallanRecord['transport_fare']) || $feeChallanRecord['transport_fare'] != null) ? round($transport_fare, 0) : 0 ?>">
                            <span class="pull-left currency-head"> Rs. <?= $feeChallanRecord['transport_fare'] ?></span>
                        	</span>
                            </td>
                        </tr>
                        <?php
                    }
                    if((!empty($feeChallanRecord['hostel_fare']) || $feeChallanRecord['hostel_fare'] != null) && $feeChallanRecord['hostel_fare'] > 0) {
                        ?>
                        <tr style="width: 100%;">
                            <th style="background:none;"></th>
                            <th style="background:none;"><span style="font-weight:normal;">Hostel Fare</span></th>
                            <td style="background:none;"><span id="total-transport-fare"  data-totaltrnsprt="<?= (!empty($feeChallanRecord['hostel_fare']) || $feeChallanRecord['hostel_fare'] != null) ? round($feeChallanRecord['hostel_fare'], 0) : 0 ?>">
                            <span class="pull-left currency-head"> Rs. <?= $feeChallanRecord['hostel_fare'] ?></span>
                        	</span>
                            </td>
                        </tr>
                        <?php
                    }
                    if((!empty($total_discount) || $total_discount != null) && $total_discount!=0 ) {
                        ?>
                        <tr style="width: 100%;">
                            <th style="background:none;"></th>
                            <th style="background:none;"><span class="ds_amount" style="font-weight:normal;">Discount Amount</span></th>
                            <td style="background:none;">
                                <span id="total-discount" data-totaldiscount="<?= (!empty($total_discount) || $total_discount != null) ? round($total_discount, 0) : 0 ?>">
                                    <?= 'Rs. ' . round($total_discount, 0) ?>
                                </span>
                            </td>
                        </tr>
                        <?php
                    }
                    if($discount_sibling>0) {
                        ?>
                        <tr style="width: 100%;">
                            <th style="background:none;"></th>
                            <th style="background:none;"><span class="ds_amount" style="font-weight:normal;">Sibling Discount(<?=$settings->sibling_discount.'%'?>)</span></th>
                            <td style="background:none;">
                                <span id="total-discount">
                                    <?= 'Rs. ' . round($discount_sibling, 0) ?>
                                </span>
                            </td>
                        </tr>
                        <?php
                    }
                    ?>
                    <tr>
                        <th style="background:none;"></th>
                        <th style="background:none;">Amount Payable</th>
                        <td style="background:none;">
                        	<span id="net-amount"><?php echo 'Rs. '. round($net_total_amt-$total_discount,0); ?> </span> 
                        </td>
                    </tr> 
                    </tbody>
            </table> 
            </div>
            <div style="width: 100%; margin-top: 0px; font-size:12px;">
                <strong>Due Date :</strong><?=date('d-m-Y',strtotime($due_date))?>
            </div>
        </div> 
        <?php
    }
?>