<?php
/**
 * Email
 *
 */
Route::group(['namespace' => 'Backend', 'prefix' => 'admin', 'as' => 'admin.', 'middleware' => 'admin'], function () {
    
    Route::group( ['namespace' => 'Email'], function () {
        Route::resource('emails', 'EmailsController');
        //For Datatable
        Route::post('emails/get', 'EmailsTableController')->name('emails.get');
    });
    
});