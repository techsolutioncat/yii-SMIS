
<table class="table table-striped">
    <thead>
      <tr>
        <th>Student Name</th>
        <th>Zone</th>
        <th>Route</th>
        <th>Stop</th>
        <th>Fare</th>
      </tr>
    </thead>
    <tbody>
    <?php foreach ($transport as $transports) {
   //echo '<pre>';print_r($withdrawlStud);
    ?>
      <tr>
        <td><?= $transports['student_name'] ?></td>
        <td><?= $transports['zone_name'] ?></td>
        <td><?= $transports['route_name'] ?></td>
        <td><?= $transports['stop_name'] ?></td>
        <td><?= $transports['fare'] ?></td>
      </tr>
      <?php } ?>
    </tbody>
  </table>
