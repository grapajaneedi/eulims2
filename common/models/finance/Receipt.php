<?php

namespace common\models\finance;

use Yii;

/**
 * This is the model class for table "tbl_receipt".
 *
 * @property int $receipt_id
 * @property int $rstl_id
 * @property int $terminal_id
 * @property int $orderofpayment_id
 * @property int $project_id
 * @property string $or_number
 * @property string $receiptDate
 * @property int $payment_mode_id
 * @property int $check_id
 * @property int $customer_id
 * @property int $collectiontype_id
 * @property string $total
 * @property int $cancelled
 *
 * @property Check $check
 * @property Orderofpayment $orderofpayment
 * @property Project $project
 * @property Paymentmode $paymentMode
 * @property Collectiontype $collectiontype
 */
class Receipt extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tbl_receipt';
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
            [['rstl_id', 'terminal_id', 'orderofpayment_id', 'project_id', 'or_number', 'receiptDate', 'payment_mode_id', 'customer_id', 'collectiontype_id', 'total', 'cancelled'], 'required'],
            [['rstl_id', 'terminal_id', 'orderofpayment_id', 'project_id', 'payment_mode_id', 'check_id', 'customer_id', 'collectiontype_id', 'cancelled'], 'integer'],
            [['receiptDate'], 'safe'],
            [['total'], 'number'],
            [['or_number'], 'string', 'max' => 50],
            [['check_id'], 'exist', 'skipOnError' => true, 'targetClass' => Check::className(), 'targetAttribute' => ['check_id' => 'check_id']],
            [['orderofpayment_id'], 'exist', 'skipOnError' => true, 'targetClass' => Orderofpayment::className(), 'targetAttribute' => ['orderofpayment_id' => 'orderofpayment_id']],
            [['project_id'], 'exist', 'skipOnError' => true, 'targetClass' => Project::className(), 'targetAttribute' => ['project_id' => 'project_id']],
            [['payment_mode_id'], 'exist', 'skipOnError' => true, 'targetClass' => Paymentmode::className(), 'targetAttribute' => ['payment_mode_id' => 'payment_mode_id']],
            [['collectiontype_id'], 'exist', 'skipOnError' => true, 'targetClass' => Collectiontype::className(), 'targetAttribute' => ['collectiontype_id' => 'collectiontype_id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'receipt_id' => 'Receipt ID',
            'rstl_id' => 'Rstl ID',
            'terminal_id' => 'Terminal ID',
            'orderofpayment_id' => 'Orderofpayment ID',
            'project_id' => 'Project ID',
            'or_number' => 'Or Number',
            'receiptDate' => 'Receipt Date',
            'payment_mode_id' => 'Payment Mode ID',
            'check_id' => 'Check ID',
            'customer_id' => 'Customer ID',
            'collectiontype_id' => 'Collectiontype ID',
            'total' => 'Total',
            'cancelled' => 'Cancelled',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCheck()
    {
        return $this->hasOne(Check::className(), ['check_id' => 'check_id']);
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
    public function getProject()
    {
        return $this->hasOne(Project::className(), ['project_id' => 'project_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPaymentMode()
    {
        return $this->hasOne(Paymentmode::className(), ['payment_mode_id' => 'payment_mode_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCollectiontype()
    {
        return $this->hasOne(Collectiontype::className(), ['collectiontype_id' => 'collectiontype_id']);
    }
}
