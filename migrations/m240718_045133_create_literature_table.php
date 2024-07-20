<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%literature}}`.
 */
class m240718_045133_create_literature_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function up()
    {
        $this->createTable('literature', [
            'id' => $this->primaryKey(),
            'title' => $this->string()->notNull(),
            'author' => $this->string(),
            'description' => $this->text(),
            'category_id' => $this->integer(),
            'cover_url' => $this->string(),
            'type' => "ENUM('book', 'novel', 'light_novel', 'romance') NOT NULL",
            'created_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
            'updated_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'),
    ]);

        // Add foreign key for category_id
        $this->addForeignKey(
            'fk-literature-category_id',
            'literature',
            'category_id',
            'categories',
            'id',
            'CASCADE'
        );
    }

    public function down()
    {
        $this->dropTable('literature');
    }

}
