<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use Carbon\CarbonInterval;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;


class AsistenciaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        return view('web.welcome');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $departamentos = DB::connection('merulink')->table('Departamentos')->where('codigo','!=',0)->get();

         return view('asistencia.registrar',compact('departamentos'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        if ($request){

            $fecha_actual = Carbon::today();

            //$entrada = DB::connection('ra')->select('select id from asistencia where cedula = ? and hora_entrada != ? and fecha = ?',[$request->cedula, 0,$fecha_actual]);
            $entrada = DB::connection('ra')->table('asistencia')->where('cedula','=',$request->cedula)->where('fecha','=',$fecha_actual)->first();
            //$salida = DB::connection('ra')->select('select id from asistencia where cedula = ? and hora_salida != ? and fecha = ?',[$request->cedula, 0,$fecha_actual]);
            //$entrada = DB::connection('ra')->table('asistencia')->where('cedula','=',$request->cedula)->where('hora_salida','!=',NULL)->where('fecha','!=',$fecha_actual)->get();

            if ($entrada == NULL){
                DB::connection('ra')->table('asistencia')->insert([
                    'nombre_apellido' => $request->nombre . ' ' . $request->apellido,
                    'cedula' => $request->cedula,
                    'departamento' => $request->departamento,
                    'fecha' => $fecha_actual,
                    'hora_entrada' => Carbon::now(),
                    'modo_entrada' => 'A'
                ]);

                return redirect()->route('registrar')->with('mensaje','Asistencia registrada.');
            }else{


                    if ($entrada->hora_entrada_2 == NULL) {

                        DB::connection('ra')->table('asistencia')->where('cedula','=',$request->cedula)->where('fecha','=',$fecha_actual)->update([

                            'hora_entrada_2' => Carbon::now(),
                            'modo_entrada' => $request->modo_entrada . ' A'

                        ]);

                        return redirect()->route('registrar')->with('mensaje','Registro de Asistencia actualizada.');
                    }else{
                        return redirect()->route('registrar')->with('mensaje-error','Empleado no puede registrar su ingreso por tercera vez.');
                    }







            }

        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        return view('asistencia.consultar',['info'=>[], 'minFijadoFechaInicio' => '2021-01-01','tipoReporte'=> 0 ]);
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
    public function update(Request $request)
    {

        if ($request){

            $fecha_actual = Carbon::today();
            //$registro = DB::connection('ra')->table('asistencia')->where('cedula','=',$request->cedula)->where('hora_entrada','!=', null)->where('fecha','=', $fecha_actual)->where('hora_salida','=',null)->get();
            $registro = DB::connection('ra')->table('asistencia')->where('cedula','=',$request->cedula)->where('fecha','=', $fecha_actual)->first();

            if ($registro){

                if ($registro->hora_salida == NULL){
                   // dd($registro);
                   DB::connection('ra')->table('asistencia')->where('cedula','=',$request->cedula)->where('fecha','=', $fecha_actual)->update(['hora_salida' => Carbon::now() ,'modo_entrada' => $registro->modo_entrada . ' A']); //Carbon::now('America/Caracas')
                   return redirect()->route('registrar')->with('mensaje','Registro de Asistencia actualizada.');

                }else{
                    DB::connection('ra')->table('asistencia')->where('cedula','=',$request->cedula)->where('fecha','=', $fecha_actual)->update(['hora_salida_2' => Carbon::now() ,'modo_entrada' => $registro->modo_entrada . ' A']);
                    return redirect()->route('registrar')->with('mensaje','Registro de Asistencia cerrada.');
                }

            }else{

                return redirect()->route('registrar')->with('mensaje-error','Empleado no ha registrado su ingreso.');
            }

        }
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

    public function depto_empleados(Request $request, $id )
    {
        if ($request->ajax()) {
            //$empleados = DB::connection('merulink')->select('select cedula, primer_nombre, primer_apellido from Empleados where Departamento_id = ?', [$id]);
            $empleados = DB::connection('merulink')->table('empleados')->select('cedula', 'primer_nombre', 'primer_apellido')->where('Departamento_id','=', $id)->where('inactivo','!=', 1)->get();
            return response()->json($empleados);
        }
    }

    public function nombre_depto_empleados(Request $request, $nombre )
    {

        if ($request->ajax()) {
            $Departamento = DB::connection('merulink')->table('Departamentos')->where('nombre','=',$nombre)->get();

            $empleados = DB::connection('merulink')->table('empleados')->select('cedula', 'primer_nombre', 'primer_apellido')->where('Departamento_id','=', $Departamento->codigo)->where('inactivo','!=', 1)->get();

            return response()->json($empleados);
        }
    }

    public function deptos(Request $request )
    {

        if ($request->ajax()) {
            $departamentos = DB::connection('merulink')->table('Departamentos')->where('codigo','!=',0)->get();

            return response()->json($departamentos);
        }
    }

    public function busca_empleado(Request $request, $id) {

        if ($request->ajax()) {

            $fecha_actual = carbon::today();
            $registro= DB::connection('ra')->table('asistencia')->where('cedula','=', $id)->where('fecha','=', $fecha_actual)->first();

            $empleado = DB::connection('merulink')->select('select cedula, primer_nombre, primer_apellido, Departamento_id, Cargo_id from Empleados where cedula = ? and inactivo <> 1',[$id]);
            //$empleado = DB::connection('merulink')->table('Empleados')->select('cedula', 'primer_nombre', 'primer_apellido', 'Departamento_id', 'Cargo_id')->where('cedula', '=', $id)->first();

            $departamento = DB::connection('merulink')->select('select nombre from Departamentos where codigo = ?',[$empleado[0]->Departamento_id]);
            $cargo = DB::connection('merulink')->select('select nombre from Cargos where codigo = ?',[$empleado[0]->Cargo_id]);

            $data =[
                'empleado' => $empleado,
                'departamento' => $departamento,
                'cargo' => $cargo,
                'registro' => $registro,

            ];

            return response()->json($data);


        }

    }

    public function ejecutarConsulta(Request $request) {

        // $h_ent;
        // $h_sal;
        // $totalHr;
        $minFijadoFechaInicio = '2021-01-01';

        if (Carbon::parse($request->fechaFin)->lessThan(Carbon::parse($request->fechaInicio))) {
            return redirect()->route('consultar_asistencia')->with('mensaje-error','La Fecha Final no puede ser menor a la Fecha Inicial.')->withInput();
        }

        if (Carbon::parse($request->fechaInicio)->diffInDays(Carbon::parse($request->fechaFin)) > 31) {
            return redirect()->route('consultar_asistencia')->with('mensaje-error','La consulta solicitada no puede exceder de los 31 Días de diferencia.')->withInput();
        }

        if($request->consultaHoy == null && $request->consultaPor == null ){
            $tipoReporte = 1;

            $titulo = 'por Rango de Fechas';
            $departamento = DB::connection('merulink')->select('select nombre from Departamentos where codigo > 0');
            $ctDepartamento = count($departamento);
            $data = DB::connection('ra')->table('asistencia')->select('cedula', 'nombre_apellido','departamento', 'fecha','hora_entrada','hora_salida', 'hora_entrada_2','hora_salida_2','modo_entrada','nocturno')->where('fecha','>=',$request->fechaInicio)->where('fecha','<=',$request->fechaFin)->groupBy('cedula', 'nombre_apellido','departamento', 'fecha','hora_entrada','hora_salida','hora_entrada_2','hora_salida_2','modo_entrada','nocturno')->get();
            //$data = DB::connection('ra')->table('asistencia')->select('cedula', 'nombre_apellido','departamento', 'fecha','hora_entrada','hora_salida','modo_entrada')->where('fecha','>=',$request->fechaInicio)->where('fecha','<=',$request->fechaFin)->get();
            $ctData = count($data);
            $ctFecha = Carbon::parse($request->fechaInicio)->diffInDays(Carbon::parse($request->fechaFin)) ;
            $totalHrMinFinal = '';
            for ($k=0; $k <= $ctFecha ; $k++) {
                $lstFecha[$k] = date('d-m-Y', strtotime($request->fechaInicio . '+' . $k .' days'));
            }
            //dd(Carbon::parse($request->fechaInicio), $fecha, $fecha2, Carbon::parse($request->fechaInicio)->diffInDays(Carbon::parse($request->fechaFin)));

            if ($ctData > 0) {

            for ($i=0; $i < count($departamento) ; $i++) {
                $ctReg[$i] = 0;
                for ($j=0; $j < count($data) ; $j++) {

                    $totalHrMinFinal = '';
                    if ($departamento[$i]->nombre == $data[$j]->departamento) {
                         $ctReg[$i]=1;
                    }
                    if ($data[$j]->hora_entrada != null && $data[$j]->hora_salida != null) {
                        $ent = Carbon::parse($data[$j]->hora_entrada);
                        $sal = Carbon::parse($data[$j]->hora_salida);
                        $totalHr = $ent->diffInHours($sal) < 10 ? '0' . $ent->diffInHours($sal) : $ent->diffInHours($sal);
                        $totalMin =$ent->diffInMinutes($sal) % 60 < 10 ? '0' . $ent->diffInMinutes($sal) % 60 : $ent->diffInMinutes($sal) % 60;
                        $totalHrMinFinal = $totalHr . ':' . $totalMin;
                    }else{
                        $ent = '';
                        $sal = '';
                        $totalHr = '';
                        $totalMin = '';
                    }
                    if ($data[$j]->hora_entrada_2 != null && $data[$j]->hora_salida_2 != null) {
                        $ent2 = Carbon::parse($data[$j]->hora_entrada_2);
                        $sal2 = Carbon::parse($data[$j]->hora_salida_2);
                        $totalHr2 = $ent2->diffInHours($sal2) < 10 ? '0' . $ent2->diffInHours($sal2) : $ent2->diffInHours($sal2);
                        $totalMin2 = $ent2->diffInMinutes($sal2) % 60 < 10 ? '0' . $ent2->diffInMinutes($sal2) % 60 : $ent2->diffInMinutes($sal2) % 60;
                        if (intval($totalMin2) + intval($totalMin) > 59){

                            $totalHrFinal = (intval($totalHr) + intval($totalHr2)) + 1;
                            $totalMinFinal = (intval($totalMin) + intval($totalMin2)) - 60;
                            $totalHrMinFinal = ($totalHrFinal < 10 ? '0' . $totalHrFinal : $totalHrFinal) . ':' . ($totalMinFinal < 10 ? '0' . $totalMinFinal : $totalMinFinal);

                        }else{
                            $totalHrFinal = (intval($totalHr) + intval($totalHr2));
                            $totalMinFinal = (intval($totalMin) + intval($totalMin2));
                            $totalHrMinFinal = ($totalHrFinal < 10 ? '0' . $totalHrFinal : $totalHrFinal) . ':' . ($totalMinFinal < 10 ? '0' . $totalMinFinal : $totalMinFinal);

                        }

                    }else{
                        $ent2 = '';
                        $sal2 = '';
                        $totalHr2 = '';
                        $totalMin2 = '';
                       // $totalHrMinFinal = '';

                    }

                    $info[$i][$j] = [
                        'departamento' => $data[$j]->departamento,
                        'fecha' => date('d-m-Y', strtotime($data[$j]->fecha)),
                        'nombre' => $data[$j]->nombre_apellido,
                        'cedula' =>  $data[$j]->cedula,
                        'fechaEnt' => date('d-m-Y', strtotime($data[$j]->hora_entrada)),
                        'horaEnt' => date('h : i a', strtotime($data[$j]->hora_entrada)),
                        'fechaSal' => ($data[$j]->hora_salida != null ? date('d-m-Y', strtotime($data[$j]->hora_salida)) : ''),
                        'horaSal' => ($data[$j]->hora_salida != null ? date('h : i a', strtotime($data[$j]->hora_salida)) : ''),
                        'horaEnt2' => ($data[$j]->hora_entrada_2 != null ? date('h : i a', strtotime($data[$j]->hora_entrada_2)) : ''),
                        'horaSal2' => ($data[$j]->hora_salida_2 != null ? date('h : i a', strtotime($data[$j]->hora_salida_2)) : ''),
                        'totalHoras' => $totalHrMinFinal,
                        'Modo' => $data[$j]->modo_entrada,
                        'Nocturno'=> $data[$j]->nocturno,

                    ];



                }

            }
            }else{
                    $info ="";
                    $ctReg = 0;

            }

            //dd($info);
            $request->session()->put([
                'data'=>$info,
                'tipo'=>$tipoReporte,
                'titulo'=>$titulo,
                'fechaInicio'=>date('d-m-Y', strtotime($request->fechaInicio)),
                'fechaFin'=>date('d-m-Y', strtotime($request->fechaFin)),
                'ctReg' => $ctReg,

                ]);
            return view('asistencia.consultar',compact('info','minFijadoFechaInicio','ctData','ctDepartamento','departamento','ctReg','ctFecha', 'lstFecha','tipoReporte'));
        }

        if($request->consultaHoy == 'hoy'){

            if ($request->consultaPor == 'departamento'){
                if ($request->departamento != 'Todos') {
                    $tipoReporte = 4;
                    $titulo = 'del Día por Departamento';
                    $departamento =DB::connection('merulink')->table('Departamentos')->where('codigo','=',$request->departamento)->pluck('nombre');
                    if ($request->empleadoDepartamento == 'Todos') {
                        $data = DB::connection('ra')->table('asistencia')->where('fecha','=',$request->fechaInicio)->where('departamento','=',$departamento[0])->get();
                        $ctData = count($data);
                        $totalHrMinFinal = '';
                        if ($ctData > 0) {
                            for ($j=0; $j < count($data) ; $j++) {
                                if ($data[$j]->hora_entrada != null && $data[$j]->hora_salida != null) {
                                    $ent = Carbon::parse($data[$j]->hora_entrada);
                                    $sal = Carbon::parse($data[$j]->hora_salida);
                                    $totalHr = $ent->diffInHours($sal) < 10 ? '0' . $ent->diffInHours($sal) : $ent->diffInHours($sal);
                                    $totalMin =$ent->diffInMinutes($sal) % 60 < 10 ? '0' . $ent->diffInMinutes($sal) % 60 : $ent->diffInMinutes($sal) % 60;
                                    $totalHrMinFinal = $totalHr . ':' . $totalMin;

                                }else{
                                    $ent = '';
                                    $sal = '';
                                    $totalHr = '';
                                    $totalMin = '';

                                }
                                if ($data[$j]->hora_entrada_2 != null && $data[$j]->hora_salida_2 != null) {
                                    $ent2 = Carbon::parse($data[$j]->hora_entrada_2);
                                    $sal2 = Carbon::parse($data[$j]->hora_salida_2);
                                    $totalHr2 = $ent2->diffInHours($sal2) < 10 ? '0' . $ent2->diffInHours($sal2) : $ent2->diffInHours($sal2);
                                    $totalMin2 = $ent2->diffInMinutes($sal2) % 60 < 10 ? '0' . $ent2->diffInMinutes($sal2) % 60 : $ent2->diffInMinutes($sal2) % 60;

                                    if (intval($totalMin2) + intval($totalMin) > 59){

                                        $totalHrFinal = (intval($totalHr) + intval($totalHr2)) + 1;
                                        $totalMinFinal = (intval($totalMin) + intval($totalMin2)) - 60;
                                        $totalHrMinFinal = ($totalHrFinal < 10 ? '0' . $totalHrFinal : $totalHrFinal) . ':' . ($totalMinFinal < 10 ? '0' . $totalMinFinal : $totalMinFinal);

                                    }else{
                                        $totalHrFinal = (intval($totalHr) + intval($totalHr2));
                                        $totalMinFinal = (intval($totalMin) + intval($totalMin2));
                                        $totalHrMinFinal = ($totalHrFinal < 10 ? '0' . $totalHrFinal : $totalHrFinal) . ':' . ($totalMinFinal < 10 ? '0' . $totalMinFinal : $totalMinFinal);

                                    }

                                }else{
                                    $ent2 = '';
                                    $sal2 = '';
                                    $totalHr2 = '';
                                    $totalMin2 = '';


                                }
                                $info[$j] = [
                                    'departamento' => $data[$j]->departamento,
                                    'fecha' => date('d-m-Y', strtotime($data[$j]->fecha)),
                                    'nombre' => $data[$j]->nombre_apellido,
                                    'cedula' =>  $data[$j]->cedula,
                                    'fechaEnt' => date('d-m-Y', strtotime($data[$j]->hora_entrada)),
                                    'horaEnt' => date('h : i a', strtotime($data[$j]->hora_entrada)),
                                    'fechaSal' => ($data[$j]->hora_salida != null ? date('d-m-Y', strtotime($data[$j]->hora_salida)) : ''),
                                    'horaSal' => ($data[$j]->hora_salida != null ? date('h : i a', strtotime($data[$j]->hora_salida)) : ''),
                                    'horaEnt2' => ($data[$j]->hora_entrada_2 != null ? date('h : i a', strtotime($data[$j]->hora_entrada_2)) : ''),
                                    'horaSal2' => ($data[$j]->hora_salida_2 != null ? date('h : i a', strtotime($data[$j]->hora_salida_2)) : ''),
                                    'totalHoras' => $totalHrMinFinal,
                                    'Modo' => $data[$j]->modo_entrada,
                                    'Nocturno'=> $data[$j]->nocturno,

                                ];

                            }
                        }else{
                            $info ="";

                        }
                    }else{
                        $data = DB::connection('ra')->table('asistencia')->where('fecha','=',$request->fechaInicio)->where('cedula','=',$request->empleadoDepartamento)->get();
                        $totalHrMinFinal = '';
                        $ctData = count($data);
                            if ($ctData > 0) {
                                $nombreEmpleado = $data[0]->nombre_apellido;
                                for ($j=0; $j < count($data) ; $j++) {

                                    if ($data[$j]->hora_entrada != null && $data[$j]->hora_salida != null) {
                                        $ent = Carbon::parse($data[$j]->hora_entrada);
                                        $sal = Carbon::parse($data[$j]->hora_salida);
                                        $totalHr = $ent->diffInHours($sal) < 10 ? '0' . $ent->diffInHours($sal) : $ent->diffInHours($sal);
                                        $totalMin =$ent->diffInMinutes($sal) % 60 < 10 ? '0' . $ent->diffInMinutes($sal) % 60 : $ent->diffInMinutes($sal) % 60;
                                        $totalHrMinFinal = $totalHr . ':' . $totalMin;
                                    }else{
                                        $ent = '';
                                        $sal = '';
                                        $totalHr = '';
                                        $totalMin = '';
                                    }
                                    if ($data[$j]->hora_entrada_2 != null && $data[$j]->hora_salida_2 != null) {
                                        $ent2 = Carbon::parse($data[$j]->hora_entrada_2);
                                        $sal2 = Carbon::parse($data[$j]->hora_salida_2);
                                        $totalHr2 = $ent2->diffInHours($sal2) < 10 ? '0' . $ent2->diffInHours($sal2) : $ent2->diffInHours($sal2);
                                        $totalMin2 = $ent2->diffInMinutes($sal2) % 60 < 10 ? '0' . $ent2->diffInMinutes($sal2) % 60 : $ent2->diffInMinutes($sal2) % 60;
                                        if (intval($totalMin2) + intval($totalMin) > 59){

                                            $totalHrFinal = (intval($totalHr) + intval($totalHr2)) + 1;
                                            $totalMinFinal = (intval($totalMin) + intval($totalMin2)) - 60;
                                            $totalHrMinFinal = ($totalHrFinal < 10 ? '0' . $totalHrFinal : $totalHrFinal) . ':' . ($totalMinFinal < 10 ? '0' . $totalMinFinal : $totalMinFinal);

                                        }else{
                                            $totalHrFinal = (intval($totalHr) + intval($totalHr2));
                                            $totalMinFinal = (intval($totalMin) + intval($totalMin2));
                                            $totalHrMinFinal = ($totalHrFinal < 10 ? '0' . $totalHrFinal : $totalHrFinal) . ':' . ($totalMinFinal < 10 ? '0' . $totalMinFinal : $totalMinFinal);

                                        }

                                    }else{
                                        $ent2 = '';
                                        $sal2 = '';
                                        $totalHr2 = '';
                                        $totalMin2 = '';

                                    }
                                    $info[$j] = [
                                        'departamento' => $data[$j]->departamento,
                                        'fecha' => date('d-m-Y', strtotime($data[$j]->fecha)),
                                        'nombre' => $data[$j]->nombre_apellido,
                                        'cedula' =>  $data[$j]->cedula,
                                        'fechaEnt' => date('d-m-Y', strtotime($data[$j]->hora_entrada)),
                                        'horaEnt' => date('h : i a', strtotime($data[$j]->hora_entrada)),
                                        'fechaSal' => ($data[$j]->hora_salida != null ? date('d-m-Y', strtotime($data[$j]->hora_salida)) : ''),
                                        'horaSal' => ($data[$j]->hora_salida != null ? date('h : i a', strtotime($data[$j]->hora_salida)) : ''),
                                        'horaEnt2' => ($data[$j]->hora_entrada_2 != null ? date('h : i a', strtotime($data[$j]->hora_entrada_2)) : ''),
                                        'horaSal2' => ($data[$j]->hora_salida_2 != null ? date('h : i a', strtotime($data[$j]->hora_salida_2)) : ''),
                                        'totalHoras' => $totalHrMinFinal,
                                        'Modo' => $data[$j]->modo_entrada,
                                        'Nocturno'=> $data[$j]->nocturno,

                                    ];

                                }
                            }else{
                                $info ="";
                            }

                    }
                $request->session()->put([
                    'departamento' => $request->departamento,
                    'data'=>$info,
                    'tipo'=>$tipoReporte,
                    'titulo'=>$titulo,
                    'fechaInicio'=>date('d-m-Y', strtotime($request->fechaInicio)),
                    'fechaFin'=>date('d-m-Y', strtotime($request->fechaFin)),

                ]);
                return view('asistencia.consultar',compact('info','minFijadoFechaInicio','ctData','departamento','tipoReporte'));

                }else{
                    return redirect()->route('consultar_asistencia')->with('mensaje-error','No ha sido seleccionado ningun departamento.');
                }


            }

            if($request->consultaPor == 'cedula'){
                $tipoReporte = 6;
                $titulo = 'del Empleado';
                $empleado =DB::connection('merulink')->table('Empleados')->where('cedula','=',$request->cedula)->first();
                if ($empleado) {
                    $departamento =DB::connection('merulink')->table('Departamentos')->where('codigo','=',$empleado->Departamento_id)->pluck('nombre');
                    $nombreEmpleado = $empleado->primer_nombre . ' ' . $empleado->primer_apellido;

                    $data = DB::connection('ra')->table('asistencia')->where('fecha','=',$request->fechaInicio)->where('cedula','=',$request->cedula)->get();
                    $totalHrMinFinal = '';
                    $ctData = count($data);
                        if ($ctData > 0) {
                            for ($j=0; $j < count($data) ; $j++) {

                                if ($data[$j]->hora_entrada != null && $data[$j]->hora_salida != null) {
                                    $ent = Carbon::parse($data[$j]->hora_entrada);
                                    $sal = Carbon::parse($data[$j]->hora_salida);
                                    $totalHr = $ent->diffInHours($sal) < 10 ? '0' . $ent->diffInHours($sal) : $ent->diffInHours($sal);
                                    $totalMin =$ent->diffInMinutes($sal) % 60 < 10 ? '0' . $ent->diffInMinutes($sal) % 60 : $ent->diffInMinutes($sal) % 60;
                                    $totalHrMinFinal = $totalHr . ':' . $totalMin;
                                }else{
                                    $ent = '';
                                    $sal = '';
                                    $totalHr = '';
                                    $totalMin = '';

                                }
                                if ($data[$j]->hora_entrada_2 != null && $data[$j]->hora_salida_2 != null) {
                                    $ent2 = Carbon::parse($data[$j]->hora_entrada_2);
                                    $sal2 = Carbon::parse($data[$j]->hora_salida_2);
                                    $totalHr2 = $ent2->diffInHours($sal2) < 10 ? '0' . $ent2->diffInHours($sal2) : $ent2->diffInHours($sal2);
                                    $totalMin2 = $ent2->diffInMinutes($sal2) % 60 < 10 ? '0' . $ent2->diffInMinutes($sal2) % 60 : $ent2->diffInMinutes($sal2) % 60;
                                    if (intval($totalMin2) + intval($totalMin) > 59){

                                        $totalHrFinal = (intval($totalHr) + intval($totalHr2)) + 1;
                                        $totalMinFinal = (intval($totalMin) + intval($totalMin2)) - 60;
                                        $totalHrMinFinal = ($totalHrFinal < 10 ? '0' . $totalHrFinal : $totalHrFinal) . ':' . ($totalMinFinal < 10 ? '0' . $totalMinFinal : $totalMinFinal);

                                    }else{
                                        $totalHrFinal = (intval($totalHr) + intval($totalHr2));
                                        $totalMinFinal = (intval($totalMin) + intval($totalMin2));
                                        $totalHrMinFinal = ($totalHrFinal < 10 ? '0' . $totalHrFinal : $totalHrFinal) . ':' . ($totalMinFinal < 10 ? '0' . $totalMinFinal : $totalMinFinal);

                                    }

                                }else{
                                    $ent2 = '';
                                    $sal2 = '';
                                    $totalHr2 = '';
                                    $totalMin2 = '';

                                }
                                $info[$j] = [
                                    'departamento' => $data[$j]->departamento,
                                    'fecha' => date('d-m-Y', strtotime($data[$j]->fecha)),
                                    'nombre' => $data[$j]->nombre_apellido,
                                    'cedula' =>  $data[$j]->cedula,
                                    'fechaEnt' => date('d-m-Y', strtotime($data[$j]->hora_entrada)),
                                    'horaEnt' => date('h : i a', strtotime($data[$j]->hora_entrada)),
                                    'fechaSal' => ($data[$j]->hora_salida != null ? date('d-m-Y', strtotime($data[$j]->hora_salida)) : ''),
                                    'horaSal' => ($data[$j]->hora_salida != null ? date('h : i a', strtotime($data[$j]->hora_salida)) : ''),
                                    'horaEnt2' => ($data[$j]->hora_entrada_2 != null ? date('h : i a', strtotime($data[$j]->hora_entrada_2)) : ''),
                                    'horaSal2' => ($data[$j]->hora_salida_2 != null ? date('h : i a', strtotime($data[$j]->hora_salida_2)) : ''),
                                    'totalHoras' => $totalHrMinFinal,
                                    'Modo' => $data[$j]->modo_entrada,
                                    'Nocturno'=> $data[$j]->nocturno,

                                ];

                            }
                        }else{
                            $info ="";
                        }
                        $request->session()->put([
                            'cedula' => $request->cedula,
                            'data'=>$info,
                            'tipo'=>$tipoReporte,
                            'titulo'=>$titulo,
                            'fechaInicio'=>date('d-m-Y', strtotime($request->fechaInicio)),
                            'fechaFin'=>date('d-m-Y', strtotime($request->fechaFin)),

                        ]);
                        return view('asistencia.consultar',compact('info','minFijadoFechaInicio','ctData','departamento', 'nombreEmpleado','tipoReporte'));


                }else{
                    return redirect()->route('consultar_asistencia')->with('mensaje-error','La cedula no existe.');

                }




            }
            $tipoReporte = 2;
            $titulo = 'del Día';
            $data = DB::connection('ra')->table('asistencia')->where('fecha','=',$request->fechaInicio)->get();
            $ctData = count($data);
            $ctFecha = 0;
            $lstFecha ='';
            $departamento = DB::connection('merulink')->select('select nombre from Departamentos where codigo > 0');
            $ctDepartamento = count($departamento);
            $totalHrMinFinal = '';
            if ($ctData > 0) {
                for ($i=0; $i < count($departamento) ; $i++) {
                    $ctReg[$i]=0;
                    for ($j=0; $j < count($data) ; $j++) {
                        $totalHrMinFinal = '';
                        if ($departamento[$i]->nombre == $data[$j]->departamento) {
                            $ctReg[$i]=1;
                        }

                        if ($data[$j]->hora_entrada != null && $data[$j]->hora_salida != null) {
                            $ent = Carbon::parse($data[$j]->hora_entrada);
                            $sal = Carbon::parse($data[$j]->hora_salida);
                            $totalHr = $ent->diffInHours($sal) < 10 ? '0' . $ent->diffInHours($sal) : $ent->diffInHours($sal);
                            $totalMin =$ent->diffInMinutes($sal) % 60 < 10 ? '0' . $ent->diffInMinutes($sal) % 60 : $ent->diffInMinutes($sal) % 60;
                            $totalHrMinFinal = $totalHr . ':' . $totalMin;
                        }else{
                            $ent = '';
                            $sal = '';
                            $totalHr = '';
                            $totalMin = '';
                        }
                        if ($data[$j]->hora_entrada_2 != null && $data[$j]->hora_salida_2 != null) {
                            $ent2 = Carbon::parse($data[$j]->hora_entrada_2);
                            $sal2 = Carbon::parse($data[$j]->hora_salida_2);
                            $totalHr2 = $ent2->diffInHours($sal2) < 10 ? '0' . $ent2->diffInHours($sal2) : $ent2->diffInHours($sal2);
                            $totalMin2 = $ent2->diffInMinutes($sal2) % 60 < 10 ? '0' . $ent2->diffInMinutes($sal2) % 60 : $ent2->diffInMinutes($sal2) % 60;
                            if (intval($totalMin2) + intval($totalMin) > 59){

                                $totalHrFinal = (intval($totalHr) + intval($totalHr2)) + 1;
                                $totalMinFinal = (intval($totalMin) + intval($totalMin2)) - 60;
                                $totalHrMinFinal = ($totalHrFinal < 10 ? '0' . $totalHrFinal : $totalHrFinal) . ':' . ($totalMinFinal < 10 ? '0' . $totalMinFinal : $totalMinFinal);

                            }else{
                                $totalHrFinal = (intval($totalHr) + intval($totalHr2));
                                $totalMinFinal = (intval($totalMin) + intval($totalMin2));
                                $totalHrMinFinal = ($totalHrFinal < 10 ? '0' . $totalHrFinal : $totalHrFinal) . ':' . ($totalMinFinal < 10 ? '0' . $totalMinFinal : $totalMinFinal);

                            }

                        }else{
                            $ent2 = '';
                            $sal2 = '';
                            $totalHr2 = '';
                            $totalMin2 = '';

                        }
                        $info[$i][$j] = [
                            'departamento' => $data[$j]->departamento,
                            'fecha' => date('d-m-Y', strtotime($data[$j]->fecha)),
                            'nombre' => $data[$j]->nombre_apellido,
                            'cedula' =>  $data[$j]->cedula,
                            'fechaEnt' => date('d-m-Y', strtotime($data[$j]->hora_entrada)),
                            'horaEnt' => date('h : i a', strtotime($data[$j]->hora_entrada)),
                            'fechaSal' => ($data[$j]->hora_salida != null ? date('d-m-Y', strtotime($data[$j]->hora_salida)) : ''),
                            'horaSal' => ($data[$j]->hora_salida != null ? date('h : i a', strtotime($data[$j]->hora_salida)) : ''),
                            'horaEnt2' => ($data[$j]->hora_entrada_2 != null ? date('h : i a', strtotime($data[$j]->hora_entrada_2)) : ''),
                            'horaSal2' => ($data[$j]->hora_salida_2 != null ? date('h : i a', strtotime($data[$j]->hora_salida_2)) : ''),
                            'totalHoras' => $totalHrMinFinal,
                            'Modo' => $data[$j]->modo_entrada,
                            'Nocturno'=> $data[$j]->nocturno,

                        ];

                    }

                }
            }else{
                $info ="";
                $ctReg = 0;

            }
            $request->session()->put([
                'data'=>$info,
                'tipo'=>$tipoReporte,
                'titulo'=>$titulo,
                'fechaInicio'=>date('d-m-Y', strtotime($request->fechaInicio)),
                'fechaFin'=>date('d-m-Y', strtotime($request->fechaFin)),
                'ctReg' => $ctReg,


                ]);
                return view('asistencia.consultar',compact('info','minFijadoFechaInicio', 'ctReg','ctData','ctDepartamento','departamento','tipoReporte','ctFecha','lstFecha'));
        }

        if($request->consultaPor == 'departamento'){
            if ($request->departamento != 'Todos') {
            $tipoReporte = 3;
            $departamento =   DB::connection('merulink')->table('Departamentos')->where('codigo','=',$request->departamento)->pluck('nombre');
            $titulo = 'por Departamento';
            //$data = DB::connection('ra')->table('asistencia')->where('fecha','>=',$request->fechaInicio)->where('fecha','<=',$request->fechaFin)->where('departamento','=',$request->departamento)->get();

            if ($request->empleadoDepartamento == 'Todos') {
                $data = DB::connection('ra')->table('asistencia')->select('cedula', 'nombre_apellido','departamento', 'fecha','hora_entrada','hora_salida','hora_entrada_2','hora_salida_2','modo_entrada','nocturno')->where('fecha','>=',$request->fechaInicio)->where('fecha','<=',$request->fechaFin)->where('departamento','=',$departamento[0])->groupBy('cedula', 'nombre_apellido','departamento', 'fecha','hora_entrada','hora_salida','hora_entrada_2','hora_salida_2','modo_entrada','nocturno')->get();
                $ctData = count($data);
                $totalHrMinFinal = '';
                $ctFecha = Carbon::parse($request->fechaInicio)->diffInDays(Carbon::parse($request->fechaFin)) ;
                for ($k=0; $k <= $ctFecha ; $k++) {
                    $lstFecha[$k] = date('d-m-Y', strtotime($request->fechaInicio . '+' . $k .' days'));
                }
                if ($ctData > 0) {
                    for ($j=0; $j < count($data) ; $j++) {
                        if ($data[$j]->hora_entrada != null && $data[$j]->hora_salida != null) {
                            $ent = Carbon::parse($data[$j]->hora_entrada);
                            $sal = Carbon::parse($data[$j]->hora_salida);
                            $totalHr = $ent->diffInHours($sal) < 10 ? '0' . $ent->diffInHours($sal) : $ent->diffInHours($sal);
                            $totalMin =$ent->diffInMinutes($sal) % 60 < 10 ? '0' . $ent->diffInMinutes($sal) % 60 : $ent->diffInMinutes($sal) % 60;
                            $totalHrMinFinal = $totalHr . ':' . $totalMin;
                        }else{
                            $ent = '';
                            $sal = '';
                            $totalHr = '';
                            $totalMin = '';
                        }
                        if ($data[$j]->hora_entrada_2 != null && $data[$j]->hora_salida_2 != null) {
                            $ent2 = Carbon::parse($data[$j]->hora_entrada_2);
                            $sal2 = Carbon::parse($data[$j]->hora_salida_2);
                            $totalHr2 = $ent2->diffInHours($sal2) < 10 ? '0' . $ent2->diffInHours($sal2) : $ent2->diffInHours($sal2);
                            $totalMin2 = $ent2->diffInMinutes($sal2) % 60 < 10 ? '0' . $ent2->diffInMinutes($sal2) % 60 : $ent2->diffInMinutes($sal2) % 60;
                            if (intval($totalMin2) + intval($totalMin) > 59){

                                $totalHrFinal = (intval($totalHr) + intval($totalHr2)) + 1;
                                $totalMinFinal = (intval($totalMin) + intval($totalMin2)) - 60;
                                $totalHrMinFinal = ($totalHrFinal < 10 ? '0' . $totalHrFinal : $totalHrFinal) . ':' . ($totalMinFinal < 10 ? '0' . $totalMinFinal : $totalMinFinal);

                            }else{
                                $totalHrFinal = (intval($totalHr) + intval($totalHr2));
                                $totalMinFinal = (intval($totalMin) + intval($totalMin2));
                                $totalHrMinFinal = ($totalHrFinal < 10 ? '0' . $totalHrFinal : $totalHrFinal) . ':' . ($totalMinFinal < 10 ? '0' . $totalMinFinal : $totalMinFinal);

                            }

                        }else{
                            $ent2 = '';
                            $sal2 = '';
                            $totalHr2 = '';
                            $totalMin2 = '';

                        }

                        $info[$j] = [
                            'departamento' => $data[$j]->departamento,
                            'fecha' => date('d-m-Y', strtotime($data[$j]->fecha)),
                            'nombre' => $data[$j]->nombre_apellido,
                            'cedula' =>  $data[$j]->cedula,
                            'fechaEnt' => date('d-m-Y', strtotime($data[$j]->hora_entrada)),
                            'horaEnt' => date('h : i a', strtotime($data[$j]->hora_entrada)),
                            'fechaSal' => ($data[$j]->hora_salida != null ? date('d-m-Y', strtotime($data[$j]->hora_salida)) : ''),
                            'horaSal' => ($data[$j]->hora_salida != null ? date('h : i a', strtotime($data[$j]->hora_salida)) : ''),
                            'horaEnt2' => ($data[$j]->hora_entrada_2 != null ? date('h : i a', strtotime($data[$j]->hora_entrada_2)) : ''),
                            'horaSal2' => ($data[$j]->hora_salida_2 != null ? date('h : i a', strtotime($data[$j]->hora_salida_2)) : ''),
                            'totalHoras' => $totalHrMinFinal,
                            'Modo' => $data[$j]->modo_entrada,
                            'Nocturno'=> $data[$j]->nocturno,

                        ];

                    }
                }else{
                    $info ="";

                }
            }else{
                $empleado =DB::connection('merulink')->table('Empleados')->where('cedula','=',$request->empleadoDepartamento)->first();
                if ($empleado) {
                    $departamento =DB::connection('merulink')->table('Departamentos')->where('codigo','=',$empleado->Departamento_id)->pluck('nombre');
                    $nombreEmpleado = $empleado->primer_nombre . ' ' . $empleado->primer_apellido;
                    $data = DB::connection('ra')->table('asistencia')->where('fecha','>=',$request->fechaInicio)->where('fecha','<=',$request->fechaFin)->where('cedula','=',$request->empleadoDepartamento)->get();
                    $totalHrMinFinal = '';
                    $ctFecha = Carbon::parse($request->fechaInicio)->diffInDays(Carbon::parse($request->fechaFin)) ;
                    for ($k=0; $k <= $ctFecha ; $k++) {
                        $lstFecha[$k] = date('d-m-Y', strtotime($request->fechaInicio . '+' . $k .' days'));
                    }
                    $ctData = count($data);
                        if ($ctData > 0) {
                            for ($j=0; $j < count($data) ; $j++) {
                                if ($data[$j]->hora_entrada != null && $data[$j]->hora_salida != null) {
                                    $ent = Carbon::parse($data[$j]->hora_entrada);
                                    $sal = Carbon::parse($data[$j]->hora_salida);
                                    $totalHr = $ent->diffInHours($sal) < 10 ? '0' . $ent->diffInHours($sal) : $ent->diffInHours($sal);
                                    $totalMin =$ent->diffInMinutes($sal) % 60 < 10 ? '0' . $ent->diffInMinutes($sal) % 60 : $ent->diffInMinutes($sal) % 60;
                                    $totalHrMinFinal = $totalHr . ':' . $totalMin;
                                }else{
                                    $ent = '';
                                    $sal = '';
                                    $totalHr = '';
                                    $totalMin = '';
                                }
                                if ($data[$j]->hora_entrada_2 != null && $data[$j]->hora_salida_2 != null) {
                                    $ent2 = Carbon::parse($data[$j]->hora_entrada_2);
                                    $sal2 = Carbon::parse($data[$j]->hora_salida_2);
                                    $totalHr2 = $ent2->diffInHours($sal2) < 10 ? '0' . $ent2->diffInHours($sal2) : $ent2->diffInHours($sal2);
                                    $totalMin2 = $ent2->diffInMinutes($sal2) % 60 < 10 ? '0' . $ent2->diffInMinutes($sal2) % 60 : $ent2->diffInMinutes($sal2) % 60;
                                    if (intval($totalMin2) + intval($totalMin) > 59){

                                        $totalHrFinal = (intval($totalHr) + intval($totalHr2)) + 1;
                                        $totalMinFinal = (intval($totalMin) + intval($totalMin2)) - 60;
                                        $totalHrMinFinal = ($totalHrFinal < 10 ? '0' . $totalHrFinal : $totalHrFinal) . ':' . ($totalMinFinal < 10 ? '0' . $totalMinFinal : $totalMinFinal);

                                    }else{
                                        $totalHrFinal = (intval($totalHr) + intval($totalHr2));
                                        $totalMinFinal = (intval($totalMin) + intval($totalMin2));
                                        $totalHrMinFinal = ($totalHrFinal < 10 ? '0' . $totalHrFinal : $totalHrFinal) . ':' . ($totalMinFinal < 10 ? '0' . $totalMinFinal : $totalMinFinal);

                                    }

                                }else{
                                    $ent2 = '';
                                    $sal2 = '';
                                    $totalHr2 = '';
                                    $totalMin2 = '';

                                }

                                $info[$j] = [
                                    'departamento' => $data[$j]->departamento,
                                    'fecha' => date('d-m-Y', strtotime($data[$j]->fecha)),
                                    'nombre' => $data[$j]->nombre_apellido,
                                    'cedula' =>  $data[$j]->cedula,
                                    'fechaEnt' => date('d-m-Y', strtotime($data[$j]->hora_entrada)),
                                    'horaEnt' => date('h : i a', strtotime($data[$j]->hora_entrada)),
                                    'fechaSal' => ($data[$j]->hora_salida != null ? date('d-m-Y', strtotime($data[$j]->hora_salida)) : ''),
                                    'horaSal' => ($data[$j]->hora_salida != null ? date('h : i a', strtotime($data[$j]->hora_salida)) : ''),
                                    'horaEnt2' => ($data[$j]->hora_entrada_2 != null ? date('h : i a', strtotime($data[$j]->hora_entrada_2)) : ''),
                                    'horaSal2' => ($data[$j]->hora_salida_2 != null ? date('h : i a', strtotime($data[$j]->hora_salida_2)) : ''),
                                    'totalHoras' => $totalHrMinFinal,
                                    'Modo' => $data[$j]->modo_entrada,
                                    'Nocturno'=> $data[$j]->nocturno,

                                ];

                            }
                        }else{
                            $info ="";
                        }
                }
            }

            $request->session()->put([
                'departamento' => $departamento[0],
                'data'=>$info,
                'tipo'=>$tipoReporte,
                'titulo'=>$titulo,
                'fechaInicio'=>date('d-m-Y', strtotime($request->fechaInicio)),
                'fechaFin'=>date('d-m-Y', strtotime($request->fechaFin)),


            ]);
            return view('asistencia.consultar',compact('info','minFijadoFechaInicio','ctData','departamento','ctFecha','lstFecha','tipoReporte'));
        }else{
            return redirect()->route('consultar_asistencia')->with('mensaje-error','No ha sido seleccionado ningun departamento.');
        }

        }

        if($request->consultaPor == 'cedula'){
            $tipoReporte = 5;
            $titulo = 'del Empleado';

            $empleado =DB::connection('merulink')->table('Empleados')->where('cedula','=',$request->cedula)->first();
            if ($empleado) {
                $departamento =DB::connection('merulink')->table('Departamentos')->where('codigo','=',$empleado->Departamento_id)->pluck('nombre');
                $nombreEmpleado = $empleado->primer_nombre . ' ' . $empleado->primer_apellido;
                $data = DB::connection('ra')->table('asistencia')->where('fecha','>=',$request->fechaInicio)->where('fecha','<=',$request->fechaFin)->where('cedula','=',$request->cedula)->get();
                $totalHrMinFinal = '';

                $ctData = count($data);
                    if ($ctData > 0) {
                        for ($j=0; $j < count($data) ; $j++) {
                            if ($data[$j]->hora_entrada != null && $data[$j]->hora_salida != null) {
                                $ent = Carbon::parse($data[$j]->hora_entrada);
                                $sal = Carbon::parse($data[$j]->hora_salida);
                                $totalHr = $ent->diffInHours($sal) < 10 ? '0' . $ent->diffInHours($sal) : $ent->diffInHours($sal);
                                $totalMin =$ent->diffInMinutes($sal) % 60 < 10 ? '0' . $ent->diffInMinutes($sal) % 60 : $ent->diffInMinutes($sal) % 60;
                                $totalHrMinFinal = $totalHr . ':' . $totalMin;
                            }else{
                                $ent = '';
                                $sal = '';
                                $totalHr = '';
                                $totalMin = '';
                            }
                            if ($data[$j]->hora_entrada_2 != null && $data[$j]->hora_salida_2 != null) {
                                $ent2 = Carbon::parse($data[$j]->hora_entrada_2);
                                $sal2 = Carbon::parse($data[$j]->hora_salida_2);
                                $totalHr2 = $ent2->diffInHours($sal2) < 10 ? '0' . $ent2->diffInHours($sal2) : $ent2->diffInHours($sal2);
                                $totalMin2 = $ent2->diffInMinutes($sal2) % 60 < 10 ? '0' . $ent2->diffInMinutes($sal2) % 60 : $ent2->diffInMinutes($sal2) % 60;
                                if (intval($totalMin2) + intval($totalMin) > 59){

                                    $totalHrFinal = (intval($totalHr) + intval($totalHr2)) + 1;
                                    $totalMinFinal = (intval($totalMin) + intval($totalMin2)) - 60;
                                    $totalHrMinFinal = ($totalHrFinal < 10 ? '0' . $totalHrFinal : $totalHrFinal) . ':' . ($totalMinFinal < 10 ? '0' . $totalMinFinal : $totalMinFinal);

                                }else{
                                    $totalHrFinal = (intval($totalHr) + intval($totalHr2));
                                    $totalMinFinal = (intval($totalMin) + intval($totalMin2));
                                    $totalHrMinFinal = ($totalHrFinal < 10 ? '0' . $totalHrFinal : $totalHrFinal) . ':' . ($totalMinFinal < 10 ? '0' . $totalMinFinal : $totalMinFinal);

                                }

                            }else{
                                $ent2 = '';
                                $sal2 = '';
                                $totalHr2 = '';
                                $totalMin2 = '';

                            }

                            $info[$j] = [
                                'departamento' => $data[$j]->departamento,
                                'fecha' => date('d-m-Y', strtotime($data[$j]->fecha)),
                                'nombre' => $data[$j]->nombre_apellido,
                                'cedula' =>  $data[$j]->cedula,
                                'fechaEnt' => date('d-m-Y', strtotime($data[$j]->hora_entrada)),
                                'horaEnt' => date('h : i a', strtotime($data[$j]->hora_entrada)),
                                'fechaSal' => ($data[$j]->hora_salida != null ? date('d-m-Y', strtotime($data[$j]->hora_salida)) : ''),
                                'horaSal' => ($data[$j]->hora_salida != null ? date('h : i a', strtotime($data[$j]->hora_salida)) : ''),
                                'horaEnt2' => ($data[$j]->hora_entrada_2 != null ? date('h : i a', strtotime($data[$j]->hora_entrada_2)) : ''),
                                'horaSal2' => ($data[$j]->hora_salida_2 != null ? date('h : i a', strtotime($data[$j]->hora_salida_2)) : ''),
                                'totalHoras' => $totalHrMinFinal,
                                'Modo' => $data[$j]->modo_entrada,
                                'Nocturno'=> $data[$j]->nocturno,

                            ];

                        }
                    }else{
                        $info ="";
                    }
                    $request->session()->put([
                        'cedula' => $request->cedula,
                        'data'=>$info,
                        'tipo'=>$tipoReporte,
                        'titulo'=>$titulo,
                        'fechaInicio'=>date('d-m-Y', strtotime($request->fechaInicio)),
                        'fechaFin'=>date('d-m-Y', strtotime($request->fechaFin)),

                    ]);
                return view('asistencia.consultar',compact('info','minFijadoFechaInicio','ctData','departamento','tipoReporte','nombreEmpleado'));


            }else{
                return redirect()->route('consultar_asistencia')->with('mensaje-error','La cedula no existe.');

            }

        }


    }

    public function guardarRegistroManual(Request $request){

        if ($request) {
            $valido = 1;

            $nCedulas = count($request->lasCedulas);


            for ($i=0; $i < $nCedulas ; $i++) {

                if ($request->chkNocturno[$i] != null){


                    switch ($request->chkAgregarEntSal[$i]) {

                        case 'activo':
                            if ($request->hrEntrada2[$i] != null) {

                                if (strtotime($request->fecha  . $request->hrEntrada2[$i]) <= strtotime($request->fecha  . $request->hrSalida[$i])) {
                                    $valido = 0;
                                    break 2;
                                }
                            }
                            if ($request->hrSalida2[$i] != null) {

                                if (strtotime($request->fecha . '+1 days' . $request->hrSalida2[$i]) <= strtotime($request->fecha  . $request->hrEntrada2[$i])) {
                                    $valido = 0;
                                    break 2;
                                }
                            }
                            break;

                        case 'inactivo':
                            if ($request->hrSalida[$i] != null) {

                                if (strtotime($request->fecha . '+1 days' . $request->hrSalida[$i]) <= strtotime($request->fecha . $request->hrEntrada[$i])) {
                                    $valido = 0;
                                    break 2;
                                }
                            }
                            break;
                    }

                }else{

                    switch ($request->chkAgregarEntSal[$i]) {

                        case 'activo':
                            if ($request->hrEntrada2[$i] != null) {

                                if (strtotime($request->fecha . $request->hrEntrada2[$i]) <= strtotime($request->fecha . $request->hrSalida[$i])) {
                                    $valido = 0;
                                    break 2;
                                }
                            }
                            if ($request->hrSalida2[$i] != null) {

                                if (strtotime($request->fecha . $request->hrSalida2[$i]) <= strtotime($request->fecha . $request->hrEntrada2[$i])) {
                                    $valido = 0;
                                    break 2;
                                }
                            }
                            break;

                        case 'inactivo':
                            if ($request->hrSalida[$i] != null) {

                                if (strtotime($request->fecha . $request->hrSalida[$i]) <= strtotime($request->fecha . $request->hrEntrada[$i])) {
                                    $valido = 0;
                                    break 2;
                                }
                            }
                            break;
                    }
                }


            }
            if ($valido == 1) {

                for ($i=0; $i < $nCedulas ; $i++) {
                    $empleado = DB::connection('ra')->table('asistencia')->where('cedula', '=', $request->lasCedulas[$i])->where('fecha','=',$request->fecha)->first();
                    if ($empleado){

                        if ($request->chkNocturno[$i] != null) {
                            if (date('Y-m-d h:i a', strtotime($empleado->hora_entrada)) != date('Y-m-d h:i a',strtotime($request->fecha . $request->hrEntrada[$i]))  ||  date('Y-m-d h:i a', strtotime($empleado->hora_salida)) != date('Y-m-d h:i a',strtotime($request->fecha . '+1 days' . $request->hrSalida[$i])) || date('Y-m-d h:i a', strtotime($empleado->hora_entrada_2)) != date('Y-m-d h:i a',strtotime( $request->hrEntrada2[$i]))  ||  date('Y-m-d h:i a', strtotime($empleado->hora_salida_2)) != date('Y-m-d h:i a',strtotime($request->hrSalida2[$i]))) {

                                    DB::connection('ra')->table('asistencia')->updateOrInsert(
                                        ['cedula'=> $request->lasCedulas[$i], 'fecha'=>$request->fecha],
                                        ['nombre_apellido'=>$request->losNombres[$i], 'departamento'=>$request->losDepartamentos[$i], 'hora_entrada'=>date('Y-m-d h:i a', strtotime($request->fecha  . $request->hrEntrada[$i])), 'hora_entrada_2'=>( $request->hrEntrada2[$i] != '' ? date('Y-m-d h:i a', strtotime($request->fecha . $request->hrEntrada2[$i])) : NULL),'hora_salida'=>($request->hrSalida[$i]!= '' ? date('Y-m-d h:i a', strtotime($request->fecha  . '+1 days' .$request->hrSalida[$i])) : NULL), 'hora_salida_2'=>($request->hrSalida2[$i]!= '' ? date('Y-m-d h:i a', strtotime($request->fecha  . $request->hrSalida2[$i])) : NULL),'modo_entrada'=> $empleado->modo_entrada . ' M']);



                                }else{

                                if ($request->hrEntrada[$i] != '' ) {
                                    DB::connection('ra')->table('asistencia')->insert([
                                            'cedula'=> $request->lasCedulas[$i],
                                            'fecha'=>$request->fecha,
                                            'nombre_apellido'=>$request->losNombres[$i],
                                            'departamento'=>$request->losDepartamentos[$i],
                                            'hora_entrada'=>date('Y-m-d h:i a', strtotime($request->fecha . $request->hrEntrada[$i])),
                                            'hora_entrada_2'=>($request->hrEntrada2[$i] != '' ? date('Y-m-d h:i a', strtotime($request->fecha . $request->hrEntrada2[$i])) : NULL),
                                            'hora_salida'=>($request->hrSalida[$i]!= '' ? date('Y-m-d h:i a', strtotime($request->fecha . '+1 days' . $request->hrSalida[$i])) : NULL),
                                            'hora_salida_2'=>($request->hrSalida2[$i]!= '' ? date('Y-m-d h:i a', strtotime($request->hrSalida2[$i])) : NULL),
                                            'modo_entrada'=>'M'
                                    ]);
                                }
                            }
                        }else{
                          if (date('Y-m-d h:i a', strtotime($empleado->hora_entrada)) != date('Y-m-d h:i a',strtotime($request->fecha . $request->hrEntrada[$i]))  ||  date('Y-m-d h:i a', strtotime($empleado->hora_salida)) != date('Y-m-d h:i a',strtotime($request->fecha . $request->hrSalida[$i])) || date('Y-m-d h:i a', strtotime($empleado->hora_entrada_2)) != date('Y-m-d h:i a',strtotime($request->fecha . $request->hrEntrada2[$i]))  ||  date('Y-m-d h:i a', strtotime($empleado->hora_salida_2)) != date('Y-m-d h:i a',strtotime($request->fecha . $request->hrSalida2[$i]))) {

                                    DB::connection('ra')->table('asistencia')->updateOrInsert(
                                        ['cedula'=> $request->lasCedulas[$i], 'fecha'=>$request->fecha],
                                        ['nombre_apellido'=>$request->losNombres[$i], 'departamento'=>$request->losDepartamentos[$i], 'hora_entrada'=>date('Y-m-d h:i a', strtotime($request->fecha . $request->hrEntrada[$i])), 'hora_entrada_2'=>($request->hrEntrada2[$i] != '' ? date('Y-m-d h:i a', strtotime($request->fecha . $request->hrEntrada2[$i])) : NULL),'hora_salida'=>($request->hrSalida[$i]!= '' ? date('Y-m-d h:i a', strtotime($request->fecha . $request->hrSalida[$i])) : NULL), 'hora_salida_2'=>($request->hrSalida2[$i]!= '' ? date('Y-m-d h:i a', strtotime($request->fecha . $request->fecha . $request->hrSalida2[$i])) : NULL),'modo_entrada'=> $empleado->modo_entrada . ' M']);



                                }else{

                                if ($request->hrEntrada[$i] != '' ) {
                                    DB::connection('ra')->table('asistencia')->insert([
                                            'cedula'=> $request->lasCedulas[$i],
                                            'fecha'=>$request->fecha,
                                            'nombre_apellido'=>$request->losNombres[$i],
                                            'departamento'=>$request->losDepartamentos[$i],
                                            'hora_entrada'=>date('Y-m-d h:i a', strtotime($request->fecha . $request->hrEntrada[$i])),
                                            'hora_entrada_2'=>($request->hrEntrada2[$i] != '' ? date('Y-m-d h:i a', strtotime($request->fecha . $request->hrEntrada2[$i])) : NULL),
                                            'hora_salida'=>($request->hrSalida[$i]!= '' ? date('Y-m-d h:i a', strtotime($request->fecha . $request->hrSalida[$i])) : NULL),
                                            'hora_salida_2'=>($request->hrSalida2[$i]!= '' ? date('Y-m-d h:i a', strtotime($request->fecha . $request->hrSalida2[$i])) : NULL),
                                            'modo_entrada'=>'M'
                                    ]);
                                }
                            }
                        }
                    }




                }
                return redirect()->route('registro_manual')->with('mensaje','Asistencia Manual registrada exitosamente.');

            }else{

                return redirect()->back()->with('mensaje-error','Al menos un registro presenta un valor incorrecto. Por favor intente otra vez.');


            }

        }

    }


    public function guardarEditarAsistencia(Request $request){

        if ($request) {

                $empleado = DB::connection('ra')->table('asistencia')->where('cedula', '=', $request->cedula)->where('fecha','=',date('Y-m-d',strtotime('today')))->first();

                if ($empleado) {
                    $horaEntrada =  $request->editarHoraEntrada . ':' . $request->editarMinEntrada . ' ' . $request->editarMdEntrada;
                    $horaSalida =  $request->editarHoraSalida . ':' . $request->editarMinSalida . ' ' . $request->editarMdSalida;
                    $horaEntrada2 =  $request->editarHoraEntrada2 . ':' . $request->editarMinEntrada2 . ' ' . $request->editarMdEntrada2;
                    $horaSalida2 =  $request->editarHoraSalida2 . ':' . $request->editarMinSalida2 . ' ' . $request->editarMdSalida2;

                    if (date('Y-m-d h:i a', strtotime($empleado->hora_entrada)) != date('Y-m-d h:i a', strtotime($horaEntrada))) {

                        DB::connection('ra')->table('asistencia')->where('cedula', '=', $request->cedula)->where('fecha','=',date('Y-m-d',strtotime('today')))->update(
                            ['hora_entrada'=>date('Y-m-d h:i a', strtotime($horaEntrada)), 'modo_entrada'=> $empleado->modo_entrada . ' M']);
                    }
                        if ($empleado->hora_salida != null) {

                            if (date('Y-m-d h:i a', strtotime($empleado->hora_salida)) != date('Y-m-d h:i a', strtotime($horaSalida))) {

                                DB::connection('ra')->table('asistencia')->where('cedula', '=', $request->cedula)->where('fecha','=',date('Y-m-d',strtotime('today')))->update(
                                    ['hora_salida'=>date('Y-m-d h:i a', strtotime($horaSalida)), 'modo_entrada'=> $empleado->modo_entrada . ' M']);
                            }
                        }else{
                            if (date('Y-m-d h:i a', strtotime($horaSalida)) != date('Y-m-d h:i a', strtotime('1:00 am'))) {
                                DB::connection('ra')->table('asistencia')->where('cedula', '=', $request->cedula)->where('fecha','=',date('Y-m-d',strtotime('today')))->update(
                                    ['hora_salida'=>date('Y-m-d h:i a', strtotime($horaSalida)), 'modo_entrada'=> 'M']);
                            }
                        }

                        if ($empleado->hora_entrada_2 != null) {

                            if (date('Y-m-d h:i a', strtotime($empleado->hora_entrada_2)) != date('Y-m-d h:i a', strtotime($horaEntrada2))) {

                                DB::connection('ra')->table('asistencia')->where('cedula', '=', $request->cedula)->where('fecha','=',date('Y-m-d',strtotime('today')))->update(
                                    ['hora_entrada_2'=>date('Y-m-d h:i a', strtotime($horaEntrada2)), 'modo_entrada'=> $empleado->modo_entrada . ' M']);
                            }
                        }else{
                            if (date('Y-m-d h:i a', strtotime($horaEntrada2)) != date('Y-m-d h:i a', strtotime('1:00 am'))) {
                                DB::connection('ra')->table('asistencia')->where('cedula', '=', $request->cedula)->where('fecha','=',date('Y-m-d',strtotime('today')))->update(
                                    ['hora_entrada_2'=>date('Y-m-d h:i a', strtotime($horaEntrada2)), 'modo_entrada'=> 'M']);
                            }
                        }

                        if ($empleado->hora_salida_2 != null) {

                            if (date('Y-m-d h:i a', strtotime($empleado->hora_salida_2)) != date('Y-m-d h:i a', strtotime($horaSalida2))) {

                                DB::connection('ra')->table('asistencia')->where('cedula', '=', $request->cedula)->where('fecha','=',date('Y-m-d',strtotime('today')))->update(
                                    ['hora_salida_2'=>date('Y-m-d h:i a', strtotime($horaSalida2)), 'modo_entrada'=> $empleado->modo_entrada . ' M']);
                            }
                        }else{
                            if (date('Y-m-d h:i a', strtotime($horaSalida2)) != date('Y-m-d h:i a', strtotime('1:00 am'))) {
                                DB::connection('ra')->table('asistencia')->where('cedula', '=', $request->cedula)->where('fecha','=',date('Y-m-d',strtotime('today')))->update(
                                    ['hora_salida_2'=>date('Y-m-d h:i a', strtotime($horaSalida2)), 'modo_entrada'=> 'M']);
                            }
                        }
                }

             return redirect()->route('registrar')->with('mensaje','Asistencia editada exitosamente.');
        }

    }

    public function auditoria()
    {

        return view('asistencia.auditoria');
    }


}
