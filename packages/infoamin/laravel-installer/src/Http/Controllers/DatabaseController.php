<?php

namespace Infoamin\Installer\Http\Controllers;

use AppController, Artisan, Exception, DB;
use Infoamin\Installer\Repositories\EnvironmentRepository;
use Illuminate\Http\Request;

class DatabaseController extends AppController
{
    /**
     * Show form.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $host     = env('DB_HOST');
		$port     = env('DB_PORT');
        $database = env('DB_DATABASE');
        $username = env('DB_USERNAME');
        $password = env('DB_PASSWORD');

        return view('vendor.installer.database', compact('host', 'port', 'database', 'username', 'password'));
    }

    /**
     * Manage form submission.
     *
     * @param  Illuminate\Http\Request                               $request
     * @param  Infoamin\Installer\Repositories\EnvironmentRepository $environmentRepository
     * @return redirection
     */
    public function store(Request $request, EnvironmentRepository $environmentRepository)
    {
        // Set config for migrations and seeds
        $connection = config('database.default');
        config([
            'database.connections.' . $connection . '.host'     => $request->host,
			'database.connections.' . $connection . '.port'     => $request->port,
            'database.connections.' . $connection . '.database' => $request->dbname,
            'database.connections.' . $connection . '.password' => $request->password,
            'database.connections.' . $connection . '.username' => $request->username,
        ]);

        // Update .env file
        $environmentRepository->SetDatabaseSetting($request);
        $seedType = "dummy-data-off";

        if (isset($request->seedtype) && $request->seedtype == "on") {
            $seedType = "dummy-data-on";
        }

        return redirect('install/seedmigrate/' . $seedType);
    }

    public function seedMigrate($type)
    {
        // Migrations and seeds
        try {
            ini_set('max_execution_time', 300);
            DB::statement('SET FOREIGN_KEY_CHECKS=0;');

            if ($type == 'dummy-data-on') {

                Artisan::call('app:install --seed=all --migrate=true --dummydata=true');

            } else {

                Artisan::call('app:install --seed=all --migrate=true --dummydata=false');
            }
			
            
            DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        }
        catch (Exception $e)
        {
            dd($e->getMessage());
            return view('vendor.installer.database-error', ['error' => $e->getMessage()]);
        }

        if (config('installer.administrator'))
        {
            return redirect('install/register');
        }

        return redirect('install/finish');
    }

}
