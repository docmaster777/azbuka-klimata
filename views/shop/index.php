<?php
use yii\helpers\Html;
?>
<div class="container">
    <div class="wrap__index__shop">
        <div class="index__shop__title">
            <h2><b>АЗБУКА КЛИМАТА</b> - это магазин  в котором Вы найдете для себя большое количество товаров которые соответствуют цене - качеству и прослужит долгие годы.</h2>
        </div>
        <div class="index__shop__slider">
            <div class="sl__slide__shop">
                <img src="/web/images/main-slider/sl1.jpg" alt="">
            </div>
            <div class="sl__slide__shop">
                <img src="/web/images/main-slider/sl2.jpg" alt="">
            </div>
        </div>
    </div>
    <div class="wrap__shop__second__block">
        <div class="left__block__shop">
            <div class="category__title">
                <h2>Категории</h2>
            </div>
            <ul class="catalog">
                <?= \app\widgets\MenuWidget::widget(['tpl'=>'menu']); ?>
            </ul>
        </div>
        <div class="right__block__shop">
            <?php if(!empty($hits)): ?>
                <div class="popular__goods__title">
                    <h2>Популярные товары</h2>
                </div>
                <div class="products__wrapper">
                    <?php foreach ($hits as $hit): ?>
                        <div class="card__product__wrap">
                            <a href="<?= \yii\helpers\Url::to($hit->category_alias . '/' . $hit->alias) ?>">
                                <div class="cart__product__img">
                                    <?= Html::img('@web/images/index-img1.jpeg', ['alt' => $hit->name, 'title' => $hit->name]) ?>
                                </div>
                                <div class="cart__product__name">
                                    <p><b>Имя:</b> <?=$hit->name  ?></p>
                                </div>
                                <div class="cart__product__price">
                                    <p><b>Цена: </b><?=$hit->price ?> руб.</p>
                                </div>
                            </a>
                                <div class="cart__product__card">
                                    <div class="buttons-coll">
                                        <a class="add-to-cart" data-id="<?= $hit->id ?>" href="<?= \yii\helpers\Url::to(['card/add', 'id' => $hit->id]) ?>"><button class="custom-btn btn-5"><span>Добавить в корзину</span></button></a>
                                    </div>
                                </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>

    </div>










</div>