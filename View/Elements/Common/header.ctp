<div class="logo">
  <?php
  echo $this->Html->link(
    $this->Html->image(
      'logo.png',
      array(
        'alt' => 'PunditTracker',
        'width' => "345",
        'height' => '78'
      )
    ),
    '/',
    array(
      'escape' => false
    )
  );
  ?>
</div>

<div class="head_btns">

  <?php
  if ($this->Session->read('Auth.User')) {
    /*echo $this->Html->link(
      'All Pundits',
      array(
        'controller' => 'pundits',
        'action' => 'index',
        'admin' => false
      ),
      array(
        'id' => 'PunditIndex'
      )
    );*/
    if ($this->Session->read('Auth.User.userGroup') == 'Admin') {
      echo $this->Html->link(
        'Admin Dashboard',
        array(
          'controller' => 'suggested_pundits',
          'action'     => 'index',
          'admin'      => true,
        ),
        array('class'  => 'dashboard')
      );
    }
    echo $this->Html->link(
      'My Profile',
      array(
        'controller' => 'users',
        'action' => 'profile', $this->Session->read('Auth.User.slug'),
        'admin' => false
      ),
      array(
        'id' => 'UserProfile'
      )
    );

    echo $this->Html->link(
      'Logout',
      array(
        'controller' => 'users',
        'action'     => 'logout',
        'admin'      => false
      ),
      array(
        'id' => 'UserLogout'
      )
    );
  } else {
    /*if ($isMobile) {
      echo $this->Html->link(
        'Sign up',
        array(
          'controller' => 'users',
          'action'     => 'signup',
        ),
        array(
          'class' => 'signup',
          'id' => 'UserSignup-m'
        )
      );

      echo $this->Html->link(
        'Login',
        array(
          'controller' => 'users',
          'action'     => 'login',
        ),
        array(
          'class'  => 'login',
          'id'     => 'UserLogin',
          'mobile' => $isMobile
        )
      );

      echo $this->Html->link(
        'Forgot Password',
        array(
         'controller' => 'users',
         'action'     => 'forgot_password',
        ),
        array(
          'id' => 'forgotPassword-m'
        )
      );
    } else {*/
    echo $this->Html->link(
      'Sign up',
      '#signup',
      array(
        'class' => 'signup',
        'id' => 'UserSignup'
      )
    );

    echo $this->Html->link(
      'Login',
      '#signin',
      array(
        'class'  => 'login',
        'id'     => 'UserLogin',
        'mobile' => $isMobile
      )
    );

   // }
  }
  ?>
</div>

<div class="head_icons">
  <?php
    echo $this->Html->link(
      $this->Html->image(
        'ico_facebook.png',
        array(
          'alt' => '',
          'width' => "24",
          'height' => '24'
        )
      ),
      'http://www.facebook.com/pundittracker',
      array(
        'escape' => false
      )
    );
    echo $this->Html->link(
      $this->Html->image(
        'ico_twitter.png',
        array(
          'alt' => '',
          'width' => "24",
          'height' => '24'
        )
      ),
      'https://twitter.com/pundittracker/',
      array(
        'escape' => false
      )
    );
  ?>
</div>

<?php echo $this->element('Common/navigation'); ?><!--end of nav_bar-->

<div class="hide">
    <?php echo $this->element('login'); ?>
</div>

<div class="hide">
    <?php echo $this->element('signup'); ?>
</div>
