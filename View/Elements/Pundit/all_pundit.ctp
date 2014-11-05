
<?php
if(!isset($trType)){
  $trType = '';
}
$class = $trType;
if (($counter%2)) {
  $class = 'odd '.$trType;
}
?>
<tr class="<?php echo $class;?>">
  <td class="td1">
    <?php
     echo $this->Html->link($userData['first_name']. ' ' .$userData['last_name'], array('controller' => 'pundits', 'action' => 'profile', $userData['slug']), array());
    ?>
  </td>
    <?php
      $gradeClass = "";
      $gradeSuffix = '';
      if ($punditData['calls_graded'] < Configure::read('minimum_call_grade_limit')) {
        $gradeClass = "gradeText";
        Configure::write('getAsterisk', '*');
        $gradeSuffix = Configure::read('getAsterisk');
      }
      $grade = $this->PT->getGrade($punditData['score'], $punditData['calls_graded']);
      ?>
  <td class="<?php echo $gradeClass; ?>">
    <?php 
      if ($grade != 'TBD') {
        echo $gradeSuffix;
        echo $grade;
      }
      else {
            echo $this->Html->image('tbd_grey.png', array('alt' => 'TBD'));
          } ?>
   </td>
</tr>