<?php

use App\Http\Controllers\mails\CategoryController;
use App\Http\Controllers\mails\MailController;
use Illuminate\Support\Facades\Route;

Route::get('/inbox', [MailController::class, 'inbox'])->name('inbox');
Route::get('/outbox', [MailController::class, 'outbox'])->name('outbox');

Route::get('/send-email', [MailController::class, 'showSendEmailForm'])->name('show.send.email');
Route::post('/send-email', [MailController::class, 'sendEmail'])->name('send.email');

Route::get('/reply-email/{email}', [MailController::class, 'showReplyEmailForm'])->name('show.reply.email');
Route::post('/reply-email/{email}', [MailController::class, 'replyEmail'])->name('reply.email');

Route::get('/forward-email/{email}', [MailController::class, 'showForwardEmailForm'])->name('show.forward.email');
Route::post('/forward-email/{email}', [MailController::class, 'forwardEmail'])->name('forward.email');

Route::resource('categories', CategoryController::class);
