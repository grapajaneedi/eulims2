<?php

namespace common\models\finance;

use Yii;
use common\models\lab\Customer;
/**
 * This is the model class for table "tbl_orderofpayment".
 *
 * @property int $orderofpayment_id
 * @property int $rstl_id
 * @property string $transactionnum
 * @property int $collectiontype_id
 * @property string $order_date
 * @property int $customer_id
 * @property double $amount
 * @property string $purpose
 * @property int $created_receipt
 * @property int $allow_erratum
 *
 * @property Collectiontype $collectiontype
 * @property Paymentitem[] $paymentitems
 * @property Customer[] $customer
 */
class Orderofpayment extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tbl_orderofpayment';
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
            [['rstl_id', 'collectiontype_id', 'customer_id', 'created_receipt', 'allow_erratum'], 'integer'],
            [['order_date'], 'safe'],
            [['allow_erratum','collectiontype_id','order_date','customer_id','amount','purpose'],'required'],
            [['amount'], 'number'],
            [['transactionnum'], 'string', 'max' => 100],
            [['purpose'], 'string', 'max' => 200],
            [['collectiontype_id'], 'exist', 'skipOnError' => true, 'targetClass' => Collectiontype::className(), 'targetAttribute' => ['collectiontype_id' => 'collectiontype_id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'orderofpayment_id' => 'Orderofpayment ID',
            'rstl_id' => 'Rstl ID',
            'transactionnum' => 'Transactionnum',
            'collectiontype_id' => 'Collectiontype ID',
            'order_date' => 'Order Date',
            'customer_id' => 'Customer ID',
            'amount' => 'Amount',
            'purpose' => 'Purpose',
            'created_receipt' => 'Created Receipt',
            'allow_erratum' => 'Allow Erratum',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCollectiontype()
    {
        return $this->hasOne(Collectiontype::className(), ['collectiontype_id' => 'collectiontype_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPaymentitems()
    {
        return $this->hasMany(Paymentitem::className(), ['orderofpayment_id' => 'orderofpayment_id']);
    }
    public function getCustomer(){
        return $this->hasOne(Customer::className(), ['customer_id'=>'customer_id']);
    }
    
}
