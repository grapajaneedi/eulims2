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
 * @property string $bi_ids
 *
 * @property Billing $billing
 * @property Receipt $receipt
 */
class Soa extends \yii\db\ActiveRecord
{
    public $bi_ids;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tbl_soa';
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
            [['soa_date', 'customer_id', 'user_id', 'soa_number'], 'required'],
            [['soa_date'], 'safe'],
            [['customer_id', 'user_id'], 'integer'],
            [['previous_balance', 'current_amount'], 'number'],
            [['soa_number','bi_ids'], 'string', 'max' => 100]
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'soa_id' => 'Statement of Account ID',
            'soa_date' => 'Soa Date',
            'customer_id' => 'Customer ID',
            'user_id' => 'User ID',
            'soa_number' => 'Soa Number',
            'previous_balance' => 'Previous Balance',
            'current_amount' => 'Current Amount',
            'bi_ds'=>'BIs'
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
   public function getSoaBillings()
   {
       return $this->hasMany(SoaBilling::className(), ['soa_id' => 'soa_id']);
   }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSoaReceipts()
   {
       return $this->hasMany(SoaReceipt::className(), ['soa_id' => 'soa_id']);
   }
   /**
    * @return \yii\db\ActiveQuery
    */
   public function getReceipts()
   {
       return $this->hasMany(Receipt::className(), ['receipt_id' => 'receipt_id'])->viaTable('tbl_soa_receipt', ['soa_id' => 'soa_id']);
   }
}
