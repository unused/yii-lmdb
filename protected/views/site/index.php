<?php $this->pageTitle=Yii::app()->name.' - Dashboard'; ?>

<?php
$this->widget('zii.widgets.jui.CJuiAccordion', array(
    'panels'=>array(
        'Recent Comments'=>$this->renderPartial('_list',
            array('items'=>Comment::model()->recent()->findAll()),true),
//         'Top Movies'=>$this->renderPartial('_list',
//             array('items'=>MovieAttributes::model()->top()->findAll()),true),
        'LMDB Popular Movies'=>$this->renderPartial('_list',
            array('items'=>Movie::model()->popular()->findAll()),true),
        'Top Public Movies'=>$this->renderPartial('_list',
            array('items'=>MovieAttributes::model()->top()->findAll()),true),
        'Recent Added Movies'=>$this->renderPartial('_list',
            array('items'=>Movie::model()->recent()->findAll()),true),
        'Recent Searches'=>$this->renderPartial('_list',
            array('items'=>SearchLog::model()->recent()->findAll()),true),
    ),
    'options'=>array(
        'animated'=>'bounceslide',
    ),
));
?>