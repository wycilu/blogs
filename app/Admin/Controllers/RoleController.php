<?php

namespace App\Admin\Controllers;

class RoleController extends Controller {

    //角色列表页面
    public function index(){
        $roles = \App\AdminRole::paginate(10);
        return view('/admin/role/index',compact('roles'));
    }

    //角色创建页面
    public function create(){
        return view('/admin/role/add');
    }

    //角色创建操作
    public function store(){
        $this->validate(request(),[
            'name' => 'required|min:3',
            'description' => 'required'
        ]);
        \App\AdminRole::create(request(['name','description']));
        return redirect('/admin/roles');
    }

    //角色权限的关系页面
    public function permission(\App\AdminRole $role){
        //获取所有权限
        $permissions = \App\AdminPermission::all();
        //获取当前角色权限
        $myPermissions = $role->permissions;
        return view('/admin/role/permission',compact('permissions','myPermissions','role'));
    }

    //存储角色权限行为
    public function storePermission(\App\AdminRole $role){
        $this->validate(request(),[
            'permissions' => 'required|array'
        ]);
        $permissions = \App\AdminPermission::findMany(request('permissions'));
        $myPermissions = $role->permissions;

        //要增加的  diff差集   $roles里面除掉$myRoles 就是要删除的
        $addPermissions = $permissions->diff($myPermissions);
        foreach ($addPermissions as $permission){
            $role->grantPermission($permission);
        }
        //要删除的
        $deletePermissions = $myPermissions->diff($permissions);
        foreach ($deletePermissions as $permission){
            $role->deletePermission($permission);
        }

        return back();
    }
}