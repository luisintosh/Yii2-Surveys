<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
 * @var yii\web\View $this
 * @var app\modules\user\Module $module
 * @var app\modules\user\models\User $user
 * @var app\modules\user\models\Profile $profile
 * @var app\modules\user\models\Role $role
 * @var yii\widgets\ActiveForm $form
 */

$module = $this->context->module;
$role = $module->model("Role");
?>

<div class="user-form">

    <?php $form = ActiveForm::begin([
        'enableAjaxValidation' => true,
    ]); ?>

    <div class="row">
        <div class="col-md-6">
            <?= $form->field($user, 'email')->textInput(['maxlength' => 255]) ?>
        </div>

        <div class="col-md-6">
            <?= $form->field($user, 'username')->textInput(['maxlength' => 255]) ?>
        </div>

        <div class="col-md-6">
            <?= $form->field($user, 'newPassword')->passwordInput() ?>
        </div>

        <div class="col-md-6">
            <?= $form->field($profile, 'full_name'); ?>
        </div>

        <div class="col-md-6">
            <?= $form->field($user, 'role_id')->dropDownList($role::dropdown()); ?>
        </div>

        <div class="col-md-6">
            <?= $form->field($user, 'status')->dropDownList($user::statusDropdown()); ?>
        </div>

        <div class="col-md-6">
            <?php $user->banned_at = $user->banned_at ? 1 : 0 ?>
            <?= $form->field($user, 'banned_at')->radio([],false)->label(Yii::t('user', 'Banned')) ?>
            <?= Html::error($user, 'banned_at'); ?>
        </div>
        
        <div class="col-md-6">
            <?= $form->field($user, 'banned_reason'); ?>
        </div>
    </div>

    <div class="form-group">
        <?= Html::submitButton($user->isNewRecord ? Yii::t('user', 'Create') : Yii::t('user', 'Update'), ['class' => $user->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
