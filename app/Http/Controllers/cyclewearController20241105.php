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


use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;

use App\Models\MultiVenderClient;
use App\Models\MultiVenderOrderItem;
use App\Models\MultiVenderOrder;
use App\Models\MultiVendeToken;
use App\Models\SiigoProducto;
use App\Models\SiigoStock;

use PDF;

use Illuminate\Support\Facades\DB;

class cyclewearController extends Controller
{
    private $urlSigo;
    private $Partner;
    private $siigo_username;
    private $siigo_access_key;

    public function __construct()
    {
        $this->urlSigo = 'https://api.siigo.com/auth?oauth_consumer_key=lzcH2sPb4FQo1A9wWQKihb14&oauth_signature_method=HMAC-SHA1&oauth_timestamp=1706290114&oauth_nonce=TFKy4oTOP2u&oauth_version=1.0&oauth_signature=KRUX3Tz4VU22oeDVT%2FLOEGlvVZ0%3D';
        $this->Partner = 'sandbox';
        $this->siigo_username = 'sandbox@siigoapi.com';
        $this->siigo_access_key = 'NDllMzI0NmEtNjExZC00NGM3LWE3OTQtMWUyNTNlZWU0ZTM0OkosU2MwLD4xQ08=';

        $this->middleware('api');

        //header('Access-Control-Allow-Origin: *');
        header("Access-Control-Allow-Origin: *");
        //Partner-Id("Cyclewear");

        $this->cur_connect = 'mysql';
        $this->db = 'cyclewear_sys';

        // Datos para consultas de Api de Siigo
        $this->url_siigo_api = "https://api.siigo.com/v1/";
    }


    public function cwrGeneral(Request $request, $accion, $parametro=null)
    {
        switch ($accion) {
            case 1:
                $this->cwrCategorias($request);
                break;
            case 2:
                $this->cwrTiposCliente($request);
                break;
            case 3:
                $this->cwrMainMenu($request);
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
                $this->cwrTipoIdentificacion($request);
                break;
            case 8:
                $this->cwrCondicionProducto($request);
                break;
            case 9:
                $this->cwrListarSexo($request);
                break;
            case 10:
                $this->cwr2($request);
                break;
            case 11:
                $this->cwr3($request);
                break;
            case 12:
                $this->cwr4($request);
                break;
            case 13:
                $this->readUser($request);
                break;
            case 14:
                $this->cwrCreateProduct($request);
                break;
            case 15:
                $this->cwrGetProducts($request, $parametro);
                break;
            case 16:
                $this->cwrTiposProducto($request, $parametro);
                break;
            case 17:
                $this->cwrListarConsecutivos($request, $parametro);
                break;
            case 18:
                $this->cwrCrearConsecutivos($request, $parametro);
                break;
            case 19:
                $this->cwrActualizarConsecutivos($request, $parametro);
                break;
            case 20:
                $this->cwrListarVariantesProducto($request, $parametro);
                break;       
            case 21:
                $this->cwrcrearVarianteProductoDB($request, $parametro);
                break;
            case 22:
                $this->cwrCrearProductoDB($request);
                break;
            case 23:
                $this->cwrListarProductoDB($request);
                break;
            case 24:
                $this->cwrLeeUnProductoDB($request);
                break;
            case 25:
                $this->cwrListarUnaVarianteProducto($request, $parametro);
                break;
            case 26:
                $this->cwrListarResponsableIVA($request, $parametro);
                break;
            case 27:
                $this->cwrListarProductoSIIGO($request, $parametro);
                break;
            case 28:
                $this->ListarUnConsecutivoCategorias($request, $parametro);
                break;
            case 282:
                $this->ListarUnConsecutivoCategoriasDos($request, $parametro);
                break;
            case 283:
                $this->ListarUnConsecutivoCategoriasTres($request, $parametro);
                break;
            case 284:
                $this->ListarUnConsecutivoCategoriasCuatro($request, $parametro);
                break;
            case 285:
                $this->ListarUnConsecutivoCategoriasCinco($request, $parametro);
                break;
            case 29:
                $this->CrearConsecutivosCategorias($request, $parametro);
                break;
            case 30:
                $this->ActualizarConsecutivosCategorias($request, $parametro);
                break;   
            case 31:
                $this->ListarConsecutivosCategorias($request, $parametro);
                break;  
            case 100:
                $this->listarInterlocutores($request);
                break;
            case 101:
                $this->crearCliente($request);
                break;
            case 102:
                $this->cwrleerUnCliente($request);
                break;
            case 110:
                $this->cwrCrearInterlocutor($request);
                break;
            case 111:
                $this->cwrlistarProveedores($request);
                break;
            case 112:
                $this->cwrTiposInterlocutores($request);
                break;
            case 113:
                $this->cwrCrearInterlocutorBE($request);
                break;
            case 114:
                $this->cwrLeerInterlocutor($request);
                break;    
            case 200:
                $this->cwrBikeExchange($request);
                break;
            case 201:
                $this->cwrReadBills($request);
                break;
            case 202:
                $this->cwrReadEnvoice($request);
                break;
            case 203:
                $this->cwrReadAdverts($request);
                break;
            case 204:
                $this->cwrReadAdvertsVariants($request);
                break;
            case 205:
                $this->cwrReadEnvoiceDate($request);
                break;
            case 206:
                $this->cwrCrearPedidosBD($request);
                break;
            case 207:
                $this->cwrCrearItemsPedidosBD($request);                    
                break;
            case 208:
                $this->listarComprobantes($request);                    
                break;
            case 209:
                $this->listarUnPedidoDB($request);   
                break;   
            case 210:
                $this->listarPedidosDB($request);   
                break;
            case 211:
                $this->listarItemsPedidosDB($request);   
                break;
            case 212:
                $this->actualizaCedulaPedidos($request);  
                break;
            case 213:
                $this->actualizaDatosPedidos($request);  
                break;
            case 214:
                $this->actualizaPedidosConsola($request);  
                break;
            case 215:
                $this->actualizaDatosItemsPedido($request);  
                break;
            case 216:
                $this->listarInformacionCombos($request);   
                break;
            case 217:
                $this->listarProductosActualiza($request);   
                break;
            case 709:
                $this->cwrIdentification($request);
                break;
            case 710:
                $this->listaProductosFecha($request);
                break;
            case 711:
                $this->crearProducto($request);
                break;
            case 712:
                $this->consultarProducto($request);
                break;
            case 713:
                $this->actualizarProducto($request);
                break;
            case 714:
                $this->borrarProducto($request);
                break;
            case 715:
                $this->listarProductosSiigo($request);
                break;
            case 716:
                $this->actualizaProductoSiigo($request);
                break;
            case 717:
                $this->sinCodigoSiigo($request);
                break;
            case 718:
                $this->actualizaCodigoPedido($request);
                break;
            case 719:
                $this->actualizaProductoSiigoPru($request);
                break;
            case 729:
                $this->crearFacturas($request);
                break;
            case 730:
                $this->listaFacturas($request);
                break;
            case 731:
                $this->crearFacturasItems($request);
                break;
            case 999:
                $this->cwrDatosEntorno($request);
                break;
            case 800:
                $this->loadInventory($request, $parametro);
                break;
            case 801:
                $this->loadInventoryValidacion($request, $parametro);
                break;
            case 802:
                $this->procesarInventory($request, $parametro);
                break;
            case 803:
                $this->leerInventory($request, $parametro);
                break;
            case 804:
                $this->leerInventoryCustomer($request, $parametro);
                break;
            case 805:
                $this->leerUsuariosBU($request, $parametro);
                break;
            case 806:
                $this->unloadInventory($request, $parametro);
                break;
                
            case '1001':
                return $this->createClientes($request);
                break;
            case '1002':
                return $this->updateClientes($request);
                break;
            case '1003':
                return $this->showClientes($request);
                break;
            case '1004':
                return $this->destroyClientes($request);
                break;
            case '1005':
                return $this->createProducto($request);
                break;
            case '1006':
                return $this->updateProducto($request);
                break;
            case '1007':
                return $this->showProducto($request);
                break;
            case '1008':
                return $this->destroyProducto($request);
                break;
            case '1009':
                return $this->createFacturas($request);
                break;
            case '1010':
                return $this->updateFacturas($request);
                break;
            case '1011':
                return $this->createNotaCredi($request);
                break;
            case '1012':
                return $this->pdfNotaCredi($request);
                break;
            case '1013':
                return $this->pdfFacturas($request);
                break;
            case '1014':
                return $this->sendFacturas($request);
                break;
            case '1015':
                return $this->showFacturas($request);
                break;
            case '1016':
                return $this->showNotaCredi($request);
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
////////////////////////////////////////////////////////////////////////////////////////
// inicio Api MultiVende
////////////////////////////////////////////////////////////////////////////////////////
    public function webhooks(Request $request)
    {
        $datajson = json_decode($request->getContent(), true);

        $tokenRecord = MultivendeToken::first();
        $client_id = $tokenRecord->client_id;
        $token = $tokenRecord->token;       
        $OrderId = $datajson['CheckoutId'];

        if ($datajson['OauthClient']['client_id'] !== $client_id) {
            return response()->json(['error' => 'El client_id no coincide con el registrado.'], 403);
        }
        
        $url = 'https://app.multivende.com/api/checkouts/' . $OrderId;
        $metodo = 'GET';
        $orderData = $this->sendMultiventa($url, $metodo);
        $existingOrder = MultiVenderOrder::where('id', $OrderId)->first();
        
        if ($existingOrder) {
            $this->updateOrden($existingOrder, $orderData);
            return response()->json(['message' => 'Orden Actualizada.'], 200);
        }

        foreach ($orderData['CheckoutItems'] as $product) {
            
            if ($product['ProductVersion']['internalCode']) {
                $code = $product['ProductVersion']['internalCode'];
            } else {
                $code = $product['code'];
            }
            $existingProduct = SiigoProducto::where('code', $code)->first();
            if (!$existingProduct) {
                $product_siigo = $this->createProductoMVsiggo($product);  
            }
        }
        $this->createOrden($existingOrder, $orderData);
        $this->createItems($orderData);
        
        return response()->json(['message' => 'Orden Creada Correctamente.'], 200);
    }
    protected function createOrden($existingOrder, $data)
    {

            // Guardar el cliente
            $clientData = $data['Client'];
            $ClientId = $data['ClientId'];

            switch ($data['origin']) {
                case 'shopify':
                    $payment = $data['CheckoutLink']['externalContent']['transactions'][0]['gateway'];
                        break;
                default:
                    $payment = $data['origin'];
                        break;
            }
            
            //  Guardar los datos de la nueva orden
            $order = MultiVenderOrder::create([
                'id' => $data['_id'],
                'client_id' => $clientData['_id'],
                'orden_number' => $data['CheckoutLink']['externalCustomerOrderNumber'],
                'payment'   => $payment,
                'code' => $data['code'],
                'origin' => $data['origin'],
                'net' => $data['net'],
                'tags' => $data['tags'],
                'status' => $data['status'],
                'verification_status' => $data['verificationStatus'],
                'payment_status' => $data['paymentStatus'],
                'delivery_status' => $data['deliveryStatus'],
                'comment' => $data['comment'],
                'sold_at' => $data['soldAt'],
                'is_multiwarehouse' => $data['isMultiwarehouse'],
                'courier_name' => $data['courierName'],
                'shipping_mode' => $data['shippingMode'],
                'created_at' => $data['createdAt'],
                'updated_at' => $data['updatedAt'],
                'CreatedById' => $data['CreatedById']
            ]);
        
            $client = MultiVenderClient::create([
                'full_name' => $clientData['fullName'],
                'name' => $clientData['name'],
                'last_name' => $clientData['lastName'],
                'document_type' => $data['CheckoutBillingClients']['0']['documentType'],
                'type' => $clientData['type'],
                'identification' => $clientData['taxId'],
                'phoneNumber' => $clientData['phoneNumber'],
                'email' => $clientData['email'],
                'address_1' => $clientData['BillingAddresses']['0']['address_1'],
                'address_2' => $clientData['BillingAddresses']['0']['address_2'],
                'client_id' => $ClientId,
                'merchant_id' => $clientData['MerchantId']
            ]);
                            

        return response()->json(['message' => 'Orden procesada correctamente.'], 200);
    }
    protected function createItems($data)
    {
        // Guardar los CheckoutItems
        foreach ($data['CheckoutItems'] as $checkoutItemData) {
            
            if ($product['ProductVersion']['internalCode']) {
                $code = $product['ProductVersion']['internalCode'];
            } else {
                $code = $product['code'];
            }
            $product = SiigoProducto::where('code', $code)->first();

            MultiVenderOrderItem::create([
                'id' => $checkoutItemData['_id'],
                'id_siigo' => $product->id_siigo,
                'name' => $checkoutItemData['ProductVersion']['Product']['name'],
                'checkout_id' => $checkoutItemData['CheckoutId'],
                'sku' => $code,
                'gross' => $checkoutItemData['gross'],
                'count' => $checkoutItemData['count'],
                'total' => $checkoutItemData['total'],
                'discount' => $checkoutItemData['discount'],
                'total_with_discount' => $checkoutItemData['totalWithDiscount'],
                'payment_by_item' => $checkoutItemData['paymentByItem'],
                'product_version_id' => $checkoutItemData['ProductVersionId'],
                'merchant_id' => $checkoutItemData['MerchantId']
            ]);

            SiigoStock::create([
                'producto_sku' => $checkoutItemData['ProductVersion']['internalCode'],
                'checkout_id' => $checkoutItemData['CheckoutId'],
                'type' => 'Ventas',
                'quantity' => $checkoutItemData['count'],
                'description' => $checkoutItemData['ProductVersion']['Product']['name'],
            ]);


        }
        return response()->json(['message' => 'Orden procesada correctamente.'], 200);
    }
    protected function createProductoMVsiggo($productData)
    {

        $product_id =$productData['ProductVersion']['Product']['_id'];

        $url = 'https://app.multivende.com/api/products/'. $product_id .'?_include_product_picture=false';
        $metodo = 'GET';
        $dataProduct = $this->sendMultiventa($url, $metodo);

        if ($productData['discount']) {
            $price = $productData['discount'];
        } else {
            $price = $productData['gross'];
        }

        if ($productData['ProductVersion']['internalCode']) {
            $code = $productData['ProductVersion']['internalCode'];
        } else {
            $code = $productData['code'];
        }

        // Expresión regular para validar y limpiar el nombre, adaptada a los caracteres permitidos
            $regex = '/[^\w\.\@\-\%\_\;\(\)\#\?\¡\[\]\/\:\{\}\*\+\,\$\sñáéíóúÁÉÍÓÚüÜ\-]+/u';

            // Eliminar caracteres no válidos
            $nameRegex = preg_replace($regex, '', $dataProduct['name']);
            // Limitar la longitud a un máximo de 100 caracteres
            $name = mb_substr($nameRegex, 0, 80);
            $fullname = $code . ' - ' . $name;
            // Eliminar los saltos de línea
            $cleanedDescription = str_replace(["\r", "\n"], ' ', $dataProduct['shortDescription']);

            // Truncar la descripción al límite de caracteres
            $shortDescription = mb_substr($cleanedDescription, 0, 490);

            // Si la longitud original es mayor que el límite, encontrar el último espacio y truncar allí
            if (mb_strlen($cleanedDescription) > 490) {
                $lastSpace = mb_strrpos($shortDescription, ' ');
                if ($lastSpace !== false) {
                    $shortDescription = mb_substr($shortDescription, 0, $lastSpace) . '...';
                } else {
                    $shortDescription .= '...';
                }
            }
            $Description = preg_replace($regex, '', $shortDescription);

            
            
        $data = [
            "code" =>  $code,
            "name" =>   $fullname,
            "account_group" => 121,
            "type" => "Product",
            "stock_control" => false,
            "active" => true,
            "tax_classification" => "Taxed",
            "tax_included" => false,
            "tax_consumption_value" => 0,
            "taxes" => [
                [
                    "id" => 1270
                ]
            ],
            "prices" => [
                [
                    "currency_code" => "COP",
                    "price_list" => [
                        [
                            "position" => 1,
                            "value" => $price
                        ]
                    ]
                ]
            ],
            "unit" => "94",
            "unit_label" => "unidad",
            "reference" => $dataProduct['ProductVersions']['0']['code'],
            "description" => $Description,
            "additional_fields" => [
                "barcode" => $dataProduct['ProductVersions']['0']['code'],
                "brand" => $dataProduct['Brand']['name'],
                "model" => $dataProduct['model']
            ]
        ];

        $url = 'https://api.siigo.com/v1/products';
        $metodo = 'POST';
        $product_siigo =$this->sendMessageData($url, $metodo, $data);
        $product_siigo_array = json_decode($product_siigo, true);
        
            
        SiigoProducto::create([
            'id_siigo' => $product_siigo_array['id'],
            'code' => $product_siigo_array['code'],
            'name' => $product_siigo_array['name'],
            'type' => $product_siigo_array['type'],
            'active' => $product_siigo_array['active'],
            'description' => $product_siigo_array['description'],
            'precio' => $price,
            'referencia' => $dataProduct['internalCode'],
            'stock_control' => $product_siigo_array['stock_control'],
            'available_quantity' => $product_siigo_array['available_quantity'],
            'unit' => $product_siigo_array['unit_label'],
            'barcode' => $dataProduct['internalCode'],
            'brand' => $dataProduct['Brand']['name'],
            'model' => $dataProduct['model'],
        ]);
        
        return  $product_siigo_array;

    }
    protected function updateOrden($existingOrder, $data)
    {
        $clientData = $data['Client'];
        
        switch ($data['origin']) {
            case 'shopify':
                $payment = $data['CheckoutLink']['externalContent']['transactions'][0]['gateway'];
                    break;
            default:
                $payment = $data['origin'];
                    break;
        }

        // Obtener los datos de la orden desde el JSON
        $existingOrder->update([
            'id' => $data['_id'],
            'client_id' => $clientData['_id'],
            'orden_number' => $data['CheckoutLink']['externalCustomerOrderNumber'],
            'payment'   => $payment,
            'code' => $data['code'],
            'origin' => $data['origin'],
            'net' => $data['net'],
            'tags' => $data['tags'],
            'status' => $data['status'],
            'verification_status' => $data['verificationStatus'],
            'payment_status' => $data['paymentStatus'],
            'delivery_status' => $data['deliveryStatus'],
            'comment' => $data['comment'],
            'sold_at' => $data['soldAt'],
            'is_multiwarehouse' => $data['isMultiwarehouse'],
            'courier_name' => $data['courierName'],
            'shipping_mode' => $data['shippingMode'],
            'created_at' => $data['createdAt'],
            'updated_at' => $data['updatedAt'],
            'CreatedById' => $data['CreatedById'],
        ]);
    }
    public function createProducto(Request $request)
    {
            $url = 'https://api.siigo.com/v1/products';
            $metodo = 'POST';
            $data = $request->json()->all();
            return $this->sendMessageData($url, $metodo, $data);
    }
    //Siigo
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
    public function createProducto1(Request $request)
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
            Cache::put('key_siigo', $accessToken, now()->addMinutes(2));
            return $accessToken;
        } else {
            return response()->json(['error' => 'Error en la autenticación con Siigo'], $response->status());
        }
    }
    private function sendMessage($url, $metodo)
    {
        $tokenSiigo = Cache::get('key_siigo');
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
        $tokenSiigo = Cache::get('key_siigo');
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
    private function sendMultiventa($url, $metodo)
    {
        
        $tokenRecord = DB::connection('mysql2')->table('multivende_tokens')->first();
        $client_id = $tokenRecord->client_id;
        $token = $tokenRecord->token;      
        try {
            $response = Http::withHeaders([
                'Content-Type' => 'application/x-www-form-urlencoded',
                'Authorization' => 'Bearer ' . $token,
            ])->timeout(120)->send($metodo, $url);
            if ($response->successful()) {
            return  $response->json();
            } elseif ($response->serverError()) {
                return response()->json(['error' => 'Error en el servidor de Multivende. Intenta nuevamente más tarde.'], 500);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => 'Ocurrió un error al consultar la API de Multivende: ' . $e->getMessage()], 500);
        }
    }


////////////////////////////////////////////////////////////////////////////////////////
// Fin Api MultiVende
////////////////////////////////////////////////////////////////////////////////////////
    // Lee la condición del producto
    public function cwrDatosEntorno($rec)
    {
        $db_name = "cyclewear_sys";
    
        $condicionproducto = DB::connection($this->cur_connect)->select("select t0.id as value, t0.nombrecondicion as label 
                                                                             from ".$db_name.'.condicionproducto'." 
                                                                             t0 WHERE t0.estado = 1 ORDER BY nombrecondicion ASC");
        
        $tiposcliente = DB::connection($this->cur_connect)->select("select t0.*, t0.id as value, t0.nombretipocliente as label
                                                                    from ".$db_name.'.tipocliente'." t0 
                                                                    WHERE t0.estado = 1 ORDER BY tipocliente ASC");

        $listProveedores = DB::connection($this->cur_connect)->select("select t0.id as value, t0.razonsocial as label, t0.* 
                                                                       from ".$db_name.'.interlocutores'." t0
                                                                        WHERE t0.estado = 1 ORDER BY tipotercero ASC");

        $listSexo = DB::connection($this->cur_connect)->select("select t0.id as value, t0.nombresexo as label, t0.* 
                                                                from ".$db_name.'.sexo'." t0
                                                                WHERE t0.estado = 1 ORDER BY nombresexo ASC");

        $tiposinterlocutores = DB::connection($this->cur_connect)->select("select t0.id as value, 
                                                                t0.nombretipotercero as label, t0.* 
                                                                from ".$db_name.'.tipotercero'." t0
                                                                WHERE t0.estado = 1 ORDER BY nombretipotercero ASC");

        $tiposidentificacion = DB::connection($this->cur_connect)->select("select t0.id as value,
                                                                t0.descripcion as label, t0.* 
                                                                from ".$db_name.'.tipoidentificacion'." t0 
                                                                WHERE t0.estado = 1 ORDER BY tipoidentificacion ASC");
                                                                                              
        $ciudades = DB::connection($this->cur_connect)->select("select t0.id as value,
                                                                t0.nombre as label, t0.* 
                                                                from ".$db_name.'.ciudades'." t0 
                                                                ORDER BY nombre ASC");

        $tipoderegimen = DB::connection($this->cur_connect)->select("select t0.id as value, t0.descripcion as label, t0.* 
                                                                from ".$db_name.'.tiporegimen'." t0
                                                                WHERE t0.estado = 1 ORDER BY descripcion ASC");

        $responsabilidadfiscal = DB::connection($this->cur_connect)->select("select t0.id as value,
                                                                t0.descripcion as label, t0.* 
                                                                from ".$db_name.'.responsabilidadfiscal'." t0
                                                                WHERE t0.estado = 1 ORDER BY descripcion ASC");

        $listTiposProductos = DB::connection($this->cur_connect)->select("select t0.codigotipo as value, t0.nombretipoproducto as label, t0.* ,
                                                                                 t1.nombreestado
                                                                from ".$db_name.'.tipodeproducto'." t0
                                                                JOIN ".$db_name.'.estados'." t1 ON t0.estado = t1.id
                                                                WHERE t0.estado = 1 ORDER BY nombretipoproducto ASC");

        $listCategoriasUno = DB::connection($this->cur_connect)->select("select t0.codigocategoriauno as value, t0.nombrecategoriauno as label, t0.*,
                                                                t1.nombreestado, t2.nombretipoproducto
                                                                from ".$db_name.'.categoriauno'." t0
                                                                JOIN ".$db_name.'.estados'." t1 ON t0.estado = t1.id
                                                                JOIN ".$db_name.'.tipodeproducto'." t2 ON t0.tipodeproducto = t2.codigotipo
                                                                WHERE t0.estado = 1 ORDER BY nombrecategoriauno ASC");

        $listCategoriasDos = DB::connection($this->cur_connect)->select("select t0.codigocategoriados as value, t0.nombrecategoriados as label, 
                                                                                t0.*, t1.nombretipoproducto, t2.nombrecategoriauno
                                                                from ".$db_name.'.categoriados'." t0
                                                                JOIN ".$db_name.'.tipodeproducto'." t1 ON t0.tipodeproducto = t1.codigotipo
                                                                JOIN ".$db_name.'.categoriauno'." t2 ON t2.codigocategoriauno = t0.categoriauno
                                                                WHERE t0.estado = 1 ORDER BY t0.nombrecategoriados ASC");

        $listCategoriasTres = DB::connection($this->cur_connect)->select("select t0.codigocategoriatres as value, t0.nombrecategoriatres as label,
                                                                                 t0.*, t2.nombretipoproducto
                                                                from ".$db_name.'.categoriatres'." t0
                                                                JOIN ".$db_name.'.tipodeproducto'." t2 ON t0.tipodeproducto = t2.codigotipo
                                                                WHERE t0.estado = 1 ORDER BY t0.nombrecategoriatres ASC");

        $listCategoriasCuatro = DB::connection($this->cur_connect)->select("select t0.codigocategoriacuatro as value, 
                                                                                   t0.nombrecategoriacuatro as label,
                                                                                   t0.*, t2.nombretipoproducto
                                                                from ".$db_name.'.categoriacuatro'." t0
                                                                JOIN ".$db_name.'.tipodeproducto'." t2 
                                                                                  ON t0.tipodeproducto = t2.codigotipo
                                                                WHERE t0.estado = 1 ORDER BY t0.nombrecategoriacuatro ASC");
        
        $listMarcas = DB::connection($this->cur_connect)->select("select t0.id as value, t0.nombremarca as label, t0.*
                                                                from ".$db_name.'.marcas'." t0 
                                                                WHERE t0.estado = 1 ORDER BY  nombremarca ASC");

        $listColores = DB::connection($this->cur_connect)->select("select t0.id as value, t0.nombrecolor as label, t0.*
                                                                from ".$db_name.'.colores'." t0 
                                                                WHERE t0.estado = 1 ORDER BY  nombrecolor ASC");

        $listSabores = DB::connection($this->cur_connect)->select("select t0.id as value, t0.nombresabor label, t0.* 
                                                                from ".$db_name.'.sabor'." t0 
                                                                WHERE t0.estado = 1 ORDER BY  nombresabor ASC");
        
        $listTallas = DB::connection($this->cur_connect)->select("select t0.id as value, t0.nombretalla as label, t0.* 
                                                                from ".$db_name.'.talla'." t0 
                                                                WHERE t0.estado = 1 ORDER BY  nombretalla ASC");

        $listMarcoenPulgadas = DB::connection($this->cur_connect)->select("select t0.id as value, t0.nombremarcoenpulgadas as label, t0.*
                                                                from ".$db_name.'.marcoenpulgadas'." t0 
                                                                WHERE t0.estado = 1 ORDER BY nombremarcoenpulgadas ASC");
        
        $listTallaBandana = DB::connection($this->cur_connect)->select("select t0.id as value, t0.nombretallabandana as label, t0.*
                                                                from ".$db_name.'.tallabandana'." t0 
                                                                WHERE t0.estado = 1 ORDER BY nombretallabandana ASC");

        $listTallaCentimetros = DB::connection($this->cur_connect)->select("select t0.id as value, t0.nombretallacentimetros as label,  t0.*
                                                                    from ".$db_name.'.tallaencentimetros'." t0 
                                                                    WHERE t0.estado = 1 ORDER BY nombretallacentimetros ASC");

        $listTallaGuantes = DB::connection($this->cur_connect)->select("select t0.id as value, t0.nombreguantes as label, t0.* 
                                                                from ".$db_name.'.tallaguantes'." t0 
                                                                WHERE t0.estado = 1 ORDER BY nombreguantes ASC");

        $listTallaJersey = DB::connection($this->cur_connect)->select("select t0.id as value, t0.nombrejersey as label, t0.*
                                                                  from ".$db_name.'.tallajersey'." t0 
                                                                  WHERE t0.estado = 1 ORDER BY nombrejersey ASC");

        $listTallaMedias = DB::connection($this->cur_connect)->select("select t0.id as value, t0.nombremedias as label, t0.*
                                                                  from ".$db_name.'.tallamedias'." t0 
                                                                  WHERE t0.estado = 1 ORDER BY nombremedias ASC");

        $listTallaPantaloneta = DB::connection($this->cur_connect)->select("select t0.id as value, t0.nombretallapantaloneta as label,  t0.*
                                                                  from ".$db_name.'.tallapantaloneta'." t0 
                                                                  WHERE t0.estado = 1 ORDER BY nombretallapantaloneta ASC");

        $listTamanoAccesorio = DB::connection($this->cur_connect)->select("select t0.id as value, t0.nombretamanoaccesorio as label,  t0.*
                                                                  from ".$db_name.'.tamanoaccesorio'." t0 
                                                                  WHERE t0.estado = 1 ORDER BY nombretamanoaccesorio ASC");
                                                                  
        $listTamanoComponentes = DB::connection($this->cur_connect)->select("select t0.id as value, t0.nombretamanocomponentes as label, t0.*
                                                                  from ".$db_name.'.tamanocomponentes'." t0 
                                                                  WHERE t0.estado = 1 ORDER BY nombretamanocomponentes ASC");

        $listTamanoLlantasyNeumaticos = DB::connection($this->cur_connect)->select("select t0.id as value, t0.nombrellantasyneumaticos as label, t0.*
                                                                  from ".$db_name.'.tamanollantasyneumaticos'." t0 
                                                                  WHERE t0.estado = 1 ORDER BY nombrellantasyneumaticos ASC");

        $listTamanoRuedasyPartes = DB::connection($this->cur_connect)->select("select t0.id as value, t0.nombreruedasypartes as label, t0.* 
                                                                  from ".$db_name.'.tamanoruedasypartes'." t0 
                                                                  WHERE t0.estado = 1 ORDER BY nombreruedasypartes ASC");
        
        $listAcoplamiento = DB::connection($this->cur_connect)->select("select t0.id as value, t0.nombreacoplamiento as label, t0.*
                                                                  from ".$db_name.'.acoplamiento'." t0 
                                                                  WHERE t0.estado = 1 ORDER BY nombreacoplamiento ASC");
        
        $listDiametro = DB::connection($this->cur_connect)->select("select t0.id as value, t0.nombreadiametro as label, t0.* 
                                                                  from ".$db_name.'.diametro'." t0 
                                                                  WHERE t0.estado = 1 ORDER BY nombreadiametro ASC");
        
        $listRosca = DB::connection($this->cur_connect)->select("select t0.id as value, t0.nombrerosca as label, t0.*
                                                                  from ".$db_name.'.rosca'." t0 
                                                                  WHERE t0.estado = 1 ORDER BY  nombrerosca ASC");

        $listLongitud = DB::connection($this->cur_connect)->select("select t0.id as value, t0.nombrelongitud as label, t0.*
                                                                  from ".$db_name.'.longitud'." t0 
                                                                  WHERE t0.estado = 1 ORDER BY nombrelongitud ASC");

        $listAncho = DB::connection($this->cur_connect)->select("select t0.id as value, t0.nombreancho as label, t0.*
                                                                  from ".$db_name.'.ancho'." t0  
                                                                  WHERE t0.estado = 1 ORDER BY nombreancho ASC");

        $listMaterial = DB::connection($this->cur_connect)->select("select t0.id as value, t0.nombrematerial as label, t0.*
                                                                  from ".$db_name.'.material'." t0  
                                                                  WHERE t0.estado = 1 ORDER BY nombrematerial ASC");

        $listBrazodelaBiela = DB::connection($this->cur_connect)->select("select t0.id as value, t0.nombrebrazodelabiela as label, t0.*
                                                                  from ".$db_name.'.brazodelabiela'." t0    
                                                                  WHERE t0.estado = 1 ORDER BY nombrebrazodelabiela ASC");
                                                            
        $listVariablesProducto = DB::connection($this->cur_connect)->select("select t0.id as value, t0.id as label, t0.*,
                                                                  t1.nombretipoproducto, t2.nombrecategoriauno, t3.nombrecategoriados,
                                                                  t4.nombrecategoriatres, t5.nombrecategoriacuatro
                                                                  from ".$db_name.'.variablesproductos'." t0
                                                                  JOIN ".$db_name.'.tipodeproducto'." t1 ON t0.tipoproducto = t1.id
                                                                  JOIN ".$db_name.'.categoriauno'." t2 ON t0.categoriauno = t2.id  
                                                                  JOIN ".$db_name.'.categoriados'." t3 ON t0.categoriados = t3.id
                                                                  JOIN ".$db_name.'.categoriatres'." t4 ON t0.categoriatres = t4.id
                                                                  JOIN ".$db_name.'.categoriacuatro'." t5 ON t0.categoriacuatro = t5.id
                                                                  WHERE t0.estado = 1 ORDER BY id ASC");
           
        $listClientes = DB::connection($this->cur_connect)->select("select t0.id as value, t0.razonsocial as label, t0.* 
                                                            from ".$db_name.'.interlocutores'." t0
                                                            WHERE t0.estado = 1 && t0.tipotercero = 1 ORDER BY tipotercero ASC");
        
        $entorno = array(
            'vgl_condicionproducto' => $condicionproducto,
            'vgl_tiposcliente' => $tiposcliente,
            'vgl_proveedores' => $listProveedores,
            'vgl_sexo' => $listSexo,
            'vgl_tipointerlocutor' => $tiposinterlocutores,
            'vgl_tiposidentificacion' => $tiposidentificacion,
            'vgl_ciudades' => $ciudades,
            'vgl_tipoderegimen' => $tipoderegimen,
            'vgl_responsabilidadfiscal' => $responsabilidadfiscal,
            'vgl_tiposproductos' => $listTiposProductos,
            'vgl_categoriasUno' => $listCategoriasUno,
            'vgl_categoriasDos' => $listCategoriasDos,
            'vgl_categoriasTres' => $listCategoriasTres,
            'vgl_categoriasCuatro' => $listCategoriasCuatro,
            'vgl_colores' => $listColores,
            'vgl_marcas' => $listMarcas,
            'vgl_sabores' => $listSabores,       
            'vgl_tallas' => $listTallas,
            'vgl_marcopulagadas' => $listMarcoenPulgadas,
            'vgl_tallabandana' => $listTallaBandana,
            'vgl_centimetros' => $listTallaCentimetros,
            'vgl_tallaguantes' => $listTallaGuantes,
            'vgl_jersey' => $listTallaJersey,
            'vgl_tallamedias' => $listTallaMedias,
            'vgl_tallapantaloneta' => $listTallaPantaloneta,
            'vgl_tamanoaccesorios' => $listTamanoAccesorio,
            'vgl_tamanocomponentes' => $listTamanoComponentes,
            'vgl_llantasyneumaticos' => $listTamanoLlantasyNeumaticos,
            'vgl_ruedasypartes' => $listTamanoRuedasyPartes,
            'vgl_acoplamiento' => $listAcoplamiento,
            'vgl_diametro' => $listDiametro, 
            'vgl_rosca' => $listRosca,
            'vgl_longitud' => $listLongitud,
            'vgl_ancho' => $listAncho,
            'vgl_material' => $listMaterial ,
            'vgl_brazobiela' => $listBrazodelaBiela,
            'vgl_variablesproducto' => $listVariablesProducto,
            'vgl_clientes' => $listClientes,
        );
    
        $condicionprod = array();
    
        $datoc = [
            'header_supplies' => $condicionproducto
        ];
        $condicionprod[] = $datoc;
    
        echo json_encode($entorno);
    }

     // Lee la condición del producto
    public function cwrIdentification($rec)
    {

        $envoice = $rec->factura; // aqui consultas por la factura o el invoice
        // Es necesario para siempre obtener el ultimo token actualizado
        $curl = curl_init();
        
        curl_setopt_array($curl, array(
          CURLOPT_URL => 'http://45.33.26.241/api/login',
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => '',
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 0,
          CURLOPT_FOLLOWLOCATION => true,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => 'POST',
          CURLOPT_POSTFIELDS =>'{
            "username": "cyclewear",
            "password": "cyclewear123*"
        }',
          CURLOPT_HTTPHEADER => array(
            'Content-Type: application/json'
          ),
        ));
        
        $response = curl_exec($curl);
        
        curl_close($curl);
        $data_token = json_decode($response); // Aqui obtengo el ultimo token actualizado
        
        $curl = curl_init();
         
        curl_setopt_array($curl, array(
           CURLOPT_URL => 'http://45.33.26.241/api/Validations/GetByInvoice/'.$envoice,
           CURLOPT_RETURNTRANSFER => true,
           CURLOPT_ENCODING => '',
           CURLOPT_MAXREDIRS => 10,
           CURLOPT_TIMEOUT => 0,
           CURLOPT_FOLLOWLOCATION => true,
           CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
           CURLOPT_CUSTOMREQUEST => 'GET',
           CURLOPT_HTTPHEADER => array(
             'Authorization: Bearer eyJhbGciOiJodHRwOi8vd3d3LnczLm9yZy8yMDAxLzA0L3htbGRzaWctbW9yZSNobWFjLXNoYTI1NiIsInR5cCI6IkpXVCJ9.eyJodHRwOi8vc2NoZW1hcy54bWxzb2FwLm9yZy93cy8yMDA1LzA1L2lkZW50aXR5L2NsYWltcy9uYW1lIjoiY3ljbGV3ZWFyIiwiaHR0cDovL3NjaGVtYXMubWljcm9zb2Z0LmNvbS93cy8yMDA4LzA2L2lkZW50aXR5L2NsYWltcy9yb2xlIjoiU2VsbGVyIiwiaHR0cDovL3NjaGVtYXMueG1sc29hcC5vcmcvd3MvMjAwNS8wNS9pZGVudGl0eS9jbGFpbXMvbmFtZWlkZW50aWZpZXIiOiJiZDc4OTNhMS0zM2Q1LTQzOWItOGNmNi05ZGFlYTYyMjBlM2MiLCJTZWxsZXIiOiIzODQxIiwiZXhwIjoxNjU3NjUzMzk0LCJpc3MiOiJ3d3cuYnl0ZWxhbmd1YWdlLm5ldCIsImF1ZCI6Ind3dy5ieXRlbGFuZ3VhZ2UubmV0In0.wchbNfSuC2myTi18_qTRPZWQjxI1sfcA-ZJuGPaLEI0'
           ),
           //CURLOPT_HTTPHEADER => array(
           //  'Authorization: Bearer '.$data_token->token
           //),
        ));
         
        $response = curl_exec($curl);
        //echo $response;
        //exit;
        
        curl_close($curl);
        $data = json_decode($response);
        echo $response;
        exit;
        // DATOS FINALES
        //var_dump($data);
        /*
        echo "Name1: ". $name = $data[0]->name;
        echo "LastName 1: ". $lastName = $data[0]->lastName;
        echo "Email 1: ". $email = $data[0]->email;
        echo "DocumentID 1: ". $documentId = $data[0]->document;
        */
        $entorno = array(
            "Name1"=> $data[0]->name,
            "LastName" => $data[0]->lastName,
            "Email" => $data[0]->email,
            "DocumentID" => $data[0]->document
    
        );

        echo json_encode($entorno);
        exit;
        
        // Los otros datos
        //echo "Name 2: ". $name = $data[1]->name;
        //echo "LastName 2: ". $lastName = $data[1]->lastName;
        //echo "Email 2: ". $email = $data[1]->email;
        //echo "DocumentID 2: ". $documentId = $data[1]->document;
    
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
    public function cwrReadBills($rec)
    {
        $curl = curl_init();
        $iniciar =  $rec->pagina;

        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://www.bikeexchange.com.co/api/v2/client/invoices?page%5Bnumber%5D=".$iniciar."page%5Bsize%5D=100",
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
    public function cwrReadEnvoice($rec)
    {
        $curl = curl_init();
        $envoice =  $rec->factura;

        curl_setopt_array($curl, array(
          CURLOPT_URL => "https://www.bikeexchange.com.co/api/v2/client/invoices/".$envoice,
          //CURLOPT_URL => "https://www.bikeexchange.com.co/api/v2/client/invoices/107921",
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
    public function cwrReadEnvoiceDate($rec)
    {
            $curl = curl_init();
            $startdate =  $rec->fecha;

            curl_setopt_array($curl, array(
            CURLOPT_URL => "https://www.bikeexchange.com.co/api/v2/client/invoices?since=".$startdate,
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
    public function cwrReadAdverts($rec)
    {
        $curl = curl_init();
        $iniciar =  $rec->pagina;
    
        curl_setopt_array($curl, array(
          CURLOPT_URL => "https://www.bikeexchange.com.co/api/v2/client/adverts?page%5Bnumber%5D=".$iniciar."page%5Bsize%5D=100",
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

    public function cwrReadAdvertsVariants($rec)
    {
        $curl = curl_init();
        $adverts =  $rec->anuncio;
    
        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://www.bikeexchange.com.co/api/v2/client/adverts/".$adverts."/variants",
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

    //Crear conscutivo en Base de Datos
    public function cwrCrearConsecutivos($rec)
    {

        DB::beginTransaction();
        try {
                    $db_name = $this->db.".consecutivos";
                    $nuevoConsecutivo = new ModelGlobal();
                    $nuevoConsecutivo->setConnection($this->cur_connect);
                    $nuevoConsecutivo->setTable($db_name);

                    $nuevoConsecutivo->prefijo = $rec->prefijo;
                    $nuevoConsecutivo->descripcion = $rec->descripcion;
                    $nuevoConsecutivo->consecutivo = $rec->consecutivo;
                    $nuevoConsecutivo->empresa = $rec->empresa;
                    $nuevoConsecutivo->estado = $rec->estado;

                    $nuevoConsecutivo->save();

        } catch (\Exception $e){

            DB::rollBack();
            $response = array(
                'type' => '0',
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

    //Actualizar Consecutivo
    public function cwrActualizarConsecutivos($rec)
    {
        //echo json_encode($rec->id);
        //exit;
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

     // Lee consecutivo de categorias
     public function ListarUnConsecutivoCategoriasCinco($rec)
     {
 
         //echo json_encode($rec->tipoproducto);
         //exit;
         $db_name = "cyclewear_sys";
         
         $consecutivocategorias = DB::connection($this->cur_connect)->select(
                                                 "select t0.id as value, t0.nombretipoproducto as label,
                                                  t0.* from ".$db_name.'.consecutivoscategorias'." t0 
                                                 WHERE estado = 1 
                                                   AND t0.nombretipoproducto  = '".$rec->tipoproducto."' 
                                                   AND t0.nombrecategoriauno  = '".$rec->categoriauno."'
                                                   AND t0.nombrecategoriados  = '".$rec->categoriados."'
                                                   AND t0.nombrecategoriatres = '".$rec->categoriatres."'
                                                   AND t0.nombrecategoriacuatro = '".$rec->categoriacuatro."'
                                                 ORDER BY t0.nombretipoproducto ASC");
                                                   /*
        
                                                   AND t0.nombrecategoriacuatro = '".$rec->categoriacuatro."'
                                                   */
                                                   
         echo json_encode($consecutivocategorias);
     }
    
    // Lee consecutivo de categorias
    public function ListarUnConsecutivoCategorias($rec)
    {

        //echo json_encode($rec->tipoproducto);
        //exit;
        $db_name = "cyclewear_sys";
        
        $consecutivocategorias = DB::connection($this->cur_connect)->select(
                                                "select t0.id as value, t0.nombretipoproducto as label,
                                                 t0.* from ".$db_name.'.consecutivoscategorias'." t0 
                                                WHERE estado = 1 
                                                  AND t0.nombretipoproducto  = '".$rec->tipoproducto."' 
                                                  AND t0.nombrecategoriauno  = '".$rec->categoriauno."'
                                                  AND t0.nombrecategoriados  = '".$rec->categoriados."'
                                                  AND t0.nombrecategoriatres = '".$rec->categoriatres."'
                                                ORDER BY t0.nombretipoproducto ASC");
                                                  /*
       
                                                  AND t0.nombrecategoriacuatro = '".$rec->categoriacuatro."'
                                                  */
                                                  
        echo json_encode($consecutivocategorias);
    }

    // Lee consecutivo de categorias
    public function ListarUnConsecutivoCategoriasDos($rec)
    {

        //echo json_encode($rec->tipoproducto);
        //exit;
        $db_name = "cyclewear_sys";
        
        $consecutivocategorias = DB::connection($this->cur_connect)->select(
                                                "select t0.id as value, t0.nombretipoproducto as label,
                                                 t0.* from ".$db_name.'.consecutivoscategorias'." t0 
                                                WHERE estado = 1 
                                                  AND t0.nombretipoproducto  = '".$rec->tipoproducto."' 
                                                  AND t0.nombrecategoriauno  = '".$rec->categoriauno."'
                                                  AND t0.nombrecategoriados  = '".$rec->categoriados."'
                                                ORDER BY t0.nombretipoproducto ASC");
                                                  /*
       
                                                  AND t0.nombrecategoriacuatro = '".$rec->categoriacuatro."'
                                                  */
                                                  
        echo json_encode($consecutivocategorias);
    }

    // Lee consecutivo de categorias
    public function ListarUnConsecutivoCategoriasTres($rec)
    {
        //echo json_encode($rec->tipoproducto);
        //exit;
        $db_name = "cyclewear_sys";
        
        $consecutivocategorias = DB::connection($this->cur_connect)->select(
                                                "select t0.id as value, t0.nombretipoproducto as label,
                                                 t0.* from ".$db_name.'.consecutivoscategorias'." t0 
                                                WHERE estado = 1 
                                                  AND t0.nombretipoproducto  = '".$rec->tipoproducto."' 
                                                  AND t0.nombrecategoriauno  = '".$rec->categoriauno."'
                                                ORDER BY t0.nombretipoproducto ASC");
                                                  /*
       
                                                  AND t0.nombrecategoriacuatro = '".$rec->categoriacuatro."'
                                                  */
                                                  
        echo json_encode($consecutivocategorias);
    }

    // Lee consecutivo de categorias
    public function ListarUnConsecutivoCategoriasCuatro($rec)
    {
         //echo json_encode($rec->tipoproducto);
         //exit;
         $db_name = "cyclewear_sys";
         
         $consecutivocategorias = DB::connection($this->cur_connect)->select(
                                                 "select t0.id as value, t0.nombretipoproducto as label,
                                                  t0.* from ".$db_name.'.consecutivoscategorias'." t0 
                                                 WHERE estado = 1 
                                                   AND t0.nombretipoproducto  = '".$rec->tipoproducto."' 
                                                 ORDER BY t0.nombretipoproducto ASC");
                                                   /*
        
                                                   AND t0.nombrecategoriacuatro = '".$rec->categoriacuatro."'
                                                   */
                                                   
         echo json_encode($consecutivocategorias);
    }

    //Actualizar Consecutivo categorias
    public function ActualizarConsecutivosCategorias($rec)
    {
        //echo json_encode($rec->id);
        //exit;
        $db_name = $this->db.".consecutivoscategorias";
 
        DB::beginTransaction();
        try {
 
            DB::connection($this->cur_connect)->update("UPDATE ".$db_name." 
                SET consecutivo = '".$rec->consecutivo."'
                WHERE codigo = '".$rec->codigo."'");
 
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

    //Crear conscutivo en Base de Datos
    public function cwrCrearPedidosBD($rec)
    {
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
            'message' => 'REGISTRO EXITOSO',listarPedidosDB
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
        //$url = $this->url_siigo_api."/products/75abf5d7-5736-430d-aea5-1f78b9b8e7e8";
        //$url = $this->url_siigo_api."taxes";
        //$url = $this->url_siigo_api."/products/3db9cdd7-d441-4ab8-9a98-3317a81f0d6c";
        //$url = $this->url_siigo_api."taxes";
        $url = $this->url_siigo_api."document-types?type=FV";
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
                                "sku"=>isset($items["reference"])?
                                $items["reference"]:"",
                                "description"=>isset($items["description"])?
                                $items["description"]:"",
                                "type"=>$items["type"],
                                "active"=>$items["active"],
                                "stock_control"=>$items["stock_control"],
                                "tax_classification"=>$items["tax_classification"],
                                "tax_included"=>$items["tax_included"],
                                "idgrupo"=>
                                    @$items["account_group"][0]["id"] ?
                                    $items["account_group"][0]["id"]
                                    :
                                    0,
                                "nombregrupo"=>
                                    @$items["account_group"]["name"] ?
                                    $items["account_group"]["name"]
                                    :
                                    0,
                                "cantidad"=>$items["available_quantity"],
                                "impuestos"=>0,
                                "codigobarra"=>
                                    @$items["additional_fields"]["barcode"] ?
                                    $items["additional_fields"]["barcode"]
                                    :
                                    0,
                                "marca"=>
                                    @$items["additional_fields"]["brand"] ?
                                    $items["additional_fields"]["brand"]
                                    :
                                    0,
                                "bodega"=>
                                    @$items["warehouses"]["name"] ?
                                    $items["warehouses"]["name"]
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
                                //"sku"=>$items["reference"],
                                "sku"=>isset($items["reference"])?
                                $items["reference"]:"",
                                "description"=>isset($items["description"])?
                                $items["description"]:"",
                                "type"=>$items["type"],
                                "active"=>$items["active"],
                                "stock_control"=>$items["stock_control"],
                                "tax_classification"=>$items["tax_classification"],
                                "tax_included"=>$items["tax_included"],
                                "idgrupo"=>
                                    @$items["account_group"]["id"] ?
                                    $items["account_group"]["id"]
                                    :
                                    0,
                                "nombregrupo"=>
                                    @$items["account_group"]["name"] ?
                                    $items["account_group"]["name"]
                                    :
                                    0,
                                "cantidad"=>$items["available_quantity"],
                                //"impuestos"=>$items["taxes"][0]["percentage"],
                                "impuestos"=>isset($items["taxes"][0]["percentage"])?
                                $items["taxes"][0]["percentage"]
                                :0,
                                "codigobarra"=>
                                    @$items["additional_fields"]["barcode"] ?
                                    $items["additional_fields"]["barcode"]
                                    :
                                    0,
                                "marca"=>
                                    @$items["additional_fields"]["brand"] ?
                                    $items["additional_fields"]["brand"]
                                    :
                                    0,
                                "bodega"=>
                                    @$items["warehouses"]["name"] ?
                                    $items["warehouses"]["name"]
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

    public function actualizaProductoSiigoPru($rec)
    { 
        $id =  $rec->idsiigo;
        $url = $this->url_siigo_api."products/".$id;
        //$url = "https://api.siigo.com/v1/products/e28c45b8-16f4-4b5e-a486-ce4667385a6e";
        //$response = FunctionsCustoms::SiigoPut($url,$this->db);
        //echo $url;
        //exit;
       
        $listaitems = array();
        //foreach($data["results"] as $items){
            $itemunico = array(
                                    
                                        "code" => $rec->code,
                                        "name" => $rec->name,
                                        "account_group" => $rec->account_group,
                                        "type" => $rec->type,
                                        "stock_control" => $rec->stock_control,
                                        "active" => $rec->active,
                                        "tax_classification" => $rec->tax_classification,
                                        "tax_included" => $rec->tax_included,
                                        "tax_consumption_value" => 0,
                                        "taxes" => array 
                                        ([
                                          "id" => $rec->idtaxes,
                                        ]),
                                        "prices" => array ([
                                          
                                            "currency_code" => "COP",
                                            "price_list"=> array(['position' => 1, 'value' => $rec->value])
                                          
                                        ]),
                                        "unit" =>"94",
                                        "unit_label" =>"unidad",
                                        "reference" =>$rec->sku,
                                        "description" => $rec->description,
                                        "additional_fields" => array(
                                            "barcode" => $rec->barcode,
                                            "brand" => $rec->brand,
                                            "tariff" =>"",
                                            "model" =>""
                                          )
                                      
                                    


        );
            //    var_dump($items["prices"][0]["price_list"][0]["value"]); 
            $listaitems[] = $itemunico;
        //};
    
        //echo json_encode($itemunico);
        //exit;

        $response = FunctionsCustoms::SiigoPut($url,$this->db,$itemunico);
        $rec->headers->set('Accept', 'application/json');

        $respuesta = json_decode($response);
        echo json_encode($respuesta);
        exit;
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
    //AQUI
    public function crearProducto($rec)
    {
            $url = $this->url_siigo_api."products";
            $taxes_p = array();
            $priceslist_p = array();
            $prices_p = array();

            // Impuestos array
            $taxesa = array('id' => $rec->tarifa);
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
            header('Content-Type: application/json; charset=utf-8; Partner-Id: aplicacion');
            $response = FunctionsCustoms::SiigoPost($url,$this->db,$array_post, header);
            $rec->headers->set('Accept', 'application/json', 'Partner-Id:"producto"');

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

        //echo $response;
        //exit;

        $resp_crear = json_decode($response);

        if(isset($resp_crear->id)){
            $array_Resp = array("status" => 200, "id" => $resp_crear->id);
            $response = array(
                'type' => 1,
                'message' => 'REGISTRO EXITOSO',
                'codigo' => 'REGISTRO EXITOSO',
                'id' => $resp_crear->id,
                'status' => 200,
            );
        }else{
            $array_Resp = array("status" => $resp_crear->Status,
                                "id" => 0,
                                "codigo" => $resp_crear-> Errors[0]->Code,
                                "mensaje" => $resp_crear-> Errors[0]->Message
                            );
            $response = array(
                'type' => 0,
                'message' => 'ERROR EN REGISTRO',
                'id' => 0,
                'status' => 0,

            );
        }
        echo json_encode($array_Resp);
        //echo json_encode($response);
        
        //exit;
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
                "id" => 38317, //$rec->id,
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

    //Subir inventario de inmuebles
    public function loadInventory($rec)
    {

        DB::beginTransaction();
        try {
                    $db_name = $this->db.".importarinventario2";
                    $inventario = new ModelGlobal();
                    $inventario->setConnection($this->cur_connect);
                    $inventario->setTable($db_name);

                    /* Lee datos del place ID */
                    $place_describe  = 0;
                    $place_id = 0;
                    $ofr_latitud = 0;
                    $ofr_longitud = 0;

                    $address = urlencode( $rec->place);
                    define( 'API_KEY', 'AIzaSyBbbqRlLKh58Gboy-73McYBqlQREL84xqU' ); // https://developers.google.com/places/web-service/get-api-key
            
                    if ( $address ) {
            
                        $place_query = "https://maps.googleapis.com/maps/api/place/findplacefromtext/json?input={$address}&inputtype=textquery&key=" . API_KEY ;
            
                        $response_str = file_get_contents( $place_query );
                        
                        if ( $response_str ) {
                            $response = json_decode( $response_str );
            
                            if (  $response ) {
                                //print_r( $response );
                                header('Content-Type: application/json; charset=utf-8');
                                //echo json_encode($response);
                                
                                foreach ( $response->candidates as $candidate ) {
                                    $place_id = $candidate->place_id;
                                    
                                    $place_id_query = "https://maps.googleapis.com/maps/api/place/details/json?placeid={$place_id}&key=" . API_KEY;
            
                                    $response_str = file_get_contents( $place_id_query );
                                    //var_dump($response_str);exit;
                                    if ( $response_str ) {
                                        $response = json_decode( $response_str , true );
            
                                        if (  $response ) {
                                            //echo "place_describe: ".$response['result']['name'].", ".$response['result']['formatted_address'];
                                            $place_describe  = $response['result']['formatted_address'];
                                            $place_id = $response['result']['place_id'];
                                            $ofr_latitud = $response['result']['geometry']["location"]["lat"];
                                            $ofr_longitud = $response['result']['geometry']["location"]["lng"];
                                            //header('Content-Type: application/json; charset=utf-8');
                                        }
                                    }
                                }
                            }
                        }
                    } else {
                        echo "Usage: php {$argv[0]} \"address string\"\n";
                    }

                    /*Termina lectura del Place ID */

                    $inventario -> Codigo =  $rec-> Codigo;
                    $inventario -> Cliente =  $rec-> Cliente;
                    $inventario -> Estadoenelsistema =  $rec-> Estadoenelsistema;
                    $inventario -> Tituloinmueble =  $rec-> Tituloinmueble;
                    $inventario -> Pais =  $rec-> Pais;
                    $inventario -> Departamento =  $rec-> Departamento;
                    $inventario -> Ciudad =  $rec-> Ciudad;
                    $inventario -> Localidad =  $rec-> Localidad;
                    $inventario -> Zona =  $rec-> Zona;
                    $inventario -> Tipodeinmueble =  $rec-> Tipodeinmueble;
                    $inventario -> Tipodenegocio =  $rec-> Tipodenegocio;
                    $inventario -> Preciodeventa =  $rec-> Preciodeventa;
                    $inventario -> PrecioRenta =  $rec-> PrecioRenta;
                    $inventario -> TiempoRenta =  $rec-> TiempoRenta;
                    $inventario -> Moneda =  $rec-> Moneda;
                    $inventario -> Estadodelinmueble =  $rec-> Estadodelinmueble;
                    $inventario -> AreaConstruida =  $rec-> AreaConstruida;
                    $inventario -> AreaPrivada =  $rec-> AreaPrivada;
                    $inventario -> AreaTerreno =  $rec-> AreaTerreno;
                    $inventario -> ValorAdministracion =  $rec-> ValorAdministracion;
                    $inventario -> Alcobas =  $rec-> Alcobas;
                    $inventario -> Banos =  $rec-> Banos;
                    $inventario -> Garaje =  $rec-> Garaje;
                    $inventario -> Estrato =  $rec-> Estrato;
                    $inventario ->MediosBanos =  $rec-> MediosBanos;
                    $inventario ->AlcobaServicio =  $rec-> AlcobaServicio;
                    $inventario ->Balcon =  $rec-> Balcon;
                    $inventario ->Ascensor =  $rec-> Ascensor;
                    $inventario ->Shabbat =  $rec-> Shabbat;
                    $inventario ->Airbnb =  $rec-> Airbnb;
                    $inventario -> Direccion =  $rec-> Direccion;
                    $inventario -> Codigopostal =  $rec-> Codigopostal;
                    $inventario -> Mapa =  $rec-> Mapa;
                    $inventario -> Latitud =  $rec-> Latitud;
                    $inventario -> Longitud =  $rec-> Longitud;
                    $inventario -> Opcionesmapa =  $rec-> Opcionesmapa;
                    $inventario -> EnRed =  $rec-> EnRed;
                    $inventario -> Video =  $rec-> Video;
                    $inventario -> Disponibilidad =  $rec-> Disponibilidad;
                    $inventario -> Anoconstruccion =  $rec-> Anoconstruccion;
                    $inventario -> Fechaderegistro =  $rec-> Fechaderegistro;
                    $inventario -> UsuarioAsignado =  $rec-> UsuarioAsignado;
                    $inventario -> Descripcion =  $rec-> Descripcion;
                    $inventario -> Comentario =  $rec-> Comentario;
                    $inventario -> Visitas =  $rec-> Visitas;
                    $inventario -> ValorComision =  $rec-> ValorComision;
                    $inventario -> TipodeComision =  $rec-> TipodeComision;
                    $inventario -> Certificadoenergetico =  $rec-> Certificadoenergetico;
                    $inventario -> NombrePropietario =  $rec-> NombrePropietario;
                    $inventario -> MovilPropietario =  $rec-> MovilPropietario;
                    $inventario -> TelefonoPropietario =  $rec-> TelefonoPropietario;
                    $inventario -> CorreoPropietario =  $rec-> CorreoPropietario;
                    $inventario -> Vinculo =  $rec-> Vinculo;
                    $inventario -> Portales =  $rec-> Portales;
                    $inventario -> Notas =  $rec-> Notas;
                    $inventario -> Caracteristicas =  $rec-> Caracteristicas;
                    $inventario -> Banoservicio =  $rec-> Servicio;
                    $inventario -> Balcon =  $rec-> Balcon;
                    $inventario -> Elevadores =  $rec-> Elevador;
                    $inventario -> Elevador =  $rec-> Elevador;
                    $inventario -> Airbnb =  $rec-> Airbnb;

                    $inventario -> ofr_latitud =  $ofr_latitud;
                    $inventario -> ofr_longitud =  $ofr_longitud;
                    $inventario -> place_id =  $place_id;
                    $inventario -> place_describe =  $place_describe;
                    $inventario -> place =  $rec-> place;
                    $inventario -> Foto1  = $rec-> Fotos;
                    $inventario -> Foto2  = $rec-> Foto2;
                    $inventario -> Foto3  = $rec-> Foto3;
                    $inventario -> Foto4  = $rec-> Foto4;
                    $inventario -> Foto5  = $rec-> Foto5;
                    $inventario -> Foto6  = $rec-> Foto6;
                    $inventario -> Foto7  = $rec-> Foto7;
                    $inventario -> Foto8  = $rec-> Foto8;
                    $inventario -> Foto9  = $rec-> Foto9;
                    $inventario -> Foto10 = $rec-> Foto10;

                    $inventario->save();

        } catch (\Exception $e){

            DB::rollBack();
            $response = array(
                'type' => '0',
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

    //Subir inventario de inmuebles
    public function loadInventoryValidacion($rec)
    {
        DB::beginTransaction();
        try {
                    $db_name = $this->db.".validainventario";
                    $validacion = new ModelGlobal();
                    $validacion->setConnection($this->cur_connect);
                    $validacion->setTable($db_name);

                    $validacion -> Codigo =  $rec-> Codigo;
                    $validacion -> Cliente =  $rec-> Cliente;

                    $validacion->save();

        } catch (\Exception $e){

            DB::rollBack();
            $response = array(
                'type' => '0',
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
    public function unloadInventory($rec)
    {
        $db_name = "cyclewear_sys";
    
        $listadoinmuebles = DB::connection($this->cur_connect)->select("
                                                        select t0.codigo as value, t0.Tipodeinmueble as label, t0.*
                                                        from ".$db_name.'.importarinventario2'." t0
                                                        ORDER BY value ASC");
    
        echo json_encode($listadoinmuebles);
    }

    //Subir inventario de inmuebles
    public function procesarInventory($rec)
    {
        //$address = urlencode( 'El Tesoro'.' Medellín Antioquia'. ' Colombia' );
        $address = urlencode( $rec->place);
        define( 'API_KEY', 'AIzaSyBbbqRlLKh58Gboy-73McYBqlQREL84xqU' ); // https://developers.google.com/places/web-service/get-api-key

        if ( $address ) {

            $place_query = "https://maps.googleapis.com/maps/api/place/findplacefromtext/json?input={$address}&inputtype=textquery&key=" . API_KEY ;

            $response_str = file_get_contents( $place_query );
            
            if ( $response_str ) {
                $response = json_decode( $response_str );

                if (  $response ) {
                    //print_r( $response );
                    header('Content-Type: application/json; charset=utf-8');
                    //echo json_encode($response);
                    
                    foreach ( $response->candidates as $candidate ) {
                        $place_id = $candidate->place_id;
                        
                        $place_id_query = "https://maps.googleapis.com/maps/api/place/details/json?placeid={$place_id}&key=" . API_KEY;

                        $response_str = file_get_contents( $place_id_query );
                        //var_dump($response_str);exit;
                        if ( $response_str ) {
                            $response = json_decode( $response_str , true );

                            if (  $response ) {
                                //echo "place_describe: ".$response['result']['name'].", ".$response['result']['formatted_address'];
                                echo "place_describe: ".$response['result']['formatted_address'];
                                echo " place_id: ".$response['result']['place_id'];
                                echo " ofr_latitud: ".$response['result']['geometry']["location"]["lat"];
                                echo " ofr_longitud: ".$response['result']['geometry']["location"]["lng"];
                                header('Content-Type: application/json; charset=utf-8');
                                

                            }
                        }
                    }
                }
            }
        } else {
            echo "Usage: php {$argv[0]} \"address string\"\n";
        }

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
