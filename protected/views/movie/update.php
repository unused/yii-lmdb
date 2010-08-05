<?php
$this->breadcrumbs=array(
	'Movies'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Movie', 'url'=>array('index')),
	array('label'=>'Create Movie', 'url'=>array('create')),
	array('label'=>'View Movie', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage Movie', 'url'=>array('admin')),
);
?>

<h1>Update Movie <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>