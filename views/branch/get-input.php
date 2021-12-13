<?php $rows = empty($_POST['rows']) ? 0 : (int)$_POST['rows'] ; 
//echo count($_POST['rows']);
?>


<?php if(0 !== $rows): ?>
    
	<?php 

    foreach(range(1, $rows) as $row): ?>
          
                
            <!--  <p> <?php //echo count($row); ?></p>  -->
            <!-- Create a PHP array compatible set of inputs, using $row as the index -->
            <div class="row">
            <div class="col-md-6">
            	<br />
            <!-- <?php // echo $row; ?> -->
            <input type="text" name="RefClass[title][]" class="form-control classex" id="inputClas" style="margin-left: 14px;" />
            </div>
            <div class="col-md-6">
            
            </div><br />
           
          </div>
        <?php endforeach; ?>
   
      <?php endif; ?>