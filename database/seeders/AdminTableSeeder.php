<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;

class AdminTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('admins')->delete();
        $adminRecords=[
            ['id'=>1,
            'name'=>'admin',
            'type'=>'admin',
            'mobile'=>'1000000000',
            'email'=>'admin@admin.com',
            'password'=>'$2y$10$gSZzaK3nanYoxK.3ZFxcpuDZzg9bIcfpEfpyKskeBvfyO5wCE026W',
            'image'=>'',
            'status'=>1,],
            ['id'=>2,
            'name'=>'admin2',
            'type'=>'admin',
            'mobile'=>'3000000000',
            'email'=>'admin2@admin.com',
            'password'=>'$2y$10$gSZzaK3nanYoxK.3ZFxcpuDZzg9bIcfpEfpyKskeBvfyO5wCE026W',
            'image'=>'',
            'status'=>1,],
            ['id'=>3,
            'name'=>'admin3',
            'type'=>'admin',
            'mobile'=>'3000000000',
            'email'=>'admin3@admin.com',
            'password'=>'$2y$10$gSZzaK3nanYoxK.3ZFxcpuDZzg9bIcfpEfpyKskeBvfyO5wCE026W',
            'image'=>'',
            'status'=>1,],
        ];
        //DB::table('admins')->insert($adminRecords);
        foreach ($adminRecords as $key=>$record) {
            \App\Admin::create($record);
            
        }

    }
}
