<?php
use app\widgets\MenuWidget;
//  $this->params['breadcrumbs'][] = $category->name;
//  $this->params['breadcrumbs'][] = 'ssc';
//    debug($this->params['breadcrumbs']);
//?>

<div class="container">
    <div class="wrap__product__page">
        <div class="left__block__category">
            <div class="category__title">
                <h2>Категории</h2>
            </div>
            <ul class="catalog">
                <?= MenuWidget::widget(['tpl'=>'menu']); ?>
            </ul>
        </div>
        <div class="right__block__product">
            <a data-fancybox="gallery" href="/web/images/index-img1.jpeg"><img src="/web/images/index-img1.jpeg"></a>
            <a data-fancybox="gallery" href="/web/images/main-fon.jpg"><img src="/web/images/main-fon.jpg"></a>
        </div>
    </div>
</div>
