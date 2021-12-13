<?php
use yii\helpers\Html;
use yii\helpers\Url;
?>
<div class="text-center">
    <strong class="text-center" id="header"><?=Yii::$app->common->getCGSName($class_id,$group_id,$section_id).' - '.ucfirst($examtype->type)?></strong>
</div>
<div class="col-md-12 print-padding-bottom">
    <div class="col-md-6">&nbsp;<br/></div>
    <div class="col-md-6">
        <div class="export-classwise-resultsheet pull-right" data-url = "<?=Url::to(['reports/class-wise-resultsheet'])?>">

        </div>
    </div>
</div>

<div class="col-md-12">
    <div id="class-wise-container" class="table-responsive kv-grid-container">
        <table class="kv-grid-table table table-bordered table-striped kv-table-wrap">
            <thead>

        <tr>
        <th>#</th>
        <th valign="middle">Roll No.</th>
        <th valign="middle">Name</th>
            <?php
            $max_marks= 0;
            foreach ($heads_marks['heads'] as $key=>$sub){
                echo "<th>".ucfirst($sub)."<br/>(".$heads_marks['total_marks'][$key].")</th>";

                 $max_marks= $max_marks+$heads_marks['total_marks'][$key];
            }
            ?>
            <th valign="middle">Marks</th>
            <th valign="middle">Percentage</th>
            <th valign="middle">Position</th>
        </thead>
            <tbody>
        <?php
        $i=1;

        foreach ($query as $student_id=>$marks){
            $totalMarks_arr = [];
            $totalMarks = 0;
            $total_marks_obtain= 0;
            $percentage=0;
            echo "<tr>";
            echo "<td>".$i."</td>";
            foreach ($marks as $key=>$std_mark_obt){

                if($key==='name'){
                    echo "<td>";
                    echo Yii::$app->common->getName($std_mark_obt);
                    echo "</td>";

                }else if($key==='student_id'){
                    echo "<td>";
                    echo $std_mark_obt;
                    echo "</td>";
                }else{
                    $totalMarks_arr[$i][] = $totalMarks+$std_mark_obt;
                    echo "<td>";
                    echo $std_mark_obt;
                    echo "</td>";

                }


            }
            $total_marks_obtain = array_sum($totalMarks_arr[$i]);
            if($max_marks>0){
                $percentage= $total_marks_obtain*100/$max_marks;
            }else{
                $percentage = 0;
            }
            echo "<td>";
            echo number_format($total_marks_obtain, 2, '.', '');
            echo "</td>";
            echo "<td>";
            echo round($percentage,1)."%";
            echo "</td>";
            if(isset($positions)){
                echo "<td>".Yii::$app->common->multidimensional_search($positions, ['student_id'=>$student_id])."</td>";
            }else{
                echo "<td>N/A</td>";
            }
            echo "<tr>";
            $i++;
        }
        ?>

        </tbody>
        </table>
    </div>
</div>