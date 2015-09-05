<?php

namespace iriscrm\Yii2PODataAdapter\implementation;

use yii;
use yii\web\Controller;
use POData\OperationContext\ServiceHost;
use iriscrm\SimplePOData\DataService;
use iriscrm\Yii2PODataAdapter\OperationContextAdapter;

use app\models\OData\MetadataProvider;

class ODataController extends Controller
{

    public function actionIndex()
    {
        yii::$classMap['iriscrm\SimplePOData\QueryProvider'] = '@vendor/iriscrm/Yii2PODataAdapter/implementation/QueryProvider.php';

        $op = new OperationContextAdapter(yii::$app->request);
        $host = new ServiceHost($op);
        $host->setServiceUri("/odata.svc/");
        $service = new DataService(yii::$app->db, MetadataProvider::create());
        $service->setHost($host);
        $service->handleRequest();
        $odataResponse = $op->outgoingResponse();

        $response = yii::$app->response;
        foreach ($odataResponse->getHeaders() as $headerName => $headerValue) {
            if (!is_null($headerValue)) {
                $response->headers->set($headerName, $headerValue);
            }
        }
        return $odataResponse->getStream();
    }

}
