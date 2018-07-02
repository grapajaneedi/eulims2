<?php

namespace common\models\finance;

use Yii;

/**
 * This is the model class for table "tbl_billing_receipt".
 *
 * @property int $billing_receipt_id
 * @property string $soa_date
 * @property int $customer_id
 * @property int $user_id
 * @property int $billing_id
 * @property int $receipt_id
 * @property string $soa_number
 * @property string $previous_balance
 * @property string $current_amount
 *
 * @property Billing $billing
 * @property Receipt $receipt
 */
class BillingReceipt extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tbl_billing_receipt';
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
            [['soa_date', 'customer_id', 'user_id', 'billing_id', 'soa_number'], 'required'],
            [['soa_date'], 'safe'],
            [['customer_id', 'user_id', 'billing_id', 'receipt_id'], 'integer'],
            [['previous_balance', 'current_amount'], 'number'],
            [['soa_number'], 'string', 'max' => 100],
            [['billing_id'], 'exist', 'skipOnError' => true, 'targetClass' => Billing::className(), 'targetAttribute' => ['billing_id' => 'billing_id']],
            [['receipt_id'], 'exist', 'skipOnError' => true, 'targetClass' => Receipt::className(), 'targetAttribute' => ['receipt_id' => 'receipt_id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'billing_receipt_id' => 'Billing Receipt ID',
            'soa_date' => 'Soa Date',
            'customer_id' => 'Customer ID',
            'user_id' => 'User ID',
            'billing_id' => 'Billing ID',
            'receipt_id' => 'Receipt ID',
            'soa_number' => 'Soa Number',
            'previous_balance' => 'Previous Balance',
            'current_amount' => 'Current Amount',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBilling()
    {
        return $this->hasOne(Billing::className(), ['billing_id' => 'billing_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getReceipt()
    {
        return $this->hasOne(Receipt::className(), ['receipt_id' => 'receipt_id']);
    }
}
