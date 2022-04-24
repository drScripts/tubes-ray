<?php
require_once '../../db/index.php';
session_start();
header('Content-Type: text/xml');
$method = $_SERVER['REQUEST_METHOD'];

function xmlConvert($datas, $parent_name, $name)
{
    $stringBased = "<$parent_name>";
    foreach ($datas as $data) {
        $stringBased .= "<$name>";
        foreach ($data as $key => $value) {
            $stringBased .= "<$key>$value</$key>";
        }
        $stringBased .= "</$name>";
    }
    $stringBased .= "</$parent_name>";
    return $stringBased;
}

function get($connection, $user_id)
{
    $query = "SELECT answers.id as answerId,answers.answer,answers.question_id,answers.user_id,questions.id,questions.questions,questions.user_id,questions.category_id FROM answers LEFT JOIN questions ON answers. question_id=questions.id WHERE answers.user_id = '$user_id'";
    $response = mysqli_query($connection, $query);
    $allData = [];
    while ($data = mysqli_fetch_assoc($response)) {
        $allData[] = $data;
    }
    $status = '<status>success</status>';
    $returnResponse =
        '<response>' .
        $status .
        xmlConvert($allData, 'answers', 'answerData') .
        '</response>';
    print $returnResponse;
}

switch ($method) {
    case 'GET':
        $user_id = $_SESSION['users']['id'];
        get($connection, $user_id);
        break;
    default:
        echo "<response>
        <status>error</status>
        <message>
            No Request Method Available
        </message>
        </response>";
        break;
}
