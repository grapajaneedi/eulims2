<?php

namespace common\models\referral;

use Yii;

/**
 * This is the model class for table "tbl_notification".
 *
 * @property int $notification_id
 * @property int $referral_id
 * @property int $notificationtype_id
 * @property int $recipient_id
 * @property int $sender_id
 * @property string $sender_name
 * @property string $remarks
 * @property int $viewed
 * @property string $notification_date
 */
class Notification extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tbl_notification';
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
            [['referral_id', 'notificationtype_id', 'recipient_id', 'sender_id', 'sender_name', 'remarks', 'viewed', 'notification_date'], 'required'],
            [['referral_id', 'notificationtype_id', 'recipient_id', 'sender_id', 'viewed'], 'integer'],
            [['notification_date'], 'safe'],
            [['sender_name', 'remarks'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'notification_id' => 'Notification ID',
            'referral_id' => 'Referral ID',
            'notificationtype_id' => 'Notificationtype ID',
            'recipient_id' => 'Recipient ID',
            'sender_id' => 'Sender ID',
            'sender_name' => 'Sender Name',
            'remarks' => 'Remarks',
            'viewed' => 'Viewed',
            'notification_date' => 'Notification Date',
        ];
    }
}
