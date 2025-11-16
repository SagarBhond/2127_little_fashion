<?php

namespace App\Http\Middleware;

use App\Models\Tenant;
use Closure;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;

class TenantResolver
{
    public function handle($request, Closure $next)
    {
        $host = $request->getHost();
        $parts = explode('.', $host);
        $subdomain = $parts[0] ?? null;

        if (! $subdomain) {
            abort(400, 'Invalid host');
        }

        $tenant = Tenant::where('code', $subdomain)->first();
        if (! $tenant) {
            abort(403, 'Tenant not found');
        }

        // Set tenant DB dynamically
        Config::set('database.connections.tenant.database', $tenant->db_name);
        DB::setDefaultConnection('tenant');

        // attach tenant to request
        $request->attributes->set('tenant', $tenant);

        return $next($request);
    }
}
