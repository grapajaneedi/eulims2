<?php

namespace common\models\lab;

use Yii;

/**
 * This is the model class for table "tbl_test_package".
 *
 * @property int $testpackage_id
 * @property int $lab_sampletype_id
 * @property int $package_rate
 * @property int $testname_methods
 * @property int $added_by
 */
class Testpackage extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tbl_test_package';
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
            [['lab_sampletype_id', 'package_rate', 'testname_methods', 'added_by'], 'required'],
            [['lab_sampletype_id', 'package_rate', 'testname_methods', 'added_by'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'testpackage_id' => 'Testpackage ID',
            'lab_sampletype_id' => 'Sample Type',
            'package_rate' => 'Package Rate',
            'testname_methods' => 'Test Name Methods',
            'added_by' => 'Added By',
        ];
    }
}
