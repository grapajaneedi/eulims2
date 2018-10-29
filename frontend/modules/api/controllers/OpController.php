<?php

namespace api\modules\v1\controllers;
use yii\web\Response;

use yii\rest\ActiveController;
use yii\data\ActiveDataProvider;
use yii\filters\auth\QueryParamAuth;
use api\components\Apicomponent;
use Yii;

/**

 * Op Controller API

 *

 * @author DOST IX ICT Team <red_x88@yahoo.com>

 */

class OpController extends ActiveController

{

    public $modelClass = 'api\modules\v1\models\Op';    

	
	public function actions()
    {
        return array_merge(
            parent::actions(),
            [
                'index' => [
                    'class' => 'yii\rest\IndexAction',
                    'modelClass' => $this->modelClass,
                    'checkAccess' => [$this, 'checkAccess'],
                    'prepareDataProvider' => function ($action) {
                        /* @var $model Methodreference */
                        $model = new $this->modelClass;
                        $query = $model::find();
                        $dataProvider = new ActiveDataProvider(['query' => $query, 'pagination' => false]);
                        return $dataProvider;
                    }
                ],
    
                //'delete' => null
            ]
        );
    }



	 public function actionSearch()
    {
        if (!empty($_GET)) {
            $model = new $this->modelClass;
            foreach ($_GET as $key => $value) {
                if (!$model->hasAttribute($key)) {
                    throw new \yii\web\HttpException(404, 'Invalid attribute:' . $key);
                }
            }
            try {
                $provider = new ActiveDataProvider([
                    'query' => $model->find()->where($_GET),
                    'pagination' => [
                     'defaultPageSize' => 100, // to set default count items on one page
                     'pageSize' => 50, //to set count items on one page, if not set will be set from defaultPageSize
                     'pageSizeLimit' => [1, 50] //to set range for pageSize 

             ],
                ]);
            } catch (Exception $ex) {
                throw new \yii\web\HttpException(500, 'Internal server error');
            }

            if ($provider->getCount() <= 0) {
                throw new \yii\web\HttpException(404, 'No entries found with this query string');
            } else {
                 \Yii::$app->response->format= \yii\web\Response::FORMAT_JSON;
                return $provider;
            }
        } else {
            throw new \yii\web\HttpException(400, 'There are no query string');
        }
    }  

}

