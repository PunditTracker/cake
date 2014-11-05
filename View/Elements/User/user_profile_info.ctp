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
        <?php
          $score = null;
          if ($this->Session->read('Auth.User.userGroup') == 'Admin') {
            $score = " ($".(float)$userInfo['User']['score'].")";
          }
          ?>
        <div class="per_info">
            <div class="per_name"><?php echo $userInfo['User']['first_name'].' '.$userInfo['User']['last_name']; ?><span class="noBold"><?php echo $score; ?> </span></div>
        </div>
      </div><!--end of per_block-->

      <div class="person_grade">
         <?php
          $gradeClass = "per_grade";
          $gradeSuffix = '';
          if ($userInfo['User']['calls_graded'] < Configure::read('minimum_call_grade_limit')) {
            $gradeClass = "per_grade gradeBox";
            Configure::write('getAsterisk', '<sup>*</sup>');
            $gradeSuffix = Configure::read('getAsterisk');
          }
          ?>
        <div class="<?php echo $gradeClass; ?>">
          <?php
          $grade = $this->PT->getGrade($userInfo['User']['score'], $userInfo['User']['calls_graded']);
          echo $grade;
          if ($grade != 'TBD') {
            echo $gradeSuffix;
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
        <p><?php echo nl2br($userInfo['User']['biography']);?></p>
    </div><!--end of person_cont-->

    <div class="person_detail">
      <div class="detail_row detail_row_first"><strong>Tracked Since: </strong><?php echo !empty($userInfo['tracked']) ? date('F Y', strtotime($userInfo['tracked'])) : '';?></div>
      <div class="detail_row">
        <div class="detail_col1"><strong>Predictions Graded:</strong><br><?php echo $userInfo['User']['calls_graded'];?></div>
        <div class="detail_col2"><strong>Correct Predictions:</strong><br><?php echo $userInfo['User']['calls_correct'];?></div>
      </div>
      <div class="detail_row">
        <div class="detail_col1">
          <strong>Hit Rate:</strong>
          <span class="ico_info" title="Correct Calls / Calls Graded"></span><br>
          <?php echo $this->PT->hitRate($userInfo['User']['calls_correct'], $userInfo['User']['calls_graded']).'%'; ?>
        </div>
        <div class="detail_col2">
          <strong>Yield:</strong>
          <span class="ico_info" title="Average payout had you placed $1 bets on each of the pundit’s predictions; based on consensus odds at the time of the prediction."></span><br><?php        
          $score = (null != $userInfo['User']['score']) ? $userInfo['User']['score'] : 0;
            echo '$'.$score; 
          // echo $this->PT->avgBoldness($userInfo['User']['avg_boldness']); ?>
        </div>        
      </div>
      <div class="detail_row detail_row_last">
        <div class="ranking">
          <?php echo "<strong>Earned</strong>: $".number_format($earned[0][0]['earned'],2);?>
        </div>
        <div class="ranking">
         <strong>Ranking:</strong> <?php echo $ranking['rank']; ?> out of <?php echo $ranking['totalUser']; ?>  users**
        </div>        
      </div>
    </div><!--end of person_detail-->
  </div><!--end of person_box-->
  <?php if (!empty($gradeSuffix)) : ?>
    <div class="asteriskDef">
      <?php echo "NOTE : Asterisk (&#8727;) and ".Configure::read('asteriskDefinition'); ?>      
    </div>
  <?php endif; ?>
  <div>
    <?php printf('** %d users have at least ten graded votes inside Pundit Tracker.', $ranking['totalUser']);?>
  </div>
  <?php if (!$this->request->is('ajax')) : ?>
 
</div><!--end of main_content-->
<?php endif; ?>

