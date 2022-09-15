<?php

namespace App\Http\Controllers\Admin;

use App\UseCases\Auth\RegisterService;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Users\CreateRequest;
use App\Http\Requests\Admin\Users\UpdateRequest;

class UsersController extends Controller
{
    private $service;

    public function __construct(RegisterService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        $users = User::orderBy('id','desc')->paginate(10);

        return view('admin.users.index', compact('users'));
    }

    public function create()
    {
        return view('admin.users.create');
    }

    public function store(CreateRequest $request)
    {
        $user = User::create( $request->only(['name','email']) + [
            'password' => bcrypt(Str::random()),
            'status'   => User::STATUS_ACTIVE,
        ]);
        //$user = User::create([
        //    'name'  => $request['name'],
        //    'email' => $request['email'],
        //    'status'=> User::STATUS_ACTIVE,
        //]);
        //или
        //$user = User::create($request->only(['name','email']));
        //или (плохой метод для безопасности)
        //$user = User::create($request->all());
        //или выше занести в $data = $this->validate($request ...
        //$user = User::create($data);

        //return redirect()->route('admin.users.show', ['id' => $user->id]);
        return redirect()->route('admin.users.show', $user);
    }

    //public function show($id)
    public function show(User $user)
    {
        // laralearn метод findOrFail либо находит либо сразу кидает исключение
        // $user = User::findOrFail($id);
        // вынесли на вход функции, поэтому эт больше не нужно

        return view('admin.users.show', compact('user'));
    }

    public function edit(User $user)
    {
        //$statuses = [
        //    User::STATUS_WAIT   => 'Waiting',
        //    User::STATUS_ACTIVE => 'Active',
        //];

        return view('admin.users.edit', compact('user'));
        //return view('admin.users.edit', compact('user', 'statuses'));
    }

    public function update(UpdateRequest $request, User $user)
    {
        $user->update($request->only( ['name','email'] ));

        return redirect()->route('admin.users.show', $user);
    }

    public function destroy(User $user)
    {
        $user->delete();

        return redirect()->route('admin.users.index');
    }

    // добавим к сгенерированным методам свой:

    public function verify(User $user)
    {
        // laralearn можно сразу $user->verify(); , но разбиваем на части
        $this->service->verify($user->id);

        return redirect()->route('admin.users.show', $user);
    }
}
