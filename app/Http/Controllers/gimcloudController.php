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

class gimcloudController extends Controller
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
        $this->db = 'gimbcservice_sys';

        // Datos para consultas de Api de Siigo
        $this->url_siigo_api = "https://api.siigo.com/v1/";
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function logistralGimGeneral(Request $request, $accion, $parametro=null)
    {
        switch ($accion) {
            case 1:
                $this->listarCiudades($request);
                break;
            case 2:
                $this->cwrTiposCliente($request);
                break;
            case 3:
                $this->cwrMainMenu($request);
                break;    
            case 4:
                $this->creardatoscostosacumulados($request);
                break;           
            case 5:
                $this->listCategoriasInspeccion($request);
                break;
            case 6:
                $this->listItemsInspeccionAlistamiento($request);
                break;
            case 7:
                $this->listSubGrupoEquipos($request);
                break;
            case 8:
                $this->listModelosEquipos($request);
                break;
            case 9:
                $this->listEquipos($request);
                break;
            case 10:
                $this->listTecnicos($request);
                break;
            case 11:
                $this->listEmpleados($request);
                break;
            case 12:
                $this->crearInspeccionEquipos($request);
                break;
            case 13:
                $this->leerInspeccionEquipos($request);
                break;
            case 14:
                $this->crearRegistroInspeccion($request);
                break;
            case 15:
                $this->leerRegistroInspeccion($request);
                break;
            case 16:
                $this->actualizarFirmaLider($request);
                break;
            case 17:
                $this->actualizarFirmaEncargado($request);
                break;
            case 18:
                $this->listarEquiposGenericos($request);
                break;
            case 19:
                $this->actualizarEmpInspeccion($request);
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

    // Lee la condición del producto
    public function cwrDatosEntorno($rec)
    {
        $db_name = "cyclewear_sys";
    
        $condicionproducto = DB::connection($this->cur_connect)->select("select t0.id as value, t0.nombrecondicion as label 
                                                                             from ".$db_name.'.condicionproducto'." 
                                                                             t0 WHERE t0.estado = 1 ORDER BY nombrecondicion ASC");
        
        $entorno = array(
            'vgl_condicionproducto' => $condicionproducto,
        );
    
        $condicionprod = array();
    
        $datoc = [
            'header_supplies' => $condicionproducto
        ];
        $condicionprod[] = $datoc;
    
        echo json_encode($entorno);
    }

    //Crear conscutivo en Base de Datos
    public function creardatoscostosacumulados($rec)
    {

        DB::beginTransaction();
        try {
                    $db_name = $this->db.".datoscostoscontratacionesconsumos";
                    $datoscostosamulados = new ModelGlobal();
                    $datoscostosamulados->setConnection($this->cur_connect);
                    $datoscostosamulados->setTable($db_name);

                    $datoscostosamulados->idequipo = $rec->idequipo;
                    $datoscostosamulados->codigomt = $rec->codigomt;
                    $datoscostosamulados->descripcionmt = $rec->descripcionmt;
                    $datoscostosamulados->anno = $rec->anno;
                    $datoscostosamulados->mes = $rec->mes;
                    $datoscostosamulados->periodo = $rec->periodo;
                    $datoscostosamulados->codigomtanno = $rec->codigomtanno;
                    $datoscostosamulados->codigoperiodo = $rec->codigoperiodo;
                    $datoscostosamulados->valorconsumo = $rec->valorconsumo;
                    $datoscostosamulados->valorcontratos = $rec->valorcontratos;
                    $datoscostosamulados->valorrentames = $rec->valorrentames;

                    $datoscostosamulados->save();

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
    public function cwrCondicionProducto($rec)
    {
        $db_name = "cyclewear_sys";

        $condicionproducto = DB::connection($this->cur_connect)->select("select t0.id as value, t0.nombrecondicion as label 
                                                                         from ".$db_name.'.condicionproducto'." 
                                                                         t0 WHERE t0.estado = 1 ORDER BY nombrecondicion ASC");

        $condicionprod = array();

        $datoc = [
                    'header_supplies' => $condicionproducto
                ];
                $condicionprod[] = $datoc;

        echo json_encode($condicionproducto);
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

    // Listar ciudades creadas en la base de datos
    public function listarCiudades($rec)
    {
        $db_name = "gimbcservice_sys";
        
        $listarciudades = DB::connection($this->cur_connect)->select(
                                                "select t0.* 
                                                from ".$db_name.'.ciudades'." t0 
                                                ORDER BY id_ciu DESC"); 
    
        echo json_encode($listarciudades);
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

    // Lee informacion Cambos
    public function listarInformacionCombos($rec)
    {
        $db_name = "cyclewear_sys";
            
        $listarinfocombos = DB::connection($this->cur_connect)->select(
                                                "select t0.* 
                                                from ".$db_name.'.combos'." t0 "); 
                                                       
        echo json_encode($listarinfocombos);
    }

    // Lee informacion Cambos
    public function listarProductosActualiza($rec)
    {
        $db_name = "cyclewear_sys";
            
        $listarproductos = DB::connection($this->cur_connect)->select(
                                                "select t0.* 
                                                from ".$db_name.'.actualizaproductos_3'." t0 "); 
                                                       
        echo json_encode($listarproductos);
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

    // Listar categorias inspeccion alistamiento
    public function listCategoriasInspeccion($rec)
    {
        //echo json_encode($rec->idinterno);
        //exit;
        DB::beginTransaction();
        try {
            $db_name = "gimbcservice_sys";
                
        $listcategoriasinspeccion = DB::connection($this->cur_connect)->select(
                                                "select t0.*
                                                from ".$db_name.'.categoriasinspeccionalistamiento'." t0
                                                ORDER BY t0.id ASC");

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
            'listcategoriasinspeccion' => $listcategoriasinspeccion,
            'message' => 'LIST CONTRACTS OK',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    // Listar Items Inspeccion Alistamiento
    public function listItemsInspeccionAlistamiento($rec)
    {
        //echo json_encode($rec->idinterno);
        //exit;
        DB::beginTransaction();
        try {
            $db_name = "gimbcservice_sys";
                
        $listitemsinspeccion = DB::connection($this->cur_connect)->select(
                                                "select t0.*
                                                from ".$db_name.'.itemsinspeccionalistamiento'." t0
                                                ORDER BY t0.id ASC");

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
            'listitemsinspeccion' => $listitemsinspeccion,
            'message' => 'LIST listitemsinspeccion OK',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    // Listar Items Inspeccion Alistamiento
    public function listSubGrupoEquipos($rec)
    {
        dd($rec);
        exit;
        
        DB::beginTransaction();
        try {
            $db_name = "gimbcservice_sys";
                
        $listsubgrupoequipos = DB::connection($this->cur_connect)->select(
                                                "select t0.*
                                                from ".$db_name.'.subgrupopartes'." t0
                                                WHERE t0.tipoconsecutivo_sgre = '".$rec->grupoequipos."'
                                                ORDER BY t0.id_sgre ASC");

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
            'listsubgrupoequipos' => $listsubgrupoequipos,
            'message' => 'LIST listitemsinspeccion OK',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    // Listar Modelos 
    public function listModelosEquipos($rec)
    {
        //echo json_encode($rec->idinterno);
        //exit;
        DB::beginTransaction();
        try {
            $db_name = "gimbcservice_sys";
                
        $listarmodelos = DB::connection($this->cur_connect)->select(
                                                "select t0.*
                                                from ".$db_name.'.modelos'." t0
                                                ORDER BY t0.id ASC");

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
            'listarmodelos' => $listarmodelos,
            'message' => 'LIST listitemsinspeccion OK',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    // Listar Items Inspeccion Alistamiento
    public function listEquipos($rec)
    {
        //echo json_encode($rec->idinterno);
        //exit;
        DB::beginTransaction();
        try {
            $db_name = "gimbcservice_sys";
                
        $listequipos = DB::connection($this->cur_connect)->select(
                                                "select t0.id_equ, t0.codigo_equ, t0.descripcion_equ,
                                                        t0.subgrupoparte_equ
                                                from ".$db_name.'.equipos'." t0
                                                ORDER BY t0.id_equ ASC");
                    //WHERE t0.tipoconsecutivo_sgre = '".$rec->grupoequipos."'
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
            'listequipos' => $listequipos,
            'message' => 'LIST Equipos OK',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    // Listar Items Inspeccion Alistamiento
    public function listTecnicos($rec)
    {
        //echo json_encode($rec->idinterno);
        //exit;
        DB::beginTransaction();
        try {
            $db_name = "gimbcservice_sys";
                
        $listartecnicos = DB::connection($this->cur_connect)->select(
                                                "select t0.id_emp, t0.email_emp, t0.primer_nombre_emp,
                                                        t0.primer_apellido_emp, 
                                                        CONCAT(t0.primer_nombre_emp,' ',t0.primer_apellido_emp) as
                                                        nombretecnico 
                                                from ".$db_name.'.interlocutores_emp'." t0
                                                WHERE t0.estado_emp = 31
                                                  AND especialidad_emp = 6
                                                ORDER BY t0.id_emp DESC");
                    //WHERE t0.tipoconsecutivo_sgre = '".$rec->grupoequipos."'
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
            'listartecnicos' => $listartecnicos,
            'message' => 'LIST Equipos OK',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    // Listar Items Inspeccion Alistamiento
    public function listEmpleados($rec)
    {
        //echo json_encode($rec->idinterno);
        //exit;
        DB::beginTransaction();
        try {
            $db_name = "gimbcservice_sys";
                
        $listarempleados = DB::connection($this->cur_connect)->select(
                                                "select t0.id_emp, t0.email_emp, t0.primer_nombre_emp,
                                                        t0.primer_apellido_emp, 
                                                        CONCAT(t0.primer_nombre_emp,' ',t0.primer_apellido_emp) as
                                                        nombretecnico 
                                                from ".$db_name.'.interlocutores_emp'." t0
                                                WHERE t0.estado_emp = 31
                                                  AND especialidad_emp != 6
                                                ORDER BY t0.id_emp DESC");
                    //WHERE t0.tipoconsecutivo_sgre = '".$rec->grupoequipos."'
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
            'listarempleados' => $listarempleados,
            'message' => 'LIST Equipos OK',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    //Crear Inspeccion Alistamiento Equipos
    public function crearInspeccionEquipos($rec)
    {
        DB::beginTransaction();
        try {
                    $db_name = $this->db.".inspeccionalistamientoequipos";
                    $crearinspeccionequipos = new ModelGlobal();
                    $crearinspeccionequipos->setConnection($this->cur_connect);
                    $crearinspeccionequipos->setTable($db_name);
                   
                    $crearinspeccionequipos->idequipo = $rec->idequipo;
                    $crearinspeccionequipos->tecnicoresponsable = $rec->tecnicoresponsable;
                    $crearinspeccionequipos->horainicio = $rec->horainicio;
                    $crearinspeccionequipos->horafinal = $rec->horafinal;
                    $crearinspeccionequipos->tiempomayor = $rec->tiempomayor;
                    $crearinspeccionequipos->tiempomenor = $rec->tiempomenor;
                    $crearinspeccionequipos->lidermantenimiento = $rec->lidermantenimiento;
                    $crearinspeccionequipos->encargadologistica = $rec->encargadologistica;
                    $crearinspeccionequipos->pedido = $rec->pedido;
                    $crearinspeccionequipos->consecutivo = $rec->consecutivo;
                    $crearinspeccionequipos->serialequipo = $rec->serialequipo;
                    $crearinspeccionequipos->serialbateria = $rec->serialbateria;
                    $crearinspeccionequipos->serialcargador = $rec->serialcargador;
                    $crearinspeccionequipos->fechacreacion = $date = date('Y-m-d H:i:s');

                    $crearinspeccionequipos->save();
                 
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

    public function leerInspeccionEquipos($rec)
    {
       //echo json_encode($rec->idinterno);
       //exit;
       DB::beginTransaction();
       try {
        $db_name = "gimbcservice_sys";
               
       $leerinspeccionequipos = DB::connection($this->cur_connect)->select(
                                                           "select t0.*, t0.id as iditeminspeccion, t1.descripcion_equ as equipo,
                                                            CONCAT(t2.primer_nombre_emp,' ',t2.primer_apellido_emp) as nombrelider,
                                                            CONCAT(t2.primer_nombre_emp,' ',t2.primer_apellido_emp) as nombreencargado,
                                                            t1.codigo_equ, t4.serie_dequ
                                                           from ".$db_name.'.inspeccionalistamientoequipos'." t0
                                                           JOIN ".$db_name.'.equipos'." t1 ON t0.idequipo = t1.id_equ
                                                           JOIN ".$db_name.'.interlocutores_emp'." t2 ON t0.lidermantenimiento = t2.id_emp
                                                           JOIN ".$db_name.'.vista_empleados1'." t3 ON t0.encargadologistica = t3.id_emp
                                                           JOIN ".$db_name.'.datosadicionalequipos'." t4 ON t4.id_dequ = t1.id_equ
                                                           ORDER BY t0.id DESC");

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
           'leerinspeccionequipos' => $leerinspeccionequipos,
           'message' => 'LIST Documentos Clientes OK',
       );
       $rec->headers->set('Accept', 'application/json');
       echo json_encode($response);
       exit;
    }

    //Crear Inspeccion Alistamiento Equipos
    public function crearRegistroInspeccion($rec)
    {
        DB::beginTransaction();
        try {
                    $db_name = $this->db.".itemsregistroinspeccion";
                    $crearregistroinspeccion = new ModelGlobal();
                    $crearregistroinspeccion->setConnection($this->cur_connect);
                    $crearregistroinspeccion->setTable($db_name);
                   
                    $crearregistroinspeccion->idinspeccion = $rec->idinspeccion;
                    $crearregistroinspeccion->categoria = $rec->categoria;
                    $crearregistroinspeccion->item = $rec->item;
                    $crearregistroinspeccion->cumple = $rec->cumple;
                    $crearregistroinspeccion->nocumple = $rec->nocumple;
                    $crearregistroinspeccion->noaplica = $rec->noaplica;
                    $crearregistroinspeccion->comentarios = $rec->comentarios;
                    $crearregistroinspeccion->descripcionitem = $rec->descripcionitem;


                    $crearregistroinspeccion->save();
                 
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

    public function leerRegistroInspeccion($rec)
    {
       //echo json_encode($rec->idinterno);
       //exit;
       DB::beginTransaction();
       try {
        $db_name = "gimbcservice_sys";
               
       $leerregistroinspeccion = DB::connection($this->cur_connect)->select(
                                                           "select t0.*
                                                           from ".$db_name.'.itemsregistroinspeccion'." t0
                                                           ORDER BY t0.id DESC");

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
           'leerregistroinspeccion' => $leerregistroinspeccion,
           'message' => 'LIST Documentos Clientes OK',
       );
       $rec->headers->set('Accept', 'application/json');
       echo json_encode($response);
       exit;
    }

    //Actualizar Resolver dudas que tenga el vendedor
    public function actualizarFirmaLider($rec)
    {
        $db_name = $this->db.".inspeccionalistamientoequipos";

        DB::beginTransaction();
        try {

            DB::connection($this->cur_connect)->update("UPDATE ".$db_name." 
                SET firmalider = '".$rec->nameimg."'
                WHERE id = '".$rec->id."'");

                $foto[1] = $rec->imagen1;
                    
                //Nombre imagenes se pasa a un arreglo
                $nombrefoto[1] = $rec->nombreimagen1;

                for ($i = 1; $i <= $rec->numerodeimagenes; $i++) {
                    $this->GuardarIMG($foto[$i] ,$nombrefoto[$i],'imggimcloud/');
                }
                
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

    //Actualizar Resolver dudas que tenga el vendedor
    public function actualizarFirmaEncargado($rec)
    {
        $db_name = $this->db.".inspeccionalistamientoequipos";

        DB::beginTransaction();
        try {

            DB::connection($this->cur_connect)->update("UPDATE ".$db_name." 
                SET firmaencargado = '".$rec->nameimg."'
                WHERE id = '".$rec->id."'");

                $foto[1] = $rec->imagen1;
                    
                //Nombre imagenes se pasa a un arreglo
                $nombrefoto[1] = $rec->nombreimagen1;

                for ($i = 1; $i <= $rec->numerodeimagenes; $i++) {
                    $this->GuardarIMG($foto[$i] ,$nombrefoto[$i],'imggimcloud/');
                }
                
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

    //Actualizar Resolver dudas que tenga el vendedor
    public function actualizarEmpInspeccion($rec)
    {
        $db_name = $this->db.".inspeccionalistamientoequipos";

        DB::beginTransaction();
        try {

            DB::connection($this->cur_connect)->update("UPDATE ".$db_name." 
                SET lidermantenimiento = '".$rec->lidermantenimiento."',
                    encargadologistica = '".$rec->encargadologistica."'
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

    public function listarEquiposGenericos($rec)
    {
       //echo json_encode($rec->idinterno);
       //exit;
       DB::beginTransaction();
       try {
        $db_name = "gimbcservice_sys";
               
       $listequipos = DB::connection($this->cur_connect)->select(
                                                           "select t0.id_equ, t0.codigo_equ, t0.descripcion_equ,
                                                                  t1.serie_dequ, t1.modelo_dequ, t1.modelo_dequ 
                                                           from ".$db_name.'.equipos'." t0
                                                           JOIN ".$db_name.'.datosadicionalequipos'." t1 ON t1.id_dequ = t0.id_equ
                                                           WHERE t0.tipo_equ = 22");

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
           'listequipos' => $listequipos,
           'message' => 'LIST Documentos Clientes OK',
       );
       $rec->headers->set('Accept', 'application/json');
       echo json_encode($response);
       exit;
    }

    public function GuardarIMG($imagenB64,$nameImg,$dirImg)
    {
         return $upd_img = FunctionsCustoms::UploadImageMrp($imagenB64,$nameImg,$dirImg);
    }

}
