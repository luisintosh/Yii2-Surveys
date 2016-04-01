<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\assets;

use yii\web\AssetBundle;

/**
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class AdminlteAsset extends AssetBundle
{
    public $sourcePath = '@bower/';
    public $css = [
        'fontawesome/css/font-awesome.min.css',
        'admin-lte/dist/css/AdminLTE.min.css',
        'admin-lte/dist/css/skins/_all-skins.min.css',
        'admin-lte/plugins/iCheck/flat/blue.css',
        'admin-lte/plugins/morris/morris.css',
        'admin-lte/plugins/jvectormap/jquery-jvectormap-1.2.2.css',
        'admin-lte/plugins/datepicker/datepicker3.css',
        'admin-lte/plugins/daterangepicker/daterangepicker-bs3.css',
        'admin-lte/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css',
        'admin-lte/plugins/colorpicker/bootstrap-colorpicker.min.css',
        'switchery/dist/switchery.min.css',
        'toastr/toastr.min.css',
    ];
    public $js = [
        'admin-lte/plugins/jQueryUI/jquery-ui.min.js',
        'raphael/raphael-min.js',
        'admin-lte/plugins/morris/morris.min.js',
        'admin-lte/plugins/chartjs/Chart.min.js',
        'admin-lte/plugins/sparkline/jquery.sparkline.min.js',
        'admin-lte/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js',
        'admin-lte/plugins/jvectormap/jquery-jvectormap-world-mill-en.js',
        'admin-lte/plugins/knob/jquery.knob.js',
        'admin-lte/plugins/daterangepicker/moment.min.js',
        'admin-lte/plugins/daterangepicker/daterangepicker.js',
        'admin-lte/plugins/datepicker/bootstrap-datepicker.js',
        'admin-lte/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js',
        'admin-lte/plugins/slimScroll/jquery.slimscroll.min.js',
        'admin-lte/plugins/fastclick/fastclick.js',
        'admin-lte/plugins/colorpicker/bootstrap-colorpicker.min.js',
        'admin-lte/dist/js/app.js',
        'switchery/dist/switchery.min.js',
        'toastr/toastr.min.js',
    ];
    public $depends = [
        'yii\web\JqueryAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}
