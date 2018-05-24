<?php

namespace common\models\lab;

use Yii;

/**
 * This is the model class for table "tbl_requestcode_template".
 *
 * @property int $requestcode_template_id
 * @property int $rstl_id
 * @property string $requestcode_template
 */
class RequestcodeTemplate extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tbl_requestcode_template';
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
            [['rstl_id', 'requestcode_template'], 'required'],
            [['rstl_id'], 'integer'],
            [['requestcode_template'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'requestcode_template_id' => 'Requestcode Template ID',
            'rstl_id' => 'Rstl ID',
            'requestcode_template' => 'Requestcode Template',
        ];
    }
}
