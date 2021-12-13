<?php $rows = empty($_POST['rows']) ? 0 : (int)$_POST['rows'] ; ?>

<?php if(0 !== $rows): ?>
	<?php 

  foreach(range(1, $rows) as $key=> $row): ?>
          <div>
            <!-- <p>Class <?php echo $row; ?></p> -->
            <!-- Create a PHP array compatible set of inputs, using $row as the index -->
            <div class="row">
            <div class="col-md-5">
            <br />
            <input type="text" name="FeePaymentMode[title][]" class="form-control mode" style="margin-left: 15px;" />
            
            
             
            </div>
            <br />
            <div class="col-md-5">
             <select id="feepaymentmode-time_span" name="FeePaymentMode[time_span][<?php echo $key;?>]" class="form-control timespan">
              <option value="">Select No. of month(s)</option>
              <option value="1">1 month</option>
              <option value="2">2 months</option>
              <option value="3">3 months</option>
              <option value="4">4 months</option>
              <option value="5">5 months</option>
              <option value="6">6 months</option>
              <option value="7">7 months</option>
              <option value="8">8 months</option>
              <option value="9">9 months</option>
              <option value="10">10 months</option>
              <option value="11">11 months</option>
              <option value="12">12 months</option>
            </select>
            <br />
            <!-- <?php // echo $row; ?> -->
            </div><br />
            </div>
          </div>
        <?php endforeach; ?>
      <?php endif; ?>