<?php

namespace common\models\finance;

use Yii;

/**
 * This is the model class for table "tbl_customertransaction".
 *
 * @property integer $customertransaction_id
 * @property string $date
 * @property integer $transactiontype
 * @property string $amount
 * @property string $balance
 * @property integer $customerwallet_id
 * @property integer $updated_by
 *
 * @property Customerwallet $customerwallet
 */
class Customertransaction extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tbl_customertransaction';
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
            [['date', 'transactiontype', 'amount', 'balance', 'customerwallet_id', 'updated_by'], 'required'],
            [['date'], 'safe'],
            [['transactiontype', 'customerwallet_id', 'updated_by'], 'integer'],
            [['amount', 'balance'], 'number'],
            [['customerwallet_id'], 'exist', 'skipOnError' => true, 'targetClass' => Customerwallet::className(), 'targetAttribute' => ['customerwallet_id' => 'customerwallet_id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'customertransaction_id' => 'Customertransaction ID',
            'date' => 'Date',
            'transactiontype' => 'Transaction Type',
            'amount' => 'Amount',
            'balance' => 'Balance',
            'customerwallet_id' => 'Customerwallet ID',
            'updated_by' => 'Updated By',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCustomerwallet()
    {
        return $this->hasOne(Customerwallet::className(), ['customerwallet_id' => 'customerwallet_id']);
    }
}
