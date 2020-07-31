<?php

use yii\db\Migration;

/**
 * Class m200728_104556_shopsdata
 */
class m200728_104556_shopsdata extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable( 'shopsdata', [
            'id' => $this->primaryKey(10),
            'shopName' => $this->string(255),
            'url' => $this->string(255),
            'parsed' => $this->boolean(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m200728_104556_shopsdata cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200728_104556_shopsdata cannot be reverted.\n";

        return false;
    }
    */
}
