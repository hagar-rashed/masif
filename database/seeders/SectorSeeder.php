<?php

namespace Database\Seeders;

use App\Models\Sector;
use Illuminate\Database\Seeder;

class SectorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Sector::insert([
            [
                'name_ar' => 'قطاع الاستصلاح الزراعي',
                'name_en' => 'Agricultural reclamation sector',
                'desc_ar' => 'يسرنا أن نعلن عن شراكة جديدة بين SMARTTEL و LG Electronics. تعد LG Electronics مزودًا عالميًا للخدمة وتوفر خدمات IPTV واللافتات الرقمية في جميع أنحاء العالم.',
                'desc_en' => 'We are pleased to announce a new partnership between SMARTTEL and LG Electronics. LG Electronics is a global service provider providing IPTV and digital signage services worldwide.',
                'image'   => 'sectors/img_1.png',
                'link'    => 'https://google.com'
            ],
            [
                'name_ar' => 'لوحات كهربية',
                'name_en' => 'Electric panels',
                'desc_ar' => 'يسرنا أن نعلن عن شراكة جديدة بين SMARTTEL و LG Electronics. تعد LG Electronics مزودًا عالميًا للخدمة وتوفر خدمات IPTV واللافتات الرقمية في جميع أنحاء العالم.',
                'desc_en' => 'We are pleased to announce a new partnership between SMARTTEL and LG Electronics. LG Electronics is a global service provider providing IPTV and digital signage services worldwide.',
                'image'   => 'sectors/img_1.png',
                'link'    => 'https://google.com'
            ],
            [
                'name_ar' => 'تيار خفيف',
                'name_en' => 'Light Scream',
                'desc_ar' => 'يسرنا أن نعلن عن شراكة جديدة بين SMARTTEL و LG Electronics. تعد LG Electronics مزودًا عالميًا للخدمة وتوفر خدمات IPTV واللافتات الرقمية في جميع أنحاء العالم.',
                'desc_en' => 'We are pleased to announce a new partnership between SMARTTEL and LG Electronics. LG Electronics is a global service provider providing IPTV and digital signage services worldwide.',
                'image'   => 'sectors/img_1.png',
                'link'    => 'https://google.com'
            ],
        ]);
    }
}
