<?php

namespace tapanmandal81\tm81_role\Http\Controllers;
use Auth;
use tapanmandal81\tm81_role\Models\User;///added extra
use tapanmandal81\tm81_role\Models\Role;
use DB;
use tapanmandal81\tm81_role\Models\Role_user;
use tapanmandal81\tm81_role\Models\User_meta;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
		/*$this->authorize('browse', User::class);*/
		$no_of_entries = $request->entries;	
		$s_key = $request->s_key;
			
		if($request->ajax()){
			$users = User::where('name','LIKE','%'.$s_key.'%')
					->orderBy('name')
					->paginate($no_of_entries);
				   
		   return view('tm81_role::users.index_ajax', compact('users'))->render(); 
	
    	}
		$users=User::orderBy('name')->paginate(10);
		return view('tm81_role::users.index',compact('users'));    
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
		$roles=Role::All();

         return view('tm81_role::users.create',compact('roles'));    
       //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

	  $request->validate([
				'name' => 'required|string|max:255',
				'email' => 'required|string|email|max:255|unique:users',
				'role_id' => 'required',
				'password' => 'required|string|min:1|confirmed',
		]);

		//print_r( $request->all());

        $user= User::create($request->has('password') ? array_merge($request->except('password'), ['password' => bcrypt($request->input('password'))]) : $request->except('password'));
		$user_id = $user->id;

		DB::table('role_user')->insert([
				'role_id' =>$request['role_id'],
				'user_id' => $user_id,
				]);
				

		$a_d=$request->all();
		//print_r( $a_d);
		unset($a_d['_token'],$a_d['name'],$a_d['email'],$a_d['role_id'],$a_d['password'],$a_d['password_confirmation']);
		print_r( $a_d);
		foreach($a_d as $k=>$v){
			User_meta::create([
				'user_id' => $user_id,
				'meta_key' =>$k,
				'meta_value' => $v,
				]);		
			
/*			DB::table('user_meta')->insert([
				'user_id' => $user_id,
				'meta_key' =>$k,
				'meta_value' => $v,
				"created_at" =>  \Carbon\Carbon::now(), # new \Datetime()
            	"updated_at" => \Carbon\Carbon::now(),  # new \Datetime()				
				]);
*/		}

		return redirect()->route('users.index')->with(['message' => 'User added successfully']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
		/*$this->authorize('view', User::class);*/
        $user = User::findOrFail($id);
		//$user = App\User::find(1);
		foreach ($user->roles as $role) {
			$user_role = $role;
		}
		$user_metas = $user->user_meta;		
/*		foreach($user_metas as $meta){
			echo $meta->meta_value;
		};
*/		
		
		return view('tm81_role::users.view', compact('user','user_role','user_metas'));    
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
		//$this->authorize('update', User::class);
		
        $user = User::findOrFail($id);
		foreach ($user->roles as $role) {
			$user_role = $role;
		}
		$user_role_id=$user_role->id;
		$roles=Role::All();
		$user_metas = $user->user_meta;	
        return view('tm81_role::users.edit',compact('user','roles','user_role_id','user_metas'));    
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
		//Validation
	  	$request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,'.$id,
            'password' => 'confirmed',
		]);
		
		//update User
        $user = User::findOrFail($id);
		$user->update($request->has('password') ? array_merge($request->except('password'), ['password' => bcrypt($request->input('password'))]) : $request->except('password'));
		
		//update role_id
		$role_user=DB::table('role_user')->where('user_id', $id)->update(['role_id' => $request['role_id']]);

		//update meta value
		$a_d=$request->all();
		unset($a_d['_method'],$a_d['_token'],$a_d['id'],$a_d['name'],$a_d['email'],$a_d['role_id'],$a_d['password'],$a_d['password_confirmation']);
		foreach($a_d as $k=>$v){
			User_meta::firstOrCreate([
				'user_id' => $id,
				'meta_key' =>$k,
				]);		

			//echo $k;
			$Usermeta = User_meta::where('user_id','=',$id)
						->where('meta_key','=',$k)
						->first();
			$Usermeta->update([
				'meta_value' => $v,
				]);		
		}



		return redirect()->route('users.index')->with(['message' => 'User updated successfully']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request,$id)
    {
		/*$this->authorize('delete', User::class);*/
		$ids=$request->ids;
		$ids=explode(",",$ids);
		print_r($ids);
		if($id==0){
			if(!empty($ids)){
				User::destroy($ids);
				foreach($ids as $id){
					DB::table('role_user')->where('user_id', $id)->delete();
					User_meta::where('user_id', $id)->delete();
				}
        		return redirect()->route('users.index')->with(['message' => 'All Users deleted successfully.']);
				
			}
		}else{
			$user = User::findOrFail($id);
			$user->delete();
			DB::table('role_user')->where('user_id', $id)->delete();
			User_meta::where('user_id', $id)->delete();
        	return redirect()->route('users.index')->with(['message' => 'User deleted successfully.']);
		}
    }
}
