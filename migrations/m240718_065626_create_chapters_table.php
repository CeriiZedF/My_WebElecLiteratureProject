<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%chapters}}`.
 */
class m240718_065626_create_chapters_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%chapters}}', [
            'id' => $this->primaryKey(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%chapters}}');
    }
}
