<?php
if (strpos($_SERVER['HTTP_HOST'], 'pundittracker.com') !== false) {
  $config = array(
      'fbAppId'            => '428993863813184',
      'fbAppSecret'        => '692729b015efe955ac3dd223158d6dbe',
      'fbPermissionsArray' => array('email'),
      'fbPermissionsScope' => 'email',
  );
} else {
  $config = array(
      'fbAppId'            => '443400875690269',
      'fbAppSecret'        => 'e3f8490ebd5a23814ad9685403892d9f',
      'fbPermissionsArray' => array('email'),
      'fbPermissionsScope' => 'email',
  );
}
