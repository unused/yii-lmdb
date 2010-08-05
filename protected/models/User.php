<?php

/**
 * This is the model class for table "user".
 *
 * The followings are the available columns in table 'user':
 * @property integer $id
 * @property string $username
 * @property string $password
 * @property string $salt
 * @property string $last_login_at
 * @property string $created_at
 * @property string $updated_at
 */
class User extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return User the static model class
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
		return 'user';
	}

  public function validatePassword($password)
  {
    return (sha1($this->salt.$password) == $this->password);
  }

  /**
   *  @brief generate salt and set sha1 password
   *  @return call parent beforeInsert
   */
  public function beforeSave()
  {
    if(!$this->id)$this->setSha1Password();
    return parent::beforeSave();
  }

  public function setSha1Password()
  {
    $salt = md5(time().$this->username);
    $this->salt = $salt;
    $this->password = sha1($salt.$this->password);
  }

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('password', 'required'),
			array('password', 'length', 'max'=>255),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, username, last_login_at, created_at, updated_at', 'safe', 'on'=>'search'),
      array('updated_at','default', 'value'=>date('Y-m-d H:i:s'),
            'setOnEmpty'=>false,'on'=>'update'),
      array('created_at, updated_at','default', 'value'=>date('Y-m-d H:i:s'),
            'setOnEmpty'=>false,'on'=>'insert')
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
    return array(
        'movies'=>array(self::MANY_MANY, 'Movie',
                'user2movie(user_id, movie_id)'),
    );
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id'            => 'User-ID',
			'username'      => 'Username',
			'password'      => 'Password',
			'salt'          => 'Salt',
			'last_login_at' => 'Last Login At',
			'created_at'    => 'Created At',
			'updated_at'    => 'Updated At',
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

		$criteria->compare('username',$this->username,true);

		$criteria->compare('last_login_at',$this->last_login_at,true);

		$criteria->compare('created_at',$this->created_at,true);

		$criteria->compare('updated_at',$this->updated_at,true);

		return new CActiveDataProvider('User', array(
			'criteria'=>$criteria,
		));
	}
}