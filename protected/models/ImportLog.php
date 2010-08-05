<?php

/**
 * This is the model class for table "import_log".
 *
 * The followings are the available columns in table 'import_log':
 * @property integer $id
 * @property string $import_name
 * @property integer $search_id
 * @property integer $movie_id
 * @property string $created_at
 */
class ImportLog extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return ImportLog the static model class
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
		return 'import_log';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('import_name, search_id', 'required'),
			array('search_id, movie_id', 'numerical', 'integerOnly'=>true),
			array('import_name', 'length', 'max'=>255),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, import_name, search_id, movie_id, created_at', 'safe', 'on'=>'search'),
		);
	}

  public function getMovie()
  {
    return ($this->movie)?$this->movie:array_shift($this->search->getContent());
  }

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		return array(
      'search'=>array(self::BELONGS_TO, 'SearchLog', 'search_id'),
      'movie'=>array(self::BELONGS_TO, 'Movie', 'movie_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'Id',
			'import_name' => 'Import Name',
			'search_id' => 'Search',
			'movie_id' => 'Movie',
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

		$criteria->compare('import_name',$this->import_name,true);

		$criteria->compare('search_id',$this->search_id);

		$criteria->compare('movie_id',$this->movie_id);

		$criteria->compare('created_at',$this->created_at,true);

		return new CActiveDataProvider('ImportLog', array(
			'criteria'=>$criteria,
		));
	}
}