<?php

Route::get('Admin2020',  function(){
    return redirect()->route('admin.login');
});

Route::group(['namespace' => 'Auth'], function(){
    # Login Routes
    Route::get('login',     'LoginController@showLoginForm')->name('login');
    Route::post('login',    'LoginController@login');
    Route::post('clear',    'LoginController@clear');
    Route::post('logout',   'LoginController@logout')->name('logout');

});

Route::group(['middleware' => 'auth:admin'],function (){

    # dashboard
    Route::get('/dashboard',                'DashboardController@index')->name('dashboard');



    # admin update password
    Route::get('change-password',           'DashboardController@changePassword')->name('change-password');
    Route::patch('update-password',         'DashboardController@updatePassword')->name('update-password');

    # Interest category
    Route::group(['prefix' => 'category', 'as' => 'category.'],function (){
        Route::get('/',                     'InterestCategoryController@index')->name('index');
        Route::post('store',                'InterestCategoryController@store')->name('store');
        Route::get('edit',                  'InterestCategoryController@edit')->name('edit');
        Route::post('update',               'InterestCategoryController@update')->name('update');
        Route::delete('delete',             'InterestCategoryController@delete')->name('delete');
        Route::patch('change-status',       'InterestCategoryController@changeStatus')->name('change_status');
    });


     #Sub Interest category
    Route::group(['prefix' => 'subcategory', 'as' => 'subcategory.'],function (){
        Route::get('/',                     'SubInterestCategoryController@index')->name('index');
        Route::post('store',                'SubInterestCategoryController@store')->name('store');
        Route::get('edit',                  'SubInterestCategoryController@edit')->name('edit');
        Route::post('update',               'SubInterestCategoryController@update')->name('update');
        Route::delete('delete',             'SubInterestCategoryController@delete')->name('delete');
        Route::patch('change-status',       'SubInterestCategoryController@changeStatus')->name('change_status');
        Route::get('getSubcategories',      'SubInterestCategoryController@getSubcategories')->name('getSubcategories');
    });

    #Color Pallets 
    Route::group(['prefix' => 'color', 'as' => 'color.'],function (){
        Route::get('/',                     'ColorPaletteController@index')->name('index');
        Route::post('store',                'ColorPaletteController@store')->name('store');
        Route::get('edit',                  'ColorPaletteController@edit')->name('edit');
        Route::post('update',               'ColorPaletteController@update')->name('update');
        Route::delete('delete',               'ColorPaletteController@delete')->name('delete');
        Route::patch('change-status',       'ColorPaletteController@changeStatus')->name('change_status');
    });

    #Users 
    Route::group(['prefix' => 'users', 'as' => 'users.'],function (){
        Route::get('/',                     'UserController@index')->name('index');
        Route::post('store',                'UserController@store')->name('store');
        Route::get('edit/{id}',                  'UserController@edit')->name('edit');
        Route::get('usergroup/{id}',                  'UserController@usergroup')->name('usergroup');
        Route::post('update',               'UserController@update')->name('update');
        Route::delete('delete',               'UserController@delete')->name('delete');
        Route::patch('change-status',       'UserController@changeStatus')->name('change_status');
        Route::get('getGroup',       'UserController@getGroup')->name('getGroup');
    });


    #Polls  
    Route::group(['prefix' => 'poll', 'as' => 'poll.'],function (){
        Route::get('/',                     'PollController@index')->name('index');
        Route::post('store',                'PollController@store')->name('store');
        Route::get('edit/{id}',                  'PollController@edit')->name('edit');
        Route::get('view/{id}',                  'PollController@view')->name('view');
        Route::post('update',               'PollController@update')->name('update');
        Route::delete('delete',               'PollController@delete')->name('delete');
        Route::patch('change-status',       'PollController@changeStatus')->name('change_status');
        Route::post('endPoll',       'PollController@endPoll')->name('endPoll');
    });
    Route::post('upload_file', 'PollController@uploadFile')->name('upload_file');

    #Polls  
    Route::group(['prefix' => 'notification', 'as' => 'notification.'],function (){
        Route::get('/',                     'NotificationController@index')->name('index');
        Route::post('store',                'NotificationController@store')->name('store');
        Route::get('edit',                  'NotificationController@edit')->name('edit');
        Route::post('update',               'NotificationController@update')->name('update');
        Route::delete('delete',             'NotificationController@delete')->name('delete');
        Route::patch('send-push',       'NotificationController@sendPush')->name('send_push');
    });

    # FAQ
    Route::patch('faq/change-status',        'FaqController@changeStatus')->name('faq.change-status');
    Route::post('faq/delete',               'FaqController@delete')->name('faq.delete');
    Route::post('faq/bulk-delete',          'FaqController@bulkDelete')->name('faq.bulk-delete');
    Route::resource('faq',                  'FaqController');

    Route::group(['prefix' => 'contactus', 'as' => 'contactus.'],function (){
        Route::get('/',                     'ContactUsController@index')->name('index');
    });
});

?>
