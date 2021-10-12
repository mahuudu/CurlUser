<table  class="table">
  <tr>
    <th>Username</th>
    <th>fullname</th>
    <th>birth_of_day</th>
  </tr>
  <?php
    foreach($listData as $item){ ?>
    <tr>
        <td><?php echo $item['username']?></td>
        <td><?php echo $item['fullname']?></td>
        <td><?php echo $item['birth_of_day']?></td>
    </tr>
    <?php     
        }
    ?>
</table>