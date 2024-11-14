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

class gimcloudwilcarController extends Controller
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

        $this->cur_connect = 'wilcargimcloud';
        $this->db = 'gimwilcar_sys';

        // Datos para consultas de Api de Siigo
        $this->url_siigo_api = "https://api.siigo.com/v1/";
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function wilcarGimGeneral(Request $request, $accion, $parametro=null)
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
                $this->crearMovimientosAlmacen($request);
                break;
            case 5:
                $this->leerMovimientosAlmacen($request);
                break;
            case 6:
                $this->listarTiposOperacion($request);
                break;
            case 7:
                $this->listarTiposDesembolso($request);
                break;
            case 8:
                $this->actualizaConsumosAlmacen($request);
                break;
            case 9:
                $this->listIdEquipo($request);
                break;   
            case 10:
                $this->crearImagenEquipos($request);
                break;  
            case 11:
                $this->leerUsuarios($request);
                break;
            case 12:
                $this->crearImagenOT($request);
                break; 
            case 13:
                $this->crearDocumentosClientes($request);
                break;
            case 14:
                $this->leerDocumentosClientes($request);
                break;   
            case 15:
                $this->crearDocumentosClientesPDF($request);
                break;
            case 16:
                $this->crearImagenFirma($request);
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

    //Crear movimientos almacen
    public function crearMovimientosAlmacen($rec)
    {

        DB::beginTransaction();
        try {
                    $db_name = $this->db.".movimientosalmacen";
                    $movimientos = new ModelGlobal();
                    $movimientos->setConnection($this->cur_connect);
                    $movimientos->setTable($db_name);

                    $movimientos->id_mov= $rec->id_mov;
                    $movimientos->tipooperacion_mov= $rec->tipooperacion_mov;
                    $movimientos->almacen_mov= $rec->almacen_mov;
                    $movimientos->tipodesembolso_mov= $rec->tipodesembolso_mov;
                    $movimientos->ordendecompra_mov= $rec->ordendecompra_mov;
                    $movimientos->proveedor_mov= $rec->proveedor_mov;
                    $movimientos->descripcion_mov= $rec->descripcion_mov;
                    $movimientos->referencia_mov= $rec->referencia_mov;
                    $movimientos->maquina_mov= $rec->maquina_mov;
                    $movimientos->ciudad_mov= $rec->ciudad_mov;
                    $movimientos->aprobo_mov= $rec->aprobo_mov;
                    $movimientos->cantidad_mov= $rec->cantidad_mov;
                    $movimientos->costounitario_mov= $rec->costounitario_mov;
                    $movimientos->valormovimiento_mov= $rec->valormovimiento_mov;
                    $movimientos->fecha_mov= $rec->fecha_mov;
                    $movimientos->estado_mov= $rec->estado_mov;

                    $movimientos->save();

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

    // Lee movimientos almacen
    public function leerMovimientosAlmacen($rec)
    {
         $db_name = "gimwilcar_sys";
     
         $consecutivoproducto = DB::connection($this->cur_connect)->select(               
            "SELECT t0.id_mov,t0.tipooperacion_mov,t1.descripcion_tope, t0.almacen_mov, t2.descripcion_alm,
            t0.tipodesembolso_mov, t3.descripcion_dese, t0.ordendecompra_mov, t0.consumo_mov, t0.disponible_mov,
            t0.proveedor_mov,t0.descripcion_mov,t0.referencia_mov,t0.maquina_mov, t4.codigo_equ,
            t4.descripcion_equ, t0.ciudad_mov, t5.nombre_ciu,  t0.aprobo_mov,
            t0.cantidad_mov,t0.costounitario_mov,t0.valormovimiento_mov,t0.fecha_mov,t0.estado_mov,
            t6.razonsocial_int
            FROM    movimientosalmacen t0, tipooperacion t1, almacenes t2, tipodesembolso t3, equipos t4,
                    ciudades t5, interlocutores t6
            WHERE t0.tipooperacion_mov = t1.id_tope
            AND t0.almacen_mov = t2.id_alm
            AND t0.tipodesembolso_mov = t3.id_dese
            AND t0.maquina_mov = t4.codigointerno
            AND t0.ciudad_mov = t5.id_ciu
            AND t0.proveedor_mov = t6.id_int"); 
 
    echo json_encode($consecutivoproducto);
    }

    public function listIdEquipo($rec)
    {
        DB::beginTransaction();
        try {
            $db_name = "gimwilcar_sys";
                
        $listidequipos = DB::connection($this->cur_connect)->select(
                                                "SELECT equipos.id_equ, 
                                                            SUBSTRING(equipos.codigo_equ,1,3) AS codigoequipo
                                                FROM equipos
                                                ORDER BY codigoequipo asc"); 

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
            'listidequipos' => $listidequipos,
            'message' => 'REGISTRO EXITOSO',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    //Actualiaza consumos almacen
    public function actualizaConsumosAlmacen($rec)
    {
        $db_name = $this->db.".movimientosalmacen";
 
        DB::beginTransaction();
        try {
 
                $date = date('Y-m-d H:i:s');
                DB::connection($this->cur_connect)->update("UPDATE ".$db_name." 
                SET disponible_mov = '".$rec->disponible_mov."',
                    consumo_mov = '".$rec->consumo_mov."'
                WHERE id_mov = '".$rec->id_mov."'");
 
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
 
    // Lee tipo de operaciones en asociado con las compras
    public function listarTiposOperacion($rec)
    {
        $db_name = "gimwilcar_sys";
    
        $tipodeoperacion = DB::connection($this->cur_connect)->select(
            "select t0.id_tope as value, t0.descripcion_tope as label, t0.*
             from ".$db_name.'.tipooperacion'." 
             t0 WHERE estado_tope = 31"); 
       
        echo json_encode($tipodeoperacion);
    }

    // Lee tipo de desembolso, identifica el origen de los fondos para el pago de la compra
    public function listarTiposDesembolso($rec)
    {
        $db_name = "gimwilcar_sys";
    
        $tipodesembolso = DB::connection($this->cur_connect)->select(
            "select t0.id_dese as value, t0.descripcion_dese as label, t0.*
             from ".$db_name.'.tipodesembolso'." 
             t0 WHERE estado_dese = 31"); 

        echo json_encode($tipodesembolso);
    }
    
    // Lee la condición del producto
    public function cwrCondicionProducto($rec)
    {
        $db_name = "gimwilcar_sys";

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
    public function leerMovimientosAlmacenXXXX($rec)
    {
        $db_name = "gimwilcar_sys";
    
        $consecutivoproducto = DB::connection($this->cur_connect)->select(
                                              "select t0.id as value, t0.descripcion as label,
                                               t0.* from ".$db_name.'.consecutivos'." 
                                               t0 WHERE estado = 1 && prefijo = '". $rec->prefijo."'"); 

    echo json_encode($consecutivoproducto);
    }

    // Listar ciudades creadas en la base de datos
    public function listarCiudades($rec)
    {
        $db_name = "gimwilcar_sys";
        
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

    //Crear vehiculos asociados a productos
    public function crearImagen($rec)
    {
         DB::beginTransaction();
         try {
                     $db_name = $this->db.".controlfacturas";
                     $registrarfacturavta = new ModelGlobal();
                     $registrarfacturavta->setConnection($this->cur_connect);
                     $registrarfacturavta->setTable($db_name);
                    
                     //$registrarfacturavta->idproducto = $rec->idproducto;
                     $registrarfacturavta->fechacarga = $date = date('Y-m-d H:i:s');
                     $registrarfacturavta->nombreimagen1 = $rec->nombreimagen1;
                 
                     $registrarfacturavta->save();
                  
                     //Imagen base 64 se pasa a un arreglo
                     $nombrefoto[1] = $rec->nombreimagen1;
                     $foto[1] = $rec->imagen;
 
                     for ($i = 1; $i <= $rec->numerodeimagenes; $i++) {
                         $this->GuardarIMG($foto[$i] ,$nombrefoto[$i],'imggimwilcar/');
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
             'message' => 'REGISTRO EXITOSO',
         );
         $rec->headers->set('Accept', 'application/json');
         echo json_encode($response);
         exit;
    }

    public function leerUsuarios($rec)
    {
        DB::beginTransaction();
        try {
            $db_name = "gimwilcar_sys";
                
        $listusuarios = DB::connection($this->cur_connect)->select(
                                                "SELECT t0.*, t1.nombre_est, t2.nombre_ciu, t3.descripcion_und
                                                FROM usuarios as t0 
                                                INNER JOIN estados as t1 
                                                INNER JOIN ciudades as t2  
                                                INNER JOIN unidades as t3
                                                WHERE t0.estado_usu = t1.id_est and t0.ciudad_usu = t2.id_ciu 
                                                  and t0.tipo_usu IN (10,11,12,13,17) and t0.tipo_usu = t3.id_und 
                                                  and uidfirebase_usu = '". $rec->idusuario."'");
                                                  
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
            'listusuarios' => $listusuarios,
            'message' => 'REGISTRO EXITOSO',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

     //$crearfotosequipos->fechacarga = $date = date('Y-m-d H:i:s');
     //Crear imagenes equiposgim
     public function crearImagenEquipos($rec)
     {
         DB::beginTransaction();
         try {
                     $db_name = $this->db.".fotosequipos";
                     $crearfotosequipos = new ModelGlobal();
                     $crearfotosequipos->setConnection($this->cur_connect);
                     $crearfotosequipos->setTable($db_name);
                    
                     $crearfotosequipos->type = $rec->type;
                     $crearfotosequipos->name = $rec->name;
                     $crearfotosequipos->nombrefoto = $rec->nombrefoto;
                     $crearfotosequipos->fechafoto = $rec->fechafoto;
                     $crearfotosequipos->url = $rec->url;
                     $crearfotosequipos->codigoequipo = $rec->codigoequipo;
                 
                     $crearfotosequipos->save();
                  
                     //Imagen base 64 se pasa a un arreglo
                     $nombrefoto[1] = $rec->name;
                     $foto[1] = $rec->imagen;
 
                     for ($i = 1; $i <= $rec->numerodeimagenes; $i++) {
                         $this->GuardarIMG($foto[$i] ,$nombrefoto[$i],'imggimwilcar/');
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
             'message' => 'REGISTRO EXITOSO',
         );
         $rec->headers->set('Accept', 'application/json');
         echo json_encode($response);
         exit;
     }

     //Crear imagenes equiposgim
     public function crearImagenOT($rec)
     {
         DB::beginTransaction();
         try {
                     $db_name = $this->db.".imagenesordenes";
                     $crearfotosequipos = new ModelGlobal();
                     $crearfotosequipos->setConnection($this->cur_connect);
                     $crearfotosequipos->setTable($db_name);
                    
                     $crearfotosequipos->type = $rec->type;
                     $crearfotosequipos->name = $rec->name;
                     $crearfotosequipos->url = $rec->url;
                     $crearfotosequipos->data = $rec->data;
                     $crearfotosequipos->orden = $rec->orden;
                    
                     $crearfotosequipos->save();
                  
                     //Imagen base 64 se pasa a un arreglo
                     $nombrefoto[1] = $rec->name;
                     $foto[1] = $rec->imagen;
 
                     for ($i = 1; $i <= $rec->numerodeimagenes; $i++) {
                         $this->GuardarIMG($foto[$i] ,$nombrefoto[$i],'imggimwilcar/');
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
             'message' => 'REGISTRO EXITOSO',
         );
         $rec->headers->set('Accept', 'application/json');
         echo json_encode($response);
         exit;
     }

     //Crear imagenes equiposgim
     public function crearDocumentosClientes($rec)
     {
         DB::beginTransaction();
         try {
                     $db_name = $this->db.".documentosclientes";
                     $crearDocumentosClientes = new ModelGlobal();
                     $crearDocumentosClientes->setConnection($this->cur_connect);
                     $crearDocumentosClientes->setTable($db_name);
                    
                     $crearDocumentosClientes->type = $rec->type;
                     $crearDocumentosClientes->name = $rec->name;
                     $crearDocumentosClientes->nombredocumento = $rec->nombredocumento;
                     $crearDocumentosClientes->fechadocumento = $rec->fechadocumento;
                     $crearDocumentosClientes->url = $rec->url;
                     $crearDocumentosClientes->codigocliente = $rec->codigocliente;
                 
                     $crearDocumentosClientes->save();
                  
                     //Imagen base 64 se pasa a un arreglo
                     $nombrefoto[1] = $rec->name;
                     $foto[1] = $rec->imagen;
 
                     for ($i = 1; $i <= $rec->numerodeimagenes; $i++) {
                         $this->GuardarIMG($foto[$i] ,$nombrefoto[$i],'imggimwilcar/');
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
             'message' => 'REGISTRO EXITOSO',
         );
         $rec->headers->set('Accept', 'application/json');
         echo json_encode($response);
         exit;
     }

     //Crear imagenes equiposgim
     public function crearDocumentosClientesPDF($rec)
     {
         DB::beginTransaction();
         try {
                     $db_name = $this->db.".documentosclientes";
                     $crearDocumentosClientes = new ModelGlobal();
                     $crearDocumentosClientes->setConnection($this->cur_connect);
                     $crearDocumentosClientes->setTable($db_name);
                    
                     $crearDocumentosClientes->type = $rec->type;
                     $crearDocumentosClientes->name = $rec->name;
                     $crearDocumentosClientes->nombredocumento = $rec->nombredocumento;
                     $crearDocumentosClientes->fechadocumento = $rec->fechadocumento;
                     $crearDocumentosClientes->url = $rec->url;
                     $crearDocumentosClientes->codigocliente = $rec->codigocliente;
                 
                     $crearDocumentosClientes->save();
                  
                     //Imagen base 64 se pasa a un arreglo
                     $nombrefoto[1] = $rec->name;
                     $foto[1] = $rec->imagen;
 /*
                     for ($i = 1; $i <= $rec->numerodeimagenes; $i++) {
                         $this->GuardarIMG($foto[$i] ,$nombrefoto[$i],'imggimwilcar/');
                     }
*/
                    for ($i = 1; $i <= $rec->numerodeimagenes; $i++) {
                        $response = FunctionsCustoms::UploadPDFName($foto[$i],$nombrefoto[1],'imggimwilcar/');
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
             'message' => 'REGISTRO EXITOSO',
         );
         $rec->headers->set('Accept', 'application/json');
         echo json_encode($response);
         exit;
     }

     public function leerDocumentosClientes($rec)
    {
        //echo json_encode($rec->idinterno);
        //exit;
        DB::beginTransaction();
        try {
            $db_name = "gimwilcar_sys";
                
        $listardocumentosclientes = DB::connection($this->cur_connect)->select(
                                                            "select t0.*
                                                            from ".$db_name.'.documentosclientes'." t0
                                                            WHERE t0.codigocliente = '".$rec->codigocliente."'
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
            'listardocumentosclientes' => $listardocumentosclientes,
            'message' => 'LIST Documentos Clientes OK',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    //Crear vehiculos asociados a productos
    public function crearImagenFirma($rec)
    {
         DB::beginTransaction();
         try {
                     $db_name = $this->db.".firmarot";
                     $registrarfirma = new ModelGlobal();
                     $registrarfirma->setConnection($this->cur_connect);
                     $registrarfirma->setTable($db_name);
                    
                     //$registrarfirma->idproducto = $rec->idproducto;
                     $registrarfirma->id_fir = $rec->id_fir;
                     $registrarfirma->imagen_fir = $rec->imagen_fir;
                     $registrarfirma->firmatecnico_fir = $rec->firmatecnico_fir;
                     $registrarfirma->nombre_fir = $rec->nombre_fir;
                     $registrarfirma->observacion_fir = $rec->observacion_fir;
                     $registrarfirma->url = $rec->url;
                     $registrarfirma->fechafirma_fir = $date = date('Y-m-d H:i:s');
                     
                     $registrarfirma->save();
                  
                     //Imagen base 64 se pasa a un arreglo
                     $nombrefoto[1] = $rec->nombre_fir;
                     $foto[1] = $rec->imagen;
 
                     for ($i = 1; $i <= $rec->numerodeimagenes; $i++) {
                         $this->GuardarIMG($foto[$i] ,$nombrefoto[$i],'imggimwilcar/');
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
             'message' => 'REGISTRO EXITOSO',
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
