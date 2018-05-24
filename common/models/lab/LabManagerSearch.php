<?php

namespace common\models\lab;

use Yii;
use yii\base\Model;
//use yii\data\ActiveDataProvider;
use common\models\lab\LabManager;
use yii\data\SqlDataProvider;

/**
 * LabManagerSearch represents the model behind the search form of `common\models\lab\LabManager`.
 */
class LabManagerSearch extends LabManager
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['lab_manager_id', 'lab_id', 'user_id', 'updated_at'], 'integer'],
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
        $this->load($params); 
        $SQLCount="SELECT COUNT(*) FROM `eulims`.`vw_labrbac` ";
        $SQLCount.="LEFT JOIN `eulims_lab`.`tbl_lab_manager` ON(`eulims_lab`.`tbl_lab_manager`.`user_id`=`vw_labrbac`.`user_id`) ";
        $SQLCount.="WHERE `vw_labrbac`.`user_id` LIKE CONCAT(:user_id,'%') AND `tbl_lab_manager`.`lab_id` LIKE CONCAT(:lab_id,'%')";
        $SQL="SELECT `vw_labrbac`.`lab_manager_id`, `vw_labrbac`.`user_id`, `vw_labrbac`.`labmanager`,`vw_labrbac`.`labname`, ";
        $SQL.="`vw_labrbac`.`lab_id`, `updated_at` ";
        $SQL.="FROM `eulims`.`vw_labrbac` ";
        $SQL.="WHERE IFNULL(`vw_labrbac`.`user_id`,'') LIKE CONCAT(:user_id,'%') AND IFNULL(`lab_id`,'') LIKE CONCAT(:lab_id,'%')";
        $count = Yii::$app->db->createCommand($SQLCount, [':user_id' => '',':lab_id'=>''])->queryScalar();
        $dataProvider = new SqlDataProvider([
            'sql' => $SQL,
            'params' => [':user_id' => $this->user_id,':lab_id'=>$this->lab_id],
            'totalCount' => $count,
            'pagination' => [
                'pageSize' => 5,
            ],
            /*'sort' => [
                'attributes' => [
                    'labmanager',
                    'lab_id',
                    'updated_at:datetime'
                ],
            ]
             * 
             */
        ]);

        return $dataProvider;
    }
}
