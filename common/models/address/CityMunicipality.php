<?php

namespace common\models\address;

use Yii;

/**
 * This is the model class for table "tbl_city_municipality".
 *
 * @property int $city_municipality_id
 * @property int $province_id
 * @property string $city_municipality
 *
 * @property Barangay[] $barangays
 * @property Province $province
 */
class CityMunicipality extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tbl_city_municipality';
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
            [['province_id', 'city_municipality'], 'required'],
            [['province_id'], 'integer'],
            [['city_municipality'], 'string', 'max' => 100],
            [['province_id'], 'exist', 'skipOnError' => true, 'targetClass' => Province::className(), 'targetAttribute' => ['province_id' => 'province_id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'city_municipality_id' => 'City Municipality ID',
            'province_id' => 'Province ID',
            'city_municipality' => 'City Municipality',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBarangays()
    {
        return $this->hasMany(Barangay::className(), ['city_municipality_id' => 'city_municipality_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProvince()
    {
        return $this->hasOne(Province::className(), ['province_id' => 'province_id']);
    }
}
