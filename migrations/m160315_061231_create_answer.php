<?php

use yii\db\Migration;

class m160315_061231_create_answer extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('answer', [
            'id' => $this->primaryKey(),
            'id_question_option' => $this->integer()->notNull(),
            'a_number' => $this->integer(),
            'a_text' => $this->text(),
            'a_bool' => $this->boolean(),
            'a_date' => $this->date(),
            'a_time' => $this->time(),
            'created_at' => $this->timestamp(),
            'updated_at' => $this->timestamp(),
        ], $tableOptions);


        $this->createTable('answer_detail', [
            'id' => $this->primaryKey(),
            'id_survey' => $this->integer()->notNull(),
            'id_cookie' => $this->string()->notNull()->unique(),
            'contact_email' => $this->string(),
            'refer_url' => $this->string(),
            'country' => $this->string(),
            'web_browser' => $this->string(),
            'platform' => $this->string(),
        ], $tableOptions);


        $this->createTable('survey_comment', [
            'id' => $this->primaryKey(),
            'id_survey' => $this->integer()->notNull(),
            'text' => $this->text(),
            'created_at' => $this->timestamp(),
            'updated_at' => $this->timestamp(),
        ], $tableOptions);


        $this->addForeignKey('fk_answer_question_option', 'answer', 'id_question_option', 'question_option', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('fk_answer_detail_survey', 'answer_detail', 'id_survey', 'survey', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('fk_comment_survey', 'survey_comment', 'id_survey', 'survey', 'id', 'CASCADE', 'CASCADE');
    }

    public function down()
    {
        $this->dropTable('answer');
        $this->dropTable('answer_detail');
        $this->dropTable('survey_comment');
    }
}
