1. To download, open commnad promt & paste "composer require tapanmandal81/tm81_role", then press enter.

2. Add Service provide tapanmandal81\tm81_role\RolePermissionServiceProvider::class, to config/app.php

3. Run "composer dump-autoload" command

4. Run "php artisan migrate" command

5. Run " php artisan db:seed --class=tapanmandal81\tm81_role\Database\seeds\PermissionsTableSeeder" command

6. Now check  "admin/roles" or "admin/users"

7. Create dashboard resource controller by command "php artisan make:controller DashboardController --resource"



Thanks