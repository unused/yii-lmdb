<?php

/**
 * This is the model class for table "MovieImages".
 *
 * The followings are the available columns in table 'MovieImages':
 */
class MovieImages extends CActiveRecord
{
  public function __toString()
  {
    return $this->url;
  }

	/**
	 * Returns the static model of the specified AR class.
	 * @return MovieImages the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'movie_images';
	}

  public function randomThumbs($limit=6)
  {
    $this->getDbCriteria()->mergeWith(array(
        'order'=>'RAND()',
        'condition'=>"size='thumb' AND type='backdrop'",
        'limit'=>(int)$limit,
      ));
    return $this;
  }
  public function randomWallpaper($limit=6)
  {
    $this->getDbCriteria()->mergeWith(array(
        'order'=>'RAND()',
        'condition'=>"size='original' AND type='backdrop'",
        'limit'=>(int)$limit,
      ));
    return $this;
  }

  public function byMovie($url_key)
  {
    if($url_key)
      $this->getDbCriteria()->mergeWith(array(
        'join'=>'JOIN movie m on t.movie_id=m.id',
        'condition'=>'m.url_key LIKE :url_key',
        'params'=>array(':url_key'=>$url_key),
        'limit'=>'',
      ));
    return $this;
  }

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		return array(
			array('', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		return array(
        'movie'=>array(self::BELONGS_TO, 'Movie', 'movie_id'),
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
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		$criteria=new CDbCriteria;

		return new CActiveDataProvider('MovieImages', array(
			'criteria'=>$criteria,
		));
	}
}