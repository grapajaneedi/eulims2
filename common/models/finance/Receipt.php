<?php

namespace common\models\finance;

use Yii;

/**
 * This is the model class for table "tbl_receipt".
 *
 * @property int $receipt_id
 * @property int $rstl_id
 * @property int $terminal_id
 * @property int $collection_id
 * @property int $deposit_type_id
 * @property string $or_number
 * @property string $receiptDate
 * @property int $payment_mode_id
 * @property string $payor
 * @property int $collectiontype_id
 * @property string $total
 * @property int $cancelled
 * @property int $deposit_id
 * @property int $or
 * @property int $or_series_id
 * @property Billing[] $billings
 * @property Check[] $checks
 * @property DepositType $depositType
 * @property Paymentmode $paymentMode
 * @property Collectiontype $collectiontype
 * @property Collection $collection
 * @property Deposit $deposit
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
            [['rstl_id', 'terminal_id', 'or_number', 'receiptDate','deposit_type_id', 'payment_mode_id', 'payor', 'collectiontype_id', 'total', 'cancelled','or_series_id'], 'required'],
            [['rstl_id', 'terminal_id', 'collection_id', 'deposit_type_id', 'payment_mode_id', 'collectiontype_id', 'cancelled', 'deposit_id','or_series_id'], 'integer'],
            [['receiptDate'], 'safe'],
            [['total'], 'number'],
            [['or_number'], 'string', 'max' => 50],
            [['payor'], 'string', 'max' => 100],
            [['rstl_id', 'or_number'], 'unique', 'targetAttribute' => ['rstl_id', 'or_number']],
            [['deposit_type_id'], 'exist', 'skipOnError' => true, 'targetClass' => DepositType::className(), 'targetAttribute' => ['deposit_type_id' => 'deposit_type_id']],
            [['payment_mode_id'], 'exist', 'skipOnError' => true, 'targetClass' => Paymentmode::className(), 'targetAttribute' => ['payment_mode_id' => 'payment_mode_id']],
            [['collectiontype_id'], 'exist', 'skipOnError' => true, 'targetClass' => Collectiontype::className(), 'targetAttribute' => ['collectiontype_id' => 'collectiontype_id']],
            [['collection_id'], 'exist', 'skipOnError' => true, 'targetClass' => Collection::className(), 'targetAttribute' => ['collection_id' => 'collection_id']],
            [['deposit_id'], 'exist', 'skipOnError' => true, 'targetClass' => Deposit::className(), 'targetAttribute' => ['deposit_id' => 'deposit_id']],
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
            'collection_id' => 'Collection ID',
            'deposit_type_id' => 'Deposit Type ID',
            'or_number' => 'Or Number',
            'receiptDate' => 'Receipt Date',
            'payment_mode_id' => 'Payment Mode ID',
            'payor' => 'Payor',
            'collectiontype_id' => 'Collectiontype ID',
            'total' => 'Total',
            'cancelled' => 'Cancelled',
            'deposit_id' => 'Deposit ID',
            'or_series_id' => 'Or Series'
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBillings()
    {
        return $this->hasMany(Billing::className(), ['receipt_id' => 'receipt_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getChecks()
    {
        return $this->hasMany(Check::className(), ['receipt_id' => 'receipt_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDepositType()
    {
        return $this->hasOne(DepositType::className(), ['deposit_type_id' => 'deposit_type_id']);
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

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCollection()
    {
        return $this->hasOne(Collection::className(), ['collection_id' => 'collection_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDeposit()
    {
        return $this->hasOne(Deposit::className(), ['deposit_id' => 'deposit_id']);
    }
    /** 
    * @return \yii\db\ActiveQuery 
    */ 
   public function getSoaReceipts() 
   { 
       return $this->hasMany(SoaReceipt::className(), ['receipt_id' => 'receipt_id']); 
   } 
 
   /** 
    * @return \yii\db\ActiveQuery 
    */ 
   public function getSoas() 
   { 
       return $this->hasMany(Soa::className(), ['soa_id' => 'soa_id'])->viaTable('tbl_soa_receipt', ['receipt_id' => 'receipt_id']); 
   } 
}
