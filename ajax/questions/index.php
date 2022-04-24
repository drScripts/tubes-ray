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

function get($connection, $category_id = null)
{
    $query =
        'SELECT questions.id as questionId,questions,category_id,user_id,questions.created_at as questionsCreatedAt,questions.updated_at as questionsUpdatedAt,users.id as id_users,username,email,biodata,pic_profile,users.created_at as userCreatedAt,users.updated_at as userUpdatedAt,categories.id as classCategoryId,categories.name as classCategoryName FROM questions JOIN users ON questions.user_id=users.id JOIN categories ON questions.category_id=categories.id';

    if ($category_id) {
        $query .= " WHERE category_id = '$category_id'";
    }

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

function update($connection, $body, $id)
{
    $name = $body['name'];
    $query = "UPDATE questions SET name = '$name' WHERE id = '$id'";

    if (mysqli_query($connection, $query)) {
        echo "<response>
        <status>success</status>
        </response>";
    } else {
        echo "<response>
        <status>error</status>
        <message>
            Failed Update Category
        </message>
        </response>";
    }
}

function delete($connection, $id)
{
    $query = "DELETE FROM questions WHERE id = $id";

    if (mysqli_query($connection, $query)) {
        echo "<response>
        <status>success</status>
        </response>";
    } else {
        echo "<response>
        <status>error</status>
        <message>
            Failed to delete data
        </message>
        </response>";
    }
}

function add($connection, $body)
{
    $questions = $body['questions'];
    $user_id = $_SESSION['users']['id'];
    $category_id = $body['category_id'];

    $query = "INSERT INTO `questions`(`questions`,`user_id`,`category_id`) VALUES ('$questions','$user_id','$category_id')";

    if (mysqli_query($connection, $query)) {
        echo "<response>
        <status>success</status>
        </response>";
    } else {
        echo "<response>
        <status>error</status>
        <message>
            Failed to Add Data
        </message>
        </response>";
    }
}

switch ($method) {
    case 'POST':
        $body = $_POST;
        add($connection, $body);
        break;
    case 'GET':

        if (isset($_GET['type'])) {
            $category_id = $_GET['category_id'];
            $question = $_GET['questions'];

            $body = [
                'questions' => $question,
                'category_id' => $category_id
            ];

            add($connection, $body);
        } else {

            $category_id = null;

            if (isset($_GET['category_id'])) {
                $category_id = $_GET['category_id'];
            }

            get($connection, $category_id);
        }

        break;
    case 'PATCH':
        $id = $_POST['id'];
        $body = $_POST;
        update($connection, $body, $id);
        break;
    case 'DELETE':
        $id = $_POST['id'];
        delete($connection, $id);
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
