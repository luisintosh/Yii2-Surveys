<?php

use yii\helpers\Html;
use app\assets\ClientAsset;
use app\assets\ClientBowerAsset;
use yii\widgets\LinkPager;
use app\models\SurveyDesign;

/* @var $this yii\web\View */
/* @survey $this app\models\Survey */
/* @interview $this app\models\Interview */
/* @var $preferences app\models\SurveyPreferences */

ClientBowerAsset::register($this);
ClientAsset::register($this);

// set mailer options
Yii::$app->set('mailer', [
    'class' => 'yii\swiftmailer\Mailer',
    'transport' => [
        'class' => 'Swift_SmtpTransport',
        'host' => Yii::$app->settings->get('mailserver_url'),
        'username' => Yii::$app->settings->get('mailserver_login'),
        'password' => Yii::$app->settings->get('mailserver_pass'),
        'port' => Yii::$app->settings->get('mailserver_port'),
        'encryption' => 'tls',
    ],
]);

// get design
$design = SurveyDesign::find()->where(['id_survey'=>$survey->id])->one();

// get preferences
$preferences = $survey->getSurveyPreferences()->one();

// post
$post = Yii::$app->request->post();

$this->registerCss(".bgcolor-theme {background-color: $design->color !important;}");
$this->registerCss(".font-theme {font-family: '$design->font_text', sans-serif !important;}");
$this->registerCss(".middle-area {background: url('$design->background_img') no-repeat center center fixed;
    -webkit-background-size: cover;
    -moz-background-size: cover;
    -o-background-size: cover;
    background-size: cover;}")

?>
<?php $this->beginPage() ?>
<!doctype html>
<html>
<head>
    <meta charset="UTF-8">
    <title><?= $survey->title ?> | <?= Yii::$app->settings->get('app_name') ?></title>
    <?= Html::csrfMetaTags() ?>
    <meta name="description" content="<?= Yii::$app->settings->get('app_description') ?>">
    <?php $this->head() ?>

    <?= $this->registerCssFile('https://fonts.googleapis.com/css?family=Roboto|Oswald|Montserrat|Ubuntu|Fjalla+One|Indie+Flower|Bitter|Lobster|Bree+Serif|Chewy')?>
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body>
<?php $this->beginBody() ?>

<section class="top-area bgcolor-theme">
    <div class="content">
        <!-- title -->
        <div class="container">
            <div class="header text-center">
                <div class="logo">
                    <?= (!empty($survey->logo_url)) ? Html::img($survey->logo_url, ['class'=>'img-thumbnail', 'alt'=>'logo']) : '' ?>
                </div>
                <h1 class="font-theme"><?= Html::encode($survey->title) ?></h1>
                <p class="lead">
                    <?= $survey->description ?>
                </p>
            </div>
        </div>
    </div>
</section>

<div id="survey">

    <?php
    if ($surveySent) {
        echo $this->render('view/survey_sent', [
            'survey'=> $survey,
            'interview' => $interview,
        ]);
    } else {
        // Password protection
        $password = '';
        if (array_key_exists('SurveyPreferences', $post))
            if (array_key_exists('password_string', $post['SurveyPreferences']))
                $password = $post['SurveyPreferences']['password_string'];

        // Allow multiple submissions
        $cookies = Yii::$app->request->cookies;
        $uniqueCookie = $cookies->getValue('unique', '');

        if ( (!($preferences->password_protect) || ($password === $preferences->password_string)) && (empty($uniqueCookie) || $preferences->allow_multi_submissions)) {
            echo $this->render('view/survey_all', [
                'survey'=> $survey,
                'interview' => $interview,
            ]);

        } else if ($preferences->password_protect) {
            echo $this->render('view/survey_password', [
                'survey'=> $survey,
                'interview' => $interview,
            ]);
        } else if (! empty($uniqueCookie) && !($preferences->allow_multi_submissions)) {
            echo $this->render('view/survey_cookie', [
                'survey'=> $survey,
                'interview' => $interview,
            ]);
        }
    }
    ?>

</div>

<?= $this->renderFile('@app/views/layouts/alerts.php') ?>

<footer class="footer">
    <div class="container">
        <p class="text-muted">Copyright &copy; <?= Yii::$app->settings->get('app_name') ?> <?= date('Y') ?> | <?= Yii::t('app','Developed by') ?> <a href="http://www.luism.net">Luis Mendieta</a>.</p>
    </div>
</footer>

<?php
Yii::$app->set('mailer', [
    'class' => 'yii\swiftmailer\Mailer',
    'transport' => [
        'class' => 'Swift_SmtpTransport',
        'host' => Yii::$app->settings->get('mailserver_url'), 
        'username' => Yii::$app->settings->get('mailserver_login'),
        'password' => Yii::$app->settings->get('mailserver_pass'),
        'port' => Yii::$app->settings->get('mailserver_port'),
        'encryption' => 'tls',
    ],
]);
?>

<?php $this->endBody() ?>
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', '<?= Yii::$app->settings->get('google_analytics_id') ?>', 'auto');
  ga('send', 'pageview');
</script>
</body>
</html>
<?php $this->endPage() ?>