<div class="slider_holder">
  <ul class="slider">
    <li>
      <?php
        echo $this->Html->image(
          'slide1.jpg',
          array(        
            'alt' => '',
            'width' => "640",
            'height' => '235'
          )
        );
      ?>         
    </li>
    <li class="hide">
      <?php
        echo $this->Html->image(
          'slide2.jpg',
          array(        
            'alt' => '',
            'width' => "640",
            'height' => '235'
          )
        );
      ?>          
    </li>
    <li class="hide">
      <?php
        echo $this->Html->image(
          'slide3.jpg',
          array(        
            'alt' => '',
            'width' => "640",
            'height' => '235'
          )
        );
      ?>    
    </li>
  </ul>
  <div class="slider_control"></div>
</div><!--end of slider_holder-->