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


class brokerupController extends Controller
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
        $this->db = 'brokerup_sys';
       
        // Datos para consultas de Api de Siigo
        $this->url_siigo_api = "https://api.siigo.com/v1/";
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function bruGeneral(Request $request, $accion, $parametro=null)
    {
        switch ($accion) {
            case 1:
                $this->listarUsuarios($request);
                break;
            case 2:
                $this->crearUsuarios($request);
                break;
            case 3:
                $this->MainMenu($request);
            case 4:
                $this->updateteUser($request);
                break;                
            case 5:
                $this->listarTiposClientes($request);
                break;
            case 6:
                $this->listarTipoIdentificacion($request);
                break;
            case 7:
                $this->listarAreaExteriorPrivada($request);
                break;
            case 8:
                $this->listarAreasComunes($request);
                break;
            case 9:
                $this->listarCaracteristicas($request);
                break;
            case 10:
                $this->listarDistribucionInterna($request);
                break;
            case 11:
                $this->listarEstados($request);
                break;
            case 12:
                $this->listarEstratos($request);
                break;
            case 13:
                $this->listarExtras($request);
                break;
            case 14:
                $this->listarOrientacion($request);
                break;
            case 15:
                $this->listarOtrosServicios($request);
                break;
            case 16:
                $this->listarPiso($request);
                break;
            case 17:
                $this->listarServicioAdministracion($request);
                break;
            case 18:
                $this->listarSubTipo($request);
                break;
            case 19:
                $this->listarTecho($request);
                break;
            case 20:
                $this->listarTipoEstructura($request);
                break;
            case 21:
                $this->listarTipodeVia($request);
                break;
            case 22:
                $this->listarTipoParqueadero($request);
                break;
            case 23:
                $this->listarPaises($request);
                break;
            case 24:
                $this->listarDepartamentos($request);
                break;
            case 90:
                $this->crearCliente($request);
                break;
            case 91:
                $this->listarClientes($request);
                break;
            case 92:
                $this->actualizarCliente($request);
                break;
            case 95:
                $this->crearInmueble($request);
                break;
            case 96:
                $this->listarInmuebles($request);
                break;
            case 97:
                $this->actualizarInmueble($request);
                break;
            case 100:
                $this->listarCiudades($request);
                break;
            case 101:
                $this->crearCiudades($request);
                break;
            case 102:
                $this->actualizarCiudades($request);
                break;
            case 103:
                $this->borrarCiudades($request);
                break;
            case 897:
                $this->leerImagenesLatInt($request);
                break;
            case 898:
                $this->subirImagenesLatInt($request);
                break;
            case 899:
                $this->leerImagenesBE($request);
                break;
            case 900:
                $this->subirImagenesBE($request);
                break;
            case 997:
                $this->datosEntorno($request);
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

    public function prueba($rec)
    {
        DB::beginTransaction();
        try {
        $db_name = "brokerup_sys";
                
        $listarusuarios = DB::connection($this->cur_connect)->select(
                                                "select t0.*
                                                from ".$db_name.'.users'." t0 
                                                ORDER BY id ASC"); 

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
            'listarusuarios' => $listarusuarios,
            'message' => 'REGISTRO EXITOSO',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
        //echo json_encode($listarusuarios);
    }

    // Listar usuarios
    public function listarUsuarios($rec)
    {
        DB::beginTransaction();
        try {
        $db_name = "brokerup_sys";
                
        $listarusuarios = DB::connection($this->cur_connect)->select(
                                                "select t0.*
                                                from ".$db_name.'.users'." t0 
                                                ORDER BY id ASC"); 

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
            'listarusuarios' => $listarusuarios,
            'message' => 'REGISTRO EXITOSO',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
        //echo json_encode($listarusuarios);
    }

    // Listar ciudades creadas en la base de datos
    public function listarCiudades($rec)
    {
        DB::beginTransaction();
        try {
        $db_name = "brokerup_sys";
                
        $listarciudades = DB::connection($this->cur_connect)->select(
                                                "select t0.*
                                                from ".$db_name.'.ciudades'." t0 
                                                ORDER BY id ASC"); 

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
            'listarciudades' => $listarciudades,
            'message' => 'REGISTRO EXITOSO',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
        //echo json_encode($listarciudades);
    }

    //Crear Ciudad BrokerUp
    public function crearCiudades($rec)
    {
        DB::beginTransaction();
        try {
                //$db_name = $this->db.".productos";
                $db_name = "brokerup_sys.ciudades";
                $crearCiudades = new ModelGlobal();
                $crearCiudades->setConnection($this->cur_connect);
                $crearCiudades->setTable($db_name);
  
                $crearCiudades->codigo = $rec->codigo;	
                $crearCiudades->codigointerno = $rec->codigointerno;
                $crearCiudades->nombre = $rec->nombre;
                $crearCiudades->departamento = $rec->departamento;
                
                $crearCiudades->save();
  
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

    //Actualizar torres inmobiliario
    public function actualizarCiudades($rec)
    {
        //echo json_encode($rec->id);
        //exit;
        $db_name = "brokerup_sys.ciudades";
 
        DB::beginTransaction();
        try {
 
            DB::connection($this->cur_connect)->update("UPDATE ".$db_name." 
                    SET codigo= '".$rec->codigo."',
                        codigointerno= '".$rec->codigointerno."',
                        nombre= '".$rec->nombre."',
                        departamento= '".$rec->departamento."'
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
    public function datosEntorno($rec)
     {
        
        $db_name = "brokerup_sys";
        
        $areaexteriorprivada = DB::connection($this->cur_connect)->select("select t0.*, t0.id as value, t0.nombre as label 
                                                                      from ".$db_name.'.areaexteriorprivada'." t0 
                                                                      ORDER BY nombre ASC");

        $areascomunes = DB::connection($this->cur_connect)->select("select t0.*, t0.id as value, t0.nombres as label 
                                                                      from ".$db_name.'.areascomunes'." t0 
                                                                      ORDER BY nombres ASC");

        $caracteristicas = DB::connection($this->cur_connect)->select("select t0.*, t0.id as value, t0.nombre as label 
                                                                      from ".$db_name.'.caracteristicas'." t0 
                                                                      ORDER BY nombre ASC");
        
        $ciudades = DB::connection($this->cur_connect)->select("select t0.*, t0.id as value, t0.nombre as label 
                                                                      from ".$db_name.'.ciudades'." t0 
                                                                      ORDER BY nombre ASC");

        $departamentos = DB::connection($this->cur_connect)->select("select t0.*, t0.id as value, t0.nombredpto as label 
                                                                      from ".$db_name.'.departamentos'." t0 
                                                                      ORDER BY nombredpto ASC");

        $distribucioninterna = DB::connection($this->cur_connect)->select("select t0.*, t0.id as value, t0.nombre as label 
                                                                      from ".$db_name.'.distribucioninterna'." t0 
                                                                      ORDER BY nombre ASC");
        
        $estados = DB::connection($this->cur_connect)->select("select t0.*, t0.id as value, t0.nombre as label 
                                                                      from ".$db_name.'.estados'." t0 
                                                                      ORDER BY nombre ASC");

        $estrato = DB::connection($this->cur_connect)->select("select t0.*, t0.id as value, t0.nombre as label 
                                                                      from ".$db_name.'.estrato'." t0 
                                                                      ORDER BY nombre ASC");
                                                                
        $extras = DB::connection($this->cur_connect)->select("select t0.*, t0.id as value, t0.nombre as label 
                                                                      from ".$db_name.'.extras'." t0 
                                                                      ORDER BY nombre ASC");  
        
        $orientacion = DB::connection($this->cur_connect)->select("select t0.*, t0.id as value, t0.nombre as label 
                                                                      from ".$db_name.'.orientacion'." t0 
                                                                      ORDER BY nombre ASC"); 
                                                                      
        $otrosservicios = DB::connection($this->cur_connect)->select("select t0.*, t0.id as value, t0.nombre as label 
                                                                      from ".$db_name.'.otrosservicios'." t0 
                                                                      ORDER BY nombre ASC"); 
                                                                      
        $paises = DB::connection($this->cur_connect)->select("select t0.*, t0.id as value, t0.nombre as label 
                                                                      from ".$db_name.'.paises'." t0 
                                                                      ORDER BY nombre ASC");
                                                                      
        $piso = DB::connection($this->cur_connect)->select("select t0.*, t0.id as value, t0.nombre as label 
                                                                      from ".$db_name.'.piso'." t0 
                                                                      ORDER BY nombre ASC");

        $servicioadministracion = DB::connection($this->cur_connect)->select("select t0.*, t0.id as value, t0.nombre as label 
                                                                      from ".$db_name.'.servicioadministracion'." t0 
                                                                      ORDER BY nombre ASC");

        $subtipo = DB::connection($this->cur_connect)->select("select t0.*, t0.id as value, t0.nombre as label 
                                                                      from ".$db_name.'.subtipo'." t0 
                                                                      ORDER BY nombre ASC");

        $techo = DB::connection($this->cur_connect)->select("select t0.*, t0.id as value, t0.nombre as label 
                                                                      from ".$db_name.'.techo'." t0 
                                                                      ORDER BY nombre ASC");

        $tipocliente = DB::connection($this->cur_connect)->select("select t0.*, t0.id as value, t0.tipocliente as label 
                                                                      from ".$db_name.'.tipocliente'." t0 
                                                                      ORDER BY tipocliente ASC");

        $tipodeestructura = DB::connection($this->cur_connect)->select("select t0.*, t0.id as value, t0.nombre as label 
                                                                      from ".$db_name.'.tipodeestructura'." t0 
                                                                      ORDER BY nombre ASC");

        $tipodevia = DB::connection($this->cur_connect)->select("select t0.*, t0.id as value, t0.nombre as label 
                                                                      from ".$db_name.'.tipodevia'." t0 
                                                                      ORDER BY nombre ASC");

        $tipoidentificacion = DB::connection($this->cur_connect)->select("select t0.*, t0.id as value, t0.descripcion as label 
                                                                      from ".$db_name.'.tipoidentificacion'." t0 
                                                                      ORDER BY descripcion ASC");

        $tipoparqueadero = DB::connection($this->cur_connect)->select("select t0.*, t0.id as value, t0.nombre as label 
                                                                      from ".$db_name.'.tipoparqueadero'." t0 
                                                                      ORDER BY nombre ASC");

        $entorno = array(
            'areaexteriorprivada'=>$areaexteriorprivada,
            'areascomunes'=>$areascomunes,
            'caracteristicas'=>$caracteristicas,
            'ciudades'=>$ciudades,
            'departamentos'=>$departamentos,
            'distribucioninterna'=>$distribucioninterna,
            'estados'=>$estados,
            'estrato'=>$estrato,
            'extras'=>$extras,
            'orientacion'=>$orientacion,
            'otrosservicios'=>$otrosservicios,
            'paises'=>$paises,
            'piso'=>$piso,
            'servicioadministracion'=>$servicioadministracion,
            'subtipo'=>$subtipo,
            'techo'=>$techo,
            'tipocliente'=>$tipocliente,
            'tipodeestructura'=>$tipodeestructura,
            'tipodevia'=>$tipodevia,
            'tipoidentificacion'=>$tipoidentificacion,
            'tipoparqueadero'=>$tipoparqueadero,
        );

        $response = array(
            'type' => 1,
            'message' => " CREACION EXITOSA",
            'datos' => $entorno,
        );
        
        echo json_encode($response);
        exit;
        
        //$datos = array();    
        //echo json_encode($entorno);
        //exit;
    }                                                            

    //Crear usuario en Base de Datos
    public function createUser($rec)
    {

        DB::beginTransaction();
        try {
                    $db_name = $this->db.".users";
                    $nuevoUser = new ModelGlobal();
                    $nuevoUser->setConnection($this->cur_connect);
                    $nuevoUser->setTable($db_name);

                    $nuevoUser->uid = $rec->uid;
                    $nuevoUser->primernombre = $rec->primernombre;
                    $nuevoUser->segundonombre = $rec->segundonombre;
                    $nuevoUser->primerapellido = $rec->primerapellido;
                    $nuevoUser->segundoapellido = $rec->segundoapellido;
                    $nuevoUser->razonsocial = $rec->razonsocial;
                    $nuevoUser->tipoidentificacion = $rec->tipoidentificacion;
                    $nuevoUser->identificacion = $rec->identificacion;
                    $nuevoUser->celular = $rec->celular;
                    $nuevoUser->email = $rec->email;
                    $nuevoUser->token = $rec->token;
                    $nuevoUser->activo = $rec->activo;
                    $nuevoUser->direccion = $rec->direccion;

                    $nuevoUser->save();

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

    // Listar tipos de clientes
    public function listarTiposClientes($rec)
    {
        DB::beginTransaction();
        try {
        $db_name = "brokerup_sys";
                
        $listartipocliente = DB::connection($this->cur_connect)->select(
                                                "select t0.*
                                                from ".$db_name.'.tipocliente'." t0 
                                                ORDER BY id ASC"); 

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
            'listartipocliente' => $listartipocliente,
            'message' => 'REGISTRO EXITOSO',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    // Listar tipos de clientes
    public function listarTipoIdentificacion($rec)
    {
        DB::beginTransaction();
        try {
        $db_name = "brokerup_sys";
                
        $listartipoidentificacion = DB::connection($this->cur_connect)->select(
                                                "select t0.*
                                                from ".$db_name.'.tipoidentificacion'." t0 
                                                ORDER BY id ASC"); 

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
            'listartipoidentificacion' => $listartipoidentificacion,
            'message' => 'REGISTRO EXITOSO',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    // Listar tipos de clientes
    public function listarAreaExteriorPrivada($rec)
    {
        DB::beginTransaction();
        try {
        $db_name = "brokerup_sys";
                
        $listarareaexteriorprivada = DB::connection($this->cur_connect)->select(
                                                "select t0.*
                                                from ".$db_name.'.areaexteriorprivada'." t0 
                                                ORDER BY id ASC"); 

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
            'listarareaexteriorprivada' => $listarareaexteriorprivada,
            'message' => 'REGISTRO EXITOSO',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    // Listar areas comunes
    public function listarAreasComunes($rec)
    {
        DB::beginTransaction();
        try {
        $db_name = "brokerup_sys";
                
        $listarareascomunes = DB::connection($this->cur_connect)->select(
                                                "select t0.*
                                                from ".$db_name.'.areascomunes'." t0 
                                                ORDER BY id ASC"); 

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
            'listarareascomunes' => $listarareascomunes,
            'message' => 'REGISTRO EXITOSO',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    // Listar caracteristicas de los inmuebles
    public function listarCaracteristicas($rec)
    {
        DB::beginTransaction();
        try {
        $db_name = "brokerup_sys";
                
        $listarcaracteristicas = DB::connection($this->cur_connect)->select(
                                                "select t0.*
                                                from ".$db_name.'.caracteristicas'." t0 
                                                ORDER BY id ASC"); 

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
            'listarcaracteristicas' => $listarcaracteristicas,
            'message' => 'REGISTRO EXITOSO',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    // Listar caracteristicas de los inmuebles
    public function listarDistribucionInterna($rec)
    {
        DB::beginTransaction();
        try {
        $db_name = "brokerup_sys";
                
        $listardistribucioninterna = DB::connection($this->cur_connect)->select(
                                                "select t0.*
                                                from ".$db_name.'.distribucioninterna'." t0 
                                                ORDER BY id ASC"); 

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
            'listardistribucioninterna' => $listardistribucioninterna,
            'message' => 'REGISTRO EXITOSO',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    // Listar estados de los inmuebles
    public function listarEstados($rec)
    {
        DB::beginTransaction();
        try {
        $db_name = "brokerup_sys";
                
        $listartiposestados = DB::connection($this->cur_connect)->select(
                                                "select t0.*
                                                from ".$db_name.'.estados'." t0 
                                                ORDER BY id ASC"); 

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
            'listartiposestados' => $listartiposestados,
            'message' => 'REGISTRO EXITOSO',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    // Listar estratos
    public function listarEstratos($rec)
    {
        DB::beginTransaction();
        try {
        $db_name = "brokerup_sys";
                
        $listarestratos = DB::connection($this->cur_connect)->select(
                                                "select t0.*
                                                from ".$db_name.'.estrato'." t0 
                                                ORDER BY id ASC"); 

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
            'listarestratos' => $listarestratos,
            'message' => 'REGISTRO EXITOSO',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    // Listar estratos
    public function listarExtras($rec)
    {
        DB::beginTransaction();
        try {
        $db_name = "brokerup_sys";
                
        $listarextras = DB::connection($this->cur_connect)->select(
                                                "select t0.*
                                                from ".$db_name.'.extras'." t0 
                                                ORDER BY id ASC"); 

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
            'listarextras' => $listarextras,
            'message' => 'REGISTRO EXITOSO',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    // Listar orientacion del inmueble
    public function listarOrientacion($rec)
    {
        DB::beginTransaction();
        try {
        $db_name = "brokerup_sys";
                
        $listarorientacion = DB::connection($this->cur_connect)->select(
                                                "select t0.*
                                                from ".$db_name.'.orientacion'." t0 
                                                ORDER BY id ASC"); 

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
            'listarorientacion' => $listarorientacion,
            'message' => 'REGISTRO EXITOSO',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    // Listar otros servicios
    public function listarOtrosServicios($rec)
    {
        DB::beginTransaction();
        try {
        $db_name = "brokerup_sys";
                
        $listarotrosservicios = DB::connection($this->cur_connect)->select(
                                                "select t0.*
                                                from ".$db_name.'.otrosservicios'." t0 
                                                ORDER BY id ASC"); 

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
            'listarotrosservicios' => $listarotrosservicios,
            'message' => 'REGISTRO EXITOSO',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    // Listar pisos del inmueble
    public function listarPiso($rec)
    {
        DB::beginTransaction();
        try {
        $db_name = "brokerup_sys";
                
        $listarpisos = DB::connection($this->cur_connect)->select(
                                                "select t0.*
                                                from ".$db_name.'.piso'." t0 
                                                ORDER BY id ASC"); 

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
            'listarpisos' => $listarpisos,
            'message' => 'REGISTRO EXITOSO',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    // Listar servicios de la administración
    public function listarServicioAdministracion($rec)
    {
        DB::beginTransaction();
        try {
        $db_name = "brokerup_sys";
                
        $listarserviciosadministracion = DB::connection($this->cur_connect)->select(
                                                "select t0.*
                                                from ".$db_name.'.servicioadministracion'." t0 
                                                ORDER BY id ASC"); 

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
            'listarserviciosadministracion' => $listarserviciosadministracion,
            'message' => 'REGISTRO EXITOSO',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    // Listar subtipos
    public function listarSubTipo($rec)
    {
        DB::beginTransaction();
        try {
        $db_name = "brokerup_sys";
                
        $listarsubtipos = DB::connection($this->cur_connect)->select(
                                                "select t0.*
                                                from ".$db_name.'.subtipo'." t0 
                                                ORDER BY id ASC"); 

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
            'listarsubtipos' => $listarsubtipos,
            'message' => 'REGISTRO EXITOSO',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    // Listar subtipos
    public function listarTecho($rec)
    {
        DB::beginTransaction();
        try {
        $db_name = "brokerup_sys";
                
        $listartechos = DB::connection($this->cur_connect)->select(
                                                "select t0.*
                                                from ".$db_name.'.techo'." t0 
                                                ORDER BY id ASC"); 

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
            'listartechos' => $listartechos,
            'message' => 'REGISTRO EXITOSO',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    // Listar tipos estructuras
    public function listarTipoEstructura($rec)
    {
        DB::beginTransaction();
        try {
        $db_name = "brokerup_sys";
                
        $listartiposestructura = DB::connection($this->cur_connect)->select(
                                                "select t0.*
                                                from ".$db_name.'.tipodeestructura'." t0 
                                                ORDER BY id ASC"); 

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
            'listartiposestructura' => $listartiposestructura,
            'message' => 'REGISTRO EXITOSO',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    // Listar tipos estructuras
    public function listarTipodeVia($rec)
    {
        DB::beginTransaction();
        try {
        $db_name = "brokerup_sys";
                
        $listartipodevia = DB::connection($this->cur_connect)->select(
                                                "select t0.*
                                                from ".$db_name.'.tipodevia'." t0 
                                                ORDER BY id ASC"); 

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
            'listartipodevia' => $listartipodevia,
            'message' => 'REGISTRO EXITOSO',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    // Listar tipos estructuras
    public function listarTipoParqueadero($rec)
    {
        DB::beginTransaction();
        try {
        $db_name = "brokerup_sys";
                
        $listartipoparqueadero = DB::connection($this->cur_connect)->select(
                                                "select t0.*
                                                from ".$db_name.'.tipoparqueadero'." t0 
                                                ORDER BY id ASC"); 

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
            'listartipoparqueadero' => $listartipoparqueadero,
            'message' => 'REGISTRO EXITOSO',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    // Listar paises
    public function listarPaises($rec)
    {
        DB::beginTransaction();
        try {
        $db_name = "brokerup_sys";
                
        $listarpaises = DB::connection($this->cur_connect)->select(
                                                "select t0.*
                                                from ".$db_name.'.paises'." t0 
                                                ORDER BY id ASC"); 

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
            'listarpaises' => $listarpaises,
            'message' => 'REGISTRO EXITOSO',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    // Listar departamentos
    public function listarDepartamentos($rec)
    {
        DB::beginTransaction();
        try {
        $db_name = "brokerup_sys";
                
        $listardepartamentos = DB::connection($this->cur_connect)->select(
                                                "select t0.*
                                                from ".$db_name.'.departamentos'." t0 
                                                ORDER BY id ASC"); 

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
            'listardepartamentos' => $listardepartamentos,
            'message' => 'REGISTRO EXITOSO',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }


    // Listar clientes
    public function listarClientes($rec)
    {
        DB::beginTransaction();
        try {
        $db_name = "brokerup_sys";
                
        $listarclientes = DB::connection($this->cur_connect)->select(
                                                "select  t0.*, t1.tipocliente as nombretipo, t2.descripcion as nombreidentificacion,
                                                t3.nombredpto AS nombredepartamento, t4.nombre AS nombreciudad, t5.nombre AS nombrepais
                                                from ".$db_name.'.clientes'." t0
                                                JOIN ".$db_name.'.tipocliente'." t1 ON t0.tipocliente = t1.id 
                                                JOIN ".$db_name.'.tipoidentificacion'." t2 ON t0.tipoidentificacion = t2.id
                                                JOIN ".$db_name.'.departamentos'." t3 ON t0.departamento = t3.id 
                                                JOIN ".$db_name.'.ciudades'." t4 ON t0.ciudad = t4.id 
                                                JOIN ".$db_name.'.paises'." t5 ON t0.pais = t5.id 
                                                ORDER BY id ASC"); 

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
    }

    // Listar inmuebles
    public function listarInmuebles($rec)
    {
        DB::beginTransaction();
        try {
        $db_name = "brokerup_sys";
                
        $listarinmuebles = DB::connection($this->cur_connect)->select(
                                                "select  t0.*, t1.nombredpto AS nombredepartamento, t2.nombre AS nombreciudad,
                                                t3.nombre AS nombrepais, t4.nombre as nombreestado, t5.nombre as disponibilidad,
                                                t6.nombre as nombretipoinmueble, t7.nombre as nombresubtipo
                                                from ".$db_name.'.inmuebles'." t0
                                                JOIN ".$db_name.'.departamentos'." t1 ON t0.departamento = t1.id 
                                                JOIN ".$db_name.'.ciudades'." t2 ON t0.ciudad = t2.id 
                                                JOIN ".$db_name.'.paises'." t3 ON t0.pais = t3.id 
                                                JOIN ".$db_name.'.estados'." t4 ON t0.estado = t4.id 
                                                JOIN ".$db_name.'.disponibilidad'." t5 ON t0.disponibilidad = t5.id 
                                                JOIN ".$db_name.'.tipoinmueble'." t6 ON t0.tipodeinmueble = t6.id
                                                JOIN ".$db_name.'.subtipo'." t7 ON t0.subtipo = t7.id
                                                ORDER BY id ASC"); 

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
    }





    public function mrpMainMenu($rec)
    {
        $db_name = "brokerup_sys";

        $mainmenu = DB::connection($this->cur_connect)->select("select t0.* from ".$db_name.'.main_menu'." t0 WHERE t0.estado = 1");
        $validate = DB::connection($this->cur_connect)->select("select t0.* from ".$db_name.'.validate'." t0 ORDER BY RAND() limit 5");

        $menuprincipal = array();
        $main_menu_array = array();
        $Validate_array = array();

         $datovalidate = [
                    'heading' => "validate",
                    'megaItems' => $validate
                ];

         $Validate_array[] = $datovalidate;
         //echo json_encode($datovalidate);

            $n=1;
            foreach($mainmenu as $mm){
                if($n == 1){
                    $datoc = [
                        'id' => $mm->id,
                        'text' => $mm->text,
                        'external' => $mm->external,
                        'module' => $mm->module,
                        'url' => $mm->url
                    ];
                }elseif($n == 2){
                    $datoc = [
                        'id' => $mm->id,
                        'text' => $mm->text,
                        'url' => $mm->url,
                        'extraClass' => $mm->extraClass,
                        'subClass' => $mm->subClass
                    ];
                }else{
                    $datoc = [
                        'id' => $mm->id,
                        'text' => $mm->text,
                        'url' => $mm->url,
                        'extraClass' => $mm->extraClass,
                        'subClass' => $mm->subClass,
                        'megaContent' => $Validate_array
                    ];
                }

                $main_menu_array[] = $datoc;
            $n++;
            }

        $datoc = [
                    'main_menu' => $main_menu_array
                ];
                $menuprincipal[] = $datoc;

        echo json_encode($menuprincipal);
    }

    public function mrpvalidateInmuebles($rec)
    {
        //echo json_encode($rec->idvehiculo);
        //exit;
        $db_name = "brokerup_sys";

    $validateInmuebles = DB::connection($this->cur_connect)->select("
        select t0.* from ".$db_name.'.validate'." t0 WHERE estado = 1 && tipovehiculo = ". $rec->idvehiculo." ORDER BY text ASC"
    );

    echo json_encode($validateInmuebles);
    }

    public function mrpAnosInmuebles($rec)
    {
        $db_name = "brokerup_sys";

        $anosInmuebles = DB::connection($this->cur_connect)->select("select t0.* from ".$db_name.".anosInmuebles t0 ORDER BY anovehiculo DESC");

        $datosanosInmuebles = array();

        foreach($anosInmuebles as $mm){
            $datoc = [
                'value' => $mm->id,
                'label' => $mm->anovehiculo
            ];
            $datosanosInmuebles[] = $datoc;
        }

        echo json_encode($datosanosInmuebles);
    }

    public function mrpModelosInmuebles($rec)
    {
        $db_name = "brokerup_sys";

        $modelosInmuebles = DB::connection($this->cur_connect)->select("select t0.* from ".$db_name.'.modelos'." t0 WHERE estado = 1 && Validate = ". $rec->idValidate);

        $modelosInmueblesValidate = array();

        foreach($modelosInmuebles as $mm){
            $datoc = [
                'value' => $mm->id,
                'label' => $mm->modelo
            ];
            $modelosInmueblesValidate[] = $datoc;
        }
        echo json_encode($modelosInmueblesValidate);
    }

    public function mrpCarroceriasInmuebles($rec)
    {
        $db_name = "brokerup_sys";

        $carroceriasInmuebles = DB::connection($this->cur_connect)->select("select t0.* from ".$db_name.'.tiposcarrocerias'." t0 WHERE tipovehiculo = ". $rec->idcarroceria);

        $tiposInmueblescarroceria = array();

        foreach($carroceriasInmuebles as $mm){
            $datoc = [
                'value' => $mm->id,
                'label' => $mm->carroceria
            ];
            $tiposInmueblescarroceria[] = $datoc;
        }
        echo json_encode($tiposInmueblescarroceria);
    }

    public function readUser($rec)
    {
        $db_name = "brokerup_sys";

        $usuarios = DB::connection($this->cur_connect)->select("select t0.* from ".$db_name.'.users'." t0 WHERE uid = ". $rec->uid);

        $usuarioseleccionado = array();

        echo json_encode($usuarios);
    }

    public function readUserEmail($rec)
    {
        $db_name = "brokerup_sys";

        $usuarios = DB::connection($this->cur_connect)->select("select t0.* from ".$db_name.'.users'." t0 WHERE email = '". $rec->email."'");

        $usuarioseleccionado = array();

        echo json_encode($usuarios);
    }

    public function mrpEnvioToken($rec)
    {
       /*
        echo $rec->token;
        echo $rec->email_cliente;
        echo $rec->nro_ws;
        echo $rec->medio;
        exit;
        */
        $token_acceso = $rec->token;

        switch ($rec->medio) {
            case 'email':

                // Envio Token Via Email
                $rec->destinatario = $rec->email_cliente;
                $rec->remitente = 'soporte@aal-team.com';
                $rec->nombre_remitente = 'MERCADO REPUESTOS SAS';
                $rec->asunto = 'Token de Registro Mercado Repuesto - '.$token_acceso;
                $rec->plantilla = 'tokenmrp';
                $rec->contenido_html = ''.$token_acceso.'';
                FunctionsCustoms::EnvioCodigoTokenMRP($rec);

                break;
            case 'whatsapp':

                // Envio Token Via WS
                $mensaje = '🚗Mercado Repuesto SAS🏍️
                Para continuar con el registro, debe ingresar este Webtoken '.$token_acceso.'
                Gracias por Su Registro';

                FunctionsCustoms::NotificarWS($rec->nro_ws,$mensaje);

                break;
            case 'sms':

                // Envio Token via SMS
                $mensaje = 'Su token para Mercado Repuesto es: '.$token_acceso.'';
                FunctionsCustoms::TokenSMS($rec->nro_ws,$mensaje);

                break;
            default:
               echo "SIN ENVIO";
        }


    }

    public function readWompi($rec)
    {
        //echo json_encode($rec);
        //exit;

        $db_name = "brokerup_sys";

        $validateInmuebles = DB::connection($this->cur_connect)->select("select t0.* from ".$db_name.'.validate'." t0 WHERE tipovehiculo = ". $rec->idvehiculo);

        echo json_encode($validateInmuebles);
    }

    public function readVersionMotor($rec)
    {
        //echo json_encode($rec->idvehiculo);
        //exit;
        $db_name = "brokerup_sys";
        $versionmotor = DB::connection($this->cur_connect)->select("select t0.* from ".$db_name.'.versionmotor'." t0 WHERE t0.estado = 1 && modelo = ". $rec->idmodelo);

        $cilindradamotor = array();

        foreach($versionmotor as $mm){
            $datoc = [
                'value' => $mm->id,
                'label' => $mm->cilindraje
            ];
            $cilindradamotor[] = $datoc;
        }

        echo json_encode($cilindradamotor);
    }

    //Lee Productos de la Base de Datos
    public function getProducts($rec, $parametro)
    {
        //////////////////////////////////
        /// INICIO DE FOREACH DE PRODUCTOS
        //////////////////////////////////
        $db_name = "brokerup_sys";
        $url_img = '/files/mercadorepuesto/';
        //$variable = json_decode($parametro);
        //echo $rec;
        //exit;

        $aKeyword = explode(" ", $rec->name_contains);

        $query = "select DISTINCT t0.id, t0.*,
            t0.id as idproducto,
            t1.text AS Validate,
            t1.id AS id_Validate,
            t2.id AS id_modelos,
            t2.modelo AS modelos
            from ".$db_name.'.productos'." t0
            JOIN ".$db_name.'.validate'." t1 ON t0.Validate = t1.id
            JOIN ".$db_name.'.tiposInmuebles'." t3 ON t0.tipovehiculo = t3.id
            JOIN ".$db_name.'.modelos'." t2 ON t0.modelo = t2.id
            WHERE t3.id = t1.tipovehiculo &&
                  (t1.text LIKE '%".$aKeyword[0]."%' ||
                   t0.titulonombre LIKE '%".$aKeyword[0]."%' ||
                   t2.modelo LIKE '%".$aKeyword[0]."%')  ";

                   for($i = 1; $i < count($aKeyword); $i++) {
                    if(!empty($aKeyword[$i])) {
                        $query .= " OR (t1.text LIKE '%".$aKeyword[$i]."%' ||
                        t0.titulonombre LIKE '%".$aKeyword[$i]."%' ||
                        t2.modelo LIKE '%".$aKeyword[$i]."%')";
                    }
                  }
                
        $productos = DB::connection($this->cur_connect)->select($query);
     
        $product = array();

        foreach($productos as $producto) {
        //Imagenes
        $img = array();
        $product_categories = array();
        $product_brands =array();
        //echo json_encode($extension);
        //exit;

        $nombrefoto[1] = $producto->nombreimagen1;
        $nombrefoto[2] = $producto->nombreimagen2;
        $nombrefoto[3] = $producto->nombreimagen3;
        $nombrefoto[4] = $producto->nombreimagen4;
        $nombrefoto[5] = $producto->nombreimagen5;
        $nombrefoto[6] = $producto->nombreimagen6;
        $nombrefoto[7] = $producto->nombreimagen7;
        $nombrefoto[8] = $producto->nombreimagen8;
        $nombrefoto[9] = $producto->nombreimagen9;
        $nombrefoto[10] = $producto->nombreimagen10;

        for ($i = 1; $i <= $producto->numerodeimagenes; $i++) {
        // Foreach AQUI
        $img_name = explode(".", $nombrefoto[$i]);
        $formats_thumbnail = array('name' => $nombrefoto[$i],
                                'hash' => $img_name[0],
                                'ext' =>  ".".$img_name[1],
                                'mime' => 'image/jpeg',
                                'width' => 156,
                                'height' => 156,
                                'size' => number_format(1.52),
                                'path' => null,
                                'url' => $url_img.$nombrefoto[$i]);

        $formats_large = array('name' => $nombrefoto[$i],
                                'hash' => $img_name[0],
                                'ext' => ".".$img_name[1],
                                'mime' => 'image/jpeg',
                                'width' => 1000,
                                'height' => 1000,
                                'size' => number_format(18.15),
                                'path' => null,
                                'url' => $url_img.$nombrefoto[$i]);

        $formats_medium = array('name' => $nombrefoto[$i],
                                'hash' => $img_name[0],
                                'ext' => ".".$img_name[1],
                                'mime' => 'image/jpeg',
                                'width' => 750,
                                'height' => 750,
                                'size' => number_format(11.54),
                                'path' => null,
                                'url' => $url_img.$nombrefoto[$i]);

        $formats_small = array('name' => $nombrefoto[$i],
                                'hash' => $img_name[0],
                                'ext' => ".".$img_name[1],
                                'mime' => 'image/jpeg',
                                'width' => 500,
                                'height' => 500,
                                'size' => number_format(6.23),
                                'path' => null,
                                'url' => $url_img.$nombrefoto[$i]);

        $formats_img_data = array('thumbnail' => $formats_thumbnail,
                             'large' => $formats_large,
                             'medium' => $formats_medium,
                             'small' => $formats_small);
        $formats_img = $formats_img_data;

        $imgdata = array('id' => $i,
                     'name' => $nombrefoto[$i],
                     'alternativeText' => $producto->titulonombre,
                     'caption' => $this->string2url($producto->titulonombre),
                     'width' => 1200,
                     'height' => 1200,
                     'formats' => $formats_img,
                     'hash' => $img_name[0],
                     'ext' => ".".$img_name[1],
                     'mime' => 'image/jpeg',
                     'size' => number_format(23.67),
                     'url' => $url_img.$nombrefoto[$i],
                     'previewUrl' => null,
                     'provider' => 'local',
                     'provider_metadata' => null,
                     'created_at' => '2021-06-12T09:17:55.793Z',
                     'updated_at' => date("Y-m-d").'T09:17:55.815Z');
        $img[] = $imgdata;
        }
        $img_name = explode(".", $producto->nombreimagen1);
        $thumbnail_thumbnail = array('name' => $producto->nombreimagen1,
                                'hash' => $img_name[0],
                                'ext' => ".".$img_name[1],
                                'mime' => 'image/jpeg',
                                'width' => 156,
                                'height' => 156,
                                'size' => number_format(1.52),
                                'path' => null,
                                'url' => $url_img.$producto->nombreimagen1);

        $thumbnail_large = array('name' => $producto->nombreimagen1,
                                'hash' => $img_name[0],
                                'ext' => ".".$img_name[1],
                                'mime' => 'image/jpeg',
                                'width' => 1000,
                                'height' => 1000,
                                'size' => number_format(18.15),
                                'path' => null,
                                'url' => $url_img.$producto->nombreimagen1);

        $thumbnail_medium = array('name' => $producto->nombreimagen1,
                                'hash' => $img_name[0],
                                'ext' => ".".$img_name[1],
                                'mime' => 'image/jpeg',
                                'width' => 750,
                                'height' => 750,
                                'size' => number_format(11.54),
                                'path' => null,
                                'url' => $url_img.$producto->nombreimagen1);

        $thumbnail_small = array('name' => $producto->nombreimagen1,
                                'hash' => $img_name[0],
                                'ext' => ".".$img_name[1],
                                'mime' => 'image/jpeg',
                                'width' => 500,
                                'height' => 500,
                                'size' => number_format(6.23),
                                'path' => null,
                                'url' => $url_img.$producto->nombreimagen1);

        $thumbnail_formats_img_data = array('thumbnail' => $thumbnail_thumbnail,
                             'large' => $thumbnail_large,
                             'medium' => $thumbnail_medium,
                             'small' => $thumbnail_small);

        $thumbnail_img = array('id' => 1,
                               'name' => $producto->nombreimagen1,
                               'alternativeText' => $producto->titulonombre,
                               'caption' => $this->string2url($producto->titulonombre),
                               'width' => 1200,
                               'height' => 1200,
                               'formats' => $thumbnail_formats_img_data,
                               'hash' => $img_name[0],
                               'ext' => ".".$img_name[1],
                               'mime' => 'image/jpeg',
                               'size' => number_format(23.67),
                               'url' => $url_img.$producto->nombreimagen1,
                               'previewUrl' => null,
                               'provider' => 'local',
                               'provider_metadata' => null,
                               'created_at' => '2021-06-12T09:17:55.793Z',
                               'updated_at' => date("Y-m-d").'T09:17:55.815Z'
                                );

        $thumbnail_back = array('id' => 1,
                                'name' => $producto->nombreimagen1,
                                'alternativeText' => $producto->titulonombre,
                                'caption' => $this->string2url($producto->titulonombre),
                                'width' => 1200,
                                'height' => 1200,
                                'formats' => $thumbnail_formats_img_data,
                                'hash' => $img_name[0],
                                'ext' => ".".$img_name[1],
                                'mime' => 'image/jpeg',
                                'size' => number_format(23.67),
                                'url' => $url_img.$producto->nombreimagen1,
                                'previewUrl' => null,
                                'provider' => 'local',
                                'provider_metadata' => null,
                                'created_at' => '2021-06-12T09:17:55.793Z',
                                'updated_at' => date("Y-m-d").'T09:17:55.815Z'
                                );
        // Fin Foreach IMG AQUI

        $modelos = DB::connection($this->cur_connect)->select("select t0.* FROM ".$db_name.'.modelos'." t0
            WHERE t0.Validate = '".$producto->id_Validate."' ORDER BY Validate ASC");
        foreach($modelos as $modelo) {
        // Inicio Foreach CAT AQUI
        $cat_pro = array('id' => $modelo->id,
                         'name' => $modelo->modelo,
                         'slug' => $this->string2url($modelo->modelo),
                         'created_at' => '2021-06-12T08:53:06.932Z',
                         'updated_at' => date("Y-m-d").'T08:53:06.943Z');
        $product_categories[] = $cat_pro;
        // Fin Foreach CAT AQUI
        }

        // Inicio Foreach validate
        $brand = array('id' => $producto->id_Validate,
                       'name' => $producto->Validate,
                       'slug' => $this->string2url($producto->Validate),
                       'created_at' => date("Y-m-d").'T10:56:52.945Z',
                        'updated_at' => date("Y-m-d").'T10:58:02.351Z');
        $product_brands[] = $brand;
        // Fin Foreach validate

        // Imagenes

            $datoproduct = [
            'id' => $producto->idproducto,
            'name' => $producto->titulonombre,
            'featured' => false,
            'price' => $producto->precio,
            'sale_price' => $producto->precio,
            'numerounidades' => $producto->numerodeunidades,
            'on_sale' => true,
            'slug' => $this->string2url($producto->titulonombre),
            'is_stock' => true,
            'rating_count' => 9,
            'description' => 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Donec quam felis, ultricies nec, pellentesque eu, pretium quis, sem. Nulla consequat massa quis enim. Donec pede justo, fringilla vel, aliquet nec, vulputate eget, arcu. In enim justo, rhoncus ut, imperdiet a, venenatis vitae, justo. Nullam dictum felis eu pede mollis pretium. Integer tincidunt. Cras dapibus. Vivamus elementum semper nisi. Aenean vulputate eleifend tellus. Aenean leo ligula, porttitor eu, consequat vitae, eleifend ac, enim. Aliquam lorem ante, dapibus in, viverra quis, feugiat a, tellus. Phasellus viverra nulla ut metus varius laoreet. Quisque rutrum. Aenean imperdiet. Etiam ultricies nisi vel augue. Curabitur ullamcorper ultricies nisi. Nam eget dui. Etiam rhoncus. Maecenas tempus, tellus eget condimentum rhoncus, sem quam semper libero, sit amet adipiscing sem neque sed ipsum. Nam quam nunc, blandit vel, luctus pulvinar, hendrerit id, lorem. Maecenas nec odio et ante tincidunt tempus. Donec vitae sapien ut libero venenatis faucibus. Nullam quis ante. Etiam sit amet orci eget eros faucibus tincidunt. Duis leo. Sed fringilla mauris sit amet nibh. Donec sodales sagittis magna. Sed consequat, leo eget bibendum sodales, augue velit cursus nunc,',
            'short_description' => 'Ut enim ad minima veniam, quis nostrum exercitationem ullam corporis suscipit laboriosam',
            'created_at' => '2021-06-12T09:24:14.184Z',
            'updated_at' => '2021-06-12T11:06:51.663Z',
            'sizes' => array(),
            'colors' => array(),
            'badges' => array(),
            'images' => $img,
            'thumbnail' => $thumbnail_img,
            'thumbnail_back' => $thumbnail_back,
            'collections' => array(),
            'product_categories' => $product_categories,
            'product_brands' => $product_brands,
            ];
            $product[] = $datoproduct;

            //////////////////////////
            // FIN FOREACH PRODUCTOS

        }
        
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($product);
        exit;
    }

    //Lee una publicación
    public function getPublication($rec, $parametro)
    {
       ///////////////////////////////////
        /// INICIO DE FOREACH DE PRODUCTOS
        //////////////////////////////////

        $db_name = "brokerup_sys";
        $url_img = '/files/mercadorepuesto/';
        //echo $variable = json_decode($parametro);
        //echo $rec->idarticulo;
        //exit;

        $productos = DB::connection($this->cur_connect)->select("select t0.*,
        t0.id as idproducto,
        t1.text AS Validate,
        t1.id AS id_Validate,
        t2.id AS id_modelos,
        t2.modelo AS modelos
        from ".$db_name.'.productos'." t0
        JOIN ".$db_name.'.tiposInmuebles'." t3 ON t0.tipovehiculo = t3.id
        JOIN ".$db_name.'.validate'." t1 ON t0.Validate = t1.id
        JOIN ".$db_name.'.modelos'." t2 ON t0.modelo = t2.id
        WHERE t0.compatible IN ".$rec->idarticulo);

        //WHERE t0.id = ".$rec->idarticulo);
        //echo json_encode($productos);
        //exit;
        //$variable = json_decode($parametro);
        //echo $variable->name_contains;
        //exit;
        $product = array();

        foreach($productos as $producto) {
        //Imagenes
        $img = array();
        $product_categories = array();
        $product_brands =array();
        //echo json_encode($extension);
        //exit;

        $nombrefoto[1] = $producto->nombreimagen1;
        $nombrefoto[2] = $producto->nombreimagen2;
        $nombrefoto[3] = $producto->nombreimagen3;
        $nombrefoto[4] = $producto->nombreimagen4;
        $nombrefoto[5] = $producto->nombreimagen5;
        $nombrefoto[6] = $producto->nombreimagen6;
        $nombrefoto[7] = $producto->nombreimagen7;
        $nombrefoto[8] = $producto->nombreimagen8;
        $nombrefoto[9] = $producto->nombreimagen9;
        $nombrefoto[10] = $producto->nombreimagen10;

        //for ($i = 1; $i <= $producto->numerodeimagenes; $i++) {
        //for ($i = 1; $i <= 2; $i++) {
        for ($i = 1; $i <= $producto->numerodeimagenes; $i++) {
        // Foreach AQUI
        $img_name = explode(".", $nombrefoto[$i]);
        $formats_thumbnail = array('name' => $nombrefoto[$i],
                                'hash' => $img_name[0],
                                'ext' =>  ".".$img_name[1],
                                'mime' => 'image/jpeg',
                                'width' => 156,
                                'height' => 156,
                                'size' => number_format(1.52),
                                'path' => null,
                                'url' => $url_img.$nombrefoto[$i]);

        $formats_large = array('name' => $nombrefoto[$i],
                                'hash' => $img_name[0],
                                'ext' => ".".$img_name[1],
                                'mime' => 'image/jpeg',
                                'width' => 1000,
                                'height' => 1000,
                                'size' => number_format(18.15),
                                'path' => null,
                                'url' => $url_img.$nombrefoto[$i]);

        $formats_medium = array('name' => $nombrefoto[$i],
                                'hash' => $img_name[0],
                                'ext' => ".".$img_name[1],
                                'mime' => 'image/jpeg',
                                'width' => 750,
                                'height' => 750,
                                'size' => number_format(11.54),
                                'path' => null,
                                'url' => $url_img.$nombrefoto[$i]);

        $formats_small = array('name' => $nombrefoto[$i],
                                'hash' => $img_name[0],
                                'ext' => ".".$img_name[1],
                                'mime' => 'image/jpeg',
                                'width' => 500,
                                'height' => 500,
                                'size' => number_format(6.23),
                                'path' => null,
                                'url' => $url_img.$nombrefoto[$i]);

        $formats_img_data = array('thumbnail' => $formats_thumbnail,
                             'large' => $formats_large,
                             'medium' => $formats_medium,
                             'small' => $formats_small);
        $formats_img = $formats_img_data;

        $imgdata = array('id' => $i,
                     'name' => $nombrefoto[$i],
                     'alternativeText' => $producto->titulonombre,
                     'caption' => $this->string2url($producto->titulonombre),
                     'width' => 1200,
                     'height' => 1200,
                     'formats' => $formats_img,
                     'hash' => $img_name[0],
                     'ext' => ".".$img_name[1],
                     'mime' => 'image/jpeg',
                     'size' => number_format(23.67),
                     'url' => $url_img.$nombrefoto[$i],
                     'previewUrl' => null,
                     'provider' => 'local',
                     'provider_metadata' => null,
                     'created_at' => '2021-06-12T09:17:55.793Z',
                     'updated_at' => date("Y-m-d").'T09:17:55.815Z');
        $img[] = $imgdata;
        }
        $img_name = explode(".", $producto->nombreimagen1);
        $thumbnail_thumbnail = array('name' => $producto->nombreimagen1,
                                'hash' => $img_name[0],
                                'ext' => ".".$img_name[1],
                                'mime' => 'image/jpeg',
                                'width' => 156,
                                'height' => 156,
                                'size' => number_format(1.52),
                                'path' => null,
                                'url' => $url_img.$producto->nombreimagen1);

        $thumbnail_large = array('name' => $producto->nombreimagen1,
                                'hash' => $img_name[0],
                                'ext' => ".".$img_name[1],
                                'mime' => 'image/jpeg',
                                'width' => 1000,
                                'height' => 1000,
                                'size' => number_format(18.15),
                                'path' => null,
                                'url' => $url_img.$producto->nombreimagen1);

        $thumbnail_medium = array('name' => $producto->nombreimagen1,
                                'hash' => $img_name[0],
                                'ext' => ".".$img_name[1],
                                'mime' => 'image/jpeg',
                                'width' => 750,
                                'height' => 750,
                                'size' => number_format(11.54),
                                'path' => null,
                                'url' => $url_img.$producto->nombreimagen1);

        $thumbnail_small = array('name' => $producto->nombreimagen1,
                                'hash' => $img_name[0],
                                'ext' => ".".$img_name[1],
                                'mime' => 'image/jpeg',
                                'width' => 500,
                                'height' => 500,
                                'size' => number_format(6.23),
                                'path' => null,
                                'url' => $url_img.$producto->nombreimagen1);

        $thumbnail_formats_img_data = array('thumbnail' => $thumbnail_thumbnail,
                             'large' => $thumbnail_large,
                             'medium' => $thumbnail_medium,
                             'small' => $thumbnail_small);

        $thumbnail_img = array('id' => 1,
                               'name' => $producto->nombreimagen1,
                               'alternativeText' => $producto->titulonombre,
                               'caption' => $this->string2url($producto->titulonombre),
                               'width' => 1200,
                               'height' => 1200,
                               'formats' => $thumbnail_formats_img_data,
                               'hash' => $img_name[0],
                               'ext' => ".".$img_name[1],
                               'mime' => 'image/jpeg',
                               'size' => number_format(23.67),
                               'url' => $url_img.$producto->nombreimagen1,
                               'previewUrl' => null,
                               'provider' => 'local',
                               'provider_metadata' => null,
                               'created_at' => '2021-06-12T09:17:55.793Z',
                               'updated_at' => date("Y-m-d").'T09:17:55.815Z'
                                );

        $thumbnail_back = array('id' => 1,
                                'name' => $producto->nombreimagen1,
                                'alternativeText' => $producto->titulonombre,
                                'caption' => $this->string2url($producto->titulonombre),
                                'width' => 1200,
                                'height' => 1200,
                                'formats' => $thumbnail_formats_img_data,
                                'hash' => $img_name[0],
                                'ext' => ".".$img_name[1],
                                'mime' => 'image/jpeg',
                                'size' => number_format(23.67),
                                'url' => $url_img.$producto->nombreimagen1,
                                'previewUrl' => null,
                                'provider' => 'local',
                                'provider_metadata' => null,
                                'created_at' => '2021-06-12T09:17:55.793Z',
                                'updated_at' => date("Y-m-d").'T09:17:55.815Z'
                                );
        // Fin Foreach IMG AQUI

        $modelos = DB::connection($this->cur_connect)->select("
            select t0.* FROM ".$db_name.'.modelos'." t0
            JOIN ".$db_name.'.validate'." t1 ON t0.Validate = t1.id
            JOIN ".$db_name.'.tiposInmuebles'." t3 ON t3.id = t1.tipovehiculo
            WHERE t0.Validate = '".$producto->id_Validate."' AND t0.id = '".$producto->modelo."' ORDER BY t0.Validate ASC");

        foreach($modelos as $modelo) {
        // Inicio Foreach CAT AQUI
        $cat_pro = array('id' => $modelo->id,
                         'name' => $modelo->modelo,
                         'slug' => $this->string2url($modelo->modelo),
                         'created_at' => '2021-06-12T08:53:06.932Z',
                         'updated_at' => date("Y-m-d").'T08:53:06.943Z');
        $product_categories[] = $cat_pro;
        // Fin Foreach CAT AQUI
        }

        // Inicio Foreach validate
        $brand = array('id' => $producto->id_Validate,
                       'name' => $producto->Validate,
                       'slug' => $this->string2url($producto->Validate),
                       'created_at' => date("Y-m-d").'T10:56:52.945Z',
                        'updated_at' => date("Y-m-d").'T10:58:02.351Z');
        $product_brands[] = $brand;
        // Fin Foreach validate

        // Imagenes

            $datoproduct = [
            'id' => $producto->idproducto,
            'name' => $producto->titulonombre,
            'featured' => false,
            'price' => $producto->precio,
            'sale_price' => $producto->precio,
            'numerounidades' => $producto->numerodeunidades,
            'on_sale' => true,
            'slug' => $this->string2url($producto->titulonombre),
            'is_stock' => true,
            'rating_count' => 9,
            'description' => 'Los autos están expuestos a diario a sufrir una falla o
             verse involucrados en accidentes de tránsito, y  dependiendo del nivel de
            daño, se requiere sustituir piezas. Para los fabricantes y talleres es
            importante tratar de devolver el auto a sus condiciones iniciales.,',
            'short_description' => 'La industria automotriz está implementando nuevos sistemas modulares  para reducir el costo de producción',
            'created_at' => '2021-06-12T09:24:14.184Z',
            'updated_at' => '2021-06-12T11:06:51.663Z',
            'sizes' => array(),
            'colors' => array(),
            'badges' => array(),
            'images' => $img,
            'thumbnail' => $thumbnail_img,
            'thumbnail_back' => $thumbnail_back,
            'collections' => array(),
            'product_categories' => $product_categories,
            'product_brands' => $product_brands,
            ];
            $product[] = $datoproduct;

            //////////////////////////
            // FIN FOREACH PRODUCTOS

        }

        $rec->headers->set('Accept', 'application/json');
        echo json_encode($product);
        exit;
       
    }

    //Lee Productos de la Base de Datos
    public function getProductsById($rec, $parametro)
    {   ///////////////////////////////////
        /// INICIO DE FOREACH DE PRODUCTOS
        //////////////////////////////////

        $db_name = "brokerup_sys";
        $url_img = '/files/mercadorepuesto/';
        //echo $variable = json_decode($parametro);
        //echo $rec->idarticulo;
        //exit;

        $productos = DB::connection($this->cur_connect)->select("select t0.*,
        t0.id as idproducto,
        t1.text AS Validate,
        t1.id AS id_Validate,
        t2.id AS id_modelos,
        t2.modelo AS modelos
        from ".$db_name.'.productos'." t0
        JOIN ".$db_name.'.tiposInmuebles'." t3 ON t0.tipovehiculo = t3.id
        JOIN ".$db_name.'.validate'." t1 ON t0.Validate = t1.id
        JOIN ".$db_name.'.modelos'." t2 ON t0.modelo = t2.id
        WHERE t3.id = t1.tipovehiculo && t0.id IN ".$rec->idarticulo);

        //WHERE t0.id = ".$rec->idarticulo);
        //echo json_encode($productos);
        //exit;
        //$variable = json_decode($parametro);
        //echo $variable->name_contains;
        //exit;
        $product = array();

        foreach($productos as $producto) {
        //Imagenes
        $img = array();
        $product_categories = array();
        $product_brands =array();
        //echo json_encode($extension);
        //exit;

        $nombrefoto[1] = $producto->nombreimagen1;
        $nombrefoto[2] = $producto->nombreimagen2;
        $nombrefoto[3] = $producto->nombreimagen3;
        $nombrefoto[4] = $producto->nombreimagen4;
        $nombrefoto[5] = $producto->nombreimagen5;
        $nombrefoto[6] = $producto->nombreimagen6;
        $nombrefoto[7] = $producto->nombreimagen7;
        $nombrefoto[8] = $producto->nombreimagen8;
        $nombrefoto[9] = $producto->nombreimagen9;
        $nombrefoto[10] = $producto->nombreimagen10;

        //for ($i = 1; $i <= $producto->numerodeimagenes; $i++) {
        //for ($i = 1; $i <= 2; $i++) {
        for ($i = 1; $i <= $producto->numerodeimagenes; $i++) {
        // Foreach AQUI
        $img_name = explode(".", $nombrefoto[$i]);
        $formats_thumbnail = array('name' => $nombrefoto[$i],
                                'hash' => $img_name[0],
                                'ext' =>  ".".$img_name[1],
                                'mime' => 'image/jpeg',
                                'width' => 156,
                                'height' => 156,
                                'size' => number_format(1.52),
                                'path' => null,
                                'url' => $url_img.$nombrefoto[$i]);

        $formats_large = array('name' => $nombrefoto[$i],
                                'hash' => $img_name[0],
                                'ext' => ".".$img_name[1],
                                'mime' => 'image/jpeg',
                                'width' => 1000,
                                'height' => 1000,
                                'size' => number_format(18.15),
                                'path' => null,
                                'url' => $url_img.$nombrefoto[$i]);

        $formats_medium = array('name' => $nombrefoto[$i],
                                'hash' => $img_name[0],
                                'ext' => ".".$img_name[1],
                                'mime' => 'image/jpeg',
                                'width' => 750,
                                'height' => 750,
                                'size' => number_format(11.54),
                                'path' => null,
                                'url' => $url_img.$nombrefoto[$i]);

        $formats_small = array('name' => $nombrefoto[$i],
                                'hash' => $img_name[0],
                                'ext' => ".".$img_name[1],
                                'mime' => 'image/jpeg',
                                'width' => 500,
                                'height' => 500,
                                'size' => number_format(6.23),
                                'path' => null,
                                'url' => $url_img.$nombrefoto[$i]);

        $formats_img_data = array('thumbnail' => $formats_thumbnail,
                             'large' => $formats_large,
                             'medium' => $formats_medium,
                             'small' => $formats_small);
        $formats_img = $formats_img_data;

        $imgdata = array('id' => $i,
                     'name' => $nombrefoto[$i],
                     'alternativeText' => $producto->titulonombre,
                     'caption' => $this->string2url($producto->titulonombre),
                     'width' => 1200,
                     'height' => 1200,
                     'formats' => $formats_img,
                     'hash' => $img_name[0],
                     'ext' => ".".$img_name[1],
                     'mime' => 'image/jpeg',
                     'size' => number_format(23.67),
                     'url' => $url_img.$nombrefoto[$i],
                     'previewUrl' => null,
                     'provider' => 'local',
                     'provider_metadata' => null,
                     'created_at' => '2021-06-12T09:17:55.793Z',
                     'updated_at' => date("Y-m-d").'T09:17:55.815Z');
        $img[] = $imgdata;
        }
        $img_name = explode(".", $producto->nombreimagen1);
        $thumbnail_thumbnail = array('name' => $producto->nombreimagen1,
                                'hash' => $img_name[0],
                                'ext' => ".".$img_name[1],
                                'mime' => 'image/jpeg',
                                'width' => 156,
                                'height' => 156,
                                'size' => number_format(1.52),
                                'path' => null,
                                'url' => $url_img.$producto->nombreimagen1);

        $thumbnail_large = array('name' => $producto->nombreimagen1,
                                'hash' => $img_name[0],
                                'ext' => ".".$img_name[1],
                                'mime' => 'image/jpeg',
                                'width' => 1000,
                                'height' => 1000,
                                'size' => number_format(18.15),
                                'path' => null,
                                'url' => $url_img.$producto->nombreimagen1);

        $thumbnail_medium = array('name' => $producto->nombreimagen1,
                                'hash' => $img_name[0],
                                'ext' => ".".$img_name[1],
                                'mime' => 'image/jpeg',
                                'width' => 750,
                                'height' => 750,
                                'size' => number_format(11.54),
                                'path' => null,
                                'url' => $url_img.$producto->nombreimagen1);

        $thumbnail_small = array('name' => $producto->nombreimagen1,
                                'hash' => $img_name[0],
                                'ext' => ".".$img_name[1],
                                'mime' => 'image/jpeg',
                                'width' => 500,
                                'height' => 500,
                                'size' => number_format(6.23),
                                'path' => null,
                                'url' => $url_img.$producto->nombreimagen1);

        $thumbnail_formats_img_data = array('thumbnail' => $thumbnail_thumbnail,
                             'large' => $thumbnail_large,
                             'medium' => $thumbnail_medium,
                             'small' => $thumbnail_small);

        $thumbnail_img = array('id' => 1,
                               'name' => $producto->nombreimagen1,
                               'alternativeText' => $producto->titulonombre,
                               'caption' => $this->string2url($producto->titulonombre),
                               'width' => 1200,
                               'height' => 1200,
                               'formats' => $thumbnail_formats_img_data,
                               'hash' => $img_name[0],
                               'ext' => ".".$img_name[1],
                               'mime' => 'image/jpeg',
                               'size' => number_format(23.67),
                               'url' => $url_img.$producto->nombreimagen1,
                               'previewUrl' => null,
                               'provider' => 'local',
                               'provider_metadata' => null,
                               'created_at' => '2021-06-12T09:17:55.793Z',
                               'updated_at' => date("Y-m-d").'T09:17:55.815Z'
                                );

        $thumbnail_back = array('id' => 1,
                                'name' => $producto->nombreimagen1,
                                'alternativeText' => $producto->titulonombre,
                                'caption' => $this->string2url($producto->titulonombre),
                                'width' => 1200,
                                'height' => 1200,
                                'formats' => $thumbnail_formats_img_data,
                                'hash' => $img_name[0],
                                'ext' => ".".$img_name[1],
                                'mime' => 'image/jpeg',
                                'size' => number_format(23.67),
                                'url' => $url_img.$producto->nombreimagen1,
                                'previewUrl' => null,
                                'provider' => 'local',
                                'provider_metadata' => null,
                                'created_at' => '2021-06-12T09:17:55.793Z',
                                'updated_at' => date("Y-m-d").'T09:17:55.815Z'
                                );
        // Fin Foreach IMG AQUI

        $modelos = DB::connection($this->cur_connect)->select("
            select t0.* FROM ".$db_name.'.modelos'." t0
            JOIN ".$db_name.'.validate'." t1 ON t0.Validate = t1.id
            JOIN ".$db_name.'.tiposInmuebles'." t3 ON t3.id = t1.tipovehiculo
            WHERE t0.Validate = '".$producto->id_Validate."' AND t0.id = '".$producto->modelo."' ORDER BY t0.Validate ASC");

        foreach($modelos as $modelo) {
        // Inicio Foreach CAT AQUI
        $cat_pro = array('id' => $modelo->id,
                         'name' => $modelo->modelo,
                         'slug' => $this->string2url($modelo->modelo),
                         'created_at' => '2021-06-12T08:53:06.932Z',
                         'updated_at' => date("Y-m-d").'T08:53:06.943Z');
        $product_categories[] = $cat_pro;
        // Fin Foreach CAT AQUI
        }

        // Inicio Foreach validate
        $brand = array('id' => $producto->id_Validate,
                       'name' => $producto->Validate,
                       'slug' => $this->string2url($producto->Validate),
                       'created_at' => date("Y-m-d").'T10:56:52.945Z',
                        'updated_at' => date("Y-m-d").'T10:58:02.351Z');
        $product_brands[] = $brand;
        // Fin Foreach validate

        // Imagenes

            $datoproduct = [
            'id' => $producto->idproducto,
            'name' => $producto->titulonombre,
            'featured' => false,
            'price' => $producto->precio,
            'sale_price' => $producto->precio,
            'numerounidades' => $producto->numerodeunidades,
            'on_sale' => true,
            'slug' => $this->string2url($producto->titulonombre),
            'is_stock' => true,
            'rating_count' => 9,
            'description' => 'Los autos están expuestos a diario a sufrir una falla o
             verse involucrados en accidentes de tránsito, y  dependiendo del nivel de
            daño, se requiere sustituir piezas. Para los fabricantes y talleres es
            importante tratar de devolver el auto a sus condiciones iniciales.,',
            'short_description' => 'La industria automotriz está implementando nuevos sistemas modulares  para reducir el costo de producción',
            'created_at' => '2021-06-12T09:24:14.184Z',
            'updated_at' => '2021-06-12T11:06:51.663Z',
            'sizes' => array(),
            'colors' => array(),
            'badges' => array(),
            'images' => $img,
            'thumbnail' => $thumbnail_img,
            'thumbnail_back' => $thumbnail_back,
            'collections' => array(),
            'product_categories' => $product_categories,
            'product_brands' => $product_brands,
            ];
            $product[] = $datoproduct;

            //////////////////////////
            // FIN FOREACH PRODUCTOS

        }

        $rec->headers->set('Accept', 'application/json');
        echo json_encode($product);
        exit;
    }

    public function createDocsNit($rec)
    {

        //echo json_encode($rec);
        //echo json_encode($rec->usuario);
        //echo json_encode($rec->estado);
//exit;
        DB::beginTransaction();
        try {
                    $db_name = $this->db.".documentoscrearnit";
                    $crearDocsNit = new ModelGlobal();
                    $crearDocsNit->setConnection($this->cur_connect);
                    $crearDocsNit->setTable($db_name);
                    //$extension = ".jpg";
                    //$extension = $this->getB64Extension($rec->doc1);

                    //$crearProducto->url = $rec->uid;
                    $crearDocsNit->usuario = $rec->usuario;
                    $crearDocsNit->estado = $rec->estado;
                    $crearDocsNit->nombredoc1 = $rec->nombredoc1;
                    $crearDocsNit->nombredoc2 = $rec->nombredoc2;
                    $crearDocsNit->nombredoc3 = $rec->nombredoc3;

                   //Imagen base 64 se pasa a un arreglo
                    $doc[1] = $rec->doc1;
                    $doc[2] = $rec->doc2;
                    $doc[3] = $rec->doc3;

                    //$nombreimagen1=$rec->nombreimagen1;
                    //$nuevoUser->primernombre = $rec->primernombre;

                    $crearDocsNit->save();

                    //for ($i = 1; $i <= $rec->longitud; $i++) {
                        //this->GuardarIMG($doc[$i] ,$nombredoc[$i],'mercadorepuesto/');
                    $response = FunctionsCustoms::UploadPDF($rec->doc1,'mercadorepuesto/pdf/');
                    $response = FunctionsCustoms::UploadPDF($rec->doc2,'mercadorepuesto/pdf/');
                    $response = FunctionsCustoms::UploadPDF($rec->doc3,'mercadorepuesto/pdf/');
                    //}

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
            'message' => 'REGISTRO DOCUMENTOS EXITOSO',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    public function savePDFsNit($rec)
    {

        //echo json_encode($rec);
        //echo json_encode($rec->usuario);
        //echo json_encode($rec->estado);
        //exit;
        DB::beginTransaction();
        try {
                    $db_name = $this->db.".documentoscrearnit";
                    $crearDocsNit = new ModelGlobal();
                    $crearDocsNit->setConnection($this->cur_connect);
                    $crearDocsNit->setTable($db_name);
                    //$extension = ".jpg";
                    //$extension = $this->getB64Extension($rec->doc1);

                    //$crearProducto->url = $rec->uid;
                    //$crearDocsNit->usuario = $rec->usuario;
                    //$crearDocsNit->estado = $rec->estado;
                    //$crearDocsNit->nombredoc1 = $rec->nombredoc1;
                    //$crearDocsNit->nombredoc2 = $rec->nombredoc2;
                    //$crearDocsNit->nombredoc3 = $rec->nombredoc3;

                   //Imagen base 64 se pasa a un arreglo
                    //$doc[1] = $rec->doc1;
                    //$doc[2] = $rec->doc2;
                    //$doc[3] = $rec->doc3;

                    //$nombreimagen1=$rec->nombreimagen1;
                    //$nuevoUser->primernombre = $rec->primernombre;

                    //$crearDocsNit->save();

                    //for ($i = 1; $i <= $rec->longitud; $i++) {
                        //this->GuardarIMG($doc[$i] ,$nombredoc[$i],'mercadorepuesto/');
                    $response = FunctionsCustoms::UploadPDF($rec->doc1,'mercadorepuesto/pdf/');
                    //$response = FunctionsCustoms::UploadPDF($rec->doc2,'mercadorepuesto/pdf/');
                    //$response = FunctionsCustoms::UploadPDF($rec->doc3,'mercadorepuesto/pdf/');
                    //}

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
            'message' => 'REGISTRO DOCUMENTOS EXITOSO',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    public function createProduct($rec)
    {

        //echo json_encode($rec);
        //echo json_encode($rec->tipovehiculo);
        //echo json_encode($rec->Validaterepuesto);

        //echo json_encode($rec->imagen1);
        //echo json_encode($rec->imagen2);
        //echo json_encode($rec->imagen3);
        //echo json_encode($rec->imagen4);
        //exit;

        DB::beginTransaction();
        try {
                    $db_name = $this->db.".productos";
                    $crearProducto = new ModelGlobal();
                    $crearProducto->setConnection($this->cur_connect);
                    $crearProducto->setTable($db_name);
                    //$extension = ".jpg";
                    $extension = $this->getB64Extension($rec->imagen1);

                    //$crearProducto->url = $rec->uid;
                    
                    $crearProducto->productogenerico = $rec->productogenerico;
                    $crearProducto->tipovehiculo = $rec->tipovehiculo;
                    $crearProducto->carroceria = $rec->carroceria;
                    $crearProducto->Validate = $rec->Validate;
                    $crearProducto->anno = $rec->anno;
                    $crearProducto->modelo = $rec->modelo;
                    $crearProducto->cilindrajemotor = $rec->cilindrajemotor;
                    $crearProducto->tipocombustible = $rec->tipocombustible;
                    $crearProducto->transmision = $rec->transmision;
                    $crearProducto->tipotraccion = $rec->tipotraccion;
                    $crearProducto->turbocompresor = $rec->turbocompresor;
                    $crearProducto->posicionproducto = $rec->posicionproducto;
                    $crearProducto->partedelvehiculo = $rec->partedelvehiculo;
                    $crearProducto->titulonombre = $rec->titulonombre;
                    $crearProducto->Validaterepuesto = $rec->Validaterepuesto;
                    $crearProducto->condicion = $rec->condicion;
                    $crearProducto->estadoproducto = $rec->estadoproducto;
                    $crearProducto->vendeporpartes = $rec->vendeporpartes;
                    $crearProducto->numerodeparte = $rec->numerodeparte;
                    $crearProducto->numerodeunidades = $rec->numerodeunidades;
                    $crearProducto->precio = $rec->precio;
                    $crearProducto->compatible = $rec->compatible;
                    $crearProducto->descripcionproducto = $rec->descripcionproducto;
                    $crearProducto->peso = $rec->peso;
                    $crearProducto->alto = $rec->alto;
                    $crearProducto->ancho = $rec->ancho;
                    $crearProducto->largo = $rec->largo;
                    $crearProducto->descuento = $rec->descuento;
                    $crearProducto->usuario = $rec->usuario;
                    $crearProducto->moneda = $rec->moneda;
                    $crearProducto->estado = $rec->estado;
    
                    $crearProducto->numerodeimagenes = $rec->longitud;
                    $crearProducto->nombreimagen1 = $rec->nombreimagen1;
                    $crearProducto->nombreimagen2 = $rec->nombreimagen2;
                    $crearProducto->nombreimagen3 = $rec->nombreimagen3;
                    $crearProducto->nombreimagen4 = $rec->nombreimagen4;
                    $crearProducto->nombreimagen5 = $rec->nombreimagen5;
                    $crearProducto->nombreimagen6 = $rec->nombreimagen6;
                    $crearProducto->nombreimagen7 = $rec->nombreimagen7;
                    $crearProducto->nombreimagen8 = $rec->nombreimagen8;
                    $crearProducto->nombreimagen9 = $rec->nombreimagen9;
                    $crearProducto->nombreimagen10 = $rec->nombreimagen10;

                   //Imagen base 64 se pasa a un arreglo
                    $foto[1] = $rec->imagen1;
                    $foto[2] = $rec->imagen2;
                    $foto[3] = $rec->imagen3;
                    $foto[4] = $rec->imagen4;
                    $foto[5] = $rec->imagen5;
                    $foto[6] = $rec->imagen6;
                    $foto[7] = $rec->imagen7;
                    $foto[8] = $rec->imagen8;
                    $foto[9] = $rec->imagen9;
                    $foto[10] = $rec->imagen10;

                    //Nombre imagenes se pasa a un arreglo
                    $nombrefoto[1] = $rec->nombreimagen1;
                    $nombrefoto[2] = $rec->nombreimagen2;
                    $nombrefoto[3] = $rec->nombreimagen3;
                    $nombrefoto[4] = $rec->nombreimagen4;
                    $nombrefoto[5] = $rec->nombreimagen5;
                    $nombrefoto[6] = $rec->nombreimagen6;
                    $nombrefoto[7] = $rec->nombreimagen7;
                    $nombrefoto[8] = $rec->nombreimagen8;
                    $nombrefoto[9] = $rec->nombreimagen9;
                    $nombrefoto[10] = $rec->nombreimagen10;
                    //$nombreimagen1=$rec->nombreimagen1;
                    //$nuevoUser->primernombre = $rec->primernombre;

                    $crearProducto->save();

                    for ($i = 1; $i <= $rec->longitud; $i++) {
                        $this->GuardarIMG($foto[$i] ,$nombrefoto[$i],'mercadorepuesto/');
                    }

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
            'message' => 'REGISTRO FOTOS EXITOSO',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    public function createInmueblesCompatibles($rec)
    {
        //echo json_encode($rec->estado);
        //exit;
        DB::beginTransaction();
        try {
                    $db_name = $this->db.".productosInmuebles";
                    $compatibles = new ModelGlobal();
                    $compatibles->setConnection($this->cur_connect);
                    $compatibles->setTable($db_name);

                    $compatibles->codigopublicacion = $rec->codigopublicacion;
                    $compatibles->tipovehiculo = $rec->tipovehiculo;
                    $compatibles->carroceria = $rec->carroceria;
                    $compatibles->Validate = $rec->Validate;
                    $compatibles->anno = $rec->anno;
                    $compatibles->modelo = $rec->modelo;
                    $compatibles->cilindrajemotor = $rec->cilindrajemotor;
                    $compatibles->tipocombustible = $rec->tipocombustible;
                    $compatibles->transmision = $rec->transmision;
                    $compatibles->partedelvehiculo = $rec->partedelvehiculo;
                    $compatibles->posicionproducto = $rec->posicionproducto;
                    $compatibles->tipotraccion = $rec->tipotraccion;
                    $compatibles->turbocompresor = $rec->turbocompresor;
                    $compatibles->usuario = $rec->usuario;

                    $compatibles->save();

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
            'message' => 'REGISTRO Inmuebles COMPATIBLES EXITOSO',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    public function createInmueblesGarage($rec)
    {
        //echo json_encode($rec->estado);
        //exit;
        DB::beginTransaction();
        try {
                    $db_name = $this->db.".Inmueblesgarage";
                    $garage = new ModelGlobal();
                    $garage->setConnection($this->cur_connect);
                    $garage->setTable($db_name);

                    $date = date('Y-m-d H:i:s');

                    $garage->idusuario = $rec->idusuario;
                    $garage->tipovehiculo = $rec->tipovehiculo;
                    $garage->carroceria = $rec->carroceria;
                    $garage->Validate = $rec->Validate;
                    $garage->anno = $rec->anno;
                    $garage->modelo = $rec->modelo;
                    $garage->cilindrajemotor = $rec->cilindrajemotor;
                    $garage->tipocombustible = $rec->tipocombustible;
                    $garage->transmision = $rec->transmision;
                    $garage->tipotraccion = $rec->tipotraccion;
                    $garage->estado = $rec->estado;
                    $garage->fecha = $date;
                    $garage->comentario = $rec->comentario;

                    $garage->save();

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
            'message' => 'REGISTRO Inmuebles GARAGE EXITOSO',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    public function listarVehiculoGarageUsuario($rec)
    {
        $db_name = "brokerup_sys";

        $garage = DB::connection($this->cur_connect)->select("
            select t0.* from ".$db_name.'.Inmueblesgarage'." t0 
            WHERE t0.estado = 1 ORDER BY id ASC");

        $vehigarage = array();

        //$datoc = [
        //            'header_supplies' => $garage
        //        ];
        //        $vehigarage[] = $datoc;

        echo json_encode($garage);
    }

    public function listarUnVehiculoGarageUsuario($rec)
    {
        $db_name = "brokerup_sys";

        $garage = DB::connection($this->cur_connect)->select("
            select t0.* from ".$db_name.'.Inmueblesgarage'." t0 
            WHERE t0.estado = 1 && t0.idusuario = '". $rec->idusuario."'"); 

        $vehigarage = array();

        //$datoc = [
        //            'header_supplies' => $garage
        //        ];
        //        $vehigarage[] = $datoc;

        echo json_encode($garage);
    }

     //Actualiaza token del usuario al realizar el reenvio
     public function actualizaVehiculoGarageUsuario($rec)
     {
         $db_name = $this->db.".Inmueblesgarage";
 
         DB::beginTransaction();
         try {
 
                $date = date('Y-m-d H:i:s');
                DB::connection($this->cur_connect)->update("UPDATE ".$db_name." 
                SET tipovehiculo = '".$rec->tipovehiculo."'
                    ,idusuario = '".$rec->idusuario."'
                    ,carroceria = '".$rec->carroceria."'
                    ,Validate = '".$rec->Validate."'
                    ,anno = '".$rec->anno."'
                    ,modelo = '".$rec->modelo."'
                    ,cilindrajemotor = '".$rec->cilindrajemotor."'
                    ,tipocombustible = '".$rec->tipocombustible."'
                    ,transmision = '".$rec->transmision."'
                    ,comentario = '".$rec->comentario."'
                    ,estado = '".$rec->estado."'
                    ,fecha = '".$date."'
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

     //Actualiaza token del usuario al realizar el reenvio
     public function borrarVehiculoGarageUsuario($rec)
     {
         $db_name = $this->db.".Inmueblesgarage";
 
         DB::beginTransaction();
         try {
 
            DB::connection($this->cur_connect)->delete("DELETE FROM ".$db_name." 
            WHERE id = ".$rec->id);
 
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

    public function crearValidateVehiculo($rec)
    {
        //echo json_encode($rec->estado);
        //exit;
        DB::beginTransaction();
        try {
                    $db_name = $this->db.".validate";
                    $nvaValidate = new ModelGlobal();
                    $nvaValidate->setConnection($this->cur_connect);
                    $nvaValidate->setTable($db_name);

                    $nvaValidate->text = $rec->nombreValidate;
                    $nvaValidate->tipovehiculo = $rec->tipo;
                    $nvaValidate->carroceria = $rec->carroceria;
                    $nvaValidate->estado = $rec->estado;
                    $nvaValidate->url = $rec->url;
                    $nvaValidate->id = $rec->Validate;

                    $nvaValidate->save();

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
            'message' => 'REGISTRO Inmuebles COMPATIBLES EXITOSO',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    //Obtener la extension de un base 64
    public function getB64Extension($base64_image, $full=null){
        // Obtener mediante una expresión regular la extensión imagen y guardarla
        // en la variable "img_extension"
        preg_match("/^data:image\/(.*);base64/i",$base64_image, $img_extension);
        // Dependiendo si se pide la extensión completa o no retornar el arreglo con
        // los datos de la extensión en la posición 0 - 1
        return ($full) ?  $img_extension[0] : $img_extension[1];
    }

    public function GuardarIMG($imagenB64,$nameImg,$dirImg)
    {
        return $upd_img = FunctionsCustoms::UploadImageMrp($imagenB64,$nameImg,$dirImg);
    }

    public function string2url($cadena) {
        $cadena = trim($cadena);
        $cadena = strtr($cadena,
    "ÀÁÂÃÄÅàáâãäåÒÓÔÕÖØòóôõöøÈÉÊËèéêëÇçÌÍÎÏìíîïÙÚÛÜùúûüÿÑñ",
    "aaaaaaaaaaaaooooooooooooeeeeeeeecciiiiiiiiuuuuuuuuynn");
        $cadena = strtr($cadena,"ABCDEFGHIJKLMNOPQRSTUVWXYZ","abcdefghijklmnopqrstuvwxyz");
        $cadena = preg_replace('#([^.a-z0-9]+)#i', '-', $cadena);
            $cadena = preg_replace('#-{2,}#','-',$cadena);
            $cadena = preg_replace('#-$#','',$cadena);
            $cadena = preg_replace('#^-#','',$cadena);
        return $cadena;
    }

     //Actualiaza token del usuario al realizar el reenvio
    public function updateToken($rec)
    {
        $db_name = $this->db.".users";

        DB::beginTransaction();
        try {

            DB::connection($this->cur_connect)->update("UPDATE ".$db_name."
                SET token = '".$rec->token."' WHERE uid = '".$rec->id."'");

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


    //Activa usuario en la base de datos al ingresar el Token
    public function activeToken($rec)
    {
        $db_name = $this->db.".users";

        DB::beginTransaction();
        try {

            DB::connection($this->cur_connect)->update("UPDATE ".$db_name." SET activo = 'S' WHERE uid = '".$rec->id."'");

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

    public function subirImagenesBE($rec)
    {
        //echo json_encode($rec);
        //echo json_encode($rec->usuario);
        //echo json_encode($rec->estado);
//exit;
        DB::beginTransaction();
        try {
                    $db_name = $this->db.".imagenesbe";
                    $subirImagenes = new ModelGlobal();
                    $subirImagenes->setConnection($this->cur_connect);
                    $subirImagenes->setTable($db_name);
                    //$extension = ".jpg";
                    //$extension = $this->getB64Extension($rec->doc1);

                    $subirImagenes->codigo = $rec->codigo;
                    $subirImagenes->nombredocumento1 = $rec->nombredcto1;
                    $subirImagenes->nombredocumento2 = $rec->nombredcto2;
                    $subirImagenes->nombredocumento22 = $rec->nombredcto22;
                    $subirImagenes->nombredocumento3 = $rec->nombredcto3;
                    $subirImagenes->nombredocumento32 = $rec->nombredcto32;
                    $subirImagenes->nombredocumento4 = $rec->nombredcto4;
                    $subirImagenes->nombredocumento42 = $rec->nombredcto42;
                    $subirImagenes->nombredocumento5 = $rec->nombredcto5;
                    $subirImagenes->nombredocumento52 = $rec->nombredcto52;
                    $subirImagenes->nombredocumento6 = $rec->nombredcto6;
                    $subirImagenes->nombredocumento62 = $rec->nombredcto62;
                    $subirImagenes->nombredocumento7 = $rec->nombredcto7;
                    $subirImagenes->nombredocumento72 = $rec->nombredcto72;
                    $subirImagenes->nombredocumento8 = $rec->nombredcto8;
                    $subirImagenes->nombredocumento82 = $rec->nombredcto82;
                    $subirImagenes->nombredocumento9 = $rec->nombredcto9;
                    $subirImagenes->nombredocumento92 = $rec->nombredcto92;
                    $subirImagenes->nombredocumento10 = $rec->nombredcto10;
                    $subirImagenes->nombredocumento102 = $rec->nombredcto102;
                    $subirImagenes->nombredocumento11 = $rec->nombredcto11;
                    $subirImagenes->nombredocumento112 = $rec->nombredcto112;
                    $subirImagenes->nombredocumento12 = $rec->nombredcto12;
                    $subirImagenes->nombredocumento122 = $rec->nombredcto122;
                    $subirImagenes->nombredocumento13 = $rec->nombredcto13;
                    $subirImagenes->nombredocumento132 = $rec->nombredcto132;
                    $subirImagenes->nombredocumento14 = $rec->nombredcto14;
                    $subirImagenes->nombredocumento142 = $rec->nombredcto142;
                    $subirImagenes->nombredocumento15 = $rec->nombredcto15;
                    $subirImagenes->nombredocumento152 = $rec->nombredcto152;
                    $subirImagenes->nombredocumento16 = $rec->nombredcto16;
                    $subirImagenes->nombredocumento162 = $rec->nombredcto162;
                    $subirImagenes->nombredocumento17 = $rec->nombredcto17;
                    $subirImagenes->nombredocumento172 = $rec->nombredcto172;
                    
                    //Imagen base 64 se pasa a un arreglo
                    $doc[1] = $rec->doc1;
                    $doc[2] = $rec->doc2;
                    $doc[3] = $rec->doc22;
                    $doc[4] = $rec->doc3;
                    $doc[5] = $rec->doc32;
                    $doc[6] = $rec->doc4;
                    $doc[7] = $rec->doc42;
                    $doc[8] = $rec->doc5;
                    $doc[9] = $rec->doc52;
                    $doc[10] = $rec->doc6;
                    $doc[11] = $rec->doc62;
                    $doc[12] = $rec->doc7;
                    $doc[13] = $rec->doc72;
                    $doc[14] = $rec->doc8;
                    $doc[15] = $rec->doc82;
                    $doc[16] = $rec->doc9;
                    $doc[17] = $rec->doc92;
                    $doc[18] = $rec->doc10;
                    $doc[19] = $rec->doc102;
                    $doc[20] = $rec->doc11;
                    $doc[21] = $rec->doc112;
                    $doc[22] = $rec->doc12;
                    $doc[23] = $rec->doc122;
                    $doc[24] = $rec->doc13;
                    $doc[25] = $rec->doc132;
                    $doc[26] = $rec->doc14;
                    $doc[27] = $rec->doc142;
                    $doc[28] = $rec->doc15;
                    $doc[29] = $rec->doc152;
                    $doc[30] = $rec->doc16;
                    $doc[31] = $rec->doc162;
                    $doc[32] = $rec->doc17;
                    $doc[33] = $rec->doc172;

                    $nombreimagen[1]=$rec->nombredcto1;
                    $nombreimagen[2]=$rec->nombredcto2;
                    $nombreimagen[3]=$rec->nombredcto22;
                    $nombreimagen[4]=$rec->nombredcto3;
                    $nombreimagen[5]=$rec->nombredcto32;
                    $nombreimagen[6]=$rec->nombredcto4;
                    $nombreimagen[7]=$rec->nombredcto42;
                    $nombreimagen[8]=$rec->nombredcto5;
                    $nombreimagen[9]=$rec->nombredcto52;
                    $nombreimagen[10]=$rec->nombredcto6;
                    $nombreimagen[11]=$rec->nombredcto62;
                    $nombreimagen[12]=$rec->nombredcto7;
                    $nombreimagen[13]=$rec->nombredcto72;
                    $nombreimagen[14]=$rec->nombredcto8;
                    $nombreimagen[15]=$rec->nombredcto82;
                    $nombreimagen[16]=$rec->nombredcto9;
                    $nombreimagen[17]=$rec->nombredcto92;
                    $nombreimagen[18]=$rec->nombredcto10;
                    $nombreimagen[19]=$rec->nombredcto102;
                    $nombreimagen[20]=$rec->nombredcto11;
                    $nombreimagen[21]=$rec->nombredcto112;
                    $nombreimagen[22]=$rec->nombredcto12;
                    $nombreimagen[23]=$rec->nombredcto122;
                    $nombreimagen[24]=$rec->nombredcto13;
                    $nombreimagen[25]=$rec->nombredcto132;
                    $nombreimagen[26]=$rec->nombredcto14;
                    $nombreimagen[27]=$rec->nombredcto142;
                    $nombreimagen[28]=$rec->nombredcto15;
                    $nombreimagen[29]=$rec->nombredcto152;
                    $nombreimagen[30]=$rec->nombredcto16;
                    $nombreimagen[31]=$rec->nombredcto162;
                    $nombreimagen[32]=$rec->nombredcto17;
                    $nombreimagen[33]=$rec->nombredcto172;

                    $subirImagenes->save();

                    for ($i = 1; $i <= $rec->longitud; $i++) {               
                        $this->GuardarIMG($doc[$i] ,$nombreimagen[$i],'mercadorepuesto/buscador/');
                    //$response = FunctionsCustoms::UploadPDF($rec->doc1,'mercadorepuesto/pdf/');
                    //$response = FunctionsCustoms::UploadPDF($rec->doc2,'mercadorepuesto/pdf/');
                    //$response = FunctionsCustoms::UploadPDF($rec->doc3,'mercadorepuesto/pdf/');
                    }

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
            'message' => 'REGISTRO DOCUMENTOS EXITOSO',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }   

    public function leerImagenesBe($rec)
    {
        //echo json_encode($rec);
        //exit;      
        $db_name = "brokerup_sys";
    
        $leerimagenesbe = DB::connection($this->cur_connect)->select(
                                              "select t0.*
                                               from ".$db_name.'.imagenesbe'." 
                                               t0 WHERE codigo = '". $rec->codigo."'"); 

    echo json_encode($leerimagenesbe);
    }

    public function subirImagenesLatInt($rec)
    {
        //echo json_encode($rec);
        //echo json_encode($rec->usuario);
        //echo json_encode($rec->estado);
//exit;
        DB::beginTransaction();
        try {
                    $db_name = $this->db.".imageneslotint";
                    $subirImagenes = new ModelGlobal();
                    $subirImagenes->setConnection($this->cur_connect);
                    $subirImagenes->setTable($db_name);
                    //$extension = ".jpg";
                    //$extension = $this->getB64Extension($rec->doc1);

                    $subirImagenes->codigo = $rec->codigo;
                    $subirImagenes->nombredocumento1 = $rec->nombredcto1;
                    $subirImagenes->nombredocumento2 = $rec->nombredcto2;
                    $subirImagenes->nombredocumento3 = $rec->nombredcto3;
                    $subirImagenes->nombredocumento4 = $rec->nombredcto4;
                    $subirImagenes->nombredocumento5 = $rec->nombredcto5;
                    $subirImagenes->nombredocumento6 = $rec->nombredcto6;
                    $subirImagenes->nombredocumento7 = $rec->nombredcto7;
                    $subirImagenes->nombredocumento8 = $rec->nombredcto8;
                    $subirImagenes->nombredocumento9 = $rec->nombredcto9;
                    $subirImagenes->nombredocumento10 = $rec->nombredcto10;
                    $subirImagenes->nombredocumento11 = $rec->nombredcto11;
                    $subirImagenes->nombredocumento12 = $rec->nombredcto12;
                    $subirImagenes->nombredocumento13 = $rec->nombredcto13;
                    $subirImagenes->nombredocumento14 = $rec->nombredcto14;
                    $subirImagenes->nombredocumento15 = $rec->nombredcto15;
                    $subirImagenes->nombredocumento16 = $rec->nombredcto16;
                    $subirImagenes->nombredocumento17 = $rec->nombredcto17;
                    
                    //Imagen base 64 se pasa a un arreglo
                    $doc[1] = $rec->doc1;
                    $doc[2] = $rec->doc2;
                    $doc[3] = $rec->doc3;
                    $doc[4] = $rec->doc4;
                    $doc[5] = $rec->doc5;
                    $doc[6] = $rec->doc6;
                    $doc[7] = $rec->doc7;
                    $doc[8] = $rec->doc8;
                    $doc[9] = $rec->doc9;
                    $doc[10] = $rec->doc10;
                    $doc[11] = $rec->doc11;
                    $doc[12] = $rec->doc12;
                    $doc[13] = $rec->doc13;
                    $doc[14] = $rec->doc14;
                    $doc[15] = $rec->doc15;
                    $doc[16] = $rec->doc16;
                    $doc[17] = $rec->doc17;

                    $nombreimagen[1]=$rec->nombredcto1;
                    $nombreimagen[2]=$rec->nombredcto2;
                    $nombreimagen[3]=$rec->nombredcto3;
                    $nombreimagen[4]=$rec->nombredcto4;
                    $nombreimagen[5]=$rec->nombredcto5;
                    $nombreimagen[6]=$rec->nombredcto6;
                    $nombreimagen[7]=$rec->nombredcto7;
                    $nombreimagen[8]=$rec->nombredcto8;
                    $nombreimagen[9]=$rec->nombredcto9;
                    $nombreimagen[10]=$rec->nombredcto10;
                    $nombreimagen[11]=$rec->nombredcto11;
                    $nombreimagen[12]=$rec->nombredcto12;
                    $nombreimagen[13]=$rec->nombredcto13;
                    $nombreimagen[14]=$rec->nombredcto14;
                    $nombreimagen[15]=$rec->nombredcto15;
                    $nombreimagen[16]=$rec->nombredcto16;
                    $nombreimagen[17]=$rec->nombredcto17;

                    $subirImagenes->save();

                    for ($i = 1; $i <= $rec->longitud; $i++) {               
                        $this->GuardarIMG($doc[$i] ,$nombreimagen[$i],'mercadorepuesto/buscador/');
                    //$response = FunctionsCustoms::UploadPDF($rec->doc1,'mercadorepuesto/pdf/');
                    //$response = FunctionsCustoms::UploadPDF($rec->doc2,'mercadorepuesto/pdf/');
                    //$response = FunctionsCustoms::UploadPDF($rec->doc3,'mercadorepuesto/pdf/');
                    }

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
            'message' => 'REGISTRO DOCUMENTOS EXITOSO',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    public function leerImagenesLatInt($rec)
    {
        //echo json_encode($rec);
        //exit;      
        $db_name = "brokerup_sys";
    
        $leerimageneslatint = DB::connection($this->cur_connect)->select(
                                              "select t0.*
                                               from ".$db_name.'.imageneslotint'." 
                                               t0 WHERE codigo = '". $rec->codigo."'"); 

        echo json_encode($leerimageneslatint);
    }



}


/* endpoint SIIGO MERCADO REPUESTO - CONEXIONES 

        DB::beginTransaction();
        try {
                    $db_name = $this->db.".pedidos";
                    $pedidosventa = new ModelGlobal();
                    $pedidosventa->setConnection($this->cur_connect);
                    $pedidosventa->setTable($db_name);

                    $pedidosventa->id_fact = $rec->id_fact;
                    $pedidosventa->id_siigo = $rec->id_siigo;
                    $pedidosventa->comprobante = $rec->comprobante;
                    $pedidosventa->prefijo = $rec->prefijo;
                    $pedidosventa->facturasiigo = $rec->facturasiigo;
                    $pedidosventa->fechafactura = $rec->fechafactura;
                    $pedidosventa->idcliente = $rec->idcliente;
                    $pedidosventa->estadocliente = $rec->estadocliente;
                    $pedidosventa->valorfactura = $rec->valorfactura;
                    $pedidosventa->descuento = $rec->descuento;
                    $pedidosventa->cost_center = $rec->cost_center;
                    $pedidosventa->seller = $rec->seller;
                    $pedidosventa->status = $rec->status;
                    $pedidosventa->delivery_type = $rec->delivery_type;
                    $pedidosventa->valorimpuesto = $rec->valorimpuesto;
                    $pedidosventa->porcentajeimpto = $rec->porcentajeimpto;
                    $pedidosventa->Observaciones = $rec->observaciones;

                    $pedidosventa->save();

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

    // Lee la condición del producto
    public function listarPedidosDB($rec)
    {
        $db_name = "cyclewear_sys";
        
        $listarpedidos = DB::connection($this->cur_connect)->select(
                                                "select t0.* 
                                                from ".$db_name.'.pedidos'." t0 
                                                ORDER BY id_fact DESC"); 
    
        echo json_encode($listarpedidos);
    }

    // Lee la condición del producto
    public function listarItemsPedidosDB($rec)
    {
        $db_name = "cyclewear_sys";
            
         $listaritemspedidos = DB::connection($this->cur_connect)->select(
                                                "select t0.* 
                                                from ".$db_name.'.itemspedidos'." t0 "); 
        
        echo json_encode($listaritemspedidos);
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
                $itemspedidosventa->advert_code = $rec->advert_code;
                $itemspedidosventa->brand_name = $rec->brand_name;
                $itemspedidosventa->price = $rec->price;
                $itemspedidosventa->quantity = $rec->quantity;
                $itemspedidosventa->subtotal = $rec->subtotal;
                $itemspedidosventa->tax_total = $rec->tax_total;
                $itemspedidosventa->taxon_name = $rec->taxon_name;
                $itemspedidosventa->status = $rec->status;
                $itemspedidosventa->total = $rec->total;
                $itemspedidosventa->variant_barcode = $rec->variant_barcode;
                $itemspedidosventa->variant_name = $rec->variant_name;
                $itemspedidosventa->variant_sku = $rec->variant_sku;
                $itemspedidosventa->codigoproductosiigo = $rec->codigoproductosiigo;
                $itemspedidosventa->direccion = $rec->direccion;
                $itemspedidosventa->observaciones = $rec->observaciones;
                $itemspedidosventa->categoriauno = $rec->categoriauno;
                $itemspedidosventa->categoriados = $rec->categoriados;
                $itemspedidosventa->categoriatres = $rec->categoriatres;
                $itemspedidosventa->categoriacuatro = $rec->categoriacuatro;
                $itemspedidosventa->codigoconsecutivo = $rec->codigoconsecutivo;

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

    // Lee la condición del producto
    public function cwrTiposProducto($rec)
    {
        $db_name = "cyclewear_sys";
    
        $listTiposProductos = DB::connection($this->cur_connect)->select("select t0.id as value, t0.nombretipoproducto as label, t0.* ,
                                                        t1.nombreestado
                                                        from ".$db_name.'.tipodeproducto'." t0
                                                        JOIN ".$db_name.'.estados'." t1 ON t0.estado = t1.id
                                                        WHERE t0.estado = 1 ORDER BY nombretipoproducto ASC");
    
        //$condicionprod = array();
    
        //$datoc = [
        //           'header_supplies' => $condicionproducto
        //            ];
        //         $condicionprod[] = $datoc;
    
        echo json_encode($listTiposProductos);
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
                $crearProducto->Validate = $rec->Validate;
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

    // Lee un producto por el codigo en la DB Local
    public function cwrLeeUnProductoDB($rec)
    {
        //echo json_encode($rec->idinterno);
        //exit;
        $db_name = "cyclewear_sys";
            
        $leeproducto = DB::connection($this->cur_connect)->select(
                                            "select t0.*
                                             from ".$db_name.'.productos'." t0
                                             WHERE sku = '". $rec->sku."'"); 
         
        echo json_encode($leeproducto);
    }

    // Lee las variantes de los productos creados en la BD Local
    public function cwrListarVariantesProducto($rec)
    {
        //echo json_encode($rec->idinterno);
        //exit;
        $db_name = "cyclewear_sys";
      
        $variantesproducto = DB::connection($this->cur_connect)->select(
                                              "select t0.id as value, t0.idinterno as label, t0.*,
                                              t1.nombretipoproducto, t2.nombrecategoriauno, t3.nombrecategoriados,
                                              t4.nombrecategoriatres, t5.nombrecategoriacuatro
                                              from ".$db_name.'.variantesproductos'." t0 
                                              JOIN ".$db_name.'.productos'." t6 ON t0.idinterno = t6.idinterno
                                              JOIN ".$db_name.'.tipodeproducto'." t1 ON t6.tipodeproducto = t1.id
                                              JOIN ".$db_name.'.categoriauno'." t2 ON t6.categoriauno = t2.id  
                                              left join ".$db_name.'.categoriados'." t3 ON t6.categoriados = t3.id
                                              left join ".$db_name.'.categoriatres'." t4 ON t6.categoriatres = t4.id
                                              left join ".$db_name.'.categoriacuatro'." t5 ON t6.categoriacuatro = t5.id
                                              WHERE t0.estado = 1"); 
  
        echo json_encode($variantesproducto);
    }

    // Lee las variantes de los productos creados en la BD Local
    public function cwrListarUnaVarianteProducto($rec)
    {
        //echo json_encode($rec->idinterno);
        //exit;
        $db_name = "cyclewear_sys";
          
        $variantesproducto = DB::connection($this->cur_connect)->select(
                                              "select t0.id as value, t0.idinterno as label, t0.*,
                                              t1.nombretipoproducto, t2.nombrecategoriauno, t3.nombrecategoriados,
                                              t4.nombrecategoriatres, t5.nombrecategoriacuatro
                                              from ".$db_name.'.variantesproductos'." t0 
                                              JOIN ".$db_name.'.productos'." t6 ON t0.idinterno = t6.idinterno
                                              JOIN ".$db_name.'.tipodeproducto'." t1 ON t6.tipodeproducto = t1.id
                                              JOIN ".$db_name.'.categoriauno'." t2 ON t6.categoriauno = t2.id  
                                              left join ".$db_name.'.categoriados'." t3 ON t6.categoriados = t3.id
                                              left join ".$db_name.'.categoriatres'." t4 ON t6.categoriatres = t4.id
                                              left join ".$db_name.'.categoriacuatro'." t5 ON t6.categoriacuatro = t5.id 
                                              WHERE t0.estado = 1 && t0.idinterno = '". $rec->idinterno."'"); 
      
        echo json_encode($variantesproducto);
    }
    
    //Crear usuario en Base de Datos
    public function cwrCrearVarianteProductoDB($rec)
    {
        //echo json_encode($rec->idvariante);
        //exit;
        DB::beginTransaction();
        try {
                $db_name = $this->db.".variantesproductos";
                $crearVarianteProducto = new ModelGlobal();
                $crearVarianteProducto->setConnection($this->cur_connect);
                $crearVarianteProducto->setTable($db_name);
  
                $crearVarianteProducto->idvariante = $rec->idvariante;
                $crearVarianteProducto->idinterno = $rec->idinterno;
                $crearVarianteProducto->nombrevarianteuno = $rec->nombrevarianteuno;
                $crearVarianteProducto->nombrevariantedos = $rec->nombrevariantedos;
                $crearVarianteProducto->nombrevariantetres = $rec->nombrevariantetres;
                $crearVarianteProducto->nombrevariantecuatro = $rec->nombrevariantecuatro;
                $crearVarianteProducto->nombrevariantecinco = $rec->nombrevariantecinco;
                $crearVarianteProducto->preciobasevariante = $rec->preciobasevariante;
                $crearVarianteProducto->precioventavariante = $rec->precioventavariante;
                $crearVarianteProducto->cantidadvariante = $rec->cantidadvariante;
                $crearVarianteProducto->codigobarravariante = $rec->codigobarravariante;
                $crearVarianteProducto->skuvariante = $rec->skuvariante;
                $crearVarianteProducto->taxcodevariante = $rec->taxcodevariante;
                $crearVarianteProducto->fechaingreso = $rec->fechaingreso;
                $crearVarianteProducto->fechamodificacion = $rec->fechamodificacion;
                $crearVarianteProducto->estado = $rec->estado;
  
                $crearVarianteProducto->save();
  
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

    //Crear Interlocutor en Base de Datos Local
    public function cwrCrearInterlocutor($rec)
    {
         DB::beginTransaction();
         try {
                     $db_name = $this->db.".interlocutores";
                     $nuevoInterlocutor = new ModelGlobal();
                     $nuevoInterlocutor->setConnection($this->cur_connect);
                     $nuevoInterlocutor->setTable($db_name);
 
                     $nuevoInterlocutor->tipotercero = $rec->tipotercero;
                     $nuevoInterlocutor->tipopersona = $rec->tipopersona;
                     $nuevoInterlocutor->tipoidentificacion = $rec->tipoidentificacion;
                     $nuevoInterlocutor->identificacion = $rec->identificacion;
                     $nuevoInterlocutor->digitodeverificacion = $rec->digitodeverificacion;
                     $nuevoInterlocutor->razonsocial = $rec->razonsocial;
                     $nuevoInterlocutor->nombres = $rec->nombres;
                     $nuevoInterlocutor->apellidos = $rec->apellidos;
                     $nuevoInterlocutor->nombrecomercial = $rec->nombrecomercial;
                     $nuevoInterlocutor->sucursal = $rec->sucursal;
                     $nuevoInterlocutor->estado = $rec->estado;
                     $nuevoInterlocutor->ciudad = $rec->ciudad;
                     $nuevoInterlocutor->direccion = $rec->direccion;
                     $nuevoInterlocutor->indicativo = $rec->indicativo;
                     $nuevoInterlocutor->telefono = $rec->telefono;
                     $nuevoInterlocutor->extension = $rec->extension;
                     $nuevoInterlocutor->nombrescontacto = $rec->nombrescontacto;
                     $nuevoInterlocutor->apellidoscontacto = $rec->apellidoscontacto;
                     $nuevoInterlocutor->correocontacto = $rec->correocontacto;
                     $nuevoInterlocutor->tipoderegimen = $rec->tipoderegimen;
                     $nuevoInterlocutor->codigoresponsabilidadfiscal = $rec->codigoresponsabilidadfiscal;
                     $nuevoInterlocutor->indicativofacturacion = $rec->indicativofacturacion;
                     $nuevoInterlocutor->telefonofacturacion = $rec->telefonofacturacion;
                     $nuevoInterlocutor->codigopostalfacturacion = $rec->codigopostalfacturacion;
                     $nuevoInterlocutor->usuarioasignado = $rec->usuarioasignado;
                     $nuevoInterlocutor->observacion = $rec->observacion;
                     $nuevoInterlocutor->fechacreacion = $rec->fechacreacion;
                     $nuevoInterlocutor->fechamodificacion = $rec->fechamodificacion;
          
                     $nuevoInterlocutor->save();
 
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

     //Crear Interlocutor en Base de Datos Local tomados de BikeExchange
    public function cwrCrearInterlocutorBE($rec)
    {
         DB::beginTransaction();
         try {
                     $db_name = $this->db.".interlocutores";
                     $nuevoInterlocutor = new ModelGlobal();
                     $nuevoInterlocutor->setConnection($this->cur_connect);
                     $nuevoInterlocutor->setTable($db_name);

                     $nuevoInterlocutor->tipotercero = $rec->tipotercero;
                     $nuevoInterlocutor->tipopersona = $rec->tipotercero;
                     $nuevoInterlocutor->tipoidentificacion = $rec->id_type;
                     $nuevoInterlocutor->identificacion = $rec->identification;
                     $nuevoInterlocutor->digitodeverificacion = $rec->check_digit;
                     $nuevoInterlocutor->razonsocial = $rec->commercial_name;
                     $nuevoInterlocutor->nombres = $rec->nombre;
                     $nuevoInterlocutor->apellidos = $rec->apellido;
                     $nuevoInterlocutor->nombrecomercial = $rec->commercial_name;
                     $nuevoInterlocutor->sucursal = $rec->sucursal;
                     $nuevoInterlocutor->estado = $rec->estado;
                     $nuevoInterlocutor->ciudad = $rec->ciudad;
                     $nuevoInterlocutor->direccion = $rec->address;
                     $nuevoInterlocutor->indicativo = $rec->indicative;
                     $nuevoInterlocutor->telefono = $rec->number;
                     $nuevoInterlocutor->extension = $rec->extension;
                     $nuevoInterlocutor->nombrescontacto = $rec->nombre;
                     $nuevoInterlocutor->apellidoscontacto = $rec->apellido;
                     $nuevoInterlocutor->correocontacto = $rec->email;
                     $nuevoInterlocutor->tipoderegimen = $rec->tipoderegimen;
                     $nuevoInterlocutor->codigoresponsabilidadfiscal = $rec->code;
                     $nuevoInterlocutor->indicativofacturacion = $rec->indicativofacturacion;
                     $nuevoInterlocutor->telefonofacturacion = $rec->number;
                     $nuevoInterlocutor->codigopostalfacturacion = $rec->postal_code;
                     $nuevoInterlocutor->usuarioasignado = $rec->usuarioasignado;
                     $nuevoInterlocutor->observacion = $rec->comments;
                     $nuevoInterlocutor->fechacreacion = $rec->fecha;
                     $nuevoInterlocutor->fechamodificacion = $rec->fecha;
          
                     $nuevoInterlocutor->save();
 
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

    public function listarComprobantes($rec)
    {
        //created_start=2021-02-17
        //$url = $this->url_siigo_api."document-types?type=FV"; ID COMPROBANTES
        //$url = $this->url_siigo_api."users";
        //$url = $this->url_siigo_api."payment-types?document_type=FV";
        //$url = $this->url_siigo_api."taxes";
        //$url = $this->url_siigo_api."warehouses";
        //$url = $this->url_siigo_api."products";
        // $url = $this->url_siigo_api."taxes";
        //  $url = $this->url_siigo_api."users";
        //$url = $this->url_siigo_api."account-groups";
        //$url = $this->url_siigo_api."cost-centers";
        //$url = $this->url_siigo_api."users";
        $url = $this->url_siigo_api."/products/75abf5d7-5736-430d-aea5-1f78b9b8e7e8";
        $response = FunctionsCustoms::SiigoGet($url,$this->db);
        echo $response;
        exit;
        // El objeto llega con String por eso no podias entrarle como un arreglo, con esta funcion la conviertes en un objecto accesible, y le agregas el segundo paramtro true para que seaun array manejable
        //var_dump($data); // luego de convertilo en un array porque te lo devolvia como un string puedes explorar sus llaves y sus array y objetos con esta funcion y asi puedes ver hasta donde quieres llegar en este caso a el result pero el result tiene 17 array y tiene sque decirle cual array quieres acceder
        //var_dump($data["results"][0]["code"]); // aqui acceso a el objecto results y luego al el array 0 y luego dentro de ese array cero es que encuentro en code
        //var_dump($data);
        //echo $data["results"][1]["code"];
        //echo $data["results"][11]["code"];
        $listaitems = array();
        foreach($data["results"] as $items){
            $itemunico = array("code:"=>$items["code"],
                               "id:"=>$items["id"],
                                "name:"=>$items["name"],
                                "namedos:"=>$items["reference"],
                                "adicional:"=>
                                    @$items["additional_fields"][0]["barcode"] ?
                                    $items["additional_fields"][0]["barcode"]
                                    :
                                    0,
                               "nombre:"=>
                                    @$items["prices"][0]["price_list"][0]["name"] ?
                                    $items["prices"][0]["price_list"][0]["name"]
                                    :
                                    0,
                                "valor:"=>
                                    @$items["prices"][0]["price_list"][0]["value"] ?
                                    $items["prices"][0]["price_list"][0]["value"]
                                    :
                                    0   
        );
            //    var_dump($items["prices"][0]["price_list"][0]["value"]); 
            $listaitems[] = $itemunico;
        };
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($listaitems);
        //exit;
        //$rec->headers->set('Accept', 'application/json');
        //echo $response;
    }

    public function listarProductosSiigo($rec)
    { 
        $inicia =  $rec->pagina;
        //$url = $this->url_siigo_api."products?page=".$inicia."&page_size=25";
        //$url = $this->url_siigo_api."products?created_start=2022-09-07";
        $url = $this->url_siigo_api."products?page=".$inicia."&page_size=25";
        $response = FunctionsCustoms::SiigoGet($url,$this->db);
        //echo $response;
        //exit;

        $data = json_decode($response, true);
       
        $listaitems = array();

    foreach($data["results"] as $items){
    $itemunico = array("tipoimpuesto"=>$items["tax_classification"]);

    if($itemunico["tipoimpuesto"] == "Excluded" ){
        $itemunico = array("code"=>$items["code"],
                       "id"=>$items["id"],
                        "name"=>$items["name"],
                        "sku"=>$items["reference"],
                        "idgrupo"=>
                            @$items["account_group"][0]["id"] ?
                            $items["account_group"][0]["id"]
                            :
                            0,
                        "nombregrupo"=>
                            @$items["account_group"][0]["name"] ?
                            $items["account_group"][0]["name"]
                            :
                            0,
                        "cantidad"=>$items["available_quantity"],
                        "impuestos"=>0,
                        "codigobarra"=>
                            @$items["additional_fields"][0]["barcode"] ?
                            $items["additional_fields"][0]["barcode"]
                            :
                            0,
                        "Validate"=>
                            @$items["additional_fields"][0]["brand"] ?
                            $items["additional_fields"][0]["brand"]
                            :
                            0,
                        "bodega"=>
                            @$items["warehouses"][0]["name"] ?
                            $items["warehouses"][0]["name"]
                            :
                            0,   
                       "nombre"=>
                            @$items["prices"][0]["price_list"][0]["name"] ?
                            $items["prices"][0]["price_list"][0]["name"]
                            :
                            0,
                        "valor"=>
                            @$items["prices"][0]["price_list"][0]["value"] ?
                            $items["prices"][0]["price_list"][0]["value"]
                            :
                            0,
                        "idiva"=>0,
                        "porcentajeiva"=>0,
                        "fechacreacion"=>
                            @$items["metadata"][0]["created"] ?
                            $items["metadata"][0]["created"]
                            :
                            0,   
        );
    }else {
        $itemunico = array("code"=>$items["code"],
                       "id"=>$items["id"],
                        "name"=>$items["name"],
                        "sku"=>$items["reference"],
                        "idgrupo"=>
                            @$items["account_group"][0]["id"] ?
                            $items["account_group"][0]["id"]
                            :
                            0,
                        "nombregrupo"=>
                            @$items["account_group"][0]["name"] ?
                            $items["account_group"][0]["name"]
                            :
                            0,
                        "cantidad"=>$items["available_quantity"],
                        "impuestos"=>$items["taxes"][0]["percentage"],
                        "codigobarra"=>
                            @$items["additional_fields"][0]["barcode"] ?
                            $items["additional_fields"][0]["barcode"]
                            :
                            0,
                        "Validate"=>
                            @$items["additional_fields"][0]["brand"] ?
                            $items["additional_fields"][0]["brand"]
                            :
                            0,
                        "bodega"=>
                            @$items["warehouses"][0]["name"] ?
                            $items["warehouses"][0]["name"]
                            :
                            0,   
                       "nombre"=>
                            @$items["prices"][0]["price_list"][0]["name"] ?
                            $items["prices"][0]["price_list"][0]["name"]
                            :
                            0,
                        "valor"=>
                            @$items["prices"][0]["price_list"][0]["value"] ?
                            $items["prices"][0]["price_list"][0]["value"]
                            :
                            0,
                        "idiva"=>
                            @$items["taxes"][0]["id"] ?
                            $items["taxes"][0]["id"]
                            :
                            0,
                        "porcentajeiva"=>
                            @$items["taxes"][0]["percentage"] ?
                            $items["taxes"][0]["percentage"]
                            :
                            0,
                        "fechacreacion"=>
                            @$items["metadata"][0]["created"] ?
                            $items["metadata"][0]["created"]
                            :
                            0,   
    );
   }
   $listaitems[] = $itemunico;
};

$rec->headers->set('Accept', 'application/json');
echo json_encode($listaitems);
//exit;
//$rec->headers->set('Accept', 'application/json');
//echo $response;
}

public function actualizaProductoSiigo($rec)
{ 
$codigo =  $rec->codigosiigo;
$url = $this->url_siigo_api."products/8c7b31c6-a463-40c8-8025-2fbff3c2ad76/code?".$codigo;
$response = FunctionsCustoms::SiigoPut($url,$this->db);
echo $response;
exit;

$data = json_decode($response, true); 

$listaitems = array();
foreach($data["results"] as $items){
    $itemunico = array("code"=>$items["code"],
                       "id"=>$items["id"],
                        "name"=>$items["name"],
                        "namedos"=>$items["reference"],
                        "cantidad"=>$items["available_quantity"],
                        "impuestos"=>$items["taxes"][0]["percentage"],
                        "adicional"=>
                            @$items["additional_fields"][0]["barcode"] ?
                            $items["additional_fields"][0]["barcode"]
                            :
                            0,
                       "nombre"=>
                            @$items["prices"][0]["price_list"][0]["name"] ?
                            $items["prices"][0]["price_list"][0]["name"]
                            :
                            0,
                        "valor"=>
                            @$items["prices"][0]["price_list"][0]["value"] ?
                            $items["prices"][0]["price_list"][0]["value"]
                            :
                            0   
);
    //    var_dump($items["prices"][0]["price_list"][0]["value"]); 
    $listaitems[] = $itemunico;
};
$rec->headers->set('Accept', 'application/json');
echo json_encode($listaitems);
//exit;
//$rec->headers->set('Accept', 'application/json');
//echo $response;
}

//Validate Items del pedido sin codigo Siigo
public function sinCodigoSiigo($rec)
{
//echo json_encode($rec->id);
//exit;
$db_name = $this->db.".itemspedidos";

DB::beginTransaction();
try {

    DB::connection($this->cur_connect)->update("UPDATE ".$db_name." 
        SET sincodigosiigo = '".$rec->estado."'
        WHERE itempedido = '".$rec->itempedido."'");

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

//Validate Items del pedido sin codigo Siigo
public function actualizaCodigoPedido($rec)
{
//echo json_encode($rec->id);
//exit;
$db_name = $this->db.".itemspedidos";

DB::beginTransaction();
try {

    DB::connection($this->cur_connect)->update("UPDATE ".$db_name." 
        SET sincodigosiigo      = '".$rec->estado."'
           ,codigoproductosiigo = '".$rec->codigosiigo."'
        WHERE itempedido = '".$rec->itempedido."'");

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

//Actualiza pedido con la cedula obtenida de BE
public function actualizaCedulaPedidos($rec)
{
//echo json_encode($rec->id);
//exit;
$db_name = $this->db.".pedidos";

DB::beginTransaction();
try {

    DB::connection($this->cur_connect)->update("UPDATE ".$db_name." 
        SET estadocliente = 1, 
            idcliente = '".$rec->cedula."'
        WHERE id_fact = '".$rec->pedido."'");

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

//Actualiza pedido con la cedula obtenida de BE
public function actualizaDatosPedidos($rec)
{
//echo json_encode($rec->id);
//exit;
$db_name = $this->db.".pedidos";

DB::beginTransaction();
try {

    DB::connection($this->cur_connect)->update("UPDATE ".$db_name." 
        SET nombre = '".$rec->nombre."'
           ,apellido = '".$rec->apellido."'
           ,email = '".$rec->email."'
           ,ciudad = '".$rec->ciudad."'
           ,departamento = '".$rec->departamento."'
           ,codigopostal = '".$rec->codigopostal."'
           ,direccion = '".$rec->direccion."'
           ,status = '".$rec->status."'
           ,delivery_type = '".$rec->delivery_type."'
           ,phone = '".$rec->phone."'
        WHERE id_fact = '".$rec->pedido."'");

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

//Actualiza pedido con la cedula obtenida de BE
public function actualizaPedidosConsola($rec)
{
//echo json_encode($rec->id);
//exit;
$db_name = $this->db.".pedidos";

DB::beginTransaction();
try {
    DB::connection($this->cur_connect)->update("UPDATE ".$db_name." 
        SET idcliente = '".$rec->cedula."' 
            ,nombre = '".$rec->nombre."'
            ,apellido = '".$rec->apellido."'
            ,email = '".$rec->email."'
            ,ciudad = '".$rec->ciudad."'
            ,departamento = '".$rec->departamento."'
            ,direccion = '".$rec->direccion."'
        WHERE id_fact = '".$rec->pedido."'");

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

public function listaProductosFecha($rec)
{
//created_start=2021-02-17
$url = $this->url_siigo_api."products?created_start".$rec->fecha;
$response = FunctionsCustoms::SiigoGet($url,$this->db);
$data = json_decode($response, true); // El objeto llega con String por eso no podias entrarle como un arreglo, con esta funcion la conviertes en un objecto accesible, y le agregas el segundo paramtro true para que seaun array manejable
//var_dump($data); // luego de convertilo en un array porque te lo devolvia como un string puedes explorar sus llaves y sus array y objetos con esta funcion y asi puedes ver hasta donde quieres llegar en este caso a el result pero el result tiene 17 array y tiene sque decirle cual array quieres acceder
//var_dump($data["results"][0]["code"]); // aqui acceso a el objecto results y luego al el array 0 y luego dentro de ese array cero es que encuentro en code
//var_dump($data);
//echo $data["results"][1]["code"];
//echo $data["results"][11]["code"];
$listaitems = array();
foreach($data["results"] as $items){
    $itemunico = array("code:"=>$items["code"],
                       "id:"=>$items["id"],
                        "name:"=>$items["name"],
                        "namedos:"=>$items["reference"],
                        "adicional:"=>
                            @$items["additional_fields"][0]["barcode"] ?
                            $items["additional_fields"][0]["barcode"]
                            :
                            0,
                       "nombre:"=>
                            @$items["prices"][0]["price_list"][0]["name"] ?
                            $items["prices"][0]["price_list"][0]["name"]
                            :
                            0,
                        "valor:"=>
                            @$items["prices"][0]["price_list"][0]["value"] ?
                            $items["prices"][0]["price_list"][0]["value"]
                            :
                            0   
);
    //    var_dump($items["prices"][0]["price_list"][0]["value"]); 
    $listaitems[] = $itemunico;
};
$rec->headers->set('Accept', 'application/json');
echo json_encode($listaitems);
//exit;
//$rec->headers->set('Accept', 'application/json');
//echo $response;
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

public function cwrListarProveedores($rec)
{
$db_name = "cyclewear_sys";

$listProveedores = DB::connection($this->cur_connect)->select("select t0.id as value, t0.razonsocial as label, t0.* 
                    from ".$db_name.'.interlocutores'." t0
                    WHERE t0.estado = 1 ORDER BY tipotercero ASC");

//$listprov = array();

$datoc = [
            //'header_supplies' => $listProveedores
            $listProveedores
        ];
        //$listprov[] = $datoc;

echo json_encode($listProveedores);
}

public function cwrTiposInterlocutores($rec)
{
$db_name = "cyclewear_sys";

$tiposinterlocutores = DB::connection($this->cur_connect)->select("select t0.id as value, 
                                                        t0.nombretipotercero as label, t0.* 
                                                        from ".$db_name.'.tipotercero'." t0
                                                        WHERE t0.estado = 1 ORDER BY nombretipotercero ASC");

//$listprov = array();

$datoc = [
            //'header_supplies' => $listProveedores
            $tiposinterlocutores
        ];
        //$listprov[] = $datoc;

echo json_encode($tiposinterlocutores);
}

public function cwrListarSexo($rec)
{
$db_name = "cyclewear_sys";

$listSexo = DB::connection($this->cur_connect)->select("select t0.id as value, t0.nombresexo as label, t0.* 
                    from ".$db_name.'.sexo'." t0
                    WHERE t0.estado = 1 ORDER BY nombresexo ASC");

//$listprov = array();

$datoc = [
            //'header_supplies' => $listProveedores
            $listSexo
        ];
        //$listprov[] = $datoc;

echo json_encode($listSexo);
}

public function cwrTipoIdentificacion($rec)
{
$db_name = "cyclewear_sys";

$tiposidentificacion = DB::connection($this->cur_connect)->select("select t0.* 
                                                           from ".$db_name.'.tipoidentificacion'." t0 
                                                           WHERE t0.estado = 1 ORDER BY tipoidentificacion ASC");

$tiposidentifi = array();

$datoc = [
            'header_supplies' => $tiposidentificacion
        ];
        $tiposidentifi[] = $datoc;

echo json_encode($tiposidentifi);
}

public function crearProducto($rec)
{
$url = $this->url_siigo_api."products";
$taxes_p = array();
$priceslist_p = array();
$prices_p = array();

// Impuestos array
$taxesa = array('id' => 745);
$taxes_p[] = $taxesa;

// PriceList Array
$priceslist_p[] = array('position' => 1, 'value' => $rec->precio1);
//$priceslist_p[] = array('position' => 2, 'value' => $rec->precio2);

// Prices Array
$pricesa = array('currency_code' => 'COP', 'price_list' => $priceslist_p);
$prices_p[] = $pricesa;

$array_post = array(
    "code" => $rec->code,
    "name" => $rec->name,
    "account_group" => $rec->account_group,
    "type" => "Product",
    "stock_control" => true,
    "active" => true,
    "tax_classification" => "Taxed",
    "tax_included" => true,
    "tax_consumption_value" => 0,
    "taxes" => $taxes_p,
    "prices" => $prices_p,
    "unit" => "94",
    "unit_label" => "unidad",
    "reference" => $rec->reference,
    "description" => $rec->description,
    "additional_fields" => array(
      "barcode" => $rec->barcode,
      "brand" => $rec->Validate,
      "tariff" => $rec->tarifa,
      "model" => $rec->model
    )
  );
$response = FunctionsCustoms::SiigoPost($url,$this->db,$array_post);
$rec->headers->set('Accept', 'application/json');

$respuesta = json_decode($response);

if(isset($respuesta->id)){
$array_post = array(
"codigo" => $respuesta->code,
"id" => $respuesta->id,
"sku" => $respuesta->reference,
"nombre" => $respuesta->name,
"cantidad" => 0,
"idgrupo" => 0,
"nombregrp" => 0,
"codigobarra" => 0,
"Validate" => 0,
"bodega" => 0,
"nombrebodega" => 0,
"valor" => 0,
"idiva" =>$respuesta->taxes[0]->id,
"valoriva" =>$respuesta->taxes[0]->percentage,
"fechadecreacion" =>"2022-09-22", //$respuesta->metadata->created,
"estado" => 1,
"status" => 200,//$respuesta->status
//"val" => $respuesta
);
}else{
$array_post = array(
"type" => $respuesta->Errors[0]->Code,
"status" => $respuesta->Status
);
}


//var_dump($data);
echo json_encode($array_post);

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

//Actualiza items pedido información producto
public function actualizaDatosItemsPedido($rec)
{
//echo json_encode($rec->id);
//exit;
$db_name = $this->db.".itemspedidos";

DB::beginTransaction();
try {
    DB::connection($this->cur_connect)->update("UPDATE ".$db_name." 
        SET codigoproductosiigo = '".$rec->codigoproductosiigo."' 
            ,pedido = '".$rec->pedido."'
            ,variant_sku = '".$rec->variant_sku."'
            ,price = '".$rec->price."'
            ,categoriauno = '".$rec->categoriauno."'
            ,categoriados = '".$rec->categoriados."'
        WHERE id_fact = '".$rec->pedido."'");

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

public function listarInterlocutores($rec)
{
//$startdate =  $rec->fecha;
$pagina =  $rec->pagina;
//url = $this->url_siigo_api."customers?identification=".$rec->identification;
//"https://api.siigo.com/v1/customers?created_start=2021-01-01&page=2&page_size=25"

//$url = $this->url_siigo_api."customers?created_start=".$startdate."&page=1&page_size=100";
$url = $this->url_siigo_api."customers?page=".$pagina."&page_size=100";
$response = FunctionsCustoms::SiigoGet($url,$this->db);
$rec->headers->set('Accept', 'application/json');
echo $response;
}

// Lee un cliente en la BD Local
public function cwrleerUnCliente($rec)
{
$db_name = "cyclewear_sys";

$consecutivoproducto = DB::connection($this->cur_connect)->select(
                                       "select t0.id as value, t0.razonsocial as label, t0.*
                                        from ".$db_name.'.interlocutores'." t0
                                        WHERE identificacion = ".$rec->identificacion." 
                                           && tipotercero = '". $rec->tipotercero."'"); 

echo json_encode($consecutivoproducto);
}

public function crearCliente($rec)
{
$url = $this->url_siigo_api."customers";
$taxes_p = array();
$priceslist_p = array();
$prices_p = array();
 
$array_post = array(
    "type" => $rec->type,
    "person_type" => $rec->person_type,
    "id_type" => $rec->id_type,
    "identification" => $rec->identification,
    "check_digit" => $rec->check_digit,
    "name" => [$rec->nombre, $rec->apellido],
    "commercial_name" => $rec->commercial_name,
    "branch_office" => 0,
    "active" => $rec->active,
    "vat_responsible" => $rec->vat_responsible,
    "fiscal_responsibilities" =>  array([
        "code" => $rec->code               
    ]),
    "address" => array(
        "address" => $rec->address,
        "city" => array(
        "country_code" => $rec->country_code,
        "state_code" => $rec->state_code,
        "city_code" => $rec->city_code
        ),
    "postal_code" => $rec->postal_code),
    "phones" => array([
        "indicative" => $rec->indicative,
        "number" => $rec->number,
        "extension" => $rec->extension
    ]),
    "contacts" => array([
        "first_name" => $rec->first_name,
        "last_name" => $rec->last_name,
        "email" => $rec->email,
        "phone" => array(
        "indicative" => $rec->indicative,
        "number" => $rec->number,
        "extension" => $rec->extension
        )
    ]),
    "comments" => "Comentarios",
    "related_users" => array(
    "seller_id" => $rec->seller_id,
    "collector_id" => $rec->collector_id
    )
);

$response = FunctionsCustoms::SiigoPost($url,$this->db,$array_post);
$rec->headers->set('Accept', 'application/json');

echo $response;
exit;

}

public function crearFacturas($rec)
{
$url = $this->url_siigo_api."invoices";
$taxes_p = array();
$priceslist_p = array();
$prices_p = array();
//echo json_encode($rec);
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
    "items" => array([
          "code" => $rec->code,
          "description" => $rec->description,
          "quantity" =>$rec->quantity,
          "price" => $rec->price,
          "warehouse" => 5,     
          "discount" => $rec->discount,
          "taxes" => array 
            ([
              "id" => $rec->idtaxes,
            ])
      ]),
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

echo json_encode($response);
exit;

$resp_crear = json_decode($response);

if(isset($resp_crear->id)){
    $array_Resp = array("status" => 200, "id" => $resp_crear->id);
    $response = array(
        'type' => 1,
        'message' => 'REGISTRO EXITOSO',
        'id' => $resp_crear->id,
        'status' => 200,
    );
}else{
    $array_Resp = array("status" => $resp_crear->Status, "id" => 0);
    $response = array(
        'type' => 0,
        'message' => 'ERROR EN REGISTRO',
        'id' => 0,
        'status' => 0,

    );
}
//cho json_encode($array_Resp);
echo json_encode($response);
//exit;
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

//$data = json_decode($itemspedidos, true); // El objeto llega con String por eso no podias entrarle como un arreglo, con esta funcion la conviertes en un objecto accesible, y le agregas el segundo paramtro true para que seaun array manejable
//var_dump($data); // luego de convertilo en un array porque te lo devolvia como un string puedes explorar sus llaves y sus array y objetos con esta funcion y asi puedes ver hasta donde quieres llegar en este caso a el result pero el result tiene 17 array y tiene sque decirle cual array quieres acceder
//var_dump($data["results"][0]["code"]); // aqui acceso a el objecto results y luego al el array 0 y luego dentro de ese array cero es que encuentro en code
//var_dump($data);
//echo $data["results"][1]["code"];
//echo $data["results"][11]["code"];

//echo json_encode($itemspedidos);
//exit;

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
*/
