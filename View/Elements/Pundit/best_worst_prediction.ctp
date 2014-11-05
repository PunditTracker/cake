<?php 
$voteObj = ClassRegistry::init('Pundit');
$bestWorstPredictions = $voteObj->bestWorstPredictions($UserId);
//debug($bestWorstPredictions);
?>
<div class="predic_blocks best">
  <h1>Best Predictions
  <span class="ico_info" title="Boldest predictions that turned out correct. For financial market predictions (e.g. stocks), “best” predictions are the picks with the highest returns."></span>
  </h1>
  <ol>
      <?php 
      $index = 1;
      $count = count($bestWorstPredictions);
      if(!empty($bestWorstPredictions)) {
        foreach($bestWorstPredictions['best'] as  $key => $user) {
          if ($key + 1 == $count) {
            $lastItem = true;
          }
        ?>
        <li <?php if (!empty($lastItem)) echo 'class="last-top-user"' ?>>
          <div class="order" id="user<?php echo $index; ?>"><?php echo $index++; ?>.</div>
            <div class="txt">
              <?php
                echo $user['Call']['prediction'];
              ?>
            </div>
            <div class="date">
              <?php
              echo  date('m-d-Y', strtotime($user['Call']['created']));
               
              ?>
              
            </div>
            <div class="icon"><?php echo $this->Html->image('ico_right2.png', array('alt' => 'rightimg'));?></div>
          </li>
        <?php } 
      }?>
  </ol>
</div>

<div class="predic_blocks">
  <h1>Worst Predictions <span class="ico_info" title="Boldest predictions that turned out incorrect. For financial market predictions (e.g. stocks), “worst” predictions are the picks with the lowest returns.

** We recognize that boldness is not the best barometer for ‘worst’ since it does capture the magnitude of error (how wrong the prediction was). We are looking for objective ways of measuring this; if you have a suggestion, please send us a note.
"></span></h1>

  <ol>
      <?php 
      $index = 1;
      $count = count($bestWorstPredictions);
      if(!empty($bestWorstPredictions)) {
        foreach($bestWorstPredictions['worst'] as  $key => $user) {
          if ($key + 1 == $count) {
            $lastItem = true;
          }
        ?>
          <li <?php if (!empty($lastItem)) echo 'class="last-top-user"' ?>>
            <div class="order" id="user<?php echo $index; ?>"><?php echo $index++; ?>.</div>
              <div class="txt">
                <?php
                  echo $user['Call']['prediction'];
                ?>
              </div>
              <div class="date">
                <?php
                echo  date('m-d-Y', strtotime($user['Call']['created']));
                 
                ?>
                
              </div>
              <div class="icon"><?php echo $this->Html->image('ico_wrong2.png', array('alt' => 'Wrongimg'));?></div>
            </li>
        <?php
        } 
      }?>
  </ol>
</div>