<?php

namespace common\models\lab;

use Yii;

/**
 * This is the model class for table "tbl_lab_sampletype".
 *
 * @property int $lab_sampletype_id
 * @property int $lab_id
 * @property int $sampletype_id
 * @property string $effective_date
 * @property string $added_by
 *
 * @property Sampletype $sampletype
* @property Lab $lab
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
        // return [
        //     [['lab_id', 'sampletype_id', 'added_by'], 'required'],
        //     [['lab_id', 'sampletype_id'], 'integer'],
        //     [['effective_date'], 'safe'],
        //     [['added_by'], 'string', 'max' => 300],
        //     [['sampletype_id'], 'exist', 'skipOnError' => true, 'targetClass' => Sampletype::className(), 'targetAttribute' => ['sampletype_id' => 'sampletype_id']],
        // ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'lab_sampletype_id' => 'Lab Sampletype ID',
            'lab_id' => 'Lab',
            'sampletype_id' => 'Sample Type',
            'effective_date' => 'Effective Date',
            'added_by' => 'Added By',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSampletype()
    {
        return $this->hasOne(Sampletype::className(), ['sampletype_id' => 'sampletype_id']);
    }

    public function getLab()
    {
        return $this->hasOne(Lab::className(), ['lab_id' => 'lab_id']);
    }
}
