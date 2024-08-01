<?php

namespace Database\Seeders;

use App\Models\Service;
use Illuminate\Database\Seeder;

class ServiceTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Service::insert([
            [
                'name_ar' => 'الخبرة',
                'name_en' => 'Experience',
                'desc_ar' => 'Construction Cairo Newهي شركة أنظمة متكاملة ذات خبرة. لقد نجح فريقنا المحترف في مجال التيار الخفيف في مساعدة العمالء في الحصول على الحلول المثلى من خالل دراسات الحالة.',
                'desc_en' => 'Construction Cairo New is an experienced integrated systems company. Our professional team in the field of low current has succeeded in helping customers to find the optimal solutions through case studies.',
                'image'   => 'services/img_1.png',
            ],
            [
                'name_ar' => 'الابداع',
                'name_en' => 'Creativity',
                'desc_ar' => 'الهدف هو فريدة ومبتكرة لنجاح المشروع لمساعدة عملائنا في الحصول على حلول مبتكرة في أسرع إطار زمني ممكن.',
                'desc_en' => 'The unique and innovative goal of project success is to help our clients obtain innovative solutions in the fastest possible time frame.',
                'image'   => 'services/img_1.png',
            ],
            [
                'name_ar' => 'الخبرة',
                'name_en' => 'Experience',
                'desc_ar' => 'سيؤدي تقديم نظام متكامل إلى تبسيط عملياتك وتقليل التكاليف وضمان الكفاءة. تحدد إدارة تكلفة المشروع األساس لتكاليف المشروع.',
                'desc_en' => 'Offering an integrated system will streamline your operations, reduce costs and ensure efficiency. Project cost management determines the basis for project costs.',
                'image'   => 'services/img_1.png',
            ],
            [
                'name_ar' => 'إدارة الوقت',
                'name_en' => 'Time Management',
                'desc_ar' => 'إدارة الوقت ا للجدول الزمني المحدد. يساعد تنسيق المشروع في المراقبة والتحكم بشكل أفضل لكل مرحلة من مراحل المشروع لضمان تقدمه وفقً تتيح اإلدارة الجيدة للوقت تقديم خدماتنا في الوقت المحدد دون أي تسامح.',
                'desc_en' => 'Manage time according to the set schedule. Project coordination helps in better monitoring and control of each phase of the project to ensure it progresses accordingly. Good time management enables our services to be delivered on time without any tolerance.',
                'image'   => 'services/img_1.png',
            ],
            [
                'name_ar' => 'الجودة والموثوقية',
                'name_en' => 'Quality and reliability',
                'desc_ar' => 'أحد أهم العوامل الكتساب ميزة تنافسية مستدامة وثقة العمالء في سوق تنافسية للغاية. إن الوفاء بالوعود للعمالء وااللتزام هو القاعدة والثقافة في شركتنا.',
                'desc_en' => 'One of the most important factors for gaining sustainable competitive advantage and customer confidence in a highly competitive market. Keeping promises to customers and commitment is the norm and culture of our company.',
                'image'   => 'services/img_1.png',
            ],
            [
                'name_ar' => 'الخبرة',
                'name_en' => 'Experience',
                'desc_ar' => 'نحن نؤمن أن لخدمة ما بعد البيع دو ًرا مهًما في إرضاء العمالء والاحتفاظ بهم. تلقي ردود فعل إيجابية من عمالئنا يدفعنا إلى الامام.',
                'desc_en' => 'We believe that after-sales service plays an important role in customer satisfaction and customer retention. Receiving positive feedback from our customers drives us forward.',
                'image'   => 'services/img_1.png',
            ],
        ]);
    }
}
