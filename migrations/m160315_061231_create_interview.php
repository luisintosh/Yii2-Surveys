<?php

use yii\db\Migration;

class m160315_061231_create_interview extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('interview', [
            'id' => $this->primaryKey(),
            'id_survey' => $this->integer()->notNull(),
            'unique' => $this->string(),
            'contact_email' => $this->string(),
            'refer_url' => $this->string(),
            'country' => $this->string(),
            'web_browser' => $this->string(),
            'ip_address' => $this->string(),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
        ], $tableOptions);

        $this->createTable('interview_answer', [
            'id' => $this->primaryKey(),
            'id_interview' => $this->integer()->notNull(),
            'id_question' => $this->integer()->notNull(),
            'id_question_option' => $this->integer()->notNull(),
            'a_number' => $this->integer(),
            'a_text' => $this->text(),
            'a_bool' => $this->boolean(),
            'a_date' => $this->date(),
            'a_time' => $this->time(),
        ], $tableOptions);


        $this->addForeignKey('fk_interview_survey', 'interview', 'id_survey', 'survey', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('fk_interview_answer_interview', 'interview_answer', 'id_interview', 'interview', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('fk_interview_answer_question', 'interview_answer', 'id_question', 'question', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('fk_interview_answer_question_option', 'interview_answer', 'id_question_option', 'question_option', 'id', 'CASCADE', 'CASCADE');
    }

    public function down()
    {
        $this->dropTable('interview_answer');
        $this->dropTable('interview');
    }
}
