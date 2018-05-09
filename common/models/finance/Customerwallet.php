<?php

namespace common\models\finance;

use Yii;
use common\models\lab\Customer;
use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;
 
/* @property integer $customerwallet_id
 * @property string $date
 * @property string $last_update
 * @property string $balance
 * @property integer $customer_id
 *
 * @property Customertransaction[] $customertransactions
  * @property Customer[] $customer
 */

class Customerwallet extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tbl_customerwallet';
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
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['balance', 'customer_id'], 'required'],
            [['date', 'last_update'], 'safe'],
            [['balance'], 'number'],
            [['customer_id'], 'integer'],
            [['customer_id'], 'unique', 'targetAttribute' => ['customer_id'], 'message' => 'The Customer has already been added!'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'customerwallet_id' => 'Customerwallet ID',
            'date' => 'Date Created',
            'last_update' => 'Last Updated',
            'balance' => 'Balance',
            'customer_id' => 'Customer',
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
