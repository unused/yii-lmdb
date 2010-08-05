<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
    'id'=>'comment-form',
    'enableAjaxValidation'=>true,
)); ?>
  <?php echo $form->hiddenField($model,'type',array('size'=>60,'maxlength'=>128));    ?>
  <?php echo $form->hiddenField($model,'type_id',array('size'=>60,'maxlength'=>128)); ?>

  <div class="row">
    <?php echo $form->errorSummary($model); ?>
    <?php echo $form->textArea($model,'comment',array('rows'=>2, 'cols'=>23)); ?>
  </div>

  <div class="row buttons">
    <?php echo CHtml::imageButton('/images/comment.png'); ?>
  </div>
  <br class="clear" />
<?php $this->endWidget(); ?>

</div><!-- form -->