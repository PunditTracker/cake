<?php
App::uses('UsersController', 'Controller');
App::uses('ExceptionRenderer', 'Error');
/**
 * TestUsersController *
 */
class TestUsersController extends UsersController 
{
  /**
   * Auto render
   *
   * @var boolean
   */
  public $autoRender = false;

  /**
   * Redirect action
   *
   * @param mixed $url
   * @param mixed $status
   * @param boolean $exit
   * @return void
   */
  public function redirect($url, $status = null, $exit = true) 
  {
    $this->redirectUrl = $url;
  }
}

/**
 * UsersController Test Case
 *
 */
class UsersControllerTestCase extends ControllerTestCase 
{
  /**
   * Fixtures
   *
   * @var array
   */
  public $fixtures = array(
    'app.user', 
    'app.call', 
    'app.category', 
    'app.pundit', 
    'app.pundit_category', 
    'app.outcome', 
    'app.vote', 
    'app.call_dummy', 
    'app.aro', 
    'app.aco', 
    'app.permission'
  );

  /**
   * setUp method
   *
   * @return void
   */
  public function setUp() {
    parent::setUp();
    $this->Users = new TestUsersController();
    $this->Users->constructClasses();

    $this->Users->Session->delete('Auth');
    $this->Users->Session->delete('parent_id');
    $this->Users->Session->delete('parent_group');
    $this->Users->Session->delete('flash');
  }

  /**
   * tearDown method
   *
   * @return void
   */
  public function tearDown() {
    unset($this->Users);

    parent::tearDown();
  }
  

  /**
   * testLogin method
   *
   * @return void
   */
  public function testLogin() 
  {
    //$result = $this->testAction('/users/login', array('method' => 'get'));

    $data = array(
      'User' => array(
        'email' => '',
        'password' => ''
      )
    );
    $result = $this->testAction('/users/login', array('method' => 'post', 'data' => $data));
    $result = json_decode($result, true);
    $expected = 'Please enter email';
    $this->assertEquals($expected, $result['email']);

    $data = array(
      'User' => array(
        'email' => 'admin@pundittracker.com',
        'password' => '111111'
      )
    );
    $result = $this->testAction('/users/login', array('method' => 'post', 'data' => $data));
    $result = json_decode($result, true);
    $expected = 'Your username or password was incorrect.';
    $this->assertEquals($expected, $result['authFail']);


    $data['User']['password'] = '123456';
    $result = $this->testAction('/users/login', array('method' => 'post', 'data' => $data));
    $result = json_decode($result, true);
    $this->assertTrue(true, $result['success']);
    
    $this->Users->Session->write('Auth.User', array(
      'id' => null,
      'userGroup' => '',
      )
    );

    
    $data = array(
      'Config' => array(
        'userAgent' => '8ae4118396df6092b96c00d0c0c07149',
        'time' => (int) 1345815424,
        'countdown' => (int) 10
      ),
      'fb_387683227959372_code' => 'AQDUlhVIJ7agmGGH8JSfX6qZ_Bs4CTRRYvGZlNl7c1D3BIntNkmdaK3KNzWlWoZGga7ixySwh8GRp7-gk3-4lxj8EUyXRlwKJkcP6aacCsmW1Cx-2fP_itUBGOWq7194kJiD6YEH7y09deRsgTcprHSqUIY9UD5eBV0LbeS5V-vqJwlhTIUxPWLx8Mh74k4NGf8',
      'fb_387683227959372_access_token' => 'AAAFgmIkWgEwBAKFe3K91w4S047A4FCZC6ziTXInSLktk9YhpW2IrTOM6OLefWEcAShe0BTccEhTxeZAuxGsLZBqzvnsCdclZCNLqi3dJgAZDZD',
      'fb_387683227959372_user_id' => '100000782195794',
      'Auth' => array(
        'User' => array(
          'fb_id' => '100000782195794',
          'fb_access_token' => 'AAAFgmIkWgEwBAKFe3K91w4S047A4FCZC6ziTXInSLktk9YhpW2IrTOM6OLefWEcAShe0BTccEhTxeZAuxGsLZBqzvnsCdclZCNLqi3dJgAZDZD',
          'email' => 'jitendra.naina@yahoo.com',
          'first_name' => 'Jitendra',
          'last_name' => 'Thakur',
          'avatar' => 'https://graph.facebook.com/100000782195794/picture',
          'website' => 'http://www.facebook.com/jitz31',
          'id' => '6',
          'userGroup' => 'General'
        )
      )
    );
    $this->Users->Session->write($data);
    $this->testAction('/users/login', array('method' => 'get'));
    $expected = 'General';
    $this->assertEquals($expected, $this->Users->Session->read('Auth.User.userGroup'));
   
  }


  /**
   * testLogout method
   *
   * @return void
   */
  public function testLogout() 
  {
    $this->Users->Session->write('Auth.User', array(
      'id' => '1',
      'userGroup' => 'Admin',
      )
    );
    $this->testAction('/users/logout/', array('method' => 'post'));
    $result = $this->Users->Session->read('Message.flash.message');
    $expected = 'Successfully logged out of the system.';
    $this->assertEquals($expected, $result);
  }


  /**
   * testSignup method
   *
   * @return void
   */
  public function testSignup() 
  {
    $this->Users->Session->write('Auth.User', array(
      'id' => null,
      'userGroup' => '',
      )
    ); 
        
    $data = array(
      'User' => array(
        'password' => '123456',
        'first_name' => 'General',
        'last_name' => 'User',
        'email' => 'general@pundittracker.com',
        'password2' => '',
        'group_id' => 4
      )
    );
    $result = $this->testAction('/users/signup', array('method' => 'post', 'data' => $data));
    $result = json_decode($result, true);
    $expected = 'Please confirm your password';
    $this->assertEquals($expected, $result['failure']['password2'][0]);

    $data['User']['password2'] = '123456';
    $result = $this->testAction('/users/signup', array('method' => 'post', 'data' => $data));
    $result = json_decode($result, true);
    $this->assertTrue(true, $result['success']);
            
  }


  /**
   * testHome method
   *
   * @return void
   */
  public function testHome() 
  {
    $this->Users->Session->write('Auth.User', array(
      'id' => null,
      'userGroup' => '',
      )
    );
    $result = $this->testAction('/users/home', array('method' => 'get', 'return' => 'vars'));
   
    $expected = '5';
    $this->assertEquals($expected, $result['calls'][0]['Call']['user_id']);
  }


  /**
   * testProfile method
   *
   * @return void
   */
  public function testProfile() 
  {
    $this->Users->Session->write('Auth.User', array(
      'id' => null,
      'userGroup' => '',
      )
    );
    $result = $this->testAction('/users/profile/3', array('method' => 'get', 'return' => 'vars'));
    $expected = '3';
    $this->assertEquals($expected, $result['userId']);

    $result = $this->testAction('/users/profile/100', array('method' => 'get', 'return' => 'vars'));
    $expected = '100';
    $this->assertEquals($expected, $result['userId']);

    $result = $this->testAction('/users/profile/2', array('method' => 'get', 'return' => 'vars'));
    $expected = '2';
    $this->assertEquals($expected, $result['userId']);
    
    $this->Users->Session->write('Auth.User', array(
      'id' => '1',
      'userGroup' => 'Admin',
      )
    );
    
    $result = $this->testAction('/users/profile', array('method' => 'get', 'return' => 'vars'));
    $expected = true;
    $this->assertEquals($expected, $result['isAdmin']);
  }

  
  /**
   * testLiveCall method
   *
   * @return void
   */
  public function testLiveCall() 
  {
    $result = $this->testAction('/users/live_call/3', array('method' => 'get', 'return' => 'vars'));
    $expected = '3';
    $this->assertEquals($expected, $result['userId']);
  }


  /**
   * testArchiveCall method
   *
   * @return void
   */
  public function testArchiveCall() 
  {
    $result = $this->testAction('/users/archive_call/3', array('method' => 'get', 'return' => 'vars'));
    $expected = '3';
    $this->assertEquals($expected, $result['userId']);
  }


  /**
   * testAdminIndex method
   *
   * @return void
   */
  public function testAdminIndex() 
  {
    $this->Users->Session->write('Auth.User', array(
      'id' => '1',
      'userGroup' => 'Admin',
      )
    );
    $result = $this->testAction('/admin/users/index', array('method' => 'get', 'return' => 'vars'));
    $expected = true;
    $this->assertTrue($expected, $result['isAdmin']);
  }


  /**
   * testAdminDelete method
   *
   * @return void
   */
  public function testAdminDelete() 
  {
    $this->Users->Session->write('Auth.User', array(
      'id' => '1',
      'userGroup' => 'Admin',
      )
    );
    try {
      $this->testAction('/admin/users/delete/3', array('method' => 'post'));
    } catch (Exception $e)  {
      $expected1 = 'Method Not Allowed';
      $this->assertEquals($expected1, $e->getMessage());
    }

    $_ENV['HTTP_X_REQUESTED_WITH'] = 'XMLHttpRequest';
    $result = $this->testAction('/admin/users/delete/3', array());
    $result = json_decode($result, true);
    $expected = true;
    $this->assertTrue($expected, $result['success']);
  }


  /**
   * testAdminEdit method
   *
   * @return void
   */
  public function testAdminEdit() 
  {
    $this->Users->Session->write('Auth.User', array(
      'id' => '1',
      'userGroup' => 'Admin',
      )
    );
    try {
      $this->testAction('/admin/users/edit/100', array('method' => 'post'));
    } catch (Exception $e)  {
      $expected1 = 'Invalid User';
      $this->assertEquals($expected1, $e->getMessage());
    }

    $result = $this->testAction('/admin/users/edit/3', array('method' => 'get', 'return' => 'vars'));
    $expected = array('className' => 'hide');
    $this->assertEquals($expected['className'], $result['className']);

    $data = array(
      'User' => array(
        'fb_id' => '',
        'first_name' => 'User1',
        'last_name' => 'General1',
        'email' => 'user_general1@perfectspace.com',
        'biography' => '',
        'score' => '0.00',
        'filename' => array(
          'name' => '',
          'type' => '',
          'tmp_name' => '',
          'error' => 1,
          'size' => 0
        )
      )
    );
    $this->testAction('/admin/users/edit/3', array('method' => 'post', 'data' => $data));

    $data['User']['filename']['error'] = 4;
    $this->testAction('/admin/users/edit/3', array('method' => 'post', 'data' => $data));
    $result = $this->Users->Session->read('Message.flash.message');
    $expected = 'The user information has been updated.';
    $this->assertEquals($expected, $result);
  }


  /**
   * testAdminUserView method
   *
   * @return void
   */
  public function testAdminUserView() 
  {
    $this->Users->Session->write('Auth.User', array(
      'id' => '1',
      'userGroup' => 'Admin',
      )
    );
    try {
      $this->testAction('/admin/users/user_view/100', array('method' => 'get'));
    } catch (Exception $e)  {
      $expected1 = 'Invalid User';
      $this->assertEquals($expected1, $e->getMessage());
    }

    $result = $this->testAction('/admin/users/user_view/3', array('method' => 'get', 'return' => 'vars'));
    $this->assertEquals(true, $result['isAdmin']);
  }


  /**
   * testEditInfo method
   *
   * @return void
   */
  public function testEditInfo() 
  {
    $this->Users->Session->write('Auth.User', array(
      'id' => '100',
      'userGroup' => 'General',
      )
    );
    try {
      $this->testAction('/users/edit_info', array('method' => 'get'));
    } catch (Exception $e)  {
      $expected1 = 'Invalid User';
      $this->assertEquals($expected1, $e->getMessage());
    }

    $this->Users->Session->write('Auth.User', array(
      'id' => '3',
      'userGroup' => 'General',
      )
    );

    $result = $this->testAction('/users/edit_info', array('method' => 'get', 'return' => 'vars'));
    $expected = array('className' => 'hide');
    $this->assertEquals($expected['className'], $result['className']);

    $data = array(
      'User' => array(
        'fb_id' => '',
        'first_name' => 'User1',
        'last_name' => 'General1',
        'email' => 'user_general1@perfectspace.com',
        'biography' => '',
        'score' => '0.00',
        'filename' => array(
          'name' => '',
          'type' => '',
          'tmp_name' => '',
          'error' => 1,
          'size' => 0
        )
      )
    );
    $this->testAction('/users/edit_info', array('method' => 'post', 'data' => $data));

    $data['User']['filename']['error'] = 4;
    $this->testAction('/users/edit_info', array('method' => 'post', 'data' => $data));
    $result = $this->Users->Session->read('Message.flash.message');
    $expected = 'The user information has been updated.';
    $this->assertEquals($expected, $result);
  }


  /**
   * testResetPassword method
   *
   * @return void
   */
  public function testResetPassword() 
  {
    $this->Users->Session->write('Auth.User', array(
      'id' => '100',
      'userGroup' => 'General',
      )
    );
    try {
      $this->testAction('/users/reset_password', array('method' => 'get'));
    } catch (Exception $e)  {
      $expected1 = 'Invalid User';
      $this->assertEquals($expected1, $e->getMessage());
    }

    $this->Users->Session->write('Auth.User', array(
      'id' => '3',
      'userGroup' => 'General',
      )
    );
    $data = array(
      'User' => array(
        'password' => '111111',
        'old_password' => '123456',
        'password2' => ''
      )
    );
    $this->testAction('/users/reset_password', array('method' => 'post', 'data' => $data));

    $data['User']['password'] = '';
    $this->testAction('/users/reset_password', array('method' => 'post', 'data' => $data));
    $result = $this->Users->Session->read('Message.flash.message');
    $expected = 'Password updated.';
    $this->assertEquals($expected, $result);

    $data['User']['password2'] = '111111';
    $data['User']['password'] = '111111';
    $this->testAction('/users/reset_password', array('method' => 'post', 'data' => $data));
    $result = $this->Users->Session->read('Message.flash.message');
    $expected = 'Password updated.';
    $this->assertEquals($expected, $result);
  }


  /**
   * testForgotPassword method
   *
   * @return void
   */
  public function testForgotPassword() 
  {
    $this->Users->Session->write('Auth.User', array(
      'id' => null,
      'userGroup' => '',
      )
    );

    $data['User']['email'] = '';
    $this->testAction('/users/forgot_password', array('method' => 'post', 'data' => $data));
    $result = $this->Users->Session->read('Message.flash.message');
    $expected = 'Please enter a valid email';
    $this->assertEquals($expected, $result);

    $data['User']['email'] = 'aaaaa';
    $this->testAction('/users/forgot_password', array('method' => 'post', 'data' => $data));
    $result = $this->Users->Session->read('Message.flash.message');
    $expected = 'Email does not exist.';
    $this->assertEquals($expected, $result);

    $data['User']['email'] = 'user_general1@perfectspace.com';
    $this->testAction('/users/forgot_password', array('method' => 'post', 'data' => $data));
    $result = $this->Users->Session->read('Message.flash.message');
    //$expected = 'Password reset link has been sent to your e-mail. Please click the link to complete the reset process.';
    //$this->assertEquals($expected, $result);
  }


  /**
   * testResetNew method
   *
   * @return void
   */
  public function testResetNew() 
  {
    $this->Users->Session->write('Auth.User', array(
      'id' => null,
      'userGroup' => '',
      )
    );

    $this->testAction('/users/reset_new/', array('method' => 'get'));
    $result = $this->Users->Session->read('Message.flash.message');
    $expected = 'Invalid activation code.';
    $this->assertEquals($expected, $result);

    //$code = '12345';
    $this->testAction('/users/reset_new/12345', array('method' => 'get'));
    $result = $this->Users->Session->read('Message.flash.message');
    $expected = 'Invalid activation code.';
    $this->assertEquals($expected, $result);

    //$code = '982c42bd8671fd5e784d530ec4290069';
    $this->testAction('/users/reset_new/982c42bd8671fd5e784d530ec4290069', array('method' => 'get'));
    $result = $this->Users->Session->read('Message.flash.message');
    $expected = 'Temporary password sent to your email. Please login using this and then reset your password using profile manager.';
    $this->assertEquals($expected, $result);
  }
 
}
