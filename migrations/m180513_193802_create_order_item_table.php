<?php

use yii\db\Migration;

/**
 * Handles the creation of table `order_item`.
 */
class m180513_193802_create_order_item_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('order_item', [
            'id' => $this->primaryKey(),
            'order_id' => $this->integer(10),
            'product_id' => $this->integer(10),
            'name' => $this->string(),
            'price' => $this->float(),
            'qty_item' => $this->integer(11),
            'sum_item' => $this->float(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('order_item');
    }
}
