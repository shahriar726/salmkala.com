<?php

namespace App\Http\Controllers\admin\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\User\RoleRequest;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    //
    public function index(){
//        $roles= Role::whereNotIn('name', ['admin'])->get();
//        $roles= Role::all();
        $roles= Role::whereNotIn('name', ['super_admin'])->get();
        return view('admin.user.role.index',compact('roles'));
    }

    public function  create(){
        $permissions = Permission::all();
        return view('admin.user.role.create',compact('permissions'));

    }
    public function  store(RoleRequest $request){
        $inputs = $request->all();
        $role = Role::create($inputs);
        //agar null bod hich permissioni  nafreste
        $inputs['permissions'] = $inputs['permissions'] ?? [];
//        $role->givePermissionTo($inputs['permissions'] && $inputs['guard_name']);
        //agar null nabood  permission ro as tariq role sync kon
        $role->permissions()->sync($inputs['permissions']);
        return redirect()->route('admin.user.role.index')->with('swal-success', 'نقش جدید با موفقیت ثبت شد');
    }

    public function edit(Role $role){
        return view('admin.user.role.edit', compact('role'));
    }
    public function update(RoleRequest $request, Role $role){
        $inputs = $request->all();
        $role->update($inputs);
        return redirect()->route('admin.user.role.index')->with('swal-success', 'نقش شما با موفقیت ویرایش شد');
    }
    public function destroy(Role $role){
        $result = $role->delete();
        return redirect()->route('admin.user.role.index')->with('swal-success', 'نقش شما با موفقیت حذف شد');
    }
    public function permissionForm(Role $role)
    {
        $permissions = Permission::all();
        return view('admin.user.role.set-permission', compact('role', 'permissions'));
    }
    public function permissionUpdate(RoleRequest $request, Role $role){
        $inputs = $request->all();
        $inputs['permissions'] = $inputs['permissions'] ?? [];
        $role->permissions()->sync($inputs['permissions']);
        return redirect()->route('admin.user.role.index')->with('swal-success', 'نقش جدید با موفقیت ویرایش شد');
    }

}
