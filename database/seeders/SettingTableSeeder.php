<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Setting::insert([
            [
                'key'      => 'logo',
                'neckname' => 'الشعار',
                'type'     => 'file',
                'value'    => 'setting/logo.png',
            ],
            [
                'key'      => 'footer_logo',
                'neckname' => 'الشعار السفلى',
                'type'     => 'file',
                'value'    => 'setting/logo.png',
            ],
            [
                'key'      => 'favicon',
                'neckname' => 'ايقونة الموقع',
                'type'     => 'file',
                'value'    => 'setting/logo.png',
            ],
            [
                'key'      => 'main_video',
                'neckname' => 'فيديو الصفحة الرئيسية',
                'type'     => 'file',
                'value'    => 'setting/main_video.png',
            ],
            // [
            //     'key'      => 'about_image',
            //     'neckname' => 'صورة من نحن',
            //     'type'     => 'file',
            //     'value'    => 'setting/about_image.jpg',
            // ],
            // [
            //     'key'      => 'main_name_ar',
            //     'neckname' => 'الاسم بالصفحة الرئيسية بالعربية',
            //     'type'     => 'text',
            //     'value'    => 'د.عمران بن محمد العمران',
            // ],
            // [
            //     'key'      => 'main_name_en',
            //     'neckname' => 'الاسم بالصفحة الرئيسية بالانجليزية',
            //     'type'     => 'text',
            //     'value'    => 'Dr. Imran bin Mohammed Al-Omran',
            // ],
            [
                'key'      => 'about_ar',
                'neckname' => 'من نحن بالعربية',
                'type'     => 'textarea',
                'value'    => 'تأسست مجموعة Construction Cairo New في عام 2014 وتعمل في مجاالت التيار الخفيف ( شبكات البيانات وأنظمة الكابالت الهيكلية و وكاميرات المراقبة PBXs و IPTV وأنظمة إنذار الحريق وأنظمة اإلذاعه الداخلية وأنظمة التحكم في الدخول والخروج و RMS و BMS وأجهزة الكشف عن المعادن ) تسمح لنا قدراتنا ومهاراتنا بتصميم / استشارة وإدارة المشاريع. كما تتيح لنا عالقتنا الجيدة مع كبار الموردين الموردين بتوفير السعر و المنتجات لتحقيق النجاح للمشروع.. نحن نقدم خدماتنا للجهات الحكومية وشركات المقاوالت والمصانع والمباني اإلدارية ومراكز التسوق والفنادق ومحالت السوبر ماركت والمجتمعات والمباني السكنية.'
            ],
            [
                'key'      => 'about_en',
                'neckname' => 'من نحن بالانجليزية',
                'type'     => 'textarea',
                'value'    => 'Construction Cairo New Group was established in 2014 and operates in the fields of light current (data networks, structured cabling systems, surveillance cameras PBXs, IPTV, fire alarm systems, intercom broadcasting systems, entry and exit control systems, RMS, BMS, and metal detectors) Our capabilities and skills allow us to design / Consulting and project management. Also, our good relationship with major suppliers allows us to provide the price and products to achieve the success of the project.. We provide our services to government agencies, contracting companies, factories, administrative buildings, shopping centers, hotels, supermarkets, communities and residential buildings.'
            ],
            [
                'key'      => 'what_we_do_ar',
                'neckname' => 'ماذا نفعل بالعربية',
                'type'     => 'textarea',
                'value'    => '"تكامل النظام" يوفر احتياجات العمالء من خالل نقل الصندوق من الموردين إلى العمالء النهائيين بأقل سعر للمنتجات مع تركيب عالي الجودة. نحن ن قدم جميع احتياجات السوق مع حلول مخصصة حسب احتياجات العميل.'
            ],
            [
                'key'      => 'what_we_do_en',
                'neckname' => 'ماذا نفعل بالانجليزية',
                'type'     => 'textarea',
                'value'    => '“System Integration” provides customer needs by transferring the box from suppliers to end customers at the lowest product price with high quality installation. We cater to all market needs with customized solutions as per client needs.'
            ],
            [
                'key'      => 'how_we_do_ar',
                'neckname' => 'كيف نفعل ذلك بالعربية',
                'type'     => 'textarea',
                'value'    => '"تكامل النظام" يوفر احتياجات العمالء من خالل نقل الصندوق من الموردين إلى العمالء النهائيين بأقل سعر للمنتجات مع تركيب عالي الجودة. نحن ن قدم جميع احتياجات السوق مع حلول مخصصة حسب احتياجات العميل.'
            ],
            [
                'key'      => 'how_we_do_en',
                'neckname' => 'كيف نفعل ذلك بالانجليزية',
                'type'     => 'textarea',
                'value'    => '“System Integration” provides customer needs by transferring the box from suppliers to end customers at the lowest product price with high quality installation. We cater to all market needs with customized solutions as per client needs.'
            ],
            [
                'key'      => 'why_we_do_ar',
                'neckname' => 'لماذا نفعل ذلك بالعربية',
                'type'     => 'textarea',
                'value'    => '"تكامل النظام" يوفر احتياجات العمالء من خالل نقل الصندوق من الموردين إلى العمالء النهائيين بأقل سعر للمنتجات مع تركيب عالي الجودة. نحن ن قدم جميع احتياجات السوق مع حلول مخصصة حسب احتياجات العميل.'
            ],
            [
                'key'      => 'why_we_do_en',
                'neckname' => 'لماذا نفعل ذلك بالانجليزية',
                'type'     => 'textarea',
                'value'    => '“System Integration” provides customer needs by transferring the box from suppliers to end customers at the lowest product price with high quality installation. We cater to all market needs with customized solutions as per client needs.'
            ],
            [
                'key'      => 'vision_ar',
                'neckname' => 'الرؤية بالعربية',
                'type'     => 'textarea',
                'value'    => 'الريادة في السوق المصري في عام 2028 من خالل توفير نظام متكامل متكامل بأعلى الحلول التكنولوجية'
            ],
            [
                'key'      => 'vision_en',
                'neckname' => 'الرؤية بالانجليزية',
                'type'     => 'textarea',
                'value'    => 'Leadership in the Egyptian market in 2028 by providing an integrated system with the highest technological solutions'
            ],
            [
                'key'      => 'mission_ar',
                'neckname' => 'المهمة بالعربية',
                'type'     => 'textarea',
                'value'    => 'تقديم منتجات ذات علامة تجارية مناسبة مع جودة الخدمة الفائقة ، لضمان رضا عمالئنا وشركائنا.'
            ],
            [
                'key'      => 'mission_en',
                'neckname' => 'المهمة بالانجليزية',
                'type'     => 'textarea',
                'value'    => 'To provide appropriately branded products with superior service quality, to ensure the satisfaction of our customers and partners.'
            ],
            [
                'key'      => 'goal_ar',
                'neckname' => 'المهمة بالعربية',
                'type'     => 'textarea',
                'value'    => 'تقديم منتجات ذات علامة تجارية مناسبة مع جودة الخدمة الفائقة ، لضمان رضا عمالئنا وشركائنا.'
            ],
            [
                'key'      => 'goal_en',
                'neckname' => 'المهمة بالانجليزية',
                'type'     => 'textarea',
                'value'    => 'To provide appropriately branded products with superior service quality, to ensure the satisfaction of our customers and partners.'
            ],
            [
                'key'      => 'address',
                'neckname' => 'العنوان',
                'type'     => 'text',
                'value'    => 'القاهرة زهراء المعادي شارع كارفور الرئيسي عمارة البنك الاهلي الدوار السابع'
            ],
            [
                'key'      => 'phone_1',
                'neckname' => 'رقم الهاتف',
                'type'     => 'text',
                'value'    => '+20224476876'
            ],
            [
                'key'      => 'phone_2',
                'neckname' => 'رقم هاتف آخر',
                'type'     => 'text',
                'value'    => '+20224476876'
            ],
            [
                'key'      => 'whatsapp',
                'neckname' => 'رقم الواتساب',
                'type'     => 'text',
                'value'    => '+20224476876'
            ],
            [
                'key'      => 'instagram',
                'neckname' => 'انستاجرام',
                'type'     => 'url',
                'value'    => 'https://www.instagram.com/'
            ],
            [
                'key'      => 'facebook',
                'neckname' => 'فيسبوك',
                'type'     => 'url',
                'value'    => 'https://www.facebook.com/'
            ],
            [
                'key'      => 'twitter',
                'neckname' => 'تويتر',
                'type'     => 'url',
                'value'    => 'https://www.twitter.com/'
            ],
        ]);
    }
}
