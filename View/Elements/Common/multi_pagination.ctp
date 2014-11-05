<div class="table_pages">
    <?php
    if (!isset($action)) {
      $action = '';
    }
    $update = !empty($divId) ? $divId : 'content';
    if ($this->name == 'Pundits' || $this->name == 'Categories') {
      if ($model == 'Call' && $action == 'live') {
        $url = array('action' => 'profile_calls', $keyId);  
      } else if($model == 'CallDummy' && $action == 'pundit_archive') {
        $url = array('action' => 'profile_calls', $keyId, 'archive' => true);
      } else if ($model == 'CallDummy') {
        $url = array('action' => 'view_all_calls', $keyId, 'archive' => true);
      } else if($model == 'Call' && $action == 'history') {
        $url = array('action' => 'history', $keyId);
      } else if($model == 'Call' && $action == 'category_view') {
        $url = array('action' => 'view_all_calls', $keyId);
      }  
    } else if($this->name == 'Users') {
      if ($model == 'Call') {
        $url = array('action' => 'profile_calls', $keyId);
      } else if($model == 'CallDummy') {
        $url = array('action' => 'profile_calls', $keyId, 'archive' => true);
      } else if($model == 'User') {
        $url = array('action' => 'admin_index');
      } else if($model == 'Vote') {
         $url = array('action' => 'user_leaderboard');
      }
    } else if($this->name == 'Calls') {
      if ($model == 'Call' && $action == 'history') {
        $url = array('action' => 'history', $keyId);
      } else if($model == 'CallDummy') {
        $url = array('action' => 'admin_all');
      } else if($model == 'Call' && $action == 'search') {
        $url = array('action' => 'search');
      } else if($model == 'Call') {
        $url = array('action' => 'admin_index');
      }
    } else if($this->name == 'SuggestedPundits') {
      if ($model == 'SuggestedPundit') {
        $url = array('action' => 'admin_index');
      }
      } else if($this->name == 'SuggestedCalls') {
      if ($model == 'SuggestedCall') {
        $url = array('action' => 'admin_index');
      } 
    } 
       

    echo $this->Paginator->options(array(
        //'update' => "#$update", // Disable the ajax pagination
        'url' => $url,
        'evalScripts' => false,
        'before' => $this->Js->get('#busy-indicator')->effect('fadeIn', array('buffer' => false)),
        'complete' => $this->Js->get('#busy-indicator')->effect('fadeOut', array('buffer' => false)),
      )
    );
    echo $this->Paginator->first(
      '&#124;&laquo;',
      array(
        'model' => $model,
        'tag' => 'span',
        'escape' => false
      )
    );
    echo $this->Paginator->prev(
      '&laquo;',
      array(
        'model' => $model,
        'tag' => 'span',
        'escape' => false
      ),
      null,
      array(
        'class' => 'disabled',
        'tag' => 'span',
        'escape' => false
      )
    );
    echo $this->Paginator->numbers(
      array(
        'model' => $model,
        'modulus' => 6,
        'separator' => '',
        'tag' => 'span',
        'currentClass' => 'on'
      )
    );
    echo $this->Paginator->next(
      '&raquo;',
      array(
        'model' => $model,
        'tag' => 'span',
        'escape' => false
      ),
      null,
      array(
        'class' => 'disabled',
        'tag' => 'span',
        'escape' => false
      )
    );
    echo $this->Paginator->last(
      '&raquo;&#124;',
      array(
        'model' => $model,
        'tag' => 'span',
        'escape' => false
      )
    );
    ?>
</div>

