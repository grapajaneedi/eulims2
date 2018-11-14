<?php

namespace common\models\finance;

use Yii;

/**
 * This is the model class for table "tbl_backuprestore_logs".
 *
 * @property int $id
 * @property string $activity
 * @property string $transaction_date
 * @property string $op_data
 * @property string $pi_data
 * @property string $sc_data
 * @property string $op_billing_data
 * @property string $cancelled_op_data
 * @property string $receipt_data
 * @property string $check_data
 * @property string $deposit_data
 * @property string $status
 */
class BackuprestoreLogs extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tbl_backuprestore_logs';
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
            [['transaction_date'], 'safe'],
            [['activity'], 'string', 'max' => 200],
            [['op_data', 'pi_data', 'sc_data', 'op_billing_data', 'cancelled_op_data', 'receipt_data', 'check_data', 'deposit_data', 'status'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'activity' => 'Activity',
            'transaction_date' => 'Transaction Date',
            'op_data' => 'Op Data',
            'pi_data' => 'Pi Data',
            'sc_data' => 'Sc Data',
            'op_billing_data' => 'Op Billing Data',
            'cancelled_op_data' => 'Cancelled Op Data',
            'receipt_data' => 'Receipt Data',
            'check_data' => 'Check Data',
            'deposit_data' => 'Deposit Data',
            'status' => 'Status',
        ];
    }
}
