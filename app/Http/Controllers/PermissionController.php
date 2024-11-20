<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function create(Request $request)
    {
        $data = $request->validate([
            "name" => "required|string|unique:permissions"
        ]);

        try {
            $permission = Permission::firstOrCreate($data);
            return response()->json(["message" => "Permission created successfully"], 200);
        } catch (\Exception $e) {
            return response()->json(["error" => $e->getMessage()]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show()
    {
        $data = Permission::all();
        return response()->json(["permission" => $data]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $data = $request->validate([
            "name" => "required|string"
        ]);

        try {
            $permission = Permission::findById($id);
            $permission->update($data);
            return response()->json(["Permission updated successfully"]);
        } catch (\Exception $e) {
            return response()->json(["error" => $e->getMessage()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function delete($id)
    {
        try {
            $permission = Permission::findById($id);
            $permission->delete();
            return response()->json(["message" => "Permission deleted successfully"]);
        } catch (\Exception $e) {
            return response()->json(["error" => $e->getMessage()]);
        }
    }
}
