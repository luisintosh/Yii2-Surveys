<?php

use yii\db\Migration;

class m160315_061243_create_options extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }
        $this->createTable('app_options', [
            'id' => $this->primaryKey(),
            'option_name' => $this->string()->unique(),
            'option_value' => $this->string(),
        ], $tableOptions);

        $this->batchInsert('app_options', ['option_name', 'option_value'], [
            ['home_url', ''],
            ['app_name', 'website name'],
            ['app_description', 'website description'],
            ['logo_url', ''],
            ['can_register_users', '1'],
            ['support_email', 'admin@admin.com'],
            ['mailserver_url', ''],
            ['mailserver_login', ''],
            ['mailserver_pass', ''],
            ['mailserver_port', ''],
            ['social_facebook_page', ''],
            ['social_twitter_user', ''],
        ]);
    }

    public function down()
    {
        $this->dropTable('app_options');
    }
}
