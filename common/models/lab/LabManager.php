<?php

namespace common\models\lab;

use Yii;
use common\models\system\Labrbac;
/**
 * This is the model class for table "tbl_lab_manager".
 *
 * @property int $lab_manager_id
 * @property int $lab_id
 * @property int $user_id
 * @property int $updated_at
 *
 * @property Lab $lab
 * @property Labrbac $labrbac
 */
class LabManager extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tbl_lab_manager';
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
            [['lab_id', 'user_id'], 'required'],
            [['lab_id', 'user_id', 'updated_at'], 'integer'],
            [['lab_id'], 'exist', 'skipOnError' => true, 'targetClass' => Lab::className(), 'targetAttribute' => ['lab_id' => 'lab_id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => Labrbac::className(), 'targetAttribute' => ['user_id' => 'user_id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'lab_manager_id' => 'Lab Manager ID',
            'lab_id' => 'Lab ID',
            'user_id' => 'User ID',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLab()
    {
        return $this->hasOne(Lab::className(), ['lab_id' => 'lab_id']);
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLabrbac()
    {
        return $this->hasOne(Labrbac::className(), ['user_id' => 'user_id']);
    }
}
