<ul>
  <li id="movie-in-library">
    <?php echo CHtml::ajaxLink(
              (!$movie->inLibrary())?(CHtml::image('/images/db-add.png','Add to Library')):(CHtml::image('/images/db-rm.png','Remove from Library')),
              CController::createUrl('movie/inLibrary', array('id'=>$movie->id)),
              array('update'=>'#movie-relation-update')) ?>
  </li>
  <li id="movie-on-wishlist">
    <?php echo CHtml::ajaxLink(
              (!$movie->onWishlist())?(CHtml::image('/images/list-add.png','Add On Wishlist')):(CHtml::image('/images/list-rm.png','Remove From Wishlist')),
              CController::createUrl('movie/onWishlist', array('id'=>$movie->id)),
              array('update'=>'#movie-relation-update')) ?>
  </li>
</ul>
