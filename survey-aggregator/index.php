<?php

require_once 'config/autoload.php';


/** @var $pdo */

$controller = new Controllers\Controller($pdo);
$apiController = new Controllers\APIController($pdo);

$controller->index();

$stmt = $pdo->query("SELECT id FROM surveys");
$surveyIds = $stmt->fetchAll(PDO::FETCH_COLUMN);

foreach ($surveyIds as $surveyId) {
    $params = [$surveyId];
    $apiController->getSurveyData($params);
}
