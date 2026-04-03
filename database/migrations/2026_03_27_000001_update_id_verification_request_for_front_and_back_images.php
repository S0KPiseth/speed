<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (! Schema::hasTable('id_verification_request')) {
            return;
        }

        Schema::table('id_verification_request', function (Blueprint $table) {
            if (Schema::hasColumn('id_verification_request', 'id_url')) {
                $table->string('id_url')->nullable()->change();
            }

            if (! Schema::hasColumn('id_verification_request', 'id_front_url')) {
                $table->string('id_front_url')->nullable()->after('id_url');
            }

            if (! Schema::hasColumn('id_verification_request', 'id_back_url')) {
                $table->string('id_back_url')->nullable()->after('id_front_url');
            }

            if (! Schema::hasColumn('id_verification_request', 'id_front_file_id')) {
                $table->string('id_front_file_id')->nullable()->after('id_back_url');
            }

            if (! Schema::hasColumn('id_verification_request', 'id_back_file_id')) {
                $table->string('id_back_file_id')->nullable()->after('id_front_file_id');
            }
        });

        Schema::table('id_verification_request', function (Blueprint $table) {
            if (Schema::hasColumn('id_verification_request', 'admin_id')) {
                $table->dropForeign(['admin_id']);
                $table->unsignedBigInteger('admin_id')->nullable()->change();
                $table->foreign('admin_id')->references('id')->on('users')->nullOnDelete();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (! Schema::hasTable('id_verification_request')) {
            return;
        }

        Schema::table('id_verification_request', function (Blueprint $table) {
            if (Schema::hasColumn('id_verification_request', 'id_front_file_id')) {
                $table->dropColumn('id_front_file_id');
            }

            if (Schema::hasColumn('id_verification_request', 'id_back_file_id')) {
                $table->dropColumn('id_back_file_id');
            }

            if (Schema::hasColumn('id_verification_request', 'id_front_url')) {
                $table->dropColumn('id_front_url');
            }

            if (Schema::hasColumn('id_verification_request', 'id_back_url')) {
                $table->dropColumn('id_back_url');
            }
        });
    }
};
