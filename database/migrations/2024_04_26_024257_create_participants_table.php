<?php

use App\Models\User;
use App\Models\SecretFriendGroup;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('participants', function (Blueprint $table) {
            $table->id();
            $table->string('name', 150);
            $table->string('phone', 14);
            $table->string('email', 150);
            $table->string('suggestion', 250);
            $table->integer('secret_friend_id');
            $table->foreignIdFor(User::class, 'owner_id');
            $table->foreignIdFor(SecretFriendGroup::class, 'secret_friend_group_id');
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
        Schema::dropIfExists('participants');
    }
};
