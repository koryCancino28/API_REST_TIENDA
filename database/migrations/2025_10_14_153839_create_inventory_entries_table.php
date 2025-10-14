<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('inventory_entries', function (Blueprint $t) {
            $t->id();
            $t->foreignId('product_id')->constrained('products')->cascadeOnDelete();
            $t->enum('type', ['IN', 'OUT']);
            $t->integer('quantity');
            $t->string('reason')->nullable();
            $t->text('note')->nullable();

            // Auditoría
            $t->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $t->foreignId('updated_by')->nullable()->constrained('users')->nullOnDelete();
            $t->foreignId('deleted_by')->nullable()->constrained('users')->nullOnDelete();
            $t->ipAddress('created_ip')->nullable();
            $t->ipAddress('updated_ip')->nullable();
            $t->ipAddress('deleted_ip')->nullable();

            $t->softDeletes();
            $t->timestamps();

            $t->index(['product_id', 'type']);
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('inventory_entries');
    }
};
