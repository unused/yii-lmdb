<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'movie-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'tmdb_id'); ?>
		<?php echo $form->textField($model,'tmdb_id'); ?>
		<?php echo $form->error($model,'tmdb_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'imdb_id'); ?>
		<?php echo $form->textField($model,'imdb_id'); ?>
		<?php echo $form->error($model,'imdb_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'url_key'); ?>
		<?php echo $form->textField($model,'url_key',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'url_key'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->