<?php

namespace common\models\lab;

use Yii;

/**
 * This is the model class for table "tbl_testname_method".
 *
 * @property int $id
 * @property int $testname_id
 * @property int $method_id
 * @property string $create_time
 * @property string $update_time
 *
 * @property Testname $testname
 */
class Testnamemethod extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tbl_testname_method';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('labdb');
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['testname_id', 'method_id', 'create_time'], 'required'],
            [['testname_id', 'method_id'], 'integer'],
            [['create_time', 'update_time'], 'safe'],
            [['testname_id'], 'exist', 'skipOnError' => true, 'targetClass' => Testname::className(), 'targetAttribute' => ['testname_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'testname_id' => 'Testname ID',
            'method_id' => 'Method ID',
            'create_time' => 'Create Time',
            'update_time' => 'Update Time',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTestname()
    {
        return $this->hasOne(Testname::className(), ['id' => 'testname_id']);
    }
}
