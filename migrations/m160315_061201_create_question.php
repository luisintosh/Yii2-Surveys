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

        $this->createTable('input_type', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->unique(),
        ], $tableOptions);

        $this->batchInsert('input_type', ['id', 'name'], [
            [1, 'text'],
            [2, 'text_area'],
            [3, 'radio'],
            [4, 'checkbox'],
            [5, 'date'],
            [6, 'time'],
            [7, 'dropdown'],
            [8, 'image'],
        ]);

        $this->createTable('group_type', [
            'id' => $this->primaryKey(),
            'id_input_type' => $this->integer()->notNull(),
            'name' => $this->string()->notNull()->unique(),
            'description' => $this->string(),
        ], $tableOptions);

        $this->addForeignKey('fk_group_input_type', 'group_type', 'id_input_type', 'input_type', 'id', 'CASCADE', 'CASCADE');

        $this->batchInsert('group_type', ['id_input_type', 'name'], [
            [1, 'number'],
            [1, 'short_answer'],
            [2, 'long_answer'],
            [3, 'select_options'],
            [3, 'linear_scale'],
            [3, 'true_false'],
            [4, 'multiselect_options'],
            [5, 'date'],
            [6, 'time'],
            [7, 'dropdown_menu'],
        ]);



        $this->createTable('question', [
            'id' => $this->primaryKey(),
            'id_form_section' => $this->integer()->notNull(),
            'id_group_type' => $this->integer()->notNull(),
            'title' => $this->string()->notNull(),
            'optional' => $this->boolean()->defaultValue(false),
            'add_textbox' => $this->boolean()->defaultValue(false),
        ], $tableOptions);

        $this->addForeignKey('fk_question_section', 'question', 'id_form_section', 'form_section', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('fk_question_group_type', 'question', 'id_group_type', 'group_type', 'id', 'CASCADE', 'CASCADE');



        $this->createTable('question_extraitem', [
            'id' => $this->primaryKey(),
            'id_question' => $this->integer()->notNull(),
            'tip' => $this->string(),
            'image_url' => $this->string(),
            'videoyt_url' => $this->string(),
            'soundcloud_url' => $this->string(),
        ], $tableOptions);

        $this->addForeignKey('fk_extraitem_question', 'question_extraitem', 'id_question', 'question', 'id', 'CASCADE', 'CASCADE');



        $this->createTable('question_option', [
            'id' => $this->primaryKey(),
            'id_question' => $this->integer()->notNull(),
            'title' => $this->string()->notNull(),
        ], $tableOptions);

        $this->addForeignKey('fk_option_question', 'question_option', 'id_question', 'question', 'id', 'CASCADE', 'CASCADE');
    }

    public function down()
    {
        $this->dropTable('input_type');
        $this->dropTable('group_type');
        $this->dropTable('question');
        $this->dropTable('question_extraitem');
        $this->dropTable('question_option');
    }
}