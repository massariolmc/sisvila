<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Response;
use App\Local;

class LocaisController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $locais = Local::all();
        return view('locais.index', compact('locais'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('locais.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Responseadadad
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
           'status' => 'required|string',
           'tipo' => 'required|string',
           'local' => 'required|string|unique:locais,local',
	],
	[
	   'status.required' => 'Selecione OCUPADO/DESOCUPADO',
	   'tipo.required' => 'Selecione o tipo de edificacao',
	   'local.required' => 'Informe a identificacao da edificacao Ex: GOLF0000',
	   'local.unique' => 'Local existente. Informe outro',
	]
	);
        //var_dump($request->all());
        Local::create($request->all());
        return redirect()->route('locais.index')->with('success', 'Local criado com sucesso!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function delete($local)
    {
        $locais = Local::find($local);
        
        $locais->delete();   
        
        return redirect()
                    ->route('locais.index')
                    ->with('success', 'Edificação excluída com sucesso!');

    }
}
