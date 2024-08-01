<?php

namespace Database\Seeders;

use App\Models\JobVacancy;
use Illuminate\Database\Seeder;

class JobVacancySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        JobVacancy::insert([
            [
                'name_ar' => 'مدير إدارة المشاريع الهندسية',
                'name_en' => 'Engineering Projects Manager',
                'desc_ar' => 'توصيف الوظائف: مسؤول عن إدارة وتنفيذ المشاريع بنجاح. إدارة إنشاء وإغلاق جميع أوامر العمل وطلبات العملاء. الالتزام بضمان الانتهاء في الوقت المناسب من أقرأ المزيد',
                'desc_en' => 'Job Description: Responsible for successfully managing and implementing projects. Manage the creation and closing of all work orders and customer requests. Commitment to ensuring the timely completion of Read More',
            ],
        ]);
    }
}
