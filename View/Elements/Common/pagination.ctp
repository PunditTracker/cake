<div class="table_pages">
    <?php
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
        'modulus' => 6,
        'separator' => '|',
        'tag' => 'span',
        'currentClass' => 'on'
      )
    );
    echo $this->Paginator->next(
      '&raquo;',
      array(
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

