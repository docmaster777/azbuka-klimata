<?php
/**
 * Created by PhpStorm.
 * User: 555
 * Date: 29.04.2018
 * Time: 18:01
 */

namespace app\controllers;

use app\models\Product;

class ShopController extends AppController
{
    public function actionIndex()
    {
        $hits = Product::find()->where(['hit' => '1'])->limit(6)->all();
        return $this->render('index', compact('hits'));
    }
}