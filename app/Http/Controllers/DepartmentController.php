<?php

namespace App\Http\Controllers;

use App\Http\{Requests\FormCreate, Requests\DepartmentRequest};
use App\Models\{Department, User};
use Illuminate\{Http\Request,
    Support\Facades\Redirect,
    Support\Facades\Storage,
    Support\Facades\URL};
use Inertia\Inertia;
use Intervention\Image\ImageManagerStatic as Image;

class DepartmentController extends Controller
{
    const PAGE_SIZE = 4;

    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $Request
     * @return \Inertia\Response
     */
    public function index(Request $request)
    {
        $page_size = $request->get('page-size') ?? self::PAGE_SIZE;
        $departments = Department::paginate($page_size);

        return Inertia::render('Departments/Index', [
            'departments' => $departments->map(function ($department) {
                return [
                    'id' => $department->id,
                    'name' => $department->name,
                    'description' => $department->description,
                    'logo' => $department->logo,
                    'edit_url' => URL::route('departments.edit', $department),
                    'delete_url' => URL::route('departments.destroy', $department),
                    'users' => $department->users,
                ];
            }),
            'create_url' => URL::route('departments.create'),
            'links' => $departments->toArray()['links'],
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Inertia\Response
     */
    public function create()
    {
        return Inertia::render('Departments/Form',
            ['all_users' => User::all()]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\FormCreate  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(DepartmentRequest $request)
    {

        $fields = $request->except('user_id');

        $fields['logo'] = Storage::disk('logo')->put('', $fields['logo']);
        $department = new Department();
        $department->fill($fields);
        $department->save();
        if ($request->has('user_id')) {
            $department->users()->attach($request->get('user_id'));
        }

        return Redirect::route('departments.edit',$department->id)->with('message', 'Отдел создан');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Inertia\Response
     */
    public function edit($id)
    {
        $department = Department::with('users:id')->find($id);
        return Inertia::render('Departments/Form',
            [
                'all_users' => User::all(),
                'department' => $department,
                'user_attached' => $department->getUserIdsAttribute(),

            ]
        );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\DepartmentRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(DepartmentRequest $request, $id)
    {

        $validated_data =  $request->validated();
        $user_ids = $validated_data['user_id'];
        $data = array_filter($validated_data,function($key): bool {
            return $key !== 'user_id';
        },ARRAY_FILTER_USE_KEY);
        $department = Department::find($id);
        if(($request->file('logo'))){
            $data['logo'] = Storage::disk('logo')->put('',$request->file('logo'));
        }
        $department->update($data);

        $department->users()->sync($user_ids);
        return Redirect::back()->with('message', 'Отдел обновлён');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request, $id)
    {
        $request->validate([
            'id' => 'integer',
        ]);
        Department::destroy($id);
        return Redirect::route('departments.index');
    }
}
