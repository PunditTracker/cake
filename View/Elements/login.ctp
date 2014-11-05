<div id="signin" class="edit_form">
  <h2><?php  echo __('Login');?></h2>
    <?php
    echo $this->Form->create('User', array('url' => array('action' => 'login', 'class' => 'edit_form')));
    ?>

    <?php
    echo $this->Form->input(
      'email',
      array(
        'label' => array(
          'text' => 'Email<div id="errorMessageEmail"></div><div id="errorMessage"></div>'
        ),
        'placeholder' => 'Email',
        'autofocus' => true,
        'class' => 'input_txt'
      )
    );
    echo $this->Form->input(
      'password',
      array(
        'label' => array(
          'text' => 'Password<div id="errorMessagePassword"></div>'
        ),
        'div' => false,
        'placeholder' => 'Password',
        'class' => 'input_txt'
      )
    );
    ?>
    <div class="actions edit_btns facebook">
    <?php
    echo $this->Form->submit(
      __('Sign in'),
      array(
        'class' => 'input_submit',
        'div' => false
      )
    );

    echo $this->Form->input('remember_me',
      array(
        'type' => 'checkbox',
        'label' => 'Remember me',
        'class' => 'rememberMe'
      )
    );
    echo "<br>";
    echo $this->Html->link(
      'Forgot Password',
      array(
        'controller' => 'users',
        'action'     => 'forgot_password',
      ),
      array(
        'id'     => 'forgotPassword',
        'mobile' => $isMobile
      )
    );
    ?>
    <div class="div"><span>Or</span></div>
    <?php
    if ($isMobile) {
      echo $this->Html->link(
        'Sign up',
        array(
          'controller' => 'users',
          'action'     => 'signup',
        ),
        array(
          'class' => 'signup-m',
          'id' => 'UserSignup-m'
        )
      );
    } else {
      echo $this->Html->link(
        'Sign up',
        '#signup',
        array(
          'class' => 'signup',
          'id' => 'UserSignup'
        )
      );
    }

    echo $this->Html->image(
      "login-button.png",
      array(
       'alt' => 'Login with Facebook',
       'url' => array('controller' => 'users', 'action' => 'login', 'fb'),
       'scope' => 'email',
       'id' => 'UserFacebookLogin',
       'width' => '200px',
       'height' => '40px'
      )
    );
      ?>
    </div>
    <?php echo $this->Form->end(); ?>
</div>
