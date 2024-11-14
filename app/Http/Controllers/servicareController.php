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

class servicareController extends Controller
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
        $this->db = 'servicare_sys';
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
    public function servicareGeneral(Request $request, $accion, $parametro=null)
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
            case 5:
                $this->login($request);
                break;
            case 6:
                $this->listarEstratos($request);
                break;
            case 7:
                $this->environmentData($request);
                break;            
            case 100:
                $this->createClient($request);
                break;
            case 101:
                $this->listClients($request);
                break;
            case 102:
                $this->updateClients($request);
                break;
            case 105:
                $this->createContracts($request);
                break;
            case 106:
                $this->listContracts($request);
                break;
            case 107:
                $this->updateContracts($request);
                break;
            case 108:
                $this->createSupplier($request);
                break;
            case 109:
                $this->listSupplier($request);
                break;
            case 110:
                $this->updateSupplier($request);
                break;
            case 111:
                $this->createEmployee($request);
                break;
            case 112:
                $this->listEmployee($request);
                break;
            case 113:
                $this->updateEmployee($request);
                break;
            case 114:
                $this->createWorkOrders($request);
                break;
            case 115:
                $this->listWorkOrders($request);
                break;
            case 116:
                $this->updateWorkOrders($request);
                break;
            case 117:
                $this->createWorkingHours($request);
                break;
            case 118:
                $this->listWorkingHours($request);
                break;
            case 119:
                $this->updateWorkingHours($request);
                break;
            case 120:
                $this->deleteWorkingHours($request);
                break;
            case 121:
                $this->listWorkingHoursDay($request);
                break;
            case 122:
                $this->createContact($request);
                break;
            case 123:
                $this->listContact($request);
                break;
            case 124:
                $this->updateContact($request);
                break;
            case 125:
                $this->deleteContact($request);
                break;
            case 126:
                $this->createRecordCalls($request);
                break;
            case 127:
                $this->listRecordCalls($request);
                break;
            case 128:
                $this->updateRecordCalls($request);
                break;
            case 129:
                $this->deleteRecordCalls($request);
                break;
            case 130:
                $this->createQuoteSiteSurvey($request);
                break;
            case 131:
                $this->listQuoteSiteSurvey($request);
                break;
            case 132:
                $this->updateQuoteSiteSurvey($request);
                break;
            case 1321:
                $this->updateQuoteSSCalculation($request);
                break;            
            case 133:
                $this->deleteQuoteSiteSurvey($request);
                break;
            case 134:
                $this->createQuoteItemsSQFT($request);
                break;
            case 135:
                $this->listQuoteItemsSQFT($request);
                break;
            case 136:
                $this->updateQuoteItemsSQFT($request);
                break;
            case 137:
                $this->deleteQuoteItemsSQFT($request);
                break;
            case 138:
                $this->createQuoteItemsWL($request);
                break;
            case 139:
                $this->listQuoteItemsWL($request);
                break;
            case 1391:
                $this->listQuotePartsBuilding($request);
                break;
            case 140:
                $this->updateQuoteItemsWL($request);
                break;
            case 141:
                $this->deleteQuoteItemsWL($request);
                break;
            case 142:
                $this->createQuoteCostElements($request);
                break;
            case 143:
                $this->listQuoteCostElements($request);
                break;
            case 144:
                $this->updateQuoteCostElements($request);
                break;
            case 145:
                $this->deleteQuoteCostElements($request);
                break;
            case 146:
                $this->createQuoteSiteSurveyCMP($request);
                break;
            case 147:
                $this->listQuoteSiteSurveyCMP($request);
                break;
            case 148:
                $this->updateQuoteSiteSurveyCMP($request);
                break;
            case 149:
                $this->deleteQuoteSiteSurveyCMP($request);
                break;
            case 150:
                $this->createFixedValuesCMP($request);
                break;
            case 151:
                $this->listFixedValuesCMP($request);
                break;
            case 152:
                $this->updateFixedValuesCMP($request);
                break;
            case 153:
                $this->deleteFixedValuesCMP($request);
                break;
            case 154:
                $this->createServiceAreaCMP($request);
                break;
            case 155:
                $this->listServiceAreaCMP($request);
                break;
            case 156:
                $this->updateServiceAreaCMP($request);
                break;
            case 157:
                $this->deleteServiceAreaCMP($request);
                break;
            case 158:
                $this->createQuestionsToAskContact($request);
                break;
            case 159:
                $this->listQuestionsToAskContact($request);
                break;
            case 160:
                $this->updateQuestionsToAskContact($request);
                break;
            case 161:
                $this->deleteQuestionsToAskContact($request);
                break;
            case 162:
                $this->createQuoteFixedValuesCMP($request);
                break;
            case 163:
                $this->listQuoteFixedValuesCMP($request);
                   break;
            case 164:
                $this->updateQuoteFixedValuesCMP($request);
                break;
            case 165:
                $this->deleteQuoteFixedValuesCMP($request);
                break;
            case 166:
                $this->createQuoteUntCostJS($request);
                break;
            case 167:
                $this->listQuoteUntCostJS($request);
                break;
            case 168:
                $this->updateQuoteUntCostJS($request);
                 break;
            case 169:
                $this->deleteQuoteUntCostJS($request);
                break;
            case 170:
                $this->listQuoteSiteSurveyJS($request);
                break;
            case 171:
                $this->listQuoteSTSurveyCMP($request);
                break;
            case 172:
                $this->createViewFieldClient($request);
                break;
            case 173:
                $this->listViewFieldClient($request);
                break;
            case 174:
                $this->updateViewFieldClient($request);
                break;
            case 175:
                $this->deleteViewFieldClient($request);
                break;
            case 176:
                $this->createScopeWork($request);
                break;
            case 178:
                $this->updateScopeWork($request);
                break;
            case 179:
                $this->deleteScopeWork($request);
                break;
            case 180:
                $this->createScopeWorkJWR($request);
                break;
            case 181:
                $this->listScopeWorkJWR($request);
                break;
            case 182:
                $this->updateScopeWorkJWR($request);
                break;
            case 183:
                $this->deleteScopeWorkJWR($request);
                break;
            case 184:
                $this->createQuotation($request);
                break;
            case 185:
                $this->listQuotation($request);
                break;
            case 186:
                $this->updateQuotation($request);
                break;
            case 187:
                $this->deleteQuotation($request);
                break;
            case 188:
                $this->listAClient($request);
                break;
            case 189:
                $this->listAEmployee($request);
                break;
            case 190:
                $this->listAContracts($request);
                break;
            case 191:
                $this->listAddressClient($request);
                break;
            case 193:
                $this->createClientAddresses($request);
                break;
            case 194:
                $this->listClientAddresses($request);
                break;
            case 195:
                $this->updateClientAddresses($request);
                break;
            case 196:
                $this->deleteClientAddresses($request);
                break;
            case 197:
                $this->createEmergencyContact($request);
                break;
            case 198:
                $this->listEmergencyContact($request);
                break;
            case 199:
                $this->updateEmergencyContact($request);
                break;
            case 200:
                $this->deleteEmergencyContact($request);
                break;
            case 201:
                $this->createSiteInventoryMachine($request);
                break;
            case 2011:
                $this->createSiteInventoryMachinePDF($request);
                break;
            case 202:
                $this->listSiteInventoryMachine($request);
                break;
            case 203:
                $this->updateSiteInventoryMachine($request);
                break;
            case 204:
                $this->deleteSiteInventoryMachine($request);
                break;
            case 205:
                $this->createSignedDocuments($request);
                break;
            case 2051:
                $this->createSignedDocumentsPDF($request);
                break;
            case 206:
                $this->listSignedDocuments($request);
                break;
            case 207:
                $this->updateSignedDocuments($request);
                break;
            case 208:
                $this->deleteSignedDocuments($request);
                break;
            case 209:
                $this->createServiceTeamMember($request);
                break;
            case 210:
                $this->listServiceTeamMember($request);
                break;
            case 211:
                $this->updateServiceTeamMember($request);
                break;
            case 212:
                $this->deleteServiceTeamMember($request);
                break;
            case 213:
                $this->listAllQuotation($request);
                break;
            case 214:
                $this->createCompensation($request);
                break;
            case 215:
                $this->listCompensation($request);
                break;
            case 216:
                $this->updateCompensation($request);
                break;
            case 217:
                $this->deleteCompensation($request);
                break;
            case 218:
                $this->listClientFatherAndSon($request);
                break;
            case 219:
                $this->createWorkRegulation($request);
                break;
            case 220:
                $this->listWorkRegulation($request);
                break;
            case 221:
                $this->updateWorkRegulation($request);
                break;
            case 222:
                $this->deleteWorkRegulation($request);
                break;
            case 223:
                $this->createQuoteSiteSurveyOCJS($request);
                break;
            case 224:
                $this->listQuoteSiteSurveyOCJS($request);
                break;
            case 225:
                $this->updateQuoteSiteSurveyOCJS($request);
                break;
            case 226:
                $this->deleteQuoteSiteSurveyOCJS($request);
                break;
            case 227:
                $this->listQuoteSiteSurveyIdQuote($request);
                break;
            case 228:
                $this->createQuoteJanitorialWR($request);
                break;
            case 229:
                $this->listQuoteJanitorialWR($request);
                break;
            case 230:
                $this->updateQuoteJanitorialWR($request);
                break;
            case 231:
                $this->deleteQuoteJanitorialWR($request);
                break;
            case 232:
                $this->createScheduleSSJS($request);
                break;
            case 233:
                $this->listScheduleSSJS($request);
                break;
            case 234:
                $this->updateScheduleSSJS($request);
                break;
            case 235:
                $this->deleteScheduleSSJS($request);
                break;
            case 236:
                $this->listScheduleDaySSJS($request);
                break;
            case 237:
                $this->createQuoteSiteSurveyOCCMP($request);
                break;
            case 238:
                $this->listQuoteSiteSurveyOCCMP($request);
                break;
            case 239:
                $this->updateQuoteSiteSurveyOCCMP($request);
                break;
            case 240:
                $this->deleteQuoteSiteSurveyOCCMP($request);
                break;
            case 241:
                $this->createDocumentsEmployee($request);
                break;
            case 242:
                $this->createDocumentsEmployeePDF($request);
                break;
            case 243:
                $this->listDocumentsEmployee($request);
                break;
            case 244:
                $this->updateDocumentsEmployee($request);
                break;
            case 245:
                $this->deleteDocumentsEmployee($request);
                break;
            case 246:
                $this->createEmpPolicyHandbook($request);
                break;
            case 247:
                $this->listEmpPolicyHandbook($request);
                break;
            case 248:
                $this->updateEmpPolicyHandbook($request);
                break;
            case 249:
                $this->deleteEmpPolicyHandbook($request);
                break;
            case 250:
                $this->createMasterScopeWorkSSCMP($request);
                break;
            case 251:
                $this->listMasterScopeWorkSSCMP($request);
                break;
            case 252:
                $this->updateMasterScopeWorkSSCMP($request);
                break;
            case 253:
                $this->deleteMasterScopeWorkSSCMP($request);
                break;
            case 254:
                $this->listScopeWorkJWRIdQuote($request);
                break;
            case 255:
                $this->listWorkOrdersScopeWork($request);
                break;
            case 256:
                $this->createSupplyRequestForm($request);
                break;
            case 257:
                $this->listSupplyRequestForm($request);
                break;
            case 258:
                $this->updateSupplyRequestForm($request);
                break;
            case 259:
                $this->deleteSupplyRequestForm($request);
                break;
            case 260:
                $this->createVacationRF($request);
                break;
            case 261:
                $this->listVacationRF($request);
                break;
            case 262:
                $this->updateVacationRF($request);
                break;
            case 263:
                $this->deleteVacationRF($request);
                break;
            case 264:
                $this->createCertificateEmployee($request);
                break;
            case 265:
                $this->createCertificateEmployeePDF($request);
                break;
            case 266:
                $this->listCertificateEmployee($request);
                break;
            case 267:
                $this->updateCertificateEmployee($request);
                break;
            case 268:
                $this->deleteCertificateEmployee($request);
                break;
            case 269:
                $this->createConceptEmp($request);
                break;
            case 270:
                $this->listConceptEmp($request);
                break;
            case 271:
                $this->updateConceptEmp($request);
                break;
            case 272:
                $this->deleteConceptEmp($request);
                break;
            case 273:
                $this->listSupplyRequestSentTo($request);
                break;
            case 274:
                $this->createServiceAreaWO($request);
                break;
            case 275:
                $this->listServiceAreaWO($request);
                break;
            case 276:
                $this->updateServiceAreaWO($request);
                break;
            case 277:
                $this->deleteServiceAreaWO($request);
                break;
            case 278:
                $this->createDWOCustomized($request);
                break;
            case 279:
                $this->listDWOCustomized($request);
                break;
            case 280:
                $this->updateDWOCustomized($request);
                break;
            case 281:
                $this->deleteDWOCustomized($request);
                break;
            case 282:
                $this->listDWOCustomizedIDQuote($request);
                break;
            case 283:
                $this->listDWOCustomizedAll($request);
                break;
            case 284:
                $this->listQuoteSiteSurveyOCCMPAll($request);
                break;
            case 285:
                $this->listQuoteSiteSurveyOCJSAll($request);
                break;
            case 286:
                $this->listStatusWOCalendar($request);
                break;
            case 287:
                $this->updateEmpPolicyInit($request);
                break;
            case 288:
                $this->listAllAddressClient($request);
                break;
            case 289:
                $this->createPaymentMethods($request);
                break;
            case 290:
                $this->listPaymentMethods($request);
                break;
            case 2891:
                $this->updatePaymentMethods($request);
                break;
            case 292:
                $this->deletePaymentMethods($request);
                break;
            case 293:
                $this->listAddresClientUnique($request);
                break;
            case 294:
                $this->updatePaymentMethodClient($request);
                break;
            case 295:
                $this->createCSR($request);
                break;
            case 296:
                $this->listCSR($request);
                break;
            case 297:
                $this->updateCSR($request);
                break;
            case 298:
                $this->deleteCSR($request);
                break;
            case 299:
                $this->listSiteSurveyIdQuote($request);
                break;
            case 300:
                $this->createSSCMP($request);
                break;
            case 301:
                $this->listSSCMP($request);
                break;
            case 302:
                $this->updateDWOCustomizedComment($request);
                break;
            case 303:
                $this->listEmpClassifications($request);
                break;
            case 304:
                $this->listWorkOrdersEmployee($request);
                break;
            case 305:
                $this->createAdditionalEmp($request);
                break;
            case 306:
                $this->listAdditionalEmp($request);
                break;
            case 307:
                $this->updateAdditionalEmp($request);
                break;
            case 308:
                $this->deleteAdditionalEmp($request);
                break;    
            case 309:
                $this->listAllEmployees($request);
                break;
            case 310:
                $this->listAdditionalIdWO($request);
                break;
            case 311:
                $this->createInvoice($request);
                break;
            case 312:
                $this->listInvoice($request);
                break;
            case 313:
                $this->updateInvoice($request);
                break;
            case 314:
                $this->deleteInvoice($request);
                break;
            case 315:
                $this->createSAR($request);
                break;
            case 316:
                $this->listSAR($request);
                break;
            case 317:
                $this->listSAREmployee($request);
                break;
            case 318:
                 $this->updateSAR($request);
                break;
            case 319:
                $this->deleteSAR($request);
                break;
            case 320:
                $this->listCSREmployee($request);
                break;
            case 321:
                $this->listClientFather($request);
                break;
            case 322:
                $this->listClientChildren($request);
                break;
            case 323:
                $this->createEmployeeTC($request);
                break;
            case 324:
                $this->listEmployeeTC($request);
                break;
            case 325:
                $this->updateEmployeeTC($request);
                break;
            case 326:
                $this->deleteEmployeeTC($request);
                break;
            case 327:
                $this->listEmployeeTCWO($request);
                break;
            case 328:
                $this->listEmployeeTCAll($request);
                break;
            case 329:
                $this->createJWEmployee($request);
                break;
            case 330:
                $this->listJWEmployeeWO($request);
                break;
            case 331:
                $this->updateJWEmployee($request);
                break;
            case 332:
                $this->deleteJWEmployee($request);
                break;
            case 333:
                $this->listJWEmployeeAll($request);
                break;
            case 334:
                $this->listJWEmployee($request);
                break;
            case 335:
                $this->listSupplyRequestAll($request);
                break;
            case 336:
                $this->listSupplyRequestClient($request);
                break;
            case 337:
                $this->listVacationSentTo($request);
                break;
            case 338:
                $this->createWOCostConcept($request);
                break;
            case 339:
                $this->listWOCostConcept($request);
                break;
            case 340:
                $this->updateWOCostConcept($request);
                break;
            case 341:
                $this->deleteWOCostConcept($request);
                break;
            case 342:
                $this->createWOCostElement($request);
                break;
            case 343:
                $this->listWOCostElement($request);
                break;
            case 344:
                $this->updateWOCostElement($request);
                break;
            case 345:
                $this->deleteWOCostElement($request);
                break;
            case 346:
                $this->createworkordercost($request);
                break;
            case 347:
                $this->listWorkOrderCost($request);
                break;
            case 348:
                $this->updateworkordercost($request);
                break;
            case 349:
                $this->deleteworkordercost($request);
                break;
            case 350:
                $this->updateWorkOrdersStatus($request);
                break;
            case 351:
                $this->updateSiteSurveyComments($request);
                break;
            case 352:
                $this->saveImgWorkOrder($request);
                break;   
            case 353:
                $this->listImgWorkOrder($request);
                break; 
            case 354:
                $this->listTimeControlOffice($request);
                break;  
            case 355:
                $this->listContacts($request);
                break;
            case 356:
                $this->listInventoryMachine($request);
                break;
            case 357:
                $this->listDocumentsClients($request);
                break;
            case 358:
                $this->listEmergencyContacts($request);
                break;
            case 359:
                $this->listDocumentsEmployees($request);
                break;
            case 360:
                $this->listCertificateEmployees($request);
                break;
            case 361:
                $this->listVacationEmployee($request);
                break;
            case 362:
                $this->createVehicle($request);
                break;
            case 363:
                $this->listVehicle($request);
                break;
            case 364:
                $this->updateVehicle($request);
                break;
            case 365:
                $this->deleteVehicle($request);
                break;
            case 367:
                $this->listImgWorkOrderClient($request);
                break;
            case 368:
                $this->updateClientInactive($request);
                break;
            case 369:
                $this->updateSupplierPDF($request);
                break;
            case 370:
                $this->listWorkOrdersSingle($request);
                break;
            case 371:
                $this->updateQuoteEdit($request);
                break;
            case 372:
                $this->updateLatLngWorkOrder($request);
                break; 
            case 373:
                $this->updateEditDWOCustomized($request);
                break;
            case 374:
                $this->createPurposeSupplier($request);
                break;
            case 375:
                $this->listPurposeSupplier($request);
                break;
            case 376:
                $this->updatePurposeSupplier($request);
                break;
            case 377:
                $this->deletePurposeSupplier($request);
                break;
            case 378:
                $this->listAllClientsAndAddress($request);
                break;
            case 379:
                $this->listAllQuoteSiteSurvey($request);
                break;
            case 380:
                $this->listTotAmountInvoice($request);
                break;
            case 366:
                $this->createAppOperatione($request);
                break;            
            case 381:
                $this->listAppOperatione($request);
                break;
            case 382:
                $this->updateAppOperatione($request);
                break;
            case 383:
                $this->deleteAppOperatione($request);
                break;
            case 384:
                $this->createAppOffice($request);
                break;            
            case 385:
                $this->listAppOffice($request);
                break;
            case 386:
                $this->updateAppOffice($request);
                break;
            case 387:
                $this->deleteAppOffice($request);
                break;
            case 388:
                $this->createCommentsWO($request);
                break;
            case 389:
                $this->listCommentsWO($request);
                break;
            case 390:
                $this->updateCommentsWO($request);
                break;
            case 391:
                $this->deleteCommentsWO($request);
                break;
            case 392:
                $this->listAllSAR($request);
                break; 
            case 393:
                $this->listAllCSR($request);
                break;
            case 394:
                $this->listAppOfficeGeo($request);
                break;
            case 395:
                $this->listAppOperationeGeo($request);
                break;
            case 396:
                $this->createCommentsApp($request);
                break;
            case 397:
                $this->listCommentsApp($request);
                break;
            case 398:
                $this->updateCommentsApp($request);
                break;
            case 399:
                $this->deleteCommentsApp($request);
                break;
            case 400:
                $this->listWorkOrdersIdQuote($request);
                break;   
            case 401:
                $this->listAWorkOrderCost($request);
                break;  
            case 402:
                $this->listAllPurposeSupplier($request);
                break;
            case 403:
                $this->updateTotalCMP($request);
                break;
            case 404:
                $this->listAllWOCustomized($request);
                break;
            case 405:
                $this->createServiceSubarea($request);
                break;
            case 406:
                $this->listServiceSubarea($request);
                break;
            case 407:
                $this->updateServiceSubarea($request);
                break;
            case 408:
                $this->deleteServiceSubarea($request);
                break;
            case 409:
                $this->listAllCompensation($request);
                break;
            case 410:
                $this->listControlEmployee($request);
                break;
            case 411:
                $this->updateAnniversaryDates($request);
                break;
            case 412:
                $this->updateFollowUpComments($request);
                break;
            case 413:
                $this->listScheduleSSJSClient($request);
                break;
            case 414:
                $this->editInvoice($request);
                break;
            case 415:
                $this->listAllQuote($request);
                break;
            case 416:
                $this->createCommentsInvoice($request);
                break;
            case 417:
                $this->updateCommentsInvoice($request);
                break;
            case 418:
                $this->listCommentsInvoice($request);
                break;
            case 419:
                $this->deleteCommentsInvoice($request);
                break;
            case 420:
                $this->updateDeliveriedToClient($request);
                break;
            case 421:
                $this->updateFollowUpGenerate($request);
                break;
            case 422:
                $this->createUser($request);
                break;
            case 423:
                $this->updateUser($request);
                break;
            case 424:
                $this->listOneUser($request);
                break;
            case 425:
                $this->listUSers($request);
                break;
            case 426:
                $this->deleteUser($request);
                break;
            case 427:
                $this->createNotification($request);
                break;
            case 428:
                $this->listarNotificaciones($request);
                break;
            case 429:
                $this->listarAllNotificaciones($request);
                break;            
            case 430:
                $this->updateNotificacion($request);
                break;
            case 431:
                $this->updateCommentsCSR($request);
                break;
            case 432:
                $this->updateAnniversaryEmployee($request);
                break;
            case 433:
                $this->updateDeliveredToClient($request);
                break;
            case 434:                
                $this->listQuoteSSOCCMPAll($request);
                break;
            case 435:                
                $this->listQuoteSSOCJSAll($request);
                break;
            case 436:                
                $this->updatePriceChange($request);
                break;
            case 437:                
                $this->listAgency($request);
                break;
            case 438:                
                $this->updateClientStatus($request);
                break;
            case 439:
                $this->updateAnniversaryClient($request);
                break;
            case 440:
                $this->listWorkOrderDay($request);
                break;
            case 441:
                $this->updateVacationNotif($request);
                break;
            case 442:
                $this->listEmployeeUnsigne($request);
                break;
            case 443:
                $this->updateWorkOrderClose($request);
                break;
            case 444:
                $this->updateStatusSRF($request);
                break;
            case 445:
                $this->listOneSupplyRequest($request);
                break;
            case 446:
                $this->updateQuantitySRF($request);
                break;
            case 447:
                $this->listSRFWarehouse($request);
                break;
            case 448:
                $this->createNotifScheduled($request);
                break;
            case 449:
                $this->listarNotifScheduled($request);
                break;
            case 450:
                $this->listarAllNotifScheduled($request);
                break;            
            case 451:
                $this->updateNotifScheduled($request);
                break;
            case 452:
                $this->updateNotificacionWO($request);
                break;
            case 453:
                $this->createNotifRenewAgreement($request);
                break;
            case 454:
                $this->listarNotifRenewAgreement($request);
                break;
            case 455:
                $this->listarAllNotifRenewAgreement($request);
                break;            
            case 456:
                $this->updateNotifRenewAgreement($request);
                break;
            case 457:
                $this->updateIDUser($request);
                break;
            case 458:
                $this->listEmployeeUID($request);
                break;
            case 459:
                $this->listUserEmail($request);
                break;
            case 460:
                $this->updatePasswordUser($request);
                break;
            case 461:
                $this->listWorkOrdersDuplicate($request);
                break;
            case 462:
                $this->updateStatusUser($request);
                break;
            case 463:
                $this->updateStatusWareHouse($request);
                break;
            case 464:
                $this->listContactInvoice($request);
                break;
            case 465:
                $this->createCompanyCertificate($request);
                break;
            case 466:
                $this->createCompanyCertificatePDF($request);
                break;
            case 467:
                $this->listCompanyCertificate($request);
                break;
            case 468:
                $this->updateCompanyCertificate($request);
                break;
            case 469:
                $this->deleteCompanyCertificate($request);
                break;
            case 470:
                $this->updateEmployeeEmail($request);
                break;
            case 471:
                $this->updateUserEmail($request);
                break;
            case 472:
                $this->listOnlyServiceArea($request);
                break;
            case 473:
                $this->listOnlyTypeSiteSurvey($request);
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

            case 4001:
                return $this->IntuitShowInvoice($request);
                break;
            case 4002:
                return $this->IntuitCreateInvoice($request);
                break;
            case 4003:
                return $this->IntuitUpdateInvoice($request);
                break;
            case 4004:
                return $this->IntuitDeleteInvoice($request);
                break;
            case 4005:
                return $this->IntuitVoidInvoice($request);
                break;
            case 4006:
                return $this->IntuitPDFInvoice($request);
                break;
            case 4007:
                return $this->IntuitMailInvoice($request);
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

    // Listar ciudades creadas en la base de datos
    public function listarEstratos($rec)
    {
        $db_name = "servicare_sys";
            
        $listarestratos = DB::connection($this->cur_connect)->select(
                                                "select t0.* 
                                                from ".$db_name.'.estratos'." t0 
                                                ORDER BY id DESC"); 
        
        echo json_encode($listarestratos);
    }

    //Datos generales
    public function environmentData($rec)
     {

        DB::beginTransaction();
        try {
            $db_name = "servicare_sys";
                
        $listcountry = DB::connection($this->cur_connect)->select(
                                                "select t0.* 
                                                from ".$db_name.'.country'." t0");

        $listzones = DB::connection($this->cur_connect)->select(
                                                    "select t0.* 
                                                    from ".$db_name.'.zones'." t0 
                                                    ORDER BY description ASC");

        $listcities = DB::connection($this->cur_connect)->select(
                                                        "select t0.* 
                                                        from ".$db_name.'.cities'." t0 
                                                        WHERE t0.codecity > 0 ORDER BY description ASC"); 
                                                        
        $listmunicipalities = DB::connection($this->cur_connect)->select(
                                                        "select t0.* 
                                                        from ".$db_name.'.municipality'." t0 
                                                        WHERE t0.codemunicipality > 0 ORDER BY description ASC"); 

        $liststates = DB::connection($this->cur_connect)->select(
                                                            "select t0.* 
                                                            from ".$db_name.'.status'." t0 
                                                            ORDER BY description ASC");

        $listtypecustomer = DB::connection($this->cur_connect)->select(
                                                                "select t0.* 
                                                                from ".$db_name.'.typecustomer'." t0 
                                                                ORDER BY description DESC");

        $listemployeeprofiles = DB::connection($this->cur_connect)->select(
                                                                "select t0.*
                                                                from ".$db_name.'.employeeprofiles'." t0 
                                                                ORDER BY description ASC");

        $listtypeemployee = DB::connection($this->cur_connect)->select(
                                                                "select t0.*
                                                                from ".$db_name.'.typeemployee'." t0 
                                                                WHERE t0.id > 0
                                                                ORDER BY description ASC");

        $listtypesorder = DB::connection($this->cur_connect)->select(
                                                                "select t0.*
                                                                from ".$db_name.'.typesorder'." t0 
                                                                ORDER BY description ASC");

        $listtypesupplier = DB::connection($this->cur_connect)->select(
                                                                "select t0.*
                                                                from ".$db_name.'.typesupplier'." t0 
                                                                ORDER BY description ASC");

        $listclasscontac = DB::connection($this->cur_connect)->select(
                                                                "select t0.*
                                                                from ".$db_name.'.classcontact'." t0 
                                                                ORDER BY id ASC");

        $listtypesitesurvey = DB::connection($this->cur_connect)->select(
                                                                "select t0.*
                                                                from ".$db_name.'.typesitesurvey'." t0 
                                                                ORDER BY id ASC");


        $listunitcosttrafficJS = DB::connection($this->cur_connect)->select(
                                                                "select t0.*
                                                                from ".$db_name.'.unitcosttrafficJS'." t0 
                                                                ORDER BY id ASC");

        $listsitesurvey = DB::connection($this->cur_connect)->select(
                                                                "select t0.*, t1.description as nametypesitesurvey
                                                                from ".$db_name.'.sitesurvey'." t0 
                                                                JOIN ".$db_name.'.typesitesurvey'." t1 ON t0.type = t1.id
                                                                ORDER BY t0.order ASC");

        $listpartabuildingsummaryjs = DB::connection($this->cur_connect)->select(
                                                                "select t0.*, t2.description as nametypesitesurvey,
                                                                t1.description as namesitesurvey
                                                                from ".$db_name.'.partAbuildingsummaryJS'." t0
                                                                JOIN ".$db_name.'.sitesurvey'." t1 ON t0.sitesurvey = t1.id 
                                                                JOIN ".$db_name.'.typesitesurvey'." t2 ON t1.type = t2.id 
                                                                ORDER BY id ASC");

        $listpartbworkloadingjs = DB::connection($this->cur_connect)->select(
                                                                "select t0.*, t2.description as nametypesitesurvey,
                                                                t1.description as namesitesurvey
                                                                from ".$db_name.'.partBworkloadingJS'." t0
                                                                JOIN ".$db_name.'.sitesurvey'." t1 ON t0.sitesurvey = t1.id 
                                                                JOIN ".$db_name.'.typesitesurvey'." t2 ON t1.type = t2.id 
                                                                ORDER BY t0.id ASC");

        $listselcarpetcondition = DB::connection($this->cur_connect)->select(
                                                                "select t0.*
                                                                from ".$db_name.'.selectcarpetcondition'." t0
                                                                ORDER BY id ASC");

        $listseltrafficcondition = DB::connection($this->cur_connect)->select(
                                                                "select t0.*
                                                                from ".$db_name.'.selecttrafficcondition'." t0
                                                                ORDER BY id ASC");

        $listfibretype = DB::connection($this->cur_connect)->select(
                                                                "select t0.*
                                                                from ".$db_name.'.fibretype'." t0
                                                                ORDER BY id ASC");

        $listpattern = DB::connection($this->cur_connect)->select(
                                                                "select t0.*
                                                                from ".$db_name.'.pattern'." t0
                                                                ORDER BY id ASC");

        $listtexture = DB::connection($this->cur_connect)->select(
                                                                "select t0.*
                                                                from ".$db_name.'.texture'." t0
                                                                ORDER BY id ASC");

        $listinstallationmethod = DB::connection($this->cur_connect)->select(
                                                                "select t0.*
                                                                from ".$db_name.'.installationmethod'." t0
                                                                ORDER BY id ASC");

        $listyesorno = DB::connection($this->cur_connect)->select(
                                                                "select t0.*
                                                                from ".$db_name.'.yesorno'." t0
                                                                ORDER BY id ASC");

        $listquestionstoaskcontact = DB::connection($this->cur_connect)->select(
                                                                "select t0.*
                                                                from ".$db_name.'.questionstoaskcontact'." t0
                                                                ORDER BY id ASC");
    
        $listelementscostpersqft = DB::connection($this->cur_connect)->select(
                                                                "select t0.*
                                                                from ".$db_name.'.elementscostpersqft'." t0
                                                                ORDER BY id ASC");

        $listtypeemployeeprofile = DB::connection($this->cur_connect)->select(
                                                                "select t0.*
                                                                from ".$db_name.'.typeemployeeprofile'." t0
                                                                ORDER BY id ASC");

        $listcategoryindustry = DB::connection($this->cur_connect)->select(
                                                                "select t0.*
                                                                from ".$db_name.'.categoryindustry'." t0
                                                                ORDER BY id ASC");

        $listtypeindustry = DB::connection($this->cur_connect)->select(
                                                                "select t0.*
                                                                from ".$db_name.'.typeindustry'." t0
                                                                ORDER BY id ASC");

        $listjanitorialworkroutines = DB::connection($this->cur_connect)->select(
                                                                "select t0.*
                                                                from ".$db_name.'.janitorialworkroutines'." t0
                                                                ORDER BY id ASC");

        $listscopeofjanitorialwork = DB::connection($this->cur_connect)->select(
                                                                    "select t0.*
                                                                    from ".$db_name.'.scopeofjanitorialwork'." t0
                                                                    ORDER BY id ASC");

        $liststypeaddress = DB::connection($this->cur_connect)->select(
                                                                    "select t0.*
                                                                    from ".$db_name.'.typeaddress'." t0
                                                                    ORDER BY id ASC");

        $listtyperelationshipemployee = DB::connection($this->cur_connect)->select(
                                                                    "select t0.*
                                                                    from ".$db_name.'.typerelationshipemployee'." t0
                                                                    ORDER BY id ASC");

        $listcondition = DB::connection($this->cur_connect)->select(
                                                                    "select t0.*
                                                                    from ".$db_name.'.condition'." t0
                                                                    ORDER BY id ASC");

        $listtypedocuments = DB::connection($this->cur_connect)->select(
                                                                    "select t0.*
                                                                    from ".$db_name.'.typedocuments'." t0
                                                                    ORDER BY id ASC");

        $listrating = DB::connection($this->cur_connect)->select(
                                                                   "select t0.*
                                                                    from ".$db_name.'.clientrating'." t0
                                                                    WHERE t0.id > 0 ORDER BY t0.id ASC"); 
                                                                    
        $listtyperegister = DB::connection($this->cur_connect)->select(
                                                                    "select t0.*
                                                                     from ".$db_name.'.typeregister'." t0
                                                                     ORDER BY id ASC");

        $listtypecompensation = DB::connection($this->cur_connect)->select(
                                                                    "select t0.*
                                                                     from ".$db_name.'.typecompensation'." t0
                                                                     ORDER BY id ASC");

        $listtypecontact = DB::connection($this->cur_connect)->select(
                                                                    "select t0.*
                                                                    from ".$db_name.'.typecontact'." t0
                                                                    ORDER BY id ASC");

        $listtypecleaningcmp = DB::connection($this->cur_connect)->select(
                                                                    "select t0.*
                                                                    from ".$db_name.'.typecleaningcmp'." t0
                                                                    ORDER BY id ASC");

        $listmasterscopeworkcmp = DB::connection($this->cur_connect)->select(
                                                                    "select t0.*, t1.description as nametypecleaningcmp,
                                                                    t1.comments as descriptioncleaningcmp,
                                                                    t2.descriptioncmp as namedescriptioncmp,
                                                                    t3.description as descriptionsitesurvey
                                                                    from ".$db_name.'.masterscopeworkcmp'." t0
                                                                    JOIN ".$db_name.'.typecleaningcmp'." t1 ON t0.typeservicecmp = t1.id
                                                                    JOIN ".$db_name.'.unitcosttrafficJS'." t2 ON t0.idtraffic = t2.id
                                                                    JOIN ".$db_name.'.sitesurvey'." t3 ON t0.typesitesurvey = t3.id
                                                                    ORDER BY id ASC");

        $listtypeworkorder = DB::connection($this->cur_connect)->select(
                                                                    "select t0.*
                                                                    from ".$db_name.'.typeworkorder'." t0
                                                                    ORDER BY id ASC");

        $listmasterrequestform = DB::connection($this->cur_connect)->select(
                                                                        "select t0.*
                                                                        from ".$db_name.'.mastersupplyrequestform'." t0
                                                                        ORDER BY id ASC");

        $listemployeeskilllevel = DB::connection($this->cur_connect)->select(
                                                                        "select t0.*
                                                                        from ".$db_name.'.employeeskilllevel'." t0
                                                                        ORDER BY id ASC");
                                                                    
        $listcompanyprocess = DB::connection($this->cur_connect)->select("select t0.*
                                                                    from ".$db_name.'.companyprocess'." t0 
                                                                    ORDER BY description ASC");

        $listnotificationstype = DB::connection($this->cur_connect)->select("select t0.*
                                                                    from ".$db_name.'.notificationstype'." t0 
                                                                    ORDER BY description ASC");
        
        } catch (\Exception $e){
        
            DB::rollBack();
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
            'listcountry' => $listcountry,
            'listzones' => $listzones,
            'listcities' => $listcities,
            'listmunicipalities' => $listmunicipalities,
            'liststates' => $liststates,
            'listtypecustomer' => $listtypecustomer,
            'listemployeeprofiles' => $listemployeeprofiles,
            'listtypeemployee' => $listtypeemployee,
            'listtypesorder' => $listtypesorder,
            'listtypesupplier' => $listtypesupplier,
            'listclasscontac' => $listclasscontac,
            'listunitcosttrafficJS' => $listunitcosttrafficJS,
            'listtypesitesurvey' => $listtypesitesurvey,
            'listsitesurvey' => $listsitesurvey,
            'listpartabuildingsummaryjs' => $listpartabuildingsummaryjs,
            'listpartbworkloadingjs' => $listpartbworkloadingjs,
            'listtypeemployeeprofile' => $listtypeemployeeprofile,

            'listselcarpetcondition' => $listselcarpetcondition,
            'listseltrafficcondition' => $listseltrafficcondition,
            'listfibretype' => $listfibretype,
            'listpattern' => $listpattern,
            'listtexture' => $listtexture,
            'listinstallationmethod' => $listinstallationmethod,
            'listyesorno' => $listyesorno,
            'listquestionstoaskcontact' => $listquestionstoaskcontact,
            'listelementscostpersqft' => $listelementscostpersqft,
            'listtypeindustry' => $listtypeindustry,
            'listcategoryindustry' => $listcategoryindustry,
            'listjanitorialworkroutines' => $listjanitorialworkroutines,
            'listscopeofjanitorialwork' => $listscopeofjanitorialwork,
            'liststypeaddress' => $liststypeaddress,
            'listtyperelationshipemployee' => $listtyperelationshipemployee,
            'listcondition' => $listcondition,
            'listtypedocuments' => $listtypedocuments,
            'listrating' => $listrating,
            'listtyperegister' => $listtyperegister,
            'listtypecompensation' => $listtypecompensation,
            'listtypecontact' => $listtypecontact,
            'listtypecleaningcmp' => $listtypecleaningcmp,
            'listmasterscopeworkcmp' => $listmasterscopeworkcmp,
            'listtypeworkorder'=> $listtypeworkorder,
            'listmasterrequestform' => $listmasterrequestform,
            'listemployeeskilllevel' => $listemployeeskilllevel,
            'listcompanyprocess' => $listcompanyprocess,
            'listnotificationstype' => $listnotificationstype,
            
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

    public function Categorias($rec)
    {   
        $db_name = "servicare_sys";

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

    public function TipoVehiculos($rec)
    {
        $db_name = "servicare_sys";

        $tiposvehiculos = DB::connection($this->cur_connect)->select("select t0.* from ".$db_name.'.tiposvehiculos'." t0 WHERE t0.estado = 1 ORDER BY orden ASC");

        $tiposvehi = array();

        $datoc = [
                    'header_supplies' => $tiposvehiculos
                ];
                $tiposvehi[] = $datoc;

        echo json_encode($tiposvehi);
    }

    public function TipoIdentificacion($rec)
    {
        DB::beginTransaction();
        try {
            $db_name = "servicare_sys";
                
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

    //Create client
    public function createClient($rec)
    {

        DB::beginTransaction();
        try {
                    $db_name = $this->db.".clients";
                    $createClient = new ModelGlobal();
                    $createClient->setConnection($this->cur_connect);
                    $createClient->setTable($db_name);

                    $createClient->customertype = $rec->customertype;
                    $createClient->industrytype = $rec->industrytype;
                    $createClient->paymentmethod = $rec->paymentmethod;
                    $createClient->names = $rec->names;
                    $createClient->surnames = $rec->surnames;
                    $createClient->businessname = $rec->businessname;
                    $createClient->mail = $rec->mail;
                    $createClient->commercialadvisor = $rec->commercialadvisor;
                    $createClient->accountmanager = $rec->accountmanager;
                    $createClient->adduser = $rec->adduser;
                    $createClient->updateuser = $rec->updateuser;
                    $createClient->numberfax = $rec->numberfax;
                    $createClient->extension = $rec->extension;
                    $createClient->anniversarydates = $rec->anniversarydates;

                    $createClient->father = $rec->father;
                    $createClient->isfather = $rec->isfather;
                    $createClient->abbreviation = $rec->abbreviation;
                    $createClient->rating = $rec->rating;
                    $createClient->creationdate = $date = date('Y-m-d H:i:s');
                    $createClient->updatedate = $date = date('Y-m-d H:i:s'); 
                    $createClient->lastvisitdate = $rec->lastvisitdate;
                    $createClient->businessphone = $rec->businessphone;
                    $createClient->cellphone = $rec->cellphone;
                    $createClient->status = $rec->status;
                    $createClient->comments = $rec->comments;
                    $createClient->commentspaymethod = $rec->commentspaymethod;

                    $createClient->save();

        } catch (\Exception $e){

            DB::rollBack();
            $response = array(
                'type' => '0',
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

    // Listar cliente
    public function listClients($rec)
    {
        //echo json_encode($rec->idinterno);
        //exit;
        DB::beginTransaction();
        try {
            $db_name = "servicare_sys";
                
        $listclients = DB::connection($this->cur_connect)->select(
                                                "select t0.*, t1.description as namemethodpay, t2.uid, t3.uidemp
                                                from ".$db_name.'.clients'." t0
                                                JOIN ".$db_name.'.paymentmethods'." t1 ON t0.paymentmethod = t1.id
                                                JOIN ".$db_name.'.employee'." t2 ON t0.accountmanager = t2.id
                                                JOIN ".$db_name.'.viewemployee'." t3 ON t0.commercialadvisor = t3.idemp
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
            'listclients' => $listclients,
            'message' => 'REGISTRO EXITOSO',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    // Listar un cliente
    public function listAClient($rec)
    {
        //echo json_encode($rec->idinterno);
        //exit;
        DB::beginTransaction();
        try {
            $db_name = "servicare_sys";
                
        $listclients = DB::connection($this->cur_connect)->select(
                                                "select t0.*, t0.comments as commentsclient, t0.id as idclient,
                                                 t1.description as namecustomertype,
                                                 t2.description as namemethodpay
                                                from ".$db_name.'.clients'." t0
                                                JOIN ".$db_name.'.typecustomer'." t1 ON t0.customertype = t1.id
                                                JOIN ".$db_name.'.paymentmethods'." t2 ON t0.paymentmethod = t2.id
                                                WHERE t0.id = '".$rec->idclient."'
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
            'listclients' => $listclients,
            'message' => 'REGISTRO EXITOSO',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    //Listar clientes padres
    public function listClientFather($rec)
    {
        //echo json_encode($rec->idinterno);
        //exit;
        DB::beginTransaction();
        try {
            $db_name = "servicare_sys";
                
        $listclients = DB::connection($this->cur_connect)->select(
                                                "select t0.*, t1.description as namecustomertype,
                                                 t2.description as namemethodpay, t3.description as namestatus
                                                from ".$db_name.'.clients'." t0
                                                JOIN ".$db_name.'.typecustomer'." t1 ON t0.customertype = t1.id
                                                JOIN ".$db_name.'.paymentmethods'." t2 ON t0.paymentmethod = t2.id
                                                JOIN ".$db_name.'.status'." t3 ON t0.status = t3.id
                                                WHERE t0.father = 0
                                                  AND t0.status in (1,3)
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
            'listclients' => $listclients,
            'message' => 'REGISTRO EXITOSO',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    // Listar clientes hijos
    public function listClientChildren($rec)
    {
        //echo json_encode($rec->idinterno);
        //exit;
        DB::beginTransaction();
        try {
            $db_name = "servicare_sys";
                
        $listclients = DB::connection($this->cur_connect)->select(
                                                "select t0.*, t1.description as namecustomertype,
                                                 t2.description as namemethodpay,t3.description as namestatus,
                                                 t5.description as namecity, t6.description as namemunicipality
                                                from ".$db_name.'.clients'." t0
                                                JOIN ".$db_name.'.typecustomer'." t1 ON t0.customertype = t1.id
                                                JOIN ".$db_name.'.paymentmethods'." t2 ON t0.paymentmethod = t2.id
                                                JOIN ".$db_name.'.status'." t3 ON t0.status = t3.id
                                                JOIN ".$db_name.'.addressclient'." t4 ON t0.id = t4.idclient
                                                JOIN ".$db_name.'.cities'." t5 ON t4.city = t5.id
                                                JOIN ".$db_name.'.municipality'." t6 ON t4.municipality = t6.id      
                                                WHERE t0.father > 0
                                                  AND t4.typeaddress = 1
                                                  AND t0.status in (1,3)
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
            'listclients' => $listclients,
            'message' => 'REGISTRO EXITOSO',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    // Listar un cliente
    public function listClientFatherAndSon($rec)
    {
        //echo json_encode($rec->idinterno);
        //exit;
        DB::beginTransaction();
        try {
            $db_name = "servicare_sys";
                
        $listclients = DB::connection($this->cur_connect)->select(
                                                "select t0.* 
                                                from ".$db_name.'.clients'." t0
                                                WHERE t0.father = '".$rec->idfather."'
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
            'listclients' => $listclients,
            'message' => 'REGISTRO EXITOSO',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    //Actualizar dirección del usuario
    public function updateClients($rec)
    {
        //echo json_encode($rec->id);
        //exit;
        $db_name = $this->db.".clients";
   
        DB::beginTransaction();
        try {
   
              DB::connection($this->cur_connect)->update("UPDATE ".$db_name." 
                  SET mail = '".$rec-> mail."',
                      customertype = '".$rec-> customertype."',
                      businessname = '".$rec-> businessname."',
                      names = '".$rec-> names."',
                      surnames = '".$rec-> surnames."',
                      industrytype = '".$rec-> industrytype."',
                      paymentmethod = '".$rec->paymentmethod."',
                      quickbookid = '".$rec->quickbookid."',
                      rating = '".$rec-> rating."',
                      abbreviation = '".$rec-> abbreviation."',
                      businessphone = '".$rec-> businessphone."',
                      commercialadvisor = '".$rec-> commercialadvisor."',cellphone = '".$rec-> cellphone."',
                      accountmanager = '".$rec-> accountmanager."',
                      father = '".$rec-> father."',
                      isfather = '".$rec-> isfather."',
                      cellphone = '".$rec-> cellphone."',
                      extension = '".$rec-> extension."',
                      numberfax = '".$rec-> numberfax."',
                      updateuser = '".$rec-> updateuser."',
                      lastvisitdate = '".$rec-> lastvisitdate."',
                      updatedate = '".$date = date('Y-m-d H:i:s')."',
                      status = '".$rec-> status."',
                      idcomment = '".$rec-> idcomment."',
                      commentreason = '".$rec-> commentreason."',
                      anniversarydates = '".$rec-> anniversarydates."',
                      comments = '".$rec-> comments."'
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

    //Actualizar dirección del usuario
    public function updatePaymentMethodClient($rec)
    {
        //echo json_encode($rec->id);
        //exit;
        $db_name = $this->db.".clients";
   
        DB::beginTransaction();
        try {
   
              DB::connection($this->cur_connect)->update("UPDATE ".$db_name." 
                  SET paymentmethod = '".$rec-> paymentmethod."',
                      purchaseorder = '".$rec-> purchaseorder."',
                      mailpayment = '".$rec-> mailpayment."',
                      commentspaymethod = '".$rec-> commentspaymethod."'
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

    //Actualizar dirección del usuario
    public function updateAnniversaryDates($rec)
    {
        //echo json_encode($rec->id);
        //exit;
        $db_name = $this->db.".clients";
   
        DB::beginTransaction();
        try {
   
              DB::connection($this->cur_connect)->update("UPDATE ".$db_name." 
                    SET anniversarydates = '".$rec-> anniversarydates."'
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

    //Actualizar dirección del usuario
    public function updateAnniversaryClient($rec)
    {
        //echo json_encode($rec->id);
        //exit;
        $db_name = $this->db.".clients";
   
        DB::beginTransaction();
        try {
   
              DB::connection($this->cur_connect)->update("UPDATE ".$db_name." 
                    SET anniversary = '".$rec-> anniversary."'
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

    //Actualizar deliveriedtoclient 
    public function updateDeliveriedToClient($rec)
    {
        //echo json_encode($rec->id);
        //exit;
        $db_name = $this->db.".clients";
   
        DB::beginTransaction();
        try {
   
              DB::connection($this->cur_connect)->update("UPDATE ".$db_name." 
                    SET deliveriedtoclient = '".$rec-> deliveriedtoclient."'
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

    //Actualizar dirección del usuario
    public function updateFollowUpGenerate($rec)
    {
        //echo json_encode($rec->id);
        //exit;
        $db_name = $this->db.".clients";
   
        DB::beginTransaction();
        try {
   
              DB::connection($this->cur_connect)->update("UPDATE ".$db_name." 
                    SET followupgenerate = '".$rec-> followupgenerate."'
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

    //Actualizar dirección del usuario
    public function updateCommentClient($rec)
    {
        //echo json_encode($rec->id);
        //exit;
        $db_name = $this->db.".clients";
   
        DB::beginTransaction();
        try {
   
              DB::connection($this->cur_connect)->update("UPDATE ".$db_name." 
                    SET idinvoice = '".$rec-> idinvoice."',
                        commentinvoice = '".$rec-> commentinvoice."'
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

    //Create client
    public function createSupplier($rec)
    {

        DB::beginTransaction();
        try {
                    $db_name = $this->db.".supplier";
                    $createSupplier = new ModelGlobal();
                    $createSupplier->setConnection($this->cur_connect);
                    $createSupplier->setTable($db_name);

                    $createSupplier->suppliertype = $rec->suppliertype;
                    $createSupplier->names = $rec->names;
                    $createSupplier->surnames = $rec->surnames;
                    $createSupplier->businessname = $rec->businessname;
                    $createSupplier->mail = $rec->mail;
                    $createSupplier->address = $rec->address;
                    $createSupplier->addresstwo = $rec->addresstwo;
                    $createSupplier->zone = $rec->zone;
                    $createSupplier->country = $rec->country;
                    $createSupplier->city = $rec->city;
                    $createSupplier->postalcode = $rec->postalcode;
                    $createSupplier->idprocess = $rec->idprocess;

                    $createSupplier->contact = $rec->contact;
                    $createSupplier->faxnumber = $rec->faxnumber;
                    $createSupplier->purpose = $rec->purpose;

                    //$createSupplier->creationdate = $rec->creationdate;
                    $createSupplier->creationdate = $date = date('Y-m-d H:i:s');
                    $createSupplier->phone = $rec->phone;
                    $createSupplier->status = $rec->status;
                    $createSupplier->comments = $rec->comments;

                    $createSupplier->save();

        } catch (\Exception $e){

            DB::rollBack();
            $response = array(
                'type' => '0',
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

    // Listar supplier
    public function listSupplier($rec)
    {
        //echo json_encode($rec->idinterno);
        //exit;
        DB::beginTransaction();
        try {
            $db_name = "servicare_sys";
                
        $listsupplier = DB::connection($this->cur_connect)->select(
                                                "select t1.*, t0.comments as commentssupplies, t0.*
                                                from ".$db_name.'.supplier'." t0
                                                JOIN ".$db_name.'.companyprocess'." t1 ON t0.idprocess = t1.id
                                                Where t0.status != 2
                                                  and t0.status != 13
                                                  and t0.id > 0");

        } catch (\Exception $e){
        
            DB::rollBack();
            $response = array(
                'type' => '0',
                'message' => "ERROR ".$e
            );
            $rec->headers->set('Accept', 'application/json');
            echo json_encode($response);
            exit;
        }
        DB::commit();
        $response = array(
            'type' => 1,
            'listsupplier' => $listsupplier,
            'message' => 'REGISTRO EXITOSO',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    // Listar supplier
    public function listAgency($rec)
    {
        //echo json_encode($rec->idinterno);
        //exit;
        DB::beginTransaction();
        try {
            $db_name = "servicare_sys";
                
        $listsupplier = DB::connection($this->cur_connect)->select(
                                                "select t0.*, t1.*, t0.comments as commentssupplies,
                                                t0.id as idcompany
                                                from ".$db_name.'.supplier'." t0
                                                JOIN ".$db_name.'.companyprocess'." t1 ON t0.idprocess = t1.id
                                                Where t0.id > 0
                                                  AND t0.suppliertype = 1");

        } catch (\Exception $e){
        
            DB::rollBack();
            $response = array(
                'type' => '0',
                'message' => "ERROR ".$e
            );
            $rec->headers->set('Accept', 'application/json');
            echo json_encode($response);
            exit;
        }
        DB::commit();
        $response = array(
            'type' => 1,
            'listsupplier' => $listsupplier,
            'message' => 'REGISTRO EXITOSO',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }


    //Actualizar dirección del usuario
    public function updateSupplier($rec)
    {
        //echo json_encode($rec->id);
        //exit;
        $db_name = $this->db.".supplier";
   
        DB::beginTransaction();
        try {
   
              DB::connection($this->cur_connect)->update("UPDATE ".$db_name." 
                  SET mail = '".$rec-> mail."',
                      suppliertype = '".$rec-> suppliertype."',
                      address = '".$rec-> address."',
                      zone   = '".$rec-> zone."',
                      country = '".$rec-> country."',
                      city = '".$rec-> city."',
                      idprocess = '".$rec-> idprocess."',
                      postalcode = '".$rec-> postalcode."',
                      contact = '".$rec-> contact."',
                      faxnumber = '".$rec-> faxnumber."',
                      purpose = '".$rec-> purpose."',
                      phone = '".$rec-> phone."',  
                      businessname = '".$rec-> businessname."',  
                      mail = '".$rec-> mail."',  
                      addresstwo = '".$rec-> addresstwo."',  
                      comments = '".$rec-> comments."',
                      document = '".$rec-> nombreimagen1."',
                      status = '".$rec-> status."'
                  WHERE id = '".$rec->id."'");

                    //Imagen base 64 se pasa a un arreglo
                    $nombrefoto[1] = $rec->nombreimagen1;
                    $foto[1] = $rec->imagen1;

                    for ($i = 1; $i <= $rec->numerodeimagenes; $i++) {
                        $response = FunctionsCustoms::UploadPDFName($foto[$i],$nombrefoto[1],'servicaredocuments/');
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

    //Create Site Inventory Machine
    public function updateSupplierPDF($rec)
    {
        DB::beginTransaction();
        try {
                    $db_name = $this->db.".supplier";
                    $createsiteinventory = new ModelGlobal();
                    $createsiteinventory->setConnection($this->cur_connect);
                    $createsiteinventory->setTable($db_name);

                    //Imagen base 64 se pasa a un arreglo
                    $nombrefoto[1] = $rec->nombreimagen1;
                    $foto[1] = $rec->imagen1;

                    for ($i = 1; $i <= $rec->numerodeimagenes; $i++) {
                        $response = FunctionsCustoms::UploadPDFName($foto[$i],$nombrefoto[1],'servicaredocuments/');
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
            'message' => 'UPDATE SUPPLIER',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    //Create client
    public function createContracts($rec)
    {

        DB::beginTransaction();
        try {
                    $db_name = $this->db.".contracts";
                    $createContract = new ModelGlobal();
                    $createContract->setConnection($this->cur_connect);
                    $createContract->setTable($db_name);

                    $createContract->codecontract = $rec->codecontract;
                    $createContract->client = $rec->client;
                    $createContract->commercialadvisor = $rec->commercialadvisor;
                    $createContract->signaturedate = $date = date('Y-m-d H:i:s');
                    $createContract->signaturestart = $rec->signaturestart;
                    $createContract->signatureend = $rec->signatureend;
                    $createContract->city = $rec->city;
                    $createContract->valuecontract = $rec->valuecontract;
                    $createContract->valuemonth = $rec->valuemonth;
                    $createContract->increasedate = $rec->increasedate;
                    $createContract->finishdate = $rec->finishdate;
                    $createContract->billingday = $rec->billingday;
                    $createContract->status = $rec->status;
                    $createContract->comments = $rec->comments;

                    $createContract->save();

        } catch (\Exception $e){

            DB::rollBack();
            $response = array(
                'type' => '0',
                'message' => "ERROR ".$e
            );
            $rec->headers->set('Accept', 'application/json');
            echo json_encode($response);
            exit;
        }
        DB::commit();
        $response = array(
            'type' => 1,
            'message' => 'REGISTER CONTRACT',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    // Listar contratos
    public function listContracts($rec)
    {
        //echo json_encode($rec->idinterno);
        //exit;
        DB::beginTransaction();
        try {
            $db_name = "servicare_sys";
                
        $listcontracts = DB::connection($this->cur_connect)->select(
                                                "select t0.* 
                                                from ".$db_name.'.contracts'." t0");

        } catch (\Exception $e){
        
            DB::rollBack();
            $response = array(
                'type' => '0',
                'message' => "ERROR ".$e
            );
            $rec->headers->set('Accept', 'application/json');
            echo json_encode($response);
            exit;
        }
        DB::commit();
        $response = array(
            'type' => 1,
            'listcontracts' => $listcontracts,
            'message' => 'LIST CONTRACTS OK',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    // Listar contratos
    public function listAContracts($rec)
    {
        //echo json_encode($rec->idinterno);
        //exit;
        DB::beginTransaction();
        try {
            $db_name = "servicare_sys";
                
        $listcontracts = DB::connection($this->cur_connect)->select(
                                                "select t0.* 
                                                from ".$db_name.'.contracts'." t0
                                                WHERE t0.id = '".$rec->idcontract."'
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
            'listcontracts' => $listcontracts,
            'message' => 'LIST CONTRACTS OK',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    //Actualizar dirección del usuario
    public function updateContracts($rec)
    {
        //echo json_encode($rec->id);
        //exit;
        $db_name = $this->db.".contracts";
   
        DB::beginTransaction();
        try {
   
              DB::connection($this->cur_connect)->update("UPDATE ".$db_name." 
                  SET commercialadvisor = '".$rec-> commercialadvisor."',
                      signaturestart = '".$rec-> signaturestart."',
                      signatureend = '".$rec-> signatureend."',
                      city = '".$rec-> city."',
                      valuecontract = '".$rec-> valuecontract."',
                      valuemonth = '".$rec-> valuemonth."',
                      increasedate = '".$rec-> increasedate."',
                      billingday = '".$rec-> billingday."',
                      finishdate = '".$rec-> finishdate."',
                      status = '".$rec-> status."',
                      comments = '".$rec-> comments."'
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
               'message' => 'UPDATED CONTRACTS OK'
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    //Create client
    public function createEmployee($rec)
    {

        DB::beginTransaction();
        try {
                    $db_name = $this->db.".employee";
                    $createEmployee = new ModelGlobal();
                    $createEmployee->setConnection($this->cur_connect);
                    $createEmployee->setTable($db_name);

                    $createEmployee->sin = $rec->sin;
                    $createEmployee->employeetype = $rec->employeetype;
                    $createEmployee->classifications = $rec->classifications;
                    $createEmployee->firstname = $rec->firstname;
                    $createEmployee->lastname = $rec->lastname;
                    $createEmployee->middlename = $rec->middlename;
                    $createEmployee->city = $rec->city;
                    $createEmployee->municipality = $rec->municipality;
                    $createEmployee->province = $rec->province;
                    $createEmployee->country = $rec->country;
                    $createEmployee->address = $rec->address;
                    $createEmployee->addresstwo = $rec->addresstwo;
                    $createEmployee->mainintersection = $rec->mainintersection;
                    $createEmployee->mainintersection2 = $rec->mainintersection2;
                    $createEmployee->phone = $rec->phone;
                    $createEmployee->mail = $rec->mail;
                    $createEmployee->mailaccount = $rec->mailaccount;
                    
                    $createEmployee->uid = $rec->uid;
                    $createEmployee->rating = $rec->rating; 
                    $createEmployee->dateofbirth = $rec->dateofbirth;
                    $createEmployee->dependents = $rec->dependents;
                    $createEmployee->company = $rec->company;
                    $createEmployee->employeeprofile = $rec->employeeprofile;
                    $createEmployee->classemployee = $rec->classemployee;
                    $createEmployee->creationdate = $date = date('Y-m-d H:i:s');
                    $createEmployee->modificationdate = $date = date('Y-m-d H:i:s');
                    $createEmployee->employeestartdate = $rec->employeestartdate;
                    $createEmployee->status = $rec->status;
                    $createEmployee->comments = $rec->comments;

                    $createEmployee->save();

        } catch (\Exception $e){

            DB::rollBack();
            $response = array(
                'type' => '0',
                'message' => "ERROR ".$e
            );
            $rec->headers->set('Accept', 'application/json');
            echo json_encode($response);
            exit;
        }
        DB::commit();
        $response = array(
            'type' => 1,
            'message' => 'REGISTER EMPLOYEE',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    // Listar empleados
    public function listAllEmployees($rec)
    {
        //echo json_encode($rec->idinterno);
        //exit;
        DB::beginTransaction();
        try {
            $db_name = "servicare_sys";
                
        $listallemployees = DB::connection($this->cur_connect)->select(
                                                "select t0.*
                                                from ".$db_name.'.employee'." t0
                                                WHERE t0.id > 0
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
            'listallemployees' => $listallemployees,
            'message' => 'LIST CONTRACTS OK',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    // Listar empleados
    public function listEmployee($rec)
    {
        //echo json_encode($rec->idinterno);
        //exit;
        DB::beginTransaction();
        try {
            $db_name = "servicare_sys";
                
        $listofemployees = DB::connection($this->cur_connect)->select(
                                                "select t0.*, t0.id as idemp,  t1.description as ratingemployee,
                                                t2.businessname, t3.description as nameprofile,
                                                t4.description as nametypeemployee,
                                                t5.description as nameclassemployee
                                                from ".$db_name.'.employee'." t0
                                                JOIN ".$db_name.'.employeeskilllevel'." t1 ON t0.rating = t1.id
                                                JOIN ".$db_name.'.supplier'." t2 ON t0.company = t2.id
                                                JOIN ".$db_name.'.employeeprofiles'." t3 ON t0.employeeprofile = t3.id
                                                JOIN ".$db_name.'.typeemployee'." t4 ON t0.employeetype = t4.id
                                                JOIN ".$db_name.'.employeeclassifications'." t5 ON t0.classemployee = t5.id
                                                WHERE t0.id > 0
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
            'listofemployees' => $listofemployees,
            'message' => 'LIST CONTRACTS OK',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    // Listar empleados
    public function listEmployeeUnsigne($rec)
    {
        //echo json_encode($rec->idinterno);
        //exit;
        DB::beginTransaction();
        try {
            $db_name = "servicare_sys";
                
        $listofemployees = DB::connection($this->cur_connect)->select(
                                                "select t0.*, t0.id as idemp,  t1.description as ratingemployee,
                                                t2.businessname, t3.description as nameprofile,
                                                t4.description as nametypeemployee,
                                                t5.description as nameclassemployee
                                                from ".$db_name.'.employee'." t0
                                                JOIN ".$db_name.'.employeeskilllevel'." t1 ON t0.rating = t1.id
                                                JOIN ".$db_name.'.supplier'." t2 ON t0.company = t2.id
                                                JOIN ".$db_name.'.employeeprofiles'." t3 ON t0.employeeprofile = t3.id
                                                JOIN ".$db_name.'.typeemployee'." t4 ON t0.employeetype = t4.id
                                                JOIN ".$db_name.'.employeeclassifications'." t5 ON t0.classemployee = t5.id
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
            'listofemployees' => $listofemployees,
            'message' => 'LIST CONTRACTS OK',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    // Listar empleados
    public function listAEmployee($rec)
    {
        //echo json_encode($rec->idinterno);
        //exit;
        DB::beginTransaction();
        try {
            $db_name = "servicare_sys";
                
        $listaemployee = DB::connection($this->cur_connect)->select(
                                                "select t0.*, t1.businessname , t2.description as nameprofile
                                                from ".$db_name.'.employee'." t0
                                                JOIN ".$db_name.'.supplier'." t1 ON t0.company = t1.id
                                                JOIN ".$db_name.'.employeeprofiles'." t2 ON t0.employeeprofile = t2.id
                                                WHERE t0.id = '".$rec->idemployee."'
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
            'listaemployee' => $listaemployee,
            'message' => 'LIST CONTRACTS OK',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    // Listar empleados
    public function listEmployeeUID($rec)
    {
        //echo json_encode($rec->idinterno);
        //exit;
        DB::beginTransaction();
        try {
            $db_name = "servicare_sys";
                
        $listaemployee = DB::connection($this->cur_connect)->select(
                                                "select t0.*
                                                from ".$db_name.'.employee'." t0
                                                WHERE t0.uid = '".$rec->uidemployee."'
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
            'listaemployee' => $listaemployee,
            'message' => 'LIST CONTRACTS OK',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    //Actualizar dirección del usuario
    public function updateEmployee($rec)
    {
        //echo json_encode($rec->id);
        //exit;
        $db_name = $this->db.".employee";
   
        DB::beginTransaction();
        try {
   
              DB::connection($this->cur_connect)->update("UPDATE ".$db_name." 
                    SET modificationdate = '".$date = date('Y-m-d H:i:s')."',
                        sin = '".$rec-> sin."',
                        employeetype = '".$rec-> employeetype."',
                        firstname = '".$rec-> firstname."',
                        lastname = '".$rec-> lastname."',
                        middlename = '".$rec-> middlename."',
                        dateofbirth = '".$rec-> dateofbirth."',
                        address = '".$rec-> address."',
                        addresstwo = '".$rec-> addresstwo."',
                        mainintersection = '".$rec-> mainintersection."',
                        mainintersection2 = '".$rec-> mainintersection2."',
                        city = '".$rec-> city."',
                        municipality = '".$rec-> municipality."',
                        classemployee = '".$rec-> classemployee."',
                        province = '".$rec-> province."',
                        country = '".$rec-> country."',
                        latitud = '".$rec-> latitud."',
                        longitud = '".$rec-> longitud."',
                        addressgeolocation = '".$rec-> addressgeolocation."',
                        status = '".$rec-> status."',
                        postalcode= '".$rec-> postalcode."',
                        phone= '".$rec-> phone."',
                        company= '".$rec-> company."',
                        employeestartdate = '".$rec-> employeestartdate."',
                        mail= '".$rec-> mail."',
                        rating= '".$rec-> rating."',
                        comments = '".$rec-> comments."'
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
               'message' => 'UPDATED CONTRACTS OK'
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    //Actualizar dirección del usuario
    public function updateEmployeeEmail($rec)
    {
        //echo json_encode($rec->id);
        //exit;
        $db_name = $this->db.".employee";
   
        DB::beginTransaction();
        try {
   
              DB::connection($this->cur_connect)->update("UPDATE ".$db_name." 
                  SET mailaccount = '".$rec-> mailaccount."'
                   WHERE id = '".$rec->idemployee."'");
   
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
               'message' => 'UPDATED WORK ORDER OK'
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

     //Actualizar dirección del usuario
     public function updateUserEmail($rec)
     {
         //echo json_encode($rec->id);
         //exit;
         $db_name = $this->db.".users";
    
         DB::beginTransaction();
         try {
    
               DB::connection($this->cur_connect)->update("UPDATE ".$db_name." 
                   SET email = '".$rec-> email."'
                    WHERE id = '".$rec->iduser."'");
    
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
                'message' => 'UPDATED WORK ORDER OK'
         );
         $rec->headers->set('Accept', 'application/json');
         echo json_encode($response);
         exit;
     }

    //Create client
    public function createWorkingHours($rec)
    {

        DB::beginTransaction();
        try {
                    $db_name = $this->db.".workinghours";
                    $workinghours = new ModelGlobal();
                    $workinghours->setConnection($this->cur_connect);
                    $workinghours->setTable($db_name);

                    $workinghours->employee = $rec->employee;
                    $workinghours->supplier = $rec->supplier;
                    $workinghours->city = $rec->city;
                    $workinghours->starttime = $rec->starttime;
                    $workinghours->finalhour = $rec->finalhour;
                    $workinghours->day = $rec->day;
                    $workinghours->status = $rec->status;
                    $workinghours->comments = $rec->comments;

                    $workinghours->save();

        } catch (\Exception $e){

            DB::rollBack();
            $response = array(
                'type' => '0',
                'message' => "ERROR ".$e
            );
            $rec->headers->set('Accept', 'application/json');
            echo json_encode($response);
            exit;
        }
        DB::commit();
        $response = array(
            'type' => 1,
            'message' => 'REGISTER WORKING HOURS',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    // Listar cliente
    public function listWorkingHours($rec)
    {
        //echo json_encode($rec->idinterno);
        //exit;
        DB::beginTransaction();
        try {
            $db_name = "servicare_sys";
                
        $listworkinghours = DB::connection($this->cur_connect)->select(
                                                "select t0.* 
                                                from ".$db_name.'.workinghours'." t0
                                                JOIN ".$db_name.'.daydescription'." t1 ON t0.day = t1.day
                                                WHERE t0.employee = '". $rec->idemployee."'
                                                  AND t0.status in (4,5,6)
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
            'listworkinghours' => $listworkinghours,
            'message' => 'LIST CONTRACTS OK',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    // Listar cliente
    public function listWorkingHoursDay($rec)
    {
        //echo json_encode($rec->idinterno);
        //exit;
        DB::beginTransaction();
        try {
            $db_name = "servicare_sys";
                
        $listworkinghoursday = DB::connection($this->cur_connect)->select(
                                                "select t0.* 
                                                from ".$db_name.'.workinghours'." t0
                                                JOIN ".$db_name.'.daydescription'." t1 ON t0.day = t1.day
                                                WHERE t0.employee = '". $rec->idemployee."'
                                                  AND t0.day = '". $rec->day."'
                                                  AND t0.status in (4,5,6)
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
            'listworkinghoursday' => $listworkinghoursday,
            'message' => 'LIST CONTRACTS OK',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    //Actualizar dirección del usuario
    public function updateWorkingHours($rec)
    {
        //echo json_encode($rec->id);
        //exit;
        $db_name = $this->db.".workinghours";

        DB::beginTransaction();
        try {

            DB::connection($this->cur_connect)->update("UPDATE ".$db_name." 
                SET day = '".$rec-> day."',
                    starttime = '".$rec-> starttime."',
                    finalhour = '".$rec-> finalhour."',
                    status = '".$rec-> status."',
                    comments = '".$rec-> comments."'
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
            'message' => 'UPDATED CONTRACTS OK'
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    //Delete Workin Hours
    public function deleteWorkingHours($rec)
    {
        $db_name = $this->db.".workinghours";

        DB::beginTransaction();
        try {

            DB::connection($this->cur_connect)->delete("DELETE FROM ".$db_name."
            WHERE employee = '". $rec->idemployee."'
              AND day = '". $rec->day."'");

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

    //Create Contact
    public function createContact($rec)
    {

        DB::beginTransaction();
        try {
                    $db_name = $this->db.".contacts";
                    $createcontact = new ModelGlobal();
                    $createcontact->setConnection($this->cur_connect);
                    $createcontact->setTable($db_name);

                    $createcontact->idclient = $rec->idclient;
                    $createcontact->typecontact = $rec->typecontact;
                    $createcontact->names = $rec->names;
                    $createcontact->surnames = $rec->surnames;
                    $createcontact->contactposition = $rec->contactposition;
                    $createcontact->mail = $rec->mail;
                    $createcontact->emergency = $rec->emergency;
                    $createcontact->contactinvoice = $rec->contactinvoice;
                    $createcontact->cellphone = $rec->cellphone;
                    $createcontact->extension = $rec->extension;
                    $createcontact->creationdate = $date = date('Y-m-d H:i:s');
                    $createcontact->status = $rec->status;
                    $createcontact->comments = $rec->comments;

                    $createcontact->save();

        } catch (\Exception $e){

            DB::rollBack();
            $response = array(
                'type' => '0',
                'message' => "ERROR ".$e
            );
            $rec->headers->set('Accept', 'application/json');
            echo json_encode($response);
            exit;
        }
        DB::commit();
        $response = array(
            'type' => 1,
            'message' => 'REGISTER CONTACTS',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    // Listar cliente
    public function listContact($rec)
    {
        //echo json_encode($rec->idinterno);
        //exit;
        DB::beginTransaction();
        try {
            $db_name = "servicare_sys";
                
        $liscontact = DB::connection($this->cur_connect)->select(
                                                            "select t0.*, t1.description
                                                            from ".$db_name.'.contacts'." t0
                                                            JOIN ".$db_name.'.status'." t1 ON t0.status = t1.id
                                                            WHERE t0.idclient = '".$rec->idclient."'
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
            'liscontact' => $liscontact,
            'message' => 'LIST CONTRACTS OK',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    // Listar cliente
    public function listContactInvoice($rec)
    {
        //echo json_encode($rec->idinterno);
        //exit;
        DB::beginTransaction();
        try {
            $db_name = "servicare_sys";
                
        $liscontact = DB::connection($this->cur_connect)->select(
                                                            "select t0.*, t1.description
                                                            from ".$db_name.'.contacts'." t0
                                                            JOIN ".$db_name.'.status'." t1 ON t0.status = t1.id
                                                            WHERE t0.contactinvoice = 1
                                                              AND t0.idclient = '".$rec->idclient."'
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
            'liscontact' => $liscontact,
            'message' => 'LIST CONTRACTS OK',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    // Listar cliente
    public function listAddressClient($rec)
    {
        //echo json_encode($rec->idinterno);
        //exit;
        DB::beginTransaction();
        try {
            $db_name = "servicare_sys";
                
        $listaddressclient = DB::connection($this->cur_connect)->select(
                                                            "select t0.id, t0.servicesaddress, t0.servicesaddress2,
                                                            t0.billingaddress, t0.mainintersection, t0.zone,
                                                            t0.country, t0.city, t1.description, t0.mainintersection2,
                                                            t2.description as namezone, t3.description as namecity
                                                            from ".$db_name.'.clients'." t0
                                                            JOIN ".$db_name.'.status'." t1 ON t0.status = t1.id
                                                            JOIN ".$db_name.'.zones'." t2 ON t0.zone = t2.codezone
                                                            JOIN ".$db_name.'.cities'." t3 ON t0.city = t3.id
                                                            WHERE t0.id = '".$rec->idclient."'
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
            'listaddressclient' => $listaddressclient,
            'message' => 'LIST ADDRESS CLIENT OK',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    //Actualizar dirección del usuario
    public function updateContact($rec)
    {
        //echo json_encode($rec->id);
        //exit;
        $db_name = $this->db.".contacts";

        DB::beginTransaction();
        try {

            DB::connection($this->cur_connect)->update("UPDATE ".$db_name." 
                SET names = '".$rec-> names."',
                    surnames = '".$rec-> surnames."',
                    mail = '".$rec-> mail."',
                    cellphone = '".$rec-> cellphone."',
                    extension = '".$rec-> extension."',
                    contactinvoice = '".$rec-> contactinvoice."',
                    status = '".$rec-> status."',
                    emergency = '".$rec-> emergency."',
                    comments = '".$rec-> comments."'
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
            'message' => 'UPDATED CONTACT OK'
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    //Delete Workin Hours
    public function deleteContact($rec)
    {
        $db_name = $this->db.".contacts";

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

    //Create Site Inventory Machine
    public function createSiteInventoryMachine($rec)
    {
        DB::beginTransaction();
        try {
                    $db_name = $this->db.".siteinventorymachine";
                    $createsiteinventory = new ModelGlobal();
                    $createsiteinventory->setConnection($this->cur_connect);
                    $createsiteinventory->setTable($db_name);

                    //$createsiteinventory->idscopework = $rec->idscopework;
                    $createsiteinventory->idclient = $rec->idclient;
                    $createsiteinventory->equipment = $rec->equipment;
                    $createsiteinventory->serialnumber = $rec->serialnumber;
                    $createsiteinventory->idequipment = $rec->idequipment;
                    $createsiteinventory->condition = $rec->condition;

                    $createsiteinventory->purchaseprice = $rec->purchaseprice;
                    $createsiteinventory->marketcost = $rec->marketcost;
                    $createsiteinventory->costtoreplace = $rec->costtoreplace;
                    $createsiteinventory->appearance = $rec->appearance;

                    $createsiteinventory->lasttimeservice = $rec->lasttimeservice;
                    $createsiteinventory->locationofstorage = $rec->locationofstorage;
                    $createsiteinventory->creationdate = $date = date('Y-m-d H:i:s');
                    $createsiteinventory->image = $rec->image; 
                    $createsiteinventory->technicalsheet = $rec->technicalsheet; 
                    $createsiteinventory->comments = $rec->comments;

                    $createsiteinventory->save();

                    //Imagen base 64 se pasa a un arreglo
                    $nombrefoto[1] = $rec->nombreimagen1;
                    $foto[1] = $rec->imagen1;

                    for ($i = 1; $i <= $rec->numerodeimagenes; $i++) {
                        $this->GuardarIMG($foto[$i] ,$nombrefoto[$i],'servicaredocuments/');
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
            'message' => 'REGISTER SITE INVENTORY',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    //Create Site Inventory Machine
    public function createSiteInventoryMachinePDF($rec)
    {
        DB::beginTransaction();
        try {
                    $db_name = $this->db.".siteinventorymachine";
                    $createsiteinventory = new ModelGlobal();
                    $createsiteinventory->setConnection($this->cur_connect);
                    $createsiteinventory->setTable($db_name);

                    //$createsiteinventory->idscopework = $rec->idscopework;
                    $createsiteinventory->idclient = $rec->idclient;
                    $createsiteinventory->equipment = $rec->equipment;
                    $createsiteinventory->serialnumber = $rec->serialnumber;
                    $createsiteinventory->idequipment = $rec->idequipment;
                    $createsiteinventory->condition = $rec->condition;

                    $createsiteinventory->purchaseprice = $rec->purchaseprice;
                    $createsiteinventory->marketcost = $rec->marketcost;
                    $createsiteinventory->costtoreplace = $rec->costtoreplace;
                    $createsiteinventory->appearancen = $rec->appearancen;

                    $createsiteinventory->lasttimeservice = $rec->lasttimeservice;
                    $createsiteinventory->locationofstorage = $rec->locationofstorage;
                    $createsiteinventory->creationdate = $date = date('Y-m-d H:i:s');
                    $createsiteinventory->image = $rec->image; 
                    $createsiteinventory->technicalsheet = $rec->technicalsheet; 
                    $createsiteinventory->comments = $rec->comments;

                    $createsiteinventory->save();

                    //Imagen base 64 se pasa a un arreglo
                    $nombrefoto[1] = $rec->nombreimagen1;
                    $foto[1] = $rec->imagen1;

                    for ($i = 1; $i <= $rec->numerodeimagenes; $i++) {
                        $response = FunctionsCustoms::UploadPDFName($foto[$i],$nombrefoto[1],'servicaredocuments/');
                    }

/*
                    for ($i = 1; $i <= $rec->numerodeimagenes; $i++) {
                        $this->GuardarIMG($foto[$i] ,$nombrefoto[$i],'servicaredocuments/');
                    }
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
            'message' => 'REGISTER SITE INVENTORY',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    // Listar Site Inventory Machine
    public function listSiteInventoryMachine($rec)
    {
        //echo json_encode($rec->idinterno);
        //exit;
        DB::beginTransaction();
        try {
            $db_name = "servicare_sys";
                
        $siteinventory = DB::connection($this->cur_connect)->select(
                                                            "select t0.*, t1.description as nameappearance
                                                            from ".$db_name.'.siteinventorymachine'." t0
                                                            JOIN ".$db_name.'.condition'." t1 ON t0.appearance = t1.id
                                                            WHERE t0.idclient = '".$rec->idclient."'
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
            'siteinventory' => $siteinventory,
            'message' => 'LIST SITE INVENTORYOK',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    //Actualizar Site Inventory Machine
    public function updateSiteInventoryMachine($rec)
    {
        //echo json_encode($rec->id);
        //exit;
        $db_name = $this->db.".siteinventorymachine";

        DB::beginTransaction();
        try {

            DB::connection($this->cur_connect)->update("UPDATE ".$db_name." 
                SET idclient = '".$rec-> idclient."',
                    equipment = '".$rec-> equipment."',
                    serialnumber = '".$rec-> serialnumber."',
                    idequipment = '".$rec-> idequipment."',
                    condition = '".$rec-> condition."',
                    purchaseprice = '".$rec-> purchaseprice."',
                    marketcost = '".$rec-> marketcost."',
                    costtoreplace = '".$rec-> costtoreplace."',
                    appearance = '".$rec-> appearance."',
                    lasttimeservice = '".$rec-> lasttimeservice."',
                    locationofstorage = '".$rec-> locationofstorage."',
                    image = '".$rec-> image."',
                    technicalsheet = '".$rec-> technicalsheet."',
                    comments = '".$rec-> comments."'
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
            'message' => 'UPDATED SITE INVENTORY OK'
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    //Delete Site Inventory Machine
    public function deleteSiteInventoryMachine($rec)
    {
        $db_name = $this->db.".siteinventorymachine";

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

    //Create ServiceTeamMember
    public function createServiceTeamMember($rec)
    {
        DB::beginTransaction();
        try {
                    $db_name = $this->db.".serviceteammember";
                    $createserviceteam = new ModelGlobal();
                    $createserviceteam->setConnection($this->cur_connect);
                    $createserviceteam->setTable($db_name);

                    //$createserviceteam->idscopework = $rec->idscopework;
                    $createserviceteam->idclient = $rec->idclient;
                    $createserviceteam->idemployee = $rec->idemployee;
                    $createserviceteam->position = $rec->position;
                    $createserviceteam->creationdate = $date = date('Y-m-d H:i:s');
                    $createserviceteam->comments = $rec->comments;

                    $createserviceteam->save();

        } catch (\Exception $e){

            DB::rollBack();
            $response = array(
                'type' => '0',
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

    // Listar ServiceTeamMember
    public function listServiceTeamMember($rec)
    {
        //echo json_encode($rec->idinterno);
        //exit;
        DB::beginTransaction();
        try {
            $db_name = "servicare_sys";
                
        $listserviceteammember = DB::connection($this->cur_connect)->select(
                                                            "select t0.* 
                                                            from ".$db_name.'.serviceteammember'." t0
                                                            WHERE t0.idclient = '".$rec->idclient."'
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
            'listserviceteammember' => $listserviceteammember,
            'message' => 'LIST SITE INVENTORYOK',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    //Actualizar ServiceTeamMember
    public function updateServiceTeamMember($rec)
    {
        //echo json_encode($rec->id);
        //exit;
        $db_name = $this->db.".serviceteammember";

        DB::beginTransaction();
        try {

            DB::connection($this->cur_connect)->update("UPDATE ".$db_name." 
                SET idemployee = '".$rec-> idemployee."',
                    position = '".$rec-> position."',
                    comments = '".$rec-> comments."'
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
            'message' => 'UPDATED SITE INVENTORY OK'
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    //Delete ServiceTeamMember
    public function deleteServiceTeamMember($rec)
    {
        $db_name = $this->db.".serviceteammember";

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

    //Create SignedDocuments
    public function createSignedDocuments($rec)
    {
        DB::beginTransaction();
        try {
                    $db_name = $this->db.".signeddocuments";
                    $createsigneddocuments = new ModelGlobal();
                    $createsigneddocuments->setConnection($this->cur_connect);
                    $createsigneddocuments->setTable($db_name);

                    $createsigneddocuments->idemployee = $rec->idemployee;
                    $createsigneddocuments->idclient = $rec->idclient;
                    $createsigneddocuments->typedocument = $rec->typedocument;
                    $createsigneddocuments->namedocument = $rec->namedocument;
                    $createsigneddocuments->nameimg = $rec->nameimg;
                    $createsigneddocuments->creationdate = $date = date('Y-m-d H:i:s');
                    $createsigneddocuments->comments = $rec->comments;

                    $createsigneddocuments->save();
                    
                    //Imagen base 64 se pasa a un arreglo
                    $nombrefoto[1] = $rec->nombreimagen1;
                    $foto[1] = $rec->imagen1;

                    for ($i = 1; $i <= $rec->numerodeimagenes; $i++) {
                        $this->GuardarIMG($foto[$i] ,$nombrefoto[$i],'servicaredocuments/');
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

    //Create SignedDocuments
    public function createSignedDocumentsPDF($rec)
    {
        DB::beginTransaction();
        try {
                    $db_name = $this->db.".signeddocuments";
                    $createsigneddocuments = new ModelGlobal();
                    $createsigneddocuments->setConnection($this->cur_connect);
                    $createsigneddocuments->setTable($db_name);

                    //$createsigneddocuments->idscopework = $rec->idscopework;
                    $createsigneddocuments->idemployee = $rec->idemployee;
                    $createsigneddocuments->idclient = $rec->idclient;
                    $createsigneddocuments->typedocument = $rec->typedocument;
                    $createsigneddocuments->namedocument = $rec->namedocument;
                    $createsigneddocuments->nameimg = $rec->nameimg;
                    $createsigneddocuments->creationdate = $date = date('Y-m-d H:i:s');
                    $createsigneddocuments->comments = $rec->comments;

                    $createsigneddocuments->save();
                    
                    //Imagen base 64 se pasa a un arreglo
                    $nombrefoto[1] = $rec->nombreimagen1;
                    $foto[1] = $rec->imagen1;
/*
                    for ($i = 1; $i <= $rec->numerodeimagenes; $i++) {
                        $this->GuardarIMG($foto[$i] ,$nombrefoto[$i],'servicaredocuments/');
                    }
*/
                    for ($i = 1; $i <= $rec->numerodeimagenes; $i++) {
                        $response = FunctionsCustoms::UploadPDFName($foto[$i],$nombrefoto[1],'servicaredocuments/');
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

    // Listar Signed Documents
    public function listSignedDocuments($rec)
    {
        //echo json_encode($rec->idinterno);
        //exit;
        DB::beginTransaction();
        try {
            $db_name = "servicare_sys";
                
        $listsigneddocuments = DB::connection($this->cur_connect)->select(
                                                            "select t0.* 
                                                            from ".$db_name.'.signeddocuments'." t0
                                                            WHERE t0.idclient = '".$rec->idclient."'
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
            'listsigneddocuments' => $listsigneddocuments,
            'message' => 'LIST signeddocuments',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    //Actualizar Signed Documents
    public function updateSignedDocuments($rec)
    {
        //echo json_encode($rec->id);
        //exit;
        $db_name = $this->db.".signeddocuments";

        DB::beginTransaction();
        try {

            DB::connection($this->cur_connect)->update("UPDATE ".$db_name." 
                SET typedocument = '".$rec-> typedocument."',
                    namedocument = '".$rec-> namedocument."',
                    image = '".$rec-> image."',
                    comments = '".$rec-> comments."'
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
            'message' => 'UPDATED SITE INVENTORY OK'
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    //Delete Signed Documents
    public function deleteSignedDocuments($rec)
    {
        $db_name = $this->db.".signeddocuments";

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

    //Create Contact
    public function createClientAddresses($rec)
    {
        DB::beginTransaction();
        try {
                    $db_name = $this->db.".addressclient";
                    $createcontact = new ModelGlobal();
                    $createcontact->setConnection($this->cur_connect);
                    $createcontact->setTable($db_name);

                    $createcontact->idclient = $rec->idclient;
                    $createcontact->typeaddress = $rec->typeaddress;
                    $createcontact->address1 = $rec->address1;
                    $createcontact->address2 = $rec->address2;
                    $createcontact-> mainintersection = $rec-> mainintersection;
                    $createcontact-> mainintersection2 = $rec-> mainintersection2;
                    $createcontact->city = $rec->city;
                   
                    $createcontact->latitud = $rec->latitud;
                    $createcontact->longitud = $rec->longitud;
                    $createcontact->addressgeolocation = $rec->addressgeolocation;
                   
                    $createcontact->municipality = $rec->municipality;
                    $createcontact->province = $rec->province;
                    $createcontact->country = $rec->country;
                    $createcontact->postalcode = $rec->postalcode;
                    $createcontact->creationdate = $date = date('Y-m-d H:i:s');
                    $createcontact->status = $rec->status;
                    $createcontact->comments = $rec->comments;

                    $createcontact->save();

        } catch (\Exception $e){

            DB::rollBack();
            $response = array(
                'type' => '0',
                'message' => "ERROR ".$e
            );
            $rec->headers->set('Accept', 'application/json');
            echo json_encode($response);
            exit;
        }
        DB::commit();
        $response = array(
            'type' => 1,
            'message' => 'REGISTER CONTACTS',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    // Listar cliente
    public function listClientAddresses($rec)
    {
        //echo json_encode($rec->idinterno);
        //exit;
        DB::beginTransaction();
        try {
            $db_name = "servicare_sys";
                
        $listaddressclient = DB::connection($this->cur_connect)->select(
                                                            "select t0.*, t1.description as namecity, t2.description as namemucipality
                                                            from ".$db_name.'.addressclient'." t0
                                                            JOIN ".$db_name.'.cities'." t1 ON t0.city = t1.id
                                                            JOIN ".$db_name.'.municipality'." t2 ON t0.municipality = t2.id
                                                            WHERE t0.idclient = '".$rec->idclient."'
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
            'listaddressclient' => $listaddressclient,
            'message' => 'LIST ADDRESS CLIENT OK',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    // Listar cliente
    public function listAllAddressClient($rec)
    {
        //echo json_encode($rec->idinterno);
        //exit;
        DB::beginTransaction();
        try {
            $db_name = "servicare_sys";
                
        $listaddressclient = DB::connection($this->cur_connect)->select(
                                                            "select t0.*, t1.description as namecity, t2.description as namemucipality,
                                                            t3.id, t3.customertype, t3.names,
                                                            t3.surnames, t3.businessname
                                                            from ".$db_name.'.addressclient'." t0
                                                            JOIN ".$db_name.'.cities'." t1 ON t0.city = t1.id
                                                            JOIN ".$db_name.'.municipality'." t2 ON t0.municipality = t2.id
                                                            JOIN ".$db_name.'.clients'." t3 ON t0.idclient = t3.id
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
            'listaddressclient' => $listaddressclient,
            'message' => 'LIST ADDRESS CLIENT OK',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    // Listar cliente
    public function listAllClientsAndAddress($rec)
    {
        //echo json_encode($rec->idinterno);
        //exit;
        DB::beginTransaction();
        try {
            $db_name = "servicare_sys";
                
        $listaddressclient = DB::connection($this->cur_connect)->select(
                                                            "select t0.*, t3.status as statusclient,
                                                             t1.description as namecity,
                                                             t2.description as namemucipality,
                                                             t3.*
                                                            from ".$db_name.'.addressclient'." t0
                                                            JOIN ".$db_name.'.cities'." t1 ON t0.city = t1.id
                                                            JOIN ".$db_name.'.municipality'." t2 ON t0.municipality = t2.id
                                                            JOIN ".$db_name.'.clients'." t3 ON t0.idclient = t3.id
                                                            WHERE t0.typeaddress = 1
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
            'listaddressclient' => $listaddressclient,
            'message' => 'LIST ADDRESS CLIENT OK',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    //Actualizar dirección del usuario
    public function updateClientAddresses($rec)
    {
        //echo json_encode($rec->id);
        //exit;
        $db_name = $this->db.".addressclient";

        DB::beginTransaction();
        try {

            DB::connection($this->cur_connect)->update("UPDATE ".$db_name." 
                SET typeaddress = '".$rec-> typeaddress."',
                    address1 = '".$rec-> address1."',
                    address2 = '".$rec-> address2."',
                    city = '".$rec-> city."',
                    municipality = '".$rec-> municipality."',
                    mainintersection = '".$rec-> mainintersection."',
                    mainintersection2 = '".$rec-> mainintersection2."',
                    province = '".$rec-> province."',
                    country = '".$rec-> country."',
                    latitud = '".$rec-> latitud."',
                    longitud = '".$rec-> longitud."',
                    addressgeolocation = '".$rec-> addressgeolocation."',
                    postalcode = '".$rec-> postalcode."',
                    status = '".$rec-> status."',
                    comments = '".$rec-> comments."'
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
            'message' => 'UPDATED CONTACT OK'
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    //Delete Workin Hours
    public function deleteClientAddresses($rec)
    {
        $db_name = $this->db.".addressclient";

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

    //Create Emergency Contact
    public function createEmergencyContact($rec)
    {

        DB::beginTransaction();
        try {
                    $db_name = $this->db.".emergencycontact";
                    $createemergencycontact = new ModelGlobal();
                    $createemergencycontact->setConnection($this->cur_connect);
                    $createemergencycontact->setTable($db_name);

                    //$createemergencycontact->idscopework = $rec->idscopework;
                    $createemergencycontact->idemployee = $rec->idemployee;
                    $createemergencycontact->emergency = $rec->emergency;
                    $createemergencycontact->name = $rec->name;
                    $createemergencycontact->surname = $rec->surname;
                    $createemergencycontact->email = $rec->email;
                    $createemergencycontact->relationshipemployee = $rec->relationshipemployee;
                    $createemergencycontact->phonenumber = $rec->phonenumber;
                    $createemergencycontact->dateofbirth = $rec->dateofbirth;
                    $createemergencycontact->creationdate = $date = date('Y-m-d H:i:s');    
                    $createemergencycontact->comments = $rec->comments;

                    $createemergencycontact->save();

        } catch (\Exception $e){

            DB::rollBack();
            $response = array(
                'type' => '0',
                'message' => "ERROR ".$e
            );
            $rec->headers->set('Accept', 'application/json');
            echo json_encode($response);
            exit;
        }
        DB::commit();
        $response = array(
            'type' => 1,
            'message' => 'REGISTER EMERGENCY CONTACT',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    // Listar scopework por Cliente
    public function listEmergencyContact($rec)
    {
        //echo json_encode($rec->idinterno);
        //exit;
        DB::beginTransaction();
        try {
            $db_name = "servicare_sys";
                
        $listemergencycontact = DB::connection($this->cur_connect)->select(
                                                            "select t0.*, t1.description as namerelationship 
                                                            from ".$db_name.'.emergencycontact'." t0
                                                            JOIN ".$db_name.'.typerelationshipemployee'." t1 ON t0.relationshipemployee = t1.id
                                                            WHERE t0.idemployee = '".$rec->idemployee."'
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
            'listemergencycontact' => $listemergencycontact,
            'message' => 'LIST EMERGENCY CONTACT OK',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    //Actualizar dirección del usuario
    public function updateEmergencyContact($rec)
    {
        //echo json_encode($rec->id);
        //exit;
        $db_name = $this->db.".emergencycontact";

        DB::beginTransaction();
        try {

            DB::connection($this->cur_connect)->update("UPDATE ".$db_name." 
                SET name = '".$rec-> name."',
                    surname = '".$rec-> surname."',
                    emergency = '".$rec-> emergency."',
                    email = '".$rec-> email."',
                    relationshipemployee = '".$rec-> relationshipemployee."',
                    phonenumber = '".$rec-> phonenumber."',
                    dateofbirth = '".$rec-> dateofbirth."',
                    comments = '".$rec-> comments."'
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
            'message' => 'UPDATED scopework OK'
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    //Delete Workin Hours
    public function deleteEmergencyContact($rec)
    {
        $db_name = $this->db.".emergencycontact";

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

    //Create Contact
    public function createRecordCalls($rec)
    {

        DB::beginTransaction();
        try {
                    $db_name = $this->db.".recordcalls";
                    $createrecordcalls = new ModelGlobal();
                    $createrecordcalls->setConnection($this->cur_connect);
                    $createrecordcalls->setTable($db_name);

                    $createrecordcalls->idclient = $rec->idclient;
                    $createrecordcalls->employeeregister = $rec->employeeregister;
                    $createrecordcalls->responsibleemployee = $rec->responsibleemployee;
                    $createrecordcalls->creationdate = $date = date('Y-m-d H:i:s');
                    $createrecordcalls->creationregister = $rec->creationregister;
                    $createrecordcalls->duedate = $rec->duedate;
                    $createrecordcalls->typeregister = $rec->typeregister;
                    $createrecordcalls->status = $rec->status;
                    $createrecordcalls->generatecsr = $rec->generatecsr;
                    $createrecordcalls->comments = $rec->comments;
                    $createrecordcalls->answer = $rec->answer;
                    
                    $createrecordcalls->save();

        } catch (\Exception $e){

            DB::rollBack();
            $response = array(
                'type' => '0',
                'message' => "ERROR ".$e
            );
            $rec->headers->set('Accept', 'application/json');
            echo json_encode($response);
            exit;
        }
        DB::commit();
        $response = array(
            'type' => 1,
            'message' => 'REGISTER CONTACTS',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    // Listar cliente
    public function listRecordCalls($rec)
    {
        //echo json_encode($rec->idinterno);
        //exit;
        DB::beginTransaction();
        try {
            $db_name = "servicare_sys";
                
        $listrecord = DB::connection($this->cur_connect)->select(
                                                        "select t0.*, t1.description, t2.descriptionalt
                                                        from ".$db_name.'.recordcalls'." t0
                                                        JOIN ".$db_name.'.status'." t1 ON t0.status = t1.id
                                                        JOIN ".$db_name.'.statusalternate'." t2 ON t0.typeregister = t2.idalt
                                                        WHERE t0.idclient = '".$rec->idclient."'
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
            'listrecord' => $listrecord,
            'message' => 'LIST RECORDS OK',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    //Actualizar dirección del usuario
    public function updateRecordCalls($rec)
    {
        //echo json_encode($rec->id);
        //exit;
        $db_name = $this->db.".recordcalls";

        DB::beginTransaction();
        try {

            DB::connection($this->cur_connect)->update("UPDATE ".$db_name." 
                SET status = '".$rec-> status."',
                    comments = '".$rec-> comments."',
                    answer = '".$rec-> answer."',
                    generatecsr = '".$rec-> generatecsr."',
                    duedate = '".$rec-> duedate."'
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
            'message' => 'UPDATED CONTACT OK'
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    //Delete Workin Hours
    public function deleteRecordCalls($rec)
    {
        $db_name = $this->db.".recordcalls";

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

    //Create QuoteunitcosttrafficJS
    public function createQuoteUntCostJS($rec)
    {

        DB::beginTransaction();
        try {
                    $db_name = $this->db.".quoteunitcosttrafficJS";
                    $createQuoteUntCostJS = new ModelGlobal();
                    $createQuoteUntCostJS->setConnection($this->cur_connect);
                    $createQuoteUntCostJS->setTable($db_name);

                    $createQuoteUntCostJS->idquote = $rec->idquote;
                    $createQuoteUntCostJS->idcosttrafficjs = $rec->idcosttrafficjs;
                    $createQuoteUntCostJS->description = $rec->description;
                    $createQuoteUntCostJS->value = $rec->value;
                    
                    $createQuoteUntCostJS->save();

        } catch (\Exception $e){

            DB::rollBack();
            $response = array(
                'type' => '0',
                'message' => "ERROR ".$e
            );
            $rec->headers->set('Accept', 'application/json');
            echo json_encode($response);
            exit;
        }
        DB::commit();
        $response = array(
            'type' => 1,
            'message' => 'REGISTER QuoteUntCostJS',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    // Listar cliente
    public function listQuoteUntCostJS($rec)
    {
        //echo json_encode($rec->idinterno);
        //exit;
        DB::beginTransaction();
        try {
            $db_name = "servicare_sys";
                
        $listquoteuntcostjs = DB::connection($this->cur_connect)->select(
                                                        "select t0.*
                                                        from ".$db_name.'.quoteunitcosttrafficJS'." t0
                                                        WHERE t0.idquote = '".$rec->idquote."'
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
            'listquoteuntcostjs' => $listquoteuntcostjs,
            'message' => 'LIST QuoteUntCostJS',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    //Actualizar dirección del usuario
    public function updateQuoteUntCostJS($rec)
    {
        //echo json_encode($rec->id);
        //exit;
        $db_name = $this->db.".quoteunitcosttrafficJS";

        DB::beginTransaction();
        try {

            DB::connection($this->cur_connect)->update("UPDATE ".$db_name." 
                SET value = '".$rec-> value."'
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
            'message' => 'UPDATED QuoteUntCostJS OK'
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    //Delete Workin Hours
    public function deleteQuoteUntCostJS($rec)
    {
        $db_name = $this->db.".quoteunitcosttrafficJS";

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

    public function listAllQuoteSiteSurvey($rec)
    {
        //echo json_encode($rec->idinterno);
        //exit;
        DB::beginTransaction();
        try {
            $db_name = "servicare_sys";
                
        $listquotesitesurvey = DB::connection($this->cur_connect)->select(
                                                        "select t0.*, t0.description as namesitesurvey,
                                                        t1.comments as commenttask,
                                                         t1.*, t2.*, t1.creationdate, t3.description as namestate,
                                                         0 as idquotation, t0.id 
                                                         from ".$db_name.'.sitesurvey'." t0
                                                         JOIN ".$db_name.'.quotesitesurvey'." t1 ON t0.id = t1.idsitesurvey
                                                         JOIN ".$db_name.'.clients'." t2 ON t1.clients = t2.id
                                                         JOIN ".$db_name.'.status'." t3 ON t1.state = t3.id
                                                        ORDER BY t1.idquote DESC");

        } catch (\Exception $e){
        
            DB::rollBack();
            $response = array(
                'type' => '0',
                'message' => "ERROR ".$e
            );
            $rec->headers->set('Accept', 'application/json');
            echo json_encode($response);
            exit;
        }
        DB::commit();
        $response = array(
            'type' => 1,
            'listquotesitesurvey' => $listquotesitesurvey,
            'message' => 'LIST listquotesitesurveyjs',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    public function listTotAmountInvoice($rec)
    {
        //echo json_encode($rec->idinterno);
        //exit;
        DB::beginTransaction();
        try {
            $db_name = "servicare_sys";
                
        $listtotamountinvoice = DB::connection($this->cur_connect)->select(
                                                        "select t0.*
                                                        from ".$db_name.'.viewtotamountinvoice'." t0
                                                        ORDER BY t0.idscopework DESC");

        } catch (\Exception $e){
        
            DB::rollBack();
            $response = array(
                'type' => '0',
                'message' => "ERROR ".$e
            );
            $rec->headers->set('Accept', 'application/json');
            echo json_encode($response);
            exit;
        }
        DB::commit();
        $response = array(
            'type' => 1,
            'listtotamountinvoice' => $listtotamountinvoice,
            'message' => 'LIST listquotesitesurveyjs',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    // Listar cotizaciones y site survey tipos JS
    public function listQuoteSiteSurveyJS($rec)
    {
        //echo json_encode($rec->idinterno);
        //exit;
        DB::beginTransaction();
        try {
            $db_name = "servicare_sys";
                
        $listquotesitesurveyjs = DB::connection($this->cur_connect)->select(
                                                        "select t0.*, t0.description as namesitesurvey,
                                                        t1.comments as commenttask,
                                                         t1.*, t2.*, t1.creationdate, t3.description as namestate,
                                                         0 as idquotation, t0.id 
                                                         from ".$db_name.'.sitesurvey'." t0
                                                         JOIN ".$db_name.'.quotesitesurvey'." t1 ON t0.id = t1.idsitesurvey
                                                         JOIN ".$db_name.'.clients'." t2 ON t1.clients = t2.id
                                                         JOIN ".$db_name.'.status'." t3 ON t1.state = t3.id
                                                        WHERE t1.clients = '".$rec->idclient."'
                                                        ORDER BY t1.idquote DESC");

        } catch (\Exception $e){
        
            DB::rollBack();
            $response = array(
                'type' => '0',
                'message' => "ERROR ".$e
            );
            $rec->headers->set('Accept', 'application/json');
            echo json_encode($response);
            exit;
        }
        DB::commit();
        $response = array(
            'type' => 1,
            'listquotesitesurveyjs' => $listquotesitesurveyjs,
            'message' => 'LIST listquotesitesurveyjs',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    // Listar cotizaciones y site survey tipos CMP
    public function listQuoteSTSurveyCMP($rec)
    {
        //echo json_encode($rec->idinterno);
        //exit;
        DB::beginTransaction();
        try {
            $db_name = "servicare_sys";
                
        $listquotesitesurveycmp = DB::connection($this->cur_connect)->select(
                                                        "select t0.*, t1.description as namesitesurvey,
                                                        t2.*, t3.*, t4.description as namestate
                                                        from ".$db_name.'.quotesitesurveycmp'." t0
                                                        JOIN ".$db_name.'.quotesitesurvey'." t2 ON t0.idquote = t2.idquote
                                                        JOIN ".$db_name.'.sitesurvey'." t1 ON t2.idsitesurvey = t1.id
                                                        JOIN ".$db_name.'.clients'." t3 ON t2.clients = t3.id
                                                        JOIN ".$db_name.'.status'." t4 ON t2.state = t4.id
                                                        WHERE t2.clients = '".$rec->idclient."'
                                                        ORDER BY t0.idquote DESC");

        } catch (\Exception $e){
        
            DB::rollBack();
            $response = array(
                'type' => '0',
                'message' => "ERROR ".$e
            );
            $rec->headers->set('Accept', 'application/json');
            echo json_encode($response);
            exit;
        }
        DB::commit();
        $response = array(
            'type' => 1,
            'listquotesitesurveycmp' => $listquotesitesurveycmp,
            'message' => 'LIST listquotesitesurveyCMP',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    //Create Work Orders
    public function createWorkOrders($rec)
    {

        DB::beginTransaction();
        try {
                    $db_name = $this->db.".workorders";
                    $createWorkOrders = new ModelGlobal();
                    $createWorkOrders->setConnection($this->cur_connect);
                    $createWorkOrders->setTable($db_name);

                    $createWorkOrders->typeworkorder = $rec->typeworkorder;
                    $createWorkOrders->idscopework = $rec->idscopework;
                    $createWorkOrders->idduplicate = $rec->idduplicate;
                    $createWorkOrders->idsitesurvey = $rec->idsitesurvey;
                    $createWorkOrders->idquote = $rec->idquote;
                    $createWorkOrders->schedulingdate = $date = date('Y-m-d H:i:s');
                    $createWorkOrders->assigneddate = $rec->assigneddate;
                    $createWorkOrders->startdate = $rec->startdate;
                    $createWorkOrders->enddate = $rec->enddate;

                    $createWorkOrders->arrivaltime = $rec->arrivaltime;
                    $createWorkOrders->departuretime = $rec->departuretime;

                    $createWorkOrders->color = $rec->color;
                    $createWorkOrders->supplier = $rec->supplier;
                    $createWorkOrders->latitud = $rec->latitud;
                    $createWorkOrders->longitud = $rec->longitud;
                    $createWorkOrders->addressgeolocation = $rec->addressgeolocation;
                    $createWorkOrders->client = $rec->client;
                    $createWorkOrders->employee = $rec->employee;
                    $createWorkOrders->duration = $rec->duration;
                    $createWorkOrders->worktime = $rec->worktime;
                    $createWorkOrders->salesperson = $rec->salesperson;
                    $createWorkOrders->accountmanager = $rec->accountmanager;
                    $createWorkOrders->supervisor = $rec->supervisor;
                    $createWorkOrders->comments = $rec->comments;
                    $createWorkOrders->status = $rec->status;

                    $createWorkOrders->save();

        } catch (\Exception $e){

            DB::rollBack();
            $response = array(
                'type' => '0',
                'message' => "ERROR ".$e
            );
            $rec->headers->set('Accept', 'application/json');
            echo json_encode($response);
            exit;
        }
        DB::commit();
        $response = array(
            'type' => 1,
            'message' => 'REGISTER CONTRACT',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    // Listar cliente
    public function listWorkOrders($rec)
    {
        //echo json_encode($rec->idinterno);
        //exit;
        DB::beginTransaction();
        try {
            $db_name = "servicare_sys";

            $listworkorders = DB::connection($this->cur_connect)->select(
                                "select t0.*, t0.id as idworkorder,
                                        t1.names, t1.surnames, t1.businessname,
                                        t1.customertype, t2.description as nametypeorder,
                                        t3.namelargegroup as namesitesurvey,
                                        t3.order as ordersitesurvey, t1.abbreviation,
                                        t3.group as idgroupss, t3.namegroup as groupss,
                                        t4.businessname as namesupplier, t5.firstname, t5.lastname,
                                        CONCAT(t5.firstname,' ',t5.lastname) as nametechnical,
                                        CONCAT(t7.namesupervisor,' ',t7.lastnamesupervisor) as namesupervisor,
                                        CONCAT(t8.namemanager, t8.lastnamemanager) as namemanager,
                                        253 as idcity, 'Mississauga' as namecity,
                                        t6.description as stateworkorder, t6.id as idstatus,
                                        t1.accountmanager as clientmanager,
                                        t9.address1, t9.postalcode,
                                        t10.description as namecity, t11.description as namemucipality,
                                        t12.area
                                from ".$db_name.'.workorders'." t0
                                JOIN ".$db_name.'.clients'." t1 ON t0.client = t1.id
                                JOIN ".$db_name.'.typeworkorder'." t2 ON t0.typeworkorder = t2.id
                                JOIN ".$db_name.'.sitesurvey'." t3 ON t0.idsitesurvey = t3.id 
                                JOIN ".$db_name.'.supplier'." t4 ON t0.supplier = t4.id
                                JOIN ".$db_name.'.employee'." t5 ON t0.employee = t5.id
                                JOIN ".$db_name.'.status'." t6 ON t0.status = t6.id
                                JOIN ".$db_name.'.viewemployeesupervisor'." t7 ON t0.supervisor = t7.idemployee
                                JOIN ".$db_name.'.viewemployeemanager'." t8 ON t0.accountmanager = t8.idmanager
                                JOIN ".$db_name.'.addressclient'." t9 ON t0.client = t9.idclient
                                JOIN ".$db_name.'.cities'." t10 ON t9.city = t10.id
                                JOIN ".$db_name.'.municipality'." t11 ON t9.municipality = t11.id
                           LEFT JOIN ".$db_name.'.dataworkordercustomized'." t12 ON t0.idquote = t12.idquote     
                                WHERE t9.typeaddress = 1 ORDER BY t0.id DESC");

        /*  
        $listworkorders = DB::connection($this->cur_connect)->select(
                                                "select t0.*, t0.id as idworkorder,
                                                        t1.names, t1.surnames, t1.businessname,
                                                        t1.customertype, t2.description as nametypeorder,
                                                        t3.namelargegroup as namesitesurvey,
                                                        t3.order as ordersitesurvey, t1.abbreviation,
                                                        t3.group as idgroupss, t3.namegroup as groupss,
                                                        t4.businessname as namesupplier, t5.firstname, t5.lastname,
                                                        CONCAT(t5.firstname,' ',t5.lastname) as nametechnical,
                                                        CONCAT(t7.namesupervisor,' ',t7.lastnamesupervisor) as namesupervisor,
                                                        CONCAT(t8.namemanager, t8.lastnamemanager) as namemanager,
                                                        253 as idcity, 'Mississauga' as namecity,
                                                        t6.description as stateworkorder, t6.id as idstatus,
                                                        t1.accountmanager as clientmanager,
                                                        t9.address1, t9.postalcode,
                                                        t10.description as namecity, t11.description as namemucipality
                                                from ".$db_name.'.workorders'." t0
                                                JOIN ".$db_name.'.clients'." t1 ON t0.client = t1.id
                                                JOIN ".$db_name.'.typeworkorder'." t2 ON t0.typeworkorder = t2.id
                                                JOIN ".$db_name.'.sitesurvey'." t3 ON t0.typeworkorder = t3.type 
                                                JOIN ".$db_name.'.supplier'." t4 ON t0.supplier = t4.id
                                                JOIN ".$db_name.'.employee'." t5 ON t0.employee = t5.id
                                                JOIN ".$db_name.'.status'." t6 ON t0.status = t6.id
                                                JOIN ".$db_name.'.viewemployeesupervisor'." t7 ON t0.supervisor = t7.idemployee
                                                JOIN ".$db_name.'.viewemployeemanager'." t8 ON t0.accountmanager = t8.idmanager
                                                JOIN ".$db_name.'.addressclient'." t9 ON t0.client = t9.idclient
                                                JOIN ".$db_name.'.cities'." t10 ON t9.city = t10.id
                                                JOIN ".$db_name.'.municipality'." t11 ON t9.municipality = t11.id     
                                                WHERE t9.typeaddress = 1 ORDER BY t0.id DESC");
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
            'listworkorders' => $listworkorders,
            'message' => 'LIST CONTRACTS OK',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    public function listWorkOrdersSingle($rec)
    {
        //echo json_encode($rec->idinterno);
        //exit;
        DB::beginTransaction();
        try {
            $db_name = "servicare_sys";
                
        $listworkorders = DB::connection($this->cur_connect)->select(
                                                "select t0.*, t0.id as idworkorder
                                                from ".$db_name.'.workorders'." t0
                                                WHERE t0.status = 27
                                                  AND t0.client = '".$rec->idclient."'
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
            'listworkorders' => $listworkorders,
            'message' => 'LIST CONTRACTS OK',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    public function listWorkOrdersDuplicate($rec)
    {
        //echo json_encode($rec->idinterno);
        //exit;
        DB::beginTransaction();
        try {
            $db_name = "servicare_sys";
                
        $listworkorders = DB::connection($this->cur_connect)->select(
                                                "select t0.*, t0.id as idworkorder
                                                from ".$db_name.'.workorders'." t0
                                                WHERE t0.idquote = '".$rec->idquote."'
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
            'listworkorders' => $listworkorders,
            'message' => 'LIST WORK ORDER OK',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    // Listar cliente
    public function listWorkOrdersScopeWork($rec)
    {
        //echo json_encode($rec->idinterno);
        //exit;
        DB::beginTransaction();
        try {
            $db_name = "servicare_sys";
                
        $listworkordersscope = DB::connection($this->cur_connect)->select(
                                                "select t0.*, t1.names, t1.surnames, t1.businessname,
                                                        t1.customertype, t2.description as nametypeorder,
                                                        t3.description as namesitesurvey, t1.abbreviation,
                                                        t4.businessname as namesupplier,
                                                        t5.firstname, t5.lastname,
                                                        CONCAT(t5.firstname, t5.lastname) as nametechnical,
                                                        CONCAT(t7.namesupervisor, t7.lastnamesupervisor) as namesupervisor,
                                                        CONCAT(t8.namemanager, t8.lastnamemanager) as namemanager,
                                                        t6.description as stateworkorder,
                                                        t1.accountmanager as clientmanager,
                                                        t9.address1, t9.postalcode,
                                                        t10.description as namecity, t11.description as namemucipality
                                                from ".$db_name.'.workorders'." t0
                                                JOIN ".$db_name.'.clients'." t1 ON t0.client = t1.id
                                                JOIN ".$db_name.'.typeworkorder'." t2 ON t0.typeworkorder = t2.id
                                                JOIN ".$db_name.'.sitesurvey'." t3 ON t0.idsitesurvey = t3.id 
                                                JOIN ".$db_name.'.supplier'." t4 ON t0.supplier = t4.id
                                                JOIN ".$db_name.'.employee'." t5 ON t0.employee = t5.id
                                                JOIN ".$db_name.'.status'." t6 ON t0.status = t6.id
                                                JOIN ".$db_name.'.viewemployeesupervisor'." t7 ON t0.supervisor = t7.idemployee
                                                JOIN ".$db_name.'.viewemployeemanager'." t8 ON t0.accountmanager = t8.idmanager
                                                JOIN ".$db_name.'.addressclient'." t9 ON t0.client = t9.idclient
                                                JOIN ".$db_name.'.cities'." t10 ON t9.city = t10.id
                                                JOIN ".$db_name.'.municipality'." t11 ON t9.municipality = t11.id 
                                                WHERE t0.idscopework = '".$rec->idscopework."'
                                                  AND t9.typeaddress = 1
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
            'listworkordersscope' => $listworkordersscope,
            'message' => 'LIST CONTRACTS OK',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    // Listar cliente
    public function listWorkOrdersIdQuote($rec)
    {
        //echo json_encode($rec->idinterno);
        //exit;
        DB::beginTransaction();
        try {
            $db_name = "servicare_sys";
                
        $listworkordersscope = DB::connection($this->cur_connect)->select(
                                                "select t0.*, t1.names, t1.surnames, t1.businessname,
                                                        t1.customertype, t2.description as nametypeorder,
                                                        t1.abbreviation,

                                                        t3.description as namesitesurveyxxx, 
                                                        
                                                        t3.namelargegroup as namesitesurvey,
                                                        t3.order as ordersitesurvey,
                                                        t3.group as idgroupss, t3.namegroup as groupss,
                                                    

                                                        t4.businessname as namesupplier,
                                                        t5.firstname, t5.lastname,
                                                        CONCAT(t5.firstname, t5.lastname) as nametechnical,
                                                        CONCAT(t7.namesupervisor, t7.lastnamesupervisor) as namesupervisor,
                                                        CONCAT(t8.namemanager, t8.lastnamemanager) as namemanager,
                                                        t6.description as stateworkorder,
                                                        t1.accountmanager as clientmanager,
                                                        t9.address1, t9.postalcode,
                                                        t10.description as namecity, t11.description as namemucipality
                                                from ".$db_name.'.workorders'." t0
                                                JOIN ".$db_name.'.clients'." t1 ON t0.client = t1.id
                                                JOIN ".$db_name.'.typeworkorder'." t2 ON t0.typeworkorder = t2.id
                                                JOIN ".$db_name.'.sitesurvey'." t3 ON t0.idsitesurvey = t3.id 
                                                JOIN ".$db_name.'.supplier'." t4 ON t0.supplier = t4.id
                                                JOIN ".$db_name.'.employee'." t5 ON t0.employee = t5.id
                                                JOIN ".$db_name.'.status'." t6 ON t0.status = t6.id
                                                JOIN ".$db_name.'.viewemployeesupervisor'." t7 ON t0.supervisor = t7.idemployee
                                                JOIN ".$db_name.'.viewemployeemanager'." t8 ON t0.accountmanager = t8.idmanager
                                                JOIN ".$db_name.'.addressclient'." t9 ON t0.client = t9.idclient
                                                JOIN ".$db_name.'.cities'." t10 ON t9.city = t10.id
                                                JOIN ".$db_name.'.municipality'." t11 ON t9.municipality = t11.id 
                                                WHERE t0.idquote = '".$rec->idquote."'
                                                  AND t9.typeaddress = 1
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
            'listworkordersscope' => $listworkordersscope,
            'message' => 'LIST CONTRACTS OK',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    // Listar cliente
    public function listWorkOrdersEmployee($rec)
    {
        //echo json_encode($rec->idinterno);
        //exit;
        DB::beginTransaction();
        try {
            $db_name = "servicare_sys";
                
        $listworkordersemployee = DB::connection($this->cur_connect)->select(
                                                "select t0.*, t1.names, t1.surnames, t1.businessname,
                                                        t1.customertype, t2.description as nametypeorder,
                                                        t3.description as namesitesurvey, t1.abbreviation,
                                                        t4.businessname as namesupplier,
                                                        CONCAT(t5.firstname, t5.lastname) as nametechnical,
                                                        CONCAT(t7.namesupervisor, t7.lastnamesupervisor) as namesupervisor,
                                                        CONCAT(t8.namemanager, t8.lastnamemanager) as namemanager,
                                                        t6.description as stateworkorder,
                                                        t1.accountmanager as clientmanager,
                                                        TIMEDIFF(NOW(),t0.startactivity) AS timeworkorder
                                                from ".$db_name.'.workorders'." t0
                                                JOIN ".$db_name.'.clients'." t1 ON t0.client = t1.id
                                                JOIN ".$db_name.'.typeworkorder'." t2 ON t0.typeworkorder = t2.id
                                                JOIN ".$db_name.'.sitesurvey'." t3 ON t0.idsitesurvey = t3.id 
                                                JOIN ".$db_name.'.supplier'." t4 ON t0.supplier = t4.id
                                                JOIN ".$db_name.'.employee'." t5 ON t0.employee = t5.id
                                                JOIN ".$db_name.'.status'." t6 ON t0.status = t6.id
                                                JOIN ".$db_name.'.viewemployeesupervisor'." t7 ON t0.supervisor = t7.idemployee
                                                JOIN ".$db_name.'.viewemployeemanager'." t8 ON t0.accountmanager = t8.idmanager
                                                WHERE t0.employee = '".$rec->employee."'
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
            'listworkordersemployee' => $listworkordersemployee,
            'message' => 'LIST Work Employee OK',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    //Actualizar work orders
    public function updateWorkOrders($rec)
    {
        //echo json_encode($rec->id);
        //exit;
        $db_name = $this->db.".workorders";
   
        DB::beginTransaction();
        try {
   
              DB::connection($this->cur_connect)->update("UPDATE ".$db_name." 
                  SET schedulingdate = '".$rec-> schedulingdate."',
                      assigneddate = '".$date = date('Y-m-d H:i:s')."',
                      startdate = '".$rec-> startdate."',
                      enddate = '".$rec-> enddate."',
                      arrivaltime = '".$rec-> arrivaltime."',
                      departuretime = '".$rec-> departuretime."',
                      supplier = '".$rec-> supplier."',
                      employee = '".$rec-> employee."',
                      color = '".$rec-> color."',
                      worktime = '".$rec-> worktime."',
                      status = '".$rec-> status."',
                      supervisor = '".$rec-> supervisor."',
                      duration = '".$rec-> duration."',
                      salesperson = '".$rec-> salesperson."',
                      accountmanager = '".$rec-> accountmanager."',
                      comments = '".$rec-> comments."'
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
               'message' => 'UPDATED CONTRACTS OK'
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    //Actualizar work orders
    public function updateWorkOrdersStatus($rec)
    {
        //echo json_encode($rec->id);
        //exit;
        $db_name = $this->db.".workorders";
   
        DB::beginTransaction();
        try {
   
              DB::connection($this->cur_connect)->update("UPDATE ".$db_name." 
                  SET status = '".$rec-> status."',
                      startactivity = '".$rec-> startactivity."'
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
               'message' => 'UPDATED CONTRACTS OK'
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    //Actualizar work orders
    public function updateWorkOrderClose($rec)
    {
        //echo json_encode($rec->id);
        //exit;
        $db_name = $this->db.".workorders";
   
        DB::beginTransaction();
        try {
   
              DB::connection($this->cur_connect)->update("UPDATE ".$db_name." 
                  SET status = '".$rec-> status."'
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
               'message' => 'UPDATED WORK ORDER OK'
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    //Actualizar work orders
    public function updateNotificacionWO($rec)
    {
        //echo json_encode($rec->id);
        //exit;
        $db_name = $this->db.".workorders";
   
        DB::beginTransaction();
        try {
   
              DB::connection($this->cur_connect)->update("UPDATE ".$db_name." 
                  SET generatenotification = '".$rec-> status."'
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
               'message' => 'UPDATED WORK ORDER OK'
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    //Actualizar work orders
    public function updateLatLngWorkOrder($rec)
    {
        //echo json_encode($rec->id);
        //exit;
        $db_name = $this->db.".workorders";
   
        DB::beginTransaction();
        try {
   
              DB::connection($this->cur_connect)->update("UPDATE ".$db_name." 
                  SET latitud = '".$rec-> latitud."',
                      longitud = '".$rec-> longitud."'
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
               'message' => 'UPDATED LAT LNG WO OK'
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }


    //Create quotesitesurvey
    public function createQuoteSiteSurvey($rec)
    {

        DB::beginTransaction();
        try {
                    $db_name = $this->db.".quotesitesurvey";
                    $createquotesitesurvey = new ModelGlobal();
                    $createquotesitesurvey->setConnection($this->cur_connect);
                    $createquotesitesurvey->setTable($db_name);

                    $createquotesitesurvey->idquotefather = $rec->idquotefather;
                    $createquotesitesurvey->idsitesurvey = $rec->idsitesurvey;
                    $createquotesitesurvey->wogenerate = $rec->wogenerate;
                    $createquotesitesurvey->clients = $rec->clients;
                    $createquotesitesurvey->creationdate = $date = date('Y-m-d H:i:s');
                    $createquotesitesurvey->state = $rec->state;
                    
                    $createquotesitesurvey->save();

        } catch (\Exception $e){

            DB::rollBack();
            $response = array(
                'type' => '0',
                'message' => "ERROR ".$e
            );
            $rec->headers->set('Accept', 'application/json');
            echo json_encode($response);
            exit;
        }
        DB::commit();
        $response = array(
            'type' => 1,
            'message' => 'REGISTER CONTACTS',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    // Listar cliente
    public function listQuoteSiteSurvey($rec)
    {
        //echo json_encode($rec->idinterno);
        //exit;
        DB::beginTransaction();
        try {
            $db_name = "servicare_sys";
                
        $listquotesitesurvey = DB::connection($this->cur_connect)->select(
                                                            "select t0.*, t1.description as namesitesurvey,
                                                            t2.names, t2.surnames, t2.businessname,
                                                            t3.description as namestate 
                                                            from ".$db_name.'.quotesitesurvey'." t0
                                                            JOIN ".$db_name.'.sitesurvey'." t1 ON t0.idsitesurvey = t1.id
                                                            JOIN ".$db_name.'.clients'." t2 ON t0.clients = t2.id
                                                            JOIN ".$db_name.'.status'." t3 ON t0.state = t3.id
                                                            WHERE t0.clients = '".$rec->idclient."'
                                                            ORDER BY t0.idquote DESC");

        } catch (\Exception $e){
        
            DB::rollBack();
            $response = array(
                'type' => '0',
                'message' => "ERROR ".$e
            );
            $rec->headers->set('Accept', 'application/json');
            echo json_encode($response);
            exit;
        }
        DB::commit();
        $response = array(
            'type' => 1,
            'listquotesitesurvey' => $listquotesitesurvey,
            'message' => 'LIST SITE SURVEy JS OK',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    // Listar cliente
    public function listQuoteSiteSurveyIdQuote($rec)
    {
        //echo json_encode($rec->idinterno);
        //exit;
        DB::beginTransaction();
        try {
            $db_name = "servicare_sys";
                
        $listquotesitesurveyidquote = DB::connection($this->cur_connect)->select(
                                                            "select t0.*, t1.description as namesitesurvey,
                                                            t2.names, t2.surnames, t2.businessname,
                                                            t3.description as namestate 
                                                            from ".$db_name.'.quotesitesurvey'." t0
                                                            JOIN ".$db_name.'.sitesurvey'." t1 ON t0.idsitesurvey = t1.id
                                                            JOIN ".$db_name.'.clients'." t2 ON t0.clients = t2.id
                                                            JOIN ".$db_name.'.status'." t3 ON t0.state = t3.id
                                                            WHERE t0.clients = '".$rec->idclient."'
                                                              AND t0.idquote = '".$rec->idquote."'
                                                            ORDER BY t0.idquote DESC");

        } catch (\Exception $e){
        
            DB::rollBack();
            $response = array(
                'type' => '0',
                'message' => "ERROR ".$e
            );
            $rec->headers->set('Accept', 'application/json');
            echo json_encode($response);
            exit;
        }
        DB::commit();
        $response = array(
            'type' => 1,
            'listquotesitesurveyidquote' => $listquotesitesurveyidquote,
            'message' => 'LIST SITE SURVEy JS OK',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    public function listSiteSurveyIdQuote($rec)
    {
        //echo json_encode($rec->idinterno);
        //exit;
        DB::beginTransaction();
        try {
            $db_name = "servicare_sys";
                
        $listquotesitesurveyidquote = DB::connection($this->cur_connect)->select(
                                                            "select t0.*, t1.description as namesitesurvey,
                                                            t2.names, t2.surnames, t2.businessname,
                                                            t3.description as namestate 
                                                            from ".$db_name.'.quotesitesurvey'." t0
                                                            JOIN ".$db_name.'.sitesurvey'." t1 ON t0.idsitesurvey = t1.id
                                                            JOIN ".$db_name.'.clients'." t2 ON t0.clients = t2.id
                                                            JOIN ".$db_name.'.status'." t3 ON t0.state = t3.id
                                                            WHERE t0.idquote = '".$rec->idquote."'
                                                            ORDER BY t0.idquote DESC");

        } catch (\Exception $e){
        
            DB::rollBack();
            $response = array(
                'type' => '0',
                'message' => "ERROR ".$e
            );
            $rec->headers->set('Accept', 'application/json');
            echo json_encode($response);
            exit;
        }
        DB::commit();
        $response = array(
            'type' => 1,
            'listquotesitesurveyidquote' => $listquotesitesurveyidquote,
            'message' => 'LIST SITE SURVEy JS OK',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    // Listar cliente
    public function listAllQuote($rec)
    {
        //echo json_encode($rec->idinterno);
        //exit;
        DB::beginTransaction();
        try {
            $db_name = "servicare_sys";
                
        $listallquote = DB::connection($this->cur_connect)->select(
                                                            "select t0.*, t1.description as namesitesurvey,
                                                            t2.names, t2.surnames, t2.businessname,
                                                            t3.description as namestate,
                                                            (360 - TRUNCATE(((DATEDIFF(NOW(), t0.creationdate))),1)) AS timequote 
                                                            from ".$db_name.'.quotesitesurvey'." t0
                                                            JOIN ".$db_name.'.sitesurvey'." t1 ON t0.idsitesurvey = t1.id
                                                            JOIN ".$db_name.'.clients'." t2 ON t0.clients = t2.id
                                                            JOIN ".$db_name.'.status'." t3 ON t0.state = t3.id
                                                            WHERE t0.idsitesurvey IN (1,3,4,5)
                                                            ORDER BY t0.idquote DESC");

        } catch (\Exception $e){
        
            DB::rollBack();
            $response = array(
                'type' => '0',
                'message' => "ERROR ".$e
            );
            $rec->headers->set('Accept', 'application/json');
            echo json_encode($response);
            exit;
        }
        DB::commit();
        $response = array(
            'type' => 1,
            'listallquote' => $listallquote,
            'message' => 'LIST SITE SURVEy JS OK',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    //Actualizar QuoteSiteSurvey
    public function updateQuoteSiteSurvey($rec)
    {
        //echo json_encode($rec->id);
        //exit;
        $db_name = $this->db.".quotesitesurvey";

        DB::beginTransaction();
        try {

            DB::connection($this->cur_connect)->update("UPDATE ".$db_name." 
                SET idsitesurvey = '".$rec-> idsitesurvey."',
                    state = '".$rec-> state."',
                    wogenerate = '".$rec-> wogenerate."',
                    deliveredtoclient = '".$rec-> deliveredtoclient."',
                    customeraccepted = '".$rec-> customeraccepted."',
                    generateenvoice = '".$rec-> generateenvoice."',
                    generateagreement = '".$rec-> generateagreement."',
                    generatescopework = '".$rec-> generatescopework."'
                WHERE idquote = '".$rec->idquote."'");

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
            'message' => 'UPDATED quotesitesurvey OK'
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    //Actualizar QuoteSiteSurvey
    public function updateDeliveredToClient($rec)
    {
        //echo json_encode($rec->id);
        //exit;
        $db_name = $this->db.".quotesitesurvey";

        DB::beginTransaction();
        try {

            DB::connection($this->cur_connect)->update("UPDATE ".$db_name." 
                SET deliveredtoclient = '".$rec-> deliveredtoclient."',
                    deliveredtoclientdate = '".$date = date('Y-m-d H:i:s')."'
                WHERE idquote = '".$rec->idquote."'");

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
            'message' => 'UPDATED quotesitesurvey OK'
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    //Actualizar QuoteSiteSurvey
    public function updateSiteSurveyComments($rec)
    {
        //echo json_encode($rec->id);
        //exit;
        $db_name = $this->db.".quotesitesurvey";

        DB::beginTransaction();
        try {

            DB::connection($this->cur_connect)->update("UPDATE ".$db_name." 
                SET idcomment = '".$rec-> idcomment."',  
                    comments = '".$rec-> comments."'
                WHERE idquote = '".$rec->idquote."'");

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
            'message' => 'UPDATED quotesitesurvey OK'
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    //Actualizar QuoteSiteSurvey
    public function updateFollowUpComments($rec)
    {
        //echo json_encode($rec->id);
        //exit;
        $db_name = $this->db.".quotesitesurvey";

        DB::beginTransaction();
        try {

            DB::connection($this->cur_connect)->update("UPDATE ".$db_name." 
                SET followup = '".$rec-> followup."',  
                    commentsfollowup = '".$rec-> commentsfollowup."',
                    followupdate = '".$date = date('Y-m-d H:i:s')."'
                WHERE idquote = '".$rec->idquote."'");

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
            'message' => 'UPDATED FOLLOW UP OK'
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    //Actualizar QuoteSiteSurvey
    public function updateQuoteSSCalculation($rec)
    {
        //echo json_encode($rec->id);
        //exit;
        $db_name = $this->db.".quotesitesurvey";

        DB::beginTransaction();
        try {

            DB::connection($this->cur_connect)->update("UPDATE ".$db_name." 
                SET low = '".$rec-> low."',
                    medium = '".$rec-> medium."',
                    high = '".$rec-> high."',
                    optionselect = '".$rec-> optionselect."',
                    frequency = '".$rec-> frequency."'
                WHERE idquote = '".$rec->idquote."'");

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
            'message' => 'UPDATED CALCULATION quotesitesurvey OK'
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    //Actualizar QuoteSiteSurvey
    public function updateQuoteEdit($rec)
    {
        //echo json_encode($rec->id);
        //exit;
        $db_name = $this->db.".quotesitesurvey";

        DB::beginTransaction();
        try {

            DB::connection($this->cur_connect)->update("UPDATE ".$db_name." 
                SET low = '".$rec-> low."',
                    medium = '".$rec-> medium."',
                    high = '".$rec-> high."',
                    optionselect = '".$rec-> optionselect."'
                WHERE idquote = '".$rec->idquote."'");

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
            'message' => 'UPDATED CALCULATION quotesitesurvey OK'
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    //Actualizar QuoteSiteSurvey
    public function updatePriceChange($rec)
    {
        //echo json_encode($rec->id);
        //exit;
        $db_name = $this->db.".quotesitesurvey";

        DB::beginTransaction();
        try {

            DB::connection($this->cur_connect)->update("UPDATE ".$db_name." 
                SET pricechange = '".$rec-> pricechange."'
                WHERE idquote = '".$rec->idquote."'");

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
            'message' => 'UPDATED CALCULATION quotesitesurvey OK'
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    //Delete Workin Hours
    public function deleteQuoteSiteSurvey($rec)
    {
        $db_name = $this->db.".quotesitesurvey";

        DB::beginTransaction();
        try {

            DB::connection($this->cur_connect)->delete("DELETE FROM ".$db_name."
            WHERE idquote = ".$rec->idquote);

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
    public function deleteQuoteSiteSurvey($rec)
    {
        $db_name = $this->db.".quotesitesurvey";

        DB::beginTransaction();
        try {

            DB::connection($this->cur_connect)->delete("DELETE FROM ".$db_name."
                                                        WHERE idquote = ".$rec->idquote);

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

    //Create quotation
    public function createQuotation($rec)
    {

        DB::beginTransaction();
        try {
                    $db_name = $this->db.".quotation";
                    $createquotation = new ModelGlobal();
                    $createquotation->setConnection($this->cur_connect);
                    $createquotation->setTable($db_name);

                    //$createquotation->idquote = $rec->idquote;
                    $createquotation->idsitesurvey = $rec->idsitesurvey;
                    $createquotation->clients = $rec->clients;
                    $createquotation->idquote = $rec->idquote;
                    $createquotation->creationdate = $date = date('Y-m-d H:i:s');
                    
                    $createquotation->save();

        } catch (\Exception $e){

            DB::rollBack();
            $response = array(
                'type' => '0',
                'message' => "ERROR ".$e
            );
            $rec->headers->set('Accept', 'application/json');
            echo json_encode($response);
            exit;
        }
        DB::commit();
        $response = array(
            'type' => 1,
            'message' => 'REGISTER QUOTATION',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    // Listar cliente
    public function listQuotation($rec)
    {
        //echo json_encode($rec->idinterno);
        //exit;
        DB::beginTransaction();
        try {
            $db_name = "servicare_sys";
                
        $listquotation = DB::connection($this->cur_connect)->select(
                                                            "select t0.*, t1.description as namesitesurvey,
                                                            t2.names, t2.surnames, t2.businessname 
                                                            from ".$db_name.'.quotation'." t0
                                                            JOIN ".$db_name.'.sitesurvey'." t1 ON t0.idsitesurvey = t1.id
                                                            JOIN ".$db_name.'.clients'." t2 ON t0.clients = t2.id
                                                            WHERE t0.clients = '".$rec->idclient."'
                                                              AND t0.idquote = '".$rec->idquote."'
                                                            ORDER BY t0.idquotation DESC");

        } catch (\Exception $e){
        
            DB::rollBack();
            $response = array(
                'type' => '0',
                'message' => "ERROR ".$e
            );
            $rec->headers->set('Accept', 'application/json');
            echo json_encode($response);
            exit;
        }
        DB::commit();
        $response = array(
            'type' => 1,
            'listquotation' => $listquotation,
            'message' => 'LIST SITE SURVEy JS OK',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    // Listar cliente
    public function listAllQuotation($rec)
    {
        //echo json_encode($rec->idinterno);
        //exit;
        DB::beginTransaction();
        try {
            $db_name = "servicare_sys";
                
        $listquotation = DB::connection($this->cur_connect)->select(
                                                            "select t0.*, t1.description as namesitesurvey,
                                                            t2.names, t2.surnames, t2.businessname 
                                                            from ".$db_name.'.quotation'." t0
                                                            JOIN ".$db_name.'.sitesurvey'." t1 ON t0.idsitesurvey = t1.id
                                                            JOIN ".$db_name.'.clients'." t2 ON t0.clients = t2.id
                                                            WHERE t0.clients = '".$rec->idclient."'
                                                            ORDER BY t0.idquotation DESC");

        } catch (\Exception $e){
        
            DB::rollBack();
            $response = array(
                'type' => '0',
                'message' => "ERROR ".$e
            );
            $rec->headers->set('Accept', 'application/json');
            echo json_encode($response);
            exit;
        }
        DB::commit();
        $response = array(
            'type' => 1,
            'listquotation' => $listquotation,
            'message' => 'LIST SITE SURVEy JS OK',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    //Actualizar dirección del usuario
    public function updateQuotation($rec)
    {
        //echo json_encode($rec->id);
        //exit;
        $db_name = $this->db.".quotation";

        DB::beginTransaction();
        try {

            DB::connection($this->cur_connect)->update("UPDATE ".$db_name." 
                SET idsitesurvey = '".$rec-> idsitesurvey."'
                WHERE idquotation = '".$rec->idquotation."'");

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
            'message' => 'UPDATED idquotation OK'
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    //Delete Workin Hours
    public function deleteQuotation($rec)
    {
        $db_name = $this->db.".quotation";

        DB::beginTransaction();
        try {

            DB::connection($this->cur_connect)->delete("DELETE FROM ".$db_name."
            WHERE idquotation = ".$rec->idquotation);

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

    //Create scopework
    public function createScopeWork($rec)
    {

        DB::beginTransaction();
        try {
                    $db_name = $this->db.".scopework";
                    $createscopework = new ModelGlobal();
                    $createscopework->setConnection($this->cur_connect);
                    $createscopework->setTable($db_name);

                    //$createscopework->idscopework = $rec->idscopework;
                    $createscopework->idsitesurvey = $rec->idsitesurvey;
                    $createscopework->clients = $rec->clients;
                    $createscopework->creationdate = $date = date('Y-m-d H:i:s');
                    
                    $createscopework->save();

        } catch (\Exception $e){

            DB::rollBack();
            $response = array(
                'type' => '0',
                'message' => "ERROR ".$e
            );
            $rec->headers->set('Accept', 'application/json');
            echo json_encode($response);
            exit;
        }
        DB::commit();
        $response = array(
            'type' => 1,
            'message' => 'REGISTER scopework',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    //Actualizar dirección del usuario
    public function updateScopeWork($rec)
    {
        //echo json_encode($rec->id);
        //exit;
        $db_name = $this->db.".scopework";

        DB::beginTransaction();
        try {

            DB::connection($this->cur_connect)->update("UPDATE ".$db_name." 
                SET idsitesurvey = '".$rec-> idsitesurvey."'
                WHERE idscopework = '".$rec->idscopework."'");

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
            'message' => 'UPDATED scopework OK'
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    //Delete Workin Hours
    public function deleteScopeWork($rec)
    {
        $db_name = $this->db.".scopework";

        DB::beginTransaction();
        try {

            DB::connection($this->cur_connect)->delete("DELETE FROM ".$db_name."
            WHERE idscopework = ".$rec->idscopework);

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

    //Create quotesitesurvey
    public function createQuoteItemsSQFT($rec)
    {

        DB::beginTransaction();
        try {
                    $db_name = $this->db.".quoteitemssquarefeet";
                    $createquoteitemssqft = new ModelGlobal();
                    $createquoteitemssqft->setConnection($this->cur_connect);
                    $createquoteitemssqft->setTable($db_name);

                    $createquoteitemssqft->idquote = $rec->idquote;
                    $createquoteitemssqft->idsitesurvey = $rec->idsitesurvey;
                    $createquoteitemssqft->iditem = $rec->iditem;
                    $createquoteitemssqft->squarefeet = $rec->squarefeet;
                    
                    $createquoteitemssqft->save();

        } catch (\Exception $e){

            DB::rollBack();
            $response = array(
                'type' => '0',
                'message' => "ERROR ".$e
            );
            $rec->headers->set('Accept', 'application/json');
            echo json_encode($response);
            exit;
        }
        DB::commit();
        $response = array(
            'type' => 1,
            'message' => 'REGISTER CONTACTS',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    // Listar cliente
    public function listQuoteItemsSQFT($rec)
    {
        //echo json_encode($rec->idinterno);
        //exit;
        DB::beginTransaction();
        try {
            $db_name = "servicare_sys";
                
        $listquotesitesurvey = DB::connection($this->cur_connect)->select(
                                                            "select t0.*, t1.description as namesitesurvey,
                                                            t2.description as nametypefloor 
                                                            from ".$db_name.'.quoteitemssquarefeet'." t0
                                                            JOIN ".$db_name.'.sitesurvey'." t1 ON t0.idsitesurvey = t1.id
                                                            JOIN ".$db_name.'.partAbuildingsummaryJS'." t2 ON t0.iditem = t2.id
                                                            WHERE t0.idquote = '".$rec->idquote."'
                                                            ORDER BY t0.idquote DESC");

        } catch (\Exception $e){
        
            DB::rollBack();
            $response = array(
                'type' => '0',
                'message' => "ERROR ".$e
            );
            $rec->headers->set('Accept', 'application/json');
            echo json_encode($response);
            exit;
        }
        DB::commit();
        $response = array(
            'type' => 1,
            'listquotesitesurvey' => $listquotesitesurvey,
            'message' => 'LIST SITE SURVEy JS OK',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    //Actualizar dirección del usuario
    public function updateQuoteItemsSQFT($rec)
    {
        //echo json_encode($rec->id);
        //exit;
        $db_name = $this->db.".quoteitemssquarefeet";

        DB::beginTransaction();
        try {

            DB::connection($this->cur_connect)->update("UPDATE ".$db_name." 
                SET iditem = '".$rec-> iditem."',
                    squarefeet = '".$rec-> squarefeet."'
                WHERE idquote = '".$rec->idquote."'");

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
            'message' => 'UPDATED quoteitemssquarefeet OK'
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    //Delete Workin Hours
    public function deleteQuoteItemsSQFT($rec)
    {
        $db_name = $this->db.".quoteitemssquarefeet";

        DB::beginTransaction();
        try {

            DB::connection($this->cur_connect)->delete("DELETE FROM ".$db_name."
            WHERE idquote = '". $rec->idquote."'
            AND iditem = '". $rec->iditem."'");

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

    //Create quotesitesurvey
    public function createQuoteItemsWL($rec)
    {

        DB::beginTransaction();
        try {
                    $db_name = $this->db.".quoteitemsworkloading";
                    $createquoteitemswl = new ModelGlobal();
                    $createquoteitemswl->setConnection($this->cur_connect);
                    $createquoteitemswl->setTable($db_name);

                    $createquoteitemswl->idquote = $rec->idquote;
                    $createquoteitemswl->idsitesurvey = $rec->idsitesurvey;
                    $createquoteitemswl->iditemsquote = $rec->iditemsquote;
                    $createquoteitemswl->quantity = $rec->quantity;
                    
                    $createquoteitemswl->save();

        } catch (\Exception $e){

            DB::rollBack();
            $response = array(
                'type' => '0',
                'message' => "ERROR ".$e
            );
            $rec->headers->set('Accept', 'application/json');
            echo json_encode($response);
            exit;
        }
        DB::commit();
        $response = array(
            'type' => 1,
            'message' => 'REGISTER CONTACTS',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    // Listar cliente
    public function listQuoteItemsWL($rec)
    {
        //echo json_encode($rec->idinterno);
        //exit;
        DB::beginTransaction();
        try {
            $db_name = "servicare_sys";
                
        $listquotesitesurvey = DB::connection($this->cur_connect)->select(
                                                            "select t0.*, t1.description as namesitesurvey,
                                                            t2.description as nametypefloor 
                                                            from ".$db_name.'.quoteitemsworkloading'." t0
                                                            JOIN ".$db_name.'.sitesurvey'." t1 ON t0.idsitesurvey = t1.id
                                                            JOIN ".$db_name.'.partBworkloadingJS'." t2 ON t0.iditemsquote = t2.id
                                                            WHERE t0.iditemsquote = '".$rec->iditemsquote."'
                                                            ORDER BY t0.idquote DESC");

        } catch (\Exception $e){
        
            DB::rollBack();
            $response = array(
                'type' => '0',
                'message' => "ERROR ".$e
            );
            $rec->headers->set('Accept', 'application/json');
            echo json_encode($response);
            exit;
        }
        DB::commit();
        $response = array(
            'type' => 1,
            'listquotesitesurvey' => $listquotesitesurvey,
            'message' => 'LIST SITE SURVEy JS OK',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    // Listar distribución Site Survey JS
    public function listQuotePartsBuilding($rec)
    {
        //echo json_encode($rec->idinterno);
        //exit;
        DB::beginTransaction();
        try {
            $db_name = "servicare_sys";
                
        $listquotesitesurvey = DB::connection($this->cur_connect)->select(
                                                            "select t0.*, t1.description as namesitesurvey,
                                                            t2.description as nametypefloor 
                                                            from ".$db_name.'.quoteitemsworkloading'." t0
                                                            JOIN ".$db_name.'.sitesurvey'." t1 ON t0.idsitesurvey = t1.id
                                                            JOIN ".$db_name.'.partBworkloadingJS'." t2 ON t0.iditemsquote = t2.id
                                                            WHERE t0.idquote = '".$rec->idquote."'
                                                            ORDER BY t0.iditemsquote DESC");

        } catch (\Exception $e){
        
            DB::rollBack();
            $response = array(
                'type' => '0',
                'message' => "ERROR ".$e
            );
            $rec->headers->set('Accept', 'application/json');
            echo json_encode($response);
            exit;
        }
        DB::commit();
        $response = array(
            'type' => 1,
            'listquotesitesurvey' => $listquotesitesurvey,
            'message' => 'LIST SITE SURVEy JS OK',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    //Actualizar dirección del usuario
    public function updateQuoteItemsWL($rec)
    {
        //echo json_encode($rec->id);
        //exit;
        $db_name = $this->db.".quoteitemsworkloading";

        DB::beginTransaction();
        try {

            DB::connection($this->cur_connect)->update("UPDATE ".$db_name." 
                SET iditemsquote = '".$rec-> iditemsquote."',
                    quantity = '".$rec-> quantity."'
                WHERE idquote = '".$rec->idquote."'");

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
            'message' => 'UPDATED quoteitemsworkloading OK'
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    //Delete Workin Hours
    public function deleteQuoteItemsWL($rec)
    {
        $db_name = $this->db.".quoteitemsworkloading";

        DB::beginTransaction();
        try {

            DB::connection($this->cur_connect)->delete("DELETE FROM ".$db_name."
            WHERE idquote      = '". $rec->idquote."'
            AND iditemsquote = '". $rec->iditemsquote."'");

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

    //Create quotesitesurvey
    public function createQuoteCostElements($rec)
    {

        DB::beginTransaction();
        try {
                    $db_name = $this->db.".quotecostelements";
                    $createquotecostelements = new ModelGlobal();
                    $createquotecostelements->setConnection($this->cur_connect);
                    $createquotecostelements->setTable($db_name);

                    $createquotecostelements->idquote = $rec->idquote;
                    $createquotecostelements->idsitesurvey = $rec->idsitesurvey;
                    $createquotecostelements->costelements = $rec->costelements;
                    $createquotecostelements->value = $rec->value;
                    
                    $createquotecostelements->save();

        } catch (\Exception $e){

            DB::rollBack();
            $response = array(
                'type' => '0',
                'message' => "ERROR ".$e
            );
            $rec->headers->set('Accept', 'application/json');
            echo json_encode($response);
            exit;
        }
        DB::commit();
        $response = array(
            'type' => 1,
            'message' => 'REGISTER CONTACTS',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    // Listar cliente
    public function listQuoteCostElements($rec)
    {
        //echo json_encode($rec->idinterno);
        //exit;
        DB::beginTransaction();
        try {
            $db_name = "servicare_sys";
                
        $listquotesitesurvey = DB::connection($this->cur_connect)->select(
                                                            "select t0.*, t1.description as namesitesurvey,
                                                            t2.description as nameelementcost 
                                                            from ".$db_name.'.quotecostelements'." t0
                                                            JOIN ".$db_name.'.sitesurvey'." t1 ON t0.idsitesurvey = t1.id
                                                            JOIN ".$db_name.'.elementscostpersqft'." t2 ON t0.costelements = t2.id
                                                            WHERE t0.idquote = '".$rec->idquote."'
                                                            ORDER BY t0.idquote ASC");

        } catch (\Exception $e){
        
            DB::rollBack();
            $response = array(
                'type' => '0',
                'message' => "ERROR ".$e
            );
            $rec->headers->set('Accept', 'application/json');
            echo json_encode($response);
            exit;
        }
        DB::commit();
        $response = array(
            'type' => 1,
            'listquotesitesurvey' => $listquotesitesurvey,
            'message' => 'LIST SITE SURVEy JS OK',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    //Actualizar dirección del usuario
    public function updateQuoteCostElements($rec)
    {
        //echo json_encode($rec->id);
        //exit;
        $db_name = $this->db.".quotecostelements";

        DB::beginTransaction();
        try {

            DB::connection($this->cur_connect)->update("UPDATE ".$db_name." 
                SET iditemsquote = '".$rec-> iditemsquote."',
                    quantity = '".$rec-> quantity."'
                WHERE idquote = '".$rec->idquote."'");

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
            'message' => 'UPDATED QuoteCostElements OK'
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    //Delete Workin Hours
    public function deleteQuoteCostElements($rec)
    {
        $db_name = $this->db.".quotecostelements";

        DB::beginTransaction();
        try {

            DB::connection($this->cur_connect)->delete("DELETE FROM ".$db_name."
            WHERE idquote      = '". $rec->idquote."'
            AND costelements = '". $rec->costelements."'");

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

    //Create quotesitesurvey
    public function createQuoteSiteSurveyCMP($rec)
    {

        DB::beginTransaction();
        try {
                    $db_name = $this->db.".quotesitesurveycmp";
                    $createsitesurveycmp = new ModelGlobal();
                    $createsitesurveycmp->setConnection($this->cur_connect);
                    $createsitesurveycmp->setTable($db_name);

                    $createsitesurveycmp->idquote = $rec->idquote;
                    $createsitesurveycmp->typetraffic = $rec->typetraffic;
                    $createsitesurveycmp->length = $rec->length;
                    $createsitesurveycmp->width = $rec->width;
                    $createsitesurveycmp->sqft = $rec->sqft;
                    $createsitesurveycmp->quotecreatedby = $rec->quotecreatedby;
                    
                    $createsitesurveycmp->selectcarpetcondition = $rec->selectcarpetcondition;
                    $createsitesurveycmp->selecttrafficcondition = $rec->selecttrafficcondition;
                    $createsitesurveycmp->fibretype = $rec->fibretype;
                    $createsitesurveycmp->pattern = $rec->pattern;
                    $createsitesurveycmp->texture = $rec->texture;
                    $createsitesurveycmp->installationmethod = $rec->installationmethod;
                    $createsitesurveycmp->colour = $rec->colour;
                    $createsitesurveycmp->excesivewear = $rec->excesivewear;
                    $createsitesurveycmp->stains = $rec->stains;
                    $createsitesurveycmp->frayedseams = $rec->frayedseams;
                    $createsitesurveycmp->stretching = $rec->stretching;
                    $createsitesurveycmp->carpetsamples = $rec->carpetsamples;
                    
                    $createsitesurveycmp->save();

        } catch (\Exception $e){

            DB::rollBack();
            $response = array(
                'type' => '0',
                'message' => "ERROR ".$e
            );
            $rec->headers->set('Accept', 'application/json');
            echo json_encode($response);
            exit;
        }
        DB::commit();
        $response = array(
            'type' => 1,
            'message' => 'CREAT QUOTE CPMP',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    // Listar cliente
    public function listQuoteSiteSurveyCMP($rec)
    {
        //echo json_encode($rec->idinterno);
        //exit;
        DB::beginTransaction();
        try {
            $db_name = "servicare_sys";
                
        $listquotesitesurveycpm = DB::connection($this->cur_connect)->select(
                                                            "select t0.*, t2.description as namesitesurvey,
                                                             t3.description as nametypetraffic       
                                                            from ".$db_name.'.quotesitesurveycmp'." t0
                                                            JOIN ".$db_name.'.quotesitesurvey'." t1 ON t0.idquote = t1.idquote
                                                            JOIN ".$db_name.'.sitesurvey'." t2 ON t1.idsitesurvey = t2.id
                                                            JOIN ".$db_name.'.unitcosttrafficJS'." t3 ON t0.typetraffic = t3.id
                                                            WHERE t0.idquote = '".$rec->idquote."'
                                                            ORDER BY t0.idquote DESC");

        } catch (\Exception $e){
        
            DB::rollBack();
            $response = array(
                'type' => '0',
                'message' => "ERROR ".$e
            );
            $rec->headers->set('Accept', 'application/json');
            echo json_encode($response);
            exit;
        }
        DB::commit();
        $response = array(
            'type' => 1,
            'listquotesitesurveycpm' => $listquotesitesurveycpm,
            'message' => 'LIST SITE SURVEy JS OK',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    //Actualizar dirección del usuario
    public function updateQuoteSiteSurveyCMP($rec)
    {
        //echo json_encode($rec->id);
        //exit;
        $db_name = $this->db.".quotesitesurveycmp";

        DB::beginTransaction();
        try {

            DB::connection($this->cur_connect)->update("UPDATE ".$db_name." 
                SET typetraffic = '".$rec-> typetraffic."',
                    quantity = '".$rec-> quantity."',
                    length = '".$rec-> length."',
                    width = '".$rec-> width."',
                    sqft = '".$rec-> sqft."',
                    selectcarpetcondition = '".$rec-> selectcarpetcondition."',
                    selecttrafficcondition = '".$rec-> selecttrafficcondition."',
                    fibretype = '".$rec-> fibretype."',
                    pattern = '".$rec-> pattern."',
                    texture = '".$rec-> texture."',
                    installationmethod = '".$rec-> installationmethod."',
                    colour = '".$rec-> colour."',
                    excesivewear = '".$rec-> excesivewear."',
                    stains = '".$rec-> stains."',
                    frayedseams = '".$rec-> frayedseams."',
                    carpetsamples = '".$rec-> carpetsamples."',
                    stretching = '".$rec-> stretching."'
                WHERE idquote = '".$rec->idquote."'
                AND typetraffic = '". $rec->typetraffic."'");

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
            'message' => 'UPDATED QuoteCostElements OK'
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    //Delete Workin Hours
    public function deleteQuoteSiteSurveyCMP($rec)
    {
        $db_name = $this->db.".quotesitesurveycmp";

        DB::beginTransaction();
        try {

            DB::connection($this->cur_connect)->delete("DELETE FROM ".$db_name."
            WHERE idquote     = '". $rec->ididquote."'
            AND typetraffic = '". $rec->typetraffic."'");

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

    //Create scopeworkjanitorialwr
    public function createScopeWorkJWR($rec)
    {

        DB::beginTransaction();
        try {
                    $db_name = $this->db.".scopeworkjanitorialwr";
                    $createscopeworkjwr = new ModelGlobal();
                    $createscopeworkjwr->setConnection($this->cur_connect);
                    $createscopeworkjwr->setTable($db_name);

                    $createscopeworkjwr->idscopework = $rec->idscopework;
                    $createscopeworkjwr->idquote = $rec->idquote;
                    $createscopeworkjwr->idscopeofjanitorialwork = $rec->idscopeofjanitorialwork;
                    
                    $createscopeworkjwr->daily = $rec->daily;
                    $createscopeworkjwr->weekly = $rec->weekly;
                    $createscopeworkjwr->biweekly = $rec->biweekly;
                    $createscopeworkjwr->monthly = $rec->monthly;
                    $createscopeworkjwr->bimonthly = $rec->bimonthly;
                    $createscopeworkjwr->quarterly = $rec->quarterly;
                    $createscopeworkjwr->semiannual = $rec->semiannual;
                    $createscopeworkjwr->annual = $rec->annual;
                    
                    $createscopeworkjwr->save();

        } catch (\Exception $e){

            DB::rollBack();
            $response = array(
                'type' => '0',
                'message' => "ERROR ".$e
            );
            $rec->headers->set('Accept', 'application/json');
            echo json_encode($response);
            exit;
        }
        DB::commit();
        $response = array(
            'type' => 1,
            'message' => 'CREAT scopeworkjanitorialwr JS',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    // Listar Scope Work por id
    public function listScopeWorkJWR($rec)
    {
        //echo json_encode($rec->idinterno);
        //exit;
        DB::beginTransaction();
        try {
            $db_name = "servicare_sys";
                
        $listsscopeworkjanitorialwr = DB::connection($this->cur_connect)->select(
                                                            "select t0.*, t2.description as namesitesurvey
                                                            from ".$db_name.'.scopeworkjanitorialwr'." t0
                                                            JOIN ".$db_name.'.scopeofjanitorialwork'." t2 ON t0.idscopeofjanitorialwork = t2.id
                                                            WHERE t0.idquote = '".$rec->idquote."'
                                                              AND t0.idscopework = t2.jwr
                                                            ORDER BY t0.idscopework DESC");

        } catch (\Exception $e){
        
            DB::rollBack();
            $response = array(
                'type' => '0',
                'message' => "ERROR ".$e
            );
            $rec->headers->set('Accept', 'application/json');
            echo json_encode($response);
            exit;
        }
        DB::commit();
        $response = array(
            'type' => 1,
            '$listsscopeworkjanitorialwr' => $listsscopeworkjanitorialwr,
            'message' => 'LIST scopeofjanitorialwork JS OK',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    // Listar Scope Work por idquote
    public function listScopeWorkJWRIdQuote($rec)
    {
        //echo json_encode($rec->idinterno);
        //exit;
        DB::beginTransaction();
        try {
            $db_name = "servicare_sys";
                
        $listsscopeworkjanitorialwr = DB::connection($this->cur_connect)->select(
                                                            "select t0.*, t2.description as namesitesurvey
                                                            from ".$db_name.'.scopeworkjanitorialwr'." t0
                                                            JOIN ".$db_name.'.scopeofjanitorialwork'." t2 ON t0.idscopeofjanitorialwork = t2.id
                                                            WHERE t0.idquote = '".$rec->idquote."'
                                                              AND t0.idscopework = t2.jwr
                                                            ORDER BY t0.idquote DESC");

        } catch (\Exception $e){
        
            DB::rollBack();
            $response = array(
                'type' => '0',
                'message' => "ERROR ".$e
            );
            $rec->headers->set('Accept', 'application/json');
            echo json_encode($response);
            exit;
        }
        DB::commit();
        $response = array(
            'type' => 1,
            '$listsscopeworkjanitorialwr' => $listsscopeworkjanitorialwr,
            'message' => 'LIST scopeofjanitorialwork JS OK',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    //Actualizar dirección del usuario
    public function updateScopeWorkJWR($rec)
    {
        //echo json_encode($rec->id);
        //exit;
        $db_name = $this->db.".scopeworkjanitorialwr";

        DB::beginTransaction();
        try {

            DB::connection($this->cur_connect)->update("UPDATE ".$db_name." 
                SET daily = '".$rec-> daily."',
                    weekly = '".$rec-> weekly."',
                    biweekly = '".$rec-> biweekly."',
                    monthly = '".$rec-> monthly."',
                    bimonthly = '".$rec-> bimonthly."',
                    quarterly = '".$rec-> quarterly."',
                    semiannual = '".$rec-> semiannual."',
                    annual = '".$rec-> annual."'
                WHERE idscopework = '".$rec->idscopework."'
                AND idscopeofjanitorialwork = '". $rec->idscopeofjanitorialwork."'");

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
            'message' => 'UPDATED scopeofjanitorialwork OK'
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    //Delete Workin Hours
    public function deleteScopeWorkJWR($rec)
    {
        $db_name = $this->db.".scopeworkjanitorialwr";

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

    //Create quotesitesurvey
    public function createFixedValuesCMP($rec)
    {

        DB::beginTransaction();
        try {
                    $db_name = $this->db.".fixedvaluescmp";
                    $createfixedvaluescmp = new ModelGlobal();
                    $createfixedvaluescmp->setConnection($this->cur_connect);
                    $createfixedvaluescmp->setTable($db_name);

                    $createfixedvaluescmp->description = $rec->description;
                    $createfixedvaluescmp->sitesurvey = $rec->sitesurvey;
                    $createfixedvaluescmp->value = $rec->value;

                    $createfixedvaluescmp->save();

        } catch (\Exception $e){

            DB::rollBack();
            $response = array(
                'type' => '0',
                'message' => "ERROR ".$e
            );
            $rec->headers->set('Accept', 'application/json');
            echo json_encode($response);
            exit;
        }
        DB::commit();
        $response = array(
            'type' => 1,
            'message' => 'CREAT QUOTE CPMP',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    // Listar cliente
    public function listFixedValuesCMP($rec)
    {
        //echo json_encode($rec->idinterno);
        //exit;
        DB::beginTransaction();
        try {
            $db_name = "servicare_sys";
                
        $listfixedvaluescmp = DB::connection($this->cur_connect)->select(
                                                            "select t0.*, t1.description as namesitesurvey
                                                            from ".$db_name.'.fixedvaluescmp'." t0
                                                            JOIN ".$db_name.'.sitesurvey'." t1 ON t1.id = t0.sitesurvey
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
            'listfixedvaluescmp' => $listfixedvaluescmp,
            'message' => 'LIST SITE SURVEy JS OK',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    //Actualizar dirección del usuario
    public function updateFixedValuesCMP($rec)
    {
        //echo json_encode($rec->id);
        //exit;
        $db_name = $this->db.".fixedvaluescmp";

        DB::beginTransaction();
        try {

            DB::connection($this->cur_connect)->update("UPDATE ".$db_name." 
                SET value = '".$rec->value."'
                WHERE id = '". $rec->id."'");

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
            'message' => 'UPDATED fixedvaluescmp OK'
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    //Delete Workin Hours
    public function deleteFixedValuesCMP($rec)
    {
        $db_name = $this->db.".fixedvaluescmp";

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

    //Create quotesitesurvey
    public function createQuoteFixedValuesCMP($rec)
    {

        DB::beginTransaction();
        try {
                    $db_name = $this->db.".quotefixedvaluescmp";
                    $createquotefixedvaluescmp = new ModelGlobal();
                    $createquotefixedvaluescmp->setConnection($this->cur_connect);
                    $createquotefixedvaluescmp->setTable($db_name);

                    $createquotefixedvaluescmp->idquote = $rec->idquote;
                    $createquotefixedvaluescmp->sitesurvey = $rec->sitesurvey;
                    $createquotefixedvaluescmp->description = $rec->description;
                    $createquotefixedvaluescmp->value = $rec->value;

                    $createquotefixedvaluescmp->save();

        } catch (\Exception $e){

            DB::rollBack();
            $response = array(
                'type' => '0',
                'message' => "ERROR ".$e
            );
            $rec->headers->set('Accept', 'application/json');
            echo json_encode($response);
            exit;
        }
        DB::commit();
        $response = array(
            'type' => 1,
            'message' => 'CREAT QUOTE CPMP',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    // Listar cliente
    public function listQuoteFixedValuesCMP($rec)
    {
        //echo json_encode($rec->idinterno);
        //exit;
        DB::beginTransaction();
        try {
            $db_name = "servicare_sys";
                
        $listquotefixedvaluescmp = DB::connection($this->cur_connect)->select(
                                                            "select t0.*, t1.description as namesitesurvey
                                                            from ".$db_name.'.quotefixedvaluescmp'." t0
                                                            JOIN ".$db_name.'.sitesurvey'." t1 ON t1.id = t0.sitesurvey
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
            'listquotefixedvaluescmp' => $listquotefixedvaluescmp,
            'message' => 'LIST QUOTE CMP OK',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    //Actualizar dirección del usuario
    public function updateQuoteFixedValuesCMP($rec)
    {
        //echo json_encode($rec->id);
        //exit;
        $db_name = $this->db.".quotefixedvaluescmp";

        DB::beginTransaction();
        try {

            DB::connection($this->cur_connect)->update("UPDATE ".$db_name." 
                SET value = '".$rec->value."'
                WHERE id = '". $rec->id."'");

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
            'message' => 'UPDATED fixedvaluescmp OK'
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    //Delete Workin Hours
    public function deleteQuoteFixedValuesCMP($rec)
    {
        $db_name = $this->db.".quotefixedvaluescmp";

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

    //Create quotesitesurvey
    public function createServiceAreaCMP($rec)
    {

        DB::beginTransaction();
        try {
                    $db_name = $this->db.".servicearea";
                    $createserviceareacmp = new ModelGlobal();
                    $createserviceareacmp->setConnection($this->cur_connect);
                    $createserviceareacmp->setTable($db_name);

                    $createserviceareacmp->sitesurvey = $rec->sitesurvey;
                    $createserviceareacmp->typetraffic = $rec->typetraffic;
                    $createserviceareacmp->description = $rec->description;
                    $createserviceareacmp->numberperyear = $rec->numberperyear;
                    $createserviceareacmp->feetperhour = $rec->feetperhour;

                    $createserviceareacmp->save();

        } catch (\Exception $e){

            DB::rollBack();
            $response = array(
                'type' => '0',
                'message' => "ERROR ".$e
            );
            $rec->headers->set('Accept', 'application/json');
            echo json_encode($response);
            exit;
        }
        DB::commit();
        $response = array(
            'type' => 1,
            'message' => 'CREAT QUOTE CPMP',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    // Listar cliente
    public function listServiceAreaCMP($rec)
    {
        //echo json_encode($rec->idinterno);
        //exit;
        DB::beginTransaction();
        try {
            $db_name = "servicare_sys";
                
        $listquotesitesurveycpm = DB::connection($this->cur_connect)->select(
                                                            "select t0.*, t1.description as namesitesurvey
                                                            from ".$db_name.'.servicearea'." t0
                                                            JOIN ".$db_name.'.sitesurvey'." t1 ON t1.id = t0.sitesurvey
                                                            JOIN ".$db_name.'.unitcosttrafficJS'." t2 ON t2.id = t0.typetraffic
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
            'listquotesitesurveycpm' => $listquotesitesurveycpm,
            'message' => 'LIST SITE SURVEy JS OK',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    //Actualizar dirección del usuario
    public function updateServiceAreaCMP($rec)
    {
        //echo json_encode($rec->id);
        //exit;
        $db_name = $this->db.".servicearea";

        DB::beginTransaction();
        try {

            DB::connection($this->cur_connect)->update("UPDATE ".$db_name." 
                SET numberperyear = '".$rec->numberperyear."',
                    feetperhour = '".$rec->feetperhour."'
                WHERE id = '". $rec->id."'");

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
            'message' => 'UPDATED fixedvaluescmp OK'
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    //Delete Workin Hours
    public function deleteServiceAreaCMP($rec)
    {
        $db_name = $this->db.".servicearea";

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

    //Create service area customized
    public function createServiceAreaWO($rec)
    {

        DB::beginTransaction();
        try {
                    $db_name = $this->db.".serviceareawocustomized";
                    $createserviceareawo = new ModelGlobal();
                    $createserviceareawo->setConnection($this->cur_connect);
                    $createserviceareawo->setTable($db_name);

                    $createserviceareawo->typeworkorder = $rec->typeworkorder;
                    $createserviceareawo->typesitesurvey = $rec->typesitesurvey;
                    $createserviceareawo->description = $rec->description;

                    $createserviceareawo->save();

        } catch (\Exception $e){

            DB::rollBack();
            $response = array(
                'type' => '0',
                'message' => "ERROR ".$e
            );
            $rec->headers->set('Accept', 'application/json');
            echo json_encode($response);
            exit;
        }
        DB::commit();
        $response = array(
            'type' => 1,
            'message' => 'CREAT QUOTE CPMP',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    // Listar cliente
    public function listServiceAreaWO($rec)
    {
        //echo json_encode($rec->idinterno);
        //exit;
        DB::beginTransaction();
        try {
            $db_name = "servicare_sys";
                
        $listserviceareawo = DB::connection($this->cur_connect)->select(
                                                            "select t0.*, t1.description as nameworkorder,
                                                            t2.namelargegroup as namesitesurvey,
                                                            t1.namelargegroup, t2.id as idtypewo
                                                            from ".$db_name.'.serviceareawocustomized'." t0
                                                            JOIN ".$db_name.'.sitesurvey'." t1 ON t1.id = t0.typeworkorder
                                                            JOIN ".$db_name.'.typesitesurvey'." t2 ON t2.id = t0.typesitesurvey
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
            'listserviceareawo' => $listserviceareawo,
            'message' => 'LIST list service area wo OK',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    // Listar cliente
    public function listOnlyServiceArea($rec)
    {
        //echo json_encode($rec->idinterno);
        //exit;
        DB::beginTransaction();
        try {
            $db_name = "servicare_sys";
                
        $listserviceareawo = DB::connection($this->cur_connect)->select(
                                                            "select t0.*
                                                            from ".$db_name.'.serviceareawocustomized'." t0
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
            'listserviceareawo' => $listserviceareawo,
            'message' => 'LIST list service area wo OK',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    // Listar cliente
    public function listOnlyTypeSiteSurvey($rec)
    {
        //echo json_encode($rec->idinterno);
        //exit;
        DB::beginTransaction();
        try {
            $db_name = "servicare_sys";
                
        $listtypesitesurvey = DB::connection($this->cur_connect)->select(
                                                            "select t0.*
                                                            from ".$db_name.'.sitesurvey'." t0
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
            'listtypesitesurvey' => $listtypesitesurvey,
            'message' => 'LIST list service area wo OK',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    //Actualizar dirección del usuario
    public function updateServiceAreaWO($rec)
    {
        //echo json_encode($rec->id);
        //exit;
        $db_name = $this->db.".serviceareawocustomized";

        DB::beginTransaction();
        try {

            DB::connection($this->cur_connect)->update("UPDATE ".$db_name." 
                SET typesitesurvey = '".$rec->typesitesurvey."',
                    description = '".$rec->description."'
                WHERE id = '". $rec->id."'");

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
            'message' => 'UPDATED Area WO customized OK'
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    //Delete Workin Hours
    public function deleteServiceAreaWO($rec)
    {
        $db_name = $this->db.".serviceareawocustomized";

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

    //Create service subarea
    public function createServiceSubarea($rec)
    {

        DB::beginTransaction();
        try {
                    $db_name = $this->db.".servicesubarea";
                    $createserviceareawo = new ModelGlobal();
                    $createserviceareawo->setConnection($this->cur_connect);
                    $createserviceareawo->setTable($db_name);

                    $createserviceareawo->typeworkorder = $rec->typeworkorder;
                    $createserviceareawo->typesitesurvey = $rec->typesitesurvey;
                    $createserviceareawo->description = $rec->description;

                    $createserviceareawo->save();

        } catch (\Exception $e){

            DB::rollBack();
            $response = array(
                'type' => '0',
                'message' => "ERROR ".$e
            );
            $rec->headers->set('Accept', 'application/json');
            echo json_encode($response);
            exit;
        }
        DB::commit();
        $response = array(
            'type' => 1,
            'message' => 'CREAT QUOTE CPMP',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    // Listar cliente
    public function listServiceSubarea($rec)
    {
        //echo json_encode($rec->idinterno);
        //exit;
        DB::beginTransaction();
        try {
            $db_name = "servicare_sys";
                
        $listservicesubarea = DB::connection($this->cur_connect)->select(
                                                            "select t0.*, t1.description as nameworkorder,
                                                            t2.description as namesitesurvey
                                                            from ".$db_name.'.servicesubarea'." t0
                                                            JOIN ".$db_name.'.sitesurvey'." t1 ON t1.id = t0.typeworkorder
                                                            JOIN ".$db_name.'.typesitesurvey'." t2 ON t2.id = t0.typesitesurvey
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
            'listservicesubarea' => $listservicesubarea,
            'message' => 'LIST servicesubarea wo OK',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    //Actualizar dirección del usuario
    public function updateServiceSubarea($rec)
    {
        //echo json_encode($rec->id);
        //exit;
        $db_name = $this->db.".servicesubarea";

        DB::beginTransaction();
        try {

            DB::connection($this->cur_connect)->update("UPDATE ".$db_name." 
                SET typesitesurvey = '".$rec->typesitesurvey."',
                    description = '".$rec->description."'
                WHERE id = '". $rec->id."'");

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
            'message' => 'UPDATED servicesubarea customized OK'
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    //Delete Workin Hours
    public function deleteServiceSubarea($rec)
    {
        $db_name = $this->db.".servicesubarea";

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

    //Create create Data Work Order Customized
    public function createDWOCustomized($rec)
    {

        DB::beginTransaction();
        try {
                    $db_name = $this->db.".dataworkordercustomized";
                    $createdwocustomized = new ModelGlobal();
                    $createdwocustomized->setConnection($this->cur_connect);
                    $createdwocustomized->setTable($db_name);

                    $createdwocustomized->idquote = $rec->idquote;
                    $createdwocustomized->idclient = $rec->idclient;
                    $createdwocustomized->typeworkorder = $rec->typeworkorder;
                    $createdwocustomized->area = $rec->area;
                    $createdwocustomized->subarea = $rec->subarea;
                    $createdwocustomized->description = $rec->description;
                    $createdwocustomized->value = $rec->value;
                    $createdwocustomized->status = $rec->status;

                    $createdwocustomized->commentworkorder = $rec->commentworkorder;
                    $createdwocustomized->commentprivate = $rec->commentprivate;
                    $createdwocustomized->commentinvoice = $rec->commentinvoice;

                    $createdwocustomized->schedulingdate = $rec->schedulingdate;
                    $createdwocustomized->creationdate = $date = date('Y-m-d H:i:s');

                    $createdwocustomized->save();

        } catch (\Exception $e){

            DB::rollBack();
            $response = array(
                'type' => '0',
                'message' => "ERROR ".$e
            );
            $rec->headers->set('Accept', 'application/json');
            echo json_encode($response);
            exit;
        }
        DB::commit();
        $response = array(
            'type' => 1,
            'message' => 'Created WO Customized',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    // Listar cliente
    public function listDWOCustomizedAll($rec)
    {
        //echo json_encode($rec->idinterno);
        //exit;
        DB::beginTransaction();
        try {
            $db_name = "servicare_sys";
                
        $listwocustomizedall = DB::connection($this->cur_connect)->select(
                                                            "select distinct t0.idquote
                                                            from ".$db_name.'.dataworkordercustomized'." t0
                                                            WHERE t0.idclient = '".$rec->idclient."'
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
            'listwocustomizedall' => $listwocustomizedall,
            'message' => 'LIST Data Work Order OK',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

     // Listar cliente
     public function listAllWOCustomized($rec)
     {
         //echo json_encode($rec->idinterno);
         //exit;
         DB::beginTransaction();
         try {
             $db_name = "servicare_sys";

             //JOIN ".$db_name.'.sitesurvey'." t1 ON t1.id = t0.typeworkorder
                                                            
                 
         $listallwocustomized = DB::connection($this->cur_connect)->select(
                                                             "select t0.*, t1.description as areawo, t1.typesitesurvey,
                                                                     t2.namegroup, t3.description as namesubarea
                                                             from ".$db_name.'.dataworkordercustomized'." t0
                                                             JOIN ".$db_name.'.serviceareawocustomized'." t1 ON t0.area = t1.id
                                                             JOIN ".$db_name.'.sitesurvey'." t2 ON t1.typesitesurvey = t2.id
                                                             JOIN ".$db_name.'.servicesubarea'." t3 ON t0.subarea = t3.id
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
             'listallwocustomized' => $listallwocustomized,
             'message' => 'LIST Data Work Order OK',
         );
         $rec->headers->set('Accept', 'application/json');
         echo json_encode($response);
         exit;
     }

    // Listar cliente
    public function listDWOCustomized($rec)
    {
        //echo json_encode($rec->idinterno);
        //exit;
        DB::beginTransaction();
        try {
            $db_name = "servicare_sys";
                
        $listwocustomized = DB::connection($this->cur_connect)->select(
                                                            "select t0.*, t1.description as nameworkorder,
                                                            t2.description as nameservicearea, 
                                                            t3.description as namesubarea
                                                            from ".$db_name.'.dataworkordercustomized'." t0
                                                            JOIN ".$db_name.'.sitesurvey'." t1 ON t1.id = t0.typeworkorder
                                                            JOIN ".$db_name.'.serviceareawocustomized'." t2 ON t2.id = t0.area
                                                            JOIN ".$db_name.'.servicesubarea'." t3 ON t0.subarea = t3.id
                                                            WHERE t0.idquote = '".$rec->idquote."'
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
            'listwocustomized' => $listwocustomized,
            'message' => 'LIST Data Work Order Customized OK',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    // Listar cliente
    public function listDWOCustomizedIDQuote($rec)
    {
        //echo json_encode($rec->idinterno);
        //exit;
        DB::beginTransaction();
        try {
            $db_name = "servicare_sys";
                
        $listwocustomizedidquote = DB::connection($this->cur_connect)->select(
                                                            "select t0.*, t1.description as nameworkorder,
                                                            t2.description as nameservicearea
                                                            from ".$db_name.'.dataworkordercustomized'." t0
                                                            JOIN ".$db_name.'.sitesurvey'." t1 ON t1.id = t0.typeworkorder
                                                            JOIN ".$db_name.'.serviceareawocustomized'." t2 ON t2.id = t0.area
                                                            JOIN ".$db_name.'.quotesitesurvey'." t3 ON t3.idquote = t0.idquote
                                                            WHERE t0.idquote = '".$rec->idquote."'
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
            'listwocustomizedidquote' => $listwocustomizedidquote,
            'message' => 'LIST DWO Customized ID Quote OK',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    //Actualizar dirección del usuario
    public function updateDWOCustomized($rec)
    {
        //echo json_encode($rec->id);
        //exit;
        $db_name = $this->db.".dataworkordercustomized";

        DB::beginTransaction();
        try {

            DB::connection($this->cur_connect)->update("UPDATE ".$db_name." 
                SET area = '".$rec->area."',
                    subarea = '".$rec->subarea."',
                    description = '".$rec->description."',
                    schedulingdate = '".$rec->schedulingdate."',
                    value = '".$rec->value."'
                WHERE id = '". $rec->id."'");

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
            'message' => 'UPDATED fixedvaluescmp OK'
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

        //Actualizar dirección del usuario
        public function updateEditDWOCustomized($rec)
        {
            //echo json_encode($rec->id);
            //exit;
            $db_name = $this->db.".dataworkordercustomized";

            DB::beginTransaction();
            try {

                DB::connection($this->cur_connect)->update("UPDATE ".$db_name." 
                    SET value = '".$rec->value."'
                    WHERE id = '". $rec->id."'");

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
            'message' => 'UPDATED fixedvaluescmp OK'
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    //Actualizar dirección del usuario
    public function updateDWOCustomizedComment($rec)
    {
        //echo json_encode($rec->id);
        //exit;
        $db_name = $this->db.".dataworkordercustomized";

        DB::beginTransaction();
        try {

            DB::connection($this->cur_connect)->update("UPDATE ".$db_name." 
                SET commentworkorder = '".$rec->commentworkorder."',
                    commentprivate = '".$rec->commentprivate."',
                    commentinvoice = '".$rec->commentinvoice."'
                WHERE id = '". $rec->id."'");

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
            'message' => 'UPDATED fixedvaluescmp OK'
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    //Delete Workin Hours
    public function deleteDWOCustomized($rec)
    {
        $db_name = $this->db.".dataworkordercustomized";

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

    //Create quotesitesurvey
    public function createQuestionsToAskContact($rec)
    {

        DB::beginTransaction();
        try {
                    $db_name = $this->db.".questionstoaskcontactcmp";
                    $createqsttoaskcontact = new ModelGlobal();
                    $createqsttoaskcontact->setConnection($this->cur_connect);
                    $createqsttoaskcontact->setTable($db_name);

                    $createqsttoaskcontact->idquote = $rec->idquote;
                    $createqsttoaskcontact->questions = $rec->questions;
                    $createqsttoaskcontact->answers = $rec->answers;
                    
                    $createqsttoaskcontact->save();

        } catch (\Exception $e){

            DB::rollBack();
            $response = array(
                'type' => '0',
                'message' => "ERROR ".$e
            );
            $rec->headers->set('Accept', 'application/json');
            echo json_encode($response);
            exit;
        }
        DB::commit();
        $response = array(
            'type' => 1,
            'message' => 'CREAT QUESTIONS CPMP',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    // Listar cliente
    public function listQuestionsToAskContact($rec)
    {
        //echo json_encode($rec->idinterno);
        //exit;
        DB::beginTransaction();
        try {
            $db_name = "servicare_sys";
                
        $listquestiontoaskcontcmp = DB::connection($this->cur_connect)->select(
                                                            "select t0.*
                                                            from ".$db_name.'.questionstoaskcontactcmp'." t0
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
            'listquestiontoaskcontcmp' => $listquestiontoaskcontcmp,
            'message' => 'LIST SITE SURVEy JS OK',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    //Actualizar dirección del usuario
    public function updateQuestionsToAskContact($rec)
    {
        //echo json_encode($rec->id);
        //exit;
        $db_name = $this->db.".questionstoaskcontactcmp";

        DB::beginTransaction();
        try {

            DB::connection($this->cur_connect)->update("UPDATE ".$db_name." 
                SET numberperyear = '".$rec->numberperyear."',
                    feetperhour = '".$rec->feetperhour."'
                WHERE id = '". $rec->id."'");

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
            'message' => 'UPDATED fixedvaluescmp OK'
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    //Delete Workin Hours
    public function deleteQuestionsToAskContact($rec)
    {
        $db_name = $this->db.".questionstoaskcontactcmp";

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

    //Create view field clients
    public function createViewFieldClient($rec)
    {

        DB::beginTransaction();
        try {
                    $db_name = $this->db.".viewfieldsclients";
                    $createviewfc = new ModelGlobal();
                    $createviewfc->setConnection($this->cur_connect);
                    $createviewfc->setTable($db_name);

                    $createviewfc->name = $rec->name;
                    $createviewfc->state = $rec->state;
                   
                    $createviewfc->save();

        } catch (\Exception $e){

            DB::rollBack();
            $response = array(
                'type' => '0',
                'message' => "ERROR ".$e
            );
            $rec->headers->set('Accept', 'application/json');
            echo json_encode($response);
            exit;
        }
        DB::commit();
        $response = array(
            'type' => 1,
            'message' => 'REGISTER viewfieldsclients',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    // Listar scopework por Cliente
    public function listViewFieldClient($rec)
    {
        //echo json_encode($rec->idinterno);
        //exit;
        DB::beginTransaction();
        try {
            $db_name = "servicare_sys";
                
        $listsviewfieldsclients = DB::connection($this->cur_connect)->select(
                                                        "select t0.* 
                                                        from ".$db_name.'.viewfieldsclients'." t0
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
            'listsviewfieldsclients' => $listsviewfieldsclients,
            'message' => 'LIST listsviewfieldsclients JS OK',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    //Actualizar dirección del usuario
    public function updateViewFieldClient($rec)
    {
        //echo json_encode($rec->id);
        //exit;
        $db_name = $this->db.".viewfieldsclients";

        DB::beginTransaction();
        try {

            DB::connection($this->cur_connect)->update("UPDATE ".$db_name." 
                SET state = '".$rec-> state."'
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
            'message' => 'UPDATED viewfieldsclients OK'
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    //Delete Workin Hours
    public function deleteViewFieldClient($rec)
    {
        $db_name = $this->db.".scopework";

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

    //Create Compensation
    public function createCompensation($rec)
    {

        DB::beginTransaction();
        try {
                    $db_name = $this->db.".compensation";
                    $createcontact = new ModelGlobal();
                    $createcontact->setConnection($this->cur_connect);
                    $createcontact->setTable($db_name);

                    $createcontact->idemployee = $rec->idemployee;
                    $createcontact->typecompensation = $rec->typecompensation;
                    $createcontact->yesorno = $rec->yesorno;
                    $createcontact->typecompensation = $rec->typecompensation;
                    $createcontact->idclientassociated = $rec->idclientassociated;
                    $createcontact->associatedtoaclient = $rec->associatedtoaclient;
                    $createcontact->valuepaid = $rec->valuepaid;
                    $createcontact->comments = $rec->comments;
                    $createcontact->creationdate = $date = date('Y-m-d H:i:s');
                    $createcontact->updatedate = $date = date('Y-m-d H:i:s');

                    $createcontact->save();

        } catch (\Exception $e){

            DB::rollBack();
            $response = array(
                'type' => '0',
                'message' => "ERROR ".$e
            );
            $rec->headers->set('Accept', 'application/json');
            echo json_encode($response);
            exit;
        }
        DB::commit();
        $response = array(
            'type' => 1,
            'message' => 'REGISTER CONTACTS',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    // Listar cliente
    public function listCompensation($rec)
    {
        //echo json_encode($rec->idinterno);
        //exit;
        DB::beginTransaction();
        try {
            $db_name = "servicare_sys";
                
        $listcompensation = DB::connection($this->cur_connect)->select(
                                                            "select t0.*
                                                            from ".$db_name.'.compensation'." t0
                                                            WHERE t0.idemployee = '".$rec->idemployee."'
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
            'listcompensation' => $listcompensation,
            'message' => 'LIST compensation OK',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    // Listar cliente
    public function listAllCompensation($rec)
    {
        //echo json_encode($rec->idinterno);
        //exit;
        DB::beginTransaction();
        try {
            $db_name = "servicare_sys";
                
        $listcompensation = DB::connection($this->cur_connect)->select(
                                                            "select t0.*
                                                            from ".$db_name.'.compensation'." t0
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
            'listcompensation' => $listcompensation,
            'message' => 'LIST compensation OK',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    //Actualizar dirección del usuario
    public function updateCompensation($rec)
    {
        //echo json_encode($rec->id);
        //exit;
        $db_name = $this->db.".compensation";

        DB::beginTransaction();
        try {

            DB::connection($this->cur_connect)->update("UPDATE ".$db_name." 
                SET typecompensation = '".$rec-> typecompensation."',
                    yesorno = '".$rec-> yesorno."',
                    idclientassociated = '".$rec-> idclientassociated."',
                    associatedtoaclient = '".$rec-> associatedtoaclient."',
                    comments = '".$rec-> comments."',
                    valuepaid = '".$rec-> valuepaid."'
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
            'message' => 'UPDATED CONTACT OK'
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    //Delete Workin Hours
    public function deleteCompensation($rec)
    {
        $db_name = $this->db.".compensation";

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

    //Create Work Regulation
    public function createWorkRegulation($rec)
    {

        DB::beginTransaction();
        try {
                    $db_name = $this->db.".workregulation";
                    $createworkregulation = new ModelGlobal();
                    $createworkregulation->setConnection($this->cur_connect);
                    $createworkregulation->setTable($db_name);

                    $createworkregulation->name = $rec->name;
                    $createworkregulation->idemployee = $rec->idemployee;
                    $createworkregulation->state = $rec->state;
                    $createworkregulation->acceptancedate = $date = date('Y-m-d H:i:s');
                   
                    $createworkregulation->save();

        } catch (\Exception $e){

            DB::rollBack();
            $response = array(
                'type' => '0',
                'message' => "ERROR ".$e
            );
            $rec->headers->set('Accept', 'application/json');
            echo json_encode($response);
            exit;
        }
        DB::commit();
        $response = array(
            'type' => 1,
            'message' => 'REGISTER CONTACTS',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    // Listar Work Regulation
    public function listWorkRegulation($rec)
    {
        //echo json_encode($rec->idinterno);
        //exit;
        DB::beginTransaction();
        try {
            $db_name = "servicare_sys";
                
        $listworkregulation = DB::connection($this->cur_connect)->select(
                                                            "select t0.*, t1.*
                                                            from ".$db_name.'.workregulation'." t0
                                                            JOIN ".$db_name.'.employee'." t1 ON t0.idemployee = t1.id
                                                            WHERE t0.idemployee = '".$rec->idemployee."'
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
            'listworkregulation' => $listworkregulation,
            'message' => 'LIST Work Regulation OK',
        );

        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    //Actualizar Work Regulation
    public function updateWorkRegulation($rec)
    {
        //echo json_encode($rec->id);
        //exit;
        $db_name = $this->db.".workregulation";

        DB::beginTransaction();
        try {

            DB::connection($this->cur_connect)->update("UPDATE ".$db_name." 
                SET state = '".$rec-> state."'
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
            'message' => 'UPDATED Work Regulation OK'
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    //Delete WorkRegulation
    public function deleteWorkRegulation($rec)
    {
        $db_name = $this->db.".workregulation";

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

    //Create Work Regulation
    public function createQuoteSiteSurveyOCJS($rec)
    {
        DB::beginTransaction();
        try {
                    $db_name = $this->db.".quotesitesurveyocjs";
                    $createquotesitesurveyoc = new ModelGlobal();
                    $createquotesitesurveyoc->setConnection($this->cur_connect);
                    $createquotesitesurveyoc->setTable($db_name);

                    $createquotesitesurveyoc->idquote = $rec->idquote;
                    $createquotesitesurveyoc->idclient = $rec->idclient;
                    $createquotesitesurveyoc->typearea = $rec->typearea;
                    $createquotesitesurveyoc->sqft = $rec->sqft;
                    $createquotesitesurveyoc->value = $rec->value;
                    $createquotesitesurveyoc->details = $rec->details;
                    $createquotesitesurveyoc->schedulingdate = $rec->schedulingdate;
                    $createquotesitesurveyoc->creationdate = $date = date('Y-m-d H:i:s');
                    
                    $createquotesitesurveyoc->save();

        } catch (\Exception $e){

            DB::rollBack();
            $response = array(
                'type' => '0',
                'message' => "ERROR ".$e
            );
            $rec->headers->set('Accept', 'application/json');
            echo json_encode($response);
            exit;
        }
        DB::commit();
        $response = array(
            'type' => 1,
            'message' => 'REGISTER quotesitesurveyoc',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    // Listar Work Regulation
    public function listQuoteSiteSurveyOCJS($rec)
    {
        //echo json_encode($rec->idinterno);
        //exit;
        DB::beginTransaction();
        try {
            $db_name = "servicare_sys";
                
        $listsitesurveyoc = DB::connection($this->cur_connect)->select(
                                                            "select t0.*, t1.description as namearea
                                                            from ".$db_name.'.quotesitesurveyocjs'." t0
                                                            JOIN ".$db_name.'.janitorialworkroutines'." t1 ON t0.typearea = t1.id
                                                            WHERE t0.idquote = '".$rec->idquote."'
                                                            ORDER BY t0.idquote DESC");

        } catch (\Exception $e){
        
            DB::rollBack();
            $response = array(
                'type' => '0',
                'message' => "ERROR ".$e
            );
            $rec->headers->set('Accept', 'application/json');
            echo json_encode($response);
            exit;
        }
        DB::commit();
        $response = array(
            'type' => 1,
            'listsitesurveyoc' => $listsitesurveyoc,
            'message' => 'LIST SITE SURVEY OC OK',
        );

        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    // Listar Work Regulation
    public function listQuoteSiteSurveyOCJSAll($rec)
    {
        //echo json_encode($rec->idinterno);
        //exit;
        DB::beginTransaction();
        try {
            $db_name = "servicare_sys";
                
        $listsitesurveyocall = DB::connection($this->cur_connect)->select(
                                                            "select distinct t0.idquote
                                                            from ".$db_name.'.quotesitesurveyocjs'." t0
                                                            WHERE t0.idclient = '".$rec->idclient."'
                                                            ORDER BY t0.idquote DESC");

        } catch (\Exception $e){
        
            DB::rollBack();
            $response = array(
                'type' => '0',
                'message' => "ERROR ".$e
            );
            $rec->headers->set('Accept', 'application/json');
            echo json_encode($response);
            exit;
        }
        DB::commit();
        $response = array(
            'type' => 1,
            'listsitesurveyocall' => $listsitesurveyocall,
            'message' => 'LIST SITE SURVEY OC OK',
        );

        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    // Listar Work Regulation
    public function listQuoteSSOCJSAll($rec)
    {
        //echo json_encode($rec->idinterno);
        //exit;
        DB::beginTransaction();
        try {
            $db_name = "servicare_sys";
                
        $listsitesurveyocjs = DB::connection($this->cur_connect)->select(
                                                            "select t0.*
                                                            from ".$db_name.'.quotesitesurveyocjs'." t0
                                                            ORDER BY t0.idquote DESC");

        } catch (\Exception $e){
        
            DB::rollBack();
            $response = array(
                'type' => '0',
                'message' => "ERROR ".$e
            );
            $rec->headers->set('Accept', 'application/json');
            echo json_encode($response);
            exit;
        }
        DB::commit();
        $response = array(
            'type' => 1,
            'listsitesurveyocjs' => $listsitesurveyocjs,
            'message' => 'LIST SITE SURVEY OC OK',
        );

        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    //Actualizar quotesitesurveyoc
    public function updateQuoteSiteSurveyOCJS($rec)
    {
        //echo json_encode($rec->id);
        //exit;
        $db_name = $this->db.".quotesitesurveyocjs";

        DB::beginTransaction();
        try {

            DB::connection($this->cur_connect)->update("UPDATE ".$db_name." 
                SET typearea = '".$rec-> typearea."',
                    sqft = '".$rec-> sqft."',
                    value = '".$rec-> value."',
                    details = '".$rec-> details."',
                    schedulingdate = '".$rec-> schedulingdate."'
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
            'message' => 'UPDATED Work Regulation OK'
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    //Delete quotesitesurveyoc
    public function deleteQuoteSiteSurveyOCJS($rec)
    {
        $db_name = $this->db.".quotesitesurveyocjs";

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

    //Create quotesitesurvey
    public function createQuoteJanitorialWR($rec)
    {
        DB::beginTransaction();
        try {
                    $db_name = $this->db.".quotejanitorialworkroutines";
                    $createquoteitemssqft = new ModelGlobal();
                    $createquoteitemssqft->setConnection($this->cur_connect);
                    $createquoteitemssqft->setTable($db_name);

                    $createquoteitemssqft->idquote = $rec->idquote;
                    $createquoteitemssqft->itemid = $rec->itemid;
                    $createquoteitemssqft->description = $rec->description;
                    $createquoteitemssqft->required = $rec->required;
                    $createquoteitemssqft->label = $rec->label;
                    
                    $createquoteitemssqft->save();

        } catch (\Exception $e){

            DB::rollBack();
            $response = array(
                'type' => '0',
                'message' => "ERROR ".$e
            );
            $rec->headers->set('Accept', 'application/json');
            echo json_encode($response);
            exit;
        }
        DB::commit();
        $response = array(
            'type' => 1,
            'message' => 'REGISTER QuoteJanitorialWR',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    // Listar cliente
    public function listQuoteJanitorialWR($rec)
    {
        //echo json_encode($rec->idinterno);
        //exit;
        DB::beginTransaction();
        try {
            $db_name = "servicare_sys";
                
        $listquotejanitorialwr = DB::connection($this->cur_connect)->select(
                                                            "select t0.*
                                                            from ".$db_name.'.quotejanitorialworkroutines'." t0
                                                            WHERE t0.idquote = '".$rec->idquote."'
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
            'listquotejanitorialwr' => $listquotejanitorialwr,
            'message' => 'LIST QuoteJanitorialWR OK',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    //Actualizar dirección del usuario
    public function updateQuoteJanitorialWR($rec)
    {
        //echo json_encode($rec->id);
        //exit;
        $db_name = $this->db.".quotejanitorialworkroutines";

        DB::beginTransaction();
        try {

            DB::connection($this->cur_connect)->update("UPDATE ".$db_name." 
                SET itemid = '".$rec-> itemid."',
                    description = '".$rec-> description."',
                    required = '".$rec-> required."',
                    label = '".$rec-> label."'
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
            'message' => 'UPDATED QuoteJanitorialWR OK'
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    //Delete Workin Hours
    public function deleteQuoteJanitorialWR($rec)
    {
        $db_name = $this->db.".quotejanitorialworkroutines";

        DB::beginTransaction();
        try {

            DB::connection($this->cur_connect)->delete("DELETE FROM ".$db_name."
            WHERE idquote = '". $rec->idquote."'
              AND id = '". $rec->id."'");

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

    //Create ScheduleSSJS
    public function createScheduleSSJS($rec)
    {
        DB::beginTransaction();
        try {
                    $db_name = $this->db.".schedulesiteserviceJS";
                    $workinghours = new ModelGlobal();
                    $workinghours->setConnection($this->cur_connect);
                    $workinghours->setTable($db_name);

                    $workinghours->idquote = $rec->idquote;
                    $workinghours->starttime = $rec->starttime;
                    $workinghours->finalhour = $rec->finalhour;
                    $workinghours->day = $rec->day;
                    $workinghours->client = $rec->client;
                    $workinghours->status = $rec->status;
                    $workinghours->comments = $rec->comments;

                    $workinghours->save();

        } catch (\Exception $e){

            DB::rollBack();
            $response = array(
                'type' => '0',
                'message' => "ERROR ".$e
            );
            $rec->headers->set('Accept', 'application/json');
            echo json_encode($response);
            exit;
        }
        DB::commit();
        $response = array(
            'type' => 1,
            'message' => 'REGISTER Schedule Site Survey JS',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    // Listar ScheduleSSJS
    public function listScheduleSSJS($rec)
    {
        //echo json_encode($rec->idinterno);
        //exit;
        DB::beginTransaction();
        try {
            $db_name = "servicare_sys";
                
        $listschedulessjs = DB::connection($this->cur_connect)->select(
                                                "select t0.* 
                                                from ".$db_name.'.schedulesiteserviceJS'." t0
                                                JOIN ".$db_name.'.daydescription'." t1 ON t0.day = t1.day
                                                WHERE t0.idquote = '". $rec->idquote."'
                                                AND t0.status in (4,5,6)
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
            'listschedulessjs' => $listschedulessjs,
            'message' => 'LIST listSchedulessjs OK',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    // Listar ScheduleSSJS
    public function listScheduleSSJSClient($rec)
    {
        //echo json_encode($rec->idinterno);
        //exit;
        DB::beginTransaction();
        try {
            $db_name = "servicare_sys";
                
        $listschedulessjs = DB::connection($this->cur_connect)->select(
                                                "select t0.* 
                                                from ".$db_name.'.schedulesiteserviceJS'." t0
                                                JOIN ".$db_name.'.daydescription'." t1 ON t0.day = t1.day
                                                WHERE t0.client = '". $rec->client."'
                                                AND t0.status in (4,5,6)
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
            'listschedulessjs' => $listschedulessjs,
            'message' => 'LIST listSchedulessjs OK',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    // Listar cliente
    public function listScheduleDaySSJS($rec)
    {
        //echo json_encode($rec->idinterno);
        //exit;
        DB::beginTransaction();
        try {
            $db_name = "servicare_sys";
                
        $listschedulessjsday = DB::connection($this->cur_connect)->select(
                                                "select t0.* 
                                                from ".$db_name.'.schedulesiteserviceJS'." t0
                                                JOIN ".$db_name.'.daydescription'." t1 ON t0.day = t1.day
                                                WHERE t0.idquote = '". $rec->idquote."'
                                                AND t0.day = '". $rec->day."'
                                                AND t0.status in (4,5,6)
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
            'listschedulessjsday' => $listschedulessjsday,
            'message' => 'LIST ScheduleDaySSJS OK',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    //Actualizar dirección del usuario
    public function updateScheduleSSJS($rec)
    {
        //echo json_encode($rec->id);
        //exit;
        $db_name = $this->db.".schedulesiteserviceJS";

        DB::beginTransaction();
        try {

            DB::connection($this->cur_connect)->update("UPDATE ".$db_name." 
                SET day = '".$rec-> day."',
                    starttime = '".$rec-> starttime."',
                    finalhour = '".$rec-> finalhour."',
                    status = '".$rec-> status."',
                    comments = '".$rec-> comments."'
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
            'message' => 'UPDATED CONTRACTS OK'
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    //Delete Workin schedulesiteserviceJS
    public function deleteScheduleSSJS($rec)
    {
        $db_name = $this->db.".schedulesiteserviceJS";

        DB::beginTransaction();
        try {

            DB::connection($this->cur_connect)->delete("DELETE FROM ".$db_name."
            WHERE idquote = '". $rec->ididquote."'
              AND day = '". $rec->day."'");

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

    //Create Quote Site Survey OC CMP
    public function createQuoteSiteSurveyOCCMP($rec)
    {
        DB::beginTransaction();
        try {
                    $db_name = $this->db.".quotesitesurveyoccmp";
                    $createquotessoccmp = new ModelGlobal();
                    $createquotessoccmp->setConnection($this->cur_connect);
                    $createquotessoccmp->setTable($db_name);

                    $createquotessoccmp->idquote = $rec->idquote;
                    $createquotessoccmp->idclient = $rec->idclient;
                    $createquotessoccmp->sqft = $rec->sqft;
                    $createquotessoccmp->low = $rec->low;
                    $createquotessoccmp->medium = $rec->medium;
                    $createquotessoccmp->high = $rec->high;
                    $createquotessoccmp->optionselected = $rec->optionselected;
                    $createquotessoccmp->details = $rec->details;
                    $createquotessoccmp->schedulingdate = $rec->schedulingdate;
                    $createquotessoccmp->creationdate = $date = date('Y-m-d H:i:s');
                    
                    $createquotessoccmp->save();

        } catch (\Exception $e){

            DB::rollBack();
            $response = array(
                'type' => '0',
                'message' => "ERROR ".$e
            );
            $rec->headers->set('Accept', 'application/json');
            echo json_encode($response);
            exit;
        }
        DB::commit();
        $response = array(
            'type' => 1,
            'message' => 'REGISTER quotesitesurveyoc CMP',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    // Listar Work Regulation
    public function listQuoteSiteSurveyOCCMP($rec)
    {
        //echo json_encode($rec->idinterno);
        //exit;
        DB::beginTransaction();
        try {
            $db_name = "servicare_sys";
                
        $listsitesurveyoccmp = DB::connection($this->cur_connect)->select(
                                                            "select t0.*
                                                            from ".$db_name.'.quotesitesurveyoccmp'." t0
                                                            WHERE t0.idquote = '".$rec->idquote."'
                                                            ORDER BY t0.idquote DESC");

        } catch (\Exception $e){
        
            DB::rollBack();
            $response = array(
                'type' => '0',
                'message' => "ERROR ".$e
            );
            $rec->headers->set('Accept', 'application/json');
            echo json_encode($response);
            exit;
        }
        DB::commit();
        $response = array(
            'type' => 1,
            'listsitesurveyoccmp' => $listsitesurveyoccmp,
            'message' => 'LIST SITE SURVEY OC CMP OK',
        );

        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    // Listar Work Regulation
    public function listQuoteSiteSurveyOCCMPAll($rec)
    {
        //echo json_encode($rec->idinterno);
        //exit;
        DB::beginTransaction();
        try {
            $db_name = "servicare_sys";
                
        $listsitesurveyoccmpall = DB::connection($this->cur_connect)->select(
                                                            "select distinct t0.idquote
                                                            from ".$db_name.'.quotesitesurveyoccmp'." t0
                                                            WHERE t0.idclient = '".$rec->idclient."'
                                                            ORDER BY t0.idquote DESC");

        } catch (\Exception $e){
        
            DB::rollBack();
            $response = array(
                'type' => '0',
                'message' => "ERROR ".$e
            );
            $rec->headers->set('Accept', 'application/json');
            echo json_encode($response);
            exit;
        }
        DB::commit();
        $response = array(
            'type' => 1,
            'listsitesurveyoccmpall' => $listsitesurveyoccmpall,
            'message' => 'LIST SITE SURVEY OC CMP OK',
        );

        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    // Listar Work Regulation
    public function listQuoteSSOCCMPAll($rec)
    {
        //echo json_encode($rec->idinterno);
        //exit;
        DB::beginTransaction();
        try {
            $db_name = "servicare_sys";
                
        $listsitesurveyoccmp = DB::connection($this->cur_connect)->select(
                                                            "select t0.*
                                                            from ".$db_name.'.quotesitesurveyoccmp'." t0
                                                            ORDER BY t0.idquote DESC");

        } catch (\Exception $e){
        
            DB::rollBack();
            $response = array(
                'type' => '0',
                'message' => "ERROR ".$e
            );
            $rec->headers->set('Accept', 'application/json');
            echo json_encode($response);
            exit;
        }
        DB::commit();
        $response = array(
            'type' => 1,
            'listsitesurveyoccmp' => $listsitesurveyoccmp,
            'message' => 'LIST SITE SURVEY OC CMP OK',
        );

        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    //Actualizar quotesitesurveyoc
    public function updateQuoteSiteSurveyOCCMP($rec)
    {
        //echo json_encode($rec->id);
        //exit;
        $db_name = $this->db.".quotesitesurveyoccmp";

        DB::beginTransaction();
        try {

            DB::connection($this->cur_connect)->update("UPDATE ".$db_name." 
                SET sqft = '".$rec-> sqft."',
                    details = '".$rec-> details."',
                    low = '".$rec-> low."',
                    medium = '".$rec-> medium."',
                    high = '".$rec-> high."',
                    optionselected = $rec->optionselected,
                    schedulingdate = '".$rec-> schedulingdate."'
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
            'message' => 'UPDATED Work Regulation OK'
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    //Delete quotesitesurveyoc
    public function deleteQuoteSiteSurveyOCCMP($rec)
    {
        $db_name = $this->db.".quotesitesurveyoccmp";

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

    //Create SignedDocuments
    public function createDocumentsEmployee($rec)
    {
        DB::beginTransaction();
        try {
                    $db_name = $this->db.".documentsemployee";
                    $createdocumentsemp = new ModelGlobal();
                    $createdocumentsemp->setConnection($this->cur_connect);
                    $createdocumentsemp->setTable($db_name);

                    //$createdocumentsemp->idscopework = $rec->idscopework;
                    $createdocumentsemp->idemployee = $rec->idemployee;
                    $createdocumentsemp->typedocument = $rec->typedocument;
                    $createdocumentsemp->namedocument = $rec->namedocument;
                    $createdocumentsemp->nameimg = $rec->nameimg;
                    $createdocumentsemp->creationdate = $date = date('Y-m-d H:i:s');
                    $createdocumentsemp->comments = $rec->comments;

                    $createdocumentsemp->save();
                    
                    //Imagen base 64 se pasa a un arreglo
                    $nombrefoto[1] = $rec->nombreimagen1;
                    $foto[1] = $rec->imagen1;

                    for ($i = 1; $i <= $rec->numerodeimagenes; $i++) {
                        $this->GuardarIMG($foto[$i] ,$nombrefoto[$i],'servicaredocuments/');
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

    //Create SignedDocuments
    public function createDocumentsEmployeePDF($rec)
    {
        DB::beginTransaction();
        try {
                    $db_name = $this->db.".documentsemployee";
                    $createdocumentsemp = new ModelGlobal();
                    $createdocumentsemp->setConnection($this->cur_connect);
                    $createdocumentsemp->setTable($db_name);

                    //$createdocumentsemp->idscopework = $rec->idscopework;
                    $createdocumentsemp->idemployee = $rec->idemployee;
                    $createdocumentsemp->typedocument = $rec->typedocument;
                    $createdocumentsemp->namedocument = $rec->namedocument;
                    $createdocumentsemp->nameimg = $rec->nameimg;
                    $createdocumentsemp->creationdate = $date = date('Y-m-d H:i:s');
                    $createdocumentsemp->comments = $rec->comments;

                    $createdocumentsemp->save();
                    
                    //Imagen base 64 se pasa a un arreglo
                    $nombrefoto[1] = $rec->nombreimagen1;
                    $foto[1] = $rec->imagen1;
/*
                    for ($i = 1; $i <= $rec->numerodeimagenes; $i++) {
                        $this->GuardarIMG($foto[$i] ,$nombrefoto[$i],'servicaredocuments/');
                    }
*/
                    for ($i = 1; $i <= $rec->numerodeimagenes; $i++) {
                        $response = FunctionsCustoms::UploadPDFName($foto[$i],$nombrefoto[1],'servicaredocuments/');
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

    // Listar Signed Documents
    public function listDocumentsEmployee($rec)
    {
        //echo json_encode($rec->idinterno);
        //exit;
        DB::beginTransaction();
        try {
            $db_name = "servicare_sys";
                
        $listdocumentsemployee = DB::connection($this->cur_connect)->select(
                                                            "select t0.*, t1.description as nametypedocument
                                                            from ".$db_name.'.documentsemployee'." t0
                                                            JOIN ".$db_name.'.typedocuments'." t1 ON t0.typedocument = t1.id
                                                            WHERE t0.idemployee = '".$rec->idemployee."'
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
            'listdocumentsemployee' => $listdocumentsemployee,
            'message' => 'LIST DOCUMENT EMPLOYEE',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    //Actualizar Signed Documents
    public function updateDocumentsEmployee($rec)
    {
        //echo json_encode($rec->id);
        //exit;
        $db_name = $this->db.".documentsemployee";

        DB::beginTransaction();
        try {

            DB::connection($this->cur_connect)->update("UPDATE ".$db_name." 
                SET typedocument = '".$rec-> typedocument."',
                    namedocument = '".$rec-> namedocument."',
                    nameimg = '".$rec-> nameimg."',
                    comments = '".$rec-> comments."'
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
            'message' => 'UPDATED SITE INVENTORY OK'
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    //Delete Signed Documents
    public function deleteDocumentsEmployee($rec)
    {
        $db_name = $this->db.".documentsemployee";

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

    //Create SignedDocuments
    public function createEmpPolicyHandbook($rec)
    {
        DB::beginTransaction();
        try {
                    $db_name = $this->db.".employeepolicyhandbook";
                    $createdocumentsemp = new ModelGlobal();
                    $createdocumentsemp->setConnection($this->cur_connect);
                    $createdocumentsemp->setTable($db_name);

                    //$createdocumentsemp->idscopework = $rec->idscopework;
                    $createdocumentsemp->idemployee = $rec->idemployee;
                    $createdocumentsemp->namedocument = $rec->namedocument;
                    //$createdocumentsemp->acceptancedate = $date = date('Y-m-d H:i:s');
                    //$createdocumentsemp->lastreadingdate = $date = date('Y-m-d H:i:s');
                    $createdocumentsemp->state = $rec->state;

                    $createdocumentsemp->save();
                    
                    //Imagen base 64 se pasa a un arreglo
                    /*
                    $nombrefoto[1] = $rec->nombreimagen1;
                    $foto[1] = $rec->imagen1;

                    for ($i = 1; $i <= $rec->numerodeimagenes; $i++) {
                        $this->GuardarIMG($foto[$i] ,$nombrefoto[$i],'servicaredocuments/');
                    }
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
            'message' => 'REGISTER EmpPolicyHandbook OK',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    // Listar Signed Documents
    public function listEmpPolicyHandbook($rec)
    {
        //echo json_encode($rec->idinterno);
        //exit;
        DB::beginTransaction();
        try {
            $db_name = "servicare_sys";
                
        $listdocumentsemployee = DB::connection($this->cur_connect)->select(
                                                            "select t0.*, t1.description as namestate
                                                            from ".$db_name.'.employeepolicyhandbook'." t0
                                                            JOIN ".$db_name.'.status'." t1 ON t0.state = t1.id
                                                            WHERE t0.idemployee = '".$rec->idemployee."'
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
            'listdocumentsemployee' => $listdocumentsemployee,
            'message' => 'LIST DOCUMENT EMPLOYEE',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    //Actualizar Signed Documents
    public function updateEmpPolicyInit($rec)
    {
        //echo json_encode($rec->id);
        //exit;
        $db_name = $this->db.".employeepolicyhandbook";

        DB::beginTransaction();
        try {

            DB::connection($this->cur_connect)->update("UPDATE ".$db_name." 
                SET state = '".$rec-> state."',
                    lastreadingdate = '".$date = date('Y-m-d H:i:s')."'
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
            'message' => 'UPDATED SITE INVENTORY OK'
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    //Actualizar Signed Documents
    public function updateEmpPolicyHandbook($rec)
    {
        //echo json_encode($rec->id);
        //exit;
        $db_name = $this->db.".employeepolicyhandbook";

        DB::beginTransaction();
        try {

            DB::connection($this->cur_connect)->update("UPDATE ".$db_name." 
                SET state = '".$rec-> state."',
                    acceptancedate = '".$date = date('Y-m-d H:i:s')."'
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
            'message' => 'UPDATED SITE INVENTORY OK'
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    //Delete Signed Documents
    public function deleteEmpPolicyHandbook($rec)
    {
        $db_name = $this->db.".employeepolicyhandbook";

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

    //Create Master Scope Work Site Survey CMP
    public function createMasterScopeWorkSSCMP($rec)
    {
        DB::beginTransaction();
        try {
                    $db_name = $this->db.".masterscopeworkssurveycmp";
                    $createdocumentsemp = new ModelGlobal();
                    $createdocumentsemp->setConnection($this->cur_connect);
                    $createdocumentsemp->setTable($db_name);

                    $createdocumentsemp->typesitesurvey = $rec->typesitesurvey;
                    $createdocumentsemp->idquote = $rec->idquote;
                    $createdocumentsemp->idtraffic = $rec->idtraffic;
                    $createdocumentsemp->typeservicecmp = $rec->typeservicecmp;
                    $createdocumentsemp->monthone = $rec->monthone;
                    $createdocumentsemp->monthtwo = $rec->monthtwo;
                    $createdocumentsemp->monththree = $rec->monththree;
                    $createdocumentsemp->monthfour = $rec->monthfour;
                    $createdocumentsemp->monthfive = $rec->monthfive;
                    $createdocumentsemp->monthsix = $rec->monthsix;
                    $createdocumentsemp->monthseven = $rec->monthseven;
                    $createdocumentsemp->montheight = $rec->montheight;
                    $createdocumentsemp->monthnine = $rec->monthnine;
                    $createdocumentsemp->monthten = $rec->monthten;
                    $createdocumentsemp->montheleven = $rec->montheleven;
                    $createdocumentsemp->monthtwelve = $rec->monthtwelve;
                    $createdocumentsemp->creationdate = $date = date('Y-m-d H:i:s');
                    
                    $createdocumentsemp->save();
                    
                    //Imagen base 64 se pasa a un arreglo
                    /*
                    $nombrefoto[1] = $rec->nombreimagen1;
                    $foto[1] = $rec->imagen1;

                    for ($i = 1; $i <= $rec->numerodeimagenes; $i++) {
                        $this->GuardarIMG($foto[$i] ,$nombrefoto[$i],'servicaredocuments/');
                    }
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
            'message' => 'REGISTER MasterScopeWorkSSCMP OK',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    // Listar MasterScopeWorkSSCMP
    public function listMasterScopeWorkSSCMP($rec)
    {
        //echo json_encode($rec->idinterno);
        //exit;
        DB::beginTransaction();
        try {
            $db_name = "servicare_sys";
                
        $listmasterscopeworkcmp = DB::connection($this->cur_connect)->select(
                                                            "select t0.*, t1.description as nametypecleaningcmp,
                                                                   t1.comments as descriptioncleaningcmp,
                                                                   t2.descriptioncmp as namedescriptioncmp,
                                                                   t3.description as descriptionsitesurvey
                                                            from ".$db_name.'.masterscopeworkssurveycmp'." t0
                                                            JOIN ".$db_name.'.typecleaningcmp'." t1 ON t0.typeservicecmp = t1.id
                                                            JOIN ".$db_name.'.unitcosttrafficJS'." t2 ON t0.idtraffic = t2.id
                                                            JOIN ".$db_name.'.sitesurvey'." t3 ON t0.typesitesurvey = t3.id
                                                            WHERE t0.idquote = '".$rec->idquote."'
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
            'listmasterscopeworkcmp' => $listmasterscopeworkcmp,
            'message' => 'LIST MasterScopeWorkSSCMP',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    //Actualizar MasterScopeWorkSSCMP
    public function updateMasterScopeWorkSSCMP($rec)
    {
        //echo json_encode($rec->id);
        //exit;
        $db_name = $this->db.".masterscopeworkssurveycmp";

        DB::beginTransaction();
        try {

            DB::connection($this->cur_connect)->update("UPDATE ".$db_name." 
                SET monthone = '".$rec-> monthone."',
                    monthtwo = '".$rec-> monthtwo."',
                    monththree = '".$rec-> monththree."',
                    monthfour = '".$rec-> monthfour."',
                    monthfive = '".$rec-> monthfive."',
                    monthsix = '".$rec-> monthsix."',
                    monthseven = '".$rec-> monthseven."',
                    montheight = '".$rec-> montheight."',
                    monthnine = '".$rec-> monthnine."',
                    monthten = '".$rec-> monthten."',
                    montheleven = '".$rec-> montheleven."',
                    monthtwelve = '".$rec-> monthtwelve."'
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
            'message' => 'UPDATED MasterScopeWorkSSCMP OK'
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    //Delete MasterScopeWorkSSCMP
    public function deleteMasterScopeWorkSSCMP($rec)
    {
        $db_name = $this->db.".masterscopeworkssurveycmp";

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

    //Create SupplyRequestForm
    public function createSupplyRequestForm($rec)
    {
        DB::beginTransaction();
        try {
                    $db_name = $this->db.".supplyrequestform";
                    $createsupplyrequest = new ModelGlobal();
                    $createsupplyrequest->setConnection($this->cur_connect);
                    $createsupplyrequest->setTable($db_name);

                    $createsupplyrequest->idrequestform = $rec->idrequestform;
                    $createsupplyrequest->namerequestform = $rec->namerequestform;
                    $createsupplyrequest->client = $rec->client;
                    $createsupplyrequest->idworkorder = $rec->idworkorder;
                    $createsupplyrequest->itemrequest = $rec->itemrequest;
                    $createsupplyrequest->idnotification = $rec->idnotification;

                    $createsupplyrequest->employeerequest = $rec->employeerequest;
                    $createsupplyrequest->requestsentto = $rec->requestsentto;
                    $createsupplyrequest->requestdate = $date = date('Y-m-d H:i:s');
                    $createsupplyrequest->requireddate = $rec->requireddate;
                    $createsupplyrequest->creationdate = $date = date('Y-m-d H:i:s');
                    $createsupplyrequest->qualityrequested = $rec->qualityrequested;
                    $createsupplyrequest->qualityprovided = $rec->qualityprovided;
                    $createsupplyrequest->state = $rec->state;
                    $createsupplyrequest->itemrequest = $rec->itemrequest;

                    $createsupplyrequest->save();
                    
                    //Imagen base 64 se pasa a un arreglo
                    /*
                    $nombrefoto[1] = $rec->nombreimagen1;
                    $foto[1] = $rec->imagen1;

                    for ($i = 1; $i <= $rec->numerodeimagenes; $i++) {
                        $this->GuardarIMG($foto[$i] ,$nombrefoto[$i],'servicaredocuments/');
                    }
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
            'message' => 'REGISTER SupplyRequestForm OK',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    // Listar SupplyRequestForm
    public function listSupplyRequestAll($rec)
    {
        //echo json_encode($rec->idinterno);
        //exit;
        DB::beginTransaction();
        try {
            $db_name = "servicare_sys";
                
        $listsupplyrequestall = DB::connection($this->cur_connect)->select(
                                                            "select t0.*, t1.description as namestate,
                                                                    t2.description as namerequest,
                                                                    CONCAT(t3.firstname,' ',t3.lastname) as nameempployee,
                                                                    t4.customertype, t4.names, t4.surnames, t4.businessname
                                                            from ".$db_name.'.supplyrequestform'." t0
                                                            JOIN ".$db_name.'.status'." t1 ON t0.state = t1.id
                                                            JOIN ".$db_name.'.mastersupplyrequestform'." t2 ON t0.itemrequest = t2.id
                                                            JOIN ".$db_name.'.employee'." t3 ON t0.employeerequest = t3.id
                                                            JOIN ".$db_name.'.clients'." t4 ON t0.client = t4.id
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
            'listsupplyrequestall' => $listsupplyrequestall,
            'message' => 'LIST Supplyrequest',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    // Listar SupplyRequestForm
    public function listSRFWarehouse($rec)
    {
        //echo json_encode($rec->idinterno);
        //exit;
        DB::beginTransaction();
        try {
            $db_name = "servicare_sys";
                
        $listsupplyrequestall = DB::connection($this->cur_connect)->select(
                                                            "select t0.*, t1.description as namestate,
                                                                    t2.description as namerequest,
                                                                    CONCAT(t3.firstname,' ',t3.lastname) as nameempployee,
                                                                    t4.customertype, t4.names, t4.surnames, t4.businessname
                                                            from ".$db_name.'.supplyrequestform'." t0
                                                            JOIN ".$db_name.'.status'." t1 ON t0.state = t1.id
                                                            JOIN ".$db_name.'.mastersupplyrequestform'." t2 ON t0.itemrequest = t2.id
                                                            JOIN ".$db_name.'.employee'." t3 ON t0.employeerequest = t3.id
                                                            JOIN ".$db_name.'.clients'." t4 ON t0.client = t4.id
                                                            WHERE t0.state = 34
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
            'listsupplyrequestall' => $listsupplyrequestall,
            'message' => 'LIST Supplyrequest',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    // Listar SupplyRequestForm
    public function listOneSupplyRequest($rec)
    {
        //echo json_encode($rec->idinterno);
        //exit;
        DB::beginTransaction();
        try {
            $db_name = "servicare_sys";
                
        $listsupplyrequest = DB::connection($this->cur_connect)->select(
                                                            "select t0.*, t1.description as namestate,
                                                                    t2.description as namerequest,
                                                                    CONCAT(t3.firstname,' ',t3.lastname) as nameempployee,
                                                                    t4.customertype, t4.names, t4.surnames, t4.businessname
                                                            from ".$db_name.'.supplyrequestform'." t0
                                                            JOIN ".$db_name.'.status'." t1 ON t0.state = t1.id
                                                            JOIN ".$db_name.'.mastersupplyrequestform'." t2 ON t0.itemrequest = t2.id
                                                            JOIN ".$db_name.'.employee'." t3 ON t0.employeerequest = t3.id
                                                            JOIN ".$db_name.'.clients'." t4 ON t0.client = t4.id
                                                            WHERE t0.idrequestform = '".$rec->idrequestform."'
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
            'listsupplyrequest' => $listsupplyrequest,
            'message' => 'LIST Supplyrequest',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    // Listar SupplyRequestForm
    public function listSupplyRequestForm($rec)
    {
        //echo json_encode($rec->idinterno);
        //exit;
        DB::beginTransaction();
        try {
            $db_name = "servicare_sys";
                
        $listsupplyrequest = DB::connection($this->cur_connect)->select(
                                                            "select t0.*, t1.description as namestate,
                                                                    t2.description as namerequest,
                                                                    t3.customertype, t3.names,
                                                             t3.surnames, t3.businessname
                                                            from ".$db_name.'.supplyrequestform'." t0
                                                            JOIN ".$db_name.'.status'." t1 ON t0.state = t1.id
                                                            JOIN ".$db_name.'.mastersupplyrequestform'." t2 ON t0.itemrequest = t2.id
                                                            JOIN ".$db_name.'.clients'." t3 ON t0.client = t3.id
                                                            WHERE t0.employeerequest = '".$rec->employeerequest."'
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
            'listsupplyrequest' => $listsupplyrequest,
            'message' => 'LIST Supplyrequest',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    // Listar SupplyRequestForm
    public function listSupplyRequestClient($rec)
    {
        //echo json_encode($rec->idinterno);
        //exit;
        DB::beginTransaction();
        try {
            $db_name = "servicare_sys";
                
        $listrequestclient = DB::connection($this->cur_connect)->select(
                                                            "select t0.*, t1.description as namestate,
                                                                    t2.description as namerequest
                                                            from ".$db_name.'.supplyrequestform'." t0
                                                            JOIN ".$db_name.'.status'." t1 ON t0.state = t1.id
                                                            JOIN ".$db_name.'.mastersupplyrequestform'." t2 ON t0.itemrequest = t2.id
                                                            WHERE t0.client = '".$rec->client."'
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
            'listrequestclient' => $listrequestclient,
            'message' => 'LIST Supplyrequest',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    // Listar SupplyRequestForm
    public function listSupplyRequestSentTo($rec)
    {
        //echo json_encode($rec->idinterno);
        //exit;
        DB::beginTransaction();
        try {
            $db_name = "servicare_sys";
                
        $listsupplyrequestsentto = DB::connection($this->cur_connect)->select(
                                                            "select t0.*, t1.description as namestate,
                                                                    t2.description as namerequest,
                                                                    t3.customertype, t3.names,
                                                                    t3.surnames, t3.businessname 
                                                            from ".$db_name.'.supplyrequestform'." t0
                                                            JOIN ".$db_name.'.status'." t1 ON t0.state = t1.id
                                                            JOIN ".$db_name.'.mastersupplyrequestform'." t2 ON t0.itemrequest = t2.id
                                                            JOIN ".$db_name.'.clients'." t3 ON t0.client = t3.id
                                                            WHERE t0.requestsentto = '".$rec->requestsentto."'
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
            'listsupplyrequestsentto' => $listsupplyrequestsentto,
            'message' => 'LIST Supplyrequest',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    //Actualizar SupplyRequestForm
    public function updateSupplyRequestForm($rec)
    {
        //echo json_encode($rec->id);
        //exit;
        $db_name = $this->db.".supplyrequestform";

        DB::beginTransaction();
        try {

            DB::connection($this->cur_connect)->update("UPDATE ".$db_name." 
                SET state = '".$rec-> state."',
                    requestdate = '".$rec-> requestdate."',
                    requireddate = '".$rec-> requireddate."',
                    qualityrequested = '".$rec-> qualityrequested."',
                    qualityprovided = '".$rec-> qualityprovided."'
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
            'message' => 'UPDATED SupplyRequestForm OK'
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    public function updateStatusSRF($rec)
    {
        //echo json_encode($rec->id);
        //exit;
        $db_name = $this->db.".supplyrequestform";

        DB::beginTransaction();
        try {

            DB::connection($this->cur_connect)->update("UPDATE ".$db_name." 
                SET state = '".$rec-> state."'
                WHERE idnotification = '".$rec->idnotification."'");

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
            'message' => 'UPDATED SupplyRequestForm OK'
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    public function updateQuantitySRF($rec)
    {
        //echo json_encode($rec->id);
        //exit;
        $db_name = $this->db.".supplyrequestform";

        DB::beginTransaction();
        try {

            DB::connection($this->cur_connect)->update("UPDATE ".$db_name." 
                SET qualityprovided = '".$rec->qualityprovided."'
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
            'message' => 'UPDATED SupplyRequestForm OK'
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    public function updateStatusWareHouse($rec)
    {
        //echo json_encode($rec->id);
        //exit;
        $db_name = $this->db.".supplyrequestform";

        DB::beginTransaction();
        try {

            DB::connection($this->cur_connect)->update("UPDATE ".$db_name." 
                SET statewarehouse = '".$rec->statewarehouse."'
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
            'message' => 'UPDATED SupplyRequestForm OK'
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }


    //Delete SupplyRequestForm
    public function deleteSupplyRequestForm($rec)
    {
        $db_name = $this->db.".supplyrequestform";

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

    //Create Vacation Request Form
    public function createVacationRF($rec)
    {
        DB::beginTransaction();
        try {
                    $db_name = $this->db.".vacationrequestform";
                    $createvacationrf = new ModelGlobal();
                    $createvacationrf->setConnection($this->cur_connect);
                    $createvacationrf->setTable($db_name);

                    $createvacationrf->employeerequest = $rec->employeerequest;
                    $createvacationrf->requestsentto = $rec->requestsentto;
                    $createvacationrf->requestdaystotal = $rec->requestdaystotal;
                    $createvacationrf->employeesigned = $rec->employeesigned;
                    $createvacationrf->idnotification = $rec->idnotification;
                    $createvacationrf->employeeapproval = $rec->employeeapproval;
                    $createvacationrf->lastdayworking = $rec->lastdayworking;
                    $createvacationrf->firtsdayworking = $rec->firtsdayworking;
                    $createvacationrf->approvaldate = $rec->approvaldate;
                    $createvacationrf->creationdate = $date = date('Y-m-d H:i:s');
                    $createvacationrf->state = $rec->state;
                    
                    $createvacationrf->state = $rec->state;
                    

                    $createvacationrf->save();
                    
                    //Imagen base 64 se pasa a un arreglo
                    /*
                    $nombrefoto[1] = $rec->nombreimagen1;
                    $foto[1] = $rec->imagen1;

                    for ($i = 1; $i <= $rec->numerodeimagenes; $i++) {
                        $this->GuardarIMG($foto[$i] ,$nombrefoto[$i],'servicaredocuments/');
                    }
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
            'message' => 'REGISTER vacationrequestform OK',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    // Listar vacationrequestform
    public function listVacationRF($rec)
    {
        //echo json_encode($rec->idinterno);
        //exit;
        DB::beginTransaction();
        try {
            $db_name = "servicare_sys";
                
        $listvacationrequest = DB::connection($this->cur_connect)->select(
                                                            "select t0.*, t1.description as namestatus
                                                            from ".$db_name.'.vacationrequestform'." t0
                                                            JOIN ".$db_name.'.status'." t1 ON t0.state = t1.id
                                                            WHERE t0.employeerequest = '".$rec->idemployee."'
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
            'listvacationrequest' => $listvacationrequest,
            'message' => 'LIST Supplyrequest',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    // Listar vacationrequestform
    public function listVacationSentTo($rec)
    {
        //echo json_encode($rec->idinterno);
        //exit;
        DB::beginTransaction();
        try {
            $db_name = "servicare_sys";
                
        $listvacationrequest = DB::connection($this->cur_connect)->select(
                                                            "select t0.*, t1.description as namestatus
                                                            from ".$db_name.'.vacationrequestform'." t0
                                                            JOIN ".$db_name.'.status'." t1 ON t0.state = t1.id
                                                            WHERE t0.requestsentto = '".$rec->idemployee."'
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
            'listvacationrequest' => $listvacationrequest,
            'message' => 'LIST Supplyrequest',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    //Actualizar SupplyRequestForm
    public function updateVacationRF($rec)
    {
        //echo json_encode($rec->id);
        //exit;
        $db_name = $this->db.".vacationrequestform";

        DB::beginTransaction();
        try {

            DB::connection($this->cur_connect)->update("UPDATE ".$db_name." 
                SET state = '".$rec-> state."',
                    requestdaystotal = '".$rec-> requestdaystotal."',
                    lastdayworking = '".$rec-> lastdayworking."',
                    firtsdayworking = '".$rec-> firtsdayworking."',
                    approvaldate = '".$rec-> approvaldate."'
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
            'message' => 'UPDATED vacationrequestform OK'
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    //Actualizar SupplyRequestForm
    public function updateVacationNotif($rec)
    {
        //echo json_encode($rec->id);
        //exit;
        $db_name = $this->db.".vacationrequestform";

        DB::beginTransaction();
        try {

            DB::connection($this->cur_connect)->update("UPDATE ".$db_name." 
                SET state = '".$rec-> state."',
                    approvaldate = '".$date = date('Y-m-d H:i:s')."'
                WHERE idnotification = '".$rec->idnotification."'");

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
            'message' => 'UPDATED vacationrequestform OK'
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    //Delete vacationrequestform
    public function deleteVacationRF($rec)
    {
        $db_name = $this->db.".vacationrequestform";

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

    //Create Certificate Employee
    public function createCertificateEmployee($rec)
    {
        DB::beginTransaction();
        try {
                    $db_name = $this->db.".employeecertificates";
                    $createcertificateemp = new ModelGlobal();
                    $createcertificateemp->setConnection($this->cur_connect);
                    $createcertificateemp->setTable($db_name);

                    $createcertificateemp->idemployee = $rec->idemployee;
                    $createcertificateemp->typecertificate = $rec->typecertificate;
                    $createcertificateemp->namecertificate = $rec->namecertificate;
                    $createcertificateemp->certificatestartdate = $rec->certificatestartdate;
                    $createcertificateemp->certificateenddate = $rec->certificateenddate;
                    $createcertificateemp->creationdate = $date = date('Y-m-d H:i:s');
                    $createcertificateemp->comments = $rec->comments;
                    $createcertificateemp->nameimg = $rec->nameimg;

                    $createcertificateemp->save();
                    
                    //Imagen base 64 se pasa a un arreglo
                    $nombrefoto[1] = $rec->nombreimagen1;
                    $foto[1] = $rec->imagen1;

                    for ($i = 1; $i <= $rec->numerodeimagenes; $i++) {
                        $this->GuardarIMG($foto[$i] ,$nombrefoto[$i],'servicaredocuments/');
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
            'message' => 'REGISTER CertificateEmployee OK',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    //Create Certificate Employee
    public function createCertificateEmployeePDF($rec)
    {
        DB::beginTransaction();
        try {
                    $db_name = $this->db.".employeecertificates";
                    $createcertificateemp = new ModelGlobal();
                    $createcertificateemp->setConnection($this->cur_connect);
                    $createcertificateemp->setTable($db_name);

                    $createcertificateemp->idemployee = $rec->idemployee;
                    $createcertificateemp->typecertificate = $rec->typecertificate;
                    $createcertificateemp->namecertificate = $rec->namecertificate;
                    $createcertificateemp->certificatestartdate = $rec->certificatestartdate;
                    $createcertificateemp->certificateenddate = $rec->certificateenddate;
                    $createcertificateemp->creationdate = $date = date('Y-m-d H:i:s');
                    $createcertificateemp->comments = $rec->comments;
                    $createcertificateemp->nameimg = $rec->nameimg;

                    $createcertificateemp->save();
                    
                    //Imagen base 64 se pasa a un arreglo
                    $nombrefoto[1] = $rec->nombreimagen1;
                    $foto[1] = $rec->imagen1;
/*
                    for ($i = 1; $i <= $rec->numerodeimagenes; $i++) {
                        $this->GuardarIMG($foto[$i] ,$nombrefoto[$i],'servicaredocuments/');
                    }
*/
                    for ($i = 1; $i <= $rec->numerodeimagenes; $i++) {
                        $response = FunctionsCustoms::UploadPDFName($foto[$i],$nombrefoto[1],'servicaredocuments/');
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
            'message' => 'REGISTER CertificateEmployee',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    // Listar Certificate Employee
    public function listCertificateEmployee($rec)
    {
        //echo json_encode($rec->idinterno);
        //exit;
        DB::beginTransaction();
        try {
            $db_name = "servicare_sys";
                
        $listemployeecertificates = DB::connection($this->cur_connect)->select(
                                                            "select t0.*, 
                                                            TRUNCATE(((DATEDIFF(t0.certificateenddate,t0.certificatestartdate))),1) AS time
                                                            from ".$db_name.'.employeecertificates'." t0
                                                            WHERE t0.idemployee = '".$rec->idemployee."'
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
            'listemployeecertificates' => $listemployeecertificates,
            'message' => 'LIST DOCUMENT EMPLOYEE',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    //Actualizar Certificate Employee
    public function updateCertificateEmployee($rec)
    {
        //echo json_encode($rec->id);
        //exit;
        $db_name = $this->db.".employeecertificates";

        DB::beginTransaction();
        try {

            DB::connection($this->cur_connect)->update("UPDATE ".$db_name." 
                SET typecertificate = '".$rec-> typecertificate."',
                    namecertificate = '".$rec-> namecertificate."',
                    certificatestartdate = '".$rec-> certificatestartdate."',
                    certificateenddate = '".$rec-> certificateenddate."',
                    nameimg = '".$rec-> nameimg."',
                    comments = '".$rec-> comments."'
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
            'message' => 'UPDATED Certificate Employee OK'
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    //Delete Certificate Employee
    public function deleteCertificateEmployee($rec)
    {
        $db_name = $this->db.".employeecertificates";

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

    //Create Concept Empleado
    public function createConceptEmp($rec)
    {

        DB::beginTransaction();
        try {
                    $db_name = $this->db.".otheremployeeconcepts";
                    $createconceptoemp = new ModelGlobal();
                    $createconceptoemp->setConnection($this->cur_connect);
                    $createconceptoemp->setTable($db_name);

                    $createconceptoemp->idemployee = $rec->idemployee;
                    $createconceptoemp->concept = $rec->concept;
                    $createconceptoemp->yesorno = $rec->yesorno;
                    $createconceptoemp->value = $rec->value;
                    $createconceptoemp->creationdate = $date = date('Y-m-d H:i:s');
                    
                    $createconceptoemp->save();

        } catch (\Exception $e){

            DB::rollBack();
            $response = array(
                'type' => '0',
                'message' => "ERROR ".$e
            );
            $rec->headers->set('Accept', 'application/json');
            echo json_encode($response);
            exit;
        }
        DB::commit();
        $response = array(
            'type' => 1,
            'message' => 'REGISTER CONTACTS',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    // Listar Concept Empleado
    public function listConceptEmp($rec)
    {
        //echo json_encode($rec->idinterno);
        //exit;
        DB::beginTransaction();
        try {
            $db_name = "servicare_sys";
                
        $listconceptempleado = DB::connection($this->cur_connect)->select(
                                                            "select t0.*, t0.id as idconcept, t1.*, t0.id as idcompensation
                                                            from ".$db_name.'.otheremployeeconcepts'." t0
                                                            JOIN ".$db_name.'.employee'." t1 ON t0.idemployee = t1.id
                                                            WHERE t0.idemployee = '".$rec->idemployee."'
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
            'listconceptempleado' => $listconceptempleado,
            'message' => 'LIST compensation OK',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    //Actualizar Concept Empleado
    public function updateConceptEmp($rec)
    {
        //echo json_encode($rec->id);
        //exit;
        $db_name = $this->db.".otheremployeeconcepts";

        DB::beginTransaction();
        try {

            DB::connection($this->cur_connect)->update("UPDATE ".$db_name." 
                SET concept = '".$rec-> concept."',
                    yesorno = '".$rec->yesorno."',
                    value = '".$rec-> value."'
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
            'message' => 'UPDATED CONTACT OK'
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    //Delete Concept Empleado
    public function deleteConceptEmp($rec)
    {
        $db_name = $this->db.".otheremployeeconcepts";

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

    // Listar Concept Empleado
    public function listStatusWOCalendar($rec)
    {
        //echo json_encode($rec->idinterno);
        //exit;
        DB::beginTransaction();
        try {
            $db_name = "servicare_sys";
                
        $liststatuswocalendar = DB::connection($this->cur_connect)->select(
                                                            "select count(*) as numberwo, t1.description
                                                            from ".$db_name.'.workorders'." t0
                                                            JOIN ".$db_name.'.status'." t1 ON t1.id = t0.status
                                                            GROUP BY t0.status, t1.description");

                                                            /*
                                        SELECT t0.status, t1.description
                                        FROM workorders t0
                                        JOIN status t1 on t1.id = t0.status
                                        GROUP BY t0.status;
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
            'liststatuswocalendar' => $liststatuswocalendar,
            'message' => 'LIST compensation OK',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    // Listar Concept Empleado
    public function listWorkOrderDay($rec)
    {
        //echo json_encode($rec->idinterno);
        //exit;
        DB::beginTransaction();
        try {
            $db_name = "servicare_sys";
                
        $listworkorder = DB::connection($this->cur_connect)->select(
                                                            "select t0.*, t0.id as idwo, 
                                                                    t1.id as idtechnical, t1.uid, t2.uidemp
                                                            from ".$db_name.'.workorders'." t0
                                                            JOIN ".$db_name.'.employee'." t1 ON t0.employee = t1.id
                                                            JOIN ".$db_name.'.viewemployee'." t2 ON t0.supervisor = t2.idemp
                                                            WHERE t0.generatenotification = 0
                                                              AND t0.startdate > '". $rec->startdate."'
                                                              AND t0.enddate < '". $rec->enddate."'");

                                                            /*
                                        SELECT t0.status, t1.description
                                        FROM workorders t0
                                        JOIN status t1 on t1.id = t0.status
                                        GROUP BY t0.status;
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
            'listworkorder' => $listworkorder,
            'message' => 'LIST compensation OK',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    //PaymentMethods
    public function createPaymentMethods($rec)
    {
        DB::beginTransaction();
        try {
                    $db_name = $this->db.".paymentmethods";
                    $paymentmethod = new ModelGlobal();
                    $paymentmethod->setConnection($this->cur_connect);
                    $paymentmethod->setTable($db_name);

                    $paymentmethod->description = $rec->description;
                    $paymentmethod->comments = $rec->comments;

                    $paymentmethod->save();

        } catch (\Exception $e){

            DB::rollBack();
            $response = array(
                'type' => '0',
                'message' => "ERROR ".$e
            );
            $rec->headers->set('Accept', 'application/json');
            echo json_encode($response);
            exit;
        }
        DB::commit();
        $response = array(
            'type' => 1,
            'message' => 'REGISTER PAYMENT METHOD',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    // PaymentMethods
    public function listPaymentMethods($rec)
    {
        //echo json_encode($rec->idinterno);
        //exit;
        DB::beginTransaction();
        try {
            $db_name = "servicare_sys";
                
        $listpaymentmethods = DB::connection($this->cur_connect)->select(
                                                "select t0.* 
                                                from ".$db_name.'.paymentmethods'." t0
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
            'listpaymentmethods' => $listpaymentmethods,
            'message' => 'LIST CONTRACTS OK',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    //Actualizar PaymentMethods
    public function updatePaymentMethods($rec)
    {
        //echo json_encode($rec->id);
        //exit;
        $db_name = $this->db.".paymentmethods";

        DB::beginTransaction();
        try {

            DB::connection($this->cur_connect)->update("UPDATE ".$db_name." 
                SET description = '".$rec-> description."',
                    comments = '".$rec-> comments."'
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
            'message' => 'UPDATED PAYMENT METHODS OK'
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    //Delete PaymentMethods
    public function deletePaymentMethods($rec)
    {
        $db_name = $this->db.".paymentmethods";

        DB::beginTransaction();
        try {

            DB::connection($this->cur_connect)->delete("DELETE FROM ".$db_name."
            WHERE id = '". $rec->id."'");

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

    // List Addres, Municipality, Cities
    public function listAddresClientUnique($rec)
    {
        //echo json_encode($rec->idinterno);
        //exit;
        DB::beginTransaction();
        try {
            $db_name = "servicare_sys";
                
        $listlientaddressunique = DB::connection($this->cur_connect)->select(
                                                "select t0.* 
                                                from ".$db_name.'.viewaddressunique'." t0"); 

        } catch (\Exception $e){
        
            DB::rollBack();
            $response = array(
                'type' => '0',
                'message' => "ERROR ".$e
            );
            $rec->headers->set('Accept', 'application/json');
            echo json_encode($response);
            exit;
        }
        DB::commit();
        $response = array(
            'type' => 1,
            'listlientaddressunique' => $listlientaddressunique,
            'message' => 'LIST CONTRACTS OK',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    //Create Site Inventory Machine
    public function createCSR($rec)
    {
        DB::beginTransaction();
        try {
                    $db_name = $this->db.".customerservicereport";
                    $createcsr = new ModelGlobal();
                    $createcsr->setConnection($this->cur_connect);
                    $createcsr->setTable($db_name);

                    $createcsr->idclient = $rec->idclient;
                    $createcsr->idemployee = $rec->idemployee;
                    $createcsr->idcallnote = $rec->idcallnote;
                    $createcsr->idworkorder = $rec->idworkorder;
                    $createcsr->complaint = $rec->complaint;
                    $createcsr->inspection = $rec->inspection;
                    $createcsr->requisition = $rec->requisition;
                    $createcsr->recorder = $rec->recorder;
                    $createcsr->technician = $rec->technician;
                    $createcsr->inspector = $rec->inspector;
                    $createcsr->followupdate = $rec->followupdate;
                    $createcsr->redoby = $rec->redoby;
                    $createcsr->redodatecomplaint = $rec->redodatecomplaint;
                    $createcsr->csrcompliantdate = $rec->csrcompliantdate;
                    $createcsr->approvalby = $rec->approvalby;
                    $createcsr->mainlobbyreception = $rec->mainlobbyreception;
                    $createcsr->mainlobbyreceptionAB = $rec->mainlobbyreceptionAB;
                    $createcsr->privateoffices = $rec->privateoffices;
                    $createcsr->privateofficesAB = $rec->privateofficesAB;
                    $createcsr->floorhallway = $rec->floorhallway;
                    $createcsr->floorhallwayAB = $rec->floorhallwayAB;
                    $createcsr->description = $rec->description;
                    $createcsr->investigation = $rec->investigation;
                    $createcsr->action = $rec->action;
                    $createcsr->followup = $rec->followup;
                    $createcsr->closure = $rec->closure;
                    $createcsr->generaloffice = $rec->generaloffice;
                    $createcsr->generalofficeAB = $rec->generalofficeAB;
                    $createcsr->status = $rec->status;
                    $createcsr->creationdate = $date = date('Y-m-d H:i:s');
                   
                    $createcsr->save();

        } catch (\Exception $e){

            DB::rollBack();
            $response = array(
                'type' => '0',
                'message' => "ERROR ".$e
            );
            $rec->headers->set('Accept', 'application/json');
            echo json_encode($response);
            exit;
        }
        DB::commit();
        $response = array(
            'type' => 1,
            'message' => 'REGISTER SITE INVENTORY',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    // Listar Site Inventory Machine
    public function listCSR($rec)
    {
        //echo json_encode($rec->idinterno);
        //exit;
        DB::beginTransaction();
        try {
            $db_name = "servicare_sys";
                
        $siteinventory = DB::connection($this->cur_connect)->select(
                                                            "select t0.* 
                                                            from ".$db_name.'.customerservicereport'." t0
                                                            WHERE t0.idclient = '".$rec->idclient."'
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
            'siteinventory' => $siteinventory,
            'message' => 'LIST SITE INVENTORYOK',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    // Listar Site Inventory Machine
    public function listAllCSR($rec)
    {
        //echo json_encode($rec->idinterno);
        //exit;
        DB::beginTransaction();
        try {
            $db_name = "servicare_sys";
                
        $siteinventory = DB::connection($this->cur_connect)->select(
                                                            "select t0.*, t1.id, t1.customertype, t1.names,
                                                             t1.surnames, t1.businessname 
                                                            from ".$db_name.'.customerservicereport'." t0
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
            'siteinventory' => $siteinventory,
            'message' => 'LIST SITE INVENTORYOK',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    // Listar Site Inventory Machine
    public function listCSREmployee($rec)
    {
        //echo json_encode($rec->idinterno);
        //exit;
        DB::beginTransaction();
        try {
            $db_name = "servicare_sys";
                
        $listcsremployee = DB::connection($this->cur_connect)->select(
                                                            "select t0.*, t1.id, t1.customertype, t1.names,
                                                             t1.surnames, t1.businessname, 
                                                             CONCAT(t2.firstname, t2.lastname) as nameredoby
                                                             from ".$db_name.'.customerservicereport'." t0
                                                            JOIN ".$db_name.'.clients'." t1 ON t0.idclient = t1.id
                                                            JOIN ".$db_name.'.employee'." t2 ON t0.redoby = t2.id
                                                            WHERE t0.idemployee = '".$rec->idemployee."'
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
            'listcsremployee' => $listcsremployee,
            'message' => 'LIST SITE INVENTORYOK',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    //Actualizar Site Inventory Machine
    public function updateCSR($rec)
    {
        //echo json_encode($rec->id);
        //exit;
        $db_name = $this->db.".customerservicereport";

        DB::beginTransaction();
        try {

            DB::connection($this->cur_connect)->update("UPDATE ".$db_name." 
                SET complaint = '".$rec-> complaint."',
                    inspection = '".$rec-> inspection."',
                    recorder = '".$rec-> recorder."',
                    technician = '".$rec-> technician."',
                    inspector = '".$rec-> inspector."',
                    followupdate = '".$rec-> followupdate."',
                    redoby = '".$rec-> redoby."',
                    redodatecomplaint = '".$rec-> redodatecomplaint."',
                    csrcompliantdate = '".$rec-> csrcompliantdate."',
                    approvalby = '".$rec-> approvalby."',
                    mainlobbyreception = '".$rec-> mainlobbyreception."',
                    mainlobbyreceptionAB = '".$rec-> mainlobbyreceptionAB."',
                    privateoffices = '".$rec-> privateoffices."',
                    privateofficesAB = '".$rec-> privateofficesAB."',
                    floorhallway = '".$rec-> floorhallway."',
                    floorhallwayAB = '".$rec-> floorhallwayAB."',
                    description = '".$rec-> description."',
                    investigation = '".$rec-> investigation."',
                    action = '".$rec-> action."',
                    followup = '".$rec-> followup."',
                    closure = '".$rec-> closure."',
                    generaloffice = '".$rec-> generaloffice."',
                    generalofficeAB = '".$rec-> generalofficeAB."',
                    status = '".$rec-> status."'
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

    //Actualizar Site Inventory Machine
    public function updateCommentsCSR($rec)
    {
        //echo json_encode($rec->id);
        //exit;
        $db_name = $this->db.".customerservicereport";

        DB::beginTransaction();
        try {

            DB::connection($this->cur_connect)->update("UPDATE ".$db_name." 
                SET comments = '".$rec-> comments."',
                    status = '".$rec-> status."'
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
    public function deleteCSR($rec)
    {
        $db_name = $this->db.".customerservicereport";

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

    //Create Total Site Survey CMP
    public function createSSCMP($rec)
    {

        DB::beginTransaction();
        try {
                    $db_name = $this->db.".totalsitesurveycmp";
                    $createsscmp = new ModelGlobal();
                    $createsscmp->setConnection($this->cur_connect);
                    $createsscmp->setTable($db_name);

                    $createsscmp->idquote = $rec->idquote;
                    $createsscmp->typesitesurvey = $rec->typesitesurvey;
                    $createsscmp->traffichigh = $rec->traffichigh;
                    $createsscmp->totHigh = $rec->totHigh;
                    $createsscmp->totHoursVisitsHigh = $rec->totHoursVisitsHigh;
                    $createsscmp->totLabourCostVisitsHigh = $rec->totLabourCostVisitsHigh;
                    $createsscmp->totMaterialCostVisitsHigh = $rec->totMaterialCostVisitsHigh;
                    $createsscmp->totProfitHigh = $rec->totProfitHigh;
                    $createsscmp->totSupervisionTrainingHigh = $rec->totSupervisionTrainingHigh;
                    $createsscmp->totOverheadInsuranceHigh = $rec->totOverheadInsuranceHigh;
                    $createsscmp->totSalesServiceHigh = $rec->totSalesServiceHigh;

                    $createsscmp->trafficlow = $rec->trafficlow;
                    $createsscmp->totLow = $rec->totLow;
                    $createsscmp->totHoursVisitsLow = $rec->totHoursVisitsLow;
                    $createsscmp->totLabourCostVisitsLow = $rec->totLabourCostVisitsLow;
                    $createsscmp->totMaterialCostVisitsLow = $rec->totMaterialCostVisitsLow;
                    $createsscmp->totProfitLow = $rec->totProfitLow;
                    $createsscmp->totSupervisionTrainingLow = $rec->totSupervisionTrainingLow;
                    $createsscmp->totOverheadInsuranceLow = $rec->totOverheadInsuranceLow;
                    $createsscmp->totSalesServiceLow = $rec->totSalesServiceLow;

                    $createsscmp->trafficmedium = $rec->trafficmedium;
                    $createsscmp->totMedium = $rec->totMedium;
                    $createsscmp->totHoursVisitsMedium = $rec->totHoursVisitsMedium;
                    $createsscmp->totLabourCostVisitsMedium = $rec->totLabourCostVisitsMedium;
                    $createsscmp->totMaterialCostVisitsMedium = $rec->totMaterialCostVisitsMedium;
                    $createsscmp->totProfitMedium = $rec->totProfitMedium;
                    $createsscmp->totSupervisionTrainingMedium = $rec->totSupervisionTrainingMedium;
                    $createsscmp->totOverheadInsuranceMedium = $rec->totOverheadInsuranceMedium;
                    $createsscmp->totSalesServiceMedium = $rec->totSalesServiceMedium;

                    
                    $createsscmp->save();

        } catch (\Exception $e){

            DB::rollBack();
            $response = array(
                'type' => '0',
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

    // Listar supplier
    public function listSSCMP($rec)
    {
        //echo json_encode($rec->idinterno);
        //exit;
        DB::beginTransaction();
        try {
            $db_name = "servicare_sys";
                
        $listtotalsurveycmp = DB::connection($this->cur_connect)->select(
                                                "select t0.* 
                                                from ".$db_name.'.totalsitesurveycmp'." t0
                                                WHERE t0.idquote = '".$rec->idquote."'
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
            'listtotalsurveycmp' => $listtotalsurveycmp,
            'message' => 'REGISTRO EXITOSO',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

     //Actualizar QuoteSiteSurvey
     public function updateTotalCMP($rec)
     {
         //echo json_encode($rec->id);
         //exit;
         $db_name = $this->db.".totalsitesurveycmp";
 
         DB::beginTransaction();
         try {
 
             DB::connection($this->cur_connect)->update("UPDATE ".$db_name." 
                 SET totHigh = '".$rec-> totHigh."',
                     totLow = '".$rec-> totLow."',
                     totMedium = '".$rec-> totMedium."'
                 WHERE idquote = '".$rec->idquote."'");
 
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
             'message' => 'UPDATED TOTAL SS CMP OK'
         );
         $rec->headers->set('Accept', 'application/json');
         echo json_encode($response);
         exit;
     }

    // Listar supplier
    public function listEmpClassifications($rec)
    {
        //echo json_encode($rec->idinterno);
        //exit;
        DB::beginTransaction();
        try {
            $db_name = "servicare_sys";
                
        $listempclassifications = DB::connection($this->cur_connect)->select(
                                                "select t0.* 
                                                from ".$db_name.'.employeeclassifications'." t0
                                                WHERE t0.id > 0
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
            'listempclassifications' => $listempclassifications,
            'message' => 'REGISTRO EXITOSO',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    //Create Site Inventory Machine
    public function createAdditionalEmp($rec)
    {
        DB::beginTransaction();
        try {
                    $db_name = $this->db.".additionalempworkorder";
                    $createadditionalemp = new ModelGlobal();
                    $createadditionalemp->setConnection($this->cur_connect);
                    $createadditionalemp->setTable($db_name);

                    $createadditionalemp->employee = $rec->employee;
                    $createadditionalemp->idworkorder = $rec->idworkorder;
                    $createadditionalemp->creationdate = $date = date('Y-m-d H:i:s');
                   
                    $createadditionalemp->save();

        } catch (\Exception $e){

            DB::rollBack();
            $response = array(
                'type' => '0',
                'message' => "ERROR ".$e
            );
            $rec->headers->set('Accept', 'application/json');
            echo json_encode($response);
            exit;
        }
        DB::commit();
        $response = array(
            'type' => 1,
            'message' => 'REGISTER Additional Emp',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    // Listar Site Inventory Machine
    public function listAdditionalEmp($rec)
    {
        //echo json_encode($rec->idinterno);
        //exit;
        DB::beginTransaction();
        try {
            $db_name = "servicare_sys";
                
        $listadditionalemp = DB::connection($this->cur_connect)->select(
                                                            "select t0.* 
                                                            from ".$db_name.'.additionalempworkorder'." t0
                                                            WHERE t0.employee = '".$rec->employee."'
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
            'listadditionalemp' => $listadditionalemp,
            'message' => 'LIST Additional Emp Work Order OK',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    // Listar Site Inventory Machine
    public function listAdditionalIdWO($rec)
    {
        //echo json_encode($rec->idinterno);
        //exit;
        DB::beginTransaction();
        try {
            $db_name = "servicare_sys";
                
        $listadditionalwo = DB::connection($this->cur_connect)->select(
                                                            "select t0.*, t1.firstname, t1.lastname
                                                            from ".$db_name.'.additionalempworkorder'." t0
                                                            JOIN ".$db_name.'.employee'." t1 ON t0.employee = t1.id
                                                            WHERE t0.idworkorder = '".$rec->idworkorder."'
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
            'listadditionalwo' => $listadditionalwo,
            'message' => 'LIST Additional Emp Work Order OK',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }


    //Actualizar Site Inventory Machine
    public function updateAdditionalEmp($rec)
    {
        //echo json_encode($rec->id);
        //exit;
        $db_name = $this->db.".additionalempworkorder";

        DB::beginTransaction();
        try {

            DB::connection($this->cur_connect)->update("UPDATE ".$db_name." 
                SET employee = '".$rec-> employee."'
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
    public function deleteAdditionalEmp($rec)
    {
        $db_name = $this->db.".additionalempworkorder";

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

    //Create Site Inventory Machine
    public function createInvoice($rec)
    {
        DB::beginTransaction();
        try {
                    $db_name = $this->db.".invoice";
                    $createinvoice = new ModelGlobal();
                    $createinvoice->setConnection($this->cur_connect);
                    $createinvoice->setTable($db_name);

                    $createinvoice->invoice = $rec->invoice;
                    $createinvoice->idclient = $rec->idclient;
                    $createinvoice->idscopework = $rec->idscopework;
                    $createinvoice->idsitesurvey = $rec->idsitesurvey;
                    $createinvoice->amount = $rec->amount;
                    $createinvoice->status = $rec->status;
                    $createinvoice->invoicedate = $rec->invoicedate;
                    $createinvoice->updatedate = $date = date('Y-m-d H:i:s');
                    $createinvoice->creationdate = $date = date('Y-m-d H:i:s');
                   
                    $createinvoice->save();

        } catch (\Exception $e){

            DB::rollBack();
            $response = array(
                'type' => '0',
                'message' => "ERROR ".$e
            );
            $rec->headers->set('Accept', 'application/json');
            echo json_encode($response);
            exit;
        }
        DB::commit();
        $response = array(
            'type' => 1,
            'message' => 'REGISTER INVOICE',
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
            $db_name = "servicare_sys";
                
        $listinvoice = DB::connection($this->cur_connect)->select(
                                                            "select t0.*, t0.id as idinvoice, t1.names, t1.surnames,
                                                                    t1.businessname, t2.group as idgrupsitesurvey,
                                                                    t2.namegroup, t2.type as typesitesurvey,
                                                                    t2.group as idgroup, t1.customertype,
                                                                    t2.namelargegroup,
                                                                    t1.accountmanager, t1.commercialadvisor
                                                            from ".$db_name.'.invoice'." t0
                                                            JOIN ".$db_name.'.clients'." t1 ON t0.idclient = t1.id
                                                            JOIN ".$db_name.'.sitesurvey'." t2 ON t0.idsitesurvey = t2.id
                                                            ORDER BY t0.invoicedate ASC");

        } catch (\Exception $e){
        
            DB::rollBack();
            $response = array(
                'type' => '0',
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
                    generateinvoice = '".$rec-> generateinvoice."',
                    usersentinvoice = '".$rec-> usersentinvoice."',
                    userconfirmspayment = '".$rec-> userconfirmspayment."',
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

    //Actualizar Site Inventory Machine
    public function editInvoice($rec)
    {
        //echo json_encode($rec->id);
        //exit;
        $db_name = $this->db.".invoice";

        DB::beginTransaction();
        try {

            DB::connection($this->cur_connect)->update("UPDATE ".$db_name." 
                SET amount = '".$rec-> amount."',
                    invoicedate = '".$rec-> invoicedate."',
                    changeinvoice = '".$rec-> changeinvoice."',
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

    //Create Security Access Report
    public function createSAR($rec)
    {
        DB::beginTransaction();
        try {
                    $db_name = $this->db.".securityaccessreport";
                    $createsar = new ModelGlobal();
                    $createsar->setConnection($this->cur_connect);
                    $createsar->setTable($db_name);

                    $createsar->idclient = $rec->idclient;
                    $createsar->idemployee = $rec->idemployee;
                    $createsar->locationaddress = $rec->locationaddress;
                    $createsar->mainintersection = $rec->mainintersection;
                    $createsar->phonenumber = $rec->phonenumber;
                    $createsar->contactname = $rec->contactname;
                    $createsar->totalsquarefootage = $rec->totalsquarefootage;
                    $createsar->typeofservice = $rec->typeofservice;
                    $createsar->areasofservice = $rec->areasofservice;
                    $createsar->frequency = $rec->frequency;
                    $createsar->floorplans = $rec->floorplans;
                    $createsar->numberoffloors = $rec->numberoffloors;
                    $createsar->timerestrictions = $rec->timerestrictions;
                    $createsar->specificdays = $rec->specificdays;
                    $createsar->donotstartbefore = $rec->donotstartbefore;
                    $createsar->donotfinishlaterthan = $rec->donotfinishlaterthan;
                    $createsar->cleaningconfirmation = $rec->cleaningconfirmation;
                    $createsar->numberofdays = $rec->numberofdays;
                    $createsar->closestentrancetoareas = $rec->closestentrancetoareas;
                    $createsar->parkinginformation = $rec->parkinginformation;
                    $createsar->entranceprocedures = $rec->entranceprocedures;
                    $createsar->exitprocedures = $rec->exitprocedures;
                    $createsar->leaveworkorder = $rec->leaveworkorder;
                    $createsar->ifyeswhere = $rec->ifyeswhere;
                    $createsar->keyboxnumber = $rec->keyboxnumber;
                    $createsar->passcard = $rec->passcard;
                    $createsar->opens = $rec->opens;
                    $createsar->companyname = $rec->companyname;
                    $createsar->telephonenumber = $rec->telephonenumber;
                    $createsar->securityalarmcode = $rec->securityalarmcode;
                    $createsar->alarmpassword = $rec->alarmpassword;
                    $createsar->emergencycontactname = $rec->emergencycontactname;
                    $createsar->emergencycontactphone = $rec->emergencycontactphone;
                    $createsar->electrical = $rec->electrical;
                    $createsar->water = $rec->water;
                    $createsar->lighting = $rec->lighting;
                    $createsar->equipment = $rec->equipment;
                    $createsar->solutions = $rec->solutions;
                    $createsar->specialnote = $rec->specialnote;
                    $createsar->creationdate = $date = date('Y-m-d H:i:s');

                    $createsar->save();

        } catch (\Exception $e){

            DB::rollBack();
            $response = array(
                'type' => '0',
                'message' => "ERROR ".$e
            );
            $rec->headers->set('Accept', 'application/json');
            echo json_encode($response);
            exit;
        }
        DB::commit();
        $response = array(
            'type' => 1,
            'message' => 'REGISTER Security Access Report',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    // Listar Site Inventory Machine
    public function listSAR($rec)
    {
        //echo json_encode($rec->idinterno);
        //exit;
        DB::beginTransaction();
        try {
            $db_name = "servicare_sys";
                
        $siteinventory = DB::connection($this->cur_connect)->select(
                                                            "select t0.* 
                                                            from ".$db_name.'.securityaccessreport'." t0
                                                            WHERE t0.idclient = '".$rec->idclient."'
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
            'siteinventory' => $siteinventory,
            'message' => 'LIST SITE INVENTORYOK',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    // Listar Site Inventory Machine
    public function listAllSAR($rec)
    {
        //echo json_encode($rec->idinterno);
        //exit;
        DB::beginTransaction();
        try {
            $db_name = "servicare_sys";
                
        $siteinventory = DB::connection($this->cur_connect)->select(
                                                            "select t0.* 
                                                            from ".$db_name.'.securityaccessreport'." t0
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
            'siteinventory' => $siteinventory,
            'message' => 'LIST SITE INVENTORYOK',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    // Listar Site Inventory Machine
    public function listSAREmployee($rec)
    {
        //echo json_encode($rec->idinterno);
        //exit;
        DB::beginTransaction();
        try {
            $db_name = "servicare_sys";
                
        $listsar = DB::connection($this->cur_connect)->select(
                                                            "select t0.* 
                                                            from ".$db_name.'.securityaccessreport'." t0
                                                            WHERE t0.idemployee = '".$rec->idemployee."'
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
            'listsar' => $listsar,
            'message' => 'LIST SITE INVENTORYOK',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    //Actualizar Site Inventory Machine
    public function updateSAR($rec)
    {
        //echo json_encode($rec->id);
        //exit;
        $db_name = $this->db.".securityaccessreport";

        DB::beginTransaction();
        try {

            DB::connection($this->cur_connect)->update("UPDATE ".$db_name." 
                SET complaint = '".$rec-> complaint."'
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
    public function deleteSAR($rec)
    {
        $db_name = $this->db.".securityaccessreport";

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

    //Crete employee time control
    public function createEmployeeTC($rec)
    {
        DB::beginTransaction();
        try {
                    $db_name = $this->db.".employeetimecontrol";
                    $createemployeetc = new ModelGlobal();
                    $createemployeetc->setConnection($this->cur_connect);
                    $createemployeetc->setTable($db_name);

                    $createemployeetc->idworkorder = $rec->idworkorder;
                    $createemployeetc->idemployee = $rec->idemployee;
                    $createemployeetc->workstarttime = $rec->workstarttime;
                    $createemployeetc->workfinishtime = $rec->workfinishtime;
                    $createemployeetc->workingtime = $rec->workingtime;
                    $createemployeetc->latitude = $rec->latitude;
                    $createemployeetc->longitude = $rec->longitude;
                    $createemployeetc->creationdate = $date = date('Y-m-d H:i:s');
                    $createemployeetc->save();

        } catch (\Exception $e){

            DB::rollBack();
            $response = array(
                'type' => '0',
                'message' => "ERROR ".$e
            );
            $rec->headers->set('Accept', 'application/json');
            echo json_encode($response);
            exit;
        }
        DB::commit();
        $response = array(
            'type' => 1,
            'message' => 'REGISTER EMPLOYEE TIME CONTROL',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    //List EmployeeTC
    public function listEmployeeTC($rec)
    {
        //echo json_encode($rec->idinterno);
        //exit;
        DB::beginTransaction();
        try {
            $db_name = "servicare_sys";
                
        $listemployetc = DB::connection($this->cur_connect)->select(
                                                            "select t0.*, t1.*, t0.id as idtimecontrol
                                                            from ".$db_name.'.employeetimecontrol'." t0
                                                            JOIN ".$db_name.'.employee'." t1 ON t0.idemployee = t1.id
                                                            WHERE t0.idemployee = '".$rec->idemployee."'
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
            'listemployetc' => $listemployetc,
            'message' => 'list Employee C',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    //List EmployeeTC
    public function listEmployeeTCWO($rec)
    {
        //echo json_encode($rec->idinterno);
        //exit;
        DB::beginTransaction();
        try {
            $db_name = "servicare_sys";
                
        $listemployetc = DB::connection($this->cur_connect)->select(
                                                            "select t0.*, t1.*, t0.id as idtimecontrol,
                                                            t2.client, t3.customertype, t3.names,  t3.surnames,
                                                            t3.businessname, t4.address1 as addressclien,
                                                            t4.latitud as latitudclient,
                                                            t4.longitud as longitudclient,
                                                            t4.addressgeolocation as addressgeolocation
                                                            from ".$db_name.'.employeetimecontrol'." t0
                                                            JOIN ".$db_name.'.employee'." t1 ON t0.idemployee = t1.id
                                                            JOIN ".$db_name.'.workorders'." t2 ON t0.idworkorder = t2.id
                                                            JOIN ".$db_name.'.clients'." t3 ON t2.client = t3.id
                                                            JOIN ".$db_name.'.addressclient'." t4 ON t2.client = t4.idclient
                                                            WHERE t4.typeaddress = 1
                                                              AND t0.idworkorder = '".$rec->idworkorder."'");


        } catch (\Exception $e){
        
            DB::rollBack();
            $response = array(
                'type' => '0',
                'message' => "ERROR ".$e
            );
            $rec->headers->set('Accept', 'application/json');
            echo json_encode($response);
            exit;
        }
        DB::commit();
        $response = array(
            'type' => 1,
            'listemployetc' => $listemployetc,
            'message' => 'list Employee C',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    //List EmployeeTC
    public function listControlEmployee($rec)
    {
        //echo json_encode($rec->idinterno);
        //exit;
        DB::beginTransaction();
        try {
            $db_name = "servicare_sys";
                
        $listemployetc = DB::connection($this->cur_connect)->select(
                                                            "select t0.*, t1.*, t0.id as idtimecontrol,
                                                            t2.client, t3.customertype, t3.names,  t3.surnames,
                                                            t3.businessname, t4.address1 as addressclien,
                                                            t4.latitud as latitudclient,
                                                            t4.longitud as longitudclient,
                                                            t4.addressgeolocation as addressgeolocation
                                                            from ".$db_name.'.employeetimecontrol'." t0
                                                            JOIN ".$db_name.'.employee'." t1 ON t0.idemployee = t1.id
                                                            JOIN ".$db_name.'.workorders'." t2 ON t0.idworkorder = t2.id
                                                            JOIN ".$db_name.'.clients'." t3 ON t2.client = t3.id
                                                            JOIN ".$db_name.'.addressclient'." t4 ON t2.client = t4.idclient
                                                            WHERE t4.typeaddress = 1");


        } catch (\Exception $e){
        
            DB::rollBack();
            $response = array(
                'type' => '0',
                'message' => "ERROR ".$e
            );
            $rec->headers->set('Accept', 'application/json');
            echo json_encode($response);
            exit;
        }
        DB::commit();
        $response = array(
            'type' => 1,
            'listemployetc' => $listemployetc,
            'message' => 'list Employee C',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    //List EmployeeTC
    public function listEmployeeTCAll($rec)
    {
        //echo json_encode($rec->idinterno);
        //exit;
        DB::beginTransaction();
        try {
            $db_name = "servicare_sys";
                
        $listemployetc = DB::connection($this->cur_connect)->select(
                                                            "select t0.*, t1.*, t0.id as idtimecontrol,
                                                            t2.client, t3.customertype, t3.names,  t3.surnames,
                                                            t3.businessname 
                                                            from ".$db_name.'.employeetimecontrol'." t0
                                                            JOIN ".$db_name.'.employee'." t1 ON t0.idemployee = t1.id
                                                            JOIN ".$db_name.'.workorders'." t2 ON t0.idworkorder = t2.id
                                                            JOIN ".$db_name.'.clients'." t3 ON t2.client = t3.id
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
            'listemployetc' => $listemployetc,
            'message' => 'list Employee C',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    //List EmployeeTC
    public function listTimeControlOffice($rec)
    {
        //echo json_encode($rec->idinterno);
        //exit;
        DB::beginTransaction();
        try {
            $db_name = "servicare_sys";
                
        $listemployetc = DB::connection($this->cur_connect)->select(
                                                            "select t0.*, t1.*, t0.id as idtimecontrol
                                                            from ".$db_name.'.employeetimecontrol'." t0
                                                            JOIN ".$db_name.'.employee'." t1 ON t0.idemployee = t1.id
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
            'listemployetc' => $listemployetc,
            'message' => 'list Employee C',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    //Actualizar EmployeeTC
    public function updateEmployeeTC($rec)
    {
        //echo json_encode($rec->id);
        //exit;
        $db_name = $this->db.".employeetimecontrol";

        DB::beginTransaction();
        try {

            DB::connection($this->cur_connect)->update("UPDATE ".$db_name." 
                SET workfinishtime = '".$rec-> workfinishtime."',
                    workingtime    = '".$rec-> workingtime."',
                    latitudefinish  = '".$rec-> latitudefinish."',
                    longitudefinish = '".$rec-> longitudefinish."'
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
            'message' => 'Employee Time Control'
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    //Actualizar EmployeeTC
    public function updateAnniversaryEmployee($rec)
    {
        //echo json_encode($rec->id);
        //exit;
        $db_name = $this->db.".employee";

        DB::beginTransaction();
        try {

            DB::connection($this->cur_connect)->update("UPDATE ".$db_name." 
                SET anniversary = '".$rec-> anniversary."'
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
            'message' => 'Employee Update'
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    //Delete CSR
    public function deleteEmployeeTC($rec)
    {
        $db_name = $this->db.".employeetimecontrol";

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

    //Crete employee time control
    public function createJWEmployee($rec)
    {
        DB::beginTransaction();
        try {
                    $db_name = $this->db.".janitorialworkemployee";
                    $createjwemployee = new ModelGlobal();
                    $createjwemployee->setConnection($this->cur_connect);
                    $createjwemployee->setTable($db_name);

                    $createjwemployee->idworkorder = $rec->idworkorder;
                    $createjwemployee->idemployee = $rec->idemployee;
                    $createjwemployee->idsitesurvey = $rec->idsitesurvey;
                    $createjwemployee->idactivity = $rec->idactivity;
                    $createjwemployee->typeservice = $rec->typeservice;
                    $createjwemployee->status = $rec->status;
                    $createjwemployee->nameactivity = $rec->nameactivity;
                    $createjwemployee->comments = $rec->comments;
                    $createjwemployee->creationdate = $date = date('Y-m-d H:i:s');

                    $createjwemployee->save();

        } catch (\Exception $e){

            DB::rollBack();
            $response = array(
                'type' => '0',
                'message' => "ERROR ".$e
            );
            $rec->headers->set('Accept', 'application/json');
            echo json_encode($response);
            exit;
        }
        DB::commit();
        $response = array(
            'type' => 1,
            'message' => 'REGISTER Janitorial Work Employee',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    //List EmployeeTC
    public function listJWEmployee($rec)
    {
        //echo json_encode($rec->idinterno);
        //exit;
        DB::beginTransaction();
        try {
            $db_name = "servicare_sys";
                
        $listjwemployee = DB::connection($this->cur_connect)->select(
                                                            "select t0.*
                                                            from ".$db_name.'.janitorialworkemployee'." t0
                                                            WHERE t0.idemployee = '".$rec->idemployee."'
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
            'istjwemployee' => $istjwemployee,
            'message' => 'list Employee C',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    //List JWEmployee
    public function listJWEmployeeWO($rec)
    {
        //echo json_encode($rec->idinterno);
        //exit;
        DB::beginTransaction();
        try {
            $db_name = "servicare_sys";
                
        $istjwemployee = DB::connection($this->cur_connect)->select(
                                                            "select t0.*
                                                            from ".$db_name.'.janitorialworkemployee'." t0
                                                            WHERE t0.idworkorder = '".$rec->idworkorder."'
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
            'istjwemployee' => $istjwemployee,
            'message' => 'list Employee C',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    //List JWEmployee
    public function listJWEmployeeAll($rec)
    {
        //echo json_encode($rec->idinterno);
        //exit;
        DB::beginTransaction();
        try {
            $db_name = "servicare_sys";
                
        $istjwemployee = DB::connection($this->cur_connect)->select(
                                                            "select t0.*
                                                            from ".$db_name.'.janitorialworkemployee'." t0
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
            'istjwemployee' => $istjwemployee,
            'message' => 'list Employee C',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    //Actualizar JWEmployee
    public function updateJWEmployee($rec)
    {
        //echo json_encode($rec->id);
        //exit;
        $db_name = $this->db.".janitorialworkemployee";

        DB::beginTransaction();
        try {

            DB::connection($this->cur_connect)->update("UPDATE ".$db_name." 
                SET status = '".$rec-> status."',
                    nameactivity    = '".$rec-> nameactivity."',
                    comments      = '".$rec-> comments."'
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
            'message' => 'Employee Time Control'
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    //Delete CSR
    public function deleteJWEmployee($rec)
    {
        $db_name = $this->db.".janitorialworkemployee";

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

    //Crete work order cost concept
    public function createWOCostConcept($rec)
    {
        DB::beginTransaction();
        try {
                    $db_name = $this->db.".workordercostconcept";
                    $createwocostconcept = new ModelGlobal();
                    $createwocostconcept->setConnection($this->cur_connect);
                    $createwocostconcept->setTable($db_name);

                    $createwocostconcept->concept = $rec->concept;
                    $createwocostconcept->comments = $rec->comments;
                    //$createwocostconcept->creationdate = $date = date('Y-m-d H:i:s');

                    $createwocostconcept->save();

        } catch (\Exception $e){

            DB::rollBack();
            $response = array(
                'type' => '0',
                'message' => "ERROR ".$e
            );
            $rec->headers->set('Accept', 'application/json');
            echo json_encode($response);
            exit;
        }
        DB::commit();
        $response = array(
            'type' => 1,
            'message' => 'REGISTER Janitorial Work Employee',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    //List work order cost concept
    public function listWOCostConcept($rec)
    {
        //echo json_encode($rec->idinterno);
        //exit;
        DB::beginTransaction();
        try {
            $db_name = "servicare_sys";
                
        $listwocostconcept = DB::connection($this->cur_connect)->select(
                                                            "select t0.*
                                                            from ".$db_name.'.workordercostconcept'." t0
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
            'listwocostconcept' => $listwocostconcept,
            'message' => 'list Employee C',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    //Actualizar work order cost concept
    public function updateWOCostConcept($rec)
    {
        //echo json_encode($rec->id);
        //exit;
        $db_name = $this->db.".workordercostconcept";

        DB::beginTransaction();
        try {

            DB::connection($this->cur_connect)->update("UPDATE ".$db_name." 
                SET concept    = '".$rec-> concept."',
                    comments      = '".$rec-> comments."'
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
            'message' => 'Employee Time Control'
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    //Delete work order cost concept
    public function deleteWOCostConcept($rec)
    {
        $db_name = $this->db.".workordercostconcept";

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

    //Crete work order cost element
    public function createWOCostElement($rec)
    {
        DB::beginTransaction();
        try {
                    $db_name = $this->db.".workordercostelement";
                    $createwocostelement = new ModelGlobal();
                    $createwocostelement->setConnection($this->cur_connect);
                    $createwocostelement->setTable($db_name);

                    $createwocostelement->idconcepto = $rec->idconcepto;
                    $createwocostelement->namecostelement = $rec->namecostelement;
                    $createwocostelement->percentage = $rec->percentage;
                    $createwocostelement->comments = $rec->comments;
                    //$createwocostelement->creationdate = $date = date('Y-m-d H:i:s');

                    $createwocostelement->save();

        } catch (\Exception $e){

            DB::rollBack();
            $response = array(
                'type' => '0',
                'message' => "ERROR ".$e
            );
            $rec->headers->set('Accept', 'application/json');
            echo json_encode($response);
            exit;
        }
        DB::commit();
        $response = array(
            'type' => 1,
            'message' => 'Register Work Order Cost Element',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    //List work order cost element
    public function listWOCostElement($rec)
    {
        //echo json_encode($rec->idinterno);
        //exit;
        DB::beginTransaction();
        try {
            $db_name = "servicare_sys";
                
        $listwocostelelement = DB::connection($this->cur_connect)->select(
                                                            "select t0.*
                                                            from ".$db_name.'.workordercostelement'." t0
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
            'listwocostelelement' => $listwocostelelement,
            'message' => 'list Employee C',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    //Actualizar work order cost element
    public function updateWOCostElement($rec)
    {
        //echo json_encode($rec->id);
        //exit;
        $db_name = $this->db.".workordercostelement";

        DB::beginTransaction();
        try {

            DB::connection($this->cur_connect)->update("UPDATE ".$db_name." 
                SET namecostelement = '".$rec-> namecostelement."',
                    percentage      = '".$rec-> percentage."',
                    comments        = '".$rec-> comments."'
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
            'message' => 'Employee Time Control'
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    //Delete work order cost element
    public function deleteWOCostElement($rec)
    {
        $db_name = $this->db.".workordercostelement";

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

    //Crete work order cost 
    public function createworkordercost($rec)
    {
        DB::beginTransaction();
        try {
                    $db_name = $this->db.".workordercost";
                    $createworkordercost = new ModelGlobal();
                    $createworkordercost->setConnection($this->cur_connect);
                    $createworkordercost->setTable($db_name);

                    $createworkordercost->idinvoice= $rec->idinvoice;
                    $createworkordercost->idgrupsitesurvey= $rec->idgrupsitesurvey;
                    $createworkordercost->employee1= $rec->employee1;
                    $createworkordercost->percentage1= $rec->percentage1;
                    $createworkordercost->amount1= $rec->amount1;
                    $createworkordercost->employee2= $rec->employee2;
                    $createworkordercost->percentage2= $rec->percentage2;
                    $createworkordercost->amount2= $rec->amount2;
                    $createworkordercost->employee3= $rec->employee3;
                    $createworkordercost->percentage3= $rec->percentage3;
                    $createworkordercost->amount3= $rec->amount3;
                    $createworkordercost->employee4= $rec->employee4;
                    $createworkordercost->percentage4= $rec->percentage4;
                    $createworkordercost->amount4= $rec->amount4;
                    $createworkordercost->employee5= $rec->employee5;
                    $createworkordercost->percentage5= $rec->percentage5;
                    $createworkordercost->amount5= $rec->amount5;
                    $createworkordercost->employee6= $rec->employee6;
                    $createworkordercost->percentage6= $rec->percentage6;
                    $createworkordercost->amount6= $rec->amount6;
                    $createworkordercost->employee7= $rec->employee7;
                    $createworkordercost->percentage7= $rec->percentage7;
                    $createworkordercost->amount7= $rec->amount7;
                    $createworkordercost->employee8= $rec->employee8;
                    $createworkordercost->percentage8= $rec->percentage8;
                    $createworkordercost->amount8= $rec->amount8;
                    $createworkordercost->employee9= $rec->employee9;
                    $createworkordercost->percentage9= $rec->percentage9;
                    $createworkordercost->amount9= $rec->amount9;
                    $createworkordercost->employee10= $rec->employee10;
                    $createworkordercost->percentage10= $rec->percentage10;
                    $createworkordercost->amount10= $rec->amount10;
                    $createworkordercost->employee11= $rec->employee11;
                    $createworkordercost->percentage11= $rec->percentage11;
                    $createworkordercost->amount11= $rec->amount11;
                    $createworkordercost->employee12= $rec->employee12;
                    $createworkordercost->percentage12= $rec->percentage12;
                    $createworkordercost->amount12= $rec->amount12;
                    $createworkordercost->creationdate = $date = date('Y-m-d H:i:s');

                    $createworkordercost->save();

        } catch (\Exception $e){

            DB::rollBack();
            $response = array(
                'type' => '0',
                'message' => "ERROR ".$e
            );
            $rec->headers->set('Accept', 'application/json');
            echo json_encode($response);
            exit;
        }
        DB::commit();
        $response = array(
            'type' => 1,
            'message' => 'Register Work Order Cost',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    //List work order cost element
    public function listWorkOrderCost($rec)
    {
        //echo json_encode($rec->idinterno);
        //exit;
        DB::beginTransaction();
        try {
            $db_name = "servicare_sys";
                
        $listwocostelelement = DB::connection($this->cur_connect)->select(
                                                            "select t0.*,t2.namegroup, t1.idsitesurvey
                                                            from ".$db_name.'.workordercost'." t0
                                                            JOIN ".$db_name.'.invoice'." t1 ON t0.idinvoice = t1.id
                                                            JOIN ".$db_name.'.sitesurvey'." t2 ON t1.idsitesurvey = t2.id
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
            'listwocostelelement' => $listwocostelelement,
            'message' => 'list work order cost',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    //List work order cost element
    public function listAWorkOrderCost($rec)
    {
        //echo json_encode($rec->idinterno);
        //exit;
        DB::beginTransaction();
        try {
            $db_name = "servicare_sys";
                
        $listwocostelelement = DB::connection($this->cur_connect)->select(
                                                            "select t0.*,t2.namegroup, t1.idsitesurvey
                                                            from ".$db_name.'.workordercost'." t0
                                                            JOIN ".$db_name.'.invoice'." t1 ON t0.idinvoice = t1.id
                                                            JOIN ".$db_name.'.sitesurvey'." t2 ON t1.idsitesurvey = t2.id
                                                            WHERE idinvoice = '".$rec->idinvoice."'
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
            'listwocostelelement' => $listwocostelelement,
            'message' => 'list work order cost',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    //Actualizar work order cost element
    public function updateworkordercost($rec)
    {
        //echo json_encode($rec->id);
        //exit;
        $db_name = $this->db.".workordercost";

        DB::beginTransaction();
        try {

            DB::connection($this->cur_connect)->update("UPDATE ".$db_name." 
                SET amount     = '".$rec-> amount."',
                    percentage = '".$rec-> percentage."'
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
            'message' => 'update work order cost'
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    //Delete work order cost element
    public function deleteworkordercost($rec)
    {
        $db_name = $this->db.".workordercost";

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
    public function saveImgWorkOrder($rec)
    {
        DB::beginTransaction();
        try {
                    $db_name = $this->db.".imageworkorder";
                    $saveworkorder = new ModelGlobal();
                    $saveworkorder->setConnection($this->cur_connect);
                    $saveworkorder->setTable($db_name);

                    $saveworkorder->idworkorder = $rec->idworkorder;
                    $saveworkorder->nameimg = $rec->nombreimagen1;
                    $saveworkorder->commentimg = $rec->commentimg;
                    $saveworkorder->creationdate = $date = date('Y-m-d H:i:s');;

                    $saveworkorder->save();
                    
                    //Imagen base 64 se pasa a un arreglo
                    $nombrefoto[1] = $rec->nombreimagen1;
                    $foto[1] = $rec->imagen1;

                    for ($i = 1; $i <= $rec->numerodeimagenes; $i++) {
                        $this->GuardarIMG($foto[$i] ,$nombrefoto[$i],'servicaredocuments/');
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
            'message' => 'SAVE IMAGE WORK ORDER',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

     //List work order cost element
     public function listImgWorkOrder($rec)
     {
         //echo json_encode($rec->idinterno);
         //exit;
         DB::beginTransaction();
         try {
             $db_name = "servicare_sys";
                 
         $listimagewo = DB::connection($this->cur_connect)->select(
                                                            "select t0.*, t1.*, t2.*
                                                            from ".$db_name.'.imageworkorder'." t0
                                                            JOIN ".$db_name.'.workorders'." t1 ON t0.idworkorder = t1.id
                                                            JOIN ".$db_name.'.clients'." t2 ON t1.client = t2.id
                                                            WHERE t0.idworkorder = '".$rec->idworkorder."'
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
             'listimagewo' => $listimagewo,
             'message' => 'list work order cost',
         );
         $rec->headers->set('Accept', 'application/json');
         echo json_encode($response);
         exit;
    }

    public function listImgWorkOrderClient($rec)
     {
         //echo json_encode($rec->idinterno);
         //exit;
         DB::beginTransaction();
         try {
             $db_name = "servicare_sys";
                 
         $listimagewo = DB::connection($this->cur_connect)->select(
                                                            "select t0.*, t1.*, t2.*, 
                                                            CONCAT(t3.firstname,' ',t3.lastname) as nametechnical
                                                            from ".$db_name.'.imageworkorder'." t0
                                                            JOIN ".$db_name.'.workorders'." t1 ON t0.idworkorder = t1.id
                                                            JOIN ".$db_name.'.clients'." t2 ON t1.client = t2.id
                                                       LEFT JOIN ".$db_name.'.employee'." t3 ON t1.employee = t3.id
                                                            WHERE t1.client = '".$rec->idclient."'
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
             'listimagewo' => $listimagewo,
             'message' => 'list work order cost',
         );
         $rec->headers->set('Accept', 'application/json');
         echo json_encode($response);
         exit;
    }

    public function listContacts($rec)
    {
        //echo json_encode($rec->idinterno);
        //exit;
        DB::beginTransaction();
        try {
            $db_name = "servicare_sys";
                
        $liscontacts = DB::connection($this->cur_connect)->select(
                                                            "select t0.*, t1.description, t2.*, t0.names as namecontact,
                                                            t0.surnames as surnamecontact
                                                            from ".$db_name.'.contacts'." t0
                                                            JOIN ".$db_name.'.status'." t1 ON t0.status = t1.id
                                                            JOIN ".$db_name.'.clients'." t2 ON t0.idclient = t2.id
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
            'liscontacts' => $liscontacts,
            'message' => 'LIST CONTRACTS OK',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    // Listar Site Inventory Machine
    public function listInventoryMachine($rec)
    {
        //echo json_encode($rec->idinterno);
        //exit;
        DB::beginTransaction();
        try {
            $db_name = "servicare_sys";
                
        $siteinventory = DB::connection($this->cur_connect)->select(
                                                            "select t0.*, t1.* 
                                                            from ".$db_name.'.siteinventorymachine'." t0
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
            'siteinventory' => $siteinventory,
            'message' => 'LIST SITE INVENTORYOK',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    // Listar Signed Documents
    public function listDocumentsClients($rec)
    {
        //echo json_encode($rec->idinterno);
        //exit;
        DB::beginTransaction();
        try {
            $db_name = "servicare_sys";
                
        $listsigneddocuments = DB::connection($this->cur_connect)->select(
                                                            "select t0.*, t1.* 
                                                            from ".$db_name.'.signeddocuments'." t0
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
            'listsigneddocuments' => $listsigneddocuments,
            'message' => 'LIST signeddocuments',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    // Listar scopework por Cliente
    public function listEmergencyContacts($rec)
    {
        //echo json_encode($rec->idinterno);
        //exit;
        DB::beginTransaction();
        try {
            $db_name = "servicare_sys";
                
        $listemergencycontact = DB::connection($this->cur_connect)->select(
                                                            "select t0.*, t1.description as namerelationship,
                                                            t2.* 
                                                            from ".$db_name.'.emergencycontact'." t0
                                                            JOIN ".$db_name.'.typerelationshipemployee'." t1 ON t0.relationshipemployee = t1.id
                                                            JOIN ".$db_name.'.employee'." t2 ON t0.idemployee = t2.id
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
            'listemergencycontact' => $listemergencycontact,
            'message' => 'LIST EMERGENCY CONTACT OK',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    // Listar Signed Documents
    public function listDocumentsEmployees($rec)
    {
        //echo json_encode($rec->idinterno);
        //exit;
        DB::beginTransaction();
        try {
            $db_name = "servicare_sys";
                
        $listdocumentsemployee = DB::connection($this->cur_connect)->select(
                                                            "select t0.*, t1.description as nametypedocument,
                                                            t2.*
                                                            from ".$db_name.'.documentsemployee'." t0
                                                            JOIN ".$db_name.'.typedocuments'." t1 ON t0.typedocument = t1.id
                                                            JOIN ".$db_name.'.employee'." t2 ON t0.idemployee = t2.id
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
            'listdocumentsemployee' => $listdocumentsemployee,
            'message' => 'LIST DOCUMENT EMPLOYEE',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    // Listar Certificate Employee
    public function listCertificateEmployees($rec)
    {
        //echo json_encode($rec->idinterno);
        //exit;
        DB::beginTransaction();
        try {
            $db_name = "servicare_sys";
                
        $listemployeecertificates = DB::connection($this->cur_connect)->select(
                                                            "select t0.*, t1.*,
                                                            TRUNCATE(((DATEDIFF(t0.certificateenddate,t0.certificatestartdate))),1) AS time
                                                            from ".$db_name.'.employeecertificates'." t0
                                                            JOIN ".$db_name.'.employee'." t1 ON t0.idemployee = t1.id
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
            'listemployeecertificates' => $listemployeecertificates,
            'message' => 'LIST DOCUMENT EMPLOYEE',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    // Listar vacationrequestform
    public function listVacationEmployee($rec)
    {
        //echo json_encode($rec->idinterno);
        //exit;
        DB::beginTransaction();
        try {
            $db_name = "servicare_sys";
                
        $listvacationrequest = DB::connection($this->cur_connect)->select(
                                                            "select t0.*, t1.description as namestatus, t2.*
                                                            from ".$db_name.'.vacationrequestform'." t0
                                                            JOIN ".$db_name.'.status'." t1 ON t0.state = t1.id
                                                            JOIN ".$db_name.'.employee'." t2 ON t0.employeerequest = t2.id
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
            'listvacationrequest' => $listvacationrequest,
            'message' => 'LIST Supplyrequest',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    //Create Site Vehicles
    public function createVehicle($rec)
    {
        DB::beginTransaction();
        try {
                    $db_name = $this->db.".sitevehicles";
                    $createvehicle = new ModelGlobal();
                    $createvehicle->setConnection($this->cur_connect);
                    $createvehicle->setTable($db_name);

                    $createvehicle->employeeasigned = $rec->employeeasigned;
                    $createvehicle->brand = $rec->brand;
                    $createvehicle->modelo = $rec->modelo;
                    $createvehicle->license = $rec->license;
                    $createvehicle->year = $rec->year;
                    $createvehicle->purchasedate = $rec->purchasedate;
                    $createvehicle->miles = $rec->miles;

                    $createvehicle->purchasevalue = $rec->purchasevalue;
                    $createvehicle->currentvalue = $rec->currentvalue;
                    $createvehicle->retailvalue = $rec->retailvalue;

                    $createvehicle->maintenancelast = $rec->maintenancelast;
                    $createvehicle->maintenancenext = $rec->maintenancenext;
                    $createvehicle->color = $rec->color;
                    $createvehicle->status = $rec->status;
                    $createvehicle->comments = $rec->comments;
                    $createvehicle->updatedate = $date = date('Y-m-d H:i:s');
                    $createvehicle->creationdate = $date = date('Y-m-d H:i:s');
                   
                    $createvehicle->save();

        } catch (\Exception $e){

            DB::rollBack();
            $response = array(
                'type' => '0',
                'message' => "ERROR ".$e
            );
            $rec->headers->set('Accept', 'application/json');
            echo json_encode($response);
            exit;
        }
        DB::commit();
        $response = array(
            'type' => 1,
            'message' => 'REGISTER INVOICE',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    // Listar Site Inventory Machine
    public function listVehicle($rec)
    {
        //echo json_encode($rec->idinterno);
        //exit;
        DB::beginTransaction();
        try {
            $db_name = "servicare_sys";
                
        $listvehicles = DB::connection($this->cur_connect)->select(
                                                            "select t0.* 
                                                            from ".$db_name.'.sitevehicles'." t0
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
            'listvehicles' => $listvehicles,
            'message' => 'LIST INVOICE OK',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    //Actualizar Site Inventory Machine
    public function updateVehicle($rec)
    {
        //echo json_encode($rec->id);
        //exit;
        $db_name = $this->db.".sitevehicles";

        DB::beginTransaction();
        try {

            DB::connection($this->cur_connect)->update("UPDATE ".$db_name." 
                SET employeeasigned = '".$rec-> employeeasigned."',
                    miles = '".$rec-> miles."',
                    purchasevalue = '".$rec-> purchasevalue."',
                    currentvalue = '".$rec-> currentvalue."',
                    retailvalue = '".$rec-> retailvalue."',
                    maintenancelast = '".$rec-> maintenancelast."',
                    maintenancenext = '".$rec-> maintenancenext."',
                    updatedate = '".$date = date('Y-m-d H:i:s')."', 
                    status = '".$rec-> status."'
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
    public function deleteVehicle($rec)
    {
        $db_name = $this->db.".sitevehicles";

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

    //Create Site Vehicles
    public function createAppOperatione($rec)
    {
        DB::beginTransaction();
        try {
                    $db_name = $this->db.".applicationoperation";
                    $createappoperation = new ModelGlobal();
                    $createappoperation->setConnection($this->cur_connect);
                    $createappoperation->setTable($db_name);

                    $createappoperation->newdriverlicense=$rec->newdriverlicense;
                    $createappoperation->newdriverlicensecomments=$rec->newdriverlicensecomments;
                    $createappoperation->doyoudrive=$rec->doyoudrive;
                    $createappoperation->doyoudrivecomments=$rec->doyoudrivecomments;
                    $createappoperation->newvehicle=$rec->newvehicle;
                    $createappoperation->newvehiclecomments=$rec->newvehiclecomments;
                    $createappoperation->newexperience=$rec->newexperience;
                    $createappoperation->newexperiencecomments=$rec->newexperiencecomments;
                    $createappoperation->newfirstintersection=$rec->newfirstintersection;
                    $createappoperation->newsecintersection=$rec->newsecintersection;
                    $createappoperation->newcity=$rec->newcity;

                    $createappoperation->latitud=$rec->latitud;
                    $createappoperation->longitud=$rec->longitud;
                    $createappoperation->addressgeolocation=$rec->addressgeolocation;

                    $createappoperation->lastname=$rec->lastname;
                    $createappoperation->firstname=$rec->firstname;
                    $createappoperation->middlename=$rec->middlename;
                    $createappoperation->personaldate=$rec->personaldate;
                    $createappoperation->presentaddress=$rec->presentaddress;
                    $createappoperation->personalcity=$rec->personalcity;
                    $createappoperation->personalprovince=$rec->personalprovince;
                    $createappoperation->personalpostalcode=$rec->personalpostalcode;
                    $createappoperation->personalphone=$rec->personalphone;
                    $createappoperation->mainintersection=$rec->mainintersection;
                    $createappoperation->driverslicense=$rec->driverslicense;
                    $createappoperation->dateofbirth=$rec->dateofbirth;
                    $createappoperation->numbercell=$rec->numbercell;
                    $createappoperation->socialinsurance=$rec->socialinsurance;
                    $createappoperation->longpresentaddress=$rec->longpresentaddress;
                    $createappoperation->previuslyapplied=$rec->previuslyapplied;
                    $createappoperation->personalmonthyear=$rec->personalmonthyear;
                    $createappoperation->earningsexpected=$rec->earningsexpected;
                    $createappoperation->personalnamecontact=$rec->personalnamecontact;
                    $createappoperation->whereemployed=$rec->whereemployed;
                    $createappoperation->phonenumberone=$rec->phonenumberone;
                    $createappoperation->canadacitizen=$rec->canadacitizen;
                    $createappoperation->email=$rec->email;
                    $createappoperation->physicalhealth=$rec->physicalhealth;
                    $createappoperation->lastphysicaldate=$rec->lastphysicaldate;
                    $createappoperation->mentalconditions=$rec->mentalconditions;
                    $createappoperation->physicalpastyears=$rec->physicalpastyears;
                    $createappoperation->physicalpastdescription=$rec->physicalpastdescription;
                    $createappoperation->incomepayments=$rec->incomepayments;
                    $createappoperation->incomedescription=$rec->incomedescription;
                    $createappoperation->dateoflastphysical=$rec->dateoflastphysical;
                    $createappoperation->firstschool=$rec->firstschool;
                    $createappoperation->secondschool=$rec->secondschool;
                    $createappoperation->thirdschool=$rec->thirdschool;
                    $createappoperation->firstcourse=$rec->firstcourse;
                    $createappoperation->secondcourse=$rec->secondcourse;
                    $createappoperation->thirdcourse=$rec->thirdcourse;
                    $createappoperation->circlelastyearcompleted=$rec->circlelastyearcompleted;
                    $createappoperation->firstattendance=$rec->firstattendance;
                    $createappoperation->secondattendance=$rec->secondattendance;
                    $createappoperation->thirdattendance=$rec->thirdattendance;
                    $createappoperation->firstyear=$rec->firstyear;
                    $createappoperation->secondyear=$rec->secondyear;
                    $createappoperation->thirdyear=$rec->thirdyear;
                    $createappoperation->firstgraduate=$rec->firstgraduate;
                    $createappoperation->secondgraduate=$rec->secondgraduate;
                    $createappoperation->thirdgraduate=$rec->thirdgraduate;
                    $createappoperation->firstdegree=$rec->firstdegree;
                    $createappoperation->seconddegree=$rec->seconddegree;
                    $createappoperation->phonenumbertwo=$rec->phonenumbertwo;
                    $createappoperation->thirddegree=$rec->thirddegree;
                    $createappoperation->employerno=$rec->employerno;
                    $createappoperation->reason=$rec->reason;
                    $createappoperation->currentcompanyname=$rec->currentcompanyname;
                    $createappoperation->currentaddress=$rec->currentaddress;
                    $createappoperation->currentsupervisor=$rec->currentsupervisor;
                    $createappoperation->currentphone=$rec->currentphone;
                    $createappoperation->currentreason=$rec->currentreason;
                    $createappoperation->currentjob=$rec->currentjob;
                    $createappoperation->currentfrom=$rec->currentfrom;
                    $createappoperation->currentto=$rec->currentto;
                    $createappoperation->phonenumberthree=$rec->phonenumberthree;
                    $createappoperation->currentstarting=$rec->currentstarting;
                    $createappoperation->currentending=$rec->currentending;
                    $createappoperation->stcompanyname=$rec->stcompanyname;
                    $createappoperation->staddress=$rec->staddress;
                    $createappoperation->stsupervisor=$rec->stsupervisor;
                    $createappoperation->companynamethree=$rec->companynamethree;
                    $createappoperation->stphone=$rec->stphone;
                    $createappoperation->stjob=$rec->stjob;
                    $createappoperation->streason=$rec->streason;
                    $createappoperation->stdate=$rec->stdate;
                    $createappoperation->stfrom=$rec->stfrom;
                    $createappoperation->stto=$rec->stto;
                    $createappoperation->ststarting=$rec->ststarting;
                    $createappoperation->stending=$rec->stending;
                    $createappoperation->ndcompanyname=$rec->ndcompanyname;
                    $createappoperation->ndaddress=$rec->ndaddress;
                    $createappoperation->phone=$rec->phone;
                    $createappoperation->ndsupervisor=$rec->ndsupervisor;
                    $createappoperation->ndphone=$rec->ndphone;
                    $createappoperation->ndjob=$rec->ndjob;
                    $createappoperation->ndreason=$rec->ndreason;
                    $createappoperation->ndfrom=$rec->ndfrom;
                    $createappoperation->ndto=$rec->ndto;
                    $createappoperation->ndndarting=$rec->ndndarting;
                    $createappoperation->ndending=$rec->ndending;
                    $createappoperation->employeeskills=$rec->employeeskills;
                    $createappoperation->excludereference=$rec->excludereference;
                    $createappoperation->firstreferencename=$rec->firstreferencename;
                    $createappoperation->secondreferencename=$rec->secondreferencename;
                    $createappoperation->firstphonereference=$rec->firstphonereference;
                    $createappoperation->secondphonereference=$rec->secondphonereference;
                    $createappoperation->firstreferencerelation=$rec->firstreferencerelation;
                    $createappoperation->secondreferencerelation=$rec->secondreferencerelation;
                    $createappoperation->signature=$rec->signature;
                    $createappoperation->nddate=$rec->nddate;
                    $createappoperation->creationdate=$date=date('Y-m-d H:i:s');
                    
                    $createappoperation->save();

        } catch (\Exception $e){

            DB::rollBack();
            $response = array(
                'type' => '0',
                'message' => "ERROR ".$e
            );
            $rec->headers->set('Accept', 'application/json');
            echo json_encode($response);
            exit;
        }
        DB::commit();
        $response = array(
            'type' => 1,
            'message' => 'REGISTER APPLICATION OPERATION',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    public function listAppOperatione($rec)
    {
        //echo json_encode($rec->idinterno);
        //exit;
        DB::beginTransaction();
        try {
            $db_name = "servicare_sys";
                
        $listappoperation = DB::connection($this->cur_connect)->select(
                                                            "select t0.*, t1.status, t2.description as namestatus
                                                            from ".$db_name.'.applicationoperation'." t0
                                                        LEFT JOIN ".$db_name.'.commentsapp'." t1 ON t0.id = t1.idapplication
                                                        LEFT JOIN ".$db_name.'.status'." t2 ON t1.status = t2.id
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
            'listappoperation' => $listappoperation,
            'message' => 'LIST compensation OK',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    public function listAppOperationeGeo($rec)
    {
        //echo json_encode($rec->idinterno);
        //exit;
        DB::beginTransaction();
        try {
            $db_name = "servicare_sys";
                
        $listappoperation = DB::connection($this->cur_connect)->select(
                                                            "select t0.id as idapplication, 
                                                             t0.lastname as lastnameopera,
                                                             t0.firstname as firstnameopera,
                                                             t0.presentaddress as presentaddressopera,
                                                             t0.personalcity as personalcityopera, 
                                                             t0.personalprovince as personalprovinceopera,
                                                             t0.personalpostalcode as personalpostalcodeopera,
                                                             t0.personalphone as personalphoneopera,
                                                             t0.creationdate as creationdateopera,
                                                             t0.latitud as latitudopera,
                                                             t0.longitud as longitudopera,
                                                             t0.email as emailopera,
                                                             t0.mainintersection as mainintersectionopera,
                                                             t0.newsecintersection as mainintersectionoperatwo,
                                                             2 as tipoapplicationopera,
                                                             t1.status, t2.description as namestatus
                                                             from ".$db_name.'.applicationoperation'." t0
                                                        LEFT JOIN ".$db_name.'.commentsapp'." t1 ON t0.id = t1.idapplication
                                                        LEFT JOIN ".$db_name.'.status'." t2 ON t1.status = t2.id
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
            'listappoperation' => $listappoperation,
            'message' => 'LIST compensation OK',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }


    //Actualizar Concept Empleado
    public function updateAppOperatione($rec)
    {
        //echo json_encode($rec->id);
        //exit;
        $db_name = $this->db.".applicationoperation";

        DB::beginTransaction();
        try {

            DB::connection($this->cur_connect)->update("UPDATE ".$db_name." 
                SET description = '".$rec-> description."'
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
            'message' => 'UPDATED PURPOSE OK'
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    //Delete Concept Empleado
    public function deleteAppOperatione($rec)
    {
        $db_name = $this->db.".applicationoperation";

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

    //Create Application Office
    public function createAppOffice($rec)
    {
        DB::beginTransaction();
        try {
                    $db_name = $this->db.".applicationoffice";
                    $createappoffice = new ModelGlobal();
                    $createappoffice->setConnection($this->cur_connect);
                    $createappoffice->setTable($db_name);

                    $createappoffice->newdriverlicense=$rec->newdriverlicense;
                    $createappoffice->newdriverlicensecomments=$rec->newdriverlicensecomments;
                    $createappoffice->doyoudrive=$rec->doyoudrive;
                    $createappoffice->doyoudrivecomments=$rec->doyoudrivecomments;
                    $createappoffice->newvehicle=$rec->newvehicle;
                    $createappoffice->newvehiclecomments=$rec->newvehiclecomments;
                    $createappoffice->newexperience=$rec->newexperience;
                    $createappoffice->newexperiencecomments=$rec->newexperiencecomments;
                    $createappoffice->newfirstintersection=$rec->newfirstintersection;
                    $createappoffice->newsecintersection=$rec->newsecintersection;
                    $createappoffice->newcity=$rec->newcity;

                    $createappoffice->latitud=$rec->latitud;
                    $createappoffice->longitud=$rec->longitud;
                    $createappoffice->addressgeolocation=$rec->addressgeolocation;

                    $createappoffice->lastname=$rec->lastname;
                    $createappoffice->firstname=$rec->firstname;
                    $createappoffice->middlename=$rec->middlename;
                    $createappoffice->personaldate=$rec->personaldate;
                    $createappoffice->presentaddress=$rec->presentaddress;
                    $createappoffice->personalcity=$rec->personalcity;
                    $createappoffice->personalprovince=$rec->personalprovince;
                    $createappoffice->personalpostalcode=$rec->personalpostalcode;
                    $createappoffice->personalphone=$rec->personalphone;
                    $createappoffice->cellpagerno=$rec->cellpagerno;
                    $createappoffice->longpresentaddress=$rec->longpresentaddress;
                    $createappoffice->licencetodrive=$rec->licencetodrive;
                    $createappoffice->previuslyapplied=$rec->previuslyapplied;
                    $createappoffice->personalmonthyear=$rec->personalmonthyear;
                    $createappoffice->earningsexpected=$rec->earningsexpected;
                    $createappoffice->personalnamecontact=$rec->personalnamecontact;
                    $createappoffice->whereemployed=$rec->whereemployed;
                    $createappoffice->personaltelno=$rec->personaltelno;
                    $createappoffice->canadacitizen=$rec->canadacitizen;
                    $createappoffice->incomepayments=$rec->incomepayments;
                    $createappoffice->incomedescription=$rec->incomedescription;
                    $createappoffice->email=$rec->email;
                    $createappoffice->firstschool=$rec->firstschool;
                    $createappoffice->secondschool=$rec->secondschool;
                    $createappoffice->thirdschool=$rec->thirdschool;
                    $createappoffice->fourschool=$rec->fourschool;
                    $createappoffice->firstcourse=$rec->firstcourse;
                    $createappoffice->secondcourse=$rec->secondcourse;
                    $createappoffice->thirdcourse=$rec->thirdcourse;
                    $createappoffice->fourcourse=$rec->fourcourse;
                    $createappoffice->firstyear=$rec->firstyear;
                    $createappoffice->secondyear=$rec->secondyear;
                    $createappoffice->thirdyear=$rec->thirdyear;
                    $createappoffice->fouryears=$rec->fouryears;
                    $createappoffice->firstgraduate=$rec->firstgraduate;
                    $createappoffice->secondgraduate=$rec->secondgraduate;
                    $createappoffice->thirdgraduate=$rec->thirdgraduate;
                    $createappoffice->fourgraduate=$rec->fourgraduate;
                    $createappoffice->firstdegree=$rec->firstdegree;
                    $createappoffice->seconddegree=$rec->seconddegree;
                    $createappoffice->thirddegree=$rec->thirddegree;
                    $createappoffice->fourdegree=$rec->fourdegree;
                    $createappoffice->employerno=$rec->employerno;
                    $createappoffice->reason=$rec->reason;
                    $createappoffice->currentcompanyname=$rec->currentcompanyname;
                    $createappoffice->currentaddress=$rec->currentaddress;
                    $createappoffice->currentsupervisor=$rec->currentsupervisor;
                    $createappoffice->currentphone=$rec->currentphone;
                    $createappoffice->currentreason=$rec->currentreason;
                    $createappoffice->currentjob=$rec->currentjob;
                    $createappoffice->currentfrom=$rec->currentfrom;
                    $createappoffice->currentto=$rec->currentto;
                    $createappoffice->currentstarting=$rec->currentstarting;
                    $createappoffice->currentending=$rec->currentending;
                    $createappoffice->stcompanyname=$rec->stcompanyname;
                    $createappoffice->staddress=$rec->staddress;
                    $createappoffice->stsupervisor=$rec->stsupervisor;
                    $createappoffice->stphone=$rec->stphone;
                    $createappoffice->stjob=$rec->stjob;
                    $createappoffice->streason=$rec->streason;
                    $createappoffice->stdate=$rec->stdate;
                    $createappoffice->stfrom=$rec->stfrom;
                    $createappoffice->stto=$rec->stto;
                    $createappoffice->ststarting=$rec->ststarting;
                    $createappoffice->stending=$rec->stending;
                    $createappoffice->ndcompanyname=$rec->ndcompanyname;
                    $createappoffice->ndaddress=$rec->ndaddress;
                    $createappoffice->ndsupervisor=$rec->ndsupervisor;
                    $createappoffice->ndphone=$rec->ndphone;
                    $createappoffice->ndjob=$rec->ndjob;
                    $createappoffice->ndreason=$rec->ndreason;
                    $createappoffice->nddate=$rec->nddate;
                    $createappoffice->ndfrom=$rec->ndfrom;
                    $createappoffice->ndto=$rec->ndto;
                    $createappoffice->ndndarting=$rec->ndndarting;
                    $createappoffice->ndending=$rec->ndending;
                    $createappoffice->employeeskills=$rec->employeeskills;
                    $createappoffice->excludereference=$rec->excludereference;
                    $createappoffice->firstreferencename=$rec->firstreferencename;
                    $createappoffice->secondreferencename=$rec->secondreferencename;
                    $createappoffice->firstphonereference=$rec->firstphonereference;
                    $createappoffice->secondphonereference=$rec->secondphonereference;
                    $createappoffice->firstreferencerelation=$rec->firstreferencerelation;
                    $createappoffice->secondreferencerelation=$rec->secondreferencerelation;
                    $createappoffice->signature=$rec->signature;
                    $createappoffice->creationdate=$date=date('Y-m-d H:i:s');
                    
                    $createappoffice->save();

        } catch (\Exception $e){

            DB::rollBack();
            $response = array(
                'type' => '0',
                'message' => "ERROR ".$e
            );
            $rec->headers->set('Accept', 'application/json');
            echo json_encode($response);
            exit;
        }
        DB::commit();
        $response = array(
            'type' => 1,
            'message' => 'REGISTER Application Office',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    public function listAppOffice($rec)
    {
        //echo json_encode($rec->idinterno);
        //exit;
        DB::beginTransaction();
        try {
            $db_name = "servicare_sys";
                
        $listappoperation = DB::connection($this->cur_connect)->select(
                                                            "select t0.*, t1.status, t2.description as namestatus
                                                            from ".$db_name.'.applicationoffice'." t0
                                                            JOIN ".$db_name.'.commentsapp'." t1 ON t0.id = t1.idapplication
                                                            JOIN ".$db_name.'.status'." t2 ON t1.status = t2.id
                                                            WHERE t1.type = 2
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
            'listappoperation' => $listappoperation,
            'message' => 'LIST Application Office OK',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    public function listAppOfficeGeo($rec)
    {
        //echo json_encode($rec->idinterno);
        //exit;
        DB::beginTransaction();
        try {
            $db_name = "servicare_sys";
                
        $listapplicateoffice = DB::connection($this->cur_connect)->select(
                                                            "select t0.lastname, t0.firstname, t0.presentaddress,
                                                            t0.personalcity, t0.personalprovince,
                                                            t0.personalpostalcode, t0.personalphone,
                                                            t0.creationdate, t0.email,
                                                            t0.latitud, t0.longitud,
                                                            1 as tipoapplication
                                                            from ".$db_name.'.applicationoffice'." t0
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
            'listapplicateoffice' => $listapplicateoffice,
            'message' => 'LIST Application Office OK',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    //Actualizar Application Office
    public function updateAppOffice($rec)
    {
        //echo json_encode($rec->id);
        //exit;
        $db_name = $this->db.".applicationoffice";

        DB::beginTransaction();
        try {

            DB::connection($this->cur_connect)->update("UPDATE ".$db_name." 
                SET description = '".$rec-> description."'
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
            'message' => 'UPDATED Application Office OK'
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    //Delete Application Office
    public function deleteAppOffice($rec)
    {
        $db_name = $this->db.".applicationoffice";

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

    //Actualizar QuoteSiteSurvey
    public function updateClientInactive($rec)
    {
        //echo json_encode($rec->id);
        //exit;
        $db_name = $this->db.".clients";

        DB::beginTransaction();
        try {

            DB::connection($this->cur_connect)->update("UPDATE ".$db_name." 
                SET idcomment = '".$rec-> idcomment."', 
                    status = '".$rec-> status."',  
                    commentreason = '".$rec-> commentreason."'
                WHERE id = '".$rec->idclient."'");

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
            'message' => 'UPDATED quotesitesurvey OK'
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    //Actualizar QuoteSiteSurvey
    public function updateClientStatus($rec)
    {
        //echo json_encode($rec->id);
        //exit;
        $db_name = $this->db.".clients";

        DB::beginTransaction();
        try {

            DB::connection($this->cur_connect)->update("UPDATE ".$db_name." 
                SET status = '".$rec-> status."'
                WHERE id = '".$rec->idclient."'");

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
            'message' => 'UPDATED quotesitesurvey OK'
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    //Create Purpose Supplier
    public function createPurposeSupplier($rec)
    {

        DB::beginTransaction();
        try {
                    $db_name = $this->db.".purposesupplier";
                    $createpurpose = new ModelGlobal();
                    $createpurpose->setConnection($this->cur_connect);
                    $createpurpose->setTable($db_name);

                    $createpurpose->idsupplier = $rec->idsupplier;
                    $createpurpose->description = $rec->description;
                    $createpurpose->amount = $rec->amount;
                    $createpurpose->referenceamount = $rec->referenceamount;
                    $createpurpose->creationdate = $date = date('Y-m-d H:i:s');
                    
                    $createpurpose->save();

        } catch (\Exception $e){

            DB::rollBack();
            $response = array(
                'type' => '0',
                'message' => "ERROR ".$e
            );
            $rec->headers->set('Accept', 'application/json');
            echo json_encode($response);
            exit;
        }
        DB::commit();
        $response = array(
            'type' => 1,
            'message' => 'REGISTER PURPOSE',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    // Listar Concept Empleado
    public function listPurposeSupplier($rec)
    {
        //echo json_encode($rec->idinterno);
        //exit;
        DB::beginTransaction();
        try {
            $db_name = "servicare_sys";
                
        $listpurposesupplier = DB::connection($this->cur_connect)->select(
                                                            "select t0.*, t0.id as idpurpose,  t1.*
                                                            from ".$db_name.'.purposesupplier'." t0
                                                            JOIN ".$db_name.'.supplier'." t1 ON t0.idsupplier = t1.id
                                                            WHERE t0.idsupplier = '".$rec->idsupplier."'
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
            'listpurposesupplier' => $listpurposesupplier,
            'message' => 'LIST compensation OK',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    // Listar Concept Empleado
    public function listAllPurposeSupplier($rec)
    {
        //echo json_encode($rec->idinterno);
        //exit;
        DB::beginTransaction();
        try {
            $db_name = "servicare_sys";
                
        $listpurposesupplier = DB::connection($this->cur_connect)->select(
                                                            "select t0.*, t0.id as idpurpose,  t1.*
                                                            from ".$db_name.'.purposesupplier'." t0
                                                            JOIN ".$db_name.'.supplier'." t1 ON t0.idsupplier = t1.id
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
            'listpurposesupplier' => $listpurposesupplier,
            'message' => 'LIST compensation OK',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }


    //Actualizar Concept Empleado
    public function updatePurposeSupplier($rec)
    {
        //echo json_encode($rec->id);
        //exit;
        $db_name = $this->db.".purposesupplier";

        DB::beginTransaction();
        try {

            DB::connection($this->cur_connect)->update("UPDATE ".$db_name." 
                SET description = '".$rec-> description."'
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
            'message' => 'UPDATED PURPOSE OK'
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    //Delete Concept Empleado
    public function deletePurposeSupplier($rec)
    {
        $db_name = $this->db.".purposesupplier";

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

    //Create commentswo
    public function createCommentsWO($rec)
    {

        DB::beginTransaction();
        try {
                    $db_name = $this->db.".commentswo";
                    $createpurpose = new ModelGlobal();
                    $createpurpose->setConnection($this->cur_connect);
                    $createpurpose->setTable($db_name);

                    $createpurpose->idquote = $rec->idquote;
                    $createpurpose->commentprivate = $rec->commentprivate;
                    $createpurpose->commentworkorder = $rec->commentworkorder;
                    $createpurpose->commentinvoice = $rec->commentinvoice;
                    $createpurpose->creationdate = $date = date('Y-m-d H:i:s');
                    
                    $createpurpose->save();

        } catch (\Exception $e){

            DB::rollBack();
            $response = array(
                'type' => '0',
                'message' => "ERROR ".$e
            );
            $rec->headers->set('Accept', 'application/json');
            echo json_encode($response);
            exit;
        }
        DB::commit();
        $response = array(
            'type' => 1,
            'message' => 'REGISTER comments wo',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    // Listar Concept Empleado
    public function listCommentsWO($rec)
    {
        //echo json_encode($rec->idinterno);
        //exit;
        DB::beginTransaction();
        try {
            $db_name = "servicare_sys";
                
        $listcommentswo = DB::connection($this->cur_connect)->select(
                                                            "select t0.*
                                                            from ".$db_name.'.commentswo'." t0
                                                            WHERE t0.idquote = '".$rec->idquote."'
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
            'listcommentswo' => $listcommentswo,
            'message' => 'LIST compensation OK',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    //Actualizar Concept Empleado
    public function updateCommentsWO($rec)
    {
        //echo json_encode($rec->id);
        //exit;
        $db_name = $this->db.".commentswo";

        DB::beginTransaction();
        try {

            DB::connection($this->cur_connect)->update("UPDATE ".$db_name." 
                SET commentprivate = '".$rec-> commentprivate."',
                    commentworkorder = '".$rec-> commentworkorder."',
                    commentinvoice = '".$rec-> commentinvoice."'
                WHERE idquote = '".$rec->id."'");

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
            'message' => 'UPDATED PURPOSE OK'
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    //Delete Concept Empleado
    public function deleteCommentsWO($rec)
    {
        $db_name = $this->db.".commentswo";

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

    //Create commentswo
    public function createCommentsInvoice($rec)
    {

        DB::beginTransaction();
        try {
                    $db_name = $this->db.".commentsinvoice";
                    $createpurpose = new ModelGlobal();
                    $createpurpose->setConnection($this->cur_connect);
                    $createpurpose->setTable($db_name);

                    $createpurpose->idinvoice = $rec->idinvoice;
                    $createpurpose->commentinvoice = $rec->commentinvoice;
                    $createpurpose->creationdate = $date = date('Y-m-d H:i:s');
                    
                    $createpurpose->save();

        } catch (\Exception $e){

            DB::rollBack();
            $response = array(
                'type' => '0',
                'message' => "ERROR ".$e
            );
            $rec->headers->set('Accept', 'application/json');
            echo json_encode($response);
            exit;
        }
        DB::commit();
        $response = array(
            'type' => 1,
            'message' => 'REGISTER comments wo',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    // Listar Concept Empleado
    public function listCommentsInvoice($rec)
    {
        //echo json_encode($rec->idinterno);
        //exit;
        DB::beginTransaction();
        try {
            $db_name = "servicare_sys";
                
        $listcommentsinvoice = DB::connection($this->cur_connect)->select(
                                                        "select t0.*
                                                        from ".$db_name.'.commentsinvoice'." t0
                                                        WHERE t0.idinvoice = '".$rec->idinvoice."'
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
            'listcommentsinvoice' => $listcommentsinvoice,
            'message' => 'LIST COMMENTS OK',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    //Actualizar Concept Empleado
    public function updateCommentsInvoice($rec)
    {
        //echo json_encode($rec->id);
        //exit;
        $db_name = $this->db.".commentsinvoice";

        DB::beginTransaction();
        try {

            DB::connection($this->cur_connect)->update("UPDATE ".$db_name." 
                SET commentinvoice = '".$rec-> commentinvoice."'
                WHERE idinvoice = '".$rec->idinvoice."'");

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
            'message' => 'UPDATED COMMENTS OK'
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    //Delete Concept Empleado
    public function deleteCommentsInvoice($rec)
    {
        $db_name = $this->db.".commentsinvoice";

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

    //Create comments application
    public function createCommentsApp($rec)
    {

        DB::beginTransaction();
        try {
                    $db_name = $this->db.".commentsapp";
                    $createcommentsapp = new ModelGlobal();
                    $createcommentsapp->setConnection($this->cur_connect);
                    $createcommentsapp->setTable($db_name);

                    $createcommentsapp->type = $rec->type;
                    $createcommentsapp->interviewby = $rec->interviewby;
                    $createcommentsapp->cleaningtype = $rec->cleaningtype;
                    $createcommentsapp->availablehours = $rec->availablehours;
                    $createcommentsapp->status = $rec->status;
                    $createcommentsapp->zone = $rec->zone;
                    $createcommentsapp->comments = $rec->comments;
                    $createcommentsapp->idapplication = $rec->idapplication;
                    $createcommentsapp->creationdate = $date = date('Y-m-d H:i:s');
                    
                    $createcommentsapp->save();

        } catch (\Exception $e){

            DB::rollBack();
            $response = array(
                'type' => '0',
                'message' => "ERROR ".$e
            );
            $rec->headers->set('Accept', 'application/json');
            echo json_encode($response);
            exit;
        }
        DB::commit();
        $response = array(
            'type' => 1,
            'message' => 'REGISTER Comments App',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    // Listar comments application
    public function listCommentsApp($rec)
    {
        //echo json_encode($rec->idinterno);
        //exit;
        DB::beginTransaction();
        try {
            $db_name = "servicare_sys";
                
        $listcommentsapp = DB::connection($this->cur_connect)->select(
                                                            "select t0.*
                                                            from ".$db_name.'.commentsapp'." t0
                                                            WHERE t0.type = '". $rec->type."'
                                                              AND t0.idapplication = '". $rec->idapplication."'
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
            'listcommentsapp' => $listcommentsapp,
            'message' => 'LIST comments app OK',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    //Actualizar  comments application
    public function updateCommentsApp($rec)
    {
        //echo json_encode($rec->id);
        //exit;
        $db_name = $this->db.".commentsapp";

        DB::beginTransaction();
        try {

            DB::connection($this->cur_connect)->update("UPDATE ".$db_name." 
                SET interviewby = '".$rec-> interviewby."',
                    availablehours = '".$rec-> availablehours."',
                    cleaningtype = '".$rec-> cleaningtype."',
                    status = '".$rec-> status."',
                    zone = '".$rec-> zone."',
                    comments = '".$rec-> comments."'
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
            'message' => 'UPDATED COMMENTS APP OK'
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    //Delete  comments application
    public function deleteCommentsApp($rec)
    {
        $db_name = $this->db.".commentsapp";

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

    //Create User Servicare BD
    public function createUser($rec)
    {

        DB::beginTransaction();
        try {
                    $db_name = $this->db.".users";
                    $createuser = new ModelGlobal();
                    $createuser->setConnection($this->cur_connect);
                    $createuser->setTable($db_name);

                    $createuser->uid = $rec->uid;
                    $createuser->idemployee = $rec->idemployee;
                    $createuser->email = $rec->email;
                    $createuser->firstname = $rec->firstname;
                    $createuser->lastname = $rec->lastname;
                    $createuser->usertype = $rec->usertype;
                    $createuser->active = $rec->active;
                    $createuser->password = $rec->password;
                    $createuser->creationdate = $date = date('Y-m-d H:i:s');
                    
                    $createuser->save();

        } catch (\Exception $e){

            DB::rollBack();
            $response = array(
                'type' => '0',
                'message' => "ERROR ".$e
            );
            $rec->headers->set('Accept', 'application/json');
            echo json_encode($response);
            exit;
        }
        DB::commit();
        $response = array(
            'type' => 1,
            'message' => 'REGISTER USER OK',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    // Listar User Servicare BD
    public function listUsers($rec)
    {
        //echo json_encode($rec->idinterno);
        //exit;
        DB::beginTransaction();
        try {
            $db_name = "servicare_sys";
                
        $listusers = DB::connection($this->cur_connect)->select(
                                                        "select t0.*, t1.description as namestatus, t2.description as classemployee,
                                                                t3.description as typeemployee
                                                        from ".$db_name.'.users'." t0
                                                        JOIN ".$db_name.'.employee'." t4 ON t0.uid = t4.uid
                                                        
                                                        JOIN ".$db_name.'.status'." t1 ON t0.active = t1.id
                                                        JOIN ".$db_name.'.employeeclassifications'." t2 ON t4.classemployee = t2.id
                                                        JOIN ".$db_name.'.typeemployee'." t3 ON t4.employeetype = t3.id
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
            'listusers' => $listusers,
            'message' => 'LIST USERS OK',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    //Listar User Servicare BD
    public function listOneUser($rec)
    {
        //echo json_encode($rec->idinterno);
        //exit;
        DB::beginTransaction();
        try {
            $db_name = "servicare_sys";
                
        $listusers = DB::connection($this->cur_connect)->select(
                                                        "select t0.*, t1.employeetype
                                                        from ".$db_name.'.users'." t0
                                                        JOIN ".$db_name.'.employee'." t1 ON t0.uid = t1.uid
                                                        WHERE t0.uid = '".$rec->uid."'
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
            'listusers' => $listusers,
            'message' => 'LIST USER OK',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    // Listar User Servicare BD
    public function listUserEmail($rec)
    {
        //echo json_encode($rec->idinterno);
        //exit;
        DB::beginTransaction();
        try {
            $db_name = "servicare_sys";
                
        $listusers = DB::connection($this->cur_connect)->select(
                                                        "select t0.*
                                                        from ".$db_name.'.users'." t0
                                                        WHERE t0.email = '".$rec->email."'
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
            'listusers' => $listusers,
            'message' => 'LIST USER OK',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    //ActualizarUser Servicare BD
    public function updateUser($rec)
    {
        //echo json_encode($rec->id);
        //exit;
        $db_name = $this->db.".users";

        DB::beginTransaction();
        try {

            DB::connection($this->cur_connect)->update("UPDATE ".$db_name." 
                SET idemployee = '".$rec-> idemployee."',
                    firstname = '".$rec-> firstname."',
                    lastname = '".$rec-> lastname."',
                    usertype = '".$rec-> usertype."',
                    active = '".$rec-> active."'
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
            'message' => 'UPDATED USER OK'
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    //ActualizarUser Servicare BD
    public function updateIDUser($rec)
    {
        //echo json_encode($rec->id);
        //exit;
        $db_name = $this->db.".users";

        DB::beginTransaction();
        try {

            DB::connection($this->cur_connect)->update("UPDATE ".$db_name." 
                SET idemployee = '".$rec-> idemployee."'
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
            'message' => 'UPDATED USER OK'
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    //ActualizarUser Servicare BD
    public function updatePasswordUser($rec)
    {
        //echo json_encode($rec->id);
        //exit;
        $db_name = $this->db.".users";

        DB::beginTransaction();
        try {

            DB::connection($this->cur_connect)->update("UPDATE ".$db_name." 
                SET password = '".$rec-> password."'
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
            'message' => 'UPDATED USER OK'
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    //ActualizarUser Servicare BD
    public function updateStatusUser($rec)
    {
        //echo json_encode($rec->id);
        //exit;
        $db_name = $this->db.".users";

        DB::beginTransaction();
        try {

            DB::connection($this->cur_connect)->update("UPDATE ".$db_name." 
                SET active = '".$rec-> status."'
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
            'message' => 'UPDATED USER OK'
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    //Delete User Servicare BD
    public function deleteUser($rec)
    {
        $db_name = $this->db.".users";

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

    //Create notificaciones
    public function createNotification($rec)
    {
        DB::beginTransaction();
        try {
                    $db_name = $this->db.".notifications";
                    $notificaciones = new ModelGlobal();
                    $notificaciones->setConnection($this->cur_connect);
                    $notificaciones->setTable($db_name);

                    $notificaciones->uiduser = $rec->uiduser;
                    $notificaciones->idnotification = $rec->idnotification;
                    $notificaciones->notiticationstype = $rec->notiticationstype;
                    $notificaciones->comments = $rec->comments;
                    $notificaciones->status = $rec->status;
                    $notificaciones->ctlreadnotifications = 66;
                    $notificaciones->creationdate = $date = date('Y-m-d H:i:s');
                    
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
        $db_name = "servicare_sys";
                
        $listarnotifications = DB::connection($this->cur_connect)->select(
                                                "select t0.*, t1.description as namenotification,
                                                        t2.description as namestatus, t3.descriptionalt as namecontrol
                                                from ".$db_name.'.notifications'." t0 
                                                JOIN ".$db_name.'.notificationstype'." t1 ON t0.notiticationstype = t1.id
                                                JOIN ".$db_name.'.status'." t2 ON t0.status = t2.id
                                                JOIN ".$db_name.'.statusalternate'." t3 ON t0.ctlreadnotifications = t3.idalt
                                                WHERE t0.uiduser = '". $rec->uiduser."'
                                                  AND t0.status in (60,61)
                                                  AND t0.ctlreadnotifications in (66)
                                                ORDER BY t0.creationdate DESC"); 

        } catch (\Exception $e){
        
            DB::rollBack();
            $response = array(
                'type' => '0',
                'message' => "ERROR ".$e
            );
            $rec->headers->set('Accept', 'application/json');
            echo json_encode($response);
            exit;
        }
        DB::commit();
        $response = array(
            'type' => 1,
            'listarnotifications' => $listarnotifications,
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
        $db_name = "servicare_sys";
                
        $listarnotifications = DB::connection($this->cur_connect)->select(
                                                "select t0.*, t1.description as namenotification,
                                                        t2.description as namestatus, t3.descriptionalt as namecontrol
                                                from ".$db_name.'.notifications'." t0 
                                                JOIN ".$db_name.'.notificationstype'." t1 ON t0.notiticationstype = t1.id
                                                JOIN ".$db_name.'.status'." t2 ON t0.status = t2.id
                                                JOIN ".$db_name.'.statusalternate'." t3 ON t0.ctlreadnotifications = t3.idalt
                                                WHERE t0.uiduser = '". $rec->uiduser."'
                                                  AND t0.status in (60,61)
                                                ORDER BY t0.ctlreadnotifications DESC, 
                                                t0.creationdate  DESC"); 

        } catch (\Exception $e){
        
            DB::rollBack();
            $response = array(
                'type' => '0',
                'message' => "ERROR ".$e
            );
            $rec->headers->set('Accept', 'application/json');
            echo json_encode($response);
            exit;
        }
        DB::commit();
        $response = array(
            'type' => 1,
            'listarnotifications' => $listarnotifications,
            'message' => 'REGISTRO EXITOSO',
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
        $db_name = $this->db.".notifications";
   
        DB::beginTransaction();
        try {
   
              DB::connection($this->cur_connect)->update("UPDATE ".$db_name." 
                  SET ctlreadnotifications = '".$rec->ctlreadnotifications."'
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

    //Create control notificaciones recurrentes
    public function createCtrlNotification($rec)
    {
        DB::beginTransaction();
        try {
                    $db_name = $this->db.".controlnotifications";
                    $notificaciones = new ModelGlobal();
                    $notificaciones->setConnection($this->cur_connect);
                    $notificaciones->setTable($db_name);

                    $notificaciones->uiduser = $rec->uiduser;
                    $notificaciones->idnotification = $rec->idnotification;
                    $notificaciones->notiticationstype = $rec->notiticationstype;
                    $notificaciones->comments = $rec->comments;
                    $notificaciones->pastday = $rec->pastday;
                    $notificaciones->status = $rec->status;
                    $notificaciones->ctlreadnotifications = 66;
                    $notificaciones->creationdate = $date = date('Y-m-d H:i:s');
                    
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

    public function listarCtrlNotificaciones($rec)
    {
        DB::beginTransaction();
        try {
        $db_name = "servicare_sys";
                
        $listarnotifications = DB::connection($this->cur_connect)->select(
                                                "select t0.*, t1.description as namenotification,
                                                        t2.description as namestatus, t3.descriptionalt as namecontrol
                                                from ".$db_name.'.controlnotifications'." t0 
                                                JOIN ".$db_name.'.notificationstype'." t1 ON t0.notiticationstype = t1.id
                                                JOIN ".$db_name.'.status'." t2 ON t0.status = t2.id
                                                JOIN ".$db_name.'.statusalternate'." t3 ON t0.ctlreadnotifications = t3.idalt
                                                WHERE t0.uiduser = '". $rec->uiduser."'
                                                  AND t0.status in (60,61)
                                                  AND t0.ctlreadnotifications in (66)
                                                ORDER BY t0.creationdate DESC"); 

        } catch (\Exception $e){
        
            DB::rollBack();
            $response = array(
                'type' => '0',
                'message' => "ERROR ".$e
            );
            $rec->headers->set('Accept', 'application/json');
            echo json_encode($response);
            exit;
        }
        DB::commit();
        $response = array(
            'type' => 1,
            'listarnotifications' => $listarnotifications,
            'message' => 'REGISTRO EXITOSO',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    public function listarCtrlAllNotificaciones($rec)
    {
        DB::beginTransaction();
        try {
        $db_name = "servicare_sys";
                
        $listarnotifications = DB::connection($this->cur_connect)->select(
                                                "select t0.*, t1.description as namenotification,
                                                        t2.description as namestatus, t3.descriptionalt as namecontrol
                                                from ".$db_name.'.controlnotifications'." t0 
                                                JOIN ".$db_name.'.notificationstype'." t1 ON t0.notiticationstype = t1.id
                                                JOIN ".$db_name.'.status'." t2 ON t0.status = t2.id
                                                JOIN ".$db_name.'.statusalternate'." t3 ON t0.ctlreadnotifications = t3.idalt
                                                WHERE t0.uiduser = '". $rec->uiduser."'
                                                  AND t0.status in (60,61)
                                                ORDER BY t0.ctlreadnotifications DESC, 
                                                t0.creationdate  DESC"); 

        } catch (\Exception $e){
        
            DB::rollBack();
            $response = array(
                'type' => '0',
                'message' => "ERROR ".$e
            );
            $rec->headers->set('Accept', 'application/json');
            echo json_encode($response);
            exit;
        }
        DB::commit();
        $response = array(
            'type' => 1,
            'listarnotifications' => $listarnotifications,
            'message' => 'REGISTRO EXITOSO',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    //Actualiza estado de la devolución
    public function updateCtrlNotificacion($rec)
    {
        //echo json_encode($rec->estadomensaje);
        //exit;
        $db_name = $this->db.".controlnotifications";
   
        DB::beginTransaction();
        try {
   
              DB::connection($this->cur_connect)->update("UPDATE ".$db_name." 
                  SET ctlreadnotifications = '".$rec->ctlreadnotifications."'
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

    //Create notificaciones
    public function createNotifScheduled ($rec)
    {
        DB::beginTransaction();
        try {
                    $db_name = $this->db.".notificationsscheduled";
                    $notificaciones = new ModelGlobal();
                    $notificaciones->setConnection($this->cur_connect);
                    $notificaciones->setTable($db_name);

                    $notificaciones->uiduser = $rec->uiduser;
                    $notificaciones->idnotification = $rec->idnotification;
                    $notificaciones->notiticationstype = $rec->notiticationstype;
                    $notificaciones->interval = $rec->interval;
                    $notificaciones->comments = $rec->comments;
                    $notificaciones->status = $rec->status;
                    $notificaciones->ctlreadnotifications = 66;
                    $notificaciones->creationdate = $date = date('Y-m-d H:i:s');
                    
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

    public function listarNotifScheduled($rec)
    {
        DB::beginTransaction();
        try {
        $db_name = "servicare_sys";
                
        $listarnotifications = DB::connection($this->cur_connect)->select(
                                                "select t0.*, t1.description as namenotification,
                                                        t2.description as namestatus, t3.descriptionalt as namecontrol
                                                from ".$db_name.'.notificationsscheduled'." t0 
                                                JOIN ".$db_name.'.notificationstype'." t1 ON t0.notiticationstype = t1.id
                                                JOIN ".$db_name.'.status'." t2 ON t0.status = t2.id
                                                JOIN ".$db_name.'.statusalternate'." t3 ON t0.ctlreadnotifications = t3.idalt
                                                WHERE t0.uiduser = '". $rec->uiduser."'
                                                  AND t0.status in (60,61)
                                                  AND t0.ctlreadnotifications in (66)
                                                ORDER BY t0.creationdate DESC"); 

        } catch (\Exception $e){
        
            DB::rollBack();
            $response = array(
                'type' => '0',
                'message' => "ERROR ".$e
            );
            $rec->headers->set('Accept', 'application/json');
            echo json_encode($response);
            exit;
        }
        DB::commit();
        $response = array(
            'type' => 1,
            'listarnotifications' => $listarnotifications,
            'message' => 'REGISTRO EXITOSO',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    public function listarAllNotifScheduled($rec)
    {
        DB::beginTransaction();
        try {
        $db_name = "servicare_sys";
                
        $listarnotifications = DB::connection($this->cur_connect)->select(
                                                "select t0.*, t1.description as namenotification,
                                                        t2.description as namestatus, t3.descriptionalt as namecontrol
                                                from ".$db_name.'.notificationsscheduled'." t0 
                                                JOIN ".$db_name.'.notificationstype'." t1 ON t0.notiticationstype = t1.id
                                                JOIN ".$db_name.'.status'." t2 ON t0.status = t2.id
                                                JOIN ".$db_name.'.statusalternate'." t3 ON t0.ctlreadnotifications = t3.idalt
                                                WHERE t0.uiduser = '". $rec->uiduser."'
                                                  AND t0.status in (60,61)
                                                ORDER BY t0.ctlreadnotifications DESC, 
                                                t0.creationdate  DESC"); 

        } catch (\Exception $e){
        
            DB::rollBack();
            $response = array(
                'type' => '0',
                'message' => "ERROR ".$e
            );
            $rec->headers->set('Accept', 'application/json');
            echo json_encode($response);
            exit;
        }
        DB::commit();
        $response = array(
            'type' => 1,
            'listarnotifications' => $listarnotifications,
            'message' => 'REGISTRO EXITOSO',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    //Actualiza estado de la devolución
    public function updateNotifScheduled($rec)
    {
        //echo json_encode($rec->estadomensaje);
        //exit;
        $db_name = $this->db.".notificationsscheduled";
   
        DB::beginTransaction();
        try {
   
              DB::connection($this->cur_connect)->update("UPDATE ".$db_name." 
                  SET ctlreadnotifications = '".$rec->ctlreadnotifications."'
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

    //Create Notificacion Renew Agreement
    public function createNotifRenewAgreement ($rec)
    {
        DB::beginTransaction();
        try {
                    $db_name = $this->db.".notifrenewagreement";
                    $notificaciones = new ModelGlobal();
                    $notificaciones->setConnection($this->cur_connect);
                    $notificaciones->setTable($db_name);

                    $notificaciones->uiduser = $rec->uiduser;
                    $notificaciones->idnotification = $rec->idnotification;
                    $notificaciones->idquote = $rec->idquote;
                    $notificaciones->notiticationstype = $rec->notiticationstype;
                    $notificaciones->intervaldate = $rec->intervaldate;
                    $notificaciones->startdateagreement = $rec->startdateagreement;
                    $notificaciones->enddateagreement = $rec->enddateagreement;
                    $notificaciones->comments = $rec->comments;
                    $notificaciones->status = $rec->status;
                    $notificaciones->ctlreadnotifications = 66;
                    $notificaciones->creationdate = $date = date('Y-m-d H:i:s');
                    
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

    public function listarNotifRenewAgreement($rec)
    {
        DB::beginTransaction();
        try {
        $db_name = "servicare_sys";
                
        $listarnotifications = DB::connection($this->cur_connect)->select(
                                                "select t0.*, t1.description as namenotification,
                                                        t2.description as namestatus, t3.descriptionalt as namecontrol
                                                from ".$db_name.'.notifrenewagreement'." t0 
                                                JOIN ".$db_name.'.notificationstype'." t1 ON t0.notiticationstype = t1.id
                                                JOIN ".$db_name.'.status'." t2 ON t0.status = t2.id
                                                JOIN ".$db_name.'.statusalternate'." t3 ON t0.ctlreadnotifications = t3.idalt
                                                WHERE t0.uiduser = '". $rec->uiduser."'
                                                  AND t0.status in (60,61)
                                                  AND t0.ctlreadnotifications in (66)
                                                ORDER BY t0.creationdate DESC"); 

        } catch (\Exception $e){
        
            DB::rollBack();
            $response = array(
                'type' => '0',
                'message' => "ERROR ".$e
            );
            $rec->headers->set('Accept', 'application/json');
            echo json_encode($response);
            exit;
        }
        DB::commit();
        $response = array(
            'type' => 1,
            'listarnotifications' => $listarnotifications,
            'message' => 'REGISTRO EXITOSO',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    public function listarAllNotifRenewAgreement($rec)
    {
        DB::beginTransaction();
        try {
        $db_name = "servicare_sys";
                
        $listarnotifications = DB::connection($this->cur_connect)->select(
                                                "select t0.*, t1.description as namenotification,
                                                        t2.description as namestatus, t3.descriptionalt as namecontrol,
                                                        (TRUNCATE(((DATEDIFF(NOW(), t0.enddateagreement ))),1)+3) AS daysleft
                                                from ".$db_name.'.notifrenewagreement'." t0 
                                                JOIN ".$db_name.'.notificationstype'." t1 ON t0.notiticationstype = t1.id
                                                JOIN ".$db_name.'.status'." t2 ON t0.status = t2.id
                                                JOIN ".$db_name.'.statusalternate'." t3 ON t0.ctlreadnotifications = t3.idalt
                                                WHERE t0.status in (60,61)
                                                ORDER BY t0.enddateagreement ASC"); 

        } catch (\Exception $e){
        
            DB::rollBack();
            $response = array(
                'type' => '0',
                'message' => "ERROR ".$e
            );
            $rec->headers->set('Accept', 'application/json');
            echo json_encode($response);
            exit;
        }
        DB::commit();
        $response = array(
            'type' => 1,
            'listarnotifications' => $listarnotifications,
            'message' => 'REGISTRO EXITOSO',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    //Actualiza estado de la devolución
    public function updateNotifRenewAgreement($rec)
    {
        //echo json_encode($rec->estadomensaje);
        //exit;
        $db_name = $this->db.".notifrenewagreement";
   
        DB::beginTransaction();
        try {
   
              DB::connection($this->cur_connect)->update("UPDATE ".$db_name." 
                  SET ctlreadnotifications = '".$rec->ctlreadnotifications."'
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

    //Create Certificate Company
    public function createCompanyCertificate($rec)
    {
        DB::beginTransaction();
        try {
                    $db_name = $this->db.".companycertifications";
                    $createcertificatecia = new ModelGlobal();
                    $createcertificatecia->setConnection($this->cur_connect);
                    $createcertificatecia->setTable($db_name);

                    $createcertificatecia->namecertificate = $rec->namecertificate;
                    $createcertificatecia->certificatestartdate = $rec->certificatestartdate;
                    $createcertificatecia->certificateenddate = $rec->certificateenddate;
                    $createcertificatecia->creationdate = $date = date('Y-m-d H:i:s');
                    //$createcertificatecia->comments = $rec->comments;
                    $createcertificatecia->nameimg = $rec->nameimg;

                    $createcertificatecia->save();
                    
                    //Imagen base 64 se pasa a un arreglo
                    $nombrefoto[1] = $rec->nombreimagen1;
                    $foto[1] = $rec->imagen1;

                    for ($i = 1; $i <= $rec->numerodeimagenes; $i++) {
                        $this->GuardarIMG($foto[$i] ,$nombrefoto[$i],'servicaredocuments/');
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
            'message' => 'REGISTER CertificateEmployee OK',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    //Create Certificate Employee
    public function createCompanyCertificatePDF($rec)
    {
        DB::beginTransaction();
        try {
                    $db_name = $this->db.".companycertifications";
                    $createcertificatecia = new ModelGlobal();
                    $createcertificatecia->setConnection($this->cur_connect);
                    $createcertificatecia->setTable($db_name);

                    $createcertificatecia->namecertificate = $rec->namecertificate;
                    $createcertificatecia->certificatestartdate = $rec->certificatestartdate;
                    $createcertificatecia->certificateenddate = $rec->certificateenddate;
                    $createcertificatecia->creationdate = $date = date('Y-m-d H:i:s');
                    //$createcertificatecia->comments = $rec->comments;
                    $createcertificatecia->nameimg = $rec->nameimg;

                    $createcertificatecia->save();
                    
                    //Imagen base 64 se pasa a un arreglo
                    $nombrefoto[1] = $rec->nombreimagen1;
                    $foto[1] = $rec->imagen1;
/*
                    for ($i = 1; $i <= $rec->numerodeimagenes; $i++) {
                        $this->GuardarIMG($foto[$i] ,$nombrefoto[$i],'servicaredocuments/');
                    }
*/
                    for ($i = 1; $i <= $rec->numerodeimagenes; $i++) {
                        $response = FunctionsCustoms::UploadPDFName($foto[$i],$nombrefoto[1],'servicaredocuments/');
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
            'message' => 'REGISTER CertificateEmployee',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    // Listar Certificate Employee
    public function listCompanyCertificate($rec)
    {
        //echo json_encode($rec->idinterno);
        //exit;
        DB::beginTransaction();
        try {
            $db_name = "servicare_sys";
                
        $listcompanycertificates = DB::connection($this->cur_connect)->select(
                                                            "select t0.*, 
                                                            TRUNCATE(((DATEDIFF(t0.certificateenddate,
                                                            t0.certificatestartdate))),1) AS time
                                                            from ".$db_name.'.companycertifications'." t0
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
            'listcompanycertificates' => $listcompanycertificates,
            'message' => 'LIST DOCUMENT Company',
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    //Actualizar Certificate Employee
    public function updateCompanyCertificate($rec)
    {
        //echo json_encode($rec->id);
        //exit;
        $db_name = $this->db.".companycertifications";
        //comments = '".$rec-> comments."'
        DB::beginTransaction();
        try {

            DB::connection($this->cur_connect)->update("UPDATE ".$db_name." 
                SET namecertificate = '".$rec-> namecertificate."',
                    certificatestartdate = '".$rec-> certificatestartdate."',
                    certificateenddate = '".$rec-> certificateenddate."',
                    nameimg = '".$rec-> nameimg."'
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
            'message' => 'UPDATED Certificate Employee OK'
        );
        $rec->headers->set('Accept', 'application/json');
        echo json_encode($response);
        exit;
    }

    //Delete Certificate Company
    public function deleteCompanyCertificate($rec)
    {
        $db_name = $this->db.".companycertifications";

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

    public function MainMenu($rec)
    {
        $db_name = "servicare_sys";

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

    public function readUserEmail($rec)
    {
        $db_name = "servicare_sys";

        $usuarios = DB::connection($this->cur_connect)->select("select t0.* from ".$db_name.'.users'." t0 WHERE email = '". $rec->email."'");

        $usuarioseleccionado = array();

        echo json_encode($usuarios);
    }

    public function EnvioToken($rec)
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

        $db_name = "servicare_sys";

        $marcasvehiculos = DB::connection($this->cur_connect)->select("select t0.* from ".$db_name.'.marcas'." t0 WHERE tipovehiculo = ". $rec->idvehiculo);

        echo json_encode($marcasvehiculos);
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
                    $addwompi->user_legal_id = $data->data->transaction->payment_method->user_type;
                    $addwompi->status = $data->data->transaction->status;
                    $addwompi->status_message = $data->data->transaction->payment_method->payment_description;
                    $addwompi->address_line_1 = $data->data->transaction->shipping_address->address_line_1;
                    $addwompi->country = $data->data->transaction->shipping_address->country;
                    $addwompi->phone_number = $data->data->transaction->shipping_address->phone_number;
                    $addwompi->city = $data->data->transaction->shipping_address->city;
                    $addwompi->region = $data->data->transaction->shipping_address->region;
                    $addwompi->full_name = $data->data->transaction->customer_data->full_name;
                    $addwompi->phone_number = $data->data->transaction->customer_data->phone_number;
                    
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


   // Factura
    private function IntuitShowInvoice(Request $request)
    {
        $metodo = 'GET';
        $url = 'invoice/'. $request->input('id') .'?minorversion=73';
        return $this->Send($metodo, $url);
    }
    private function IntuitCreateInvoice(Request $request)
    {
        $metodo = 'POST';
        $url = 'invoice';
        $data = $request->json()->all();
        return $this->SendData($metodo, $url, $data);
    }
    private function IntuitUpdateInvoice(Request $request)
    {
        $metodo = 'POST';
        $url = 'invoice?minorversion=73';
        $data = $request->json()->all();
        return $this->SendData($metodo, $url, $data);
    }
    private function IntuitDeleteInvoice(Request $request)
    {
        $metodo = 'POST';
        $url = 'invoice?operation=delete';
        $data = $request->json()->all();
        return $this->SendData($metodo, $url, $data);
    }
    private function IntuitVoidInvoice(Request $request)
    {
        $metodo = 'POST';
        $url = 'invoice?operation=void';
        $data = $request->json()->all();
        return $this->SendData($metodo, $url, $data);
    }
    private function IntuitPDFInvoice(Request $request)
    {
        $invoiceId = $request->input('invoiceId');

        $accessToken = Cache::get('intuit_access_token');
        if (!$accessToken) {
            $accessToken = $this->refreshAccessToken();
        }
        $fullUrl = "https://sandbox-quickbooks.api.intuit.com/v3/company/{$this->CompanyId}/invoice/{$invoiceId}/pdf?minorversion=73";
        $response = Http::withHeaders([
            'Accept' => 'application/pdf',
            'Authorization' => 'Bearer ' . $accessToken,
        ])->get($fullUrl);
        if ($response->successful()) {
            return response($response->body(), 200)
                ->header('Content-Type', 'application/pdf')
                ->header('Content-Disposition', "attachment; filename=invoice_{$invoiceId}.pdf");
        } else {
            return response()->json(['error' => 'No se pudo obtener la factura PDF.'], $response->status());
        }
    }    
    private function IntuitMailInvoice(Request $request)
    {
        $invoiceId = $request->input('invoiceId');
        $email = $request->input('email', null);
        $metodo = 'POST';
        $url = "invoice/{$invoiceId}/send?sendTo={$email}";
        return $this->Send($metodo, $url);
    }    
    // Metodos de Envios
    private function Send($metodo, $url)
    {
        $accessToken = Cache::get('intuit_access_token');
        if (!$accessToken) {
            $accessToken = $this->refreshAccessToken();
        }
        $fullUrl = "https://sandbox-quickbooks.api.intuit.com/v3/company/{$this->CompanyId}/{$url}";   
        $response = Http::withHeaders([
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
            'Authorization' => 'Bearer ' . $accessToken,
        ])->timeout(120)->send($metodo, $fullUrl);

        return $response->body();
    }
    private function SendData($metodo, $url, $data)
    {
        $accessToken = Cache::get('intuit_access_token');
        if (!$accessToken) {
            $accessToken = $this->refreshAccessToken();
        }
        
        $fullUrl = "https://sandbox-quickbooks.api.intuit.com/v3/company/{$this->CompanyId}/{$url}";
        
        $response = Http::withHeaders([
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
            'Authorization' => 'Bearer ' . $accessToken,
        ])->timeout(120)->send($metodo, $fullUrl, [
            'json' => $data
        ]);

        return $response->body();
    }
    // Creación y Actualización de Token
    public function redirectToIntuit()
    {
        $authorizationUrl = $this->urlAuthorize . '?' . http_build_query([
            'response_type' => 'code',
            'client_id' => $this->clientId,
            'redirect_uri' => $this->redirectUri,
            'scope' => 'com.intuit.quickbooks.accounting',
            'state' => csrf_token(),
        ]);
        session(['oauth2state' => csrf_token()]);
        return redirect($authorizationUrl);
    }
    public function handleIntuitCallback(Request $request)
    {
        $state = $request->input('state');
        if (empty($state) || $state !== session('oauth2state')) {
            session()->forget('oauth2state');
            abort(403, 'Invalid OAuth state');
        }
        try {
            $client = new Client();
             $response = $client->post($this->urlAccessToken, [
                 'auth' => [$this->clientId, $this->clientSecret],
                 'form_params' => [
                     'grant_type' => 'authorization_code',
                     'code' => $request->input('code'),
                     'redirect_uri' => $this->redirectUri,
                 ],
             ]);
 
             $body = json_decode($response->getBody(), true);
             $accessToken = $body['access_token'];
             $refreshToken = $body['refresh_token'];
 
             session(['accessToken' => $accessToken]);
             Cache::put('intuit_access_token', $accessToken, Carbon::now()->addSeconds(3600)); // 1 Hora
             Cache::put('intuit_refresh_token', $refreshToken, Carbon::now()->addSeconds(15552000)); // 180 días
 
             return $accessToken;
 
         } catch (\Exception $e) {
             abort(500, 'Failed to get access token: ' . $e->getMessage());
         }
     }
    public function refreshAccessToken()
    {
        $refreshToken = Cache::get('intuit_refresh_token');
        if (!$refreshToken) {
            return response()->json(['redirect' => route('intuit.redirect')]); 
            // Frontend
            // $.post('/your-endpoint', function(data) {
            //     if (data.redirect) {
            //         window.open(data.redirect, '_blank', 'width=500,height=500');
            //     }
            // });
        }
        $clientId = $this->clientId;
        $clientSecret = $this->clientSecret;
        $authorization = base64_encode($clientId . ':' . $clientSecret);
        $url = 'https://oauth.platform.intuit.com/oauth2/v1/tokens/bearer';

        $ch = curl_init();

        curl_setopt_array($ch, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => http_build_query([
                'grant_type' => 'refresh_token',
                'refresh_token' => $refreshToken,
            ]),
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/x-www-form-urlencoded',
                'Accept: application/json',
                'Authorization: Basic ' . $authorization,
            ),
        ));

        $response = curl_exec($ch);

        if (curl_errno($ch)) {
            $error = curl_error($ch);
            curl_close($ch);
            abort(500, 'cURL error: ' . $error);
        }

        curl_close($ch);

        // Decodifica la respuesta JSON
        $responseData = json_decode($response, true);

        if (isset($responseData['error'])) {
            abort(500, 'Failed to refresh access token: ' . $responseData['error']);
        }

        $newAccessToken = $responseData['access_token'] ?? null;
        $expiresIn = $responseData['expires_in'] ?? 3600;
        $newRefreshToken = $responseData['refresh_token'] ?? null;
        $x_refresh_token_expires_in = $responseData['x_refresh_token_expires_in'] ?? 15551945;

        // Actualiza los tokens en la caché
        Cache::put('intuit_access_token', $newAccessToken, Carbon::now()->addSeconds($expiresIn)); // 1 Hora
        Cache::put('intuit_refresh_token', $newRefreshToken, Carbon::now()->addSeconds($x_refresh_token_expires_in)); // 180 días

        return $newAccessToken;
    }
}


