<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DebugController extends Controller
{
    /**
     * Display system information for debugging.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $info = [
            'Laravel Version' => app()->version(),
            'PHP Version' => phpversion(),
            'Environment' => app()->environment(),
            'Debug Mode' => config('app.debug') ? 'On' : 'Off',
            'App Directory Structure' => $this->checkDirectoryStructure(),
            'Model Classes' => $this->checkModelClasses(),
            'View Paths' => $this->checkViewPaths(),
            'Routes' => $this->getRoutes(),
            'Database Configuration' => $this->checkDatabaseConfig(),
        ];
        
        return view('debug.info', ['info' => $info]);
    }
    
    /**
     * Check if important directories exist.
     *
     * @return array
     */
    private function checkDirectoryStructure()
    {
        $directories = [
            'app' => app_path(),
            'app/Http/Controllers' => app_path('Http/Controllers'),
            'app/Models' => app_path('Models'),
            'resources/views' => resource_path('views'),
            'resources/views/admin' => resource_path('views/admin'),
            'resources/views/layouts' => resource_path('views/layouts'),
            'public/css' => public_path('css'),
            'public/js' => public_path('js'),
        ];
        
        $results = [];
        foreach ($directories as $name => $path) {
            $results[$name] = [
                'path' => $path,
                'exists' => file_exists($path) && is_dir($path),
                'writable' => file_exists($path) && is_dir($path) && is_writable($path),
            ];
        }
        
        return $results;
    }
    
    /**
     * Check if the model classes exist.
     *
     * @return array
     */
    private function checkModelClasses()
    {
        $models = [
            'App\Models\Patient',
            'App\Models\Appointment',
            'App\Models\Payment',
            'App\Models\Treatment',
            'App\Models\Prescription',
            'App\Models\InventoryItem',
        ];
        
        $results = [];
        foreach ($models as $model) {
            $results[$model] = class_exists($model);
        }
        
        return $results;
    }
    
    /**
     * Check if important view paths exist.
     *
     * @return array
     */
    private function checkViewPaths()
    {
        $views = [
            'layouts/admin' => resource_path('views/layouts/admin.blade.php'),
            'admin/dashboard' => resource_path('views/admin/dashboard.blade.php'),
            'debug/info' => resource_path('views/debug/info.blade.php'),
        ];
        
        $results = [];
        foreach ($views as $name => $path) {
            $results[$name] = [
                'path' => $path,
                'exists' => file_exists($path),
            ];
        }
        
        return $results;
    }
    
    /**
     * Get a list of registered routes.
     *
     * @return array
     */
    private function getRoutes()
    {
        $routes = app('router')->getRoutes();
        $routeList = [];
        
        foreach ($routes as $route) {
            $routeList[] = [
                'method' => implode('|', $route->methods()),
                'uri' => $route->uri(),
                'name' => $route->getName(),
                'action' => $route->getActionName(),
            ];
        }
        
        return $routeList;
    }
    
    /**
     * Check database configuration.
     *
     * @return array
     */
    private function checkDatabaseConfig()
    {
        $connection = config('database.default');
        $config = config('database.connections.' . $connection);
        
        // Remove sensitive info
        if (isset($config['password'])) {
            $config['password'] = '********';
        }
        
        return [
            'connection' => $connection,
            'config' => $config,
            'tables' => $this->getDatabaseTables(),
        ];
    }
    
    /**
     * Get a list of tables in the database.
     *
     * @return array
     */
    private function getDatabaseTables()
    {
        try {
            $tables = [];
            $results = \DB::select('SHOW TABLES');
            
            foreach ($results as $result) {
                $tables[] = array_values((array) $result)[0];
            }
            
            return $tables;
        } catch (\Exception $e) {
            return ['Error connecting to database: ' . $e->getMessage()];
        }
    }
}