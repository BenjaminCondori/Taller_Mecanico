<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class PermisosController extends Controller
{
    public function index()
    {
        $url = env('URL_SERVER_API', 'http://127.0.0.1:8000');
        $response = Http::get($url . '/permisos');
        $data = $response->json();
        return view('dashboard.permisos.index', compact('data'));
    }

    public function asignar()
    {
        $url = env('URL_SERVER_API', 'http://127.0.0.1:8000');
        $response = Http::get($url . '/permisos');
        $permisos = $response->json();

        $response = Http::get($url . '/roles');
        $roles = $response->json();

        return view('dashboard.permisos.asignar', compact('permisos', 'roles'));
    }


    public function create()
    {
        //
    }


    public function store(Request $request)
    {
        //
    }


    public function show(string $id)
    {
        //
    }


    public function edit(string $id)
    {
        //
    }


    public function update(Request $request, string $id)
    {
        //
    }


    public function destroy(string $id)
    {
        //
    }
}
