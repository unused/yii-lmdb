<div class="movie-item">
  <?php echo chtml::link(chtml::image($data->getcover(), $data->get('name'),
          array('class'=>'left')),array('movie/view', 'url_key'=>$data->url_key)) ?>
  <h3><?php echo $data->get('name') ?></h3>
  <?php echo $data->getReleaseYear() ?><br />
  <br />
  <ul>
    <li>Views: <?php echo $data->views ?></li>
    <li>Comments: <?php echo count($data->comments) ?></li>
    <li>My Rating: <?php echo ($rate=$data->getMyRating())?$rate:'unseen' ?></li>
  </ul>
</div>