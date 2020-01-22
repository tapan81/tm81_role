<?php
namespace tapanmandal81\tm81_role\Database\seeds;
use Illuminate\Database\Seeder;
use tapanmandal81\tm81_role\Models\Permission;
use Carbon\Carbon;

class PermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $keys = [
            'browse_admin',
			'browse_dashboard',
        ];

        foreach ($keys as $key) {
            Permission::firstOrCreate([
                'key'        => $key,
                'table_name' => null,
            ]);
        }


        Permission::generateFor('roles');
        Permission::generateFor('users');

    }
}
