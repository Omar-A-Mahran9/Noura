<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Page;
use Illuminate\Http\Request;

class DataController extends Controller
{
    public function about_nura()
    {
        return response()->json([
            'success' => true,
            'message' => 'About Nura details fetched successfully!',
            'data' => [
                // Section 1: About Nura
                'section1' => [
                    'title' => 'About Nura',
                    'description' => 'Nura is a dedicated professional with extensive experience in...',
                    'image' => asset('images/about_nura.jpg') // Change the path to your actual image
                ],

                // Section 2: Qualifications
                'section2' => [
                    'qualifications' => [
                        [
                            'title' => 'Qualification 1',
                            'image' => asset('images/qualification1.jpg'), // Change the path
                            'description' => 'Description for qualification 1...'
                        ],
                        [
                            'title' => 'Qualification 2',
                            'image' => asset('images/qualification2.jpg'), // Change the path
                            'description' => 'Description for qualification 2...'
                        ],
                        [
                            'title' => 'Qualification 3',
                            'image' => asset('images/qualification2.jpg'), // Change the path
                            'description' => 'Description for qualification 2...'
                        ],
                        // Add more qualifications if needed
                    ]
                ],

                // Section 3: Book Your Consultation
                'section3' => [
                    'title' => 'Book Your Consultation',
                    'description' => 'Schedule a session with Nura to receive expert advice and guidance.',
                    'image' => asset('images/book_consultation.jpg') // Change the path
                ],

                // Section 4: Special Consultant
                'section4' => [
                    'title' => 'Special Consultant',
                    'description' => 'Nura provides specialized consultation services in multiple fields...',
                    'image' => asset('images/special_consultant.jpg') // Change the path
                ],

                // Section 5: Customer Opinions
                'section5' => [
                    'customer_opinions' => [
                        [
                            'client' => [
                                'image' => asset('images/client1.jpg'), // Change the path
                                'name' => 'John Doe'
                            ],
                            'description' => 'Nura’s consultation helped me make better financial decisions!'
                        ],
                        [
                            'client' => [
                                'image' => asset('images/client2.jpg'), // Change the path
                                'name' => 'Jane Smith'
                            ],
                            'description' => 'I had an amazing experience, highly recommended!'
                        ],
                        [
                            'client' => [
                                'image' => asset('images/client2.jpg'), // Change the path
                                'name' => 'Jane Smith'
                            ],
                            'description' => 'I had an amazing experience, highly recommended!'
                        ],
                        // Add more customer opinions if needed
                    ]
                ]
            ]
        ], 200);
    }

    public function home_page()
    {
        $page = Page::where('title', 'home')->with('sections.items')->first();
        $sectionOne = $page->sections->first();
        $sectiontwo = $page->sections->where('id',2)->first();

         return response()->json([
            'success' => true,
            'message' => 'Home page details fetched successfully!',
            'data' => [
                // Section 1: Main Introduction
            'section1' => [
                    'title' => $sectionOne->title ?? 'Default Title',
                    'description' => $sectionOne->description ?? 'Default description',
                    'image' => getImagePathFromDirectory($sectionOne->image, 'Sections'),
                ],

                            // Section 2: Events per Day
                'section2' => [
                    '2025-03-08' => [
                    [
                        'image' => asset('images/event_friday.jpg'),
                        'title' => 'Special Workshop on Mindset',
                        'time' => '10:00 AM - 12:00 PM'
                    ],
                    [
                        'image' => asset('images/event_friday2.jpg'),
                        'title' => 'Networking Session',
                        'time' => '1:00 PM - 3:00 PM'
                    ]
                    ],
                        '2025-03-09' => [
                    [
                        'image' => asset('images/event_friday.jpg'),
                        'title' => 'Special Workshop on Mindset',
                        'time' => '10:00 AM - 12:00 PM'
                    ],
                    [
                        'image' => asset('images/event_friday2.jpg'),
                        'title' => 'Networking Session',
                        'time' => '1:00 PM - 3:00 PM'
                    ]
                            ]
                    ],


                // Section 3: Why Mindset is Important
            'section3' => [
                    'title' => $sectiontwo->title ?? 'Default Title',
                    'description' => $sectiontwo->description ?? 'Default description',
                    'details' => $sectiontwo->items->map(function ($item) {
                        return [
                            'image' => getImagePathFromDirectory($item->image ?? '', 'Items'),
                            'title' => $item->title ?? 'Default Item Title',
                            'description' => $item->description ?? 'Default Item Description'
                        ];
                    })
                ],

                // Section 4: General Content Section
                'section4' => [
                    [
                        'image' => asset('images/section4_1.jpg'),
                        'title' => 'Self-Improvement Tips',
                        'description' => 'Daily habits to enhance personal growth.'
                    ],
                    [
                        'image' => asset('images/section4_2.jpg'),
                        'title' => 'Building Resilience',
                        'description' => 'How to handle failures and keep moving forward.'
                    ]
                ],

                // Section 5: Another General Section
                'section5' => [
                    [
                        'image' => asset('images/section5_1.jpg'),
                        'title' => 'Meditation & Focus',
                        'description' => 'The role of meditation in improving mental clarity.'
                    ],
                    [
                        'image' => asset('images/section5_2.jpg'),
                        'title' => 'Time Management',
                        'description' => 'Master the art of managing time effectively.'
                    ]
                ],

                // Section 6: Special Topic
                'section6' => [
                    'title' => 'Achieve Your Goals with the Right Mindset',
                    'description' => 'Follow a structured approach to set and achieve goals successfully.',
                    'details' => [
                        [
                            'image' => asset('images/goal1.jpg'),
                            'title' => 'Set SMART Goals',
                            'description' => 'Learn how to create Specific, Measurable, Achievable, Relevant, and Time-bound goals.'
                        ],
                        [
                            'image' => asset('images/goal2.jpg'),
                            'title' => 'Stay Consistent',
                            'description' => 'Success comes with consistency and perseverance.'
                        ]
                    ]
                ],

                // Books Section
                'books' => [
                    [
                        'title' => 'The Power of Mindset',
                        'image' => asset('images/book1.jpg'),
                        'description' => 'A comprehensive guide to shifting your mindset for success.'
                    ],
                    [
                        'title' => 'Think and Grow Rich',
                        'image' => asset('images/book2.jpg'),
                        'description' => 'A classic book on the psychology of success.'
                    ]
                ],

                // Section 7: Final Content
                'section7' => [
                    'image' => asset('images/section7.jpg'),
                    'title' => 'Your Journey Starts Here',
                    'description' => 'Embrace a new way of thinking and transform your life today.'
                ]
            ]
        ], 200);
    }


}
