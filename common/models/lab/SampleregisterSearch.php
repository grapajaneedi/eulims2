<?php

namespace common\models\lab;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\lab\Analysis;

/**
 * SampleregisterSearch extended model of `common\models\lab\Analysis`.
 */
class SampleregisterSearch extends Analysis
{
    /**
     * {@inheritdoc}
     */
    public $samplename,$start_date,$end_date;
    public function rules()
    {
        return [
            [['analysis_id', 'rstl_id', 'pstcanalysis_id', 'request_id', 'sample_id', 'quantity', 'test_id', 'cancelled', 'status', 'user_id'], 'integer'],
            //[['date_analysis', 'sample_code', 'testname', 'method', 'references'], 'safe'],
            [['date_analysis', 'sample_code', 'testname','samplename', 'method', 'references'], 'safe'],
            [['fee'], 'number'],
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
        $query = Analysis::find();
        // $query = Analysis::find()
        //     ->with('taggings')
        //     ->all();
        //$query->with('taggings');
        //$query->with('sample');
        $query->joinWith(['sample','taggings']);
        //$query = Analysis::find()->with('sample', 'taggings');

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
            'analysis_id' => $this->analysis_id,
            'date_analysis' => $this->date_analysis,
            'rstl_id' => $this->rstl_id,
            'pstcanalysis_id' => $this->pstcanalysis_id,
            'request_id' => $this->request_id,
            'sample_id' => $this->sample_id,
            'quantity' => $this->quantity,
            'fee' => $this->fee,
            'test_id' => $this->test_id,
            'cancelled' => $this->cancelled,
            'status' => $this->status,
            'user_id' => $this->user_id,
        ]);

        //->andFilterWhere(['like', 'tbl_city.name', $this->city])
        //->andFilterWhere(['like', 'tbl_country.name', $this->country]);

        $query->andFilterWhere(['like', 'tbl_sample.sample_code', $this->sample_code])
            ->andFilterWhere(['like', 'testname', $this->testname])
            ->andFilterWhere(['like', 'tbl_sample.samplename', $this->samplename])
            ->andFilterWhere(['like', 'tbl_tagging.start_date', $this->start_date])
            ->andFilterWhere(['like', 'tbl_tagging.end_date', $this->end_date])
            ->andFilterWhere(['like', 'method', $this->method])
            ->andFilterWhere(['like', 'references', $this->references]);

            echo "<pre>";
            print_r($dataProvider);
            echo "</pre>";
        return $dataProvider;
    }
}
