<?php

namespace App\Providers;

use Faker\Generator as FakerGenerator;
use Faker\Factory as FakerFactory;
use DavidBadura\FakerMarkdownGenerator\FakerProvider;

use Illuminate\Support\ServiceProvider;

class FakerServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(FakerGenerator::class, function(){
            $faker = FakerFactory::create();
            $faker->addProvider(new FakerProvider($faker));
            return $faker;
        });
        if (! class_exists('Faker')) {
            class_alias(FakerGenerator::class, 'Faker');
        }
    }
}
