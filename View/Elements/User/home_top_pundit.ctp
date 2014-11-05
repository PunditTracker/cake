<div class="block">
  <?php if (!empty($categoryId) && $categoryId == 'all') { ?>
    <div class="title_row2">
  <?php } else { ?>
    <div class="title_row">
  <?php } ?>
    <h1>featured pundits</h1>
  </div>

  <ol class="featured_pundits_list">
    <?php
    if(!empty($topPundit)) { 
      $index = 1;
      if ($this->params['controller'] == 'pundits') {
        $categoryName = $topPundit['Category']['name'];
        $topPundit = $topPundit['Pundit']; 
      } 
      foreach($topPundit as $pundit) : 
      ?>
      <li>
        <div class="fea_order"><?php echo $index++; ?></div>
        <div class="fea_img">
          <?php
          $imgPath = $this->PT->setImage($pundit['User']['avatar'], $pundit['User']['fb_id']);
          echo $this->Html->image($imgPath, array('alt' => '', 'height' => 40, 'width' => 40));
          ?>
        </div>
        <div class="fea_txt">
          <?php
          echo $this->Html->link($pundit['User']['first_name']. ' ' .$pundit['User']['last_name'], array(
            'controller' => 'pundits',
            'action' => 'profile',
            $pundit['User']['slug'] ), array('class' => '')
          ); ?>
          <span><?php
          if ($this->params['controller'] == 'pundits') { 
            echo $categoryName;
          } else {
            echo $pundit['Category'][0]['name'];
          }
            ?></span>
        </div>
        <?php
          $gradeClass = "";
          $gradeSuffix = '';
          if ($this->params['controller'] == 'pundits') {
            $callGraded = $pundit['calls_graded'];
          } else {
            $callGraded = $pundit['Pundit']['calls_graded'];
          }
          if ($callGraded < Configure::read('minimum_call_grade_limit')) {
            $gradeClass = "gradeBox";
            Configure::write('getAsterisk', '<sup>*</sup>');
            $gradeSuffix = Configure::read('getAsterisk');
          }
        ?>
        <div class="fea_grade user_pundit_grade <?php echo $gradeClass; ?>">
          <?php
          if ($this->params['controller'] == 'pundits') {
            $score = $pundit['score'];
          } else {
            $score = $pundit['Pundit']['score'];
          }
          $grade = $this->PT->getGrade($score, $callGraded);
          
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
    <?php endforeach;  } ?>
  </ol>

</div>
