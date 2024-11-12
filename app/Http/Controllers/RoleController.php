<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:role-list|role-create|role-edit|role-delete', ['only' => ['index', 'store']]);
        $this->middleware('permission:role-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:role-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:role-delete', ['only' => ['destroy']]);
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:roles,name',
            'permission' => 'required'
        ]);

        try {
            $permissionID = array_map(
                function ($value) {
                    return (int)$value;
                },
                $request->input('permission')
            );

            $role = Role::create(['name' => $request->input('name')]);
            $role->syncPermissions($permissionID);

            return response()->json(["Role created successfully"]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show()
    {
        $data = Role::all();

        return response()->json(["roles" => $data]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, $id)
    {
        $data = $request->validate([
            "name" => "required|string"
        ]);

        try {
            $role = Role::findById($id);

            $role->update($data);

            return response()->json(["Role updated successfully"]);
        } catch (\Exception $e) {
            return response()->json(["error" => $e->getMessage()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $role = Role::findById($id);

            $role->delete();

            return response()->json(["role deleted successfully"]);
        } catch (\Exception $e) {
            return response()->json(["error" => $e->getMessage()]);
        }
    }
}
