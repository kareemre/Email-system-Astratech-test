<?php

use App\Http\Controllers\mails\CategoryController;
use App\Http\Controllers\mails\MailController;
use Illuminate\Support\Facades\Route;


//MailController routes
Route::controller(MailController::class)->group(function () {

    Route::get('/inbox',  'inbox')->name('inbox');

    Route::get('/outbox',  'outbox')->name('outbox');

    Route::get('/send-email',  'showSendEmailForm')->name('show.send.email');

    Route::get('/emails/{email}',  'showEmail')->name('emails.show');

    Route::post('/send-email',  'sendEmail')->name('send.email');

    Route::get('/reply-email/{email}',  'showReplyEmailForm')->name('show.reply.email');

    Route::post('/reply-email/{email}',  'replyEmail')->name('reply.email');

    Route::get('/forward-email/{email}',  'showForwardEmailForm')->name('show.forward.email');

    Route::post('/forward-email/{email}',  'forwardEmail')->name('forward.email');

    Route::post('/emails/{email}/categorize',  'categorizeEmail')->name('emails.categorize');
});


//CategoryController
Route::controller(CategoryController::class)->group(function () {

    Route::get('/categories', 'index')->name('categories.index');

    Route::post('/categories', 'store')->name('categories.store');

    Route::delete('/categories/{category}', 'destroy')->name('categories.destroy');
});
