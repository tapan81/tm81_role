@extends('tm81_role::layouts.layout')

@section('title', 'Edit') {{-- For different pages you can change your title here --}} 
@section('body_content') {{--Put your middle content--}}

<!--********************************** Page wrapper********************************************* -->
<!--*****************************************Breadcrumb*****************************************************-->
<div class="row" style="margin-left: -13px;padding-top: 26px; ">
    <div class="col-lg-6" style="width: auto;">
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.index')}}">Dashbord</a></li>
            <li class="breadcrumb-item"><a href="{{ route('roles.index') }}">Role</a></li>
            <li class="breadcrumb-item active" aria-current="page">Edit</li>
          </ol>
        </nav>
    </div>
</div>
<!--*****************************************Page Title*****************************************************-->
<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header"  style="margin-top: 10px;">Edit Role</h1>
    </div>
    <!-- /.col-lg-12 -->
</div>

<div class="row">
    <div class="col-md-10">
        <div class="panel panel-default">
            <div class="panel-body">
                <div class="col-lg-12">
                    <form class="form-horizontal" method="post" action="{{ route('roles.update', $role->id) }}">
                        <input type="hidden" name="_method" value="PUT">
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                            <label for="name" >Name</label>
                            <input id="name" type="text" class="form-control" name="name" value="{{ $role->name }}"   autofocus>
                            @if ($errors->has('name'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('name') }}</strong>
                                </span>
                            @endif
                        </div>


                        <div class="form-group{{ $errors->has('display_name') ? ' has-error' : '' }}">
                            <label for="display_name" >Display Name</label>
                            <input id="display_name" type="text" class="form-control" name="display_name" value="{{ $role->display_name }}" required   autofocus>
                            @if ($errors->has('display_name'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('display_name') }}</strong>
                                </span>
                            @endif
                        </div>
                        
                        <div class="form-group">
                        <label for="permission">Permissions</label><br>
                        <a href="#" class="permission-select-all">Select All</a> / <a href="#"  class="permission-deselect-all">De-select All</a>
                        <ul class="permissions checkbox">
                            <?php
                                $role_permissions = (isset($dataTypeContent)) ? $dataTypeContent->permissions->pluck('key')->toArray() : [];
                                //print_r($role_permissions);
                            ?>
                            @foreach(tapanmandal81\tm81_role\Models\Permission::all()->groupBy('table_name') as $table => $permission)
                                <li>
                                    <input type="checkbox" id="{{$table}}" class="permission-group">
                                    <label for="{{$table}}"><strong>{{Illuminate\Support\Str::title(str_replace('_',' ', $table))}}</strong></label>
                                    <ul>
                                        @foreach($permission as $perm)
                                            <li>
                                                <input type="checkbox" id="permission-{{$perm->permission_id}}" name="permissions[]" class="the-permission" value="{{$perm->id}}" @if(in_array($perm->id, $role_permission_array)) checked @endif>
                                                <label for="permission-{{$perm->id}}">{{Illuminate\Support\Str::title(str_replace('_', ' ', $perm->key))}}</label>
                                            </li>
                                        @endforeach
                                    </ul>
                                </li>
                            @endforeach
                        </ul>
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
    </div>
</div>
<!--********************************** /# Page wrapper********************************************* -->
@endsection
@section('javascript')

    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script type="text/javascript">
        $('document').ready(function () {
			// alert("Settings page was loaded");
            $('.permission-group').on('change', function(){
				
                $(this).siblings('ul').find("input[type='checkbox']").prop('checked', this.checked);
            });

            $('.permission-select-all').on('click', function(){
                $('ul.permissions').find("input[type='checkbox']").prop('checked', true);
                return false;
            });

            $('.permission-deselect-all').on('click', function(){
                $('ul.permissions').find("input[type='checkbox']").prop('checked', false);
                return false;
            });

            function parentChecked(){
                $('.permission-group').each(function(){
                    var allChecked = true;
                    $(this).siblings('ul').find("input[type='checkbox']").each(function(){
                        if(!this.checked) allChecked = false;
                    });
                    $(this).prop('checked', allChecked);
                });
            }

            parentChecked();

            $('.the-permission').on('change', function(){
                parentChecked();
            });
        });
    </script>
@endsection
