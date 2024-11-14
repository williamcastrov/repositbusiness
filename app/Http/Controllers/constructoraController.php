<?php

namespace App\Http\Controllers;

use App\Entities\ModelGlobal;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use FunctionsCustoms;

use Kreait\Firebase\Factory;
use Kreait\Firebase\Messaging\CloudMessage;
use Kreait\Firebase\Messaging\Notification;
use Kreait\Firebase\Messaging;

use PDF;

use Illuminate\Support\Facades\DB;

class constructoraController extends Controller
{
        /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct()
    {
        $this->middleware('api');

        //header('Access-Control-Allow-Origin: *');
        header("Access-Control-Allow-Origin: *");

        $this->cur_connect = 'mysql';
        $this->db = 'constructora_sys';

        // Datos para consultas de Api de Siigo
        $this->url_siigo_api = "https://api.siigo.com/v1/";
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function constructoraGeneral(Request $request, $accion, $parametro=null)
    {
        switch ($accion) {
            case 1:
                $this->datosEntorno($request);
                break;
            case 2:
                $this->listarEstratos($request);
                break;
            case 3:
                $this->listarTipoInmueble($request);
                break;
            case 4:
                $this->listarPorteria($request);
                break;
            case 5:
                $this->listarEstados($request);
                break;
            case 6:
                $this->crearProyecto($request);
                break;
            case 7:
                $this->listarProyectos($request);
                break;
            case 8:
                $this->crearTorre($request);
                break;
            case 9:
                $this->listarTorres($request);
                break;
            case 10:
                $this->crearInmueble($request);
                break;
            case 11:
                $this->listarInmuebles($request);
                break;
            case 1011:
                $this->AllSatate($request);
                break;
            case 12:
                $this->actualizarInmueble($request);
            case 13:
                $this->crearCliente($request);
                break;
            case 14:
                $this->listarClientes($request);
                break;
            case 15:
                $this->actualizarCliente($request);
                break;
            case 16:
                $this->actualizarProyecto($request);
                break;
            case 17:
                $this->actualizarTorre($request);
                break;
            case 18:
                $this->listarParqueaderos($request);
                break;
            case 19:
                $this->listarAcabados($request);
                break;
            case 20:
                $this->listarPremisas($request);
                break;
            case 21:
                $this->listarPrecioM2Inmueble($request);
                break;
            case 22:
                $this->crearCotizacion($request);
                break; 
            case 23:
                $this->listarCotizaciones($request);
                break;
            case 24:
                $this->ultimoNumeroCotizacion($request);
                break;
            case 25:
                $this->actualizarCotizacion($request);
                break; 
            case 26:
                $this->crearGestion($request);
                break;
            case 27:
                $this->reservarInmueble($request);
                break;
            case 28:
                $this->listarVentasInmuebles($request);
                break;
            case 29:
                $this->actualizarVentaInmueble($request);
                break;
            case 30:
                $this->crearInmueblesVendidos($request);
                break;
            case 31:
                $this->crearReciboCaja($request);
                break;
            case 32:
                $this->listarReciboCaja($request);
                break;
            case 33:
                $this->actualizarReciboCaja($request);
                break;
            case 34:
                $this->actualizarAbonoInmueble($request);
                break;   
            case 35:
                $this->crearPlanPago($request);
                break;
            case 36:
                $this->listarPlanPago($request);
                break;
            case 37:
                $this->actualizarPlanPago($request);
               break;
            case 38:
                $this->ResumenInmueblesVendidos($request);
                break;
            case 39:
                $this->ResumenVtasMes($request);
                break;   
            case 40:
                $this->RecaudoMes($request);
                break;   
            case 41:
                $this->RecaudoAno($request);
                break;
            case 42:
                $this->RecaudoMesSigue($request);
                break; 
            case 43:
                $this->RecaudoAnoSigue($request);
                break;  
            case 44:
                $this->RecaudoReal($request);
                break; 
            case 45:
                $this->RecaudoMesActual($request);
                break;
            case 46:
                $this->checkPaymentPlan($request);
                break;
            case 47:
                $this->RecaudoMesAnterior($request);
                break;
            case 48:
                $this->crearConsecutivo($request);
                break;
            case 49:
                $this->listarConsecutivo($request);
                break;
            case 50:
                $this->actualizarConsecutivoRC($request);
                break; 
               

            case 3100:
                $this->cwrTiposCliente($request);
                break;
            case 4000:
                $this->createUser($request);
                break;
             case 5000:
                $this->login($request);
                break;
            case 6000:
                $this->listarUsuarios($request);
                break;
            case 7000:
                $this->cwrTipoIdentificacion($request);
                break;
            case 8000:
                $this->ListarConsecutivosCategorias($request);
                break;
            case 9000:
                $this->cwrActualizarConsecutivos($request);
                break;                
            case 1000:
                $this->authenticateConstructora($request);
                break;
            default:
                $response = array(
                    'type' => '0',
                    'message' => 'ERROR INESPERADO'
                );
                echo json_encode($response);
                exit;
        }
    }

    // Objeto para asignar los datos del entorno
    public function datosEntorno($rec)
    {
        $db_name = "constructora_sys";
            
        $listarciudades = DB::connection($this->cur_connect)->select(
                                                "select t0.*, t0.id as value, t0.nombre as label 
                                                from ".$db_name.'.ciudades'." t0 
                                                ORDER BY nombre ASC"); 
        
        $listarestratos = DB::connection($this->cur_connect)->select(
                                                "select t0.*, t0.id as value, t0.nombre as label  
                                                from ".$db_name.'.estratos'." t0 
                                                ORDER BY id DESC");
                                                
        $listartiposinmuebles = DB::connection($this->cur_connect)->select(
                                                "select t0.*, t0.id as value, t0.nombre as label  
                                                from ".$db_name.'.tipoinmueble'." t0 
                                                ORDER BY id DESC");                                        
        
        $listarporterias = DB::connection($this->cur_connect)->select(
                                                "select t0.*, t0.id as value, t0.nombre as label  
                                                from ".$db_name.'.porteria'." t0 
                                                ORDER BY id DESC"); 
    
        $listarestados = DB::connection($this->cur_connect)->select(
                                                "select t0.*, t0.id as value, t0.nombre as label  
                                                from ".$db_name.'.estados'." t0 
                                                ORDER BY id DESC");

        $tiposdeacabados = DB::connection($this->cur_connect)->select(
                                                "select t0.*, t0.id as value, t0.nombre as label  
                                                from ".$db_name.'.tiposdeacabados'." t0 
                                                ORDER BY id DESC");
        
        $a = array(
            'ciudades' => $listarciudades,
            'estratos' => $listarestratos,
            'tiposinmuebles' => $listartiposinmuebles,
            'listarporterias' => $listarporterias,  
            'listarestados' => $listarestados,
            'tiposdeacabados' => $tiposdeacabados
        );
                                    
        $response = array(
            'type' => 1,
            'message' => " CREACION EXITOSA",
            'datos' => $a,
        );
        //echo json_encode($listarciudades);
        echo json_encode($response);
        //return $response;
        exit;                                        

        //echo json_encode($listarciudades);
    }

    //Crear proyecto inmobiliario
    public function crearProyecto($rec)
    {
        DB::beginTransaction();
        try {
                //$db_name = $this->db.".productos";
                $db_name = "constructora_sys.proyectos";
                $crearProyecto = new ModelGlobal();
                $crearProyecto->setConnection($this->cur_connect);
                $crearProyecto->setTable($db_name);
 
                $crearProyecto->nombre = $rec->nombre;	
                $crearProyecto->nit = $rec->nit;
                $crearProyecto->digitochequeo = $rec->digitochequeo;
                $crearProyecto->direccion = $rec->direccion;
                $crearProyecto->ciudad = $rec->ciudad;
                $crearProyecto->estrato = $rec->estrato;
                $crearProyecto->tipodeinmueble = $rec->tipodeinmueble;
                $crearProyecto->terrenototal = $rec->terrenototal;
                $crearProyecto->areaconstruida = $rec->areaconstruida;
                $crearProyecto->torres = $rec->torres;
                $crearProyecto->parqueadorestotales = $rec->parqueadorestotales;
                $crearProyecto->parqueaderosprivados = $rec->parqueaderosprivados;
                $crearProyecto->parqueaderospublicos = $rec->parqueaderospublicos;
                $crearProyecto->porteria = $rec->porteria;
                $crearProyecto->tipodeinmueble = $rec->tipodeinmueble;
                $crearProyecto->estado = $rec->estado;
                $crearProyecto->fechainicia = $rec->fechainicia;
                $crearProyecto->fechafin = $rec->fechafin;
                $crearProyecto->fechacreacion = $rec->fechacreacion;
                $crearProyecto->fechamodificacion = $rec->fechamodificacion;
                $crearProyecto->descripcion = $rec->descripcion;
 
                $crearProyecto->save();
 
        } catch (\Exception $e){
 
            DB::rollBack();
            $response = array(
                'type' => '0',
                'message' => "ERROR ".$e
            );
            $rec->headers->set('Accept', 'application/json');
            echo json_encode($response);
            exit;
        }
        DB::commit();
        $response = array(
            'type' => 1,
            'message' => 'REGISTRO EXITOSO',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    //Actualizar proyecto inmobiliario
    public function actualizarProyecto($rec)
    {
        //echo json_encode($rec->id);
        //exit;
        $db_name = "constructora_sys.proyectos";
 
        DB::beginTransaction();
        try {
 
            DB::connection($this->cur_connect)->update("UPDATE ".$db_name." 
                    SET nombre= '".$rec->nombre."',
                        nit= '".$rec->nit."',
                        digitochequeo= '".$rec->digitochequeo."',
                        direccion= '".$rec->direccion."',
                        ciudad= '".$rec->ciudad."',
                        estrato= '".$rec->estrato."',
                        terrenototal= '".$rec->terrenototal."',
                        areaconstruida= '".$rec->areaconstruida."',
                        torres= '".$rec->torres."',
                        totalinmuebles= '".$rec->totalinmuebles."',
                        parqueadorestotales= '".$rec->parqueadorestotales."',
                        parqueaderosprivados= '".$rec->parqueaderosprivados."',
                        parqueaderospublicos= '".$rec->parqueaderospublicos."',
                        porteria= '".$rec->porteria."',
                        tipodeinmueble= '".$rec->tipodeinmueble."',
                        estado= '".$rec->estado."',
                        fechainicia= '".$rec->fechainicia."',
                        fechafin= '".$rec->fechafin."',
                        fechacreacion= '".$rec->fechacreacion."',
                        fechamodificacion= '".$rec->fechamodificacion."',
                        descripcion= '".$rec->descripcion."'
                    WHERE id = '".$rec->id."'");
 
        } catch (\Exception $e){
 
            DB::rollBack();
            $response = array(
                'type' => '0',
                'message' => "ERROR ".$e
            );
            echo json_encode($response);
            exit;
        }
        DB::commit();
 
        $response = array(
             'type' => 1,
             'message' => 'PROCESO EXITOSO'
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    //Actualizar torres inmobiliario
    public function actualizarTorre($rec)
    {
        //echo json_encode($rec->id);
        //exit;
        $db_name = "constructora_sys.torres";
 
        DB::beginTransaction();
        try {
 
            DB::connection($this->cur_connect)->update("UPDATE ".$db_name." 
                    SET nombre= '".$rec->nombre."',
                        numeropisos= '".$rec->numeropisos."',
                        numeroinmuebles= '".$rec->numeroinmuebles."',
                        elevadores= '".$rec->elevadores."',
                        proyecto= '".$rec->proyecto."',
                        estado= '".$rec->estado."'
                    WHERE id = '".$rec->id."'");
 
        } catch (\Exception $e){
 
            DB::rollBack();
            $response = array(
                'type' => '0',
                'message' => "ERROR ".$e
            );
            echo json_encode($response);
            exit;
        }
        DB::commit();
 
        $response = array(
             'type' => 1,
             'message' => 'PROCESO EXITOSO'
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }
    
    // Listar ciudades creadas en la base de datos
    public function listarProyectos($rec)
    {
        DB::beginTransaction();
        try {
        $db_name = "constructora_sys";
                
        $listarproyectos = DB::connection($this->cur_connect)->select(
                                                "select t0.*, t1.nombre as nombreciudad, t2.nombre as nombreestrato,
                                                        t3.nombre as nombretipoinmueble, t4.nombre as nombreestado 
                                                from ".$db_name.'.proyectos'." t0 
                                                JOIN ".$db_name.'.ciudades'." t1 ON t0.ciudad = t1.id
                                                JOIN ".$db_name.'.estratos'." t2 ON t0.estrato = t2.id
                                                JOIN ".$db_name.'.tipoinmueble'." t3 ON t0.tipodeinmueble = t3.id
                                                JOIN ".$db_name.'.estados'." t4 ON t0.estado = t4.id
                                                WHERE t0.estado != 7 ORDER BY fechacreacion ASC"); 

        } catch (\Exception $e){
        
            DB::rollBack();
            $response = array(
                'type' => '0',
                'message' => "ERROR ".$e
            );
            $rec->headers->set('Accept', 'application/json');
            echo json_encode($response);
            exit;
        }
        DB::commit();
        $response = array(
            'type' => 1,
            'listarproyectos' => $listarproyectos,
            'message' => 'REGISTRO EXITOSO',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
        //echo json_encode($listarproyectos);
    }

    //Crear torre proyecto inmobiliario
    public function crearTorre($rec)
    {
        DB::beginTransaction();
        try {
                //$db_name = $this->db.".productos";
                $db_name = "constructora_sys.torres";
                $crearTorre = new ModelGlobal();
                $crearTorre->setConnection($this->cur_connect);
                $crearTorre->setTable($db_name);
  
                $crearTorre->nombre = $rec->nombre;	
                $crearTorre->numeropisos = $rec->numeropisos;
                $crearTorre->numeroinmuebles = $rec->numeroinmuebles;
                $crearTorre->elevadores = $rec->elevadores;
                $crearTorre->proyecto = $rec->proyecto;
                $crearTorre->estado = $rec->estado;
  
                $crearTorre->save();
  
        } catch (\Exception $e){
  
            DB::rollBack();
            $response = array(
                'type' => '0',
                'message' => "ERROR ".$e
            );
            $rec->headers->set('Accept', 'application/json');
            echo json_encode($response);
            exit;
        }
        DB::commit();
        $response = array(
            'type' => 1,
            'message' => 'REGISTRO EXITOSO',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    // Listar ciudades creadas en la base de datos
    public function listarTorres($rec)
    {
        DB::beginTransaction();
        try {
        $db_name = "constructora_sys";
                
        $listartorres = DB::connection($this->cur_connect)->select(
                                                "select t0.*, t1.nombre as nombreproyecto, t2.nombre as nombreestado 
                                                from ".$db_name.'.torres'." t0 
                                                JOIN ".$db_name.'.proyectos'." t1 ON t0.proyecto = t1.id
                                                JOIN ".$db_name.'.estados'." t2 ON t0.estado = t2.id
                                                WHERE t0.estado != 7
                                                   && t0.proyecto = '". $rec->proyecto."'ORDER BY id ASC"); 

        } catch (\Exception $e){
        
            DB::rollBack();
            $response = array(
                'type' => '0',
                'message' => "ERROR ".$e
            );
            $rec->headers->set('Accept', 'application/json');
            echo json_encode($response);
            exit;
        }
        DB::commit();
        $response = array(
            'type' => 1,
            'listartorres' => $listartorres,
            'message' => 'REGISTRO EXITOSO',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
        //echo json_encode($listarproyectos);
    }

    public function crearInmueble($rec)
    {
        DB::beginTransaction();
        try {
                //$db_name = $this->db.".productos";
                $db_name = "constructora_sys.inmuebles";
                $crearInmueble = new ModelGlobal();
                $crearInmueble->setConnection($this->cur_connect);
                $crearInmueble->setTable($db_name);
 
                $crearInmueble->id= $rec->id;
                $crearInmueble->idproyecto= $rec->idproyecto;
                $crearInmueble->idtorre= $rec->idtorre;
                $crearInmueble->idinmueble= $rec->idinmueble;
                $crearInmueble->areatotal= $rec->areatotal;
                $crearInmueble->area= $rec->area;
                $crearInmueble->lote= $rec->lote;
                $crearInmueble->precioobrablanca= $rec->precioobrablanca;
                $crearInmueble->precioobragris= $rec->precioobragris;
                $crearInmueble->alcobas= $rec->alcobas;
                $crearInmueble->banos= $rec->banos;
                $crearInmueble->parqueadero= $rec->parqueadero;
                $crearInmueble->tipodeacabado= $rec->tipodeacabado;
                $crearInmueble->nombre= $rec->nombre;
                $crearInmueble->nota= $rec->nota;
                $crearInmueble->estado= $rec->estado;
                $crearInmueble->tipo= $rec->tipo;
                $crearInmueble->servicio= $rec->servicio;
                $crearInmueble->balcon= $rec->balcon;
                $crearInmueble->otrascaracteristicas= $rec->otrascaracteristicas;
                $crearInmueble->fechacreacion= $rec->fechacreacion;
                $crearInmueble->fechamodificacion= $rec->fechamodificacion;

                $crearInmueble->save();
 
        } catch (\Exception $e){
 
            DB::rollBack();
            $response = array(
                'type' => '0',
                'message' => "ERROR ".$e
            );
            $rec->headers->set('Accept', 'application/json');
            echo json_encode($response);
            exit;
        }
        DB::commit();
        $response = array(
            'type' => 1,
            'message' => 'REGISTRO EXITOSO',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    // Listar ciudades creadas en la base de datos
    public function listarInmuebles($rec)
    {
        DB::beginTransaction();
        try {
        $db_name = "constructora_sys";
                
        $listarinmuebles = DB::connection($this->cur_connect)->select(
                                                "select t0.*, t1.nombre as nombreproyecto, t2.nombre as nombretorre,
                                                        t3.nombre as nombreestado  
                                                from ".$db_name.'.inmuebles'." t0 
                                                JOIN ".$db_name.'.proyectos'." t1 ON t0.idproyecto = t1.id
                                                JOIN ".$db_name.'.torres'."  t2 ON t0.idtorre = t2.id
                                                JOIN ".$db_name.'.estados'." t3 ON t0.estado = t3.id
                                                WHERE t0.estado != 7 
                                                   && t2.proyecto   = '". $rec->proyecto."' 
                                                   && t0.idproyecto = '". $rec->proyecto."' 
                                                   && t0.idtorre = '". $rec->idtorre."'ORDER BY idinmueble ASC"); 
        } catch (\Exception $e){
        
            DB::rollBack();
            $response = array(
                'type' => '0',
                'message' => "ERROR ".$e
            );
            $rec->headers->set('Accept', 'application/json');
            echo json_encode($response);
            exit;
        }
        DB::commit();
        $response = array(
            'type' => 1,
            'listarinmuebles' => $listarinmuebles,
            'message' => 'REGISTRO EXITOSO',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
        //echo json_encode($listarproyectos);
    }

    // Listar todos los inmuebles
    public function AllSatate($rec)
    {
        DB::beginTransaction();
        try {
        $db_name = "constructora_sys";
                
        $listarinmuebles = DB::connection($this->cur_connect)->select(
                                                "select t0.*, t1.nombre as nombreproyecto, t2.nombre as nombretorre,
                                                        t3.nombre as nombreestado, t4.valormetroscuadrados  
                                                from ".$db_name.'.inmuebles'." t0 
                                                JOIN ".$db_name.'.proyectos'." t1 ON t0.idproyecto = t1.id
                                                JOIN ".$db_name.'.torres'."  t2 ON t0.idtorre = t2.id
                                                JOIN ".$db_name.'.estados'." t3 ON t0.estado = t3.id
                                                JOIN ".$db_name.'.valormt2porinmueble'." t4 ON t0.areatotal = t4.metroscuadrados
                                                WHERE t0.estado != 7 ORDER BY id ASC"); 
        } catch (\Exception $e){
        
            DB::rollBack();
            $response = array(
                'type' => '0',
                'message' => "ERROR ".$e
            );
            $rec->headers->set('Accept', 'application/json');
            echo json_encode($response);
            exit;
        }
        DB::commit();
        $response = array(
            'type' => 1,
            'listarinmuebles' => $listarinmuebles,
            'message' => 'REGISTRO EXITOSO',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
        //echo json_encode($listarproyectos);
    }

    public function actualizarInmueble($rec)
    {
        //echo json_encode($rec->id);
        //exit;
        $db_name = "constructora_sys.inmuebles";
 
        DB::beginTransaction();
        try {
 
            DB::connection($this->cur_connect)->update("UPDATE ".$db_name." 
                    SET idproyecto = '".$rec->idproyecto."',
                    idtorre= '".$rec->idtorre."',
                    idinmueble= '".$rec->idinmueble."',
                    areatotal= '".$rec->areatotal."',
                    area= '".$rec->area."',
                    lote= '".$rec->lote."',
                    precio:= '".$rec->precio."',
                    alcobas= '".$rec->alcobas."',
                    banos= '".$rec->banos."',
                    parqueadero= '".$rec->parqueadero."',
                    tipodeacabado= '".$rec->tipodeacabado."',
                    nombre= '".$rec->nombre."',
                    nota= '".$rec->nota."',
                    estado= '".$rec->estado."',
                    tipo= '".$rec->tipo."',
                    servicio= '".$rec->servicio."',
                    balcon= '".$rec->balcon."',
                    otrascaracteristicas= '".$rec->otrascaracteristicas."',
                    fechacreacion= '".$rec->fechacreacion."',
                    fechamodificacion= '".$rec->fechamodificacion."'
                WHERE id = '".$rec->id."'");
 
        } catch (\Exception $e){
 
            DB::rollBack();
            $response = array(
                'type' => '0',
                'message' => "ERROR ".$e
            );
            echo json_encode($response);
            exit;
        }
        DB::commit();
 
        $response = array(
             'type' => 1,
             'message' => 'PROCESO EXITOSO'
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    public function reservarInmueble($rec)
    {
        //echo json_encode($rec->id);
        //exit;
        $db_name = "constructora_sys.inmuebles";
 
        DB::beginTransaction();
        try {
 
            DB::connection($this->cur_connect)->update("UPDATE ".$db_name." 
                    SET estado= '".$rec->estado."'
                    WHERE id = '".$rec->id."'");
 
        } catch (\Exception $e){
 
            DB::rollBack();
            $response = array(
                'type' => '0',
                'message' => "ERROR ".$e
            );
            echo json_encode($response);
            exit;
        }
        DB::commit();
 
        $response = array(
             'type' => 1,
             'message' => 'PROCESO EXITOSO'
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    //Crear torre proyecto inmobiliario
    public function crearCliente($rec)
    {
        DB::beginTransaction();
        try {
                //$db_name = $this->db.".productos";
                $db_name = "constructora_sys.clientes";
                $crearCliente = new ModelGlobal();
                $crearCliente->setConnection($this->cur_connect);
                $crearCliente->setTable($db_name);
  	
                $crearCliente->nombres = $rec->nombres;	
                $crearCliente->apellidos = $rec->apellidos;	
                $crearCliente->cedula = $rec->cedula;	
                $crearCliente->telefono = $rec->telefono;	
                $crearCliente->mobile = $rec->mobile;	
                $crearCliente->email = $rec->email;	
                $crearCliente->direccion = $rec->direccion;	
                $crearCliente->observacion = $rec->observacion;	
                $crearCliente->fechacreacion = $rec->fechacreacion;	
                $crearCliente->fechamodificacion = $rec->fechamodificacion;	
                $crearCliente->estado = $rec->estado;	
  
                $crearCliente->save();
  
        } catch (\Exception $e){
  
            DB::rollBack();
            $response = array(
                'type' => '0',
                'message' => "ERROR ".$e
            );
            $rec->headers->set('Accept', 'application/json');
            echo json_encode($response);
            exit;
        }
        DB::commit();
        $response = array(
            'type' => 1,
            'message' => 'REGISTRO EXITOSO',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    // Listar clientes creadas en la base de datos
    public function listarClientes($rec)
    {
        DB::beginTransaction();
        try {
        $db_name = "constructora_sys";
                
        $listarclientes = DB::connection($this->cur_connect)->select(
                                                "select t0.*, t1.nombre as nombreestado
                                                from ".$db_name.'.clientes'." t0 
                                                JOIN ".$db_name.'.estados'." t1 ON t0.estado = t1.id
                                                WHERE t0.estado != 7 ORDER BY nombre ASC"); 

        } catch (\Exception $e){
        
            DB::rollBack();
            $response = array(
                'type' => '0',
                'message' => "ERROR ".$e
            );
            $rec->headers->set('Accept', 'application/json');
            echo json_encode($response);
            exit;
        }
        DB::commit();
        $response = array(
            'type' => 1,
            'listarclientes' => $listarclientes,
            'message' => 'REGISTRO EXITOSO',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
        //echo json_encode($listarproyectos);
    }

    public function actualizarCliente($rec)
    {
        //echo json_encode($rec->id);
        //exit;
        $db_name = "constructora_sys.clientes";
 
        DB::beginTransaction();
        try {
 
            DB::connection($this->cur_connect)->update("UPDATE ".$db_name." 
                    SET nombres= '".$rec->nombres."',
                        apellidos= '".$rec->apellidos."',
                        ciudad= '".$rec->ciudad."',
                        telefono= '".$rec->telefono."',
                        mobile= '".$rec->mobile."',
                        email= '".$rec->email."',
                        direccion= '".$rec->direccion."',
                        observacion= '".$rec->observacion."',
                        estado= '".$rec->estado."',
                        fechacreacion= '".$rec->fechacreacion."',
                        fechamodificacion= '".$rec->fechamodificacion."'
                WHERE id = '".$rec->id."'");
 
        } catch (\Exception $e){
 
            DB::rollBack();
            $response = array(
                'type' => '0',
                'message' => "ERROR ".$e
            );
            echo json_encode($response);
            exit;
        }
        DB::commit();
 
        $response = array(
             'type' => 1,
             'message' => 'PROCESO EXITOSO'
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    // Listar parqueaderos por torre y proyecto
    public function listarParqueaderos($rec)
    {
        DB::beginTransaction();
        try {
        $db_name = "constructora_sys";
                
        $listarparqueaderos = DB::connection($this->cur_connect)->select(
                                                "select t0.*, t1.nombre as nombreproyecto, t2.nombre as nombretorre,
                                                        t3.nombre as nombreestado 
                                                from ".$db_name.'.parqueaderos'." t0 
                                                JOIN ".$db_name.'.proyectos'." t1 ON t0.idproyecto = t1.id
                                                JOIN ".$db_name.'.torres'."  t2 ON t0.idtorre = t2.id
                                                JOIN ".$db_name.'.estados'." t3 ON t0.estado = t3.id
                                                WHERE t0.estado != 7 
                                                  && t0.idproyecto = '". $rec->proyecto."' 
                                                  && t2.proyecto = '". $rec->proyecto."' 
                                                  && t0.idtorre = '". $rec->idtorre."'ORDER BY idparqueadero ASC");  
                    

        } catch (\Exception $e){
        
            DB::rollBack();
            $response = array(
                'type' => '0',
                'message' => "ERROR ".$e
            );
            $rec->headers->set('Accept', 'application/json');
            echo json_encode($response);
            exit;
        }
        DB::commit();
        $response = array(
            'type' => 1,
            'listarparqueaderos' => $listarparqueaderos,
            'message' => 'REGISTRO EXITOSO',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
        //echo json_encode($listarproyectos);
    }

    // Listar parqueaderos por torre y proyecto
    public function listarAcabados($rec)
    {
        DB::beginTransaction();
        try {
        $db_name = "constructora_sys";
                
        $listaracabados = DB::connection($this->cur_connect)->select(
                                                "select t0.*, t1.nombre as nombreestado 
                                                from ".$db_name.'.tiposdeacabados'." t0 
                                                JOIN ".$db_name.'.estados'." t1 ON t0.estado = t1.id
                                                WHERE t0.estado != 7 ORDER BY id ASC");  
                    

        } catch (\Exception $e){
        
            DB::rollBack();
            $response = array(
                'type' => '0',
                'message' => "ERROR ".$e
            );
            $rec->headers->set('Accept', 'application/json');
            echo json_encode($response);
            exit;
        }
        DB::commit();
        $response = array(
            'type' => 1,
            'listaracabados' => $listaracabados,
            'message' => 'REGISTRO EXITOSO',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
        //echo json_encode($listarproyectos);
    }

    // Listar valores premisas
    public function listarPremisas($rec)
    {
        DB::beginTransaction();
        try {
        $db_name = "constructora_sys";
                
        $listarpremisas = DB::connection($this->cur_connect)->select(
                                                "select t0.*, t1.nombre as nombreestado 
                                                from ".$db_name.'.premisasproyectos'." t0 
                                                JOIN ".$db_name.'.estados'." t1 ON t0.estado = t1.id
                                                WHERE t0.estado != 7 ORDER BY id ASC");  
                    

        } catch (\Exception $e){
        
            DB::rollBack();
            $response = array(
                'type' => '0',
                'message' => "ERROR ".$e
            );
            $rec->headers->set('Accept', 'application/json');
            echo json_encode($response);
            exit;
        }
        DB::commit();
        $response = array(
            'type' => 1,
            'listarpremisas' => $listarpremisas,
            'message' => 'REGISTRO EXITOSO',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
        //echo json_encode($listarproyectos);
    }
    // Listar valores premisas
    public function listarPrecioM2Inmueble($rec)
    {
        DB::beginTransaction();
        try {
        $db_name = "constructora_sys";
                
        $listarpreciom2 = DB::connection($this->cur_connect)->select(
                                                "select t0.*, t1.nombre as nombreestado 
                                                from ".$db_name.'.valormt2porinmueble'." t0 
                                                JOIN ".$db_name.'.estados'." t1 ON t0.estado = t1.id
                                                WHERE t0.estado != 7 && t0.idproyecto = '". $rec->proyecto."' &&
                                                t0.idtorre = '". $rec->idtorre."'ORDER BY id ASC"); 

        } catch (\Exception $e){
        
            DB::rollBack();
            $response = array(
                'type' => '0',
                'message' => "ERROR ".$e
            );
            $rec->headers->set('Accept', 'application/json');
            echo json_encode($response);
            exit;
        }
        DB::commit();
        $response = array(
            'type' => 1,
            'listarpreciom2' => $listarpreciom2,
            'message' => 'REGISTRO EXITOSO',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
        //echo json_encode($listarproyectos);
    }
    // Listar ciudades creadas en la base de datos
    public function listarEstratos($rec)
    {
        $db_name = "constructora_sys";
            
        $listarestratos = DB::connection($this->cur_connect)->select(
                                                "select t0.* 
                                                from ".$db_name.'.estratos'." t0 
                                                ORDER BY id DESC"); 
        
        echo json_encode($listarestratos);
    }

    // Listar tipos de inmuebles creadas en la base de datos
    public function listarTipoInmueble($rec)
    {
        $db_name = "constructora_sys";
            
        $listartiposinmuebles = DB::connection($this->cur_connect)->select(
                                                "select t0.* 
                                                from ".$db_name.'.tipoinmueble'." t0 
                                                ORDER BY id DESC"); 
        
        echo json_encode($listartiposinmuebles);
    }

    // Listar tipos de porterias creadas en la base de datos
    public function listarPorteria($rec)
    {
        $db_name = "constructora_sys";
                
        $listarporterias = DB::connection($this->cur_connect)->select(
                                                "select t0.* 
                                                from ".$db_name.'.porteria'." t0 
                                                ORDER BY id DESC"); 
            
        echo json_encode($listarporterias);
    }
    
    // Listar tipos de porterias creadas en la base de datos
    public function listarEstados($rec)
    {
        $db_name = "constructora_sys";
                    
        $listarestados = DB::connection($this->cur_connect)->select(
                                                "select t0.* 
                                                from ".$db_name.'.estados'." t0 
                                                ORDER BY id DESC"); 
                
        echo json_encode($listarestados);
    }

    //Crear torre proyecto inmobiliario
    public function crearCotizacion($rec)
    {
        DB::beginTransaction();
        try {
                //$db_name = $this->db.".productos";
                $db_name = "constructora_sys.cotizaciones";
                $crearCotizacion = new ModelGlobal();
                $crearCotizacion->setConnection($this->cur_connect);
                $crearCotizacion->setTable($db_name);
  
                $crearCotizacion -> idproyecto = $rec-> idproyecto;
                $crearCotizacion -> fechacotizacion = $rec-> fechacotizacion;
                $crearCotizacion -> nombreproyecto = $rec-> nombreproyecto;
                $crearCotizacion -> nombreapartamento = $rec-> nombreapartamento;
                $crearCotizacion -> numeroapartamento = $rec-> numeroapartamento;
                $crearCotizacion -> nombrecliente = $rec-> nombrecliente;
                $crearCotizacion -> direccioncliente = $rec-> direccioncliente;
                $crearCotizacion -> identificacioncliente = $rec-> identificacioncliente;
                $crearCotizacion -> celularcliente = $rec-> celularcliente;
                $crearCotizacion -> emailclient = $rec-> emailclient;
                $crearCotizacion -> parqueaderomoto = $rec-> parqueaderomoto;
                $crearCotizacion -> parqueaderocarro = $rec-> parqueaderocarro;
                $crearCotizacion -> cuartoutil = $rec-> cuartoutil;
                $crearCotizacion -> nombreacabado = $rec-> nombreacabado;
                $crearCotizacion -> valoraapartamento = $rec-> valoraapartamento;
                $crearCotizacion -> valorseguroanual = $rec-> valorseguroanual;
                $crearCotizacion -> valorseguromes = $rec-> valorseguromes;
                $crearCotizacion -> valortotalapto = $rec-> valortotalapto;
                $crearCotizacion -> porcentajecuotaini = $rec-> porcentajecuotaini;
                $crearCotizacion -> valorcuuotainicial = $rec-> valorcuuotainicial;
                $crearCotizacion -> valorcuotaextra = $rec-> valorcuotaextra;
                $crearCotizacion -> plazocuotainicial = $rec-> plazocuotainicial;
                $crearCotizacion -> valorparqueaderocarro = $rec-> valorparqueaderocarro;
                $crearCotizacion -> plazomesesfinanciar = $rec-> plazomesesfinanciar;
                $crearCotizacion -> valorcuotainimes = $rec-> valorcuotainimes;
                $crearCotizacion -> valorfinanciar = $rec-> valorfinanciar;
                $crearCotizacion -> valorcuotafija = $rec-> valorcuotafija;
                $crearCotizacion -> valornetoapartamento = $rec-> valornetoapartamento;
                $crearCotizacion -> descuentoporcentaje = $rec-> descuentoporcentaje;
                $crearCotizacion -> valorparqueaderomoto = $rec-> valorparqueaderomoto;
                $crearCotizacion -> valorcuartoutil = $rec-> valorcuartoutil;
                $crearCotizacion -> observaciones = $rec-> observaciones;
                $crearCotizacion -> cuotaextra = $rec-> cuotaextra;
                $crearCotizacion -> descuentototal = $rec-> descuentototal;
                $crearCotizacion -> valorobragris = $rec-> valorobragris;
                $crearCotizacion -> descuentovalor = $rec-> descuentovalor;
                $crearCotizacion -> valorobrablanca = $rec-> valorobrablanca;
                $crearCotizacion -> descuentovalorblanca = $rec-> descuentovalorblanca;
                $crearCotizacion -> valornetoobrablanca = $rec-> valornetoobrablanca;
                $crearCotizacion -> valorcuotaextrablanca = $rec-> valorcuotaextrablanca;
                $crearCotizacion -> valorcuotaextragris = $rec-> valorcuotaextragris;
                $crearCotizacion -> valortotalaptoblanca = $rec-> valortotalaptoblanca;
                $crearCotizacion -> valorcuotainicialblanca = $rec-> valorcuotainicialblanca;
                $crearCotizacion -> valorcuotainimesblanca = $rec-> valorcuotainimesblanca;
                $crearCotizacion -> valorfinanciarblanca = $rec-> valorfinanciarblanca;
                $crearCotizacion -> valorcuotafijablanca = $rec-> valorcuotafijablanca;
                $crearCotizacion -> totalapto = $rec-> totalapto;
                $crearCotizacion -> totalcuotainicial = $rec-> totalcuotainicial;
                $crearCotizacion -> totalafinanciar = $rec-> totalafinanciar;
                $crearCotizacion -> totalcuotafija = $rec-> totalcuotafija;
                $crearCotizacion -> estado = $rec-> estado;
                
                $crearCotizacion->save();
  
        } catch (\Exception $e){
  
            DB::rollBack();
            $response = array(
                'type' => '0',
                'message' => "ERROR ".$e
            );
            $rec->headers->set('Accept', 'application/json');
            echo json_encode($response);
            exit;
        }
        DB::commit();
        $response = array(
            'type' => 1,
            'message' => 'REGISTRO EXITOSO',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }
    
    // Listar cotizaciones
    public function listarCotizaciones($rec)
    {
        DB::beginTransaction();
        try {
        $db_name = "constructora_sys";
        /*
       $listarcotizaciones = DB::connection($this->cur_connect)->select(
                                                "select t0.*, t1.nombre as nombreestado 
                                                from ".$db_name.'.cotizaciones'." t0 
                                                JOIN ".$db_name.'.estados'." t1 ON t0.estado = t1.id
                                                WHERE t0.estado != 7 && t0.idproyecto = '". $rec->proyecto."'
                                                ORDER BY id ASC");  
                    
        */
                
        $listarcotizaciones = DB::connection($this->cur_connect)->select(
                                                "select t0.*, t1.nombre as nombreestado 
                                                from ".$db_name.'.cotizaciones'." t0 
                                                JOIN ".$db_name.'.estados'." t1 ON t0.estado = t1.id
                                                WHERE t0.estado != 7 && t0.idproyecto = '". $rec->proyecto."'
                                                ORDER BY id DESC");  
                    

        } catch (\Exception $e){
        
            DB::rollBack();
            $response = array(
                'type' => '0',
                'message' => "ERROR ".$e
            );
            $rec->headers->set('Accept', 'application/json');
            echo json_encode($response);
            exit;
        }
        DB::commit();
        $response = array(
            'type' => 1,
            'listarcotizaciones' => $listarcotizaciones,
            'message' => 'REGISTRO EXITOSO',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
        //echo json_encode($listarproyectos);
    }

    //Actualizar cotización proyecto inmobiliario
    public function actualizarCotizacion($rec)
    {
        //echo json_encode($rec->id);
        //exit;
        $db_name = "constructora_sys.cotizaciones";
 
        DB::beginTransaction();
        try {
 
            DB::connection($this->cur_connect)->update("UPDATE ".$db_name." 
                    SET idproyecto = '".$rec-> idproyecto."',
                        fechacotizacion= '".$rec-> fechacotizacion."',
                        nombreproyecto= '".$rec-> nombreproyecto."',
                        nombreapartamento= '".$rec-> nombreapartamento."',
                        numeroapartamento = '".$rec-> numeroapartamento."',
                        nombrecliente= '".$rec-> nombrecliente."',
                        direccioncliente= '".$rec-> direccioncliente."',
                        identificacioncliente= '".$rec-> identificacioncliente."',
                        celularcliente= '".$rec-> celularcliente."',
                        emailclient= '".$rec-> emailclient."',
                        parqueaderomoto= '".$rec-> parqueaderomoto."',
                        parqueaderocarro= '".$rec-> parqueaderocarro."',
                        nombreacabado= '".$rec-> nombreacabado."',
                        valoraapartamento= '".$rec-> valoraapartamento."',
                        valorseguroanual= '".$rec-> valorseguroanual."',
                        valorseguromes= '".$rec-> valorseguromes."',
                        valortotalapto= '".$rec-> valortotalapto."',
                        porcentajecuotaini= '".$rec-> porcentajecuotaini."',
                        valorcuuotainicial= '".$rec-> valorcuuotainicial."',
                        valorcuotaextra= '".$rec-> valorcuotaextra."',
                        plazocuotainicial= '".$rec-> plazocuotainicial."',
                        valorparqueaderocarro= '".$rec-> valorparqueaderocarro."',
                        plazomesesfinanciar= '".$rec-> plazomesesfinanciar."',
                        valorcuotainimes= '".$rec-> valorcuotainimes."',
                        valorfinanciar= '".$rec-> valorfinanciar."',
                        valorcuotafija= '".$rec-> valorcuotafija."',
                        valornetoapartamento= '".$rec-> valornetoapartamento."',
                        descuentoporcentaje= '".$rec-> descuentoporcentaje."',
                        valorparqueaderomoto= '".$rec-> valorparqueaderomoto."',
                        observaciones= '".$rec-> observaciones."',
                        cuotaextra= '".$rec-> cuotaextra."',
                        estado= '".$rec-> estado."'
                  WHERE id = '".$rec->id."'");
 
        } catch (\Exception $e){
 
            DB::rollBack();
            $response = array(
                'type' => '0',
                'message' => "ERROR ".$e
            );
            echo json_encode($response);
            exit;
        }
        DB::commit();
 
        $response = array(
             'type' => 1,
             'message' => 'PROCESO EXITOSO'
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    //Registrar estado del inmuble
    public function crearGestion($rec)
    {
        DB::beginTransaction();
        try {
                //$db_name = $this->db.".productos";
                $db_name = "constructora_sys.gestioninmuebles";
                $GestionarInmueble = new ModelGlobal();
                $GestionarInmueble->setConnection($this->cur_connect);
                $GestionarInmueble->setTable($db_name);
  	
                $GestionarInmueble->idproyecto = $rec->idproyecto;	
                $GestionarInmueble->idtorre = $rec->idtorre;	
                $GestionarInmueble->idinmueble = $rec->idinmueble;	
                $GestionarInmueble->area = $rec->area;	
                $GestionarInmueble->cliente = $rec->cliente;	
                $GestionarInmueble->precio = $rec->precio;	
                $GestionarInmueble->nota = $rec->nota;	
                $GestionarInmueble->estado = $rec->estado;	
                $GestionarInmueble->fechacreacion = $rec->fechacreacion;	
                $GestionarInmueble->fechamodificacion = $rec->fechamodificacion;
  
                $GestionarInmueble->save();
  
        } catch (\Exception $e){
  
            DB::rollBack();
            $response = array(
                'type' => '0',
                'message' => "ERROR ".$e
            );
            $rec->headers->set('Accept', 'application/json');
            echo json_encode($response);
            exit;
        }
        DB::commit();
        $response = array(
            'type' => 1,
            'message' => 'REGISTRO EXITOSO',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    // Listar cotizaciones
    public function ultimoNumeroCotizacion($rec)
    {
        DB::beginTransaction();
        try {
        $db_name = "constructora_sys";
        /*
       $listarcotizaciones = DB::connection($this->cur_connect)->select(
                                                "select t0.*, t1.nombre as nombreestado 
                                                from ".$db_name.'.cotizaciones'." t0 
                                                JOIN ".$db_name.'.estados'." t1 ON t0.estado = t1.id
                                                WHERE t0.estado != 7 && t0.idproyecto = '". $rec->proyecto."'
                                                ORDER BY id ASC");  
                    
        */
                
        $ultimoregistro = DB::connection($this->cur_connect)->select(
                                                "SELECT max(t0.id) as ultimoregistro
                                                 from ".$db_name.'.cotizaciones'." t0");  
                    
        } catch (\Exception $e){
        
            DB::rollBack();
            $response = array(
                'type' => '0',
                'message' => "ERROR ".$e
            );
            $rec->headers->set('Accept', 'application/json');
            echo json_encode($response);
            exit;
        }
        DB::commit();
        $response = array(
            'type' => 1,
            'ultimoregistro' => $ultimoregistro,
            'message' => 'REGISTRO EXITOSO',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
        //echo json_encode($listarproyectos);
    }

    // Listar ciudades creadas en la base de datos
    public function listarUsuarios($rec)
    {
        $db_name = "constructora_sys";
            
        $listarciudades = DB::connection($this->cur_connect)->select(
                                                "select t0.* 
                                                from ".$db_name.'.users'." t0 
                                                ORDER BY id DESC"); 
        
        echo json_encode($listarciudades);
    }
    
    //Authenticacion de Cosmos
    public function authenticateConstructora($rec)
    {
        $db_name = "constructora_sys";
        $curConstructora = current(DB::connection($this->cur_connect)->select(
                                                  "select t0.id as value, t0.name as label, t0.*, 
                                                   t0.* from ".$db_name.'.users'." 
                                                   t0 WHERE activo = 1 && uid = '". $rec->uid."'"));
 
        //echo json_encode($curConstructora);
        //exit;
        $curUser = array(
             'displayName' => $curConstructora->name,//$user->displayName,
             'email' => $curConstructora->email,
             'passwordHash' => $curConstructora->password,//$user->passwordHash,
             'phoneNumber' => $curConstructora->telefono,//$user->phoneNumber,
             'token' => $rec->token,
             'uid' => $curConstructora->uid,
             'tokensValidAfterTime' => 0,//$user->tokensValidAfterTime,
             'photoUrl' => $curConstructora->avatar, //$curConstructora->brk_avatar,
             'role' => 'admin',
             'component' => $curConstructora->page,
             'proyecto' => $curConstructora->proyecto,
             'id' => $curConstructora->id,
             'password' => $rec->password
        );
 
        //echo json_encode($curUser);
        //exit;
        //valido que el usuario este activo
        
         if($curConstructora->activo == 0){
             $response = array(
                 'type' => 0,
                 'message' => 'Usuario Inexistente en la Constructora... contacte un asesor',
                 'user' => $user
             );
             echo json_encode($response);
             exit;
         }
 
         $response = array(
             'type' => 1,
             'message' => "Credenciales Correctas",
             'userData' => $curUser,
             'accessToken' => $rec->token,
         );
         echo json_encode($response);
         exit;          
    }    

    public function cwrTipoIdentificacion($rec)
    {
        $db_name = "cyclewear_sys";

        $tiposidentificacion = DB::connection($this->cur_connect)->select("select t0.* 
                                                                   from ".$db_name.'.tipoidentificacion'." t0 
                                                                   WHERE t0.estado = 1 ORDER BY tipoidentificacion ASC");

        $tiposidentifi = array();

        $response = array(
            'type' => 1,
            'message' => "Lectura correcta",
            'userData' => $tiposidentificacion,
            'accessToken' => 0,
        );
        echo json_encode($response);
        exit; 
    }

    public function cwrActualizarConsecutivos($rec)
    {
        echo json_encode($rec->uid);
        exit;
        $db_name = $this->db.".consecutivoscategorias";
 
        DB::beginTransaction();
        try {
 
            DB::connection($this->cur_connect)->update("UPDATE ".$db_name." 
                SET consecutivo = '".$rec->consecutivo."'
                WHERE codigo = '".$rec->prefijo."'");
 
        } catch (\Exception $e){
 
            DB::rollBack();
            $response = array(
                'type' => '0',
                'message' => "ERROR ".$e
            );
            echo json_encode($response);
            exit;
        }
        DB::commit();
 
        $response = array(
             'type' => 1,
             'message' => 'PROCESO EXITOSO'
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    //Listar ventas inmuebles
    public function listarVentasInmuebles($rec)
    {
        DB::beginTransaction();
        try {
        $db_name = "constructora_sys";
                
        $listarventasinmuebles = DB::connection($this->cur_connect)->select(
                                                "select t0.*, t1.nombre, t2.nombres, t2.apellidos,
                                                        t3.nombre as nombreacabado 
                                                from ".$db_name.'.inmueblesvendidos'." t0 
                                                JOIN ".$db_name.'.proyectos'." t1 ON t0.idproyecto = t1.id
                                                JOIN ".$db_name.'.clientes'." t2 ON t0.cliente = t2.id
                                                JOIN ".$db_name.'.tiposdeacabados'." t3 ON t0.tipodeacabado = t3.id
                                                WHERE t0.idproyecto = '".$rec->proyecto."'
                                                ORDER BY idinmueble DESC");  
                    
        } catch (\Exception $e){
        
            DB::rollBack();
            $response = array(
                'type' => '0',
                'message' => "ERROR ".$e
            );
            $rec->headers->set('Accept', 'application/json');
            echo json_encode($response);
            exit;
        }
        DB::commit();
        $response = array(
            'type' => 1,
            'listarventasinmuebles' => $listarventasinmuebles,
            'message' => 'REGISTRO EXITOSO',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
        //echo json_encode($listarproyectos);
    }

    //grabar inmuebles vendidos
    public function crearInmueblesVendidos($rec)
    {
        DB::beginTransaction();
        try {
                //$db_name = $this->db.".productos";
                $db_name = "constructora_sys.inmueblesvendidos";
                $crearInmueblesVendidos = new ModelGlobal();
                $crearInmueblesVendidos->setConnection($this->cur_connect);
                $crearInmueblesVendidos->setTable($db_name);
  
                $crearInmueblesVendidos->idproyecto = $rec-> idproyecto;
                $crearInmueblesVendidos->idtorre = $rec-> idtorre;
                $crearInmueblesVendidos->idinmueble = $rec-> idinmueble;
                $crearInmueblesVendidos->idapartamento = $rec-> idapartamento;
                $crearInmueblesVendidos->fechaventa = $rec-> fechaventa;
                $crearInmueblesVendidos->cliente = $rec-> cliente;
                $crearInmueblesVendidos->nomapto = $rec-> nomapto;
                $crearInmueblesVendidos->nomparqueadero = $rec-> nomparqueadero;
                $crearInmueblesVendidos->nomutil = $rec-> nomutil;
                $crearInmueblesVendidos->nommoto = $rec-> nommoto;
                $crearInmueblesVendidos->parqueaderocarro = $rec-> parqueaderocarro;
                $crearInmueblesVendidos->parqueaderomoto = $rec-> parqueaderomoto;
                $crearInmueblesVendidos->cuartoutil = $rec-> cuartoutil;
                $crearInmueblesVendidos->tipodeacabado = $rec-> tipodeacabado;
                $crearInmueblesVendidos->valorventa = $rec-> valorventa;
                $crearInmueblesVendidos->cuotamensual = $rec-> cuotamensual;
                $crearInmueblesVendidos->numerocuotaspagadas = $rec-> numerocuotaspagadas;
                $crearInmueblesVendidos->totalpagado = $rec-> totalpagado;
                $crearInmueblesVendidos->valorabonos = $rec-> valorabonos;
                $crearInmueblesVendidos->fechaabono = $rec-> fechaabono;
                $crearInmueblesVendidos->deudaactual = $rec-> deudaactual;
                $crearInmueblesVendidos->comisionpagado = $rec-> comisionpagado;
                $crearInmueblesVendidos->comentarios = $rec-> comentarios;
  
                $crearInmueblesVendidos->save();
  
        } catch (\Exception $e){
  
            DB::rollBack();
            $response = array(
                'type' => '0',
                'message' => "ERROR ".$e
            );
            $rec->headers->set('Accept', 'application/json');
            echo json_encode($response);
            exit;
        }
        DB::commit();
        $response = array(
            'type' => 1,
            'message' => 'REGISTRO EXITOSO',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    //Actualizar Venta del Inmueble
    public function actualizarVentaInmueble($rec)
    {
        //echo json_encode($rec->id);
        //exit;
        $db_name = "constructora_sys.inmueblesvendidos";
 
        DB::beginTransaction();
        try {
 
            DB::connection($this->cur_connect)->update("UPDATE ".$db_name." 
                    SET idproyecto = '".$rec-> idproyecto."',
                        idtorre = '".$rec-> idtorre."',
                        idinmueble = '".$rec-> idinmueble."',
                        fechaventa = '".$rec-> fechaventa."',
                        cliente = '".$rec-> cliente."',
                        parqueaderocarro = '".$rec-> parqueaderocarro."',
                        parqueaderomoto = '".$rec-> parqueaderomoto."',
                        cuartoutil = '".$rec-> cuartoutil."',
                        tipodeacabado = '".$rec-> tipodeacabado."',
                        valorventa = '".$rec-> valorventa."',
                        totalpagado = '".$rec-> totalpagado."',
                        cuotamensual = '".$rec-> cuotamensual."',
                        numerocuotaspagadas = '".$rec-> numerocuotaspagadas."',
                        valorabonos = '".$rec-> valorabonos."',
                        fechaabono = '".$rec-> fechaabono."',
                        deudaactual = '".$rec-> deudaactual."',
                        comisionpagado = '".$rec-> comisionpagado."',
                        comentarios = '".$rec-> comentarios."'
                  WHERE id = '".$rec->id."'");
 
        } catch (\Exception $e){
 
            DB::rollBack();
            $response = array(
                'type' => '0',
                'message' => "ERROR ".$e
            );
            echo json_encode($response);
            exit;
        }
        DB::commit();
 
        $response = array(
             'type' => 1,
             'message' => 'PROCESO EXITOSO'
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    //Resumen inmuebles vendidos
    public function ResumenInmueblesVendidos($rec)
    {
        DB::beginTransaction();
        try {
        $db_name = "constructora_sys";
                
        $resumenventasinmuebles = DB::connection($this->cur_connect)->select(
                                                "select sum(t0.valorventa) AS valorventa, 
                                                COUNT(*) AS aptovendidos, SUM(t0.totalpagado) AS totalpagado,
                                                (COUNT(*)/136)*100 AS porcentajevta
                                                from ".$db_name.'.inmueblesvendidos'." t0 
                                                WHERE t0.idproyecto = '".$rec->proyecto."'");  
                    
        } catch (\Exception $e){
        
            DB::rollBack();
            $response = array(
                'type' => '0',
                'message' => "ERROR ".$e
            );
            $rec->headers->set('Accept', 'application/json');
            echo json_encode($response);
            exit;
        }
        DB::commit();
        $response = array(
            'type' => 1,
            'resumenventasinmuebles' => $resumenventasinmuebles,
            'message' => 'REGISTRO EXITOSO',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
        //echo json_encode($listarproyectos);
    }

    //Resumen inmuebles vendidos
    public function ResumenVtasMes($rec)
    {
        DB::beginTransaction();
        try {
        $db_name = "constructora_sys";

        //$date = date('Y-m-1');
        //$date2 = date('Y-m-31');
        $date = date('Y-m-1');
        $date2 = date('Y-m-31');
        //echo json_encode($date2);
        //exit;
                
        $resumenvtasmes = DB::connection($this->cur_connect)->select(
                                                "select sum(t0.valorventa) AS valorventa, 
                                                COUNT(*) AS aptovendidos, SUM(t0.totalpagado) AS totalpagado,
                                                (COUNT(*)/9)*100 AS porcentajevta
                                                from ".$db_name.'.inmueblesvendidos'." t0 
                                                WHERE t0.idproyecto = '". $rec->proyecto."' 
                                                && t0.fechaventa >= '". $date."'
                                                && t0.fechaventa <= '". $date2."'"); 
                                                /*
                                                WHERE t0.idproyecto = '".$rec->proyecto."'
                                                AND t0.fechaventa >= "2023-10-01"
                                                AND t0.fechaventa <= "2023-10-31"
                                                "); 
                                                */ 
                    
        } catch (\Exception $e){
        
            DB::rollBack();
            $response = array(
                'type' => '0',
                'message' => "ERROR ".$e
            );
            $rec->headers->set('Accept', 'application/json');
            echo json_encode($response);
            exit;
        }
        DB::commit();
        $response = array(
            'type' => 1,
            'resumenvtasmes' => $resumenvtasmes,
            'message' => 'REGISTRO EXITOSO',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
        //echo json_encode($listarproyectos);
    }

    //Resumen inmuebles vendidos
    public function RecaudoMesSigue($rec)
    {
        DB::beginTransaction();
        try {
        $db_name = "constructora_sys";

        //$date = date('Y-m-1');
        //$date2 = date('Y-m-31');
        $date = date('Y-12-1');
        $date2 = date('Y-12-31');
        //$ano = date('Y');
        //echo json_encode($date);
        //exit;
                
        $recaudomessigue = DB::connection($this->cur_connect)->select(
                                                "select sum(t0.valorpago) AS valorrecaudo
                                                from ".$db_name.'.plandepago'." t0 
                                                WHERE t0.idproyecto = '". $rec->proyecto."' 
                                                && t0.fechacreacion >= '". $date."'
                                                && t0.fechacreacion <= '". $date2."'"); 
                    
        } catch (\Exception $e){
        
            DB::rollBack();
            $response = array(
                'type' => '0',
                'message' => "ERROR ".$e
            );
            $rec->headers->set('Accept', 'application/json');
            echo json_encode($response);
            exit;
        }
        DB::commit();
        $response = array(
            'type' => 1,
            'recaudomessigue' => $recaudomessigue,
            'message' => 'REGISTRO EXITOSO',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
        //echo json_encode($listarproyectos);
    }

    //Resumen inmuebles vendidos
    public function RecaudoMes($rec)
    {
        DB::beginTransaction();
        try {
        $db_name = "constructora_sys";

        //$date = date('Y-m-1');
        //$date2 = date('Y-m-31');
        $date = date('Y-m-1');
        $date2 = date('Y-m-31');
        //$ano = date('Y');
        //echo json_encode($date);
        //exit;
                
        $recaudomes = DB::connection($this->cur_connect)->select(
                                                "select sum(t0.valorpago) AS valorrecaudomes
                                                from ".$db_name.'.plandepago'." t0 
                                                WHERE t0.idproyecto = '". $rec->proyecto."' 
                                                && t0.fechacreacion >= '". $date."'
                                                && t0.fechacreacion <= '". $date2."'"); 
                    
        } catch (\Exception $e){
        
            DB::rollBack();
            $response = array(
                'type' => '0',
                'message' => "ERROR ".$e
            );
            $rec->headers->set('Accept', 'application/json');
            echo json_encode($response);
            exit;
        }
        DB::commit();
        $response = array(
            'type' => 1,
            'recaudomes' => $recaudomes,
            'message' => 'REGISTRO EXITOSO',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
        //echo json_encode($listarproyectos);
    }

    //Resumen inmuebles vendidos
    public function RecaudoReal($rec)
    {
        DB::beginTransaction();
        try {
        $db_name = "constructora_sys";

        //$date = date('Y-m-1');
        //$date2 = date('Y-m-31');
        $date = date('Y-m-1');
        $date2 = date('Y-m-31');
        //$ano = date('Y');
        //echo json_encode($date);
        //exit;
                
        $recaudomes = DB::connection($this->cur_connect)->select(
                                                "select sum(t0.valorabonos) AS recaudoreal
                                                from ".$db_name.'.recibosdecaja'." t0 
                                                WHERE t0.idproyecto = '". $rec->proyecto."' 
                                                && t0.fechamovimiento >= '". $date."'
                                                && t0.fechamovimiento <= '". $date2."'"); 
                    
        } catch (\Exception $e){
        
            DB::rollBack();
            $response = array(
                'type' => '0',
                'message' => "ERROR ".$e
            );
            $rec->headers->set('Accept', 'application/json');
            echo json_encode($response);
            exit;
        }
        DB::commit();
        $response = array(
            'type' => 1,
            'recaudomes' => $recaudomes,
            'message' => 'REGISTRO EXITOSO',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
        //echo json_encode($listarproyectos);
    }

    //Resumen inmuebles vendidos
    public function RecaudoMesActual($rec)
    {
        DB::beginTransaction();
        try {
        $db_name = "constructora_sys";
   
        $date = date('Y-m-1');
        $date2 = date('Y-m-31');
        //$date = date('Y-11-1');
        //$date2 = date('Y-11-31');
        //$ano = date('Y');
        //echo json_encode($date);
        //exit;      
        $recaudomes = DB::connection($this->cur_connect)->select(
                                                "select sum(t0.valorabonos) AS recaudoreal
                                                from ".$db_name.'.recibosdecaja'." t0 
                                                WHERE t0.idproyecto = '". $rec->proyecto."' 
                                                && t0.fechamovimiento >= '". $date."'
                                                && t0.fechamovimiento <= '". $date2."'"); 
                       
        } catch (\Exception $e){
            DB::rollBack();
            $response = array(
                'type' => '0',
                'message' => "ERROR ".$e
            );
            $rec->headers->set('Accept', 'application/json');
            echo json_encode($response);
            exit;
        }
        DB::commit();
        $response = array(
            'type' => 1,
            'recaudomes' => $recaudomes,
            'message' => 'REGISTRO EXITOSO',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
        //echo json_encode($listarproyectos);
    }

    //Resumen inmuebles vendidos
    public function RecaudoMesAnterior($rec)
    {
        DB::beginTransaction();
        try {
        $db_name = "constructora_sys";
   
        $fechauno = date('Y-m-1');
        $fechados = date('Y-m-31');

        $date = date("Y-m-d", strtotime($fechauno. '- 1 month'));
        $date2 = date("Y-m-d", strtotime($fechados. '- 1 month'));
        //$date = date('Y-11-1');
        //$date2 = date('Y-11-31');
        //$ano = date('Y');
        //echo json_encode($date);
        //echo json_encode($date2);
        //exit;      
        $recaudomesanterior = DB::connection($this->cur_connect)->select(
                                                "select sum(t0.valorabonos) AS recaudoreal
                                                from ".$db_name.'.recibosdecaja'." t0 
                                                WHERE t0.idproyecto = '". $rec->proyecto."' 
                                                && t0.fechamovimiento >= '". $date."'
                                                && t0.fechamovimiento <= '". $date2."'"); 
                       
        } catch (\Exception $e){
            DB::rollBack();
            $response = array(
                'type' => '0',
                'message' => "ERROR ".$e
            );
            $rec->headers->set('Accept', 'application/json');
            echo json_encode($response);
            exit;
        }
        DB::commit();
        $response = array(
            'type' => 1,
            'recaudomesanterior' => $recaudomesanterior,
            'message' => 'REGISTRO EXITOSO',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
        //echo json_encode($listarproyectos);
    }

    //Resumen inmuebles vendidos
    public function RecaudoAno($rec)
    {
        DB::beginTransaction();
        try {
        $db_name = "constructora_sys";

        //$date = date('Y-m-1');
        //$date2 = date('Y-m-31');
        $date = date('Y-m-1');
        $date2 = date('Y-m-31');
        $ano = date('Y');
        //echo json_encode($ano);
        //exit;
                
        $reacudoano = DB::connection($this->cur_connect)->select(
                                                "select sum(t0.valorpago) AS valorrecaudoanoactual
                                                from ".$db_name.'.plandepago'." t0 
                                                WHERE t0.idproyecto = '". $rec->proyecto."' 
                                                && t0.ano <= '". $ano."'"); 
                    
        } catch (\Exception $e){
        
            DB::rollBack();
            $response = array(
                'type' => '0',
                'message' => "ERROR ".$e
            );
            $rec->headers->set('Accept', 'application/json');
            echo json_encode($response);
            exit;
        }
        DB::commit();
        $response = array(
            'type' => 1,
            'reacudoano' => $reacudoano,
            'message' => 'REGISTRO EXITOSO',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
        //echo json_encode($listarproyectos);
    }

    //Resumen inmuebles vendidos
    public function RecaudoAnoSigue($rec)
    {
        DB::beginTransaction();
        try {
        $db_name = "constructora_sys";

        //$date = date('Y-m-1');
        //$date2 = date('Y-m-31');
        $date = date('Y-m-1');
        $date2 = date('Y-m-31');
        $ano = date('Y')+1;
        //echo json_encode($ano);
        //exit;
                
        $reacudoanosiguiente = DB::connection($this->cur_connect)->select(
                                                "select sum(t0.valorpago) AS valorrecaudoanosigue
                                                from ".$db_name.'.plandepago'." t0 
                                                WHERE t0.idproyecto = '". $rec->proyecto."' 
                                                && t0.ano <= '". $ano."'"); 
                    
        } catch (\Exception $e){
        
            DB::rollBack();
            $response = array(
                'type' => '0',
                'message' => "ERROR ".$e
            );
            $rec->headers->set('Accept', 'application/json');
            echo json_encode($response);
            exit;
        }
        DB::commit();
        $response = array(
            'type' => 1,
            'reacudoanosiguiente' => $reacudoanosiguiente,
            'message' => 'REGISTRO EXITOSO',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
        //echo json_encode($listarproyectos);
    }

    //Actualizar Venta del Inmueble
    public function actualizarAbonoInmueble($rec)
    {
        //echo json_encode($rec->id);
        //exit;
        $db_name = "constructora_sys.inmueblesvendidos";
 
        DB::beginTransaction();
        try {
 //numerocuotaspagadas = '".$rec-> numerocuotaspagadas."',
            DB::connection($this->cur_connect)->update("UPDATE ".$db_name." 
                    SET valorabonos = '".$rec-> valorabonos."',
                        fechaabono = '".$rec-> fechaabono."',
                        numerocuotaspagadas = '".$rec-> numerocuotaspagadas."',
                        deudaactual = '".$rec-> deudaactual."',
                        totalpagado = '".$rec-> totalpagado."',
                        comentarios = '".$rec-> comentarios."'
                  WHERE id = '".$rec->id."'");
 
        } catch (\Exception $e){
 
            DB::rollBack();
            $response = array(
                'type' => '0',
                'message' => "ERROR ".$e
            );
            echo json_encode($response);
            exit;
        }
        DB::commit();
 
        $response = array(
             'type' => 1,
             'message' => 'PROCESO EXITOSO'
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    //grabar recibo de caja
    public function crearReciboCaja($rec)
    {
         DB::beginTransaction();
         try {
                //$db_name = $this->db.".productos";
                $db_name = "constructora_sys.recibosdecaja";
                $grabarReciboCaja = new ModelGlobal();
                $grabarReciboCaja->setConnection($this->cur_connect);
                $grabarReciboCaja->setTable($db_name);
   
                $grabarReciboCaja->id = $rec-> id;
                $grabarReciboCaja->idproyecto = $rec-> idproyecto;
                $grabarReciboCaja->idtorre = $rec-> idtorre;
                $grabarReciboCaja->idinmueble = $rec-> idinmueble;
                $grabarReciboCaja->fechamovimiento = $rec-> fechamovimiento;
                $grabarReciboCaja->cliente = $rec-> cliente;
                $grabarReciboCaja->nomapto = $rec-> nomapto;
                $grabarReciboCaja->nomparqueadero = $rec-> nomparqueadero;
                $grabarReciboCaja->nomutil = $rec-> nomutil;
                $grabarReciboCaja->nommoto = $rec-> nommoto;
                $grabarReciboCaja->valorabonos = $rec-> valorabonos;
                $grabarReciboCaja->deudaactual = $rec-> deudaactual;
                $grabarReciboCaja->numerocuotaspagadas = $rec-> numerocuotaspagadas;
                $grabarReciboCaja->comentarios = $rec-> comentarios;
   
                $grabarReciboCaja->save();
   
         } catch (\Exception $e){
   
             DB::rollBack();
             $response = array(
                 'type' => '0',
                 'message' => "ERROR ".$e
             );
             $rec->headers->set('Accept', 'application/json');
             echo json_encode($response);
             exit;
         }
         DB::commit();
         $response = array(
             'type' => 1,
             'message' => 'REGISTRO EXITOSO',
         );
         $rec->headers->set('Accept', 'application/json');
         echo json_encode($response);
         exit;
    }

    //Listar ventas inmuebles
    public function listarReciboCaja($rec)
    {
        DB::beginTransaction();
        try {
        $db_name = "constructora_sys";
                
        $listarrecibocaja = DB::connection($this->cur_connect)->select(
                                                "select t0.*, t1.nombre, t2.nombres, t2.apellidos, t2.cedula,
                                                        t2.direccion, t2.telefono, t4.nombre as acabado,
                                                        t3.valorventa, t3.cuotamensual, t3.deudaactual as saldodeuda,
                                                        t3.totalpagado, t3.parqueaderocarro, t3.cuartoutil,
                                                        t3.parqueaderomoto, t2.mobile, t5.nomapto, t5.nomparqueadero,
                                                        t5.nomutil
                                                from ".$db_name.'.recibosdecaja'." t0 
                                                JOIN ".$db_name.'.proyectos'." t1 ON t0.idproyecto = t1.id
                                                JOIN ".$db_name.'.clientes'." t2 ON t0.cliente = t2.id
                                                JOIN ".$db_name.'.inmuebles'." t5 ON t0.idproyecto = t5.idproyecto && 
                                                t0.idtorre = t5.idtorre && t0.idinmueble = t5.idinmueble
                                                JOIN ".$db_name.'.inmueblesvendidos'." t3 ON t3.idapartamento = t5.id
                                                JOIN ".$db_name.'.tiposdeacabados'." t4 ON t3.tipodeacabado = t4.id
                                                WHERE t0.idproyecto = '".$rec->proyecto."'
                                                  AND t0.idtorre = '".$rec->torre."'
                                                ORDER BY fechamovimiento DESC");  
                    
        } catch (\Exception $e){
        
            DB::rollBack();
            $response = array(
                'type' => '0',
                'message' => "ERROR ".$e
            );
            $rec->headers->set('Accept', 'application/json');
            echo json_encode($response);
            exit;
        }
        DB::commit();
        $response = array(
            'type' => 1,
            'listarrecibocaja' => $listarrecibocaja,
            'message' => 'REGISTRO EXITOSO',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
        //echo json_encode($listarproyectos);
    }

    //Actualizar Venta del Inmueble
    public function actualizarReciboCaja($rec)
    {
        //echo json_encode($rec->id);
        //exit;
        $db_name = "constructora_sys.recibosdecaja";
 
        DB::beginTransaction();
        try {
 
            DB::connection($this->cur_connect)->update("UPDATE ".$db_name." 
                    SET idproyecto = '".$rec-> idproyecto."',
                        idtorre = '".$rec-> idtorre."',
                        idinmueble = '".$rec-> idinmueble."',
                        fechamovimiento = '".$rec-> fechamovimiento."',
                        cliente = '".$rec-> cliente."',
                        valorabonos = '".$rec-> valorabonos."',
                        numerocuotaspagadas = '".$rec-> numerocuotaspagadas."',
                        comentarios = '".$rec-> comentarios."'
                  WHERE id = '".$rec->id."'");
 
        } catch (\Exception $e){
 
            DB::rollBack();
            $response = array(
                'type' => '0',
                'message' => "ERROR ".$e
            );
            echo json_encode($response);
            exit;
        }
        DB::commit();
 
        $response = array(
             'type' => 1,
             'message' => 'PROCESO EXITOSO'
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    public function crearConsecutivo($rec)
    {
        //echo json_encode($rec->estado);
        //exit;
        DB::beginTransaction();
        try {
                    $db_name = $this->db.".consecutivos";
                    $consecutivos = new ModelGlobal();
                    $consecutivos->setConnection($this->cur_connect);
                    $consecutivos->setTable($db_name);

                    $consecutivos->nombre = $rec->nombre;
                    $consecutivos->descripcion = $rec->descripcion;
                    $consecutivos->consecutivo = $rec->consecutivo;
                    $consecutivos->estado = $rec->estado;
                    
                    $consecutivos->save();

        } catch (\Exception $e){

            DB::rollBack();
            $response = array(
                'type' => '0',
                'message' => "ERROR ".$e
            );
            $rec->headers->set('Accept', 'application/json');
            echo json_encode($response);
            exit;
        }
        DB::commit();
        $response = array(
            'type' => 1,
            'message' => 'REGISTRO VEHICULOS COMPATIBLES EXITOSO',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    public function listarConsecutivo($rec)
    {
        DB::beginTransaction();
        try {
        $db_name = "constructora_sys";
                
        $consecutivorc = DB::connection($this->cur_connect)->select(
                                                "select t0.*
                                                from ".$db_name.'.consecutivos'." t0 
                                                WHERE t0.id = ".$rec->id);

        } catch (\Exception $e){
        
            DB::rollBack();
            $response = array(
                'type' => '0',
                'message' => "ERROR ".$e
            );
            $rec->headers->set('Accept', 'application/json');
            echo json_encode($response);
            exit;
        }
        DB::commit();
        $response = array(
            'type' => 1,
            'consecutivorc' => $consecutivorc,
            'message' => 'REGISTRO EXITOSO',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    //Actualizar Consecutivo MR
    public function actualizarConsecutivoRC($rec)
    {
        //echo json_encode($rec->id);
        //exit;
        $db_name = $this->db.".consecutivos";
   
        DB::beginTransaction();
        try {
            DB::connection($this->cur_connect)->update("UPDATE ".$db_name."
            SET consecutivo = '".$rec->siguiente."' WHERE id = '".$rec->id."'");
          } catch (\Exception $e){
   
              DB::rollBack();
              $response = array(
                  'type' => '0',
                  'message' => "ERROR ".$e
              );
              echo json_encode($response);
              exit;
        }
        DB::commit();
   
        $response = array(
               'type' => 1,
               'message' => 'PROCESO EXITOSO'
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    //grabar plan de pago del inmueble
    public function crearPlanPago($rec)
    {
        DB::beginTransaction();
        try {
                //$db_name = $this->db.".productos";
                $db_name = "constructora_sys.plandepago";
                $grabarPlanPago = new ModelGlobal();
                $grabarPlanPago->setConnection($this->cur_connect);
                $grabarPlanPago->setTable($db_name);

                $grabarPlanPago->idproyecto = $rec-> idproyecto;
                $grabarPlanPago->idtorre = $rec-> idtorre;
                $grabarPlanPago->idinmueble = $rec-> idinmueble;
                $grabarPlanPago->fechacreacion = $rec-> fechacreacion;
                $grabarPlanPago->valorpago = $rec-> valorpago;
                $grabarPlanPago->estado = $rec-> estado;
                $grabarPlanPago->comentarios = $rec-> comentarios;

                $grabarPlanPago->save();

        } catch (\Exception $e){

            DB::rollBack();
            $response = array(
                'type' => '0',
                'message' => "ERROR ".$e
            );
            $rec->headers->set('Accept', 'application/json');
            echo json_encode($response);
            exit;
        }
        DB::commit();
        $response = array(
            'type' => 1,
            'message' => 'REGISTRO EXITOSO',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    //Listar ventas inmuebles
    public function listarPlanPago($rec)
    {
        DB::beginTransaction();
        try {
        $db_name = "constructora_sys";
                
        $listarplanpago = DB::connection($this->cur_connect)->select(
                                                "select t0.*, t1.nombre as nombreproyecto, t2.nombre as nombretorre,
                                                        concat(t3.nombres  ,' ', t3.apellidos) as nombrecliente,
                                                        t5.nombre as estadocuota
                                                from ".$db_name.'.plandepago'." t0 
                                                JOIN ".$db_name.'.proyectos'." t1 ON t0.idproyecto = t1.id
                                                JOIN ".$db_name.'.torres'." t2 ON t0.idtorre = t2.id
                                                JOIN ".$db_name.'.inmueblesvendidos'." t4 ON t0.idinmueble = t4.idinmueble
                                                JOIN ".$db_name.'.clientes'." t3 ON t4.cliente = t3.id
                                                JOIN ".$db_name.'.estados'." t5 ON t0.estado = t5.id
                                                WHERE t0.estado != 21
                                                  && t2.proyecto = '". $rec->proyecto."' 
                                                  && t0.idproyecto = '".$rec->proyecto."'
                                                ORDER BY idinmueble, fechacreacion ASC");  
                    
        } catch (\Exception $e){
        
            DB::rollBack();
            $response = array(
                'type' => '0',
                'message' => "ERROR ".$e
            );
            $rec->headers->set('Accept', 'application/json');
            echo json_encode($response);
            exit;
        }
        DB::commit();
        $response = array(
            'type' => 1,
            'listarplanpago' => $listarplanpago,
            'message' => 'REGISTRO EXITOSO',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
        //echo json_encode($listarproyectos);
    }

    //Listar ventas inmuebles
    public function checkPaymentPlan($rec)
    {
        DB::beginTransaction();
        try {
        $db_name = "constructora_sys";
                
        $listarplanpago = DB::connection($this->cur_connect)->select(
                                                "select t0.*
                                                from ".$db_name.'.plandepago'." t0 
                                                WHERE t0.idproyecto = '".$rec->proyecto."'
                                                ORDER BY idinmueble, fechacreacion ASC");  
                    
        } catch (\Exception $e){
        
            DB::rollBack();
            $response = array(
                'type' => '0',
                'message' => "ERROR ".$e
            );
            $rec->headers->set('Accept', 'application/json');
            echo json_encode($response);
            exit;
        }
        DB::commit();
        $response = array(
            'type' => 1,
            'listarplanpago' => $listarplanpago,
            'message' => 'REGISTRO EXITOSO',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
        //echo json_encode($listarproyectos);
    }

    //Actualizar Venta del Inmueble
    public function actualizarPlanPago($rec)
    {
        //echo json_encode($rec->id);
        //exit;
        $db_name = "constructora_sys.plandepago";

        DB::beginTransaction();
        try {

            DB::connection($this->cur_connect)->update("UPDATE ".$db_name." 
                    SET idproyecto = '".$rec-> idproyecto."',
                        idtorre = '".$rec-> idtorre."',
                        idinmueble = '".$rec-> idinmueble."',
                        fechacreacion = '".$rec-> fechacreacion."',
                        valorpago = '".$rec-> valorpago."',
                        estado = '".$rec-> estado."',
                        comentarios = '".$rec-> comentarios."'
                WHERE id = '".$rec->id."'");

        } catch (\Exception $e){

            DB::rollBack();
            $response = array(
                'type' => '0',
                'message' => "ERROR ".$e
            );
            echo json_encode($response);
            exit;
        }
        DB::commit();

        $response = array(
            'type' => 1,
            'message' => 'PROCESO EXITOSO'
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }


     // Lee la condición del producto
    public function cwrBikeExchange($rec)
    {
        $curl = curl_init();
        $iniciar =  $rec->valor;

        curl_setopt_array($curl, array(
                CURLOPT_URL => "https://www.bikeexchange.com.co/api/v2/client/adverts?page%5Bnumber%5D=".$iniciar."&page%5Bsize%5D=100",
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'GET',
                CURLOPT_HTTPHEADER => array(
                'MARKETPLACER-API-KEY: 4a99fa8c297af70d8878f255f096642b',
                'Authorization: Basic e3t1c2VybmFtZX19Ont7cGFzc3dvcmR9fQ=='
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        echo $response;
    }

    
    // Lee la condición del producto
    public function cwrListarConsecutivos($rec)
    {
        $db_name = "cyclewear_sys";
    
        $consecutivoproducto = DB::connection($this->cur_connect)->select(
                                              "select t0.id as value, t0.descripcion as label,
                                               t0.* from ".$db_name.'.consecutivos'." 
                                               t0 WHERE estado = 1 && prefijo = '". $rec->prefijo."'"); 

    echo json_encode($consecutivoproducto);
    }

    //Crear conscutivo en Base de Datos
    
    // Listar los codigos de los cponsecutivos
    public function ListarConsecutivosCategorias($rec)
    {
        $db_name = "cyclewear_sys";
            
        $listarcodigoscategorias = DB::connection($this->cur_connect)->select(
                                            "select t0.* 
                                            from ".$db_name.'.consecutivoscategorias'." t0 
                                            WHERE estado = 1"); 
        
        echo json_encode($listarcodigoscategorias);
    }
    

    
    
    // Lee la condición del producto
    public function listarUnPedidoDB($rec)
    {
        $db_name = "cyclewear_sys";
    
        $listarunpedido = DB::connection($this->cur_connect)->select(
                                              "select t0.* 
                                               from ".$db_name.'.pedidos'." t0
                                               WHERE id_fact = '". $rec->pedido."'"); 

        echo json_encode($listarunpedido);
    }
    
    //Crear items de pedidos
    public function cwrCrearItemsPedidosBD($rec)
    {

        DB::beginTransaction();
        try {
                $db_name = $this->db.".itemspedidos";
                $itemspedidosventa = new ModelGlobal();
                $itemspedidosventa->setConnection($this->cur_connect);
                $itemspedidosventa->setTable($db_name);

                $itemspedidosventa->itempedido = $rec->itempedido;
                $itemspedidosventa->pedido = $rec->pedido;
                $itemspedidosventa->advert_name = $rec->advert_name;
                

                $itemspedidosventa->save();

        } catch (\Exception $e){

            DB::rollBack();
            $response = array(
                'type' => '0',
                'message' => "ERROR ".$e
            );
            $rec->headers->set('Accept', 'application/json');
            echo json_encode($response);
            exit;
        }
        DB::commit();
        $response = array(
            'type' => 1,
            'message' => 'REGISTRO EXITOSO',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

     //Crear conscutivo en Base de Datos
    public function cwrCreateProduct($rec)
    {
        DB::beginTransaction();
        try {
                $db_name = $this->db.".productos";
                $crearProducto = new ModelGlobal();
                $crearProducto->setConnection($this->cur_connect);
                $crearProducto->setTable($db_name);
 
                $crearProducto->idinterno = $rec->idinterno;
                $crearProducto->codigosiigo = $rec->codigosiigo;
                $crearProducto->codigoproveedor = $rec->codigoproveedor;
                $crearProducto->condicionproducto = $rec->condicionproducto;
                $crearProducto->sexo = $rec->sexo;
                $crearProducto->tipodeproducto = $rec->tipodeproducto;
                $crearProducto->categoriauno = $rec->categoriauno;
                $crearProducto->categoriados = $rec->categoriados;
                $crearProducto->categoriatres = $rec->categoriatres;
                $crearProducto->categoriacuatro = $rec->categoriacuatro;
                $crearProducto->fechaingreso = $rec->fechaingreso;
                $crearProducto->fechamodificacion = $rec->fechamodificacion;
                $crearProducto->estado = $rec->estado;
                $crearProducto->empresa = $rec->empresa;
 
                $crearProducto->save();
 
        } catch (\Exception $e){
 
            DB::rollBack();
            $response = array(
                'type' => '0',
                'message' => "ERROR ".$e
            );
            $rec->headers->set('Accept', 'application/json');
            echo json_encode($response);
            exit;
        }
        DB::commit();
        $response = array(
            'type' => 1,
            'message' => 'REGISTRO EXITOSO',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    //Crear usuario en Base de Datos
    public function cwrCrearProductoDB($rec)
    {
        //echo json_encode($rec->idinterno);
        //exit;
        DB::beginTransaction();
        try {
                $db_name = $this->db.".productos";
                $crearProducto = new ModelGlobal();
                $crearProducto->setConnection($this->cur_connect);
                $crearProducto->setTable($db_name);
 
                $crearProducto->codigo = $rec->codigo;
                $crearProducto->id = $rec->id;
                $crearProducto->sku = $rec->sku;
                $crearProducto->nombre = $rec->nombre;
                $crearProducto->cantidad = $rec->cantidad;
                $crearProducto->idgrupo = $rec->idgrupo;
                $crearProducto->nombregrp = $rec->nombregrp;
                $crearProducto->codigobarra = $rec->codigobarra;
                $crearProducto->marca = $rec->marca;
                $crearProducto->bodega = $rec->bodega;
                $crearProducto->nombrebodega = $rec->nombrebodega;
                $crearProducto->valor = $rec->valoriva;
                $crearProducto->idiva = $rec->idiva;
                $crearProducto->porcetajeiva = $rec->porcetajeiva;
                $crearProducto->fechadecreacion = $rec->fechadecreacion;
                $crearProducto->estado = $rec->estado;
 
                $crearProducto->save();
 
        } catch (\Exception $e){
 
            DB::rollBack();
            $response = array(
                'type' => '0',
                'message' => "ERROR ".$e
            );
            $rec->headers->set('Accept', 'application/json');
            echo json_encode($response);
            exit;
        }
        DB::commit();
        $response = array(
            'type' => 1,
            'message' => 'REGISTRO EXITOSO',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    // Lee productos creados en la DB Local
    public function cwrListarProductoDB($rec)
    {
        //echo json_encode($rec->idinterno);
        //exit;
        $db_name = "cyclewear_sys";
          
        $listaproductos = DB::connection($this->cur_connect)->select(
                                               "select t0.*
                                               from ".$db_name.'.productos'." t0
                                               ");

        echo json_encode($listaproductos);

    }

    // Lee productos creados en la DB Local
    public function cwrListarProductoSIIGO($rec)
    {
        //echo json_encode($rec->idinterno);
        //exit;
        $db_name = "cyclewear_sys";
              
        $listaproductos = DB::connection($this->cur_connect)->select(
                                                "select t0.*
                                                from ".$db_name.'.productos'." t0
                                                WHERE t0.estado = 1 ORDER BY codigo DESC");
    
        echo json_encode($listaproductos);
    }

    // Lee clientes en la BD local
    public function cwrLeerInterlocutor($rec)
    {
        $db_name = "cyclewear_sys";
    
        $listarterceros = DB::connection($this->cur_connect)->select("select t0.*, t0.id as value, t0.razonsocial as label,
                                                                        concat(t0.nombres, ' ', t0.apellidos) as labeldos 
                                                                        from ".$db_name.'.interlocutores'." t0
                                                                        WHERE t0.tipotercero = '". $rec->tipotercero."'"); 
    
        echo json_encode($listarterceros);
    }

   

    public function cwrTiposCliente($rec)
    {
        $db_name = "cyclewear_sys";

        $tiposcliente = DB::connection($this->cur_connect)->select("select t0.* from ".$db_name.'.tipocliente'." t0 WHERE t0.estado = 1 ORDER BY tipocliente ASC");

        $tiposcli = array();

        $datoc = [
                    'header_supplies' => $tiposcliente
                ];
                $tiposcli[] = $datoc;

        echo json_encode($tiposcli);
    }

    public function consultarProducto($rec)
    {
        $idproducto =  $rec->idproducto;
        //$url = $this->url_siigo_api."customers?page=".$pagina."&page_size=100";
        $url = $this->url_siigo_api."/products/".$idproducto;
        $response = FunctionsCustoms::SiigoGet($url,$this->db);
        //echo $response;
        //exit;

        $rec->headers->set('Accept', 'application/json');
        echo $response;
    }
   
    public function crearFacturasItems($rec)
    {
        $url = $this->url_siigo_api."invoices";
        $taxes_p = array();
        $priceslist_p = array();
        $prices_p = array();

        $db_name = "cyclewear_sys";
     
        $itemspedidos = DB::connection($this->cur_connect)->select(
                                               "select t0.*
                                                from ".$db_name.'.itemspedidos'." t0
                                                WHERE pedido = '". $rec->pedido."'"); 
 
       /*
        $itemspedidos = DB::connection($this->cur_connect)->select(
                                               "select t0.*
                                                from ".$db_name.'.itemspedidos'." t0
                                                WHERE pedido = '". $rec->pedido."'"); 

       */

        $listaitems = array();

        foreach($itemspedidos as $modelo) {
            // Inicio Foreach CAT AQUI
            //"items" => array([

            $cat_pro = array("code" =>$modelo->codigoproductosiigo,
                             "description" =>$modelo->advert_name,
                             "quantity" =>$modelo->quantity,
                             "price" => round((($modelo->subtotal)/($rec->iva)),4),
                             "discount" => "0",
                             "warehouse" => 5,     
                             "taxes" => array 
                              ([
                                "id" => $rec->idtaxes,
                              ])
                            );
            $listaitems[] = $cat_pro;
            // Fin Foreach CAT AQUI
        }

        //echo json_encode($listaitems);
        //exit;

        $array_post = array(
            "document" =>  array(
                "id" => $rec->id,
            ),
            "date" => $rec->date,
            "customer" => array(
              "identification" => $rec->identification,
              "branch_office" => 0
            ),
            "cost_center" => $rec->cost_center,
            //"currency" => array(
            //"code" => "USD",
            //"exchange_rate" => 3825
            //),
            //"total" => 2544.22,
            //"balance" => 0,
            "seller" => $rec->seller,
            "observations" => $rec->observations,
            "items" => $listaitems,
              "payments" => array([
                  "id" => $rec->idpayments,
                  "value" => $rec->value,
                  "due_date" => $rec->due_date,
              ]),
              //"additional_fields" => ""
        );

        //echo json_encode($array_post);
        //exit;

        $response = FunctionsCustoms::SiigoPost($url,$this->db,$array_post);
        $rec->headers->set('Accept', 'application/json');

        //echo json_encode($response);
        //exit;

        $resp_crear = json_decode($response);
        
        if(isset($resp_crear->id)){
            $array_Resp = array("status" => 200, "id" => $resp_crear->number);
            $response = array(
                'type' => 1,
                'message' => 'REGISTRO EXITOSO',
                'id' => $resp_crear->number,
                'status' => 200,
            );
        }else{
            $array_Resp = array("status" => $resp_crear->Status, "id" => 0);
            $response = array(
                'type' => 0,
                'message' => 'ERROR EN REGISTRO',
                'id' => 0,
                'status' => $resp_crear->Status,
                'Error' => $resp_crear->Errors[0]->Message,

            );
        }
        //cho json_encode($array_Resp);
        echo json_encode($response);
        //exit;
    }

     // Lee la condición del producto
     public function leerUsuariosBU($rec)
     {
         $db_name = "cyclewear_sys";
     
         $usuariosbrokerup = DB::connection($this->cur_connect)->select("
                                                         select t0.id as value, t0.brk_company as label, t0.*
                                                         from ".$db_name.'.bkh_brokers'." t0
                                                         WHERE t0.brk_activo = 1 ORDER BY label ASC");
     
         //$condicionprod = array();
     
         //$datoc = [
         //           'header_supplies' => $condicionproducto
         //            ];
         //         $condicionprod[] = $datoc;
     
         echo json_encode($usuariosbrokerup);
     }
}
