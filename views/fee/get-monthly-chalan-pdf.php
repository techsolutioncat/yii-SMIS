<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use app\models\EmplEducationalHistoryInfo;
use yii\helpers\Url;
use app\models\FeeChallanRecord;
use yii\helpers\ArrayHelper;

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
    body{
     background-color:#fff !important;
    }
}  

");

if(count($sundry_account) > 0 ) {
    $sundary_list= ArrayHelper::map($sundry_account,'fk_head_id','total_advance_bal');
}


?>

<?php 
    for ($itrration=1;$itrration<=$copies;$itrration++) {
        if ($itrration == 1) {
            $copy = 'Dues Reminder';
        } else if ($itrration == 2) {
            $copy = 'School Copy';
        } else {
            $copy = 'Bank Copy';
        }
        if((Yii::$app->common->getBranch() == 64 || Yii::$app->common->getBranch() == 65 || Yii::$app->common->getBranch() == 66) && $copy == 'Bank Copy'){
            continue;
        }
		
        ?>
        <style type="text/css">
        	*{ margin:0; padding:0;}
        </style>
        <div style="border-bottom:1px dashed #3f3c8b; background: url('<?= $imgaeUrl ?>'); background-repeat: no-repeat; background-position: center center;padding-bottom: 5px;
            margin-bottom: 5px; background-color: #fff;">
            <div style="width: 100%; text-align: center; /*background-color: #3f3c8b;*/ color: #000; font-size:14px;">
                <h2 style="font-size:16px; font-weight:700; color:#000000; text-transform:capitalize;margin: 0;padding: 15px 0 8px 0;">
                    <?=Yii::$app->common->getBranchDetail()->address?>
                </h2>
            </div>
            <div style="padding:10px;width: 75%; margin-top:5px; float:left; font-size:13px;text-align:center;">
                <h2 style="font-size:17px; width: 100%; text-transform:capitalize;margin: 0;padding:5px 0;font-weight:700;"><?=$copy?></h2>            </div> 
            <div style="width: auto%; margin-top:5px; float:right; padding:6px; border:1px solid #000;">
				<span><?= $challan_no ?></span>
            </div> 
 		<div style="width: 100%; padding-bottom:10px;">
                    <table class="table table-striped" style="background:none; font-size:13px;">
                    <thead>
                    <tr> 
                          <th style="background:none;">Class : <?=$student->class->title?></th>
                        <th style="background:none;">Section :<?=$student->section->title?></th>
                        <th style="background:none;">Account No: <?= ucfirst($student->user->username) ?></th>                     </tr>
                    </thead> 
                </table> 
		<table class="table table-striped" style="background:none; font-size:13px;">
                    <thead>
                    <tr> 
                        <th style="background:none;">Student Name : <?= ucfirst($student_name) ?></th>
                        <th style="background:none;">Father Name : <?=ucfirst(Yii::$app->common->getParentName($student->stu_id))?></th>
                    </tr>
		    <tr>
		    <td colspan="2">
		    <p>We would like to inform you that the following amount on account of your Son/Ward have become due.</p>
		    </td>
			</tr>
                    </thead> 
                </table> 

            </div>
            <div style="width: 30%; float:left;">
            	 
            </div> 
            <div style="width: 66%; float:right background:none; font-size:13px;">
                <table class="table table-striped" style="background:none;" cellpadding="8">
                    <thead>
                    <tr> 
                        <th style="background:none;">S#&nbsp;&nbsp;</th>
                        <th style="background:none;">&nbsp;&nbsp;Particulars</th>
                        <th style="background:none;">&nbsp;&nbsp;Amount</th>
                        <th style="background:none;">&nbsp;&nbsp;Total Adv.</th>
                        <th style="background:none;">Remaining Adv.</th>
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
                    $total_advance_amount = 0;
                    $total_remaining_advance_amount = 0;
                    $head_advance = 0;
                    $remaining_advance = 0;
                    $arrears = 0;
                    $store_array_particular=[];
                    if($challan_id){
                        $extraheads = \app\models\FeeChallanRecord::find()
                            ->select([
                                'fh.title',
                                'fh.id head_id',
                                'fee_challan_record.head_amount',
                                'fee_challan_record.arrears'
                            ])
                            ->innerJoin('fee_heads fh','fh.id=fee_challan_record.fk_head_id')
                            ->where([
                                'fee_challan_record.fk_stu_id'=>$student->stu_id,
                                'fee_challan_record.fk_fee_plan_id'=>$plan_id,
                                'fh.extra_head'=>1,
                                'fee_challan_record.status'=>1
                            ])->asArray()->all();
                    }

                    foreach ($query as $items){ 
                        /*partical challan record query*/
                        $fee_challan_record = \app\models\FeeChallanRecord::find()->where(['fk_stu_id'=>$student->stu_id,'fk_fee_plan_id'=>$plan_id,'fk_head_id'=>$items['fee_head_id'],'status'=>1])->one();


                        if(count($fee_challan_record)>0){
                            /*if head is availabel head amount will be shown from fee challan record.*/
                            $amount = $fee_challan_record->head_amount;
                        }else{
                            /*if fee challan record amount is empoty that it will get head amount from actual heads.*/
                            if($items['no_months'] == 1){
                                $amount = 0;
                            }else{
                                $amount = $items['amount']* $items['no_months']/$no_of_installments;

                            }
                        }

                        /*if  (!empty($fee_challan_record->arrears)){
                            $amount = $amount + $fee_challan_record->arrears;
                        }*/
                        $sum_total = $sum_total + $amount;
                        $arrears = $arrears+$fee_challan_record->arrears;
                        if($amount > 0) {
                            ?>
                            <tr style="background:none;">
                                <td style="background:none;"><?=$i?>&nbsp;&nbsp;</td>
                                <td style="background:none;">&nbsp;&nbsp;<?=$items['fee_head']?></td>
                                <td style="background:none;">&nbsp;&nbsp;
                                    <?php
                                    if ($items['no_months'] == 1) {
                                        $totalHeadAmt  =  Yii::$app->formatter->asCurrency($amount, 'RS.');
                                        $totalHeadAmt_without_currency  =  $amount;
                                    } else {
                                        $totalHeadAmt =  Yii::$app->formatter->asCurrency($amount, 'RS.') ;
                                        $totalHeadAmt_without_currency =  $amount ;
                                        /*$item['amount'].' '.$item['no_months'].' '.$query_std_plan['no_of_installments'];*/
                                    }
                                    //$totalHeadAmt_without_currency = $head_amount_with_discount = $totalHeadAmt_without_currency - $item['head_discount'];
                                    /*if total headwise receive is not empty it will diduct tht total recieved amount from total along with head discount*/
                                    $remaining_amount = $remaining_amount+ $totalHeadAmt_without_currency;
                                    ?>
                                    <span class="pull-left currency-head"> Rs. <?=round($totalHeadAmt_without_currency, 0)?></span>
                                    <!--<span class="pull-left currency-head"> Amount Received </span>
                                            <span class="pull-left currency-head"><?/*= Yii::$app->formatter->asCurrency($item['payment_rec'], 'RS.')*/?></span>-->
                                </td>
                                <td style="background:none;">&nbsp;&nbsp;
                                    <?php
 
                                    if(isset($sundary_list[$items['fee_head_id']]) && $sundary_list[$items['fee_head_id']] > 0){
                                        $total_advance_amount = $total_advance_amount + $sundary_list[$items['fee_head_id']];
                                        ?>
                                        <span class="pull-left currency-head"> Rs. <?=$sundary_list[$items['fee_head_id']]?></span>
                                        <?php
                                    }else{
                                        ?>
                                        <span class="pull-left currency-head"> Rs. 0</span>
                                        <?php
                                    }
                                    ?>
                                </td>
                                <td style="background:none;">&nbsp;&nbsp;
                                    <?php

                                    if(isset($sundary_list[$items['fee_head_id']]) && $sundary_list[$items['fee_head_id']] > 0){
 
                                        $remaining_advance = $sundary_list[$items['fee_head_id']] - round($totalHeadAmt_without_currency, 0);
                                        if($remaining_advance > 0){
                                            $head_advance = $remaining_advance;
                                            $total_remaining_advance_amount =$total_remaining_advance_amount+$remaining_advance;
                                        }else{
                                            $head_advance = 0;
                                        }
                                        ?>
                                        <span class="pull-left currency-head"> Rs. <?=$head_advance?></span>
                                        <?php
                                    }else{
                                        ?>
                                        <span class="pull-left currency-head"> Rs. 0</span>

                                        <?php
                                    }
                                    ?>
                                </td>
                            </tr>
                            <?php
                            $i++;
                        }
                    }
 

                    if(isset($extraheads) && count($extraheads )>0){
                        foreach($extraheads as $ex_heads) {
                            /*total head wise received till date.*/
                            $ex_head_received=0;
                            $extra_head_receive = \app\models\FeeHeadWise::find()
                                ->where([
                                    'fk_branch_id'        => Yii::$app->common->getBranch(),
                                    'fk_stu_id'           => $student_data->stu_id,
                                    'fk_fee_head_id'      => $ex_heads['head_id'],
                                    'fk_chalan_id'        => $challan_id
                                ])
                                ->sum('payment_received');
                            if(!empty($extra_head_receive)){
                                $ex_head_received = $extra_head_receive;
                            }
                            if($ex_heads['head_amount'] - $ex_head_received > 0) {
                                ?>
                                <tr>
                                    <td style="background:none;"><?= $i ?>&nbsp;&nbsp;</td>
                                    <td style="background:none;">&nbsp;&nbsp;<?= $ex_heads['title'] ?></td>
                                    <td style="background:none;">&nbsp;&nbsp;
                                        <span class="pull-left currency-head"> Rs. <?= round($ex_heads['head_amount'] + $ex_heads['arrears'] - $extra_head_receive, 0) ?></span>
                                    </td>
                                    <td style="background:none;"></td>
                                    <td style="background:none;"></td>
                                </tr>
                                <?php
                            }
                            $sum_total = $sum_total+$ex_heads['head_amount']+$ex_heads['arrears']-$extra_head_receive;
                            $custom_ext_head_arr[] = $ex_heads['head_id'];
                            $i++;
                        }
                    }
                    /*if transport fere is applicable than */
                    if($transport_fare >0)
                    {
                        $net_total_amt = $sum_total+$transport_fare;
                    }
                    else
                    {
                        $net_total_amt = $sum_total;
                    }

                    if($hostel_fare > 0){
                        $net_total_amt = $net_total_amt+$hostel_fare;
                    }
                    /*total amount minus total discount.*/
                    $payable = $net_total_amt-$total_discount;
                    ?>
                   <!-- <tr style="background:none;">
                        <th style="background:none;" colspan="1"><span style="font-weight:normal;">Total</span></th>
                        <td style="background:none;" colspan="1"><span class="res_total" style="font-weight:normal;" id="total-amount">Rs.&nbsp;<?/*=round($sum_total,0);*/?></span> </td>
                    </tr>-->
                    <?php
                    if($transport_fare > 0) {
                        ?>
                        <tr style="width: 100%;">
                            <td>&nbsp;&nbsp;</td>
                            <th style="background:none;">&nbsp;&nbsp;<span style="font-weight:normal;">Transport</span></th>
                            <td style="background:none;">&nbsp;&nbsp;<span id="total-transport-fare"  data-totaltrnsprt="<?= ($transport_fare > 0) ? round($transport_fare, 0) : 0 ?>">
                            <span class="pull-left currency-head"> Rs. <?= $transport_fare ?></span>
                        	</span>
                            </td>
                            <td style="background:none;">&nbsp;&nbsp;
                                <?php
                                if(count($sundry_hosel_transport) > 0 ) {
                                    if($sundry_hosel_transport->transport_fare){
                                        $total_advance_amount = $total_advance_amount + $sundry_hosel_transport->transport_fare;
                                        ?>
                                        <span>Rs. <?=$sundry_hosel_transport->transport_fare?></span>
                                        <?php
                                    }
                                }
                                ?>
                            </td>
                            <td style="background:none;">&nbsp;&nbsp;
                                <?php
                                if(count($sundry_hosel_transport) > 0 ) {
                                    if($sundry_hosel_transport->transport_fare){
                                        ?>
                                        <span>Rs. <?=$sundry_hosel_transport->transport_fare-$transport_fare?></span>
                                        <?php
                                    }
                                }?>
                            </td>
                        </tr>
                        <?php
                    }
                    if($hostel_fare > 0) {
                        ?>
                        <tr style="width: 100%;">
                            <td>&nbsp;&nbsp;</td>
                            <th style="background:none;">&nbsp;&nbsp;<span style="font-weight:normal;">Hostel</span></th>
                            <td style="background:none;">&nbsp;&nbsp;<span id="total-transport-fare"
                                                               data-totaltrnsprt="<?= ($hostel_fare > 0) ? round($hostel_fare, 0) : 0 ?>">
                            <span class="pull-left currency-head"> Rs. <?= $hostel_fare ?></span>
                        	</span>
                            </td>
                            <td style="background:none;">&nbsp;&nbsp;
                                <?php
                                if(count($sundry_hosel_transport) > 0 ) {
                                    if($sundry_hosel_transport->hostel_fare){
                                        $total_advance_amount = $total_advance_amount + $sundry_hosel_transport->hostel_fare;
                                        ?>
                                        <span>Rs. <?=$sundry_hosel_transport->hostel_fare?></span>
                                        <?php
                                    }
                                }
                                ?>
                            </td>
                            <td style="background:none;">
                                <?php
                                if(count($sundry_hosel_transport) > 0 ) {
                                    if($sundry_hosel_transport->hostel_fare){
                                        ?>
                                        <span>Rs. <?=$sundry_hosel_transport->hostel_fare-$hostel_fare?></span>
                                        <?php
                                    }
                                }?>
                            </td>
                        </tr>
                        <?php
                    }
                    if((!empty($total_discount) || $total_discount != null) && $total_discount!=0 ) {
                        ?>
                        <tr style="width: 100%;">
                            <td></td>
                            <th style="background:none;"><span class="ds_amount" style="font-weight:normal;">Discount Amount</span>
                            </th>
                            <td style="background:none;"><span id="total-discount"
                                                               data-totaldiscount="<?= (!empty($total_discount) || $total_discount != null) ? round($total_discount, 0) : 0 ?>"><?= 'Rs. ' . round($total_discount, 0) ?></span>
                            </td>
                        </tr>
                        <?php
                    }
                    if((!empty($feeheadwise_received) || $feeheadwise_received != null) && $feeheadwise_received > 0 ) {
                        ?>
                        <tr style="width: 100%;">
                            <td></td>
                            <th style="background:none;"><span class="ds_amount" style="font-weight:normal;">Amount Paid</span>
                            </th>
                            <td style="background:none;"><span id="total-paid-amount"><?= 'Rs. ' . $feeheadwise_received ?></span>
                            </td>
                        </tr>
                        <?php
                    }

                    if($arrears>0) {
                        ?>
                        <tr style="width: 100%;">
                            <th style="background:none;"><span class="ds_amount" style="font-weight:normal;">Arrears&nbsp;&nbsp;</span>
                            </th>
                            <td style="background:none;"><span id="total-paid-amount">&nbsp;&nbsp;<?= 'Rs. ' . $arrears ?></span>
                            </td>
                        </tr>
                        <?php
                    }
                    ?>
                    <tr style="background:none; ">
                        <td style="background:none;border-top:1px solid #000;">&nbsp;&nbsp;</td>
                        <th style="background:none;border-top:1px solid #000;">&nbsp;&nbsp;Payable </th>
                        <td style="background:none;border-top:1px solid #000;" >&nbsp;&nbsp;
                            <span id="net-amount">
                                <?php
                               if($total_advance_amount >= $net_total_amt ) {
				echo 'Rs. 0';
				
  				}else{

                                if($feeheadwise_received > 0){
                                    echo 'Rs. '. round($net_total_amt-$feeheadwise_received-$total_discount,0);
                                }else{
                                    echo 'Rs. '. round($net_total_amt-$total_discount,0);
                                }
				}
                                ?>
                            </span>
                        </td>
			<td style="border-top:1px solid #000;background:none;"></td>
			<td style="border-top:1px solid #000;background:none;"></td>
                    </tr>
                    <?php
                    /*if(count($sundry_account) > 0 ) {
                        ?>
                        <!--<tr style="background:none;">
                            <td style="background:none;"></td>
                            <th style="background:none;"><span class="">&nbsp;&nbsp;Total Advance Payment</span></th>
                            <td style="background:none;">&nbsp;
                            <span id="net-amount">
                               <?=(count($total_advance_amount)> 0)?$total_advance_amount :0?>
                            </span>
                            </td>
                        </tr>-->
                        <?php
                    }*/
                    ?>
                    </tbody>
                </table> 
            </div>
            <div style="width: 100%; margin-top: 2px; font-size:12px;">
                <p><span>You are therefore requested to deposit the same amount upto <strong><?= date('dS F-Y',strtotime($due_date)) ?></strong></span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span style = "color:#000;margin-left:100px;-moz-text-decoration-line: overline;text-decoration-line: overline;">Ehsan Muhammad</span></p>
		<b>Note : In this dues reminder all the dues are upto the month of <?=date('F-Y')?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <span style = "margin-left:100px;-moz-text-decoration-line: overline;text-decoration-line: overline;">Accountant</span></b>
            </div>
        </div>
        <?php
    }
?>
