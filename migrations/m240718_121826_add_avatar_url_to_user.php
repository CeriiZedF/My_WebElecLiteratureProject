<?php

use yii\db\Migration;

/**
 * Class m240718_121826_add_avatar_url_to_user
 */
class m240718_121826_add_avatar_url_to_user extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%user}}', 'avatar', $this->string()->defaultValue(null));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%user}}', 'avatar');
    }
}
