<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use yii\grid\GridView;
use app\models\StudentInfo;
use kartik\date\DatePicker;
use app\models\RefClass;
use app\models\RefSection;
use app\models\RefGroup;
use yii\widgets\ActiveForm;
use kartik\depdrop\DepDrop;
$this->title = 'Branch Reports :: Statistics';
?>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-8 col-xs-9 bhoechie-tab-container">
        <div class="col-lg-1 col-md-2 col-sm-3 col-xs-3 bhoechie-tab-menu">
            <div class="list-group">
            <?php 
            $count=0;
            foreach ($getAllBranches as $allBranches) {
            $count++;
             ?>
                <a href="<?= url::to(['/branch-reports/all-branch-reports'])?>" data-branchid=<?= $allBranches->id;?> data-url=<?= Url::to(['branch-reports/all-branch-reports']) ?> id="BranchesAjax" class="<?php if($count == 1){echo "list-group-item active text-center";}else{echo "list-group-item text-center";}?>">
                 <?= $allBranches->name;
                 ?>
                 </a>
                <?php } ?>
                
            </div>
        </div>
        <div class="col-lg-11 col-md-10 col-sm-9 col-xs-9 bhoechie-tab">
            <!-- flight section -->

            <?php 
            $counts=0;
            foreach ($getAllBranches as $allBranchesDiv) {
            $counts++;
             ?>
            <div class="bhoechie-tab-content active">
                <!-- tab 1  content-->
			
       
            
		  
   
    		<!-- <div class="viewBranches"></div> -->
    	
            


            </div> <!-- end of tab 1 admission -->

            <?php } ?>

            <!-- train section -->
             <div class="bhoechie-tab-content">
               tab 2 content
           tab 2
           
           </div> 
           <div class="bhoechie-tab-content">
               tradadfsdf
           
           </div> 
      

           
        </div>
    </div>


    <?php 
$script= <<< JS
$(document).ready(function() {

var url=$('#BranchesAjaxss').data('url');
var branchid=$("#BranchesAjax").data('branchid');
//alert(url);
$.ajax
        ({
            type: "POST",
            dataType:"JSON",
            data: {branchid:branchid},
            url: url,
            cache: false,
            success: function(html)
            {
                $(".viewBranches").html(html.viewBranches);
            } 
        });
});

JS;
$this->registerJs($script);

?>