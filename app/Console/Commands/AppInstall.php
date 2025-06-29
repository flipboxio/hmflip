<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Artisan;


class AppInstall extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:install {--seed=all} {--migrate=true} {--dummydata=true}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'App Install with Database Migration and Seed Command';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        if ($this->option('migrate')) {
            $this->call('migrate:fresh');
            $this->info('Database migrated successfully.');
        }

        $this->mainAppSeed();
        $this->moduleSeed();

        $this->info('Database seeding completed successfully.');

        $this->call('optimize:clear');
    }

    /*
    * Main App Seed
    *
    * @return void
    */
    protected function mainAppSeed()
    {
        if ($this->option('dummydata') == 'false') {
            $this->call('db:seed', ['--class' => 'Database\\Seeders\\RequiredDatabaseSeeder']);
        }

        if ($this->option('dummydata') == 'true') {
            $this->call('db:seed');
        }
    }

    /*
    * Module Seed
    *
    * @return void
    */
    protected function moduleSeed()
    {
        $this->warn('Module Seeding: ');

        foreach ($this->modulesName() as $module) {

            $moduleSeederClass = 'Modules\\' . $module . '\\Database\\Seeders\\' . $module . 'DatabaseWithoutDummyDataSeeder';

            if (class_exists($moduleSeederClass)) {
                Artisan::call('db:seed', ['--class' => $moduleSeederClass]);
            } else {
                Artisan::call('module:seed ' . $module);
            }

            $this->line('   ✔ ' . $module);
        }

        $this->info('Module seeding completed successfully.');
    }

    /*
    * Modules Name
    *
    * @return array
    */
    protected function modulesName()
    {
        if ($this->option('seed') != 'all') {
            return explode(',', $this->option('seed'));
        }

        $moduels = [];

        foreach (\Nwidart\Modules\Facades\Module::getOrdered() as $module) {
            array_push($moduels, $module->getName());
        }

        return $moduels;
    }
}
