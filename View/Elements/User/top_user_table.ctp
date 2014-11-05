
    <table class="table_box table_box4" id='userProfileLiveTable'>
      <tr>
          <th class="col1"><span><?php echo 'Rank';?></span></th>
          <th class="col2"><span><?php echo  'Name';?></span></th>
          <th class="col5"><span><?php echo  '# Graded';?></span></th>  
          <th class="col4"><span><?php echo '# Correct';?></span></th>
          <th class="col4"><span><?php echo  'Hit Rate';?></span></th>
          <th class="col6"><span><?php echo '$Earned';?></span></th>
          <th class="col6"><span><?php echo 'Yield';?></span></th>
          <th class="last col5"><span>Grade</span></th>
      </tr>
      <?php  
        $count = count($topUsersTable);
        $index = 1;
        foreach($topUsersTable as  $key => $user) {
          $class = '';
          if (($key % 2) == 0) {
            $class = 'odd';
          } 
      ?>
      <tr class="<?php echo $class; ?>">
          <td class="td_center"><?php echo $index++;?></td>
          <td class="preFirst"> 
            <?php
              echo $this->Html->link(
                $user['User']['first_name']. ' ' .$user['User']['last_name'],
                array(
                    'controller' => 'users',
                    'action'=> 'profile',
                      $user['User']['id']
                )
              );
       
        ?></td>
          <td class="td_center"><?php echo $user['User']['calls_graded'];?></td>
          <td class="td_center"><?php echo $user['User']['calls_correct'];?></td>
          <td class="td_center"><?php echo number_format($user[0]['hitrate'],0)."%";?></td>
          <td class="td_center"><?php echo "$".number_format($user[0]['earned'],2);?></td>
          <td class="td_center"><?php echo "$".number_format($user['User']['score'], 2);?></td>
          <td class="td_center last"><?php echo $this->PT->getGrade($user['User']['score'], $user['User']['calls_graded']);?></td>
      </tr>
     <?php } ?>
    </table>