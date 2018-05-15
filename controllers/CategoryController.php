<?php
/**
 * Created by PhpStorm.
 * User: 555
 * Date: 29.04.2018
 * Time: 20:38
 */

namespace app\controllers;
use app\models\Category;
use app\models\Product;
use Yii;
use yii\data\Pagination;

class CategoryController extends AppController
{
    public function actionView(){

        $url = substr(Yii::$app->request->url, 1);
//        var_dump($url); die();
        $category = Category::find()->where(['alias' => $url])->one();
//        debug($category);
        if(empty($category))
            throw new \yii\web\HttpException(404, 'Такой категории нет');
        $query = Product::find()->where(['category_alias' => $url]);
        $pages = new Pagination(['totalCount' => $query->count(), 'pageSize' => 200000000, 'forcePageParam' => false, 'pageSizeParam' => false]);

        $products = $query->offset($pages->offset)->limit($pages->limit)->all();
//                var_dump($products);
        $this->setMeta('Азбука климата | ' . $category->name, $category->keywords, $category->description);
        return $this->render('view', compact('products', 'pages', 'category'));
    }
}