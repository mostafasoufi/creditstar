<?php

use yii\db\Schema;
use yii\db\Migration;

/**
 * Class m170911_093407_setup
 */
class m170911_093407_setup extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $this->createTable('user', [
            'id' => Schema::TYPE_PK,
            'first_name' => Schema::TYPE_TEXT . ' NOT NULL',
            'last_name' => Schema::TYPE_TEXT . ' NOT NULL',
            'email' => Schema::TYPE_TEXT . ' NOT NULL',
            'personal_code' => Schema::TYPE_BIGINT . ' NOT NULL',
            'phone' => Schema::TYPE_BIGINT . ' NOT NULL',
            'active' => Schema::TYPE_BOOLEAN,
            'dead' => Schema::TYPE_BOOLEAN,
            'lang' => Schema::TYPE_TEXT
        ]);

        $this->createTable('loan', [
            'id' => Schema::TYPE_PK,
            'user_id' => Schema::TYPE_BIGINT . ' NOT NULL',
            'amount' => 'NUMERIC( 10, 2 ) NOT NULL',
            'interest' => 'NUMERIC( 10, 2 ) NOT NULL',
            'duration' => Schema::TYPE_INTEGER . ' NOT NULL',
            'start_date' => Schema::TYPE_DATE . ' NOT NULL',
            'end_date' => Schema::TYPE_DATE . ' NOT NULL',
            'campaign' => Schema::TYPE_INTEGER . ' NOT NULL',
            'status' => Schema::TYPE_BOOLEAN
        ]);
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        $this->dropTable('user');
        $this->dropTable('loan');
    }
}
