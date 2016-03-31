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
class ClientBowerAsset extends AssetBundle
{
    public $sourcePath = '@bower/';
    public $css = [
        'fontawesome/css/font-awesome.min.css',
        'admin-lte/plugins/datepicker/datepicker3.css',
        'eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css',
        'toastr/toastr.min.css',
    ];
    public $js = [
        'admin-lte/plugins/daterangepicker/moment.min.js',
        'admin-lte/plugins/datepicker/bootstrap-datepicker.js',
        'eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js',
        'toastr/toastr.min.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapPluginAsset',
    ];
}
