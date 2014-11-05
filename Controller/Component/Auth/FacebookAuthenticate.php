<?php
/**
 * Facebook authentication handling
 *
 * PHP version 5.3
 *
 * @category Component
 * @package  Component
 * @author   Rakesh Tembhurne <rakesh@sanisoft.com>
 * @license  http://nagpurbirds.org Private
 * @link     http://nagpurbirds.org
 */

App::uses('BaseAuthenticate', 'Controller/Component/Auth');

/**
 * Facebook Authenticate class
 *
 * @category Component
 * @package  Component
 * @author   Rakesh Tembhurne <rakesh@sanisoft.com>
 * @license  http://nagpurbirds.org Private
 * @link     http://nagpurbirds.org
 */
class FacebookAuthenticate extends BaseAuthenticate
{

    /**
     * Name used to identify this class.
     *
     * @var type
     */
    public $name = 'Facebook';


    /**
     * This authentication method is used to authenticate facebook user.
     *
     * @param CakeRequest  $request  CakePHP request
     * @param CakeResponse $response CakePHP response
     *
     * @return array
     */
    public function authenticate(CakeRequest $request, CakeResponse $response)
    {
        // Gets facebook user by initiating facebook class.
        $facebook = getFbInstance();
        $fbuser   = $facebook->getUser(); 
        // Gets required user data from facebook.
        if ($fbuser) {
            try {
                // Get facebook user's detail.     
                $me          = $facebook->api('/me');
                $accessToken = $facebook->getAccessToken();
                $fbUsername  = isset($me['email']) ? $me['email'] : null;
                $fbAvatar  = isset($me['picture']) ? $me['picture'] : null;
                $user        = array(
                                'fb_id'        => $me['id'],
                                'fb_access_token' => $accessToken,
                                'email'        => $fbUsername,
                                'first_name'   => $me['first_name'],
                                'last_name'    => $me['last_name'],
                                'avatar'       => 'https://graph.facebook.com/'.$me['id'].'/picture',                              
                                'website'      => $me['link'],
                               );
                return $user;
            } catch(FacebookApiException $e) {
                $result = $e->getResult();
                SessionComponent::setFlash($result['error']['message'], 'default', array(), 'auth');
                return false;
            }
        }

        // Redirects to login page.
        $loginUrlParams = array(
                           'scope'     => Configure::read('fbPermissionsScope'),
                           'fbconnect' => 1,
                           'display'   => 'page',
                           'next'      => 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'],
                          );
        $loginUrl       = $facebook->getLoginUrl($loginUrlParams);
        header("Location: {$loginUrl}");
        exit;
    }//end authenticate()


}//end class
