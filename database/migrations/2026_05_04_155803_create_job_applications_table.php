<?php

use App\Models\JobPost;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('job_applications', function (Blueprint $table) {
            $table->id();

            $table->foreignIdFor(JobPost::class)
                ->constrained()
                ->cascadeOnDelete();

            $table->foreignIdFor(User::class, 'applicant_id')
                ->constrained('users')
                ->cascadeOnDelete();

            $table->longText('cover_letter');
            $table->string('resume_path')->nullable();
            $table->string('expected_salary')->nullable();
            $table->date('availability_date')->nullable();
            $table->string('portfolio_url')->nullable();

            $table->enum('status', [
                'pending',
                'shortlisted',
                'selected',
                'rejected',
            ])->default('pending');

            $table->timestamp('reviewed_at')->nullable();
            $table->foreignIdFor(User::class, 'reviewed_by')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->timestamps();
            $table->softDeletes();

            $table->unique(['job_post_id', 'applicant_id']);

            $table->index('status');
            $table->index('availability_date');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('job_applications');
    }
};