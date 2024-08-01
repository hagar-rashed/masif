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
        // \App\Models\User::factory(10)->create();
        $this->call(UserTableSeeder::class);
        $this->call(SettingTableSeeder::class);
        $this->call(ResearchTableSeeder::class);
        $this->call(CategorySeeder::class);
        $this->call(ArticleTableSeeder::class);
        $this->call(ServiceTableSeeder::class);
        $this->call(JobVacancySeeder::class);
        $this->call(SectorSeeder::class);
        $this->call(ValueSeeder::class);
        $this->call(SolutionSeeder::class);
        $this->call(BrandSeeder::class);
        $this->call(VideoTableSeeder::class);
        $this->call(BookTableSeeder::class);
        $this->call(ContactTableSeeder::class);
        $this->call(AboutTableSeeder::class);
    }
}
