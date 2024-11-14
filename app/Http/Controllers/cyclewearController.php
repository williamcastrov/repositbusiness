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
    private $Authorization;

    public function __construct()
    {
        $this->urlSigo = 'https://api.siigo.com/auth?oauth_consumer_key=lzcH2sPb4FQo1A9wWQKihb14&oauth_signature_method=HMAC-SHA1&oauth_timestamp=1706290114&oauth_nonce=TFKy4oTOP2u&oauth_version=1.0&oauth_signature=KRUX3Tz4VU22oeDVT%2FLOEGlvVZ0%3D';
        $this->Partner = 'sandbox';
        $this->siigo_username = 'sandbox@siigoapi.com';
        $this->siigo_access_key = 'NDllMzI0NmEtNjExZC00NGM3LWE3OTQtMWUyNTNlZWU0ZTM0OkosU2MwLD4xQ08=';

        $this->Authorization = '$2y$10$hc8dShHM0E71/08Tcjq3nOdq.hCmOcn5mEH5a/UZ9Lk0eBptD8CeG';
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
        $token = $request->header('Authorization');
        if ($token !== $this->Authorization) {
            return response()->json(['error' => 'Token incorrecto'], 401);
        }

        switch ($accion) {
            case 1:
                $this->cwrCategorias($request);
                break;
            case 2:
                $this->cwrTiposCliente($request);
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
            
            
            case '2000':
                return $this->listarOrdenes($request);
                break;
            case '2001':
                return $this->listarItemsOrdenes($request);
                break;
            case '2002':
                return $this->listarClientes($request);
                break;
            case '2003':
                return $this->listarProductos($request);
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
            
            
            if ($checkoutItemData['ProductVersion']['internalCode']) {
                $code = $checkoutItemData['ProductVersion']['internalCode'];
            } else {
                $code = $checkoutItemData['code'];
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

            $producto = SiigoProducto::where('code', $code)->first();
            $nuevaCantidad = $producto->available_quantity - $checkoutItemData['count'];
            $producto->available_quantity = $nuevaCantidad;
            $producto->save();
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

            
            
        // $data = [
        //     "code" =>  $code,
        //     "name" =>   $fullname,
        //     "account_group" => 121,
        //     "type" => "Product",
        //     "stock_control" => false,
        //     "active" => true,
        //     "tax_classification" => "Taxed",
        //     "tax_included" => false,
        //     "tax_consumption_value" => 0,
        //     "taxes" => [
        //         [
        //             "id" => 1270
        //         ]
        //     ],
        //     "prices" => [
        //         [
        //             "currency_code" => "COP",
        //             "price_list" => [
        //                 [
        //                     "position" => 1,
        //                     "value" => $price
        //                 ]
        //             ]
        //         ]
        //     ],
        //     "unit" => "94",
        //     "unit_label" => "unidad",
        //     "reference" => $dataProduct['ProductVersions']['0']['code'],
        //     "description" => $Description,
        //     "additional_fields" => [
        //         "barcode" => $dataProduct['ProductVersions']['0']['code'],
        //         "brand" => $dataProduct['Brand']['name'],
        //         "model" => $dataProduct['model']
        //     ]
        // ];

        SiigoProducto::create([
            'code' => $code,
            'name' => $fullname,
            'description' => $Description,
            'precio' => $price
        ]);


        // $url = 'https://api.siigo.com/v1/products';
        // $metodo = 'POST';
        // $product_siigo = $this->sendMessageData($url, $metodo, $data);
        // $product_siigo_array = json_decode($product_siigo, true);
        
            
        // SiigoProducto::create([
        //     'id_siigo' => $product_siigo_array['id'],
        //     'code' => $product_siigo_array['code'],
        //     'name' => $product_siigo_array['name'],
        //     'type' => $product_siigo_array['type'],
        //     'active' => $product_siigo_array['active'],
        //     'description' => $product_siigo_array['description'],
        //     'precio' => $price,
        //     'referencia' => $dataProduct['internalCode'],
        //     'stock_control' => $product_siigo_array['stock_control'],
        //     'available_quantity' => $product_siigo_array['available_quantity'],
        //     'unit' => $product_siigo_array['unit_label'],
        //     'barcode' => $dataProduct['internalCode'],
        //     'brand' => $dataProduct['Brand']['name'],
        //     'model' => $dataProduct['model'],
        // ]);

        // SiigoStock::create([
        //     'producto_sku' => $product_siigo_array['code'],
        //     'description' => $name,
        //     'quantity' => $product_siigo_array['available_quantity'],
        // ]);

        // return  $product_siigo_array;

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
    public function createProducto(Request $request)
    {
        $url = 'https://api.siigo.com/v1/products';
        $metodo = 'POST';
        $data = $request->json()->all();
        $product_siigo = $this->sendMessageData($url, $metodo, $data);
        $product_siigo_array = json_decode($product_siigo, true);
        
        SiigoProducto::create([
            'id_siigo' => $product_siigo_array['id'],
            'code' => $product_siigo_array['code'],
            'name' => $product_siigo_array['name'],
            'type' => $product_siigo_array['type'],
            'active' => $product_siigo_array['active'],
            'description' => $product_siigo_array['description'],
            'precio' => $product_siigo_array['prices'][0]['price_list'][0]['value'],
            'referencia' => $product_siigo_array['reference'],
            'stock_control' => $product_siigo_array['stock_control'],
            'available_quantity' => $product_siigo_array['available_quantity'],
            'unit' => $product_siigo_array['unit_label'],
            'barcode' => $product_siigo_array['additional_fields']['barcode'],
            'brand' => $product_siigo_array['additional_fields']['brand'],
            'model' => $product_siigo_array['additional_fields']['model'],
        ]);

        SiigoStock::create([
            'producto_sku' => $product_siigo_array['code'],
            'description' => $product_siigo_array['name'],
            'quantity' => $product_siigo_array['available_quantity'],
        ]);

        return  $product_siigo_array;
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
            Cache::put('key_siigo_mv', $accessToken, now()->addHours(23));
            return $accessToken;
        } else {
            return response()->json(['error' => 'Error en la autenticación con Siigo'], $response->status());
        }
    }
    private function sendMessage($url, $metodo)
    {
        $tokenSiigo = Cache::get('key_siigo_mv');
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
        $tokenSiigo = Cache::get('key_siigo_mv');
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
        $tokenSiigo = Cache::get('key_siigo2');
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
    
    public function listarOrdenes($rec)
    {
        //echo json_encode($rec->idinterno);
        //exit;
        DB::beginTransaction();
        try {
            $db_name = "cyclewear_sys";
                
        $listarordenes = DB::connection($this->cur_connect)->select(
                                                "select t0.*
                                                from ".$db_name.'.multivende_orders'." t0
                                                ORDER BY t0.created_at ASC");

        } catch (\Exception $e){
        
            DB::rollBack();
            $response = array(
                'type' => '0',
                'message' => "ERROR ".$e
            );
            $rec->headers->set('Accept', 'application/json');
            echo json_encode($response);
            exit;
        }
        DB::commit();
        $response = array(
            'type' => 1,
            'listarordenes' => $listarordenes,
            'message' => 'LIST ORDENES OK',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    public function listarItemsOrdenes($rec)
    {
        //echo json_encode($rec->idinterno);
        //exit;
        DB::beginTransaction();
        try {
            $db_name = "cyclewear_sys";
                
        $listaritemsordenes = DB::connection($this->cur_connect)->select(
                                                "select t0.*
                                                from ".$db_name.'.multivende_orders_item'." t0
                                                WHERE t0.checkout_id = '".$rec->idorder."'
                                                ORDER BY t0.created_at ASC");

        } catch (\Exception $e){
        
            DB::rollBack();
            $response = array(
                'type' => '0',
                'message' => "ERROR ".$e
            );
            $rec->headers->set('Accept', 'application/json');
            echo json_encode($response);
            exit;
        }
        DB::commit();
        $response = array(
            'type' => 1,
            'listaritemsordenes' => $listaritemsordenes,
            'message' => 'LIST ORDENES OK',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }


    public function listarClientes($rec)
    {
        //echo json_encode($rec->idinterno);
        //exit;
        DB::beginTransaction();
        try {
            $db_name = "cyclewear_sys";
                
        $listarclientes = DB::connection($this->cur_connect)->select(
                                                "select t0.*
                                                from ".$db_name.'.multivende_clients'." t0
                                                ORDER BY t0.created_at ASC");

        } catch (\Exception $e){
        
            DB::rollBack();
            $response = array(
                'type' => '0',
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
            'message' => 'LIST ORDENES OK',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    public function listarProductos($rec)
    {
        //echo json_encode($rec->idinterno);
        //exit;
        DB::beginTransaction();
        try {
            $db_name = "cyclewear_sys";
                
        $listarproductos = DB::connection($this->cur_connect)->select(
                                                "select t0.*
                                                from ".$db_name.'.siigo_producto'." t0
                                                ORDER BY t0.created_at ASC");

        } catch (\Exception $e){
        
            DB::rollBack();
            $response = array(
                'type' => '0',
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
            'message' => 'LIST ORDENES OK',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }








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
    
  
}
