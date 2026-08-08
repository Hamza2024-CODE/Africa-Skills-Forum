<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('registrations', function (Blueprint $table) {
            if (!Schema::hasColumn('registrations', 'issued_at')) {
                $table->timestamp('issued_at')->nullable()->after('submitted_at');
            }
            if (!Schema::hasColumn('registrations', 'expires_at')) {
                $table->timestamp('expires_at')->nullable()->after('issued_at');
            }
            if (!Schema::hasColumn('registrations', 'revoked_at')) {
                $table->timestamp('revoked_at')->nullable()->after('expires_at');
            }
            if (!Schema::hasColumn('registrations', 'revoked_by')) {
                $table->foreignId('revoked_by')->nullable()->constrained('users')->nullOnDelete()->after('revoked_at');
            }
            if (!Schema::hasColumn('registrations', 'revocation_reason')) {
                $table->text('revocation_reason')->nullable()->after('revoked_by');
            }
        });

        Schema::create('audit_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('event')->index();
            $table->string('subject_type')->nullable();
            $table->unsignedBigInteger('subject_id')->nullable();
            $table->string('ip_address')->nullable();
            $table->text('user_agent')->nullable();
            $table->json('metadata')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('audit_logs');

        Schema::table('registrations', function (Blueprint $table) {
            $table->dropForeign(['revoked_by']);
            $table->dropColumn([
                'issued_at',
                'expires_at',
                'revoked_at',
                'revoked_by',
                'revocation_reason',
            ]);
        });
    }
};
