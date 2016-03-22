<?php

use yii\db\Migration;

class m160315_061141_create_survey extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('survey', [
            'id' => $this->primaryKey(6),
            'id_user' => $this->integer()->notNull(),
            'title' => $this->string()->notNull(),
            'description' => $this->text(),
            'status' => $this->integer()->notNull()->defaultValue(0),
            'logo_url' => $this->string(),
            'created_at' => $this->timestamp(),
            'updated_at' => $this->timestamp(),
        ], $tableOptions);

        $this->createTable('survey_design', [
            'id' => $this->primaryKey(),
            'id_survey' => $this->integer()->notNull(),
            'color' => $this->string(),
            'font_text' => $this->integer(),
            'background_img' => $this->string(),
        ], $tableOptions);

        $this->createTable('survey_preferences', [
            'id' => $this->primaryKey(),
            'id_survey' => $this->integer()->notNull(),
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

        $this->createTable('survey_section', [
            'id' => $this->primaryKey(),
            'id_survey' => $this->integer()->notNull(),
            'title' => $this->string(),
            'description' => $this->text(),
        ], $tableOptions);

        $this->addForeignKey('fk_survey_user', 'survey', 'id_user', 'user', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('fk_design_survey', 'survey_design', 'id_survey', 'survey', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('fk_preferences_survey', 'survey_preferences', 'id_survey', 'survey', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('fk_section_survey', 'survey_section', 'id_survey', 'survey', 'id', 'CASCADE', 'CASCADE');
    }

    public function down()
    {
        $this->dropTable('survey_section');
        $this->dropTable('survey_preferences');
        $this->dropTable('survey_design');
        $this->dropTable('survey');
    }
}
