<?php

namespace Imageplus\AuthScaffolding\Console;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Str;

class InstallCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'imageplus:scaffold-auth';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Handles the installation process of the authentication scaffolding';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->handleFortify();

        $this->handleRoutes();

        $this->setupDatabaseSessions();

        $this->handleNodePackages();

        $this->handleLayout();
    }

    protected function handleFortify(){
        $this->callSilent('vendor:publish', ['--tag' => 'fortify-config', '--force' => true]);
        $this->callSilent('vendor:publish', ['--tag' => 'fortify-support', '--force' => true]);
        $this->callSilent('vendor:publish', ['--tag' => 'fortify-migrations', '--force' => true]);

        $this->callSilent('vendor:publish', ['--tag' => 'imageplus-auth-scaffolding-provider', '--force' => true]);

        $this->installServiceProvider('App\Providers\ImageplusAuthScaffoldingServiceProvider::class');
        $this->installServiceProvider('App\Providers\FortifyServiceProvider::class');
    }

    protected function handleRoutes(){
        $this->replaceInFile('/home', '/dashboard', app_path('Providers/RouteServiceProvider.php'));

        $contents = file_get_contents(base_path('/routes/web.php'));
        $route =
            "Route::get('/dashboard', function () {" . PHP_EOL .
            "    return \Inertia\Inertia::render('Dashboard');" . PHP_EOL .
            "})->middleware(['auth']);";

        if(!Str::contains($contents, $route)){
            file_put_contents(base_path('/routes/web.php'),
                $contents . PHP_EOL .
                "Route::get('/dashboard', function () {" . PHP_EOL .
                "    return \Inertia\Inertia::render('Dashboard');" . PHP_EOL .
                "})->middleware(['auth']);"
            );
        }
    }

    protected function setupDatabaseSessions(){
        //only create the session:table migration if it doesn't yet exist
        if (! class_exists('CreateSessionsTable')) {
            try {
                $this->call('session:table');
            } catch (\Throwable $t) {
                //do nothing
            }
        }

        //make sure the session driver is database
        $this->replaceInFile("'SESSION_DRIVER', 'file'", "'SESSION_DRIVER', 'database'", config_path('session.php'));
        $this->replaceInFile('SESSION_DRIVER=file', 'SESSION_DRIVER=database', base_path('.env'));
        $this->replaceInFile('SESSION_DRIVER=file', 'SESSION_DRIVER=database', base_path('.env.example'));
    }

    protected function handleLayout(){
        copy(__DIR__.'/../../stubs/webpack.mix.js', base_path('webpack.mix.js'));

        (new Filesystem)->ensureDirectoryExists(resource_path('views'));

        (new Filesystem)->ensureDirectoryExists(resource_path('sass'));
        (new Filesystem)->ensureDirectoryExists(resource_path('sass/auth'));

        (new Filesystem)->ensureDirectoryExists(resource_path('js/Modules'));

        (new Filesystem)->ensureDirectoryExists(resource_path('js/Partials'));
        (new Filesystem)->ensureDirectoryExists(resource_path('js/Partials/Auth'));

        (new Filesystem)->ensureDirectoryExists(resource_path('js/Pages'));
        (new Filesystem)->ensureDirectoryExists(resource_path('js/Pages/Auth'));

        //copy the inertia base layout
        copy(__DIR__.'/../../stubs/resources/views/app.blade.php', resource_path('views/app.blade.php'));

        //copy the stylesheets
        copy(__DIR__.'/../../stubs/resources/sass/app.scss', resource_path('sass/app.scss'));
        (new Filesystem)->copyDirectory(__DIR__.'/../../stubs/resources/sass/auth', resource_path('sass/auth'));

        //copy the modules
        (new Filesystem)->copyDirectory(__DIR__.'/../../stubs/resources/js/Modules', resource_path('js/Modules'));
        copy(__DIR__.'/../../stubs/resources/js/app.js', resource_path('js/app.js'));

        //copy the views
        copy(__DIR__.'/../../stubs/resources/js/Pages/Dashboard.vue', resource_path('js/Pages/Dashboard.vue'));
        (new Filesystem)->copyDirectory(__DIR__.'/../../stubs/resources/js/Pages/Auth', resource_path('js/Pages/Auth'));

        //Copy the partials
        (new Filesystem)->copyDirectory(__DIR__ . '/../../stubs/resources/js/Partials/Auth', resource_path('js/Partials/Auth'));
    }

    /**
     * Install the Fortify service providers in the application configuration file.
     *
     * @return void
     */
    protected function installServiceProvider($class)
    {
        if (! Str::contains($appConfig = file_get_contents(config_path('app.php')), $class)) {
            file_put_contents(config_path('app.php'), str_replace(
                "App\\Providers\RouteServiceProvider::class,",
                "App\\Providers\RouteServiceProvider::class,".PHP_EOL."        $class,",
                $appConfig
            ));
        }
    }

    /**
     * Adds the packages into package.json
     */
    protected function handleNodePackages(){
        $this->updateNodePackages(function ($packages) {
            return [
                    '@inertiajs/inertia' => '^0.1.7',
                    '@inertiajs/inertia-vue' => '^0.1.2',
                    'vue' => '^2.5.17',
                    'vue-template-compiler' => '^2.6.10',
                    'nprogress' => '^0.2.0',
                    'bootstrap' => '^4.5.2',
                    'sass' => '^1.26.11',
                    'sass-loader' => '^10.0.2'
                ] + $packages;
        });
    }

    /**
     * Update the "package.json" file.
     *
     * @param  callable  $callback
     * @param  bool  $dev
     * @return void
     */
    protected static function updateNodePackages(callable $callback, $dev = true)
    {
        //if the package json file doesn't exist node modules cannot be installed
        if (!file_exists(base_path('package.json'))) {
            return;
        }

        $configurationKey = $dev ? 'devDependencies' : 'dependencies';

        $packages = json_decode(
            file_get_contents(base_path('package.json')
        ), true);

        $packages[$configurationKey] = $callback(
            array_key_exists($configurationKey, $packages) ? $packages[$configurationKey] : [],
            $configurationKey
        );

        ksort($packages[$configurationKey]);

        file_put_contents(
            base_path('package.json'),
            json_encode($packages, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT).PHP_EOL
        );
    }

    /**
     * Replace a given string within a given file.
     *
     * @param  string  $search
     * @param  string  $replace
     * @param  string  $path
     * @return void
     */
    protected function replaceInFile($search, $replace, $path)
    {
        file_put_contents($path, str_replace($search, $replace, file_get_contents($path)));
    }
}
