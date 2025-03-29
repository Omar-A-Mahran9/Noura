<?php

namespace Database\Seeders;


use App\Models\Ability;
use App\Models\Employee;
use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = [
            'employees',
            'orders',
            'page',
            'reports',
            'group_chat',
            'consultation_work',
            'vendors',

            'courses',
            'courses_order',
            'course_category',
            'quizzes',
            'categories',
            'questions',
            'videos_materials',
            'attachment_materials',
            'books',
            'books_orders',
            'articles',
            'roles',
            'contact_us',
            'news',
            'settings',
            'news_subscribers',
            'consultation',
            "consultation_type",
            "consultation_time"

        ];

        $actions = [
            'view',
            'show',
            'create',
            'update',
            'delete',
        ];

        // Indices of unused actions from the above array
        $exceptions = [
            'contact_us'            => [ 'unused_actions' => [ 1,2,4 ]       , 'extra_actions' => []          ],
            'reports'               => [ 'unused_actions' => [ 1,2,3,4 ]                                      ],
            'news_subscribers'      => [ 'unused_actions' => [ 1,2,3 ]                                        ],
            'slider_dashboard'      => [ 'unused_actions' => [ 1,2,3,4 ]                                      ],
            'recycle_bin'           => [ 'unused_actions' => [ 1,2,3 ]       , 'extra_actions' => ['restore'] ],
        ];

        foreach ($categories as $category) {
            $usedActions = array_merge($actions, $exceptions[$category]['extra_actions'] ?? []);

            foreach ($exceptions[$category]['unused_actions'] ?? [] as $index) { // Remove unused actions
                unset($usedActions[$index]);
            }

            foreach (array_values($usedActions) as $action) {
                Ability::create([
                    'name'     => $action . '_' . str_replace(' ', '_', $category),
                    'category' => $category,
                    'action'   => $action,
                ]);
            }
        }

        // Create Super Admin Role
        $superAdminRole = Role::create([
            'name_ar' => 'مدير تنفيذي',
            'name_en' => 'Super Admin',
        ]);

        // Get the IDs of all abilities
        $superAdminAbilitiesIds = Ability::pluck('id');
        $superAdminRole->abilities()->attach($superAdminAbilitiesIds);

        // Create other roles with limited abilities
        $adminRole = Role::create([
            'name_ar' => 'مدير',
            'name_en' => 'Admin',
        ]);

        // Assign abilities for Admins (Admin can manage content, users, and live events)
        $adminAbilities = Ability::whereIn('category', ['courses', 'books', 'consultation', 'articles', 'vendors'])
            ->whereIn('action', ['create', 'update', 'view', 'show'])
            ->pluck('id');

        $adminRole->abilities()->attach($adminAbilities);

        $contentCreatorRole = Role::create([
            'name_ar' => 'منشئ محتوى',
            'name_en' => 'Content Creator',
        ]);

        // Assign abilities for Content Creators (Content creators can add and manage course content, quizzes, and live sessions)
        $contentCreatorAbilities = Ability::whereIn('category', ['courses', 'quizzes', 'consultation'])
            ->whereIn('action', ['create', 'update', 'view', 'show'])
            ->pluck('id');

        $contentCreatorRole->abilities()->attach($contentCreatorAbilities);

        $specialistRole = Role::create([
            'name_ar' => 'أخصائي/مضيف',
            'name_en' => 'Specialist/Host',
        ]);

        // Assign abilities for Specialists/Hosts (They can provide consultations, manage appointments, and interact with users)
        $specialistAbilities = Ability::whereIn('category', ['consultation', 'appointments'])
            ->whereIn('action', ['create', 'view', 'update', 'show'])
            ->pluck('id');

        $specialistRole->abilities()->attach($specialistAbilities);

        // Assign these roles to employees (assuming employees with IDs 1, 2 exist)
        Employee::find(1)->assignRole($superAdminRole);
        Employee::find(2)->assignRole($superAdminRole);
        // Employee::find(3)->assignRole($contentCreatorRole);
        // Employee::find(4)->assignRole($specialistRole);
    }
}
