<?php

namespace frontend\modules\lab\models;

use Yii;
use common\models\system\Rstl;
use common\components\Functions;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use common\models\lab\Sample;
/**
 * Extended model from lab Sample
 *
**/

class Sampleextend extends Sample
{
	const SCENARIO_CANCEL_SAMPLE = 'cancelsample';

	public function rules()
    {
        return [
            [['remarks'], 'required', 'on' => self::SCENARIO_CANCEL_SAMPLE],
        ];
    }
}
