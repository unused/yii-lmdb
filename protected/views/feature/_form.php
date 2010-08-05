<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'feature-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'is_done'); ?>
		<?php echo $form->checkBox($model,'is_done'); ?>
		<?php echo $form->error($model,'is_done'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'priority'); ?>
    <?php echo CHtml::dropDownList('Feature[priority]','', array(1=>'High',2=>'Default',3=>'Low')) ?>
		<?php echo $form->error($model,'priority'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'label'); ?>
		<?php echo $form->textField($model,'label',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'label'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'description'); ?>
		<?php echo $form->textArea($model,'description',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'description'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->