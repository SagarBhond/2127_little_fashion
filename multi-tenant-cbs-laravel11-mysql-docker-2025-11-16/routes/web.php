<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return 'Public Landing - no tenant';
});

Route::middleware('tenant')->get('/dashboard', function () {
    $tenant = request()->attributes->get('tenant');
    return "Tenant: " . $tenant->code;
});
