<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\admin\models\Product */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="product-form">
<!--    --><?php //debug($model->category_id); ?>

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

    <?= $form->field($model, 'category_id')->dropDownList( $model->CategoryList, ['class'=>'form-control']) ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'keywords')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'description')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'alias')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'content')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'price')->textInput() ?>

    <?= $form->field($model, 'hit')->textInput() ?>

    <?= $form->field($model, 'new')->textInput() ?>

    <?= $form->field($model, 'sale')->textInput() ?>

<!--    Вывод основной картинки-->
    <?= $form->field($model, 'imageFile')->fileInput() ?>
    <div class="view__product">
        <?  if($model->pathImage()){
//            вывод картинка
                echo Html::img('/web/' . $model->pathImage()->filePath, ['width' => '100', 'class' => 'postImg']);
            }
        ?>
        <p style="display: none;" class="alert__text">Удалено</p>
        <?php
//        debug($model->idImage()->idImage);
        if($model->pathImage()){
            echo Html::a('<span title ="удалить" class="glyphicon glyphicon-remove"></span>', ['product/deleteimage', 'idimg' => $model->idImage()->idImage, 'id' => $model->id], [
                'onclick'=>
                    "$.ajax({
                    type:'POST',
                    cache: false,
                    url: '".Url::to(['product/deleteimage', 'idimg' => $model->idImage()->idImage, 'id' => $model->id])."',
                    success  : function(response) {
                        $('.link-del').html(response);
                        $('.postImg').hide(300);
                        $('.alert__text').show('slow');
                        setTimeout(function() { $('.alert__text').hide('slow'); }, 2000);
                    }
                });
                return false;",
                'class' => 'link-del'
            ]);
        }
        //            поле для ввода имени картинки
//            echo $form->field($model, 'name_image')->textInput();
        ?>
    </div>


<!--вывод всех картинок-->
    <?= $form->field($model, 'imageFiles[]')->fileInput(['multiple' => true, 'accept' => 'image/*']) ?>

    <div class="view__product">

        <?  if($model->pathImages()):?>
            <?php $images = $model->pathImages();
                foreach ($images as $image):
//                    debug($image);
                    echo Html::img('/web/' . $image->filePath, ['width' => '100', 'class' => 'postImg'.$image->idImage]); ?>

                    <p style="display: none;" class="alert__text<?php $image->idImage ?><?php echo $image->idImage?> ">Удалено</p>

                    <?php if($model->pathImages()){

                        $idimgs = $model->idImages();

                            echo Html::a('<span title ="удалить" class="glyphicon glyphicon-remove"></span>', ['product/deleteimage', 'idimg' => $image->idImage, 'id' => $model->id], [
                                'onclick'=>
                                    "$.ajax({
                                        type:'POST',
                                        cache: false,
                                        url: '".Url::to(['product/deleteimage', 'idimg' => $image->idImage, 'id' => $model->id])."',
                                        success  : function(response) {
                                            $('.link-del$image->idImage').html(response);
                                            $('.postImg$image->idImage').hide(300);
                                            $('.alert__text$image->idImage').show('slow');
                                            setTimeout(function() { $('.alert__text$image->idImage').hide('slow'); }, 1500);
                                        }
                                    });
                                    return false;",
                                'class' => 'link-del'.$image->idImage
                            ]);

                        }
                //            поле для ввода имени картинки
//                echo $form->field($model, 'name_image')->textInput();
                    ?>
                <?php endforeach; ?>
        <?php endif; ?>


    </div>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
