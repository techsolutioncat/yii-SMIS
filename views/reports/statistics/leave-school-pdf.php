<?php 
  use yii\helpers\Url;
 
 ?> 
  <style>
th, tr, td  {
border:1px solid #469DC8;
padding:10px;
font-size:1.5em;
}

tr:nth-child(even){background-color: #f2f2f2}
</style>    

          
                  <table class="table table-striped" align="center">
                          <thead>
                          <tr>
                          <th>SR</th>
                          <th>Total students issued SLC</th>
                          </tr>
                          </thead>
                          <tbody>
                           <tr>
                                <td><?php echo '1'; ?></td>
                                <td><?php echo $leaveInfo; ?></td>
                           </tr>
                           </tbody>
                   </table>
                     