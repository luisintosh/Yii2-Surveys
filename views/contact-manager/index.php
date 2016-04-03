<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\models\ContactSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Contacts');
?>
<section class="content-header">
    <h1><?= Html::encode($this->title) ?></h1>
</section>
<div class="content contact-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p class="text-right">
        <?= Html::a('Back to lists', ['/contacts'], ['class'=>'btn btn-primary']) ?>
        <?= Html::button(Yii::t('app','Add new contact'), ['class'=>'btn btn-success', 'data-toggle'=>'modal', 'data-target'=>'#modal-new-contact']) ?>
    </p>

    <div class="modal fade" id="modal-new-contact" tabindex="-1" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title"><?= Yii::t('app','Add new contact') ?></h4>
                </div>
                <div class="modal-body">
                    <p>
                        <!-- Render create form -->
                        <?= $this->render('_form', [
                            'model' => $model,
                        ]) ?>
                    </p>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

    <?php Pjax::begin(['id' => 'contacts']); ?>
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],
                'contact_name',
                'contact_email:email',

                [
                    'class' => 'yii\grid\ActionColumn',
                    'buttons' => [
                        'edit' => function ($url, $model, $key) {
                            return Html::a('<i class="fa fa-pencil"></i>', ['update', 'id'=>$model->id, 'contactListID'=>Yii::$app->request->queryParams['contactListID']], ['title'=>Yii::t('app','Edit'), 'data-toggle'=>'tooltip', 'class'=>'btn btn-default']);
                        },
                        'delete' => function ($url, $model, $key) {
                            return Html::a('<i class="fa fa-trash"></i>', ['delete', 'id'=>$model->id, 'contactListID'=>Yii::$app->request->queryParams['contactListID']], ['title'=>Yii::t('app','Delete'), 'data-toggle'=>'tooltip', 'class'=>'btn btn-default', 'data' => [
                                'confirm' => Yii::t('app','Are you sure you want to delete profile?'),
                                'method' => 'post',
                            ],]);
                        },
                    ],
                    'template' => '<div class="btn-group" role="group">{edit} {delete}</div>',
                ],
            ],
        ]); ?>
    <?php Pjax::end(); ?>
</div>
