<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class TransactionDetail extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => TRUE,
                'auto_increment' => TRUE
            ],
            'transaction_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => TRUE,
            ],
            'product_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => TRUE,
            ],
            'jumlah' => [
                'type' => 'INT',
                'constraint' => 5,
                'null' => FALSE,
            ],
            'diskon' => [
                'type' => 'DOUBLE',
                'null' => TRUE,
            ],
            'subtotal_harga' => [
                'type' => 'DOUBLE',
                'null' => FALSE,
            ],
            'created_at' => [
                'type' => 'datetime',
                'null' => TRUE
            ],
            'updated_at' => [
                'type' => 'datetime',
                'null' => TRUE
            ]
        ]);

        $this->forge->addKey('id', TRUE);
        $this->forge->createTable('transaction_detail');
    }

    public function down()
    {
        $this->forge->dropTable('transaction_detail');
    }
}