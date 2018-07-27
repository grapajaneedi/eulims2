<?php

namespace common\models\lab;

use Yii;

/**
 * This is the model class for table "tbl_lab".
 *
 * @property int $lab_id
 * @property string $labname
 * @property string $labcode
 * @property int $active
 *
 * @property LabSampletype $lab
 */
class Lab extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tbl_lab';
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
            [['labname', 'labcode', 'active'], 'required'],
            [['active'], 'integer'],
            [['labname'], 'string', 'max' => 50],
            [['labcode'], 'string', 'max' => 10],
            [['lab_id'], 'exist', 'skipOnError' => true, 'targetClass' => LabSampletype::className(), 'targetAttribute' => ['lab_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'lab_id' => 'Lab ID',
            'labname' => 'Labname',
            'labcode' => 'Labcode',
            'active' => 'Active',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLab()
    {
        return $this->hasOne(LabSampletype::className(), ['id' => 'lab_id']);
    }
}
