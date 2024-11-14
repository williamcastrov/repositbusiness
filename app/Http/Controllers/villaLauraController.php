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

class villalauraController extends Controller
{
        /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
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

        //header('Access-Control-Allow-Origin: *');
        header("Access-Control-Allow-Origin: *");

        $this->cur_connect = 'mysql';
        $this->db = 'villalaura_sys';
        //$this->dbgim = 'zafirogimbc_sys';
       
        // Datos para consultas de Api de Siigo
        $this->url_siigo_api = "https://api.siigo.com/v1/";

        // Datos para consultas de Api de intuit
        $this->CompanyId = '9341452921544848';
        $this->clientId = 'ABvDXTXyX9I9BmkQoXyVHprxmYB3DZs6cttp1WqGxmo8rdLnph';
        $this->clientSecret = 'Ac4KgGfDbfZ38vYSIYaVq9LuRjRZErB8spG5NRkv';
        $this->urlAccessToken = 'https://oauth.platform.intuit.com/oauth2/v1/tokens/bearer';
        $this->redirectUri = 'https://gimcloud.com.co/intuit/callback';
        $this->urlAuthorize = 'https://appcenter.intuit.com/connect/oauth2';
        $this->urlResourceOwnerDetails = 'https://sandbox-quickbooks.api.intuit.com/v3/company/';
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function villalauraGeneral(Request $request, $accion, $parametro=null)
    {
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
            $db_name = "villalaura_sys";
                
        $listcountry = DB::connection($this->cur_connect)->select(
                                                "select t0.* 
                                                from ".$db_name.'.country'." t0");                                                            
        
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
            'listcountry' => $listcountry
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
            $db_name = "villalaura_sys";
                
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



    public function GuardarIMG($imagenB64,$nameImg,$dirImg)
    {
        return $upd_img = FunctionsCustoms::UploadImageMrp($imagenB64,$nameImg,$dirImg);
    }
    
}


