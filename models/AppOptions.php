<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "app_options".
 *
 * @property integer $id
 * @property string $option_name
 * @property string $option_value
 */
class AppOptions extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'app_options';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['option_name', 'option_value'], 'string', 'max' => 255],
            [['option_name'], 'unique']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'option_name' => Yii::t('app', 'Option Name'),
            'option_value' => Yii::t('app', 'Option Value'),
        ];
    }

    /**
     * Create, load and save a set of models.
     * @param $modelClass = Model::className()
     * @param $post = Yii::$app->request->post()
     * @return bool
     */
    public static function saveMultipleData($modelClass, $post) {
        $m    = new $modelClass; // new Model()
        $formName = $m->formName(); // String: Model
        $post     = $post[$formName];
        // $models   = []; // array of models
        $success  = true; // saved or no

        if ($post && is_array($post)) {
            foreach ($post as $i => $item) { // $post: [[id=>...],[id=>...],[id=>...]]
                if (isset($item['id']) && !empty($item['id']) && $success) {
                    $model = $m::findOne($item['id']);
                    $success = $model->load($item, '');
                    $success = $success && $model->save();
                }
            }
        }
        else {
            $success = false;
        }

        return $success;
    }
}
