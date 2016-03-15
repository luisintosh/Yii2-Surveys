<?php

use yii\db\Schema;
use yii\db\Migration;

class m160201_053226_init_user extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        // create tables. note the specific order
        $this->createTable('{{%role}}', [
            'id' => Schema::TYPE_PK,
            'name' => Schema::TYPE_STRING . ' not null',
            'created_at' => Schema::TYPE_TIMESTAMP . ' null',
            'updated_at' => Schema::TYPE_TIMESTAMP . ' null',
            'can_admin' => Schema::TYPE_SMALLINT . ' not null default 0',
        ], $tableOptions);
        $this->createTable('{{%user}}', [
            'id' => Schema::TYPE_PK,
            'role_id' => Schema::TYPE_INTEGER . ' not null',
            'status' => Schema::TYPE_SMALLINT . ' not null',
            'email' => Schema::TYPE_STRING . ' null',
            'username' => Schema::TYPE_STRING . ' null',
            'password' => Schema::TYPE_STRING . ' null',
            'auth_key' => Schema::TYPE_STRING . ' null',
            'access_token' => Schema::TYPE_STRING . ' null',
            'logged_in_ip' => Schema::TYPE_STRING . ' null',
            'logged_in_at' => Schema::TYPE_TIMESTAMP . ' null',
            'created_ip' => Schema::TYPE_STRING . ' null',
            'created_at' => Schema::TYPE_TIMESTAMP . ' null',
            'updated_at' => Schema::TYPE_TIMESTAMP . ' null',
            'banned_at' => Schema::TYPE_TIMESTAMP . ' null',
            'banned_reason' => Schema::TYPE_STRING . ' null',
        ], $tableOptions);
        $this->createTable('{{%user_token}}', [
            'id' => Schema::TYPE_PK,
            'user_id' => Schema::TYPE_INTEGER . ' null',
            'type' => Schema::TYPE_SMALLINT . ' not null',
            'token' => Schema::TYPE_STRING . ' not null',
            'data' => Schema::TYPE_STRING . ' null',
            'created_at' => Schema::TYPE_TIMESTAMP . ' null',
            'expired_at' => Schema::TYPE_TIMESTAMP . ' null',
        ], $tableOptions);
        $this->createTable('{{%profile}}', [
            'id' => Schema::TYPE_PK,
            'user_id' => Schema::TYPE_INTEGER . ' not null',
            'created_at' => Schema::TYPE_TIMESTAMP . ' null',
            'updated_at' => Schema::TYPE_TIMESTAMP . ' null',
            'full_name' => Schema::TYPE_STRING . ' null',
            'sex' => Schema::TYPE_STRING . ' null',
            'state' => Schema::TYPE_STRING . ' null',
            'city' => Schema::TYPE_STRING . ' null',
            'zip' => Schema::TYPE_INTEGER . ' null',
            'tel_office' => Schema::TYPE_INTEGER . ' null',
            'tel_mobile' => Schema::TYPE_INTEGER . ' null',
            'bio' => Schema::TYPE_TEXT . ' null',
            'timezone' => Schema::TYPE_STRING . ' null',
        ], $tableOptions);
        $this->createTable('{{%user_auth}}', [
            'id' => Schema::TYPE_PK,
            'user_id' => Schema::TYPE_INTEGER . ' not null',
            'provider' => Schema::TYPE_STRING . ' not null',
            'provider_id' => Schema::TYPE_STRING . ' not null',
            'provider_attributes' => Schema::TYPE_TEXT . ' not null',
            'created_at' => Schema::TYPE_TIMESTAMP . ' null',
            'updated_at' => Schema::TYPE_TIMESTAMP . ' null'
        ], $tableOptions);

        // add indexes for performance optimization
        $this->createIndex('{{%user_email}}', '{{%user}}', 'email', true);
        $this->createIndex('{{%user_username}}', '{{%user}}', 'username', true);
        $this->createIndex('{{%user_token_token}}', '{{%user_token}}', 'token', true);
        $this->createIndex('{{%user_auth_provider_id}}', '{{%user_auth}}', 'provider_id', false);

        // add foreign keys for data integrity
        $this->addForeignKey('{{%user_role_id}}', '{{%user}}', 'role_id', '{{%role}}', 'id');
        $this->addForeignKey('{{%profile_user_id}}', '{{%profile}}', 'user_id', '{{%user}}', 'id');
        $this->addForeignKey('{{%user_token_user_id}}', '{{%user_token}}', 'user_id', '{{%user}}', 'id');
        $this->addForeignKey('{{%user_auth_user_id}}', '{{%user_auth}}', 'user_id', '{{%user}}', 'id');

        // insert role data
        $columns = ['name', 'can_admin', 'created_at'];
        $this->batchInsert('{{%role}}', $columns, [
            ['admin', 1, gmdate('Y-m-d H:i:s')],
            ['client', 0, gmdate('Y-m-d H:i:s')],
        ]);

        // insert admin user: neo/neo
        $security = Yii::$app->security;
        $columns = ['role_id', 'email', 'username', 'password', 'status', 'created_at', 'access_token', 'auth_key'];
        $this->batchInsert('{{%user}}', $columns, [
            [
                1, // Role::ROLE_ADMIN
                'admin@website.com',
                'admin',
                Yii::$app->security->generatePasswordHash('admin'), // password
                1, // User::STATUS_ACTIVE
                gmdate('Y-m-d H:i:s'),
                $security->generateRandomString(),
                $security->generateRandomString(),
            ],
        ]);

        // insert profile data
        $columns = ['user_id', 'full_name', 'created_at'];
        $this->batchInsert('{{%profile}}', $columns, [
            [1, 'Administrador', gmdate('Y-m-d H:i:s')],
        ]);
    }

    public function down()
    {
        // drop tables in reverse order (for foreign key constraints)
        $this->dropTable('{{%user_auth}}');
        $this->dropTable('{{%profile}}');
        $this->dropTable('{{%user_token}}');
        $this->dropTable('{{%user}}');
        $this->dropTable('{{%role}}');
    }

    /*
    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
    }

    public function safeDown()
    {
    }
    */
}
