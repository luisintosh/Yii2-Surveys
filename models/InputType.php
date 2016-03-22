<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "input_type".
 *
 * @property integer $id
 * @property string $name
 *
 * @property GroupType[] $groupTypes
 */
class InputType extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'input_type';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'string', 'max' => 255],
            [['name'], 'unique']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', 'Name'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGroupTypes()
    {
        return $this->hasMany(GroupType::className(), ['id_input_type' => 'id']);
    }
}
