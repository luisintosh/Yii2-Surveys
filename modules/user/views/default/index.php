<?php

use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var app\modules\user\Module $module
 * @var array $actions
 */

$module = $this->context->module;

$this->title = Yii::t('user', 'Yii 2 User');
?>
<section class="content-header">
    <h1><?= Html::encode($this->title) ?></h1>
</section>
<div class="content user-default-index">

    <p>
        <em><strong>Note:</strong> Some actions may be unavailable depending on if you are logged in/out, or as an
            admin/regular user</em>
    </p>

    <table class="table table-bordered">
        <tr>
            <th>URL</th>
            <th>Description</th>
        </tr>

        <?php foreach ($actions as $url => $description): ?>

            <tr>
                <td>
                    <strong><?= Html::a($url, [$url]) ?></strong>
                </td>
                <td>
                    <?= $description ?>
                </td>
            </tr>

        <?php endforeach; ?>

    </table>

</div>