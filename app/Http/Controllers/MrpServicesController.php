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

class MrpServicesController extends Controller
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
        $this->db = 'mercadorepuesto_sys';
        $this->dbgim = 'zafirogimbc_sys';
       
        // Datos para consultas de Api de Siigo
        $this->url_siigo_api = "https://api.siigo.com/v1/";
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function mrpGeneral(Request $request, $accion, $parametro=null)
    {
        switch ($accion) {
            case 1:
                $this->mrpCategorias($request);
                break;
            case 2:
                $this->mrpTipoVehiculos($request);
                break;
            case 3:
                $this->mrpMainMenu($request);
                break;
            case 4:
                $this->createUser($request);
                break;
             case 5:
                $this->login($request);
                break;
            case 6:
                $this->homepageDemos($request);
                break;
            case 7:
                $this->mrpTipoIdentificacion($request);
                break;
            case 8:
                $this->mrpMarcasVehiculos($request);
                break;
            case 9:
                $this->mrpAnosVehiculos($request);
                break;
            case 10:
                $this->mrpModelosVehiculos($request);
                break;
            case 11:
                $this->mrpCarroceriasVehiculos($request);
                break;
            case 12:
                $this->mrpEnvioToken($request);
                break;
            case 13:
                $this->readUser($request);
                break;
            case 1301:
                $this->readAllUser($request);
                break;
            case 14:
                $this->readWompi($request);
                break;
            case 15:
                $this->readVersionMotor($request);
                break;
            case 16:
                $this->createProduct($request);
                break;
            case 1016:
                $this->updateProduct($request);
                break;
            case 1018:
                $this->updateExistenceProduct($request);
                break;
            case 17:
                $this->getProducts($request, $parametro);
                break;
            case 1701:
                $this->getProductsCategory($request, $parametro);
                break;
            case 1702:
                $this->listarProductos($request, $parametro);
                break;                
            case 1703:
                $this->getProductsCategoryPos($request, $parametro);
                break;
            case 1704:
                $this->getProductsCategoryGaraje($request, $parametro);
                break;
            case 1705:
                $this->getProductsGaraje($request, $parametro);
                break;
            case 18:
                $this->getProductsById($request, $parametro);
                break;
            case 19:
                $this->updateToken($request, $parametro);
                break;
            case 20:
                $this->activeToken($request);
                break;
            case 21:
                $this->readUserEmail($request);
                break;
            case 22:
                $this->createDocsNit($request);
                break;
            case 23:
                $this->savePDFsNit($request);
                break;
            case 24:
                $this->createVehiculosCompatibles($request);
                break;
            case 25:
                 $this->getPublication($request, $parametro);
                break;
            case 26:
                $this->crearMarcaVehiculo($request);
                break;
            case 27:
                $this->createVehiculosGarage($request);
                break;    
            case 28:
                $this->listarVehiculoGarageUsuario($request);
                break;
            case 29:
                $this->listarUnVehiculoGarageUsuario($request);
                break;
            case 30:
                $this->actualizaVehiculoGarageUsuario($request);
                break;
            case 31:
                $this->borrarVehiculoGarageUsuario($request);
                break;
            case 32:
                $this->createTemporaryProductVehicles($request);
                break;
            case 33:
                $this->selectTemporaryProductVehicles($request);
                break;
            case 34:
                $this->actualizaTemporaryProductVehicles($request);
                break;
            case 35:
                $this->borrarTemporaryProductVehicles($request);
                break;
            case 36:
                $this->createProductVehicles($request);
                break;
            case 37:
                $this->listarBDPalabras($request);
                break;
            case 38:
                $this->listarConectores($request);
                break;
            case 39:
                $this->coincidenciasBDPalabras($request);
                break;       
            case 40:
                $this->getNameProducts($request);
                break;
            case 41:
                $this->listarProductosDB($request);
                break;
            case 42:
                $this->getProductsGeneric($request, $parametro);
                break;
            case 43:
                $this->listarCantidadPrdCiudad($request);
                break;
            case 44:
                $this->getProductsContact($request, $parametro);
                break;
            case 45:
                $this->listarVehiculosCompatabibles($request, $parametro);
                break;
            case 46:
                $this->listarPosicionProducto($request, $parametro);
                break;
            case 47:
                $this->saveCalificacionProducto($request, $parametro);
                break;
            case 48:
                $this->listarCalificacionProducto($request, $parametro);
                break;
            case 481:
                $this->listarUnaCalificacionProducto($request, $parametro);
                break;
            case 49:
                $this->saveCalificacionVendedor($request, $parametro);
                break;
            case 50:
                $this->listarCalificacionVendedorPrd($request, $parametro);
                break;
            case 501:
                $this->listarCalificacionPrdCompra($request, $parametro);
                break;
            case 502:
                $this->listarCalificacionPrdVende($request, $parametro);
                break;
            case 51:
                $this->savePreguntaVendedor($request, $parametro);
                break;
            case 52:
                $this->listarPreguntaVendedor($request, $parametro);
                break;
            case 5215:
                $this->listarPreguntaMisProductos($request, $parametro);
                break;
            case 5216:
                $this->listarPreguntaUsuarioPrd($request, $parametro);
                break;
            case 5217:
                $this->listarPrgComprador($request, $parametro);
                break;
            case 5218:
                $this->listarRespVendedor($request, $parametro);
                break;
            case 5219:
                $this->actualizaEstadoPregunta($request, $parametro);
                break;
            case 5220:
                $this->listarPrgConsolaAdmon($request, $parametro);
                break;
            case 5211:
                $this->listarPreguntaComprador($request, $parametro);
                break;
            case 5212:
                $this->listarPreguntasProducto($request, $parametro);
                break;
            case 5213:
                $this->deletePreguntaVendedor($request, $parametro);
                break; 
            case 5214:
                $this->listarPreguntasIdpregunta($request, $parametro);
                break; 
            case 5220:
                $this->listarPrgVendedorNotificacion($request, $parametro);
                break;             
            case 53:
                $this->saveWishList($request, $parametro);
                break;
            case 531:
                $this->saveWishListHistory($request, $parametro);
                break;
            case 532:
                $this->listPrdWishListHistory($request, $parametro);
                break;                
            case 54:
                $this->listarWishList($request, $parametro);
                break;
            case 55:
                $this->deleteWishListUser($request, $parametro);
                break;
            case 56:
                $this->deleteWishListItemUser($request, $parametro);
                break;
            case 561:
                $this->deleteWishListPrd($request, $parametro);
                break;            
            case 57:
                $this->listarUnPrdWishList($request, $parametro);
                break;
            case 58:
                $this->saveShoppingCart($request, $parametro);
                break;
            case 581:
                $this->saveShoppingCartHistory($request, $parametro);
                break;
            case 582:
                $this->HistoryPrdShoppingCart($request, $parametro);
                break;
            case 59:
                $this->listarShoppingCart($request, $parametro);
                break;
            case 60:
                $this->deleteShoppingCartUser($request, $parametro);
                break;
            case 61:
                $this->deleteShoppingCartItemUser($request, $parametro);
                break;
            case 611:
                $this->deleteShoppingCartPrd($request, $parametro);
                break;
            case 62:
                $this->listarUnPrdShoppingCart($request, $parametro);
                break;
            case 63:
                $this->actualizaItemShoppingCart($request, $parametro);
                break;
            case 64:
                $this->saveAddressUser($request, $parametro);
                break;
            case 65:
                $this->listarAddressUser($request, $parametro);
                break;
            case 66:
                $this->listarUnAddressUser($request, $parametro);
                break;
            case 67:
                $this->actualizaAddressUser($request, $parametro);
                break;
            case 68:
                $this->deleteAddressUser($request, $parametro);
                break;
            case 69:
                $this->deleteOneAddressUser($request, $parametro);
                break;
            case 70:
                $this->saveMyPosts($request, $parametro);
                break;
            case 71:
                $this->listarMyPosts($request, $parametro);
                break;
            case 72:
                $this->deleteMyPostsUser($request, $parametro);
                break;
            case 73:
                $this->deleteMyPostsItemUser($request, $parametro);
                break;
            case 74:
                $this->listarUnPrdMyPosts($request, $parametro);
                break;

            case 75:
                $this->actualizarUsuario($request);
                break;
            case 76:
                $this->getProductsUser($request);
                break;
            case 77:
                $this->actualizaPublicacion($request);
                break;
            case 78:
                $this->getProductId($request);
                break;
            case 79:
                $this->duplicarProduct($request);
                break;  
            case 80:
                $this->crearRegistroCompra($request);
                break;
            case 801:
                $this->crearRechazoCompra($request);
                break;            
            case 81:
                $this->listarCompras($request);
                break;
            case 811:
                $this->listarComprasConsola($request);
                break;
            case 812:
                $this->listarComprasRechazada($request);
                break;
            case 82:
                $this->actualizarCompra($request);
                break;
            case 820:
                $this->actualizaEstadoCompra($request);
                break;  
            case 821:
                $this->actualizaNotificacionCompra($request);
                break;
            case 822:
                $this->actualizaNotificacionVenta($request);
                break;
            case 823:
                $this->saveNotificacion($request);
                break;
            case 824:
                $this->listarNotificaciones($request);
                break;
            case 825:
                $this->listarAllNotificaciones($request);
                break;
            case 826:
                $this->actEstadoFacturaVta($request);
                break;
            case 83:
                $this->saveMessage($request);
                break;
            case 84:
                $this->listMessage($request);
                break;
            case 841:
                $this->listMessageComprador($request);
                break;
            case 842:
                $this->listMessageVendedor($request);
                break;
            case 843:
                $this->listMessagePregVende($request);
                break;
            case 844:
                $this->msgsVendedorCompradorAdmon($request);
                break;
            case 847:
                $this->listPregMisPrdAdmon($request);
                break;
            case 845:
                $this->listSeguimientoProblema($request);
                break; 
            case 846:
                $this->listProblemaAdmon($request);
                break; 
            case 848:
                $this->listDevoluciones($request);
                break;
            case 849:
                $this->listMessageCompradorAdmon($request);
                break;
            case 85:
                $this->updateMessage($request);
                break;
            case 851:
                $this->updateMessageReadSeller($request);
                break;
            case 852:
                $this->updatePrguntasVendedor($request);
                break;
            case 853:
                $this->updateNotificacionPrgVendedor($request);
                break;
            case 854:
                $this->updateNotificacionResptaVendedor($request);
                break;
            case 855:
                $this->updateDevolucion($request);
                break;
            case 856:
                $this->updateNotificacion($request);
                break;
            case 86:
                $this->listarAllMyPosts($request, $parametro);
                break;
            case 87:
                $this->saveHistoryVisitPrd($request, $parametro);
                break;
            case 88:
                $this->listarAllHistoryVisitPrd($request, $parametro);
                break;
            case 89:
                $this->listarHistoryVisitPrd($request, $parametro);
                break;
            case 90:
                $this->deleteHistoryVisitPrd($request, $parametro);
                break;
            case 91:
                $this->deleteItemHistoryVisitPrd($request, $parametro);
                break; 
            case 92:
                $this->saveLinkedDevices($request, $parametro);
                break;
            case 921:
                $this->saveHistoryLinkedDevices($request, $parametro);
                break;
            case 93:
                $this->listLinkedDevices($request, $parametro);
                break;
            case 931:
                $this->listHistoryLinkedDevices($request, $parametro);
                break;
            case 94:
                $this->lisItemtLinkedDevices($request, $parametro);
                break;
            case 95:
                $this->deleteLinkedDevices($request, $parametro);
                break;
            case 951:
                $this->deleteHistoryLinkedDevices($request, $parametro);
                break;
            case 96:
                $this->deleteItemLinkedDevices($request, $parametro);
                break;
            case 961:
                $this->deleteHistoryItemLinkedDevices($request, $parametro);
                break;  
            case 97:
                $this->updateLinkedDevices($request);
                break;
            case 98:
                $this->createHistoryVehSearchSpecial($request);
                break;
            case 99:
                $this->selectHistoryVehSearchSpecial($request);
                break;
            case 100:
                $this->actualizaHistoryVehSearchSpecial($request);
                break;
            case 101:
                $this->borrarHistoryVehSearchSpecial($request);
                break;
            case 102:
                $this->selectVehiclesMercadoRepuesto($request);
                break;
            case 103:
                $this->listarCompraUsuario($request);
                break;
            case 1031:
                $this->listarCompraUsuarioNotificacion($request);
                break;
            case 1032:
                $this->listarCompraPrd($request);
                break;
            case 106:
                $this->listarVentaUsuario($request);
                break;
            case 1061:
                $this->listarVentaUsuarioNotificacion($request);
                break;
            case 104:
                $this->crearRegistroVenta($request);
                break;
            case 105:
                $this->listarVentas($request);
                break;
            case 107:
                $this->actualizarVenta($request);
                break; 
            case 108:
                $this->listarVentaUsuarioComprador($request);
                break;   
            case 109:
                $this->crearControlFacturaVta($request);
                break;
            case 1091:
                $this->crearControlFacturaVtaPDF($request);
                break;
            case 1092:
                $this->crearControlGuiaDespachoPDF($request);
                break;
            case 110:
                $this->listarControlFacturaVta($request);
                break;
            case 1101:
                $this->listarControlGuiaDespacho($request);
                break;            
            case 111:
                $this->listarFacturaVendedor($request);
                break; 
            case 1110:
                $this->listarFacturasVentaPrd($request);
                break; 
            case 1111:
                $this->listarGuiasDespacho($request);
                break;            
            case 112:
                $this->crearConsecutivoMR($request);
                break;
            case 113:
                $this->listarConsecutivoMR($request);
                break;
            case 114:
                $this->actualizarConsecutivoMR($request);
                break; 
            case 115:
                $this->listarResuelveDudasNivelUno($request);
                break; 
            case 116:
                $this->listarResuelveDudasNivelDos($request);
                break; 
            case 117:
                $this->actualizarResuelveDudasNivelUno($request);
                break; 
            case 118:
                $this->actualizarResuelveDudasNivelDos($request);
                break; 
            case 119:
                $this->crearCuentaxCobrar($request);
                break;
            case 120:
                $this->listarCuentaxCobrar($request);
                break;
            case 121:
                $this->listarCxCUsuario($request);
                break;
            case 122:
                $this->actualizarCuentaxCobrar($request);
                break; 
            case 123:
                $this->listarCxCUsuarioEstado($request);
                break; 
            case 124:
                $this->actualizarMensajesFactura($request);
                break;  
            case 125:
                $this->crearResolverDudasVend($request);
                break;
            case 126:
                $this->listarResolverDudasVend($request);
                break;
            case 127:
                $this->actualizarResolverDudasVend($request);
                break;
            case 128:
                $this->crearImgCarrusel($request);
                break;
            case 129:
                $this->listarImgCarrusel($request);
                break;
            case 130:
                $this->actualizarImgCarrusel($request);
                break; 
            case 131:
                $this->crearTextoBvenida($request);
                break;
            case 132:
                $this->listarTextoBvenida($request);
                break;
            case 133:
                $this->actualizarTextoBvenida($request);
                break;
            case 134:
                $this->crearCategoria($request);
                break;
            case 135:
                $this->listarCategorias($request);
                break;
            case 136:
                $this->actualizarCategorias($request);
                break;
            case 137:
                $this->crearSubCategoria($request);
                break;
            case 138:
                $this->listarSubCategorias($request);
                break;
            case 139:
                $this->actualizarSubCategorias($request);
                break;
            case 140:
                $this->crearImgSubcategorias($request);
                break;
            case 141:
                $this->listarImgSubcategorias($request);
                break;
            case 142:
                $this->listarUnaImgSubcategorias($request);
                break;
            case 143:
                $this->actualizarImgSubcategorias($request);
                break;
            case 144:
                $this->crearEstadodeCuenta($request);
                break;
            case 145:
                $this->listarEstadodeCuenta($request);
                break;
            case 146:
                $this->actualizarEstadodeCuenta($request);
                break;
            case 147:
                $this->saveTransaccionBilletera($request, $parametro);
                break;
            case 1471:
                $this->saveTransaccionRetiro($request, $parametro);
                break;
            case 148:
                $this->listarTransaccionBilletera($request, $parametro);
                break;
            case 149:
                $this->listarUnaTransaccionBilletera($request, $parametro);
                break;
            case 150:
                $this->actualizarTransaccionBilletera($request);
                break;
            case 151:
                $this->crearPQR($request);
                break;
            case 1511:
                $this->crearPQRPDF($request);
                break;
            case 152:
                $this->listarPQR($request);
                break;
            case 153:
                $this->actualizarPQR($request);
                break;
            case 154:
                $this->grabarSolicitudRetiro($request);
                break;
            case 155:
                $this->listarSolicitudRetiro($request);
                break;
            case 1551:
                $this->listarSolicitudRetiroUsuario($request);
                break;
            case 1552:
                $this->listarSolicitudRetiroPteUsu($request);
                break;
            case 156:
                $this->actualizarSolicitudRetiro($request);
                break;
            case 157:
                $this->listarEntidadesBancarias($request);
                break;
            case 158:
                $this->listarEstados($request);
                break;
            case 159:
                $this->productosVendidos($request);
                break;
            case 160:
                $this->productosUsuario($request);
                break;
            case 161:
                $this->crearControlNotificaciones($request);
                break;
            case 162:
                $this->listarControlNotificacion($request);
                break;
            case 163:
                $this->listarEstadosProceso($request);
                break;
            case 164:
                $this->actualizaEstadoUsuario($request);
                break;
            case 165:
                $this->listarDcosNit($request);
                break;
            case 166:
                $this->leerCiudades($request);
                break;
            case 167:
                $this->saveNotificacionAdmom($request);
                break;
            case 168:
                $this->listarNotificacionesAdmon($request);
                break;
            case 169:
                $this->listarAllNotificacionesAdmon($request);
                break;
            case 170:
                $this->grabarPendienteFacturar($request);
                break;
            case 171:
                $this->listarPendienteFacturar($request);
                break;
            case 172:
                $this->actualizaPendienteFacturar($request);
                break;
            case 173:
                $this->listarTipoPendienteFacturar($request);
                break;
            case 174:
                $this->actualizarEstadoCxC($request);
                break;
            case 175:
                $this->crearResolverDudaCero($request);
                break;
            case 176:
                $this->listarDudaCero($request);
                break;
            case 177:
                $this->actualizarDudaCero($request);
                break;
            case 178:
                $this->actualizarMensajesAyuda($request);
                break;
            case 179:
                $this->salvarImgAyuda($request);
                break;
            case 180:
                $this->salvarImgAyudaDos($request);
                break;
            case 181:
                $this->salvarImgAyudaTres($request);
                break;
            case 182:
                $this->salvarImgAyudaPDF($request);
                break;
            case 183:
                $this->actualizarLinkVideo($request);
                break;
            case 184:
                $this->salvarImgAyudaTresPDF($request);
                break;
            case 185:
                $this->leerUsuarioEmail($request);
                break;
            case 186:
                $this->crearResolverDudaUno($request);
                break;
            case 187:
                $this->crearResolverDudaDos($request);
                break;
            case 188:
                $this->imagenNotificarPQR($request);
                break;
            case 189:
                $this->pdfNotificarPQR($request);
                break;
            case 190:
                $this->listarUnaCategoria($request);
                break;
            case 191:
                $this->listarUnaSubCategoria($request);
                break;
            case 192:
                $this->borrarCategoriaCero($request);
                break;
            case 193:
                $this->listarUnaAyuda($request);
                break;
            case 194:
                $this->borrarCategoriaUno($request);
                break;
            case 195:
                $this->borrarCategoriaDos($request);
                break;
            case 196:
                $this->crearSolicitudNvoVeh($request);
                break;
            case 197:
                $this->listarSolicitudNvoVeh($request);
                break;
            case 198:
                $this->actualizarSolicitudNvoVeh($request);
                break;
            case 199:
                $this->deleteSolicitudNvoVeh($request);
                break;
            case 200:
                $this->listarMarcasVehiculos($request);
                break;
            case 201:
                $this->crearMarcaVeh($request);
                break;
            case 202:
                $this->listarModelosVehiculos($request);
                break;
            case 203:
                $this->crearModeloVeh($request);
                break;
            case 204:
                $this->listarCilindrajesVehiculos($request);
                break;
            case 205:
                $this->crearCilindrajeVeh($request);
                break;
            case 206:
                $this->marcasTipoCarroceria($request);
                break;
            case 207:
                $this->listarIDSolicitudNvoVeh($request);
                break;
            case 208:
                $this->listarDudaCeroDesc($request);
                break;
            case 209:
                $this->crearImgCategorias($request);
                break;
            case 210:
                $this->listarImgCategorias($request);
                break;
            case 211:
                $this->actualizarImgCategorias($request);
                break;
            case 212:
                $this->listarImgMarcas($request);
                break;
            case 213:
                $this->listarMarcasPrd($request);
                break;
            case 214:
                $this->actualizarEstadoCategoria($request);
                break;
            case 215:
                $this->listarSubRecomendadas($request);
                break;
            case 216:
                $this->listarSubCategGenericas($request);
                break;
            case 217:
                $this->actualizarImgMarcas($request);
                break;
            case 218:
                $this->listarMovBilletera($request);
                break;
            case 219:
                $this->listarMvoAbonos($request);
                break;
        

                /******PENDIENTE  */

            case 220:
                $this->actualizaDctoRetiro($request);
                break;
            case 221:
                $this->pdfActualizaDctoRetiro($request);
                break;
            case 222:
                $this->listarUsuarioDcto($request);
                break;
            case 223:
                $this->actualizaDctoRetiroDos($request);
                break;
            case 224:
                $this->pdfActualizaDctoRetiroDos($request);
                break;
  /******PENDIENTE  */


            case 225:
                $this->grabarDctoRetiro($request);
                break;
            case 226:
                $this->grabarDctoRetiroPDF($request);
                break;
            case 227:
                $this->listarDctoRetiro($request);
                break;
            case 229:
                $this->borrarDctoRetiro($request);
                break;
            case 230:
                $this->listarUnMvoBilletera($request);
                break;
            case 231:
                $this->editarDctoRetiro($request);
                break;
            case 232:
                $this->pdfEditarDctoRetiro($request);
                break;
            case 233:
                $this->mrpTipodeCuenta($request);
                break;
            case 234:
                $this->grabarCertifUsuario($request);
                break;
            case 235:
                $this->grabarCertifUsuarioPDF($request);
                break;
            case 236:
                $this->listarCertifUsuario($request);
                break;
            case 237:
                $this->editarCertifUsuario($request);
                break;
            case 238:
                $this->pdfEditarCertifUsuario($request);
                break;
            case 239:
                $this->borrarCertifUsuario($request);
                break;
            case 240:
                $this->listarDctoRetiroUsu($request);
                break;
            case 241:
                $this->listarUnaVenta($request);
                break;
            case 242:
                $this->unMsgsVendedorComprador($request);
                break;
            case 243:
                $this->unaDevolucionPrd($request);
                break;
            case 244:
                $this->seguimientoProblemaRedirigir($request);
                break;
            case 245:
                $this->readIdMessage($request);
                break;
            case 246:
                $this->updateUserSiigo($request);
                break;
            case 247:
                $this->actualizarEstadoCxCSiigo($request);
                break;
            case 248:
                $this->crearPrdSiigo($request);
                break;
            case 249:
                $this->listarPrdSiigo($request);
                break;
            case 250:
                $this->listarUnPrdSiigo($request);
                break;
            case 251:
                $this->actualizarPrdSiigo($request);
                break;
            case 252:
                $this->borrarPrdSiigo($request);
                break;
            case 253:
                $this->borrarUnModelo($request);
                break;
            case 254:
                $this->borrarUnaMarca($request);
                break;
            case 255:
                $this->crearTempoMarca($request);
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
                $this->mrDatosEntorno($request);
                break;
            case 1017:
                $this->getWebHookWompi($request);
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

    // Lee la condición del producto
    public function mrDatosEntorno($rec)
     {
        $db_name = "mercadorepuesto_sys";
        
        $tiposvehiculos = DB::connection($this->cur_connect)->select("select t0.*, t0.id as value, t0.text as label 
                                                                      from ".$db_name.'.tiposvehiculos'." t0 
                                                                      WHERE t0.estado = 1 ORDER BY orden ASC");

        $marcasvehiculos = DB::connection($this->cur_connect)->select("select t0.*, t0.id as value, t0.text as label  
                                                                       from ".$db_name.'.marcas'." t0 
                                                                       WHERE estado = 1 ORDER BY text ASC");

        $carroceriasvehiculos = DB::connection($this->cur_connect)->select("select t0.*, t0.id as value, t0.carroceria as label  
                                                                            from ".$db_name.'.tiposcarrocerias'." t0 
                                                                            WHERE estado = 1 ORDER BY carroceria ASC");
        
        $anosvehiculos = DB::connection($this->cur_connect)->select("select t0.*, t0.id as value, t0.anovehiculo as label
                                                                     from ".$db_name.".anosvehiculos t0 ORDER BY anovehiculo DESC");

        $modelosvehiculos = DB::connection($this->cur_connect)->select("select t0.*, t0.id as value, t0.modelo as label 
                                                                        from ".$db_name.'.modelos'." t0 
                                                                       ");

        $versionmotor = DB::connection($this->cur_connect)->select("select t0.*, t0.id as value, t0.cilindraje as label  
                                                                    from ".$db_name.'.versionmotor'." t0 
                                                                    WHERE t0.estado = 1");
        
        $categorias = DB::connection($this->cur_connect)->select("select t0.*, t0.id as value, t0.nombre as label,
                                                                    t0.nombre as text 
                                                                    from ".$db_name.'.categorias'." t0");
        $subcategorias = DB::connection($this->cur_connect)->select("select t0.*, t0.id_categorias as value, t0.nombre as label,
                                                                    t0.nombre as text 
                                                                    from ".$db_name.'.subcategorias'." t0 
                                                                    ORDER BY id ASC");
        
        $departamentos = DB::connection($this->cur_connect)->select("select t0.*, t0.id_dep as value, t0.nombre_dep as label,
                                                                    t0.nombre_dep as text 
                                                                    from ".$db_name.'.departamentos'." t0 
                                                                    ORDER BY nombre_dep ASC");

        $ciudades = DB::connection($this->cur_connect)->select("select t0.*, t0.id_ciu as value, 
                                                                t0.nombre_ciu as label,
                                                                t0.nombre_ciu as text 
                                                                from ".$db_name.'.ciudades'." t0 
                                                                ORDER BY nombre_ciu ASC");

        $entorno = array(
            'vgl_tiposvehiculos' => $tiposvehiculos,
            'vgl_marcasvehiculos' => $marcasvehiculos,
            'vgl_carroceriasvehiculos' => $carroceriasvehiculos,
            'vgl_annosvehiculos' => $anosvehiculos,
            'vgl_modelosvehiculos' => $modelosvehiculos,
            'vgl_cilindrajesvehiculos' => $versionmotor,
            'vgl_categorias' => $categorias, 
            'vgl_subcategorias' => $subcategorias,
            'vgl_departamentos' => $departamentos,
            'vgl_ciudades' => $ciudades,
        );
        
        $datos = array();
    
        $datoc = [
            'header_supplies' => $tiposvehiculos
        ];
        $datos[] = $datoc;
    
        echo json_encode($entorno);
    }                                                            

    public function mrpCategorias($rec)
    {   
        $db_name = "mercadorepuesto_sys";

        $categorias = DB::connection($this->cur_connect)->select("select t0.* from ".$db_name.'.categorias'." t0 WHERE t0.estado = 1");

        $menu_categorias = current(DB::connection($this->cur_connect)->select("select t0.* from ".$db_name.'.categorias_menu'." t0 WHERE t0.id = 1"));

        $categ = array();

            foreach($categorias as $cat){

                $subcateg = DB::connection($this->cur_connect)->select("select t0.nombre AS text, t0.url AS url from ".$db_name.'.subcategorias'." t0 WHERE t0.id_categorias='".$cat->id."' AND t0.estado = 1");

                $datoc = [
                    'heading' => $cat->nombre,
                    'megaItems' => $subcateg
                ];
                $categ[] = $datoc;
            }

        $main_categ = array();

                $datom = [
                    'id' => $menu_categorias->id,
                    'text' => $menu_categorias->text,
                    'url' => $menu_categorias->url,
                    'extraClass' => $menu_categorias->extraClass,
                    'subClass' => "sub-menu",
                    'megaContent' => $categ
                ];
            $main_categ[] = $datom;

        echo json_encode($main_categ);
    }

    public function mrpTipoVehiculos($rec)
    {
        $db_name = "mercadorepuesto_sys";

        $tiposvehiculos = DB::connection($this->cur_connect)->select("select t0.* from ".$db_name.'.tiposvehiculos'." t0 WHERE t0.estado = 1 ORDER BY orden ASC");

        $tiposvehi = array();

        $datoc = [
                    'header_supplies' => $tiposvehiculos
                ];
                $tiposvehi[] = $datoc;

        echo json_encode($tiposvehi);
    }

    public function mrpTipoIdentificacion($rec)
    {
        DB::beginTransaction();
        try {
            $db_name = "mercadorepuesto_sys";
                
            $tipoidentificacion = DB::connection($this->cur_connect)->select("select t0.* from ".$db_name.'.tipoidentificacion'." t0 WHERE t0.estado = 1");

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
            'tipoidentificacion' => $tipoidentificacion,
            'message' => 'REGISTRO EXITOSO',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    public function mrpTipodeCuenta($rec)
    {
        DB::beginTransaction();
        try {
            $db_name = "mercadorepuesto_sys";
                
            $tipodecuenta = DB::connection($this->cur_connect)->select("
                                                                select t0.* 
                                                                from ".$db_name.'.tipodecuenta'." t0 
                                                                WHERE t0.estado = 31");

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
            'tipodecuenta' => $tipodecuenta,
            'message' => 'REGISTRO EXITOSO',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
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
                    $nuevoUser->usuario = $rec->usuario;
                    $nuevoUser->primernombre = $rec->primernombre;
                    $nuevoUser->segundonombre = $rec->segundonombre;
                    $nuevoUser->primerapellido = $rec->primerapellido;
                    $nuevoUser->segundoapellido = $rec->segundoapellido;
                    $nuevoUser->razonsocial = $rec->razonsocial;
                    $nuevoUser->tipoidentificacion = $rec->tipoidentificacion;
                    $nuevoUser->identificacion = $rec->identificacion;
                    $nuevoUser->tipousuario = $rec->tipousuario;
                    $nuevoUser->celular = $rec->celular;
                    $nuevoUser->email = $rec->email;
                    $nuevoUser->token = $rec->token;
                    $nuevoUser->activo = $rec->activo;
                    $nuevoUser->direccion = $rec->direccion;
                    $nuevoUser->fechacreacion = $date = date('Y-m-d H:i:s');
                    $nuevoUser->fechatoken = $date = date('Y-m-d H:i:s');
                    $nuevoUser->fechaactualizadctos = $date = date('Y-m-d H:i:s');
                    $nuevoUser->fechaactualiza = $rec->fechaactualiza;
                    
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

    public function mrpMainMenu($rec)
    {
        $db_name = "mercadorepuesto_sys";

        $mainmenu = DB::connection($this->cur_connect)->select("select t0.* from ".$db_name.'.main_menu'." t0 WHERE t0.estado = 1");
        $marcas = DB::connection($this->cur_connect)->select("select t0.* from ".$db_name.'.marcas'." t0 ORDER BY RAND() limit 5");

        $menuprincipal = array();
        $main_menu_array = array();
        $marca_array = array();

         $datomarcas = [
                    'heading' => "Marcas",
                    'megaItems' => $marcas
                ];

         $marca_array[] = $datomarcas;
         //echo json_encode($datomarcas);

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
                        'megaContent' => $marca_array
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

    public function homepageDemos($rec)
    {
        $db_name = "mercadorepuesto_sys";

        $pagedemos = DB::connection($this->cur_connect)->select("select t0.* from ".$db_name.'.homepage'." t0 WHERE t0.estado = 1");

        $paginasinicio = array();
        $homepages     = array();
        $marca_array   = array();

         //echo json_encode($datomarcas);
        foreach($pagedemos as $mm){
            $datoc = [
                'id' => $mm->id,
                'text' => $mm->text,
                'image' => $mm->image,
                'url' => $mm->url
            ];
            $paginasinicio[] = $datoc;
        }

        $datoc = [
                    'homepage_demos' => $paginasinicio
                ];

        $homepages[] = $datoc;

        echo json_encode($homepages);
    }

    public function mrpMarcasVehiculos($rec)
    {
        //echo json_encode($rec->idvehiculo);
        //exit;
        $db_name = "mercadorepuesto_sys";

    $marcasvehiculos = DB::connection($this->cur_connect)->select("
                                                            select t0.* 
                                                            from ".$db_name.'.marcas'." t0 
                                                            WHERE estado = 1 
                                                            && tipovehiculo = ". $rec->idvehiculo." 
                                                            ORDER BY text ASC"
    );
/*
.'.marcas'." t0 ORDER BY RAND() limit 5"
*/
       echo json_encode($marcasvehiculos);
    }

    public function mrpAnosVehiculos($rec)
    {
        $db_name = "mercadorepuesto_sys";

        $anosvehiculos = DB::connection($this->cur_connect)->select("select t0.* from ".$db_name.".anosvehiculos t0 ORDER BY anovehiculo DESC");

        $datosanosvehiculos = array();

        foreach($anosvehiculos as $mm){
            $datoc = [
                'value' => $mm->id,
                'label' => $mm->anovehiculo
            ];
            $datosanosvehiculos[] = $datoc;
        }

        echo json_encode($datosanosvehiculos);
    }

    public function mrpModelosVehiculos($rec)
    {
        $db_name = "mercadorepuesto_sys";

        $modelosvehiculos = DB::connection($this->cur_connect)->select("select t0.* from ".$db_name.'.modelos'." t0 WHERE estado = 1 && marca = ". $rec->idmarca);

        $modelosvehiculosmarca = array();

        foreach($modelosvehiculos as $mm){
            $datoc = [
                'value' => $mm->id,
                'label' => $mm->modelo
            ];
            $modelosvehiculosmarca[] = $datoc;
        }
        echo json_encode($modelosvehiculosmarca);
    }

    public function mrpCarroceriasVehiculos($rec)
    {
        $db_name = "mercadorepuesto_sys";

        $carroceriasvehiculos = DB::connection($this->cur_connect)->select("select t0.* from ".$db_name.'.tiposcarrocerias'." t0 WHERE tipovehiculo = ". $rec->idcarroceria);

        $tiposvehiculoscarroceria = array();

        foreach($carroceriasvehiculos as $mm){
            $datoc = [
                'value' => $mm->id,
                'label' => $mm->carroceria
            ];
            $tiposvehiculoscarroceria[] = $datoc;
        }
        echo json_encode($tiposvehiculoscarroceria);
    }

    public function readAllUser($rec)
    {
        $db_name = "mercadorepuesto_sys";

        DB::beginTransaction();
        try {
            $db_name = "mercadorepuesto_sys";
                
        $leeusuarios = DB::connection($this->cur_connect)->select("select t0.*, t0.activo as idestado,
                                                        t1.descripcion as nombredocumento,
                                                        TRUNCATE(((DATEDIFF(NOW(), t0.fechacreacion ))/30),1) AS tiempocomovendedor,
                                                        t2.nombre,
                                                        TRUNCATE(((DATEDIFF(NOW(), t0.fechaactualiza ))),1) AS tiempoactualiza
                                                        from ".$db_name.'.users'." t0 
                                                        JOIN ".$db_name.'.tipoidentificacion'." t1 ON t0.tipoidentificacion = t1.id
                                                        JOIN ".$db_name.'.estados'." t2 ON t0.activo = t2.tipodeestado
                                                        ORDER BY fechacreacion DESC");

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
            'leeusuarios' => $leeusuarios,
            'message' => 'REGISTRO EXITOSO',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    public function leerCiudades($rec)
    {
        $db_name = "mercadorepuesto_sys";

        DB::beginTransaction();
        try {
            $db_name = "mercadorepuesto_sys";
                
        $ciudades = DB::connection($this->cur_connect)->select("select t0.*, t0.id_ciu as value, 
                                                                t0.nombre_ciu as label, t1.nombre_dep, t1.codigo_dep,
                                                                t0.nombre_ciu as text 
                                                                from ".$db_name.'.ciudades'." t0 
                                                                JOIN ".$db_name.'.departamentos'." t1 ON t0.departamento_ciu = t1.codigo_dep
                                                                ORDER BY nombre_ciu ASC");
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
            'ciudades' => $ciudades,
            'message' => 'REGISTRO EXITOSO',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    public function readUser($rec)
    {
        $db_name = "mercadorepuesto_sys";

        $usuarios = DB::connection($this->cur_connect)->select("select t0.*, t1.descripcion as nombredocumento,
                                                        TRUNCATE(((DATEDIFF(NOW(), t0.fechacreacion ))/30),1) AS tiempocomovendedor
                                                        from ".$db_name.'.users'." t0 
                                                        JOIN ".$db_name.'.tipoidentificacion'." t1 ON t0.tipoidentificacion = t1.id
                                                        WHERE uid = ".$rec->usuario);

        $usuarioseleccionado = array();
        echo json_encode($usuarios);
    }

    //Actualiza datos del usuario
    public function actualizarUsuario($rec)
    {
        //echo json_encode($rec->id);
        //exit;
        $db_name = $this->db.".users";
 
        DB::beginTransaction();
        try {
 
            DB::connection($this->cur_connect)->update("UPDATE ".$db_name." 
                SET primernombre = '".$rec-> primernombre."',
                    segundonombre = '".$rec-> segundonombre."',
                    primerapellido = '".$rec-> primerapellido."',
                    segundoapellido = '".$rec-> segundoapellido."',
                    razonsocial = '".$rec-> razonsocial."',
                    tipoidentificacion = '".$rec-> tipoidentificacion."',
                    identificacion = '".$rec-> identificacion."',
                    celular = '".$rec-> celular."',
                    email = '".$rec-> email."',
                    token = '".$rec-> token."',
                    activo = '".$rec-> activo."',
                    direccion = '".$rec-> direccion."',
                    fechacreacion = '".$rec-> fechacreacion."',
                    fechatoken = '".$rec-> fechatoken."'
                WHERE uid = '".$rec->uid."'");
                
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

    //Actualiza datos del usuario
    public function updateUserSiigo($rec)
    {
        //echo json_encode($rec->id);
        //exit;
        $db_name = $this->db.".users";
 
        DB::beginTransaction();
        try {
 
            DB::connection($this->cur_connect)->update("UPDATE ".$db_name." 
                SET idsiigo = '".$rec-> idsiigo."',
                    activesiigo = '".$rec-> activesiigo."'
                WHERE uid = '".$rec->uid."'");
                
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

    public function readUserEmail($rec)
    {
        $db_name = "mercadorepuesto_sys";

        $usuarios = DB::connection($this->cur_connect)->select(
                                                        "select t0.* 
                                                        from ".$db_name.'.users'." t0 
                                                        WHERE email = '". $rec->email."'");

        $usuarioseleccionado = array();

        echo json_encode($usuarios);
    }

    // Lee productos creados en la DB Local
    public function leerUsuarioEmail($rec)
    {
         //echo json_encode($rec->idinterno);
         //exit;
         DB::beginTransaction();
         try {
             $db_name = "mercadorepuesto_sys";
                 
        $infousuario = DB::connection($this->cur_connect)->select(
                                                "select t0.uid, t0.email
                                                from ".$db_name.'.users'." t0 
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
             'infousuario' => $infousuario,
             'message' => 'REGISTRO EXITOSO',
         );
         $rec->headers->set('Accept', 'application/json');
         echo json_encode($response);
         exit;
    }
    
    public function mrpCategoriasxxxx($rec)
    {
        $db_name = "categorias";
        $productos = DB::connection($this->cur_connect)->select("select t0.*,t1.stock from ".$db_name.'.stkarticulos'." t0 JOIN ".$db_name.'.v_stock'." t1 ON t0.art_id = t1.art_id WHERE t0.id_wc = 0");

        echo json_encode($productos);
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

        $db_name = "mercadorepuesto_sys";

        $marcasvehiculos = DB::connection($this->cur_connect)->select("select t0.* from ".$db_name.'.marcas'." t0 WHERE tipovehiculo = ". $rec->idvehiculo);

        echo json_encode($marcasvehiculos);
    }

    public function readVersionMotor($rec)
    {
        //echo json_encode($rec->idvehiculo);
        //exit;
        $db_name = "mercadorepuesto_sys";
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

    //Lee Productos Unicos de la Base de Datos de productos
    public function getProductsUnique($rec)
    {
        ////////////////////////////////////////////////
        /// INICIO DE FOREACH DE VEHICULOS COMPATIBLES
        ///////////////////////////////////////////////
        $db_name = "mercadorepuesto_sys";
        $aKeyword = explode(" ", $rec->name_contains);
         
        $querycompatibles = "select DISTINCT t0.id, t0.*,
            t0.idproductovehiculo as idproducto,
            t1.text AS marca,
            t1.id AS id_marca,
            t2.id AS id_modelos,
            t2.modelo AS modelos,
            t7.nombre AS condicion
            from ".$db_name.'.productos'." t0
            JOIN ".$db_name.'.marcas'." t1 ON t0.marca = t1.id
            JOIN ".$db_name.'.tiposvehiculos'." t3 ON t0.tipovehiculo = t3.id
             JOIN ".$db_name.'.modelos'." t2 ON t0.modelo = t2.id
             JOIN ".$db_name.'.tiposcarrocerias'." t4 ON t0.carroceria = t4.id
             JOIN ".$db_name.'.anosvehiculos'." t5 ON t0.anno = t5.id
             JOIN ".$db_name.'.versionmotor'." t6 ON t0.cilindrajemotor = t6.id
             JOIN ".$db_name.'.condicion'." t7 ON t0.condicion = t7.id
             WHERE t3.id = t1.tipovehiculo &&
                   (t1.text LIKE '%".$aKeyword[0]."%' ||
                    t0.titulonombre LIKE '%".$aKeyword[0]."%' ||
                    t0.marcarepuesto LIKE '%".$aKeyword[0]."%' ||
                    t0.numerodeparte LIKE '%".$aKeyword[0]."%' ||
                    t6.cilindraje = '".$aKeyword[0]."' ||
                    t3.text LIKE '%".$aKeyword[0]."%' ||
                    t7.nombre LIKE '%".$aKeyword[0]."%' ||
                    t4.carroceria LIKE '%".$aKeyword[0]."%' ||
                    t5.anovehiculo LIKE '%".$aKeyword[0]."%' ||
                    t2.modelo LIKE '%".$aKeyword[0]."%')  ";
                    
         $nameproducts = DB::connection($this->cur_connect)->select($querycompatibles);
         $numreg = 0;
         //////////////////////////////////////////////////////////////////////////////////////////////
         /// Elimina registros de la tabla de productos comapatibles solo para busquedas relacionadas
         /////////////////////////////////////////////////////////////////////////////////////////////
 
         $rec->headers->set('Accept', 'application/json');
         echo json_encode($nameproducts);
         exit;
     } 

    //Lee Productos de la Base de Datos
    public function getNameProducts($rec)
    {
        ////////////////////////////////////////////////
        /// INICIO DE FOREACH DE VEHICULOS COMPATIBLES
        ///////////////////////////////////////////////
        $db_name = "mercadorepuesto_sys";
        $aKeyword = explode(" ", $rec->name_contains);
        
        $querycompatibles = "select DISTINCT t0.id, t0.*,
            t0.idproductovehiculo as idproducto,
            t1.text AS marca,
            t1.id AS id_marca,
            t2.id AS id_modelos,
            t2.modelo AS modelos,
            t7.nombre AS condicion
            from ".$db_name.'.productos'." t0
            JOIN ".$db_name.'.marcas'." t1 ON t0.marca = t1.id
            JOIN ".$db_name.'.tiposvehiculos'." t3 ON t0.tipovehiculo = t3.id
            JOIN ".$db_name.'.modelos'." t2 ON t0.modelo = t2.id
            JOIN ".$db_name.'.tiposcarrocerias'." t4 ON t0.carroceria = t4.id
            JOIN ".$db_name.'.anosvehiculos'." t5 ON t0.anno = t5.id
            JOIN ".$db_name.'.versionmotor'." t6 ON t0.cilindrajemotor = t6.id
            JOIN ".$db_name.'.condicion'." t7 ON t0.condicion = t7.id
            WHERE t3.id = t1.tipovehiculo &&
                  (t1.text LIKE '%".$aKeyword[0]."%' ||
                   t0.titulonombre LIKE '%".$aKeyword[0]."%' ||
                   t0.marcarepuesto LIKE '%".$aKeyword[0]."%' ||
                   t0.numerodeparte LIKE '%".$aKeyword[0]."%' ||
                   t6.cilindraje = '".$aKeyword[0]."' ||
                   t3.text LIKE '%".$aKeyword[0]."%' ||
                   t7.nombre LIKE '%".$aKeyword[0]."%' ||
                   t4.carroceria LIKE '%".$aKeyword[0]."%' ||
                   t5.anovehiculo LIKE '%".$aKeyword[0]."%' ||
                   t2.modelo LIKE '%".$aKeyword[0]."%')  ";

        $nameproducts = DB::connection($this->cur_connect)->select($querycompatibles);
        $numreg = 0;
        //////////////////////////////////////////////////////////////////////////////////////////////
        /// Elimina registros de la tabla de productos comapatibles solo para busquedas relacionadas
        /////////////////////////////////////////////////////////////////////////////////////////////

        $rec->headers->set('Accept', 'application/json');
        echo json_encode($nameproducts);
        exit;
    }

    // Lee productos creados en la DB Local
    public function listarProductosDB($rec)
    {
        //echo json_encode($rec->idinterno);
        //exit;
        DB::beginTransaction();
        try {
            $db_name = "mercadorepuesto_sys";
                
        $listarproductosbd = DB::connection($this->cur_connect)->select(
                                                "select t0.*, t1.*, t0.id as idprd, t2.nombre as nombreestado,
                                                TRUNCATE(((DATEDIFF(NOW(), t0.fechaactualizacion))),1) AS tiempoestado
                                                from ".$db_name.'.productos'." t0
                                                JOIN ".$db_name.'.users'." t1 ON t0.usuario = t1.uid
                                                JOIN ".$db_name.'.estados'." t2 ON t0.estado = t2.tipodeestado");

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
            'listarproductosbd' => $listarproductosbd,
            'message' => 'REGISTRO EXITOSO',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    // Cantidad de productos publicados por ciudad
    public function listarCantidadPrdCiudad($rec)
    {
        //echo json_encode($rec->idinterno);
        //exit;
        DB::beginTransaction();
        try {
            $db_name = "mercadorepuesto_sys";
                
        $cantidadprdciudad = DB::connection($this->cur_connect)->select(
                                                "SELECT t0.ciudad, COUNT(*) AS productosciudad, t1.nombre_ciu
                                                from ".$db_name.'.productos'." t0
                                                JOIN ".$db_name.'.ciudades'." t1 ON t0.ciudad = t1.id_ciu
                                                GROUP BY t0.ciudad, t1.nombre_ciu");

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
            'cantidadprdciudad' => $cantidadprdciudad,
            'message' => 'REGISTRO EXITOSO',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;

    }

    // Cantidad de productos publicados por ciudad
    public function listarVehiculosCompatabibles($rec, $parametro)
    {
        //echo json_encode($rec->idinterno);
        //exit;
        DB::beginTransaction();
        try {
            $db_name = "mercadorepuesto_sys";
            $idprd = explode(" ", $rec->idproducto);
                
        $vehiculoscomp = DB::connection($this->cur_connect)->select(
                                                "select DISTINCT t0.id, t0.*, t1.text as marcaveh,
                                                t2.modelo as modeloveh, t6.cilindraje as cilindraje,
                                                t6.id as id_cilindraje, t4.carroceria as nombrecarroceria,
                                                t0.idproductovehiculo as idproducto, t5.anovehiculo,
                                                t3.tipo as nombretipoveh,
                                                t1.text AS marca,
                                                t1.id AS id_marca,
                                                t2.id AS id_modelos,
                                                t2.modelo AS modelos,
                                                t7.nombre AS condicion
                                                from ".$db_name.'.vehiculosproducto'." t0
                                                JOIN ".$db_name.'.marcas'." t1 ON t0.marca = t1.id
                                                JOIN ".$db_name.'.tiposvehiculos'." t3 ON t0.tipovehiculo = t3.id
                                                JOIN ".$db_name.'.modelos'." t2 ON t0.modelo = t2.id
                                                JOIN ".$db_name.'.tiposcarrocerias'." t4 ON t0.carroceria = t4.id
                                                JOIN ".$db_name.'.anosvehiculos'." t5 ON t0.anno = t5.id
                                                JOIN ".$db_name.'.versionmotor'." t6 ON t0.cilindraje = t6.id
                                                JOIN ".$db_name.'.condicion'." t7 ON t0.condicion = t7.id
                                                WHERE t0.idproductovehiculo = ".$rec->idproducto);

                                                // WHERE t0.idproductovehiculo = ". $rec->idproducto);

        //echo json_encode($vehiculoscomp);
        //exit;                     

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
            'vehiculoscomp' => $vehiculoscomp,
            'message' => 'REGISTRO EXITOSO',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    public function listarPosicionProducto($rec)
    {
        DB::beginTransaction();
        try {
            $db_name = "mercadorepuesto_sys";
                
        $listarposicionprd = DB::connection($this->cur_connect)->select(
                                                "select t0.* 
                                                from ".$db_name.'.posicionproducto'." t0
                                                ORDER BY codigo ASC");

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
            'listarposicionprd' => $listarposicionprd,
            'message' => 'REGISTRO EXITOSO',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    //Lee Productos de la Base de Datos
    public function listarProductos($rec, $parametro)
    {
        $query = "select DISTINCT t0.id, t0.*,
            t0.id as idproducto,
            t1.text AS marca,
            t1.id AS id_marca,
            t2.id AS id_modelos,
            t2.modelo AS modelos,
            t7.nombre AS condicion,
            t5.anovehiculo AS anovehiculo,
            t0.condicion AS condicionprd,
            t8.nombre_ciu AS nombreciudad
            from ".$db_name.'.productos'." t0
            JOIN ".$db_name.'.marcas'." t1 ON t0.marca = t1.id
            JOIN ".$db_name.'.tiposvehiculos'." t3 ON t0.tipovehiculo = t3.id
            JOIN ".$db_name.'.modelos'." t2 ON t0.modelo = t2.id
            JOIN ".$db_name.'.tiposcarrocerias'." t4 ON t0.carroceria = t4.id
            JOIN ".$db_name.'.anosvehiculos'." t5 ON t0.anno = t5.id
            JOIN ".$db_name.'.versionmotor'." t6 ON t0.cilindrajemotor = t6.id
            JOIN ".$db_name.'.condicion'." t7 ON t0.condicion = t7.id
            JOIN ".$db_name.'.ciudades'." t8 ON t0.ciudad = t8.id_ciu
            WHERE (t0.estado = 11 || t0.estado = 31) && t3.id = t1.tipovehiculo";
                
        $productos = DB::connection($this->cur_connect)->select($query);
        echo json_encode($productos);
        exit;
        
        $product = array();

        $rec->headers->set('Accept', 'application/json');
        echo json_encode($product);
        exit;
    }

    //Lee Productos de la Base de Datos
    public function getProducts($rec, $parametro)
    {
        ////////////////////////////////////////////////
        /// INICIO DE FOREACH DE VEHICULOS COMPATIBLES
        ///////////////////////////////////////////////
        $db_name = "mercadorepuesto_sys";
        $aKeyword = explode(" ", $rec->name_contains);
        
        $querycompatibles = "select DISTINCT t0.id, t0.*,
            t0.idproductovehiculo as idproducto,
            t1.text AS marca,
            t1.id AS id_marca,
            t2.id AS id_modelos,
            t2.modelo AS modelos,
            t7.nombre AS condicion
            from ".$db_name.'.vehiculosproducto'." t0
            JOIN ".$db_name.'.marcas'." t1 ON t0.marca = t1.id
            JOIN ".$db_name.'.tiposvehiculos'." t3 ON t0.tipovehiculo = t3.id
            JOIN ".$db_name.'.modelos'." t2 ON t0.modelo = t2.id
            JOIN ".$db_name.'.tiposcarrocerias'." t4 ON t0.carroceria = t4.id
            JOIN ".$db_name.'.anosvehiculos'." t5 ON t0.anno = t5.id
            JOIN ".$db_name.'.versionmotor'." t6 ON t0.cilindraje = t6.id
            JOIN ".$db_name.'.condicion'." t7 ON t0.condicion = t7.id
            WHERE  t3.id = t1.tipovehiculo &&
                  (t1.text LIKE '%".$aKeyword[0]."% COLLATE utf8_bin' ||
                   t0.titulonombre LIKE '%".$aKeyword[0]."% COLLATE utf8_bin' ||
                   t0.marcarepuesto LIKE '%".$aKeyword[0]."% COLLATE utf8_bin' ||
                   t0.numerodeparte LIKE '%".$aKeyword[0]."% COLLATE utf8_bin' ||
                   t6.cilindraje = '".$aKeyword[0]." COLLATE utf8_bin' ||
                   t3.text LIKE '%".$aKeyword[0]."% COLLATE utf8_bin' ||
                   t7.nombre LIKE '%".$aKeyword[0]."% COLLATE utf8_bin' ||
                   t4.carroceria LIKE '%".$aKeyword[0]."% COLLATE utf8_bin' ||
                   t5.anovehiculo LIKE '%".$aKeyword[0]."% COLLATE utf8_bin' ||
                   t2.modelo LIKE '%".$aKeyword[0]."%')  ";
/*
                   for($i = 1; $i < count($aKeyword); $i++) {
                    if(!empty($aKeyword[$i])) {
                        $query .= " OR (t1.text LIKE '%".$aKeyword[$i]."%' ||
                        t0.titulonombre LIKE '%".$aKeyword[$i]."%' ||
                        t2.modelo LIKE '%".$aKeyword[$i]."%')";
                    }
                  }
*/
        $idproductos = DB::connection($this->cur_connect)->select($querycompatibles);

        $numreg = 0;
        //////////////////////////////////////////////////////////////////////////////////////////////
        /// Elimina registros de la tabla de productos comapatibles solo para busquedas relacionadas
        /////////////////////////////////////////////////////////////////////////////////////////////
       
        $db_name = $this->db.".productoscompatibles";
        DB::connection($this->cur_connect)->delete("DELETE FROM ".$db_name);

        foreach($idproductos as $idproducto) {
            $numreg = $numreg + 1; 
            $prdCompatibles = new ModelGlobal();
            $prdCompatibles->setConnection($this->cur_connect);
            $prdCompatibles->setTable($db_name);
                    
            $prdCompatibles->idproducto = $idproducto ->idproductovehiculo;
                    
            $prdCompatibles->save();
        }
        //echo json_encode($numreg);
        //exit;

        $codigosproducto = array();

        for ($i = 0; $i < $numreg; $i++) {
            $codprd = $idproductos[$i]->idproductovehiculo;
            $menosuno = $i-1;
            
            if($i == 0) {
                $codigosproducto[$i] = $codprd;
            }

            if($i > 0) {
                if($idproductos[$menosuno]->idproductovehiculo != $codprd) {
                    $codigosproducto[$i] = $codprd;
                }
            }
        }

        $prdselect = array();
        $sqlarmado = "";
        foreach($codigosproducto as $codigoprd) {
            $sqlarmado .= " t0.idproductovehiculo LIKE '%".$codigoprd."%' || ";
        }

        //foreach($prdselect as $prd) {
            //echo json_encode($prd); 
        //}
        /////////////////////////////////////////////
        /// TERMINA FOREACH DE VEHICULOS COMPATIBLES
        /////////////////////////////////////////////

        //////////////////////////////////
        /// INICIO DE FOREACH DE PRODUCTOS
        //////////////////////////////////
        $db_name = "mercadorepuesto_sys";
        $url_img = '/files/mercadorepuesto/';
        //$variable = json_decode($parametro);
        //echo $rec;
        //exit;
        $aKeyword = explode(" ", $rec->name_contains);

        //echo json_encode($aKeyword);
        //exit;
       
        $query = "select DISTINCT t0.id, t0.*,
            t0.id as idproducto,
            t1.text AS marca,
            t1.id AS id_marca,
            t2.id AS id_modelos,
            t2.modelo AS modelos,
            t7.nombre AS condicion,
            t5.anovehiculo AS anovehiculo,
            t0.condicion AS condicionprd,
            t8.nombre_ciu AS nombreciudad,
            t9.email as emailvendedor
            from ".$db_name.'.productos'." t0
            JOIN ".$db_name.'.marcas'." t1 ON t0.marca = t1.id
            JOIN ".$db_name.'.tiposvehiculos'." t3 ON t0.tipovehiculo = t3.id
            JOIN ".$db_name.'.modelos'." t2 ON t0.modelo = t2.id
            JOIN ".$db_name.'.tiposcarrocerias'." t4 ON t0.carroceria = t4.id
            JOIN ".$db_name.'.anosvehiculos'." t5 ON t0.anno = t5.id
            JOIN ".$db_name.'.versionmotor'." t6 ON t0.cilindrajemotor = t6.id
            JOIN ".$db_name.'.condicion'." t7 ON t0.condicion = t7.id
            JOIN ".$db_name.'.ciudades'." t8 ON t0.ciudad = t8.id_ciu
            JOIN ".$db_name.'.users'." t9 ON t0.usuario = t9.uid
            WHERE (t0.estado = 11 || t0.estado = 31) && 
                  t3.id = t1.tipovehiculo &&
                 (t1.text LIKE '%".$aKeyword[0]."%' ||
                  t0.titulonombre LIKE '%".$aKeyword[0]."%' ||
                  t0.descripcionproducto LIKE '%".$aKeyword[0]."%' ||
                  t0.marcarepuesto LIKE '%".$aKeyword[0]."%' ||
                  t0.numerodeparte LIKE '%".$aKeyword[0]."%' ||
                  t6.cilindraje = '".$aKeyword[0]."' ||
                  t3.text LIKE '%".$aKeyword[0]."%' ||
                  t7.nombre LIKE '%".$aKeyword[0]."%' ||
                  ".$sqlarmado."
                  t4.carroceria LIKE '%".$aKeyword[0]."%' ||
                  t5.anovehiculo LIKE '%".$aKeyword[0]."%')  ";

                  for($i = 1; $i < count($aKeyword); $i++) {
                   if(!empty($aKeyword[$i])) {
                       $query .= " OR (t1.text LIKE '%".$aKeyword[$i]."%' ||
                       t0.titulonombre LIKE '%".$aKeyword[$i]."%' ||
                       t7.nombre LIKE '%".$aKeyword[$i]."%' ||
                       t2.modelo LIKE '%".$aKeyword[$i]."%')";
                   }
                 }

                
        $productos = DB::connection($this->cur_connect)->select($query);

        //echo json_encode($productos);
        //exit;
        
        /*echo "select t0.*,
            t0.id as idproducto,
            t1.text AS marca,
            t1.id AS id_marca,
            t2.id AS id_modelos,
            t2.modelo AS modelos
            from ".$db_name.'.productos'." t0
            JOIN ".$db_name.'.marcas'." t1 ON t0.marca = t1.id
            JOIN ".$db_name.'.tiposvehiculos'." t3 ON t0.tipovehiculo = t3.id
            JOIN ".$db_name.'.modelos'." t2 ON t0.modelo = t2.id
            WHERE t3.id = t1.tipovehiculo &&
                  (t1.text LIKE '%".$rec->name_contains."%' ||
                   t0.titulonombre LIKE '%".$rec->name_contains."%' ||
                   t2.modelo LIKE '%".$rec->name_contains."%')  ";
        exit;
        */
         //t0.titulonombre LIKE '%".$rec->name_contains."%'

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

        for ($i = 1; $i <= $producto->numerodeimagenes; $i++) {
 
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


        $modelos = DB::connection($this->cur_connect)->select("select t0.* FROM ".$db_name.'.modelos'." t0
            WHERE t0.marca = '".$producto->id_marca."' ORDER BY marca ASC");
        foreach($modelos as $modelo) {
        $cat_pro = array('id' => $modelo->id,
                         'name' => $modelo->modelo,
                         'slug' => $this->string2url($modelo->modelo),
                         'created_at' => '2021-06-12T08:53:06.932Z',
                         'updated_at' => date("Y-m-d").'T08:53:06.943Z');
        $product_categories[] = $cat_pro;
        }

        // Inicio Foreach Marcas
        $brand = array('id' => $producto->id_marca,
                       'name' => $producto->marca,
                       'slug' => $this->string2url($producto->marca),
                       'created_at' => date("Y-m-d").'T10:56:52.945Z',
                        'updated_at' => date("Y-m-d").'T10:58:02.351Z');
        $product_brands[] = $brand;
        // Fin Foreach Marcas

        // Imagenes

            $datoproduct = [
            'estadopublicacion' => $producto->estado,
            'id' => $producto->idproducto,
            'fechacreacion' => $producto->fechacreacion,
            'name' => $producto->titulonombre,
            'marca' => $producto->marca,
            'modelos' => $producto->modelos,
            'condicion' => $producto->condicion,
            'condition' => $producto->condicionprd,
            'nombreciudad' => $producto->nombreciudad,
            'estadoproducto' => $producto->estadoproducto,
            'marcarepuesto' => $producto->marcarepuesto,
            'tipovehiculo' => $producto->tipovehiculo,
            'anovehiculo' => $producto->anovehiculo,
            'ciudad'=> $producto->ciudad,
            'descripcionproducto' => $producto->descripcionproducto,
            'posicionproducto' => $producto->posicionproducto,
            'numerodeparte' => $producto->numerodeparte,
            'funcionalidad' => $producto->funcionalidad,
            'compatible' => $producto->compatible,
            'usuario' => $producto->usuario,
            'emailvendedor' => $producto->emailvendedor,
            'peso' => $producto->peso,
            'largo' => $producto->largo,
            'ancho' => $producto->ancho,
            'alto' => $producto->alto,
            'genericos' => 'no',
            //'productogenerico' => $producto->productogenerico,
            'productogenerico' => 'No',
            'featured' => false,
            'price' => $producto->precio,
            'sale_price' => $producto->precio,
            'numerounidades' => $producto->numerodeunidades,
            'on_sale' => true,
            'slug' => $this->string2url($producto->titulonombre),
            'is_stock' => true,
            'rating_count' => 9,
            'description' => $producto->descripcionproducto,
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

    //Lee Productos de la Base de Datos
    public function getProductsCategory($rec, $parametro)
    {
        ////////////////////////////////////////////////
        /// INICIO DE FOREACH DE VEHICULOS COMPATIBLES
        ///////////////////////////////////////////////
        $db_name = "mercadorepuesto_sys";
        $aKeyword = explode(" ", $rec->name_contains);
        $posPrd = $rec->posicionprd;
        //echo json_encode($posPrd);
        //exit;
        //return
        
        $querycompatibles = "select DISTINCT t0.id, t0.*,
            t0.idproductovehiculo as idproducto,
            t1.text AS marca,
            t1.id AS id_marca,
            t2.id AS id_modelos,
            t2.modelo AS modelos,
            t7.nombre AS condicion
            from ".$db_name.'.vehiculosproducto'." t0
            JOIN ".$db_name.'.marcas'." t1 ON t0.marca = t1.id
            JOIN ".$db_name.'.tiposvehiculos'." t3 ON t0.tipovehiculo = t3.id
            JOIN ".$db_name.'.modelos'." t2 ON t0.modelo = t2.id
            JOIN ".$db_name.'.tiposcarrocerias'." t4 ON t0.carroceria = t4.id
            JOIN ".$db_name.'.anosvehiculos'." t5 ON t0.anno = t5.id
            JOIN ".$db_name.'.condicion'." t7 ON t0.condicion = t7.id
            WHERE  t3.id = t1.tipovehiculo &&
                  (t1.text LIKE '%".$aKeyword[0]."%' ||
                   t0.titulonombre LIKE '%".$aKeyword[0]."%' ||
                   t0.posicionproducto = '".$posPrd."' ||
                   t0.marcarepuesto LIKE '%".$aKeyword[0]."%' ||
                   t0.numerodeparte LIKE '%".$aKeyword[0]."%' ||
                   t3.text LIKE '%".$aKeyword[0]."%' ||
                   t7.nombre LIKE '%".$aKeyword[0]."%' ||
                   t4.carroceria LIKE '%".$aKeyword[0]."%' ||
                   t5.anovehiculo LIKE '%".$aKeyword[0]."%' ||
                   t2.modelo LIKE '%".$aKeyword[0]."%')  ";
        
        $idproductos = DB::connection($this->cur_connect)->select($querycompatibles);

        $numreg = 0;
        //////////////////////////////////////////////////////////////////////////////////////////////
        /// Elimina registros de la tabla de productos comapatibles solo para busquedas relacionadas
        /////////////////////////////////////////////////////////////////////////////////////////////
       
        $db_name = $this->db.".productoscompatibles";
        DB::connection($this->cur_connect)->delete("DELETE FROM ".$db_name);

        foreach($idproductos as $idproducto) {
            $numreg = $numreg + 1; 
            $prdCompatibles = new ModelGlobal();
            $prdCompatibles->setConnection($this->cur_connect);
            $prdCompatibles->setTable($db_name);
                    
            $prdCompatibles->idproducto = $idproducto ->idproductovehiculo;
                    
            $prdCompatibles->save();
        }
        //echo json_encode($numreg);
        //exit;

        $codigosproducto = array();

        for ($i = 0; $i < $numreg; $i++) {
            $codprd = $idproductos[$i]->idproductovehiculo;
            $menosuno = $i-1;
            
            if($i == 0) {
                $codigosproducto[$i] = $codprd;
            }

            if($i > 0) {
                if($idproductos[$menosuno]->idproductovehiculo != $codprd) {
                    $codigosproducto[$i] = $codprd;
                }
            }
        }

        $prdselect = array();
        $sqlarmado = "";
        foreach($codigosproducto as $codigoprd) {
            $sqlarmado .= " t0.idproductovehiculo LIKE '%".$codigoprd."%' || ";
        }

        //foreach($prdselect as $prd) {
            //echo json_encode($prd); 
        //}
        /////////////////////////////////////////////
        /// TERMINA FOREACH DE VEHICULOS COMPATIBLES
        /////////////////////////////////////////////

        //////////////////////////////////
        /// INICIO DE FOREACH DE PRODUCTOS
        //////////////////////////////////
        $db_name = "mercadorepuesto_sys";
        $url_img = '/files/mercadorepuesto/';
        //$variable = json_decode($parametro);
        //echo $rec;
        //exit;
        $aKeyword = explode(" ", $rec->name_contains);

        //JOIN ".$db_name.'.versionmotor'." t6 ON t0.cilindrajemotor = t6.id
        // t6.cilindraje = '".$aKeyword[0]."' ||
                 
        $query = "select DISTINCT t0.id, t0.*,
            t0.id as idproducto,
            t1.text AS marca,
            t1.id AS id_marca,
            t2.id AS id_modelos,
            t2.modelo AS modelos,
            t7.nombre AS condicion,
            t5.anovehiculo AS anovehiculo,
            t0.condicion AS condicionprd,
            t8.nombre_ciu AS nombreciudad,
            t9.email as emailvendedor
            from ".$db_name.'.productos'." t0
            JOIN ".$db_name.'.marcas'." t1 ON t0.marca = t1.id
            JOIN ".$db_name.'.tiposvehiculos'." t3 ON t0.tipovehiculo = t3.id
            JOIN ".$db_name.'.modelos'." t2 ON t0.modelo = t2.id
            JOIN ".$db_name.'.tiposcarrocerias'." t4 ON t0.carroceria = t4.id
            JOIN ".$db_name.'.anosvehiculos'." t5 ON t0.anno = t5.id
            JOIN ".$db_name.'.condicion'." t7 ON t0.condicion = t7.id
            JOIN ".$db_name.'.ciudades'." t8 ON t0.ciudad = t8.id_ciu
            JOIN ".$db_name.'.users'." t9 ON t0.usuario = t9.uid
            WHERE (t0.estado = 11 || t0.estado = 31) &&
                  t3.id = t1.tipovehiculo &&
                 (t1.text LIKE '%".$aKeyword[0]."%' ||
                  t0.titulonombre LIKE '%".$aKeyword[0]."%' ||
                  t0.descripcionproducto LIKE '%".$aKeyword[0]."%' ||
                  t0.marcarepuesto LIKE '%".$aKeyword[0]."%' ||
                  t0.posicionproducto = '".$posPrd."' ||
                  t0.numerodeparte LIKE '%".$aKeyword[0]."%' ||
                  t3.text LIKE '%".$aKeyword[0]."%' ||
                  t7.nombre LIKE '%".$aKeyword[0]."%' ||
                  ".$sqlarmado."
                  t4.carroceria LIKE '%".$aKeyword[0]."%' ||
                  t5.anovehiculo LIKE '%".$aKeyword[0]."%')  ";

                  for($i = 1; $i < count($aKeyword); $i++) {
                   if(!empty($aKeyword[$i])) {
                       $query .= " OR (t1.text LIKE '%".$aKeyword[$i]."%' ||
                       t0.titulonombre LIKE '%".$aKeyword[$i]."%' ||
                       t7.nombre LIKE '%".$aKeyword[$i]."%' ||
                       t2.modelo LIKE '%".$aKeyword[$i]."%')";
                   }
                 }
 
        $productos = DB::connection($this->cur_connect)->select($query);

        //echo json_encode($productos);
        //exit;
       
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

        for ($i = 1; $i <= $producto->numerodeimagenes; $i++) {
 
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


        $modelos = DB::connection($this->cur_connect)->select("select t0.* FROM ".$db_name.'.modelos'." t0
            WHERE t0.marca = '".$producto->id_marca."' ORDER BY marca ASC");
        foreach($modelos as $modelo) {
        $cat_pro = array('id' => $modelo->id,
                         'name' => $modelo->modelo,
                         'slug' => $this->string2url($modelo->modelo),
                         'created_at' => '2021-06-12T08:53:06.932Z',
                         'updated_at' => date("Y-m-d").'T08:53:06.943Z');
        $product_categories[] = $cat_pro;
        }

        // Inicio Foreach Marcas
        $brand = array('id' => $producto->id_marca,
                       'name' => $producto->marca,
                       'slug' => $this->string2url($producto->marca),
                       'created_at' => date("Y-m-d").'T10:56:52.945Z',
                        'updated_at' => date("Y-m-d").'T10:58:02.351Z');
        $product_brands[] = $brand;
        // Fin Foreach Marcas

        // Imagenes

            $datoproduct = [
            'estadopublicacion' => $producto->estado,
            'id' => $producto->idproducto,
            'fechacreacion' => $producto->fechacreacion,
            'name' => $producto->titulonombre,
            'marca' => $producto->marca,
            'modelos' => $producto->modelos,
            'condicion' => $producto->condicion,
            'condition' => $producto->condicionprd,
            'nombreciudad' => $producto->nombreciudad,
            'estadoproducto' => $producto->estadoproducto,
            'marcarepuesto' => $producto->marcarepuesto,
            'tipovehiculo' => $producto->tipovehiculo,
            'anovehiculo' => $producto->anovehiculo,
            'ciudad'=> $producto->ciudad,
            'descripcionproducto' => $producto->descripcionproducto,
            'posicionproducto' => $producto->posicionproducto,
            'numerodeparte' => $producto->numerodeparte,
            'funcionalidad' => $producto->funcionalidad,
            'compatible' => $producto->compatible,
            'usuario' => $producto->usuario,
            'emailvendedor' => $producto->emailvendedor,
            'peso' => $producto->peso,
            'largo' => $producto->largo,
            'ancho' => $producto->ancho,
            'alto' => $producto->alto,
            'genericos' => 'no',
            //'productogenerico' => $producto->productogenerico,
            'productogenerico' => 'No',
            'featured' => false,
            'price' => $producto->precio,
            'sale_price' => $producto->precio,
            'numerounidades' => $producto->numerodeunidades,
            'on_sale' => true,
            'slug' => $this->string2url($producto->titulonombre),
            'is_stock' => true,
            'rating_count' => 9,
            'description' => $producto->descripcionproducto,
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

    //Lee Productos de la Base de Datos
    public function getProductsCategoryGaraje($rec, $parametro)
    {
        ////////////////////////////////////////////////
        /// INICIO DE FOREACH DE VEHICULOS COMPATIBLES
        ///////////////////////////////////////////////
        $db_name = "mercadorepuesto_sys";
        //$aKeyword = explode(" ", $rec->name_contains);
        $posPrd = $rec->posicionprd;
        $carroceria = $rec->carroceria;
        $marca = $rec->marca;
        $cilindraje = $rec->cilindraje;
        $combustible = $rec->combustible;
        $modelo = $rec->modelo;
        $traccion = $rec->traccion;
        $transmision = $rec->transmision;
        $tipo = $rec->tipo;
        $anno = $rec->anno;
        //echo json_encode($posPrd);
        //echo json_encode($carroceria);
        //echo json_encode($marca);
        //echo json_encode($cilindraje);
        //echo json_encode($modelo);
        //exit;
        //return
        
        $querycompatibles = "select DISTINCT t0.id, t0.*,
            t0.idproductovehiculo as idproducto,
            t1.text AS marca,
            t1.id AS id_marca,
            t2.id AS id_modelos,
            t2.modelo AS modelos,
            t7.nombre AS condicion
            from ".$db_name.'.vehiculosproducto'." t0
            JOIN ".$db_name.'.marcas'." t1 ON t0.marca = t1.id
            JOIN ".$db_name.'.tiposvehiculos'." t3 ON t0.tipovehiculo = t3.id
            JOIN ".$db_name.'.modelos'." t2 ON t0.modelo = t2.id
            JOIN ".$db_name.'.tiposcarrocerias'." t4 ON t0.carroceria = t4.id
            JOIN ".$db_name.'.anosvehiculos'." t5 ON t0.anno = t5.id
            JOIN ".$db_name.'.condicion'." t7 ON t0.condicion = t7.id
            WHERE  t3.id = t1.tipovehiculo 
               &&  t0.tipovehiculo = '".$tipo."'
               &&  t0.carroceria = '".$carroceria."'
               &&  t0.marca = '".$marca."'
               &&  t0.modelo = '".$modelo."'
               &&  t0.anno = '".$anno."'
               &&  t0.cilindraje = '".$cilindraje."'
               &&  t0.combustible = '".$combustible."'
               &&  t0.transmision = '".$transmision."'
               &&  t0.traccion = '".$traccion."'
               ";
        
        $idproductos = DB::connection($this->cur_connect)->select($querycompatibles);

        //echo json_encode($idproductos);
        //exit;
        //return

        $numreg = 0;
        //////////////////////////////////////////////////////////////////////////////////////////////
        /// Elimina registros de la tabla de productos comapatibles solo para busquedas relacionadas
        /////////////////////////////////////////////////////////////////////////////////////////////
       
        $db_name = $this->db.".productoscompatibles";
        DB::connection($this->cur_connect)->delete("DELETE FROM ".$db_name);

        foreach($idproductos as $idproducto) {
            $numreg = $numreg + 1; 
            $prdCompatibles = new ModelGlobal();
            $prdCompatibles->setConnection($this->cur_connect);
            $prdCompatibles->setTable($db_name);
                    
            $prdCompatibles->idproducto = $idproducto ->idproductovehiculo;
                    
            $prdCompatibles->save();
        }
        //echo json_encode($numreg);
        //exit;

        $codigosproducto = array();

        for ($i = 0; $i < $numreg; $i++) {
            $codprd = $idproductos[$i]->idproductovehiculo;
            $menosuno = $i-1;
            
            if($i == 0) {
                $codigosproducto[$i] = $codprd;
            }

            if($i > 0) {
                if($idproductos[$menosuno]->idproductovehiculo != $codprd) {
                    $codigosproducto[$i] = $codprd;
                }
            }
        }

        //echo json_encode($codigosproducto);
        //exit;


        $prdselect = array();
        $sqlarmado = "";
        foreach($codigosproducto as $codigoprd) {
            $sqlarmado .= " t0.idproductovehiculo LIKE '%".$codigoprd."%' || ";
        }

        //foreach($prdselect as $prd) {
            //echo json_encode($prd); 
        //}
        /////////////////////////////////////////////
        /// TERMINA FOREACH DE VEHICULOS COMPATIBLES
        /////////////////////////////////////////////

        //////////////////////////////////
        /// INICIO DE FOREACH DE PRODUCTOS
        //////////////////////////////////
        $db_name = "mercadorepuesto_sys";
        $url_img = '/files/mercadorepuesto/';
        //$variable = json_decode($parametro);
        //echo $rec;
        //exit;
        $aKeyword = explode(" ", $rec->name_contains);

        //JOIN ".$db_name.'.versionmotor'." t6 ON t0.cilindrajemotor = t6.id
        // t6.cilindraje = '".$aKeyword[0]."' ||
                 
        $query = "select DISTINCT t0.id, t0.*,
            t0.id as idproducto,
            t1.text AS marca,
            t1.id AS id_marca,
            t2.id AS id_modelos,
            t2.modelo AS modelos,
            t7.nombre AS condicion,
            t5.anovehiculo AS anovehiculo,
            t0.condicion AS condicionprd,
            t8.nombre_ciu AS nombreciudad,
            t9.email as emailvendedor
            from ".$db_name.'.productos'." t0
            JOIN ".$db_name.'.marcas'." t1 ON t0.marca = t1.id
            JOIN ".$db_name.'.tiposvehiculos'." t3 ON t0.tipovehiculo = t3.id
            JOIN ".$db_name.'.modelos'." t2 ON t0.modelo = t2.id
            JOIN ".$db_name.'.tiposcarrocerias'." t4 ON t0.carroceria = t4.id
            JOIN ".$db_name.'.anosvehiculos'." t5 ON t0.anno = t5.id
            JOIN ".$db_name.'.condicion'." t7 ON t0.condicion = t7.id
            JOIN ".$db_name.'.ciudades'." t8 ON t0.ciudad = t8.id_ciu
            JOIN ".$db_name.'.users'." t9 ON t0.usuario = t9.uid
            WHERE (t0.estado = 11 || t0.estado = 31)
                  &&  t0.tipovehiculo = '".$tipo."'
                  &&  t0.carroceria = '".$carroceria."'
                  &&  t0.marca = '".$marca."'
                  &&  t0.modelo = '".$modelo."'
                  &&  t0.anno = '".$anno."'
                  &&  t0.cilindrajemotor = '".$cilindraje."'
                  &&  t0.tipocombustible = '".$combustible."'
                  &&  t0.transmision = '".$transmision."'
                  &&  t0.tipotraccion = '".$traccion."'  
                 ";

 
        $productos = DB::connection($this->cur_connect)->select($query);

        //echo json_encode($productos);
        //exit;
       
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

        for ($i = 1; $i <= $producto->numerodeimagenes; $i++) {
 
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


        $modelos = DB::connection($this->cur_connect)->select("select t0.* FROM ".$db_name.'.modelos'." t0
            WHERE t0.marca = '".$producto->id_marca."' ORDER BY marca ASC");
        foreach($modelos as $modelo) {
        $cat_pro = array('id' => $modelo->id,
                         'name' => $modelo->modelo,
                         'slug' => $this->string2url($modelo->modelo),
                         'created_at' => '2021-06-12T08:53:06.932Z',
                         'updated_at' => date("Y-m-d").'T08:53:06.943Z');
        $product_categories[] = $cat_pro;
        }

        // Inicio Foreach Marcas
        $brand = array('id' => $producto->id_marca,
                       'name' => $producto->marca,
                       'slug' => $this->string2url($producto->marca),
                       'created_at' => date("Y-m-d").'T10:56:52.945Z',
                        'updated_at' => date("Y-m-d").'T10:58:02.351Z');
        $product_brands[] = $brand;
        // Fin Foreach Marcas

        // Imagenes

            $datoproduct = [
            'estadopublicacion' => $producto->estado,
            'id' => $producto->idproducto,
            'fechacreacion' => $producto->fechacreacion,
            'name' => $producto->titulonombre,
            'marca' => $producto->marca,
            'modelos' => $producto->modelos,
            'condicion' => $producto->condicion,
            'condition' => $producto->condicionprd,
            'nombreciudad' => $producto->nombreciudad,
            'estadoproducto' => $producto->estadoproducto,
            'marcarepuesto' => $producto->marcarepuesto,
            'tipovehiculo' => $producto->tipovehiculo,
            'anovehiculo' => $producto->anovehiculo,
            'ciudad'=> $producto->ciudad,
            'descripcionproducto' => $producto->descripcionproducto,
            'posicionproducto' => $producto->posicionproducto,
            'numerodeparte' => $producto->numerodeparte,
            'funcionalidad' => $producto->funcionalidad,
            'compatible' => $producto->compatible,
            'usuario' => $producto->usuario,
            'emailvendedor' => $producto->emailvendedor,
            'peso' => $producto->peso,
            'largo' => $producto->largo,
            'ancho' => $producto->ancho,
            'alto' => $producto->alto,
            'genericos' => 'no',
            //'productogenerico' => $producto->productogenerico,
            'productogenerico' => 'No',
            'featured' => false,
            'price' => $producto->precio,
            'sale_price' => $producto->precio,
            'numerounidades' => $producto->numerodeunidades,
            'on_sale' => true,
            'slug' => $this->string2url($producto->titulonombre),
            'is_stock' => true,
            'rating_count' => 9,
            'description' => $producto->descripcionproducto,
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

    //Lee Productos de la Base de Datos
    public function getProductsGaraje($rec, $parametro)
    {
        ////////////////////////////////////////////////
        /// INICIO DE FOREACH DE VEHICULOS COMPATIBLES
        ///////////////////////////////////////////////
        $db_name = "mercadorepuesto_sys";
        //$aKeyword = explode(" ", $rec->name_contains);
        $posPrd = $rec->posicionprd;
        $carroceria = $rec->carroceria;
        $marca = $rec->marca;
        $cilindraje = $rec->cilindraje;
        $combustible = $rec->combustible;
        $modelo = $rec->modelo;
        $traccion = $rec->traccion;
        $transmision = $rec->transmision;
        $tipo = $rec->tipo;
        $anno = $rec->anno;
        //echo json_encode($posPrd);
        //echo json_encode($carroceria);
        //echo json_encode($marca);
        //echo json_encode($cilindraje);
        //echo json_encode($modelo);
        //exit;
        //return
        
        $querycompatibles = "select DISTINCT t0.id, t0.*,
            t0.idproductovehiculo as idproducto,
            t1.text AS marca,
            t1.id AS id_marca,
            t2.id AS id_modelos,
            t2.modelo AS modelos,
            t7.nombre AS condicion
            from ".$db_name.'.vehiculosproducto'." t0
            JOIN ".$db_name.'.marcas'." t1 ON t0.marca = t1.id
            JOIN ".$db_name.'.tiposvehiculos'." t3 ON t0.tipovehiculo = t3.id
            JOIN ".$db_name.'.modelos'." t2 ON t0.modelo = t2.id
            JOIN ".$db_name.'.tiposcarrocerias'." t4 ON t0.carroceria = t4.id
            JOIN ".$db_name.'.anosvehiculos'." t5 ON t0.anno = t5.id
            JOIN ".$db_name.'.condicion'." t7 ON t0.condicion = t7.id
            WHERE  t3.id = t1.tipovehiculo 
               &&  t0.tipovehiculo = '".$tipo."'
               &&  t0.carroceria = '".$carroceria."'
               &&  t0.marca = '".$marca."'
               &&  t0.modelo = '".$modelo."'
               &&  t0.cilindraje = '".$cilindraje."'
               ";
        
        $idproductos = DB::connection($this->cur_connect)->select($querycompatibles);

        //echo json_encode($idproductos);
        //exit;
        //return

        $numreg = 0;
        //////////////////////////////////////////////////////////////////////////////////////////////
        /// Elimina registros de la tabla de productos comapatibles solo para busquedas relacionadas
        /////////////////////////////////////////////////////////////////////////////////////////////
       
        $db_name = $this->db.".productoscompatibles";
        DB::connection($this->cur_connect)->delete("DELETE FROM ".$db_name);

        foreach($idproductos as $idproducto) {
            $numreg = $numreg + 1; 
            $prdCompatibles = new ModelGlobal();
            $prdCompatibles->setConnection($this->cur_connect);
            $prdCompatibles->setTable($db_name);
                    
            $prdCompatibles->idproducto = $idproducto ->idproductovehiculo;
                    
            $prdCompatibles->save();
        }
        //echo json_encode($numreg);
        //exit;

        $codigosproducto = array();

        for ($i = 0; $i < $numreg; $i++) {
            $codprd = $idproductos[$i]->idproductovehiculo;
            $menosuno = $i-1;
            
            if($i == 0) {
                $codigosproducto[$i] = $codprd;
            }

            if($i > 0) {
                if($idproductos[$menosuno]->idproductovehiculo != $codprd) {
                    $codigosproducto[$i] = $codprd;
                }
            }
        }

        //echo json_encode($codigosproducto);
        //exit;


        $prdselect = array();
        $sqlarmado = "";
        foreach($codigosproducto as $codigoprd) {
            $sqlarmado .= " t0.idproductovehiculo LIKE '%".$codigoprd."%' || ";
        }

        //foreach($prdselect as $prd) {
            //echo json_encode($prd); 
        //}
        /////////////////////////////////////////////
        /// TERMINA FOREACH DE VEHICULOS COMPATIBLES
        /////////////////////////////////////////////

        //////////////////////////////////
        /// INICIO DE FOREACH DE PRODUCTOS
        //////////////////////////////////
        $db_name = "mercadorepuesto_sys";
        $url_img = '/files/mercadorepuesto/';
        //$variable = json_decode($parametro);
        //echo $rec;
        //exit;
        $aKeyword = explode(" ", $rec->name_contains);

        //JOIN ".$db_name.'.versionmotor'." t6 ON t0.cilindrajemotor = t6.id
        // t6.cilindraje = '".$aKeyword[0]."' ||
                 
        $query = "select DISTINCT t0.id, t0.*,
            t0.id as idproducto,
            t1.text AS marca,
            t1.id AS id_marca,
            t2.id AS id_modelos,
            t2.modelo AS modelos,
            t7.nombre AS condicion,
            t5.anovehiculo AS anovehiculo,
            t0.condicion AS condicionprd,
            t8.nombre_ciu AS nombreciudad,
            t9.email as emailvendedor
            from ".$db_name.'.productos'." t0
            JOIN ".$db_name.'.marcas'." t1 ON t0.marca = t1.id
            JOIN ".$db_name.'.tiposvehiculos'." t3 ON t0.tipovehiculo = t3.id
            JOIN ".$db_name.'.modelos'." t2 ON t0.modelo = t2.id
            JOIN ".$db_name.'.tiposcarrocerias'." t4 ON t0.carroceria = t4.id
            JOIN ".$db_name.'.anosvehiculos'." t5 ON t0.anno = t5.id
            JOIN ".$db_name.'.condicion'." t7 ON t0.condicion = t7.id
            JOIN ".$db_name.'.ciudades'." t8 ON t0.ciudad = t8.id_ciu
            JOIN ".$db_name.'.users'." t9 ON t0.usuario = t9.uid
            WHERE (t0.estado = 11 || t0.estado = 31)
                  &&  t0.tipovehiculo = '".$tipo."'
                  &&  t0.carroceria = '".$carroceria."'
                  &&  t0.marca = '".$marca."'
                  &&  t0.modelo = '".$modelo."'
                  &&  t0.cilindrajemotor = '".$cilindraje."'
                  ";

 
        $productos = DB::connection($this->cur_connect)->select($query);

        //echo json_encode($productos);
        //exit;
       
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

        for ($i = 1; $i <= $producto->numerodeimagenes; $i++) {
 
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


        $modelos = DB::connection($this->cur_connect)->select("select t0.* FROM ".$db_name.'.modelos'." t0
            WHERE t0.marca = '".$producto->id_marca."' ORDER BY marca ASC");
        foreach($modelos as $modelo) {
        $cat_pro = array('id' => $modelo->id,
                         'name' => $modelo->modelo,
                         'slug' => $this->string2url($modelo->modelo),
                         'created_at' => '2021-06-12T08:53:06.932Z',
                         'updated_at' => date("Y-m-d").'T08:53:06.943Z');
        $product_categories[] = $cat_pro;
        }

        // Inicio Foreach Marcas
        $brand = array('id' => $producto->id_marca,
                       'name' => $producto->marca,
                       'slug' => $this->string2url($producto->marca),
                       'created_at' => date("Y-m-d").'T10:56:52.945Z',
                        'updated_at' => date("Y-m-d").'T10:58:02.351Z');
        $product_brands[] = $brand;
        // Fin Foreach Marcas

        // Imagenes

            $datoproduct = [
            'estadopublicacion' => $producto->estado,
            'id' => $producto->idproducto,
            'fechacreacion' => $producto->fechacreacion,
            'name' => $producto->titulonombre,
            'marca' => $producto->marca,
            'modelos' => $producto->modelos,
            'condicion' => $producto->condicion,
            'condition' => $producto->condicionprd,
            'nombreciudad' => $producto->nombreciudad,
            'estadoproducto' => $producto->estadoproducto,
            'marcarepuesto' => $producto->marcarepuesto,
            'tipovehiculo' => $producto->tipovehiculo,
            'anovehiculo' => $producto->anovehiculo,
            'ciudad'=> $producto->ciudad,
            'descripcionproducto' => $producto->descripcionproducto,
            'posicionproducto' => $producto->posicionproducto,
            'numerodeparte' => $producto->numerodeparte,
            'funcionalidad' => $producto->funcionalidad,
            'compatible' => $producto->compatible,
            'usuario' => $producto->usuario,
            'emailvendedor' => $producto->emailvendedor,
            'peso' => $producto->peso,
            'largo' => $producto->largo,
            'ancho' => $producto->ancho,
            'alto' => $producto->alto,
            'genericos' => 'no',
            //'productogenerico' => $producto->productogenerico,
            'productogenerico' => 'No',
            'featured' => false,
            'price' => $producto->precio,
            'sale_price' => $producto->precio,
            'numerounidades' => $producto->numerodeunidades,
            'on_sale' => true,
            'slug' => $this->string2url($producto->titulonombre),
            'is_stock' => true,
            'rating_count' => 9,
            'description' => $producto->descripcionproducto,
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

    //Lee Productos de la Base de Datos
    public function getProductsCategoryPos($rec, $parametro)
    {
        ////////////////////////////////////////////////
        /// INICIO DE FOREACH DE VEHICULOS COMPATIBLES
        ///////////////////////////////////////////////
        $db_name = "mercadorepuesto_sys";
        $aKeyword = explode(" ", $rec->name_contains);
        $posPrd = $rec->posicionprd;
        //echo json_encode($posPrd);
        //exit;
        //return
        
        $querycompatibles = "select DISTINCT t0.id, t0.*,
            t0.idproductovehiculo as idproducto,
            t1.text AS marca,
            t1.id AS id_marca,
            t2.id AS id_modelos,
            t2.modelo AS modelos,
            t7.nombre AS condicion
            from ".$db_name.'.vehiculosproducto'." t0
            JOIN ".$db_name.'.marcas'." t1 ON t0.marca = t1.id
            JOIN ".$db_name.'.tiposvehiculos'." t3 ON t0.tipovehiculo = t3.id
            JOIN ".$db_name.'.modelos'." t2 ON t0.modelo = t2.id
            JOIN ".$db_name.'.tiposcarrocerias'." t4 ON t0.carroceria = t4.id
            JOIN ".$db_name.'.anosvehiculos'." t5 ON t0.anno = t5.id
            JOIN ".$db_name.'.condicion'." t7 ON t0.condicion = t7.id
            WHERE  t3.id = t1.tipovehiculo &&
                  (t0.posicionproducto = '".$posPrd."')  ";
        
        $idproductos = DB::connection($this->cur_connect)->select($querycompatibles);

        //echo json_encode($idproductos);
        //exit;
        //return

        $numreg = 0;
        //////////////////////////////////////////////////////////////////////////////////////////////
        /// Elimina registros de la tabla de productos comapatibles solo para busquedas relacionadas
        /////////////////////////////////////////////////////////////////////////////////////////////
       
        $db_name = $this->db.".productoscompatibles";
        DB::connection($this->cur_connect)->delete("DELETE FROM ".$db_name);

        foreach($idproductos as $idproducto) {
            $numreg = $numreg + 1; 
            $prdCompatibles = new ModelGlobal();
            $prdCompatibles->setConnection($this->cur_connect);
            $prdCompatibles->setTable($db_name);
                    
            $prdCompatibles->idproducto = $idproducto ->idproductovehiculo;
                    
            $prdCompatibles->save();
        }
        //echo json_encode($numreg);
        //exit;

        $codigosproducto = array();

        for ($i = 0; $i < $numreg; $i++) {
            $codprd = $idproductos[$i]->idproductovehiculo;
            $menosuno = $i-1;
            
            if($i == 0) {
                $codigosproducto[$i] = $codprd;
            }

            if($i > 0) {
                if($idproductos[$menosuno]->idproductovehiculo != $codprd) {
                    $codigosproducto[$i] = $codprd;
                }
            }
        }

        //echo json_encode($codigosproducto);
        //exit;


        $prdselect = array();
        $sqlarmado = "";
        foreach($codigosproducto as $codigoprd) {
            $sqlarmado .= " t0.idproductovehiculo LIKE '%".$codigoprd."%' || ";
        }

        //foreach($prdselect as $prd) {
            //echo json_encode($prd); 
        //}
        /////////////////////////////////////////////
        /// TERMINA FOREACH DE VEHICULOS COMPATIBLES
        /////////////////////////////////////////////

        //////////////////////////////////
        /// INICIO DE FOREACH DE PRODUCTOS
        //////////////////////////////////
        $db_name = "mercadorepuesto_sys";
        $url_img = '/files/mercadorepuesto/';
        //$variable = json_decode($parametro);
        //echo $rec;
        //exit;
        $aKeyword = explode(" ", $rec->name_contains);

        //JOIN ".$db_name.'.versionmotor'." t6 ON t0.cilindrajemotor = t6.id
        // t6.cilindraje = '".$aKeyword[0]."' ||
                 
        $query = "select DISTINCT t0.id, t0.*,
            t0.id as idproducto,
            t1.text AS marca,
            t1.id AS id_marca,
            t2.id AS id_modelos,
            t2.modelo AS modelos,
            t7.nombre AS condicion,
            t5.anovehiculo AS anovehiculo,
            t0.condicion AS condicionprd,
            t8.nombre_ciu AS nombreciudad,
            t9.email as emailvendedor
            from ".$db_name.'.productos'." t0
            JOIN ".$db_name.'.marcas'." t1 ON t0.marca = t1.id
            JOIN ".$db_name.'.tiposvehiculos'." t3 ON t0.tipovehiculo = t3.id
            JOIN ".$db_name.'.modelos'." t2 ON t0.modelo = t2.id
            JOIN ".$db_name.'.tiposcarrocerias'." t4 ON t0.carroceria = t4.id
            JOIN ".$db_name.'.anosvehiculos'." t5 ON t0.anno = t5.id
            JOIN ".$db_name.'.condicion'." t7 ON t0.condicion = t7.id
            JOIN ".$db_name.'.ciudades'." t8 ON t0.ciudad = t8.id_ciu
            JOIN ".$db_name.'.users'." t9 ON t0.usuario = t9.uid
            WHERE (t0.estado = 11 || t0.estado = 31) &&
                 (t0.posicionproducto = '".$posPrd."')  ";

 
        $productos = DB::connection($this->cur_connect)->select($query);

        //echo json_encode($productos);
        //exit;
       
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

        for ($i = 1; $i <= $producto->numerodeimagenes; $i++) {
 
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


        $modelos = DB::connection($this->cur_connect)->select("select t0.* FROM ".$db_name.'.modelos'." t0
            WHERE t0.marca = '".$producto->id_marca."' ORDER BY marca ASC");
        foreach($modelos as $modelo) {
        $cat_pro = array('id' => $modelo->id,
                         'name' => $modelo->modelo,
                         'slug' => $this->string2url($modelo->modelo),
                         'created_at' => '2021-06-12T08:53:06.932Z',
                         'updated_at' => date("Y-m-d").'T08:53:06.943Z');
        $product_categories[] = $cat_pro;
        }

        // Inicio Foreach Marcas
        $brand = array('id' => $producto->id_marca,
                       'name' => $producto->marca,
                       'slug' => $this->string2url($producto->marca),
                       'created_at' => date("Y-m-d").'T10:56:52.945Z',
                        'updated_at' => date("Y-m-d").'T10:58:02.351Z');
        $product_brands[] = $brand;
        // Fin Foreach Marcas

        // Imagenes

            $datoproduct = [
            'estadopublicacion' => $producto->estado,
            'id' => $producto->idproducto,
            'fechacreacion' => $producto->fechacreacion,
            'name' => $producto->titulonombre,
            'marca' => $producto->marca,
            'modelos' => $producto->modelos,
            'condicion' => $producto->condicion,
            'condition' => $producto->condicionprd,
            'nombreciudad' => $producto->nombreciudad,
            'estadoproducto' => $producto->estadoproducto,
            'marcarepuesto' => $producto->marcarepuesto,
            'tipovehiculo' => $producto->tipovehiculo,
            'anovehiculo' => $producto->anovehiculo,
            'ciudad'=> $producto->ciudad,
            'descripcionproducto' => $producto->descripcionproducto,
            'posicionproducto' => $producto->posicionproducto,
            'numerodeparte' => $producto->numerodeparte,
            'funcionalidad' => $producto->funcionalidad,
            'compatible' => $producto->compatible,
            'usuario' => $producto->usuario,
            'emailvendedor' => $producto->emailvendedor,
            'peso' => $producto->peso,
            'largo' => $producto->largo,
            'ancho' => $producto->ancho,
            'alto' => $producto->alto,
            'genericos' => 'no',
            //'productogenerico' => $producto->productogenerico,
            'productogenerico' => 'No',
            'featured' => false,
            'price' => $producto->precio,
            'sale_price' => $producto->precio,
            'numerounidades' => $producto->numerodeunidades,
            'on_sale' => true,
            'slug' => $this->string2url($producto->titulonombre),
            'is_stock' => true,
            'rating_count' => 9,
            'description' => $producto->descripcionproducto,
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

    //Lee ID Productos del usuario
    public function productosUsuario($rec)
    {
        DB::beginTransaction();
        try {
        $db_name = "mercadorepuesto_sys";
                
        $listarmisventas = DB::connection($this->cur_connect)->select(
                                                "select t0.id, t0.titulonombre
                                                from ".$db_name.'.productos'." t0
                                                where t0.usuario = '". $rec->uidvendedor."'
                                                order by t0.id DESC"); 

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
            'listarmisventas' => $listarmisventas,
            'message' => 'REGISTRO EXITOSO',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    //Lee Productos Genericos de la Base de Datos
    public function getProductsGeneric($rec, $parametro)
    {
        ////////////////////////////////////////////////
        /// INICIO DE FOREACH DE VEHICULOS COMPATIBLES
        ///////////////////////////////////////////////
        $db_name = "mercadorepuesto_sys";
        $aKeyword = explode(" ", $rec->name_contains);
        $url_img = '/files/mercadorepuesto/';
    
        $query = "select DISTINCT t0.id, t0.*,
            t0.posicionproducto as posicionproducto,
            t0.id as idproducto,
            t1.text AS marca,
            t1.id AS id_marca,
            t2.id AS id_modelos,
            t2.modelo AS modelos,
            t7.nombre AS condicion,
            t5.anovehiculo AS anovehiculo,
            t0.condicion AS condicionprd,
            t8.nombre_ciu AS nombreciudad,
            t9.email as emailvendedor
            from ".$db_name.'.productos'." t0
            JOIN ".$db_name.'.marcas'." t1 ON t0.marca = t1.id
            JOIN ".$db_name.'.tiposvehiculos'." t3 ON t0.tipovehiculo = t3.id
            JOIN ".$db_name.'.modelos'." t2 ON t0.modelo = t2.id
            JOIN ".$db_name.'.tiposcarrocerias'." t4 ON t0.carroceria = t4.id
            JOIN ".$db_name.'.anosvehiculos'." t5 ON t0.anno = t5.id
            JOIN ".$db_name.'.versionmotor'." t6 ON t0.cilindrajemotor = t6.id
            JOIN ".$db_name.'.condicion'." t7 ON t0.condicion = t7.id
            JOIN ".$db_name.'.ciudades'." t8 ON t0.ciudad = t8.id_ciu
            JOIN ".$db_name.'.users'." t9 ON t0.usuario = t9.uid
            WHERE (t0.estado = 11 || t0.estado = 31) &&
                  t3.id = t0.tipovehiculo &&
                  t0.productogenerico = 'Si' &&
                  (t1.text LIKE '%".$aKeyword[0]."%' ||
                   t0.titulonombre LIKE '%".$aKeyword[0]."%' ||
                   t0.descripcionproducto LIKE '%".$aKeyword[0]."%' ||
                   t0.marcarepuesto LIKE '%".$aKeyword[0]."%' ||
                   t0.numerodeparte LIKE '%".$aKeyword[0]."%' ||
                   t6.cilindraje = '".$aKeyword[0]."' ||
                   t3.text LIKE '%".$aKeyword[0]."%' ||
                   t7.nombre LIKE '%".$aKeyword[0]."%' ||
                   t4.carroceria LIKE '%".$aKeyword[0]."%' ||
                   t5.anovehiculo LIKE '%".$aKeyword[0]."%')  ";

                   for($i = 1; $i < count($aKeyword); $i++) {
                    if(!empty($aKeyword[$i])) {
                        $query .= " OR (t1.text LIKE '%".$aKeyword[$i]."%' ||
                        t0.titulonombre LIKE '%".$aKeyword[$i]."%' ||
                        t7.nombre LIKE '%".$aKeyword[$i]."%' ||
                        t2.modelo LIKE '%".$aKeyword[$i]."%')";
                    }
                  }
                
        $productos = DB::connection($this->cur_connect)->select($query);

        //echo json_encode($productos);
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

        for ($i = 1; $i <= $producto->numerodeimagenes; $i++) {

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

        $modelos = DB::connection($this->cur_connect)->select("select t0.* FROM ".$db_name.'.modelos'." t0
            WHERE t0.marca = '".$producto->id_marca."' ORDER BY marca ASC");
        foreach($modelos as $modelo) {

        $cat_pro = array('id' => $modelo->id,
                         'name' => $modelo->modelo,
                         'slug' => $this->string2url($modelo->modelo),
                         'created_at' => '2021-06-12T08:53:06.932Z',
                         'updated_at' => date("Y-m-d").'T08:53:06.943Z');
        $product_categories[] = $cat_pro;

        }

        // Inicio Foreach Marcas
        $brand = array('id' => $producto->id_marca,
                       'name' => $producto->marca,
                       'slug' => $this->string2url($producto->marca),
                       'created_at' => date("Y-m-d").'T10:56:52.945Z',
                        'updated_at' => date("Y-m-d").'T10:58:02.351Z');
        $product_brands[] = $brand;
        // Fin Foreach Marcas

        // Imagenes

            $datoproduct = [
            'estadopublicacion' => $producto->estado,
            'id' => $producto->idproducto,
            'name' => $producto->titulonombre,
            'marca' => $producto->marca,
            'modelos' => $producto->modelos,
            'condicion' => $producto->condicion,
            'anovehiculo' => $producto->anovehiculo,
            'condition' => $producto->condicionprd,
            'nombreciudad' => $producto->nombreciudad,
            'tipovehiculo' => $producto->tipovehiculo,
            'posicionproducto' =>$producto->posicionproducto,
            'descripcionproducto' => $producto->descripcionproducto,
            'posicionproducto' => $producto->posicionproducto,
            'marcarepuesto' => $producto->marcarepuesto,
            'numerodeparte' => $producto->numerodeparte,
            'funcionalidad' => $producto->funcionalidad,
            'usuario' => $producto->usuario,
            'emailvendedor' => $producto->emailvendedor,
            'compatible' => $producto->compatible,
            'peso' => $producto->peso,
            'largo' => $producto->largo,
            'ancho' => $producto->ancho,
            'alto' => $producto->alto,
            'ciudad'=> $producto->ciudad,
            'genericos' => 'productosgenericos',
            'featured' => false,
            'price' => $producto->precio,
            'sale_price' => $producto->precio,
            'productogenerico' => $producto->productogenerico,
            'numerounidades' => $producto->numerodeunidades,
            'on_sale' => true,
            'slug' => $this->string2url($producto->titulonombre),
            'is_stock' => true,
            'rating_count' => 9,
            'description' => $producto->descripcionproducto,
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

    //lee vista de vehiculos creados en mercado repuesto
    public function selectVehiclesMercadoRepuesto($rec)
    {
        //echo json_encode($rec);
        DB::beginTransaction();
        try {
        $db_name = "mercadorepuesto_sys";
                
        $listvehiclesmr = DB::connection($this->cur_connect)->select(
                                                "select t0.* 
                                                from ".$db_name.'.vista_vehiculosmr'." t0 
                                                WHERE t0.tipovehiculo = '".$rec->tipovehiculo."' 
                                                  AND t0.codigocarroceria = '".$rec->carroceria."' 
                                                  AND t0.codigomarca = '".$rec->marca."' 
                                                  AND t0.codigomodelo = '".$rec->modelo."' 
                                                  AND t0.codigocilindraje = ".$rec->cilindrajemotor);
                                             
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
            'listvehiclesmr' => $listvehiclesmr,
            'message' => 'REGISTRO EXITOSO',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    //Lee Productos Asociados a los datos del contacto
    public function getProductsContact($rec, $parametro)
    {
        ////////////////////////////////////////////////
        /// INICIO DE FOREACH DE VEHICULOS COMPATIBLES
        ///////////////////////////////////////////////
        $db_name = "mercadorepuesto_sys";
        $aKeyword = explode(" ", $rec->name_contains);
        $url_img = '/files/mercadorepuesto/';
    
        $query = "select DISTINCT t0.id, t0.*,
            t0.posicionproducto as posicionproducto,
            t0.id as idproducto,
            t1.text AS marca,
            t1.id AS id_marca,
            t2.id AS id_modelos,
            t2.modelo AS modelos,
            t7.nombre AS condicion,
            t5.anovehiculo AS anovehiculo,
            t0.condicion AS condicionprd,
            t8.nombre_ciu AS nombreciudad,
            t9.email as emailvendedor
            from ".$db_name.'.productos'." t0
            JOIN ".$db_name.'.marcas'." t1 ON t0.marca = t1.id
            JOIN ".$db_name.'.tiposvehiculos'." t3 ON t0.tipovehiculo = t3.id
            JOIN ".$db_name.'.modelos'." t2 ON t0.modelo = t2.id
            JOIN ".$db_name.'.tiposcarrocerias'." t4 ON t0.carroceria = t4.id
            JOIN ".$db_name.'.anosvehiculos'." t5 ON t0.anno = t5.id
            JOIN ".$db_name.'.versionmotor'." t6 ON t0.cilindrajemotor = t6.id
            JOIN ".$db_name.'.condicion'." t7 ON t0.condicion = t7.id
            JOIN ".$db_name.'.ciudades'." t8 ON t0.ciudad = t8.id_ciu
            JOIN ".$db_name.'.users'." t9 ON t0.usuario = t9.uid
            WHERE (t0.tipovehiculo = '".$rec->tipovehiculo."' AND
                   t0.carroceria = '".$rec->carroceria."' AND
                   t0.marca = '".$rec->marca."' AND
                   t0.modelo = '".$rec->modelo."' AND
                   t0.cilindrajemotor = '".$rec->cilindrajemotor."')  ";
/*
                   for($i = 1; $i < count($aKeyword); $i++) {
                    if(!empty($aKeyword[$i])) {
                        $query .= " OR (t1.text LIKE '%".$aKeyword[$i]."%' ||
                        t0.titulonombre LIKE '%".$aKeyword[$i]."%' ||
                        t7.nombre LIKE '%".$aKeyword[$i]."%' ||
                        t2.modelo LIKE '%".$aKeyword[$i]."%')";
                    }
                  }
                */
        $productos = DB::connection($this->cur_connect)->select($query);

        //echo json_encode($productos);
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

        for ($i = 1; $i <= $producto->numerodeimagenes; $i++) {

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

        $modelos = DB::connection($this->cur_connect)->select("select t0.* FROM ".$db_name.'.modelos'." t0
            WHERE t0.marca = '".$producto->id_marca."' ORDER BY marca ASC");
        foreach($modelos as $modelo) {

        $cat_pro = array('id' => $modelo->id,
                         'name' => $modelo->modelo,
                         'slug' => $this->string2url($modelo->modelo),
                         'created_at' => '2021-06-12T08:53:06.932Z',
                         'updated_at' => date("Y-m-d").'T08:53:06.943Z');
        $product_categories[] = $cat_pro;

        }

        // Inicio Foreach Marcas
        $brand = array('id' => $producto->id_marca,
                       'name' => $producto->marca,
                       'slug' => $this->string2url($producto->marca),
                       'created_at' => date("Y-m-d").'T10:56:52.945Z',
                        'updated_at' => date("Y-m-d").'T10:58:02.351Z');
        $product_brands[] = $brand;
        // Fin Foreach Marcas

        // Imagenes

            $datoproduct = [
            'id' => $producto->idproducto,
            'name' => $producto->titulonombre,
            'marca' => $producto->marca,
            'modelos' => $producto->modelos,
            'condicion' => $producto->condicion,
            'anovehiculo' => $producto->anovehiculo,
            'condition' => $producto->condicionprd,
            'nombreciudad' => $producto->nombreciudad,
            'tipovehiculo' => $producto->tipovehiculo,
            'posicionproducto' =>$producto->posicionproducto,
            'marcarepuesto' => $producto->marcarepuesto,
            'descripcionproducto' => $producto->descripcionproducto,
            'numerodeparte' => $producto->numerodeparte,
            'funcionalidad' => $producto->funcionalidad,
            'compatible' => $producto->compatible,
            'usuario' => $producto->usuario,
            'emailvendedor' => $producto->emailvendedor,
            'peso' => $producto->peso,
            'largo' => $producto->largo,
            'ancho' => $producto->ancho,
            'alto' => $producto->alto,
            'ciudad'=> $producto->ciudad,
            'genericos' => 'productoscontactanos',
            'featured' => false,
            'price' => $producto->precio,
            'sale_price' => $producto->precio,
            'numerounidades' => $producto->numerodeunidades,
            'productogenerico' => $producto->productogenerico,
            'on_sale' => true,
            'slug' => $this->string2url($producto->titulonombre),
            'is_stock' => true,
            'rating_count' => 9,
            'description' => $producto->descripcionproducto,
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

        $db_name = "mercadorepuesto_sys";
        $url_img = '/files/mercadorepuesto/';
        //echo $variable = json_decode($parametro);
        //echo $rec->idarticulo;
        //exit;

        $productos = DB::connection($this->cur_connect)->select("select t0.*,
        t0.id as idproducto,
        t1.text AS marca,
        t1.id AS id_marca,
        t2.id AS id_modelos,
        t2.modelo AS modelos,
        t4.nombre AS condicionprd,
        t8.nombre_ciu AS nombreciudad,
        t9.email as emailvendedor
        from ".$db_name.'.productos'." t0
        JOIN ".$db_name.'.tiposvehiculos'." t3 ON t0.tipovehiculo = t3.id
        JOIN ".$db_name.'.marcas'." t1 ON t0.marca = t1.id
        JOIN ".$db_name.'.modelos'." t2 ON t0.modelo = t2.id
        JOIN ".$db_name.'.condicion'." t4 ON t0.condicion = t4.id
        JOIN ".$db_name.'.ciudades'." t8 ON t0.ciudad = t8.id_ciu
        JOIN ".$db_name.'.users'." t9 ON t0.usuario = t9.uid
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

        $modelos = DB::connection($this->cur_connect)->select("
            select t0.* FROM ".$db_name.'.modelos'." t0
            JOIN ".$db_name.'.marcas'." t1 ON t0.marca = t1.id
            JOIN ".$db_name.'.tiposvehiculos'." t3 ON t3.id = t1.tipovehiculo
            WHERE t0.marca = '".$producto->id_marca."' AND t0.id = '".$producto->modelo."' ORDER BY t0.marca ASC");

        foreach($modelos as $modelo) {

        $cat_pro = array('id' => $modelo->id,
                         'name' => $modelo->modelo,
                         'slug' => $this->string2url($modelo->modelo),
                         'created_at' => '2021-06-12T08:53:06.932Z',
                         'updated_at' => date("Y-m-d").'T08:53:06.943Z');
        $product_categories[] = $cat_pro;
    
        }

        // Inicio Foreach Marcas
        $brand = array('id' => $producto->id_marca,
                       'name' => $producto->marca,
                       'slug' => $this->string2url($producto->marca),
                       'created_at' => date("Y-m-d").'T10:56:52.945Z',
                        'updated_at' => date("Y-m-d").'T10:58:02.351Z');
        $product_brands[] = $brand;
        // Fin Foreach Marcas
        // Imagenes

            $datoproduct = [
            'id' => $producto->idproducto,
            'name' => $producto->titulonombre,
            'featured' => false,
            'price' => $producto->precio,
            'sale_price' => $producto->precio,
            'numerounidades' => $producto->numerodeunidades,
            'productogenerico' => $producto->productogenerico,
            'idproductovehiculo' => $producto->idproductovehiculo,
            'posicionproducto' => $producto->posicionproducto,
            'productogenerico' => $producto->productogenerico,
            'tipovehiculo' => $producto->tipovehiculo,
            'estadoproducto' => $producto->estadoproducto,
            'funcionalidad' => $producto->funcionalidad,
            'marcarepuesto' => $producto->marcarepuesto,
            'condicion' => $producto->condicionprd,
            'nombreciudad' => $producto->nombreciudad,
            'vendeporpartes' => $producto->vendeporpartes,
            'numerodeparte' => $producto->numerodeparte,
            'compatible' => $producto->compatible,
            'usuario' => $producto->usuario,
            'emailvendedor' => $producto->emailvendedor,
            'peso' => $producto->peso,
            'largo' => $producto->largo,
            'ancho' => $producto->ancho,
            'alto' => $producto->alto,
            'on_sale' => true,
            'slug' => $this->string2url($producto->titulonombre),
            'is_stock' => true,
            'rating_count' => 9,
            'description' => $producto->descripcionproducto,
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
        $db_name = "mercadorepuesto_sys";
        $url_img = '/files/mercadorepuesto/';
        //echo $variable = json_decode($parametro);
        //echo $rec->idarticulo;
        //exit;

        $productos = DB::connection($this->cur_connect)->select("select t0.*,
        t0.id as idproducto,
        t1.text AS marca,
        t1.id AS id_marca,
        t2.id AS id_modelos,
        t2.modelo AS modelos,
        t4.nombre AS condicionprd,
        t8.nombre_ciu AS nombreciudad,
        t9.email as emailvendedor
        from ".$db_name.'.productos'." t0
        JOIN ".$db_name.'.tiposvehiculos'." t3 ON t0.tipovehiculo = t3.id
        JOIN ".$db_name.'.marcas'." t1 ON t0.marca = t1.id
        JOIN ".$db_name.'.modelos'." t2 ON t0.modelo = t2.id
        JOIN ".$db_name.'.condicion'." t4 ON t0.condicion = t4.id
        JOIN ".$db_name.'.ciudades'." t8 ON t0.ciudad = t8.id_ciu
        JOIN ".$db_name.'.users'." t9 ON t0.usuario = t9.uid
        WHERE t3.id = t0.tipovehiculo 
        AND t1.tipovehiculo = t0.tipovehiculo
        AND t1.carroceria = t0.carroceria
        AND t0.id = ".$rec->idarticulo);

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

        $modelos = DB::connection($this->cur_connect)->select("
            select t0.* FROM ".$db_name.'.modelos'." t0
            JOIN ".$db_name.'.marcas'." t1 ON t0.marca = t1.id
            JOIN ".$db_name.'.tiposvehiculos'." t3 ON t3.id = t1.tipovehiculo
            WHERE t0.marca = '".$producto->id_marca."' AND t0.id = '".$producto->modelo."' ORDER BY t0.marca ASC");

        foreach($modelos as $modelo) {
 
        $cat_pro = array('id' => $modelo->id,
                         'name' => $modelo->modelo,
                         'slug' => $this->string2url($modelo->modelo),
                         'created_at' => '2021-06-12T08:53:06.932Z',
                         'updated_at' => date("Y-m-d").'T08:53:06.943Z');
        $product_categories[] = $cat_pro;

        }

        // Inicio Foreach Marcas
        $brand = array('id' => $producto->id_marca,
                       'name' => $producto->marca,
                       'slug' => $this->string2url($producto->marca),
                       'created_at' => date("Y-m-d").'T10:56:52.945Z',
                        'updated_at' => date("Y-m-d").'T10:58:02.351Z');
        $product_brands[] = $brand;
        // Fin Foreach Marcas

        // Imagenes

            $datoproduct = [
            'id' => $producto->idproducto,
            'name' => $producto->titulonombre,
            'featured' => false,
            'price' => $producto->precio,
            'sale_price' => $producto->precio,
            'numerounidades' => $producto->numerodeunidades,
            'productogenerico' => $producto->productogenerico,
            'condicion' => $producto->condicionprd,
            'estadoproducto' => $producto->estadoproducto,
            'tipovehiculo' => $producto->tipovehiculo,
            'idproductovehiculo' => $producto->idproductovehiculo,
            'posicionproducto' => $producto->posicionproducto,
            'funcionalidad' => $producto->funcionalidad,
            'productogenerico' => $producto->productogenerico,
            'marcarepuesto' => $producto->marcarepuesto,
            'numerodeparte' => $producto->numerodeparte,
            'vendeporpartes' => $producto->vendeporpartes,
            'nombreciudad' => $producto->nombreciudad,
            'compatible' => $producto->compatible,
            'usuario' => $producto->usuario,
            'emailvendedor' => $producto->emailvendedor,
            'nombreImagen' => $producto->nombreimagen1,
            'peso' => $producto->peso,
            'largo' => $producto->largo,
            'ancho' => $producto->ancho,
            'alto' => $producto->alto,
            'on_sale' => true,
            'slug' => $this->string2url($producto->titulonombre),
            'is_stock' => true,
            'rating_count' => 9,
            'description' => $producto->descripcionproducto,
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
    public function getProductId($rec)
    {   ///////////////////////////////////
        /// INICIO DE FOREACH DE PRODUCTOS
        //////////////////////////////////
        $db_name = "mercadorepuesto_sys";
        $url_img = '/files/mercadorepuesto/';
        //echo $variable = json_decode($parametro);
        //echo $rec->idarticulo;
        //exit;

        DB::beginTransaction();
        try {
            $db_name = "mercadorepuesto_sys";
                
        $listapublicacion = DB::connection($this->cur_connect)->select("select t0.*,t1.nombre_ciu as nombreciudad,
                                                            t2.nombre_dep, t2.codigo_dep
                                                            from ".$db_name.'.productos'." t0
                                                            JOIN ".$db_name.'.ciudades'." t1 ON t0.ciudad = t1.id_ciu
                                                            JOIN ".$db_name.'.departamentos'." t2 ON t1.departamento_ciu = t2.codigo_dep
                                                            WHERE t0.id = ".$rec->idarticulo);

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
            'listapublicacion' => $listapublicacion,
            'message' => 'REGISTRO EXITOSO',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    //Actualiza estado de la publicación
    public function actualizaPublicacion($rec)
    {
        //echo json_encode($rec->id);
        //exit;
        $db_name = $this->db.".productos";
   
        DB::beginTransaction();
        try {
   
              DB::connection($this->cur_connect)->update("UPDATE ".$db_name." 
                  SET estado = '".$rec-> estadopublicacion."',
                      comentariomr = '".$rec-> comentariomr."',
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
               'message' => 'PROCESO EXITOSO'
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    //Lee publicaciones del usuario
    public function getProductsUser($rec)
    {   ///////////////////////////////////
        /// INICIO DE FOREACH DE PRODUCTOS
        //////////////////////////////////
        $db_name = "mercadorepuesto_sys";
        $url_img = '/files/mercadorepuesto/';
        //echo $variable = json_decode($parametro);
        //echo $rec->idarticulo;
        //exit;

        $productos = DB::connection($this->cur_connect)->select("select t0.*,
        t0.id as idproducto,
        t1.text AS marca,
        t1.id AS id_marca,
        t2.id AS id_modelos,
        t2.modelo AS modelos,
        t4.nombre AS condicionprd,
        t8.nombre_ciu AS nombreciudad,
        t9.email as emailvendedor
        from ".$db_name.'.productos'." t0
        JOIN ".$db_name.'.tiposvehiculos'." t3 ON t0.tipovehiculo = t3.id
        JOIN ".$db_name.'.marcas'." t1 ON t0.marca = t1.id
        JOIN ".$db_name.'.modelos'." t2 ON t0.modelo = t2.id
        JOIN ".$db_name.'.condicion'." t4 ON t0.condicion = t4.id
        JOIN ".$db_name.'.ciudades'." t8 ON t0.ciudad = t8.id_ciu
        JOIN ".$db_name.'.users'." t9 ON t0.usuario = t9.uid
        WHERE t0.estado != 16 && t3.id = t0.tipovehiculo && t1.tipovehiculo = t0.tipovehiculo
        && t1.carroceria = t0.carroceria && t0.usuario = ".$rec->usuario);

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

        $modelos = DB::connection($this->cur_connect)->select("
            select t0.* FROM ".$db_name.'.modelos'." t0
            JOIN ".$db_name.'.marcas'." t1 ON t0.marca = t1.id
            JOIN ".$db_name.'.tiposvehiculos'." t3 ON t3.id = t1.tipovehiculo
            WHERE t0.marca = '".$producto->id_marca."' AND t0.id = '".$producto->modelo."' ORDER BY t0.marca ASC");

        foreach($modelos as $modelo) {

        $cat_pro = array('id' => $modelo->id,
                         'name' => $modelo->modelo,
                         'slug' => $this->string2url($modelo->modelo),
                         'created_at' => '2021-06-12T08:53:06.932Z',
                         'updated_at' => date("Y-m-d").'T08:53:06.943Z');
        $product_categories[] = $cat_pro;
 
        }

        // Inicio Foreach Marcas
        $brand = array('id' => $producto->id_marca,
                       'name' => $producto->marca,
                       'slug' => $this->string2url($producto->marca),
                       'created_at' => date("Y-m-d").'T10:56:52.945Z',
                        'updated_at' => date("Y-m-d").'T10:58:02.351Z');
        $product_brands[] = $brand;
        // Fin Foreach Marcas

        // Imagenes

            $datoproduct = [
            'id' => $producto->idproducto,
            'name' => $producto->titulonombre,
            'fechacreacion' => $producto->fechacreacion,
            'featured' => false,
            'price' => $producto->precio,
            'sale_price' => $producto->precio,
            'numerounidades' => $producto->numerodeunidades,
            'productogenerico' => $producto->productogenerico,
            'condicion' => $producto->condicionprd,
            'estadoproducto' => $producto->estadoproducto,
            'estadopublicacion' => $producto->estado,
            'tipovehiculo' => $producto->tipovehiculo,
            'idproductovehiculo' => $producto->idproductovehiculo,
            'posicionproducto' => $producto->posicionproducto,
            'funcionalidad' => $producto->funcionalidad,
            'productogenerico' => $producto->productogenerico,
            'marcarepuesto' => $producto->marcarepuesto,
            'numerodeparte' => $producto->numerodeparte,
            'nombreciudad' => $producto->nombreciudad,
            'compatible' => $producto->compatible,
            'usuario' => $producto->usuario,
            'emailvendedor' => $producto->emailvendedor,
            'peso' => $producto->peso,
            'largo' => $producto->largo,
            'ancho' => $producto->ancho,
            'alto' => $producto->alto,
            'on_sale' => true,
            'slug' => $this->string2url($producto->titulonombre),
            'is_stock' => true,
            'rating_count' => 9,
            'description' => $producto->descripcionproducto,
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

    public function listarDcosNit($rec)
    {
        DB::beginTransaction();
        try {
        $db_name = "mercadorepuesto_sys";
                
        $listardcosnit = DB::connection($this->cur_connect)->select(
                                                "select t0.*
                                                from ".$db_name.'.documentoscrearnit'." t0 
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
            'listardcosnit' => $listardcosnit,
            'message' => 'REGISTRO EXITOSO',
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

    //Crear vehiculos asociados a productos
    public function crearRegistroCompra($rec)
    {
        DB::beginTransaction();
        try {
                    $db_name = $this->db.".miscompras";
                    $registrarCompra = new ModelGlobal();
                    $registrarCompra->setConnection($this->cur_connect);
                    $registrarCompra->setTable($db_name);
            
                    $registrarCompra->idproducto = $rec->idproducto;
                    $registrarCompra->idventa = $rec->idventa;
                    $registrarCompra->compatible = $rec->compatible;
                    $registrarCompra->numerodeaprobacion = $rec->numerodeaprobacion;
                    $registrarCompra->uidcomprador = $rec->uidcomprador;
                    $registrarCompra->uidvendedor = $rec->uidvendedor;
                    $registrarCompra->fechacompra =  $date = date('Y-m-d H:i:s');
                    $registrarCompra->fechaentrega = $rec->fechaentrega;
                    $registrarCompra->fechadespacho = $rec->fechadespacho;
                    $registrarCompra->fechadevolucion = $rec->fechadevolucion;
                    $registrarCompra->fechadepago =  $date = date('Y-m-d H:i:s');

                    $registrarCompra->fechaactualiza =  $date = date('Y-m-d H:i:s');
                    $registrarCompra->fechaactualizafactura =  $date = date('Y-m-d H:i:s');

                    $registrarCompra->formadepago = $rec->formadepago;
                    $registrarCompra->cantidad = $rec->cantidad;
                    $registrarCompra->idtransaccionpago = $rec->idtransaccionpago;
                    $registrarCompra->preciodeventa = $rec->preciodeventa;
                    $registrarCompra->precioenvio = $rec->precioenvio;
                    $registrarCompra->retencion = $rec->retencion;
                    $registrarCompra->impuestos = $rec->impuestos;
                    $registrarCompra->direcciondeenvio = $rec->direcciondeenvio;
                    $registrarCompra->ciudadenvio = $rec->ciudadenvio;
                    $registrarCompra->estadodeldespacho = $rec->estadodeldespacho;
                    $registrarCompra->estadodelaventa = $rec->estadodelaventa;
                    $registrarCompra->estadodelaventa = $rec->estadodelaventa;
                    $registrarCompra->estadodelafactura = 42;
                    $registrarCompra->ctlrnotificaventa = 0;
                    $registrarCompra->ctlrnotificacompra = 0;

                    $registrarCompra->save();

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

    //Crear vehiculos asociados a productos
    public function crearRechazoCompra($rec)
    {
        DB::beginTransaction();
        try {
                    $db_name = $this->db.".miscomprasrechazadas";
                    $registrarRechazo = new ModelGlobal();
                    $registrarRechazo->setConnection($this->cur_connect);
                    $registrarRechazo->setTable($db_name);
            
                    $registrarRechazo->idproducto = $rec->idproducto;
                    $registrarRechazo->compatible = $rec->compatible;
                    $registrarRechazo->numerodeaprobacion = $rec->numerodeaprobacion;
                    $registrarRechazo->uidcomprador = $rec->uidcomprador;
                    $registrarRechazo->uidvendedor = $rec->uidvendedor;
                    $registrarRechazo->fechacompra =  $date = date('Y-m-d H:i:s');
                    $registrarRechazo->fechaentrega = $rec->fechaentrega;
                    $registrarRechazo->fechadespacho = $rec->fechadespacho;
                    $registrarRechazo->fechadevolucion = $rec->fechadevolucion;
                    $registrarRechazo->fechadepago =  $date = date('Y-m-d H:i:s');
                    $registrarRechazo->formadepago = $rec->formadepago;
                    $registrarRechazo->cantidad = $rec->cantidad;
                    $registrarRechazo->idtransaccionpago = $rec->idtransaccionpago;
                    $registrarRechazo->preciodeventa = $rec->preciodeventa;
                    $registrarRechazo->precioenvio = $rec->precioenvio;
                    $registrarRechazo->retencion = $rec->retencion;
                    $registrarRechazo->impuestos = $rec->impuestos;
                    $registrarRechazo->direcciondeenvio = $rec->direcciondeenvio;
                    $registrarRechazo->ciudadenvio = $rec->ciudadenvio;
                    $registrarRechazo->estadodeldespacho = $rec->estadodeldespacho;
                    $registrarRechazo->estadodelaventa = $rec->estadodelaventa;
                    $registrarRechazo->ctlrnotificaventa = 0;
                    $registrarRechazo->ctlrnotificacompra = 0;

                    $registrarRechazo->save();

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

    public function listarCompras($rec)
    {
        DB::beginTransaction();
        try {
        $db_name = "mercadorepuesto_sys";
                
        $listarcompras = DB::connection($this->cur_connect)->select(
                                                "select t0.*, t1.nombre_ciu as nombreciudad, t2.nombre_dep,
                                                              t2.codigo_dep, t3.razonsocial, t3.identificacion,
                                                              t3.email, t3.celular, 
                                                              concat(t3.primernombre, ' ', t3.primerapellido) as nombres,
                                                              t4.idproductovehiculo, t4.titulonombre, t4.nombreimagen1,
                                                              t5.nombre as mediodepago 
                                                from ".$db_name.'.miscompras'." t0 
                                                JOIN ".$db_name.'.ciudades'." t1 ON t0.ciudadenvio = t1.id_ciu
                                                JOIN ".$db_name.'.departamentos'." t2 ON t1.departamento_ciu = t2.codigo_dep
                                                JOIN ".$db_name.'.users'." t3 ON t0.uidcomprador = t3.uid
                                                JOIN ".$db_name.'.productos'." t4 ON t0.id = t4.id
                                                JOIN ".$db_name.'.formasdepago'." t5 ON t0.formadepago= t5.id
                                                ORDER BY t0.fechacompra ASC");

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
            'listarcompras' => $listarcompras,
            'message' => 'REGISTRO EXITOSO',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    public function listarUnaVenta($rec)
    {
        DB::beginTransaction();
        try {
        $db_name = "mercadorepuesto_sys";
                
        $listarunaventa = DB::connection($this->cur_connect)->select(
                                                "select t0.*, t1.nombre_ciu as nombreciudad, t2.nombre_dep,
                                                              t2.codigo_dep, t3.razonsocial, t3.identificacion,
                                                              t3.email, t3.celular, t0.preciodeventa as total,
                                                              concat(t3.primernombre, ' ', t3.primerapellido) as nombres,
                                                              t4.idproductovehiculo, t4.titulonombre, 
                                                              t4.nombreimagen1 as nombreImagen, 
                                                              t0.fechacompra as fechadeventa,
                                                              t5.nombre as mediodepago,           
                                                              t6.nombre as estadomiscompras,
                                                              t7.nombreestadoalt as estadomisventas, t0.id as idmicompra    
                                                from ".$db_name.'.miscompras'." t0 
                                                JOIN ".$db_name.'.ciudades'." t1 ON t0.ciudadenvio = t1.id_ciu
                                                JOIN ".$db_name.'.departamentos'." t2 ON t1.departamento_ciu = t2.codigo_dep
                                                JOIN ".$db_name.'.users'." t3 ON t0.uidcomprador = t3.uid
                                                JOIN ".$db_name.'.productos'." t4 ON t0.idproducto = t4.id
                                                JOIN ".$db_name.'.formasdepago'." t5 ON t0.formadepago= t5.id
                                                JOIN ".$db_name.'.estados'." t6 ON t0.estadodeldespacho = t6.tipodeestado
                                                JOIN ".$db_name.'.estadosventas'." t7 ON t0.estadodelaventa = t7.tipoestadoalt
                                                WHERE t0.idventa = '". $rec->idventa."'");

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
            'listarunaventa' => $listarunaventa,
            'message' => 'REGISTRO EXITOSO',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    public function listarComprasConsola($rec)
    {
        DB::beginTransaction();
        try {
        $db_name = "mercadorepuesto_sys";
                
        $listarcomprasconsola = DB::connection($this->cur_connect)->select(
                                            "select t0.*, t1.*, t2.*, t0.id as idcompra, t0.fechacompra as fechadecompra,
                                            TRUNCATE(((DATEDIFF(NOW(), t0.fechaactualiza))),1) AS tiempoactualiza,
                                            TRUNCATE(((DATEDIFF(NOW(), t0.fechaactualizafactura))),1) AS tiempofactura,
                                            t2.nombre as estadosmiscompras, t3.nombreestadoalt as estadoalterno,
                                            t6.email, t6.primernombre, t6.primerapellido, t6.razonsocial, 
                                            t6.tipoidentificacion, t6.identificacion, t4.nombreestadofactura as estadofactura,
                                            t7.urlpdf,t7.urlrotulos
                                            from ".$db_name.'.miscompras'." t0 
                                            JOIN ".$db_name.'.productos'." t1 ON t0.idproducto = t1.id 
                                            JOIN ".$db_name.'.estados'."  t2 ON t0.estadodelaventa = t2.tipodeestado
                                            JOIN ".$db_name.'.estadosventas'."  t3 ON t0.estadodeldespacho = t3.tipoestadoalt
                                            JOIN ".$db_name.'.estadosfacturas'."  t4 ON t0.estadodelafactura = t4.tipoestadofactura
                                            JOIN ".$db_name.'.users'." t6 ON t0.uidcomprador = t6.uid
                                       LEFT JOIN ".$db_name.'.controlguiadespachomisvtas'." t7 ON t0.numerodeaprobacion = t7.numerodeventa
                                            ORDER BY t0.numerodeaprobacion DESC");

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
            'listarcomprasconsola' => $listarcomprasconsola,
            'message' => 'REGISTRO EXITOSO',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    public function listarComprasRechazada($rec)
    {
        DB::beginTransaction();
        try {
        $db_name = "mercadorepuesto_sys";
                
        $listarcomprasrechazadas = DB::connection($this->cur_connect)->select(
                                            "select t0.*, t1.*, t2.*, t0.id as idcompra, t0.fechacompra as fechadecompra,
                                            TRUNCATE(((DATEDIFF(NOW(), t0.fechaactualiza))),1) AS tiempoactualiza,
                                            t2.nombre as estadosmiscompras, t3.nombreestadoalt as estadoalterno
                                            from ".$db_name.'.miscomprasrechazadas'." t0
                                            JOIN ".$db_name.'.productos'." t1 ON t0.idproducto = t1.id 
                                            JOIN ".$db_name.'.estados'."  t2 ON t0.estadodelaventa = t2.tipodeestado
                                            JOIN ".$db_name.'.estadosventas'."  t3 ON t0.estadodeldespacho = t3.tipoestadoalt
                                            ORDER BY t0.numerodeaprobacion DESC");

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
            'listarcomprasrechazadas' => $listarcomprasrechazadas,
            'message' => 'REGISTRO EXITOSO',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    public function listarCompraUsuario($rec)
    {
        DB::beginTransaction();
        try {
        $db_name = "mercadorepuesto_sys";
                
        $listarmiscompras = DB::connection($this->cur_connect)->select(
                                                "select t0.*,  t1.nombre as mediodepago, t2.nombre_ciu as nombreciudad,
                                                t3.nombre_dep, t3.codigo_dep, t4.nombre as estadomiscompras,
                                                t5.nombreestadoalt as estadomisventas, t0.id as idmicompra,
                                                t6.urlpdf, t6.urlrotulos
                                                from ".$db_name.'.miscompras'." t0 
                                                JOIN ".$db_name.'.formasdepago'." t1 ON t0.formadepago= t1.id
                                                JOIN ".$db_name.'.ciudades'." t2 ON t0.ciudadenvio = t2.id_ciu
                                                JOIN ".$db_name.'.departamentos'." t3 ON t2.departamento_ciu = t3.codigo_dep
                                                JOIN ".$db_name.'.estados'." t4 ON t0.estadodeldespacho = t4.tipodeestado
                                                JOIN ".$db_name.'.estadosventas'." t5 ON t0.estadodelaventa = t5.tipoestadoalt
                                           LEFT JOIN ".$db_name.'.controlguiadespachomisvtas'." t6 ON t0.numerodeaprobacion = t6.numerodeventa
                                                WHERE t0.uidcomprador = '". $rec->uidcomprador."'
                                                ORDER BY t0.fechacompra DESC"); 

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
            'listarmiscompras' => $listarmiscompras,
            'message' => 'REGISTRO EXITOSO',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    public function listarCompraPrd($rec)
    {
        DB::beginTransaction();
        try {
        $db_name = "mercadorepuesto_sys";
                
        $listarmiscompras = DB::connection($this->cur_connect)->select(
                                                "select t0.*,  t1.nombre as mediodepago, t2.nombre_ciu as nombreciudad,
                                                 t3.nombre_dep, t3.codigo_dep, t4.nombre as estadomiscompras,
                                                 t5.nombreestadoalt as estadomisventas, t0.id as idmicompra,
                                                 t6.nombreimagen1 
                                                from ".$db_name.'.miscompras'." t0 
                                                JOIN ".$db_name.'.formasdepago'." t1 ON t0.formadepago= t1.id
                                                JOIN ".$db_name.'.ciudades'." t2 ON t0.ciudadenvio = t2.id_ciu
                                                JOIN ".$db_name.'.departamentos'." t3 ON t2.departamento_ciu = t3.codigo_dep
                                                JOIN ".$db_name.'.estados'." t4 ON t0.estadodeldespacho = t4.tipodeestado
                                                JOIN ".$db_name.'.estadosventas'." t5 ON t0.estadodelaventa = t5.tipoestadoalt
                                                JOIN ".$db_name.'.productos'." t6 ON t0.idproducto = t6.id
                                                WHERE t0.numerodeaprobacion = '". $rec->numerodeaprobacion."'
                                                ORDER BY t0.fechacompra DESC"); 

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
            'listarmiscompras' => $listarmiscompras,
            'message' => 'REGISTRO EXITOSO',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    public function listarCompraUsuarioNotificacion($rec)
    {
        DB::beginTransaction();
        try {
        $db_name = "mercadorepuesto_sys";
                
        $listarmiscompras = DB::connection($this->cur_connect)->select(
                                                "select t0.*,  t1.nombre as mediodepago, t2.nombre_ciu as nombreciudad,
                                                 t3.nombre_dep, t3.codigo_dep, t4.nombre as estadomiscompras,
                                                 t5.nombreestadoalt as estadomisventas, t0.id as idmicompra 
                                                from ".$db_name.'.miscompras'." t0 
                                                JOIN ".$db_name.'.formasdepago'." t1 ON t0.formadepago= t1.id
                                                JOIN ".$db_name.'.ciudades'." t2 ON t0.ciudadenvio = t2.id_ciu
                                                JOIN ".$db_name.'.departamentos'." t3 ON t2.departamento_ciu = t3.codigo_dep
                                                JOIN ".$db_name.'.estados'." t4 ON t0.estadodeldespacho = t4.tipodeestado
                                                JOIN ".$db_name.'.estadosventas'." t5 ON t0.estadodelaventa = t5.tipoestadoalt
                                                WHERE t0.uidcomprador = '". $rec->uidcomprador."'
                                                AND t0.ctlrnotificacompra = 0
                                                ORDER BY t0.fechacompra DESC"); 

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
            'listarmiscompras' => $listarmiscompras,
            'message' => 'REGISTRO EXITOSO',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    public function listarVentaUsuario($rec)
    {
        DB::beginTransaction();
        try {
        $db_name = "mercadorepuesto_sys";
                
        $listarmisventas = DB::connection($this->cur_connect)->select(
                                                "select t0.*,  t1.nombre as mediodepago, t2.nombre_ciu as nombreciudad,
                                                 t3.nombre_dep, t3.codigo_dep, t4.nombre as estadomiscompras,
                                                 t2.codigo_ciu
                                                from ".$db_name.'.miscompras'." t0 
                                                JOIN ".$db_name.'.formasdepago'." t1 ON t0.formadepago= t1.id
                                                JOIN ".$db_name.'.ciudades'." t2 ON t0.ciudadenvio = t2.id_ciu
                                                JOIN ".$db_name.'.departamentos'." t3 ON t2.departamento_ciu = t3.codigo_dep
                                                JOIN ".$db_name.'.estados'." t4 ON t0.estadodeldespacho = t4.tipodeestado
                                                WHERE t0.uidvendedor = ".$rec->uidvendedor);

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
            'listarmisventas' => $listarmisventas,
            'message' => 'REGISTRO EXITOSO',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    public function listarVentaUsuarioNotificacion($rec)
    {
        DB::beginTransaction();
        try {
        $db_name = "mercadorepuesto_sys";
                
        $listarmisventas = DB::connection($this->cur_connect)->select(
                                                "select t0.*,  t1.nombre as mediodepago, t2.nombre_ciu as nombreciudad,
                                                 t3.nombre_dep, t3.codigo_dep, t4.nombre as estadomiscompras 
                                                from ".$db_name.'.miscompras'." t0 
                                                JOIN ".$db_name.'.formasdepago'." t1 ON t0.formadepago= t1.id
                                                JOIN ".$db_name.'.ciudades'." t2 ON t0.ciudadenvio = t2.id_ciu
                                                JOIN ".$db_name.'.departamentos'." t3 ON t2.departamento_ciu = t3.codigo_dep
                                                JOIN ".$db_name.'.estados'." t4 ON t0.estadodeldespacho = t4.tipodeestado
                                                WHERE t0.uidvendedor = '". $rec->uidvendedor."'
                                                  AND t0.ctlrnotificaventa = 0"); 

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
            'listarmisventas' => $listarmisventas,
            'message' => 'REGISTRO EXITOSO',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    //Actualizar Datos de la compra
    public function actualizarCompra($rec)
    {
        //echo json_encode($rec->id);
        //exit;
        $db_name = $this->db."miscompras";
   
        DB::beginTransaction();
        try {
   
              DB::connection($this->cur_connect)->update("UPDATE ".$db_name." 
                  SET fechaentrega = '".$rec-> fechaentrega."',
                      fechadespacho = '".$rec-> fechadespacho."',
                      estadodeldespacho   = '".$rec-> estadodeldespacho."',
                      precioenvio = '".$rec-> precioenvio."',
                      direcciondeenvio = '".$rec-> direcciondeenvio."',
                      ciudadenvio = '".$rec-> ciudadenvio."',
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

    //Actualizar Estado Compra
    public function actualizaEstadoCompra($rec)
    {
        $db_name = $this->db.".miscompras";
 
        DB::beginTransaction();
        try {
 
            DB::connection($this->cur_connect)->update("UPDATE ".$db_name." 
                SET estadodeldespacho = '".$rec-> estadoventa."',
                    fechaactualiza = '".$date = date('Y-m-d H:i:s')."'
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

    //Actualizar Estado factura Venta
    public function actEstadoFacturaVta($rec)
    {
        $db_name = $this->db.".miscompras";
 
        DB::beginTransaction();
        try {
            DB::connection($this->cur_connect)->update("UPDATE ".$db_name." 
                SET estadodelafactura = '".$rec-> estadofactura."',
                    fechaactualizafactura = '".$date = date('Y-m-d H:i:s')."'
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

    //Actualizar Datos de la compra
    public function actualizaNotificacionCompra($rec)
    {
        $db_name = $this->db.".miscompras";
   
        DB::beginTransaction();
        try {
   
              DB::connection($this->cur_connect)->update("UPDATE ".$db_name." 
                  SET ctlrnotificacompra = 1
                  WHERE numerodeaprobacion = '".$rec->numerodeaprobacion."'");
   
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

    //Actualizar Datos de la compra
    public function actualizaNotificacionVenta($rec)
    {
        $db_name = $this->db.".miscompras";
   
        DB::beginTransaction();
        try {
   
              DB::connection($this->cur_connect)->update("UPDATE ".$db_name." 
                  SET ctlrnotificaventa = 1
                  WHERE numerodeaprobacion = '".$rec->numerodeaprobacion."'");
   
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

    //Grabar calificación producto
    public function saveNotificacion($rec)
    {
        DB::beginTransaction();
        try {
                    $db_name = $this->db.".notificacionesusuarios";
                    $notificaciones = new ModelGlobal();
                    $notificaciones->setConnection($this->cur_connect);
                    $notificaciones->setTable($db_name);

                    $notificaciones->uidusuario = $rec->uidusuario;
                    $notificaciones->idnotificacion = $rec->idnotificacion;
                    $notificaciones->fechacreacion = $date = date('Y-m-d H:i:s');
                    $notificaciones->comentario = $rec->comentario;
                    $notificaciones->tiponotificacion = $rec->tiponotificacion;
                    $notificaciones->estado = $rec->estado;
                    $notificaciones->ctllecturanotifica = 0;
                    
                    $notificaciones->save();

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

    public function listarNotificaciones($rec)
    {
        DB::beginTransaction();
        try {
        $db_name = "mercadorepuesto_sys";
                
        $listarnotificaciones = DB::connection($this->cur_connect)->select(
                                                "select t0.*, t1.nombre as nombrenotificacion, t2.nombre as nombreestado
                                                from ".$db_name.'.notificacionesusuarios'." t0 
                                                JOIN ".$db_name.'.tiponotificacion'." t1 ON t0.tiponotificacion = t1.id
                                                JOIN ".$db_name.'.estados'." t2 ON t0.estado = t2.tipodeestado
                                                WHERE t0.uidusuario = '". $rec->uidusuario."'
                                                  AND t0.estado in (90,91)
                                                  AND t0.ctllecturanotifica in (0)
                                                ORDER BY t0.fechacreacion DESC"); 

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
            'listarnotificaciones' => $listarnotificaciones,
            'message' => 'REGISTRO EXITOSO',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    public function listarAllNotificaciones($rec)
    {
        DB::beginTransaction();
        try {
        $db_name = "mercadorepuesto_sys";
                
        $listarnotificacionesactivas = DB::connection($this->cur_connect)->select(
                                                "select t0.*, t1.nombre as nombrenotificacion, t2.nombre as nombreestado
                                                from ".$db_name.'.notificacionesusuarios'." t0 
                                                JOIN ".$db_name.'.tiponotificacion'." t1 ON t0.tiponotificacion = t1.id
                                                JOIN ".$db_name.'.estados'." t2 ON t0.estado = t2.tipodeestado
                                                WHERE t0.uidusuario = '". $rec->uidusuario."'
                                                  AND t0.estado in (90,91)
                                                ORDER BY t0.fechacreacion DESC"); 

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
            'listarnotificacionesactivas' => $listarnotificacionesactivas,
            'message' => 'REGISTRO EXITOSO',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    //Grabar calificación producto
    public function saveNotificacionAdmom($rec)
    {
        DB::beginTransaction();
        try {
                    $db_name = $this->db.".notificacionesadmonmr";
                    $notificacionesadmon = new ModelGlobal();
                    $notificacionesadmon->setConnection($this->cur_connect);
                    $notificacionesadmon->setTable($db_name);

                    $notificacionesadmon->uidusuario = $rec->uidusuario;
                    $notificacionesadmon->idnotificacion = $rec->idnotificacion;
                    $notificacionesadmon->fechacreacion = $date = date('Y-m-d H:i:s');
                    $notificacionesadmon->comentario = $rec->comentario;
                    $notificacionesadmon->tiponotificacion = $rec->tiponotificacion;
                    $notificacionesadmon->estado = $rec->estado;
                    $notificacionesadmon->ctllecturanotifica = 0;
                    
                    $notificacionesadmon->save();

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

    public function listarNotificacionesAdmon($rec)
    {
        DB::beginTransaction();
        try {
        $db_name = "mercadorepuesto_sys";
                
        $listarnotificacionesadmon = DB::connection($this->cur_connect)->select(
                                                "select t0.*, t1.nombre as nombrenotificacion, t2.nombre as nombreestado
                                                from ".$db_name.'.notificacionesadmonmr'." t0 
                                                JOIN ".$db_name.'.tiponotificacion'." t1 ON t0.tiponotificacion = t1.id
                                                JOIN ".$db_name.'.estados'." t2 ON t0.estado = t2.tipodeestado
                                                WHERE t0.uidusuario = '". $rec->uidusuario."'
                                                  AND t0.estado in (90,91)
                                                  AND t0.ctllecturanotifica in (0)
                                                ORDER BY t0.fechacreacion DESC"); 

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
            'listarnotificacionesadmon' => $listarnotificacionesadmon,
            'message' => 'REGISTRO EXITOSO',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    public function listarAllNotificacionesAdmon($rec)
    {
        DB::beginTransaction();
        try {
        $db_name = "mercadorepuesto_sys";
                
        $listarnotifiactivasadmon = DB::connection($this->cur_connect)->select(
                                                "select t0.*, t1.nombre as nombrenotificacion, t2.nombre as nombreestado
                                                from ".$db_name.'.notificacionesadmonmr'." t0 
                                                JOIN ".$db_name.'.tiponotificacion'." t1 ON t0.tiponotificacion = t1.id
                                                JOIN ".$db_name.'.estados'." t2 ON t0.estado = t2.tipodeestado
                                                WHERE t0.uidusuario = '". $rec->uidusuario."'
                                                  AND t0.estado in (90,91)
                                                ORDER BY t0.fechacreacion DESC"); 

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
            'listarnotifiactivasadmon' => $listarnotifiactivasadmon,
            'message' => 'REGISTRO EXITOSO',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }


    //Eliminar las direcciones del usuario
    public function deleteCompras($rec)
    {
         $db_name = $this->db.".miscompras";
 
         DB::beginTransaction();
         try {
 
            DB::connection($this->cur_connect)->delete("DELETE FROM ".$db_name." 
            WHERE uidcomprador = ".$rec->uidcomprador);
 
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

    //Eliminar modelo vehiculo
    public function borrarUnModelo($rec)
    {
         $db_name = $this->db.".modelos";
 
         DB::beginTransaction();
         try {
 
            DB::connection($this->cur_connect)->delete("DELETE FROM ".$db_name." 
            WHERE id = ".$rec->idmodelo);

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

    //Eliminar marca del vehiculo
    public function borrarUnaMarca($rec)
    {
         $db_name = $this->db.".marcas";
 
         DB::beginTransaction();
         try {
 
            DB::connection($this->cur_connect)->delete("DELETE FROM ".$db_name." 
            WHERE id = ".$rec->idmarca);

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

    //Eliminar una compra
    public function borrarUnaCompra($rec)
    {
         $db_name = $this->db.".miscompras";
 
         DB::beginTransaction();
         try {
 
            DB::connection($this->cur_connect)->delete("DELETE FROM ".$db_name." 
            WHERE uidcomprador = '".$rec->uidcomprador."' 
              AND id = ".$rec->id);

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

    //Crear productos SIIGO
    public function crearTempoMarca($rec)
    {

        DB::beginTransaction();
        try {
                    $db_name = $this->db.".tempomarcas";
                    $crearprdsiigo = new ModelGlobal();
                    $crearprdsiigo->setConnection($this->cur_connect);
                    $crearprdsiigo->setTable($db_name);

                    $crearprdsiigo->carroceria = $rec->carroceria;
                    $crearprdsiigo->estado = $rec->estado;
                    $crearprdsiigo->fechacreacion = $rec->fechacreacion;
                    $crearprdsiigo->id = $rec->id;
                    $crearprdsiigo->imagenmarca = $rec->imagenmarca;
                    $crearprdsiigo->label = $rec->label;
                    $crearprdsiigo->text = $rec->text;
                    $crearprdsiigo->tipovehiculo = $rec->tipovehiculo;
                    $crearprdsiigo->url = $rec->url;
                    $crearprdsiigo->value = $rec->value;
                    
                    $crearprdsiigo->save();

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
            'message' => 'REGISTER TEMPO MARCA',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    //Crear vehiculos asociados a productos
    public function crearRegistroVenta($rec)
    {
        DB::beginTransaction();
        try {
                    $db_name = $this->db.".misventas";
                    $registrarVenta = new ModelGlobal();
                    $registrarVenta->setConnection($this->cur_connect);
                    $registrarVenta->setTable($db_name);
                   
                    $registrarVenta->idproducto = $rec->idproducto;
                    $registrarVenta->idcomprador = $rec->idcomprador;
                    $registrarVenta->idvendedor = $rec->idvendedor;
                    $registrarVenta->fechadeventa = $date = date('Y-m-d H:i:s');
                    $registrarVenta->fechaentrega = $rec->fechaentrega;
                    $registrarVenta->fechadespacho = $rec->fechadespacho;
                    $registrarVenta->fechadevolucion = $rec->fechadevolucion;
                    $registrarVenta->fechadepago = $rec->fechadepago;
                    $registrarVenta->numerodeventa = $rec->numerodeventa;
                    $registrarVenta->cantidad = $rec->cantidad;
                    $registrarVenta->preciodeventa = $rec->preciodeventa;
                    $registrarVenta->preciodelenvio = $rec->preciodelenvio;
                    $registrarVenta->retencion = $rec->retencion;
                    $registrarVenta->impuestos = $rec->impuestos;
                    $registrarVenta->precioenvio = $rec->precioenvio;
                    $registrarVenta->direcciondeenvio = $rec->direcciondeenvio;
                    $registrarVenta->ciudadenvio = $rec->ciudadenvio;
                    $registrarVenta->estadodeldespacho = $rec->estadodeldespacho;
                    $registrarVenta->estadodelaventa = $rec->estadodelaventa;

                         
                    $registrarVenta->save();

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

    public function listarVentas($rec)
    {
        DB::beginTransaction();
        try {
        $db_name = "mercadorepuesto_sys";
                
        $listarventas = DB::connection($this->cur_connect)->select(
                                                "select t0.*, t1.nombre_ciu as nombreciudad, t2.nombre_dep,
                                                              t2.codigo_dep, t3.razonsocial, t3.identificacion,
                                                              t3.email, t3.celular, t0.fechacompra as fechadeventa,
                                                              concat(t3.primernombre, ' ', t3.primerapellido) as nombres,
                                                              t4.idproductovehiculo, t4.titulonombre, t4.nombreimagen1
                                                from ".$db_name.'.misventas'." t0 
                                                JOIN ".$db_name.'.ciudades'." t1 ON t0.ciudadenvio = t1.id_ciu
                                                JOIN ".$db_name.'.departamentos'." t2 ON t1.departamento_ciu = t2.codigo_dep
                                                JOIN ".$db_name.'.users'." t3 ON t0.idcomprador = t3.uid
                                                JOIN ".$db_name.'.productos'." t4 ON t0.idproducto = t4.id
                                                ORDER BY t0.fechadeventa ASC");

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
            'listarventas' => $listarventas,
            'message' => 'REGISTRO EXITOSO',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    public function listarVentaUsuarioVendedor($rec)
    {
        DB::beginTransaction();
        try {
        $db_name = "mercadorepuesto_sys";
                
        $listarvtasusuariovende = DB::connection($this->cur_connect)->select(
                                                "select t0.*, t1.*,  t2.nombre_ciu as nombreciudad,
                                                t3.nombre_dep, t3.codigo_dep 
                                                from ".$db_name.'.misventas'." t0 
                                                JOIN ".$db_name.'.users'." t1 ON t0.idvendedor = t1.uid
                                                JOIN ".$db_name.'.ciudades'." t2 ON t0.ciudadenvio = t2.id_ciu
                                                JOIN ".$db_name.'.departamentos'." t3 ON t2.departamento_ciu = t3.codigo_dep
                                                WHERE t0.idvendedor = ".$rec->idvendedor);

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
            'listarvtasusuariovende' => $listarvtasusuariovende,
            'message' => 'REGISTRO EXITOSO',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    public function listarVentaUsuarioComprador($rec)
    {
        DB::beginTransaction();
        try {
        $db_name = "mercadorepuesto_sys";
                
        $listarvtasusuariocomprador = DB::connection($this->cur_connect)->select(
                                                "select t0.*
                                                from ".$db_name.'.misventas'." t0 
                                                WHERE t0.idcomprador = ".$rec->idcomprador);

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
            'listarvtasusuariocomprador' => $listarvtasusuariocomprador,
            'message' => 'REGISTRO EXITOSO',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    //Actualizar dirección del usuario
    public function actualizarVenta($rec)
    {
        //echo json_encode($rec->id);
        //exit;
        $db_name = $this->db.".direccionesusuarios";
   
        DB::beginTransaction();
        try {
   
              DB::connection($this->cur_connect)->update("UPDATE ".$db_name." 
                  SET fechaentrega = '".$rec-> fechaentrega."',
                      fechadespacho = '".$rec-> fechadespacho."',
                      fechadevolucion   = '".$rec-> fechadevolucion."',
                      precioenvio = '".$rec-> precioenvio."',
                      direcciondeenvio = '".$rec-> direcciondeenvio."',
                      estadodeldespacho = '".$rec-> estadodeldespacho."',
                      estadodelaventa = '".$rec-> estadodelaventa."',
                      ciudadenvio = '".$rec-> ciudadenvio."',
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

    //Crear vehiculos asociados a productos
    public function crearControlNotificaciones($rec)
    {
        DB::beginTransaction();
        try {
                    $db_name = $this->db.".ctrllecturanotificaciones";
                    $ctrlnotificacion = new ModelGlobal();
                    $ctrlnotificacion->setConnection($this->cur_connect);
                    $ctrlnotificacion->setTable($db_name);
                   
                    $ctrlnotificacion->idnotificacion = $rec->idnotificacion;
                    $ctrlnotificacion->uidusuario = $rec->uidusuario;
                    $ctrlnotificacion->fechacreacion = $date = date('Y-m-d H:i:s');
                
                    $ctrlnotificacion->save();
                 
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
   
    public function listarControlNotificacion($rec)
    {
        DB::beginTransaction();
        try {
        $db_name = "mercadorepuesto_sys";
                
        $listarctrlnotificacion = DB::connection($this->cur_connect)->select(
                                                "select t0.*
                                                from ".$db_name.'.ctrllecturanotificaciones'." t0 
                                                WHERE t0.uidusuario = '". $rec->uidusuario."'
                                                ORDER BY t0.fechacreacion DESC"); 

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
            'listarctrlnotificacion' => $listarctrlnotificacion,
            'message' => 'REGISTRO EXITOSO',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    //Crear vehiculos asociados a productos
    public function crearControlFacturaVta($rec)
    {
        DB::beginTransaction();
        try {
                    $db_name = $this->db.".controlfacturasmisvtas";
                    $registrarfacturavta = new ModelGlobal();
                    $registrarfacturavta->setConnection($this->cur_connect);
                    $registrarfacturavta->setTable($db_name);
                   
                    $registrarfacturavta->idproducto = $rec->idproducto;
                    $registrarfacturavta->idcomprador = $rec->idcomprador;
                    $registrarfacturavta->idvendedor = $rec->idvendedor;
                    $registrarfacturavta->fechadeventa = $rec->fechadeventa;
                    $registrarfacturavta->fechacarga = $date = date('Y-m-d H:i:s');
                    $registrarfacturavta->numerodeventa = $rec->numerodeventa;

                    $registrarfacturavta->nombreimagen1 = $rec->nombreimagen1;
                
                    $registrarfacturavta->save();
                 
                    //Imagen base 64 se pasa a un arreglo
                    
                    $nombrefoto[1] = $rec->nombreimagen1;
                    $foto[1] = $rec->imagen1;

                    for ($i = 1; $i <= $rec->numerodeimagenes; $i++) {
                        $this->GuardarIMG($foto[$i] ,$nombrefoto[$i],'imagenesmensajes/');
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

    //Crear vehiculos asociados a productos
    public function crearControlFacturaVtaPDF($rec)
    {
        DB::beginTransaction();
        try {
                    $db_name = $this->db.".controlfacturasmisvtas";
                    $registrarfacturavta = new ModelGlobal();
                    $registrarfacturavta->setConnection($this->cur_connect);
                    $registrarfacturavta->setTable($db_name);
                   
                    $registrarfacturavta->idproducto = $rec->idproducto;
                    $registrarfacturavta->idcomprador = $rec->idcomprador;
                    $registrarfacturavta->idvendedor = $rec->idvendedor;
                    $registrarfacturavta->fechadeventa = $rec->fechadeventa;
                    $registrarfacturavta->fechacarga = $date = date('Y-m-d H:i:s');
                    $registrarfacturavta->numerodeventa = $rec->numerodeventa;

                    $registrarfacturavta->nombreimagen1 = $rec->nombreimagen1;
                
                    $registrarfacturavta->save();
                 
                    //Imagen base 64 se pasa a un arreglo
                
                    $nombrefoto[1] = $rec->nombreimagen1;
                    $foto[1] = $rec->imagen1;

                    //Nombre imagenes se pasa a un arreglo
                    for ($i = 1; $i <= $rec->numerodeimagenes; $i++) {
                        $response = FunctionsCustoms::UploadPDFName($foto[$i],$nombrefoto[1],'imagenesmensajes/');
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

    //Crear guía despacho
    public function crearControlGuiaDespachoPDF($rec)
    {
        DB::beginTransaction();
        try {
                    $db_name = $this->db.".controlguiadespachomisvtas";
                    $registrarguiadespacho = new ModelGlobal();
                    $registrarguiadespacho->setConnection($this->cur_connect);
                    $registrarguiadespacho->setTable($db_name);
                   
                    $registrarguiadespacho->idcomprador =  $rec->idcomprador;
                    $registrarguiadespacho->idproducto =  $rec->idproducto;
                    $registrarguiadespacho->idvendedor =  $rec->idvendedor;
                    $registrarguiadespacho->fechadeventa =  $rec->fechadeventa;
                    $registrarguiadespacho->fechacarga = $date = date('Y-m-d H:i:s');
                    $registrarguiadespacho->numerodeventa =  $rec->numerodeventa;
                    $registrarguiadespacho->numeroguiadespacho =  $rec->numeroguiadespacho;
                    $registrarguiadespacho->nombreimagen1 =  $rec->nombreimagen1;
                    $registrarguiadespacho->remitenteName =  $rec->remitenteName;
                    $registrarguiadespacho->remitenteSurName =  $rec->remitenteSurName;
                    $registrarguiadespacho->remitenteCellPhone =  $rec->remitenteCellPhone;
                    $registrarguiadespacho->remitentePrefix =  $rec->remitentePrefix;
                    $registrarguiadespacho->remitenteEmail =  $rec->remitenteEmail;
                    $registrarguiadespacho->remitentePickupAddress =  $rec->remitentePickupAddress;
                    $registrarguiadespacho->remitenteNit =  $rec->remitenteNit;
                    $registrarguiadespacho->selectedTipoIdentificacion =  $rec->selectedTipoIdentificacion;
                    $registrarguiadespacho->destinatarioName =  $rec->destinatarioName;
                    $registrarguiadespacho->destinatarioSurName =  $rec->destinatarioSurName;
                    $registrarguiadespacho->destinatarioCellPhone =  $rec->destinatarioCellPhone;
                    $registrarguiadespacho->destinatarioPrefix =  $rec->destinatarioPrefix;
                    $registrarguiadespacho->destinatarioEmail =  $rec->destinatarioEmail;
                    $registrarguiadespacho->destinatarioPickupAddress =  $rec->destinatarioPickupAddress;
                    $registrarguiadespacho->destinatarioNit =  $rec->destinatarioNit;
                    $registrarguiadespacho->tipoIdentificacionDesti =  $rec->tipoIdentificacionDesti;
                    $registrarguiadespacho->urlpdf =  $rec->urlpdf;
                    $registrarguiadespacho->urlrotulos =  $rec->urlrotulos;
                    $registrarguiadespacho->quantity =  $rec->quantity;
                    $registrarguiadespacho->width =  $rec->width;
                    $registrarguiadespacho->large =  $rec->large;
                    $registrarguiadespacho->height =  $rec->height;
                    $registrarguiadespacho->weight =  $rec->weight;
                    $registrarguiadespacho->forbiddenProduct =  $rec->forbiddenProduct;
                    $registrarguiadespacho->productReference =  $rec->productReference;
                    $registrarguiadespacho->declaredValue =  $rec->declaredValue;
                    $registrarguiadespacho->originDaneCode =  $rec->originDaneCode;
                    $registrarguiadespacho->destinyDaneCode =  $rec->destinyDaneCode;
                    $registrarguiadespacho->interCode =  $rec->interCode;
                    $registrarguiadespacho->channel =  $rec->channel;
                    $registrarguiadespacho->deliveryCompany =  $rec->deliveryCompany;
                    $registrarguiadespacho->criteria =  $rec->criteria;
                    $registrarguiadespacho->description =  $rec->description;
                    $registrarguiadespacho->comments =  $rec->comments;
                    $registrarguiadespacho->paymentType =  $rec->paymentType;
                    $registrarguiadespacho->valueCollection =  $rec->valueCollection;
                    $registrarguiadespacho->requestPickup =  $rec->requestPickup;
                    $registrarguiadespacho->adminTransactionData =  $rec->adminTransactionData;
                    $registrarguiadespacho->saleValue =  $rec->saleValue;
                    

                    $registrarguiadespacho->save();

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
            'message' => 'REGISTRO GUIA DESPACHO',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    public function listarControlFacturaVta($rec)
    {
        DB::beginTransaction();
        try {
        $db_name = "mercadorepuesto_sys";
                
        $listarcontfacturavta = DB::connection($this->cur_connect)->select(
                                                "select t0.*, t1.razonsocial, t1.identificacion,
                                                              t1.email, t1.celular, t0.nombreimagen1 as imgfacturavta,
                                                              concat(t1.primernombre, ' ', t1.primerapellido) as nombres,
                                                              t2.idproductovehiculo, t2.titulonombre, t2.nombreimagen1,
                                                              t3.estadodelafactura
                                                from ".$db_name.'.controlfacturasmisvtas'." t0 
                                                JOIN ".$db_name.'.users'." t1 ON t0.idcomprador = t1.uid
                                                JOIN ".$db_name.'.productos'." t2 ON t0.idproducto = t2.id
                                                JOIN ".$db_name.'.miscompras'." t3 ON t0.numerodeventa = t3.numerodeaprobacion
                                                WHERE t0.numerodeventa = '". $rec->numerodeventa."'
                                                ORDER BY t0.fechadeventa DESC"); 

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
            'listarcontfacturavta' => $listarcontfacturavta,
            'message' => 'REGISTRO EXITOSO',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    public function listarControlGuiaDespacho($rec)
    {
        DB::beginTransaction();
        try {
        $db_name = "mercadorepuesto_sys";
                
        $listarcontguiadespacho = DB::connection($this->cur_connect)->select(
                                                "select t0.*, t1.razonsocial, t1.identificacion,
                                                              t1.email, t1.celular, t0.nombreimagen1 as pdfguiadespacho,
                                                              concat(t1.primernombre, ' ', t1.primerapellido) as nombres,
                                                              t2.idproductovehiculo, t2.titulonombre, t2.nombreimagen1,
                                                              t3.estadodelafactura
                                                from ".$db_name.'.controlguiadespachomisvtas'." t0 
                                                JOIN ".$db_name.'.users'." t1 ON t0.idcomprador = t1.uid
                                                JOIN ".$db_name.'.productos'." t2 ON t0.idproducto = t2.id
                                                JOIN ".$db_name.'.miscompras'." t3 ON t0.numerodeventa = t3.numerodeaprobacion
                                                WHERE t0.numerodeventa = '". $rec->numerodeventa."'
                                                ORDER BY t0.fechadeventa DESC"); 

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
            'listarcontguiadespacho' => $listarcontguiadespacho,
            'message' => 'REGISTRO EXITOSO',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    public function listarFacturasVentaPrd($rec)
    {
        DB::beginTransaction();
        try {
        $db_name = "mercadorepuesto_sys";
                
        $listafacturasvtaprd = DB::connection($this->cur_connect)->select(
                                                "select t0.*, t1.razonsocial, t1.identificacion,
                                                              t1.email, t1.celular,  t0.nombreimagen1 as imgfacturavta,
                                                              concat(t1.primernombre, ' ', t1.primerapellido) as nombres,
                                                              t2.idproductovehiculo, t2.titulonombre, t2.nombreimagen1
                                                from ".$db_name.'.controlfacturasmisvtas'." t0 
                                                JOIN ".$db_name.'.users'." t1 ON t0.idcomprador = t1.uid
                                                JOIN ".$db_name.'.productos'." t2 ON t0.idproducto = t2.id
                                                ORDER BY t0.fechadeventa DESC"); 

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
            'listafacturasvtaprd' => $listafacturasvtaprd,
            'message' => 'REGISTRO EXITOSO',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    public function listarGuiasDespacho($rec)
    {
        DB::beginTransaction();
        try {
        $db_name = "mercadorepuesto_sys";
                
        $listarguiasdespacho = DB::connection($this->cur_connect)->select(
                                                "select t0.*, t1.razonsocial, t1.identificacion,
                                                              t1.email, t1.celular,  t0.nombreimagen1 as imgdespacho,
                                                              concat(t1.primernombre, ' ', t1.primerapellido) as nombres,
                                                              t2.idproductovehiculo, t2.titulonombre, t2.nombreimagen1
                                                from ".$db_name.'.controlguiadespachomisvtas'." t0 
                                                JOIN ".$db_name.'.users'." t1 ON t0.idcomprador = t1.uid
                                                JOIN ".$db_name.'.productos'." t2 ON t0.idproducto = t2.id
                                                ORDER BY t0.fechadeventa DESC"); 

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
            'listarguiasdespacho' => $listarguiasdespacho,
            'message' => 'REGISTRO EXITOSO',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    public function listarFacturaVendedor($rec)
    {
        DB::beginTransaction();
        try {
        $db_name = "mercadorepuesto_sys";
                
        $listarfacturavendedor = DB::connection($this->cur_connect)->select(
                                                "select t0.*, t1.* 
                                                from ".$db_name.'.controlfacturasmisvtas'." t0 
                                                JOIN ".$db_name.'.users'." t1 ON t0.idvendedor = t1.uid
                                                WHERE t0.idvendedor = ".$rec->idvendedor);

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
            'listarfacturavendedor' => $listarfacturavendedor,
            'message' => 'REGISTRO EXITOSO',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    //Crear vehiculos asociados a productos
    public function crearCuentaxCobrar($rec)
    {
        DB::beginTransaction();
        try {
                    $db_name = $this->db.".cuentasxcobrar";
                    $registrarctaxcobrar = new ModelGlobal();
                    $registrarctaxcobrar->setConnection($this->cur_connect);
                    $registrarctaxcobrar->setTable($db_name);
            
                    $registrarctaxcobrar->concepto = $rec-> concepto;
                    $registrarctaxcobrar->idproducto = $rec->idproducto;
                    $registrarctaxcobrar->compatible = $rec->compatible;
                    $registrarctaxcobrar->idtransaccionpago = $rec->idtransaccionpago;
                    $registrarctaxcobrar->numeroctaxcobrar = $rec->numeroctaxcobrar;
                    $registrarctaxcobrar->numerodecompra = $rec->numerodecompra;
                    $registrarctaxcobrar->conceptopago = $rec->conceptopago;
                    $registrarctaxcobrar->uidvendedor = $rec->uidvendedor;
                    $registrarctaxcobrar->fechacreacion =  $date = date('Y-m-d H:i:s');
                    $registrarctaxcobrar->fechaactualiza =  $date = date('Y-m-d H:i:s');
                    $registrarctaxcobrar->fechaentrega = $rec->fechaentrega;
                    $registrarctaxcobrar->fechadelaventa = $rec->fechadelaventa;
                    $registrarctaxcobrar->fechadevolucion = $rec->fechadevolucion;
                    $registrarctaxcobrar->fechadepago =  $rec->fechadepago;
                    $registrarctaxcobrar->fechadevencimiento =  null;
                    $registrarctaxcobrar->formadepago = $rec->formadepago;
                    $registrarctaxcobrar->valordelaventa = $rec->valordelaventa;
                    $registrarctaxcobrar->preciodelservicio = $rec->preciodelservicio;
                    $registrarctaxcobrar->precioenvio = $rec->precioenvio;
                    $registrarctaxcobrar->retencion = $rec->retencion;
                    $registrarctaxcobrar->impuestos = $rec->impuestos;

                    $registrarctaxcobrar->titulomensaje = $rec->titulomensaje;
                    $registrarctaxcobrar->mensajevendedor = $rec->mensajevendedor;

                    $registrarctaxcobrar->estadodelpago = $rec->estadodelpago;

                    $registrarctaxcobrar->save();

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

    public function listarCuentaxCobrar($rec)
    {
        DB::beginTransaction();
        try {
        $db_name = "mercadorepuesto_sys";
                
        $listarcompras = DB::connection($this->cur_connect)->select(
                                                "select t0.*, t1.razonsocial, t1.identificacion, 
                                                              t0.fechacreacion as fechacreactaxcobrar,
                                                              t1.email, t1.celular, 
                                                              concat(t1.primernombre, ' ', t1.primerapellido) as nombres,
                                                              t2.idproductovehiculo, t2.titulonombre,
                                                              t3.nombre as mediodepago,
                                                              t4.nombre as nombreestadopago,
                                                              t5.nombre as nombreconceptopago,
                                                              t6.descripcion as conceptofacturacion,
                                                              t7.uidcomprador,
                                                TRUNCATE(((DATEDIFF(NOW(), t0.fechaactualiza))),1) AS tiempoactualiza
                                                from ".$db_name.'.cuentasxcobrar'." t0 
                                                JOIN ".$db_name.'.users'." t1 ON t0.uidvendedor = t1.uid
                                                JOIN ".$db_name.'.productos'." t2 ON t0.idproducto = t2.id
                                                JOIN ".$db_name.'.formasdepago'." t3 ON t0.formadepago= t3.id
                                                JOIN ".$db_name.'.estados'." t4 ON t0.estadodelpago = t4.tipodeestado
                                                JOIN ".$db_name.'.conceptopago'." t5 ON t0.conceptopago = t5.id
                                                JOIN ".$db_name.'.tipopendientefacturar'." t6 ON t0.concepto = t6.id
                                                JOIN ".$db_name.'.miscompras'." t7 ON t0.numerodecompra = t7.numerodeaprobacion
                                                ORDER BY t0.fechacreacion ASC");

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
            'listarcompras' => $listarcompras,
            'message' => 'REGISTRO EXITOSO',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    public function listarCxCUsuario($rec)
    {
        DB::beginTransaction();
        try {
        $db_name = "mercadorepuesto_sys";
                
        $listarcompras = DB::connection($this->cur_connect)->select(
                                                "select t0.*, t1.razonsocial, t1.identificacion,
                                                              t1.email, t1.celular, 
                                                              concat(t1.primernombre, ' ', t1.primerapellido) as nombres,
                                                              t2.idproductovehiculo, t2.titulonombre,
                                                              t3.nombre as mediodepago,
                                                              t4.nombre as nombreestadopago,
                                                              t5.nombre as nombreconceptopago,
                                                              t6.descripcion as conceptofacturacion
                                                from ".$db_name.'.cuentasxcobrar'." t0 
                                                JOIN ".$db_name.'.users'." t1 ON t0.uidvendedor = t1.uid
                                                JOIN ".$db_name.'.productos'." t2 ON t0.id = t2.id
                                                JOIN ".$db_name.'.formasdepago'." t3 ON t0.formadepago= t3.id
                                                JOIN ".$db_name.'.estados'." t4 ON t0.estadodelpago = t4.tipodeestado
                                                JOIN ".$db_name.'.conceptopago'." t5 ON t0.conceptopago = t5.id
                                                JOIN ".$db_name.'.tipopendientefacturar'." t6 ON t0.concepto = t6.id
                                                WHERE t0.uidvendedor = '". $rec->uidvendedor."'
                                                ORDER BY t0.fechacompra DESC"); 
                                                //WHERE t0.numerodeventa = '". $rec->numerodeventa."'
                                                //ORDER BY t0.fechadeventa DESC"); 

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
            'listarcompras' => $listarcompras,
            'message' => 'REGISTRO EXITOSO',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    public function listarCxCUsuarioEstado($rec)
    {
        DB::beginTransaction();
        try {
        $db_name = "mercadorepuesto_sys";
                
        $listarcompras = DB::connection($this->cur_connect)->select(
                                                "select t0.*, t1.razonsocial, t1.identificacion,
                                                              t1.email, t1.celular, 
                                                              concat(t1.primernombre, ' ', t1.primerapellido) as nombres,
                                                              t2.idproductovehiculo, t2.titulonombre,
                                                              t3.nombre as mediodepago,
                                                              t4.nombre as nombreestadopago,
                                                              t5.nombre as nombreconceptopago,
                                                              t6.descripcion as conceptofacturacion
                                                from ".$db_name.'.cuentasxcobrar'." t0 
                                                JOIN ".$db_name.'.users'." t1 ON t0.uidvendedor = t1.uid
                                                JOIN ".$db_name.'.productos'." t2 ON t0.id = t2.id
                                                JOIN ".$db_name.'.formasdepago'." t3 ON t0.formadepago= t3.id
                                                JOIN ".$db_name.'.estados'." t4 ON t0.estadodelpago = t4.tipodeestado
                                                JOIN ".$db_name.'.conceptopago'." t5 ON t0.conceptopago = t5.id
                                                JOIN ".$db_name.'.tipopendientefacturar'." t6 ON t0.concepto = t6.id
                                                WHERE t0.uidvendedor   = '". $rec->uidvendedor."'
                                                  AND t0.estadodelpago = '". $rec->estadodelpago."'
                                                ORDER BY t0.fechacompra DESC"); 

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
            'listarcompras' => $listarcompras,
            'message' => 'REGISTRO EXITOSO',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    //Actualizar Datos de la cuenta x cobrar
    public function actualizarCuentaxCobrar($rec)
    {
        //echo json_encode($rec->id);
        //exit;
        $db_name = $this->db."cuentasxcobrar";
   
        DB::beginTransaction();
        try {
   
              DB::connection($this->cur_connect)->update("UPDATE ".$db_name." 
                  SET fechaentrega = '".$rec-> fechaentrega."',
                      fechadevolucion = '".$rec-> fechadevolucion."',
                      fechadepago = '".$rec-> fechadepago."',
                      fechadevencimiento = '".$rec-> fechadevencimiento."',
                      estadodelpago = '".$rec-> estadodelpago."'
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

    //Actualizar Datos de la cuenta x cobrar
    public function actualizarEstadoCxC($rec)
    {
        //echo json_encode($rec->id);
        //exit;
        $db_name = $this->db.".cuentasxcobrar";
   
        DB::beginTransaction();
        try {
   
              DB::connection($this->cur_connect)->update("UPDATE ".$db_name." 
                  SET estadodelpago = '".$rec-> estadodelpago."',
                      fechadelaventa = '".$rec-> fechadelaventa."',
                      fechadevencimiento = '".$rec-> fechadevencimiento."'
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

    //Actualizar Datos de la cuenta x cobrar
    public function actualizarEstadoCxCSiigo($rec)
    {
        //echo json_encode($rec->id);
        //exit;
        $db_name = $this->db.".cuentasxcobrar";
   
        DB::beginTransaction();
        try {
   
              DB::connection($this->cur_connect)->update("UPDATE ".$db_name." 
                  SET estadodelpago = '".$rec-> estadodelpago."',
                      idfacturasiigo = '".$rec-> idfacturasiigo."',
                      public_url = '".$rec-> public_url."',
                      facturasiigo = '".$rec-> facturasiigo."',
                      numerofactura = '".$rec-> numerofactura."',
                      fechacreacionsiigo = '".$rec-> fechacreacionsiigo."'
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

    //Actualiza datos del usuario
    public function actualizarMensajesFactura($rec)
    {
        //echo json_encode($rec->id);
        //exit;
        $db_name = $this->db.".cuentasxcobrar";
 
        DB::beginTransaction();
        try {
 
            DB::connection($this->cur_connect)->update("UPDATE ".$db_name." 
                SET titulomensaje = '".$rec-> titulomensaje."',
                    mensajevendedor = '".$rec-> mensajevendedor."'
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

    //Crear resolver dudas a preguntas o inquietudes que pueda tener el vendedor
    public function crearResolverDudasVend($rec)
    {
        DB::beginTransaction();
        try {
                    $db_name = $this->db.".resolverdudasvendedores";
                    $savedudasvendedor = new ModelGlobal();
                    $savedudasvendedor->setConnection($this->cur_connect);
                    $savedudasvendedor->setTable($db_name);
            
                    $savedudasvendedor->id = $rec->id;
                    $savedudasvendedor->nombre = $rec->nombre;
                    $savedudasvendedor->descripcion = $rec->descripcion;
                    
                    $savedudasvendedor->save();

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

    public function listarResolverDudasVend($rec)
    {
        DB::beginTransaction();
        try {
        $db_name = "mercadorepuesto_sys";
                
        $listaresoldudasvende = DB::connection($this->cur_connect)->select(
                                                "select t0.*
                                                from ".$db_name.'.resolverdudasvendedores'." t0 
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
            'listaresoldudasvende' => $listaresoldudasvende,
            'message' => 'REGISTRO EXITOSO',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    //Actualizar Resolver dudas que tenga el vendedor
    public function actualizarResolverDudasVend($rec)
    {
        $db_name = $this->db.".resolverdudasvendedores";
 
        DB::beginTransaction();
        try {
 
            DB::connection($this->cur_connect)->update("UPDATE ".$db_name." 
                SET nombre = '".$rec-> nombre."',
                    descripcion = '".$rec-> descripcion."'
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

    //Grabar imagenes carrusel
    public function crearImgCarrusel($rec)
    {
        DB::beginTransaction();
        try {
                    $db_name = $this->db.".imagenescarrusel";
                    $saveimgcarrusel = new ModelGlobal();
                    $saveimgcarrusel->setConnection($this->cur_connect);
                    $saveimgcarrusel->setTable($db_name);
            
                    $saveimgcarrusel->id = $rec->id;
                    $saveimgcarrusel->nombreimagen = $rec->nombreimagen;
                    
                    $saveimgcarrusel->save();

                    $foto[1] = $rec->imagen;
                   
                    //Nombre imagenes se pasa a un arreglo
                    $nombrefoto[1] = $rec->nombreimagen;
    
                    for ($i = 1; $i <= $rec->numeroimagenes; $i++) {
                        $this->GuardarIMG($foto[$i] ,$nombrefoto[$i],'imagenesmensajes/');
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

    public function listarImgCarrusel($rec)
    {
        DB::beginTransaction();
        try {
        $db_name = "mercadorepuesto_sys";
                
        $listimgcarrusel = DB::connection($this->cur_connect)->select(
                                                "select t0.*
                                                from ".$db_name.'.imagenescarrusel'." t0 
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
            'listimgcarrusel' => $listimgcarrusel,
            'message' => 'REGISTRO EXITOSO',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    //Actualizar Resolver dudas que tenga el vendedor
    public function actualizarImgCarrusel($rec)
    {
        $db_name = $this->db.".imagenescarrusel";
 
        DB::beginTransaction();
        try {
 
            DB::connection($this->cur_connect)->update("UPDATE ".$db_name." 
                SET nombreimagen = '".$rec->nombreimagen."'
                WHERE id = '".$rec->id."'");

                $foto[1] = $rec->imagen;
                   
                //Nombre imagenes se pasa a un arreglo
                $nombrefoto[1] = $rec->nombreimagen;

                for ($i = 1; $i <= $rec->numeroimagenes; $i++) {
                    $this->GuardarIMG($foto[$i] ,$nombrefoto[$i],'imagenesmensajes/');
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

    //Grabar imagenes Categorias
    public function crearImgCategorias($rec)
    {
        DB::beginTransaction();
        try {
                    $db_name = $this->db.".imagenescategorias";
                    $saveimgcategorias = new ModelGlobal();
                    $saveimgcategorias->setConnection($this->cur_connect);
                    $saveimgcategorias->setTable($db_name);
            
                    $saveimgcategorias->id = $rec->id;
                    $saveimgcategorias->nombreimagen = $rec->nombreimagen;
                    
                    $saveimgcategorias->save();

                    $foto[1] = $rec->imagen;
                   
                    //Nombre imagenes se pasa a un arreglo
                    $nombrefoto[1] = $rec->nombreimagen;
    
                    for ($i = 1; $i <= $rec->numeroimagenes; $i++) {
                        $this->GuardarIMG($foto[$i] ,$nombrefoto[$i],'imagenesmensajes/');
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

    public function listarImgCategorias($rec)
    {
        DB::beginTransaction();
        try {
        $db_name = "mercadorepuesto_sys";
                
        $listimgcategorias = DB::connection($this->cur_connect)->select(
                                                "select t0.*
                                                from ".$db_name.'.imagenescategorias'." t0 
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
            'listimgcategorias' => $listimgcategorias,
            'message' => 'REGISTRO EXITOSO',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    //Actualizar Resolver dudas que tenga el vendedor
    public function actualizarImgCategorias($rec)
    {
        $db_name = $this->db.".imagenescategorias";
 
        DB::beginTransaction();
        try {
 
            DB::connection($this->cur_connect)->update("UPDATE ".$db_name." 
                SET nombrecategoria = '".$rec->nombrecategoria."', 
                    nombreimagen = '".$rec->nombreimagen."'
                WHERE id = '".$rec->id."'");

                $foto[1] = $rec->imagen;
                   
                //Nombre imagenes se pasa a un arreglo
                $nombrefoto[1] = $rec->nombreimagen;

                for ($i = 1; $i <= $rec->numeroimagenes; $i++) {
                    $this->GuardarIMG($foto[$i] ,$nombrefoto[$i],'imagenesmensajes/');
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
    public function actualizarEstadoCategoria($rec)
    {
        $db_name = $this->db.".imagenescategorias";
 
        DB::beginTransaction();
        try {
 
            DB::connection($this->cur_connect)->update("UPDATE ".$db_name." 
                SET estado = '".$rec->estado."'
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

    public function listarImgMarcas($rec)
    {
        DB::beginTransaction();
        try {
        $db_name = "mercadorepuesto_sys";
                
        $listimgmarcas = DB::connection($this->cur_connect)->select(
                                                "select t0.*
                                                from ".$db_name.'.imagenesmarcas'." t0 
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
            'listimgmarcas' => $listimgmarcas,
            'message' => 'REGISTRO EXITOSO',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    public function listarMarcasPrd($rec)
    {
        DB::beginTransaction();
        try {
        $db_name = "mercadorepuesto_sys";
                
        $listimgmarcas = DB::connection($this->cur_connect)->select(
                                                "select DISTINCT CONCAT(t0.tipovehiculo, t0.marca) AS tipomarca,
                                                        t0.tipovehiculo, t0.marca, t1.text, t1.imagenmarca,
                                                        t2.text as nombretipoveh, t3.carroceria, t1.id as idmarca
                                                from ".$db_name.'.productos'." t0
                                                JOIN ".$db_name.'.marcas'."  t1
                                                JOIN ".$db_name.'.tiposvehiculos'." t2 ON t0.tipovehiculo = t2.id
                                                JOIN ".$db_name.'.tiposcarrocerias'." t3 ON t0.carroceria = t3.id
                                                WHERE t0.marca = t1.id
                                                  AND t0.tipovehiculo = t3.tipovehiculo
                                                  AND t1.id > 0");

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
            'listimgmarcas' => $listimgmarcas,
            'message' => 'REGISTRO EXITOSO',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    //Actualizar Resolver dudas que tenga el vendedor
    public function actualizarImgMarcas($rec)
    {
        $db_name = $this->db.".marcas";
 
        DB::beginTransaction();
        try {
 
            DB::connection($this->cur_connect)->update("UPDATE ".$db_name." 
                SET imagenmarca = '".$rec->imagenmarca."'
                WHERE id = '".$rec->id."'");

                $foto[1] = $rec->imagen;
                   
                //Nombre imagenes se pasa a un arreglo
                $nombrefoto[1] = $rec->imagenmarca;

                for ($i = 1; $i <= $rec->numeroimagenes; $i++) {
                    $this->GuardarIMG($foto[$i] ,$nombrefoto[$i],'mercadorepuesto/marcas/');
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



    /*                DESDE AQUI BORRARAR *****************************/

    public function actualizaDctoRetiro($rec)
    {

        $db_name = $this->db.".users";
   
        DB::beginTransaction();
        try {
            DB::connection($this->cur_connect)->update("UPDATE ".$db_name." 
                    SET archivoretirouno    = '".$rec-> nombreimagen1."',
                        fechaactualizadctos = '".$date = date('Y-m-d H:i:s')."'
                    WHERE uid = '".$rec->uid."'");

                    //Imagen base 64 se pasa a un arreglo
                    $nombrefoto[1] = $rec->nombreimagen1;
                    $foto[1] = $rec->imagen1;

                    for ($i = 1; $i <= $rec->numerodeimagenes; $i++) {
                        $this->GuardarIMG($foto[$i] ,$nombrefoto[$i],'imagenesmensajes/');
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

    //Create Certificate Employee
    public function pdfActualizaDctoRetiro($rec)
    {

        $db_name = $this->db.".users";
   
        DB::beginTransaction();
        try {
            DB::connection($this->cur_connect)->update("UPDATE ".$db_name." 
                    SET archivoretirouno = '".$rec-> nombreimagen1."',
                        fechaactualizadctos = '".$date = date('Y-m-d H:i:s')."'
                    WHERE uid = '".$rec->uid."'");

                    //Imagen base 64 se pasa a un arreglo
                    $nombrefoto[1] = $rec->nombreimagen1;
                    $foto[1] = $rec->imagen1;

                    for ($i = 1; $i <= $rec->numerodeimagenes; $i++) {
                        $response = FunctionsCustoms::UploadPDFName($foto[$i],$nombrefoto[1],'imagenesmensajes/');
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
        
    public function actualizaDctoRetiroDos($rec)
    {

        $db_name = $this->db.".users";
   
        DB::beginTransaction();
        try {
            DB::connection($this->cur_connect)->update("UPDATE ".$db_name." 
                    SET archivoretirodos = '".$rec-> nombreimagen1."',
                        fechaactualizadctos = '".$date = date('Y-m-d H:i:s')."'
                    WHERE uid = '".$rec->uid."'");

                    //Imagen base 64 se pasa a un arreglo
                    $nombrefoto[1] = $rec->nombreimagen1;
                    $foto[1] = $rec->imagen1;

                    for ($i = 1; $i <= $rec->numerodeimagenes; $i++) {
                        $this->GuardarIMG($foto[$i] ,$nombrefoto[$i],'imagenesmensajes/');
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

    //Create Certificate Employee
    public function pdfActualizaDctoRetiroDos($rec)
    {

        $db_name = $this->db.".users";
   
        DB::beginTransaction();
        try {
            DB::connection($this->cur_connect)->update("UPDATE ".$db_name." 
                    SET archivoretirodos = '".$rec-> nombreimagen1."',
                        fechaactualizadctos = '".$date = date('Y-m-d H:i:s')."'
                    WHERE uid = '".$rec->uid."'");

                    //Imagen base 64 se pasa a un arreglo
                    $nombrefoto[1] = $rec->nombreimagen1;
                    $foto[1] = $rec->imagen1;

                    for ($i = 1; $i <= $rec->numerodeimagenes; $i++) {
                        $response = FunctionsCustoms::UploadPDFName($foto[$i],$nombrefoto[1],'imagenesmensajes/');
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

/********HASTA BORRAR REGISTROS IMG USUARIOS */







    //Documentos retiros usuarios
    public function grabarDctoRetiro($rec)
    {
        DB::beginTransaction();
        try {
                    $db_name = $this->db.".dctostransaretiros";
                    $grabardctoretiro = new ModelGlobal();
                    $grabardctoretiro->setConnection($this->cur_connect);
                    $grabardctoretiro->setTable($db_name);

                    //$grabardctoretiro->idscopework = $rec->idscopework;
                    $grabardctoretiro->idtransaccion = $rec->idtransaccion;
                    $grabardctoretiro->nameimg = $rec->nombreimagen1;
                    $grabardctoretiro->nombrearchivo = $rec->nombrearchivo;
                    $grabardctoretiro->uidusuario = $rec->uidusuario;
                    $grabardctoretiro->fechacreacion = $date = date('Y-m-d H:i:s');
                    $grabardctoretiro->fechaactualiza = $date = date('Y-m-d H:i:s');

                    $grabardctoretiro->save();
                    
                    //Imagen base 64 se pasa a un arreglo
                    $nombrefoto[1] = $rec->nombreimagen1;
                    $foto[1] = $rec->imagen1;

                    for ($i = 1; $i <= $rec->numerodeimagenes; $i++) {
                        $this->GuardarIMG($foto[$i] ,$nombrefoto[$i],'imagenesmensajes/');
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
            'message' => 'REGISTER DOCUMENT EMPLOYEE OK',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    //Documentos retiros usuarios
    public function grabarDctoRetiroPDF($rec)
    {
        DB::beginTransaction();
        try {
                    $db_name = $this->db.".dctostransaretiros";
                    $grabardctoretiro = new ModelGlobal();
                    $grabardctoretiro->setConnection($this->cur_connect);
                    $grabardctoretiro->setTable($db_name);

                    //$grabardctoretiro->idscopework = $rec->idscopework;
                    $grabardctoretiro->idtransaccion = $rec->idtransaccion;
                    $grabardctoretiro->nameimg = $rec->nombreimagen1;
                    $grabardctoretiro->uidusuario = $rec->uidusuario;
                    $grabardctoretiro->nombrearchivo = $rec->nombrearchivo;
                    $grabardctoretiro->fechacreacion = $date = date('Y-m-d H:i:s');
                    $grabardctoretiro->fechaactualiza = $date = date('Y-m-d H:i:s');

                    $grabardctoretiro->save();
                    
                    //Imagen base 64 se pasa a un arreglo
                    $nombrefoto[1] = $rec->nombreimagen1;

                    $foto[1] = $rec->imagen1;

                    for ($i = 1; $i <= $rec->numerodeimagenes; $i++) {
                        $response = FunctionsCustoms::UploadPDFName($foto[$i],$nombrefoto[1],'imagenesmensajes/');
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
            'message' => 'REGISTER service team member',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    // Listar Documentos retiros usuarios
    public function listarDctoRetiro($rec)
    {
        //echo json_encode($rec->idinterno);
        //exit;
        DB::beginTransaction();
        try {
            $db_name = "mercadorepuesto_sys";
                
        $listardctotransac = DB::connection($this->cur_connect)->select(
                                                            "select t0.*
                                                            from ".$db_name.'.dctostransaretiros'." t0
                                                            WHERE t0.idtransaccion = '".$rec->idtransaccion."'
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
            'listardctotransac' => $listardctotransac,
            'message' => 'Listar documentos transacción',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    // Listar Documentos retiros usuarios
    public function listarDctoRetiroUsu($rec)
    {
        //echo json_encode($rec->idinterno);
        //exit;
        DB::beginTransaction();
        try {
            $db_name = "mercadorepuesto_sys";
                
        $listardctotransac = DB::connection($this->cur_connect)->select(
                                                            "select t0.*
                                                            from ".$db_name.'.dctostransaretiros'." t0
                                                            WHERE t0.uidusuario = '".$rec->uidusuario."'
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
            'listardctotransac' => $listardctotransac,
            'message' => 'Listar documentos transacción',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    public function editarDctoRetiro($rec)
    {

        $db_name = $this->db.".dctostransaretiros";
   
        DB::beginTransaction();
        try {
            DB::connection($this->cur_connect)->update("UPDATE ".$db_name." 
                    SET nameimg        = '".$rec-> nombreimagen1."',
                        fechaactualiza = '".$date = date('Y-m-d H:i:s')."'
                    WHERE id = '".$rec->id."'");

                    //Imagen base 64 se pasa a un arreglo
                    $nombrefoto[1] = $rec->nombreimagen1;
                    $foto[1] = $rec->imagen1;

                    for ($i = 1; $i <= $rec->numerodeimagenes; $i++) {
                        $this->GuardarIMG($foto[$i] ,$nombrefoto[$i],'imagenesmensajes/');
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

    //Create Certificate Employee
    public function pdfEditarDctoRetiro($rec)
    {

        $db_name = $this->db.".dctostransaretiros";
   
        DB::beginTransaction();
        try {
            DB::connection($this->cur_connect)->update("UPDATE ".$db_name." 
                    SET nameimg        = '".$rec-> nombreimagen1."',
                        fechaactualiza = '".$date = date('Y-m-d H:i:s')."'
                    WHERE id = '".$rec->id."'");

                    //Imagen base 64 se pasa a un arreglo
                    $nombrefoto[1] = $rec->nombreimagen1;
                    $foto[1] = $rec->imagen1;

                    for ($i = 1; $i <= $rec->numerodeimagenes; $i++) {
                        $response = FunctionsCustoms::UploadPDFName($foto[$i],$nombrefoto[1],'imagenesmensajes/');
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


    //Delete Documentos retiros usuarios
    public function borrarDctoRetiro($rec)
    {
        $db_name = $this->db.".dctostransaretiros";

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

    //Documentos retiros usuarios
    public function grabarCertifUsuario($rec)
    {
        DB::beginTransaction();
        try {
                    $db_name = $this->db.".certificadosusuarios";
                    $grabarcertusu = new ModelGlobal();
                    $grabarcertusu->setConnection($this->cur_connect);
                    $grabarcertusu->setTable($db_name);

                    $grabarcertusu->uidusuario = $rec->uid;
                    $grabarcertusu->idcertificado = $rec->idcertificado;
                    $grabarcertusu->nameimg = $rec->nombreimagen1;
                    $grabarcertusu->nombrearchivo = $rec->nombrearchivo;
                    $grabarcertusu->fechacreacion = $date = date('Y-m-d H:i:s');
                    $grabarcertusu->fechaactualiza = $date = date('Y-m-d H:i:s');

                    $grabarcertusu->save();
                    
                    //Imagen base 64 se pasa a un arreglo
                    $nombrefoto[1] = $rec->nombreimagen1;
                    $foto[1] = $rec->imagen1;

                    for ($i = 1; $i <= $rec->numerodeimagenes; $i++) {
                        $this->GuardarIMG($foto[$i] ,$nombrefoto[$i],'imagenesmensajes/');
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
            'message' => 'REGISTRAR CERTIFICADOS USUARIOS',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    //Documentos retiros usuarios
    public function grabarCertifUsuarioPDF($rec)
    {
        DB::beginTransaction();
        try {
                    $db_name = $this->db.".certificadosusuarios";
                    $grabarcertusu = new ModelGlobal();
                    $grabarcertusu->setConnection($this->cur_connect);
                    $grabarcertusu->setTable($db_name);

                    $grabarcertusu->uidusuario = $rec->uid;
                    $grabarcertusu->nameimg = $rec->nombreimagen1;
                    $grabarcertusu->idcertificado = $rec->idcertificado;
                    $grabarcertusu->nombrearchivo = $rec->nombrearchivo;
                    $grabarcertusu->fechacreacion = $date = date('Y-m-d H:i:s');
                    $grabarcertusu->fechaactualiza = $date = date('Y-m-d H:i:s');

                    $grabarcertusu->save();
                    
                    //Imagen base 64 se pasa a un arreglo
                    $nombrefoto[1] = $rec->nombreimagen1;

                    $foto[1] = $rec->imagen1;

                    for ($i = 1; $i <= $rec->numerodeimagenes; $i++) {
                        $response = FunctionsCustoms::UploadPDFName($foto[$i],$nombrefoto[1],'imagenesmensajes/');
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
            'message' => 'REGISTER service team member',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    // Listar Documentos retiros usuarios
    public function listarCertifUsuario($rec)
    {
        //echo json_encode($rec->idinterno);
        //exit;
        DB::beginTransaction();
        try {
            $db_name = "mercadorepuesto_sys";
                
        $listarcertiusuarios = DB::connection($this->cur_connect)->select(
                                                            "select t0.*
                                                            from ".$db_name.'.certificadosusuarios'." t0
                                                            WHERE t0.uidusuario    = '".$rec->uidusuario."'
                                                              AND t0.idcertificado = '".$rec->idcertificado."'
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
            'listarcertiusuarios' => $listarcertiusuarios,
            'message' => 'Listar documentos transacción',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }


    public function editarCertifUsuario($rec)
    {

        $db_name = $this->db.".certificadosusuarios";

        DB::beginTransaction();
        try {
            DB::connection($this->cur_connect)->update("UPDATE ".$db_name." 
                    SET nameimg        = '".$rec-> nombreimagen1."',
                        nombrearchivo  = '".$rec-> nombrearchivo."',
                        fechaactualiza = '".$date = date('Y-m-d H:i:s')."'
                    WHERE id = '".$rec->id."'");

                    //Imagen base 64 se pasa a un arreglo
                    $nombrefoto[1] = $rec->nombreimagen1;
                    $foto[1] = $rec->imagen1;

                    for ($i = 1; $i <= $rec->numerodeimagenes; $i++) {
                        $this->GuardarIMG($foto[$i] ,$nombrefoto[$i],'imagenesmensajes/');
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

    //Create Certificate Employee
    public function pdfEditarCertifUsuario($rec)
    {
        $db_name = $this->db.".certificadosusuarios";

        DB::beginTransaction();
        try {
            DB::connection($this->cur_connect)->update("UPDATE ".$db_name." 
                    SET nameimg        = '".$rec-> nombreimagen1."',
                        nombrearchivo  = '".$rec-> nombrearchivo."',
                        fechaactualiza = '".$date = date('Y-m-d H:i:s')."'
                    WHERE id = '".$rec->id."'");

                    //Imagen base 64 se pasa a un arreglo
                    $nombrefoto[1] = $rec->nombreimagen1;
                    $foto[1] = $rec->imagen1;

                    for ($i = 1; $i <= $rec->numerodeimagenes; $i++) {
                        $response = FunctionsCustoms::UploadPDFName($foto[$i],$nombrefoto[1],'imagenesmensajes/');
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


    //Delete Documentos retiros usuarios
    public function borrarCertifUsuario($rec)
    {
        $db_name = $this->db.".certificadosusuarios";

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





    //Grabar imagenes carrusel
    public function crearTextoBvenida($rec)
    {
        DB::beginTransaction();
        try {
                    $db_name = $this->db.".textobienvenida";
                    $savetexto = new ModelGlobal();
                    $savetexto->setConnection($this->cur_connect);
                    $savetexto->setTable($db_name);
            
                    $savetexto->id = $rec->id;
                    $savetexto->mensaje = $rec->mensaje;
                    
                    $savetexto->save();

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

    public function listarUsuarioDcto($rec)
    {
        DB::beginTransaction();
        try {
            $db_name = "mercadorepuesto_sys";
                
        $listuserdcto = DB::connection($this->cur_connect)->select(
                                                "select t0.* 
                                                from ".$db_name.'.users'." t0
                                                WHERE id = '".$rec->id."'");

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
            'listuserdcto' => $listuserdcto,
            'message' => 'REGISTRO EXITOSO',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    public function listarTextoBvenida($rec)
    {
        DB::beginTransaction();
        try {
        $db_name = "mercadorepuesto_sys";
                
        $listmensaje = DB::connection($this->cur_connect)->select(
                                                "select t0.*
                                                from ".$db_name.'.textobienvenida'." t0 
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
            'listmensaje' => $listmensaje,
            'message' => 'REGISTRO EXITOSO',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    //Actualizar Resolver dudas que tenga el vendedor
    public function actualizarTextoBvenida($rec)
    {
        $db_name = $this->db.".textobienvenida";
 
        DB::beginTransaction();
        try {
 
            DB::connection($this->cur_connect)->update("UPDATE ".$db_name." 
                SET mensaje = '".$rec->mensaje."'
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

    //Grabar imagenes carrusel
    public function crearCategoria($rec)
    {
        DB::beginTransaction();
        try {
                    $db_name = $this->db.".categorias";
                    $savecategoria = new ModelGlobal();
                    $savecategoria->setConnection($this->cur_connect);
                    $savecategoria->setTable($db_name);
            
                    $savecategoria->id = $rec->id;
                    $savecategoria->nombre = $rec->nombre;
                    $savecategoria->descripcion = $rec->descripcion;
                    
                    $savecategoria->save();

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

    public function listarCategorias($rec)
    {
        DB::beginTransaction();
        try {
        $db_name = "mercadorepuesto_sys";
                
        $listcategorias = DB::connection($this->cur_connect)->select(
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
            'listcategorias' => $listcategorias,
            'message' => 'REGISTRO EXITOSO',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    //Actualizar Resolver dudas que tenga el vendedor
    public function actualizarCategorias($rec)
    {
        $db_name = $this->db.".categorias";
 
        DB::beginTransaction();
        try {
 
            DB::connection($this->cur_connect)->update("UPDATE ".$db_name." 
                SET nombre = '".$rec->nombre."',
                    descripcion = '".$rec->descripcion."'
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

    //Grabar imagenes carrusel
    public function crearSubCategoria($rec)
    {
        DB::beginTransaction();
        try {
                    $db_name = $this->db.".subcategorias";
                    $savesubcategoria = new ModelGlobal();
                    $savesubcategoria->setConnection($this->cur_connect);
                    $savesubcategoria->setTable($db_name);
            
                    $savesubcategoria->id_categorias = $rec->id_categorias;
                    $savesubcategoria->codigoposicion = $rec->codigoposicion;
                    $savesubcategoria->recomendadas = $rec->recomendadas;
                    $savesubcategoria->palabrasclaves = $rec->palabrasclaves;
                    $savesubcategoria->nombre = $rec->nombre;
                    $savesubcategoria->descripcion = $rec->descripcion;
                       
                    $savesubcategoria->save();
   
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
   
    public function listarSubCategorias($rec)
    {
        DB::beginTransaction();
        try {
        $db_name = "mercadorepuesto_sys";
                   
        $listsubcategorias = DB::connection($this->cur_connect)->select(
                                                "select t0.*, t1.nombre as nombrecategoria
                                                from ".$db_name.'.subcategorias'." t0
                                                JOIN ".$db_name.'.categorias'." t1 ON t0.id_categorias = t1.id
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
            'listsubcategorias' => $listsubcategorias,
            'message' => 'REGISTRO EXITOSO',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    public function listarSubRecomendadas($rec)
    {
        DB::beginTransaction();
        try {
        $db_name = "mercadorepuesto_sys";
                   
        $listsubcategorias = DB::connection($this->cur_connect)->select(
                                                "select t0.*, t1.nombre as nombrecategoria
                                                from ".$db_name.'.subcategorias'." t0
                                                JOIN ".$db_name.'.categorias'." t1 ON t0.id_categorias = t1.id
                                                WHERE t0.recomendadas = '". $rec->recomendadas."'
                                                ORDER BY t0.nombre ASC");
   
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
            'listsubcategorias' => $listsubcategorias,
            'message' => 'REGISTRO EXITOSO',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    public function listarSubCategGenericas($rec)
    {
        DB::beginTransaction();
        try {
        $db_name = "mercadorepuesto_sys";
                   
        $listsubcategorias = DB::connection($this->cur_connect)->select(
                                                "select t0.*, t1.nombre as nombrecategoria,
                                                t0.id as value, t0.nombre as label
                                                from ".$db_name.'.subcategorias'." t0
                                                JOIN ".$db_name.'.categorias'." t1 ON t0.id_categorias = t1.id
                                                WHERE t0.id_categorias = 4
                                                ORDER BY t0.codigocategoria ASC");
   
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
            'listsubcategorias' => $listsubcategorias,
            'message' => 'REGISTRO EXITOSO',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }
   
    //Actualizar Resolver dudas que tenga el vendedor
    public function actualizarSubCategorias($rec)
    {
        $db_name = $this->db.".subcategorias";
    
        DB::beginTransaction();
        try {
    
            DB::connection($this->cur_connect)->update("UPDATE ".$db_name." 
                SET recomendadas = '".$rec-> recomendadas."',
                    nombre       = '".$rec-> nombre."',
                    descripcion  = '".$rec-> descripcion."',
                    nombreimagen = '".$rec-> nombreimagen."'
                WHERE id = '".$rec->id."'");
                
                $foto[1] = $rec->imagen;
                //Nombre imagenes se pasa a un arreglo
                $nombrefoto[1] = $rec->nombreimagen;

                for ($i = 1; $i <= $rec->numeroimagenes; $i++) {
                    $this->GuardarIMG($foto[$i] ,$nombrefoto[$i],'imagenesmensajes/');
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

    //Grabar imagenes Subcategorias
    public function crearImgSubcategorias($rec)
    {
        DB::beginTransaction();
        try {
                    $db_name = $this->db.".imagenessubcategorias";
                    $saveimgsubcategorias = new ModelGlobal();
                    $saveimgsubcategorias->setConnection($this->cur_connect);
                    $saveimgsubcategorias->setTable($db_name);
            
                    $saveimgsubcategorias->id_subcategoria = $rec->id_subcategoria;
                    $saveimgsubcategorias->id_categorias = $rec->id_categorias;
                    $saveimgsubcategorias->nombreimagen = $rec->nombreimagen;
                    
                    $saveimgsubcategorias->save();

                    $foto[1] = $rec->imagen;
                   
                    //Nombre imagenes se pasa a un arreglo
                    $nombrefoto[1] = $rec->nombreimagen;
    
                    for ($i = 1; $i <= $rec->numeroimagenes; $i++) {
                        $this->GuardarIMG($foto[$i] ,$nombrefoto[$i],'imagenesmensajes/');
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

    public function listarImgSubcategorias($rec)
    {
        DB::beginTransaction();
        try {
        $db_name = "mercadorepuesto_sys";
                
        $listimgsubcategorias = DB::connection($this->cur_connect)->select(
                                                "select t0.*
                                                from ".$db_name.'.imagenessubcategorias'." t0 
                                                ORDER BY t0.id_subcategoria DESC");

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
            'listimgsubcategorias' => $listimgsubcategorias,
            'message' => 'REGISTRO EXITOSO',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    public function listarUnaImgSubcategorias($rec)
    {
        DB::beginTransaction();
        try {
        $db_name = "mercadorepuesto_sys";
                
        $listimgsubcategorias = DB::connection($this->cur_connect)->select(
                                                "select t0.*
                                                from ".$db_name.'.imagenessubcategorias'." t0 
                                                WHERE id_categorias = '".$rec->id_categorias."'");

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
            'listimgsubcategorias' => $listimgsubcategorias,
            'message' => 'REGISTRO EXITOSO',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    //Actualizar Resolver dudas que tenga el vendedor
    public function actualizarImgSubcategorias($rec)
    {
        $db_name = $this->db.".imagenessubcategorias";
 
        DB::beginTransaction();
        try {
 
            DB::connection($this->cur_connect)->update("UPDATE ".$db_name." 
                SET nombreimagen = '".$rec->nombreimagen."'
                WHERE id = ".$rec->id);

                $foto[1] = $rec->imagen;
                   
                //Nombre imagenes se pasa a un arreglo
                $nombrefoto[1] = $rec->nombreimagen;

                for ($i = 1; $i <= $rec->numeroimagenes; $i++) {
                    $this->GuardarIMG($foto[$i] ,$nombrefoto[$i],'imagenesmensajes/');
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

    //Grabar estado de cuenta del cliente
    public function crearEstadodeCuenta($rec)
    {
        DB::beginTransaction();
        try {
                    $db_name = $this->db.".estadodecuenta";
                    $saveestadocta = new ModelGlobal();
                    $saveestadocta->setConnection($this->cur_connect);
                    $saveestadocta->setTable($db_name);
            
                    $saveestadocta->usuario = $rec->usuario;
                    $saveestadocta->saldoinicial = $rec->saldoinicial;
                    $saveestadocta->entradas = $rec->entradas;
                    $saveestadocta->salidas = $rec->salidas;
                    $saveestadocta->saldofinal = $rec->saldofinal;
                    
                    $saveestadocta->save();

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

    public function listarEstadodeCuenta($rec)
    {
        DB::beginTransaction();
        try {
        $db_name = "mercadorepuesto_sys";
                
        $listestadodecta = DB::connection($this->cur_connect)->select(
                                                "select t0.*, t1.*
                                                from ".$db_name.'.estadodecuenta'." t0
                                                JOIN ".$db_name.'.users'." t1 ON t0.usuario = t1.uid
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
            'listestadodecta' => $listestadodecta,
            'message' => 'REGISTRO EXITOSO',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    //Actualizar Resolver dudas que tenga el vendedor
    public function actualizarEstadodeCuenta($rec)
    {
        $db_name = $this->db.".estadodecuenta";
 
        DB::beginTransaction();
        try {
 
            DB::connection($this->cur_connect)->update("UPDATE ".$db_name." 
                SET saldoinicial = '".$rec-> saldoinicial."',
                    entradas     = '".$rec-> entradas."',
                    salidas      = '".$rec-> salidas."',
                    saldofinal   = '".$rec-> saldofinal."'
                WHERE usuario    = '".$rec->usuario."'");

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

    //Grabar transaccion billetera
    public function saveTransaccionBilletera($rec)
    {
        DB::beginTransaction();
        try {
                    $db_name = $this->db.".transaccionesbilletera";
                    $saveestadocta = new ModelGlobal();
                    $saveestadocta->setConnection($this->cur_connect);
                    $saveestadocta->setTable($db_name);
            
                    $saveestadocta->usuario = $rec->usuario;
                    $saveestadocta->idtransaccion = $rec->idtransaccion;
                    $saveestadocta->idmovimiento = $rec->idmovimiento;
                    $saveestadocta->idcompra = $rec->idcompra;
                    $saveestadocta->valorabono = $rec->valorabono;
                    $saveestadocta->preciodelservicio = $rec->preciodelservicio;
                    $saveestadocta->valordelaventa = $rec->valordelaventa;
                    $saveestadocta->precioenvio = $rec->precioenvio;
                    $saveestadocta->retencion = $rec->retencion;
                    $saveestadocta->impuestos = $rec->impuestos;
                    $saveestadocta->fechadelaventa = $rec->fechadelaventa;
                    $saveestadocta->fechaaprobacion = null;
                    $saveestadocta->fechacreacion = $date = date('Y-m-d H:i:s');
                    $saveestadocta->fechaactualiza = $date = date('Y-m-d H:i:s');
                    $saveestadocta->estado = $rec->estado;
                    
                    $saveestadocta->save();

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

    public function saveTransaccionRetiro($rec)
    {
        DB::beginTransaction();
        try {
                    $db_name = $this->db.".transaccionesbilletera";
                    $saveestadocta = new ModelGlobal();
                    $saveestadocta->setConnection($this->cur_connect);
                    $saveestadocta->setTable($db_name);
            
                    $saveestadocta->usuario = $rec->usuario;
                    $saveestadocta->idtransaccion = $rec->idtransaccion;
                    $saveestadocta->idmovimiento = $rec->idmovimiento;
                    $saveestadocta->idcompra = $rec->idcompra;
                    $saveestadocta->valorabono = $rec->valorabono;
                    $saveestadocta->preciodelservicio = $rec->preciodelservicio;
                    $saveestadocta->valordelaventa = $rec->valordelaventa;
                    $saveestadocta->precioenvio = $rec->precioenvio;
                    $saveestadocta->retencion = $rec->retencion;
                    $saveestadocta->impuestos = $rec->impuestos;
                    $saveestadocta->fechadelaventa = $rec->fechadelaventa;
                    $saveestadocta->fechaaprobacion =  $date = date('Y-m-d H:i:s');
                    $saveestadocta->fechacreacion = $date = date('Y-m-d H:i:s');
                    $saveestadocta->fechaactualiza = $date = date('Y-m-d H:i:s');
                    $saveestadocta->estado = $rec->estado;
                    
                    $saveestadocta->save();

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

    public function listarTransaccionBilletera($rec)
    {
        DB::beginTransaction();
        try {
        $db_name = "mercadorepuesto_sys";
                
        $listmovmibilletera = DB::connection($this->cur_connect)->select(
                                                    "select t0.*, t0.fechacreacion as fechainicial,
                                                    t0.id as idmov,
                                                    t0.usuario as idcomprador,
                                                    t1.*, t2.nombre as nombreestado
                                                    from ".$db_name.'.transaccionesbilletera'." t0
                                                    JOIN ".$db_name.'.users'." t1 ON t0.usuario = t1.uid
                                                    JOIN ".$db_name.'.estados'." t2 ON t0.estado = t2.tipodeestado
                                                    ORDER BY t0.id DESC");
/*
"select t0.*, t1.*,t2.nombre, t2.tipo
                                                    from ".$db_name.'.transaccionesbilletera'." t0
                                                    JOIN ".$db_name.'.users'." t1 ON t0.usuario = t1.uid
                                                    JOIN ".$db_name.'.tipotransaccion'." t2 ON t0.idtransaccion = t2.id
                                                    ORDER BY t0.id DESC");

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
            'listmovmibilletera' => $listmovmibilletera,
            'message' => 'REGISTRO EXITOSO',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    public function listarMvoAbonos($rec)
    {
        DB::beginTransaction();
        try {
        $db_name = "mercadorepuesto_sys";
                
        $listmovabonos = DB::connection($this->cur_connect)->select(
                                                    "select t0.*, t0.fechacreacion as fechainicial,
                                                    t0.id as idmov, t1.id as idinterno,
                                                    t0.usuario as idcomprador, t3.uidcomprador,
                                                    t1.*, t2.nombre as nombreestado,
                                                    TRUNCATE(((DATEDIFF(NOW(), t0.fechacreacion))),1) AS tiempocreacion,
                                                    TRUNCATE(((DATEDIFF(NOW(), t0.fechaactualiza))),1) AS tiempoestado
                                                    from ".$db_name.'.transaccionesbilletera'." t0
                                                    JOIN ".$db_name.'.users'." t1 ON t0.usuario = t1.uid
                                                    JOIN ".$db_name.'.estados'." t2 ON t0.estado = t2.tipodeestado
                                                    JOIN ".$db_name.'.miscompras'." t3 ON t0.idcompra = t3.numerodeaprobacion
                                                    WHERE t0.idcompra > 0
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
            'listmovabonos' => $listmovabonos,
            'message' => 'REGISTRO EXITOSO',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    public function listarUnMvoBilletera($rec)
    {
        DB::beginTransaction();
        try {
        $db_name = "mercadorepuesto_sys";
                
        $listmovabonos = DB::connection($this->cur_connect)->select(
                                                    "select t0.*, t0.fechacreacion as fechainicial,
                                                    t0.id as idmov, t1.id as idinterno,
                                                    t0.usuario as idcomprador, t3.uidcomprador,
                                                    t1.*, t2.nombre as nombreestado
                                                    from ".$db_name.'.transaccionesbilletera'." t0
                                                    JOIN ".$db_name.'.users'." t1 ON t0.usuario = t1.uid
                                                    JOIN ".$db_name.'.estados'." t2 ON t0.estado = t2.tipodeestado
                                                    JOIN ".$db_name.'.miscompras'." t3 ON t0.idcompra = t3.numerodeaprobacion
                                                    WHERE t0.id = '".$rec->id."'");


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
            'listmovabonos' => $listmovabonos,
            'message' => 'REGISTRO EXITOSO',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    public function listarTransRetiros($rec)
    {
        DB::beginTransaction();
        try {
        $db_name = "mercadorepuesto_sys";
                
        $listtransretiros = DB::connection($this->cur_connect)->select(
                                                    "select t0.*, t0.fechacreacion as fechainicial,
                                                    t0.id as idmov,
                                                    t0.usuario as idcomprador,
                                                    t1.*, t2.nombre as nombreestado
                                                    from ".$db_name.'.transaccionesbilletera'." t0
                                                    JOIN ".$db_name.'.users'." t1 ON t0.usuario = t1.uid
                                                    JOIN ".$db_name.'.estados'." t2 ON t0.estado = t2.tipodeestado
                                                    WHERE t0.idcompra = 0
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
            'listtransretiros' => $listtransretiros,
            'message' => 'REGISTRO EXITOSO',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    public function listarUnaTransaccionBilletera($rec)
    {
        DB::beginTransaction();
        try {
        $db_name = "mercadorepuesto_sys";
                
        $listestadodecta = DB::connection($this->cur_connect)->select(
                                                "select t0.*, t1.*,t2.nombre, t2.tipo, t0.usuario as idcomprador
                                                from ".$db_name.'.transaccionesbilletera'." t0
                                                JOIN ".$db_name.'.users'." t1 ON t0.usuario = t1.uid
                                                JOIN ".$db_name.'.tipotransaccion'." t2 ON t0.idtransaccion = t2.id
                                                WHERE t0.usuario = '". $rec->uidcomprador."'
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
            'listestadodecta' => $listestadodecta,
            'message' => 'REGISTRO EXITOSO',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    public function listarMovBilletera($rec)
    {
        DB::beginTransaction();
        try {
        $db_name = "mercadorepuesto_sys";
                
        $listmovbilletera = DB::connection($this->cur_connect)->select(
                                                "select t0.*, t0.id as idmov, t0.fechacreacion as fechaabono, 
                                                        t1.*,t2.nombre, t2.tipo, t0.usuario as idcomprador,
                                                TRUNCATE(((DATEDIFF(NOW(), t0.fechacreacion))),1) AS tiempocreacion,
                                                TRUNCATE(((DATEDIFF(NOW(), t0.fechaactualiza))),1) AS tiempoestado,
                                                t3.idcertificado
                                                from ".$db_name.'.transaccionesbilletera'." t0
                                                JOIN ".$db_name.'.users'." t1 ON t0.usuario = t1.uid
                                                JOIN ".$db_name.'.tipotransaccion'." t2 ON t0.idtransaccion = t2.id
                                                LEFT JOIN ".$db_name.'.solicitarretiros'." t3 ON t0.idmovimiento = t3.id
                                                WHERE t0.usuario = '". $rec->uidcomprador."'
                                                  AND t0.estado = 105
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
            'listmovbilletera' => $listmovbilletera,
            'message' => 'REGISTRO EXITOSO',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    //Actualizar Resolver dudas que tenga el vendedor
    public function actualizarTransaccionBilletera($rec)
    {
        $db_name = $this->db.".transaccionesbilletera";
 
        DB::beginTransaction();
        try {
 
            DB::connection($this->cur_connect)->update("UPDATE ".$db_name." 
                SET estado = '".$rec-> estado."',
                    fechaaprobacion = '".$date = date('Y-m-d H:i:s')."',
                    fechaactualiza = '".$date = date('Y-m-d H:i:s')."'
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

    //Grabar estado de cuenta del cliente
    public function crearPQR($rec)
    {
        DB::beginTransaction();
        try {
                    $db_name = $this->db.".registrarpqr";
                    $savepqr = new ModelGlobal();
                    $savepqr->setConnection($this->cur_connect);
                    $savepqr->setTable($db_name);
            
                    $savepqr->tipoidentificacion = $rec->tipoidentificacion;
                    $savepqr->identificacion = $rec->identificacion;
                    $savepqr->nombres = $rec->nombres;
                    $savepqr->apellidos = $rec->apellidos;
                    $savepqr->email = $rec->email;
                    $savepqr->telefono = $rec->telefono;
                    $savepqr->ciudad = $rec->ciudad;
                    $savepqr->direccion = $rec->direccion;
                    $savepqr->barrio = $rec->barrio;
                    $savepqr->motivo = $rec->motivo;
                    $savepqr->asunto = $rec->asunto;
                    $savepqr->descripcion = $rec->descripcion;
                    $savepqr->respuesta = $rec->respuesta;
                    $savepqr->estado = $rec->estado;
                    $savepqr->nombreimagen1 = $rec->nombreimagen1;
                    $savepqr->nombreimagen2 = $rec->nombreimagen2;
                    $savepqr->nombreimagen3 = $rec->nombreimagen3;
    
                    $savepqr->fechacreacion = $date = date('Y-m-d H:i:s');
                    $savepqr->fechaactualiza = $date = date('Y-m-d H:i:s');
                    
                    $savepqr->save();
                    
                    $foto[1] = $rec->imagen1;
                    $foto[2] = $rec->imagen2;
                    $foto[3] = $rec->imagen3;
                   
                    //Nombre imagenes se pasa a un arreglo
                    $nombrefoto[1] = $rec->nombreimagen1;
                    $nombrefoto[2] = $rec->nombreimagen2;
                    $nombrefoto[3] = $rec->nombreimagen3;

                    if($rec->numeroimagenes >= 1){
                        if($rec->tipoarchivo1 == 1){
                            $this->GuardarIMG($foto[1] ,$nombrefoto[1],'imagenesmensajes/');
                        }else{
                            $response = FunctionsCustoms::UploadPDFName($foto[1],$nombrefoto[1],'imagenesmensajes/');
                        }
                    }

                    if($rec->numeroimagenes >= 2){
                        if($rec->tipoarchivo2 == 1){
                            $this->GuardarIMG($foto[2] ,$nombrefoto[2],'imagenesmensajes/');
                        }else{
                            $response = FunctionsCustoms::UploadPDFName($foto[2],$nombrefoto[2],'imagenesmensajes/');
                        }
                    }

                    if($rec->numeroimagenes == 3){
                        if($rec->tipoarchivo3 == 1){
                            $this->GuardarIMG($foto[3] ,$nombrefoto[3],'imagenesmensajes/');
                        }else{
                            $response = FunctionsCustoms::UploadPDFName($foto[3],$nombrefoto[3],'imagenesmensajes/');
                        }
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

    //Grabar estado de cuenta del cliente
    public function crearPQRPDF($rec)
    {
        DB::beginTransaction();
        try {
                    $db_name = $this->db.".registrarpqr";
                    $savepqr = new ModelGlobal();
                    $savepqr->setConnection($this->cur_connect);
                    $savepqr->setTable($db_name);
            
                    $savepqr->tipoidentificacion = $rec->tipoidentificacion;
                    $savepqr->identificacion = $rec->identificacion;
                    $savepqr->nombres = $rec->nombres;
                    $savepqr->apellidos = $rec->apellidos;
                    $savepqr->email = $rec->email;
                    $savepqr->telefono = $rec->telefono;
                    $savepqr->ciudad = $rec->ciudad;
                    $savepqr->direccion = $rec->direccion;
                    $savepqr->barrio = $rec->barrio;
                    $savepqr->motivo = $rec->motivo;
                    $savepqr->asunto = $rec->asunto;
                    $savepqr->descripcion = $rec->descripcion;
                    $savepqr->respuesta = $rec->respuesta;
                    $savepqr->estado = $rec->estado;
                    $savepqr->nombreimagen1 = $rec->nombreimagen1;
                    $savepqr->nombreimagen2 = $rec->nombreimagen2;
                    $savepqr->nombreimagen3 = $rec->nombreimagen3;
    
                    $savepqr->fechacreacion = $date = date('Y-m-d H:i:s');
                    $savepqr->fechaactualiza = $date = date('Y-m-d H:i:s');
                    
                    $savepqr->save();
                    
                    $foto[1] = $rec->imagen1;
                    $foto[2] = $rec->imagen2;
                    $foto[3] = $rec->imagen3;
                   
                    //Nombre imagenes se pasa a un arreglo
                    $nombrefoto[1] = $rec->nombreimagen1;
                    $nombrefoto[2] = $rec->nombreimagen2;
                    $nombrefoto[3] = $rec->nombreimagen3;
    
                    //Nombre imagenes se pasa a un arreglo
                    for ($i = 1; $i <= $rec->numeroimagenes; $i++) {
                        $response = FunctionsCustoms::UploadPDFName($foto[$i],$nombrefoto[1],'imagenesmensajes/');
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

    public function listarPQR($rec)
    {
        DB::beginTransaction();
        try {
        $db_name = "mercadorepuesto_sys";
                
        $listarpqr = DB::connection($this->cur_connect)->select(
                                                "select t0.*, t0.id as idpqr, t1.nombre as nombreestado,
                                                t1.observacion,
                                                t2.nombre_ciu as nombreciudad,
                                                TRUNCATE(((DATEDIFF(NOW(), t0.fechacreacion))),1) AS tiempopqr,
                                                TRUNCATE(((DATEDIFF(NOW(), t0.fechaactualiza))),1) AS tiempoactualiza
                                                from ".$db_name.'.registrarpqr'." t0
                                                JOIN ".$db_name.'.estados'." t1 ON t0.estado = t1.tipodeestado
                                                JOIN ".$db_name.'.ciudades'." t2 ON t0.ciudad = t2.id_ciu
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
            'listarpqr' => $listarpqr,
            'message' => 'REGISTRO EXITOSO',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    //Actualizar Resolver dudas que tenga el vendedor
    public function actualizarPQR($rec)
    {
         $db_name = $this->db.".registrarpqr";
  
         DB::beginTransaction();
         try {
  
             DB::connection($this->cur_connect)->update("UPDATE ".$db_name." 
                 SET estado = '".$rec-> estado."',
                     fechaactualiza = '".$date = date('Y-m-d H:i:s')."',
                     respuesta = '".$rec->respuesta."'
                 WHERE id = '".$rec->id."'");

                                 /*
 SET fechaentrega = '".$rec-> fechaentrega."',
                      fechadevolucion = '".$rec-> fechadevolucion."',
                      fechadepago = '".$rec-> fechadepago."',
                      estadodelpago   = '".$rec-> estadodelpago."'
                  WHERE id = '".$rec->id."'");
                */
 
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

    public function imagenNotificarPQR($rec)
    {

        $db_name = $this->db.".notificacionesusuarios";
   
        DB::beginTransaction();
        try {
            DB::connection($this->cur_connect)->update("UPDATE ".$db_name." 
                    SET nombrearchivo = '".$rec-> nombreimagen1."'
                    WHERE idnotificacion = '".$rec->idnotificacion."'");

                    //Imagen base 64 se pasa a un arreglo
                    $nombrefoto[1] = $rec->nombreimagen1;
                    $foto[1] = $rec->imagen1;

                    for ($i = 1; $i <= $rec->numerodeimagenes; $i++) {
                        $this->GuardarIMG($foto[$i] ,$nombrefoto[$i],'imagenesmensajes/');
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

    //Create Certificate Employee
    public function pdfNotificarPQR($rec)
    {

        $db_name = $this->db.".notificacionesusuarios";
   
        DB::beginTransaction();
        try {
            DB::connection($this->cur_connect)->update("UPDATE ".$db_name." 
                    SET nombrearchivo = '".$rec-> nombreimagen1."'
                    WHERE idnotificacion = '".$rec->idnotificacion."'");

                    //Imagen base 64 se pasa a un arreglo
                    $nombrefoto[1] = $rec->nombreimagen1;
                    $foto[1] = $rec->imagen1;

                    for ($i = 1; $i <= $rec->numerodeimagenes; $i++) {
                        $response = FunctionsCustoms::UploadPDFName($foto[$i],$nombrefoto[1],'imagenesmensajes/');
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

    public function productosVendidos($rec)
    {
        $db_name = "mercadorepuesto_sys";

        $usuarios = DB::connection($this->cur_connect)->select("select COUNT(*) AS productosvendidos
                                                                from ".$db_name.'.miscompras'." t0
                                                                WHERE uidvendedor = '".$rec->uidvendedor."'");

        $usuarioseleccionado = array();
        echo json_encode($usuarios);
    }
 
    //Grabar estado de cuenta del cliente
    public function grabarSolicitudRetiro($rec)
    {
        DB::beginTransaction();
        try {
                    $db_name = $this->db.".solicitarretiros";
                    $grabarsolicitud = new ModelGlobal();
                    $grabarsolicitud->setConnection($this->cur_connect);
                    $grabarsolicitud->setTable($db_name);
            
                    $grabarsolicitud->usuario = $rec->usuario;
                    $grabarsolicitud->nombretitular = $rec->nombretitular;
                    $grabarsolicitud->idcertificado = $rec->idcertificado;
                    $grabarsolicitud->tipoidentificacion = $rec->tipoidentificacion;
                    $grabarsolicitud->tipodecuenta = $rec->tipodecuenta;
                    $grabarsolicitud->identificacion = $rec->identificacion;
                    $grabarsolicitud->entidadbancaria = $rec->entidadbancaria;
                    $grabarsolicitud->numerodecuenta = $rec->numerodecuenta;
                    $grabarsolicitud->valortransferencia = $rec->valortransferencia;
                    $grabarsolicitud->estado = $rec->estado;
                    $grabarsolicitud->comentario = $rec->comentario;
                    $grabarsolicitud->fechacreacion= $date = date('Y-m-d H:i:s');
                    $grabarsolicitud->fechaactualizacion = null;
                    
                    $grabarsolicitud->save();

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

    public function listarSolicitudRetiro($rec)
    {
        DB::beginTransaction();
        try {
        $db_name = "mercadorepuesto_sys";
                
        $listarsolicitudretiro = DB::connection($this->cur_connect)->select(
                                                "select t0.*,t0.id as idsolicitud, t3.descripcion as tipodocumento,
                                                 t1.nombre as entidadbancaria, t2.nombre as nombreestado,
                                                 t4.descripcion as nombretipocuenta, t5.email,
                                                 TRUNCATE(((DATEDIFF(NOW(), t0.fechacreacion))),1) AS tiempocreada,
                                                 TRUNCATE(((DATEDIFF(NOW(), t0.fechaactualizacion))),1) AS tiempoactualiza
                                                from ".$db_name.'.solicitarretiros'." t0
                                                JOIN ".$db_name.'.entidadesbancarias'." t1 ON t0.entidadbancaria = t1.codigo
                                                JOIN ".$db_name.'.estados'." t2 ON t0.estado = t2.tipodeestado
                                                JOIN ".$db_name.'.tipoidentificacion'." t3 ON t0.tipoidentificacion = t3.id
                                                JOIN ".$db_name.'.tipodecuenta'." t4 ON t0.tipodecuenta = t4.id
                                                JOIN ".$db_name.'.users'." t5 ON t0.usuario = t5.uid
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
            'listarsolicitudretiro' => $listarsolicitudretiro,
            'message' => 'REGISTRO EXITOSO',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    public function listarSolicitudRetiroUsuario($rec)
    {
        DB::beginTransaction();
        try {
        $db_name = "mercadorepuesto_sys";
                
        $listarpqr = DB::connection($this->cur_connect)->select(
                                                "select t0.*,t0.id as idsolicitud, t3.descripcion as tipodocumento,
                                                t1.nombre as entidadbancaria, t2.nombre as nombreestado,
                                                t4.descripcion as nombretipocuenta,
                                                TRUNCATE(((DATEDIFF(NOW(), t0.fechacreacion))),1) AS tiempocreada,
                                                TRUNCATE(((DATEDIFF(NOW(), t0.fechaactualizacion))),1) AS tiempoactualiza
                                                from ".$db_name.'.solicitarretiros'." t0
                                                JOIN ".$db_name.'.entidadesbancarias'." t1 ON t0.entidadbancaria = t1.codigo
                                                JOIN ".$db_name.'.estados'." t2 ON t0.estado = t2.tipodeestado
                                                JOIN ".$db_name.'.tipoidentificacion'." t3 ON t0.tipoidentificacion = t3.id
                                                JOIN ".$db_name.'.tipodecuenta'." t4 ON t0.tipodecuenta = t4.id
                                                WHERE t0.usuario = '". $rec->uidvendedor."'
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
            'listarpqr' => $listarpqr,
            'message' => 'REGISTRO EXITOSO',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    //Listar solicitudes pendientes por usuario
    public function listarSolicitudRetiroPteUsu($rec)
    {
        DB::beginTransaction();
        try {
        $db_name = "mercadorepuesto_sys";
                
        $listarsolpendiente = DB::connection($this->cur_connect)->select(
                                                "select t0.*,t0.id as idsolicitud, 
                                                t1.nombre as entidadbancaria, t2.nombre as nombreestado,
                                                TRUNCATE(((DATEDIFF(NOW(), t0.fechacreacion))),1) AS tiempocreada,
                                                TRUNCATE(((DATEDIFF(NOW(), t0.fechaactualizacion))),1) AS tiempoactualiza
                                                from ".$db_name.'.solicitarretiros'." t0
                                                JOIN ".$db_name.'.entidadesbancarias'." t1 ON t0.entidadbancaria = t1.codigo
                                                JOIN ".$db_name.'.estados'." t2 ON t0.estado = t2.tipodeestado
                                                WHERE t0.usuario = '". $rec->uidvendedor."'
                                                  AND t0.estado = 102
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
            'listarsolpendiente' => $listarsolpendiente,
            'message' => 'REGISTRO EXITOSO',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    //Actualizar Resolver dudas que tenga el vendedor
    public function actualizarSolicitudRetiro($rec)
    {
        $db_name = $this->db.".solicitarretiros";
 
        DB::beginTransaction();
        try {
 
            DB::connection($this->cur_connect)->update("UPDATE ".$db_name." 
                SET estado   = '".$rec-> estado."',
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
             'message' => 'PROCESO EXITOSO'
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    public function listarEntidadesBancarias($rec)
    {
        DB::beginTransaction();
        try {
        $db_name = "mercadorepuesto_sys";
                
        $listarbancos = DB::connection($this->cur_connect)->select(
                                                "select t0.*
                                                from ".$db_name.'.entidadesbancarias'." t0
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
            'listarbancos' => $listarbancos,
            'message' => 'REGISTRO EXITOSO',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    public function listarEstados($rec)
    {
        DB::beginTransaction();
        try {
        $db_name = "mercadorepuesto_sys";
                
        $listarestados = DB::connection($this->cur_connect)->select(
                                                "select t0.*
                                                from ".$db_name.'.estados'." t0
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
            'listarestados' => $listarestados,
            'message' => 'REGISTRO EXITOSO',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    public function listarTipoPendienteFacturar($rec)
    {
        DB::beginTransaction();
        try {
        $db_name = "mercadorepuesto_sys";
                
        $listartipofacturar = DB::connection($this->cur_connect)->select(
                                                "select t0.*
                                                from ".$db_name.'.tipopendientefacturar'." t0
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
            'listartipofacturar' => $listartipofacturar,
            'message' => 'REGISTRO EXITOSO',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    public function listarEstadosProceso($rec)
    {
        DB::beginTransaction();
        try {
        $db_name = "mercadorepuesto_sys";
                
        $listarestadosproceso = DB::connection($this->cur_connect)->select(
                                                "select t0.*
                                                from ".$db_name.'.estados'." t0
                                                WHERE t0.proceso = '". $rec->proceso."'
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
            'listarestadosproceso' => $listarestadosproceso,
            'message' => 'REGISTRO EXITOSO',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    //Actualizar Resolver dudas que tenga el vendedor
    public function actualizaEstadoUsuario($rec)
    {
        $db_name = $this->db.".users";
 
        DB::beginTransaction();
        try {
 
            DB::connection($this->cur_connect)->update("UPDATE ".$db_name." 
                SET activo = '".$rec-> estado."',
                    fechaactualiza = '".$date = date('Y-m-d H:i:s')."'
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

    //Actualizar Estado Pregunta o Respuesta Comprador o Vendedor
    public function actualizaEstadoPregunta($rec)
    {
        $db_name = $this->db.".preguntavendedor";
 
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
             'message' => 'PROCESO EXITOSO'
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

/*
    //Crear vehiculos asociados a productos
    public function crearFacturaMR($rec)
    {
        DB::beginTransaction();
        try {
                    $db_name = $this->db.".facturacionmr";
                    $registrarfacturamr = new ModelGlobal();
                    $registrarfacturamr->setConnection($this->cur_connect);
                    $registrarfacturamr->setTable($db_name);
            
                    $registrarfacturamr->idproducto = $rec->idproducto;
                    $registrarfacturamr->compatible = $rec->compatible;
                    $registrarfacturamr->numerofactura = $rec->numerofactura;
                    $registrarfacturamr->conceptopago = $rec->conceptopago;
                    $registrarfacturamr->uidvendedor = $rec->uidvendedor;
                    $registrarfacturamr->fechacompra =  $date = date('Y-m-d H:i:s');
                    $registrarfacturamr->fechaentrega = $rec->fechaentrega;
                    $registrarfacturamr->fechadevolucion = $rec->fechadevolucion;
                    $registrarfacturamr->fechadepago =  $rec->fechadepago;
                    $registrarfacturamr->formadepago = $rec->formadepago;
                    $registrarfacturamr->preciodelservicio = $rec->preciodelservicio;
                    $registrarfacturamr->precioenvio = $rec->precioenvio;
                    $registrarfacturamr->retencion = $rec->retencion;
                    $registrarfacturamr->impuestos = $rec->impuestos;
                    $registrarfacturamr->estadodelpago = $rec->estadodelpago;

                    $registrarfacturamr->save();

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

    public function listarFacturaMR($rec)
    {
        DB::beginTransaction();
        try {
        $db_name = "mercadorepuesto_sys";
                
        $listarcompras = DB::connection($this->cur_connect)->select(
                                                "select t0.*, t1.razonsocial, t1.identificacion,
                                                              t1.email, t1.celular, 
                                                              concat(t1.primernombre, ' ', t1.primerapellido) as nombres,
                                                              t2.idproductovehiculo, t2.titulonombre,
                                                              t5.nombre as mediodepago 
                                                from ".$db_name.'.facturacionmr'." t0 
                                                JOIN ".$db_name.'.users'." t1 ON t0.uidcomprador = t3.uid
                                                JOIN ".$db_name.'.productos'." t2 ON t0.id = t2.id
                                                JOIN ".$db_name.'.formasdepago'." t3 ON t0.formadepago= t3.id
                                                ORDER BY t0.fechacompra ASC");

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
            'listarcompras' => $listarcompras,
            'message' => 'REGISTRO EXITOSO',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    //Actualizar Datos de la cuenta x cobrar
    public function actualizarFacturaMR($rec)
    {
        //echo json_encode($rec->id);
        //exit;
        $db_name = $this->db."facturacionmr";
   
        DB::beginTransaction();
        try {
   
              DB::connection($this->cur_connect)->update("UPDATE ".$db_name." 
                  SET fechaentrega = '".$rec-> fechaentrega."',
                      fechadevolucion = '".$rec-> fechadevolucion."',
                      fechadepago = '".$rec-> fechadepago."',
                      estadodelpago   = '".$rec-> estadodelpago."'
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

*/

    public function createProduct($rec)
    {

        DB::beginTransaction();
        try {
                    $db_name = $this->db.".productos";
                    $crearProducto = new ModelGlobal();
                    $crearProducto->setConnection($this->cur_connect);
                    $crearProducto->setTable($db_name);
                    //$extension = ".jpg";
                    //$extension = $this->getB64Extension($rec->imagen1);

                    //$crearProducto->url = $rec->uid;
                    $crearProducto->productogenerico = $rec->productogenerico;
                    $crearProducto->idproductovehiculo = $rec->idproductovehiculo;
                    $crearProducto->tipovehiculo = $rec->tipovehiculo;
                    $crearProducto->carroceria = $rec->carroceria;
                    $crearProducto->marca = $rec->marca;
                    $crearProducto->anno = $rec->anno;
                    $crearProducto->modelo = $rec->modelo;
                    $crearProducto->cilindrajemotor = $rec->cilindrajemotor;
                    $crearProducto->tipocombustible = $rec->tipocombustible;
                    $crearProducto->transmision = $rec->transmision;
                    $crearProducto->partedelvehiculo = $rec->partedelvehiculo;
                    $crearProducto->posicionproducto = $rec->posicionproducto;                    
                    $crearProducto->titulonombre = $rec->titulonombre;
                    $crearProducto->marcarepuesto = $rec->marcarepuesto;
                    $crearProducto->condicion = $rec->condicion;
                    $crearProducto->estadoproducto = $rec->estadoproducto;
                    $crearProducto->numerodeunidades = $rec->numerodeunidades;
                    $crearProducto->precio = $rec->precio;
                    $crearProducto->numerodeparte = $rec->numerodeparte;
                    $crearProducto->funcionalidad = $rec->funcionalidad;
                    $crearProducto->compatible = $rec->compatible;
                    $crearProducto->descripcionproducto = $rec->descripcionproducto;
                    $crearProducto->vendeporpartes = $rec->vendeporpartes;
                    $crearProducto->peso = $rec->peso;
                    $crearProducto->largo = $rec->largo;
                    $crearProducto->ancho = $rec->ancho;
                    $crearProducto->alto = $rec->alto;
                    $crearProducto->tipotraccion = $rec->tipotraccion;
                    $crearProducto->turbocompresor = $rec->turbocompresor;
                    $crearProducto->descuento = $rec->descuento;
                    $crearProducto->usuario = $rec->usuario;
                    $crearProducto->moneda = $rec->moneda;
                    $crearProducto->estado = $rec->estado;
                    $crearProducto->ciudad = $rec->ciudad;
                    $crearProducto->fechacreacion = $rec->fechacreacion;
                    
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
                   if($rec->loadimage == "Si"){
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
                   }

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

    //Actualizar dirección del usuario
    public function updateProduct($rec)
    {
        //echo json_encode($rec->id);
        //exit;
        $db_name = $this->db.".productos";
   
        DB::beginTransaction();
        try {
   
              DB::connection($this->cur_connect)->update("UPDATE ".$db_name." 
                  SET   productogenerico = '".$rec->productogenerico."',
                        idproductovehiculo = '".$rec->idproductovehiculo."',
                        tipovehiculo = '".$rec->tipovehiculo."',
                        carroceria = '".$rec->carroceria."',
                        marca = '".$rec->marca."',
                        anno = '".$rec->anno."',
                        modelo = '".$rec->modelo."',
                        cilindrajemotor = '".$rec->cilindrajemotor."',
                        tipocombustible = '".$rec->tipocombustible."',
                        transmision = '".$rec->transmision."',
                        partedelvehiculo = '".$rec->partedelvehiculo."',
                        posicionproducto = '".$rec->posicionproducto."',                    
                        titulonombre = '".$rec->titulonombre."',
                        marcarepuesto = '".$rec->marcarepuesto."',
                        condicion = '".$rec->condicion."',
                        estadoproducto = '".$rec->estadoproducto."',
                        numerodeunidades = '".$rec->numerodeunidades."',
                        precio = '".$rec->precio."',
                        numerodeparte = '".$rec->numerodeparte."',
                        funcionalidad = '".$rec->funcionalidad."',
                        compatible = '".$rec->compatible."',
                        descripcionproducto = '".$rec->descripcionproducto."',
                        vendeporpartes = '".$rec->vendeporpartes."',
                        peso = '".$rec->peso."',
                        largo = '".$rec->largo."',
                        ancho = '".$rec->ancho."',
                        alto = '".$rec->alto."',
                        tipotraccion = '".$rec->tipotraccion."',
                        turbocompresor = '".$rec->turbocompresor."',
                        descuento = '".$rec->descuento."',
                        usuario = '".$rec->usuario."',
                        moneda = '".$rec->moneda."',
                        estado = '".$rec->estado."',
                        ciudad = '".$rec->ciudad."',
                        fechacreacion = '".$rec->fechacreacion."',
                        numerodeimagenes = '".$rec->longitud."',
                        nombreimagen1 = '".$rec->nombreimagen1."',
                        nombreimagen2 = '".$rec->nombreimagen2."',
                        nombreimagen3 = '".$rec->nombreimagen3."',
                        nombreimagen4 = '".$rec->nombreimagen4."',
                        nombreimagen5 = '".$rec->nombreimagen5."',
                        nombreimagen6 = '".$rec->nombreimagen6."',
                        nombreimagen7 = '".$rec->nombreimagen7."',
                        nombreimagen8 = '".$rec->nombreimagen8."',
                        nombreimagen9 = '".$rec->nombreimagen9."',
                        nombreimagen10 = '".$rec->nombreimagen10."'
                    WHERE id = '".$rec->id."'");

                   //Imagen base 64 se pasa a un arreglo
                 
                   if($rec->loadimage == "Si"){
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
                   }
                    
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

                    //$crearProducto->save();

                    for ($i = 1; $i <= $rec->longitud; $i++) {
                        $this->GuardarIMG($foto[$i] ,$nombrefoto[$i],'mercadorepuesto/');
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

    //Actualizar existencia delproducto
    public function updateExistenceProduct($rec)
    {
        //echo json_encode($rec->id);
        //exit;
        $db_name = $this->db.".productos";
   
        DB::beginTransaction();
        try {
   
              DB::connection($this->cur_connect)->update("UPDATE ".$db_name." 
                  SET  numerodeunidades = '".$rec->unddisponibles."'
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


    public function duplicarProduct($rec)
    {
        DB::beginTransaction();
        try {
                    $db_name = $this->db.".productos";
                    $crearProducto = new ModelGlobal();
                    $crearProducto->setConnection($this->cur_connect);
                    $crearProducto->setTable($db_name);
                    //$extension = ".jpg";
                 
                    $crearProducto->productogenerico = $rec->productogenerico;
                    $crearProducto->idproductovehiculo = $rec->idproductovehiculo;
                    $crearProducto->tipovehiculo = $rec->tipovehiculo;
                    $crearProducto->carroceria = $rec->carroceria;
                    $crearProducto->marca = $rec->marca;
                    $crearProducto->anno = $rec->anno;
                    $crearProducto->modelo = $rec->modelo;
                    $crearProducto->cilindrajemotor = $rec->cilindrajemotor;
                    $crearProducto->tipocombustible = $rec->tipocombustible;
                    $crearProducto->transmision = $rec->transmision;
                    $crearProducto->partedelvehiculo = $rec->partedelvehiculo;
                    $crearProducto->posicionproducto = $rec->posicionproducto;                    
                    $crearProducto->titulonombre = $rec->titulonombre;
                    $crearProducto->marcarepuesto = $rec->marcarepuesto;
                    $crearProducto->condicion = $rec->condicion;
                    $crearProducto->estadoproducto = $rec->estadoproducto;
                    $crearProducto->numerodeunidades = $rec->numerodeunidades;
                    $crearProducto->precio = $rec->precio;
                    $crearProducto->numerodeparte = $rec->numerodeparte;
                    $crearProducto->funcionalidad = $rec->funcionalidad;
                    $crearProducto->compatible = $rec->compatible;
                    $crearProducto->descripcionproducto = $rec->descripcionproducto;
                    $crearProducto->vendeporpartes = $rec->vendeporpartes;
                    $crearProducto->peso = $rec->peso;
                    $crearProducto->largo = $rec->largo;
                    $crearProducto->ancho = $rec->ancho;
                    $crearProducto->alto = $rec->alto;
                    $crearProducto->tipotraccion = $rec->tipotraccion;
                    $crearProducto->turbocompresor = $rec->turbocompresor;
                    $crearProducto->descuento = $rec->descuento;
                    $crearProducto->usuario = $rec->usuario;
                    $crearProducto->moneda = $rec->moneda;
                    $crearProducto->estado = $rec->estado;
                    $crearProducto->ciudad = $rec->ciudad;
                    $crearProducto->fechacreacion = $rec->fechacreacion;
                    $crearProducto->numerodeimagenes = $rec->numerodeimagenes;
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
            'message' => 'DUPLICAR PRODUCTO OK',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    //Grabar calificación producto
    public function saveCalificacionProducto($rec)
    {

        DB::beginTransaction();
        try {
                    $db_name = $this->db.".calificacionproductos";
                    $calificacionPrd = new ModelGlobal();
                    $calificacionPrd->setConnection($this->cur_connect);
                    $calificacionPrd->setTable($db_name);

                    $calificacionPrd->compatible = $rec->compatible;
                    $calificacionPrd->idproducto = $rec->idproducto;
                    $calificacionPrd->idcomprador = $rec->idcomprador;
                    $calificacionPrd->fechacreacion = $date = date('Y-m-d H:i:s');
                    $calificacionPrd->calificacion = $rec->calificacion;
                    $calificacionPrd->comentario = $rec->comentario;

                    $calificacionPrd->save();

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

    public function listarCalificacionProducto($rec)
    {
        DB::beginTransaction();
        try {
        $db_name = "mercadorepuesto_sys";
                
        $listarcalificacionprd = DB::connection($this->cur_connect)->select(
                                                "select t0.* from ".$db_name.'.calificacionproductos'." t0 
                                                WHERE t0.idproducto = '". $rec->producto."'
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
            'listarcalificacionprd' => $listarcalificacionprd,
            'message' => 'REGISTRO EXITOSO',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    public function listarUnaCalificacionProducto($rec)
    {
        DB::beginTransaction();
        try {
        $db_name = "mercadorepuesto_sys";
                
        $listarcalificacionprd = DB::connection($this->cur_connect)->select(
                                                "select t0.* from ".$db_name.'.calificacionproductos'." t0 
                                                WHERE t0.compatible = '". $rec->compatible."'
                                                AND t0.idcomprador = ".$rec->idcomprador);

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
            'listarcalificacionprd' => $listarcalificacionprd,
            'message' => 'REGISTRO EXITOSO',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    //Grabar calificación producto
    public function saveMessage($rec)
    {
        DB::beginTransaction();
        try {
                    $db_name = $this->db.".mensajes";
                    $enviarmensajes = new ModelGlobal();
                    $enviarmensajes->setConnection($this->cur_connect);
                    $enviarmensajes->setTable($db_name);

                    $enviarmensajes->usuariocompra = $rec->usuariocompra;
                    $enviarmensajes->idproducto = $rec->idproducto;
                    $enviarmensajes->usuariovende = $rec->usuariovende;
                    $enviarmensajes->idaprobacioncompra = $rec->idaprobacioncompra;
                    $enviarmensajes->idmessage = $rec->idmessage;
                    $enviarmensajes->idmicompra = $rec->idmicompra;
                    $enviarmensajes->paraquien = $rec->paraquien;
                    $enviarmensajes->fechacreacion = $date = date('Y-m-d H:i:s');
                    $enviarmensajes->fechaestadosolicitud = $date = date('Y-m-d H:i:s');
                    $enviarmensajes->fechaactualizacion = $date = date('Y-m-d H:i:s');
                    $enviarmensajes->estado = $rec->estado;
                    $enviarmensajes->comentario = $rec->comentario;
                    $enviarmensajes->estadosolicitud = $rec->estadosolicitud;
                    $enviarmensajes->mensajeleidovendedor = $rec->mensajeleidovendedor;
                    $enviarmensajes->mensajeleidocomprador = $rec->mensajeleidocomprador;
                    $enviarmensajes->observacionintera = $rec->observacionintera;
                    $enviarmensajes->nombreimagen1 = $rec->nombreimagen1;
                    $enviarmensajes->nombreimagen2 = $rec->nombreimagen2;
                    $enviarmensajes->nombreimagen3 = $rec->nombreimagen3;
                    $enviarmensajes->nombreimagen4 = $rec->nombreimagen4;
                    $enviarmensajes->nombreimagen5 = $rec->nombreimagen5;

                    $enviarmensajes->save();
                    
                    //Imagen base 64 se pasa a un arreglo

                    $foto[1] = $rec->imagen1;
                    $foto[2] = $rec->imagen2;
                    $foto[3] = $rec->imagen3;
                    $foto[4] = $rec->imagen4;
                    $foto[5] = $rec->imagen5;
                                                
                    //Nombre imagenes se pasa a un arreglo
                    $nombrefoto[1] = $rec->nombreimagen1;
                    $nombrefoto[2] = $rec->nombreimagen2;
                    $nombrefoto[3] = $rec->nombreimagen3;
                    $nombrefoto[4] = $rec->nombreimagen4;
                    $nombrefoto[5] = $rec->nombreimagen5;
    
                    if($rec->numeroimagenes > 0){
                        for ($i = 1; $i <= $rec->numeroimagenes; $i++) {
                            $this->GuardarIMG($foto[$i] ,$nombrefoto[$i],'imagenesmensajes/');
                        }
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

    public function listMessage($rec)
    {
        DB::beginTransaction();
        try {
        $db_name = "mercadorepuesto_sys";
                
        $listarmensajes = DB::connection($this->cur_connect)->select(
                                                "select t0.*, t0.fechacreacion as fechamensaje,
                                                t1.*, t2.titulonombre, t3.*, t0.id as idmensaje
                                                from ".$db_name.'.mensajes'." t0 
                                                JOIN ".$db_name.'.miscompras'." t1 ON t0.idaprobacioncompra = t1.numerodeaprobacion
                                                JOIN ".$db_name.'.productos'." t2 ON t0.idproducto = t2.id
                                                JOIN ".$db_name.'.users'." t3 ON t0.usuariovende = t3.uid
                                                WHERE t0.estado = '". $rec->estado."'
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
            'listarmensajes' => $listarmensajes,
            'message' => 'REGISTRO EXITOSO',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    public function listDevoluciones($rec)
    {
        DB::beginTransaction();
        try {
        $db_name = "mercadorepuesto_sys";
                
        $listardevoluciones = DB::connection($this->cur_connect)->select(
                                                "select t0.*, t1.*, t2.titulonombre, t3.*, t0.id as idmensaje,
                                                t0.id as idsolicitud,
                                                        t0.estadosolicitud as idestadosolicitud,
                                                        t4.nombre as estadosolicitud, t0.fechacreacion as fechasolicitud,
                                                        t5.nombreuno as nombrecomprador, 
                                                        t5.apellidouno as apellidocomprador,
                                                        t5.razonsocialuser as razonsocialcomprador,
                                                        t5.celularuser as celularcomprador,
                                                        t5.emailuser as emailcomprador,
                                                        t5.usuariouser as usuariocomprador,
                                                        t5.identificacionuser as identificacioncomprador,
                                                        t2.nombreimagen1 as nombreImagen,
                                                        TRUNCATE(((DATEDIFF(NOW(), t0.fechacreacion))),1) AS tiempocreada,
                                                        TRUNCATE(((DATEDIFF(NOW(), t0.fechaestadosolicitud))),1) AS tiempoactualiza
                                                from ".$db_name.'.mensajes'." t0 
                                                JOIN ".$db_name.'.miscompras'." t1 ON t0.idmicompra = t1.numerodeaprobacion
                                                JOIN ".$db_name.'.productos'." t2 ON t0.idproducto = t2.id
                                                JOIN ".$db_name.'.users'." t3 ON t0.usuariovende = t3.uid
                                                JOIN ".$db_name.'.estados'." t4 ON t0.estadosolicitud = t4.tipodeestado
                                                JOIN ".$db_name.'.vista_users'." t5 ON t0.usuariocompra = t5.uidviewuser
                                                WHERE t0.estado in (31,11)
                                                  AND t0.estadosolicitud in (65,66,67,68,69,70,71)
                                                ORDER BY t0.id DESC"); 

                                                /*
   WHERE t0.estado = '". $rec->estado."'
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
            'listardevoluciones' => $listardevoluciones,
            'message' => 'REGISTRO EXITOSO',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    public function listSeguimientoProblema($rec)
    {
        DB::beginTransaction();
        try {
        $db_name = "mercadorepuesto_sys";
                
        $listarmensajes = DB::connection($this->cur_connect)->select(
                                                "select t0.*, t1.*, t2.titulonombre, t3.*, t0.id as idmensaje,
                                                        t4.nombre as estadosolicitud
                                                from ".$db_name.'.mensajes'." t0 
                                                JOIN ".$db_name.'.miscompras'." t1 ON t0.idmicompra = t1.numerodeaprobacion
                                                JOIN ".$db_name.'.productos'." t2 ON t0.idproducto = t2.id
                                                JOIN ".$db_name.'.users'." t3 ON t0.usuariovende = t3.uid
                                                JOIN ".$db_name.'.estados'." t4 ON t0.estadosolicitud = t4.tipodeestado
                                                WHERE t0.estado in (31,22,23,24,26)
                                                  AND t0.usuariocompra = '".$rec->idcomprador."'
                                                ORDER BY t0.id DESC"); 

                                                /*
   WHERE t0.estado = '". $rec->estado."'
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
            'listarmensajes' => $listarmensajes,
            'message' => 'REGISTRO EXITOSO',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    public function seguimientoProblemaRedirigir($rec)
    {
        DB::beginTransaction();
        try {
        $db_name = "mercadorepuesto_sys";
                
        $listarmensajes = DB::connection($this->cur_connect)->select(
                                                "select t0.*, t1.*, t2.titulonombre, t3.*, t0.id as idmensaje,
                                                        t4.nombre as estadosolicitud
                                                from ".$db_name.'.mensajes'." t0 
                                                JOIN ".$db_name.'.miscompras'." t1 ON t0.idmicompra = t1.numerodeaprobacion
                                                JOIN ".$db_name.'.productos'." t2 ON t0.idproducto = t2.id
                                                JOIN ".$db_name.'.users'." t3 ON t0.usuariovende = t3.uid
                                                JOIN ".$db_name.'.estados'." t4 ON t0.estadosolicitud = t4.tipodeestado
                                                WHERE t0.estado in (31,22,23,24,26)
                                                ORDER BY t0.id DESC"); 

                                                /*
   WHERE t0.estado = '". $rec->estado."'
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
            'listarmensajes' => $listarmensajes,
            'message' => 'REGISTRO EXITOSO',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }
    
    public function listProblemaAdmon($rec)
    {
        DB::beginTransaction();
        try {
        $db_name = "mercadorepuesto_sys";
                
        $listarproblemaadmon = DB::connection($this->cur_connect)->select(
                                                "select t0.*, t0.id as idmsg, t1.*, t2.titulonombre,
                                                        t3.*, t0.id as idmensaje, t4.nombre as estadosolicitud
                                                from ".$db_name.'.mensajes'." t0 
                                                JOIN ".$db_name.'.miscompras'." t1 ON t0.idmicompra = t1.numerodeaprobacion
                                                JOIN ".$db_name.'.productos'." t2 ON t0.idproducto = t2.id
                                                JOIN ".$db_name.'.users'." t3 ON t0.usuariovende = t3.uid
                                                JOIN ".$db_name.'.estados'." t4 ON t0.estadosolicitud = t4.tipodeestado
                                                WHERE t0.estado in (31,33)
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
            'listarproblemaadmon' => $listarproblemaadmon,
            'message' => 'REGISTRO EXITOSO',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    public function listMessagePregVende($rec)
    {
        DB::beginTransaction();
        try {
        $db_name = "mercadorepuesto_sys";
                
        $listmensajevende = DB::connection($this->cur_connect)->select(
                                                "select t0.*, t1.titulonombre, t2.*, t3.nombre as nombreestado,
                                                 t4.*, t0.fechacreacion as fechacreamensaje, t0.id as idmsj
                                                from ".$db_name.'.mensajes'." t0
                                                JOIN ".$db_name.'.productos'." t1 ON t0.idproducto = t1.id
                                                JOIN ".$db_name.'.users'." t2 ON t0.usuariovende = t2.uid
                                                JOIN ".$db_name.'.estados'." t3 ON t0.estado = t3.tipodeestado
                                                JOIN ".$db_name.'.vista_users'." t4 ON t0.usuariocompra = t4.uidviewuser
                                                WHERE t0.estado IN (22,23,24) ORDER BY t0.id DESC"); 

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
            'listmensajevende' => $listmensajevende,
            'message' => 'REGISTRO EXITOSO',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    public function msgsVendedorCompradorAdmon($rec)
    {
        DB::beginTransaction();
        try {
        $db_name = "mercadorepuesto_sys";
                
        $listarmensajes = DB::connection($this->cur_connect)->select(
                                                "select t0.*, t0.fechacreacion as fechamensaje, 
                                                t0.id as idmensaje, t1.titulonombre, t2.*,
                                                t0.fechacreacion as fechaventa, t3.nombre as nombreestado,
                                                t1.numerodeunidades as unidadesdisponible, t1.precio,
                                                t1.compatible,
                                                TRUNCATE(((DATEDIFF(NOW(), t0.fechaactualizacion))),1) AS tiempoactualiza
                                                from ".$db_name.'.mensajes'." t0 
                                                JOIN ".$db_name.'.productos'." t1 ON t0.idproducto = t1.id
                                                JOIN ".$db_name.'.users'." t2 ON t0.usuariovende = t2.uid
                                                JOIN ".$db_name.'.estados'." t3 ON t0.estado = t3.tipodeestado
                                                WHERE t0.estado IN (21,22,23,24,25,26) ORDER BY t0.id DESC"); 

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
            'listarmensajes' => $listarmensajes,
            'message' => 'REGISTRO EXITOSO',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    public function unMsgsVendedorComprador($rec)
    {
        DB::beginTransaction();
        try {
        $db_name = "mercadorepuesto_sys";
                
        $listarmensajes = DB::connection($this->cur_connect)->select(
                                                "select t0.*, t0.fechacreacion as fechamensaje, 
                                                t0.id as idmensaje, t1.titulonombre, t2.*,
                                                t0.fechacreacion as fechaventa, t3.nombre as nombreestado,
                                                t1.numerodeunidades as unidadesdisponible, t1.precio,
                                                t1.compatible, t4.*, t1.nombreimagen1 as nombreImagen,
                                                TRUNCATE(((DATEDIFF(NOW(), t0.fechaactualizacion))),1) AS tiempoactualiza
                                                from ".$db_name.'.mensajes'." t0 
                                                JOIN ".$db_name.'.productos'." t1 ON t0.idproducto = t1.id
                                                JOIN ".$db_name.'.users'." t2 ON t0.usuariovende = t2.uid
                                                JOIN ".$db_name.'.estados'." t3 ON t0.estado = t3.tipodeestado
                                                JOIN ".$db_name.'.miscompras'." t4 ON t0.idmicompra = t4.numerodeaprobacion
                                                WHERE t0.estado IN (21,22,23,24,25,26) 
                                                  AND t0.id = '".$rec->idmensaje."'
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
            'listarmensajes' => $listarmensajes,
            'message' => 'REGISTRO EXITOSO',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    public function unaDevolucionPrd($rec)
    {
        DB::beginTransaction();
        try {
        $db_name = "mercadorepuesto_sys";
                
        $listardevoluciones = DB::connection($this->cur_connect)->select(
                                                "select t0.*, t0.fechacreacion as fechamensaje, 
                                                t0.id as idmensaje, t1.titulonombre, t2.*,
                                                t0.fechacreacion as fechaventa, t3.nombre as nombreestado,
                                                t1.numerodeunidades as unidadesdisponible, t1.precio,
                                                t1.compatible, t4.*, t1.nombreimagen1 as nombreImagen,
                                                TRUNCATE(((DATEDIFF(NOW(), t0.fechaactualizacion))),1) AS tiempoactualiza
                                                from ".$db_name.'.mensajes'." t0 
                                                JOIN ".$db_name.'.productos'." t1 ON t0.idproducto = t1.id
                                                JOIN ".$db_name.'.users'." t2 ON t0.usuariovende = t2.uid
                                                JOIN ".$db_name.'.estados'." t3 ON t0.estado = t3.tipodeestado
                                                JOIN ".$db_name.'.miscompras'." t4 ON t0.idmicompra = t4.numerodeaprobacion
                                                WHERE t0.estado IN (31,21,22,23,24,25,26) 
                                                  AND t0.id = '".$rec->idmensaje."'
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
            'listardevoluciones' => $listardevoluciones,
            'message' => 'REGISTRO EXITOSO',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    public function readIdMessage($rec)
    {
        DB::beginTransaction();
        try {
        $db_name = "mercadorepuesto_sys";
                
        $listarmensajes = DB::connection($this->cur_connect)->select(
                                                "select t0.*, t0.fechacreacion as fechamensaje, 
                                                t0.id as idmensaje, t1.titulonombre, t2.*,
                                                t0.fechacreacion as fechaventa, t3.nombre as nombreestado,
                                                t1.numerodeunidades as unidadesdisponible, t1.precio,
                                                t1.compatible, t1.nombreimagen1 as nombreImagen,
                                                TRUNCATE(((DATEDIFF(NOW(), t0.fechaactualizacion))),1) AS tiempoactualiza,
                                                t4.*
                                                from ".$db_name.'.mensajes'." t0 
                                                JOIN ".$db_name.'.productos'." t1 ON t0.idproducto = t1.id
                                                JOIN ".$db_name.'.users'." t2 ON t0.usuariovende = t2.uid
                                                JOIN ".$db_name.'.estados'." t3 ON t0.estado = t3.tipodeestado
                                                JOIN ".$db_name.'.miscompras'." t4 ON t0.idmicompra = t4.numerodeaprobacion
                                                WHERE t0.estado IN (21,22,23,24,25,26) 
                                                  AND t0.idmessage = '".$rec->idmensaje."'
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
            'listarmensajes' => $listarmensajes,
            'message' => 'REGISTRO EXITOSO',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    public function listPregMisPrdAdmon($rec)
    {
        DB::beginTransaction();
        try {
        $db_name = "mercadorepuesto_sys";
                
        $listpregmisprdadmon = DB::connection($this->cur_connect)->select(
                                                "select t0.*, t0.id as idpregunta, t1.titulonombre, t2.*,
                                                t0.fechacreacion as fechaventa, t3.nombre as nombreestado,
                                                t1.numerodeunidades as unidadesdisponible, t1.precio,
                                                t1.id as idproducto
                                                from ".$db_name.'.preguntavendedor'." t0 
                                                JOIN ".$db_name.'.productos'." t1 ON t0.idprd = t1.id
                                                JOIN ".$db_name.'.users'." t2 ON t0.uidvendedor = t2.uid
                                                JOIN ".$db_name.'.estados'." t3 ON t0.estado = t3.tipodeestado
                                                WHERE t0.estado IN (80,82) ORDER BY t0.id DESC");

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
            'listpregmisprdadmon' => $listpregmisprdadmon,
            'message' => 'REGISTRO EXITOSO',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    public function listMessageComprador($rec)
    {
        DB::beginTransaction();
        try {
        $db_name = "mercadorepuesto_sys";
                
        $listmensajecompra = DB::connection($this->cur_connect)->select(
                                            "select t0.*, t1.titulonombre, t2.*, t3.nombre as nombreestado,
                                             t4.*, t0.fechacreacion as fechacreamensaje, t0.id as idmsj
                                            from ".$db_name.'.mensajes'." t0
                                            JOIN ".$db_name.'.productos'." t1 ON t0.idproducto = t1.id
                                            JOIN ".$db_name.'.users'." t2 ON t0.usuariovende = t2.uid
                                            JOIN ".$db_name.'.estados'." t3 ON t0.estado = t3.tipodeestado
                                            JOIN ".$db_name.'.vista_users'." t4 ON t0.usuariocompra = t4.uidviewuser
                                            WHERE t0.estado IN (21,22,24) ORDER BY t0.id DESC"); 

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
            'listmensajecompra' => $listmensajecompra,
            'message' => 'REGISTRO EXITOSO',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    public function listMessageCompradorAdmon($rec)
    {
        DB::beginTransaction();
        try {
        $db_name = "mercadorepuesto_sys";
                
        $listmensajecompra = DB::connection($this->cur_connect)->select(
                                            "select t0.*, t1.titulonombre, t2.*, t3.nombre as nombreestado,
                                             t4.*, t0.fechacreacion as fechacreamensaje, t0.id as idmsj
                                            from ".$db_name.'.mensajes'." t0
                                            JOIN ".$db_name.'.productos'." t1 ON t0.idproducto = t1.id
                                            JOIN ".$db_name.'.users'." t2 ON t0.usuariovende = t2.uid
                                            JOIN ".$db_name.'.estados'." t3 ON t0.estado = t3.tipodeestado
                                            JOIN ".$db_name.'.vista_users'." t4 ON t0.usuariocompra = t4.uidviewuser
                                            WHERE t0.estado IN (21,22,24,25,26) ORDER BY t0.id DESC"); 

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
            'listmensajecompra' => $listmensajecompra,
            'message' => 'REGISTRO EXITOSO',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    public function listMessageVendedor($rec)
    {
        DB::beginTransaction();
        try {
        $db_name = "mercadorepuesto_sys";
                
        $listarmensajes = DB::connection($this->cur_connect)->select(
                                                "select t0.* from ".$db_name.'.mensajes'." t0 
                                                WHERE t0.estado = '". $rec->estado."'
                                                AND t0.usuariovende = '".$rec->usuariovende."'
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
            'listarmensajes' => $listarmensajes,
            'message' => 'REGISTRO EXITOSO',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    //Actualiza estado del mensaje
    public function updateMessage($rec)
    {
        //echo json_encode($rec->estadomensaje);
        //exit;
        $db_name = $this->db.".mensajes";
   
        DB::beginTransaction();
        try {
   
              DB::connection($this->cur_connect)->update("UPDATE ".$db_name." 
                  SET estado = '".$rec->estadomensaje."',
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
               'message' => 'PROCESO EXITOSO'
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    //Actualiza estado de la devolución
    public function updateDevolucion($rec)
    {
        //echo json_encode($rec->estadomensaje);
        //exit;
        $db_name = $this->db.".mensajes";
   
        DB::beginTransaction();
        try {
   
            DB::connection($this->cur_connect)->update("UPDATE ".$db_name." 
            SET estadosolicitud  = '".$rec-> estadodevolucion."',
                fechaestadosolicitud = '".$date = date('Y-m-d H:i:s')."'
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

    //Actualiza estado de la devolución
    public function updateNotificacion($rec)
    {
        //echo json_encode($rec->estadomensaje);
        //exit;
        $db_name = $this->db.".notificacionesusuarios";
   
        DB::beginTransaction();
        try {
   
              DB::connection($this->cur_connect)->update("UPDATE ".$db_name." 
                  SET ctllecturanotifica = '".$rec->ctllecturanotifica."'
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

    //Actualiza estado del mensaje
    public function updateMessageReadSeller($rec)
    {
         //echo json_encode($rec->estadomensaje);
         //exit;
         $db_name = $this->db.".mensajes";
    
         DB::beginTransaction();
         try {
    
               DB::connection($this->cur_connect)->update("UPDATE ".$db_name." 
                   SET mensajeleidovendedor = '".$rec->mensajeleidovendedor."'
                   WHERE idproducto = '". $rec->idproducto."'
                      && usuariovende = '".$rec->usuariovende."'"); 
    
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

    //Actualiza estado del mensaje
    public function updatePrguntasVendedor($rec)
    {
        //echo json_encode($rec->estadomensaje);
        //exit;
        $db_name = $this->db.".preguntavendedor";
   
        DB::beginTransaction();
        try {
   
              DB::connection($this->cur_connect)->update("UPDATE ".$db_name." 
                  SET estado = '".$rec->estadomensaje."',
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
               'message' => 'PROCESO EXITOSO'
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    //Actualiza estado del mensaje
    public function updateNotificacionPrgVendedor($rec)
    {
        //echo json_encode($rec->estadomensaje);
        //exit;
        $db_name = $this->db.".preguntavendedor";
   
        DB::beginTransaction();
        try {
   
              DB::connection($this->cur_connect)->update("UPDATE ".$db_name." 
                  SET ctlrnotificapregunta = 1
                  WHERE idpregunta = '".$rec->idpregunta."'");
   
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

    //Actualiza estado del mensaje
    public function updateNotificacionResptaVendedor($rec)
    {
        //echo json_encode($rec->estadomensaje);
        //exit;
        $db_name = $this->db.".preguntavendedor";
   
        DB::beginTransaction();
        try {
   
              DB::connection($this->cur_connect)->update("UPDATE ".$db_name." 
                  SET ctlrnotificarespuesta = 1
                  WHERE idpregunta = '".$rec->idpregunta."'");
   
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

    //Grabar calificación producto
    public function savePreguntaVendedor($rec)
    {
        DB::beginTransaction();
        try {
                    $db_name = $this->db.".preguntavendedor";
                    $preguntavend = new ModelGlobal();
                    $preguntavend->setConnection($this->cur_connect);
                    $preguntavend->setTable($db_name);

                    $preguntavend->idprd = $rec->idprd;
                    $preguntavend->uidcomprador = $rec->uidcomprador;
                    $preguntavend->uidvendedor = $rec->uidvendedor;
                    $preguntavend->idpregunta = $rec->idpregunta;
                    $preguntavend->fechacreacion = $date = date('Y-m-d H:i:s');
                    $preguntavend->fechaactualizacion = $date = date('Y-m-d H:i:s');
                    $preguntavend->comentario = $rec->comentario;
                    $preguntavend->estado = $rec->estado;
                    $preguntavend->ctlrnotificapregunta = 0;
                    $preguntavend->ctlrnotificarespuesta = 0;
//AQUI
                    $preguntavend->save();

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

    public function listarPreguntasProducto($rec)
    {
        DB::beginTransaction();
        try {
        $db_name = "mercadorepuesto_sys";
                
        $listpreguntacompra = DB::connection($this->cur_connect)->select(
                                                "select t0.* 
                                                from ".$db_name.'.preguntavendedor'." t0 
                                                WHERE t0.idprd = '". $rec->idprd."'
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
            'listpreguntacompra' => $listpreguntacompra,
            'message' => 'REGISTRO EXITOSO',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    public function listarPreguntasIdpregunta($rec)
    {
        DB::beginTransaction();
        try {
        $db_name = "mercadorepuesto_sys";
                
        $listpreguntacompra = DB::connection($this->cur_connect)->select(
                                                "select t0.* 
                                                from ".$db_name.'.preguntavendedor'." t0 
                                                WHERE t0.idpregunta = '". $rec->idpregunta."'
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
            'listpreguntacompra' => $listpreguntacompra,
            'message' => 'REGISTRO EXITOSO',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    //Eliminar lista de deseos del usuario
    public function deletePreguntaVendedor($rec)
    {
         $db_name = $this->db.".preguntavendedor";
 
         DB::beginTransaction();
         try {
 
            DB::connection($this->cur_connect)->delete("DELETE FROM ".$db_name." 
            WHERE idpregunta = ".$rec->idpregunta);
 
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

    public function listarPreguntaComprador($rec)
    {
        DB::beginTransaction();
        try {
        $db_name = "mercadorepuesto_sys";
                
        $listpreguntacompra = DB::connection($this->cur_connect)->select(
                                                "select t0.* from ".$db_name.'.preguntavendedor'." t0 
                                                WHERE t0.uidcomprador = '". $rec->uidcomprador."'
                                                AND t0.ctlrnotificarespuesta = 0
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
            'listpreguntacompra' => $listpreguntacompra,
            'message' => 'REGISTRO EXITOSO',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    public function listarPreguntaVendedor($rec)
    {
        DB::beginTransaction();
        try {
        $db_name = "mercadorepuesto_sys";
                
        $listarpreguntavend = DB::connection($this->cur_connect)->select(
                                                "select t0.* from ".$db_name.'.preguntavendedor'." t0 
                                                WHERE t0.uidvendedor = '". $rec->uidvendedor."'
                                                ORDER BY t0.fechacreacion DESC"); 

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
            'listarpreguntavend' => $listarpreguntavend,
            'message' => 'REGISTRO EXITOSO',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    public function listarPrgVendedorNotificacion($rec)
    {
        DB::beginTransaction();
        try {
        $db_name = "mercadorepuesto_sys";
                
        $listarpreguntavend = DB::connection($this->cur_connect)->select(
                                                "select t0.* from ".$db_name.'.preguntavendedor'." t0 
                                                WHERE t0.uidvendedor = '". $rec->uidvendedor."'
                                                AND t0.ctlrnotificaventa = '0'
                                                ORDER BY t0.fechacreacion DESC"); 

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
            'listarpreguntavend' => $listarpreguntavend,
            'message' => 'REGISTRO EXITOSO',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    public function listarPreguntaMisProductos($rec)
    {
        DB::beginTransaction();
        try {
        $db_name = "mercadorepuesto_sys";
                
        $listapreguntamisprd = DB::connection($this->cur_connect)->select(
                                                "select t0.* 
                                                from ".$db_name.'.preguntavendedor'." t0 
                                                WHERE t0.uidvendedor = '". $rec->uidvendedor."'
                                                  AND t0.estado in (81,82,83)
                                                ORDER BY t0.fechacreacion DESC"); 

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
            'listapreguntamisprd' => $listapreguntamisprd,
            'message' => 'REGISTRO EXITOSO',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    public function listarPreguntaUsuarioPrd($rec)
    {
        DB::beginTransaction();
        try {
        $db_name = "mercadorepuesto_sys";
                
        $listarpreguntasusuarioprd = DB::connection($this->cur_connect)->select(
                                                "select t0.* 
                                                from ".$db_name.'.preguntavendedor'." t0 
                                                WHERE t0.uidcomprador = '". $rec->uidcomprador."'
                                                AND t0.estado in (80,81,83)
                                                ORDER BY t0.fechacreacion DESC"); 
//   AND t0.estado in (81,82,83)
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
            'listarpreguntasusuarioprd' => $listarpreguntasusuarioprd,
            'message' => 'REGISTRO EXITOSO',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    public function listarPrgComprador($rec)
    {
        DB::beginTransaction();
        try {
        $db_name = "mercadorepuesto_sys";
                
        $listarprgcomprador = DB::connection($this->cur_connect)->select(
                                                "select t0.*, t1.*, t2.nombre as nombreestado,
                                                t0.id as idmensaje, t3.compatible, t0.fechacreacion as fechapregunta,
                                                t3.titulonombre, t3.precio, t3.descripcionproducto,
                                                TRUNCATE(((DATEDIFF(NOW(), t0.fechaactualizacion))),1) AS tiempoactualiza
                                                from ".$db_name.'.preguntavendedor'." t0
                                                JOIN ".$db_name.'.users'." t1 ON t0.uidcomprador = t1.uid
                                                JOIN ".$db_name.'.estados'." t2 ON t0.estado = t2.tipodeestado
                                                JOIN ".$db_name.'.productos'." t3 ON t0.idprd = t3.id
                                                WHERE t0.estado in (80,81,84)
                                                ORDER BY t0.fechacreacion DESC"); 

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
            'listarprgcomprador' => $listarprgcomprador,
            'message' => 'REGISTRO EXITOSO',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    public function listarPrgConsolaAdmon($rec)
    {
        DB::beginTransaction();
        try {
        $db_name = "mercadorepuesto_sys";
                
        $listarprgcomprador = DB::connection($this->cur_connect)->select(
                                                "select t0.*, t1.*, t2.nombre as nombreestado,
                                                t0.id as idmensaje, t3.compatible, t0.fechacreacion as fechapregunta,
                                                t3.titulonombre, t3.precio, t3.descripcionproducto,
                                                TRUNCATE(((DATEDIFF(NOW(), t0.fechaactualizacion))),1) AS tiempoactualiza
                                                from ".$db_name.'.preguntavendedor'." t0
                                                JOIN ".$db_name.'.users'." t1 ON t0.uidcomprador = t1.uid
                                                JOIN ".$db_name.'.estados'." t2 ON t0.estado = t2.tipodeestado
                                                JOIN ".$db_name.'.productos'." t3 ON t0.idprd = t3.id
                                                WHERE t0.estado in (80,81,82,83,84,85)
                                                ORDER BY t0.fechacreacion DESC"); 

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
            'listarprgcomprador' => $listarprgcomprador,
            'message' => 'REGISTRO EXITOSO',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    public function listarRespVendedor($rec)
    {
        DB::beginTransaction();
        try {
        $db_name = "mercadorepuesto_sys";
                
        $listarrespvendedor = DB::connection($this->cur_connect)->select(
                                                "select t0.*, t1.*, t2.nombre as nombreestado,
                                                t0.id as idmensaje, t0.fechacreacion as fecharespuesta,
                                                TRUNCATE(((DATEDIFF(NOW(), t0.fechaactualizacion))),1) AS tiempoactualiza,
                                                t3.compatible
                                                from ".$db_name.'.preguntavendedor'." t0
                                                JOIN ".$db_name.'.users'." t1 ON t0.uidvendedor = t1.uid 
                                                JOIN ".$db_name.'.estados'." t2 ON t0.estado = t2.tipodeestado
                                                JOIN ".$db_name.'.productos'." t3 ON t0.idprd = t3.id
                                                WHERE t0.estado in (82,83,85)
                                                ORDER BY t0.fechacreacion DESC"); 

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
            'listarrespvendedor' => $listarrespvendedor,
            'message' => 'REGISTRO EXITOSO',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    //Grabar calificación producto
    public function saveCalificacionVendedor($rec)
    {
        DB::beginTransaction();
        try {
                    $db_name = $this->db.".calificacionvendedor";
                    $calificacionVend = new ModelGlobal();
                    $calificacionVend->setConnection($this->cur_connect);
                    $calificacionVend->setTable($db_name);

                    $calificacionVend->uidcomprador = $rec->uidcomprador;
                    $calificacionVend->uidvendedor = $rec->uidvendedor;
                    $calificacionVend->uidproducto = $rec->uidproducto;
                    $calificacionVend->fechacreacion = $date = date('Y-m-d H:i:s');
                    $calificacionVend->calificacion = $rec->calificacion;
                    $calificacionVend->comentario = $rec->comentario;

                    $calificacionVend->save();

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

    public function listarCalificacionVendedorPrd($rec)
    {
        DB::beginTransaction();
        try {
        $db_name = "mercadorepuesto_sys";
                
        $listarcalificacionvendprd = DB::connection($this->cur_connect)->select(
                        "select t0.* from ".$db_name.'.calificacionvendedor'." t0
                        WHERE t0.uidvendedor = '".$rec->uidvendedor."' ORDER BY t0.id DESC"); 
/*
 WHERE t0.uidvendedor = '". $rec->uidvendedor."'
                           && t0.uidproducto = '".$rec->uidproducto."' ORDER BY t0.id DESC"); 

&& t0.uidcomprador = '". $rec->uidcomprador."'*/
                           
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
            'listarcalificacionvendprd' => $listarcalificacionvendprd,
            'message' => 'REGISTRO EXITOSO',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    public function listarCalificacionPrdCompra($rec)
    {
        DB::beginTransaction();
        try {
        $db_name = "mercadorepuesto_sys";
                
        $listarcalprdcompra = DB::connection($this->cur_connect)->select(
                                                "select t0.* 
                                                from ".$db_name.'.calificacionvendedor'." t0 
                                                WHERE t0.uidcomprador = '". $rec->uidcomprador."'
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
            'listarcalprdcompra' => $listarcalprdcompra,
            'message' => 'REGISTRO EXITOSO',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    public function listarCalificacionPrdVende($rec)
    {
        DB::beginTransaction();
        try {
        $db_name = "mercadorepuesto_sys";
                
        $listarcalprdvendedor = DB::connection($this->cur_connect)->select(
                                                "select t0.* 
                                                from ".$db_name.'.calificacionvendedor'." t0 
                                                WHERE t0.uidvendedor = '". $rec->uidvendedor."'
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
            'listarcalprdvendedor' => $listarcalprdvendedor,
            'message' => 'REGISTRO EXITOSO',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    //Grabar items lista de deseos
    public function saveWishList($rec)
    {
        DB::beginTransaction();
        try {
                    $db_name = $this->db.".listadedeseos";
                    $grabarlistadeseo = new ModelGlobal();
                    $grabarlistadeseo->setConnection($this->cur_connect);
                    $grabarlistadeseo->setTable($db_name);

                    $grabarlistadeseo->idproducto = $rec->idproducto;
                    $grabarlistadeseo->compatible = $rec->compatible;
                    $grabarlistadeseo->usuario = $rec->usuario;
                    $grabarlistadeseo->fechacreacion = $date = date('Y-m-d H:i:s');

                    $grabarlistadeseo->save();

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

    public function listarWishList($rec)
    {
        DB::beginTransaction();
        try {
        $db_name = "mercadorepuesto_sys";
                
        $listaritemdeseos = DB::connection($this->cur_connect)->select(
                                                "select t0.*, t1.titulonombre, t1.precio, t1.numerodeunidades,
                                                        t1.nombreimagen1
                                                from ".$db_name.'.listadedeseos'." t0 
                                                JOIN ".$db_name.'.productos'." t1 ON t0.idproducto = t1.id
                                                WHERE t0.usuario = '". $rec->usuario."'
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
            'listaritemdeseos' => $listaritemdeseos,
            'message' => 'REGISTRO EXITOSO',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    public function listarUnPrdWishList($rec)
    {
        DB::beginTransaction();
        try {
        $db_name = "mercadorepuesto_sys";
                
        $listaritemdeseos = DB::connection($this->cur_connect)->select(
                                                "select t0.*, t1.titulonombre, t1.precio, t1.numerodeunidades,
                                                        t1.nombreimagen1
                                                from ".$db_name.'.listadedeseos'." t0 
                                                JOIN ".$db_name.'.productos'." t1 ON t0.idproducto = t1.id
                                                WHERE t0.usuario = '".$rec->usuario."' 
                                                  AND t0.idproducto = ".$rec->idproducto);

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
            'listaritemdeseos' => $listaritemdeseos,
            'message' => 'REGISTRO EXITOSO',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    //Eliminar lista de deseos del usuario
    public function deleteWishListUser($rec)
    {
         $db_name = $this->db.".listadedeseos";
 
         DB::beginTransaction();
         try {
 
            DB::connection($this->cur_connect)->delete("DELETE FROM ".$db_name." 
            WHERE usuario = ".$rec->usuario);
 
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

    //Eliminar lista de deseos del usuario
    public function deleteWishListItemUser($rec)
    {
         $db_name = $this->db.".listadedeseos";
 
         DB::beginTransaction();
         try {
 
            DB::connection($this->cur_connect)->delete("DELETE FROM ".$db_name." 
            WHERE usuario = '".$rec->usuario."' AND idproducto = ".$rec->idproducto);

        /*WHERE usuario = ".$rec->usuario);*/
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

    //Eliminar lista de deseos del usuario
    public function deleteWishListPrd($rec)
    {
         $db_name = $this->db.".listadedeseos";
 
         DB::beginTransaction();
         try {
 
            DB::connection($this->cur_connect)->delete("DELETE FROM ".$db_name." 
            WHERE idproducto = ".$rec->idproducto);

        /*WHERE usuario = ".$rec->usuario);*/
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

    //Grabar items lista de deseos historico
    public function saveWishListHistory($rec)
    {
        DB::beginTransaction();
        try {
                    $db_name = $this->db.".listadedeseoshistorial";
                    $grabarlistadeseo = new ModelGlobal();
                    $grabarlistadeseo->setConnection($this->cur_connect);
                    $grabarlistadeseo->setTable($db_name);

                    $grabarlistadeseo->idproducto = $rec->idproducto;
                    $grabarlistadeseo->compatible = $rec->compatible;
                    $grabarlistadeseo->usuario = $rec->usuario;
                    $grabarlistadeseo->fechacreacion = $date = date('Y-m-d H:i:s');

                    $grabarlistadeseo->save();

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

    /*
  $historywishlist = DB::connection($this->cur_connect)->select(
                                                "select t0.*, t1.titulonombre, t1.precio, t1.numerodeunidades,
                                                        t1.nombreimagen1
                                                from ".$db_name.'.listadedeseoshistorial'." t0 
                                                JOIN ".$db_name.'.productos'." t1 ON t0.idproducto = t1.id
                                                WHERE t0.idproducto = ".$rec->idproducto);
    */

    public function listPrdWishListHistory($rec)
    {
        DB::beginTransaction();
        try {
        $db_name = "mercadorepuesto_sys";
                
        $historywishlist = DB::connection($this->cur_connect)->select(
                                                "select MONTH(fechacreacion) AS mes, COUNT(*) AS cantidad
                                                from ".$db_name.'.listadedeseoshistorial'." t0 
                                                WHERE t0.idproducto = '".$rec->idproducto."'
                                                GROUP BY mes");

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
            'historywishlist' => $historywishlist,
            'message' => 'REGISTRO EXITOSO',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    //Grabar items lista de deseos
    public function saveMyPosts($rec)
    {
        DB::beginTransaction();
        try {
                    $db_name = $this->db.".visitaspublicacion";
                    $saveaddposts = new ModelGlobal();
                    $saveaddposts->setConnection($this->cur_connect);
                    $saveaddposts->setTable($db_name);

                    $saveaddposts->idproducto = $rec->idproducto;
                    $saveaddposts->compatible = $rec->compatible;
                    $saveaddposts->usuario = $rec->usuario;
                    $saveaddposts->fechacreacion = $date = date('Y-m-d H:i:s');

                    $saveaddposts->save();

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

    public function listarAllMyPosts($rec)
    {
        DB::beginTransaction();
        try {
        $db_name = "mercadorepuesto_sys";
                
        $tolistallmyposts = DB::connection($this->cur_connect)->select(
                                                "select t0.*, t1.id as idproducto, t1.titulonombre, t1.precio, t1.numerodeunidades,
                                                        t1.nombreimagen1
                                                from ".$db_name.'.visitaspublicacion'." t0 
                                                JOIN ".$db_name.'.productos'." t1 ON t0.idproducto = t1.id
                                                WHERE t0.usuario = ". $rec->usuario." ORDER BY t0.id DESC"); 
                                              

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
            'tolistallmyposts' => $tolistallmyposts,
            'message' => 'REGISTRO EXITOSO',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    public function listarMyPosts($rec)
    {
        DB::beginTransaction();
        try {
        $db_name = "mercadorepuesto_sys";
                
        $tolistmyposts = DB::connection($this->cur_connect)->select(
                                                "select t0.*, t1.id as idproducto, t1.titulonombre, t1.precio, t1.numerodeunidades,
                                                        t1.nombreimagen1
                                                from ".$db_name.'.visitaspublicacion'." t0 
                                                JOIN ".$db_name.'.productos'." t1 ON t0.idproducto = t1.id
                                                WHERE t0.usuario = '". $rec->usuario."' 
                                                   && t0.idproducto = ".$rec->idproducto." ORDER BY t0.id DESC"); 
                                              

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
            'tolistmyposts' => $tolistmyposts,
            'message' => 'REGISTRO EXITOSO',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    public function listarUnPrdMyPosts($rec)
    {
        DB::beginTransaction();
        try {
        $db_name = "mercadorepuesto_sys";
                
        $listitemmypost = DB::connection($this->cur_connect)->select(
                                                "select t0.*, t1.titulonombre, t1.precio, t1.numerodeunidades,
                                                        t1.nombreimagen1
                                                from ".$db_name.'.visitaspublicacion'." t0 
                                                JOIN ".$db_name.'.productos'." t1 ON t0.idproducto = t1.id
                                                WHERE t0.usuario = '".$rec->usuario."' AND t0.idproducto = ".$rec->idproducto);

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
            'listitemmypost' => $listitemmypost,
            'message' => 'REGISTRO EXITOSO',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    //Eliminar lista de deseos del usuario
    public function deleteMyPostsUser($rec)
    {
         $db_name = $this->db.".visitaspublicacion";
 
         DB::beginTransaction();
         try {
 
            DB::connection($this->cur_connect)->delete("DELETE FROM ".$db_name." 
            WHERE usuario = ".$rec->usuario);
 
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

    //Eliminar lista de deseos del usuario
    public function deleteMyPostsItemUser($rec)
    {
         $db_name = $this->db.".visitaspublicacion";
 
         DB::beginTransaction();
         try {
 
            DB::connection($this->cur_connect)->delete("DELETE FROM ".$db_name." 
            WHERE usuario = '".$rec->usuario."' AND idproducto = ".$rec->idproducto);

        /*WHERE usuario = ".$rec->usuario);*/
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

    //Grabar historico visitas prd user
    public function saveHistoryVisitPrd($rec)
    {
        DB::beginTransaction();
        try {
                    $db_name = $this->db.".historicovisitasprd";
                    $saveaddposts = new ModelGlobal();
                    $saveaddposts->setConnection($this->cur_connect);
                    $saveaddposts->setTable($db_name);

                    $saveaddposts->idproducto = $rec->idproducto;
                    $saveaddposts->compatible = $rec->compatible;
                    $saveaddposts->usuario = $rec->usuario;
                    $saveaddposts->fechacreacion = $date = date('Y-m-d H:i:s');

                    $saveaddposts->save();

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

    public function listarAllHistoryVisitPrd($rec)
    {
        DB::beginTransaction();
        try {
        $db_name = "mercadorepuesto_sys";
                
        $listarallhistoryvisitprd = DB::connection($this->cur_connect)->select(
                                                "select t0.*, t1.id as idproducto, t1.titulonombre, t1.precio, t1.numerodeunidades,
                                                        t1.nombreimagen1
                                                from ".$db_name.'.historicovisitasprd'." t0 
                                                JOIN ".$db_name.'.productos'." t1 ON t0.idproducto = t1.id
                                                WHERE t0.usuario = ". $rec->usuario." ORDER BY t0.id DESC"); 
                                              

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
            'listarallhistoryvisitprd' => $listarallhistoryvisitprd,
            'message' => 'REGISTRO EXITOSO',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    public function listarHistoryVisitPrd($rec)
    {
        DB::beginTransaction();
        try {
        $db_name = "mercadorepuesto_sys";
                
        $listarhistoryvisitprd = DB::connection($this->cur_connect)->select(
                                                "select t0.*, t1.id as idproducto, t1.titulonombre, t1.precio, t1.numerodeunidades,
                                                        t1.nombreimagen1
                                                from ".$db_name.'.historicovisitasprd'." t0 
                                                JOIN ".$db_name.'.productos'." t1 ON t0.idproducto = t1.id
                                                WHERE t0.usuario = '". $rec->usuario."' 
                                                   && t0.idproducto = ".$rec->idproducto." ORDER BY t0.id DESC"); 
                                              

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
            'listarhistoryvisitprd' => $listarhistoryvisitprd,
            'message' => 'REGISTRO EXITOSO',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    //Eliminar item del historico de visitas
    public function deleteHistoryVisitPrd($rec)
    {
         $db_name = $this->db.".historicovisitasprd";
 
         DB::beginTransaction();
         try {
 
            DB::connection($this->cur_connect)->delete("DELETE FROM ".$db_name." 
            WHERE usuario = ".$rec->usuario);
 
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

    //Eliminar item del historico de visitas
    public function deleteItemHistoryVisitPrd($rec)
    {
         $db_name = $this->db.".historicovisitasprd";
 
         DB::beginTransaction();
         try {
 
            DB::connection($this->cur_connect)->delete("DELETE FROM ".$db_name." 
            WHERE usuario = '".$rec->usuario."' AND idproducto = ".$rec->idproducto);

        /*WHERE usuario = ".$rec->usuario);*/
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

    //Grabar Dispositivos vinculados
    public function saveLinkedDevices($rec)
    {
        DB::beginTransaction();
        try {
                    $db_name = $this->db.".dispositivosvinculados";
                    $savelinkeddevices = new ModelGlobal();
                    $savelinkeddevices->setConnection($this->cur_connect);
                    $savelinkeddevices->setTable($db_name);

                    $savelinkeddevices->iddispositivo = $rec->iddispositivo;
                    $savelinkeddevices->localizacion = $rec->localizacion;
                    $savelinkeddevices->usuario = $rec->usuario;
                    $savelinkeddevices->fechacreacion = $date = date('Y-m-d H:i:s');

                    $savelinkeddevices->save();

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

    //Grabar Dispositivos vinculados
    public function saveHistoryLinkedDevices($rec)
    {
        DB::beginTransaction();
        try {
                    $db_name = $this->db.".historicodispositivosvinculados";
                    $savelinkeddevices = new ModelGlobal();
                    $savelinkeddevices->setConnection($this->cur_connect);
                    $savelinkeddevices->setTable($db_name);

                    $savelinkeddevices->iddispositivo = $rec->iddispositivo;
                    $savelinkeddevices->localizacion = $rec->localizacion;
                    $savelinkeddevices->usuario = $rec->usuario;
                    $savelinkeddevices->fechacreacion = $date = date('Y-m-d H:i:s');

                    $savelinkeddevices->save();

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

    public function updateLinkedDevices($rec)
    {
        //echo json_encode($rec->id);
        //exit;
        $db_name = $this->db.".dispositivosvinculados";
   
        DB::beginTransaction();
        try {

            $date = date('Y-m-d H:i:s');
   
            DB::connection($this->cur_connect)->update("UPDATE ".$db_name." 
                SET fechacreacion = '".$date."'
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


    public function listLinkedDevices($rec)
    {
        DB::beginTransaction();
        try {
        $db_name = "mercadorepuesto_sys";
                
        $listLinkedDevices = DB::connection($this->cur_connect)->select(
                                                "select t0.*
                                                from ".$db_name.'.dispositivosvinculados'." t0 
                                                WHERE t0.usuario = ". $rec->usuario." ORDER BY t0.id DESC"); 
                                              

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
            'listLinkedDevices' => $listLinkedDevices,
            'message' => 'REGISTRO EXITOSO',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    public function listHistoryLinkedDevices($rec)
    {
        DB::beginTransaction();
        try {
        $db_name = "mercadorepuesto_sys";
                
        $lisHistorytLinkedDevices = DB::connection($this->cur_connect)->select(
                                                "select t0.*
                                                from ".$db_name.'.historicodispositivosvinculados'." t0 
                                                WHERE t0.usuario = ". $rec->usuario." ORDER BY t0.id DESC"); 
                                              

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
            'lisHistorytLinkedDevices' => $lisHistorytLinkedDevices,
            'message' => 'REGISTRO EXITOSO',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    public function lisItemtLinkedDevices($rec)
    {
        DB::beginTransaction();
        try {
        $db_name = "mercadorepuesto_sys";
                
        $lisItemtLinkedDevices = DB::connection($this->cur_connect)->select(
                                                "select t0.*
                                                from ".$db_name.'.dispositivosvinculados'." t0 
                                                WHERE t0.usuario = '". $rec->usuario."' 
                                                   && t0.id = ".$rec->id." ORDER BY t0.id DESC"); 
                                              

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
            'lisItemtLinkedDevices' => $lisItemtLinkedDevices,
            'message' => 'REGISTRO EXITOSO',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    //Eliminar lista de deseos del usuario
    public function deleteLinkedDevices($rec)
    {
         $db_name = $this->db.".dispositivosvinculados";
 
         DB::beginTransaction();
         try {
 
            DB::connection($this->cur_connect)->delete("DELETE FROM ".$db_name." 
            WHERE usuario = ".$rec->usuario);
 
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

    //Eliminar lista de deseos del usuario
    public function deleteHistoryLinkedDevices($rec)
    {
         $db_name = $this->db.".historicodispositivosvinculados";
 
         DB::beginTransaction();
         try {
 
            DB::connection($this->cur_connect)->delete("DELETE FROM ".$db_name." 
            WHERE usuario = ".$rec->usuario);
 
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

    //Eliminar lista de deseos del usuario
    public function deleteItemLinkedDevices($rec)
    {
         $db_name = $this->db.".dispositivosvinculados";
 
         DB::beginTransaction();
         try {
 
            DB::connection($this->cur_connect)->delete("DELETE FROM ".$db_name." 
            WHERE usuario = '".$rec->usuario."' AND id = ".$rec->id);

        /*WHERE usuario = ".$rec->usuario);*/
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

    //Eliminar lista de deseos del usuario
    public function deleteHistoryItemLinkedDevices($rec)
    {
         $db_name = $this->db.".historicodispositivosvinculados";
 
         DB::beginTransaction();
         try {
 
            DB::connection($this->cur_connect)->delete("DELETE FROM ".$db_name." 
            WHERE usuario = '".$rec->usuario."' AND id = ".$rec->id);

        /*WHERE usuario = ".$rec->usuario);*/
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


    //Grabar items carrito de compra
    public function saveShoppingCart($rec)
    {
        DB::beginTransaction();
        try {
                    $db_name = $this->db.".carritocompra";
                    $grabarcarritocompra = new ModelGlobal();
                    $grabarcarritocompra->setConnection($this->cur_connect);
                    $grabarcarritocompra->setTable($db_name);

                    $grabarcarritocompra->idproducto = $rec->idproducto;
                    $grabarcarritocompra->compatible = $rec->compatible;
                    $grabarcarritocompra->usuario = $rec->usuario;
                    $grabarcarritocompra->cantidad = $rec->cantidad;
                    $grabarcarritocompra->fechacreacion = $date = date('Y-m-d H:i:s');

                    $grabarcarritocompra->save();

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

    public function listarShoppingCart($rec)
    {
        DB::beginTransaction();
        try {
        $db_name = "mercadorepuesto_sys";
                
        $listarcarritocompra = DB::connection($this->cur_connect)->select(
                                                "select t0.*, t1.titulonombre, t1.precio, t1.numerodeunidades,
                                                        t1.nombreimagen1, t2.email as emailvendedor,
                                                        t2.uid as uidvendedor
                                                from ".$db_name.'.carritocompra'." t0 
                                                JOIN ".$db_name.'.productos'." t1 ON t0.idproducto = t1.id
                                                JOIN ".$db_name.'.users'." t2 ON t1.usuario = t2.uid
                                                WHERE t0.usuario = '". $rec->usuario."'
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
            'listarcarritocompra' => $listarcarritocompra,
            'message' => 'REGISTRO EXITOSO',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    public function listarUnPrdShoppingCart($rec)
    {
        DB::beginTransaction();
        try {
        $db_name = "mercadorepuesto_sys";
                
        $listaritemcarrito = DB::connection($this->cur_connect)->select(
                                                "select t0.*, t1.titulonombre, t1.precio, t1.numerodeunidades,
                                                        t1.nombreimagen1, t2.email as emailvendedor
                                                from ".$db_name.'.carritocompra'." t0 
                                                JOIN ".$db_name.'.productos'." t1 ON t0.idproducto = t1.id
                                                JOIN ".$db_name.'.users'." t2 ON t1.usuario = t2.uid
                                                WHERE t0.usuario = '".$rec->usuario."' 
                                                  AND t0.idproducto = ".$rec->idproducto);

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
            'listaritemcarrito' => $listaritemcarrito,
            'message' => 'REGISTRO EXITOSO',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    //Actualiza item carrito de compra
    public function actualizaItemShoppingCart($rec)
    {
        //echo json_encode($rec->id);
        //exit;
        $db_name = $this->db.".carritocompra";
   
        DB::beginTransaction();
        try {
   
              DB::connection($this->cur_connect)->update("UPDATE ".$db_name." 
                  SET cantidad = '".$rec-> cantidad."'
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

    //Eliminar producto carrito de compra por usuario
    public function deleteShoppingCartUser($rec)
    {
         $db_name = $this->db.".carritocompra";
 
         DB::beginTransaction();
         try {
 
            DB::connection($this->cur_connect)->delete("DELETE FROM ".$db_name." 
            WHERE usuario = ".$rec->usuario);
 
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

    //Eliminar lista items carrito compra
    public function deleteShoppingCartItemUser($rec)
    {
         $db_name = $this->db.".carritocompra";
 
         DB::beginTransaction();
         try {
 
            DB::connection($this->cur_connect)->delete("DELETE FROM ".$db_name." 
            WHERE usuario = '".$rec->usuario."' AND idproducto = ".$rec->idproducto);

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

    //Eliminar lista items carrito compra
    public function deleteShoppingCartPrd($rec)
    {
         $db_name = $this->db.".carritocompra";
 
         DB::beginTransaction();
         try {
 
            DB::connection($this->cur_connect)->delete("DELETE FROM ".$db_name." 
            WHERE idproducto = ".$rec->idproducto);

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

    //Grabar items carrito de compra historial
    public function saveShoppingCartHistory($rec)
    {
        DB::beginTransaction();
        try {
                    $db_name = $this->db.".carritocomprahistorial";
                    $grabarcarritocompra = new ModelGlobal();
                    $grabarcarritocompra->setConnection($this->cur_connect);
                    $grabarcarritocompra->setTable($db_name);

                    $grabarcarritocompra->idproducto = $rec->idproducto;
                    $grabarcarritocompra->compatible = $rec->compatible;
                    $grabarcarritocompra->usuario = $rec->usuario;
                    $grabarcarritocompra->cantidad = $rec->cantidad;
                    $grabarcarritocompra->fechacreacion = $date = date('Y-m-d H:i:s');

                    $grabarcarritocompra->save();

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

    public function HistoryPrdShoppingCart($rec)
    {
        DB::beginTransaction();
        try {
        $db_name = "mercadorepuesto_sys";
                
        $historialcarritocompra = DB::connection($this->cur_connect)->select(
                                                "select MONTH(fechacreacion) AS mes, COUNT(*) AS cantidad
                                                from ".$db_name.'.carritocomprahistorial'." t0 
                                                WHERE t0.idproducto = '".$rec->idproducto."'
                                                GROUP BY mes");

                                            
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
            'historialcarritocompra' => $historialcarritocompra,
            'message' => 'REGISTRO EXITOSO',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    /*
    public function HistoryPrdShoppingCart($rec)
    {
        DB::beginTransaction();
        try {
        $db_name = "mercadorepuesto_sys";
                
        $historialcarritocompra = DB::connection($this->cur_connect)->select(
                                                "select t0.*, t1.titulonombre, t1.precio, t1.numerodeunidades,
                                                        t1.nombreimagen1
                                                from ".$db_name.'.carritocomprahistorial'." t0 
                                                JOIN ".$db_name.'.productos'." t1 ON t0.idproducto = t1.id
                                                WHERE t0.idproducto = ".$rec->idproducto);

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
            'historialcarritocompra' => $historialcarritocompra,
            'message' => 'REGISTRO EXITOSO',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }
    */

    //Grabar direccion del usuario
    public function saveAddressUser($rec)
    {
        DB::beginTransaction();
        try {
                    $db_name = $this->db.".direccionesusuarios";
                    $grabardireccionusuario = new ModelGlobal();
                    $grabardireccionusuario->setConnection($this->cur_connect);
                    $grabardireccionusuario->setTable($db_name);

                    $grabardireccionusuario->usuario = $rec->usuario;
                    $grabardireccionusuario->direccion = $rec->direccion;
                    $grabardireccionusuario->tipocalle = $rec->tipocalle;
                    $grabardireccionusuario->calle = $rec->calle;
                    $grabardireccionusuario->numerouno = $rec->numerouno;
                    $grabardireccionusuario->numerodos = $rec->numerodos;
                    $grabardireccionusuario->ciudad = $rec->ciudad;
                    $grabardireccionusuario->barrio = $rec->barrio;
                    $grabardireccionusuario->telefonorecibe = $rec->telefonorecibe;
                    $grabardireccionusuario->nombrerecibe = $rec->nombrerecibe;
                    $grabardireccionusuario->comentario = $rec->comentario;
                    $grabardireccionusuario->fechacreacion = $date = date('Y-m-d H:i:s');

                    $grabardireccionusuario->save();

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

    public function listarAddressUser($rec)
    {
        DB::beginTransaction();
        try {
        $db_name = "mercadorepuesto_sys";
                
        $listardireccionesusuario = DB::connection($this->cur_connect)->select(
                                                "select t0.*, t1.nombre_ciu as nombreciudad, t2.nombre_dep,
                                                t2.codigo_dep, t1.codigo_ciu
                                                from ".$db_name.'.direccionesusuarios'." t0 
                                                JOIN ".$db_name.'.ciudades'." t1 ON t0.ciudad = t1.id_ciu
                                                JOIN ".$db_name.'.departamentos'." t2 ON t1.departamento_ciu = t2.codigo_dep
                                                WHERE t0.usuario = '". $rec->usuario."'
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
            'listardireccionesusuario' => $listardireccionesusuario,
            'message' => 'REGISTRO EXITOSO',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    public function listarUnAddressUser($rec)
    {
        DB::beginTransaction();
        try {
        $db_name = "mercadorepuesto_sys";
                
        $listarunadireccion = DB::connection($this->cur_connect)->select(
                                                "select t0.*, t1.nombre_ciu as nombreciudad, t2.nombre_dep
                                                from ".$db_name.'.direccionesusuarios'." t0 
                                                JOIN ".$db_name.'.ciudades'." t1 ON t0.ciudad = t1.id_ciu
                                                JOIN ".$db_name.'.departamentos'." t2 ON t1.departamento_ciu = t2.codigo_dep
                                                WHERE t0.usuario = '".$rec->usuario."' AND t0.id = ".$rec->iddireccion);

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
            'listarunadireccion' => $listarunadireccion,
            'message' => 'REGISTRO EXITOSO',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    //Actualizar dirección del usuario
    public function actualizaAddressUser($rec)
    {
        //echo json_encode($rec->id);
        //exit;
        $db_name = $this->db.".direccionesusuarios";
   
        DB::beginTransaction();
        try {
   
              DB::connection($this->cur_connect)->update("UPDATE ".$db_name." 
                  SET ciudad = '".$rec-> ciudad."',
                      direccion = '".$rec-> direccion."',
                      comentario = '".$rec-> comentario."',
                      tipocalle = '".$rec->tipocalle."',
                      calle = '".$rec->calle."',
                      numerouno = '".$rec->numerouno."',
                      numerodos = '".$rec->numerodos."',
                      ciudad = '".$rec->ciudad."',
                      barrio = '".$rec->barrio."',
                      telefonorecibe = '".$rec->telefonorecibe."',
                      nombrerecibe = '".$rec->nombrerecibe."'
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

    //Eliminar las direcciones del usuario
    public function deleteAddressUser($rec)
    {
         $db_name = $this->db.".direccionesusuarios";
 
         DB::beginTransaction();
         try {
 
            DB::connection($this->cur_connect)->delete("DELETE FROM ".$db_name." 
            WHERE usuario = ".$rec->usuario);
 
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

    //Eliminar una dirección del usuario
    public function deleteOneAddressUser($rec)
    {
         $db_name = $this->db.".direccionesusuarios";
 
         DB::beginTransaction();
         try {
 
            DB::connection($this->cur_connect)->delete("DELETE FROM ".$db_name." 
            WHERE usuario = '".$rec->usuario."' AND id = ".$rec->iddireccion);

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

    public function listarMvtoWompi($rec)
    {
        DB::beginTransaction();
        try {
        $db_name = "mercadorepuesto_sys";
                
        $listarmvtowompi = DB::connection($this->cur_connect)->select(
                                                "select t0.*
                                                 from ".$db_name.'.transactions_wompi'." t0 
                                                 WHERE t0.idwompi = ".$rec->idtransaccion);

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
            'listarmvtowompi' => $listarmvtowompi,
            'message' => 'REGISTRO EXITOSO',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    public function createVehiculosCompatibles($rec)
    {
        //echo json_encode($rec->estado);
        //exit;
        DB::beginTransaction();
        try {
                    $db_name = $this->db.".productosvehiculos";
                    $compatibles = new ModelGlobal();
                    $compatibles->setConnection($this->cur_connect);
                    $compatibles->setTable($db_name);

                    $compatibles->codigopublicacion = $rec->codigopublicacion;
                    $compatibles->tipovehiculo = $rec->tipovehiculo;
                    $compatibles->carroceria = $rec->carroceria;
                    $compatibles->marca = $rec->marca;
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
            'message' => 'REGISTRO VEHICULOS COMPATIBLES EXITOSO',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    public function createVehiculosGarage($rec)
    {
        //echo json_encode($rec->estado);
        //exit;
        DB::beginTransaction();
        try {
                    $db_name = $this->db.".vehiculosgarage";
                    $garage = new ModelGlobal();
                    $garage->setConnection($this->cur_connect);
                    $garage->setTable($db_name);

                    $date = date('Y-m-d H:i:s');

                    $garage->idusuario = $rec->idusuario;
                    $garage->tipovehiculo = $rec->tipovehiculo;
                    $garage->carroceria = $rec->carroceria;
                    $garage->marca = $rec->marca;
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
            'message' => 'REGISTRO VEHICULOS GARAGE EXITOSO',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    public function listarVehiculoGarageUsuario($rec)
    {
        $db_name = "mercadorepuesto_sys";

        $garage = DB::connection($this->cur_connect)->select("
            select t0.* from ".$db_name.'.vehiculosgarage'." t0 
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
        $db_name = "mercadorepuesto_sys";

        $garage = DB::connection($this->cur_connect)->select("
            select t0.* from ".$db_name.'.vehiculosgarage'." t0 
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
         $db_name = $this->db.".vehiculosgarage";
 
         DB::beginTransaction();
         try {
 
                $date = date('Y-m-d H:i:s');
                DB::connection($this->cur_connect)->update("UPDATE ".$db_name." 
                SET tipovehiculo = '".$rec->tipovehiculo."'
                    ,idusuario = '".$rec->idusuario."'
                    ,carroceria = '".$rec->carroceria."'
                    ,marca = '".$rec->marca."'
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
         $db_name = $this->db.".vehiculosgarage";
 
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

    public function crearMarcaVehiculo($rec)
    {
        //echo json_encode($rec->estado);
        //exit;
        DB::beginTransaction();
        try {
                    $db_name = $this->db.".marcas";
                    $nvamarca = new ModelGlobal();
                    $nvamarca->setConnection($this->cur_connect);
                    $nvamarca->setTable($db_name);

                    $nvamarca->text = $rec->nombremarca;
                    $nvamarca->tipovehiculo = $rec->tipo;
                    $nvamarca->carroceria = $rec->carroceria;
                    $nvamarca->estado = $rec->estado;
                    $nvamarca->url = $rec->url;
                    $nvamarca->id = $rec->marca;

                    $nvamarca->save();

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

    public function crearConsecutivoMR($rec)
    {
        //echo json_encode($rec->estado);
        //exit;
        DB::beginTransaction();
        try {
                    $db_name = $this->db.".consecutivomr";
                    $consecutivomr = new ModelGlobal();
                    $consecutivomr->setConnection($this->cur_connect);
                    $consecutivomr->setTable($db_name);

                    $consecutivomr->nombre = $rec->nombre;
                    $consecutivomr->descripcion = $rec->descripcion;
                    $consecutivomr->consecutivo = $rec->consecutivo;
                    $consecutivomr->estado = $rec->estado;
                    
                    $consecutivomr->save();

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

    public function listarConsecutivoMR($rec)
    {
        DB::beginTransaction();
        try {
        $db_name = "mercadorepuesto_sys";
                
        $consecutivoMR = DB::connection($this->cur_connect)->select(
                                                "select t0.*
                                                from ".$db_name.'.consecutivomr'." t0 
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
            'consecutivoMR' => $consecutivoMR,
            'message' => 'REGISTRO EXITOSO',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    //Actualizar Consecutivo MR
    public function actualizarConsecutivoMR($rec)
    {
        //echo json_encode($rec->id);
        //exit;
        $db_name = $this->db.".consecutivomr";
   
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

    public function crearResolverDudaCero($rec)
    {
        //echo json_encode($rec->estado);
        //exit;
        DB::beginTransaction();
        try {
                    $db_name = $this->db.".resolverdudanivelcero";
                    $creardudacero = new ModelGlobal();
                    $creardudacero->setConnection($this->cur_connect);
                    $creardudacero->setTable($db_name);

                    $creardudacero->nivel = $rec->nivel;
                    $creardudacero->nombrenivelcero = $rec->nombrenivelcero;
                    $creardudacero->descripcionnivelcero = $rec->descripcionnivelcero;
                    
                    $creardudacero->save();

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

    public function listarDudaCero($rec)
    {
        DB::beginTransaction();
        try {
        $db_name = "mercadorepuesto_sys";
                
        $resolverdudascero = DB::connection($this->cur_connect)->select(
                                                "select t0.*
                                                from ".$db_name.'.resolverdudanivelcero'." t0
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
            'resolverdudascero' => $resolverdudascero,
            'message' => 'REGISTRO EXITOSO',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    public function listarDudaCeroDesc($rec)
    {
        DB::beginTransaction();
        try {
        $db_name = "mercadorepuesto_sys";
                
        $listardudacero = DB::connection($this->cur_connect)->select(
                                                "select t0.*
                                                from ".$db_name.'.resolverdudanivelcero'." t0
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
            'listardudacero' => $listardudacero,
            'message' => 'REGISTRO EXITOSO',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    //Actualizar Consecutivo MR
    public function actualizarDudaCero($rec)
    {
        //echo json_encode($rec->id);
        //exit;
        $db_name = $this->db.".resolverdudanivelcero";
   
        DB::beginTransaction();
        try {
            DB::connection($this->cur_connect)->update("UPDATE ".$db_name." 
                            SET nombrenivelcero = '".$rec-> nombrenivelcero."',
                                descripcionnivelcero = '".$rec-> descripcionnivelcero."'
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

    public function crearResolverDudaUno($rec)
    {
        //echo json_encode($rec->estado);
        //exit;
        DB::beginTransaction();
        try {
                    $db_name = $this->db.".resolverdudaniveluno";
                    $creardudacero = new ModelGlobal();
                    $creardudacero->setConnection($this->cur_connect);
                    $creardudacero->setTable($db_name);

                    $creardudacero->nivel = $rec->nivel;
                    $creardudacero->nombreniveluno = $rec->nombreniveluno;
                    $creardudacero->descripcionniveluno = $rec->descripcionniveluno;
                    
                    $creardudacero->save();

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
            'message' => 'REGISTRO DUDAS NIVEL UNO',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    public function listarResuelveDudasNivelUno($rec)
    {
        DB::beginTransaction();
        try {
        $db_name = "mercadorepuesto_sys";
                
        $resolverdudasuno = DB::connection($this->cur_connect)->select(
                                                "select t0.*
                                                from ".$db_name.'.resolverdudaniveluno'." t0
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
            'resolverdudasuno' => $resolverdudasuno,
            'message' => 'REGISTRO EXITOSO',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    public function listarUnaCategoria($rec)
    {
        DB::beginTransaction();
        try {
        $db_name = "mercadorepuesto_sys";
                
        $listarunacategoria = DB::connection($this->cur_connect)->select(
                                                "select t0.*
                                                from ".$db_name.'.resolverdudanivelcero'." t0
                                                WHERE nivel = '".$rec->nivel."'");

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
            'listarunacategoria' => $listarunacategoria,
            'message' => 'REGISTRO EXITOSO',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    public function listarUnaSubCategoria($rec)
    {
        DB::beginTransaction();
        try {
        $db_name = "mercadorepuesto_sys";
                
        $listarunasubcategoria = DB::connection($this->cur_connect)->select(
                                                "select t0.*
                                                from ".$db_name.'.resolverdudaniveluno'." t0
                                                WHERE nivel = '".$rec->nivel."'");

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
            'listarunasubcategoria' => $listarunasubcategoria,
            'message' => 'REGISTRO EXITOSO',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    public function listarUnaAyuda($rec)
    {
        DB::beginTransaction();
        try {
        $db_name = "mercadorepuesto_sys";
                
        $listarunaayuda = DB::connection($this->cur_connect)->select(
                                                "select t0.*
                                                from ".$db_name.'.resolverdudaniveldos'." t0
                                                WHERE niveluno = '".$rec->niveluno."'");

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
            'listarunaayuda' => $listarunaayuda,
            'message' => 'REGISTRO EXITOSO',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    //Actualizar Consecutivo MR
    public function actualizarResuelveDudasNivelUno($rec)
    {
        //echo json_encode($rec->id);
        //exit;
        $db_name = $this->db.".resolverdudaniveluno";
   
        DB::beginTransaction();
        try {
            DB::connection($this->cur_connect)->update("UPDATE ".$db_name." 
                            SET nombreniveluno = '".$rec-> nombreniveluno."',
                                descripcionniveluno = '".$rec-> descripcionniveluno."'
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

    public function borrarCategoriaCero($rec)
    {
         $db_name = $this->db.".resolverdudanivelcero";
 
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

    public function borrarCategoriaUno($rec)
    {
         $db_name = $this->db.".resolverdudaniveluno";
 
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

    public function borrarCategoriaDos($rec)
    {
         $db_name = $this->db.".resolverdudaniveldos";
 
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

    public function crearResolverDudaDos($rec)
    {
        //echo json_encode($rec->estado);
        //exit;
        DB::beginTransaction();
        try {
                    $db_name = $this->db.".resolverdudaniveldos";
                    $creardudados = new ModelGlobal();
                    $creardudados->setConnection($this->cur_connect);
                    $creardudados->setTable($db_name);

                    $creardudados->niveldos = $rec->niveldos;
                    $creardudados->niveluno = $rec->niveluno;
                    $creardudados->nombreniveldos = $rec->nombreniveldos;
                    $creardudados->descripcionniveldos = $rec->descripcionniveldos;
                    $creardudados->descripcionniveltres = $rec->descripcionniveltres;
                    $creardudados->descripcionnivelcuatro = $rec->descripcionnivelcuatro;
                    
                    $creardudados->save();

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
            'message' => 'REGISTRO DUDAS NIVEL DOS',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    public function listarResuelveDudasNivelDos($rec)
    {
        DB::beginTransaction();
        try {
        $db_name = "mercadorepuesto_sys";
                
        $resolverdudasdos = DB::connection($this->cur_connect)->select(
                            "select t0.*, t1.*, t0.id as idayuda
                            from ".$db_name.'.resolverdudaniveldos'." t0 
                            JOIN ".$db_name.'.resolverdudaniveluno'." t1 ON t0.niveluno = t1.id
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
            'resolverdudasdos' => $resolverdudasdos,
            'message' => 'REGISTRO EXITOSO',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    public function actualizarResuelveDudasNivelDos($rec)
    {
        //echo json_encode($rec->id);
        //exit;
        $db_name = $this->db.".resolverdudaniveldos";
   
        DB::beginTransaction();
        try {
            DB::connection($this->cur_connect)->update("UPDATE ".$db_name." 
                            SET nombreniveldos = '".$rec-> nombreniveldos."',
                                descripcionniveldos = '".$rec-> descripcionniveldos."',
                                descripcionniveltres = '".$rec-> descripcionniveltres."',
                                descripcionnivelcuatro = '".$rec-> descripcionnivelcuatro."',
                                nombreimagen1 = '".$rec-> nombreimagen1."',
                                nombreimagen2 = '".$rec-> nombreimagen2."',
                                nombreimagen2 = '".$rec-> nombreimagen2."'
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

    //Create Certificate Employee
    public function salvarImgAyuda($rec)
    {

        $db_name = $this->db.".resolverdudaniveldos";
   
        DB::beginTransaction();
        try {
            DB::connection($this->cur_connect)->update("UPDATE ".$db_name." 
                    SET nombreimagen1 = '".$rec-> nombreimagen1."'
                    WHERE id = '".$rec->id."'");

                    //Imagen base 64 se pasa a un arreglo
                    $nombrefoto[1] = $rec->nombreimagen1;
                    $foto[1] = $rec->imagen1;

                    for ($i = 1; $i <= $rec->numerodeimagenes; $i++) {
                        $this->GuardarIMG($foto[$i] ,$nombrefoto[$i],'imagenesmensajes/');
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

    public function salvarImgAyudaDos($rec)
    {

        $db_name = $this->db.".resolverdudaniveldos";
   
        DB::beginTransaction();
        try {
            DB::connection($this->cur_connect)->update("UPDATE ".$db_name." 
                    SET nombreimagen2 = '".$rec-> nombreimagen1."'
                    WHERE id = '".$rec->id."'");

                    //Imagen base 64 se pasa a un arreglo
                    $nombrefoto[1] = $rec->nombreimagen1;
                    $foto[1] = $rec->imagen1;

                    for ($i = 1; $i <= $rec->numerodeimagenes; $i++) {
                        $this->GuardarIMG($foto[$i] ,$nombrefoto[$i],'imagenesmensajes/');
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

    public function salvarImgAyudaTres($rec)
    {

        $db_name = $this->db.".resolverdudaniveldos";
   
        DB::beginTransaction();
        try {
            DB::connection($this->cur_connect)->update("UPDATE ".$db_name." 
                    SET nombreimagen3 = '".$rec-> nombreimagen1."'
                    WHERE id = '".$rec->id."'");

                    //Imagen base 64 se pasa a un arreglo
                    $nombrefoto[1] = $rec->nombreimagen1;
                    $foto[1] = $rec->imagen1;

                    for ($i = 1; $i <= $rec->numerodeimagenes; $i++) {
                        $this->GuardarIMG($foto[$i] ,$nombrefoto[$i],'imagenesmensajes/');
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

    //Create Certificate Employee
    public function salvarImgAyudaPDF($rec)
    {

        $db_name = $this->db.".resolverdudaniveldos";
   
        DB::beginTransaction();
        try {
            DB::connection($this->cur_connect)->update("UPDATE ".$db_name." 
                    SET linkpdf = '".$rec-> nombreimagen1."'
                    WHERE id = '".$rec->id."'");

                    //Imagen base 64 se pasa a un arreglo
                    $nombrefoto[1] = $rec->nombreimagen1;
                    $foto[1] = $rec->imagen1;

                    for ($i = 1; $i <= $rec->numerodeimagenes; $i++) {
                        $response = FunctionsCustoms::UploadPDFName($foto[$i],$nombrefoto[1],'imagenesmensajes/');
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

    public function actualizarLinkVideo($rec)
    {
        //echo json_encode($rec->id);
        //exit;
        $db_name = $this->db.".resolverdudaniveldos";
   
        DB::beginTransaction();
        try {
            DB::connection($this->cur_connect)->update("UPDATE ".$db_name." 
                            SET linkvideo = '".$rec-> linkvideo."'
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

    public function salvarImgAyudaDosPDF($rec)
    {

        $db_name = $this->db.".resolverdudaniveldos";
   
        DB::beginTransaction();
        try {
            DB::connection($this->cur_connect)->update("UPDATE ".$db_name." 
                    SET nombreimagen2 = '".$rec-> nombreimagen1."'
                    WHERE id = '".$rec->id."'");

                    //Imagen base 64 se pasa a un arreglo
                    $nombrefoto[1] = $rec->nombreimagen1;
                    $foto[1] = $rec->imagen1;

                    for ($i = 1; $i <= $rec->numerodeimagenes; $i++) {
                        $this->GuardarIMG($foto[$i] ,$nombrefoto[$i],'imagenesmensajes/');
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

    public function salvarImgAyudaTresPDF($rec)
    {

        $db_name = $this->db.".resolverdudaniveldos";
   
        DB::beginTransaction();
        try {
            DB::connection($this->cur_connect)->update("UPDATE ".$db_name." 
                    SET nombreimagen3 = '".$rec-> nombreimagen1."'
                    WHERE id = '".$rec->id."'");

                    //Imagen base 64 se pasa a un arreglo
                    $nombrefoto[1] = $rec->nombreimagen1;
                    $foto[1] = $rec->imagen1;

                    for ($i = 1; $i <= $rec->numerodeimagenes; $i++) {
                        $this->GuardarIMG($foto[$i] ,$nombrefoto[$i],'imagenesmensajes/');
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

    //Crear marca vehículo
    public function crearMarcaVeh($rec)
    {
        DB::beginTransaction();
        try {
                    $db_name = $this->db.".marcas";
                    $crearmarcas = new ModelGlobal();
                    $crearmarcas->setConnection($this->cur_connect);
                    $crearmarcas->setTable($db_name);

                    $crearmarcas->text = $rec->text;
                    $crearmarcas->tipovehiculo = $rec->tipovehiculo;
                    $crearmarcas->carroceria = $rec->carroceria;
                    $crearmarcas->estado = $rec->estado;
                    $crearmarcas->url = $rec->url;
                    $crearmarcas->fechacreacion = $date = date('Y-m-d H:i:s');
                   
                    $crearmarcas->save();

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
            'message' => 'CREAR MARCA VEHCIULO',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    //Crear marca vehículo
    public function crearModeloVeh($rec)
    {
        DB::beginTransaction();
        try {
                    $db_name = $this->db.".modelos";
                    $crearmodelos = new ModelGlobal();
                    $crearmodelos->setConnection($this->cur_connect);
                    $crearmodelos->setTable($db_name);

                    $crearmodelos->modelo = $rec->modelo;
                    $crearmodelos->tipovehiculo = $rec->tipovehiculo;
                    $crearmodelos->carroceria = $rec->carroceria;
                    $crearmodelos->estado = $rec->estado;
                    $crearmodelos->marca = $rec->marca;
                    $crearmodelos->fechacreacion = $date = date('Y-m-d H:i:s');
                   
                    $crearmodelos->save();

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
            'message' => 'CREAR MARCA VEHCIULO',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    //Crear marca vehículo
    public function crearCilindrajeVeh($rec)
    {
        DB::beginTransaction();
        try {
                    $db_name = $this->db.".versionmotor";
                    $crearcilindraje = new ModelGlobal();
                    $crearcilindraje->setConnection($this->cur_connect);
                    $crearcilindraje->setTable($db_name);

                    $crearcilindraje->cilindraje = $rec->cilindraje ;
                    $crearcilindraje->tipovehiculo = $rec->tipovehiculo;
                    $crearcilindraje->carroceria = $rec->carroceria;
                    $crearcilindraje->estado = $rec->estado;
                    $crearcilindraje->marca = $rec->marca;
                    $crearcilindraje->modelo = $rec->modelo;
                    $crearcilindraje->fechacreacion = $date = date('Y-m-d H:i:s');
                   
                    $crearcilindraje->save();

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
            'message' => 'CREAR CILINDRAJE VEHCIULO',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    // Listar Site Inventory Machine
    public function listInvoice($rec)
    {
        //echo json_encode($rec->idinterno);
        //exit;
        DB::beginTransaction();
        try {
            $db_name = "mercadorepuesto_sys";
                
        $listinvoice = DB::connection($this->cur_connect)->select(
                                                            "select t0.*, t1.names, t1.surnames, t1.businessname 
                                                            from ".$db_name.'.invoice'." t0
                                                            JOIN ".$db_name.'.clients'." t1 ON t0.idclient = t1.id
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
            'listinvoice' => $listinvoice,
            'message' => 'LIST INVOICE OK',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    //Actualizar Site Inventory Machine
    public function updateInvoice($rec)
    {
        //echo json_encode($rec->id);
        //exit;
        $db_name = $this->db.".invoice";

        DB::beginTransaction();
        try {

            DB::connection($this->cur_connect)->update("UPDATE ".$db_name." 
                SET status = '".$rec-> status."',
                    updatedate = '".$date = date('Y-m-d H:i:s')."'
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
            'message' => 'UPDATED CSR OK'
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    //Delete CSR
    public function deleteInvoice($rec)
    {
        $db_name = $this->db.".invoice";

        DB::beginTransaction();
        try {

            DB::connection($this->cur_connect)->delete("DELETE FROM ".$db_name."
            WHERE invoice = ".$rec->invoice);

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

    public function actualizarMensajesAyuda($rec)
    {
        //echo json_encode($rec->id);
        //exit;
        $db_name = $this->db.".resolverdudaniveldos";
   
        DB::beginTransaction();
        try {
            DB::connection($this->cur_connect)->update("UPDATE ".$db_name." 
                            SET nombreniveldos = '".$rec-> nombreniveldos."',
                                descripcionniveldos = '".$rec-> descripcionniveldos."',
                                descripcionniveltres = '".$rec-> descripcionniveltres."',
                                descripcionnivelcuatro = '".$rec-> descripcionnivelcuatro."'
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

    //Actualizar dirección del usuario
    public function activeToken($rec)
    {
        //echo json_encode($rec->id);
        //exit;
        $db_name = $this->db.".users";

        DB::beginTransaction();
        try {

            DB::connection($this->cur_connect)->update("UPDATE ".$db_name." 
                SET activo = '".$rec->estado."'
                WHERE uid = '".$rec->id."'");

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
                    $subirImagenes->nombredocumento4 = $rec->nombredcto3;
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
        $db_name = "mercadorepuesto_sys";
    
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
        $db_name = "mercadorepuesto_sys";
    
        $leerimageneslatint = DB::connection($this->cur_connect)->select(
                                              "select t0.*
                                               from ".$db_name.'.imageneslotint'." 
                                               t0 WHERE codigo = '". $rec->codigo."'"); 

        echo json_encode($leerimageneslatint);
    }

    //Crear vehiculos temporales asociados a productos
    public function createTemporaryProductVehicles($rec)
    {

        DB::beginTransaction();
        try {
                    $db_name = $this->db.".temporalvehiculosproducto";
                    $vehiculosTemporal = new ModelGlobal();
                    $vehiculosTemporal->setConnection($this->cur_connect);
                    $vehiculosTemporal->setTable($db_name);

                    $vehiculosTemporal->idtipoproducto = $rec->idtipoproducto;
                    $vehiculosTemporal->tipovehiculo = $rec->tipovehiculo;
                    $vehiculosTemporal->carroceria = $rec->carroceria;
                    $vehiculosTemporal->marca = $rec->marca;
                    $vehiculosTemporal->anno = $rec->anno;
                    $vehiculosTemporal->modelo = $rec->modelo;
                    $vehiculosTemporal->cilindraje = $rec->cilindraje;
                    $vehiculosTemporal->transmision = $rec->transmision;
                    $vehiculosTemporal->combustible = $rec->combustible;
                    $vehiculosTemporal->traccion = $rec->traccion;
                    $vehiculosTemporal->selecttipo = $rec->selecttipo;
                    $vehiculosTemporal->selectcarroceria = $rec->selectcarroceria;
                    $vehiculosTemporal->selectmarca = $rec->selectmarca;
                    $vehiculosTemporal->selectanno = $rec->selectanno;
                    $vehiculosTemporal->selectmodelo = $rec->selectmodelo;
                    $vehiculosTemporal->selectcilindraje = $rec->selectcilindraje;
                    $vehiculosTemporal->selecttransmision = $rec->selecttransmision;
                    $vehiculosTemporal->selectcombustible = $rec->selectcombustible;
                    $vehiculosTemporal->selecttraccion = $rec->selecttraccion;
                    $vehiculosTemporal->comparar = $rec->comparar;
                    $vehiculosTemporal->fecha = $date = date('Y-m-d H:i:s');
                    $vehiculosTemporal->estado = $rec->estado;
                    
                    $vehiculosTemporal->save();

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

    //lee vehiculos temporales asignados al producto
    public function selectTemporaryProductVehicles($rec)
    {
        //echo json_encode($rec);
        //exit;      
        $db_name = "mercadorepuesto_sys";
    
        $leevehiculostemporal = DB::connection($this->cur_connect)->select(
                                              "select t0.*
                                               from ".$db_name.'.temporalvehiculosproducto'." 
                                               t0 WHERE idtipoproducto = '". $rec->codigo."'
                                               ORDER BY t0.id ASC"); 

        echo json_encode($leevehiculostemporal);
    }

    //Actualiza pedido con la cedula obtenida de BE
    public function actualizaTemporaryProductVehicles($rec)
    {
        //echo json_encode($rec->id);
        //exit;
        $db_name = $this->db.".temporalvehiculosproducto";
 
        DB::beginTransaction();
        try {
 
            DB::connection($this->cur_connect)->update("UPDATE ".$db_name." 
                SET tipovehiculo = '".$rec-> tipovehiculo."',
                    carroceria = '".$rec-> carroceria."',
                    marca = '".$rec-> marca."',
                    anno = '".$rec-> anno."',
                    modelo = '".$rec-> modelo."',
                    cilindraje = '".$rec-> cilindraje."',
                    transmision = '".$rec-> transmision."',
                    combustible = '".$rec-> combustible."',
                    traccion = '".$rec-> traccion."',
                    selecttipo = '".$rec-> selecttipo."',
                    selectcarroceria = '".$rec-> selectcarroceria."',
                    selectmarca = '".$rec-> selectmarca."',
                    selectanno = '".$rec-> selectanno."',
                    selectmodelo = '".$rec-> selectmodelo."',
                    selectcilindraje = '".$rec-> selectcilindraje."',
                    selecttransmision = '".$rec-> selecttransmision."',
                    selectcombustible = '".$rec-> selectcombustible."',
                    selecttraccion = '".$rec-> selecttraccion."',
                    estado = '".$rec-> estado."',
                    comparar = '".$rec-> comparar."'
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
    public function borrarTemporaryProductVehicles($rec)
    {
         $db_name = $this->db.".temporalvehiculosproducto";
 
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

    //Crear historico vegiculos buscador especial
    public function createHistoryVehSearchSpecial($rec)
    {
        DB::beginTransaction();
        try {
                    $db_name = $this->db.".historyvehspecialsearch";
                    $historyvehsearchspecial = new ModelGlobal();
                    $historyvehsearchspecial->setConnection($this->cur_connect);
                    $historyvehsearchspecial->setTable($db_name);

                    $historyvehsearchspecial->idtipoproducto = $rec->idtipoproducto;
                    $historyvehsearchspecial->tipovehiculo = $rec->tipovehiculo;
                    $historyvehsearchspecial->carroceria = $rec->carroceria;
                    $historyvehsearchspecial->marca = $rec->marca;
                    $historyvehsearchspecial->anno = $rec->anno;
                    $historyvehsearchspecial->modelo = $rec->modelo;
                    $historyvehsearchspecial->cilindraje = $rec->cilindraje;
                    $historyvehsearchspecial->transmision = $rec->transmision;
                    $historyvehsearchspecial->combustible = $rec->combustible;
                    $historyvehsearchspecial->traccion = $rec->traccion;
                    $historyvehsearchspecial->selecttipo = $rec->selecttipo;
                    $historyvehsearchspecial->selectcarroceria = $rec->selectcarroceria;
                    $historyvehsearchspecial->selectmarca = $rec->selectmarca;
                    $historyvehsearchspecial->selectanno = $rec->selectanno;
                    $historyvehsearchspecial->selectmodelo = $rec->selectmodelo;
                    $historyvehsearchspecial->selectcilindraje = $rec->selectcilindraje;
                    $historyvehsearchspecial->selecttransmision = $rec->selecttransmision;
                    $historyvehsearchspecial->selectcombustible = $rec->selectcombustible;
                    $historyvehsearchspecial->selecttraccion = $rec->selecttraccion;
                    $historyvehsearchspecial->usuario = $rec->usuario;
                    $historyvehsearchspecial->fecha = $date = date('Y-m-d H:i:s');
                    $historyvehsearchspecial->estado = $rec->estado;

                    $historyvehsearchspecial->idvehiculo = $rec->idvehiculo;
                    $historyvehsearchspecial->idcarrorecia = $rec->idcarrorecia;
                    $historyvehsearchspecial->idmarca = $rec->idmarca;
                    $historyvehsearchspecial->codigoano = $rec->codigoano;
                    $historyvehsearchspecial->codigomodelo = $rec->codigomodelo;
                    $historyvehsearchspecial->codigocilindraje = $rec->codigocilindraje;
                    $historyvehsearchspecial->codigocombustible = $rec->codigocombustible;
                    $historyvehsearchspecial->codigotransmision = $rec->codigotransmision;
                    $historyvehsearchspecial->codigotraccion = $rec->codigotraccion;
                    $historyvehsearchspecial->nombretipovehiculo = $rec->nombretipovehiculo;
                    $historyvehsearchspecial->nombrecarroceria = $rec->nombrecarroceria;
                    $historyvehsearchspecial->nombremarca = $rec->nombremarca;
                    $historyvehsearchspecial->nombreanno = $rec->nombreanno;
                    $historyvehsearchspecial->nombremodelo = $rec->nombremodelo;
                    $historyvehsearchspecial->nombrecilindraje = $rec->nombrecilindraje;
                    $historyvehsearchspecial->nombretipocombustible = $rec->nombretipocombustible;
                    $historyvehsearchspecial->nombretransmision = $rec->nombretransmision;
                    $historyvehsearchspecial->nombretraccion = $rec->nombretraccion;
                    $historyvehsearchspecial->marcasseleccionadas = $rec->marcasseleccionadas;
                    $historyvehsearchspecial->annosseleccionado = $rec->annosseleccionado;
                    $historyvehsearchspecial->modelosseleccionados = $rec->modelosseleccionados;
                    $historyvehsearchspecial->cilindrajesseleccionados = $rec->cilindrajesseleccionados;
                    $historyvehsearchspecial->combustiblesseleccionados = $rec->combustiblesseleccionados;
                    $historyvehsearchspecial->transmisionesseleccionadas = $rec->transmisionesseleccionadas;
                    $historyvehsearchspecial->traccionesseleccionadas = $rec->traccionesseleccionadas;
                    
                    $historyvehsearchspecial->save();

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

    //lee vehiculos temporales asignados al producto
    public function selectHistoryVehSearchSpecial($rec)
    {
        //echo json_encode($rec);
        DB::beginTransaction();
        try {
        $db_name = "mercadorepuesto_sys";
                
        $listhistoryvehsearchspecial = DB::connection($this->cur_connect)->select(
                                                "select t0.* 
                                                from ".$db_name.'.historyvehspecialsearch'." t0 
                                                WHERE usuario = '". $rec->usuario."'
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
            'listhistoryvehsearchspecial' => $listhistoryvehsearchspecial,
            'message' => 'REGISTRO EXITOSO',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    //Actualiza pedido con la cedula obtenida de BE
    public function actualizaHistoryVehSearchSpecial($rec)
    {
        //echo json_encode($rec->id);
        //exit;
        $db_name = $this->db.".historyvehspecialsearch";
 
        DB::beginTransaction();
        try {
 
            DB::connection($this->cur_connect)->update("UPDATE ".$db_name." 
                SET tipovehiculo = '".$rec-> tipovehiculo."',
                    carroceria = '".$rec-> carroceria."',
                    marca = '".$rec-> marca."',
                    anno = '".$rec-> anno."',
                    modelo = '".$rec-> modelo."',
                    cilindraje = '".$rec-> cilindraje."',
                    transmision = '".$rec-> transmision."',
                    combustible = '".$rec-> combustible."',
                    traccion = '".$rec-> traccion."',
                    selecttipo = '".$rec-> selecttipo."',
                    selectcarroceria = '".$rec-> selectcarroceria."',
                    selectmarca = '".$rec-> selectmarca."',
                    selectanno = '".$rec-> selectanno."',
                    selectmodelo = '".$rec-> selectmodelo."',
                    selectcilindraje = '".$rec-> selectcilindraje."',
                    selecttransmision = '".$rec-> selecttransmision."',
                    selectcombustible = '".$rec-> selectcombustible."',
                    selecttraccion = '".$rec-> selecttraccion."',
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
             'message' => 'PROCESO EXITOSO'
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    //Actualiaza historial vehiculos buscador especial
    public function borrarHistoryVehSearchSpecial($rec)
    {
         $db_name = $this->db.".historyvehspecialsearch";
 
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



//Grabar items pendientes por facturar
public function grabarPendienteFacturar($rec)
{
    DB::beginTransaction();
    try {
                $db_name = $this->db.".pendienteporfacturar";
                $grabardireccionusuario = new ModelGlobal();
                $grabardireccionusuario->setConnection($this->cur_connect);
                $grabardireccionusuario->setTable($db_name);

                $grabardireccionusuario->tipo = $rec->tipo;
                $grabardireccionusuario->idproducto = $rec->idproducto;
                $grabardireccionusuario->compatible = $rec->compatible;
                $grabardireccionusuario->numerodeaprobacion = $rec->numerodeaprobacion;
                $grabardireccionusuario->idtransaccionpago = $rec->idtransaccionpago;
                $grabardireccionusuario->uidcomprador = $rec->uidcomprador;
                $grabardireccionusuario->uidvendedor = $rec->uidvendedor;
                $grabardireccionusuario->fechacompra = $rec->fechacompra;
                $grabardireccionusuario->fechaentrega = $rec->fechaentrega;
                $grabardireccionusuario->fechacreacion = $date = date('Y-m-d H:i:s');
                $grabardireccionusuario->fechadevencimiento = $rec->fechavence; 
                $grabardireccionusuario->cantidad = $rec->cantidad;
                $grabardireccionusuario->preciodeventa = $rec->preciodeventa;
                $grabardireccionusuario->precioenvio = $rec->precioenvio;
                $grabardireccionusuario->retencion = $rec->retencion;
                $grabardireccionusuario->impuestos = $rec->impuestos;
                $grabardireccionusuario->estado = $rec->estado;

                //$grabardireccionusuario->fechacreacion = $date = date('Y-m-d H:i:s');

                $grabardireccionusuario->save();

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

public function listarPendienteFacturar($rec)
{
    DB::beginTransaction();
    try {
    $db_name = "mercadorepuesto_sys";
            
    $listarpendienteporfacturar = DB::connection($this->cur_connect)->select(
                                            "select t0.*, t1.titulonombre, t2.nombre as nombreestado,
                                            TRUNCATE(((DATEDIFF(NOW(), t0.fechacreacion ))),1) AS tiempoactualiza,
                                            t3.descripcion as conceptofacturacion
                                            from ".$db_name.'.pendienteporfacturar'." t0 
                                            JOIN ".$db_name.'.productos'." t1 ON t0.idproducto = t1.id
                                            JOIN ".$db_name.'.estados'." t2 ON t0.estado = t2.tipodeestado
                                            JOIN ".$db_name.'.tipopendientefacturar'." t3 ON t0.tipo = t3.id
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
        'listarpendienteporfacturar' => $listarpendienteporfacturar,
        'message' => 'REGISTRO EXITOSO',
    );
    $rec->headers->set('Accept', 'application/json');
    echo json_encode($response);
    exit;
}


//Actualizar dirección del usuario
public function actualizaPendienteFacturar($rec)
{
    //echo json_encode($rec->id);
    //exit;
    $db_name = $this->db.".pendienteporfacturar";

    DB::beginTransaction();
    try {

          DB::connection($this->cur_connect)->update("UPDATE ".$db_name." 
              SET estado = '".$rec->estado."'
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

//Eliminar las direcciones del usuario
public function deletePendienteFacturar($rec)
{
     $db_name = $this->db.".direccionesusuarios";

     DB::beginTransaction();
     try {

        DB::connection($this->cur_connect)->delete("DELETE FROM ".$db_name." 
        WHERE usuario = ".$rec->usuario);

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

    //Crear vehículos nuevos
    public function crearSolicitudNvoVeh($rec)
    {
        DB::beginTransaction();
        try {
                    $db_name = $this->db.".solicitudnuevosvehiculos";
                    $crearsolicitudnvoveh = new ModelGlobal();
                    $crearsolicitudnvoveh->setConnection($this->cur_connect);
                    $crearsolicitudnvoveh->setTable($db_name);

                    $crearsolicitudnvoveh->uidusuario = $rec->uidusuario;
                    $crearsolicitudnvoveh->tipovehiculo = $rec->tipovehiculo;
                    $crearsolicitudnvoveh->carroceria = $rec->carroceria;
                    $crearsolicitudnvoveh->marca = $rec->marca;
                    $crearsolicitudnvoveh->anno = $rec->anno;
                    $crearsolicitudnvoveh->modelo = $rec->modelo;
                    $crearsolicitudnvoveh->cilindraje = $rec->cilindraje;
                    $crearsolicitudnvoveh->transmision = $rec->transmision;
                    $crearsolicitudnvoveh->combustible = $rec->combustible;
                    $crearsolicitudnvoveh->traccion = $rec->traccion;
                    $crearsolicitudnvoveh->selecttipo = $rec->selecttipo;
                    $crearsolicitudnvoveh->selectcarroceria = $rec->selectcarroceria;
                    $crearsolicitudnvoveh->selectmarca = $rec->selectmarca;
                    $crearsolicitudnvoveh->selectanno = $rec->selectanno;
                    $crearsolicitudnvoveh->selectmodelo = $rec->selectmodelo;
                    $crearsolicitudnvoveh->selectcilindraje = $rec->selectcilindraje;
                    $crearsolicitudnvoveh->selecttransmision = $rec->selecttransmision;
                    $crearsolicitudnvoveh->selectcombustible = $rec->selectcombustible;
                    $crearsolicitudnvoveh->selecttraccion = $rec->selecttraccion;
                    $crearsolicitudnvoveh->estado = $rec->estado;
                    $crearsolicitudnvoveh->fechacreacion = $date = date('Y-m-d H:i:s');
                    $crearsolicitudnvoveh->fechaactualiza = $date = date('Y-m-d H:i:s');
                
                    $crearsolicitudnvoveh->save();

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
            'message' => 'REGISTRO SOLICITUD NVO VEHICULO',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    // Listar Solicitud nuevo vehículo
    public function listarSolicitudNvoVeh($rec)
    {
        //echo json_encode($rec->idinterno);
        //exit;
        DB::beginTransaction();
        try {
            $db_name = "mercadorepuesto_sys";
                
        $listarsolicitudnvoveh = DB::connection($this->cur_connect)->select(
                                                            "select t0.*,
                                                            TRUNCATE(((DATEDIFF(NOW(), t0.fechacreacion))),1) AS tiemposolicitud,
                                                            TRUNCATE(((DATEDIFF(NOW(), t0.fechaactualiza))),1) AS tiempoactualiza,
                                                            t1.nombre as nombreestado, t2.email
                                                            from ".$db_name.'.solicitudnuevosvehiculos'." t0
                                                            JOIN ".$db_name.'.estados'." t1 ON t0.estado = t1.tipodeestado
                                                            JOIN ".$db_name.'.users'." t2 ON t0.uidusuario = t2.uid
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
            'listarsolicitudnvoveh' => $listarsolicitudnvoveh,
            'message' => 'Listar Solicitud Nuevo Vehiculo',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    // Listar ID Solicitud nuevo vehículo
    public function listarIDSolicitudNvoVeh($rec)
    {
        //echo json_encode($rec->idinterno);
        //exit;
        DB::beginTransaction();
        try {
            $db_name = "mercadorepuesto_sys";
                
        $listarsolicitudnvoveh = DB::connection($this->cur_connect)->select(
                                                            "select t0.*,
                                                            t1.nombre as nombreestado
                                                            from ".$db_name.'.solicitudnuevosvehiculos'." t0
                                                            JOIN ".$db_name.'.estados'." t1 ON t0.estado = t1.tipodeestado
                                                            WHERE t0.id = '". $rec->idsolicitud."'
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
            'listarsolicitudnvoveh' => $listarsolicitudnvoveh,
            'message' => 'Listar Solicitud Nuevo Vehiculo',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }


    //Actualizar Site Inventory Machine
    public function actualizarSolicitudNvoVeh($rec)
    {
        //echo json_encode($rec->id);
        //exit;
        $db_name = $this->db.".solicitudnuevosvehiculos";

        DB::beginTransaction();
        try {

            DB::connection($this->cur_connect)->update("UPDATE ".$db_name." 
                SET estado = '".$rec-> estado."',
                    fechaactualiza = '".$date = date('Y-m-d H:i:s')."'
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
            'message' => 'UPDATED SOLICITUD OK'
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    //Delete CSR
    public function deleteSolicitudNvoVeh($rec)
    {
        $db_name = $this->db.".solicitudnuevosvehiculos";

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

    //Crear productos SIIGO
    public function crearPrdSiigo($rec)
    {

        DB::beginTransaction();
        try {
                    $db_name = $this->db.".productossiigo";
                    $crearprdsiigo = new ModelGlobal();
                    $crearprdsiigo->setConnection($this->cur_connect);
                    $crearprdsiigo->setTable($db_name);

                    $crearprdsiigo->code = $rec->code;
                    $crearprdsiigo->idproducto = $rec->idproducto;
                    $crearprdsiigo->descripcion = $rec->descripcion;
                    $crearprdsiigo->nombre = $rec->nombre;
                    $crearprdsiigo->referencia = $rec->referencia;
                    $crearprdsiigo->fechacreacion = $date = date('Y-m-d H:i:s');
                    
                    $crearprdsiigo->save();

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
            'message' => 'REGISTER Productos Siigo',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    //Listar Productos Siigo
    public function listarPrdSiigo($rec)
    {
        //echo json_encode($rec->idinterno);
        //exit;
        DB::beginTransaction();
        try {
            $db_name = "mercadorepuesto_sys";
                
        $listarprdsiigo = DB::connection($this->cur_connect)->select(
                                                        "select t0.*
                                                        from ".$db_name.'.productossiigo'." t0
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
            'listarprdsiigo' => $listarprdsiigo,
            'message' => 'LIST Productos Siigo',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    //Listar Productos Siigo
    public function listarUnPrdSiigo($rec)
    {
        //echo json_encode($rec->idinterno);
        //exit;
        DB::beginTransaction();
        try {
            $db_name = "mercadorepuesto_sys";
                
        $listarprdsiigo = DB::connection($this->cur_connect)->select(
                                                        "select t0.*
                                                        from ".$db_name.'.productossiigo'." t0
                                                        WHERE t0.code = '".$rec->idcode."'
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
            'listarprdsiigo' => $listarprdsiigo,
            'message' => 'LIST Productos Siigo',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    //Actualizar Concept Empleado
    public function actualizarPrdSiigo($rec)
    {
        //echo json_encode($rec->id);
        //exit;
        $db_name = $this->db.".productossiigo";

        DB::beginTransaction();
        try {

            DB::connection($this->cur_connect)->update("UPDATE ".$db_name." 
                SET descripcion = '".$rec-> descripcion."',
                    nombre = '".$rec-> nombre."',
                    referencia = '".$rec-> referencia."'
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
            'message' => 'UPDATED PRODUCTOS SIIGO OK'
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    //Delete Concept Empleado
    public function borrarPrdSiigo($rec)
    {
        $db_name = $this->db.".productossiigo";

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


    //Crear vehiculos asociados a productos
    public function createProductVehicles($rec)
    {
        DB::beginTransaction();
        try {
                    $db_name = $this->db.".vehiculosproducto";
                    $vehiculosProducto = new ModelGlobal();
                    $vehiculosProducto->setConnection($this->cur_connect);
                    $vehiculosProducto->setTable($db_name);

                    $vehiculosProducto->id=$rec->id;
                    $vehiculosProducto->idproductovehiculo=$rec->idproductovehiculo;
                    $vehiculosProducto->productogenerico=$rec->productogenerico;
                    $vehiculosProducto->tipovehiculo=$rec->tipovehiculo;
                    $vehiculosProducto->carroceria=$rec->carroceria;
                    $vehiculosProducto->marca=$rec->marca;
                    $vehiculosProducto->anno=$rec->anno;
                    $vehiculosProducto->modelo=$rec->modelo;
                    $vehiculosProducto->cilindraje=$rec->cilindraje;
                    $vehiculosProducto->transmision=$rec->transmision;
                    $vehiculosProducto->combustible=$rec->combustible;
                    $vehiculosProducto->traccion=$rec->traccion;
                    $vehiculosProducto->partedelvehiculo=$rec->partedelvehiculo;
                    $vehiculosProducto->posicionproducto=$rec->posicionproducto;
                    $vehiculosProducto->titulonombre=$rec->titulonombre;
                    $vehiculosProducto->marcarepuesto=$rec->marcarepuesto;
                    $vehiculosProducto->condicion=$rec->condicion;
                    $vehiculosProducto->estadoproducto=$rec->estadoproducto;
                    $vehiculosProducto->numerodeunidades=$rec->numerodeunidades;
                    $vehiculosProducto->precio=$rec->precio;
                    $vehiculosProducto->numerodeparte=$rec->numerodeparte;
                    $vehiculosProducto->compatible=$rec->compatible;
                    $vehiculosProducto->descripcionproducto=$rec->descripcionproducto;
                    $vehiculosProducto->vendeporpartes=$rec->vendeporpartes;
                   
                    $vehiculosProducto->save();

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

    public function listarBDPalabras($rec)
    {
        DB::beginTransaction();
        try {
            $db_name = "mercadorepuesto_sys";
                
        $listarpalabras = DB::connection($this->cur_connect)->select(
                                                "select t0.* 
                                                from ".$db_name.'.basepalabras'." t0
                                                ORDER BY tipo ASC");

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
            'listarpalabras' => $listarpalabras,
            'message' => 'REGISTRO EXITOSO',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    public function coincidenciasBDPalabras($rec)
    {
        DB::beginTransaction();
        try {
            $db_name = "mercadorepuesto_sys";
    /*
    "select t0.* from ".$db_name." basepalabras t0 WHERE t0.palabrabase LIKE '%".$rec->palabra."'%'");
    */        
        $listarpalabras = DB::connection($this->cur_connect)->select("
                                                select t0.palabrabase, t0.id as value, t0.palabrabase as label 
                                                from ".$db_name.'.basepalabras'." t0
                                                WHERE  t0.palabrabase LIKE '%".$rec->palabra."%'
                                                ORDER BY tipo ASC");  

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
            'listarpalabras' => $listarpalabras,
            'message' => 'REGISTRO EXITOSO',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    public function listarConectores($rec)
    {
        DB::beginTransaction();
        try {
            $db_name = "mercadorepuesto_sys";
                
        $listarconectores = DB::connection($this->cur_connect)->select(
                                                "select t0.* 
                                                from ".$db_name.'.conectores'." t0"); 

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
            'listarconectores' => $listarconectores,
            'message' => 'REGISTRO EXITOSO',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    public function listarMarcasVehiculos($rec)
    {
        DB::beginTransaction();
        try {
            $db_name = "mercadorepuesto_sys";
                
        $listarmarcasveh = DB::connection($this->cur_connect)->select(
                                                "select t0.text, t0.tipovehiculo, t2.carroceria as nombrecarroceria,
                                                t1.text as nombretipoveh, t3.nombre as nombreestado 
                                                from ".$db_name.'.marcas'." t0
                                                JOIN ".$db_name.'.tiposvehiculos'." t1 ON t0.tipovehiculo = t1.id
                                                JOIN ".$db_name.'.tiposcarrocerias'." t2 ON t0.carroceria = t2.id
                                                JOIN ".$db_name.'.estados'." t3 ON t0.estado = t3.tipodeestado
                                                WHERE t0.tipovehiculo > 0
                                                GROUP BY t0.text, t0.tipovehiculo, nombretipoveh, nombreestado,
                                                         nombrecarroceria
                                                ORDER BY t0.tipovehiculo ASC, t0.text ASC"); 

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
            'listarmarcasveh' => $listarmarcasveh,
            'message' => 'REGISTRO EXITOSO',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    public function marcasTipoCarroceria($rec)
    {
        DB::beginTransaction();
        try {
            $db_name = "mercadorepuesto_sys";
                
        $listarmarcasveh = DB::connection($this->cur_connect)->select(
                                                "select t0.text, t0.tipovehiculo, t2.carroceria as nombrecarroceria,
                                                t1.text as nombretipoveh, t3.nombre as nombreestado 
                                                from ".$db_name.'.marcas'." t0
                                                JOIN ".$db_name.'.tiposvehiculos'." t1 ON t0.tipovehiculo = t1.id
                                                JOIN ".$db_name.'.tiposcarrocerias'." t2 ON t0.carroceria = t2.id
                                                JOIN ".$db_name.'.estados'." t3 ON t0.estado = t3.tipodeestado
                                                WHERE t0.tipovehiculo = '". $rec->tipo."'
                                                  AND t0.carroceria   = '". $rec->carroceria."'
                                                GROUP BY t0.text, t0.tipovehiculo, nombretipoveh, nombreestado,
                                                         nombrecarroceria
                                                ORDER BY t0.tipovehiculo ASC, t0.text ASC"); 

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
            'listarmarcasveh' => $listarmarcasveh,
            'message' => 'REGISTRO EXITOSO',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    public function listarModelosVehiculos($rec)
    {
        DB::beginTransaction();
        try {
            $db_name = "mercadorepuesto_sys";
                
        $listarmodelosveh = DB::connection($this->cur_connect)->select(
                                               "select t0.modelo, t0.tipovehiculo, t2.carroceria as nombrecarroceria,
                                                t1.text as nombretipoveh, t3.nombre as nombreestado,
                                                t4.text as nombremarca 
                                                from ".$db_name.'.modelos'." t0
                                                JOIN ".$db_name.'.tiposvehiculos'." t1 ON t0.tipovehiculo = t1.id
                                                JOIN ".$db_name.'.tiposcarrocerias'." t2 ON t0.carroceria = t2.id
                                                JOIN ".$db_name.'.estados'." t3 ON t0.estado = t3.tipodeestado
                                                JOIN ".$db_name.'.marcas'." t4 ON t0.marca = t4.id
                                                WHERE t0.tipovehiculo = '". $rec->tipo."'
                                                  AND t0.carroceria = '". $rec->carroceria."'
                                                  AND t0.marca = '". $rec->marca."'
                                                GROUP BY t0.modelo, t0.tipovehiculo, nombretipoveh, nombreestado,
                                                         nombrecarroceria, nombremarca 
                                                 ORDER BY t0.tipovehiculo ASC, t0.modelo ASC");

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
            'listarmodelosveh' => $listarmodelosveh,
            'message' => 'REGISTRO EXITOSO',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    public function listarCilindrajesVehiculos($rec)
    {
        DB::beginTransaction();
        try {
            $db_name = "mercadorepuesto_sys";
                
        $listarcilindrajeveh = DB::connection($this->cur_connect)->select(
                                               "select t0.id, t0.cilindraje, 
                                                t0.modelo, t0.tipovehiculo, t2.carroceria as nombrecarroceria,
                                                t1.text as nombretipoveh, t3.nombre as nombreestado,
                                                t4.text as nombremarca, t5.modelo as namemodelo
                                                from ".$db_name.'.versionmotor'." t0
                                                JOIN ".$db_name.'.tiposvehiculos'." t1 ON t0.tipovehiculo = t1.id
                                                JOIN ".$db_name.'.tiposcarrocerias'." t2 ON t0.carroceria = t2.id
                                                JOIN ".$db_name.'.estados'." t3 ON t0.estado = t3.tipodeestado
                                                JOIN ".$db_name.'.marcas'." t4 ON t0.marca = t4.id
                                                 JOIN ".$db_name.'.modelos'." t5 ON t0.modelo = t5.id
                                                WHERE t0.tipovehiculo = '". $rec->tipo."'
                                                  AND t0.carroceria = '". $rec->carroceria."'
                                                  AND t0.marca = '". $rec->marca."'
                                                  AND t0.modelo = '". $rec->modelo."'
                                                GROUP BY t0.modelo, t0.tipovehiculo, nombretipoveh, nombreestado,
                                                     nombrecarroceria, nombremarca, t0.id, t0.cilindraje, namemodelo
                                                ORDER BY t0.tipovehiculo ASC, t0.modelo ASC");

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
            'listarcilindrajeveh' => $listarcilindrajeveh,
            'message' => 'REGISTRO EXITOSO',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    public function getWebHookWompi($rec)
    {

        $mifecha= date('Y-m-d H:i:s');
        $data = json_decode($rec->getContent());
        if(empty($data->data->transaction->id)){
            die();
        }

        $transaction = $data->data->transaction->id;

        //$fechacreada = $data->transaction->created_at;
        //$fechatermina = $data->data->transaction->finalized_at;

        DB::beginTransaction();
        try {
                    $db_name = $this->db.".transactions_wompi";
                    $addwompi = new ModelGlobal();
                    $addwompi->setConnection($this->cur_connect);
                    $addwompi->setTable($db_name);

                    $addwompi->idwompi =  $data->data->transaction->id;
                    $addwompi->created_at =  $date = date('Y-m-d H:i:s');
                    $addwompi->finalized_at =  $date = date('Y-m-d H:i:s');
                    $addwompi->amount_in_cents = $data->data->transaction->amount_in_cents;
                    $addwompi->reference = $data->data->transaction->reference;

                    $addwompi->customer_email = $data->data->transaction->customer_email;
                    $addwompi->currency = $data->data->transaction->currency;
                    $addwompi->payment_method_type = $data->data->transaction->payment_method_type;
                    $addwompi->payment_method = $data->data->transaction->payment_method->payment_description;
                    //$addwompi->ticket_id = $data->data->transaction->payment_method->extra->ticket_id;
                    //$addwompi->return_code = $data->data->transaction->payment_method->extra->return_code;
                    //$addwompi->request_date = $data->data->transaction->payment_method->extra->request_date;
                    //$addwompi->async_payment_url = $data->data->transaction->payment_method->extra->async_payment_url;
                    //$addwompi->traceability_code = $data->data->transaction->payment_method->extra->traceability_code;
                    //$addwompi->transaction_cycle = $data->data->transaction->payment_method->extra->transaction_cycle;
                    //$addwompi->transaction_state = $data->data->transaction->payment_method->extra->transaction_state;
                    //$addwompi->external_identifier = $data->data->transaction->payment_method->extra->external_identifier;
                    //$addwompi->bank_processing_date = $data->data->transaction->payment_method->extra->bank_processing_date;
                    //$addwompi->user_type = $data->data->transaction->payment_method->user_type;
                    $addwompi->user_legal_id = $data->data->transaction->payment_method->user_type;
                    //$addwompi->user_legal_id_type = $data->data->transaction->payment_method->user_legal_id_type;
                    //$addwompi->payment_description = $data->data->transaction->payment_method->payment_description;
                    //$addwompi->financial_institution_code = $data->data->transaction->payment_method->financial_institution_code;
                    $addwompi->status = $data->data->transaction->status;
                 /*
                    $valorpago = 0;
                    if($status == "APPROVED"){
                        $valorpago = ($amount_in_cents/100);
                    } else {
                        $valorpago = 0;
                    }
                    */
                    $addwompi->status_message = $data->data->transaction->payment_method->payment_description;
                    $addwompi->address_line_1 = $data->data->transaction->shipping_address->address_line_1;
                    $addwompi->country = $data->data->transaction->shipping_address->country;
                    $addwompi->phone_number = $data->data->transaction->shipping_address->phone_number;
                    $addwompi->city = $data->data->transaction->shipping_address->city;
                    $addwompi->region = $data->data->transaction->shipping_address->region;
                    //$addwompi->$redirect_url = $data->data->transaction->redirect_url;
                    //$addwompi-> $payment_source_id = $data->data->transaction->payment_source_id;
                    //$addwompi->$payment_link_id = $data->data->transaction->payment_link_id;
                    //$addwompi->legal_id = $data->data->transaction->customer_data->legal_id;
                    $addwompi->full_name = $data->data->transaction->customer_data->full_name;
                    $addwompi->phone_number = $data->data->transaction->customer_data->phone_number;
                    //$addwompi->$sent_at = $data->sent_at;
                    //$addwompi->environment = $data->environment;
                    
                    $addwompi->save();

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

        //exit;
        echo json_encode($response);
        exit;

        //$fechacreada = $data->transaction->created_at;
        //y$fechatermina = $data->data->transaction->finalized_at;

        $id = $data->data->transaction->id;
        $created_at = $date = date('Y-m-d H:i:s'); //date("Y-m-d").$fechacreada;
        $finalized_at = $date = date('Y-m-d H:i:s'); //date("Y-m-d").$fechatermina;
        $amount_in_cents = $data->data->transaction->amount_in_cents;
        $reference = $data->data->transaction->reference;
        $customer_email = $data->data->transaction->customer_email;
        $currency = $data->data->transaction->currency;
        $payment_method_type = $data->data->transaction->payment_method_type;
        $payment_method = $data->data->transaction->payment_method->type;
        $ticket_id = $data->data->transaction->payment_method->extra->ticket_id;
        $return_code = $data->data->transaction->payment_method->extra->return_code;
        $request_date = $data->data->transaction->payment_method->extra->request_date;
        $async_payment_url = $data->data->transaction->payment_method->extra->async_payment_url;
        $traceability_code = $data->data->transaction->payment_method->extra->traceability_code;
        $transaction_cycle = $data->data->transaction->payment_method->extra->transaction_cycle;
        $transaction_state = $data->data->transaction->payment_method->extra->transaction_state;
        $external_identifier = $data->data->transaction->payment_method->extra->external_identifier;
        $bank_processing_date = $data->data->transaction->payment_method->extra->bank_processing_date;
        $user_type = $data->data->transaction->payment_method->user_type;
        $user_legal_id = $data->data->transaction->payment_method->user_legal_id;
        $user_legal_id_type = $data->data->transaction->payment_method->user_legal_id_type;
        $payment_description = $data->data->transaction->payment_method->payment_description;
        $financial_institution_code = $data->data->transaction->payment_method->financial_institution_code;
        $status = $data->data->transaction->status;

        $valorpago = 0;
        if($status == "APPROVED"){
            $valorpago = ($amount_in_cents/100);
        } else {
            $valorpago = 0;
        }

        $status_message = $data->data->transaction->status_message;
        $address_line_1 = $data->data->transaction->shipping_address->address_line_1;
        $country = $data->data->transaction->shipping_address->country;
        $phone_number = $data->data->transaction->shipping_address->phone_number;
        $city = $data->data->transaction->shipping_address->city;
        $region = $data->data->transaction->shipping_address->region;
        $redirect_url = $data->data->transaction->redirect_url;
        $payment_source_id = $data->data->transaction->payment_source_id;
        $payment_link_id = $data->data->transaction->payment_link_id;
        $legal_id = $data->data->transaction->customer_data->legal_id;
        $full_name = $data->data->transaction->customer_data->full_name;
        $phone_number = $data->data->transaction->customer_data->phone_number;
        $sent_at = $data->sent_at;
        $environment = $data->environment;

        // Registro el Json recibido como llego


        //echo json_encode($response);
        //echo json_encode(0);
        //exit;
   
        $sql_webhook = "INSERT INTO `transactions_wompi` (`idwompi`,`reference`,`customer_email`,`currency`,`payment_method_type`,`payment_method`,`ticket_id`,`return_code`,`user_legal_id`,`status`,`status_message`,`address_line_1`,`country`,`city`,`region`,`legal_id`,`full_name`,`phone_number`,`amount_in_cents`,
            `created_at`) VALUES ('".$id."','".$reference."','".$customer_email."','".$currency."','".$payment_method_type."','".$payment_method."','".$ticket_id."','".$return_code."','".$user_legal_id."','".$status."','".$status_message."','".$address_line_1."','".$country."','".$city."','".$region."','".$legal_id."','".$full_name."','".$phone_number."','".$valorpago."',now());";
        DB::connection($this->cur_connect)->insert($sql_webhook);
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
                        "marca"=>
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
                        "marca"=>
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

//Marca Items del pedido sin codigo Siigo
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

//Marca Items del pedido sin codigo Siigo
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
      "brand" => $rec->marca,
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
"marca" => 0,
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
