<?php
require_once '../../db/index.php';
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

function get($connection)
{
    $query = 'SELECT * FROM categories';
    $response = mysqli_query($connection, $query);
    $allData = [];

    while ($data = mysqli_fetch_assoc($response)) {
        $allData[] = $data;
    }
    $status = '<status>success</status>';
    $returnResponse =
        '<response>' .
        $status .
        xmlConvert($allData, 'categories', 'category') .
        '</response>';
    print $returnResponse;
}

function update($connection, $body, $id)
{
    $name = $body['name'];
    $query = "UPDATE categories SET name = '$name' WHERE id = '$id'";

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
    $query = "DELETE FROM categories WHERE id = $id";

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
    $name = $body['name'];
    $query = "INSERT INTO `categories`(`name`) VALUES ('$name')";

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
        get($connection);
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
