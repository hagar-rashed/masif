<?php

namespace Database\Seeders;

use App\Models\Article;
use Illuminate\Database\Seeder;

class ResearchTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Article::insert([
            [
                'type'         => 'research',
                'title'        => '(WORD) الاستشراق مصدرا من مصادر المعلومات عن العالم الإسلامي المعاصر',
                'pages'        => 25,
                'folders'      => 1,
                'publish_date' => '2016-07-13',
                'hijri_date'   => '1437-10-08',
                'desc'         => null,
                'image'        => 'articles/eshteshraq.png',
                'file'         => 'research/eshteshraq.docx',
                'views'        => 9142,
                'downloads'    => 0,
            ],
            [
                'type'         => 'research',
                'title'        => '(WORD) أثر الاستشراق في الحملة على رسول الله',
                'pages'        => 33,
                'folders'      => 1,
                'publish_date' => '2016-02-18',
                'hijri_date'   => '1437-05-10',
                'desc'         => 'جهود المستشرقين والمنصِّرين في موقفهم من رسول الله صلى الله عليه وسلم تحتاج إلى عناية بالرصد أولًا، ثم بالردود على الشبهات (بلغة علمية رصينة، ثم إيصال هذه الردود إلى مراكز البحث العلمي في الغرب، والعناية بترجمة هذه الردود إلى اللغات المنتشرة)',
                'image'        => 'articles/eshteshraq2.png',
                'file'         => 'research/alestshraq.docx',
                'views'        => 6433,
                'downloads'    => 0,
            ],
            [
                'type'         => 'research',
                'title'        => '(PDF) الاستشراق مصدرا من مصادر المعلومات عن العالم الإسلامي المعاصر',
                'pages'        => 35,
                'folders'      => 1,
                'publish_date' => '2015-12-09',
                'hijri_date'   => '1437-02-27',
                'desc'         => null,
                'image'        => 'articles/eshteshraq.png',
                'file'         => 'research/alestshraq2.pdf',
                'views'        => 8956,
                'downloads'    => 0,
            ],
            [
                'type'         => 'research',
                'title'        => '(PDF) أثر الاستشراق في الحملة على رسول الله صلى الله عليه وسلم',
                'pages'        => 40,
                'folders'      => 1,
                'publish_date' => '2015-12-09',
                'hijri_date'   => '1437-02-27',
                'desc'         => null,
                'image'        => 'articles/eshteshraq2.png',
                'file'         => 'research/alestshraq.pdf',
                'views'        => 5923,
                'downloads'    => 0,
            ],
        ]);
    }
}
