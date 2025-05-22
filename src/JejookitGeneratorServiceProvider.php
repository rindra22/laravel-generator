<?php

namespace Jejookit\Generator;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Jejookit\Generator\Commands\API\APIControllerGeneratorCommand;
use Jejookit\Generator\Commands\API\APIGeneratorCommand;
use Jejookit\Generator\Commands\API\APIRequestsGeneratorCommand;
use Jejookit\Generator\Commands\API\TestsGeneratorCommand;
use Jejookit\Generator\Commands\APIScaffoldGeneratorCommand;
use Jejookit\Generator\Commands\Common\MigrationGeneratorCommand;
use Jejookit\Generator\Commands\Common\ModelGeneratorCommand;
use Jejookit\Generator\Commands\Common\RepositoryGeneratorCommand;
use Jejookit\Generator\Commands\Publish\GeneratorPublishCommand;
use Jejookit\Generator\Commands\Publish\PublishTablesCommand;
use Jejookit\Generator\Commands\Publish\PublishUserCommand;
use Jejookit\Generator\Commands\RollbackGeneratorCommand;
use Jejookit\Generator\Commands\Scaffold\ControllerGeneratorCommand;
use Jejookit\Generator\Commands\Scaffold\RequestsGeneratorCommand;
use Jejookit\Generator\Commands\Scaffold\ScaffoldGeneratorCommand;
use Jejookit\Generator\Commands\Scaffold\ViewsGeneratorCommand;
use Jejookit\Generator\Common\FileSystem;
use Jejookit\Generator\Common\GeneratorConfig;
use Jejookit\Generator\Generators\API\APIControllerGenerator;
use Jejookit\Generator\Generators\API\APIRequestGenerator;
use Jejookit\Generator\Generators\API\APIRoutesGenerator;
use Jejookit\Generator\Generators\API\APITestGenerator;
use Jejookit\Generator\Generators\FactoryGenerator;
use Jejookit\Generator\Generators\MigrationGenerator;
use Jejookit\Generator\Generators\ModelGenerator;
use Jejookit\Generator\Generators\RepositoryGenerator;
use Jejookit\Generator\Generators\RepositoryTestGenerator;
use Jejookit\Generator\Generators\Scaffold\ControllerGenerator;
use Jejookit\Generator\Generators\Scaffold\MenuGenerator;
use Jejookit\Generator\Generators\Scaffold\RequestGenerator;
use Jejookit\Generator\Generators\Scaffold\RoutesGenerator;
use Jejookit\Generator\Generators\Scaffold\ViewGenerator;
use Jejookit\Generator\Generators\SeederGenerator;

class JejookitGeneratorServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $configPath = __DIR__ . '/../config/laravel_generator.php';
            $this->publishes([
                $configPath => config_path('laravel_generator.php'),
            ], 'laravel-generator-config');

            $this->publishes([
                __DIR__ . '/../views' => resource_path('views/vendor/laravel-generator'),
            ], 'laravel-generator-templates');
        }

        $this->registerCommands();
        $this->loadViewsFrom(__DIR__ . '/../views', 'laravel-generator');

        View::composer('*', function ($view) {
            $view->with(['config' => app(GeneratorConfig::class)]);
        });

        Blade::directive('tab', function () {
            return '<?php echo infy_tab() ?>';
        });

        Blade::directive('tabs', function ($count) {
            return "<?php echo infy_tabs($count) ?>";
        });

        Blade::directive('nl', function () {
            return '<?php echo infy_nl() ?>';
        });

        Blade::directive('nls', function ($count) {
            return "<?php echo infy_nls($count) ?>";
        });
    }

    private function registerCommands()
    {
        if (!$this->app->runningInConsole()) {
            return;
        }

        $this->commands([
            APIScaffoldGeneratorCommand::class,

            APIGeneratorCommand::class,
            APIControllerGeneratorCommand::class,
            APIRequestsGeneratorCommand::class,
            TestsGeneratorCommand::class,

            MigrationGeneratorCommand::class,
            ModelGeneratorCommand::class,
            RepositoryGeneratorCommand::class,

            GeneratorPublishCommand::class,
            PublishTablesCommand::class,
            PublishUserCommand::class,

            ControllerGeneratorCommand::class,
            RequestsGeneratorCommand::class,
            ScaffoldGeneratorCommand::class,
            ViewsGeneratorCommand::class,

            RollbackGeneratorCommand::class,
        ]);
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/laravel_generator.php', 'laravel_generator');

        $this->app->singleton(GeneratorConfig::class, function () {
            return new GeneratorConfig();
        });

        $this->app->singleton(FileSystem::class, function () {
            return new FileSystem();
        });

        $this->app->singleton(MigrationGenerator::class);
        $this->app->singleton(ModelGenerator::class);
        $this->app->singleton(RepositoryGenerator::class);

        $this->app->singleton(APIRequestGenerator::class);
        $this->app->singleton(APIControllerGenerator::class);
        $this->app->singleton(APIRoutesGenerator::class);

        $this->app->singleton(RequestGenerator::class);
        $this->app->singleton(ControllerGenerator::class);
        $this->app->singleton(ViewGenerator::class);
        $this->app->singleton(RoutesGenerator::class);
        $this->app->singleton(MenuGenerator::class);

        $this->app->singleton(RepositoryTestGenerator::class);
        $this->app->singleton(APITestGenerator::class);

        $this->app->singleton(FactoryGenerator::class);
        $this->app->singleton(SeederGenerator::class);
    }
}
