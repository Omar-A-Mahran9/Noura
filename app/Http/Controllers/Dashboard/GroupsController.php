<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\StoreCategoryRequest;
use App\Http\Requests\Dashboard\StoreGroupRequest;
use App\Http\Requests\Dashboard\UpdateCategoryRequest;
use App\Http\Requests\Dashboard\UpdateGroupRequest;
use App\Models\Category;
use App\Models\ChatGroup;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Request;

class GroupsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
          $this->authorize('view_group_chat');
        if ( $request->ajax() ) {

            $groups = getModelData( model: new ChatGroup() , searchingColumns: ['name_ar', 'name_en'] );

            return response()->json($groups);
        }
        return view('dashboard.groups.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('create_group_chat');

        return view('dashboard.groups.create');
    }


    public function show($id)
    {
        $this->authorize('create_group_chat');

        return view('dashboard.groups.create');
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreGroupRequest $request)
    {

        $this->authorize('create_group_chat');
        $data = $request->validated();

        // Handle the main image upload
        if ($request->file('image')) {
            $data['image'] = uploadImage($request->file('image'), "groups");
        }
        ChatGroup::create($data);
    }



    public function edit($group)
    {
        $group = ChatGroup::findOrFail($group);
        return view('dashboard.groups.edit', compact('group'));
    }

    public function update(UpdateGroupRequest $request, $group)
    {
        $data = $request->validated();

        $group = ChatGroup::findOrFail($group);
        if ($request->file('image')) {
            deleteImage($group->image,"groups");
            $data['image'] = uploadImage($request->file('image'), "groups");
        }
         $this->authorize('update_categories');
        $group->update($data);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

     public function destroy($group)
     {
         $group = ChatGroup::findOrFail($group);

         // Check if the group has vendors
         if ($group->vendors()->exists()) {
             return response()->json([
                 'status' => 'error',
                 'message' => __('Cannot delete group as it has assigned vendors.')
             ], 400);
         }

         $this->authorize('delete_categories');
         $group->delete();

         return response()->json([
             'status' => 'success',
             'message' => __('Group deleted successfully.')
         ]);
     }


}
