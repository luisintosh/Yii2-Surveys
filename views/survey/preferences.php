<?php

use yii\helpers\Html;
use yii\widgets\Menu;
use app\models\Survey;

/* @var $this yii\web\View */
$this->title = Yii::t('app','Survey Preferences');
?>
<section class="content-header">
    <h1><?= Html::encode($this->title) ?></h1>
</section>
<div class="content">

    <?=
    Menu::widget([
        'options' => ['class'=>'nav nav-pills nav-justified'],
        'items' => [
            ['label'=>Yii::t('app','Maker'), 'url'=>['/survey/maker', 'id'=>$model->getId()]],
            ['label'=>Yii::t('app','Preferences'), 'url'=>['/survey/preferences', 'id'=>$model->getId()]],
            ['label'=>Yii::t('app','Design'), 'url'=>['/survey/design', 'id'=>$model->getId()]],
        ],
    ]);
    ?>



</div>