<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\Modal;
use yii\widgets\Pjax;
$this->registerCssFile( Yii::getAlias('@web/css/students/import-students.css'));

/* @var $this yii\web\View */

$this->title = 'Dashboard';


if(Yii::$app->user->identity->fk_role_id != 3) {
    ?>
    <div class="db-wrapper">
        <div class="col-md-12 main-pallet">
            <div class="db-wrapper-inn ">

                <?php
                $count = 1;
                foreach ($dashboard as $key => $dashboard_item) {
                    if ($count % 2 == 1) {
                        echo '<div class="col-sm-3">';
                    }
                    if ($key == 0) {
                        ?>
                        <div class="widget widget-drag">
                            <img src="img/plus.svg" alt="Drag Here">
                            <a href="javascript:void(0);" id="add-quick-links">Add quick links to your dashboard</a>
                        </div>

                        <?php
                    }
                    if ($dashboard_item->type == 'links') {
                        ?>
                        <div class="widget g-border" id="pallet-no-<?= $dashboard_item->id ?>"
                             style="<?= ($dashboard_item->status == 'active') ? 'display:none;' : '' ?>">

                            <div class="wed-head">
                                <a href="javascript:void(0);" data-toggle="collapse" data-target="#widget<?= $key ?>">
                                    <?= $dashboard_item->title ?>
                                    <img src="<?= $dashboard_item->icon ?>" alt="<?= $dashboard_item->title ?>">
                                </a>
                                <a class="wid-close" href="javascript:void(0);"
                                   data-name="<?= $dashboard_item->title ?>" data-id="<?= $dashboard_item->id ?>"
                                   id="close-pallets">
                                    <img src="img/close.svg" alt="Close">
                                </a>
                            </div>
                            <div class="wed-body collapse" id="widget<?= $key ?>">
                                <?= $dashboard_item->details ?>
                            </div>
                            <?php
                                if($dashboard_item->id == 1) {
                            ?>
                            <div class="wed-head" style="min-height: 0px;padding-bottom: 5px;padding-top: 0px;">
                                <a href="javascript:void(0);" id="sms_to_branch" >
                                    SMS to Branch
                                </a>
                            </div>
                            <div class="wed-head" style="min-height: 0px;padding-bottom: 25px;padding-top: 0px;">
                                <a href="javascript:void(0);" id="sms_record_link" data-number="<?php echo $log_num;?>">
                                    <?php echo Url::to(['analysis/send-whole-school']) ?>
                                </a>
                            </div>
                            <?php 
                                }
                            ?>
                        </div>

                        <?php
                    } else {
                        ?>
                        <div class="widget" id="pallet-no-<?= $dashboard_item->id ?>"
                             style="<?= ($dashboard_item->status == 0) ? 'display:none;' : '' ?>">
                            <div class="wed-head">

                                <a class="wid-close" href="javascript:void(0);" data-id="<?= $dashboard_item->id ?>"
                                   id="close-pallets">
                                    <img src="img/close.svg" alt="Close">
                                </a>
                                <div class="wid-img-col">
                                    <span><?= $dashboard_item->title ?></span>
                                    <?php
                                    if ($dashboard_item->identifier === 'daily_student') {
                                        if (count($attendance_data) > 0) {
                                            echo $dashboard_item->details;
                                        } else {
                                            echo ' not found.';
                                        }

                                    }
                                    if ($dashboard_item->identifier === 'daily_employee') {
                                        if (count($attendance_emp_data) > 0) {
                                            echo $dashboard_item->details;
                                        } else {
                                            echo ' not found.';
                                        }
                                    }
                                    ?>

                                </div>
                            </div>
                        </div>
                        <?php
                    }

                    if ($key == $dashboard_item->sort_order) {
                        echo $key;
                    }
                    if ($count % 2 == 0) {
                        echo "</div>";
                    }
                    $count++;
                }
                ?>
                <div class="col-md-3">
                    <div class="widget">
                        <div class="wed-head">
                            <a class="wid-close" href="#">
                                <img src="img/close.svg" alt="Close">
                            </a>
                            <div class="wed-ico">
                                <img src="img/alert-ico.svg" alt="Close">
                            </div>
                            <div class="wed-altcol">
                                <h5>Winter Vacation</h5>
                                <p>Lorem ipsum dolor sit amet, consect etur adipiscing elit.</p>
                                <span>Friday 28th January 2017</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="calender-pop">
        <div class="cp-head">
            <a href="javascript:void(0)" data-toggle="collapse" data-target="#calender">
                <p>Calendar</p>
                <img src="img/collapse.svg" alt="collapse">
            </a>
        </div>
        <div class="calender-body collapse" id="calender">
            <img src="img/calender.svg" alt="Calendar">
        </div>
    </div>
    <?php
    if (count($attendance_data) > 0) {
        $this->registerJS("
    var attendance_details = " . json_encode($attendance_data, JSON_NUMERIC_CHECK) . ";
    var currentDate        = " . date('Y') . ";", \yii\web\View::POS_BEGIN);
    }
    if (count($attendance_emp_data) > 0) {
        $this->registerJS("
    var attendance_emp_details = " . json_encode($attendance_emp_data, JSON_NUMERIC_CHECK) . ";
    var currentDate        = " . date('Y') . ";", \yii\web\View::POS_BEGIN);
    }

    $this->registerJsFile(Yii::getAlias('@web') . '/js/highcharts.js', ['depends' => [yii\web\JqueryAsset::className()], null]);
    $this->registerJsFile(Yii::getAlias('@web') . '/js/dashboard.js', ['depends' => [yii\web\JqueryAsset::className()], null]);

    Modal::begin([
        'header' => '<h4>Deactivation Alert</h4><input type="hidden" id="pallet_id"/>',
        'id' => 'modal-pallet-inactive-conf',
        'options' => [
            'data-keyboard' => false,
            'data-backdrop' => "static"
        ],
        'size' => 'modal-md',
        'footer' => '<button type="button" class="btn btn-default pull-left" data-dismiss="modal">No</button> <button type="button" class="btn btn-primary pull-right" id="remove-pallet" data-url="' . Url::to("dashboard/inactive-pallet") . '">Yes</button>',

    ]);

    echo "<div id='modalContent'></div>";
    Modal::end();

    Modal::begin([
        'header' => '<h4>Activate Pallet</h4><input type="hidden" id="pallet_id"/>',
        'id' => 'modal-pallet-active-conf',
        'options' => [
            'data-keyboard' => false,
            'data-backdrop' => "static"
        ],
        'size' => 'modal-md',
        'footer' => '<button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>',

    ]);
    ?>
    <div class="table-responsive">
        <table class="table table-hover">
            <tr>
                <th>Action</th>
                <th>Pallet Name</th>
            </tr>

            <?php
            foreach ($dashboard as $active_pallets) {
                ?>
                <tr>
                    <td><input type="checkbox" id="active-inactive-pallet-<?= $active_pallets->id ?>"
                               data-url="<?= Url::to("dashboard/active-pallet") ?>"
                               data-id="<?= $active_pallets->id ?>" <?= ($active_pallets->status == 1) ? 'checked' : '' ?>/>
                    </td>
                    <td><?= $active_pallets->title ?></td>
                </tr>

                <?php
            }
            ?>
        </table>
    </div>
    <?php
    Modal::end();

}else{
    /*other than admin login.*/
}
?>

<input type="hidden" id="redirect_url" value="<?php echo Url::to('site') ?>" />
<div class="loading" style="display: none;">
  <div class="loadingWrapper">
    <div id="loading"> </div>
    <h1>Sending . . .</h1>
  </div>
</div>

<div class="container">
  

  <!-- Modal -->
  <div class="modal fade" id="sendsmsWhole" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
    <?php Pjax::begin(['id' => 'pjax-container']) ?>

      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Send Sms To Whole School</h4>
        </div>
        <div class="modal-body">
            <p>
                <textarea class="form-control" name="smsWhole" id="smsWholeSchool"></textarea>
            </p>
            <a href="Javascript:;" id="sendsmsWholeschools" class="btn btn-primary" data-url=<?php echo Url::to(['analysis/send-whole-school']) ?> ?>Send</a>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
      <?php Pjax::end() ?>
      
    </div>
  </div>

</div>

 <!-- Modal -->
 <div class="modal fade" id="sendsmsRcordNum" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
    <?php Pjax::begin(['id' => 'pjax-container']) ?>
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">The numbers of text sent in this month: <b class="number"></b></h4>
        </div>
    </div>
    <?php Pjax::end() ?>
    </div>
</div>

 <!-- Modal -->
 <div class="modal fade" id="msg_modal" role="dialog" data-backdrop="static" tabindex="-1">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-boday" style="padding: 43px;font-size: 21px;color: green;">

            </div>
            <div class="modal-footer">
                <a type="button" class="btn btn-default" href="<?php echo Url::to('site') ?>">Close</a>
            </div>
        </div>
    </div>
</div>

<style>
.success::before {
    content: '' !important;
    margin-top: -17px;
}
</style>