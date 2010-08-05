<?php
$this->breadcrumbs=array(
	'Features'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Feature', 'url'=>array('index')),
	array('label'=>'Create Feature', 'url'=>array('create')),
	array('label'=>'View Feature', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage Feature', 'url'=>array('admin')),
);
?>

<h1>Update Feature Request <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>