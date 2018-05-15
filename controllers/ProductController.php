<?php
/**
 * Created by PhpStorm.
 * User: 555
 * Date: 13.05.2018
 * Time: 16:51
 */

namespace app\controllers;


use app\models\Category;
use app\models\Product;
use Yii;

class ProductController extends AppController
{
    public function actionView($url){

        $url_category = stristr(substr(Yii::$app->request->url, 1),'/', true );

//        debug($aa);
        $category = Category::find()->where(['alias' => $url_category])->one();
        $product = Product::find()->where(['alias' => $url])->one();
        if(empty($product))
            throw new \yii\web\HttpException(404, 'Такого товара нет');
        $hits = Product::find()->where(['hit' => '1'])->limit(6)->all();
        $this->setMeta('Азбука климата | ' . $product->name, $product->keywords, $product->description);
        return $this->render('view', compact('product', 'hits', 'category'));
    }
}