<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Symfony\Component\HttpFoundation\Response;

class UserController extends Controller
{

    function __construct()
    {
        $this->middleware('permission:Read-Users', ['only' => ['index', 'show']]);
        $this->middleware('permission:Create-User', ['only' => ['create', 'store']]);
        $this->middleware('permission:Update-User', ['only' => ['edit', 'update']]);
        $this->middleware('permission:Delete-User', ['only' => ['destroy']]);
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $paginate=10;
        $users = User::withCount(['permissions'])->with('role')->paginate($paginate);
        return response()->view('cms.users.index', ['users' => $users]);
    }

    public function editPermissions(Request $request, User $user)
    {
        $permissions = Permission::where('guard_name', '=', 'user')
            ->get();
        $userPermissions = $user->permissions;
        foreach ($permissions as $permission) {
            $permission->setAttribute('assigned', false);
            foreach ($userPermissions as $userPermission) {
                if ($permission->id == $userPermission->id) {
                    $permission->setAttribute('assigned', true);
                }
            }
        }
        return response()->view('cms.users.user-permissions', ['user' => $user, 'permissions' => $permissions]);
    }

    public function updatePermissions(Request $request, User $user)
    {
        $validator = Validator($request->all(), [
            'permission_id' => 'required|numeric|exists:permissions,id',
        ]);
        if (!$validator->fails()) {
            $permission = Permission::findOrFail($request->input('permission_id'));
            if ($user->hasPermissionTo($permission)) {
                $user->revokePermissionTo($permission);
            } else {
                $user->givePermissionTo($permission);
            }
            return response()->json(
                ['message' => 'Permission updated successfully'],
                Response::HTTP_OK
            );
        } else {
            return response()->json(
                ['message' => $validator->getMessageBag()->first()],
                Response::HTTP_BAD_REQUEST
            );
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return response()->view('cms.users.create');
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
            'name' => 'required|string|max:30',
            'email' => 'required|email'
        ]);

        if (!$validator->fails()) {
            $user = new User();
            $user->name = $request->input('name');
            $user->email = $request->input('email');
            $user->password = Hash::make(12345);
            $isSaved = $user->save();
            return response()->json([
                'message' => $isSaved ? 'Saved successfully' : 'Save failed!'
            ], $isSaved ? Response::HTTP_CREATED : Response::HTTP_BAD_REQUEST);
        } else {
            return response()->json(
                ['message' => $validator->getMessageBag()->first()],
                Response::HTTP_BAD_REQUEST
            );
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        //
        return response()->view('cms.users.edit', ['user' => $user]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        //
        $validator = Validator($request->all(), [
            'name' => 'required|string|max:30',
            'email' => 'required|email'
        ]);

        if (!$validator->fails()) {
            $user->name = $request->input('name');
            $user->email = $request->input('email');
            $isSaved = $user->save();
            return response()->json([
                'message' => $isSaved ? 'Saved successfully' : 'Save failed!'
            ], $isSaved ? Response::HTTP_OK : Response::HTTP_BAD_REQUEST);
        } else {
            return response()->json(
                ['message' => $validator->getMessageBag()->first()],
                Response::HTTP_BAD_REQUEST
            );
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        //
        $deleted = $user->delete();
        return response()->json(
            ['message' => $deleted ? 'Deleted successfully' : 'Delete failed'],
            $deleted ? Response::HTTP_OK : Response::HTTP_BAD_REQUEST
        );
    }
}
