<?php

namespace common\models\address;

use Yii;

/**
 * This is the model class for table "tbl_barangay".
 *
 * @property int $barangay_id
 * @property int $city_municipality_id
 * @property int $district
 * @property string $barangay
 *
 * @property CityMunicipality $cityMunicipality
 */
class Barangay extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
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
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['city_municipality_id', 'barangay'], 'required'],
            [['city_municipality_id', 'district'], 'integer'],
            [['barangay'], 'string', 'max' => 250],
            [['city_municipality_id'], 'exist', 'skipOnError' => true, 'targetClass' => CityMunicipality::className(), 'targetAttribute' => ['city_municipality_id' => 'city_municipality_id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'barangay_id' => 'Barangay ID',
            'city_municipality_id' => 'City Municipality ID',
            'district' => 'District',
            'barangay' => 'Barangay',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCityMunicipality()
    {
        return $this->hasOne(CityMunicipality::className(), ['city_municipality_id' => 'city_municipality_id']);
    }
}
