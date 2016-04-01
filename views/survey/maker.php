<?php

use yii\helpers\Html;
use yii\widgets\Menu;


/* @var $this yii\web\View */
/* @var $model app\models\Survey */

$this->title = Yii::t('app','{title} | Survey Maker', ['title'=>$model->title]);
?>
<section class="content-header">
    <h1><?= Html::encode($model->title) ?></h1>
</section>
<div class="content">

    <?=
    $this->render('survey_maker_menu', [
        'survey'=>$model,
      ]);
    ?>

    <?= $this->render('maker_form', [
        'model' => $model,
    ]) ?>

</div>

<?= $this->registerJsFile('@web/js/survey_maker.js', ['depends' => [\yii\web\JqueryAsset::className()]]) ?>