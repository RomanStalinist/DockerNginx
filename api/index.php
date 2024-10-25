<?php

// Настройки базы данных
$host = 'mysql_db';
$db = 'mouse_db';
$user = 'user';
$pass = 'password';

// Подключение к базе данных с использованием MySQLi
$conn = new mysqli($host, $user, $pass, $db);

// Проверка соединения
if ($conn->connect_error) {
    http_response_code(500);
    echo json_encode(['error' => 'Database connection failed: ' . $conn->connect_error]);
    exit();
}

// Определение метода запроса и маршрута
$method = $_SERVER['REQUEST_METHOD'];
$id = array_key_exists('id', $_GET) ? $_GET['id'] : null;

// API endpoints
switch ($method) {
    case 'GET':
        if (isset($id)) {
            $stmt = $conn->prepare('SELECT * FROM mice WHERE id = ?');
            $stmt->bind_param('i', $id);
            $stmt->execute();
            $result = $stmt->get_result();
            $mouse = $result->fetch_assoc();
            echo json_encode($mouse ?? ['error' => 'Mouse not found'], JSON_PRETTY_PRINT);
            $stmt->close();
        } else {
            // Получить все мыши
            $result = $conn->query('SELECT * FROM mice');
            $mice = [];
            while ($row = $result->fetch_assoc()) {
                $mice[] = $row;
            }
            echo json_encode($mice, JSON_PRETTY_PRINT);
        }
        break;

    case 'POST':
        // Добавить новую мышь
        $input = json_decode(file_get_contents('php://input'), true);
        $stmt = $conn->prepare('INSERT INTO mice (name, brand, price) VALUES (?, ?, ?)');
        $stmt->bind_param('ssd', $input['name'], $input['brand'], $input['price']);
        $stmt->execute();
        echo json_encode(['id' => $stmt->insert_id], JSON_PRETTY_PRINT);
        $stmt->close();
        break;

    default:
        http_response_code(405);
        echo json_encode(['error' => 'Method not allowed'], JSON_PRETTY_PRINT);
        break;
}

// Закрываем соединение с базой данных
$conn->close();
