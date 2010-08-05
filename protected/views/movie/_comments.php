<?php foreach($comments as $comment): ?>
  <div class="comment" id="c_<?php echo $comment->id; ?>">
    <div class="head">
      <?php echo date('d.m.Y, H:i:s',strtotime($comment->created_at)); ?>
      <?php echo $comment->user->username; ?> says:
    </div>

    <div class="content">
      <?php echo nl2br(CHtml::encode($comment->comment)); ?>
    </div>
  </div><!-- comment -->
<?php endforeach; ?>