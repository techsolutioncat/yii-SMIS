<?php $rows = empty($_POST['rows']) ? 0 : (int)$_POST['rows'] ; ?>

<?php if(0 !== $rows): ?>
	<?php foreach(range(1, $rows) as $key => $row): ?>
          <div>
            <!-- <p>Class <?php echo $row; ?></p> -->
            <!-- Create a PHP array compatible set of inputs, using $row as the index -->
            <div class="row">
            <div class="col-md-6">
            	<br />
            <!-- <?php // echo $row; ?> -->
            <input type="text" name="FeePlanType[title][]" class="form-control typesfee" id="feeplanstu" />
            </div> <br /> 
            <div class="col-md-6">
            <select id="feeplantype-no_of_installments" name="FeePlanType[no_of_installments][<?php echo $key; ?>]" class="form-control instal">
                <option value="">Select Installments</option>
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="4">4</option>
                <option value="5">5</option>
                <option value="6">6</option>
                <option value="7">7</option>
                <option value="8">8</option>
                <option value="9">9</option>
                <option value="10">10</option>
                <option value="11">11</option>
                <option value="12">12</option>
            </select>
            </div><br />
            </div>
          </div>
        <?php endforeach; ?>
      <?php endif; ?>