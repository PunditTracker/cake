<?php $this->set('title_for_layout', __('PunditTracker | Tracking Predictions in Sports, Finance &amp; Politics')); ?>
<div class="breadcrum">
  <?php
  echo $this->Html->link(
    __('home'),
    array(
      'controller' => 'users',
      'action' => 'home',
      'admin' => false
    ),
    array()
  );
  ?> &raquo;
  <span>ABOUT</span>
</div><!--end of breadcrum-->

<div class="title_row">
    <h1>ABOUT</h1>
</div><!--end of title_row-->

<div class="main_content">
  <h2>What is PunditTracker?</h2>
  <p>PunditTracker’s mission to introduce accountability to the prediction industry.</p>
  <p>The incentives in punditry today are all wrong, which results in hits (correct
    predictions) being reported far more frequently than misses (incorrect predictions).</p>
  <p>A pundit simply has to use the following playbook:
    <ol class="ol_list">
      <li>make a bold prediction</li>
      <li>if wrong – keep quiet; don’t worry, no one will remember</li>
      <li>if right – self promote, write a book, go on TV, etc</li>
      <li>repeat</li>
    </ol>
  </p>
  <p>All upside and no downside. If only all our jobs were like that!</p>
  <p>PunditTracker seeks to change the game by playing the role of public scorekeeper.
    We will catalog and score the predictions of various types of pundits, starting
    with the following: Financial, Political, Sports, and Entertainment. Pundits who
    demonstrate a track record of making of accurate, out-of-consensus predictions will
    appropriately receive their due. Meanwhile, those who are bombastic solely to
    garner media attention will be exposed, no longer able to free ride off of inflated
    reputations.</p>
  <p>Grading professional pundits is only half the PunditTracker story. The other half
    is grading users such as yourself. We are providing users a platform with which
    to make their own predictions (more on the mechanics below). We have little
    reason to believe the best pundits are the mainstream ones on television each day
    -- in fact, there are reasons to believe they are the worst! By leveling the playing
    field between &quot;pundits&quot; and &quot;users,&quot; we hope to introduce a much-needed dose of
    meritocracy into the system.</p>
  <p>For a more comprehensive take on what we are trying to accomplish, see our blog
    post:</p>
  <p><a href="http://blog.pundittracker.com/why-the-prediction-industry-must-be-disrupted/" target="_blank">Why The Prediction Industry Must Be Disrupted</a></p>

  <h2>Explain this &quot;User Voting&quot; idea to me</h2>
  <p>When a pundit makes a prediction, we allow users to &quot;vote&quot; on the likelihood of that
    prediction occurring by clicking the &quot;Vote Now&quot; button.</p>
  <p>This serves two purposes:
    <ol class="ol_list">
      <li>We grade predictions on an odds-adjusted basis, and the collective user vote
          provides the information needed to set the consensus odds (more details provided
          in the &quot;How does your scoring system work?&quot; question below)</li>
      <li>When you vote on the likelihood of a pundit’s prediction, you are effectively
          making a prediction of your own. This enables us to grade you the exact same way
          we grade pundits.</li>
    </ol>
  </p>
  <p>The three best-performing users each year will become Featured Pundits on the
    website.</p>
  <p>For more details on how the User Voting works, see this post:</p>
  <p><a href="http://blog.pundittracker.com/how-user-voting-works-aka-how-to-become-a-featured-pundit/" target="_blank">How User Voting Works (aka How To Become A Featured Pundit!)</a></p>
  <p>If you have read enough and want to start making predictions now, here are all the
    predictions currently open for voting:</p>
  <p><?php echo $this->Html->link('All Predictions Open For Voting', array('controller' => 'categories', 'action' => 'view', 'all'));?></p>

  <h2>How does your scoring system work?</h2>
  <p>The traditional method to score pundits employs what’s called a &quot;hit rate&quot; or
    &quot;batting average&quot; approach: take the number of correct predictions and divide it by the
    number of total predictions. Make ten predictions and get seven right, and the hit rate is 70%. The
    problem is that this figure is useless without context. The daily prediction &quot;the sun
    will rise tomorrow&quot; would (hopefully) yield a perfect hit rate, after all.</p>
  <p>Our solution is to calibrate each prediction for boldness. We measure this by asking
    our users how likely they think a given prediction is to occur. If everyone says
    &quot;unlikely,&quot; then the predictions is bold, and the pundit, if correct, should receive more credit
    than he would for a called deemed &quot;likely&quot;. This moment-in-time gauge of consensus
    opinion underpins our scoring algorithm.</p>
  <p>Based on consensus odds, we are able to calculate the &quot;$1 Yield&quot; for each pundit.
    This metric measures the average payout had you bet $1 on each of the pundit’s
    predictions, based on consensus odds at the time, A yield of exactly $1.00, for
    instance, means the pundit’s predictions were no better or worse than the
    consensus view at the time. Pundits who have made at least 25 graded predictions are
    awarded a letter grade (A through F range, C being average) based on this boldnessadjusted accuracy metric.</p>

  <h2>Are your grades predictive?</h2>
  <p>Our grades are solely based on a pundit’s historical predictions; think of them
    as a report card. Whether or not they speak to the accuracy of a pundit’s future
    predictions is predicated on how much skill there is in punditry. If forecasting is purely
    a game of luck, for instance, then our pundit grades will ultimately revert to the
    mean. Put differently, our grades would be a contra-indicator: both A-grade and Fgrade pundits would revert to a C grade. We do not yet have an informed view on
    this matter but anticipate that the data we gather over time will help answer the
    question. Regardless, by playing the role of public scorekeeper, we hope we can help
    correct any mismatches between a pundit’s reputation and track record.</p>

  <h2>What’s the best way to learn about new pundit predictions?</h2>
  <p>Come visit the site each day! We also can deliver the information straight to you: you
    can follow us on <a href="https://www.facebook.com/pundittracker" target="_blank">Facebook</a> and on
    <a href="http://twitter.com/pundittracker" target="_blank">Twitter</a> (<a href="http://twitter.com/pundittracker" target="_blank">@pundittracker</a>).</p>
  <p>If you prefer only to follow predictions in a given category, we have specific Twitter
    handles for each one. Within the relevant category, these feeds will post each new
    prediction as well as outcomes for predictions that come due.</p>
  <p>Finance: <a href="http://twitter.com/ptraxfinance" target="_blank">@ptraxfinance</a><br/>
    Politics: <a href="http://twitter.com/ptraxpolitics" target="_blank">@ptraxpolitics</a><br/>
    Sports: <a href="http://twitter.com/ptraxsports" target="_blank">@ptraxsports</a><br/>
    Entertainment: <a href="http://twitter.com/ptraxentertain" target="_blank">@ptraxentertain</a></p>

  <h2>How can I help?</h2>
  <p>We thought you would never ask! While we are ramping up the number of pundits
    and predictions tracked on PunditTracker, we readily admit that there are many
    more to catalog. So the next time you see a prediction on television, hear one on
    the radio, or read one on the Internet, take a second to send it our way to track and
    ultimately score (use the &quot;Help Us Track&quot; form on the Home Page). With your voice
    and our platform, we can finally bring accountability to the prediction industry.</p>
  <p>If you would like to become involved with PunditTracker in a more &quot;formal&quot;
    capacity, see our blog post:</p>
  <p><a href="http://blog.pundittracker.com/help-needed-moderators-trackers/" target="_blank">Help Wanted: Moderators &amp; Trackers</a></p>
</div><!--end of main_content-->



<?php echo $this->element('Common/static_side_bar'); ?>
