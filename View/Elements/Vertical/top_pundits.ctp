<div class="block">
  <div class="title_row2">
    <h1>featured pundits</h1>
  </div>

  <ol class="featured_pundits_list">
    <?php
    $index = 1;
    foreach($topPundit['Pundit'] as $pundit) {
    ?>
    <li>
      <div class="fea_order" id="pundit<?php echo $index; ?>"><?php echo $index++; ?></div>
      <div class="fea_img">
        <?php
        $imgPath = $this->PT->setImage($pundit['User']['avatar'], $pundit['User']['fb_id']);
        echo $this->Html->image($imgPath, array('alt' => '', 'class' => 'img4040'));
        ?>
      </div>
      <div class="fea_txt">
        <?php
        echo $this->Html->link(
          $pundit['User']['first_name']. ' ' .$pundit['User']['last_name'],
          array(
            'controller' => 'pundits',
            'action'=> 'profile',
            $pundit['User']['slug']
          )
        );
        ?>
        <span><?php echo $topPundit['Category']['name']; ?></span>
      </div>
        <?php
          $gradeClass = "";
          $gradeSuffix = '';
          if ($pundit['calls_graded'] < Configure::read('minimum_call_grade_limit')) {
            $gradeClass = "gradeBox";
            Configure::write('getAsterisk', '<sup>*</sup>');
            $gradeSuffix = Configure::read('getAsterisk');
          }
        ?>
      <div class="fea_grade user_pundit_grade <?php echo $gradeClass; ?>">
        <?php
        $grade = $this->PT->getGrade($pundit['score'], $pundit['calls_graded']);
        
        if ($grade != 'TBD') {
          echo $gradeSuffix;
          echo $grade;
        }
        else {
          echo $this->Html->image('fea_grade.png', array('alt' => 'TBD'));
        }
        ?>
      </div>
    </li>
    <?php } ?>
  </ol>
</div>
