@extends('tm81_role::layouts.layout')
@section('title', 'Add New') {{-- For different pages you can change your title here --}} 
@section('body_content') {{--Put your middle content--}}

<!--********************************** Page wrapper********************************************* -->
<!--***********Breadcrumb*****************************************************-->
<div class="row" style="margin-left: -13px;padding-top: 26px; ">
    <div class="col-lg-6" style="width: auto;">
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.index')}}">Dashbord</a></li>
            <li class="breadcrumb-item"><a href="{{ route('users.index') }}">User</a></li>
            <li class="breadcrumb-item active" aria-current="page">Create</li>
          </ol>
        </nav>
    </div>
</div>
<!--***********Page Title***********************************-->
<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">Add New User</h1>
    </div>
    <!-- /.col-lg-12 -->
</div>
<!--***********Body Section*************************-->

<div class="row">
    <div class="panel-body">
        <div class="col-lg-12 user_create">
            <form class="form-horizontal" method="POST" action="{{ route('users.store') }}">
                {{ csrf_field() }}

                <!--*****************Name*****************************-->
                <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                    <label for="name" >Name*</label>
                    <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}"   autofocus>
                    @if ($errors->has('name'))
                        <span class="help-block">
                            <strong>{{ $errors->first('name') }}</strong>
                        </span>
                    @endif
                </div>
                

                <!--*****************E-Mail Id*****************************-->
                 <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                    <label for="email" >E-Mail Id*</label>
                    <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" >

                    @if ($errors->has('email'))
                        <span class="help-block">
                            <strong>{{ $errors->first('email') }}</strong>
                        </span>
                    @endif
                </div>

                <!--***************** Role *****************************-->
                <div class="form-group{{ $errors->has('role_id') ? ' has-error' : '' }}">
                    <label>Select Role*</label>
                    <select name="role_id" id="role_id" class="form-control" >
                        <option value="">Select Role</option>
                        @forelse($roles as $role)
                            @if($role->id == old('role_id'))
                                {{ $selected='selected="selected"'}}
                            @else
                                {{ $selected=''}}
                            @endif
                            <option {{ $selected }} value="{{ $role->id }}">{{ $role->name }}</option>
                        @empty
                        <option value="">No Recors Found.</option>
                        @endforelse
                    </select>
                    @if ($errors->has('role_id'))
                        <span class="help-block">
                            <strong>{{ $errors->first('role_id') }}</strong>
                        </span>
                    @endif
                </div>
                
                <!--*********** Section Start for extra fields************-->
                @php 
                  $extra_fields_array[]='User_Mobile_Number';
                  $extra_fields_array[]='User_Current_Address'; 
                  //print_r($extra_fields_array);
                  $extra_fields_array=Config::get('tm81_role-extra_user_fields.extra_fields_array');
                @endphp
                
                @foreach($extra_fields_array as $field)
                <div class="form-group">
                    <label for="name" >{{ str_replace('_',' ', $field)  }}</label>
                    <input type="text" class="form-control" name="{{ $field }}" value="{{ old($field) }}" >
                </div>
                @endforeach
                <!--*********** Section End for extra fields************-->
                
                
                <!--***************** Password *****************************-->
                <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                    <label for="password">Password*</label>
                    <input id="password" type="password" class="form-control" name="password" >

                    @if ($errors->has('password'))
                        <span class="help-block">
                            <strong>{{ $errors->first('password') }}</strong>
                        </span>
                    @endif
                </div>
    
                <!--***************** Confirm Password *****************************-->
                <div class="form-group">
                    <label for="password-confirm">Confirm Password*</label>
                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation" >
                </div>

             
                <!--***************** Confirm Password *****************************-->
                <div class="form-group">
                    <div class="col-md-6 ">
                        <button type="submit" class="btn btn-primary">
                            Add
                        </button>
                    </div>
                </div>
                
                <!--***************** End Fields *****************************-->
                
                
            </form>
        </div>
    </div>
</div>
<!--********************************** /# Page wrapper********************************************* -->
@endsection
