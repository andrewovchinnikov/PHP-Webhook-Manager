<?php

declare(strict_types=1);

require_once __DIR__.'/../.././vendor/autoload.php';

use Firebase\JWT\JWT;
use GuzzleHttp\Client;
use WebhookManager\Authentication\JwtAuthentication;
use WebhookManager\Events\WebhookEvent;
use WebhookManager\Handlers\JwtWebhookHandler;
use WebhookManager\Headers\WebhookHeaders;
use WebhookManager\Clients\AsyncWebhookClient;
use WebhookManager\Loggers\SimpleWebhookLogger;
use WebhookManager\Payloads\JsonWebhookPayload;
use WebhookManager\Payloads\XmlWebhookPayload;
use WebhookManager\Payloads\YamlWebhookPayload;
use WebhookManager\Policy\SimpleRetryPolicy;
use WebhookManager\Webhook\Webhook;
use WebhookManager\Webhook\WebhookManager;

$secretKey      = 'mysecretkey';
$data           = ['foo' => 'bar', 'baz' => ['qux' => 'quux']];
$httpClient     = new Client();
$retryPolicy    = new SimpleRetryPolicy(3);
$client         = new AsyncWebhookClient($httpClient, $retryPolicy);
$authentication = new JwtAuthentication($secretKey);
$logger         = new SimpleWebhookLogger();
$manager        = new WebhookManager($client, $authentication, $logger);
$handler        = new JwtWebhookHandler($secretKey);

// JSON payload
$jsonPayload = new JsonWebhookPayload($data);
$jsonHeaders = new WebhookHeaders([
    'Authorization' => 'Bearer '.JWT::encode(['data' => $data], $secretKey, 'HS256'),
    'Content-Type'  => 'application/json',
]);
$jsonWebhook = new Webhook('https://example.com', $jsonHeaders, $jsonPayload);
$jsonEvent   = new WebhookEvent('test_event', $jsonWebhook);
$manager->registerHandler('test_event', $handler);
$manager->triggerEvent($jsonEvent);
echo "JSON webhook delivered successfully with status code: ".$jsonEvent->getWebhook()->getResponseCode().PHP_EOL;

// XML payload
$xmlData = new \SimpleXMLElement('<?xml version="1.0"?><data></data>');
array_to_xml($data, $xmlData);
$xmlPayload = new XmlWebhookPayload($xmlData);
$xmlHeaders = new WebhookHeaders([
    'Authorization' => 'Bearer '.JWT::encode(['data' => $data], $secretKey, 'HS256'),
    'Content-Type'  => 'application/xml',
]);
$xmlWebhook = new Webhook('https://example.com', $xmlHeaders, $xmlPayload);
$xmlEvent   = new WebhookEvent('test_event', $xmlWebhook);
$manager->registerHandler('test_event', $handler);
$manager->triggerEvent($xmlEvent);
echo "XML webhook delivered successfully with status code: ".$xmlEvent->getWebhook()->getResponseCode().PHP_EOL;

// YAML payload
$yamlPayload = new YamlWebhookPayload($data);
$yamlHeaders = new WebhookHeaders([
    'Authorization' => 'Bearer '.JWT::encode(['data' => $data], $secretKey, 'HS256'),
    'Content-Type'  => 'application/x-yaml',
]);
$yamlWebhook = new Webhook('https://example.com', $yamlHeaders, $yamlPayload);
$yamlEvent   = new WebhookEvent('test_event', $yamlWebhook);
$manager->registerHandler('test_event', $handler);
$manager->triggerEvent($yamlEvent);
echo "YAML webhook delivered successfully with status code: ".$yamlEvent->getWebhook()->getResponseCode().PHP_EOL;

function array_to_xml(array $data, \SimpleXMLElement &$xmlData)
{
    foreach ($data as $key => $value) {
        if (is_array($value)) {
            if (is_numeric($key)) {
                $key = 'item'.$key; // делаем ключ строкой, если он числом
            }
            $subnode = $xmlData->addChild($key);
            array_to_xml($value, $subnode);
        } else {
            $xmlData->addChild("$key", htmlspecialchars("$value"));
        }
    }
}