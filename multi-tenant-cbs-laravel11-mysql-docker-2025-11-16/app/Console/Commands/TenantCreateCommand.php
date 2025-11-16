<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use App\Models\Tenant;

class TenantCreateCommand extends Command
{
    protected $signature = 'tenant:create {code}';
    protected $description = 'Create tenant database and register tenant';

    public function handle()
    {
        $code = $this->argument('code');
        $dbName = 'tenant_' . $code;

        // Create database on tenant-db (use control DB's privileges; in Docker we will use tenant-db root)
        $host = env('TENANT_DB_HOST', 'tenant-db');
        $user = env('TENANT_DB_USERNAME', 'root');
        $pass = env('TENANT_DB_PASSWORD', 'root');

        $pdo = new \PDO("mysql:host={$host};port=".env('TENANT_DB_PORT',3306), $user, $pass);
        $pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        $pdo->exec("CREATE DATABASE IF NOT EXISTS `{$dbName}` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");

        Tenant::create(['code' => $code, 'db_name' => $dbName]);

        $this->info("Tenant created: {$code} (DB: {$dbName})");
    }
}
