<?php
$this->breadcrumbs=array(
	'Movies'=>array('index'),
  'Import'
);

?>

<?php echo CHtml::form(array('movie/import')) ?>
  <?php echo CHtml::textarea('movies', '', array('cols'=>45,'rows'=>17)) ?>
  <?php echo CHtml::linkButton('import') ?>
<?php echo CHtml::endform() ?>

<div id="movie-import-list">
  <ul>
    <?php foreach($imported_movies as $movie): ?>
      <?php if(is_array($movie=$movie->getMovie())): ?>
        <li>
          <?php if(isset($movie['posters'][2])): ?>
            <?php //echo CHtml::image($movie['posters'][2]['image']['url']) ?>
          <?php endif ?>
          <?php echo $movie['name'] ?> (<?php echo substr($movie['released'],0,4) ?>)
          <?php echo CHtml::Link('view', array('movie/tmdb', 'id'=>$movie['id'])) ?>
        </li>
      <?php endif ?>
    <?php endforeach ?>
  <ul>
</div>