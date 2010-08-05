<?php

return array(
  'components'=>array(
    'urlManager'=>array(
      'showScriptName'=>true,
      'urlSuffix'=>'.html',
      'caseSensitive'=>false,
      'urlFormat'=>'path',
      'rules'=>array(
        'login'=>'site/login',
        'search'=>'search/index',

        '<username:\w+>/wishlist'=>'movie/wishlist',
        'wishlist'=>'movie/wishlist',

        'import'=>'movie/import',
        'export'=>'movie/export',
        'rating'=>'movie/rating',

        'movie/<url_key>/wallpapers'=>'movie/wallpaper',
        'wallpapers'=>'movie/wallpaper',

        '<username:\w+>/movies'=>'movie/index',
//         'movie/<action:\w+>'=>'movie/<action>', /// @TODO does not work o.O
        'movie/tmdb/<id:\d+>'=>'movie/tmdb',
        'movie/<url_key>'=>'movie/view',
//         'movie/<url_key:\w+>'=>'movie/view', /// @TODO check regexp

        '<controller:\w+>s'=>'<controller>/index',
        '<controller:\w+>/<id:\d+>'=>'<controller>/view',
        '<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>',
        '<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
      ),
    ),
  ),
);