<?php

use yii\widgets\Menu;

echo  Menu::widget([
        'options' => ['class'=>'nav nav-pills nav-justified hidden-print'],
        'items' => [
            ['label'=>Yii::t('app','Maker'), 'url'=>['/survey/maker', 'id'=>$survey->getId()]],
            ['label'=>Yii::t('app','Preferences'), 'url'=>['/survey/preferences', 'id'=>$survey->getId()]],
            ['label'=>Yii::t('app','Design'), 'url'=>['/survey/design', 'id'=>$survey->getId()]],
            ['label'=>Yii::t('app','Results'), 'url'=>['/survey/results', 'id'=>$survey->getId()]],
        ],
    ]);