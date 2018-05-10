<?php

namespace common\models\finance;

use Yii;

/**
 * This is the model class for table "tbl_check".
 *
 * @property int $check_id
 * @property string $payee
 * @property string $bank
 * @property string $checknumber
 * @property string $checkdate
 * @property double $amount
 *
 * @property Receipt[] $receipts
 */
class Check extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tbl_check';
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
            [['payee', 'bank', 'checknumber', 'checkdate', 'amount'], 'required'],
            [['checkdate'], 'safe'],
            [['amount'], 'number'],
            [['payee'], 'string', 'max' => 200],
            [['bank', 'checknumber'], 'string', 'max' => 25],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'check_id' => 'Check ID',
            'payee' => 'Payee',
            'bank' => 'Bank',
            'checknumber' => 'Checknumber',
            'checkdate' => 'Checkdate',
            'amount' => 'Amount',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getReceipts()
    {
        return $this->hasMany(Receipt::className(), ['check_id' => 'check_id']);
    }
}
