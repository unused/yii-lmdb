<?php

/**
 * This is the model class for table "search_log".
 *
 * The followings are the available columns in table 'search_log':
 * @property integer $id
 * @property string $query
 * @property string $log_content
 * @property string $created_at
 */
class SearchLog extends CActiveRecord
{
  const MaxSearchResults = 25;

	/**
	 * Returns the static model of the specified AR class.
	 * @return SearchLog the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

  public function recent($limit=10)
  {
      $this->getDbCriteria()->mergeWith(array(
          'order'=>'created_at DESC',
          'limit'=>$limit,
        ));
      return $this;
  }

  public function __toString()
  {
    return CHtml::link(CHtml::encode($this->query), array('search/index', 'text'=>$this->query));
  }

  private function beforeInsert()
  {
    $this->log_content = Callback::searchMovie($this->query);
    foreach($this->getContent() as $movie_info)
    {
      if(!Movie::model()->with('attributes')->find('tmdb_id=:id', array(':id' => $movie_info['imdb_id'])))
      {
        $movie = new Movie();
        $movie->setUrlKey($movie_info);
        $movie->tmdb_id = $movie_info['id'];
        $movie->imdb_id = $movie_info['imdb_id'];
        $movie->save();
      }
    }
  }

  public function beforeSave()
  {
    if(!$this->id)
      $this->beforeInsert();
    else
      throw new Exception(__CLASS__.' update is not allowed!');

    return parent::beforeSave();
  }

  public function getContent()
  {
    if(!is_array($content = Callback::decode($this->log_content)))
      throw new Exception('Callback failed!');
    if(count($content) > self::MaxSearchResults)
      $content = array_slice($content, 0, self::MaxSearchResults);
    return $content;
  }

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'search_log';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('query', 'required'),
			array('query', 'length', 'max'=>255),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, query, log_content, created_at', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'Id',
			'query' => 'Query',
			'log_content' => 'Log Content',
			'created_at' => 'Created At',
		);
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

		$criteria->compare('query',$this->query,true);

		$criteria->compare('log_content',$this->log_content,true);

		$criteria->compare('created_at',$this->created_at,true);

		return new CActiveDataProvider('SearchLog', array(
			'criteria'=>$criteria,
		));
	}
}