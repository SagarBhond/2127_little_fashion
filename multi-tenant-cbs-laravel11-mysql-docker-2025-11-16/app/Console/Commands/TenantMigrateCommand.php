<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Tenant;
use Illuminate\Support\Facades\Artisan;

class TenantMigrateCommand extends Command
{
    protected $signature = 'tenant:migrate {code}';
    protected $description = 'Run tenant-specific migrations';

    public function handle()
    {
        $code = $this->argument('code');
        $tenant = Tenant::where('code', $code)->first();
        if (! $tenant) {
            $this->error('Tenant not found');
            return 1;
        }

        config(['database.connections.tenant.database' => $tenant->db_name]);

        Artisan::call('migrate', [
            '--path' => 'database/tenants',
            '--database' => 'tenant',
            '--force' => true
        ]);

        $this->info("Tenant migrations run for: {$code}");
        return 0;
    }
}
