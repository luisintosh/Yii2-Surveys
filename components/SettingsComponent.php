<?php

namespace app\components;

use yii\base\Component;
use app\models\AppOptions;

class SettingsComponent extends Component
{
	public $content;

	public function init()
  {
		parent::init();
	}

	public function get($key)
  {
    $model = AppOptions::find()->where(['option_name'=>$key])->one();
    return $model->option_value;
	}

  public function getAll()
  {
    $model = AppOptions::find()->asArray()->all();
    $settings = [];
    foreach ($model as $key => $item) {
      $settings[$item['option_name']] = $item['option_value'];
    }
    return $settings;
  }

}
