<?php

namespace common\models\finance;

use Yii;

/**
 * This is the model class for table "tbl_collection".
 *
 * @property int $collection_id
 * @property int $rstl_id
 * @property int $orderofpayment_id
 * @property int $referral_id
 * @property string $nature
 * @property string $amount
 * @property string $wallet_amount
 * @property string $sub_total
 * @property int $cancelled
 *
 * @property Orderofpayment $orderofpayment
 * @property Receipt[] $receipts
 */
class Collection extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tbl_collection';
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
            [['rstl_id', 'orderofpayment_id', 'nature', 'amount'], 'required'],
            [['rstl_id', 'orderofpayment_id', 'referral_id', 'cancelled'], 'integer'],
            [['amount', 'wallet_amount', 'sub_total'], 'number'],
            [['nature'], 'string', 'max' => 50],
            [['rstl_id'], 'unique'],
            [['orderofpayment_id'], 'exist', 'skipOnError' => true, 'targetClass' => Orderofpayment::className(), 'targetAttribute' => ['orderofpayment_id' => 'orderofpayment_id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'collection_id' => 'Collection ID',
            'rstl_id' => 'Rstl ID',
            'orderofpayment_id' => 'Orderofpayment ID',
            'referral_id' => 'Referral ID',
            'nature' => 'Nature',
            'amount' => 'Amount',
            'wallet_amount' => 'Wallet Amount',
            'sub_total' => 'Sub Total',
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

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getReceipts()
    {
        return $this->hasMany(Receipt::className(), ['collection_id' => 'collection_id']);
    }
}
