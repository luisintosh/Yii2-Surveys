<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\models\ContactListSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Contacts Lists');
?>
<section class="content-header">
    <h1><?= Html::encode($this->title) ?></h1>
</section>
<div class="content contact-list-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p class="text-right">
        <?= Html::a(Yii::t('app', 'Create Contact List'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>
<?php Pjax::begin(); ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'title',
            [
                'attribute' => 'created_at',
                'format' => 'raw',
                'value' => function($model, $index, $widget) {
                    return Yii::$app->formatter->asDatetime($model->created_at);
                },
            ],
            [
                'attribute' => 'updated_at',
                'format' => 'raw',
                'value' => function($model, $index, $widget) {
                    return Yii::$app->formatter->asDatetime($model->updated_at);
                },
            ],

            [
                'class' => 'yii\grid\ActionColumn',
                'buttons' => [
                    'view' => function ($url, $model, $key) {
                        return Html::a('<i class="fa fa-eye"></i>', ['/contact-manager', 'contactListID'=>$model->id], ['title'=>Yii::t('app','View contacts'), 'data-toggle'=>'tooltip', 'class'=>'btn btn-default']);
                    },
                    'edit' => function ($url, $model, $key) {
                        return Html::a('<i class="fa fa-pencil"></i>', ['update', 'id'=>$model->id], ['title'=>Yii::t('app','Edit name'), 'data-toggle'=>'tooltip', 'class'=>'btn btn-default']);
                    },
                    'delete' => function ($url, $model, $key) {
                        return Html::a('<i class="fa fa-trash"></i>', ['delete', 'id'=>$model->id], ['title'=>Yii::t('app','Delete'), 'data-toggle'=>'tooltip', 'class'=>'btn btn-default', 'data' => [
                            'confirm' => Yii::t('app','Are you sure you want to delete profile?'),
                            'method' => 'post',
                        ],]);
                    },
                ],
                'template' => '<div class="btn-group" role="group">{view} {edit} {delete}</div>',
            ],
        ],
    ]); ?>
<?php Pjax::end(); ?></div>
