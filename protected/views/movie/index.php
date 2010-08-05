<?php
$this->pageTitle=Yii::app()->name . ' - Movies';

$this->breadcrumbs=array(
	'Movies',
);

$this->menu=array(
);
?>

<img src="/images/uploads/avatar/<?php echo CHttpRequest::getQuery('username',Yii::app()->user->name)?>.jpg" class="avatar"/>
<?php if($username=CHttpRequest::getQuery('username')): ?>
  <h1>Movie-Library of <?php echo $username ?></h1>
<?php else: ?>
  <h1>Your Movie-Library</h1>
<?php endif ?>

<?php $this->renderPartial('_filter'); ?>

<br class="clear"/>

<?php
  $this->widget('zii.widgets.CListView', array(
    'dataProvider'=>$dataProvider,
    'itemView'=>'_view',
    'template'=>'{summary}{pager}{items}<br class="clear"/>{pager}',
    ));
?>
