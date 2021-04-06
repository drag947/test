<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%company_user}}`.
 */
class m210331_224917_create_company_user_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%company_user}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(),
            'type' => $this->string(10),
            'user_id' => $this->integer(),
            'inn' => $this->string(),
            'full_name' => $this->text(),
            'phone'  => $this->string(),
            'full_name_user' => $this->string(),
        ]);

        $this->createIndex(
            'idx-company_user-user_id',
            '{{%company_user}}',
            'user_id'
        );

        $this->addForeignKey(
            'fk-company_user-user_id',
            '{{%company_user}}',
            'user_id',
            '{{%user}}',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%company_user}}');
    }
}
