<?php $this->breadcrumbs=array('Users'=>array('index'),$model->id=>array('view','id'=>$model->id),'Update',)?>

<h1>Update <?php echo $model->username; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>