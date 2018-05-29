<?php

namespace common\models\lab;

use Yii;

/**
 * This is the model class for table "tbl_packagelist".
 *
 * @property int $package_id
 * @property int $rstl_id
 * @property string $name
 * @property string $rate
 * @property string $tests
 *
 * @property Sample[] $samples
 */
class Packagelist extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tbl_packagelist';
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
            [['rstl_id', 'name', 'tests'], 'required'],
            [['rstl_id'], 'integer'],
            [['rate'], 'number'],
            [['name'], 'string', 'max' => 50],
            [['tests'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'package_id' => 'Package ID',
            'rstl_id' => 'Rstl ID',
            'name' => 'Name',
            'rate' => 'Rate',
            'tests' => 'Tests',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSamples()
    {
        return $this->hasMany(Sample::className(), ['package_id' => 'package_id']);
    }
}
