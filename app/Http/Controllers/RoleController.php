<?php

namespace App\Http\Controllers;

use Dotenv\Parser\Value;
use Dotenv\Validator;
use Illuminate\Auth\Events\Validated;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Symfony\Component\HttpFoundation\Response;

class RoleController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:Read-Roles', ['only' => ['index', 'show']]);
        $this->middleware('permission:Create-Role', ['only' => ['create', 'store']]);
        $this->middleware('permission:Update-Role', ['only' => ['edit', 'update']]);
        $this->middleware('permission:Delete-Role', ['only' => ['destroy']]);
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $paginate=10;
        $roles = Role::query()->filterByLevel()->withCount('permissions')->paginate($paginate);
        return response()->view('cms.roles.index',['roles'=>$roles]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return response()->view('cms.roles.create');
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
        $validator = Validator($request->all(),[
            'name'=>'required|string',
        ]);

        if(! $validator->fails()){
            $role= new Role();
            $role->name = $request->input('name');

            # set guard automatically according to user auth
            $role->guard_name = session('guard');
            $role->company_id = auth()->user()->company_id ?? null;

            $isSaved= $role->save();

            return response()->json(
                [
                    'message' => $isSaved ? 'Created Successfuly ' : 'Created Failed '
                ],
                $isSaved ? Response::HTTP_CREATED :Response::HTTP_BAD_REQUEST);
        } else {
            return response()->json(
                ['message'=>$validator->getMessageBag()->first()] ,
                Response::HTTP_BAD_REQUEST

            );
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \Spatie\Permission\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function show(Role $role)
    {
        //
    }
    public function editRolePermissions(Request $request , Role $role)
    {
        $permissions = Permission::where('guard_name', '=' ,$role->guard_name)->get();
        $rolePermissions = $role->permissions; // as data  () as query

        if(count($rolePermissions)>0){
            foreach ($permissions as $permission){
                $permission->setAttribute('assigned', false);
                foreach($rolePermissions as $rolePermission){
                    if($permission->id == $rolePermission->id){
                        $permission->setAttribute('assigned',true);
                    }
                }
            }
        }
        return  response()->view('cms.roles.role-permissions',['role'=> $role, 'permissions'=> $permissions]);
    }
    public function updateRolePermissions(Request $request , Role $role)
    {
        $validator = Validator($request->all(),[
            'permission_id'=> 'required|numeric|exists:permissions,id',
        ]);

        if(!$validator->fails()){
            $permission = Permission::findById($request->input('permission_id'),'admin');
            $role->hasPermissionTo($permission)
                ? $role->revokePermissionTo($permission):
                $role->givePermissionTo($permission);
            return response()->json(['message'=>'Permission Updated Successfully'],Response::HTTP_OK);
        }else{
            return response()->json(
                ['message'=>$validator->getMessageBag()->first() ],
            Response::HTTP_BAD_REQUEST);
        }
     }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \Spatie\Permission\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function edit(Role $role)
    {
        $roles = $role->get();
        return response()->view('cms.roles.edit',[ 'role' => $role]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Spatie\Permission\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Role $role)
    {
        $validator = Validator($request->all(),[
            'name'=> 'required|string',
        ]);


        if(!$validator->fails()){
            $role->name = $request->input('name');

            $isSaved = $role->save();
            return response()->json([
                'message'=> $isSaved ? 'Upadted Successfuly ' : ' Updated Failed '],
                  $isSaved ? Response::HTTP_OK : Response::HTTP_BAD_REQUEST);
        }else{
            return response()->json(
                ['message'=>$validator->getMessageBag()->first() ],
            Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Spatie\Permission\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function destroy(Role $role)
    {
        $deleted = $role->delete();
        return response()->json([
            'message'=> $deleted ? 'Deleted successfully': 'Deleted Failed',
        ], $deleted ? Response::HTTP_OK : Response::HTTP_BAD_REQUEST);
    }
}
