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

use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
use League\OAuth2\Client\Provider\GenericProvider;
use Illuminate\Support\Facades\Http;
use GuzzleHttp\Client;

use PDF;

use Illuminate\Support\Facades\DB;

class salespointController extends Controller
{
        /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    private $Partner;
    private $urlSigo;
    private $siigo_username;
    private $siigo_access_key;
    private $Authorization;
    protected $clientId;
    protected $clientSecret;
    protected $redirectUri;
    protected $urlAuthorize;
    protected $urlAccessToken;
    protected $urlResourceOwnerDetails;
    protected $CompanyId;

    public function __construct()
    {
        $this->middleware('api');

        header('Access-Control-Allow-Origin: *');
        header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
        header("Access-Control-Allow-Headers: Authorization, Content-Type");

        $this->cur_connect = 'mysql';
        $this->db = 'salespoint_sys';
        //$this->dbgim = 'zafirogimbc_sys';
       
        // Datos para consultas de Api de Siigo
        $this->url_siigo_api = "https://api.siigo.com/v1/";
        $this->urlSigo = 'https://api.siigo.com/auth?oauth_consumer_key=lzcH2sPb4FQo1A9wWQKihb14&oauth_signature_method=HMAC-SHA1&oauth_timestamp=1706290114&oauth_nonce=TFKy4oTOP2u&oauth_version=1.0&oauth_signature=KRUX3Tz4VU22oeDVT%2FLOEGlvVZ0%3D';
        $this->Partner = 'sandbox';
        $this->siigo_username = 'sandbox@siigoapi.com';
        $this->siigo_access_key = 'NDllMzI0NmEtNjExZC00NGM3LWE3OTQtMWUyNTNlZWU0ZTM0OkosU2MwLD4xQ08=';

        // Datos para consultas de Api de intuit
        $this->CompanyId = '9341452921544848';
        $this->clientId = 'ABvDXTXyX9I9BmkQoXyVHprxmYB3DZs6cttp1WqGxmo8rdLnph';
        $this->clientSecret = 'Ac4KgGfDbfZ38vYSIYaVq9LuRjRZErB8spG5NRkv';
        $this->urlAccessToken = 'https://oauth.platform.intuit.com/oauth2/v1/tokens/bearer';
        $this->redirectUri = 'https://gimcloud.com.co/intuit/callback';
        $this->urlAuthorize = 'https://appcenter.intuit.com/connect/oauth2';
        $this->urlResourceOwnerDetails = 'https://sandbox-quickbooks.api.intuit.com/v3/company/';
        $this->Authorization = '$2y$10$hc8dShHM0E71/08Tcjq3nOdq.hCmOcn5mEH5a/UZ9Lk0eBptD8CeG';
        
    }

    public function salespointGeneral(Request $request, $accion, $parametro=null)
    {
        //echo($request);
        //dd($request);
        
        //$token = $request->header('Authorization');
        if ('$2y$10$hc8dShHM0E71/08Tcjq3nOdq.hCmOcn5mEH5a/UZ9Lk0eBptD8CeG' != $this->Authorization) {
            return response()->json(['error' => 'Token incorrecto'], 401);
        }
        
        switch ($accion) {
            case 1:
                $this->Categorias($request);
                break;
            case 2:
                $this->TipoVehiculos($request);
                break;
            case 3:
                $this->MainMenu($request);
                break;
            case 4:
                $this->createUser($request);
                break;
            case 5:
                $this->login($request);
                break;
            case 6:
                $this->crearPais($request);
                break;
            case 7:
                $this->listarPaises($request);
                break;
            case 8:
                $this->actualizarPaises($request);
                break;
            case 9:
                $this->borrarPaises($request);
                break;
            case 10:
                $this->environmentData($request);
                break;
            case 20:
                $this->crearBodegas($request);
                break;
            case 21:
                $this->listarBodegas($request);
                break;
            case 22:
                $this->actualizarBodegas($request);
                break;
            case 23:
                $this->borrarBodegas($request);
                break;
            case 24:
                $this->crearCategorias($request);
                break;
            case 25:
                $this->listarCategorias($request);
                break;
            case 26:
                $this->actualizarCategorias($request);
                break;
            case 27:
                $this->borrarCategorias($request);
                break;
            case 28:
                $this->crearInsumos($request);
                break;
            case 29:
                $this->listarInsumos($request);
                break;
            case 30:
                $this->actualizarInsumos($request);
                break;
            case 31:
                $this->borrarInsumos($request);
                break;
            case 32:
                $this->crearMenu($request);
                break;
            case 33:
                $this->listarMenu($request);
                break;
            case 34:
                $this->actualizarMenu($request);
                break;
            case 35:
                $this->borrarMenu($request);
                break;
            case 36:
                $this->crearMesa($request);
                break;
            case 37:
                $this->listarMesa($request);
                break;
            case 38:
                $this->actualizarMesa($request);
                break;
            case 39:
                $this->borrarMesa($request);
                break;
            case 40:
                $this->crearMovInventarios($request);
                break;
            case 41:
                $this->listarMovInventarios($request);
                break;
            case 42:
                $this->actualizarMovInventarios($request);
                break;
            case 43:
                $this->borrarMovInventarios($request);
                break;
            case 44:
                $this->crearOrdenCompra($request);
                break;
            case 45:
                $this->listarOrdenCompra($request);
                break;
            case 46:
                $this->actualizarOrdenCompra($request);
                break;
            case 47:
                $this->borrarOrdenCompra($request);
                break;
            case 48:
                $this->crearProductos($request);
                break;
            case 49:
                $this->listarProductos($request);
                break;
            case 50:
                $this->actualizarProductos($request);
                break;
            case 51:
                $this->borrarProductos($request);
                break;
            case 52:
                $this->crearProveedor($request);
                break;
            case 53:
                $this->listarProveedores($request);
                break;
            case 54:
                $this->actualizarProveedores($request);
                break;
            case 55:
                $this->borrarProveedores($request);
                break;
            case 52:
                $this->crearSaldos($request);
                break;
            case 53:
                $this->listarSaldos($request);
                break;
            case 54:
                $this->actualizarSaldos($request);
                break;
            case 55:
                $this->borrarSaldos($request);
                break;
            case 56:
                $this->crearSubcategorias($request);
                break;
            case 57:
                $this->listarSubcategorias($request);
                break;
            case 58:
                $this->actualizarSubcategorias($request);
                break;
            case 59:
                $this->borrarSubcategorias($request);
                break;
            case 60:
                $this->crearZonas($request);
                break;
            case 61:
                $this->listarZonas($request);
                break;
            case 62:
                $this->actualizarZonas($request);
                break;
            case 63:
                $this->borrarZona($request);
                break;
            case 64:
                $this->crearItemMenu($request);
                break;
            case 65:
                $this->listarItemMenu($request);
                break;
            case 66:
                $this->actualizarItemMenu($request);
                break;
            case 67:
                $this->borrarItemMenu($request);
                break;
            case 68:
                $this->listarUnItemMenu($request);
                break;
            case 69:
                $this->actualizarCostoMenu($request);
                break;
            case 70:
                $this->crearPedido($request);
                break;
            case 71:
                $this->listarPedido($request);
                break;
            case 72:
                $this->actualizarPedido($request);
                break;
            case 73:
                $this->borrarPedido($request);
                break;
            case 74:
                $this->crearItemPedido($request);
                break;
            case 75:
                $this->listarItemsPedido($request);
                break;
            case 76:
                $this->listarUnPedido($request);
                break;
            case 77:
                $this->actualizarItemPedido($request);
                break;
            case 78:
                $this->borrarItemPedido($request);
                break;
            case 79:
                $this->actualizaEstadoPedido($request);
                break;
            case 80:
                $this->actualizarEstadoMesa($request);
                break;
            case 81:
                $this->actualizarValoresPedido($request);
                break;
            case 82:
                $this->actualizaZonaPedido($request);
                break;
            case 83:
                $this->crearVinculados($request);
                break;
            case 84:
                $this->listarVinculados($request);
                break;
            case 85:
                $this->actualizarVinculados($request);
                break;
            case 86:
                $this->borrarVinculados($request);
                break;
            case 87:
                $this->listarItemsVinculados($request);
                break;
            case 88:
                $this->listarOnePedido($request);
                break;
            case 89:
                $this->crearTipoZonaServicio($request);
                break;
            case 90:
                $this->listarTipoZonaServicio($request);
                break;
            case 91:
                $this->actualizarTipoZonaServicio($request);
                break;
            case 92:
                $this->borrarTipoZonaServicio($request);
                break;
            case 93:
                $this->crearZonaServicio($request);
                break;
            case 94:
                $this->listarZonaServicio($request);
                break;
            case 95:
                $this->actualizarZonaServicio($request);
                break;
            case 96:
                $this->borrarZonaServicio($request);
                break;
            case 97:
                $this->crearComanda($request);
                break;
            case 98:
                $this->listarComanda($request);
                break;
            case 99:
                $this->actualizarComanda($request);
                break;
            case 100:
                $this->borrarComanda($request);
                break;
            case 101:
                $this->actualizarEstadoZonaServicio($request);
                break;
            case 102:
                $this->actualizarEstadoComanda($request);
                break;
            case 103:
                $this->crearFactura($request);
                break;
            case 104:
                $this->listarFactura($request);
                break;
            case 105:
                $this->listarOneFactura($request);
                break;
            case 106:
                $this->actualizarFactura($request);
                break;
            case 107:
                $this->actualizarValoresFactura($request);
                break;
            case 108:
                $this->actualizaEstadoFactura($request);
                break;
            case 109:
                $this->borrarFactura($request);
                break;
            case 110:
                $this->crearItemFactura($request);
                break;
            case 111:
                $this->listarItemsFactura($request);
                break;
            case 112:
                $this->listarUnaFactura($request);
                break;
            case 113:
                $this->actualizarItemFactura($request);
                break;
            case 114:
                $this->borrarItemFactura($request);
                break;
            case 115:
                $this->actualizaItemPed($request);
                break;
            case 1001:
                return $this->createClientes($request);
                break;
            case 1002:
                return $this->updateClientes($request);
                break;
            case 1003:
                return $this->showClientes($request);
                break;
            case 1004:
                return $this->destroyClientes($request);
                break;
            case 1005:
                return $this->createProducto($request);
                break;
            case 1006:
                return $this->updateProducto($request);
                break;
            case 1007:
                return $this->showProducto($request);
                break;
            case 1008:
                return $this->destroyProducto($request);
                break;
            case 1009:
                return $this->createFacturas($request);
                break;
            case 1010:
                return $this->updateFacturas($request);
                break;
            case 1011:
                return $this->createNotaCredi($request);
                break;
            case 1012:
                return $this->pdfNotaCredi($request);
                break;
            case 1013:
                return $this->pdfFacturas($request);
                break;
            case 1014:
                return $this->sendFacturas($request);
                break;
            case 1015:
                return $this->showFacturas($request);
                break;
            case 1016:
                return $this->showNotaCredi($request);
                break;
            case 5003:
                $this->listarMvtoWompi($request);
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

    //Datos generales
    public function environmentData($rec)
     {

        DB::beginTransaction();
        try {
            $db_name = "salespoint_sys";
                
        $listaciudades = DB::connection($this->cur_connect)->select(
                                                "select t0.* 
                                                from ".$db_name.'.ciudades'." t0");       
                                                
        $listaestados = DB::connection($this->cur_connect)->select(
                                                "select t0.* 
                                                from ".$db_name.'.estados'." t0");                           

        $listaunidades = DB::connection($this->cur_connect)->select(
                                                "select t0.* 
                                                from ".$db_name.'.unidades'." t0");

        $listatiposdeplato = DB::connection($this->cur_connect)->select(
                                                "select t0.* 
                                                from ".$db_name.'.tiposdeplatos'." t0");

        $listasiono = DB::connection($this->cur_connect)->select(
                                                "select t0.* 
                                                from ".$db_name.'.siono'." t0");

        
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
        
        $entorno = array(
            'listaciudades' => $listaciudades,
            'listaestados' => $listaestados,
            'listaunidades' => $listaunidades,
            'listatiposdeplato' => $listatiposdeplato,
            'listasiono' => $listasiono
        );

        $response = array(
            'type' => 1,
            'environmentdata' => $entorno,
            'message' => 'REGISTRO EXITOSO',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }     
    
    //Create comments application
    public function crearPais($rec)
    {

        DB::beginTransaction();
        try {
                    $db_name = $this->db.".paises";
                    $createpaises = new ModelGlobal();
                    $createpaises->setConnection($this->cur_connect);
                    $createpaises->setTable($db_name);

                    $createpaises->abreviatura = $rec->abreviatura;
                    $createpaises->nombre = $rec->nombre;
                    $createpaises->codigo = $rec->codigo;
                    $createpaises->moneda = $rec->moneda;
                    $createpaises->fechacreacion = $date = date('Y-m-d H:i:s');
                    
                    $createpaises->save();

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
            'message' => 'Crear pais',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    // Listar paises
    public function listarPaises($rec)
    {
        //echo json_encode($rec->idinterno);
        //exit;
        DB::beginTransaction();
        try {
            $db_name = "salespoint_sys";
                
        $listarpaises = DB::connection($this->cur_connect)->select(
                                                            "select t0.*
                                                            from ".$db_name.'.paises'." t0
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
            'listarpaises' => $listarpaises,
            'message' => 'Listar paises',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    //Actualizar  comments application
    public function actualizarPaises($rec)
    {
        //echo json_encode($rec->id);
        //exit;
        $db_name = $this->db.".paises";

        DB::beginTransaction();
        try {

            DB::connection($this->cur_connect)->update("UPDATE ".$db_name." 
                SET nombre = '".$rec-> nombre."',
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
            'message' => 'UPDATED PAISES OK'
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    //Delete  comments application
    public function borrarPaises($rec)
    {
        $db_name = $this->db.".paises";

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

    //Administrar Bodega
    public function crearBodegas($rec)
    {

        DB::beginTransaction();
        try {
                    $db_name = $this->db.".bodegas";
                    $crearbodegas = new ModelGlobal();
                    $crearbodegas->setConnection($this->cur_connect);
                    $crearbodegas->setTable($db_name);

                    $crearbodegas->descripcion = $rec->descripcion;
                    $crearbodegas->comentarios = $rec->comentarios;
                    $crearbodegas->fechacreacion = $date = date('Y-m-d H:i:s');
                    
                    $crearbodegas->save();

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
            'message' => 'Crear Bodega',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    // Listar paises
    public function listarBodegas($rec)
    {
        //echo json_encode($rec->idinterno);
        //exit;
        DB::beginTransaction();
        try {
            $db_name = "salespoint_sys";
                
        $listarbodegas = DB::connection($this->cur_connect)->select(
                                                            "select t0.*
                                                            from ".$db_name.'.bodegas'." t0
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
            'listarbodegas' => $listarbodegas,
            'message' => 'Listar bodegas',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    //Actualizar  comments application
    public function actualizarBodegas($rec)
    {
        //echo json_encode($rec->id);
        //exit;
        $db_name = $this->db.".bodegas";

        DB::beginTransaction();
        try {

            DB::connection($this->cur_connect)->update("UPDATE ".$db_name." 
                SET descripcion = '".$rec-> descripcion."',
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
            'message' => 'UPDATED BODEGAS OK'
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    //Delete  comments application
    public function borrarBodegas($rec)
    {
        $db_name = $this->db.".bodegas";

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

    //Administrar Bodega
    public function crearCategorias($rec)
    {

        DB::beginTransaction();
        try {
                    $db_name = $this->db.".categorias";
                    $crearcategorias = new ModelGlobal();
                    $crearcategorias->setConnection($this->cur_connect);
                    $crearcategorias->setTable($db_name);

                    $crearcategorias->descripcion = $rec->descripcion;
                    $crearcategorias->comentarios = $rec->comentarios;
                    $crearcategorias->fechacreacion = $date = date('Y-m-d H:i:s');
                    
                    $crearcategorias->save();

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
            'message' => 'Crear Categorias',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    // Listar paises
    public function listarCategorias($rec)
    {
        //echo json_encode($rec->idinterno);
        //exit;
        DB::beginTransaction();
        try {
            $db_name = "salespoint_sys";
                
        $listarcategorias = DB::connection($this->cur_connect)->select(
                                                            "select t0.*
                                                            from ".$db_name.'.categorias'." t0
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
            'listarcategorias' => $listarcategorias,
            'message' => 'Listar bodegas',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    //Actualizar  comments application
    public function actualizarCategorias($rec)
    {
        //echo json_encode($rec->id);
        //exit;
        $db_name = $this->db.".categorias";

        DB::beginTransaction();
        try {

            DB::connection($this->cur_connect)->update("UPDATE ".$db_name." 
                SET descripcion = '".$rec-> descripcion."',
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
            'message' => 'UPDATED BODEGAS OK'
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    //Delete  comments application
    public function borrarCategorias($rec)
    {
        $db_name = $this->db.".categorias";

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

    //Administrar Insumos
    public function crearInsumos($rec)
    {

        DB::beginTransaction();
        try {
                    $db_name = $this->db.".insumos";
                    $crearinsumos = new ModelGlobal();
                    $crearinsumos->setConnection($this->cur_connect);
                    $crearinsumos->setTable($db_name);

                    $crearinsumos->bodega = $rec->bodega;
                    $crearinsumos->subcategoria = $rec->subcategoria;
                    $crearinsumos->descripcion = $rec->descripcion;
                    $crearinsumos->unidad = $rec->unidad;
                    $crearinsumos->costo = $rec->costo;
                    $crearinsumos->precioventa = $rec->precioventa;
                    $crearinsumos->comentarios = $rec->comentarios;
                    $crearinsumos->estado = $rec->estado;
                    $crearinsumos->fechavencimiento = $date = date('Y-m-d H:i:s');
                    $crearinsumos->fechacreacion = $date = date('Y-m-d H:i:s');
                    
                    $crearinsumos->save();

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
            'message' => 'Crear Bodega',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    // Listar paises
    public function listarInsumos($rec)
    {
        //echo json_encode($rec->idinterno);
        //exit;
        DB::beginTransaction();
        try {
            $db_name = "salespoint_sys";
                
        $listarinsumos = DB::connection($this->cur_connect)->select(
                                                            "select t0.*, t1.descripcion as nombresubcategoria
                                                            from ".$db_name.'.insumos'." t0
                                                            JOIN ".$db_name.'.subcategorias'." t1 ON t0.subcategoria = t1.id
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
            'listarinsumos' => $listarinsumos,
            'message' => 'Listar bodegas',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    //Actualizar  comments application
    public function actualizarInsumos($rec)
    {
        //echo json_encode($rec->id);
        //exit;
        $db_name = $this->db.".insumos";

        DB::beginTransaction();
        try {

            DB::connection($this->cur_connect)->update("UPDATE ".$db_name." 
                SET descripcion = '".$rec-> descripcion."',
                    unidad = '".$rec-> unidad."',
                    costo = '".$rec-> costo."',
                    precioventa = '".$rec-> precioventa."',
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
            'message' => 'UPDATED BODEGAS OK'
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    //Delete  comments application
    public function borrarInsumos($rec)
    {
        $db_name = $this->db.".insumos";

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

    //Administrar Menus
    public function crearMenu($rec)
    {

        DB::beginTransaction();
        try {
                    $db_name = $this->db.".menus";
                    $crearmenu = new ModelGlobal();
                    $crearmenu->setConnection($this->cur_connect);
                    $crearmenu->setTable($db_name);

                    $crearmenu->idproducto = $rec->idproducto;
                    $crearmenu->descripcion = $rec->descripcion;
                    $crearmenu->costo = $rec->costo;
                    $crearmenu->precioventa = $rec->precioventa;
                    $crearmenu->imagen = $rec->imagen;
                    $crearmenu->idtipodeplato = $rec->idtipodeplato;
                    $crearmenu->estado = $rec->estado;
                    $crearmenu->comentarios = $rec->comentarios;
                    $crearmenu->fechaactualizacion = $date = date('Y-m-d H:i:s');
                    $crearmenu->fechacreacion = $date = date('Y-m-d H:i:s');
                    
                    $crearmenu->save();

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
            'message' => 'Crear Bodega',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    // Listar paises
    public function listarMenu($rec)
    {
        //echo json_encode($rec->idinterno);
        //exit;
        DB::beginTransaction();
        try {
            $db_name = "salespoint_sys";
                
        $listarmenu = DB::connection($this->cur_connect)->select(
                                                            "select t0.*, t1.descripcion as nombreproducto,
                                                             t2.descripcion as tipodeplato
                                                            from ".$db_name.'.menus'." t0
                                                            JOIN ".$db_name.'.productos'." t1 ON t0.idproducto = t1.id
                                                            JOIN ".$db_name.'.tiposdeplatos'." t2 ON t0.idtipodeplato = t2.id
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
            'listarmenu' => $listarmenu,
            'message' => 'Listar menu',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    //Actualizar  comments application
    public function actualizarMenu($rec)
    {
        //echo json_encode($rec->id);
        //exit;
        $db_name = $this->db.".menus";

        DB::beginTransaction();
        try {

            DB::connection($this->cur_connect)->update("UPDATE ".$db_name." 
                SET idproducto = '".$rec-> idproducto."',
                    descripcion = '".$rec-> descripcion."',
                    costo = '".$rec-> costo."',
                    precioventa = '".$rec-> precioventa."',
                    estado = '".$rec-> estado."',
                    comentarios = '".$rec-> comentarios."',
                    fechaactualizacion = '".$date = date('Y-m-d H:i:s')."'
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
            'message' => 'UPDATED BODEGAS OK'
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    //Actualizar  comments application
    public function actualizarCostoMenu($rec)
    {
        //echo json_encode($rec->id);
        //exit;
        $db_name = $this->db.".menus";

        DB::beginTransaction();
        try {

            DB::connection($this->cur_connect)->update("UPDATE ".$db_name." 
                SET costo = '".$rec-> costo."',
                    precioventa = '".$rec-> precioventa."'
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
            'message' => 'UPDATED BODEGAS OK'
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    //Delete  comments application
    public function borrarMenu($rec)
    {
        $db_name = $this->db.".menus";

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

    //Administrar Menus
    public function crearItemMenu($rec)
    {

        DB::beginTransaction();
        try {
                    $db_name = $this->db.".itemsmenu";
                    $crearmenu = new ModelGlobal();
                    $crearmenu->setConnection($this->cur_connect);
                    $crearmenu->setTable($db_name);

                    $crearmenu->idmenu = $rec->idmenu;
                    $crearmenu->idinsumo = $rec->idinsumo;
                    $crearmenu->descripcion = $rec->descripcion;
                    $crearmenu->costounitario = $rec->costounitario;
                    $crearmenu->totalcosto = $rec->totalcosto;
                    $crearmenu->cantidad = $rec->cantidad;
                    $crearmenu->precioventa = $rec->precioventa;
                    $crearmenu->estado = $rec->estado;
                    $crearmenu->comentarios = $rec->comentarios;
                    $crearmenu->fechaactualizacion = $date = date('Y-m-d H:i:s');
                    $crearmenu->fechacreacion = $date = date('Y-m-d H:i:s');
                    
                    $crearmenu->save();

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
            'message' => 'Crear Item Menu',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    // Listar paises
    public function listarItemMenu($rec)
    {
        //echo json_encode($rec->idinterno);
        //exit;
        DB::beginTransaction();
        try {
            $db_name = "salespoint_sys";
                
        $listaritemmenu = DB::connection($this->cur_connect)->select(
                                                            "select t0.*
                                                            from ".$db_name.'.itemsmenu'." t0
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
            'listaritemmenu' => $listaritemmenu,
            'message' => 'Listar menu',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    // Listar paises
    public function listarUnItemMenu($rec)
    {
        //echo json_encode($rec->idinterno);
        //exit;
        DB::beginTransaction();
        try {
            $db_name = "salespoint_sys";
                
        $listaritemmenu = DB::connection($this->cur_connect)->select(
                                                            "select t0.*
                                                            from ".$db_name.'.itemsmenu'." t0
                                                            WHERE t0.idmenu = '". $rec->idmenu."'
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
            'listaritemmenu' => $listaritemmenu,
            'message' => 'Listar menu',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    //Actualizar  comments application
    public function actualizarItemMenu($rec)
    {
        //echo json_encode($rec->id);
        //exit;
        $db_name = $this->db.".itemsmenu";

        DB::beginTransaction();
        try {

            DB::connection($this->cur_connect)->update("UPDATE ".$db_name." 
                SET idinsumo = '".$rec-> idinsumo."',
                    descripcion = '".$rec-> descripcion."',
                    totalcosto = '".$rec-> totalcosto."',
                    costounitario = '".$rec-> costounitario."',
                    cantidad = '".$rec-> cantidad."',
                    precioventa = '".$rec-> precioventa."',
                    estado = '".$rec-> estado."',
                    comentarios = '".$rec-> comentarios."',
                    fechaactualizacion = '".$date = date('Y-m-d H:i:s')."'
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
            'message' => 'UPDATED BODEGAS OK'
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    //Delete  comments application
    public function borrarItemMenu($rec)
    {
        $db_name = $this->db.".itemsmenu";

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

    //Administrar Mesas
    public function crearMesa($rec)
    {

        DB::beginTransaction();
        try {
                    $db_name = $this->db.".mesas";
                    $crearmesa = new ModelGlobal();
                    $crearmesa->setConnection($this->cur_connect);
                    $crearmesa->setTable($db_name);

                    $crearmesa->zona = $rec->zona;
                    $crearmesa->pedido = $rec->pedido;
                    $crearmesa->descripcion = $rec->descripcion;
                    $crearmesa->estado = $rec->estado;
                    $crearmesa->comentarios = $rec->comentarios;
                    $crearmesa->fechacreacion = $date = date('Y-m-d H:i:s');
                    
                    $crearmesa->save();

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
            'message' => 'Crear Mesa',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    // Listar paises
    public function listarMesa($rec)
    {
        //echo json_encode($rec->idinterno);
        //exit;
        DB::beginTransaction();
        try {
            $db_name = "salespoint_sys";
                
        $listarmesas = DB::connection($this->cur_connect)->select(
                                                            "select t0.*
                                                            from ".$db_name.'.mesas'." t0
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
            'listarmesas' => $listarmesas,
            'message' => 'Listar mesas',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    //Actualizar  comments application
    public function actualizarMesa($rec)
    {
        //echo json_encode($rec->id);
        //exit;
        $db_name = $this->db.".mesas";

        DB::beginTransaction();
        try {

            DB::connection($this->cur_connect)->update("UPDATE ".$db_name." 
                SET zona = '".$rec-> zona."',
                    pedido = '".$rec-> pedido."',
                    descripcion = '".$rec-> descripcion."',
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
            'message' => 'UPDATED MESA OK'
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    public function actualizarEstadoMesa($rec)
    {
        //echo json_encode($rec->id);
        //exit;
        $db_name = $this->db.".mesas";

        DB::beginTransaction();
        try {

            DB::connection($this->cur_connect)->update("UPDATE ".$db_name." 
                SET pedido = '".$rec-> pedido."',
                    estado = '".$rec-> estado."'
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
            'message' => 'UPDATED MESA OK'
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    //Delete  comments application
    public function borrarMesa($rec)
    {
        $db_name = $this->db.".mesas";

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

    //Administrar Movimientos
    public function crearMovInventarios($rec)
    {
        
        DB::beginTransaction();
        try {
                    $db_name = $this->db.".movinventarios";
                    $crearmovimiento = new ModelGlobal();
                    $crearmovimiento->setConnection($this->cur_connect);
                    $crearmovimiento->setTable($db_name);

                    $crearmovimiento->bodega = $rec->bodega;
                    $crearmovimiento->transaccion = $rec->transaccion;
                    $crearmovimiento->insumo = $rec->insumo;
                    $crearmovimiento->descripcion = $rec->descripcion;
                    $crearmovimiento->cantidad = $rec->cantidad;
                    $crearmovimiento->unitario = $rec->unitario;
                    $crearmovimiento->valor = $rec->valor;
                    $crearmovimiento->estado = $rec->estado;
                    $crearmovimiento->fechacreacion = $date = date('Y-m-d H:i:s');
                    
                    $crearmovimiento->save();

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
            'message' => 'Crear Mesa',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    // Listar paises
    public function listarMovInventarios($rec)
    {
        //echo json_encode($rec->idinterno);
        //exit;
        DB::beginTransaction();
        try {
            $db_name = "salespoint_sys";
                
        $listarmovimientos = DB::connection($this->cur_connect)->select(
                                                            "select t0.*
                                                            from ".$db_name.'.movinventarios'." t0
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
            'listarmovimientos' => $listarmovimientos,
            'message' => 'Listar mesas',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    //Actualizar  comments application
    public function actualizarMovInventarios($rec)
    {
        //echo json_encode($rec->id);
        //exit;
        $db_name = $this->db.".movinventarios";

        DB::beginTransaction();
        try {

            DB::connection($this->cur_connect)->update("UPDATE ".$db_name." 
                SET bodega = '".$rec-> bodega."',
                    transaccion = '".$rec-> transaccion."',
                    insumo = '".$rec-> insumo."',
                    descripcion = '".$rec-> descripcion."',
                    cantidad = '".$rec-> cantidad."',
                    unitario = '".$rec-> unitario."',
                    valor = '".$rec-> valor."',
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
            'message' => 'UPDATED MESA OK'
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    //Delete  comments application
    public function borrarMovInventarios($rec)
    {
        $db_name = $this->db.".movinventarios";

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

    //Administrar Movimientos
    public function crearOrdenCompra($rec)
    {
        
        DB::beginTransaction();
        try {
                    $db_name = $this->db.".ordendecompra";
                    $crearordcompra = new ModelGlobal();
                    $crearordcompra->setConnection($this->cur_connect);
                    $crearordcompra->setTable($db_name);

                    $crearordcompra->idordencompra = $rec->idordencompra;
                    $crearordcompra->insumo = $rec->insumo;
                    $crearordcompra->proveedor = $rec->proveedor;
                    $crearordcompra->descripcion = $rec->descripcion;
                    $crearordcompra->unidad = $rec->unidad;
                    $crearordcompra->costo = $rec->costo;
                    $crearordcompra->preciodecompra = $rec->preciodecompra;
                    $crearordcompra->estado = $rec->estado;
                    $crearordcompra->comentarios = $rec->comentarios;
                    $crearordcompra->fechacreacion = $date = date('Y-m-d H:i:s');
                    
                    $crearordcompra->save();

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
            'message' => 'Crear Orden de Compra',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    // Listar paises
    public function listarOrdenCompra($rec)
    {
        //echo json_encode($rec->idinterno);
        //exit;
        DB::beginTransaction();
        try {
            $db_name = "salespoint_sys";
                
        $listarordcompra = DB::connection($this->cur_connect)->select(
                                                            "select t0.*
                                                            from ".$db_name.'.ordendecompra'." t0
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
            'listarordcompra' => $listarordcompra,
            'message' => 'Listar Orden de compra',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    //Actualizar  comments application
    public function actualizarOrdenCompra($rec)
    {
        //echo json_encode($rec->id);
        //exit;
        $db_name = $this->db.".ordendecompra";

        DB::beginTransaction();
        try {

            DB::connection($this->cur_connect)->update("UPDATE ".$db_name." 
                SET idordencompra = '".$rec-> idordencompra."',
                    insumo = '".$rec-> insumo."',
                    proveedor = '".$rec-> proveedor."',
                    descripcion = '".$rec-> descripcion."',
                    unidad = '".$rec-> unidad."',
                    costo = '".$rec-> costo."',
                    preciodecompra = '".$rec-> preciodecompra."',
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
            'message' => 'UPDATED OREN COMPRA OK'
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    //Delete  comments application
    public function borrarOrdenCompra($rec)
    {
        $db_name = $this->db.".ordendecompra";

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

    //Administrar Productos
    public function crearProductos($rec)
    {
        
        DB::beginTransaction();
        try {
                    $db_name = $this->db.".productos";
                    $crearproductos = new ModelGlobal();
                    $crearproductos->setConnection($this->cur_connect);
                    $crearproductos->setTable($db_name);

                    $crearproductos->subcategoria = $rec->subcategoria;
                    $crearproductos->zona = $rec->zona;
                    $crearproductos->manejaingredientes = $rec->manejaingredientes;
                    $crearproductos->descripcion = $rec->descripcion;
                    $crearproductos->costo = $rec->costo;
                    $crearproductos->preciodeventa = $rec->preciodeventa;
                    $crearproductos->estado = $rec->estado;
                    $crearproductos->comentarios = $rec->comentarios;
                    $crearproductos->fechacreacion = $date = date('Y-m-d H:i:s');
                    
                    $crearproductos->save();

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
            'message' => 'Crear Orden de Compra',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    // Listar paises
    public function listarProductos($rec)
    {
        //echo json_encode($rec->idinterno);
        //exit;
        DB::beginTransaction();
        try {
            $db_name = "salespoint_sys";
                
        $listarproductos = DB::connection($this->cur_connect)->select(
                                                            "select t0.*, t1.descripcion as nombresubcategoria
                                                            from ".$db_name.'.productos'." t0
                                                            JOIN ".$db_name.'.subcategorias'." t1 ON t0.subcategoria = t1.id
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
            'listarproductos' => $listarproductos,
            'message' => 'Listar Productos',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    //Actualizar  comments application
    public function actualizarProductos($rec)
    {
        //echo json_encode($rec->id);
        //exit;
        $db_name = $this->db.".productos";

        DB::beginTransaction();
        try {

            DB::connection($this->cur_connect)->update("UPDATE ".$db_name." 
                SET subcategoria = '".$rec-> subcategoria."',
                    zona = '".$rec-> zona."',
                    manejaingredientes = '".$rec-> manejaingredientes."',
                    descripcion = '".$rec-> descripcion."',
                    costo = '".$rec-> costo."',
                    preciodeventa = '".$rec-> preciodeventa."',
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
            'message' => 'UPDATED PRODUCTO OK'
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    //Delete  comments application
    public function borrarProductos($rec)
    {
        $db_name = $this->db.".productos";

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

    //Administrar Proveedor
    public function crearProveedor($rec)
    {
        
        DB::beginTransaction();
        try {
                    $db_name = $this->db.".proveedor";
                    $crearproveedor = new ModelGlobal();
                    $crearproveedor->setConnection($this->cur_connect);
                    $crearproveedor->setTable($db_name);

                    $crearproveedor->nombre = $rec->nombre;
                    $crearproveedor->especialidad = $rec->especialidad;
                    $crearproveedor->nit = $rec->nit;
                    $crearproveedor->digitochequeo = $rec->digitochequeo;
                    $crearproveedor->direccion = $rec->direccion;
                    $crearproveedor->ciudad = $rec->ciudad;
                    $crearproveedor->estado = $rec->estado;
                    $crearproveedor->comentarios = $rec->comentarios;
                    $crearproveedor->fechacreacion = $date = date('Y-m-d H:i:s');
                    $crearproveedor->fechaactualizacion = $date = date('Y-m-d H:i:s');
                    
                    $crearproveedor->save();

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
            'message' => 'Crear Orden de Compra',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    // Listar paises
    public function listarProveedores($rec)
    {
        //echo json_encode($rec->idinterno);
        //exit;
        DB::beginTransaction();
        try {
            $db_name = "salespoint_sys";
                
        $listarproveedores = DB::connection($this->cur_connect)->select(
                                                            "select t0.*
                                                            from ".$db_name.'.proveedor'." t0
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
            'listarproveedores' => $listarproveedores,
            'message' => 'Listar Productos',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    //Actualizar  comments application
    public function actualizarProveedores($rec)
    {
        //echo json_encode($rec->id);
        //exit;
        $db_name = $this->db.".proveedor";

        DB::beginTransaction();
        try {

            DB::connection($this->cur_connect)->update("UPDATE ".$db_name." 
                SET nombre = '".$rec-> nombre."',
                    especialidad = '".$rec-> especialidad."',
                    nit = '".$rec-> nit."',
                    digitochequeo = '".$rec-> digitochequeo."',
                    direccion = '".$rec-> direccion."',
                    ciudad = '".$rec-> ciudad."',
                    estado = '".$rec-> estado."',
                    comentarios = '".$rec-> comentarios."',
                    fechaactualizacion = '".$date = date('Y-m-d H:i:s')."'
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
            'message' => 'UPDATED PRODUCTO OK'
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    //Delete  comments application
    public function borrarProveedores($rec)
    {
        $db_name = $this->db.".proveedor";

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

    //Administrar Saldos
    public function crearSaldos($rec)
    {
        
        DB::beginTransaction();
        try {
                    $db_name = $this->db.".saldos";
                    $crearsaldos = new ModelGlobal();
                    $crearsaldos->setConnection($this->cur_connect);
                    $crearsaldos->setTable($db_name);

                    $crearsaldos->bodega = $rec->bodega;
                    $crearsaldos->insumo = $rec->insumo;
                    $crearsaldos->descripcion = $rec->descripcion;
                    $crearsaldos->costo = $rec->costo;
                    $crearsaldos->saldoinicial = $rec->saldoinicial;
                    $crearsaldos->entradas = $rec->entradas;
                    $crearsaldos->salidas = $rec->salidas;
                    $crearsaldos->saldofinal = $rec->saldofinal;
                    $crearsaldos->comentarios = $rec->comentarios;
                    $crearsaldos->fechacreacion = $date = date('Y-m-d H:i:s');
                    $crearsaldos->fechamodificacion = $date = date('Y-m-d H:i:s');
                    
                    $crearsaldos->save();

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
            'message' => 'Crear Orden de Compra',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    // Listar paises
    public function listarSaldos($rec)
    {
        //echo json_encode($rec->idinterno);
        //exit;
        DB::beginTransaction();
        try {
            $db_name = "salespoint_sys";
                
        $listarsaldos = DB::connection($this->cur_connect)->select(
                                                            "select t0.*
                                                            from ".$db_name.'.saldos'." t0
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
            'listarsaldos' => $listarsaldos,
            'message' => 'Listar Saldos',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    //Actualizar  comments application
    public function actualizarSaldos($rec)
    {
        //echo json_encode($rec->id);
        //exit;
        $db_name = $this->db.".saldos";

        DB::beginTransaction();
        try {

            DB::connection($this->cur_connect)->update("UPDATE ".$db_name." 
                SET bodega = '".$rec-> bodega."',
                    insumo = '".$rec-> insumo."',
                    descripcion = '".$rec-> descripcion."',
                    costo = '".$rec-> costo."',
                    saldoinicial = '".$rec-> saldoinicial."',
                    entradas = '".$rec-> entradas."',
                    salidas = '".$rec-> salidas."',
                    saldofinal = '".$rec-> saldofinal."',
                    comentarios = '".$rec-> comentarios."',
                    fechaactualizacion = '".$date = date('Y-m-d H:i:s')."'
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
            'message' => 'UPDATED SALDOS OK'
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    //Delete  Saldos
    public function borrarSaldos($rec)
    {
        $db_name = $this->db.".saldos";

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

     //Administrar Saldos
     public function crearSubcategorias($rec)
     {
         
         DB::beginTransaction();
         try {
                     $db_name = $this->db.".subcategorias";
                     $crearsubcategorias = new ModelGlobal();
                     $crearsubcategorias->setConnection($this->cur_connect);
                     $crearsubcategorias->setTable($db_name);
 
                     $crearsubcategorias->categoria = $rec->categoria;
                     $crearsubcategorias->descripcion = $rec->descripcion;
                     $crearsubcategorias->comentarios = $rec->comentarios;
                     $crearsubcategorias->fechacreacion = $date = date('Y-m-d H:i:s');
                     
                     $crearsubcategorias->save();
 
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
             'message' => 'Crear Subcategorias',
         );
         $rec->headers->set('Accept', 'application/json');
         echo json_encode($response);
         exit;
     }
 
     // Listar paises
     public function listarSubcategorias($rec)
     {
         //echo json_encode($rec->idinterno);
         //exit;
         DB::beginTransaction();
         try {
             $db_name = "salespoint_sys";
                 
         $listarsubcategorias = DB::connection($this->cur_connect)->select(
                                                             "select t0.*, t1.descripcion as nombrecategoria
                                                             from ".$db_name.'.subcategorias'." t0
                                                             JOIN ".$db_name.'.categorias'." t1 ON t0.categoria = t1.id
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
             'listarsubcategorias' => $listarsubcategorias,
             'message' => 'Listar Subcategorias',
         );
         $rec->headers->set('Accept', 'application/json');
         echo json_encode($response);
         exit;
     }
 
     //Actualizar  comments application
     public function actualizarSubcategorias($rec)
     {
         //echo json_encode($rec->id);
         //exit;
         $db_name = $this->db.".subcategorias";
 
         DB::beginTransaction();
         try {
 
             DB::connection($this->cur_connect)->update("UPDATE ".$db_name." 
                 SET categoria = '".$rec-> categoria."',
                     descripcion = '".$rec-> descripcion."',
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
             'message' => 'UPDATED SUBCATEGORIAS OK'
         );
         $rec->headers->set('Accept', 'application/json');
         echo json_encode($response);
         exit;
     }
 
     //Delete  Saldos
     public function borrarSubcategorias($rec)
     {
         $db_name = $this->db.".subcategorias";
 
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

     //Administrar Zonas
     public function crearZonas($rec)
     {
         
         DB::beginTransaction();
         try {
                     $db_name = $this->db.".zonas";
                     $crearzonas = new ModelGlobal();
                     $crearzonas->setConnection($this->cur_connect);
                     $crearzonas->setTable($db_name);
 
                     $crearzonas->descripcion = $rec->descripcion;
                     $crearzonas->comentarios = $rec->comentarios;
                     $crearzonas->fechacreacion = $date = date('Y-m-d H:i:s');
                     
                     $crearzonas->save();
 
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
             'message' => 'Crear Zonas',
         );
         $rec->headers->set('Accept', 'application/json');
         echo json_encode($response);
         exit;
     }
 
     // Listar paises
     public function listarZonas($rec)
     {
         //echo json_encode($rec->idinterno);
         //exit;
         DB::beginTransaction();
         try {
             $db_name = "salespoint_sys";
                 
         $listarzonas = DB::connection($this->cur_connect)->select(
                                                             "select t0.*
                                                             from ".$db_name.'.zonas'." t0
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
             'listarzonas' => $listarzonas,
             'message' => 'Listar Zonas',
         );
         $rec->headers->set('Accept', 'application/json');
         echo json_encode($response);
         exit;
     }
 
     //Actualizar  comments application
     public function actualizarZonas($rec)
     {
         //echo json_encode($rec->id);
         //exit;
         $db_name = $this->db.".zonas";
 
         DB::beginTransaction();
         try {
 
             DB::connection($this->cur_connect)->update("UPDATE ".$db_name." 
                 SET descripcion = '".$rec-> descripcion."',
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
             'message' => 'UPDATED ZONA OK'
         );
         $rec->headers->set('Accept', 'application/json');
         echo json_encode($response);
         exit;
     }
 
    //Delete  Saldos
    public function borrarZona($rec)
    {
         $db_name = $this->db.".zonas";
 
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

    //Crear pedido
    public function crearPedido($rec)
    {

        DB::beginTransaction();
        try {
                    $db_name = $this->db.".pedidos";
                    $crearpedido = new ModelGlobal();
                    $crearpedido->setConnection($this->cur_connect);
                    $crearpedido->setTable($db_name);

                    $crearpedido->idzona = $rec->idzona;
                    $crearpedido->idvinculado = $rec->idvinculado;

                    $crearpedido->mediodepago = $rec->mediodepago;
                    $crearpedido->descuento = $rec->descuento;

                    $crearpedido->cantidad = $rec->cantidad;
                    $crearpedido->costo = $rec->costo;
                    $crearpedido->total = $rec->total;
                    $crearpedido->iva = $rec->iva;
                    $crearpedido->retencion = $rec->retencion;
                    $crearpedido->propina = $rec->propina;
                    $crearpedido->estado = $rec->estado;
                    $crearpedido->comentarios = $rec->comentarios;
                    $crearpedido->fechacierre = $date = date('Y-m-d H:i:s');
                    $crearpedido->fechacreacion = $date = date('Y-m-d H:i:s');
                    
                    $crearpedido->save();

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
            'message' => 'Crear Pedido',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    // Listar paises
    public function listarPedido($rec)
    {
        //echo json_encode($rec->idinterno);
        //exit;
        DB::beginTransaction();
        try {
            $db_name = "salespoint_sys";
                
        $listarpedido = DB::connection($this->cur_connect)->select(
                                                            "select t0.*
                                                            from ".$db_name.'.pedidos'." t0
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
            'listarpedido' => $listarpedido,
            'message' => 'Listar menu',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    // Listar paises
    public function listarOnePedido($rec)
    {
        //echo json_encode($rec->idinterno);
        //exit;
        DB::beginTransaction();
        try {
            $db_name = "salespoint_sys";
                
        $listarpedido = DB::connection($this->cur_connect)->select(
                                                            "select t0.*, t1.descripcion nombrezona
                                                            from ".$db_name.'.pedidos'." t0
                                                            JOIN ".$db_name.'.zonas'." t1 ON t0.idzona = t1.id
                                                            WHERE t0.id = '". $rec->idpedido."'
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
            'listarpedido' => $listarpedido,
            'message' => 'Listar menu',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }


    //Actualizar  comments application
    public function actualizarPedido($rec)
    {
        //echo json_encode($rec->id);
        //exit;
        $db_name = $this->db.".pedidos";

        DB::beginTransaction();
        try {

            DB::connection($this->cur_connect)->update("UPDATE ".$db_name." 
                SET cantidad = '".$rec-> cantidad."',
                    idvinculado = '".$rec-> idvinculado."',
                    idzona = '".$rec-> idzona."',

                    mediodepago = '".$rec-> mediodepago."',
                    descuento = '".$rec-> descuento."',

                    costo = '".$rec-> costo."',
                    total = '".$rec-> total."',
                    estado = '".$rec-> estado."',
                    iva = '".$rec-> iva."',
                    retencion = '".$rec-> retencion."',
                    propina = '".$rec-> propina."',
                    comentarios = '".$rec-> comentarios."',
                    fechacierre = '".$date = date('Y-m-d H:i:s')."'
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
            'message' => 'UPDATED BODEGAS OK'
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    public function actualizarValoresPedido($rec)
    {
        //echo json_encode($rec->id);
        //exit;
        $db_name = $this->db.".pedidos";

        DB::beginTransaction();
        try {

            DB::connection($this->cur_connect)->update("UPDATE ".$db_name." 
                SET cantidad = '".$rec-> cantidad."',
                    costo = '".$rec-> costo."',
                    total = '".$rec-> total."',
                    iva = '".$rec-> iva."',
                    retencion = '".$rec-> retencion."'
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
            'message' => 'UPDATED BODEGAS OK'
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    //Actualizar  comments application
    public function actualizaEstadoPedido($rec)
    {
        //echo json_encode($rec->id);
        //exit;
        $db_name = $this->db.".pedidos";

        DB::beginTransaction();
        try {

            DB::connection($this->cur_connect)->update("UPDATE ".$db_name." 
                SET estado = '".$rec-> estado."'
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
            'message' => 'UPDATED BODEGAS OK'
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    //Actualizar  comments application
    public function actualizaZonaPedido($rec)
    {
        //echo json_encode($rec->id);
        //exit;
        $db_name = $this->db.".pedidos";

        DB::beginTransaction();
        try {

            DB::connection($this->cur_connect)->update("UPDATE ".$db_name." 
                SET idzona = '".$rec-> idzona."',
                    idvinculado = '".$rec-> idvinculado."'
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
            'message' => 'UPDATED BODEGAS OK'
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    //Delete  comments application
    public function borrarPedido($rec)
    {
        $db_name = $this->db.".pedidos";

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

    //Administrar Menus
    public function crearItemPedido($rec)
    {

        DB::beginTransaction();
        try {
                    $db_name = $this->db.".itemspedido";
                    $creaitempedido = new ModelGlobal();
                    $creaitempedido->setConnection($this->cur_connect);
                    $creaitempedido->setTable($db_name);

                    $creaitempedido->idpedido = $rec->idpedido;
                    $creaitempedido->idproducto = $rec->idproducto;
                    $creaitempedido->costototal = $rec->costototal;
                    $creaitempedido->costounitario = $rec->costounitario;
                    $creaitempedido->cantidad = $rec->cantidad;
                    $creaitempedido->precioventa = $rec->precioventa;
                    $creaitempedido->preciounitarioventa = $rec->preciounitarioventa;
                    $creaitempedido->estado = $rec->estado;
                    $creaitempedido->comentarios = $rec->comentarios;
                    $creaitempedido->fechacierre = $date = date('Y-m-d H:i:s');
                    $creaitempedido->fechacreacion = $date = date('Y-m-d H:i:s');
                    
                    $creaitempedido->save();

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
            'message' => 'Crear Item Menu',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    // Listar Items pedidos
    public function listarItemsPedido($rec)
    {
        //echo json_encode($rec->idinterno);
        //exit;
        DB::beginTransaction();
        try {
            $db_name = "salespoint_sys";
                
        $listaritempedido = DB::connection($this->cur_connect)->select(
                                                            "select t0.*
                                                            from ".$db_name.'.itemspedido'." t0
                                                            JOIN ".$db_name.'.pedidos'." t1 ON t0.idpedido = t1.id
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
            'listaritempedido' => $listaritempedido,
            'message' => 'Listar menu',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    // Listar un pedido
    public function listarUnPedido($rec)
    {
        //echo json_encode($rec->idinterno);
        //exit;
        DB::beginTransaction();
        try {
            $db_name = "salespoint_sys";
                
        $listaitemspedido = DB::connection($this->cur_connect)->select(
                                                            "select t0.*, t2.descripcion as nombreprd,
                                                            t2.zona as zonapreparacion
                                                            from ".$db_name.'.itemspedido'." t0
                                                            JOIN ".$db_name.'.pedidos'." t1 ON t0.idpedido = t1.id
                                                            JOIN ".$db_name.'.productos'." t2 ON t0.idproducto = t2.id
                                                            WHERE t0.idpedido = '". $rec->idpedido."'
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
            'listaitemspedido' => $listaitemspedido,
            'message' => 'Listar menu',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    //Actualizar  comments application
    public function actualizarItemPedido($rec)
    {
        //echo json_encode($rec->id);
        //exit;
        $db_name = $this->db.".itemspedido";

        DB::beginTransaction();
        try {

            DB::connection($this->cur_connect)->update("UPDATE ".$db_name." 
                SET idproducto = '".$rec-> idproducto."',
                    costototal = '".$rec-> costototal."',
                    costounitario = '".$rec-> costounitario."',
                    cantidad = '".$rec-> cantidad."',
                    precioventa = '".$rec-> precioventa."',
                    preciounitarioventa = '".$rec-> preciounitarioventa."',
                    estado = '".$rec-> estado."',
                    comentarios = '".$rec-> comentarios."',
                    fechacierre = '".$date = date('Y-m-d H:i:s')."'
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
            'message' => 'UPDATED BODEGAS OK'
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    //Actualizar  comments application
    public function actualizaItemPed($rec)
    {
        //echo json_encode($rec->id);
        //exit;
        $db_name = $this->db.".itemspedido";

        DB::beginTransaction();
        try {

            DB::connection($this->cur_connect)->update("UPDATE ".$db_name." 
                SET estado = '".$rec-> estado."',
                    fechacierre = '".$date = date('Y-m-d H:i:s')."'
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
            'message' => 'UPDATED BODEGAS OK'
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    //Delete  comments application
    public function borrarItemPedido($rec)
    {
        $db_name = $this->db.".itemspedido";

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

    //Administrar Vinculados
    public function crearVinculados($rec)
    {

        DB::beginTransaction();
        try {
                    $db_name = $this->db.".itemsvinculados";
                    $crearvinculado = new ModelGlobal();
                    $crearvinculado->setConnection($this->cur_connect);
                    $crearvinculado->setTable($db_name);

                    $crearvinculado->idpedido = $rec->idpedido;
                    $crearvinculado->idelemento = $rec->idelemento;
                    $crearvinculado->idzona = $rec->idzona;
                    $crearvinculado->fechacreacion = $date = date('Y-m-d H:i:s');
                    $crearvinculado->fechacierre = $date = date('Y-m-d H:i:s');
                    
                    $crearvinculado->save();

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
            'message' => 'Crear Mesa',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    // Listar Ietms Vinculados
    public function listarItemsVinculados($rec)
    {
        //echo json_encode($rec->idinterno);
        //exit;
        DB::beginTransaction();
        try {
            $db_name = "salespoint_sys";
                
        $listarvinculados = DB::connection($this->cur_connect)->select(
                                                            "select t0.*
                                                            from ".$db_name.'.itemsvinculados'." t0
                                                            WHERE t0.idpedido = '". $rec->idpedido."'
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
            'listarvinculados' => $listarvinculados,
            'message' => 'Listar mesas',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    // Listar Vinculados
    public function listarVinculados($rec)
    {
        //echo json_encode($rec->idinterno);
        //exit;
        DB::beginTransaction();
        try {
            $db_name = "salespoint_sys";
                
        $listarvinculados = DB::connection($this->cur_connect)->select(
                                                            "select t0.*
                                                            from ".$db_name.'.itemsvinculados'." t0
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
            'listarvinculados' => $listarvinculados,
            'message' => 'Listar mesas',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    //Actualizar  Vinculados
    public function actualizarVinculados($rec)
    {
        //echo json_encode($rec->id);
        //exit;
        $db_name = $this->db.".itemsvinculados";

        DB::beginTransaction();
        try {

            DB::connection($this->cur_connect)->update("UPDATE ".$db_name." 
                SET idpedido = '".$rec-> idpedido."',
                    idelementoo = '".$rec-> idelementoo."',
                    idzona = '".$rec-> idzona."'
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
            'message' => 'UPDATED MESA OK'
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    public function actualizarEstadoVinculados($rec)
    {
        //echo json_encode($rec->id);
        //exit;
        $db_name = $this->db.".itemsvinculados";

        DB::beginTransaction();
        try {

            DB::connection($this->cur_connect)->update("UPDATE ".$db_name." 
                SET pedido = '".$rec-> pedido."',
                    estado = '".$rec-> estado."'
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
            'message' => 'UPDATED MESA OK'
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    //Delete  Vinculados
    public function borrarVinculados($rec)
    {
        $db_name = $this->db.".itemsvinculados";

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
    
    //Tipo de zona donde se presta el servicio
    public function crearTipoZonaServicio($rec)
    {
        
        DB::beginTransaction();
        try {
                    $db_name = $this->db.".tipozonadelservicio";
                    $crearzonas = new ModelGlobal();
                    $crearzonas->setConnection($this->cur_connect);
                    $crearzonas->setTable($db_name);

                    $crearzonas->idzona = $rec->idzona;
                    $crearzonas->descripcion = $rec->descripcion;
                    $crearzonas->comentarios = $rec->comentarios;
                    $crearzonas->fechacreacion = $date = date('Y-m-d H:i:s');
                    
                    $crearzonas->save();

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
            'message' => 'Crear Zonas',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    // Listar  zona donde se presta el servicio
    public function listarTipoZonaServicio($rec)
    {
        //echo json_encode($rec->idinterno);
        //exit;
        DB::beginTransaction();
        try {
            $db_name = "salespoint_sys";
                
        $listartipozonaservicio = DB::connection($this->cur_connect)->select(
                                                            "select t0.*
                                                            from ".$db_name.'.tipozonadelservicio'." t0
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
            'listartipozonaservicio' => $listartipozonaservicio,
            'message' => 'Listar Zonas',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    //Actualizar   zona donde se presta el servicio
    public function actualizarTipoZonaServicio($rec)
    {
        //echo json_encode($rec->id);
        //exit;
        $db_name = $this->db.".tipozonadelservicio";

        DB::beginTransaction();
        try {

            DB::connection($this->cur_connect)->update("UPDATE ".$db_name." 
                SET descripcion = '".$rec-> descripcion."',
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
            'message' => 'UPDATED ZONA OK'
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

   //Delete   zona donde se presta el servicio
   public function borrarTipoZonaServicio($rec)
   {
        $db_name = $this->db.".tipozonadelservicio";

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

   //Tipo de zona donde se presta el servicio
   public function crearZonaServicio($rec)
   {
       
       DB::beginTransaction();
       try {
                   $db_name = $this->db.".zonadelservicio";
                   $crearzonas = new ModelGlobal();
                   $crearzonas->setConnection($this->cur_connect);
                   $crearzonas->setTable($db_name);

                   $crearzonas->tipozonadelservicio = $rec->tipozonadelservicio;
                   $crearzonas->idzona = $rec->idzona;
                   $crearzonas->pedido = $rec->pedido;
                   $crearzonas->descripcion = $rec->descripcion;
                   $crearzonas->estado = $rec->estado;
                   $crearzonas->comentarios = $rec->comentarios;
                   $crearzonas->fechacreacion = $date = date('Y-m-d H:i:s');
                   
                   $crearzonas->save();

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
           'message' => 'Crear zona del servicio',
       );
       $rec->headers->set('Accept', 'application/json');
       echo json_encode($response);
       exit;
   }

   // Listar  zona donde se presta el servicio
   public function listarZonaServicio($rec)
   {
       //echo json_encode($rec->idinterno);
       //exit;
       DB::beginTransaction();
       try {
           $db_name = "salespoint_sys";
               
       $listarzonaservicio = DB::connection($this->cur_connect)->select(
                                                           "select t0.*, t1.descripcion as nombrezona,
                                                            t2.descripcion as zonadelservicio
                                                           from ".$db_name.'.zonadelservicio'." t0
                                                           JOIN ".$db_name.'.zonas'." t1 ON t0.idzona = t1.id
                                                           JOIN ".$db_name.'.tipozonadelservicio'." t2 ON t0.tipozonadelservicio = t2.id
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
           'listarzonaservicio' => $listarzonaservicio,
           'message' => 'Listar Zonas',
       );
       $rec->headers->set('Accept', 'application/json');
       echo json_encode($response);
       exit;
   }

   //Actualizar   zona donde se presta el servicio
   public function actualizarZonaServicio($rec)
   {
       //echo json_encode($rec->id);
       //exit;
       $db_name = $this->db.".zonadelservicio";

       DB::beginTransaction();
       try {

           DB::connection($this->cur_connect)->update("UPDATE ".$db_name." 
               SET tipozonadelservicio = '".$rec-> tipozonadelservicio."',
                   idzona = '".$rec-> idzona."',
                   pedido = '".$rec-> pedido."',
                   descripcion = '".$rec-> descripcion."',
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
           'message' => 'UPDATED ZONA OK'
       );
       $rec->headers->set('Accept', 'application/json');
       echo json_encode($response);
       exit;
   }

   //Actualizar   zona donde se presta el servicio
   public function actualizarEstadoZonaServicio($rec)
   {
       //echo json_encode($rec->id);
       //exit;
       $db_name = $this->db.".zonadelservicio";

       DB::beginTransaction();
       try {

           DB::connection($this->cur_connect)->update("UPDATE ".$db_name." 
               SET pedido = '".$rec-> pedido."',
                   estado = '".$rec-> estado."'
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
           'message' => 'UPDATED ZONA OK'
       );
       $rec->headers->set('Accept', 'application/json');
       echo json_encode($response);
       exit;
   }

    //Delete   zona donde se presta el servicio
    public function borrarZonaServicio($rec)
    {
       $db_name = $this->db.".zonadelservicio";

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

   //Comanda de productos
   public function crearComanda($rec)
   {
       
       DB::beginTransaction();
       try {
                   $db_name = $this->db.".comanda";
                   $crearzonas = new ModelGlobal();
                   $crearzonas->setConnection($this->cur_connect);
                   $crearzonas->setTable($db_name);

                   $crearzonas->idzona = $rec->idzona;
                   $crearzonas->idpedido = $rec->idpedido;
                   $crearzonas->idzonadelservicio = $rec->idzonadelservicio;
                   $crearzonas->idproducto = $rec->idproducto;
                   $crearzonas->cantidad = $rec->cantidad;
                   $crearzonas->estado = $rec->estado;
                   $crearzonas->comentarios = $rec->comentarios;
                   $crearzonas->fechacreacion = $date = date('Y-m-d H:i:s');
                   $crearzonas->fechacierre = $date = date('Y-m-d H:i:s');
                   
                   $crearzonas->save();

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
           'message' => 'Crear comanda',
       );
       $rec->headers->set('Accept', 'application/json');
       echo json_encode($response);
       exit;
   }

   // Listar comanda
   public function listarComanda($rec)
   {
       //echo json_encode($rec->idinterno);
       //exit;
       DB::beginTransaction();
       try {
           $db_name = "salespoint_sys";
               
       $listarcomanda = DB::connection($this->cur_connect)->select(
                                                           "select t0.*, t1.descripcion as nombreproducto,
                                                            t2.descripcion as nombrezona,
                                                            t3.descripcion as zonadelservicio,
                                                            t4.nombre as nombreestado
                                                           from ".$db_name.'.comanda'." t0
                                                           JOIN ".$db_name.'.productos'." t1 ON t0.idproducto = t1.id
                                                           JOIN ".$db_name.'.zonas'." t2 ON t0.idzona = t2.id
                                                           JOIN ".$db_name.'.tipozonadelservicio'." t3 ON t0.idzonadelservicio = t3.id
                                                           JOIN ".$db_name.'.estados'." t4 ON t0.estado = t4    .id
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
           'listarcomanda' => $listarcomanda,
           'message' => 'Listar Comanda',
       );
       $rec->headers->set('Accept', 'application/json');
       echo json_encode($response);
       exit;
   }

   //Actualizar comanda
   public function actualizarComanda($rec)
   {
       //echo json_encode($rec->id);
       //exit;
       $db_name = $this->db.".comanda";

       DB::beginTransaction();
       try {

           DB::connection($this->cur_connect)->update("UPDATE ".$db_name." 
               SET idzona = '".$rec-> idzona."',
                   idpedido = '".$rec-> idpedido."',
                   idzonadelservicio = '".$rec-> idzonadelservicio."',
                   idproducto = '".$rec-> idproducto."',
                   cantidad = '".$rec-> cantidad."',
                   estado = '".$rec-> estado."',
                   comentarios = '".$rec-> comentarios."',
                   fechacierre = '".$date = date('Y-m-d H:i:s')."'
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
           'message' => 'UPDATED COMANDA OK'
       );
       $rec->headers->set('Accept', 'application/json');
       echo json_encode($response);
       exit;
   }

   //Actualizar comanda
   public function actualizarEstadoComanda($rec)
   {
       //echo json_encode($rec->id);
       //exit;
       $db_name = $this->db.".comanda";

       DB::beginTransaction();
       try {

           DB::connection($this->cur_connect)->update("UPDATE ".$db_name." 
               SET estado = '".$rec-> estado."',
                   fechacierre = '".$date = date('Y-m-d H:i:s')."'
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
           'message' => 'UPDATED COMANDA OK'
       );
       $rec->headers->set('Accept', 'application/json');
       echo json_encode($response);
       exit;
   }

    //Delete   zona donde se presta el servicio
    public function borrarComanda($rec)
    {
       $db_name = $this->db.".comanda";

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

    //Crear factura
    public function crearFactura($rec)
    {

        DB::beginTransaction();
        try {
                    $db_name = $this->db.".facturas";
                    $crearfactura = new ModelGlobal();
                    $crearfactura->setConnection($this->cur_connect);
                    $crearfactura->setTable($db_name);

                    $crearfactura->idzona = $rec->idzona;
                    $crearfactura->idpedido = $rec->idpedido;
                    $crearfactura->cantidad = $rec->cantidad;
                    $crearfactura->mediodepago = $rec->mediodepago;
                    $crearfactura->descuento = $rec->descuento;
                    $crearfactura->total = $rec->total;

                    $crearfactura->codigofc = $rec->codigofc;
                    $crearfactura->subtotal = $rec->subtotal;

                    $crearfactura->iva = $rec->iva;
                    $crearfactura->retencion = $rec->retencion;
                    $crearfactura->propina = $rec->propina;
                    $crearfactura->estado = $rec->estado;            
                    $crearfactura->comentarios = $rec->comentarios;
                    $crearfactura->fechacreacion = $date = date('Y-m-d H:i:s');
                    $crearfactura->fechacierre = $date = date('Y-m-d H:i:s');
                    
                    $crearfactura->save();

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
            'message' => 'Crear Factura',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    // Listar factura
    public function listarFactura($rec)
    {
        //echo json_encode($rec->idinterno);
        //exit;
        DB::beginTransaction();
        try {
            $db_name = "salespoint_sys";
                
        $listarfactura = DB::connection($this->cur_connect)->select(
                                                            "select t0.*
                                                            from ".$db_name.'.facturas'." t0
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
            'listarfactura' => $listarfactura,
            'message' => 'Listar factura',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    // Listar paises
    public function listarOneFactura($rec)
    {
        //echo json_encode($rec->idinterno);
        //exit;
        DB::beginTransaction();
        try {
            $db_name = "salespoint_sys";
                
        $listarfactura = DB::connection($this->cur_connect)->select(
                                                            "select t0.*, t1.descripcion nombrezona
                                                            from ".$db_name.'.facturas'." t0
                                                            JOIN ".$db_name.'.zonas'." t1 ON t0.idzona = t1.id
                                                            WHERE t0.id = '". $rec->idfactura."'
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
            'listarfactura' => $listarfactura,
            'message' => 'Listar menu',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    //Actualizar  comments application
    public function actualizarFactura($rec)
    {
        //echo json_encode($rec->id);
        //exit;
        $db_name = $this->db.".facturas";

        DB::beginTransaction();
        try {

            DB::connection($this->cur_connect)->update("UPDATE ".$db_name." 
                SET cantidad = '".$rec-> cantidad."',
                    idzona = '".$rec-> idzona."',
                    mediodepago = '".$rec-> mediodepago."',
                    descuento = '".$rec-> descuento."',
                    total = '".$rec-> total."',
                    subtotal = '".$rec-> subtotal."',
                    estado = '".$rec-> estado."',
                    iva = '".$rec-> iva."',
                    retencion = '".$rec-> retencion."',
                    propina = '".$rec-> propina."',
                    comentarios = '".$rec-> comentarios."',
                    fechacierre = '".$date = date('Y-m-d H:i:s')."'
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
            'message' => 'UPDATED BODEGAS OK'
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    public function actualizarValoresFactura($rec)
    {
        //echo json_encode($rec->id);
        //exit;
        $db_name = $this->db.".facturas";

        DB::beginTransaction();
        try {

            DB::connection($this->cur_connect)->update("UPDATE ".$db_name." 
                SET cantidad = '".$rec-> cantidad."',
                    total = '".$rec-> total."',
                    iva = '".$rec-> iva."',
                    retencion = '".$rec-> retencion."'
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
            'message' => 'UPDATED FACTURAS OK'
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    //Actualizar  comments application
    public function actualizaEstadoFactura($rec)
    {
        //echo json_encode($rec->id);
        //exit;
        $db_name = $this->db.".facturas";

        DB::beginTransaction();
        try {

            DB::connection($this->cur_connect)->update("UPDATE ".$db_name." 
                SET estado = '".$rec-> estado."'
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
            'message' => 'UPDATED FACTURA OK'
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    //Delete  comments application
    public function borrarFactura($rec)
    {
        $db_name = $this->db.".facturas";

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

    //Administrar Menus
    public function crearItemFactura($rec)
    {

        DB::beginTransaction();
        try {
                    $db_name = $this->db.".itemsfactura";
                    $crearitemfactura = new ModelGlobal();
                    $crearitemfactura->setConnection($this->cur_connect);
                    $crearitemfactura->setTable($db_name);

                    $crearitemfactura->idfactura = $rec->idfactura;
                    $crearitemfactura->idproducto = $rec->idproducto;
                    $crearitemfactura->cantidad = $rec->cantidad;
                    $crearitemfactura->codigofc = $rec->codigofc;
                    $crearitemfactura->precioventa = $rec->precioventa;
                    $crearitemfactura->preciounitarioventa = $rec->preciounitarioventa;
                    $crearitemfactura->estado = $rec->estado;
                    
                    $crearitemfactura->save();

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
            'message' => 'Crear Item Menu',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    // Listar Items pedidos
    public function listarItemsFactura($rec)
    {
        //echo json_encode($rec->idinterno);
        //exit;
        DB::beginTransaction();
        try {
            $db_name = "salespoint_sys";
                
        $listaritemfactura = DB::connection($this->cur_connect)->select(
                                                            "select t0.*
                                                            from ".$db_name.'.itemsfactura'." t0
                                                            JOIN ".$db_name.'.facturas'." t1 ON t0.idfactura = t1.id
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
            'listaritemfactura' => $listaritemfactura,
            'message' => 'Listar menu',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    // Listar un pedido
    public function listarUnaFactura($rec)
    {
        //echo json_encode($rec->idinterno);
        //exit;
        DB::beginTransaction();
        try {
            $db_name = "salespoint_sys";
                
        $listaritemfactura = DB::connection($this->cur_connect)->select(
                                                            "select t0.*, t2.descripcion as nombreprd,
                                                            t2.zona as zonapreparacion
                                                            from ".$db_name.'.itemsfactura'." t0
                                                            JOIN ".$db_name.'.facturas'." t1 ON t0.idfactura = t1.idpedido
                                                            JOIN ".$db_name.'.productos'." t2 ON t0.idproducto = t2.id
                                                            WHERE t0.idfactura = '". $rec->idfactura."'
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
            'listaritemfactura' => $listaritemfactura,
            'message' => 'Listar factura',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    //Actualizar  comments application
    public function actualizarItemFactura($rec)
    {
        //echo json_encode($rec->id);
        //exit;
        $db_name = $this->db.".itemsfactura";

        DB::beginTransaction();
        try {

            DB::connection($this->cur_connect)->update("UPDATE ".$db_name." 
                SET idproducto = '".$rec-> idproducto."',
                    cantidad = '".$rec-> cantidad."',
                    precioventa = '".$rec-> precioventa."',
                    preciounitarioventa = '".$rec-> preciounitarioventa."',
                    estado = '".$rec-> estado."'
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
            'message' => 'UPDATED FACTURA OK'
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    //Delete  comments application
    public function borrarItemFactura($rec)
    {
        $db_name = $this->db.".itemsfactura";

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
    //Siigo cliente
    public function createClientes(Request $request)
    {
            $url = 'https://api.siigo.com/v1/customers';
            $metodo = 'POST';
            $data = $request->json()->all();
            return $this->sendMessageData($url, $metodo, $data);
    }
    public function showClientes(Request $request)
    {
            $identificacion = $request->input('id');
            $url = 'https://api.siigo.com/v1/customers?identification=' . $identificacion;
            $metodo = 'GET';
            return $this->sendMessage($url, $metodo);
    }
    public function updateClientes(Request $request)
    {
        $idsiigo = json_decode($request->getContent());
        $siigo = $idsiigo->id;
        $url = 'https://api.siigo.com/v1/customers/' . $siigo;
        $metodo = 'PUT';
        $data = $request->json()->all();
        return $this->sendMessageData($url, $metodo, $data);
    }
    public function destroyClientes(Request $request)
    {
            $idsiigo = $request->input('id');
            $url = 'https://api.siigo.com/v1/customers/' . $idsiigo;
            $metodo = 'DELETE';
            return $this->sendMessage($url, $metodo);
    }
    //Siigo Producto
    public function createProducto(Request $request)
    {
        $url = 'https://api.siigo.com/v1/products';
        $metodo = 'POST';
        $data = $request->json()->all();
        return $this->sendMessageData($url, $metodo, $data);

    }
    public function showProducto(Request $request)
    {
            $code = $request->input('id');
            $url = 'https://api.siigo.com/v1/products?code=' . $code;
            $metodo = 'GET';
            return $this->sendMessage($url, $metodo);
    }
    public function updateProducto(Request $request)
    {
            $idsiigo = json_decode($request->getContent());
            $siigo = $idsiigo->id;
            $url = 'https://api.siigo.com/v1/products/' . $siigo;
            $metodo = 'PUT';
            $data = $request->json()->all();
            return $this->sendMessageData($url, $metodo, $data);
    }
    public function destroyProducto(Request $request)
    {
            $idsiigo = $request->input('id');
            $url = 'https://api.siigo.com/v1/products/' . $idsiigo;
            $metodo = 'DELETE';
            return $this->sendMessage($url, $metodo);
    }
    //Siigo Factura
    public function createFacturas(Request $request)
    {
            $url = 'https://api.siigo.com/v1/invoices';
            $metodo = 'POST';
            $data = $request->json()->all();
            return $this->sendMessageData($url, $metodo, $data);
    }
    public function updateFacturas(Request $request)
    {
            $idsiigo = json_decode($request->getContent());
            $siigo = $idsiigo->id;
            $url = 'https://api.siigo.com/v1/invoices/' . $siigo;
            $metodo = 'PUT';
            $data = $request->json()->all();
            return $this->sendMessageData($url, $metodo, $data);
    }
    public function showFacturas(Request $request)
    {
            $idsiigo =$request->input('id');
            $url = 'https://api.siigo.com/v1/invoices/' . $idsiigo;
            $metodo = 'GET';
            return $this->sendMessage($url, $metodo);
    }
    public function sendFacturas(Request $request)
    {
            $idsiigo =$request->input('id');
            $url = 'https://api.siigo.com/v1/invoices/' . $idsiigo. '/mail';
            $metodo = 'POST';
            $data = $request->json()->all();
            return $this->sendMessageData($url, $metodo, $data);
    }
    public function pdfFacturas(Request $request)
    {
            $idsiigo =$request->input('id');
            $url = 'https://api.siigo.com/v1/invoices/' . $idsiigo. '/pdf';
            $fileName = "invoice_{$idsiigo}.pdf";
            return $this->sendMessagePdf($url, $fileName);
    }
    //Siigo Nota de Credito
    public function createNotaCredi(Request $request)
    {
            $url = 'https://api.siigo.com/v1/credit-notes';
            $metodo = 'POST';
            $data = $request->json()->all();
            return $this->sendMessageData($url, $metodo, $data);
    }
    public function showNotaCredi(Request $request)
    {
            $idsiigo = $request->input('id');
            $url = 'https://api.siigo.com/v1/credit-notes/' . $idsiigo;
            $metodo = 'GET';
            return $this->sendMessage($url, $metodo);
    }
    public function pdfNotaCredi(Request $request)
    {
            $idsiigo = $request->input('id');
            $url = 'https://api.siigo.com/v1/credit-notes/' . $idsiigo. '/pdf';
            $fileName = "credit_notes_{$idsiigo}.pdf";
            return $this->sendMessagePdf($url, $fileName);
    }
    public function authenticateSiigo()
    {
        $authData = [
            "username" => $this->siigo_username,
            "access_key" => $this->siigo_access_key
        ];
        $headers = [
            'Content-Type' => 'application/json',
            'Partner-Id' => $this->Partner,
        ];
            $response = Http::withHeaders($headers)
                            ->timeout(120)
                            ->post($this->urlSigo, $authData);

        if ($response->successful()) {
            $accessToken = $response->json()['access_token'];
            Cache::put('key_siigo_sp', $accessToken, now()->addHours(23));
            return $accessToken;
        } else {
            return response()->json(['error' => 'Error en la autenticación con Siigo'], $response->status());
        }
    }
    private function sendMessage($url, $metodo)
    {
        $tokenSiigo = Cache::get('key_siigo_sp');
        if (!$tokenSiigo) {
            $tokenSiigo = $this->authenticateSiigo();
        }
        try {
            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
                'Authorization' => $tokenSiigo,
                'Partner-Id' => $this->Partner
            ])->timeout(120)->send($metodo, $url);
            if ($response->successful()) {
                return  $response->json();
            } elseif ($response->serverError()) {
                return response()->json(['error' => 'Error en el servidor de Siigo. Intenta nuevamente más tarde.'], 500);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => 'Ocurrió un error al consultar la API de Siigo: ' . $e->getMessage()], 500);
        }

    }
    private function sendMessageData($url, $metodo, $data)
    {
        $tokenSiigo = Cache::get('key_siigo_sp');
        if (!$tokenSiigo) {
            $tokenSiigo = $this->authenticateSiigo();
        }
        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
            'Authorization' => $tokenSiigo,
            'Partner-Id' => $this->Partner
        ])->timeout(120)->send($metodo, $url, ['json' => $data]);
        return $response->body();
    }
    private function sendMessagePdf($url, $fileName)
    {
        $tokenSiigo = Cache::get('key_siigo_sp');
        if (!$tokenSiigo) {
            $tokenSiigo = $this->authenticateSiigo();
        }

        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
            'Authorization' => $tokenSiigo,
            'Partner-Id' => $this->Partner
        ])->timeout(120)->get($url);

        if ($response->successful()) {
            $base64Pdf = $response['base64'];
            $decodedPdf = base64_decode($base64Pdf);
            $filePath = public_path('facturaspdf') . '/' . $fileName;
            file_put_contents($filePath, $decodedPdf);
            $fileUrl = url('facturaspdf/' . $fileName);
            return response()->json(['url' => $fileUrl]);
        } else {
            return response()->json(['error' => 'No se pudo descargar el PDF'], $response->status());
        }
    }
    public function GuardarIMG($imagenB64,$nameImg,$dirImg)
    {
        return $upd_img = FunctionsCustoms::UploadImageMrp($imagenB64,$nameImg,$dirImg);
    }
    
}


