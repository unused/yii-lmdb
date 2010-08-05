<div class="filter pager">
  <ul class="yiiPager">
    <?php foreach(range('A','Z') as $filter): ?>
      <li class="page <?php if($filter===CHttpRequest::getQuery('filter')) echo 'selected' ?>">
        <?php echo CHtml::link($filter, $this->createUrl('',array_merge($_GET,array('filter'=>$filter)))) ?>
      </li>
    <?php endforeach ?>
  </ul>
</div>
