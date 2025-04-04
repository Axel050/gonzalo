<?php 

use Illuminate\Support\Facades\Route;


Route::get("/ini", function(){
return "addmixn";
});


Route::get("/subastas", function(){
          return view('admin.subastas');
})->name("subastas");


Route::get("/comitentes", function(){
          return view('admin.comitentes');
})->name("comitentes");


Route::get("/adquirentes", function(){
          return view('admin.adquirentes');
})->name("adquirentes");