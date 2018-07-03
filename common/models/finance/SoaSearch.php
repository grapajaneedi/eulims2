<?php

namespace common\models\finance;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\finance\Soa;

/**
 * BillingReceiptSearch represents the model behind the search form about `common\models\finance\BillingReceipt`.
 */
class SoaSearch extends Soa
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['soa_id', 'customer_id', 'user_id'], 'integer'],
            [['soa_date', 'soa_number'], 'safe'],
            [['previous_balance', 'current_amount'], 'number'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Soa::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'soa_id' => $this->soa_id,
            'soa_date' => $this->soa_date,
            'customer_id' => $this->customer_id,
            'user_id' => $this->user_id,
            'previous_balance' => $this->previous_balance,
            'current_amount' => $this->current_amount,
        ]);

        $query->andFilterWhere(['like', 'soa_number', $this->soa_number]);

        return $dataProvider;
    }
}
