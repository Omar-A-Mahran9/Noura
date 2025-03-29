<?php

namespace Database\Seeders;

use App\Models\Page;
use Illuminate\Database\Seeder;

class PageSeeder extends Seeder
{
    public function run()
    {
        // First Page: Home Page (Update if exists)
        $page1 = Page::updateOrCreate(
            ['title' => 'about'],
            ['title' => 'about']
        );

        $section1 = $page1->sections()->updateOrCreate(
            ['title' => 'عنوانك هنا تسليط
                            الضوء على ما هو مهم'],
            [
                'description' => 'لوريم إيبسوم هو ببساطة نص وهمي من صناعة الطباعة والتنضيد. لقد
                كان لوريم إيبسوم هو النص الوهمي القياسي في هذه الصناعة منذ عام
                1500.',
                'image' => 'about.jpg'
            ]
        );

        $section2 = $page1->sections()->updateOrCreate(
            ['title' => 'لماذا تعتبر الصحة العقلية مهمة'],
            [
                'description' => 'لوريم إيبسوم هو ببساطة نص وهمي من صناعة الطباعة والتنضيد، وكان لوريمإيبسوم هو الصناعة.',
                'image' => 'services.jpg'
            ]
        );
        $section2->items()->updateOrCreate(
            ['title' => 'فائدة 1'],
            ['description' => 'لوريم إيبسوم هو ببساطة نص
                وهمي للطباعة والتنضيد', 'image' => 'web_dev.jpg']
        );
        $section2->items()->updateOrCreate(
            ['title' => 'فائدة 1'],
            ['description' => 'لوريم إيبسوم هو ببساطة نص
                وهمي للطباعة والتنضيد', 'image' => 'web_dev.jpg']
        );
        $section2->items()->updateOrCreate(
            ['title' => 'فائدة 1'],
            ['description' => 'لوريم إيبسوم هو ببساطة نص
                وهمي للطباعة والتنضيد', 'image' => 'web_dev.jpg']
        );

        $section3 = $page1->sections()->updateOrCreate(
            ['title' => 'عنوانك هنا تسليط
                            الضوء على ما هو مهم'],
            [
                'description' => 'لوريم إيبسوم هو ببساطة نص وهمي من صناعة الطباعة والتنضيد. لقد
                كان لوريم إيبسوم هو النص الوهمي القياسي في هذه الصناعة منذ عام
                1500.',
                'image' => 'about.jpg'
            ]
        );
        $section4 = $page1->sections()->updateOrCreate(
            ['title' => 'عنوانك هنا تسليط
                            الضوء على ما هو مهم'],
            [
                'description' => 'لوريم إيبسوم هو ببساطة نص وهمي من صناعة الطباعة والتنضيد. لقد
                كان لوريم إيبسوم هو النص الوهمي القياسي في هذه الصناعة منذ عام
                1500.',
                'image' => 'about.jpg'
            ]
        );

        $section5 = $page1->sections()->updateOrCreate(
            ['title' => 'لماذا تعتبر الصحة العقلية مهمة'],
            [
                'description' => 'لوريم إيبسوم هو ببساطة نص وهمي من صناعة الطباعة والتنضيد، وكان لوريمإيبسوم هو الصناعة.',
                'image' => 'services.jpg'
            ]
        );
        $section5->items()->updateOrCreate(
            ['title' => 'المنفعة الثانوية I'],
            ['description' => 'لوريم إيبسوم هو ببساطة نص
                وهمي للطباعة والتنضيد', 'image' => 'web_dev.jpg']
        );
        $section5->items()->updateOrCreate(
            ['title' => 'المنفعة الثانوية I'],
            ['description' => 'لوريم إيبسوم هو ببساطة نص
                وهمي للطباعة والتنضيد', 'image' => 'web_dev.jpg']
        );
        $section5->items()->updateOrCreate(
            ['title' => 'المنفعة الثانوية I'],
            ['description' => 'لوريم إيبسوم هو ببساطة نص
                وهمي للطباعة والتنضيد', 'image' => 'web_dev.jpg']
        );

        $section6 = $page1->sections()->updateOrCreate(
            ['title' => 'لماذا تعتبر الصحة العقلية مهمة'],
            [
                'description' => 'لوريم إيبسوم هو ببساطة نص وهمي من صناعة الطباعة والتنضيد، وكان لوريمإيبسوم هو الصناعة.',
                'image' => 'services.jpg'
            ]
        );
        $section6->items()->updateOrCreate(
            ['title' => 'المنفعة الثانوية I'],
            ['description' => 'لوريم إيبسوم هو ببساطة نص
                وهمي للطباعة والتنضيد', 'image' => 'web_dev.jpg']
        );
        $section6->items()->updateOrCreate(
            ['title' => 'المنفعة الثانوية I'],
            ['description' => 'لوريم إيبسوم هو ببساطة نص
                وهمي للطباعة والتنضيد', 'image' => 'web_dev.jpg']
        );
        $section6->items()->updateOrCreate(
            ['title' => 'المنفعة الثانوية I'],
            ['description' => 'لوريم إيبسوم هو ببساطة نص
                وهمي للطباعة والتنضيد', 'image' => 'web_dev.jpg']
        );


        $section7 = $page1->sections()->updateOrCreate(
            ['title' => 'عنوانك هنا تسليط
                            الضوء على ما هو مهم'],
            [
                'description' => 'لوريم إيبسوم هو ببساطة نص وهمي من صناعة الطباعة والتنضيد. لقد
                كان لوريم إيبسوم هو النص الوهمي القياسي في هذه الصناعة منذ عام
                1500.',
                'image' => 'about.jpg'
            ]
        );


        // Second Page: Contact Page (Update if exists)
        $page2 = Page::updateOrCreate(
            ['title' => 'home'],
            ['title' => 'home']
        );

        $section7 = $page2->sections()->updateOrCreate(
            ['title' => 'Get in Touch'],
            [
                'description' => 'Contact us for inquiries',
                'image' => 'contact.jpg'
            ]
        );

        $section8 = $page2->sections()->updateOrCreate(
            ['title' => 'لماذا تعتبر الصحة العقلية مهمة'],
            [
                'description' => 'لوريم إيبسوم هو ببساطة نص وهمي من صناعة الطباعة والتنضيد، وكان لوريمإيبسوم هو الصناعة.',
                'image' => 'services.jpg'
            ]
        );
        $section8->items()->updateOrCreate(
            ['title' => 'فائدة 1'],
            ['description' => 'لوريم إيبسوم هو ببساطة نص
                وهمي للطباعة والتنضيد', 'image' => 'web_dev.jpg']
        );
        $section8->items()->updateOrCreate(
            ['title' => 'فائدة 1'],
            ['description' => 'لوريم إيبسوم هو ببساطة نص
                وهمي للطباعة والتنضيد', 'image' => 'web_dev.jpg']
        );
        $section8->items()->updateOrCreate(
            ['title' => 'فائدة 1'],
            ['description' => 'لوريم إيبسوم هو ببساطة نص
                وهمي للطباعة والتنضيد', 'image' => 'web_dev.jpg']
        );
        $section9 = $page2->sections()->updateOrCreate(
            ['title' => 'Get in Touch'],
            [
                'description' => 'Contact us for inquiries',
                'image' => 'contact.jpg'
            ]
        );
        $section109 = $page2->sections()->updateOrCreate(
            ['title' => 'Get in Touch'],
            [
                'description' => 'Contact us for inquiries',
                'image' => 'contact.jpg'
            ]
        );

    }
}
