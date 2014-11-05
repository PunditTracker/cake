<?php
// Create the config array
$config = array();

//AssetCompress configuration
$config['asset_compress']['options'] = array('raw' => Configure::read('raw_assets'));

// pundit group id
$config['pundit_group_id'] = 3;

// general user group id
$config['general_user_group_id'] = 4;

// email from
$config['email_from'] = 'test@test.com';

// forgot password email subject
$config['forgot_password_email_subject'] = 'Forgot password activation link';

// temporary password email subject
$config['temporary_password_email_subject'] = 'Temporary password';

$config['radio_vote_option'] = array(
  '0'   => 'No Way',
  '0.25' => 'Unlikely',
  //'0.5'    => '50/50',
  '0.75'  => 'Likely',
  '1'    => 'Definitely'
);


// used to give grade
$config['grades'] = array(
  '0' => array(
    'min' => 0,
    'max' => 0.91,
    'grade' => 'F'
  ),
  '1' => array(
    'min' => 0.91,
    'max' => 0.93,
    'grade' => 'D-'
  ),
  '2' => array(
    'min' => 0.93,
    'max' => 0.95,
    'grade' => 'D'
  ),
  '3' => array(
    'min' => 0.95,
    'max' => 0.97,
    'grade' => 'D+'
  ),
  '4' => array(
    'min' => 0.97,
    'max' => 0.99,
    'grade' => 'C-'
  ),
  '5' => array(
    'min' => 0.99,
    'max' => 1.01,
    'grade' => 'C'
  ),
  '6' => array(
    'min' => 1.01,
    'max' => 1.03,
    'grade' => 'C+'
  ),
  '7' => array(
    'min' => 1.03,
    'max' => 1.05,
    'grade' => 'B-'
  ),
  '8' => array(
    'min' => 1.05,
    'max' => 1.07,
    'grade' => 'B'
  ),
  '9' => array(
    'min' => 1.07,
    'max' => 1.09,
    'grade' => 'B+'
  ),
  '10' => array(
    'min' => 1.09,
    'max' => 1.11,
    'grade' => 'A-'
  ),
  '11' => array(
    'min' => 1.11,
    'max' => 1.13,
    'grade' => 'A'
  ),
  '12' => array(
    'min' => 1.13,
    'max' => 100,
    'grade' => 'A+'
  ),
);

//array for average boldness
$config['avg_boldness'] = array(
  '0' => array(
    'min' => '0',
    'max' => '33',
    'obtain' => 'Low'
  ),
  '1' => array(
    'min' => '33',
    'max' => '66',
    'obtain' => 'Medium'
  ),
  '2' => array(
    'min' =>  '66',
    'max' => '100',
    'obtain' => 'High'
  ),
);


$config['category_ico'] = array(
  'FINANCE' => 'ico_dollar',
  'SPORTS' => 'ico_sport',
  'POLITICS' => 'ico_house',
  'ENTERTAINMENT' => 'ico_entertainment',
  'Barrons Roundtable' => 'ico_dollar',
  'NFL Draft' => 'ico_sport',
  'NCAAF' => 'ico_sport',
  'NCAAB' => 'ico_sport',
  'NBA' => 'ico_sport',
  'MLB' => 'ico_sport',
  'NFL' => 'ico_sport',
  'McLaughlin Group' => 'ico_house',
  'Oscars' => 'ico_entertainment',
  'Emmy' => 'ico_entertainment',
  'Box Office' => 'ico_entertainment',
);

//grade only showing when user's grade upto this limit
$config['minimum_call_grade_limit'] = 10;

//cron time to refresh user score
$config['call_graded_time'] = '-10 min';

$config['actualOutcome'] = array(
  '5' => true,
  '4' => true,
  '2' => false,
  '1' => false,
);


//array for call boldness
$config['call_boldness'] = array(
  '0' => array(
    'min' => '-100',
    'max' => '0.2',
    'obtain' => 'Low'
  ),
  '1' => array(
    'min' => '0.2',
    'max' => '0.4',
    'obtain' => 'Medium-Low'
  ),
  '2' => array(
    'min' =>  '0.4',
    'max' => '0.6',
    'obtain' => 'Medium'
  ),
  '3' => array(
    'min' =>  '0.6',
    'max' => '0.8',
    'obtain' => 'Medium-High'
  ),
  '4' => array(
    'min' =>  '0.8',
    'max' => '100',
    'obtain' => 'High'
  ),
);

//asterisk definition
$config['asteriskDefinition'] = "lighter gray color indicate that pundit does not have the requisite 10 graded predictions to have an official PunditTracker grade.";

$config['getAsterisk'] = '';

$config['whyShouldVoteToolTipMsg'] = '(1) Your vote helps us determine how bold a prediction is, which then feeds into our pundit scoring system. (2) NEW: Voting allows you to compete with the pundits and win prizes! See sidebar for more details.';

$config['youAreNotRankedToolTipMsg'] = 'Rankings are based on users with at least 10 graded votes.';

$config['howToImproveYourRankingToolTipMsg'] = 'Rankings are based on users with at least 10 graded votes.';

//user minimum graded vote limit
$config['user_votes_graded_limit'] = '10';

//Mailchimp account details
if (isset($_SERVER['HTTP_HOST']) && strpos($_SERVER['HTTP_HOST'], 'pundittracker.com') !== false) {
  //mailchimp API key
  $config['MCAPI_KEY'] = 'be65d6be6a910f396f00d0ea161b85ed-us6';
  //mailchimp API List Id
  $config['MCAPI_LISTID'] = '8f60fbb804';
} else {
  //mailchimp API key for devloper section
  $config['MCAPI_KEY'] = 'be65d6be6a910f396f00d0ea161b85ed-us6';
  //mailchimp API List Id
  $config['MCAPI_LISTID'] = '51e1555156';
}

//user minimum graded vote limit for top user in home page
$config['top_user_votes_graded_limit'] = '10';

//array for admin Ids
$config['admin_ids'] = array(226);
?>
