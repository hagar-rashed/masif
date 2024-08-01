<?php

namespace Database\Seeders;

use App\Models\Solution;
use Illuminate\Database\Seeder;

class SolutionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Solution::insert([
            [
                'name_ar' => 'نظام إنذار الحريق',
                'name_en' => 'Fire Alarm System',
                'desc_ar' => 'نحن متخصصون في توريد وتركيب واختبار وصيانة العديد من العلامات التجارية العالمية لأنظمة إنذار الحريق ذات السمعة الجيدة لتلبية الإحتياجات التي تناسب جميع المجالات للصناعات عالية المخاطر وكذلك جميع الابتكارات المتقدمة تقنيًا و التي لها قيمة كبيره طوال فترة المنتج بالكامل.',
                'desc_en' => 'We specialize in the supply, installation, testing and maintenance of many reputable international brands of fire alarm systems to cater to the cross-cutting needs of high-risk industries as well as all technologically advanced innovations that have great value throughout the entire product life.',
                'image'   => 'solutions/img_1.png',
            ],
            [
                'name_ar' => 'شبكة البيانات "سلبية ونشطة"',
                'name_en' => 'Data network "passive and active"',
                'desc_ar' => 'نحن نقدم كابلات البنية التحتية لشبكة البيانات لمكونات DN النشطة ليتم دمجها مع جميع أنظمة التيار الخفيف من خلال توفير الملصقات وتركيبها وربطها.',
                'desc_en' => 'We provide data network infrastructure cabling for active DN components to be integrated with all light current systems by providing labeling, installation and interconnection.',
                'image'   => 'solutions/img_1.png',
            ],
            [
                'name_ar' => 'نظام كاميرات المراقبة CCTV',
                'name_en' => 'CCTV surveillance camera system',
                'desc_ar' => 'لقد قمنا بتطوير حلول الدوائر التلفزيونية المغلقة المتكاملة من البداية إلى النهاية ، مع التركيز على توفير نظام إدارة أمن موحد وموحد لضمان الأمن والمراقبة أيضًا BMA (تطبيقات إدارة المباني) التي يمكن الوصول إليها بسهولة من منصة واحدة.',
                'desc_en' => 'We have developed end-to-end end-to-end integrated CCTV solutions, focusing on providing a standardized and unified security management system to ensure security and monitoring also BMA (Building Management Applications) easily accessible from a single platform.',
                'image'   => 'solutions/img_1.png',
            ],
            [
                'name_ar' => 'نظام هاتف PBX و IP',
                'name_en' => 'PBX and IP phone system',
                'desc_ar' => 'إدارة الوقت ا للجدول الزمني المحدد. يساعد تنسيق المشروع في المراقبة والتحكم بشكل أفضل لكل مرحلة من مراحل المشروع لضمان تقدمه وفقً تتيح اإلدارة الجيدة للوقت تقديم خدماتنا في الوقت المحدد دون أي تسامح.',
                'desc_en' => 'Manage time according to the set schedule. Project coordination helps in better monitoring and control of each phase of the project to ensure it progresses accordingly. Good time management enables our solutions to be delivered on time without any tolerance.',
                'image'   => 'solutions/img_1.png',
            ],
            [
                'name_ar' => 'نظام الإذاعه الداخليه',
                'name_en' => 'internal broadcasting system',
                'desc_ar' => 'نحن التاجر المشهور والمورد لمجموعة عالية الجودة من العلامات التجارية الدولية المختلفة مع القدرة على التكامل مع BMA أخرى. نحن نقدم أنظمة مخاطبة عامة مصممة لتكون قوية وتفي باحتياجات تعزيز الصوت لديك. معدات PA سهلة الاستخدام وسهلة التشغيل. أيضا ، نحن نقدم دعم العملاء على نطاق واسع.',
                'desc_en' => "We are the reputed dealer and supplier of a high quality range of various international brands with the ability to integrate with other BMA's. We offer public address systems that are designed to be robust and meet your voice enhancement needs. PA equipment is easy to use and easy to operate. Also, we provide extensive customer support.",
                'image'   => 'solutions/img_1.png',
            ],
            [
                'name_ar' => 'SMART / IPTV',
                'name_en' => 'SMART / IPTV',
                'desc_ar' => 'نحن نقدم منصة تطبيقات فريدة ومخصصة للتطبيقات التفاعلية لمدمجي الأنظمة والتي تتيح تسليم مجموعة واسعة من التطبيقات المخصصة. يمكن لـ SMATV الذي يجعل جميع الشاشات في بناء المجتمع أن يشارك هوائي القمر الصناعي المثبت مما يلغي الحاجة إلى واحد منفصل لكل مستخدم. يسمح لك بتخصيص برامجك وفقًا لاحتياجات ورغبات جمهورك. كما أصبح نظام IPTV أكثر شعبية في الفنادق والعقارات التجارية الحديثة. يتم تقديم خدمات التلفزيون الرقمي عبر الإنترنت باستخدام بروتوكول الإنترنت.',
                'desc_en' => "We provide a unique, custom application platform for system integrators' interactive applications that enables the delivery of a wide range of custom applications. The SMATV that makes all screens in the community building can share the installed satellite antenna eliminating the need for a separate one for each user. It allows you to customize your programs according to the needs and desires of your audience. IPTV is also becoming more popular in hotels and modern commercial properties. Digital TV services are delivered over the Internet using the Internet Protocol.",
                'image'   => 'solutions/img_1.png',
            ],
            [
                'name_ar' => 'انظمة حماية',
                'name_en' => 'protection systems',
                'desc_ar' => 'نحن نقدم جودة عالية لأجهزة الكشف عن المعادن بأفضل الأسعار المعتمدة للمعدات المصنعه لنظام الأمان للشركات ، من أجل أمان عالي الفعالية يمكن استخدامها مع (بوابة للكشف عن المعادن وكاشف معادن يدوي).',
                'desc_en' => "We offer high quality metal detectors at the best approved prices for corporate security system manufacturers, for highly effective security that can be used with (a metal detector gate and a manual metal detector).",
                'image'   => 'solutions/img_1.png',
            ],
        ]);
    }
}
