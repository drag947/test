<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%form_pay}}`.
 */
class m210331_233657_create_form_pay_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%form_pay}}', [
            'id' => $this->primaryKey(),
            'type' => $this->integer(),
            'user_id' => $this->integer(),
            'company_user_id' => $this->integer(),
            'method' => $this->string(30)
        ]);

        $this->createIndex(
            'idx-form_pay-user_id',
            '{{%form_pay}}',
            'user_id'
        );

        $this->addForeignKey(
            'fk-form_pay-user_id',
            '{{%form_pay}}',
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
        $this->dropTable('{{%form_pay}}');
    }
}
