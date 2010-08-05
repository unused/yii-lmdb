<?php

/**
 * This is the model class for table "user2movie".
 *
 * The followings are the available columns in table 'user2movie':
 * @property integer $id
 * @property integer $movie_id
 * @property integer $user_id
 * @property integer $rating
 * @property string $created_at
 * @property string $updated_at
 */
class User2movie extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return User2movie the static model class
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
		return 'user2movie';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('movie_id, user_id', 'required'),
			array('movie_id, user_id, rating', 'numerical', 'integerOnly'=>true),
			array('created_at, updated_at', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, movie_id, user_id, rating, created_at, updated_at', 'safe', 'on'=>'search'),
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
			'movie_id' => 'Movie',
			'user_id' => 'User',
			'rating' => 'Rating',
			'created_at' => 'Created At',
			'updated_at' => 'Updated At',
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
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);

		$criteria->compare('movie_id',$this->movie_id);

		$criteria->compare('user_id',$this->user_id);

		$criteria->compare('rating',$this->rating);

		$criteria->compare('created_at',$this->created_at,true);

		$criteria->compare('updated_at',$this->updated_at,true);

		return new CActiveDataProvider('User2movie', array(
			'criteria'=>$criteria,
		));
	}
}