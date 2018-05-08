<?php

namespace common\models\address;

use Yii;

/**
 * This is the model class for table "tbl_barangay".
 *
 * @property integer $barangay_id
 * @property integer $municipality_city_id
 * @property integer $district
 * @property string $barangay
 */
class Barangay extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tbl_barangay';
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
            [['municipality_city_id', 'barangay'], 'required'],
            [['municipality_city_id', 'district'], 'integer'],
            [['barangay'], 'string', 'max' => 250],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'barangay_id' => 'Barangay ID',
            'municipality_city_id' => 'Municipality City ID',
            'district' => 'District',
            'barangay' => 'Barangay',
        ];
    }
}
