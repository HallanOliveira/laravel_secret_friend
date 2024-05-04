<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\User;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('secret_friend_groups', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(User::class, 'owner_id');
            $table->string('name', 120);
            $table->string('reveal_location', 120);
            $table->timestamp('reveal_date');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('secret_friend_groups');
    }
};
