<?php

namespace common\models\finance;

use Yii;

/**
 * This is the model class for table "tbl_customertransaction".
 *
 * @property int $customertransaction_id
 * @property int $updated_by
 * @property string $date
 * @property int $transactiontype
 * @property string $amount
 * @property string $balance
 * @property int $customerwallet_id
 *
 * @property Customerwallet $customerwallet
 */
class Customertransaction extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
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
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['updated_by', 'date', 'transactiontype', 'amount', 'balance', 'customerwallet_id'], 'required'],
            [['updated_by', 'transactiontype', 'customerwallet_id'], 'integer'],
            [['date'], 'safe'],
            [['amount', 'balance'], 'number'],
            [['customerwallet_id'], 'exist', 'skipOnError' => true, 'targetClass' => Customerwallet::className(), 'targetAttribute' => ['customerwallet_id' => 'customerwallet_id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'customertransaction_id' => 'Customertransaction ID',
            'updated_by' => 'Updated By',
            'date' => 'Date',
            'transactiontype' => 'Transactiontype',
            'amount' => 'Amount',
            'balance' => 'Balance',
            'customerwallet_id' => 'Customerwallet ID',
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
