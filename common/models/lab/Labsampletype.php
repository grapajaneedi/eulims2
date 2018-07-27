<?php

namespace common\models\lab;

use Yii;

/**
 * This is the model class for table "tbl_lab_sampletype".
 *
 * @property int $lab_sampletype_id
 * @property int $lab_id
 * @property int $sampletypeId
 * @property string $effective_date
 * @property string $added_by
 *
 * @property Sampletype $sampletype
 */
class LabSampletype extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tbl_lab_sampletype';
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
            [['lab_id', 'sampletypeId', 'added_by'], 'required'],
            [['lab_id', 'sampletypeId'], 'integer'],
            [['effective_date'], 'safe'],
            [['added_by'], 'string', 'max' => 10],
            [['sampletypeId'], 'exist', 'skipOnError' => true, 'targetClass' => Sampletype::className(), 'targetAttribute' => ['sampletypeId' => 'sampletype_id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'lab_sampletype_id' => 'Lab Sampletype ID',
            'lab_id' => 'Lab ID',
            'sampletypeId' => 'Sampletype ID',
            'effective_date' => 'Effective Date',
            'added_by' => 'Added By',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSampletype()
    {
        return $this->hasOne(Sampletype::className(), ['sampletype_id' => 'sampletypeId']);
    }
}
