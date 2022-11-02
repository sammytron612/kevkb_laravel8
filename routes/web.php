<?php

use Illuminate\Support\Facades\Route;

Route::get('/','ArticlesController@index')->name('home')->middleware('auth','otp');

Auth::routes();

Route::get('/home', 'ArticlesController@index')->name('home')->middleware('auth','otp');

Route::get('/attachments/download/{attachment}', [ 'as' => 'attachments.download', 'uses' => 'AttachmentsController@download'])->middleware('auth','otp');
Route::post('/attachments/delete_attach', [ 'as' => 'attachments.delete_attach', 'uses' => 'AttachmentsController@delete_attach'])->middleware('auth','otp');

Route::resource('/articles', 'ArticlesController')->except(['index','destroy'])->middleware('auth','otp');
Route::delete('/delete_article/{id}', [ 'as' => 'articles.destroy', 'uses' =>'ArticlesController@destroy'])->middleware('auth','otp');
Route::any('articles_index/{sectionid?}',  [ 'as' => 'articles.index', 'uses' =>'ArticlesController@index'])->middleware('auth','otp');
Route::post('articles/ratingset',  [ 'as' => 'articles.ratingset', 'uses' =>'ArticlesController@rating_set'])->middleware('auth','otp');

Route::post('comments/addComment',  [ 'as' => 'comments.addComment', 'uses' =>'CommentsController@addComment'])->middleware('auth','otp');
Route::get('comments/viewComments',  [ 'as' => 'comments.viewComments', 'uses' =>'CommentsController@viewComments'])->middleware('auth','otp');

Route::get('/sections', [ 'as' => 'sections.index', 'uses' => 'SectionsController@index'])->middleware('auth','otp');
Route::get('/sections/edit/{id}', [ 'as' => 'sections.edit', 'uses' => 'SectionsController@edit'])->middleware('auth','otp');
Route::get('/sections/delete/{id}', [ 'as' => 'sections.delete', 'uses' => 'SectionsController@delete'])->middleware('admin');
Route::post('/sections/destroy', [ 'as' => 'sections.destroy', 'uses' => 'SectionsController@destroy'])->middleware('admin');
Route::get('/sections/create', [ 'as' => 'sections.create', 'uses' => 'SectionsController@create'])->middleware('auth','otp');
Route::post('/sections/update/{id}', [ 'as' => 'sections.update', 'uses' => 'SectionsController@update'])->middleware('auth','otp');
Route::post('/sections/store', [ 'as' => 'sections.store', 'uses' => 'SectionsController@store'])->middleware('auth','otp');

Route::post('/searches/search', [ 'as' => 'searches.search', 'uses' => 'SearchesController@search'])->middleware('auth','otp');
Route::get('/searches/index', [ 'as' => 'searches.index', 'uses' => 'SearchesController@index'])->middleware('auth','otp');
Route::delete('/searches/delete/{id}','SearchesController@destroy')->middleware('auth','otp');

Route::post('/image/upload', [ 'as' => 'image.upload', 'uses' => 'ImagesController@upload'])->middleware('auth','otp');

Route::get('/alter/{id}', [ 'as' => 'alter.alter', 'uses' => 'AlterController@alter'])->middleware('auth','otp');

Route::get('/admin', [ 'as' => 'admin.index', 'uses' => 'AdminController@index'])->middleware('admin');
Route::get('/admin/usermanagement', [ 'as' => 'admin.usermanagement', 'uses' => 'AdminController@userManagement'])->middleware('admin');
Route::get('/admin/approvals', [ 'as' => 'admin.approvals', 'uses' => 'AdminController@approvals'])->middleware('admin');
Route::get('/admin/approval_show/{id}', [ 'as' => 'admin.approval_show', 'uses' => 'AdminController@approval_show'])->middleware('admin');
Route::post('/admin/approval_update/{id}', [ 'as' => 'admin.approval_update', 'uses' => 'AdminController@approval_update'])->middleware('admin');
Route::get('/admin/invites', [ 'as' => 'admin.invites', 'uses' => 'AdminController@invites'])->middleware('admin');
Route::post('/admin/rejection', [ 'as' => 'admin.rejection', 'uses' => 'AdminController@rejection'])->middleware('admin');
Route::get('/admin/edit_user/{id}', [ 'as' => 'admin.edit_user', 'uses' => 'AdminController@edit_user'])->middleware('admin');
Route::post('/admin/update_user/{id}', [ 'as' => 'admin.update_user', 'uses' => 'AdminController@update_user'])->middleware('admin');
Route::get('/admin/stats', [ 'as' => 'admin.stats', 'uses' => 'StatsController@index'])->middleware('admin');
Route::get('/admin/stats_get/{query}', [ 'as' => 'admin.stats_get', 'uses' => 'StatsController@stats_get'])->middleware('admin');
Route::get('stats_get/{query}', [ 'as' => 'admin.stats_get', 'uses' => 'StatsController@stats_get'])->middleware('auth','otp');

Route::post('email', [ 'as' => 'email', 'uses' => 'EmailController@email_invite'])->middleware('auth','otp');
Route::post('email/article', [ 'as' => 'email.article', 'uses' => 'EmailController@email_article'])->middleware('auth','otp');


Route::get('/registeruser/{user}', 'Auth\RegisterController@registration_form')->name('registeruser')->middleware('signed');
Route::get('/email_article/{id}', 'SignedViewController@view')->name('email_article')->middleware('signed');
Route::get('/signed/download/{attachment}', [ 'as' => 'signed.download', 'uses' => 'SignedViewController@download'])->middleware('signed');

Route::get('/settings' , [ 'as' => 'settings.index', 'uses' => 'SettingsController@index'])->middleware('auth','otp');
Route::post('/settings/update' , [ 'as' => 'settings.update', 'uses' => 'SettingsController@update'])->middleware('admin');
Route::get('/settings/all' , [ 'as' => 'settings.all', 'uses' => 'SettingsController@getAll'])->middleware('auth','otp');

Route::get('/drafts', [ 'as' => 'drafts.index', 'uses' => 'DraftsController@index'])->middleware('auth','otp');
Route::get('/drafts/edit/{id}', [ 'as' => 'drafts.edit', 'uses' => 'DraftsController@edit'])->middleware('auth','otp');
Route::delete('/drafts/delete/{id}', [ 'as' => 'drafts.destroy', 'uses' => 'DraftsController@destroy'])->middleware('auth','otp');

Route::resource('/snow', 'SnowController')->middleware('admin');
Route::get('snow_group/search', ['as' => 'snow_group.search', 'uses' => 'SnowSearchController@search'])->middleware('auth','otp');
Route::post('snow_group/results', ['as' => 'snow_group.results', 'uses' => 'SnowSearchController@results'])->middleware('auth','otp');


Route::get('notifications/index/{id?}', ['as' => 'notifications.index', 'uses' => 'NotificationsController@index'])->middleware('auth','otp');
Route::post('notifications/checkbox', ['as' => 'notifications.checkbox', 'uses' => 'NotificationsController@checkbox'])->middleware('auth','otp');
Route::post('notifications/delete', ['as' => 'notifications.delete', 'uses' => 'NotificationsController@delete'])->middleware('auth','otp');
Route::get('notifications/show', ['as' => 'notifications.show', 'uses' => 'NotificationsController@show'])->middleware('auth','otp');
Route::get('notifications/create', ['as' => 'notifications.create', 'uses' => 'NotificationsController@create'])->middleware('admin');
Route::post('notifications/send', ['as' => 'notifications.send', 'uses' => 'NotificationsController@send'])->middleware('admin');

Route::post('stealth/change', ['as' => 'stealth.change', 'uses' => 'StealthController@change'])->middleware('admin');

Route::get('/profile', ['as' => 'profile.index', 'uses' => 'ProfileController@index'])->middleware('auth','otp');
Route::post('/profile/update', ['as' => 'profile.update', 'uses' => 'ProfileController@update'])->middleware('admin');

Route::post('/save-token', 'ProfileController@saveToken')->name('saveToken');
Route::post('/delete-token', 'ProfileController@deleteToken')->name('deleteToken');
Route::post('/send-notification', 'ProfileController@sendFCMNotification')->name('sendFCMNotification');

Route::get('/otp', 'OTPController@index')->name('otp')->middleware('auth');
Route::post('/otp-auth', 'OTPController@auth')->name('otp-auth')->middleware('auth');
Route::get('/send-otp', 'OTPController@resendOTP')->name('send-otp')->middleware('auth','otp');

////////////// kb front /////////////////

Route::get('/kb-front', function (){
    return view('front.index');
})->middleware('kbFront')->middleware('kbFront');

Route::get('/kb-front/show', 'kbFrontController@show')->name('kb-front.show')->middleware('kbFront');