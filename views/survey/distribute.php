<?php

use yii\helpers\Html;
use yii\widgets\Menu;
use yii\helpers\Url;


/* @var $this yii\web\View */
/* @var $model app\models\Survey */

$this->title = Yii::t('app','Distribute "{survey_title}"',['survey_title'=>$model->title]);
?>
<section class="content-header">
    <h1 class="page-header"><?= Html::encode($this->title) ?></h1>
</section>
<div class="content">

    <div class="row">
        <div class="col-md-8">
            <div class="lead"><?= Yii::t('app','How Would You Like to Collect Responses?') ?></div>
        </div>
        <div class="col-md-4 text-right">
            <a href="<?= Url::to(['survey/maker', 'id'=>$model->getId()]) ?>" class="btn btn-default"><i class="fa fa-pencil"></i> <?= Yii::t('app','Edit') ?></a>
            <a href="<?= Url::to(['survey/print', 'id'=>$model->getId()]) ?>" class="btn btn-default"><i class="fa fa-print"></i> <?= Yii::t('app','Print') ?></a>
            <a href="<?= Url::to(['survey/results', 'id'=>$model->getId()]) ?>" class="btn btn-default"><i class="fa fa-line-chart"></i> <?= Yii::t('app','Results') ?></a>
        </div>
        <div class="col-sm-12">
            <div class="box box-solid box-success">
                <div class="box-header with-border">
                    <strong><?= Yii::t('app','Your Survey Web Link') ?></strong>
                </div>
                <div class="box-body">
                    <p><?= Yii::t('app','Copy, paste and e-mail the web link below to your respondets.') ?></p>
                    <p>
                        <div class="input-group input-group-lg">
                            <input type="text" class="form-control" value="<?= Url::to(['survey/view', 'id'=>$model->getId()], true) ?>" autofocus>
                            <span class="input-group-btn">
                                <?= Html::a(Yii::t('app','Open'), ['survey/view', 'id'=>$model->getId()], ['class'=>'btn btn-success']) ?>
                            </span>
                        </div>
                    </p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="box box-solid box-primary">
                <div class="box-header with-border">
                    <i class="fa fa-share-alt"></i> <?= Yii::t('app','Share') ?>
                </div>
                <div class="box-body">
                    <div class="row">
                        <div class="addthis_toolbox addthis_default_style addthis_32x32_style" addthis:url="<?= Url::to(['survey/view', 'id'=>$model->getId()], true) ?>" addthis:title="<?= Html::encode($model->title) ?>">
                            <div class="col-xs-4"><a class="addthis_button_facebook"></a></div>
                            <div class="col-xs-4"><a class="addthis_button_twitter"></a></div>
                            <div class="col-xs-4"><a class="addthis_button_google_plusone_share"></a></div>
                            <div class="col-xs-4"><a class="addthis_button_tumblr"></a></div>
                            <div class="col-xs-4"><a class="addthis_button_linkedin"></a></div>
                            <div class="col-xs-4"><a class="addthis_button_compact"></a></div>
                        </div>
                    </div>
                    <p class="text-center">
                        <?= Html::img('@web/img/survey_maker/socialmedia.png', ['height'=>'120px']) ?>
                    </p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="box box-solid box-primary">
                <div class="box-header with-border">
                    <i class="fa fa-envelope"></i> <?= Yii::t('app','E-mail invitation') ?>
                </div>
                <div class="box-body">
                    <p>
                        <?= Yii::t('app','Invite respondents to your survey + track their identity and how they answered.') ?>
                    </p>
                    <p>
                        <?= Html::a(Yii::t('app','Send Invitations'), ['contacts/send-invitations','surveyID'=>$model->getId()], ['class'=>'btn btn-warning btn-block']) ?>
                    </p>
                    <p class="text-center">
                        <?= Html::img('@web/img/survey_maker/email_service.png', ['height'=>'110px']) ?>
                    </p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="box box-solid box-primary">
                <div class="box-header with-border">
                    <i class="fa fa-code"></i> <?= Yii::t('app','Website code') ?>
                </div>
                <div class="box-body">
                    <p>
                        <a href="#" class="btn btn-app btn-block" data-toggle="modal" data-target="#modal-weblink">
                            <i class="fa fa-link"></i> <strong><?= Yii::t('app','Website Link') ?></strong>
                        </a>
                    </p>
                    <p>
                        <a href="#" class="btn btn-app btn-block" data-toggle="modal" data-target="#modal-webiframe">
                            <i class="fa fa-newspaper-o"></i> <strong><?= Yii::t('app','Survey in the Content') ?></strong>
                        </a>
                    </p>
                    <p>
                        <a href="#" class="btn btn-app btn-block" data-toggle="modal" data-target="#modal-webpopup">
                            <i class="fa fa-clone"></i> <strong><?= Yii::t('app','Popup Window') ?></strong>
                        </a>
                    </p>
                </div>
            </div>
        </div>
    </div>

</div>

<!-- modal windows -->
<div id="modal-weblink" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"><?= Yii::t('app','Website Link') ?></h4>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <textarea rows="2" cols="50" class="form-control code" autofocus><a href="<?= Url::to(['survey/view', 'id'=>$model->getId()], true) ?>" target="_blank"><?= Html::encode($model->title) ?></a></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<div id="modal-webiframe" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"><?= Yii::t('app','Survey in the Content') ?></h4>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <textarea rows="2" cols="50" class="form-control code" autofocus><iframe src="<?= Url::to(['survey/view', 'id'=>$model->getId()], true) ?>" name="survey" scrolling="yes" frameborder="0" marginheight="0px" marginwidth="0px" height="100%" width="100%"></iframe></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<div id="modal-webpopup" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"><?= Yii::t('app','Popup Window') ?></h4>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <textarea rows="2" cols="50" class="form-control code" autofocus><a href="<?= Url::to(['survey/view', 'id'=>$model->getId()], true) ?>" onclick="NewWindow(this.href,'<?= Url::to(['survey/view', 'id'=>$model->getId()], true) ?>','600','600','yes','center');return false" onfocus="this.blur()"><?= Html::encode($model->title) ?></a>
<script language="javascript" type="text/javascript">
<!--
var win=null;
function NewWindow(mypage,myname,w,h,scroll,pos){
    if(pos=="random"){LeftPosition=(screen.width)?Math.floor(Math.random()*(screen.width-w)):100;TopPosition=(screen.height)?Math.floor(Math.random()*((screen.height-h)-75)):100;}
    if(pos=="center"){LeftPosition=(screen.width)?(screen.width-w)/2:100;TopPosition=(screen.height)?(screen.height-h)/2:100;}
    else if((pos!="center" && pos!="random") || pos==null){LeftPosition=0;TopPosition=20}
    settings='width='+w+',height='+h+',top='+TopPosition+',left='+LeftPosition+',scrollbars='+scroll+',location=yes,directories=no,status=yes,menubar=no,toolbar=no,resizable=yes';
    win=window.open(mypage,myname,settings);}
// -->
</script>
                    </textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->