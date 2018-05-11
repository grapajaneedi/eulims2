<?php

namespace common\models\finance;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "tbl_customerwallet".
 *
 * @property int $customerwallet_id
 * @property string $date
 * @property string $last_update
 * @property string $balance
 * @property int $customer_id
 *
 * @property Customertransaction[] $customertransactions
 */
class Customerwallet extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tbl_customerwallet';
    }
 
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::className(),
                'createdAtAttribute' => 'date',
                'updatedAtAttribute' => 'last_update',
                'value' => new Expression('NOW()'),
            ],
        ];
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
            [['date', 'last_update', 'balance', 'customer_id'], 'required'],
            [['date', 'last_update'], 'safe'],
            [['balance'], 'number'],
            [['customer_id'], 'integer'],
            [['customer_id'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'customerwallet_id' => 'Customerwallet ID',
            'date' => 'Date',
            'last_update' => 'Last Update',
            'balance' => 'Balance',
            'customer_id' => 'Customer ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCustomertransactions()
    {
        return $this->hasMany(Customertransaction::className(), ['customerwallet_id' => 'customerwallet_id']);
    }

    public function getCustomer()
    {
        return $this->hasOne(Customer::className(), ['customer_id' => 'customer_id']);
    }
}
