<?php

use App\Http\Controllers\AuteurController;
use App\Http\Controllers\CategorieController;
use App\Http\Controllers\LivreController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('api')->group(function () { 
    Route::resource('categories', CategorieController::class); 

    }); 
    Route::middleware(('api'))->group(function(){
        Route::resource('livres',LivreController::class);
        
    });
    Route::middleware(('api'))->group(function(){
        Route::resource('auteurs',AuteurController::class);
        
    });
    Route::get('/livres/liv/articlespaginate', [LivreController::class,
'articlesPaginate']);
