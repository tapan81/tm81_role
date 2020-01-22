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
            <li class="breadcrumb-item"><a href="{{ route('roles.index') }}">Role</a></li>
            <li class="breadcrumb-item active" aria-current="page">View</li>
          </ol>
        </nav>
    </div>
</div>
<!--*****************************************Page Title*****************************************************-->
<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header"  style="margin-top: 10px;">Role</h1>
    </div>
    <!-- /.col-lg-12 -->
</div>

<div class="row">
    <div class="col-md-8">
        <div class="panel panel-default">
            <div class="panel-body">
                <div class="col-lg-12">
                    <div class="form-group">
                        <label for="name" >Name:</label> {{ $role->name }}
                    </div>
                     <div class="form-group">
                        <label for="name" >Display Name:</label> {{ $role->display_name }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--********************************** /# Page wrapper********************************************* -->
@endsection
@section('javascript')

    <script src={{ url('AdminAsset/vendor/jquery/jquery.min.js') }}></script>
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
