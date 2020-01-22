<?php

namespace tapanmandal81\tm81_role\Http\Controllers;

use tapanmandal81\tm81_role\Models\Role;
use DB;
use tapanmandal81\tm81_role\Models\Permission;
use tapanmandal81\tm81_role\Models\Permission_role;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
		/*$this->authorize('browse', Role::class);*/
		$no_of_entries = $request->entries;	
		$s_key = $request->s_key;	
			
		if($request->ajax()){
			$roles = Role::where('name','LIKE','%'.$s_key.'%')
				   ->paginate($no_of_entries);
				   
		   return view('tm81_role::roles.index_ajax', compact('roles'))->render(); 
	
    	}
		$roles=Role::paginate(10);
		return view('tm81_role::roles.index',compact('roles'));    
	}

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
		//$permissions = Permission::all();
		/*$this->authorize('create', Role::class);*/
		
		$table_names = DB::table('permissions')
		->select('table_name')
		->groupBy('table_name')
		->get();
		$table_name_str='table_name';	
		foreach($table_names as $table_name){
			$t_name='"'.$table_name->table_name.'"';
			if($t_name!=''){
			$table_name_str=$table_name_str.','.$t_name;
			}
		}
		//print_r($table_name_str);
		
		$permissions = DB::table('permissions')
		->select('id','key','table_name')
		//->orderByRaw('FIELD(table_name, "users ", "roles")')
		->orderByRaw('FIELD('.$table_name_str.')')
		->get();
		
		//$table_name_str = serialize($table_name);
		//print_r($permissions);
		
        return view('tm81_role::roles.create',compact('permissions','table_names'));    
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
		/*$this->authorize('create', Role::class);*/
		
    	$role=Role::create($request->all());
		//print_r($request->permissions);
		 $role_id = $role->id;
		
		if(!empty( $request->permissions)){
			foreach($request->permissions as $perm){
				
				DB::table('permission_role')->insert([
							'role_id' => $role_id,
							'permission_id' => $perm 
							]);			
				
				//Permission_role::create(['role_id' => $role_id , 'permission_id' => $perm ]);
			}
		}
		return redirect()->route('roles.index')->with(['message' => 'Role added successfully']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
		/*$this->authorize('view', Role::class);*/
        $role = Role::findOrFail($id);
		return view('tm81_role::roles.view', compact('role'));    
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
		/*$this->authorize('update', Role::class);*/
        $role = Role::findOrFail($id);
			foreach ($role->permissions as $permission) {
			$role_permission_array[] =$permission->id;
		}
		if(empty($role_permission_array)){
			$role_permission_array=array();
		}
		//print_r($role_permission_array);
		return view('tm81_role::roles.edit', compact('role','role_permission_array'));    
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
		/*$this->authorize('update', Role::class);*/
        $role = Role::findOrFail($id);
		$role->update($request->all());
		$role_id = $role->id;
		$Permission_role_old = DB::table('permission_role')->where('role_id', $id)->delete();
		//$Permission_role_old->delete();
		
		if(!empty( $request->permissions)){
			foreach($request->permissions as $perm){
				DB::table('permission_role')->insert([
							'role_id' => $role_id,
							'permission_id' => $perm 
							]);			
				
				//Permission_role::create(['id' => $perm,'role_id' => $id ]);
			}
		}
		return redirect()->route('roles.index')->with(['message' => 'Role updated successfully']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request,$id)
    {
		/*$this->authorize('delete', Role::class);*/
		//print_r( $request->all());
		$ids=$request->ids;
		$ids=explode(",",$ids);
		//print_r($ids);
		if($id==0){
			if(!empty($ids)){
				Role::destroy($ids);
				
				foreach($ids as $id){
					$Permission_role_old = DB::table('permission_role')->where('role_id', $id)->delete(); 
				}
			}
		}else{
			$role = Role::findOrFail($id);
			$role->delete();
			$Permission_role_old = DB::table('permission_role')->where('role_id', $id)->delete(); 
		}
/*		print_r($id);
		break;
		 if (is_array($id)) 
			{
				Role::destroy($id);
			}
			else
			{
				Role::findOrFail($id)->delete();
			}		
		
		
*/		
        return redirect()->route('roles.index')->with(['message' => 'Role deleted successfully']);
    }
}
