<?php

use yii\db\Migration;

class m160315_061201_create_question extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('group_type', [
            'id' => $this->primaryKey(),
            'input_type' => $this->string(),
            'name' => $this->string()->notNull()->unique(),
            'description' => $this->string(),
        ], $tableOptions);


        $this->createTable('question', [
            'id' => $this->primaryKey(),
            'id_survey_section' => $this->integer()->notNull(),
            'id_group_type' => $this->integer()->notNull(),
            'title' => $this->string()->notNull(),
            'optional' => $this->boolean()->defaultValue(false),
            'add_textbox' => $this->boolean()->defaultValue(false),
        ], $tableOptions);


        $this->createTable('question_extraitem', [
            'id' => $this->primaryKey(),
            'id_question' => $this->integer()->notNull(),
            'tip' => $this->string(),
            'image_url' => $this->string(),
            'videoyt_url' => $this->string(),
            'soundcloud_url' => $this->string(),
        ], $tableOptions);


        $this->createTable('question_option', [
            'id' => $this->primaryKey(),
            'id_question' => $this->integer()->notNull(),
            'title' => $this->string()->notNull(),
        ], $tableOptions);


        $this->addForeignKey('fk_question_section', 'question', 'id_survey_section', 'survey_section', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('fk_question_group_type', 'question', 'id_group_type', 'group_type', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('fk_extraitem_question', 'question_extraitem', 'id_question', 'question', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('fk_option_question', 'question_option', 'id_question', 'question', 'id', 'CASCADE', 'CASCADE');


        $input_types = ['text','text_area','radio','checkbox','date','time'];

        $this->batchInsert('group_type', ['id', 'input_type', 'name'], [
            [1, 'text', 'short_answer'],
            [2, 'text_area', 'long_answer'],
            [3, 'text', 'number'],
            [4, 'radio', 'select_options'],
            [5, 'checkbox', 'multiselect_options'],
            [6, 'radio', 'linear_scale'],
            [7, 'radio', 'true_false'],
            [8, 'date', 'date'],
            [9, 'time', 'time'],
        ]);
    }

    public function down()
    {

        $this->dropTable('question_option');
        $this->dropTable('question_extraitem');
        $this->dropTable('question');
        $this->dropTable('group_type');
    }
}
