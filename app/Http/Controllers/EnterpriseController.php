<?php

namespace App\Http\Controllers;

use App\Models\Enterprise;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Str;


class EnterpriseController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:Read-Enterprises', ['only' => ['index', 'show']]);
        $this->middleware('permission:Create-Enterprise', ['only' => ['create', 'store']]);
        $this->middleware('permission:Update-Enterprise', ['only' => ['edit', 'update']]);
        $this->middleware('permission:Delete-Enterprise', ['only' => ['destroy']]);
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //SELECT * FROM enterprises;
        $enterprises = Enterprise::with('role')->get();
        return response()->view('cms.enterprises.index', ['enterprises' => $enterprises]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = Role::query()->filterByLevel()->get();
        return response()->view('cms.enterprises.create');
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
            'name' => 'required|string|min:3',
            'email' => 'required|string|unique:enterprises,email',
            'contact'=> 'required|string|min:3',
        ]);


        if (!$validator->fails()) {
            $enterprise = new Enterprise();
            $enterprise->name = $request->input('name');
            $enterprise->email = $request->input('email');
            $enterprise->contact = $request->input('contact');
            $password = Str::random(10);
            $isSaved = $enterprise->save();
            // if ($isSaved) {
            //     $enterprise->assignRole($request->input('role_id'));
            // }
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
     * @param  \App\Models\Enterprise  $enterprise
     * @return \Illuminate\Http\Response
     */
    public function show(Enterprise $enterprise)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Enterprise  $enterprise
     * @return \Illuminate\Http\Response
     */
    public function edit(Enterprise $enterprise)
    {
        //
        $roles = Role::query()->filterByLevel()->get();
        // $currentRole = $enterprise->roles[0];
        return response()->view('cms.enterprises.edit', ['enterprise' => $enterprise]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Enterprise  $enterprise
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Enterprise $enterprise)
    {
        //
        $validator = Validator($request->all(), [
            'name' => 'required|string|min:3',
            'email' => 'required|email|unique:enterprises,email,' . $enterprise->id,
            'contact'=> 'required|string|min:3',
        ]);

        if (!$validator->fails()) {
            $enterprise->name = $request->input('name');
            $enterprise->email = $request->input('email');
            $enterprise->contact = $request->input('contact');
            $isSaved = $enterprise->save();
            // if ($isSaved) {
            //     $enterprise->syncRoles(Role::findById($request->input('role_id'), 'enterprise'));
            // }
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
     * @param  \App\Models\Enterprise  $enterprise
     * @return \Illuminate\Http\Response
     */
    public function destroy(Enterprise $enterprise)
    {
        //
        $deleted = $enterprise->delete();
        return response()->json([
            'icon' => $deleted ? 'success' : 'error',
            'title' => $deleted ? 'Deleted successfully' : 'Delete failed!',
            'message' => $deleted ? 'Item deleted permenantly' : 'Item delete failed!'
        ], $deleted ? Response::HTTP_OK : Response::HTTP_BAD_REQUEST);
    }
}
