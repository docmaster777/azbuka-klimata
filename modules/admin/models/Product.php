<?php

namespace app\modules\admin\models;

use Yii;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\StringHelper;

/**
 * This is the model class for table "product".
 *
 * @property int $id
 * @property int $category_id
 * @property string $name
 * @property string $keywords
 * @property string $description
 * @property string $alias
 * @property string $content
 * @property double $price
 * @property int $hit
 * @property int $new
 * @property int $sale
 */
class Product extends \yii\db\ActiveRecord
{
//    Добавляем два свойства
    public $imageFile;
    public $imageFiles;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'product';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['category_id', 'hit', 'new', 'sale'], 'integer'],
            [['content'], 'string'],
            [['price'], 'number'],
            [['name', 'keywords', 'description', 'alias'], 'string', 'max' => 255],
//            Добавляем правила для валидации
            [['imageFile'], 'file', 'extensions' => 'png, jpg, jpeg'],
            [['imageFiles'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg, jpeg', 'maxFiles' => 10],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'category_id' => 'Category ID',
            'name' => 'Имя',
            'keywords' => 'Keywords',
            'description' => 'Description',
            'alias' => 'Alias',
            'content' => 'Content',
            'price' => 'Price',
            'hit' => 'Hit',
            'new' => 'New',
            'sale' => 'Sale',
            'imageFile' => 'Картинка',
            'imageFiles' => 'Галерея',
            'name_image' => 'Имя картинка',
        ];
    }

    //    ---- Получение списка категорий ----
    public function getCategoryList(){
        $categories = ArrayHelper::map(Category::find()->all(), 'id', 'name');
        return $categories;
    }

    //    ---- Загрузка одной картинки при создании ---
    public function uploadCreate($image)
    {
        $generated_name = strtolower(md5(uniqid($this->imageFile->baseName)));
        $name_model = StringHelper::basename(get_class($this));
        if ($this->validate()) {
            if($this->imageFile==!null){
                if(!file_exists('uploads/' . 'all-' .$name_model)){
                    mkdir('uploads/'. 'all-' .$name_model );
                    mkdir('uploads/'. 'all-' .$name_model . '/' . $name_model .$this->id);
                    $path = 'uploads/'. 'all-' .$name_model . '/'. $name_model .$this->id .'/'. $generated_name . '.' . $this->imageFile->extension;
                    $this->imageFile->saveAs($path);
                    return $path;

                }else{
                    if (!file_exists('uploads/'. 'all-' .$name_model .'/' . $name_model .$this->id)){
                        mkdir('uploads/'. 'all-' .$name_model .'/' . $name_model .$this->id);
                        $path = 'uploads/'. 'all-' .$name_model .'/' . $name_model .$this->id .'/'. $generated_name . '.' . $this->imageFile->extension;
                        $this->imageFile->saveAs($path);
                        return $path;
                    }
                }
            }
        }
    }

    //    Получение одной картинки из таблицы картинок (image)
    public function gettingOnePicture(){
        $image = Image::find()->andWhere(['itemId' => $this->id])->andWhere(['isMain' => 1])->one();
        if($image){
            return Html::img('/web/'. $image->filePath , ['width' => '100']);
        }else{
            return '(не задано)';
        }
    }

    //    Получение путей ко всем картинкам из таблицы картинок (image)
    public function pathImages(){
        return $images = Image::find()->andWhere(['itemId' => $this->id])->andWhere(['isMain' => 2])->all();
    }

    //    Получение пути к одной картинки из таблицы картинок (image)
    public function pathImage(){
        return $image = Image::find()->andWhere(['itemId' => $this->id])->andWhere(['isMain' => 1]) ->one();
    }
    //    Получение всех картинок из таблицы картинок (image)
    public function gettingAllPictures(){
        $images = Image::find()->andWhere(['itemId' => $this->id])->all();
        if($images){
            $html="";
            foreach ($images as $image){
                $html .= Html::img('/web/' . $image->filePath, ['width' => '150', 'class' => 'admin__wrap__images']);
            }return $html;
        }else{
            return '(не задано)';
        }
    }

    //    Получение idImage id главной картинки
    public function idImage(){
        return $image = Image::find()->andWhere(['itemId' => $this->id])->andWhere(['isMain' => 1])->one();
    }
    //    Получение idImage id главной картинки
    public function idImages(){
        return $images = Image::find()->andWhere(['itemId' => $this->id])->andWhere(['isMain' => 2])->all();
    }


//    public function getImages(){
//        return $this->hasMany(Image::className(), ['itemId' => 'id']);
//    }

    //    ---- Загрузка многих картинок при создании ---
    public function uploadsCreate($images)
    {
        $name_model = StringHelper::basename(get_class($this));

        if(!file_exists('uploads/'. 'all-' .$name_model)){
            mkdir('uploads/'. 'all-' .$name_model);
            mkdir('uploads/'. 'all-' .$name_model . '/' . $name_model .$this->id);
            foreach ($this->imageFiles as $file) {
                $generated_name = strtolower(md5(uniqid($file->baseName)));
                $path = 'uploads/'. 'all-' .$name_model . '/'. $name_model .$this->id .'/'. $generated_name . '.' . $file->extension;
                $file->saveAs($path);
                $pathtoarray[] = [$path];
            }
            return $pathtoarray;
        }elseif (file_exists('uploads/'. 'all-' .$name_model . '/' . $name_model .$this->id)){
            foreach ($this->imageFiles as $file) {
                $generated_name = strtolower(md5(uniqid($file->baseName)));
                $path = 'uploads/'. 'all-' .$name_model . '/'. $name_model .$this->id .'/'. $generated_name . '.' . $file->extension;
                $file->saveAs($path);
                $pathtoarray[] = [$path];
            }
            return $pathtoarray;
        }else{
            mkdir('uploads/'. 'all-' .$name_model . '/' . $name_model .$this->id);
            foreach ($this->imageFiles as $file) {
                $generated_name = strtolower(md5(uniqid($file->baseName)));
                $path = 'uploads/'. 'all-' .$name_model . '/'. $name_model .$this->id .'/'. $generated_name . '.' . $file->extension;
                $file->saveAs($path);
                $pathtoarray[] = [$path];
            }
            return $pathtoarray;
        }
    }

    //--- Удаление картинок при удалении продукта (очистка файлов и папки и БД)---
    public function beforeDelete()
    {
        $path_current_images = Image::find()->andWhere(['itemId' => $this->id])->all();
        if($path_current_images){
            foreach ($path_current_images as $current_image){
                unlink($current_image->filePath);
                $current_image->delete();
            }
            rmdir('uploads/all-Product/Product' . $this->id);

        }

        return parent::beforeDelete(); // TODO: Change the autogenerated stub
    }

    //--- Редактирование (update) одной картинки при обновлении продукта---

    public function updateImage($fileimg, $current_image)
    {
//        var_dump($fileimg);die();
        if ($this->validate() & $fileimg ==!null) {

            $generated_name = strtolower(md5(uniqid($this->imageFile->baseName)));
            $name_model = StringHelper::basename(get_class($this));

            if($current_image->filePath){
                unlink($current_image->filePath);
            }

            if($this->imageFile==!null){
                if (!file_exists('uploads/'. 'all-' .$name_model . '/'. $name_model .$this->id)){

                    mkdir('uploads/'. 'all-' .$name_model . '/'. $name_model .$this->id);
                    $path = 'uploads/'. 'all-' .$name_model . '/'. $name_model .$this->id .'/'. $generated_name . '.' . $this->imageFile->extension;
                    $this->imageFile->saveAs($path);
                    return $path;
                }else {
                    $path = 'uploads/'. 'all-' .$name_model . '/'. $name_model .$this->id .'/'. $generated_name . '.' . $this->imageFile->extension;
                    $this->imageFile->saveAs($path);
                    return $path;
                }
            }
        } else {
            return false;
        }
    }

    //--- Редактирование (update) многих картинок при обновлении продукта---
    public function updateImages($images)
    {

        $name_model = StringHelper::basename(get_class($this));
//        if ($this->validate()) {

            if($this->imageFiles==!null){
//                debug($images);die();
                if (!file_exists('uploads/' . 'all-' .$name_model . '/'. $name_model .$this->id)){
                    mkdir('uploads/'. 'all-' .$name_model . '/'. $name_model .$this->id);
                    $pathtoarray = [];
                    foreach ($this->imageFiles as $file) {
//                        var_dump($this->imageFiles);
                        $generated_name = strtolower(md5(uniqid($file->baseName)));
                        $path = 'uploads/'. 'all-' .$name_model . '/'. $name_model .$this->id .'/'. $generated_name . '.' . $file->extension;
                        $file->saveAs($path);
                        $pathtoarray[] = [$path];
                    }
                    return $pathtoarray;
//                    debug($pathtoarray);

                }else {
                    foreach ($this->imageFiles as $file) {
                        $generated_name = strtolower(md5(uniqid($file->baseName)));
                        $path = 'uploads/'. 'all-' .$name_model . '/'. $name_model .$this->id .'/'. $generated_name . '.' . $file->extension;
                        $file->saveAs($path);
                        $pathtoarray[] = [$path];
                    }
                    return $pathtoarray;
                }
            }
            return false;
//        } else {
//            return false;
//        }
    }












    //    Получение пути к одной картинки из таблицы картинок (image)
//    public function getImage(){
//        return $this->hasOne(Image::className(), ['itemId' => 'id']);
//        $image = Image::find()->andWhere(['itemId' => $this->id])->andWhere(['isMain' => 1]) ->one();
//    }




//    Загрузка картинки при обновлении
//    public function uploadImage($fileimg, $currentimage)
//    {
//
//        if ($this->validate()) {
//
//            $genfilename = strtolower(md5(uniqid($this->imageFile->baseName)));
//
//            if($currentimage->filePath){
//                unlink($currentimage->filePath);
//            }
//
//            if($this->imageFile==!null){
//                if (!file_exists('uploads/Products/' . 'Product' .$this->id)){
//
//                    mkdir('uploads/Products/' . 'Product' .$this->id);
//                    $pathto = 'uploads/Products/' . 'Product' .$this->id .'/'. $genfilename . '.' . $this->imageFile->extension;
//                    $this->imageFile->saveAs($pathto);
//                    return $pathto;
//                }else {
//                    $pathto = 'uploads/Products/' . 'Product' . $this->id .'/'. $genfilename . '.' . $this->imageFile->extension;
//                    $this->imageFile->saveAs($pathto);
//                    return $pathto;
//                }
//            }
//        } else {
//            return false;
//        }
//    }






//    public function uploadImages($filesimages)
//    {
//        if ($this->validate()) {
//
//            if($this->imageFiles==!null){
//
//                if (!file_exists('uploads/Products/' . 'Product' .$this->id)){
//                    mkdir('uploads/Products/' . 'Product' .$this->id);
//                    $pathtoarray = [];
//                    foreach ($this->imageFiles as $file) {
////                        var_dump($this->imageFiles);
//                        $genfilename = strtolower(md5(uniqid($file->baseName)));
//                        $pathto = 'uploads/Products/' . 'Product' .$this->id .'/'. $genfilename . '.' . $file->extension;
//                        $file->saveAs($pathto);
//                        $pathtoarray[] = [$pathto];
//                    }
//                    return $pathtoarray;
////                    debug($pathtoarray);
//
//                }else {
//                    foreach ($this->imageFiles as $file) {
//                        $genfilename = strtolower(md5(uniqid($file->baseName)));
//                        $pathto = 'uploads/Products/' . 'Product' . $this->id .'/'. $genfilename . '.' . $file->extension;
//                        $file->saveAs($pathto);
//                    }
//                    return $pathto;
//                }
//            }
//            return true;
//        } else {
//            return false;
//        }
//    }
}
