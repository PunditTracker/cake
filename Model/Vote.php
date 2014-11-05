<?php
/**
 * File used as Vote model
 *
 * Contains code needed mainly for Vote controller
 *
 * @category Model
 */

/**
 * Vote model class
 *
 * @category Model
 */
class Vote extends AppModel
{

  /**
   * Property is used to hold the string.
   *
   * @var string to be implemented
   *
   * @since 1.0.0
   */
  public $name = 'Vote';


  /**
   * belongsTo associations
   *
   * @var array
   */
  public $belongsTo = array(
    'User' => array(
      'className'  => 'User',
      'foreignKey' => 'user_id',
      'conditions' => '',
      'fields'     => '',
      'order'      => ''
    ),
    'Call' => array(
      'className'  => 'Call',
      'foreignKey' => 'call_id',
      'conditions' => '',
      'fields'     => '',
      'order'      => ''
    ),
  );


  /**
   * Method used to return avg score of user
   *
   * @param integer $userId user id
   *
   * @return integer
   */
  public function userAvgScore($userId = null)
  {
    $score = 0;
    $option = array(
      'fields' => array('AVG(Vote.yield) AS userAvgScore'),
      'conditions' => array(
        'Vote.user_id' => $userId,
        'Vote.is_calculated' => 1,
        'Call.outcome_id >' => 0
      ),
      'contain' => array('Call'),
    );
    $userScore = $this->find('all', $option);

    $score = $userScore[0][0]['userAvgScore'];

    return $score;
  }//end userAvgScore()


  /**
   * Method used to return number of call made by user
   *
   * @param integer $userId user id
   *
   * @return integer
   */
  public function userGradedCall($userId = null)
  {
    $callNo = 0;
    $option = array(
      'conditions' => array(
        'Vote.user_id' => $userId,
        'Call.outcome_id >' => 0
      ),
      'contain' => array('Call'),
    );
    $callNo = $this->find('count', $option);

    return $callNo;
  }//end userGradedCall()


  /**
   * Method used to return number of correct call made by user
   *
   * @param integer $userId user id
   *
   * @return integer
   */
  public function userCorrectCall($userId = null)
  {
    $correctCalls = 0;

    $query = "SELECT count(votes.id) AS correctCall
    FROM votes, calls, outcomes
    WHERE votes.call_id = calls.id
      AND calls.outcome_id = outcomes.id
      AND votes.user_id = $userId
      AND (abs(votes.rate-outcomes.rating) <= 0.25)
      AND (calls.outcome_id > 0)";

    $correctCalls = $this->query($query);

    return $correctCalls[0][0]['correctCall'];
  }//end userCorrectCall()


  /**
   * Method used to vote already exist for that user
   *
   * @param integer $userId user id
   * @param integer $callId call id
   *
   * @return array or boolean false
   */
  public function isExist($userId = null, $callId = null) {
    $isAlreadyPresent = $this->find(
      'first',
      array(
        'conditions' => array(
          'Vote.user_id' => $userId,
          'Vote.call_id' => $callId
        )
      )
    );
    return $isAlreadyPresent;
  }//end isExist()


  /**
   * Method used to get call for iframe
   *
   * @param integer $userId user id
   * @param integer $callId call id
   *
   * @return array or boolean false
   */
  public function getCallForIframe($callId = null, $userId = null) {

    $option = array(
      'conditions' => array(
        'Call.approved' => 1,
        'Call.id' => $callId
      )
    );
    $option['contain'] = array(
      'User',
      'Category',
      'Vote' => array(
        'conditions' => array(
          'user_id' => $userId
        )
      )
    );
    $this->Call->bindModel(
      array(
        'belongsTo' => array(
          'User' => array(
            'foreignKey'  => 'user_id',
            'type'        => 'inner',
          ),
        ),
      ), false
    );
    $calls = $this->Call->find('first', $option);

    return $calls;

  }// end getCallForIframe()


  /**
   * Method used to return yield for any one call's vote
   *
   * @param integer $data
   * @param integer $outcome
   *
   * @return integer
   */
  public function getUserYield($data = array(), $outcome = null) {
    if ($outcome) {
      if ($data['boldness'] == 1) {
        $tmpVar = $data['ptvariable'];
      } else {
        $tmpVar = $data['ptvariable']/(1 - $data['boldness']);
      }
    } else {
      $tmpVar = 0;
    }
    $yield = $tmpVar + (1 - $data['ptvariable']);
    return($yield);
  }//end getUserYield()


  /**
   * Method used to return boldness
   *
   * @param integer $ptVariable
   * @param integer $callId call id
   *
   * @return integer
   */
  /*public function getUserBoldness($ptVariable = null, $callId = null)
  {
    if ($ptVariable <= 1) {
      //calculating consensus
      $consensus = $this->getConsensus($callId);
      //calculating boldness
      $boldness = round(((float)(1 - $consensus)),2);
    } else {
      $boldness = 0;
    }
    return($boldness);
  }//end getBoldness()*/


  /**
   * Method used to return consensus
   *
   * @param integer $callId call id
   *
   * @return integer
   */
  public function getConsensus($callId = null)
  {
    //getting agreed people
    $option = array(
      'fields' => array('AVG(Vote.rate) AS avgVote'),
      'conditions' => array(
        'Vote.call_id =' => $callId,
      )
    );
    $votedPeople = $this->find('all', $option);

    return($votedPeople[0][0]['avgVote']);
  }//end getConsensus()


  /**
   * Method used to grade all vote by individual call and user
   *
   * @param array $userVoteCall all votes with user and calls data
   *
   * @return void
   */
  /*function gradeUserVote($userVoteCall = null) {
    $flag = true;
    foreach($userVoteCall as $votedCall) {
      if ($votedCall['Vote']['rate'] !== '0') {
        $PTvariable = abs($votedCall['Call']['Outcome']['rating'] - $votedCall['Vote']['rate']);

        $data['Vote']['id'] = $votedCall['Vote']['id'];
        $data['Vote']['user_id'] = $votedCall['Vote']['user_id'];
        $data['Vote']['ptvariable'] = $PTvariable;
        $data['Vote']['yield'] = $this->getUserYield($PTvariable, $votedCall['Vote']['call_id']);
        $data['Vote']['boldness'] = $this->getUserBoldness($PTvariable, $votedCall['Vote']['call_id']);
        $data['Vote']['is_calculated'] = 1;
        if ($this->save($data)) {
          $this->refreshUserScore($data['Vote']['user_id']);
        }
      }//rate 0 can not consider

    }//end foreach

    return $flag;

  }//end gradeUserVote()*/


  /**
   * Method used to refresh user yield, boldness and hit rate
   *
   * @param integer $userId user to be re - scored
   *
   * @return void
   */
  function refreshUserScore($userId = null) {
    $data['User']['id'] = $userId;
    $data['User']['score'] = $this->userAvgScore($userId);
    $data['User']['avg_boldness'] = $this->userAvgBoldness($userId);
    $data['User']['calls_graded'] = $this->userGradedCall($userId);
    $data['User']['calls_correct'] = $this->userCorrectCall($userId);

    $this->User->save($data);

  }//end refreshUserScore()


  /**
   * method used to return boldness for the user
   *
   * @param integer $userId user id
   *
   * @return integer
   */
  public function userAvgBoldness($userId = null)
  {
    $boldness = 0;
    $option = array(
      'fields'     => array('AVG(Vote.boldness) AS boldnessAvg'),
      'conditions' => array(
        'Vote.user_id'       => $userId,
        'Vote.is_calculated' => 1,
        'Call.outcome_id >' => 0
      ),
      'contain' => array('Call'),
    );
    $userBoldness = $this->find('all', $option);

    $boldness = $userBoldness[0][0]['boldnessAvg'];

    return ($boldness*100);
  }//end userBoldness()


  /**
   * method used to return boldness for the user
   *
   * @param integer $callData call array
   * @param integer $callId   call id
   *
   * @return integer
   */
  function updateVotedUserScore($callData = array(), $callId = null) {
    $option = array(
      'conditions' => array('call_id' => $callId),
      'contain' => false
    );
    $users = $this->find('all', $option);
    if (!empty($users)) {
      foreach ($users as $user) {
        //below function returns boldness and ptvariable
        $data = $this->getBoldnessAndPtVariableByUserRate($user['Vote']['rate'], $callData['boldness']);
        $data['id'] = $user['Vote']['id'];
        //returns outcome as true/false
        $adminRate = ClassRegistry::init('Outcome')->field('rating', array('id' => $callData['outcome_id']));
        $result = abs(bcsub($adminRate, $user['Vote']['rate'], 2));

        if ($result <= 0.25) {
          $outcome = TRUE;
        } else {
          $outcome = FALSE;
        }
        //calculate voted user yield
        $data['yield'] = $this->getUserYield($data, $outcome);
        $data['is_calculated'] = 1;
        if ($this->save($data)) {
          $this->refreshUserScore($user['Vote']['user_id']);
        }
      }//end loop
    }

  }//end updateVotedUserScore()


  /**
   * method used to return boldness and ptvariable by user's vote
   *
   * @param integer $rate     rate
   * @param integer $boldness boldness
   *
   * @return array
   */
  function getBoldnessAndPtVariableByUserRate($rate = null, $boldness = null) {

    switch($rate) {
      case 0:
        $return = array(
          'boldness'   => 1 - $boldness,
          'ptvariable' => 1,
        );
        break;
      case 0.25:
        $return = array(
          'boldness'   => 1 - $boldness,
          'ptvariable' => 0.7,
        );
        break;
      case 0.75:
        $return = array(
          'boldness'   => $boldness,
          'ptvariable' => 0.7,
        );
        break;
      case 1:
        $return = array(
          'boldness'   => $boldness,
          'ptvariable' => 1,
        );
        break;
    }

    return $return;

  }//end getBoldnessAndPtVariableByUserRate()


  /**
   * Method used to return user ranking
   *
   * @param integer $userId user id
   *
   * @return array
   */
  function userRanking($userId = null) {
    $conditions = array(
      'Vote.is_calculated' => true,
      'User.calls_graded >=' => Configure::read('top_user_votes_graded_limit'),
    );
    $adminIds = Configure::read('admin_ids');
    if (!empty($adminIds)) {
      $conditions['User.id NOT'] = $adminIds;
    }
    $option = array(
      'fields' => array('User.id', 'User.score'/*, 'count(Vote.user_id) AS voteCount'*/),
      'joins' => array(
        array(
          'table' => 'votes',
          'alias' => 'Vote',
          'type' => 'INNER',
          'conditions' => array('User.id = Vote.user_id')
        )
      ),
      'conditions' => $conditions,
      //'group' => 'Vote.user_id HAVING count(Vote.user_id) >= '.configure::read('user_votes_graded_limit'),
      'group' => 'Vote.user_id',
      'order' => array('User.Score DESC' , 'User.calls_graded DESC', 'User.id ASC')
    );

    $option['contain'] = array('Aro');
    $this->User->bindModel(
      array(
        'hasOne' => array(
          'Aro' => array(
            'foreignKey' => 'foreign_key',
            'type' => 'inner',
            'conditions' => array(
             'Aro.parent_id' => Configure::read('general_user_group_id')
            ),
          ),
        ),
      ), false
    );

    $users = $this->User->find('all', $option);

    $rank = 'N/A';
    if (!empty($users)) {
      foreach($users as $pos => $user) {
        if ($user['User']['id'] == $userId) {
           $rank = 1 + $pos;
           break;
        }
      }
    }
    $ranking = array(
      'rank' => $rank,
      'totalUser' => count($users)
    );
    return $ranking;

  }//end userRanking()



  /**
   * method used to return top user
   *
   * @return array
   */
  public function getTopUser()
  {
    $conditions = array(
      'Vote.is_calculated' => true,
      'User.private' => 0,
      'User.calls_graded >=' => Configure::read('top_user_votes_graded_limit'),
    );
    $adminIds = Configure::read('admin_ids');
    if (!empty($adminIds)) {
      $conditions['User.id NOT'] = $adminIds;
    }
    $option = array(
      'fields'     => array('*', 'count(Vote.user_id) as userVote'),
      'conditions' => $conditions,
      'contain'    => false,//array('Vote'),
      //'group'      => 'Vote.user_id having count(Vote.user_id) >= '.Configure::read('top_user_votes_graded_limit'),
      'group'      => 'Vote.user_id',
      'order'      => 'User.score DESC, User.calls_graded DESC, User.id ASC',
      'limit'      => 3,
      'joins' => array(
        array(
          'table' => 'votes',
          'alias' => 'Vote',
          'type' => 'INNER',
          'conditions' => array('User.id = Vote.user_id')
        )
      ),
    );

    $topUser = $this->User->find('all', $option);

    return $topUser;
  }//end getTopUser()

  /**
   * method used to show top 3 user on bases of Average yield
   *
   * @return array
   */
  function topUsers() {
   $topUser = $this->find('all',
                            array(
                              'fields' => 
                              array(
                                'user_id', 'User.first_name', 'User.last_name', 'User.avatar', 
                                'User.fb_id', '(User.score - 1) * ( User.calls_graded ) AS earned',
                                'User.score', 'User.calls_graded', 'User.calls_correct',
                                '(User.calls_correct / User.calls_graded) * 100 as hitrate'  
                              ),
                              'conditions' => 
                              array(
                                'Vote.is_calculated' => true,
                                'User.private' => 0,
                                'User.calls_graded >=' => Configure::read('top_user_votes_graded_limit'),
                              ),
                              'group' => 'user_id',
                              'order' => 'User.score DESC, User.calls_graded DESC, User.id ASC',
                              'contain' => 
                              array(
                                'User'
                              ),
                              'limit' => 3
                            )
                          );
   return $topUser;
  }// end topUsers

  /**
   * method used to show top 3 most accurate users
   *
   * @return array
   */
  function mostAccurateUsers() {
    $mostAccurateUser = $this->find('all',
                                      array(
                                        'fields' => 
                                        array(
                                          'user_id', 'User.first_name', 'User.last_name', 
                                          'User.avatar', 'User.fb_id', 'User.score',
                                          'User.calls_graded', 'User.calls_correct',
                                          '(User.calls_correct / User.calls_graded) * 100 as hitrate', 
                                          '(User.score - 1) * ( User.calls_graded ) AS earned'
                                        ),
                                        'group' => 'user_id',
                                        'order' => '(User.calls_correct / User.calls_graded) * 100 DESC,
                                                    User.calls_graded desc',
                                        'contain' => 
                                        array(
                                          'User'
                                        ),
                                        'limit' => 3
                                      )
                                    );
    return $mostAccurateUser;
  }// end mostAccurateUsers

/**
   * method used to top 3 earned users
   *
   * @return array
   */
  function lifeTimeLeaders() {
    $lifeTimeLeader = $this->find('all',
                            array(
                              'fields' => 
                              array(
                                'user_id', 'User.first_name', 'User.last_name', 'User.avatar', 
                                'User.fb_id', '(User.score - 1) * ( User.calls_graded ) AS earned',
                                'User.score', 'User.calls_graded', 'User.calls_correct',
                                '(User.calls_correct / User.calls_graded) * 100 as hitrate', 'count(Vote.user_id) as voteon '
                              ),
                              'group' => 'user_id',
                              'order' => '(User.score - 1) * ( User.calls_graded ) DESC',
                              'contain' => 
                              array(
                                'User'
                              ),
                              'limit' => 3
                            )
                          );
     
    return $lifeTimeLeader;
  }// end lifeTimeLeaders

  

}//end class
