<?php

namespace common\models\finance;

use Yii;
use common\models\lab\Customer;
use common\models\finance\Collectiontype;
/**
 * This is the model class for table "tbl_orderofpayment".
 *
 * @property integer $orderofpayment_id
 * @property integer $rstl_id
 * @property string $transactionnum
 * @property integer $collectiontype_id
 * @property string $date
 * @property integer $customer_id
 * @property double $amount
 * @property string $purpose
 * @property integer $created_receipt
 */
class Orderofpayment extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
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
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['rstl_id', 'collectiontype_id', 'customer_id', 'created_receipt'], 'integer'],
            [['order_date'], 'safe'],
            [['amount'], 'number'],
            [['transactionnum'], 'string', 'max' => 100],
            [['purpose'], 'string', 'max' => 200],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'orderofpayment_id' => 'Orderofpayment ID',
            'rstl_id' => 'Rstl ID',
            'transactionnum' => 'Transaction number',
            'collectiontype_id' => 'Nature of Collection',
            'order_date' => 'Date',
            'customer_id' => 'Customer Name',
            'amount' => 'Amount',
            'purpose' => 'Purpose',
            'created_receipt' => 'Created Receipt',
        ];
    }
    
    public function getCustomer()
    {
        return $this->hasOne(Customer::className(), ['customer_id' => 'customer_id']);
    }
    public function getCollectiontype()
    {
        return $this->hasOne(Collectiontype::className(), ['collectiontype_id' => 'collectiontype_id']);
    }
}
