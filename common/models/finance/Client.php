<?php

namespace common\models\finance;

use Yii;

/**
 * This is the model class for table "tbl_client".
 *
 * @property int $client_id
 * @property string $account_number
 * @property int $customer_id
 * @property string $company_name
 * @property string $signature_date
 * @property int $signed
 * @property int $active
 */
class Client extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tbl_client';
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
            [['account_number', 'customer_id', 'signature_date', 'signed', 'active'], 'required'],
            [['customer_id', 'signed', 'active'], 'integer'],
            [['signature_date'], 'safe'],
            [['account_number'], 'string', 'max' => 50],
            [['company_name'], 'string', 'max' => 100],
            [['customer_id'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'client_id' => 'Client ID',
            'account_number' => 'Account Number',
            'customer_id' => 'Customer ID',
            'company_name' => 'Company Name',
            'signature_date' => 'Signature Date',
            'signed' => 'Signed',
            'active' => 'Active',
        ];
    }
}
