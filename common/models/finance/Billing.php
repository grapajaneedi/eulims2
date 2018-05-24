<?php

namespace common\models\finance;

use Yii;

/**
 * This is the model class for table "tbl_billing".
 *
 * @property int $billing_id
 * @property int $user_id
 * @property string $soa_number
 * @property string $billing_date
 * @property string $due_date
 * @property int $orderofpayment_id
 * @property int $receipt_id
 * @property string $amount
 *
 * @property Receipt $receipt
 * @property Orderofpayment $orderofpayment
 */
class Billing extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tbl_billing';
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
            [['user_id', 'soa_number', 'billing_date', 'due_date', 'orderofpayment_id', 'receipt_id'], 'required'],
            [['user_id', 'orderofpayment_id', 'receipt_id'], 'integer'],
            [['billing_date', 'due_date'], 'safe'],
            [['amount'], 'number'],
            [['soa_number'], 'string', 'max' => 100],
            [['receipt_id'], 'exist', 'skipOnError' => true, 'targetClass' => Receipt::className(), 'targetAttribute' => ['receipt_id' => 'receipt_id']],
            [['orderofpayment_id'], 'exist', 'skipOnError' => true, 'targetClass' => Orderofpayment::className(), 'targetAttribute' => ['orderofpayment_id' => 'orderofpayment_id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'billing_id' => 'Billing ID',
            'user_id' => 'User ID',
            'soa_number' => 'Soa Number',
            'billing_date' => 'Billing Date',
            'due_date' => 'Due Date',
            'orderofpayment_id' => 'Orderofpayment ID',
            'receipt_id' => 'Receipt ID',
            'amount' => 'Amount',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getReceipt()
    {
        return $this->hasOne(Receipt::className(), ['receipt_id' => 'receipt_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrderofpayment()
    {
        return $this->hasOne(Orderofpayment::className(), ['orderofpayment_id' => 'orderofpayment_id']);
    }
}
