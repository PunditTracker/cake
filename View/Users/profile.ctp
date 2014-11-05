<div id="shareFacebook">
  <div class="userPunditResult">
    <div class="comparison">

      <div class="heading"><h2><?php echo $response['data']['Call']['prediction'];?></h2></div>
      <hr>
      <div class="box">
        <div class="userVsPundit">
          <div class='punditImg'>
            <?php
            $imgPath = $this->PT->setImage($response['data']['User']['avatar']);
            echo $this->Html->image($imgPath, array('alt' => '', 'class' => 'img6464'));
            ?>
            <div class="nameBox">
              <?php
              $punditName = ucwords($response['data']['User']['first_name']. ' ' .$response['data']['User']['last_name']);
              echo $punditName. ' predicted...';?>
            </div>
            <div class="userTalk">
              <strong>
                <?php echo $response['data']['Call']['prediction'];?>
              </strong>
            </div>
          </div>
          <div class="centerSign"><?php echo $this->Html->image('vs-arrow.png');?></div>
          <div class ='userImg'>
            <?php
            $imgPath = $this->PT->setImage($response['User']['avatar'], $response['User']['fb_id'], 'large');
            echo $this->Html->image($imgPath, array('alt' => '', 'class' => 'img6464'));
            ?>
            <div class="nameBox">
              <?php
              echo ucwords($response['User']['first_name']. ' ' .$response['User']['last_name']). ' said...';?>
            </div>
            <div class="userTalk">
              <strong>
                <?php $userVote = configure::read('radio_vote_option');
                  echo $userVote[$response['data']['Vote'][0]['rate']];
                ?>
              </strong>
            </div>
          </div>
        </div>
        <div class="outcome">
          <?php
            $outcomeSign = $this->PT->outcomeSign($response);
            $text = $class = null;
            if ($outcomeSign['outcomePundit'] == 'TBD') {
              $text = $outcomeSign['outcomePundit'];
            } else {
              $class = $outcomeSign['outcomePundit'];
            }
          ?>
          <div id ="top" class="<?php echo $class?>"><?php if($text == "TBD") {
                                                                echo $this->Html->image('tbdb.png', array('alt' => 'TBD'));
                                                                } else {
                                                                  echo $text;
                                                                }
          ?></div>
          <div>----&nbsp;<strong>Outcome</strong>&nbsp;----</div>
          <?php
            $text = $class = null;
            if ($outcomeSign['outcomeUser'] == 'TBD') {
              $text = $outcomeSign['outcomeUser'];
            } else {
              $class = $outcomeSign['outcomeUser'];
            }
          ?>
          <div id ="bottom" class="<?php echo $class?>"><?php if($text == "TBD") {
                                                                echo $this->Html->image('tbdb.png', array('alt' => 'TBD'));
                                                                } else {
                                                                  echo $text;
                                                                }
           ?></div>
        </div>
      </div>
    </div>
    <div class="resultBox">
      <?php
      $resultMsg = $this->PT->resultMessage($response['data']['Call']['outcome_id'], $response['data']['Outcome']['rating'], $response['data']['Vote'][0]['rate'], $punditName);
      ?>
      <div class="userStatus">
        <?php if($resultMsg == "TBD") {
               echo $this->Html->image('tbdblue.png', array('alt' => 'TBD'));
              } else {
                  echo $resultMsg;
              }?>
      </div>
    </div>
    <?php
      $thisUrl = 'http://'.$this->request->domain(2).'/users/profile/'.$slug."/$predictionSlug";
      $twitterText = "Prediction: '".$userVote[$response['data']['Vote'][0]['rate']]."' on '".$response['data']['Call']['prediction']."' (".ucwords($response['data']['User']['first_name']. " " .$response['data']['User']['last_name']).")";
    ?>
    <div style="float:right;">
      <a href="https://twitter.com/share?text=<?php echo $twitterText; ?>" class="twitter-share-button" data-lang="en">Tweet</a>
      <script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="https://platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
    </div>
    <?php
      echo $this->element('Common/facebook_share', array('url' => $thisUrl));
    ?>
  </div>
  <div class="right-panel">
    <?php
    if ($this->Session->read('Auth.User.id') == null) {
      echo $this->Html->link(
      $this->Html->image("can-you-beath-the-experts.png", array("alt" => "")),
      "#signup",
      array('escape' => false, 'class' => 'signup'));
    } else {
      echo $this->Html->image("can-you-beath-the-experts.png");
    }
    ?>
  </div>
</div><!--end #main -->
