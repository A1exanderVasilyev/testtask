<?php

use yii\db\Migration;

/**
 * Class m200728_110216_couponsdata
 */
class m200728_110216_couponsdata extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable( 'couponsdata', [
            'id' => $this->primaryKey(10),
            'shop_id' => $this->integer(10),
            'title' => $this->string(255),
            'content' => $this->text(255),
            'ends_at' => $this->date(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m200728_110216_couponsdata cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200728_110216_couponsdata cannot be reverted.\n";

        return false;
    }
    */
}
