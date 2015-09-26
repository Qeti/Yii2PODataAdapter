<?php

namespace qeti\Yii2PODataAdapter\implementation;

use yii;
use yii\web\Controller;
use POData\OperationContext\ServiceHost;
use qeti\SimplePOData\DataService;
use qeti\Yii2PODataAdapter\OperationContextAdapter;

class ODataController extends Controller
{

    public function actionIndex(
        $metaProviderClassName = 'qeti\\Yii2PODataAdapter\\implementation\\MetadataProvider', 
        $queryProviderMap = '@vendor/qeti/Yii2PODataAdapter/implementation/QueryProvider.php')
    {
        yii::$classMap['qeti\SimplePOData\QueryProvider'] = $queryProviderMap;

        $op = new OperationContextAdapter(yii::$app->request);
        $host = new ServiceHost($op);
        $host->setServiceUri("/odata.svc/");
        $service = new DataService(yii::$app->db, $metaProviderClassName::create());
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
