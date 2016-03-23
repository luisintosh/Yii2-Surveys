<?php

use yii\helpers\Html;
use yii\widgets\Menu;


/* @var $this yii\web\View */
/* @var $model app\models\Survey */

$this->title = Yii::t('app','{title} | Survey Maker', ['title'=>$model->title]);
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

    <?= $this->render('maker_form', [
        'model' => $model,
    ]) ?>

</div>

<?= $this->registerJsFile('@web/js/survey_maker.js', ['depends' => [\yii\web\JqueryAsset::className()]]) ?>