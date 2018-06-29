<?php

namespace frontend\modules\finance\components\models;

use Yii;
use yii\base\Model;
use common\models\finance\Receipt;

/**
 * OrderofpaymentSearch represents the model behind the search form about `common\models\finance\Orderofpayment`.
 */
class Ext_Receipt extends Receipt
{
    public $or;
    
    public function rules()
    {
        return [ 
            [['rstl_id', 'terminal_id', 'collection_id', 'or_number', 'receiptDate', 'payment_mode_id', 'payor', 'collectiontype_id', 'total', 'cancelled','or_series_id'], 'required'],
            [['rstl_id', 'terminal_id', 'collection_id', 'deposit_type_id', 'payment_mode_id', 'collectiontype_id', 'cancelled', 'deposit_id','or_series_id'], 'integer'],
            [['receiptDate'], 'safe'],
            [['total'], 'number'],
            [['or_number'], 'string', 'max' => 50],
            [['payor'], 'string', 'max' => 100],
            [['rstl_id', 'or_number'], 'unique', 'targetAttribute' => ['rstl_id', 'or_number']],
              [['or'], 'safe'],
            
        ];
    }
    
  
}
?>