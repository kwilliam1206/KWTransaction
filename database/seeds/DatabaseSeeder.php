<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(LanguageSeeder::class);
        $this->call(TranslatorLanguagesSeeder::class);
        $this->call(LocaleSeeder::class);
        $this->call(CurrencySeeder::class);
        $this->call(PhoneTypeSeeder::class);
        $this->call(ContactTypeSeeder::class);
        $this->call(TransactionTypeSeeder::class);
        $this->call(TransactionStatusSeeder::class);
        $this->call(ListingStatusSeeder::class);
        $this->call(UserStatusSeeder::class);
        $this->call(PermissionSeeder::class);
        $this->call(RoleSeeder::class);
        //$this->call(RegionSeeder::class);
        $this->call(RegionWWSeeder::class);
        $this->call(CountrySeeder::class);
        //$this->call(OfficeSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(StateSeeder::class);
        $this->call(CitySeeder::class);
        //$this->call(ContactSeeder::class);
        //$this->call(ListingSeeder::class);
        $this->call(LogTypeSeeder::class);
        $this->call(PaymentStatusSeeder::class);
        $this->call(TaskTypeSeeder::class);
        $this->call(FinancialAttributeSeeder::class);
    }
}
