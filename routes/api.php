<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(['middleware' => ['decrypt_req','XSS']], function ($router) {

    //user module
    Route::post('registration','UserController@registration');
    Route::post('guest','UserController@Guest');
    Route::post('social-login','UserController@socialLogin');
    Route::post('login','UserController@login');
    Route::post('forgot-password','UserController@forgotPassword');
    Route::post('verify-otp','UserController@verifyOtp');
    Route::get('resend-otp','UserController@resendOtp');
    Route::post('reset-password','UserController@resetPassword');
    //end user module

    //categoey module
    Route::get('category-list','CommanController@categoryList');
    Route::get('sub-category-list','CommanController@subCategoryList');
    //end category module

    Route::middleware('auth:api')->group(function () {

        //user auth old
        Route::get('logout','UserController@logout');

        // Route::middleware('is_user_verify')->group(function () {
        Route::post('upload_file', 'CommanController@uploadFile');
        Route::get('get-profile','UserController@getProfile');
        Route::post('update-profile','UserController@updateProfile');
        Route::post('change-password','UserController@changePassword');
        Route::get('my-intreset','UserController@myInterest');
        Route::put('my-intreset','UserController@updateMyInterest');

        //address book
        Route::post('create-address-book','AddressBookController@create');
        Route::get('my-address-book','AddressBookController@myAddressBook');
        Route::delete('delete-address-book','AddressBookController@deleteAddressBook');
        Route::get('search-user','AddressBookController@searchUser');
        //end address book

        //address group
        Route::post('create-address-group','GroupController@create');
        Route::get('my-address-group','GroupController@myGroup');
        Route::post('group-details','GroupController@groupDetails');
        Route::put('edit-group','GroupController@editGroup');
        Route::delete('delete-group','GroupController@deleteGroup');
        Route::post('add-group-members','GroupController@addGroupMembers');
        Route::delete('delete-group-member','GroupController@deleteGroupmember');
        //end address group

        //follower - following
        Route::post('follow-unfollow','FollowerFollowingController@followUnfollow');
        Route::get('follower-list','FollowerFollowingController@followerList');
        Route::get('following-list','FollowerFollowingController@followingList');
        //end follower - following

        //contact us
        Route::post('create-contact-us','ContactUsController@create');
        Route::get('my-contact-us','ContactUsController@myContactUs');
        //end contact us

        //poll
        Route::post('poll','PollController@create');
        Route::get('poll','PollController@get');
        Route::get('polls','PollController@list');
        Route::get('pollDetails','PollController@pollDetails');
        Route::put('poll','PollController@updatePoll');
        Route::put('setDuration','PollController@setDuration');

        //poll vote
        Route::post('poll-vote','PollController@pollVote');
        Route::post('poll-comment','PollController@CommnetOnPoll');
        Route::get('poll-comment','PollController@getPollCommnet');
        Route::get('recent-poll','PollController@getRecentPoll');
        Route::get('poll-result','PollController@getPollResult');
        Route::patch('poll','PollController@endPoll');
        Route::delete('poll','PollController@deletePoll');


        //end poll
        Route::get('activity','CommanController@getActivity');
        Route::get('notification','CommanController@getNotification');

        Route::post('poll-invite','PollController@pollInvite');
        Route::get('poll-invited-users','PollController@getPollInvitedUsers');
        Route::post('repoll','PollController@Repoll');
        // });

        
        // Common Apis 
        Route::get('country-list','CommanController@countryList');
        Route::get('state-list','CommanController@stateList');
        Route::get('city-list','CommanController@cityList');

        //color palette
        Route::get('color-palette-list','CommanController@colorPaletteList');
        //end color palette
        
        //Report Abuse
        Route::post('reportAbuse','CommanController@reportAbuse');
        Route::get('reportAbuseCategory','CommanController@getReportAbuseCat');
    });

});