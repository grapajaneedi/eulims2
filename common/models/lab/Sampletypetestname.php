<?php

namespace common\models\lab;

use Yii;

/**
 * This is the model class for table "tbl_sampletype_testname".
 *
 * @property int $sampletype_testname_id
 * @property int $sampletype_id
 * @property int $testname_id
 * @property string $added_by
 *
 * @property Sampletype $sampletype
 */
class Sampletypetestname extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tbl_sampletype_testname';
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
            [['sampletype_id', 'testname_id', 'added_by'], 'required'],
            [['sampletype_id', 'testname_id'], 'integer'],
            [['added_by'], 'string', 'max' => 10],
            [['sampletype_id'], 'exist', 'skipOnError' => true, 'targetClass' => Sampletype::className(), 'targetAttribute' => ['sampletype_id' => 'sampletype_id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'sampletype_testname_id' => 'Sampletype Testname ID',
            'sampletype_id' => 'Sampletype ID',
            'testname_id' => 'Testname ID',
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
}
