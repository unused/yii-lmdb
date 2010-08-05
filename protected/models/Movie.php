<?php

/**
 * This is the model class for table "movie".
 *
 * The followings are the available columns in table 'movie':
 * @property integer $id
 * @property integer $tmdb_id
 * @property integer $imdb_id
 * @property string $url_key
 * @property string $created_at
 * @property string $updated_at
 */
class Movie extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return Movie the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

  public function __toString()
  {
    return CHtml::link(CHtml::encode($this->get('name')), array('movie/view','url_key'=>$this->url_key));
  }

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'movie';
	}

  public function recent($limit=10)
  {
      $this->getDbCriteria()->mergeWith(array(
          'order'=>'created_at DESC',
          'limit'=>$limit,
        ));
      return $this;
  }
  public function popular($limit=10)
  {
      $this->getDbCriteria()->mergeWith(array(
          'order'=>'views DESC',
          'limit'=>$limit,
        ));
      return $this;
  }

  public function callback()
  {
    if(!$this->id)
      throw new Exception('Movie does not exists yet');
    if($this->callback_at)
      throw new Exception('Movie callback already executed');

    $arr_infos = Callback::decode(Callback::getMovieInfo($this->tmdb_id));
    $arr_infos = array_shift($arr_infos);
    $this->addMovieImages(array_merge($arr_infos['posters'], $arr_infos['backdrops']));
    unset($arr_infos['posters']); unset($arr_infos['backdrops']);
    $this->addMovieAttributes($arr_infos);
    $this->callback_at = time();
    $this->save();
    $this->getRelated('attributes', true);
    $this->getRelated('images', true);
  }

  private function addMovieAttributes($arr_infos)
  {
    foreach($arr_infos as $key => $value)
    {
      if(is_array($value))
        $value = Callback::encode($value);

      $attr = new MovieAttributes();
      $attr->code = $key;
      $attr->value = utf8_encode($value);
      $attr->movie_id = $this->id;
      $attr->save();
    }
  }
  private function addMovieImages($arr_infos)
  {
    foreach($arr_infos as $key => $value)
    {
      $value = $value['image'];
      $img = new MovieImages();
      $img->width  = $value['width'];
      $img->height = $value['height'];
      $img->size   = $value['size'];
      $img->type   = $value['type'];
      $img->url    = $value['url'];
      $img->movie_id = $this->id;
      $img->save();
    }
  }

  /// @TODO replace 2, 3, 4 etc to roman letters
  public function setUrlKey($attributes)
  {
    $url_key=strtolower(preg_replace('/\W+/', '-', $attributes['name']));
    // if name is already given, add the release date
    if(Movie::model()->find('url_key LIKE :url_key', array(':url_key'=>$url_key)))
      $url_key.="-".substr($attributes['released'],0,4);
    // if url_key is still not unique add a number
    $tmp_key=$url_key;
    for($num=1;Movie::model()->find('url_key LIKE :url_key', array(':url_key'=>$url_key));$num++)
      $url_key=$tmp_key."-$num";
    $this->url_key = $url_key;
  }

  public function inLibrary()
  {
    return User2movie::model()->exists(
      'user_id=:uid AND movie_id=:mid AND in_library=1',
      array(':uid'=>Yii::app()->user->id,':mid'=>$this->id));
  }
  public function onWishlist()
  {
    return User2movie::model()->exists(
      'user_id=:uid AND movie_id=:mid AND on_wishlist=1',
      array(':uid'=>Yii::app()->user->id,':mid'=>$this->id));
  }

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('url_key', 'required'),
			array('tmdb_id', 'numerical', 'integerOnly'=>true),
      array('imdb_id', 'length', 'max'=>25),
			array('url_key', 'length', 'max'=>255),
			array('created_at, updated_at', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, tmdb_id, imdb_id, url_key, created_at, updated_at', 'safe', 'on'=>'search'),
		);
	}

  /**
   * @return array behaviors
   */
  public function behaviors() {
    return array(
      'CTimestampBehavior' => array(
        'class' => 'zii.behaviors.CTimestampBehavior',
        'createAttribute' => 'created_at',
        'updateAttribute' => 'updated_at',
      )
    );
  }

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
    return array(
        'attributes'=>array(self::HAS_MANY, 'MovieAttributes', 'movie_id'),
        'images'=>array(self::HAS_MANY, 'MovieImages', 'movie_id'),
        'users'=>array(self::MANY_MANY, 'User',
                'user2movie(movie_id, user_id)'),
        'comments'=>array(self::HAS_MANY, 'Comment', 'type_id',
                    'order'=>'comments.created_at DESC',
                    'condition'=>'comments.type='.Comment::TYPE_MOVIE),
    );
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'Id',
			'tmdb_id' => 'Tmdb',
			'imdb_id' => 'Imdb',
			'url_key' => 'Url Key',
			'created_at' => 'Created At',
			'updated_at' => 'Updated At',
		);
	}

  public function getMyRating()
  {
//     static $_rating;
//     if(!$_rating)
      $_rating=MovieRating::model()->find('movie_id=:movie_id AND user_id=:user_id',
        array(':movie_id'=>$this->id,
              ':user_id'=>Yii::app()->user->id));
    return ($_rating)?$_rating->value:null;
  }
  /// @TODO summarize image function
  public function getCovers($rand = true)
  {
    $covers = array();
    foreach($this->images as $image)
      if($image['size'] == 'cover' && $image['type'] == 'poster')
        $covers[] = $image;
    if($rand) shuffle($covers);
    return $covers;
  }
  public function getCover($rand = true)
  {
    $covers = array();
    foreach($this->images as $image)
      if($image['size'] == 'thumb' && $image['type'] == 'poster')
        $covers[] = $image;
    if($rand) shuffle($covers);
    if(empty($covers)) $covers[] = 'images/default-cover-thumb.png';
    return array_shift($covers);
  }

  public function getImage($type='', $size='thumb')
  {
    $images = $this->getImages();
    return $images[$type][$size];
  }

  public function getPoster($type, $rand = true)
  {
    $originals = array();
    foreach($this->images as $image)
      if($image['size'] == 'poster' && $image['type'] == $type)
        $originals[] = $image;
    if($rand) shuffle($originals);
    return $originals;
  }

  public function getThumbs($type, $rand = true)
  {
    $thumbs = array();
    $originals = array();
    foreach($this->images as $image)
      if($image['size'] == 'thumb' && $image['type'] == $type)
        $thumbs[] = $image;
    if($rand) shuffle($thumbs);
    return $thumbs;
  }

  public function getImages()
  {
    static $images = array();
    if(empty($images))
      foreach($this->images as $image)
      {
        $images[$image['type']][$image['size']] = $image;
      }
    return $images;
  }

  /**
   * @return attributes from MovieAttributes
   */
  public function get($key)
  {
    if($this->callback_at == null)
      $this->callback();

    foreach($this->attributes as $info)
      if($info['code'] == $key)
        return CHtml::encode(utf8_decode($info['value']));
    return '';
  }

  public function getReleaseYear()
  {
    $year=substr($this->get('released'), 0, 4);
    return ($year>1900)?"($year)":'';
  }

  /**
   * Adds a new comment to this movie.
   * This method will set user, type and type_id of the comment accordingly.
   * @param Comment the comment to be added
   * @return boolean whether the comment is saved successfully
   */
  public function addComment($comment)
  {
    $comment->type=Comment::TYPE_MOVIE;
    $comment->type_id=$this->id;
    $comment->user_id=Yii::app()->user->id;
    return $comment->save();
  }


	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);

		$criteria->compare('tmdb_id',$this->tmdb_id);

		$criteria->compare('imdb_id',$this->imdb_id);

		$criteria->compare('url_key',$this->url_key,true);

		$criteria->compare('created_at',$this->created_at,true);

		$criteria->compare('updated_at',$this->updated_at,true);

		return new CActiveDataProvider('Movie', array(
			'criteria'=>$criteria,
		));
	}
}
