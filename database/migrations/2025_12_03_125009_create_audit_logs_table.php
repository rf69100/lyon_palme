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
        Schema::create('audit_logs', function (Blueprint $table) {
            $table->id();

            // User who performed the action
            $table->foreignId('utilisateur_id')->nullable()->constrained('utilisateurs')->nullOnDelete();

            // Action details
            $table->string('action'); // create, update, delete, login, logout, export, etc.
            $table->string('resource_type'); // User, Adherent, Adhesion, etc.
            $table->unsignedBigInteger('resource_id')->nullable();

            // Request details
            $table->string('method', 10); // GET, POST, PUT, DELETE, etc.
            $table->string('path', 255);
            $table->ipAddress('ip_address');
            $table->text('user_agent')->nullable();

            // Changes recorded
            $table->json('old_values')->nullable(); // Previous values for updates
            $table->json('new_values')->nullable(); // New values

            // Status
            $table->boolean('success')->default(true);
            $table->text('error_message')->nullable();

            // Timestamp
            $table->timestamp('created_at')->useCurrent();

            // Indexes for performance
            $table->index('utilisateur_id');
            $table->index('action');
            $table->index('resource_type');
            $table->index('created_at');
            $table->index(['utilisateur_id', 'created_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('audit_logs');
    }
};
