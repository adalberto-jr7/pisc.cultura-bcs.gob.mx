<?php

use App\Enums\MonthsEnum;
use App\Enums\MunicipalityEnum;
use App\Models\ActivityType;
use App\Models\Area;
use App\Models\Category;
use App\Models\Discipline;
use App\Models\FinnancingSource;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('activities', function (Blueprint $table) {
            $table->id();
            $table->string('activity_name');
            $table->foreignIdFor(Category::class);
            $table->text('activity_goal');
            $table->text('description');
            $table->foreignIdFor(ActivityType::class);
            $table->foreignIdFor(Discipline::class);
            $table->string('author_name');
            $table->date('initial_date')->nullable();
            $table->date('end_date')->nullable();
            $table->string('name_space_held');
            $table->string('locality');
            $table->enum('municipality', MunicipalityEnum::toArray());
            $table->integer('total');
            $table->integer('women_total')->default(0)->nullable();
            $table->integer('men_total')->default(0)->nullable();
            $table->integer('children_girls')->default(0)->nullable();
            $table->integer('children_boys')->default(0)->nullable();
            $table->integer('youth_women')->default(0)->nullable();
            $table->integer('youth_men')->default(0)->nullable();
            $table->integer('adult_women')->default(0)->nullable();
            $table->integer('adult_men')->default(0)->nullable();
            $table->integer('senior_women')->default(0)->nullable();
            $table->integer('senior_men')->default(0)->nullable();
            $table->integer('social_women')->default(0)->nullable();
            $table->integer('social_childrens')->default(0)->nullable();
            $table->integer('social_seniors')->default(0)->nullable();
            $table->integer('social_indigenous')->default(0)->nullable();
            $table->integer('social_disabled')->default(0)->nullable();
            $table->integer('social_migrants')->default(0)->nullable();
            $table->integer('social_afrodescendants')->default(0)->nullable();
            $table->integer('social_incarcerated')->default(0)->nullable();
            $table->integer('social_lgbtttiq')->default(0)->nullable();
            $table->foreignIdFor(FinnancingSource::class)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('activities');
    }
};
