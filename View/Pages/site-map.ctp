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
  <span>SITE MAP</span>  
</div><!--end of breadcrum--> 

<div class="title_row">
    <h1>SITE MAP</h1>
</div><!--end of title_row-->

<div class="main_content">
  <ul class="ul_list">
    <li><?php   
      echo $this->Html->link(
        __('HOME'), 
        array(
          'controller' => 'users', 
          'action' => 'home', 
          'admin' => false
        ), 
        array()
      );
      ?>
    </li>
    <li><?php echo 'Category'; ?>
      <ul>
        <li><?php   
          echo $this->Html->link(
            __('FINANCE'), 
            array(
              'controller' => 'categories', 
              'action' => 'view', 
              1
            ), 
            array()
          );
          ?>
        </li>
        <li><?php   
          echo $this->Html->link(
            __('POLITICS'), 
            array(
              'controller' => 'categories', 
              'action' => 'view', 
              2
            ), 
            array()
          );
          ?>
        </li>
        <li><?php   
          echo $this->Html->link(
            __('SPORTS'), 
            array(
              'controller' => 'categories', 
              'action' => 'view', 
              3
            ), 
            array()
          );
          ?>
        </li>        
      </ul>
    </li>
    <li><?php   
      echo $this->Html->link(
        __('BLOG'),
        'http://blog.pundittracker.com/',        
        array()
      );
      ?>
    </li>
    <li><?php   
      echo $this->Html->link(
        __('ABOUT'),
        array(
          'controller' => 'pages', 
          'action' => 'about',        
        ),        
        array()
      );
      ?>
    </li>
    <li><?php   
      echo $this->Html->link(
        __('TERMS OF USE'),
        array(
          'controller' => 'pages', 
          'action' => 'terms-of-use',        
        ),        
        array()
      );
      ?>
    </li>
    <?php if (!$this->Session->read('Auth.User.id')) : ?>
    <li><?php   
      if ($isMobile) {
        echo $this->Html->link(
          __('SIGN UP'),
          '/users/signup',        
          array(
           'id' => '',
           'class' => ''
          )
        );
      } else {
        echo $this->Html->link(
          __('SIGN UP'),
          '#signup',        
          array(
           'id' => 'UserSignup',
           'class' => 'signup cboxElement'
          )
        );
      }   
      ?>
    </li>     
    <?php endif; ?> 
    <!--   
    <li>Parent Page
      <ul>
        <li>Child Page</li>
        <li>Child Page</li>
      </ul>
    </li>
    <li>Parent Page
      <ul>
        <li>Child Page</li>
        <li>Child Page
          <ul>
            <li>Deeper Child Page</li>
          </ul>
        </li>
        <li>Child Page</li>
        <li>Child Page</li>
      </ul>
    </li>
    <li>Parent Page
      <ul>
        <li>Child Page</li>
      </ul>
    </li>-->
  </ul>
</div><!--end of main_content--> 



<?php echo $this->element('Common/static_side_bar'); ?>

