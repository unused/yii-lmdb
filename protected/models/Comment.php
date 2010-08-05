<?php

/**
 * This is the model class for table "comments".
 *
 * The followings are the available columns in table 'comments':
 * @property integer $id
 * @property integer $type
 * @property integer $type_id
 * @property string $comment
 * @property integer $user_id
 * @property string $created_at
 * @property string $updated_at
 */
class Comment extends CActiveRecord
{
  const TYPE_MOVIE=1;

	/**
	 * Returns the static model of the specified AR class.
	 * @return Comment the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

  public function __toString()
  {
    return CHtml::link(CHtml::encode(substr($this->comment,0,35)), array('movie/view','url_key'=>$this->movie->url_key));
  }

  public function recent($limit=10)
  {
      $this->getDbCriteria()->mergeWith(array(
          'order'=>'created_at DESC',
          'limit'=>$limit,
        ));
      return $this;
  }

  public function beforeSave()
  {
    if(!$this->id)
    {
      $msg=Yii::app()->user->name.'
        commented on '.$this->movie->get('name').'
        "'.$this->comment.'"';
      TwitterPost::send($msg);
    }
    return parent::beforeSave();
  }

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'comments';
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
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		return array(
			array('type, type_id, comment, user_id', 'required'),
      array('comment', 'length', 'min'=>15),
			array('type, type_id, user_id', 'numerical', 'integerOnly'=>true),
			array('updated_at, created_at', 'safe'),
			array('id, type, type_id, comment, user_id, created_at, updated_at', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
    return array(
        'user'=>array(self::BELONGS_TO, 'User', 'user_id'),
        'movie'=>array(self::BELONGS_TO, 'Movie', 'type_id'), /// @TODO set type not movie
    );
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'Id',
			'type' => 'Type',
			'type_id' => 'Type',
			'comment' => 'Comment',
			'user_id' => 'User',
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

		$criteria->compare('type',$this->type);

		$criteria->compare('type_id',$this->type_id);

		$criteria->compare('comment',$this->comment,true);

		$criteria->compare('user_id',$this->user_id);

		$criteria->compare('created_at',$this->created_at,true);

		$criteria->compare('updated_at',$this->updated_at,true);

		return new CActiveDataProvider('Comment', array(
			'criteria'=>$criteria,
		));
	}
}