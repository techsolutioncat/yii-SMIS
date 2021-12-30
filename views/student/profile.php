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
                                <?php /*
                                <!-- <a id="get-timeline" class="<?=($total_items==$counter)?'active':''?>" href="javascript:void(0);" data-sdate="<?=$s_date?>" data-edate="<?=$e_date?>" data-std="<?=$studentInfo->stu_id?>" data-class_id="<?=$items['old_class']?>" data-group_id="<?=$items['old_group']?>" data-section_id="<?=$items['old_section']?>" data-url="<?=Url::to('get-profile-stats')?>"> -->
                                */?>
                                <a id="get-timeline" class="<?=($key==$active_key)?'active':''?>" href="<?php echo Url::to('get-profile-stats-by-id').'?data-sdate='.$s_date.'&data-edate='.$e_date.'&data-std='.$studentInfo->stu_id.'&data-class_id='.$items['old_class'].'&data-group_id='.$items['old_group'].'&data-section_id='.$items['old_section'].'&active_key='.$key ?>" data-url="<?=Url::to('get-profile-stats')?>">
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
                                                    <tr class="tr-fee-plan">
                                                        <td class="fst_center"><?=$i?></td>
                                                        <td><?=$items['title']?></td>
                                                        <td>
                                                            <span class="pull-left currency-head"> Rs. </span><span class="fee-amount pull-left currency-head"><?=round($totalHeadAmt_without_currency, 0)?></span>
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
                                        $get_id = (isset($_GET["id"]))? $_GET["id"]: $student_id;
                                        ?>
                                        <li class="pull-right"><?php echo Html::a('Update', ['update', 'id' => $get_id], ['class' => 'btn green-btn pull-right']); ?></li>
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

                                <!-- Student Fee -->
                                <div id="student-fee-pop" class="pop_fat" style="display:none; top: -330px;">
                                    <div class="fad_close">
                                        <a id="fee-close-detail" href="javascript:void(0)" class="anc_btn">
                                            <img src="<?= Url::to('@web/img/close.svg') ?>" alt="MIS">
                                        </a>
                                    </div>
                                    <div class="table-responsive">
                                       <?php
                                        $countgrand=0;
                                        $payrcvGrnd=0;
                                        $arearscount=0;
                                        if(count($getChalans) > 0) {
                                            foreach ($getChalans as $i => $getChalan) {
                                                ?>
                                        <?php
                                                 if($getChalan['id']){
                                                    $fee_challan_record = \app\models\FeeChallanRecord::find()->where(['fk_branch_id'=>Yii::$app->common->getBranch(),'challan_id'=>$getChalan['id']])->one();
                                                }
                                                $query = yii::$app->db->createCommand("
                                                select fhw.id,fhw.fk_branch_id,fhw.fk_stu_id,fh.title,fhw.payment_received,fcr.arrears,fhw.transport_fare,fhw.hostel_fee from fee_head_wise fhw inner join fee_heads fh on fh.id=fhw.fk_fee_head_id inner join fee_transaction_details ftd on ftd.id=fhw.fk_chalan_id left join fee_challan_record fcr on fcr.challan_id=fhw.fk_chalan_id and fhw.fk_fee_head_id=fcr.fk_head_id where fhw.fk_stu_id=" . $student_id . " and fhw.fk_branch_id=" . Yii::$app->common->getBranch() . " and ftd.challan_no = '" . $getChalan['challan_no'] . "'
                                                ")->queryAll();
                                 
                                                 $query_extrahead = yii::$app->db->createCommand("select fhw.id,fhw.fk_branch_id,fhw.fk_stu_id,fh.title,fhw.payment_received,fcr.arrears from fee_head_wise fhw  
                                inner join fee_heads fh on fh.id=fhw.fk_fee_head_id 
                                inner join fee_transaction_details ftd on ftd.id=fhw.fk_chalan_id 
                                left join fee_challan_record fcr on fcr.challan_id=fhw.fk_chalan_id and fhw.fk_fee_head_id=fcr.fk_head_id 
                                where fhw.fk_stu_id=" . $student_id . " and fhw.fk_branch_id=" . Yii::$app->common->getBranch() . " and fh.extra_head=1 and fhw.fk_fee_particular_id IS NULL and ftd.challan_no = '" . $getChalan['challan_no'] . "'")
                                                     ->queryAll();
                                       ?>
                                        <table class="table table-striped">
                                            <thead>
                                            <tr>
                                                <th>SR</th>
                                                <!-- <th>Challan No.</th> -->
                                                <th>Title</th>
                                                <th>Total</th>
                                                <th>Payment Received</th>
                                                <th>Arrears</th>
                                                <!-- <th>Fee Submission Date</th> -->

                                            </tr>
                                            </thead>
                                            <tbody>
                                            <?php
                                            $count = 0;
                                            $total = 0;
                                            $arrears = 0;
                                            $sumboth = 0;
                                            $total_ext=0;
                                            $total_fareamount=0;
                                            $transport_fare_received=0;
                                            foreach ($query as $queryy) {
                                                //echo $queryy['transport_fare'];

                                                $count++;
                                                $total = $total + $queryy['payment_received'];
                                                $arrears = $arrears + $queryy['arrears'];
                                                $sumboth = $sumboth + $queryy['payment_received'];
                                                $countgrand = $countgrand + $queryy['payment_received'];
                                                $payrcvGrnd = $payrcvGrnd + $queryy['payment_received'];
                                                $arearscount = $arrears + $queryy['arrears'];
                                                $hostel_fee = $queryy['hostel_fee'];
                                                $transport_fare_received = $queryy['transport_fare'];
                                                ?>
                                                <?php
                                                if ($queryy['payment_received'] > 0) {
                                                    ?>
                                                    <tr>
                                                        <td><?= $count; ?></td>
                                                        <!-- <td><?//= $queryy['challan_no'];
                                                        ?></td> -->
                                                        <td><?= $queryy['title'] ?></td>
                                                        <td><?= $queryy['payment_received'] + $queryy['arrears']; ?></td>
                                                        <td><?= $queryy['payment_received']; ?></td>
                                                        <td>Rs. <?php if ($queryy['arrears'] == '') {
                                                                echo "0";
                                                            } else {
                                                                echo $queryy['arrears'];
                                                            }; ?></td>
                                                        <!-- <td><?//= $queryy['fee submission date'];
                                                        ?></td> -->

                                                    </tr>
                                                    <?php
                                                }
                                            } 
                                            if(count($query_extrahead)>0) {
                                                foreach ($query_extrahead as $query_extra) { }
                                                    $count++;
                                                    $total_ext = $total_ext + $query_extra['payment_received'];
                                                    $arrears = $arrears + $query_extra['arrears'];
                                                    $sumboth = $sumboth + $query_extra['payment_received'];
                                                    $countgrand = $countgrand + $query_extra['payment_received'];
                                                    $payrcvGrnd = $payrcvGrnd + $query_extra['payment_received'];
                                                    $arearscount = $arrears + $query_extra['arrears'];

                                                    ?>
                                                    <?php
                                                    if ($query_extra['payment_received'] > 0) {
                                                        ?>
                                                        <tr>
                                                            <td><?= $count; ?></td>
                                                            <!-- <td><?//= $queryy['challan_no'];
                                                            ?></td> -->
                                                            <td><?= $query_extra['title']; ?></td>
                                                            <td><?php echo $query_extra['payment_received'] + $queryy['arrears']; ?></td>
                                                            <td><?= $query_extra['payment_received']; ?></td>
                                                            <td>Rs. <?php if ($query_extra['arrears'] == '') {
                                                                    echo "0";
                                                                } else {
                                                                    echo $query_extra['arrears'];
                                                                }; ?></td>
                                                            <!-- <td><?//= $queryy['fee submission date'];
                                                            ?></td> -->

                                                        </tr>
                                                        <?php
                                                    }
                                                    $hostel_fee = $queryy['hostel_fee'];
                                                    $transport_fare = $queryy['transport_fare'];
                                                    if(count($fee_challan_record)>0){
                                                        $total_fareamount =$fee_challan_record->fare_amount;
                                                        $sumboth = $sumboth+$total_fareamount;

                                                        $total_hostel_fare = $fee_challan_record->fare_amount;
                                                    }
                                                    // if($transport_fare>0) {
                                                        ?>
                                                        <!--  <tr>
                                                            <td><?= $count + 1; ?></td>
                                                            <td><?//= $queryy['challan_no'];
                                                            ?></td>
                                                            <td>transport Fee</td>
                                                            <td><?//= ($total_fareamount > 0) ? $total_fareamount : 0 ?></td>
                                                            <td><?//= ($transport_fare) ? $transport_fare : 0; ?></td>
                                                            <td></td>
                                                            <td><?//= $queryy['fee submission date'];
                                                            ?></td>
                                                        
                                                        </tr> -->

                                                        <?php
                                                    //}

                                                //}
                                            }?>
                                            


                                            <?php 
                                            

                                            ?>
                                            <tr>
                                                <th><?php echo $count + 1;?></th>
                                                <td>Transport fare </td>
                                                <th> Rs. <?php echo $queryy['transport_fare']; ?></th>
                                                <th> <?php echo $queryy['transport_fare']; ?></th>
                                                
                                            </tr>

                                            </tbody>
                                        </table>
                                         <table><tbody>
                                                 <tr class="challan-fee-tr" style="display: <?php echo ($i == 0)? 'block': 'none';?>">
                                                    <td><strong style="margin-left: 20px;">Challan No: </strong><span
                                                            style="color: red" style="margin-left: 20px;"><?php echo $getChalan['challan_no']; ?></span>
                                                    </td>
                                                    <?php
                                                    if(!empty($getChalan['manual_recept_no'])) {
                                                        ?>
                                                        <td><strong><?= Yii::t('app', 'Manual Receipt #') ?>: </strong><span
                                                                style="color: red"><?php echo $getChalan['manual_recept_no']; ?></span></td>
                                                        <?php
                                                    }
                                                        ?>
                                                    <td><strong style="margin-left: 20px;">Fee Submission Date: </strong>
                                                        <span
                                                            style="color:blue" style="margin-left: 20px;"><?php echo date("d-m-Y", strtotime($getChalan['fee_submission_date'])); ?></span>
                                                    </td>
                                                </tr>
                                                </tbody></table>
                                        <?php } ?>
                                            <table class="table table-striped">

                                                <tr>
                                                    <th></th>
                                                    <th></th>
                                                    <th></th>
                                                    <th></th>
                                                    <th></th>
                                                    <th></th>
                                                    <th></th>
                                                    <th></th>

                                                    <th style="color: green">Due: Rs. <?php echo $countgrand+$total_fareamount + $queryy['transport_fare']; ?></th>
                                                    <th style="color: blue">Received: Rs. <?php echo $payrcvGrnd+$queryy['transport_fare']; ?></th>
                                                    <th style="color: red">Arears: Rs. <?php echo $arearscount; ?></th>
                                                </tr>
                                                </table>
                                                <?php
                                                }else{
                                                ?>
                                                <div class="col-md-12">
                                                <div class="alert alert-warning">
                                                    Challan Not found.
                                                </div>
                                                </div>
                                                <?php}?>
                                        <?php } ?>
                                    </div>
                                </div>
                                <!-- Student Fee -->

                            </div>
                            <div class="col-sm-6 static">
                                <div class="widget">
                                    <p>Fee</p>
                                    <!--<img src="<?/*= Url::to('@web/img/g33.svg') */?>" alt="MIS">-->
                                    <div id="container_fee_chart" style="margin: 0 auto"></div>
                                    <span class="pp_price">* PKR</span>
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
                        <?php $get_id = (isset($_GET["id"]))? $_GET["id"]: $student_id; ?>
                        <?php $sms_communication=SmsLog::find()->where(['fk_user_id'=>$get_id,'fk_branch_id'=>yii::$app->common->getBranch()])->all();
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
// $fee_array = array();
// foreach ($fee_query as $items){
//     $tmp = array();
//     $tmp['name'] = $items['title'];
//     $tmp['data'] = $items['amount'];
//     array_push($fee_array, $tmp);
// }
$this->registerJS("$('ul.exams-list li a').last()[0].click();", \yii\web\View::POS_LOAD);
$this->registerJS(" 
    var attendance_details = ".json_encode($attenance_data,JSON_NUMERIC_CHECK).";
    var currentDate        = ".date('Y').";
    var FeePiData          =".json_encode($pi_array_fee,JSON_NUMERIC_CHECK).";
    ", \yii\web\View::POS_BEGIN);
$this->registerJsFile(Yii::getAlias('@web').'/js/highcharts.js',['depends' => [yii\web\JqueryAsset::className()],null]);
$this->registerJsFile(Yii::getAlias('@web').'/js/highcharts-std-profile.js',['depends' => [yii\web\JqueryAsset::className()],null]);
?>