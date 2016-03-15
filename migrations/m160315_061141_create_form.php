<?php

use yii\db\Migration;

class m160315_061141_create_form extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('form', [
            'id' => $this->primaryKey(6),
            'id_user' => $this->integer()->notNull(),
            'title' => $this->string()->notNull()->unique(),
            'description' => $this->text(),
            'logo_url' => $this->string(),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
        ], $tableOptions);

        $this->createTable('form_design', [
            'id' => $this->primaryKey(),
            'id_form' => $this->integer()->notNull(),
            'color' => $this->string(),
            'font_text' => $this->integer(),
            'background_img' => $this->string(),
        ], $tableOptions);

        $this->createTable('form_preferences', [
            'id' => $this->primaryKey(),
            'id_form' => $this->integer()->notNull(),
            'status' => $this->integer()->notNull()->defaultValue(0),
            'start_at' => $this->dateTime()->notNull(),
            'end_at' => $this->dateTime(),
            'end_msg' => $this->text(),
            'onesection_perpage' => $this->boolean()->defaultValue(false),
            'can_multiple_sendings' => $this->boolean()->defaultValue(true),
            'can_returnsection' => $this->boolean()->defaultValue(true),
            'show_section_number' => $this->boolean()->defaultValue(true),
            'random_question' => $this->boolean()->defaultValue(false),
            'show_progressbar' => $this->boolean()->defaultValue(true),
            'email_notifications' => $this->boolean()->defaultValue(true),
            'can_social_share' => $this->boolean()->defaultValue(true),
            'private' => $this->boolean()->defaultValue(false),
            'private_password' => $this->string(),
            'redirection_type' => $this->integer(),
            'redirection_url' => $this->string(),
        ], $tableOptions);

        $this->createTable('form_section', [
            'id' => $this->primaryKey(),
            'id_form' => $this->integer()->notNull(),
            'title' => $this->string(),
            'description' => $this->text(),
        ], $tableOptions);

        $this->addForeignKey('fk_form_user', 'form', 'id_user', 'user', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('fk_design_form', 'form_design', 'id_form', 'form', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('fk_preferences_form', 'form_preferences', 'id_form', 'form', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('fk_section_form', 'form_section', 'id_form', 'form', 'id', 'CASCADE', 'CASCADE');
    }

    public function down()
    {
        $this->dropTable('form_section');
        $this->dropTable('form_preferences');
        $this->dropTable('form_design');
        $this->dropTable('form');
    }
}
