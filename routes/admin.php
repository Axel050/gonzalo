<?php

use Illuminate\Support\Facades\Route;

Route::get("/ini", function () {
  return "addmixn";
});



// Route::view('/dashboard', 'dashboard');


Route::get("/subastas", function () {
  return view('admin.subastas');
})->name("subastas")->can("subastas-ver");


Route::get("/comitentes", function () {
  return view('admin.comitentes');
})->name("comitentes")->can("comitentes-ver");


Route::get("/adquirentes", function () {
  return view('admin.adquirentes');
})->name("adquirentes")->can("adquirentes-ver");

Route::get("/usuarios", function () {
  return view('admin.personal.usuarios');
})->name("usuarios")->can("personal-ver");

Route::get("/roles", function () {
  return view('admin.personal.roles');
})->name("roles")->can("personal-ver");

Route::get("/garantias/{id?}", function () {
  return view('admin.depositos');
})->name("garantias")->can("personal-ver");

Route::get("/contratos", function () {
  return view('admin.contratos');
})->name("contratos")->can("personal-ver");

Route::get("/lotes/{id?}", function () {
  return view('admin.lotes');
})->name("lotes")->can("personal-ver");

Route::get("/auditoria", function () {
  return view('admin.auditorias');
})->name("auditoria")->can("auditoria-ver");



Route::get("/ordenes", function () {
  return view('admin.ordenes');
})->name("ordenes");
// ->can("ordenes-ver");


// AUX
Route::get("/aux/condicion-iva", function () {
  return view('admin.auxiliares.condicion-iva');
})->name("condicon-iva")->can("auxiliares-ver");

Route::get("/aux/estado-adquirentes", function () {
  return view('admin.auxiliares.estado-adquirentes');
})->name("estado-adq")->can("auxiliares-ver");

Route::get("/aux/tipo-bien", function () {
  return view('admin.auxiliares.tipo-bien');
})->name("tipo-bien")->can("auxiliares-ver");


Route::get("/aux/caracteristicas", function () {
  return view('admin.auxiliares.caracteristicas');
})->name("caracteristicas")->can("auxiliares-ver");

Route::get("/aux/monedas", function () {
  return view('admin.auxiliares.monedas');
})->name("monedas")->can("auxiliares-ver");

Route::get("/aux/estado-lotes", function () {
  return view('admin.auxiliares.estado-lotes');
})->name("estado-lotes")->can("auxiliares-ver");

Route::get("/", function () {
  return view('admin.index');
})->name("index");
