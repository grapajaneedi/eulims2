<?php

namespace common\models\lab;

use Yii;

/**
 * This is the model class for table "tbl_sampletemplate".
 *
 * @property int $sampletemplate_id
 * @property string $name
 * @property string $description
 */
class Sampletemplate extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tbl_sampletemplate';
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
            [['name', 'description'], 'required'],
            [['name'], 'string', 'max' => 100],
            [['description'], 'string', 'max' => 150],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'sampletemplate_id' => 'Sampletemplate ID',
            'name' => 'Name',
            'description' => 'Description',
        ];
    }
}
