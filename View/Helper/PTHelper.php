<?php
/**
 * File used as PT helper
 *
 * This helper is mainly for PT.
 *
 * PHP version 5
 *
 * @category Controller
 * @package  PunditTracker
 */

/**
 * PT controller class
 *
 * @category Controller
 * @package  PunditTracker
 *
 */
class PTHelper extends AppHelper {


  /**
   * array to hold helper.
   *
   * @return void
   */
  public $helpers = array('Time', 'Session', 'Html');


  /**
   * Function to format supplied date.
   *
   * @param string $date Date.
   * @param string $format format.
   *
   * @return string $date Formatted date.
   */
  function dateFormat($date = null, $format = null)
  {
    if (!empty($date)) {
      if (empty($format)) {
        $format = 'm/d/y';
      }
      $date = $this->Time->format($format, $date);
    }
    return $date;
  }//end dateFormat()


  /**
   * Function to format supplied date.
   *
   * @param string $date Date.
   * @param string $format format.
   *
   * @return string $date Formatted date.
   */
  function dateFormatLong($date = null, $format = null)
  {
    if (!empty($date)) {
      if (empty($format)) {
        $format = 'm/d/Y';
      }
      $date = $this->Time->format($format, $date);
    }
    return $date;
  }//end dateFormat()


  /**
   * Function to return date difference supplied date.
   *
   * @param string $start Date.
   * @param string $end Date.
   *
   * @return string
   */
  function dateDiff($start = null, $end = null)
  {
    $start = date('Y-m-d 23:59:59', strtotime($start));

    $start = new DateTime($start);
    if(empty($end)) {
      $end = new DateTime("now");
    }
    if ($start < $end) {
      return false;
    }

    $interval = $start->diff($end);

    $string = '';
    if($interval->y != 0) {
      $string .= $interval->y . " years ";
    }
    if($interval->m != 0) {
      $string .= $interval->m . " months ";
    }
    if($interval->d != 0) {
      $string .= $interval->d . " days ";
    }
    if ($interval->d == 0) {
      if($interval->h != 0) {
        $string .= $interval->h . " hours ";
      }
      if($interval->i != 0) {
        $string .= $interval->i . " minutes";
      }
    }
    return $string;
  }//end dateFormat()


  /**
   * Function to check access location.
   *
   * @param array $url url.
   * @param string $userId user id.
   *
   * @return bool.
   */
  function hasAccess($url = null, $userId = null) {

    if ($userId == null) {
      $userId = $this->Session->read('Auth.User.id');
    }

    $aroAlias = 'User::' . $userId;
    $acoAlias = Inflector::camelize($url['controller']) . '::' . $url['action'];

    return ClassRegistry::init('DbAcl')->check($aroAlias, $acoAlias);
  }//end hasAccess()


  /**
   * Function to check for an image.
   *
   * @param string $image image name.
   * @param string $fbId facebook id.
   *
   * @return string.
   */
  function setImage($image = null, $fbId = null, $size = 'normal')
  {
    $imgPath = 'person_img2.png';
    if (!empty($fbId)) {
      $imgPath = $image.'?type='.$size;
    } else if (!empty ($image)) {
      $imgPath = Router::url('/', true).'files/Avatar/'.$image;
      $imgUrl = WWW_ROOT .'/files/Avatar/'.$image;
    }
    if (isset($imgUrl)) {
      $imgPath = file_exists($imgUrl) ? $imgPath : 'person_img2.png';
    }
    return $imgPath;
  }//end setImage()


  /**
   * Function used to return grade
   *
   * @param float $score
   * @param integer $callNumber number of call with outcome
   *
   * @return integer.
   */
  function getGrade($score = null, $gradedCall = null) {

    if (isset($gradedCall) && $gradedCall !== null && $gradedCall < 1) {
      return 'TBD';
    }
    $grades = Configure::read('grades');
    if ($score != null) {
      foreach($grades as $key => $grade) {
        if ($score >= $grade['min'] && $score < $grade['max']) {
          return $grade['grade'];
        }
      }
    } else {
      return 'TBD';
    }
  }//end getGrade()


  /**
   * Function used to return avn boldness either low, medium or high
   *
   * @param integer $unFavor (1 - consensus)
   *
   * @return string.
   */
  function avgBoldness($boldness = null, $flag = null)
  {
    if ($flag == '0') {
      return 'TBD';
    }
    $score['obtain'] = '';
    $avgBoldness = Configure::read('avg_boldness');
    foreach($avgBoldness as $key => $score) {

      if ($boldness >= $score['min'] && $boldness <= $score['max']) {
        return $score['obtain'];
      }
    }
  }//end avgBoldness()


  /**
   * Function used to return hit rate
   *
   * @param integer $correctCalls correct call with outcome true
   * @param integer $totalCalls call with outcome
   *
   * @return string.
   */
  function hitRate($correctCalls = null, $totalCalls = null)
  {
    $hitRate = 0;
    if ($totalCalls != 0) {
      $hitRate = ($correctCalls/$totalCalls)*100;
    }
    return((int)round($hitRate));
  }//end hitRate()


  /**
   * Function used to return my outcome
   *
   * @param integer $adminRate admin rate or outcome on that call
   * @param integer $userRate  user rate or vote on that call
   *
   * @return string.
   */
  function myOutcome($adminRate = null, $userRate = null) {

    $result = abs(bcsub($adminRate, $userRate, 2));

    if ($result <= 0.25) {
      $outcome = 'ico_right2.png';
    } else {
      $outcome = 'ico_wrong2.png';
    }

    return $outcome;

  }//end hitRate()


  /**
   * Function used to return avn boldness either low, medium or high
   *
   * @param integer $unFavor (1 - consensus)
   *
   * @return string.
   */
  function callBoldness($boldness = null, $flag = null) {
    $boldness = (float)$boldness;
    if ($flag === true && empty($boldness)) {
      return 'TBD';
    }
    $score['obtain'] = 'Low';
    $callBoldness = Configure::read('call_boldness');
    foreach($callBoldness as $key => $score) {

      if ($boldness >= $score['min'] && $boldness <= $score['max']) {
        return $score['obtain'];
      }
    }//end loop

  }//end avgBoldness()


  /**
   * Function to return message for user pundit score
   *
   * @param string $adminRate admin rate
   * @param string $userRate  user rate
   *
   * @return string.
   */
  function resultMessage($outcome = null, $adminRate = null, $userRate = null, $punditName) {
     //no outcome
     if ($outcome <= 0) {
        $return = 'TBD';
      } else {
        $actualOutcome = configure::read('actualOutcome');
        //correct outcome
        if ($actualOutcome[$outcome]) {
          //user correct vote
          if (abs(bcsub($adminRate, $userRate, 2)) <= 0.25) {
            //User is Right - Pundit is Right
            $return = "Nailed it!";
          } else {
            //User is Wrong - Pundit is Right
            $return = "Don’t quit your day job!";
          }

        } else if (abs(bcsub($adminRate, $userRate, 2)) <= 0.25) {
          //User is Right - Pundit is Wrong
          $return = "Now who’s the expert?";

        } else {
          //User is Wrong - Pundit is Wrong
          $return = "Who saw that coming?";
        }

      }

    return $return;

  }//end resultMessage()


  /**
   * Function to return message for user pundit score
   *
   * @param string $response user and pundit response
   *
   * @return string.
   */
  function outcomeSign($response = array()) {

    $outcomePundit = $outcomeUser = 'TBD';
    if (isset($response['data']['Call']['outcome_id']) &&
      !empty($response['data']['Call']['outcome_id'])) {

      switch ($response['data']['Call']['outcome_id']) {
        case 1:
        case 2:
        case 3:
          $outcomePundit = 'icon-remove';
          break;
        case 4:
        case 5:
          $outcomePundit = 'icon-ok';
          break;
        default:
          $outcomePundit = 'TBD';
      }

      if (abs(bcsub($response['data']['Outcome']['rating'], $response['data']['Vote'][0]['rate'], 2)) <= 0.25) {
        $outcomeUser = 'icon-ok';
      } else {
        $outcomeUser = 'icon-remove';
      }

    }

    $return = compact('outcomePundit', 'outcomeUser');

    return $return;

  }//end outcomeSign()


  /**
   * Function to return is device is mobile or not
   *
   * @return string.
   */
  function isMobile() {


    return $this->request->is('Mobile');

  }//end isMobile()


  /**
   * Function to generate link for mobile browsers.
   *
   * @param string  $title Title.
   * @param array   $url   Url.
   * @param array   $options Options.
   * @param boolean $isMobile Is mobile flag.
   * @param string  $confirmMessage Confirmation message.
   *
   * @return string generated link
   */
  public function mobileLink($title, $url = null, $options = array(), $isMobile = false, $confirmMessage = false) {
    if ($isMoile) {
      if (!empty($options['class'])) {
        $options['class'] .= '-m';
      }
      if (!empty($options['id'])) {
        $options['id'] .= '-m';
      }
    }
    return $this->Html->link($title, $url, $options, $confirmMessage);
  }//end mobileLink()


}//end class
