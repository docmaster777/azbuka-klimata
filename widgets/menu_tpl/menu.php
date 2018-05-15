<li>
    <? $url = $category['alias'];?>

    <a href="<?= \yii\helpers\Url::to($url) ?>">
        <?= $category['name']?>
        <?php if( isset($category['childs']) ): ?>
            <span class="badge pull-right"><i class="fas fa-plus-circle"></i></span>
        <?php endif;?>
    </a>
    <?php if( isset($category['childs']) ): ?>
        <ul>
            <?= $this->getMenuHtml($category['childs'])?>
        </ul>
    <?php endif;?>

</li>