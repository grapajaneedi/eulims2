<?php

namespace common\models\referral;

use Yii;

/**
 * This is the model class for table "tbl_attachment".
 *
 * @property int $attachment_id
 * @property string $filename
 * @property int $filetype 1=OR, 2=Receipt, 3=Test Result
 * @property int $referral_id
 * @property string $upload_date
 * @property int $upload_by
 *
 * @property Referral $referral
 */
class Attachment extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tbl_attachment';
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
            [['filename', 'filetype', 'referral_id', 'upload_date', 'upload_by'], 'required'],
            [['filetype', 'referral_id', 'upload_by'], 'integer'],
            [['upload_date'], 'safe'],
            [['filename'], 'string', 'max' => 350],
            [['referral_id'], 'exist', 'skipOnError' => true, 'targetClass' => Referral::className(), 'targetAttribute' => ['referral_id' => 'referral_id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'attachment_id' => 'Attachment ID',
            'filename' => 'Filename',
            'filetype' => 'Filetype',
            'referral_id' => 'Referral ID',
            'upload_date' => 'Upload Date',
            'upload_by' => 'Upload By',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getReferral()
    {
        return $this->hasOne(Referral::className(), ['referral_id' => 'referral_id']);
    }
}
