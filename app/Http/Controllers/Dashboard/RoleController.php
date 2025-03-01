<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Ability;
use App\Models\Role;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    public $modules  = [
        'employees',
        'books',
        'tags',
        'categories',
        'articles',
        'courses',
        'quizzes',
        'consultation',
        'vendors',
        'contact_us',
        'roles',       
        'settings',
        'reports',
        'news_subscribers',
        'recycle_bin',
    ];

    public function index()
    {
        $this->authorize('view_roles');

        $roles      = Role::with('abilities:id,category,action','employees:id')->get();
        $abilities  = Ability::select('id','name','category','action')->get();

        return view('dashboard.roles.index',[ 'roles' => $roles , 'abilities' => $abilities , 'modules' => $this->modules]);
    }

    public function show(Role $role,Request $request)
    {
        $this->authorize('show_roles');

        $role->load('abilities','employees:id');
        $abilities  = Ability::select('id','name','category','action')->get();

        if ( ! $request->ajax() )
            return view('dashboard.roles.show',[ 'role' => $role , 'abilities' => $abilities , 'modules' => $this->modules]);
         else
            return response()->json(['name_ar' => $role['name_ar'] , 'name_en' => $role['name_en'] , 'role_abilities' => $role['abilities'] ]);
    }

    public function employees(Role $role,Request $request)
    {
        $role->load('employees:id,name,email,phone,image,created_at');

        $employeesCount = $role->employees->count();
 


        $page    = $request['page']     ?? 1;
        $perPage = $request['per_page'] ?? 10;


        return response()->json([
            "recordsTotal" => $employeesCount,
            "recordsFiltered" => $role->employees->count(),
            'data' => $role->employees->skip(($page - 1) * $perPage)->take($perPage)
        ]);
    }



    public function store(Request $request)
    {

        $this->authorize('create_roles');

        $data = $request->validate([
            "name_ar"   => ['required', 'string' , 'max:255','unique:roles'],
            "name_en"   => ['required', 'string' , 'max:255','unique:roles'],
            'abilities' => ['required', 'array'  , 'min:1'],
        ]);



        $role = Role::create($data);

        $role->abilities()->attach($request['abilities']);

    }


    public function update(Request $request, Role $role)
    {
        $this->authorize('update_roles');

        $data = $request->validate([
            "name_ar"   => ['required', 'string' , 'max:255','unique:roles,id,' . $role['id']],
            "name_en"   => ['required', 'string' , 'max:255','unique:roles,id,' . $role['id']],
            'abilities' => ['required', 'array'  , 'min:1'],
        ]);

        if ( $role->id == 1 ){
            abort(404);
        }


        $role->update($data);
        $role->abilities()->sync($request['abilities']);


    }


}
