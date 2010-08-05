<?php $this->pageTitle=Yii::app()->name.' - '.$model->get('name') ?>
<?php if(!Yii::app()->user->isGuest): ?>
  <?php $this->breadcrumbs=array('Movies'=>array('index'),$model->get('name')) ?>
<?php endif ?>

<div id="movie-view">
  <div class="span-12">
    <?php $this->widget('CStarRating',array(
        'name'=>'rating',
        'value'=>$model->getMyRating(),
        'callback'=>'
            function(){
            $.ajax({
                type: "POST",
                url: "'.Yii::app()->createUrl('movie/rating').'",
                data: "id='.$model->id.'&rate=" + $(this).val(),
        })}',
        'resetValue'=>0,
    ));?>
    <br />
    <h2 class="title">
      <?php echo CHtml::link($model->get('name'),array('movie/view','url_key'=>$model->url_key)) ?>
      <?php echo $model->getReleaseYear() ?>
    </h2>
    <?php if($model->get('alternative_name')): ?>
      <h3><?php echo $model->get('alternative_name') ?></h3>
    <?php endif ?>

    <?php $this->renderPartial('_info',array('movie'=>$model)) ?>

    <p class="overview"><?php echo $model->get('overview') ?></p>

    <?php $this->renderPartial('_cast',array('movie'=>$model)) ?>
  </div>

  <div class="span-6">
    <div id="cover" class="cycle-fade">
      <?php foreach($model->getCovers() as $image): ?>
        <?php echo CHtml::image($image['url'], $model->get('name'), array('width'=>$image['width'],'height'=>$image['height'])) ?>
      <?php endforeach ?>
    </div>
    <div id="backdrops">
      <ul>
        <?php $label=CHtml::image('/images/screenshots.png'); ?>
        <?php foreach($model->getPoster('backdrop') as $image): ?>
          <li><?php echo CHtml::link($label, $image['url']);$label=''; ?></li>
        <?php endforeach ?>
      </ul>
    </div>
  </div>

  <div class="span-5 last">
    <?php if(!Yii::app()->user->isGuest): ?>
      <div id="movie-relation-update">
        <?php $this->renderPartial('_relations',array('movie'=>$model)) ?>
      </div>
    <?php endif ?>
    <br class="clear" />
    <div id="comments">
      <?php if(!Yii::app()->user->isGuest): ?>
        <div class="comment-form">
          <?php $this->renderPartial('/comment/_form',array('model'=>(isset($comment))?($comment):(new Comment()),)); ?>
        </div>
      <?php endif ?>
      <?php if(($count=count($model->comments))>=1): ?>
          <?php $this->renderPartial('_comments',array( 'movie'=>$model, 'comments'=>$model->comments)); ?>
      <?php else: ?>
          <p>Noch keine Kommentare</p>
      <?php endif; ?>
    </div>
  </div>
</div>

<br class="clear" />

<?php if(Yii::app()->user->name == 'admin'): ?>
<!--
<?php echo CHtml::link('edit',array('movie/update','id'=>$model->id)) ?>
<div style="text-align:center;width:100%;">
  <div id="debug" style="height: 100px; width: 300px; overflow: auto;">
  <dl>
    <?php foreach($model->attributes as $attribute): ?>
      <dt><?php echo $attribute['code'] ?></dt>
      <dd><?php echo $attribute['value'] ?></dd>
    <?php endforeach ?>
  </dl>
  </div>
</div>
-->
<?php endif ?>