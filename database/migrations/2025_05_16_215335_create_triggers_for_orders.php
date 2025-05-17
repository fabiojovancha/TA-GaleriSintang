<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        // Trigger untuk sales_order
        DB::unprepared('
            CREATE TRIGGER TG_sales_order BEFORE INSERT ON sales_order
            FOR EACH ROW
            BEGIN
                DECLARE lastSoId INT DEFAULT 0;
                SELECT IFNULL(MAX(CAST(SUBSTRING(so_id, 2) AS UNSIGNED)), 0)
                INTO lastSoId
                FROM sales_order;
                SET NEW.so_id = CONCAT("S", LPAD(lastSoId + 1, 4, "0"));
            END
        ');

        // Trigger untuk purchase_order
        DB::unprepared('
            CREATE TRIGGER TG_purchase_order BEFORE INSERT ON purchase_order
            FOR EACH ROW
            BEGIN
                DECLARE lastPoId INT DEFAULT 0;
                SELECT IFNULL(MAX(CAST(SUBSTRING(po_id, 2) AS UNSIGNED)), 0)
                INTO lastPoId
                FROM purchase_order;
                SET NEW.po_id = CONCAT("P", LPAD(lastPoId + 1, 4, "0"));
            END
        ');
    }

    public function down()
    {
        DB::unprepared('DROP TRIGGER IF EXISTS TG_sales_order');
        DB::unprepared('DROP TRIGGER IF EXISTS TG_purchase_order');
    }
};
