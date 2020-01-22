@extends('tm81_role::layouts.layout')
@section('title', 'Edit') {{-- For different pages you can change your title here --}} 
@section('body_content') {{--Put your middle content--}}

<div id="page-wrapper" class="page_min_height">
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
            <h1 class="page-header">Edit user</h1>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!--***********Body Section*************************-->

    <div class="row">
        <div class="panel-body">
            <div class="col-lg-12 user_create">
                <form class="form-horizontal" method="post" action="{{ route('users.update', $user->id) }}">
                             <input type="hidden" name="_method" value="PUT">
                   {{ csrf_field() }}

                    <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                        <label for="name">Name*</label>
                        <input id="name" type="text" class="form-control" name="name" value="{{ $user->name }}" required autofocus>

                        @if ($errors->has('name'))
                            <span class="help-block">
                                <strong>{{ $errors->first('name') }}</strong>
                            </span>
                        @endif
                    </div>
                     

                    <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                        <label for="email" >E-Mail Id*</label>
                        <input id="email" type="email" class="form-control" name="email" value="{{ $user->email }}"  required>
                        <input id="id" type="hidden"  name="id" value="{{ $user->id }}" >

                        @if ($errors->has('email'))
                            <span class="help-block">
                                <strong>{{ $errors->first('email') }}</strong>
                            </span>
                        @endif
                    </div>

                    
                    <div class="form-group{{ $errors->has('role_id') ? ' has-error' : '' }}">
                        <label>User Role</label>
                        <select name="role_id" id="role_id" class="form-control"    required>
                            @forelse($roles as $role)
                                @if ($role->id == $user_role_id)
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
                    @foreach($user_metas as $field)
                   	<div class="form-group">
                        <label for="name" >{{ str_replace('_',' ', $field->meta_key)  }}</label>
                        <input type="text" class="form-control" name="{{ $field->meta_key }}" value="{{ $field->meta_value }}" >
                    </div>
                    @endforeach
					<!--*********** Section End for extra fields************-->


                    <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                        <label for="password">Password</label>
                        <input id="password" type="password" class="form-control" name="password" >

                        @if ($errors->has('password'))
                            <span class="help-block">
                                <strong>{{ $errors->first('password') }}</strong>
                            </span>
                        @endif
                    </div>

                    <div class="form-group">
                        <label for="password-confirm" >Confirm Password</label>
                        <input id="password-confirm" type="password" class="form-control" name="password_confirmation" >
                    </div>


                    

                    <div class="form-group">
                        <div class="col-md-6">
                            <button type="submit" class="btn btn-primary">
                                Update
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
<!--********************************** /# Page wrapper********************************************* -->
</div>
@endsection
