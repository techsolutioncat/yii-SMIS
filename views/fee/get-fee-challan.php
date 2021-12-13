<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use kartik\date\DatePicker;
use yii\bootstrap\Modal;
use yii\helpers\ArrayHelper;

$exteraHeadArrayMap = \app\models\FeeHeads::find()->select(['id','title'])->where(['fk_branch_id'=>Yii::$app->common->getBranch(),'extra_head'=>1])->asArray()->all();
$discount_type= ArrayHelper::map(\app\models\FeeDiscountTypes::find()->where(['fk_branch_id'=>Yii::$app->common->getBranch(),'is_active'=>1])->all(),'id','title');
if(count($sundry_account) > 0 ) {
    $sundary_list= ArrayHelper::map($sundry_account,'fk_head_id','total_advance_bal');
}
 
?>

<div id="calendar_div" class="fee-challan-result fee-ch-right shade">
    <?php
    $form = ActiveForm::begin(['id' => 'forum_post','action'=>Url::to(['fee/generate-challan-form'])]);
    ?>
    <div class="table-responsive" id="table-new-std-challan">
        <table class="table table-striped">
            <thead>
            <tr>
                <th class="fst_center">No.</th>
                <th>Heads</th>
                <th>Discount</th>
                <th>Amount</th>
                <th>Advance</th>
                <th>Remaining Advance</th>
                <th>Arrears</th>
            </tr>
            </thead>

            <tbody>
            <?php
            $i=1;
            $sum_total= 0;
            $new_head_amount= 0;
            $net_total_amt=0;
            $amount=0;
            $transport_amt=0;
            $total_discount = 0;
            $remaining_amount=0;
            $totalHeadAmt_without_currency =0;
            $total_advance_amount = 0;
            $total_remaining_advance_amount = 0;
            $head_advance = 0;
            $remaining_advance = 0;
            $store_array_particular=[];
            $fee_challan_record ='';
            $custom_ext_head_arr=[];
 
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
                        'fee_challan_record.fk_stu_id'=>$student_data->stu_id,
                        'fee_challan_record.fk_fee_plan_id'=>$fee_plan_Model->id,
                        'fh.extra_head'=>1,
                        'fee_challan_record.status'=>1
                    ])->asArray()->all();
            }
            foreach ($query as $items){
                $fee_challan_record ='';
                if($challan_id){
                    $fee_challan_record = \app\models\FeeChallanRecord::find()->where(['fk_stu_id'=>$student_data->stu_id,'fk_fee_plan_id'=>$fee_plan_Model->id,'fk_head_id'=>$items['head_id'],'status'=>1])->one();


                }
                /*total head wise received till date.*/
                $feeHeadWise_received = \app\models\FeeHeadWise::find() 
                    ->where([
                        'fee_head_wise.fk_branch_id'        => Yii::$app->common->getBranch(),
                        'fee_head_wise.fk_stu_id'           => $student_data->stu_id,
                        //'fee_head_wise.fk_fee_plan_type'  => $fee_plan_Model->id,
                        'fee_head_wise.fk_fee_head_id'      => $items['head_id'],
                        'fee_head_wise.fk_chalan_id'        => $challan_id
                    ])
                    ->sum('fee_head_wise.payment_received'); 

                /*student head discount*/
                $discountAmount = \app\models\FeeDiscounts::find()
                    ->where([
                        'fk_branch_id'        => Yii::$app->common->getBranch(),
                        'fk_stud_id'          => $student_data->stu_id,
                        'fk_fee_head_id'      => $items['head_id']
                    ])->one();


                if(!empty($fee_challan_record)){
                    //echo 'challan record'.$fee_challan_record->head_amount.'head_id'.$items['head_id'];
                    /*if head is availabel head amount will be shown from fee challan record.*/
                    $amount = $fee_challan_record->head_amount; 
                    $totalHeadAmt_without_currency  =  $amount;
                }else{
                    //echo 'totalamount:'.$amount.'head_id'.$items['head_id']."<br/>";
                    /**********************************************************************************/
                    /**                if Challan type is new means plan is metured                  **/
                    /**********************************************************************************/
                    if($challan_type =='new'){
                        /*if fee challan record amount is empoty that it will get head amount from actual heads.*/
                        if($items['one_time'] == 1){
                            //$amount = $items['amount']* $items['no_months'];
 			    $amount = 0; 
                            $totalHeadAmt_without_currency  =  $amount;
                        }else{
                            if($total_multiplyer > 0){

                                if($items['no_months']==1){
                                    if($items['promotion_head']==1){
                                        $stu_reg_log = \app\models\StuRegLogAssociation::find()->where(['fk_stu_id'=>$student_data->stu_id,'fk_branch_id'=>Yii::$app->common->getBranch()])->count();
                                        if($stu_reg_log > 0){
				           if($feeHeadWise_received>0){
                                            	$amount = 0;
					    }else{
					        $amount  = $amount = $items['amount']* $items['no_months'];
					    } 
 
                                        }else{
                                            $amount = 0;
                                        }
                                    }else{
                                        //$amount = $items['amount']*$items['no_months'];
					if($feeHeadWise_received>0){
                                            	$amount = 0;
					    }else{
					        $amount  = $amount = $items['amount']* $items['no_months'];
					    }

                                    }
                                }else{
                                    $amount = $items['amount']* ($items['no_months']*$total_multiplyer)/$fee_plan_Model->no_of_installments;
                                }
                            }else{
                                $amount = $items['amount']*$items['no_months']/$fee_plan_Model->no_of_installments;
                            }
                            $totalHeadAmt_without_currency  =  $amount;

                        }
                    }
                    else{
                        if($items['one_time'] == 1){
                            //$amount = $items['amount']* $items['no_months'];
                            $amount =0;
                            $totalHeadAmt_without_currency  =  $amount;
                        }else{
                            if($total_multiplyer > 0){
                                $amount = $items['amount']* ($items['no_months']*$total_multiplyer)/$fee_plan_Model->no_of_installments;
                            }else{
                                if($items['no_months']==1){
                                    if($items['promotion_head']==1){
                                        $stu_reg_log = \app\models\StuRegLogAssociation::find()->where(['fk_stu_id'=>$student_data->stu_id,'fk_branch_id'=>Yii::$app->common->getBranch()])->count();
                                       if($stu_reg_log > 0){
                                           //$amount = $items['amount']*$items['no_months'];
$amount = 0;
                                       }else{
                                           $amount = 0;
                                       }
                                    }else{
                                        //$amount = $items['amount']*$items['no_months'];
					$amount = 0;
                                    }
                                }else{
                                    $amount = $items['amount']*$items['no_months']/$fee_plan_Model->no_of_installments;
                                }
                            }
                            $totalHeadAmt_without_currency  =  $amount;

                        }
                        //echo "old ".$items['title']."<br/>";
                        //$amount = $items['amount']*$items['no_months']/$fee_plan_Model->no_of_installments;
                        //$totalHeadAmt_without_currency  =  $amount;
                    }
                }


                /*if total headwise receive is not empty it will diduct tht total recieved amount from total along with head discount*/
                if($feeHeadWise_received !=''){
                    //$totalHeadAmt_without_currency =   $item['fee_head_amount']-$feeHeadWise_received - $item['head_discount'];
                    //$totalHeadAmt_without_currency =   round($amount,0) -$feeHeadWise_received - $item['head_discount'];
                    $totalHeadAmt_without_currency =   round($amount,0) - $feeHeadWise_received;

                    if($challan_type =='new'){

                        if( $totalHeadAmt_without_currency > 0){
                            if(count($discountAmount) > 0 ){
                                $totalHeadAmt_without_currency =   $totalHeadAmt_without_currency - $discountAmount->amount;
                            }
                        }

                    }

                    if(!empty($fee_challan_record->arrears)){
                        $totalHeadAmt_without_currency = $totalHeadAmt_without_currency + $fee_challan_record->arrears;
                    }


                }
                else{
                    if($challan_type =='new') {

                        if (count($discountAmount) > 0 && $items['no_months'] != 1) {
                            $totalHeadAmt_without_currency = (round($amount, 0) - $discountAmount->amount);
                            $total_discount = $total_discount + $discountAmount->amount;

                        }
                    }else {
                        if (isset($discountAmount)) {
			    if(round($amount, 0)>0){
                              $total_discount = $total_discount + $discountAmount->amount;
			    } 
                        }
                    }
                    if  (!empty($fee_challan_record->arrears)){
                        $totalHeadAmt_without_currency = $totalHeadAmt_without_currency + $fee_challan_record->arrears;
                    }
                }

                //$remaining_amount = $remaining_amount + $totalHeadAmt_without_currency;
                /**********************************************************************************/
                /**                if Challan type is new means plan is metured                  **/
                /**                the following code will run if backdated or fee is metured    **/
                /**********************************************************************************/
                if($challan_type =='new' && $is_month_metured ==1){
                     if($items['one_time'] == 1){
                         $new_head_amount = 0;
                     }else{
                         //if $total_multiplyer is greater than 0  means months due amount is more than the current plan
                         if($total_multiplyer > 0){
                             if($items['no_months']==1){
                                 if($items['promotion_head']==1){
                                     $stu_reg_log = \app\models\StuRegLogAssociation::find()->where(['fk_stu_id'=>$student_data->stu_id,'fk_branch_id'=>Yii::$app->common->getBranch()])->count();
                                     if($stu_reg_log > 0){
                                         //$amount = $items['amount']*$items['no_months'];
					 $amount = 0;
                                     }else{
                                         $amount = 0;
                                     }
                                 }else{
                                     //$amount = $items['amount']*$items['no_months'];
					$amount = 0;
                                 }
                             }else{
                                 $amount = $items['amount']* ($items['no_months']*$total_multiplyer)/$fee_plan_Model->no_of_installments;
                             }
                             $new_head_amount = $amount;
                         }else{
                             if($items['no_months']==1){
                                 if($items['promotion_head']==1){
                                     $stu_reg_log = \app\models\StuRegLogAssociation::find()->where(['fk_stu_id'=>$student_data->stu_id,'fk_branch_id'=>Yii::$app->common->getBranch()])->count();
                                     if($stu_reg_log > 0){
                                         //$amount = $items['amount']*$items['no_months'];
$amount =0;
                                     }else{
                                         $amount = 0;
                                     }
                                 }else{
                                     //$amount = $items['amount']*$items['no_months'];
					$amount = 0;
                                 }
                             }else{
                                 $amount = $items['amount']*$items['no_months']/$fee_plan_Model->no_of_installments;
                             }
                             $new_head_amount = $amount;

                         }
                     }

                     $totalHeadAmt_without_currency =  $totalHeadAmt_without_currency+round($new_head_amount,0);


                }

                $sum_total= $sum_total+$totalHeadAmt_without_currency;

                $store_array_particular[]= $items['head_id'];

                if($totalHeadAmt_without_currency > 0) {
                    ?>
                    <tr>
                        <td class="fst_center"><?= $i ?></td>
                        <td><?= $items['title'] ?></td>
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
                            <span class="pull-left currency-head"> Rs. </span>
                            <div class="form-group field-transaction-head-amount pull-right width_88">
                                <input type="number" id="transaction-head-amount_<?= $i ?>" class="form-control"
                                       name="transaction_head_amount[<?= $items['head_id'] ?>]"
                                       value="<?= round($totalHeadAmt_without_currency, 0) ?>" aria-invalid="false"
                                       placeholder="<?= round($totalHeadAmt_without_currency, 0) ?>" min="0"  onkeypress="return isNumberKey(event)">
                                <div class="help-block"></div>
                            </div>
                            <?php
                            /*if there's any head discount.*/
                            if (count($discountAmount) > 0) {
                                ?>
                                <input type="hidden" value="<?= $discountAmount->amount; ?>"
                                       name="headDiscount[<?= $items['head_id'] ?>]"/>
                                <?php
                            }
                            ?>

                        </td>
                        <td>
                            <?php
                            if(isset($sundary_list[$items['head_id']]) && $sundary_list[$items['head_id']] > 0){
                                $total_advance_amount = $total_advance_amount + $sundary_list[$items['head_id']];
                                ?>
                                <span class="pull-left currency-head"> Rs. <?=$sundary_list[$items['head_id']]?></span>
                                <?php
                            }else{
                                ?>
                                <span class="pull-left currency-head"> Rs. 0</span>
                                <?php
                            }
                            ?>
                        </td>
                        <td>
                            <?php
                            if(isset($sundary_list[$items['head_id']]) && $sundary_list[$items['head_id']] > 0){
                                $remaining_advance = $sundary_list[$items['head_id']] - round($totalHeadAmt_without_currency, 0);
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
                        <td>
                            <span class="pull-left currency-head"> Rs. </span>
                            <div class="form-group field-transaction-head-amount pull-right width_88">
                                <input type="text" id="transaction-head-arrears_<?= $i ?>" class="form-control"
                                       name="transaction_head_arrears_amount[<?= $items['head_id'] ?>]" value=""
                                       aria-invalid="false" placeholder="" readonly>
                                <div class="help-block"></div>
                            </div>
                        </td>
                    </tr>
                    <?php
                    $i++;
                }
                else{
                    ?>
                    <input type="number" id="transaction-head-amount_<?= $i ?>" class="form-control"
                           name="transaction_head_amount[<?= $items['head_id'] ?>]"
                           value="0" aria-invalid="false"
                           placeholder="0" min="0"  onkeypress="return isNumberKey(event)" style="visibility: hidden;position: absolute;">
                    <?php
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
                            <td class="fst_center"><?= $i ?></td>
                            <td><?= $ex_heads['title'] ?></td>
                            <td>
                                <?php

                                if ($items['discount_head_status'] == 1) {
                                    echo Html::a('<i class="fa fa-money fa-2" aria-hidden="true"></i>', 'javascript:void(0);', ['data-head_id' => $ex_heads['head_id'], 'data-head_name' => $ex_heads['title'], 'data-head_amount' => $ex_heads['head_amount'] - $extra_head_receive, 'data-toggle' => "modal", 'data-target' => "#discount-details", 'id' => 'discount-modal']);
                                } else {
                                    echo 'N/A';
                                }
                                ?>
                                <div id="show_head_<?= $ex_heads['head_id'] ?>" class="show-head">
                                    <input type="hidden" name="head_hidden_discount_amount[<?= $items['head_id'] ?>]" id="head_hidden_discount_amount" value="0"/>
                                    <input type="hidden" name="head_hidden_discount_type[<?=$items['head_id']?>]" id="head_hidden_discount_type" value="0"/>
                                    <span></span>
                                </div>
                            </td>
                            <td>
                                <span class="pull-left currency-head"> Rs. </span>
                                <div class="form-group field-transaction-head-amount pull-right width_88">
                                    <input type="number" id="transaction-head-amount_<?= $i ?>" class="form-control"
                                           name="transaction_head_amount[<?= $ex_heads['head_id'] ?>]"
                                           value="<?= round($ex_heads['head_amount'] + $ex_heads['arrears'] - $extra_head_receive, 0) ?>"
                                           aria-invalid="false"
                                           placeholder="<?= round($ex_heads['head_amount'] + $ex_heads['arrears'] - $extra_head_receive, 0) ?>"
                                           min="0"
                                           onkeypress="return isNumberKey(event)">
                                    <div class="help-block"></div>
                                </div>
                            </td>

                            <td>
                                <span class="pull-left currency-head"> Rs. </span>
                                <div class="form-group field-transaction-head-amount pull-right width_88">
                                    <input type="text" id="transaction-head-arrears_<?= $i ?>" class="form-control"
                                           name="transaction_head_arrears_amount[<?= $ex_heads['head_id'] ?>]"
                                           value=""
                                           aria-invalid="false" placeholder="" readonly>
                                    <div class="help-block"></div>
                                </div>
                            </td>

                        </tr>
                        <?php
                    }
                    $sum_total = $sum_total+$ex_heads['head_amount']+$ex_heads['arrears']-$extra_head_receive;
                    $custom_ext_head_arr[] = $ex_heads['head_id'];
                    $i++;
                }
            }
            $net_total_amt = $sum_total;

            /**********************************************************************************/
            /**     23  if Challan type  is monthly means month is metured not plan          **/
            /**********************************************************************************/
            /*transprt received or not*/
            if(count($transport_hostel_received)>0){
                if (!empty($transport_hostel_received['transport_fare']) || $transport_hostel_received['transport_fare'] != null){
                    $transport_received = $transport_hostel_received['transport_fare'];
                }else{
                    $transport_received = 0;
                }

                /*hostel received or not*/
                if ($transport_hostel_received['hostel_fee']) {
                    $hostel_received = $transport_hostel_received['hostel_fee'];
                }else{
                    $hostel_received =0;
                }
            }
            else{
                $transport_received = 0;
                $hostel_received =0;
            }



            if($fee_challan_record){
                $old_hostel_fare = $fee_challan_record->hostel_fare - $hostel_received;
                $old_transport_fare = $fee_challan_record->fare_amount - $transport_received;
            }
            else{
                $old_hostel_fare = 0;
                $old_transport_fare = 0;
            }


            if($is_month_metured == 1){ 
                /*if transport fere is applicable than */
                if(!empty($transport_fare) || $transport_fare != null) {

                    if($transport_fare >0){
                        // echo 'in transport'.$transport_fare.'+'.$old_transport_fare."<br/>";
                        $transport_fare = $transport_fare+$old_transport_fare;
                    }
                    $net_total_amt = $sum_total+$transport_fare;
                }

                /*if hostel fare is applicable than*/
                if(!empty($hostel_fare) || $hostel_fare != null){
                    if($hostel_fare >0){
                        $hostel_fare = $hostel_fare+$old_hostel_fare;
                    }
                    $net_total_amt = $net_total_amt+$hostel_fare;
                }
            }
            else{
 

                /*if transport fere is applicable than */
                $registration_year = date('Y',strtotime($student_data->registration_date));
                $current_year = date('Y');
                //if($old_transport_fare == 0 && $registration_year >= $current_year) {
                if($old_transport_fare == 0 && $student_data->transport_updated ==0) {
                    $transport_fare = 0;
                    $net_total_amt = $sum_total+$transport_fare;
                }else{
                    $net_total_amt = $sum_total+$transport_fare;
                }


                /*if hostel fare is applicable than*/
                if($old_hostel_fare== 0 && $student_data->hostel_updated ==0){
                    $hostel_fare = 0;
                    $net_total_amt = $net_total_amt+$hostel_fare;
                }else{
                    $net_total_amt = $net_total_amt+$hostel_fare;
                }                
                //$net_total_amt = $sum_total+$old_transport_fare;
                //$net_total_amt = $net_total_amt+$old_hostel_fare;
            }

            /**********************************************************************************/
            /**     23  if Challan type  is monthly means month is metured not plan          **/
            /**********************************************************************************/


            /*total amount minus total discount.*/
            $payable = $net_total_amt;
            ?>
            <tr>
                <th colspan="2"></th>
                <th colspan="1"><span class="res_total">Arrears</span></th>
                <td colspan="1">
                    <div class="form-group field-transaction-arrears-amount has-success">
                        <input type="text" id="total-arrears-amount"  data-total="<?=round($sum_total,0)?>" class="form-control" name="FeeTransactionDetails[total_arrears_amount]" value="" readonly="readonly" aria-invalid="false">
                        <div class="help-block"></div>
                    </div>
                </td><td></td><td></td><td></td>
            </tr>
            <!--<tr>
                    <th colspan="2"></th>
                    <th colspan="1"><span class="res_total">Total</span></th>
                    <td colspan="1"><span class="res_total" id="total-amount" data-total="<?/*=round($sum_total,0)*/?>"><?/*=round($sum_total,0);*/?></span> </td>
                </tr>-->
            <!--<tr style="<?/*= (!empty($transport_fare) || $transport_fare != null)?'visibility:visible;':'display:none;' */?> width: 100%;">
                <th colspan="2"><span class="pull-right">Transport Fare</span></th>
                <td ><span id="total-transport-fare" data-totaltrnsprt="<?/*=(!empty($transport_fare) || $transport_fare != null)?round($transport_fare,0):0 */?>"><?/*='Rs. '.round($transport_fare,0)*/?></span>
                </td>
            </tr>-->
            <tr style="<?= ((!empty($transport_fare) || $transport_fare != null) && $transport_fare >0 )?'visibility:visible;':'display:none;' ?> width: 100%;">
                <th colspan="2"></th>
                <th><span class="trans_fare">Transport Fare</span></th>
                <td><!--<span id="total-transport-fare" data-totaltrnsprt="<?/*=(!empty($transport_fare) || $transport_fare != null)?round($transport_fare,0):0 */?>">
                                </span>-->
                    <span class="pull-left currency-head"> Rs. </span>
                    <div class="form-group field-transaction-head-amount pull-right width_88">
                        <input type="number" id="input_total_transport_fare" onkeyup="transportAdjust(event,this);" data-totaltrnsprt="<?=(!empty($transport_fare) || $transport_fare != null)?round($transport_fare,0):0 ?>" class="form-control" name="StudentDisount[input_total_transport_fare]" value="<?=$transport_fare?>"  style="width: 100px;">
                        <div class="help-block"></div>
                    </div>

                </td>
                <td>
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
                <td>
                    <?php
                    if(count($sundry_hosel_transport) > 0 ) {
                        if($sundry_hosel_transport->transport_fare){
                        ?>
                            <span>Rs. <?=$sundry_hosel_transport->transport_fare-$transport_fare?></span>
                        <?php
                        }
                    }?>
                </td>
                <td></td>
            </tr>

            <tr style="<?= ((!empty($hostel_fare) || $hostel_fare != null) && $hostel_fare >0 )?'visibility:visible;':'display:none;' ?> width: 100%;">
                <th colspan="2"></th>
                <th><span class="trans_fare">Hostel Fare</span></th>
                <td><span id="total-transport-fare" data-totaltrnsprt="<?=(!empty($hostel_fare) || $hostel_fare != null)?round($hostel_fare,0):0 ?>">
                                <span class="pull-left currency-head"> Rs. </span>
                                <div class="form-group field-transaction-head-amount pull-right width_88">
                                     <input type="text" id="input_total_hostel_fare" class="form-control" name="StudentDisount[input_total_hostel_fare]" value="<?=$hostel_fare?>"  onkeyup="hostelAdjust(event,this);" data-totalhostl="<?=(!empty($hostel_fare) || $hostel_fare != null)?round($hostel_fare,0):0 ?>"aria-invalid="false" placeholder="<?=$hostel_fare?>" >
                                    <div class="help-block"></div>
                                </div>
                </td>
                <td>
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
                <td>
                    <?php
                    if(count($sundry_hosel_transport) > 0 ) {
                        if($sundry_hosel_transport->hostel_fare){
                            ?>
                            <span>Rs. <?=$sundry_hosel_transport->hostel_fare-$hostel_fare?></span>
                            <?php
                        }
                    }?>
                </td>
                <td></td>
            </tr>
            <tr id="discount_row" style="<?= (!empty($total_discount) || $total_discount != null)?'visibility:visible;':'display:none;' ?> width: 100%;">
                <th colspan="2"></th>
                <th><span class="ds_amount">Discount Amount</span></th>
                <td><span class="total-discount" id="total-discount" data-totaldiscount="<?=(!empty($total_discount) || $total_discount != null)? round($total_discount,0):0 ?>"><?='RS.'.round($total_discount,0)?></span>
                </td><td></td>
            </tr>
            <tr id="amount-payable">
                <th class="green" colspan="2"></th>
                <th class="green"><span class="payable">Amount Payable</span></th>
                <td class="dblue"><span id="net-amount" data-net="<?=round($net_total_amt,0)?>"><?php
                        echo 'Rs. '. round($net_total_amt,0); ?>
                            </span>
                    <input type="hidden" id="input_total_discount" class="form-control" name="StudentDisount[input_total_discount]" value="<?=$total_discount?>" >
                    <input type="hidden" id="input_total_amount_payable" class="form-control" name="StudentDisount[input_total_amount_payable]" value="<?=round($payable,0)?>">
                </td>
                <td class="dblue"></td><td class="dblue"></td><td class="dblue"></td>
            </tr>
            <?php
            if(count($sundry_account) > 0 ) {
                ?>
            <tr id="advance-fee">
                <th class="" colspan="2"></th>
                <th class=""><span class="">Total Advance Payment</span></th>
                <td class="">
                    <span class="pull-left currency-head"> Rs. </span>
                    <div class="form-group field-transaction-advance-payment pull-right width_88">
                        <input type="number" id="input_total_advance_fee" data-totaltrnsprt="" class="form-control" name="StudentAdvance[input_total_advance_payment]"  value ="<?=(count($total_advance_amount)> 0)?$total_advance_amount :0?>" style="width: 100px;" readonly>
                        <div class="help-block"></div>
                    </div>
                </td><td></td><td></td><td></td>
            </tr>

                <!--<tr id="ramaining-advance-fee" >
                    <th class="" colspan="2"></th>
                    <th class=""><span class="">Remaining Advance</span></th>
                    <td class="">
                        <span class="pull-left currency-head"> Rs. </span>
                        <div class="form-group field-transaction-remaining-payment pull-right width_88">
                            <input type="number" id="input_total_remaining_fare" data-totaltrnsprt=""
                                   class="form-control" name="StudentAdvance[input_total_advance_remaining_payment]"
                                   value="<?/*=(count($total_remaining_advance_amount)> 0)?$net_total_amt-$total_remaining_advance_amount-$transport_fare-$hostel_fare: 0 */?>" style="width: 100px;" readonly/>
                            <div class="help-block"></div>
                        </div>
                    </td><td></td><td></td><td></td>
                </tr>-->
                <?php
            }else {
                ?>
                <!--<tr id="ramaining-advance-fee" style="display:none">
                    <th class="" colspan="2"></th>
                    <th class=""><span class="">Remaining Advance</span></th>
                    <td class="">
                        <span class="pull-left currency-head"> Rs. </span>
                        <div class="form-group field-transaction-remaining-payment pull-right width_88">
                            <input type="number" id="input_total_remaining_fare" data-totaltrnsprt=""
                                   class="form-control" name="StudentAdvance[input_total_advance_remaining_payment]"
                                   value="<?/*=(count($total_advance_amount)> 0)?$total_advance_amount :0*/?>" style="width: 100px;" readonly/>
                            <div class="help-block"></div>
                        </div>
                    </td>
                    <td></td><td></td><td></td>
                </tr>-->
                <?php
            }
                ?>

            <tr class="payment-tr">
                <td colspan="2"></td>
                <td>
                    Challan Amount
                </td>
                <td>
                    <?= $form->field($feeTranscModel, 'transaction_amount')->textInput(['value'=>round($payable,0),'id'=>'transaction-amount', 'readonly'=>'readonly']); ?>
                    <!-- <?/*= $form->field($feeTranscModel, 'transaction_date')->widget(DatePicker::classname(), [
                        'options' => ['value' => ($feeTranscModel->transaction_date)?date('Y-m-d',strtotime($feeTranscModel->transaction_date)):date('Y-m-d')],
                        'type' => DatePicker::TYPE_INPUT,
                        'pluginOptions' => [
                            'autoclose'=>true,
                            'format' => 'yyyy-mm-dd',
                            'todayHighlight' => true,
                        ]
                    ]);
                    */?>-->
                </td><td></td><td></td><td></td>

            </tr>
            <tr>
                <td colspan="2">
                    <div class="form-group field-transaction-due-date has-success">
                        <label class="control-label" for="transaction-challan-due-date">Due Date:</label>
                        <input class="form-control" type="text" name="FeeTransactionDetails[challan-due-date]" value="<?=date('d-m-Y',strtotime($due_date))?>" readonly />
                    </div>
                </td>

                <td colspan="5">
                    <?= Html::a('<i class="glyphicon glyphicon-plus"></i>','javascript:void(0);', ['title'=>'Add Head','class' => 'btn green-btn pull-left','style'=>'margin-top:10px;','disabled'=>($net_total_amt-$total_discount <= 0)?true:false,'id'=>'add-extra-fee-head']) ?> <?= Html::submitButton('Generate Fee Challan', ['value'=>'submit-challan','class' => 'btn btn-pay green-btn pull-right','style'=>'margin-top:10px;','disabled'=>($net_total_amt-$total_discount <= 0)?true:false]) ?>
                </td>

            </tr>
            </tbody>
        </table>
        <input type="hidden" value="<?= $student_data->stu_id; ?>" name="StudentInfo[id]"/>
        <input type="hidden" value="<?= $fee_plan_Model->id ?>" name="StudentInfo[plan_type_id]"/>
        <input type="hidden" value="<?= $challan_type?>" name="StudentInfo[challan_type]"/>
        <input type="hidden" value="<?= $is_month_metured?>" name="StudentInfo[is_month_metured]"/>
        <input type="hidden" value="<?= ($fee_generation_date)?$fee_generation_date:0?>" name="StudentInfo[fee_generation_date]"/>
    </div>
    <?php ActiveForm::end(); ?>
</div>
<?php
Modal::begin([
    'header'=>'<h4>ADD Head</h4>',
    'id'=>'modal-extera-head',
    'options'=>[
        'data-keyboard'=>false,
        'data-backdrop'=>"static"
    ],
    'size'=>'modal-md',
    'footer' =>'<button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>'.Html::a('Add Head','javascript:void(0);', ['class' => 'btn green-btn pull-right','id'=>'save-extra-fee-head']),

]);
?>
<div class="row">
    <div class="col-md-6 ex_head_division">
        <?php
        /*echo Html::dropDownList('s_id', null,$exteraHeadArrayMap,['class'=>'form-control','prompt'=>'Select Head...','id'=>'ex_head'])*/

        ?>
        <select id="ex_head" class="form-control" name="s_id">
            <option value="">Select Head...</option>
            <?php

            foreach ($exteraHeadArrayMap as $exhead){
                $check='';
                if(count($custom_ext_head_arr)>0){
                    if(in_array($exhead['id'],$custom_ext_head_arr,true)){
                        $check ='disabled="disabled"';
                    }else{
                        $check='';
                    }
                }
                echo '<option value="'.$exhead['id'].'" '.$check.'>'.$exhead['title'].'</option>';
            }
            ?>
        </select>
        <div class="help-block"></div>
    </div>
    <div class="col-md-6 ex_head_amount">
        <?=Html::input('number','extra_head_amount',null,['class'=>'form-control','placeholder'=>'Head Amount','id'=>'ex_head_amount'])?>
        <div class="help-block"></div>
    </div>
</div>
<?php
Modal::end();

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
