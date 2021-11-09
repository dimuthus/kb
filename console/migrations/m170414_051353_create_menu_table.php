<?php

use yii\db\Schema;
use yii\db\Migration;

class m170414_051353_create_menu_table extends Migration
{
    public function up()
    {
		$this->createTable('{{%menu}}', [
		'id' => $this->primaryKey(),
		//'tree' => $this->integer()->notNull(),
		'lft' => $this->integer()->notNull(),
		'rgt' => $this->integer()->notNull(),
		'depth' => $this->integer()->notNull(),
		'name' => $this->string()->notNull(),
		]);

    }

    public function down()
    {
        echo "m170414_051353_create_menu_table cannot be reverted.\n";

        return false;
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
