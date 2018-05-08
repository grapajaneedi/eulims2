<?php

namespace common\models\address;

use Yii;

/**
 * This is the model class for table "tbl_region".
 *
 * @property integer $region_id
 * @property string $code
 * @property string $region
 */
class Region extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tbl_region';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('addressdb');
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['code', 'region'], 'required'],
            [['code'], 'string', 'max' => 20],
            [['region'], 'string', 'max' => 200],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'region_id' => 'Region ID',
            'code' => 'Code',
            'region' => 'Region',
        ];
    }
}
