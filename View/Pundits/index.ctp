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
  <span>
  <?php
  echo $this->Html->link(
    __('all pundits'),
    array(
      'controller' => 'pundits',
      'action' => 'index',
      'admin' => false
    ),
    array()
  );
  ?>
  </span>
</div><!--end of breadcrum-->

<div class="title_row">
    <h1>all pundits</h1>
    <?php
    if ($this->Session->read('Auth.User.userGroup') == 'Admin') {
      $callSuggestionId = 'suggestCallBoxByAdmin';
    } else {
      $callSuggestionId = 'suggestCallBox';
    }
    echo $this->Html->link(
      '<span>help us track</span>',
      '',
      array(
        'class' => 'btn',
        'escape' => false,
        'id' => $callSuggestionId
      )
    );
    ?>
</div><!--end of title_row-->

  <?php foreach ($allCategoriesData as $punditData) :  ?>

    <div class="table_holder">
      <div class="title_row title_row2">
        <h1><?php echo $punditData['Category']['name']; ?> pundits being tracked</h1>
      </div><!--end of title_row-->
      <?php
      $m = $n = $k = $l = 0;
      $numberOfUser = count($punditData['User']);
      foreach($punditData['User'] as $userData) {
        $punditData = $userData['Pundit'];
        $userData = $userData['User'];
        $lastNameStartsWith = strtolower($userData['last_name'][0]);

        if ($lastNameStartsWith <= 'h') {

          if ($m == 0) {
          ?>
          <table class="table_col">
            <tr>
              <th class="th1">Pundits (A - H)</th>
              <th class="th2">Grade</th>
            </tr>
          <?php
          }
          $m++;

          $option = array(
            'counter' => $m,
            'userData' => $userData,
            'punditData' => $punditData
          );
          echo $this->element('Pundit/all_pundit', $option);

        } else if ('i' <= $lastNameStartsWith && 'p' >= $lastNameStartsWith) {

          if ($n == 0) {
          ?>
          </table>
          <table class="table_col">
            <tr>
              <th class="th1">Pundits (I - P)</th>
              <th class="th2">Grade</th>
            </tr>
          <?php
          }
          $n++;
          $option = array(
            'counter' => $n,
            'userData' => $userData,
            'punditData' => $punditData
          );
          echo $this->element('Pundit/all_pundit', $option);

        } else if ('q' <= $lastNameStartsWith && 'z' >= $lastNameStartsWith) {

          if ($k == 0) {
          ?>
          </table>
          <table class="table_col last_table_col">
            <tr>
              <th class="th1">Pundits (Q - Z)</th>
              <th class="th2">Grade</th>
            </tr>
          <?php
          }
          $k++;

          $option = array(
            'counter' => $k,
            'userData' => $userData,
            'punditData' => $punditData
          );
          echo $this->element('Pundit/all_pundit', $option);

        }

        $l++;
        if ($l == $numberOfUser) {
          ?>
          </table>
          <?php
        }
      }
      ?>
      <div class="clear"></div>
    </div><!--end of table_holder-->
  <div class="line">line</div>
<?php endforeach; ?>
