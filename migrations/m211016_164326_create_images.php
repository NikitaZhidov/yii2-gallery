<?php

use yii\db\Migration;

/**
 * Class m211016_164326_create_images
 */
class m211016_164326_create_images extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('images', [
            'id' => $this->primaryKey(),
            'name' => $this->string(),
            'caption' => $this->string()
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('images');

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m211016_164326_create_images cannot be reverted.\n";

        return false;
    }
    */
}
