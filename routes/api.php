<?php

use app\Route;

use controllers\api\TicketController;

Route::get('/',[new TicketController(), 'index']);
Route::post('/ticket/check',[new TicketController(), 'check']);
Route::post('/ticket/update',[new TicketController(), 'update']);

Route::go();
