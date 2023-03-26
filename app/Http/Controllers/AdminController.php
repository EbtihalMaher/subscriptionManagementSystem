<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Str;


class AdminController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:Read-Admins', ['only' => ['index', 'show']]);
        $this->middleware('permission:Create-Admin', ['only' => ['create', 'store']]);
        $this->middleware('permission:Update-Admin', ['only' => ['edit', 'update']]);
        $this->middleware('permission:Delete-Admin', ['only' => ['destroy']]);
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //SELECT * FROM admins;
        $admins = Admin::with('role')->get();
        return response()->view('cms.admins.index', ['admins' => $admins]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = Role::filterByLevel()->get();
        return response()->view('cms.admins.create', ['roles' => $roles]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $validator = Validator($request->all(), [
            'role_id' => 'required|numeric|exists:roles,id',
            'name' => 'required|string|min:3',
            'email' => 'required|string|unique:admins,email',
        ]);


        if (!$validator->fails()) {
            $admin = new Admin();
            $admin->name = $request->input('name');
            $admin->email = $request->input('email');
            $password = Str::random(10);
            $admin->password = Hash::make($password);
            $isSaved = $admin->save();
            if ($isSaved) {
                $admin->assignRole($request->input('role_id'));
            }
            return response()->json([
                'message' => $isSaved ? 'Saved successfully' : 'Save failed!'
            ], $isSaved ? Response::HTTP_CREATED : Response::HTTP_BAD_REQUEST);
        } else {
            return response()->json([
                'message' => $validator->getMessageBag()->first()
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Admin  $admin
     * @return \Illuminate\Http\Response
     */
    public function show(Admin $admin)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Admin  $admin
     * @return \Illuminate\Http\Response
     */
    public function edit(Admin $admin)
    {
        //
        $roles = Role::query()->filterByLevel()->get();
        $currentRole = $admin->roles[0];
        return response()->view('cms.admins.edit', ['admin' => $admin, 'roles' => $roles, 'currentRole' => $currentRole]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Admin  $admin
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Admin $admin)
    {
        //
        $validator = Validator($request->all(), [
            'role_id' => 'required|numeric|exists:roles,id',
            'name' => 'required|string|min:3',
            'email' => 'required|email|unique:admins,email,' . $admin->id,

        ]);

        if (!$validator->fails()) {
            $admin->name = $request->input('name');
            $admin->email = $request->input('email');
            $isSaved = $admin->save();
            if ($isSaved) {
                $admin->syncRoles(Role::findById($request->input('role_id'), 'admin'));
            }
            return response()->json(
                ['message' => $isSaved ? 'Saved successfully' : 'Save failed!'],
                $isSaved ? Response::HTTP_OK : Response::HTTP_BAD_REQUEST
            );
        } else {
            return response()->json(
                ['message' => $validator->getMessageBag()->first()],
                Response::HTTP_BAD_REQUEST,
            );
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Admin  $admin
     * @return \Illuminate\Http\Response
     */
    public function destroy(Admin $admin)
    {
        //
        $deleted = $admin->delete();
        return response()->json([
            'icon' => $deleted ? 'success' : 'error',
            'title' => $deleted ? 'Deleted successfully' : 'Delete failed!',
            'message' => $deleted ? 'Item deleted permenantly' : 'Item delete failed!'
        ], $deleted ? Response::HTTP_OK : Response::HTTP_BAD_REQUEST);
    }
}
