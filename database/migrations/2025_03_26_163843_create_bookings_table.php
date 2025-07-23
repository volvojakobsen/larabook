<?php

use App\Models\User;
use App\Models\Venue;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(User::class);
            $table->foreignIdFor(Venue::class);
            $table->date('dateFrom');
            $table->date('dateTo');
            $table->string('products');
            $table->integer('totalPrice');
            $table->timestamps();
            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
