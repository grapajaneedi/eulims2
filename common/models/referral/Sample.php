<?php

namespace common\models\referral;

use Yii;

/**
 * This is the model class for table "tbl_sample".
 *
 * @property int $sample_id
 * @property int $referral_id
 * @property int $receiving_agency_id
 * @property int $pstcsample_id
 * @property int $package_id
 * @property string $package_fee
 * @property int $sample_type_id
 * @property string $sample_code
 * @property string $samplename
 * @property string $description
 * @property string $sampling_date
 * @property string $remarks
 * @property int $sample_month
 * @property int $sample_year
 * @property int $active
 *
 * @property Analysis[] $analyses
 * @property Packagelist[] $packagelists
 * @property Sampletype $sampleType
 * @property Packagelist $package
 * @property Referral $referral
 * @property Packagelist $package0
 */
class Sample extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tbl_sample';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('referraldb');
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['referral_id', 'receiving_agency_id', 'pstcsample_id', 'sample_type_id', 'sample_code', 'samplename', 'description', 'sampling_date', 'remarks', 'sample_month', 'sample_year'], 'required'],
            [['referral_id', 'receiving_agency_id', 'pstcsample_id', 'package_id', 'sample_type_id', 'sample_month', 'sample_year', 'active'], 'integer'],
            [['package_fee'], 'number'],
            [['description'], 'string'],
            [['sampling_date'], 'safe'],
            [['sample_code'], 'string', 'max' => 20],
            [['samplename', 'remarks'], 'string', 'max' => 150],
            [['sample_type_id'], 'exist', 'skipOnError' => true, 'targetClass' => Sampletype::className(), 'targetAttribute' => ['sample_type_id' => 'sampletype_id']],
            [['package_id'], 'exist', 'skipOnError' => true, 'targetClass' => Packagelist::className(), 'targetAttribute' => ['package_id' => 'package_id']],
            [['referral_id'], 'exist', 'skipOnError' => true, 'targetClass' => Referral::className(), 'targetAttribute' => ['referral_id' => 'referral_id']],
            [['package_id'], 'exist', 'skipOnError' => true, 'targetClass' => Packagelist::className(), 'targetAttribute' => ['package_id' => 'package_id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'sample_id' => 'Sample ID',
            'referral_id' => 'Referral ID',
            'receiving_agency_id' => 'Receiving Agency ID',
            'pstcsample_id' => 'Pstcsample ID',
            'package_id' => 'Package ID',
            'package_fee' => 'Package Fee',
            'sample_type_id' => 'Sample Type ID',
            'sample_code' => 'Sample Code',
            'samplename' => 'Samplename',
            'description' => 'Description',
            'sampling_date' => 'Sampling Date',
            'remarks' => 'Remarks',
            'sample_month' => 'Sample Month',
            'sample_year' => 'Sample Year',
            'active' => 'Active',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAnalyses()
    {
        return $this->hasMany(Analysis::className(), ['sample_id' => 'sample_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPackagelists()
    {
        return $this->hasMany(Packagelist::className(), ['sampletype_id' => 'sample_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSampleType()
    {
        return $this->hasOne(Sampletype::className(), ['sampletype_id' => 'sample_type_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPackage()
    {
        return $this->hasOne(Packagelist::className(), ['package_id' => 'package_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getReferral()
    {
        return $this->hasOne(Referral::className(), ['referral_id' => 'referral_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPackage0()
    {
        return $this->hasOne(Packagelist::className(), ['package_id' => 'package_id']);
    }
}
