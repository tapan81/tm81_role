<?php
// MyVendor\contactform\src\routes\web.php
/*Route::get('contact', function(){
	return 'Hello from the contact form package';
});
*/

// MyVendor\contactform\src\routes\web.php
/*Route::get('contact', function(){
	return view('contactform::contact');
});

Route::post('contact', function(){
	// logic goes here
})->name('contact');	
*/

// MyVendor\contactform\src\routes\web.php
    Route::group(['namespace' => 'tapanmandal81\tm81_role\Http\Controllers', 'middleware' => ['web']], function(){
		Route::resource('/admin/users','UserController');		
		Route::resource('/admin/roles','RoleController');
    });