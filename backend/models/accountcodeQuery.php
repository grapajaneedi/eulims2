<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[\app\models\accountcode]].
 *
 * @see \app\models\accountcode
 */
class accountcodeQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return \app\models\accountcode[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return \app\models\accountcode|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
