<ul class="info">
  <?php if($movie->get('rating')): ?>
    <li>
      <?php echo CHtml::image('/images/rating.png') ?>
      <?php echo round($movie->get('rating'), 1) ?>/10
    </li>
  <?php endif ?>
  <?php if($movie->get('runtime')): ?>
    <li>
      <?php echo CHtml::image('/images/movie.png') ?>
      <?php echo $movie->get('runtime') ?> min
    </li>
  <?php endif ?>
  <?php if($movie->get('budget')): ?>
    <li>
      <?php echo CHtml::image('/images/dollar.png') ?>
      <?php echo Yii::app()->numberFormatter->formatCurrency($movie->get('budget'), 'USD') ?>
    </li>
  <?php endif ?>
  <?php if($movie->get('homepage')): ?>
    <li>
      <?php echo CHtml::image('/images/link.png') ?>
      <?php echo CHtml::link($movie->get('homepage'),$movie->get('homepage')) ?>
    </li>
  <?php endif ?>
  <li>
    <?php echo CHtml::image('/images/link.png') ?>
    <?php echo CHtml::link('see random Wallpapers',
                array('movie/wallpaper','url_key'=>$movie->url_key)) ?>
  </li>
  <li>
    <?php echo CHtml::image('/images/link.png') ?>
    <?php echo CHtml::link('search Trailer on Youtube',
                'http://www.youtube.com/results?search_query='.
                urlencode($movie->get('name')).
                '+trailer',array('target'=>'_blank')) ?>
  </li>
</ul>
