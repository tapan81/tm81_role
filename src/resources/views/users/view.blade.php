@extends('tm81_role::layouts.layout')
@section('title', 'View') {{-- For different pages you can change your title here --}} 
@section('body_content') {{--Put your middle content--}}

<!--********************************** Page wrapper********************************************* -->
<!--*****************************************Breadcrumb*****************************************************-->
<div class="row" style="margin-left: -13px;padding-top: 26px; ">
    <div class="col-lg-6" style="width: auto;">
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.index')}}">Dashbord</a></li>
            <li class="breadcrumb-item"><a href="{{ route('users.index') }}">User</a></li>
            <li class="breadcrumb-item active" aria-current="page">View</li>
          </ol>
        </nav>
    </div>
</div>
<!--*****************************************Page Title*****************************************************-->


<div class="row">
    <div class="panel-body">
        <div class="col-lg-12 user_view">
            <div class="form-group">
                <label for="name" >Name :</label>  {{ $user->name }}
            </div>
             
             <div class="form-group">
                <label for="name" >Email Id :</label>  {{ $user->email }}
            </div>
            <div class="form-group">
                <label for="name" >Role :</label>  {{$user_role->display_name }}
            </div>
        
            <!--*********** Section Start for extra fields************-->
            @foreach($user_metas as $field)
            <div class="form-group">
                <label for="name" >{{ str_replace('_',' ', $field->meta_key)  }} :</label>  {{ str_replace('_',' ', $field->meta_value)  }}
            </div>
            @endforeach
            <!--*********** Section End for extra fields************-->
        
        
        </div>
    </div>
</div>
<!--********************************** /# Page wrapper********************************************* -->
@endsection
