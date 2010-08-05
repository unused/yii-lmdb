<div class="view">
  <p>
    <?php echo CHtml::link(CHtml::image($data->getCover(), $data->get('name'), array('class'=>'left')), array('view', 'id'=>$data->id)) ?>
    <h4>
      <?php echo CHtml::encode(utf8_decode($data->get('name'))) ?>
      <?php if($data->get('released')): ?>
        (<?php echo $data->getReleaseYear() ?>)
      <?php endif ?>
    </h4>
    <br class="clear"/>
  </p>
</div>