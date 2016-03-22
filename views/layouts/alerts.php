<?php
/*
 * danger
 * info
 * warning
 * success
 */
?>


<?php foreach (Yii::$app->session->getAllFlashes() as $key => $message) {

    $this->registerJs(" toastr['$key']('$message'); ", yii\web\View::POS_READY, '');

} ?>
