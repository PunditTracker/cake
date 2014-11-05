<?php foreach ($allCategoriesData as $punditData) :  ?>

    <div class="table_holder">
      <div class="title_row title_row2">
        <h1><?php echo $punditData['Category']['name']; ?> pundits being tracked</h1>
        <?php
        //if ($this->Session->read('Auth.User')) {
  	      echo $this->Html->link(
  	        '<span id="allPunditsLink">View All Pundits</span>',
  	        array(
  	          'controller' => 'pundits',
  	          'action' => 'index',
  	          'admin' => false
  	        ),
  	        array(
  	          'class' => 'btn shift-left',
  	          'escape' => false
  	        )
  	      );
  	    //}
	    ?>
      </div><!--end of title_row-->
      <?php

      $tempPunditData = $punditData;
      $m = $n = $k = $l = 0;
      $numberOfUser = count($punditData['User']);
      foreach($punditData['User'] as $key => $userData) {

        //for last row of all table
        $nextLastNameStartsWith = null;
        if (isset($tempPunditData['User'][$key+1]['User']['last_name'])) {
          $nextLastNameStartsWith = strtolower($tempPunditData['User'][$key+1]['User']['last_name'][0]);
          $trType = '';
        } else {
          $trType = 'last';
        }

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


          //setting css for last row of table
          if (!empty($nextLastNameStartsWith)) {
            if (('i' <= $nextLastNameStartsWith && 'p' >= $nextLastNameStartsWith)) {
              $trType = 'last';
            }
          }

          $option = array(
            'counter' => $m,
            'userData' => $userData,
            'punditData' => $punditData,
            'trType' => $trType
          );
        //  if ($m <= 10) {
            echo $this->element('Pundit/all_pundit', $option);
       //   }

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

          //setting css for last row of table
          if (!empty($nextLastNameStartsWith)) {
            if (('q' <= $nextLastNameStartsWith && 'z' >= $nextLastNameStartsWith)) {
              $trType = 'last';
            }
          }

          $option = array(
            'counter' => $n,
            'userData' => $userData,
            'punditData' => $punditData,
            'trType' => $trType
          );
        //  if ($n <= 10) {
            echo $this->element('Pundit/all_pundit', $option);
        //  }

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
            'punditData' => $punditData,
            'trType' => $trType
          );
         // if ($k <= 10) {
            echo $this->element('Pundit/all_pundit', $option);
         // }

        }

        $l++;
        if ($l == $numberOfUser) {
          ?>
          </table>
          <?php
        }
      }
      ?>
    </div><!--end of table_holder-->
  <!--<div class="line">line</div>-->
<?php endforeach; ?>