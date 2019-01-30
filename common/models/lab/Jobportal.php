<?php

namespace common\models\lab;

use Yii;

/**
 * This is the model class for table "tbl_jobportal".
 *
 * @property int $job_id
 * @property int $rstl_id
 * @property string $region_initial
 * @property int $job_type
 * @property string $remarks
 * @property string $logs
 * @property int $isdone
 */
class Jobportal extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tbl_jobportal';
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
            [['rstl_id', 'region_initial'], 'required'],
            [['job_id', 'rstl_id', 'job_type', 'isdone'], 'integer'],
            [['logs'], 'string'],
            [['region_initial', 'remarks'], 'string', 'max' => 200],
            [['job_id'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'job_id' => 'Job ID',
            'rstl_id' => 'Rstl ID',
            'region_initial' => 'Region Initial',
            'job_type' => 'Job Type',
            'remarks' => 'Remarks',
            'logs' => 'Logs',
            'isdone' => 'Isdone',
        ];
    }
}
