<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
       // $this->call(UsersTableSeeder::class);
        //  $this->call(AdminTableSeeder::class);
        //  $this->call(SectionTableSeeder::class);
        //  $this->call(CategoryTableSeeder::class);
        //  $this->call(ProductTableSeeder::class);
        //  $this->call(ProductTableSeeder::class);
        //  $this->call(ProductImageTableSeeder::class);
        //  $this->call(BrandTableSeeder::class);
        //  $this->call(BannerTableSeeder::class);
        //  $this->call(ProductFilterTableSeeder::class);
        //  $this->call(CouponTableSeeder::class);
        //  $this->call(DeliveryAddressTableSeeder::class);
        //  $this->call(OrderStatusTableSeeder::class);
         $this->call(SiteSettingsTableSeeder::class);
    }
}
