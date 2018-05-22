<?php

namespace common\models\system;

use Yii;

/**
 * This is the model class for table "vw_labrbac".
 *
 * @property int $user_id
 * @property string $LabManager
 */
class Labrbac extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'vw_labrbac';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id'], 'required'],
            [['user_id'], 'integer'],
            [['LabManager'], 'string', 'max' => 404],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'user_id' => 'User ID',
            'LabManager' => 'Lab Manager',
        ];
    }
}
