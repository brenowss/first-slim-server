<?php

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

$app = new \Slim\App;

$app->get('/customers', function (Request $request, Response $response) {
    $sql = "SELECT * FROM customers;";

    try {
        $db = new db();
        $db = $db->connect();

        $stmt = $db->query($sql);

        $customers = $stmt->fetchAll(PDO::FETCH_OBJ);

        $db = null;

        return json_encode($customers);
    } catch (\Throwable $th) {
        return json_encode($th);
    }

    return $response;
});

$app->get('/customers/{id}', function (Request $request, Response $response) {
    $id = $request->getAttribute('id');

    $sql = "SELECT * FROM customers WHERE id = $id LIMIT 1;";

    try {
        $db = new db();
        $db = $db->connect();

        $stmt = $db->query($sql);

        $customers = $stmt->fetchAll(PDO::FETCH_OBJ);

        $db = null;

        return json_encode($customers);
    } catch (\Throwable $th) {
        return json_encode($th);
    }

    return $response;
});

$app->post('/customers', function (Request $request, Response $response) {
    $body = $request->getParsedBody();

    $first_name = $body['first_name'];
    $last_name = $body['last_name'];
    $phone = $body['phone'];
    $email = $body['email'];
    $city = $body['city'];
    $address = $body['address'];
    $state = $body['state'];

    $sql = "INSERT INTO customers (first_name,last_name,phone,email,city,address,state) VALUES (:first_name,:last_name,:phone,:email,:city,:address,:state);";

    try {
        $db = new db();
        $db = $db->connect();

        $stmt = $db->prepare($sql);

        $stmt->bindParam(':first_name', $first_name);
        $stmt->bindParam(':last_name', $last_name);
        $stmt->bindParam(':phone', $phone);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':city', $city);
        $stmt->bindParam(':address', $address);
        $stmt->bindParam(':state', $state);

        $stmt->execute();

        return '{"message": "Customer added"}';
    } catch (\Throwable $th) {
        return json_encode($th);
    }

    return $response;
});

$app->put('/customers/{id}', function (Request $request, Response $response) {
    $body = $request->getParsedBody();
    $id = $request->getAttribute('id');

    $first_name = $body['first_name'];
    $last_name = $body['last_name'];
    $phone = $body['phone'];
    $email = $body['email'];
    $city = $body['city'];
    $address = $body['address'];
    $state = $body['state'];

    $sql = "UPDATE customers SET
                first_name = :first_name,
                last_name = :last_name,
                phone = :phone,
                email = :email,
                city = :city,
                address = :address,
                state = :state
            WHERE id = $id";

    try {
        $db = new db();
        $db = $db->connect();

        $stmt = $db->prepare($sql);

        $stmt->bindParam(':first_name', $first_name);
        $stmt->bindParam(':last_name', $last_name);
        $stmt->bindParam(':phone', $phone);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':city', $city);
        $stmt->bindParam(':address', $address);
        $stmt->bindParam(':state', $state);

        $stmt->execute();

        return '{"message": "Customer updated"}';
    } catch (\Throwable $th) {
        return json_encode($th);
    }

    return $response;
});

$app->delete('/customers/{id}', function (Request $request, Response $response) {
    $id = $request->getAttribute('id');

    $sql = "DELETE FROM customers WHERE id = $id";

    try {
        $db = new db();
        $db = $db->connect();

        $stmt = $db->prepare($sql)->execute();

        return '{"message": "Customer deleted"}';
    } catch (\Throwable $th) {
        return json_encode($th);
    }

    return $response;
});