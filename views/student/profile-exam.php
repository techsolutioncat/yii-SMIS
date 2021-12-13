<?php


if(count($subjects_data)>0) {
    ?>
    <div class="col-sm-9">
        <div class="info_st">
            <?php
            $i=1;
            $total_marks= 0;
            $total_marks= 0;
            $total_obtain = 0;
            foreach ($subjects_data as $key => $subject_data) {
                if($i % 3 == 1){
                    echo "<ul>";
                }
                ?>
                    <li class="col-sm-4"><span><?=$subject_data['subject']?></span><?=$subject_data['marks_obtained']?></li>
                <?php
                if($i % 3 == 0 ){
                    echo "</ul>";
                }
                $i++;
                $total_marks = $total_marks+$subject_data['total_marks'];
                $total_obtain = $total_obtain+$subject_data['marks_obtained'];
            }

                ?>

        </div>
        <div class="info_st">
            <ul>
                <li class="col-sm-4"><span>Total Marks</span>
                    <p class="obtain_m"><?=$total_marks?></p>
                </li>
                <li class="col-sm-4"><span>Marks Obtained</span>
                    <p class="obtain_m"><?=$total_obtain?></p>
                </li>
            </ul>
        </div>
    </div>
    <?php
}
?>

