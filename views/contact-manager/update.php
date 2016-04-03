<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Contact */

$this->title = Yii::t('app', 'Update contact');
?>
<section class="content-header">
    <h1><?= Html::encode($this->title) ?></h1>
</section>
<div class="content contact-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
