<?php

namespace Controllers;

use Models\Model;

class APIController
{
    protected $model;

    public function __construct($pdo)
    {
        $this->model = new Model($pdo);
    }

    public function getSurveyData($params)
    {
        if (is_array($params) && count($params) > 0) {
            $surveyId = $params[0];
            $surveyData = $this->model->getSurveyData($surveyId);

            if ($surveyData && $surveyData['status'] == 1) {
                $answersData = $this->model->getAnswersData($surveyId);

                $data = [
                    'title' => $surveyData['title'],
                    'answers' => $answersData
                ];

                return json_encode($data, JSON_UNESCAPED_UNICODE);
            } else {
                return json_encode(['error' => 'The survey with this ID either does not exist or is not published.']);
            }
        } else {
            return json_encode(['error' => 'You need to specify the survey ID.']);
        }
    }
}
