<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use Carbon\CarbonInterval;

use Illuminate\Support\Facades\DB;

class ReporteController extends Controller
{
    public function impReporte(Request $request){
        $tipoReporte = $request->session()->get('tipo');
        $titulo = $request->session()->get('titulo');
        $data = $request->session()->get('data');
        if ($request->session()->exists('cedula')) {
            $cedula = $request->session()->get('cedula');
        }
        $fechaInicio = $request->session()->get('fechaInicio');
        $fechaFin = $request->session()->get('fechaFin');
        if ($request->session()->exists('ctReg')) {
            $ctReg = $request->session()->get('ctReg');
        }
       
        switch ($tipoReporte) {
            case '1':
                $departamentos = DB::connection('merulink')->table('Departamentos')->where('codigo','!=',0)->get();
                $view= view('asistencia.reportes.reporte1', compact('departamentos','titulo','tipoReporte','data','fechaInicio','fechaFin','ctReg'))->render();
                //return view('asistencia.reportes.reporte1', compact('departamentos','titulo','tipoReporte','data','fechaInicio','fechaFin'));
                
                $pdf= app('dompdf.wrapper');
                
                $pdf->loadHTML($view)->setPaper('a4', 'landscape')->setWarnings(false);  
                return $pdf->stream ('informe_'. date('d-m-Y', strtotime('today')) .'.pdf');
                
                break;
            
            case '2':
                $departamentos = DB::connection('merulink')->table('Departamentos')->where('codigo','!=',0)->get();
                $view= view('asistencia.reportes.reporte2', compact('departamentos','titulo','tipoReporte','data','fechaInicio','fechaFin','ctReg'))->render();
                //return view('asistencia.reportes.reporte1', compact('departamentos','titulo','tipoReporte','data','fechaInicio','fechaFin'));
                
                $pdf= app('dompdf.wrapper');
                
                $pdf->loadHTML($view)->setPaper('a4', 'landscape')->setWarnings(false); 
                return $pdf->stream ('informe_'. date('d-m-Y', strtotime('today')) .'.pdf');
                
                break;

            case '3':
                $departamento = $request->session()->get('departamento');
                $view= view('asistencia.reportes.reporte3', compact('departamento','titulo','tipoReporte','data','fechaInicio','fechaFin'))->render();
                //return view('asistencia.reportes.reporte1', compact('departamentos','titulo','tipoReporte','data','fechaInicio','fechaFin'));
                
                $pdf= app('dompdf.wrapper');
                
                $pdf->loadHTML($view)->setPaper('a4', 'landscape')->setWarnings(false); 
                return $pdf->stream ('informe_'. date('d-m-Y', strtotime('today')) .'.pdf');
                
                break;

            case '4':
                $departamento = $request->session()->get('departamento');
                $view= view('asistencia.reportes.reporte4', compact('departamento','titulo','tipoReporte','data','fechaInicio','fechaFin'))->render();
                //return view('asistencia.reportes.reporte1', compact('departamentos','titulo','tipoReporte','data','fechaInicio','fechaFin'));
                
                $pdf= app('dompdf.wrapper');
                
                $pdf->loadHTML($view)->setPaper('a4', 'landscape')->setWarnings(false); 
                return $pdf->stream ('informe_'. date('d-m-Y', strtotime('today')) .'.pdf');
                
                break;
        
            case '5':
                $cedula = $request->session()->get('cedula');
                $departamento = $request->session()->get('departamento');
                $view= view('asistencia.reportes.reporte5', compact('departamento', 'cedula','titulo','tipoReporte','data','fechaInicio','fechaFin'))->render();
                //return view('asistencia.reportes.reporte1', compact('departamentos','titulo','tipoReporte','data','fechaInicio','fechaFin'));
                
                $pdf= app('dompdf.wrapper');
                
                $pdf->loadHTML($view)->setPaper('a4', 'landscape')->setWarnings(false); 
                return $pdf->stream ('informe_'. date('d-m-Y', strtotime('today')) .'.pdf');
                
                break;
            case '6':
                $cedula = $request->session()->get('cedula');
                $departamento = $request->session()->get('departamento');
                $view= view('asistencia.reportes.reporte6', compact('departamento','cedula','titulo','tipoReporte','data','fechaInicio','fechaFin'))->render();
                //return view('asistencia.reportes.reporte1', compact('departamentos','titulo','tipoReporte','data','fechaInicio','fechaFin'));
                
                $pdf= app('dompdf.wrapper');
                
                $pdf->loadHTML($view)->setPaper('a4', 'landscape')->setWarnings(false); 
                return $pdf->stream ('informe_'. date('d-m-Y', strtotime('today')) .'.pdf');
                
                break;
        }
        dd($tipoReporte);
    }

}
