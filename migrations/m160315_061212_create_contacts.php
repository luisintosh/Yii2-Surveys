<?php

use yii\db\Migration;

class m160315_061212_create_contacts extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('contact_list', [
            'id' => $this->primaryKey(),
            'title' => $this->string(),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
        ], $tableOptions);

        $this->createTable('contact', [
            'id' => $this->primaryKey(),
            'id_contact_list' => $this->integer()->notNull(),
            'contact_name' => $this->string(),
            'contact_email' => $this->string()->notNull(),
        ], $tableOptions);

        // relacion muchos a muchos
        $this->createTable('survey_contacts', [
            'id' => $this->primaryKey(),
            'id_survey' => $this->integer()->notNull(),
            'id_contact_list' => $this->integer()->notNull(),
        ], $tableOptions);

        $this->addForeignKey('fk_contact_list', 'contact', 'id_contact_list', 'contact_list', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('fk_enc_list_enc', 'survey_contacts', 'id_survey', 'survey', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('fk_rel_lc_enc', 'survey_contacts', 'id_contact_list', 'contact_list', 'id', 'CASCADE', 'CASCADE');
    }

    public function down()
    {
        $this->dropTable('survey_contacts');
        $this->dropTable('contact');
        $this->dropTable('contact_list');
    }
}
