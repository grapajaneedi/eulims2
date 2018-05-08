<?php

namespace common\models\address;

use Yii;

/**
 * This is the model class for table "tbl_municipality_city".
 *
 * @property integer $municipality_id
 * @property integer $region_id
 * @property integer $province_id
 * @property string $municipality
 * @property integer $district
 */
class MunicipalityCity extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tbl_municipality_city';
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
            [['region_id', 'province_id', 'municipality'], 'required'],
            [['region_id', 'province_id', 'district'], 'integer'],
            [['municipality'], 'string', 'max' => 100],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'municipality_id' => 'Municipality ID',
            'region_id' => 'Region ID',
            'province_id' => 'Province ID',
            'municipality' => 'Municipality',
            'district' => 'District',
        ];
    }
}
