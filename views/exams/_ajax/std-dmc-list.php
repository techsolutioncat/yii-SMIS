<?php
use yii\helpers\Url;

?>
 <div class="row">
    <div class="col-sm-3 fs_sidebar"> 
        <ul class="std-exam-list">
            <?php
            foreach ($exam_std_query as $students_list){
                ?>
                <li><a href="javascript:void(0);"
                       id = "exam_std_list"
                       data-stdid = "<?=$students_list['stu_id']?>"
                       alt = "<?=$students_list['student_name']?>"
                       data-class = "<?=$class_id?>"
                       data-group = "<?=$group_id?>"
                       data-section = "<?=$section_id?>"
                       data-url = "<?=Url::to('student-dmc')?>"
                       data-position = "<?=Yii::$app->common->multidimensional_search($positions, ['student_id'=>$students_list['stu_id']])?>"
                       data-examId = "<?=$exam_id?>"><?=$students_list['student_name']?><img src="<?= Url::to('@web/img/view-table.svg') ?>"/> </a>
                </li>
                <?php
            }
            ?>

        </ul>
    </div>

    <div id="exam_content">
        <div class="col-sm-9 fs_content">

            <div class="ajax-content"></div>
            <div class="performance-graphs">
                <h3>Performance Graphs</h3>
                <!--<img src="<?/*= Url::to('@web/img/ppgraph.png') */?>" alt="DMC">-->
                <div id="dmc-graph-container"></div>
               <!-- <button id="export">get image</button>-->
            </div>
            <div id="chart-img"></div>
        <!-- <button id="large">Large</button>
         <button id="small">Small</button>-->
        </div>

         <?php
            $this->registerJS("$('.fs_sidebar').mCustomScrollbar({theme:'minimal-dark'});", \yii\web\View::POS_LOAD);
            $this->registerJsFile(Yii::getAlias('@web').'/js/highcharts.js',['depends' => [yii\web\JqueryAsset::className()],null]);
            $this->registerJsFile(Yii::getAlias('@web').'/js/highcharts-std-dmc.js',['depends' => [yii\web\JqueryAsset::className()],null]);
         ?>
        </div>
 </div> 