<?php

use App\Models\User;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::livewire('/users', 'users')->name('users');
Route::livewire('/user/{user}', 'user')->name('user');
