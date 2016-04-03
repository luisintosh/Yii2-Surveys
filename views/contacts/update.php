<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\ContactList */

$this->title = Yii::t('app', 'Update Contacts List Name');
?>
<section class="content-header">
    <h1><?= Html::encode($this->title) ?></h1>
</section>
<div class="content contact-list-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
