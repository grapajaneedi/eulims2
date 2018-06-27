<?php

namespace frontend\modules\finance\components\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
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
              [['or'], 'safe'],
        ];
    }
    
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }
}
?>