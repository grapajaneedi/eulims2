<?php

namespace common\models\api;

use Yii;

/**
 * This is the model class for table "tbl_migrationportal".
 *
 * @property int $pm_id
 * @property string $date_migrated
 * @property int $record_id
 * @property string $table_name
 */
class Migrationportal extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tbl_migrationportal';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['date_migrated', 'record_id', 'table_name'], 'required'],
            [['date_migrated'], 'safe'],
            [['record_id'], 'integer'],
            [['table_name'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'pm_id' => 'Pm ID',
            'date_migrated' => 'Date Migrated',
            'record_id' => 'Record ID',
            'table_name' => 'Table Name',
        ];
    }
}
