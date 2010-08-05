<?php
$this->breadcrumbs=array(
	'Search',
);?>

<h1>Searchresults</h1>
<?php if(is_array($content=$callback->getContent())): ?>
  <ul>
    <?php foreach($content as $info): ?>
      <li>
        <?php echo CHtml::link($info['name'], array('movie/tmdb','id'=>$info['id'])) ?>
        <?php if($info['released']) echo '('.substr($info['released'],0,4).')' ?>
      </li>
    <?php endforeach ?>
  </ul>
<?php endif ?>
