<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class PrenominaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function incidenciasIndex()
    {
        $maxFijadoFechaInicio = new Carbon('yesterday');
        $minFijadoFechaInicio = new Carbon('yesterday -1 month');
        $empleados = [];
       // dd($maxFijadoFechaInicio, $minFijadoFechaInicio);
       return view('prenomina.incidencias.index', compact('maxFijadoFechaInicio','minFijadoFechaInicio','empleados'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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

    public function mostrarIncidencias(Request $request)
    {
       $empleados = DB::connection('merulink')->table('Empleados')->select('cedula','primer_nombre','primer_apellido','SubDepartamento_id')->where('Departamento_id','=', $request->departamento)->where('inactivo','=',false)->get();
       $departamento = DB::connection('merulink')->table('Departamentos')->where('codigo','=',$request->departamento)->first();
       $turnos = DB::connection('merulink')->table('Horarios')->where('Departamento_id','=', $request->departamento)->get();

       $fechaInicio = new Carbon($request->fechaInicio);
       $fechaFin = new Carbon($request->fechaFin);

       $diferenciaDias = $fechaFin->diffInDays($fechaInicio) + 1;

       for ($i=0; $i < $diferenciaDias ; $i++) {
           $listaFecha[$i] = new Carbon($request->fechaInicio . ' +' . $i . 'days');
        //    $tmp = new Carbon($request->fechaInicio . ' +' . $i . 'days');
        //    $listaFecha[$i]['fecha']=$tmp->toDateString();
        //    $listaFecha[$i]['dia'] = $tmp->locale('es')->day;
        //    $listaFecha[$i]['nombreDia'] = $tmp->locale('es')->dayName;
        //    $listaFecha[$i]['mes'] = $tmp->locale('es')->month;
        //    $listaFecha[$i]['nombreMes'] = $tmp->locale('es')->monthName;
        //    $listaFecha[$i]['anio'] = $tmp->locale('es')->year;

           //echo '(' . $listaFecha[$i]['fecha'] .') / ' . $listaFecha[$i]['nombreDia'] . ', ' . $listaFecha[$i]['dia'] . ' de  ' . $listaFecha[$i]['nombreMes'] . ' de ' . $listaFecha[$i]['anio'] . '<br>';
           echo $listaFecha[$i]->locale('es')->dayName . ', ' . $listaFecha[$i]->locale('es')->day . ' de  ' . $listaFecha[$i]->locale('es')->monthName . ' de ' . $listaFecha[$i]->locale('es-ve')->year . '<br>';
           //date('Y-m-d', strtotime($request->fechaInicio . ' +' . $i . 'days'));
            //    $listaFecha2[$i]['fecha'] = $listaFecha[$i]->toDateString(); //date('d', strtotime($request->fechaInicio . ' +' . $i . 'days'));
            //    $listaFecha2[$i]['dia'] = date('d', strtotime($request->fechaInicio . ' +' . $i . 'days'));
            //    $listaFecha2[$i]['mes'] = date('m', strtotime($request->fechaInicio . ' +' . $i . 'days'));
            //    $listaFecha2[$i]['nombre_dia'] = date('l', strtotime($request->fechaInicio . ' +' . $i . 'days'));
            //    $listaFecha2[$i]['nombre_mes'] = date('F', strtotime($request->fechaInicio . ' +' . $i . 'days'));
       }



       dd($request->fechaInicio, $request->fechaFin,  $fechaInicio->toDateString(), $fechaFin->toDateString(), $diferenciaDias, $listaFecha,  );

       return view('livewire.prenomina.incidencias.mostrar-incidencias', compact('empleados','departamento'));
    }

}
