<?php

namespace App\Http\Controllers;

use App\Mail\EnvioTokenMRP;
use App\Models\Email;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Cache;

class ApiController extends Controller
{
    private $TccToken;
    private $Authorization;
    private $Partner;
    private $urlSigo;
    private $siigo_username;
    private $siigo_access_key;
    private $info_name_mail;
    private $info_mail;
    private $admin_name_mail;
    private $admin_mail;
    private $soporte_name_mail;
    private $soporte_mail;
    private $ventas_name_mail;
    private $ventas_mail;
    private $tokenWs;
    private $identificadorWs;
    private $keySms;
    private $clientSMS;

    public function __construct()
    {
        $this->keySms = 'cc4850fa394cbc9774cee275613875cf3879053a66bff1ddc66a3';
        $this->clientSMS = '6471';
        $this->tokenWs = 'EAAK68ZAS7Bt4BO2JqJJN5tskeGfgoG6utymvTcxNWXqmQlljNehwZBU3zISSxffnkdTujI2VCGQLZAP4dW9hqf4bZCqQgqjYRwoboukoADi46r9GF6kMDS3WBqpqaMnYt7fXexGX5drMpj2qd7O5QiOLh6wqJaZCTIc1vxBVGOxNMBZCsnf0vUWBhUXxB0BXXH';
        $this->identificadorWs = '287436924461440';
        $this->TccToken ='CLITCC20240OLPBZGKAK';
        $this->Authorization = '$2y$10$hc8dShHM0E71/08Tcjq3nOdq.hCmOcn5mEH5a/UZ9Lk0eBptD8CeG';
        $this->urlSigo = 'https://api.siigo.com/auth?oauth_consumer_key=lzcH2sPb4FQo1A9wWQKihb14&oauth_signature_method=HMAC-SHA1&oauth_timestamp=1706290114&oauth_nonce=TFKy4oTOP2u&oauth_version=1.0&oauth_signature=KRUX3Tz4VU22oeDVT%2FLOEGlvVZ0%3D';
        $this->Partner = 'sandbox';
        $this->siigo_username = 'sandbox@siigoapi.com';
        $this->siigo_access_key = 'NDllMzI0NmEtNjExZC00NGM3LWE3OTQtMWUyNTNlZWU0ZTM0OkosU2MwLD4xQ08=';
        $this->info_name_mail ='informacion@mercadorepuesto.com.co';
        $this->info_mail ='Mercado Repuesto';
        $this->admin_name_mail ='admin@edutechnazaret.online';
        $this->admin_mail ='admin';
        $this->soporte_name_mail ='soporte@edutechnazaret.online';
        $this->soporte_mail ='soporte';
        $this->ventas_name_mail ='ventas@edutechnazaret.online';
        $this->ventas_mail ='ventas';
    }
    public function receive(Request $request, $accion)
    {
        $token = $request->header('Authorization');
        if ($token !== $this->Authorization) {
            return response()->json(['error' => 'Token incorrecto'], 401);
        }
        

        switch ($accion) {
            case 'mail':
                return $this->sendEmail($request);
                break;
            case '10001':
                return $this->consultartarifa($request);
                break;
            case '10002':
                return $this->consultarinformacion($request);
                break;
            case '10003':
                return $this->solicitudrecogida($request);
                break;
            case '10004':
                return $this->impresionrotulos($request);
                break;
            case '10005':
                return $this->consultarestatusremesas($request);
                break;
            case '10006':
                return $this->grabardespacho7($request);
                break;
            case '10007':
                return $this->consultarestatusremesasv3($request);
                break;
            case '10008':
                return $this->anulardespacho($request);
                break;
            case 'siigo-c-create':
                return $this->createClientes($request);
                break;
            case 'siigo-c-update':
                return $this->updateClientes($request);
                break;
            case 'siigo-c-show':
                return $this->showClientes($request);
                break;
            case 'siigo-c-delete':
                return $this->destroyClientes($request);
                break;
            case 'siigo-p-create':
                return $this->createProducto($request);
                break;
            case 'siigo-p-update':
                return $this->updateProducto($request);
                break;
            case 'siigo-p-show':
                return $this->showProducto($request);
                break;
            case 'siigo-p-delete':
                return $this->destroyProducto($request);
                break;
            case 'siigo-f-create':
                return $this->createFacturas($request);
                break;
            case 'siigo-f-update':
                return $this->updateFacturas($request);
                break;
            case 'siigo-n-create':
                return $this->createNotaCredi($request);
                break;
            case 'siigo-n-pdf':
                return $this->pdfNotaCredi($request);
                break;
            case 'siigo-f-pdf':
                return $this->pdfFacturas($request);
                break;
            case 'siigo-f-mail':
                return $this->sendFacturas($request);
                break;
            case 'siigo-f-show':
                return $this->showFacturas($request);
                break;
            case 'siigo-n-show':
                return $this->showNotaCredi($request);
                break;
            case 'ws-plantilla':
                return $this->sendWsPlantilla($request);
                break;
            case 'sms':
                return $this->Sms($request);
                break;
            case 'sms-consulta':
                return $this->ConsultaSMS($request);
                break;
            case 'tcc-consultar':
                return $this->ConsultarEnvio($request);
                break;
            default:
                return response()->json(['error' => 'Ruta no encontrada'], 404);
                break;
        }
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
    //Envio de Correo
    public function sendEmail(Request $request)
    {
        try {
            switch ($request->input('to')) {
                case 'Mercado Repuesto':
                        $from = $this->info_name_mail;
                        $name_from = $this->info_mail;
                    break;
                case 'admin':
                        $from = $this->admin_name_mail;
                        $name_from = $this->admin_mail;
                    break;
                case 'soporte':
                        $from = $this->soporte_name_mail;
                        $name_from = $this->soporte_mail;
                    break;
                case 'ventas':
                        $from = $this->ventas_name_mail;
                        $name_from = $this->ventas_mail;
                    break;
                default:
                        return response()->json(['error' => 'Error al enviar el correo: Mailer ['. $request->input('to') .'] is not defined'], 500);
                    break;
            } 
            $data = [
                'remitente' => $request->input('remitente'),
                'asunto' => $request->input('asunto'),
                'plantilla' => $request->input('plantilla'),
                'contenido_html' => $request->input('contenido_html'),
                'to' => $request->input('to'),
                'from' => $from,
                'name_from' => $name_from
            ];
            
            $correo = new EnvioTokenMRP((object) $data);
            Mail::mailer($request->input('to'))->to($request->input('remitente'))->send($correo);
            return response()->json(['message' => 'Correo enviado'], 200);

        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al enviar el correo: ' . $e->getMessage()], 500);
        }
    }
    //TCC
    public function consultartarifa(Request $request)
    {  
        $url = 'https://testsomos.tcc.com.co/api/clientes/tarifas/consultartarifasmt';
        $metodo = 'POST';
        $data = $request->json()->all();
        return $this->sendTccData($url, $metodo, $data);
    }
    public function consultarinformacion(Request $request)
    {
        $url = 'https://testsomos.tcc.com.co/api/clientes/remesas/consultarinformacionremesasuen';
        $metodo = 'POST';
        $data = $request->json()->all();
        return $this->sendTccData($url, $metodo, $data);
    }
    public function solicitudrecogida(Request $request)
    {
        $url = 'https://testsomos.tcc.com.co/api/recogidas/solicitudrecogida';
        $metodo = 'POST';
        $data = $request->json()->all();
        return $this->sendTccData($url, $metodo, $data);
    }
    public function impresionrotulos(Request $request)
    {
        $ruta = 'https://testsomos.tcc.com.co/api/clientes/remesas/impresionrotulos';
        $metodo = 'POST';
        $data = $request->json()->all();
        return $this->sendTccData($ruta, $metodo, $data);
    }
    public function consultarestatusremesas(Request $request)
    {
        $url = 'https://testsomos.tcc.com.co/api/clientes/remesas/consultarestatusremesas';
        $metodo = 'POST';
        $data = $request->json()->all();
        return $this->sendTccData($url, $metodo, $data);
    }
    public function grabardespacho7(Request $request)
    {
        $url = 'https://preclientes.tcc.com.co/api/clientes/remesas/grabardespacho7';
        $metodo = 'POST';
        $data = $request->json()->all();
        return $this->sendTccData($url, $metodo, $data);
    }
    public function consultarestatusremesasv3(Request $request)
    {
        $url = 'https://testsomos.tcc.com.co/api/clientes/remesas/consultarestatusremesasv3';
        $metodo = 'POST';
        $data = $request->json()->all();
        return $this->sendTccData($url, $metodo, $data);
    }
    public function anulardespacho(Request $request)
    {
        $url = 'https://somos.tcc.com.co/api/clientes/remesas/anulardespacho';
        $metodo = 'POST';
        $data = $request->json()->all();
        return $this->sendTccData($url, $metodo, $data);
    }
    //Envio Transporte
    public function sendTccData($url, $metodo, $data)
    {
        $response = Http::withHeaders([
            'AccessToken' => $this->TccToken,
        ])->timeout(120)->send($metodo, $url, ['json' => $data]);

        return $response->body();
    }
    //Siigo envio
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
            Cache::put('key_siigo2', $accessToken, now()->addMinutes(2));
            return $accessToken;
        } else {
            return response()->json(['error' => 'Error en la autenticación con Siigo'], $response->status());
        }
    }
    private function sendMessage($url, $metodo)
    {
        $tokenSiigo = Cache::get('key_siigo2');
        if (!$tokenSiigo) {
            $tokenSiigo = $this->authenticateSiigo();
        }
        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
            'Authorization' => $tokenSiigo,
            'Partner-Id' => $this->Partner
        ])->timeout(120)->send($metodo, $url);
        return $response->body();
    }
    private function sendMessageData($url, $metodo, $data)
    {
        $tokenSiigo = Cache::get('key_siigo2');
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
    private function sendWsPlantilla(Request $request)
    {
        $to = $request->input('to');
        $template = $request->input('template');
        $parameters = $request->input('parameters');
        $formattedParameters = [];

        foreach ($parameters as $inputParam) {
            $formattedParameters[] = [
                'type' => 'text',
                'text' => $inputParam['text']
            ];
        }
        

        $body = [
            'messaging_product' => 'whatsapp',
            'to' => $to,
            'type' => 'template',
            'template' => [
                "name" => $template,
                "language" => [
                    "code" => "es" 
                ],
                "components" => [
                    [
                        "type" => "body",
                        "parameters" => $formattedParameters
                    ]
                ]
            ]
        ];
        return $this->sendNoti($body);
    }
    public function sendNoti($body)
    { 
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $this->tokenWs,
            'Content-Type' => 'application/json',
        ])->post("https://graph.facebook.com/v19.0/$this->identificadorWs/messages", $body);
    
        return $response->body();
    }
    private function Sms(Request $request)
    {
        $body = [
            'key' => $this->keySms,
            'client' => $this->clientSMS,
            'phone' => $request->input('phone'),
            'sms' => $request->input('sms'),
        ];
        $response = Http::withHeaders([
            'Content-Type' => 'application/x-www-form-urlencoded',
            'Accept' => 'application/json',
        ])->asForm()->post("https://www.onurix.com/api/v1/sms/send", $body);
        return $response->body();
    }
    private function ConsultaSMS()
    { 
        $url = "https://www.onurix.com/api/v1/balance?client={$this->clientSMS}&key={$this->keySms}";
        $response = Http::timeout(120)->get($url);
        return $response->body();
    }
}
