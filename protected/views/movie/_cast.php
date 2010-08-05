<div id="cast">
  <?php if(count($cast=Callback::decode(html_entity_decode($movie->get('cast'))))): ?>
    <ul>
      <?php foreach($cast as $person): ?>
        <?php if($person['character']): ?>
          <?php echo $person['character'] ?> <strong><?php echo $person['name'] ?></strong>
        <?php else: ?>
          <?php echo $person['job'] ?> <strong><?php echo $person['name'] ?></strong>
        <?php endif ?>
      <?php endforeach ?>
    </ul>
  <?php endif ?>
</div>