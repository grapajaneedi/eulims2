<?php

namespace common\models\inventory;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\inventory\InventoryEntries;

/**
 * InventoryEntriesSearch represents the model behind the search form of `common\models\inventory\InventoryEntries`.
 */
class InventoryEntriesSearch extends InventoryEntries
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['inventory_transactions_id', 'transaction_type_id', 'rstl_id', 'product_id', 'created_by', 'suppliers_id', 'quantity', 'created_at', 'updated_at'], 'integer'],
            [['manufacturing_date', 'expiration_date', 'po_number', 'Image1', 'Image2'], 'safe'],
            [['amount', 'total_amount'], 'number'],
        ];
    }

    /**
     * {@inheritdoc}
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
        $query = InventoryEntries::find();

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
            'inventory_transactions_id' => $this->inventory_transactions_id,
            'transaction_type_id' => $this->transaction_type_id,
            'rstl_id' => $this->rstl_id,
            'product_id' => $this->product_id,
            'manufacturing_date' => $this->manufacturing_date,
            'expiration_date' => $this->expiration_date,
            'created_by' => $this->created_by,
            'suppliers_id' => $this->suppliers_id,
            'quantity' => $this->quantity,
            'amount' => $this->amount,
            'total_amount' => $this->total_amount,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'po_number', $this->po_number])
            ->andFilterWhere(['like', 'Image1', $this->Image1])
            ->andFilterWhere(['like', 'Image2', $this->Image2]);

        return $dataProvider;
    }
}
