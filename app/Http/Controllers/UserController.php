<?php

namespace App\Http\Controllers;
use App\Http\Requests\UserRequest;
use App\Models\User;
use Inertia\Inertia;
use Illuminate\{Http\Request,
    Support\Facades\Hash,
    Support\Facades\Redirect,
    Support\Facades\Storage,
    Support\Facades\URL,
    Support\Str};



class UserController extends Controller
{
    const PAGE_SIZE = 10;

    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Inertia\Response
     */
    public function index(Request $request)
    {
        $page_size = $request->get('page-size') ?? self::PAGE_SIZE;
        $users = User::orderBy('name')->paginate($page_size);
        return Inertia::render('Users/Index', [
            'users' => $users->map(function ($user) {
                return [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'created_at' => $user->created_at->toDateString(),
                    'edit_url' => URL::route('users.edit', $user),
                    'delete_url' => URL::route('users.destroy', $user),
                ];
            }),
            'create_url' => URL::route('users.create'),
            'links' => $users->toArray()['links'],
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Inertia\Response
     */
    public function create()
    {
        return Inertia::render('Users/UserForm');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\UserRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(UserRequest $request)
    {
        $user = new User();
        $data = $request->validated();
        $data['password'] = Hash::make($data['password']);
        $user->fill($data);
        $user->password = $data['password'];
        $user->email_verified_at = now();
        $user->remember_token = Str::random(60);
        $user->save();
        return Redirect::route('users.edit',$user->id)->with('message', 'Пользователь создан');
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
        $user = User::find($id)->toArray();
        return Inertia::render('Users/UserForm',
            [
                'edit_user' => $user,
            ]
        );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Models\User  $request
     * @param  \App\Models\User  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UserRequest $request,  $id)
    {
        $data = $request->validated();
        $user = User::find($id);


        $user->update(
            [
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
            ]
        );
        return Redirect::back()->with('message', 'Пользователь обновлён');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request, $id)
    {
        $request->validate([
            'id' => 'integer',
        ]);
        User::destroy($id);
        return Redirect::route('users.index');
    }
}
