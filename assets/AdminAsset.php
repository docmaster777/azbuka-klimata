<?php
/**
 * Created by PhpStorm.
 * User: 555
 * Date: 09.05.2018
 * Time: 9:15
 */

namespace app\assets;

use yii\web\AssetBundle;
class AdminAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/admin.css',
    ];
    public $js = [

    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}