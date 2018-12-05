<?php

namespace common\modules\dbmanager;

/**
 * dbmanager module definition class
 */
class Module extends \yii\base\Module
{
    /**
     * {@inheritdoc}
     */
    public $controllerNamespace = 'common\modules\dbmanager\controllers';

    /**
     * {@inheritdoc}
     */
    public function init()
    {
        parent::init();
        if (!isset(\Yii::$app->i18n->translations['dbManager'])) {
            \Yii::$app->i18n->translations['dbManager'] = [
                'class' => 'yii\i18n\PhpMessageSource',
                'sourceLanguage' => 'en',
                'basePath' => '@common/modules/dbmanager',
            ];
        }
        // custom initialization code goes here
    }
}
