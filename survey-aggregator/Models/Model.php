<?php

namespace Models;

use PDO;

class Model
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function getData($userId)
    {
        $query = "SELECT id, email FROM users WHERE id = :userId";

        if ($this->surveyExists($userId)) {
            $query = "
            SELECT users.id, users.email, surveys.id AS survey_id, surveys.title, surveys.status, surveys.date, 
                   GROUP_CONCAT(answers.answer SEPARATOR ';') AS answers,
                   GROUP_CONCAT(answers.votes SEPARATOR ';') AS votes
            FROM users
            INNER JOIN surveys ON users.id = surveys.user_id
            INNER JOIN answers ON surveys.id = answers.survey_id
            WHERE users.id = :userId
            GROUP BY users.id, users.email, surveys.id, surveys.title, surveys.status, surveys.date 
            ORDER BY surveys.date DESC, surveys.status IS NULL, surveys.title
        ";

        }

        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':userId', $userId);
        $stmt->execute();
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $data;
    }

    public function surveyExists($userId)
    {
        $stmt = $this->pdo->prepare("SELECT COUNT(*) FROM surveys WHERE user_id = :userId");
        $stmt->bindParam(':userId', $userId);
        $stmt->execute();
        $count = $stmt->fetchColumn();

        return $count > 0;
    }

    public function updateSurveyStatus($surveyId, $status)
    {
        $sql = "UPDATE surveys SET status = :status WHERE id = :surveyId";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':status', $status, PDO::PARAM_INT);
        $stmt->bindValue(':surveyId', $surveyId, PDO::PARAM_INT);
        $stmt->execute();
    }

    public function saveSurvey($title, $userId)
    {
        $stmt = $this->pdo->prepare("INSERT INTO surveys (title, user_id) VALUES (?, ?)");
        $stmt->execute([$title, $userId]);
        $surveyId = $this->pdo->lastInsertId();

        return $surveyId;
    }

    public function saveAnswers($surveyId, $answers, $votes)
    {
        $stmt = $this->pdo->prepare("INSERT INTO answers (survey_id, answer, votes) VALUES (?, ?, ?)");

        foreach ($answers as $index => $answer) {
            $vote = $votes[$index];
            $stmt->execute([$surveyId, $answer, $vote]);
        }
    }

    public function deleteSurvey($surveyId)
    {
        $stmt = $this->pdo->prepare("DELETE FROM answers WHERE survey_id = :surveyId");
        $stmt->bindParam(':surveyId', $surveyId);
        $stmt->execute();

        $stmt = $this->pdo->prepare("DELETE FROM surveys WHERE id = :surveyId");
        $stmt->bindParam(':surveyId', $surveyId);
        $stmt->execute();
    }


    public function saveUser($email, $password)
    {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $this->pdo->prepare("INSERT INTO users (email, password) VALUES (:email, :password)");
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $hashedPassword);
        return $stmt->execute();
    }

    public function checkUser($email, $password)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM users WHERE email = :email");
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password'])) {
            return $user['id'];
        } else {
            return false;
        }
    }

    public function userExists($email)
    {
        $stmt = $this->pdo->prepare("SELECT COUNT(*) FROM users WHERE email = :email");
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        $count = $stmt->fetchColumn();

        return $count > 0;
    }

    // For API:
    public function getSurveyData($surveyId)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM surveys WHERE id = :surveyId AND status = 1");
        $stmt->bindParam(':surveyId', $surveyId);
        $stmt->execute();
        $surveyData = $stmt->fetch(PDO::FETCH_ASSOC);

        return $surveyData;
    }

    public function getAnswersData($surveyId)
    {
        $stmt = $this->pdo->prepare("
        SELECT a.answer, a.votes
        FROM answers AS a
        WHERE a.survey_id = :surveyId
    ");
        $stmt->bindParam(':surveyId', $surveyId);
        $stmt->execute();
        $answersData = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $answersData;
    }
}
