<?php 
//array contains vote options
$optionRadio  = Configure::read('radio_vote_option'); ?>
<?php
//if logged in as admin
if ($this->Session->read('Auth.User.userGroup') == 'Admin') {
  $className = "";
  $tableClass = "table_box admin_table_box admin_table_yellow";
} else {
  //logged in as general user
  $className = "last";
  $tableClass = "table_box table_box4";
} ?>
<table class="<?php echo $tableClass;?>" id="tableToSort">
  <tr>
    <?php if(isset($live_archive_call)) { ?>
      <th class="col1"><span>Pundit</span></th>
      <th class="col2"><span>Prediction</span></th>
      <th class="col4"><span>Date Made</span></th>
      <th class="col4"><span>Date Due</span></th>
      <th class="col6"><span>Vote Until</span></th>
      <th class="col7"><span>Link/Source</span></th>
      <th class="col5"><span>Boldness</span></th>
      <th class="col8 <?php echo $className; ?> last"><span>My Vote</span></th>
    <?php } else {?>
      <th class="col1"><?php echo $this->Paginator->sort('User.first_name', 'Pundit', array('class' => 'sort_down'));?></th>
      <th class="col2"><?php echo $this->Paginator->sort('Call.prediction', 'Prediction', array('class' => 'sort_down'));?></th>
      <?php if ($categoryId == 'all') { ?>
      <th class="col7"><span>Category</span></th>
      <?php } ?>
      <th class="col4"><?php echo $this->Paginator->sort('Call.created', 'Date Made', array('class' => 'sort_down'));?></th>
      <th class="col4"><?php echo $this->Paginator->sort('Call.due_date', 'Date Due', array('class' => 'sort_down'));?></th>
      <th class="col6"><?php echo $this->Paginator->sort('Call.vote_end_date', 'Vote Until', array('class' => 'sort_down'));?></th>
      <th class="col7"><span>Link/Source</span></th>
      <th class="col5"><span>Boldness</span></th>
      <th class="col8 <?php echo $className; ?> last"><span>My Vote</span></th>
    <?php } ?>
  </tr>
  <?php
  if (empty($liveCallData)) {
  ?>
    <tr>
      <td class="noRecord" colspan='9'>No Records found</td>
    </tr>
  <?php
  } else {
    foreach ($liveCallData as $key => $call) {
      if (count($call) > 0) {
        $class = '';
        if (($key % 2) == 0) {
          $class = 'odd';
        }
        ?>
        <tr class="<?php echo $class; ?>">
          <td>
            <?php
            if ($this->Session->read('Auth.User.userGroup') == 'Admin') {
              echo $this->Html->link(
                __('edit'),
                array(
                  'admin' => true,
                  'controller' => 'calls',
                  'action' => 'edit',
                  $call['Call']['id']
                ),
                array(
                  'class' => 'row_link',
                  'id' => 'editCallSuggestionId',
                  'mobile' => $isMobile
                )
              );
            }
            echo $this->Html->link(
              $call['User']['first_name'].' '.$call['User']['last_name'],
              array(
                'controller' => 'pundits',
                'action' => 'profile',
                $call['User']['slug']),
                array()
            );
            ?>
          </td>
          <td class="preFirst"><?php echo $call['Call']['prediction']; ?></td>
          <?php if ($categoryId == 'all') { ?>
            <td class="preFirst"><?php echo $call['Category']['name']; ?></td>
          <?php } ?>
          <td class="td_center"><?php echo $this->PT->dateFormat($call['Call']['created']); ?></td>
          <td class="td_center"><?php echo $this->PT->dateFormat($call['Call']['due_date']); ?></td>
          <td class="td_center">
            <?php
            if ($call['Call']['vote_end_date'] >= date('Y-m-d')) {
              echo $this->PT->dateFormat($call['Call']['vote_end_date']);
            } else { ?>
              <span class="">Closed</span>
            <?php
            }
            ?>
          </td>
          <td class="td_center"><?php echo $call['Call']['source']; ?></td>
          <td class="td_center"><?php if($this->PT->callBoldness($call['Call']['boldness'], true) == "TBD" ) {
                    echo $this->Html->image('tbd.png', array('alt' => 'TBD'));;
                  }else {
                    echo $this->PT->callBoldness($call['Call']['boldness'], true);
                  } ?></td>
          <td class="td_center <?php echo $className; ?> last">
            <?php
              if (isset($call['Vote']['rate'])) {
                if ($call['Call']['vote_end_date'] >= date('Y-m-d')) {
                  if (!empty($isMobile)) {
                    $pageUrl = array(
                      'controller' => 'users',
                      'action'     => 'login',
                      'admin'      => false,
                    );
                    if ($this->Session->read('Auth.User.id')) {
                      $pageUrl = array(
                        'controller' => 'votes',
                        'action'     => 'add',
                        'admin' => false,
                        $call['Call']['id'],
                      );
                    }

                    echo $this->Html->link(
                      $optionRadio[$call['Vote']['rate']],
                      $pageUrl,
                      array(
                        'id' => 'call'.$call['Call']['id'],
                        //'class' => 'editVoteLink',
                      )
                    );
                  } else {
                    echo $this->Html->link(
                      $optionRadio[$call['Vote']['rate']],
                      '',
                      array(
                        'id' => 'call'.$call['Call']['id'],
                        'class' => 'editVoteLink',
                        'callId' => $call['Call']['id']
                      )
                    );
                  }
                } else {
                  echo '<span class="no_btn">' . $optionRadio[$call['Vote']['rate']] . '</span>';
                }
              } else {
                if ($call['Call']['vote_end_date'] >= date('Y-m-d')) {
                  if (!empty($isMobile)) {
                    $pageUrl = array(
                      'controller' => 'users',
                      'action'     => 'login',
                      'admin'      => false,
                    );
                    if ($this->Session->read('Auth.User.id')) {
                      $pageUrl = array(
                        'controller' => 'votes',
                        'action'     => 'add',
                        'admin' => false,
                        $call['Call']['id'],
                      );
                    }

                    echo $this->Html->link(
                      __('Vote Now'),
                      $pageUrl,
                      array(
                        'id' => 'call'.$call['Call']['id'],
                        'class' => 'btn_vote_now_m',
                      )
                    );
                  } else {
                    echo $this->Html->link(
                      __('Vote Now'),
                      '',
                      array(
                        'id' => 'call'.$call['Call']['id'],
                        'class' => 'btn_vote_now',
                        'callId' => $call['Call']['id']
                      )
                    );
                  }
                } else { ?>
                  <span class="btn_closed">Closed</span>
              <?php
                }
              } ?>
          </td>
        </tr>
      <?php
      }
    }
  } ?>
</table>
<script type="text/javascript">
$(function(){

  selector = $(".asc, .desc").parent("th");
  var index = $(selector).index();
  $("table#tableToSort tr").each(function() {
    $(this).children("td:eq("+index+")").addClass("sort_on");
  });

  //table icon js
  // $.fn.make_el_absolute = function() {
  //   var $el;
  //   return this.each(function() {
  //     $el = $(this);
  //     var newDiv = $("<div />", {
  //       "class": "btn_wrap",
  //       "css"  : {
  //         "height"  : $el.height(),
  //         "position": "relative"
  //       }
  //     });
  //     $el.wrapInner(newDiv);
  //   });
  // };
  // $(".table_box td").make_el_absolute();
  //end table icon js

});//end jquery ready

$(document).ready( function(){
  //table icon js
  $.fn.make_el_absolute = function() {
    var $el;
    return this.each(function() {
      $el = $(this);
      var newDiv = $("<div />", {
        "class": "btn_wrap",
        "css"  : {
          "height"  : $el.height(),
          "position": "relative"
        }
      });
      $el.wrapInner(newDiv);
    });
  };
  $(".admin_table_box td").make_el_absolute();
  //end table icon js
});
</script>
