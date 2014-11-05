<?php
/**
 * File used as Suggestedcall model
 *
 * Contains code needed mainly for Suggestedcall controller
 *
 * @category Model
 */

/**
 * Suggestedcall model class
 *
 * @category Model
 */
class SuggestedCall extends AppModel 
{

   /**
   * Property is used to hold the string.
   *
   * @var string to be implemented
   *
   * @since 1.0.0
   */
  public $name = 'SuggestedCall';

  /**
   * Property is used to hold the string.
   *
   * @var string to be implemented
   *
   * @since 1.0.0
   */
  public $displayField = 'name';


 /**
   * array to hold behavior.
   *
   * @return void
   */
  public $actsAs = array(
    'Containable',
    'Sluggable' => array(
      'label'     => 'prediction',
      'slug'      => 'slug',
      'separator' => '-',
      'overwrite' => true
    )
  );

  /**
   * hasMany associations
   *
   * @var array
   */
  public $hasMany = array(
    'Vote' => array(
      'className'     => 'Vote',
      'foreignKey'    => 'call_id',
      'conditions'    => '',
      'order'         => '',
      //'limit'         => '5',
      'dependent'     => true
    ),
    'SuggestedCall',
  );


  /**
   * belongsTo associations
   *
   * @var array
   */
  public $belongsTo = array(
    'User' => array(
      'className'  => 'User',
      'foreignKey' => 'suggested_by_user_id',
      'conditions' => '',
      'fields'     => '',
      'order'      => ''
    ),
    'Category' => array(
      'className'  => 'Category',
      'foreignKey' => 'category_id',
      'conditions' => '',
      'fields'     => '',
      'order'      => ''
    ),
    'Pundit' => array(
      'className'  => 'Pundit',
      'foreignKey' => 'user_id',
      'conditions' => '',
      'fields'     => '',
      'order'      => ''
    ),
    'Outcome' => array(
      'className'  => 'Outcome',
      'foreignKey' => 'outcome_id',
      'conditions' => '',
      'fields'     => '',
      'order'      => ''
    ),
  );


  /**
   * Validation rules
   *
   * @var array
   */
  public $validate = array(
    'pundit_name' => array(
      'notempty' => array(
          'rule' => array('notempty'),                
      ),
    ),
    'prediction' => array(
        'notempty' => array(
            'rule' => array('notempty'),
        ),
    ),
    'category_id' => array(
        'notempty' => array(
            'rule' => array('notempty'),
        ),
    ),
    'user_id' => array(
        'notempty' => array(
            'rule' => array('notempty'),
        ),
    ),
    'source' => array(
        'notempty' => array(
            'rule' => array('notempty'),
        ),
    ),
    'created' => array(
        'notempty' => array(
            'rule' => array('notempty'),
        ),
    ),
    'due_date' => array(
      'required' => array(
        'rule' => array('notempty'),
        'message' => 'Please select',
      ),
      'confirm' => array(
        'rule'    => array('dueDateLimit'),
        'message' => 'Due date is incorrect',
      )
    ),
    'vote_end_date' => array(
      'required' => array(
        'rule' => array('notempty'),
        'message' => 'Please select',
      ),
      //'confirm' => array(
      //  'rule'    => array('voteEndLimit'),
      //  'message' => 'Vote end date is incorrect',
      //)
    ),
    'ptvariable' => array(
      'numeric' => array(
        'rule' => array('numeric'),
      )
    ),
   'boldness' => array(
      'numeric' => array(
        'rule' => array('numeric'),
      )
    ),
  );


  /**
   * Property is used to declare virtual fields
   *
   * @var string $virtualFields array of virtual fields
   */
  public $virtualFields = array();


  /**
   * Property is used to set pundit id on delete SuggestedCall
   *
   * @var string $callPunditId array of virtual fields
   */
  public $callPunditId = null;


  /**
   * Property is used to set voted user id on delete SuggestedCall
   *
   * @var string $votedUserId array of fields
   */
  public $votedUserId = array();

public function beforeSave($options = array()) {

    if (isset($this->data['SuggestedCall']['id'])) {
            unset($this->data['SuggestedCall']['id']);
    }
    if(isset($this->data['SuggestedCall']['due_date'])) {
      $this->data['SuggestedCall']['due_date'] = date('Y-m-d H:i:s', strtotime($this->data['SuggestedCall']['due_date']));
    }
    if(isset($this->data['SuggestedCall']['vote_end_date'])) {
      $this->data['SuggestedCall']['vote_end_date'] = date('Y-m-d H:i:s', strtotime($this->data['SuggestedCall']['vote_end_date']));
    }
    if(isset($this->data['SuggestedCall']['created'])) {
      $this->data['SuggestedCall']['created'] = date('Y-m-d H:i:s', strtotime($this->data['SuggestedCall']['created']));
    }
    return true;
  }//end beforeSave()
 


  /**
   * Callback method used before validating fields
   *
   * @param array $options Options passed from model::save(), see $options of model::save().
   *
   * @return boolean true or false
   */
  function beforeValidate($options = array()) {

    if (!empty($this->data['SuggestedCall']['csv_file'])) {

      $this->virtualFields[] = 'file';
      $this->validate += array(
        'csv_file' => array(
          'extension' => array('rule' => array('extension', array('csv'))),
        ),
      );
    }
  }//end beforeValidate();


  /**
   * callback function
   *
   * @return void.
   */
  public function dueDateLimit() {
    //return true when due date is greater that date made
    return greaterDate($this->data['SuggestedCall']['created'], $this->data['SuggestedCall']['due_date']);
  }//end dueDateLimit()


  /**
   * callback function
   *
   * @return void.
   */
  /*public function voteEndLimit() {

    $votEndDate = $this->data['Call']['vote_end_date'];

    return (greaterDate($this->data['Call']['created'], $votEndDate) &&
    greaterDate($votEndDate, $this->data['Call']['due_date'], true));
  }//end voteEndLimit()*/


  

  /**
   * method used to reload pundit score after deleting any SuggestedCall
   *
   * @param string $currentPunditId current pundit id
   *
   * @return array
   */
  private function __updatePunditScore($currentPunditId = null) {
 
    //saving avg score in pundits table
    $punditData['score'] = $this->punditScore($currentPunditId);
    //saving avg boldness in pundits table
    $punditData['avg_boldness'] = $this->punditBoldness($currentPunditId);
    //saving avg score in pundits table
    $punditData['calls_graded'] = $this->punditCallsGraded($currentPunditId);
    //saving avg score in pundits table
    $punditData['calls_correct'] = $this->punditCorrectCall($currentPunditId);

    $idInPunditTable = $this->Pundit->field('id', array('user_id' => $currentPunditId));
    $this->Pundit->id = $idInPunditTable;
    $this->Pundit->save($punditData);

  }//end __updatePunditScore()


  /**
   * method used to return pundits related categries
   *
   * @param int $punditId
   *
   * @return boolean
   */
  public function getPunditCategories($punditId = null)
  {
    $option = array(
      'conditions' => array(
        'Pundit.user_id' => $punditId,
      ),
      'contain' => 'Category'
    );
    $dataRow = $this->Pundit->find('first', $option);
    $i = 0;
    if (!empty($dataRow['Category'])) {
      foreach($dataRow['Category'] as $category) {
        $categories[$category['id']] = $category['name'];
      }
    }
    return($categories);
  }//end getPunditCategories()


  /**
   * method used to return boldness for the pundit
   *
   * @param integer $punditId pundit id
   *
   * @return integer
   */
  public function punditBoldness($punditId = null)
  {
    $boldness = 0;
    $option = array(
      'fields' => array('AVG(SuggestedCall.boldness) AS boldnessAvg'),
      'conditions' => array(
        'SuggestedCall.user_id' => $punditId,
        'SuggestedCall.outcome_id >' => 3
      ),
    );
    $punditBoldness = $this->find('all', $option);
    $boldness = $punditBoldness[0][0]['boldnessAvg'];
    //return $boldness;
    return ($boldness*100);
  }//end punditBoldness()


  /**
   * method used to return avg score of pundit
   *
   * @param integer $punditId pundit id
   *
   * @return integer
   */
  public function punditScore($punditId = null)
  {
    $score = 0;
    $option = array(
      'fields' => array('AVG(SuggestedCall.yield) AS punditAvgScore'),
      'conditions' => array(
        'SuggestedCall.user_id' => $punditId,
        'SuggestedCall.outcome_id >' => 0
      ),
    );
    $punditScore = $this->find('all', $option);
    $score = $punditScore[0][0]['punditAvgScore'];

    return $score;
  }//end punditScore()


  /**
   * method used to return number of SuggestedCall made by pundit
   *
   * @param integer $punditId pundit id
   *
   * @return integer
   */
  public function punditCallsGraded($punditId = null)
  {
    $option = array(
      'conditions' => array(
        'SuggestedCall.user_id' => $punditId,
        'SuggestedCall.outcome_id <>' => null,
        'SuggestedCall.outcome_id NOT' => array(0)
      )
    );
    $callNo = $this->find('count', $option);

    return $callNo;
  }//end punditCallsGraded()


  /**
   * method used to return number of correct SuggestedCall by pundit
   *
   * @param integer $punditId pundit id
   *
   * @return integer
   */
  public function punditCorrectCall($punditId = null)
  {
    $option = array(
      'conditions' => array(
        'SuggestedCall.user_id' => $punditId,
        'SuggestedCall.outcome_id >' => 3
      )
    );
    $callNo = $this->find('count', $option);

    return $callNo;
  }//end punditCorrectCall()


  /**
   * Method used to return yield for pundit
   *
   * @param array $data array of posted data
   * @param integer $callId SuggestedCall id
   *
   * @return integer
   */
  public function getPunditYield($data = null, $callId = null)
  {
    $outcomeId = $data['outcome_id'];
    $ptVariable = $data['ptvariable'];
    $boldness = $data['boldness'];
    $isCalculated = $data['is_calculated'];
    $tmpVar = 0;
    if ($outcomeId >= 4) {
      $tmpVar = $ptVariable;
      //calculating consensus

      if ($isCalculated) {
        $consensus = $this->User->Call->Vote->getConsensus($callId);
      } else {
        $consensus = 1 - $boldness;
      }
      //calculating yield
      if (!empty ($consensus)) {
        $tmpVar /= $consensus;
      }
    }
    
    $yield = round((float)($tmpVar + 1 - $ptVariable), 2);
    return($yield);
  }//end getPunditYield()


  /**
   * Method used to return boldness for pundit
   *
   * @param integer $outcome
   * @param integer $ptVariable
   * @param integer $callId SuggestedCall id
   *
   * @return integer
   */
  public function getPunditBoldness($outcomeId = null, $ptVariable = null, $callId = null)
  {
    $boldness = 0;

    //calculating consensus
    $consensus = $this->Vote->getConsensus($callId);

    //calculating boldness
    $boldness = ((float)(1 - $consensus));

    return($boldness);
  }//end getPunditBoldness()


  /**
   * method used to format csv data for application
   *
   * @param array $data csv import data
   * @param integer $params parameters
   *
   * @return array
   */
  function __getDataFromCSV($data = null, $params = array()) {

    if (isset($params['date_format']) && $params['date_format'] == 1) {

      $created = !empty($data[2]) ? dmyTomdy($data[2]) : '';
      $due_date = !empty($data[3]) ? dmyTomdy($data[3]) : '';
      $vote_end_date = !empty($data[4]) ? dmyTomdy($data[4]) : '';

    } elseif (isset($params['date_format']) && $params['date_format'] == 2) {

      $created = $data[2];
      $due_date = $data[3];
      $vote_end_date = $data[4];
    }

    if (!empty($data[9])) {
      $outcomeId = (strtolower($data[9]) == 'true') ? 5 : 1;
    } else {
      $outcomeId = null;
    }
    $validData = array(
      'user_id'       => $params['pundit_user_id'],
      'category_id'   => $params['category_id'],
      'prediction'    => trim($data[1]),
      'created'       => !empty($created) ? date('Y-m-d H:i:s', strtotime($created)) : '',
      'due_date'      => !empty($due_date) ? date('Y-m-d H:i:s', strtotime($due_date)) : '',
      'vote_end_date' => !empty($vote_end_date) ? date('Y-m-d H:i:s', strtotime($vote_end_date)) : '',
      'source'        => trim($data[5]),
      'ptvariable'    => $data[7],
      'outcome_id'    => $outcomeId,
      'yield'         => str_replace('$', '', $data[11]),
      'boldness'      => (str_replace('%', '', $data[12]))/100,
      'approved'      => 1,
      'approval_time' => date('Y-m-d H:i:s'),
    );

    return $validData;
  }//end __getDataFromCSV()

  
  
  
}//end class
