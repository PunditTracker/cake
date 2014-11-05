<?php
/**
 * This file is loaded automatically by the app/webroot/index.php file after core.php
 *
 * This file should load/create any application wide configuration settings, such as 
 * Caching, Logging, loading additional configuration files.
 *
 * You should also use this file to include any files that provide global functions/constants
 * that your application uses.
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright 2005-2011, Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2005-2011, Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Config
 * @since         CakePHP(tm) v 0.10.8.2117
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */

// Setup a 'default' cache configuration for use in the application.
Cache::config('default', array('engine' => 'File'));

//cache setup 
Cache::config('element_config', 
  array(
    'engine' => 'File',
    'duration' => '+1 hours',
    'path' => CACHE . 'views' . DS,
    'prefix' => 'cake_elem_'
  )
);

Cache::config('user_ranking_element_config', 
  array(
    'engine' => 'File',
    'duration' => '+1 day',
    'path' => CACHE . 'views' . DS,
    'prefix' => 'cake_elem_'
  )
);

Cache::config('sitemap', 
  array(
    'engine' => 'File',
    'duration' => '+24 hours',
    'path' => CACHE . 'views' . DS,
    'prefix' => 'sitemap_'
  )
);

/**
 * The settings below can be used to set additional paths to models, views and controllers.
 *
 * App::build(array(
 *     'Plugin' => array('/full/path/to/plugins/', '/next/full/path/to/plugins/'),
 *     'Model' =>  array('/full/path/to/models/', '/next/full/path/to/models/'),
 *     'View' => array('/full/path/to/views/', '/next/full/path/to/views/'),
 *     'Controller' => array('/full/path/to/controllers/', '/next/full/path/to/controllers/'),
 *     'Model/Datasource' => array('/full/path/to/datasources/', '/next/full/path/to/datasources/'),
 *     'Model/Behavior' => array('/full/path/to/behaviors/', '/next/full/path/to/behaviors/'),
 *     'Controller/Component' => array('/full/path/to/components/', '/next/full/path/to/components/'),
 *     'View/Helper' => array('/full/path/to/helpers/', '/next/full/path/to/helpers/'),
 *     'Vendor' => array('/full/path/to/vendors/', '/next/full/path/to/vendors/'),
 *     'Console/Command' => array('/full/path/to/shells/', '/next/full/path/to/shells/'),
 *     'locales' => array('/full/path/to/locale/', '/next/full/path/to/locale/')
 * ));
 *
 */

/**
 * Custom Inflector rules, can be set to correctly pluralize or singularize table, model, controller names or whatever other
 * string is passed to the inflection functions
 *
 * Inflector::rules('singular', array('rules' => array(), 'irregular' => array(), 'uninflected' => array()));
 * Inflector::rules('plural', array('rules' => array(), 'irregular' => array(), 'uninflected' => array()));
 *
 */

/**
 * Plugins need to be loaded manually, you can either load them one by one or all of them in a single call
 * Uncomment one of the lines below, as you need. make sure you read the documentation on CakePlugin to use more
 * advanced ways of loading plugins
 *
 * CakePlugin::loadAll(); // Loads all plugins at once
 * CakePlugin::load('DebugKit'); //Loads a single plugin named DebugKit
 *
 */


  Configure::load('config');

  CakePlugin::load('AssetCompress');

  if (file_exists(APP . 'Plugin/Acm')) {
    CakePlugin::load('Acm');
  }

  //Configure::load('facebook');

  //include the Sanitize core library.
  App::uses('Sanitize', 'Utility');
  /**
   * Function to escape output html.
   * Specially used to user submitted form data.
   *
   * @param string $content Content to escape.
   *
   * @return string Escaped content.
   */
  function escape($content = null) {
    return Sanitize::stripAll($content);
  }//end escape()


  /**
   * Method used to generate random password string
   *
   * @return string
   */
  function randomChars($lenghts=null) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyz';
    $string = null;
    for ($p = 0; $p < $lenghts; $p++) {
      $string .= $characters[mt_rand(0, strlen($characters)-1)];
    }
    return $string;

  }//end randomChars()

 
  /**
   * Method used to return facebook instance
   *
   * @return string
   */
  function getFbInstance() {
    static $instance;
    if ( ! isset($instance)) {
        // load vendor files
        App::import('Vendor', 'facebook/src/facebook');
        $settings = array(
            'appId' => Configure::read('fbAppId'),
            'secret' => Configure::read('fbAppSecret'),         
            'cookie' => true
        );
        $instance = new Facebook($settings);
    }
    return $instance;
  }//end getFbInstance()


  /**
   * Method used to return date greater or not
   *
   * @return string
   */
  function greaterDate($start_date = null, $end_date = null, $equalTo = false)
  {
    $start = strtotime($start_date);
    $end = strtotime($end_date);
    if ($end-$start > 0)
      return true;
    else if ($equalTo && $end-$start >= 0)
      return true;
    else
     return false;
  }//end greaterDate()


  /**
   * Method used to return date greater or not
   *
   * @param string $args date in dd/mm/yyyy format
   *
   * @return string
   */
  function dmyTomdy ($args = null) {
    $date = explode('/', $args);
    if (checkdate($date[1], $date[0], $date[2])) {
      $result = $date[1].'/'.$date[0].'/'.$date[2];
      return $result;
    }
    return '';    

  }//end dmyTomdy()
