<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace frontend\assets;

use yii\web\AssetBundle;

/**
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $jsOptions = ['position' => \yii\web\View::POS_HEAD];
    public $css = [
        'css/site.css',
        'css/loading.css',
        'css/password_strength.css',
        'css/slidestyle.css',
        'css/jquery.countrySelector.1.1.0.css',
        'css/jquery-ui.css',
        'css/jquery.countdown.css',
        'css/jquery.tree.min.css'  ,
 'css/jquery.dataTables.min.css',
        'css/buttons.dataTables.min.css',		
    ];
    public $js = [
        //'js/jquery.sticky.js',
        'js/jquery.js',
        'js/jquery-ui.js',
        
        'js/main.js',
        'js/loading.js',
		       'js/jquery.dataTables.min.js',

        'js/password_strength_lightweight.js',
        'js/jquery.rotate.js',
        'js/jquery.tree.min.js',
        
        
       // 'js/worldClock.js',
       // 'js/jquery.MyDigitClock.js',

    ];
   public $depends = [
        //'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ]; 
   
}
