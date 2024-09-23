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

return new class extends Migration
{
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
            $table->date('initial_date');
            $table->date('end_date');
            $table->string('name_space_held');
            $table->string('locality');
            $table->enum('municipality', MunicipalityEnum::toArray());
            $table->integer('total');
            $table->integer('women_total');
            $table->integer('men_total');
            $table->integer('children_girls');
            $table->integer('children_boys');
            $table->integer('youth_women');
            $table->integer('youth_men');
            $table->integer('adult_women');
            $table->integer('adult_men');
            $table->integer('senior_women');
            $table->integer('senior_men');
            $table->integer('social_women')->nullable();
            $table->integer('social_childrens')->nullable();
            $table->integer('social_seniors')->nullable();
            $table->integer('social_indigenous')->nullable();
            $table->integer('social_disabled')->nullable();
            $table->integer('social_migrants')->nullable();
            $table->integer('social_afrodescendants')->nullable();
            $table->integer('social_incarcerated')->nullable();
            $table->integer('social_lgbtttiq')->nullable();
            $table->foreignIdFor(FinnancingSource::class)->nullable();
            $table->foreignIdFor(Area::class);
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
