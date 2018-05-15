<?php
/**
 * Created by PhpStorm.
 * User: 555
 * Date: 29.04.2018
 * Time: 18:10
 */

namespace app\assets;

use yii\web\AssetBundle;
class MagazinAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
//        slick слайдер
        'libs/slick/slick.css',
        'libs/slick/slick-theme.css',
//        fancybox просмотр картинок
        'libs/fancybox/jquery.fancybox.min.css',
//        стили магазина
        'css/magazin-index.css',
    ];
    public $js = [
//        меню
        'js/jquery.cookie.js',
        'js/jquery.accordion.js',
//        slick слайдер
        'libs/slick/slick.min.js',
//        fancybox просмотр картинок
        'libs/fancybox/jquery.fancybox.min.js',
//        скрипты магазина
        'js/magazin-main.js'
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}