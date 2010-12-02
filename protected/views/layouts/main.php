<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="language" content="en" />

  <link rel="shortcut icon" href="http://movies.lipautz.org/favicon.ico">

  <!--[if lt IE 8]>
    <meta http-equiv="refresh" content="URL=http://movies.lipautz.org/no-ie.html">
  <![endif]-->

	<!-- blueprint CSS framework -->
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/screen.css" media="screen, projection" />
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/print.css" media="print" />

	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/main.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/form.css" />

  <?php Yii::app()->clientScript->registerCoreScript('jquery'); ?>

  <?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/jquery.jcarousel.min.js') ?>
  <?php Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl.'/css/jcarousel/skin.css') ?>
  <?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/jquery.cycle.all.min.js') ?>

  <?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/jquery.custom.js') ?>

  <?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/jquery.lightbox.min.js') ?>
  <?php Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl.'/css/lightbox/skin.css') ?>

	<title><?php echo CHtml::encode($this->pageTitle); ?></title>
</head>

<body<?php if(YII_DEBUG): ?> style="background-color: green"<?php endif ?>>

<div class="container" id="page">
  <?php if(!Yii::app()->user->isGuest): ?>
    <div id="header">
      <div id="logo">
        <?php echo CHtml::link(CHtml::image('/images/logo.png'), '/') ?>
        <div id="rand-images">
          <ul class="carousel jcarousel-skin-custom">
            <?php foreach(MovieImages::model()->randomThumbs()->with(array('movie'))->findAll() as $image): ?>
              <li><?php echo CHtml::link(CHtml::image($image->url), array('movie/view', 'url_key'=>$image->movie->url_key)) ?></li>
            <?php endforeach ?>
          </ul>
        </div>
      </div>
      <div class="clear"></div>
    </div><!-- header -->

    <div id="mainmenu">
      <div id="search">
        <?php echo CHtml::beginForm(Yii::app()->createUrl('search/index'), 'get'); ?>
          <?php echo CHtml::textField('text','search for movies',array('submit'=>'')) ?>
        </form>
      </div>
      <?php $this->widget('zii.widgets.CMenu',array(
        'items'=>array(
          array('label'=>'Home',  'url'=>array('/site/index')),
          array('label'=>'Movies', 'url'=>array('/movie/index')),
          array('label'=>'Wishlist', 'url'=>array('/movie/wishlist')),
          array('label'=>'User',  'url'=>array('/users')),
          array('label'=>'Logout ('.Yii::app()->user->name.')', 'url'=>array('/site/logout')),
          ),
        )); ?>
    </div><!-- mainmenu -->
  <?php endif ?>

  <div id="flash"></div>

	<?php $this->widget('zii.widgets.CBreadcrumbs', array(
		'links'=>$this->breadcrumbs,
	)); ?><!-- breadcrumbs -->

	<?php echo $content; ?>

	<div id="footer">
		Copyright &copy; <?php echo (date('Y')==2010)?'2010':'2010-'.date('Y'); ?> by christoph@lipautz.org<br/>
		All Rights Reserved.<br/>
		<?php echo Yii::powered() ?>, <?php echo CHtml::link('IconFinder', 'http://www.iconfinder.com/') ?>
    and <?php echo CHtml::link('jQuery', 'http://jquery.com/') ?><br />
    <?php echo CHtml::link('more...',array('/site/page','view'=>'about')) ?>
	</div><!-- footer -->

</div><!-- page -->

</body>
</html>