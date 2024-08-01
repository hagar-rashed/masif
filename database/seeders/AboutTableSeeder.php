<?php

namespace Database\Seeders;

use App\Models\About;
use Illuminate\Database\Seeder;

class AboutTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        About::insert([
            [
                'type'    => 'life',
                'desc_ar' => 'وُلد في مدينة الرياض عام 1352هـ/1933م ونشأ فيها',
                'desc_en' => 'He was born in the city of Riyadh in 1352 AH / 1933 AD and grew up there',
            ],
            [
                'type'    => 'life',
                'desc_ar' => 'تلقى تعليمه العام في مدينة الرياض',
                'desc_en' => 'He received his general education in the city of Riyadh',
            ],
            [
                'type'    => 'life',
                'desc_ar' => 'تحصل على الشهادة الجامعية من كلية اللغة العربية في الرياض عام 1377هـ/1957م، وكان ضمن أول دفعة تخرجت في الكلية',
                'desc_en' => 'He obtained a university degree from the College of Arabic Language in Riyadh in 1377 AH / 1957 AD, and was among the first class to graduate from the college.',
            ],
            [
                'type'    => 'life',
                'desc_ar' => 'حصل على دبلوم الدراسات الأدبية واللغوية من معهد الدراسات العليا التابع لجامعة الدول العربية عام 1380هـ/1960م',
                'desc_en' => 'He obtained a diploma in literary and linguistic studies from the Institute of Postgraduate Studies of the League of Arab States in 1380 AH / 1960 AD.',
            ],
            [
                'type'    => 'life',
                'desc_ar' => 'عمل مديرًا لأعمال لجنة الأنظمة بالأمانة العامة لمجلس الوزراء',
                'desc_en' => 'Worked as Director of the Regulations Committee at the General Secretariat of the Council of Ministers',
            ],
            [
                'type'    => 'life',
                'desc_ar' => 'عمل مديرًا إقليميًا لمكتب العمل الرئيس بالمنطقة الشرقية التابع لوزارة العمل والشؤون الاجتماعية',
                'desc_en' => 'He worked as a regional director for the main labor office in the eastern region of the Ministry of Labor and Social Affairs',
            ],
            [
                'type'    => 'life',
                'desc_ar' => 'عمل بالإعارة في الشركة الوطنية السعودية للكهرباء بالرياض',
                'desc_en' => 'He worked on secondment at the Saudi National Electricity Company in Riyadh',
            ],
            [
                'type'    => 'life',
                'desc_ar' => 'عمل بالإعارة في مؤسسة اليمامة الصحفية رئيسًا لتحرير صحيفة الرياض اليوم عام 1385هـ/1965م',
                'desc_en' => 'He worked on secondment at Al-Yamamah Press Foundation as editor-in-chief of Al-Riyadh Al-Youm newspaper in 1385 AH / 1965 AD.',
            ],
            [
                'type'    => 'life',
                'desc_ar' => 'عُين مديرًا عامًا لمصلحة المياه والصرف الصحي بمنطقة الرياض بين عامي 1397-1412هـ/1977-1992م وظل في هذه الوظيفة حتى تقاعده',
                'desc_en' => 'He was appointed Director General of the Water and Sanitation Authority in Riyadh between the years 1397-1412 AH / 1977-1992 AD, and he remained in this position until his retirement.',
            ],
            [
                'type'    => 'life',
                'desc_ar' => 'تم اختياره عضوًا في مجلس الشورى في دورتيه الأولى والثانية',
                'desc_en' => 'He was selected as a member of the Shura Council in its first and second sessions',
            ],
            [
                'type'    => 'activity',
                'desc_ar' => 'كاتب في الصحافة السعودية منذ عام 1371هـ/1951م',
                'desc_en' => 'Writer in the Saudi press since 1371 AH / 1951 AD',
            ],
            [
                'type'    => 'activity',
                'desc_ar' => 'عضو مؤسس لمؤسسة اليمامة الصحفية التي تصدر صحيفة الرياض اليومية، ومجلة اليمامة الأسبوعية',
                'desc_en' => 'A founding member of Al-Yamamah Press Foundation, which publishes the daily Al-Riyadh newspaper, and Al-Yamamah weekly magazine',
            ],
            [
                'type'    => 'activity',
                'desc_ar' => 'هو أحد مؤسسي نادي الرياض الأدبي عام 1395هـ/1975م',
                'desc_en' => 'He is one of the founders of the Riyadh Literary Club in 1395 AH / 1975 AD',
            ],
            [
                'type'    => 'activity',
                'desc_ar' => 'عمل مع حمد الجاسر في تحرير صحيفة اليمامة في مرحلة صحافة الأفراد في السعودية، كما كان ينوب عن الجاسر في التحرير أحيانًا',
                'desc_en' => 'He worked with Hamad Al-Jasser in editing Al-Yamamah newspaper during the period of individual journalism in Saudi Arabia, and he was also acting on behalf of Al-Jasser in editing sometimes.',
            ],
            [
                'type'    => 'activity',
                'desc_ar' => 'عضو في مجلس أمناء مؤسسة حمد الجاسر الخيرية',
                'desc_en' => 'Member of the Board of Trustees of the Hamad Al-Jasser Charitable Foundation',
            ],
            [
                'type'    => 'activity',
                'desc_ar' => 'عضو سابق في الهيئة العليا لتطوير مدينة الرياض',
                'desc_en' => 'Former member of the High Commission for the Development of Riyadh',
            ],
            [
                'type'    => 'activity',
                'desc_ar' => 'عضو سابق في لجنة تصنيف المقاولين',
                'desc_en' => 'Former member of the Contractors Classification Committee',
            ],
            [
                'type'    => 'activity',
                'desc_ar' => 'عضو سابق في لجنة تسمية شوارع الرياض',
                'desc_en' => 'Former member of the Riyadh Streets Naming Committee',
            ],
        ]);
    }
}
