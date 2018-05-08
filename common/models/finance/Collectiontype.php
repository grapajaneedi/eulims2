<?php

namespace common\models\finance;

use Yii;

/**
 * This is the model class for table "tbl_collectiontype".
 *
 * @property integer $collectiontype_id
 * @property string $natureofcollection
 * @property integer $status
 */
class Collectiontype extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tbl_collectiontype';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('financedb');
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['collectiontype_id', 'status'], 'integer'],
            [['natureofcollection'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'collectiontype_id' => 'Collectiontype ID',
            'natureofcollection' => 'Natureofcollection',
            'status' => 'Status',
        ];
    }
}
