<?php

namespace common\models\address;

use Yii;

/**
 * This is the model class for table "tbl_province".
 *
 * @property int $province_id
 * @property int $region_id
 * @property string $province
 * @property string $code
 *
 * @property CityMunicipality[] $cityMunicipalities
 * @property Region $region
 */
class Province extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
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
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['region_id', 'province', 'code'], 'required'],
            [['region_id'], 'integer'],
            [['province'], 'string', 'max' => 50],
            [['code'], 'string', 'max' => 10],
            [['region_id'], 'exist', 'skipOnError' => true, 'targetClass' => Region::className(), 'targetAttribute' => ['region_id' => 'region_id']],
        ];
    }

    /**
     * {@inheritdoc}
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

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCityMunicipalities()
    {
        return $this->hasMany(CityMunicipality::className(), ['province_id' => 'province_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRegion()
    {
        return $this->hasOne(Region::className(), ['region_id' => 'region_id']);
    }
}
