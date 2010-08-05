<?php

/**
 * This is the model class for table "movie_attributes".
 *
 * The followings are the available columns in table 'movie_attributes':
 * @property integer $id
 * @property string $code
 * @property string $value
 * @property string $created_at
 * @property string $updated_at
 */
class MovieAttributes extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return MovieAttributes the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

  public function __toString()
  {
    return CHtml::link(CHtml::encode($this->movie->get('name')), array('movie/view','url_key'=>$this->movie->url_key));
  }

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'movie_attributes';
	}

  public function top($limit=10)
  {
      $this->getDbCriteria()->mergeWith(array(
          'condition'=>"code='rating'",
          'order'=>'value DESC',
          'limit'=>$limit,
        ));
      return $this;
  }

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('code, value', 'required'),
			array('code', 'length', 'max'=>255),
			array('created_at, updated_at', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, code, value, created_at, updated_at', 'safe', 'on'=>'search'),
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
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'Id',
			'code' => 'Code',
			'value' => 'Value',
			'created_at' => 'Created At',
			'updated_at' => 'Updated At',
		);
	}

  /**
   * @return array behaviors
   */
  public function behaviors()
  {
    return array(
      'CTimestampBehavior' => array(
        'class' => 'zii.behaviors.CTimestampBehavior',
        'createAttribute' => 'created_at',
        'updateAttribute' => 'updated_at',
      )
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

		$criteria->compare('code',$this->code,true);

		$criteria->compare('value',$this->value,true);

		$criteria->compare('created_at',$this->created_at,true);

		$criteria->compare('updated_at',$this->updated_at,true);

		return new CActiveDataProvider('MovieAttributes', array(
			'criteria'=>$criteria,
		));
	}
}