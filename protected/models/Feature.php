<?php

/**
 * This is the model class for table "feature".
 *
 * The followings are the available columns in table 'feature':
 * @property integer $id
 * @property integer $is_done
 * @property integer $priority
 * @property string $label
 * @property string $description
 * @property string $created_at
 * @property string $updated_at
 */
class Feature extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return Feature the static model class
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
		return 'feature';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('is_done, priority, label, description', 'required'),
			array('is_done, priority', 'numerical', 'integerOnly'=>true),
			array('label', 'length', 'max'=>255),
			array('created_at, updated_at', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, is_done, priority, label, description, created_at, updated_at', 'safe', 'on'=>'search'),
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
			'id' => 'Id',
			'is_done' => 'Is Done',
			'priority' => 'Priority',
			'label' => 'Label',
			'description' => 'Description',
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

		$criteria->compare('is_done',$this->is_done);

		$criteria->compare('priority',$this->priority);

		$criteria->compare('label',$this->label,true);

		$criteria->compare('description',$this->description,true);

		$criteria->compare('created_at',$this->created_at,true);

		$criteria->compare('updated_at',$this->updated_at,true);

		return new CActiveDataProvider('Feature', array(
			'criteria'=>$criteria,
		));
	}
}