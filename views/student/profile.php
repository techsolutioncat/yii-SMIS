<?php


use yii\helpers\Url;
use app\models\SmsLog;
use app\widgets\Alert;
use yii\helpers\Html;
use app\models\Profession;

/* @var $this yii\web\View */
/* @var $searchModel app\models\StudentInfoSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Student Profile';
//$this->params['breadcrumbs'][] = $this->title;
if(Yii::$app->request->get('ch_id')) {
    $this->registerJs("$('#generate-challan-view')[0].click();",\Yii\web\View::POS_READY);
}
?>
    <div class="student-profile-index content_col">
        <h1 class="p_title">Student Details</h1>
        <div class="student-profile mid_center">
            <div class="profile_shade">
                <?php
                if(Yii::$app->request->get('ch_id')) {
                    ?>
                    <?= Html::a('generate fee challan.',['student/generate-student-fee-challan', 'challan_id' => Yii::$app->request->get('ch_id'),'stu_id' => Yii::$app->request->get('id')],['style'=>'visibility:hidden;','id'=>'generate-challan-view'])?>
                    <?php
                }
                ?>
                <?= Alert::widget()?>
                <div class="row">
                    <div class="col-sm-2 student-info">
                        <div class="student-avator shade">
                            <?php
                            $parentInfo = $studentInfo->studentParentsInfos;
                            $file_name = $studentInfo->user->Image;
                            $file_path = Yii::getAlias('@webroot').'/uploads/';

                            if(!empty($file_name) && file_exists($file_path.$file_name)) {
                                $web_path = Yii::getAlias('@web').'/uploads/';
                                $imageName = $studentInfo->user->Image;

                            }else{
                                $web_path = Yii::getAlias('@web').'/img/';
                                if($studentInfo->gender_type == 1){
                                    $imageName = 'male.jpg';
                                }else{
                                    $imageName = 'female.png';

                                }
                            }
                            if($studentInfo->gender_type == 1){
                                $s_d= 'S/O';
                                $gender_name = 'Male';
                            }else{
                                $s_d= 'D/O';
                                $gender_name = 'Female';
                                $imageName = 'female.png';
                            }
                            ?>
                            <img class="img-responsive" src="<?= $web_path.$imageName?>" alt="<?=Yii::$app->common->getName($studentInfo->user->id);?>">
                            <div class="st_caption">
                                <h3><?=Yii::$app->common->getName($studentInfo->user->id);?></h3>
                                <p><?=$s_d?> <?=($studentInfo->studentParentsInfos)?Yii::$app->common->getParentName($studentInfo->stu_id):''?></p>
                            </div>
                        </div>
                        <div class="student-timeline">
                            <?php
                            $total_items= count($total_time_line)-1;
                            $counter = $total_items;
                            $group_sect='';
                            ?>
                            <h4>Timeline</h4>
                            <?php
                            foreach ($total_time_line as $key=>$time_line_item){
                                $items= $total_time_line[$counter];
                                if($total_items==$counter){
                                    $end_date= $start_date;
                                }
                                else if($counter == 0){
                                    $end_date = date('Y-m-d',strtotime($studentInfo->registration_date));
                                }else{
                                    $end_promo_date = $total_time_line[$counter-1];
                                    $end_date = date('Y-m-d',strtotime($end_promo_date['promoted_date']));
                                }
                                $s_date = date('Y-m-d',strtotime($items['promoted_date']));
                                $e_date = $end_date;
                                ?>

                                <a id="get-timeline" class="<?=($total_items==$counter)?'active':''?>" href="javascript:void(0);" data-sdate="<?=$s_date?>" data-edate="<?=$e_date?>" data-std="<?=$studentInfo->stu_id?>" data-class_id="<?=$items['old_class']?>" data-group_id="<?=$items['old_group']?>" data-section_id="<?=$items['old_section']?>" data-url="<?=Url::to('get-profile-stats')?>">
                                    <div class="st_class">
                                        <p><?=str_replace(' ','<br/>',$items['class_name'])?></p>
                                        <span><?=date('Y',strtotime($items['promoted_date']))?></span>
                                        <!--<span><?php
                                        /*if($items['group_name'] !=''){
                                            $group_sect = $items['group_name']." | ";
                                        }
                                        if($items['section_name'] !=''){
                                            $group_sect = $items['section_name'];
                                        }

                                        echo $group_sect;*/
                                        ?> </span>-->
                                    </div>
                                </a>
                                <?php
                                $end_date = $items['promoted_date'];
                                $counter--;
                            }

                            ?>

                        </div>
                    </div>
                    <div class="col-sm-10 student-wrap">
                        <div class="st_widget shade">
                            <div class="tab-content">
                                <div id="basic-information" class="tab-pane fade in active">
                                    <div class="col-sm-10">
                                        <div class="row">
                                            <div class="info_st">
                                                <ul>
                                                    <li class="col-sm-4"><span>Reg. Date</span><?= date('d, M Y',strtotime($studentInfo->registration_date))?></li>
                                                    <li class="col-sm-4"><span><?=Yii::t('app','Class')?></span><?=$studentInfo->class->title?></li>
                                                    <li class="col-sm-4"><span><?=Yii::t('app','Gender')?></span><?=$gender_name?></li>
                                                </ul>
                                                <ul>
                                                    <li class="col-sm-4"><span><?=Yii::t('app','Withdrawl No')?>.</span><?=($studentInfo->withdrawl_no)?$studentInfo->withdrawl_no:'N/A'?></li>
                                                    <li class="col-sm-4"><span><?=Yii::t('app','Group')?></span><?=($studentInfo->group_id)?$studentInfo->group->title:'N/A'?></li>
                                                    <li class="col-sm-4"><span><?=Yii::t('app','Date of Birth')?></span><?= date('d, M Y',strtotime($studentInfo->dob))?></li>
                                                </ul>
                                                <ul>
                                                    <li class="col-sm-4"><span><?=Yii::t('app','CNIC')?></span><?=($studentInfo->cnic)?$studentInfo->cnic:'N/A'?></li>
                                                    <li class="col-sm-4"><span><?=Yii::t('app','Section')?></span><?=$studentInfo->section->title?></li>
                                                    <li class="col-sm-4"><span><?=Yii::t('app','Religion')?></span><?=($studentInfo->religion_id)?$studentInfo->religion->Title:'N/A'?></li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-2 reg_number">
                                        <div class="row">
                                            <p><?=$studentInfo->user->username?></p>
                                            <span>Registration No.</span>
                                        </div>
                                    </div>
                                </div>
                                <div id="parents" class="tab-pane fade">
                                    <div class="info_st">
                                        <ul>
                                            <li class="col-sm-4"><span>Name</span><?=($studentInfo->studentParentsInfos)?Yii::$app->common->getParentName($studentInfo->stu_id):''?></li>
                                            <li class="col-sm-4"><span>Email</span><?=($studentInfo->studentParentsInfos)?$studentInfo->studentParentsInfos->email:'N/A'?></li>
                                        </ul>
                                        <ul>

                                            <li class="col-sm-4"><span>CNIC</span><?=($studentInfo->studentParentsInfos)?$studentInfo->studentParentsInfos->cnic:'N/A'?></li>
                                            <li class="col-sm-4"><span>Contact No.1</span><?=($studentInfo->studentParentsInfos)?$studentInfo->studentParentsInfos->contact_no:'N/A'?></li>
                                        </ul>
                                        <ul>
                                            <li class="col-sm-4"><span>Profession</span>
                                                <?php
                                                if($studentInfo->studentParentsInfos){
                                                    $professn = $studentInfo->studentParentsInfos->profession;
                                                    if($professn){
                                                        $getProfession=Profession::find()->where(['id'=>$professn])->one();
                                                        echo $getProfession->title;
                                                    }else{
                                                        echo 'N/A';
                                                    }
                                                }else{
                                                    echo 'N/A';
                                                }
                                                ?>



                                            </li>
                                            <li class="col-sm-4"><span>Contact No.2</span><?=($studentInfo->studentParentsInfos)?$studentInfo->studentParentsInfos->mother_contactno:'N/A'?></li>
                                        </ul>
                                    </div>
                                </div>
                                <div id="address" class="tab-pane fade">
                                    <?php //echo ($studentInfo->location1)?$studentInfo->location1:'N/A'?>
                                    <?php //echo ($studentInfo->location2)?$studentInfo->location2:'N/A'?>
                                    <div class="info_st">
                                        <ul>
                                            <li class="col-sm-12"><span>Postal Address</span>

                                                <?php
                                                echo ($studentInfo->location1)?$studentInfo->location1:'N/A' .' , ';
                                                //echo .' ,'.;
                                                if(count($studentInfo->country_id) > 0){
                                                    echo $studentInfo->city->city_name .' , '. $studentInfo->province->province_name .' , '. $studentInfo->country->country_name;}?>

                                        </ul>
                                        <ul>
                                            <li class="col-sm-12"><span>Permanent Address</span>
                                                <?php echo ($studentInfo->location2)?$studentInfo->location2:'N/A';
                                                if(!empty($studentInfo->location2)){
                                                    if($studentInfo->fk_ref_city_id2){
                                                        echo $studentInfo->fkRefCityId2->city_name;
                                                    }
                                                    if($studentInfo->fk_ref_province_id2){
                                                        echo  ' , '. $studentInfo->fkRefProvinceId2->province_name;
                                                        
                                                    }
                                                    if($studentInfo->fk_ref_country_id2){
                                                       echo ' , '. $studentInfo->fkRefCountryId2->country_name;
                                                    }
                                                }

                                                ?>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div id="transport-hostel" class="tab-pane fade">
                                    <p>
                                        <?php
                                        if($studentInfo->fk_stop_id){
                                            ?>
                                            <strong>Transport</strong><br/>
                                            <?= '<strong>Zone:</strong>  '. $studentInfo->fkStop->fkRoute->fkZone->title.', <strong>Route:</strong> '.$studentInfo->fkStop->fkRoute->title.', <strong>Stop:</strong> '.$studentInfo->fkStop->title?>
                                            <?php
                                        }else{
                                            echo "Hostel: N/A";
                                        }
                                        ?>
                                    </p>
                                    <p>
                                        <?php
                                        if($studentInfo->is_hostel_avail == 1){
                                            $hostel_detail  = \app\models\HostelDetail::find()->where(['fk_student_id'=>$studentInfo->stu_id])->one();
                                            $hostel_name    = $hostel_detail->fkHostel->Name;
                                            $floor_name     = $hostel_detail->fkFloor->title;
                                            $room           = $hostel_detail->fkRoom->title;
                                            $bed            = $hostel_detail->fkBed->title;
                                            ?>
                                            <strong>Hostel</strong><br/>
                                            <?='<strong>Name:</strong> '.$hostel_name.", <strong>Floor Name:</strong> ".$floor_name.",  <strong>Room:</strong>  ".$room.", <strong>Bed:</strong> ".$bed?>
                                            <?php
                                        }
                                        else{
                                            echo 'Hostel: N/A';
                                        }
                                        ?>
                                    </p>


                                </div>
                                <div id="free-plan" class="tab-pane fade">
                                    <div class="col-sm-10">
                                        <div class="table-responsive new-std-challan" id="table-new-std-challan">
                                            <table class="table">
                                                <thead>
                                                <tr>
                                                    <th class="fst_center">No.</th>
                                                    <th>Heads</th>
                                                    <th>Amount</th>
                                                    <th>Yearly Amount</th>
                                                </tr>
                                                </thead>

                                                <tbody>
                                                <?php
                                                $i=1;
                                                $sum_total          = 0;
                                                $yearly_sum_total   = 0;
                                                $amount             = 0;
                                                $transport_amt      = 0;
                                                $total_discount     = 0;
                                                $remaining_amount   = 0;
                                                $yearly_hostel_fare = 0;
                                                $yearly_transport_fare = 0;
                                                $yearly_hostel_fare = 0;
                                                $total_yearly_discount=0;
                                                $store_array_particular=[];
                                                foreach ($fee_query as $items){

                                                    /*student head discount*/
                                                    $discountAmount = \app\models\FeeDiscounts::find()
                                                        ->where([
                                                            'fk_branch_id'        => Yii::$app->common->getBranch(),
                                                            'fk_stud_id'          => $studentInfo->stu_id,
                                                            'fk_fee_head_id'      => $items['head_id']
                                                        ])->one();


                                                    if($items['no_months'] == 1){
                                                        $amount = $items['amount']* $items['no_months'];
                                                        $totalHeadAmt_without_currency  =  $amount;
                                                    }else{
                                                        $amount = $items['amount']* $items['no_months']/$fee_plan_Model->no_of_installments;
                                                        $totalHeadAmt_without_currency  =  $amount;

                                                    }

                                                    /*if total headwise receive is not empty it will diduct tht total recieved amount from total along with head discount*/
                                                    if(count($discountAmount) > 0 ){
                                                        $totalHeadAmt_without_currency = (round($amount,0));
                                                        $total_discount = $total_discount + $discountAmount->amount;
                                                    }
                                                    //$remaining_amount = $remaining_amount+ $totalHeadAmt_without_currency;

                                                    $sum_total= $sum_total+$amount;
                                                    $store_array_particular[]= $items['head_id'];


                                                    ?>
                                                    <tr>
                                                        <td class="fst_center"><?=$i?></td>
                                                        <td><?=$items['title']?></td>
                                                        <td>
                                                            <span class="pull-left currency-head"> Rs. <?=round($totalHeadAmt_without_currency, 0)?></span>
                                                            <?php
                                                            /*if there's any head discount.*/
                                                            if(count($discountAmount) > 0 ){
                                                                ?>
                                                                <input type="hidden" value="<?= $discountAmount->amount; ?>" name="headDiscount[<?=$items['head_id']?>]"/>
                                                                <?php
                                                            }
                                                            ?>

                                                        </td>
                                                        <td>
                                                            <?php
                                                            if($items['no_months'] == 1) {
                                                                $yearly_sum_total =$yearly_sum_total+ round($totalHeadAmt_without_currency, 0);
                                                                ?>
                                                                <span
                                                                    class="pull-left currency-head"> Rs. <?= round($totalHeadAmt_without_currency, 0) ?></span>
                                                                <?php
                                                            }else{
                                                                $yearly_sum_total = $yearly_sum_total + (round($totalHeadAmt_without_currency, 0)* $fee_plan_Model->no_of_installments);
                                                                ?>
                                                                <span
                                                                    class="pull-left currency-head"> Rs. <?= round($totalHeadAmt_without_currency, 0)* $fee_plan_Model->no_of_installments ?></span>
                                                                <?php
                                                            }
                                                            ?>
                                                        </td>

                                                    </tr>
                                                    <?php
                                                    $i++;
                                                }
                                                /*if transport fere is applicable than */
                                                if(!empty($transport_fare) || $transport_fare != null){
                                                    $net_total_amt = $sum_total+$transport_fare;
                                                    $yearly_transport_fare     = $transport_fare*12;
                                                    $yearly_net_total_amt = $yearly_sum_total+$yearly_transport_fare;
                                                }else{
                                                    $net_total_amt          = $sum_total;
                                                    $yearly_net_total_amt   = $yearly_sum_total;
                                                }

                                                /*if hostel is awail by student*/
                                                if(!empty($hostel_fare) || $hostel_fare != null) {
                                                    $net_total_amt = $net_total_amt + $hostel_fare;
                                                    $yearly_hostel_fare = $hostel_fare*12;
                                                    $yearly_net_total_amt = $yearly_net_total_amt+$yearly_hostel_fare;
                                                }
                                                /*total yearly discount */
                                                $total_yearly_discount = $total_discount*$fee_plan_Model->no_of_installments;
                                                /*total amount minus total discount.*/
                                                $payable = $net_total_amt-$total_discount;
                                                $yearly_payable = $yearly_net_total_amt - $total_yearly_discount;
                                                ?>
                                                <tr>
                                                    <th colspan="1"></th>
                                                    <th colspan="1"><span class="res_total">Total</span></th>
                                                    <td colspan="1"><span class="res_total" id="total-amount"> Rs.&nbsp;<?=round($sum_total,0);?></span> </td>
                                                    <td colspan="1"><span class="res_total" id="total-amount"> Rs.&nbsp;<?=round($yearly_sum_total,0);?></span> </td>
                                                </tr>
                                                <tr style="<?= (!empty($transport_fare) || $transport_fare != null)?'visibility:visible;':'display:none;' ?> width: 100%;">
                                                    <th></th>
                                                    <th><span class="trans_fare">Transport Fare</span></th>
                                                    <td><span id="total-transport-fare" data-totaltrnsprt="<?=(!empty($transport_fare) || $transport_fare != null)?round($transport_fare,0):0 ?>">
                                    <span class="pull-left currency-head"> Rs.&nbsp;<?=$transport_fare?></span>
                                    </span>
                                                    </td>
                                                    <td><span id="total-transport-fare" data-totaltrnsprt="<?=(!empty($yearly_transport_fare) || $yearly_transport_fare != null)?round($transport_fare,0):0 ?>">
                                    <span class="pull-left currency-head"> Rs.&nbsp;<?=$yearly_transport_fare?></span>
                                                    </td>
                                                </tr>
                                                <tr style="<?= (!empty($hostel_fare) || $hostel_fare != null)?'visibility:visible;':'display:none;' ?> width: 100%;">
                                                    <th></th>
                                                    <th><span class="trans_fare">Hostel Fare</span></th>
                                                    <td><span id="total-transport-fare" data-totaltrnsprt="<?=(!empty($hostel_fare) || $hostel_fare != null)?round($hostel_fare,0):0 ?>">


                                    <span class="pull-left currency-head"> Rs.&nbsp;<?=$hostel_fare?></span>
                                    </span>
                                                    </td>
                                                    <td><span id="total-transport-fare" data-totaltrnsprt="<?=(!empty($yearly_hostel_fare) || $yearly_hostel_fare != null)?round($yearly_hostel_fare,0):0 ?>">
                                    <span class="pull-left currency-head"> Rs.&nbsp;<?=(!empty($yearly_hostel_fare) || $yearly_hostel_fare != null)?round($yearly_hostel_fare,0):0 ?></span></td>
                                                </tr>
                                                <tr style="<?= (!empty($total_discount) || $total_discount != null)?'visibility:visible;':'display:none;' ?> width: 100%;">
                                                    <th></th>
                                                    <th><span class="ds_amount">Discount Amount</span></th>
                                                    <td><span id="total-discount" data-totaldiscount="<?=(!empty($total_discount) || $total_discount != null)? round($total_discount,0):0 ?>"><?='Rs. '.round($total_discount,0)?></span>
                                                    </td>
                                                    <td><span id="total-discount" data-totaldiscount="<?=(!empty($total_yearly_discount) || $total_yearly_discount != null)? round($total_yearly_discount,0):0 ?>">Rs. <?=(!empty($total_yearly_discount) || $total_yearly_discount != null)? round($total_yearly_discount,0):0 ?></span>
                                                    </td>
                                                </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="col-sm-2">

                                        <br />
                                        <span class="nt_amt" id="net-amount">
                                            Initial Amount
                                            <b><?php echo  'Rs. ' .  round($payable,0); ?></b>
                                            <?php
                                            if($total_yearly_discount>0) {
                                                ?>
                                                Initial Discount
                                                <b><?php echo 'Rs. ' . round($total_discount, 0); ?></b>
                                                <?php
                                            }
                                            ?>
                                        </span>
                                    </div>

                                <div class="col-sm-2">
                                        <span class="nt_amt" id="net-amount">
                                            Yearly Plan
                                            <b><?php echo  'Rs. ' .  round($yearly_payable,0); ?></b>
                                            <?php
                                            if($total_yearly_discount>0) {
                                                ?>
                                                Yearly Discount
                                                <b><?php echo 'Rs. ' . round($total_yearly_discount, 0); ?></b>
                                                <?php
                                            }
                                            ?>
                                        </span>
                                    </div>
                                </div>

                                <div id="sms-communication" class="tab-pane fade">

                                </div>
                            </div>
                            <ul class="nav nav-tabs">
                                <li class="active"><a href="#basic-information">Basic Information</a></li>
                                <li><a href="#parents">Parents/Guardian</a></li>
                                <li><a href="#address">Address</a></li>
                                <li><a href="#transport-hostel">Transport/Hostel</a></li>
                                <li><a href="#free-plan">Fee Plan</a></li>
                                <?php
                                    if(Yii::$app->user->identity->fk_role_id != 3) {
                                        ?>
                                        <li class="pull-right"><?php echo Html::a('Update', ['update', 'id' => $_GET["id"]], ['class' => 'btn green-btn pull-right']); ?></li>
                                        <?php
                                    }
                                ?>
                            </ul>
                        </div>
                        <div class="row st_widget stp_widgets fee-attend">
                            <div class="col-sm-6 static">
                                <div class="widget">
                                    <p>Attendance</p>
                                    <!--<img src="<?/*= Url::to('@web/img/g2.png') */?>" alt="MIS">-->
                                    <?=(count($attendance_array)>0)?'<div id="container_attendance" style="margin: 0 auto"></div>':''?>
                                    <a id="attendance-detail" href="javascript:void(0)" class="fa_detail">Details</a>
                                </div>
                                <div id="attendance-pop" class="pop_fat" style="display:none;">
                                    <div class="fad_close">
                                        <a id="close-detail" href="javascript:void(0)" class="anc_btn">
                                            <img src="<?= Url::to('@web/img/close.svg') ?>" alt="MIS">
                                        </a>
                                    </div>
                                    <div class="table-responsive">
                                        <table class="table table-striped">
                                            <thead>
                                            <tr>
                                                <th>No,</th>
                                                <th>Month</th>
                                                <th>Fee Slip Generation Date</th>
                                                <th>Challan No.</th>
                                                <th>Amount (Rs)</th>
                                                <th>Amout Paid (Rs)</th>
                                                <th>Arears (Rs)</th>
                                                <th>Paying Date</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <tr>
                                                <td>1</td>
                                                <td>April</td>
                                                <td>01 April 2017</td>
                                                <td>46647</td>
                                                <td>6,000</td>
                                                <td>4,000</td>
                                                <td>12,000</td>
                                                <td>12Jan 2017</td>
                                            </tr>
                                            <tr>
                                                <td>1</td>
                                                <td>April</td>
                                                <td>01 April 2017</td>
                                                <td>46647</td>
                                                <td>6,000</td>
                                                <td>4,000</td>
                                                <td>12,000</td>
                                                <td>12Jan 2017</td>
                                            </tr>
                                            <tr>
                                                <td>1</td>
                                                <td>April</td>
                                                <td>01 April 2017</td>
                                                <td>46647</td>
                                                <td>6,000</td>
                                                <td>4,000</td>
                                                <td>12,000</td>
                                                <td>12Jan 2017</td>
                                            </tr>
                                            <tr>
                                                <td>1</td>
                                                <td>April</td>
                                                <td>01 April 2017</td>
                                                <td>46647</td>
                                                <td>6,000</td>
                                                <td>4,000</td>
                                                <td>12,000</td>
                                                <td>12Jan 2017</td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6 static">
                                <div class="widget">
                                    <p>Fee</p>
                                    <!--<img src="<?/*= Url::to('@web/img/g33.svg') */?>" alt="MIS">-->
                                    <div id="container_fee_chart" style="margin: 0 auto"></div>
                                    <span class="pp_price">* Price in PKR</span>
                                    <a id="fee-detail" href="javascript:void(0)" class="fa_detail">Details</a>
                                </div>
                            </div>

                        </div>
                        <?php
                        if(count($exam_array)>0) { ?>
                            <div class="st_widget shade st_results">
                                <div class="tab-content">
                                    <ul class="nav nav-tabs exams-list">
                                        <li class="res_title">Results</li>
                                        <?php
                                        foreach($exam_array as $key=>$exams) { 
                                            ?>
                                            <li>
                                                <a href="#exam-<?=$key?>"
                                                   id="std-profile-exam"
                                                   data-examid="<?=$key?>"
                                                   data-stdid="<?=$studentInfo->stu_id?>"
                                                   data-classid="<?=$studentInfo->class_id?>"
                                                   data-groupid="<?=($studentInfo->group_id)?$studentInfo->group_id:null?>"
                                                   data-sectionid="<?=$studentInfo->section_id ?>"
                                                   data-url="<?=Url::to('profile-exam')?>"
                                                   data-examdivid="exam-<?=$key?>"><?=$exams?></a>
                                            </li>
                                            <?php
                                        }
                                        ?>
                                    </ul>
                                    <?php
                                    foreach($exam_array as $key=>$exams) {
                                        ?>
                                        <div id="exam-<?=$key?>" class="tab-pane fade">
                                            <?=$key?>
                                        </div>
                                        <?php
                                    }
                                    ?>
                                    <div class="col-sm-3 res_chart" id="pigraph-cointainer" style="display: none;">
                                        <div id="exam-result-container">

                                        </div>
                                        <!--<img src="<?/*=\yii\helpers\Url::to('@web/img/result-chat.svg')*/?>" alt="MIS">-->
                                    </div>
                                </div>
                            </div>
                            <?php
                        }
                        ?>
                        <div class="st_widget shade result_calender">
                            <img src="<?= Url::to('@web/img/calender-1.svg') ?>" alt="MIS">
                        </div>
                        <?php $sms_communication=SmsLog::find()->where(['fk_user_id'=>$_GET['id'],'fk_branch_id'=>yii::$app->common->getBranch()])->all();
                        $count=0;
                        ?>
                        <div class="panel-group sms_log shade sms-logs" id="sms-logs">
                            <div class="sms_log_title">
                                <h4>SMS Communication </h4>
                            </div>

                            <div class="sms_log_con cscroll mCustomScrollbar" data-mcs-theme="dark">
                                <?php
                                $count=0;
                                foreach ($sms_communication as $sms) {
                                    $body=$sms->SMS_body;
                                    $count++;
                                    if(!empty($sms)){
                                        ?>
                                        <div class="panel panel-default">
                                            <div class="panel-heading">
                                                <h4 class="panel-title">
                                                    <a data-toggle="collapse" data-parent=".sms-logs" href=".sms_log_1">
                                                        <?php
                                                        $text= $sms->SMS_body;
                                                        // echo substr("$text", 0, -5);
                                                        $myvalue = 'Test me more';
                                                        $arr = explode(' ',trim($text));
                                                        echo $arr[0]; // will print Test
                                                        ?>

                                                        <div class="rig-sms_tt">
                                                            <time><?php echo date("H:i a",strtotime($sms->sent_date_time)) ?></time>
                                                            <span> 
                                                            <?php echo date("D d,M Y",strtotime($sms->sent_date_time)) ?>
                                                            </span>
                                                            <img src="<?= Url::to('@web/img/down-arrow.svg') ?>" alt="MIS">
                                                        </div>
                                                    </a>
                                                </h4>
                                            </div>

                                            <div id="sms_log_1" class="panel-collapse collapse in sms_log_1">
                                                <div class="panel-body">
                                                    <?php echo $sms->SMS_body; ?>
                                                </div>
                                            </div>
                                        </div>
                                    <?php }else{ echo "Not Found";} }?>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    </div>
    </div>
    </div>
    </div>


<?php
/*student attedance array*/
$attenance_data=[];
foreach ($attendance_array as $key=>$attendance_details){
    $attenance_data['leave_type'][]= $attendance_details['leave_type'];
    $attenance_data['total'][]= $attendance_details['total'];

}
$this->registerJS("$('ul.exams-list li a').last()[0].click();", \yii\web\View::POS_LOAD);
$this->registerJS(" 
    var attendance_details = ".json_encode($attenance_data,JSON_NUMERIC_CHECK).";
    var currentDate        = ".date('Y').";
    var FeePiData          =".json_encode($pi_array_fee,JSON_NUMERIC_CHECK).";
    ", \yii\web\View::POS_BEGIN);
$this->registerJsFile(Yii::getAlias('@web').'/js/highcharts.js',['depends' => [yii\web\JqueryAsset::className()],null]);
$this->registerJsFile(Yii::getAlias('@web').'/js/highcharts-std-profile.js',['depends' => [yii\web\JqueryAsset::className()],null]);
?>