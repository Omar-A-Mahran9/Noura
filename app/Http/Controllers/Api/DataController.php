<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
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
}
