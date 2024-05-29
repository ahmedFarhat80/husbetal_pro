<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Symfony\Component\HttpFoundation\Response;

class PermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $permissions = Permission::all();
        return response()->view('dashboard.spatie.permissions.index', ['data' => $permissions]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $validator = Validator($request->all(), [
            'name' => 'required|string|min:3|max:100',
            'guard_name' => 'required|string|in:web,doctor'
        ]);

        if (!$validator->fails()) {
            $permission = new Permission();
            $permission->name = $request->get('name');
            $permission->guard_name = $request->get('guard_name');
            $isSaved = $permission->save();
            return response()->json([
                'message' => $isSaved ? __('Saved successfully') : __('Failed to save')
            ], $isSaved ? Response::HTTP_CREATED : Response::HTTP_BAD_REQUEST);
        } else {
            return response()->json([
                'message' => $validator->getMessageBag()->first()
            ], Response::HTTP_BAD_REQUEST);
        }
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        $validator = Validator($request->all(), [
            'name' => 'required|string|min:3|max:100',
            'guard_name' => 'required|string|in:web,doctor'
        ]);

        if (!$validator->fails()) {
            $permission =  Permission::findOrFail($id);
            $permission->name = $request->get('name');
            $permission->guard_name = $request->get('guard_name');
            $isSaved = $permission->save();
            return response()->json([
                'message' => $isSaved ? __('Saved successfully') : __('Failed to save')
            ], $isSaved ? Response::HTTP_OK : Response::HTTP_BAD_REQUEST);
        } else {
            return response()->json([
                'message' => $validator->getMessageBag()->first()
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        $isDeleted = Permission::destroy($id);
        if ($isDeleted) {
            return response()->json([
                'title' => __('Success!'), 'text' => __('Permission Deleted successfully'), 'icon' => 'success'
            ], Response::HTTP_OK);
        } else {
            return response()->json([
                'title' => __('Failed!'), 'text' => __('Permission delete failed'), 'icon' => 'error'
            ], Response::HTTP_BAD_REQUEST);
        }
    }
}
