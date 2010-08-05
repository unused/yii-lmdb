<?php
$this->breadcrumbs=array(
	'Features'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Feature', 'url'=>array('index')),
	array('label'=>'Manage Feature', 'url'=>array('admin')),
);
?>

<h1>Create Feature Request</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>