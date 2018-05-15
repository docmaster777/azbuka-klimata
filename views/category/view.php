<?php
use app\widgets\MenuWidget;
use yii\helpers\Html;
?>
<div class="container">
    <div class="wrap__category__block">
    <!--    --><?php // $this->params['breadcrumbs'][] = $category->name ?>
        <div class="left__block__category">
            <div class="category__title">
                <h2>Категории</h2>
            </div>
            <ul class="catalog">
                <?= MenuWidget::widget(['tpl'=>'menu']); ?>
            </ul>
        </div>
        <div class="right__block__category">
            <?php if(!empty($products)): ?>
                <div class="popular__goods__title">
                    <h2><?=$category->name  ?></h2>
                </div>
                <div class="products__wrapper">
                    <?php foreach ($products as $product): ?>
                        <div class="card__product__wrap">
                            <a href="<?= \yii\helpers\Url::to($product->category_alias . '/' . $product->alias) ?>">
                                <div class="cart__product__img">
                                    <?= Html::img('@web/images/index-img1.jpeg', ['alt' => $hit->name, 'title' => $hit->name]) ?>
                                </div>
                                <div class="cart__product__name">
                                    <p><b>Имя:</b> <?=$product->name  ?></p>
                                </div>
                                <div class="cart__product__price">
                                    <p><b>Цена: </b><?=$product->price ?> руб.</p>
                                </div>
                            </a>
                            <div class="cart__product__card">
                                <div class="buttons-coll">
                                    <a href="<?= \yii\helpers\Url::to(['card/index']) ?>"><button class="custom-btn btn-5"><span>Добавить в карзину</span></button></a>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
    <!--                    --><?php
    //                        echo \yii\widgets\LinkPager::widget([
    //                            'pagination' => $pages,
    //                        ]);
    //                    ?>
                <?php else: ?>
                <div class="no__products__block">
                    <h2>Здесь товаров пока нет</h2>
                </div>

            <?php endif; ?>
        </div>

    </div>
</div>