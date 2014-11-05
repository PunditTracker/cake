<div class="nav_bar">
  <!-- <button class="nav-button">Toggle Navigation</button> -->
  <ul class="nav primary-nav" id="nav">
    <?php
    $active = '';
    // debug($this);
      if((strpos($this->here, '/') === 0) && ($this->params['controller'] === 'users') && ($this->here != '/users/profile')) {
        $active = "on";
      }
    ?>
    <li class="<?php echo $active; ?>">
      <?php
      echo $this->Html->link(
        __('Home'),
        array(
          'controller' => 'users',
          'action' => 'home',
          'admin' => false
        ),
        array(
          'id' => 'UserHome'
        )
      );
      ?>
    </li>
    <?php

      if(!empty($featuredCategory)) {

        foreach($featuredCategory as $category) {
          $active = "";
          if((strpos($this->here, "categories/view/".@$category['Category']['slug'])) == true) {
            $active = "on";
          }
          ?>
          <li class="<?php echo $active; ?>">
          <?php
          echo $this->Html->link(
            $category['Category']['name'],
            array(
              'admin' => false,
              'controller' => 'categories',
              'action' => 'view',
              @$category['Category']['slug']
            ),
            array(
              'id' => 'link'.strtolower($category['Category']['name']),
              'class' => 'link',
            )
          );

          $childCategories = ClassRegistry::init('Category')->children($category['Category']['id']);
          // debug($childCategories);
          if (!empty($childCategories)) {
            echo "<ul class='sub-nav'>";
            foreach ($childCategories as $key => $childCategory) {
              echo "<li>";
              echo $this->Html->link(
                $childCategory['Category']['name'],
                array(
                  'admin' => false,
                  'controller' => 'categories',
                  'action' => 'view',
                  @$childCategory['Category']['slug']
                ),
                array(
                  'id' => 'link'.strtolower($childCategory['Category']['name'])
                )
              );
              echo "</li>";
            }
            echo "</ul>";
          }
          ?>
          </li>
          <?php
        }
      }
    ?>
    <li class="">
      <?php echo $this->Html->link(__('Blog'), 'http://blog.pundittracker.com/'); ?>
    </li>
    <?php
    $active = "";
    if((strpos($this->here, 'pages/about') == true)) {
      $active = "on";
    }
    ?>
    <li class="<?php echo $active; ?>">
    <?php
      echo $this->Html->link('ABOUT', array('controller' => 'pages', 'action' => 'about', 'admin' => false));
    ?>
    </li>

    <?php
    if ($this->Session->read('Auth.User.userGroup') == 'General') {
      ?>
      <li class="">
        <?php
        echo $this->Html->link(
          'Suggest Pundit',
          array('controller' => 'suggested_pundits', 'action' => 'add'),
          array(
            'id'      => 'suggestPunditBox',
            'mobile' => $isMobile
          )
        );
        ?>
      </li><?php
    }
    if ($this->Session->read('Auth.User.userGroup') == 'Admin') {
      ?>
      <li class="">
        <?php
        echo $this->Html->link(
          'Suggest Pundit',
          array('controller' => 'suggested_pundits', 'action' => 'add', 'admin' => true),
          array('id' => 'suggestPunditBoxByAdmin',  'mobile' => $isMobile)
        );
        ?>
      </li><?php
    }
    /*if ($this->Session->read('Auth.User.userGroup') == 'Admin') {
      $active = "";
      if((strpos($this->here, 'admin/categories') == true)) {
        $active = "on";
      }
      ?><li class="<?php echo $active; ?>"><?php
      echo $this->Html->link('Category', array('controller' => 'categories', 'action' => 'index', 'admin' => true));
      ?></li><?php
    }*/
    ?>

  </ul>
    <?php echo $this->Form->create('Call', array('url' => array('controller' => 'calls', 'action' => 'search'), 'class' => 'search_form', 'id' => 'searchForm'));
    echo $this->Form->input('keyword', array(
      'class' => 'input_keyword',
      'value' => @$findRaw,
      'label' => false
      )
    );
    echo $this->Form->end();
    ?>
</div><!--end of nav_bar-->
