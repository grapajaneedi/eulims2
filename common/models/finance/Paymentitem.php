<?php

namespace common\models\finance;

use Yii;

/**
 * This is the model class for table "tbl_paymentitem".
 *
 * @property int $paymentitem_id
 * @property int $rstl_id
 * @property int $request_id
 * @property int $referral_id
 * @property int $orderofpayment_id
 * @property string $details
 * @property double $amount
 * @property int $cancelled
 *
 * @property Orderofpayment $orderofpayment
 */
class Paymentitem extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tbl_paymentitem';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('financedb');
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['rstl_id', 'request_id', 'referral_id', 'orderofpayment_id', 'cancelled'], 'integer'],
            [['amount'], 'number'],
            [['details'], 'string', 'max' => 50],
            [['orderofpayment_id'], 'exist', 'skipOnError' => true, 'targetClass' => Orderofpayment::className(), 'targetAttribute' => ['orderofpayment_id' => 'orderofpayment_id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'paymentitem_id' => 'Paymentitem ID',
            'rstl_id' => 'Rstl ID',
            'request_id' => 'Request ID',
            'referral_id' => 'Referral ID',
            'orderofpayment_id' => 'Orderofpayment ID',
            'details' => 'Details',
            'amount' => 'Amount',
            'cancelled' => 'Cancelled',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrderofpayment()
    {
        return $this->hasOne(Orderofpayment::className(), ['orderofpayment_id' => 'orderofpayment_id']);
    }
}
