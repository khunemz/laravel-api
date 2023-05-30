
```bash
# create model with related 
php artisan make Customer --all
```

```bash
php artisan migrate:fresh --seed
```

```bash
php artisan make:resource V1\CustomerResource
```
#### Class not found
```bash
composer dump-autoload -o
```


```bash
php artisan make:request StoreCustomerRequest
```

```bash
# clear cache route
php artisan route:clear
```

```bash
# Sanctum
php artisan vendor:publish --provider="Laravel\Sanctum\SanctumServiceProvider"
php artisan migrate
```
