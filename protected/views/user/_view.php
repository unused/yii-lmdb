<div class="view">
  <img src="/images/uploads/avatar/<?php echo $data->username ?>.jpg" class="avatar"/>
	<?php echo CHtml::encode($data->username); ?>
  <p class="small">
    last login <?php echo Yii::app()->dateFormatter->formatDateTime($data->last_login_at,'short'); ?>,
    joined on <?php echo Yii::app()->dateFormatter->formatDateTime($data->created_at,'short'); ?>
  </p>
  <?php if($data->username!=Yii::app()->user->name): ?>
    browse <?php echo CHtml::link($data->username.'\'s Movie-Library', array('movie/index', 'username'=>$data->username)) ?>
    <br />
    browse <?php echo CHtml::link($data->username.'\'s Movie-Wishlist', array('movie/wishlist', 'username'=>$data->username)) ?>
  <?php endif ?>
  <br class="clear"/>
</div>