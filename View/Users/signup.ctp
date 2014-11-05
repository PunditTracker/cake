<div id="signup" class="edit_form">
  <?php
  echo $this->Form->create('User', array('url' => array('action' => 'signup'), 'class' => 'edit_form'));
  ?>
    <h2>Sign Up</h2>
    <fieldset id="inputs">
      <?php
      echo $this->Form->input(
        'first_name',
        array(
          'label' => array(
            'text' => 'First Name<div id="errorMessageFirstName"></div>'
          ),
          'placeholder' => 'First Name',
          'autofocus' => true,
          'error' => array(
            'notempty' => __('Please enter your first name')
          ),
          'class' => 'input_txt'
        )
      );
      ?><div id="errorFirstname"> </div><?php
      echo $this->Form->input(
        'last_name',
        array(
          'label' => array(
            'text' => 'Last Name<div id="errorMessageLastName"></div>'
          ),
          'placeholder' => 'Last Name',
          'error' => array(
            'notempty' => __('Please enter your last name'),
          ),
          'class' => 'input_txt'
        )
      );
      ?><div id="errorLastname"> </div><?php
      echo $this->Form->input(
        'email',
        array(
          'label' => array(
            'text' => 'Email<div id="errorMessageEmail"></div>'
          ),
          'placeholder' => 'Email Address',
          'error' => array(
            'notempty' => __('Please enter email address'),
            'email' => __('Please enter valid email address'),
            'unique' => __('This email address already exist'),
          ),
          'class' => 'input_txt'
        )
      );
      ?><div id="errorEmail"> </div><?php
      echo $this->Form->input(
        'password',
        array(
          'label' => array(
            'text' => 'Password<div id="errorMessagePassword"></div>'
          ),
          'placeholder' => 'Password',
          'error' => array(
            'required' => __('Please enter password')
          ),
          'class' => 'input_txt'
        )
      );
      ?><div id="errorPassword"> </div><?php
      echo $this->Form->input(
        'password2',
        array(
          'label' => array('text' => 'Confirm password<div id="errorMessagePassword2"></div>'),
          'placeholder' => 'Confirm Password',
          'type' => 'password',
          'error' => array(
            'required' => __('Please confirm your password'),
            'confirm' => __('password could not matched')
          ),
          'class' => 'input_txt'
        )
      );
      ?><div id="errorPassword2"> </div>
      <div class="actions edit_btns facebook">
      <?php
      echo $this->Form->submit(
        __('Submit'),
        array(
          'class' => 'input_submit',
          'div' => false
        )
      );
      ?>
      <div><span>Or</span></div>
      <?php
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
    </fieldset>
  <?php echo $this->Form->end(); ?>
</div>
