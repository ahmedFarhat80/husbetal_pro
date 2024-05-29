<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Symfony\Component\HttpFoundation\Response;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $roles = Role::withCount('permissions')->get();
        return response()->view('dashboard.spatie.roles.index', ['data' => $roles]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
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
            $role = new Role();
            $role->name = $request->get('name');
            $role->guard_name = $request->get('guard_name');
            $isSaved = $role->save();
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
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }


    public function assignRole(Request $request)
    {
        if ($request->has('user_id') && $request->has('role_id')) {

            $user = User::find($request->user_id);
            if ($user) {
                $role = Role::find($request->role_id);
                if ($role) {
                    // تحقق مما إذا كان للمستخدم أي أدوار مسندة
                    $existingRole = \DB::table('model_has_roles')
                        ->where('model_id', $user->id)
                        ->where('model_type', 'App\Models\User')
                        ->first();

                    if ($existingRole) {
                        // إذا كان للمستخدم دور مسند مسبقاً، قم بتحديث الدور
                        \DB::table('model_has_roles')
                            ->where('model_id', $user->id)
                            ->where('model_type', 'App\Models\User')
                            ->update(['role_id' => $role->id]);
                    } else {
                        // إذا لم يكن للمستخدم دور مسند، قم بإضافة دور جديد
                        $user->assignRole($role);
                    }

                    return response()->json(['message' => __('Role assigned successfully')]);
                }
            }
        }

        // إذا لم يكن هناك معرف مستخدم أو دور في الطلب، أو لم يتم العثور على المستخدم أو الدور،
        // يتم إرجاع رسالة الخطأ
        return response()->json(['error' => 'Invalid user or role'], 400);
    }
}
