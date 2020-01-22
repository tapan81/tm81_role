@extends('tm81_role::layouts.layout')
@section('title', 'Users') {{-- For different pages you can change your title here --}} 
@section('body_content') {{--Put your middle content--}}
<!--********************************** Page wrapper********************************************* -->
<!--************Page Title*****************************************************-->
<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header"><i class="glyphicon glyphicon-user"></i>Users
        <span style=" margin-left:20px"><button onclick="window.location.href='{{ route('users.create') }}'" type="button" class="btn btn-success fa fa-plus" style="font-size:17px;"> Add New</button></span>
        <span style=" margin-left:10px">
            <form action="{{ route('users.destroy', 0) }}" method="POST" style="display: inline" onsubmit="return confirm('Are you sure for Bulk Delete?');">
                <input type="hidden" name="ids" id="ids_array" value="">
                <input type="hidden" name="_method" value="DELETE">
                {{ csrf_field() }}
                <button class="btn btn-danger fa fa-trash-o" onclick="return check_selection()" style="font-size:17px;"> Bulk Delete</button>
            </form>

         </span>
        </h1>
        
    </div>
</div>

 <!--***********Search Section*************************-->
 <div class="row">
    <div class="col-lg-12" >
         <div class="row">
            <div class="col-lg-4" >
                <div class="form-group">
                        <label>Show Entries</label>
                        <select name="no_of_entries" id="no_of_entries" class="form-control" onchange="search_entries()" required>
<!--                                <option value="2">2</option>
                            <option value="5">5</option>
-->                                <option value="10">10</option>
                            <option value="25">25</option>
                            <option value="50">50</option>
                            <option value="100">100</option>
                        </select>
                </div>
            </div>
            <div class="col-lg-4 col-md-offset-4" >
                <div class="form-group">
                   <label> Search </label>
                    <input type="text" class="form-control" id="search_key"  name="search_key" onkeyup="search_entries()" value=""   autofocus>
                </div>
            </div>
         </div>   	
 
    </div>
 </div>   	

 <!--***********Message Section*************************-->
 <div class="row">
    <div class="col-lg-12 " >
        @if (session('message'))
            <div class="alert alert-info">{{ session('message') }}</div>
        @endif                        
 
    </div>
 </div>   	

<!--***********Body Section*************************-->
     
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">User</div>
            <!-- /.panel-heading -->
            <div class="panel-body">
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th width="3%" height="26">#</th>
                                <th width="3%" ><input type="checkbox" name="check_all" id="check_all" class="check_all"  ></th>
                                <th width="20%">Name</th>
                                <th width="25%">Email</th>
                               <th width="35%">Action</th>
                            </tr>
                        </thead>
                        <tbody id='tbody' >
                            @if (count($users) > 0)
                                <section class="articles">
                                    @include('tm81_role::users.index_ajax')
                                </section>
                            @endif
                       </tbody>
                    </table>
                </div>
                <!-- /.table-responsive -->
            </div>
            <!-- /.panel-body -->
        </div>
        <!-- /.panel -->
    </div>
    <!-- /.col-lg-6 -->
</div>
    
<!--********************************** /# Page wrapper********************************************* -->
@endsection
@section('javascript')

    <script src={{ url('AdminAsset/vendor/jquery/jquery.min.js') }}></script>
    <script type="text/javascript">
	
	function search_entries(){
		
		$('#tbody').append('<img style="position: absolute;  left: 200px; top: 0px; z-index: 100000;" src="../AdminAsset/images/loading.gif" />');
		var entries;
		var s_key;
		entries=document.getElementById("no_of_entries").value
		s_key=document.getElementById("search_key").value
		const tableBody = document.getElementById('tbody');
		var currentURL = window.location.href;
		//alert(currentURL);
  		//location.href = "{{  route('roles.index', "+ entries +") }}";
		$.ajax({
			type: "GET",
			url: currentURL,
			data: {
					"_token": "{{ csrf_token() }}",
					"entries": entries,
					"s_key": s_key
					},
			success: function(response)
			{
				
			   tableBody.innerHTML = response; 
			   //console.log(response);
			}
		});
	}

	$('body').on('click', '.pagination a', function(e) {
		e.preventDefault();

		//alert('jhkh');
		var url = $(this).attr('href');
		//getArticles(url);
		window.history.pushState("", "", url);
		search_entries()
   });
			
			
	$('#check_all').on('click', function(e) {
		 if($(this).is(':checked',true))  
		 {
			$(".checkbox").prop('checked', true);  
		 } else {  
			$(".checkbox").prop('checked',false);  
		 }  
	});
	
	$('.checkbox').on('click',function(){
		if($('.checkbox:checked').length == $('.checkbox').length){
			$('#check_all').prop('checked',true);
		}else{
			$('#check_all').prop('checked',false);
		}
	});

	
	function check_selection(){
		if($(".checkbox").is(':checked',true)){
			
 			var selchbox = [];
			var inpfields = document.getElementsByClassName('checkbox')
			//var inpfields = document.getElementsByName('ids')
			//var inpfields = document.getElementsByTagName('input');	
			//alert(inpfields);		
			 for(var i=0; i<inpfields.length; i++){
			 if(inpfields[i].type =='checkbox' && inpfields[i].checked == true) selchbox.push(inpfields[i].value);
			 }
			 //selchbox.toString();
			 document.getElementById('ids_array').value  = selchbox ;
 			//alert(selchbox);
			//console.log(selchbox);
			return true;
		}else {
			alert("Please check atleast one checkbox.");
			return false;
		}
	}

    </script>
@endsection



