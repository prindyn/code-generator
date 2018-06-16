<?php

use yii\db\Migration;

/**
 * Class m180616_115627_code
 */
class m180616_115627_code extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function Up()
    {
        $this->createTable('code', [
            'id' => $this->primaryKey(),
            'code_item' => $this->string(100)->notNull(),
            'created_at' => $this->dateTime()->notNull(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m180616_115627_code cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180616_115627_code cannot be reverted.\n";

        return false;
    }
    */
}
