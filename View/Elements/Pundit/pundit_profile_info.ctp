<?php if (!$this->request->is('ajax')) : ?>
<div class="main_content">
  <?php endif; ?>
  <div class="person_box">
    <div class="person_row">
      <div class="per_block">
        <div class="per_img">
          <?php 
          $imgPath = $this->PT->setImage($userInfo['User']['avatar'], $userInfo['User']['fb_id']);
          echo $this->Html->image($imgPath, array('alt' => '', 'class' => 'img6464'));
          ?>
        </div>
        <div class="per_info">
          <?php
          $score = null;
          if ($this->Session->read('Auth.User.userGroup') == 'Admin') {
            $score = " ($".(float)$userInfo['Pundit']['score'].")";
          }
          ?>
            <div class="per_name"><?php echo $userInfo['User']['first_name'].' '.$userInfo['User']['last_name'];?> <span class="noBold"><?php echo $score; ?> </span></div>
        </div>
      </div><!--end of per_block-->

      <div class="person_grade">
          <?php
          $gradeClass = "per_grade";
          $gradeSuffix = '';
          if ($userInfo['Pundit']['calls_graded'] < Configure::read('minimum_call_grade_limit')) {
            $gradeClass = "per_grade gradeBox";
            Configure::write('getAsterisk', '<sup>*</sup>');
            $gradeSuffix = Configure::read('getAsterisk');
          }
          ?>
        <div class="<?php echo $gradeClass; ?>">
          <?php
          $grade = $this->PT->getGrade($userInfo['Pundit']['score'], $userInfo['Pundit']['calls_graded']);
          
          if ($grade != 'TBD') {
            echo $gradeSuffix;
            echo $grade;
          }
          else {
            echo $this->Html->image('fea_grade.png', array('alt' => 'TBD'));
          } 
          ?>
        </div>
        <?php if (empty($gradeSuffix)) { ?>
          <span class="ico_info" title="Letter grade (A-F) based on the pundit's $1 Yield, which reflects both accuracy and boldness. C is average and means the pundit’s predictions have been no better or worse than the consensus view."></span>
        <?php } else { ?>
          <span class="ico_info" title="<?php echo Configure::read('asteriskDefinition'); ?>"></span>
        <?php } ?>
      </div><!--end of person_grade-->
    </div><!--end of person_row-->

    <div class="person_cont">
        <p><?php echo nl2br($userInfo['User']['biography']); ?></p>
    </div><!--end of person_cont-->

    <div class="person_detail">
      <div class="detail_row detail_row_first"><strong>Tracked Since: </strong>
      <?php
        $tracked = ($userInfo['tracked']) ? date('F Y', strtotime($userInfo['tracked'])) : '';
        echo $tracked;
      ?>
       </div>
      <div class="detail_row">
        <div class="detail_col1"><strong>Predictions Graded:</strong><br><?php echo $userInfo['Pundit']['calls_graded']; ?></div>
        <div class="detail_col2"><strong>Correct Predictions:</strong><br><?php echo $userInfo['Pundit']['calls_correct']; ?></div>
      </div>
      <div class="detail_row detail_row_last">
        <div class="detail_col1">
          <strong>Hit Rate:</strong>
          <span class="ico_info" title="Correct Calls / Calls Graded"></span><br>
          <?php echo $this->PT->hitRate($userInfo['Pundit']['calls_correct'], $userInfo['Pundit']['calls_graded']).'%'; ?>
        </div>
        <div class="detail_col2">
          <strong>Yield:</strong>
          <span class="ico_info" title="Average payout had you placed $1 bets on each of the pundit’s predictions; based on consensus odds at the time of the prediction."></span><br><?php
            $score = (null != $userInfo['Pundit']['score']) ? $userInfo['Pundit']['score'] : 0;
            echo '$'.$score;
          //echo $this->PT->avgBoldness($userInfo['Pundit']['avg_boldness'], $userInfo['Pundit']['calls_correct']); ?>
        </div>
      </div>
    </div><!--end of person_detail-->
  </div><!--end of person_box-->
  <?php if (!empty($gradeSuffix)) : ?>
    <div class="asteriskDef"><?php echo "NOTE : Asterisk (&#8727;) and ".Configure::read('asteriskDefinition'); ?></div>
  <?php endif; ?>
  <?php if (!$this->request->is('ajax')) : ?>
  <br>
 
  <?php  ?>
  <div class="predictions_blockholder">
    <?php 
    echo $this->element('Pundit/best_worst_prediction', array('UserId' => $userInfo['Pundit']['user_id']));?>
  </div>
</div><!--end of main_content-->
<?php endif; ?>

