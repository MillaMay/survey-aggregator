<?php

namespace Controllers;

use Models\Model;
use Controllers\APIController;

class Controller
{
    protected $model;
    protected $apiController;

    public function __construct($pdo)
    {
        $this->model = new Model($pdo);
        $this->apiController = new APIController($pdo);
    }

    public function index()
    {
        session_start();

        $routes = ['/api/survey/{id}' => 'getSurveyData'];

        foreach ($routes as $route => $method) {
            $pattern = '/^' . str_replace(['/', '{id}'], ['\/', '(\d+)'], $route) . '$/';
            $matches = [];

            if ($_SERVER['REQUEST_METHOD'] === 'GET' && preg_match($pattern, $_SERVER['REQUEST_URI'], $matches)) {
                $params = array_slice($matches, 1);
                $response = $this->apiController->$method($params);
                echo $response;
                return;
            }
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST['action']) && $_POST['action'] === 'register') {
                $this->register();
                return;
            }

            $userExists = $this->model->checkUser($_POST['email'], $_POST['password']);

            if ($userExists) {
                $_SESSION['authenticated'] = true;
                $data = $this->model->getData($userExists);
                $this->render('home', ['data' => $data, 'answerVotePairs' => $this->getAnswerVotePairs($data)]);
            } elseif (isset($_POST['surveyId']) && isset($_POST['status']) && isset($_POST['id'])) {
                $this->model->updateSurveyStatus($_POST['surveyId'], $_POST['status']);
                $data = $this->model->getData($_POST['id']);
                $this->render('home', ['data' => $data, 'answerVotePairs' => $this->getAnswerVotePairs($data)]);
            } elseif (isset($_POST['question']) && isset($_POST['user_id']) && isset($_POST['answer']) && isset($_POST['votes'])) {
                $surveyId = $this->model->saveSurvey($_POST['question'], $_POST['user_id']);
                $this->model->saveAnswers($surveyId, $_POST['answer'], $_POST['votes']);
                $_SESSION['success_message'] = 'Your new survey has been successfully added!';
                header('Location: ' . $_SERVER['HTTP_REFERER']);
                exit();
            } else {
                $this->render('main', ['errorMessage' => 'Failed to log in']);
            }
        } else {
            $page = isset($_GET['page']) ? $_GET['page'] : false;

            if (isset($page) && $page === 'registration') {
                $this->render('registration', []);
            } elseif (isset($page) && $page === 'add' && $_SESSION['authenticated'] === true) {
                $this->render('add', ['user_id' => $_GET['user']]);
            } elseif (isset($page) && $page === 'home' && isset($_GET['user']) && $_SESSION['authenticated'] === true) {
                $data = $this->model->getData($_GET['user']);
                $this->render('home', ['data' => $data, 'answerVotePairs' => $this->getAnswerVotePairs($data)]);
            } elseif (isset($page) && $page === 'delete' && isset($_GET['survey'])
                && isset($_GET['user']) && $_SESSION['authenticated'] === true) {
                $this->model->deleteSurvey($_GET['survey']);
                $data = $this->model->getData($_GET['user']);
                $this->render('home', ['data' => $data, 'answerVotePairs' => $this->getAnswerVotePairs($data)]);
            } elseif (isset($page) && $page === 'logout') {
                $this->logout();
            } else {
                $this->render('main', []);
            }
        }
    }

    public function render($templateName, $data)
    {
        $templateDir = __DIR__ . '/../Views/';
        $headerFile = $templateDir . 'header.php';
        $footerFile = $templateDir . 'footer.php';
        $mainFile = $templateDir . $templateName . '.php';

        if (file_exists($headerFile) && file_exists($footerFile) && file_exists($mainFile)) {
            extract($data);
            include $headerFile;
            include $mainFile;
            include $footerFile;
        } else {
            echo 'Page not found';
        }
    }

    public function register()
    {
        $errorMessage = '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $password = $_POST['password'];
            $email = $_POST['email'];

            if ($this->model->userExists($email)) {
                $this->render('registration', ['errorMessage' => 'User with this email already exists.']);
                return;
            }

            if ($password !== $_POST['confirm_password']) {
                $this->render('registration', ['errorMessage' => 'Password and Confirm Password do not match.']);
                return;
            } else {
                $success = $this->model->saveUser($email, $password);

                if ($success) {
                    $this->render('main', ['successMessage' => 'Registration successful. Please log in.']);
                    return;
                } else {
                    $errorMessage = 'Failed to register. Please try again.';
                }
            }
        }

        $this->render('registration', ['errorMessage' => $errorMessage]);
    }

    public function logout()
    {
        session_start();
        session_destroy();
        unset($_SESSION['authenticated']);

        $this->render('main', []);
    }

    protected function getAnswerVotePairs($data)
    {
        $answerVotePairs = [];

        foreach ($data as $userData) {
            $answersArray = explode(';', $userData['answers']);
            $votesArray = explode(';', $userData['votes']);
            $answerVotePair = array_combine($answersArray, $votesArray);
            $answerVotePairs[$userData['title']] = $answerVotePair;
        }

        return $answerVotePairs;
    }
}
