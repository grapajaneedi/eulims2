<?php

namespace common\models\address;

use Yii;

/**
 * This is the model class for table "tbl_province".
 *
 * @property integer $province_id
 * @property integer $region_id
 * @property string $province
 * @property string $code
 */
class Province extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tbl_province';
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
            [['region_id', 'province', 'code'], 'required'],
            [['region_id'], 'integer'],
            [['province'], 'string', 'max' => 50],
            [['code'], 'string', 'max' => 10],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'province_id' => 'Province ID',
            'region_id' => 'Region ID',
            'province' => 'Province',
            'code' => 'Code',
        ];
    }
}
