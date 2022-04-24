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
    $query =
        "SELECT questions.id as questionId,questions,category_id,user_id,questions.created_at as questionsCreatedAt,questions.updated_at as questionsUpdatedAt,users.id as id_users,username,email,biodata,pic_profile,users.created_at as userCreatedAt,users.updated_at as userUpdatedAt,categories.id as classCategoryId,categories.name as classCategoryName FROM questions JOIN users ON questions.user_id=users.id JOIN categories ON questions.category_id=categories.id WHERE questions.user_id = $user_id";


    $response = mysqli_query($connection, $query);
    $allData = [];
    while ($data = mysqli_fetch_assoc($response)) {
        $allData[] = $data;
    }
    $status = '<status>success</status>';
    $returnResponse =
        '<response>' .
        $status .
        xmlConvert($allData, 'questions', 'question') .
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
