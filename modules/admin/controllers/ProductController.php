<?php

namespace app\modules\admin\controllers;

use app\modules\admin\models\Image;
use Yii;
use app\modules\admin\models\Product;
use app\modules\admin\models\ProductSearch;
use yii\helpers\StringHelper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

/**
 * ProductController implements the CRUD actions for Product model.
 */
class ProductController extends AppAdminController
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Product models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ProductSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Product model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Product model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Product();

        $image_model = new Image();
        $name_model = StringHelper::basename(get_class($model));

        if ($model->load(Yii::$app->request->post())){

            $model->save();

//            --загрузка одной картинки--
            $image = $model->uploadCreate($model->imageFile = UploadedFile::getInstance($model, 'imageFile'));
            $image_model->filePath = $image;
            $image_model->itemId = $model->id;
            $image_model->isMain = 1;
            $image_model->idImage = 2;
            $image_model->modelName = $name_model . $model->id;
            $image_model->save();

//            --загрузка нескольких картинок--
            $images = $model->uploadsCreate($model->imageFiles = UploadedFile::getInstances($model, 'imageFiles'));
            if($images){
                $i=3;
                foreach ($images as $image){
                    $image_model = new Image();
                    $image_model->filePath = $image[0];
                    $image_model->itemId = $model->id;
                    $image_model->isMain = 2;
                    $image_model->idImage = $i++;
                    $image_model->modelName = $name_model . $model->id;
                    $image_model->save();
                }
            }else{
                false;
            }

            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Product model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {

        $model = $this->findModel($id);

        $image_model = new Image();

        $name_model = StringHelper::basename(get_class($model));
        $current_image = Image::find()->andWhere(['itemId' => $id])->andWhere(['isMain' => 1]) ->one();

        if ($model->load(Yii::$app->request->post())){
//            debug($model);die();
            $model->save();
            $file_image = $model->updateImage($model->imageFile = UploadedFile::getInstance($model, 'imageFile'), $current_image);
//            debug($file_image);die();
            if(!empty($current_image->filePath) & $file_image ==!null ){
                $current_image->delete();
                $image_model->filePath = $file_image;
                $image_model->itemId = $model->id;
                $image_model->isMain = 1;
                $image_model->idImage = 2;
                $image_model->modelName = $name_model . $model->id;

                $image_model->save();
            }else{
                $image_model->filePath = $file_image;
                $image_model->itemId = $model->id;
                $image_model->isMain = 1;
                $image_model->idImage = 2;
                $image_model->modelName = $name_model . $model->id;
                $image_model->save();


            }

//           -------------- Загрузка нескольких картинок----
            $images = $model->updateImages($model->imageFiles = UploadedFile::getInstances($model, 'imageFiles'));
//            var_dump($images);
            $i=300;
            if($images){
                foreach ($images as $image){
//                    debug($image);die();
                    $image_model = new Image();
                    $image_model->filePath = $image[0];
                    $image_model->itemId = $model->id;
                    $image_model->isMain = 2;
                    $image_model->idImage = $i++;
                    $image_model->modelName = $name_model . $model->id;
                    $image_model->save();
                }
            }


            return $this->redirect(['view', 'id' => $model->id]);
        }
        return $this->render('update', [
        'model' => $model,
    ]);
    }

    /**
     * Deletes an existing Product model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Product model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Product the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Product::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionDeleteimage($idimg, $id)
    {

        $model = $this->findModel($id);
        $name_model = StringHelper::basename(get_class($model));
        $pathcurrentimag = Image::find()->andWhere(['idImage' => $idimg])->one();
//        debug($pathcurrentimag->filePath);
        unlink($pathcurrentimag->filePath);
//        debug($pathcurrentimag);die();

        $directory = 'uploads/'. 'all-'. $name_model. '/' . $name_model . $id;
        $scandir = scandir($directory);
        $arrdir = array_splice($scandir, 2);

        if($arrdir[0]){

            $pathcurrentimag->delete();

            $model->imageFile = null;
            $model->update();
        }else{

            $pathcurrentimag->delete();
            rmdir('uploads/all-Product/Product' . $id);
            $model->imageFile = null;
            $model->update();
        }

        if (Yii::$app->request->isAjax) {
            return '';

        } else {
            return $this->redirect(['update', 'id' => $model->id]);
        }
    }
}
