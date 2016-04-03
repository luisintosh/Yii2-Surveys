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
class ClientAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/client_style.css',
    ];
    public $js = [
    	'https://s7.addthis.com/js/300/addthis_widget.js#pubid=ra-56ed7f8dd41f7d00',
        'js/jquery.browser.min.js',
        'js/client_app.js',
    ];
}

