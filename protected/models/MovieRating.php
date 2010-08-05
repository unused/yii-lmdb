<?php

/**
 * This is the model class for table "movie_rating".
 *
 * The followings are the available columns in table 'movie_rating':
 * @property integer $id
 * @property integer $rating
 * @property integer $user_id
 * @property string $created_at
 * @property string $updated_at
 */
class MovieRating extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return MovieRating the static model class
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
		return 'movie_rating';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('value,user_id,movie_id', 'required'),
			array('value,user_id,movie_id', 'numerical', 'integerOnly'=>true),
			array('created_at,updated_at', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, value, user_id, created_at, updated_at', 'safe', 'on'=>'search'),
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
			'value' => 'Rating',
			'user_id' => 'User',
      'movie_id' => 'Movie',
			'created_at' => 'Created At',
			'updated_at' => 'Updated At',
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

		$criteria->compare('value',$this->rating);

		$criteria->compare('user_id',$this->user_id);

    $criteria->compare('movie_id',$this->movie_id);

		$criteria->compare('created_at',$this->created_at,true);

		$criteria->compare('updated_at',$this->updated_at,true);

		return new CActiveDataProvider('MovieRating', array(
			'criteria'=>$criteria,
		));
	}
}