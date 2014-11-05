<?php $isAsterisk = Configure::read('getAsterisk'); if (!empty($isAsterisk)) : ?>
  <div class="asteriskFooter">
    <?php echo "NOTE : Asterisk (&#8727;) and ".Configure::read('asteriskDefinition'); ?>
  </div>
<?php endif; ?>
<div class="foot_row1">
  <div class="foot_logo">
    <?php
    echo $this->Html->link(
      $this->Html->image(
        'foot_logo.png',
        array(
          'alt' => '',
          'width' => "235",
          'height' => '24'
        )
      ),
      '/',
      array(
        'escape' => false
      )
    );
    ?>
  </div>
  <div class="foot_icons">

  </div>
</div>

<div class="foot_row2">
  <div class="foot_col1">
      <div class="foot_links">
        <?php
          echo $this->Html->link(
            __('Home'),
            array(
              'controller' => 'users',
              'action' => 'home',
              'admin' => false
            )
          );
          echo ' | ';
          //if ($this->Session->read('Auth.User.id')) {
            if(!empty($featuredCategory)) {
              foreach($featuredCategory as $category) {
                echo $this->Html->link(
                  $category['Category']['name'],
                  array(
                    'admin' => false,
                    'controller' => 'categories',
                    'action' => 'view',
                    @$category['Category']['slug']
                  )
                );
                echo ' | ';
              }
            }
          //}
          echo $this->Html->link(
            __('blog'),
            'http://blog.pundittracker.com/'
          );
          echo ' | ';
          echo $this->Html->link(
            __('about'),
            array(
              'controller' => 'pages',
              'action' => 'about',
              'admin' => false
            )
          );
          echo ' | ';
          echo $this->Html->link(
            __('submit'),
            '#',
            array(
              'id' => 'footer_submit'
            )
          );
        ?>
      </div>
      <div class="copyright">&copy; 2012 PunditTracker. All rights reserved. Web Design by <a href="http://thewaronmars.com/" title="San Diego Web Design">The War on Mars</a> | Web Development by <a href="http://perfectspace.com/" title="San Diego Web Development">Perfect Space</a></div>
  </div>

  <div class="foot_col2">
      <div class="foot_links">
        <?php
        echo $this->Html->link(
          __('terms of use'),
          array(
            'controller' => 'pages',
            'action' => 'terms-of-use',
            'admin' => false
          )
        );
        echo ' | ';
        echo $this->Html->link(
          __('Site map'),
          array(
            'controller' => 'pages',
            'action' => 'site-map',
            'admin' => false
          )
        );
        ?>
      </div>
  </div>
</div>
