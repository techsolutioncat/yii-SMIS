<?php

 
foreach(array_filter(glob('*'), 'is_dir') as $d){
  $cmd='cd /var/www/html/'.$d.' &&  php yii hello/stu';
$output =shell_exec($cmd);
echo "<pre>$output</pre>";
}
 ob_end_clean(); 
 ?>

