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
                            $total_discount = $total_discount + $discountAmount->amount;
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

                //$store_array_particular[]= $items['head_id'];

                if($totalHeadAmt_without_currency > 0) {
                    $store_array_particular []=[
                'head_id'=>$items['head_id'],
                                'amount'=>round($totalHeadAmt_without_currency, 0),
                'fee_plan_id'=>$fee_plan_Model->id,
                'stu_id'=>$student_data->stu_id,
                'discount_amount'=>(count($discountAmount) > 0)?$discountAmount->amount:0 
                ];  
                        
                    $i++;
                }
                else{
           $store_array_particular []=[
                'head_id'=>$items['head_id'],
                                'amount'=>0,
                'fee_plan_id'=>$fee_plan_Model->id,
                'stu_id'=>$student_data->stu_id,
                'discount_amount'=>(count($discountAmount) > 0)?$discountAmount->amount:0 
                ];  
                     
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
                                
                                $store_array_particular []=[
                        'head_id'=>$items['head_id'],
                                                'amount'=>round($ex_heads['head_amount'] + $ex_heads['arrears'] - $extra_head_receive, 0),
                        'fee_plan_id'=>$fee_plan_Model->id,
                        'stu_id'=>$student_data->stu_id
                ];
 
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
                if($old_transport_fare == 0 && $registration_year < $current_year) {
                    $transport_fare = 0;
                    $net_total_amt = $sum_total+$transport_fare;
                }else{
                    $net_total_amt = $sum_total+$transport_fare;
                }


                /*if hostel fare is applicable than*/
                if($old_hostel_fare== 0 && $registration_year < $current_year){
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
           // echo 'payable  :'.$payable = $net_total_amt;
            
        if((!empty($transport_fare) || $transport_fare != null) && $transport_fare >0 ){
         //echo 'transport'.round($transport_fare,0);
         } 
 
                    if(count($sundry_hosel_transport) > 0 ) {
                        if($sundry_hosel_transport->transport_fare){
                            $total_advance_amount = $total_advance_amount + $sundry_hosel_transport->transport_fare;
                            ?>
                            <span>Rs. <?=$sundry_hosel_transport->transport_fare?></span>
                            <?php
                        }
                    } 
                    /*remaining transport*/
                    if(count($sundry_hosel_transport) > 0 ) {
                        if($sundry_hosel_transport->transport_fare){
                        ?>
                            <span>Rs. <?=$sundry_hosel_transport->transport_fare-$transport_fare?></span>
                        <?php
                        }
                    } 
             if((!empty($hostel_fare) || $hostel_fare != null) && $hostel_fare >0 ){
?>
        <input type="text" id="input_total_hostel_fare" class="form-control" name="StudentDisount[input_total_hostel_fare]" value="<?=$hostel_fare?>"  onkeyup="hostelAdjust(event,this);" data-totalhostl="<?=(!empty($hostel_fare) || $hostel_fare != null)?round($hostel_fare,0):0 ?>"aria-invalid="false" placeholder="<?=$hostel_fare?>" >
<?php
        }
/*hostel sundry remaining*/
if(count($sundry_hosel_transport) > 0 ) {
                        if($sundry_hosel_transport->hostel_fare){
                            $total_advance_amount = $total_advance_amount + $sundry_hosel_transport->hostel_fare;
                            ?>
                            <span>Rs. <?=$sundry_hosel_transport->hostel_fare?></span>
                            <?php
                        }
                    }
        if(!empty($total_discount) || $total_discount != null){
?>
<?='RS.'.round($total_discount,0)?>
<?php

}
/*total amount payable*/
//echo "payable".round($net_total_amt,0);
  
 if(count($sundry_account) > 0 ) {

//Total Advance Payment
 //$total_advance_amount 
      
}       
  

print_r($store_array_particular);exit;
?>        
 <?php /*date('d-m-Y',strtotime($due_date))*/?>   
      
 
          
        <!--<input type="hidden" value="<?= $student_data->stu_id; ?>" name="StudentInfo[id]"/>
        <input type="hidden" value="<?= $fee_plan_Model->id ?>" name="StudentInfo[plan_type_id]"/>
        <input type="hidden" value="<?= $challan_type?>" name="StudentInfo[challan_type]"/>
        <input type="hidden" value="<?= $is_month_metured?>" name="StudentInfo[is_month_metured]"/>
        <input type="hidden" value="<?= ($fee_generation_date)?$fee_generation_date:0?>" name="StudentInfo[fee_generation_date]"/>
 
 
 
