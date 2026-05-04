<?php

use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('job_posts', function (Blueprint $table) {
            $table->id();

            $table->foreignIdFor(User::class)
                ->constrained()
                ->cascadeOnDelete();

            $table->string('title');
            $table->string('slug')->unique();

            $table->string('company_name');
            $table->string('location')->nullable();

            $table->enum('workplace_type', [
                'remote',
                'on_site',
                'hybrid',
            ])->default('remote');

            $table->enum('job_type', [
                'full_time',
                'part_time',
                'contract',
            ])->default('full_time');

            $table->string('salary_currency', 10)->default('USD');
            $table->decimal('salary_min', 12, 2)->nullable();
            $table->decimal('salary_max', 12, 2)->nullable();

            $table->text('skills_required')->nullable();
            $table->longText('description');

            $table->enum('status', [
                'draft',
                'published',
                'closed',
            ])->default('draft');

            $table->date('application_deadline')->nullable();
            $table->timestamp('published_at')->nullable();

            $table->timestamps();
            $table->softDeletes();

            $table->index(['status', 'workplace_type', 'job_type']);
            $table->index('location');
            $table->index('application_deadline');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('job_posts');
    }
};