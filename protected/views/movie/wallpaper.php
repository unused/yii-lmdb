<ul id="wallpapers">
  <?php foreach($images as $image): ?>
    <li><?php echo CHtml::link(CHtml::image($image, 'wallpaper', array('width'=>300,'height'=>170)),$image) ?></li>
  <?php endforeach ?>
</ul>