# Multi-Tenant CBS - Laravel 11 (MySQL) Starter (Docker included)

Created: 2025-11-16

This is a starter multi-tenant Laravel project (single codebase, per-tenant databases).
Defaults included:
- Laravel 11 (composer.json)
- MySQL for control DB + tenant DBs (docker-compose)
- TenantResolver middleware that switches DB connection at runtime
- Artisan commands to create tenant DB and run tenant migrations
- Dockerfile + docker-compose for local testing

How to run locally (Docker):
1. docker-compose up -d
2. docker-compose exec app bash
3. composer install
4. php artisan migrate
5. php artisan tenant:create bank1
6. php artisan tenant:migrate bank1
7. open http://localhost:8000 with Host header matching tenant (see README for host testing)

Note: This project is a starter template — review and secure before production.
