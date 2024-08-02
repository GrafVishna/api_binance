<?php
// Дозволяє запити з будь-якого походження
header("Access-Control-Allow-Origin: *");
// Встановлює тип контенту як JSON
header("Content-Type: application/json");
// Дозволяє методи GET, POST та OPTIONS
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
// Дозволяє заголовки Content-Type і Authorization
header("Access-Control-Allow-Headers: Content-Type, Authorization");

// Перевіряє наявність параметра 'symbol' у запиті
if (isset($_GET['symbol'])) {
   // Санітизує параметр 'symbol' для запобігання XSS-атакам
   $symbol = htmlspecialchars($_GET['symbol'], ENT_QUOTES, 'UTF-8');

   // Формує URL для запиту до API Binance
   $url = "https://api.binance.com/api/v3/ticker/price?symbol={$symbol}";

   // Ініціалізує сеанс cURL
   $ch = curl_init($url);
   curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

   // Виконує запит
   $response = curl_exec($ch);
   // Закриває сеанс cURL
   curl_close($ch);

   // Декодує JSON-відповідь у масив
   $data = json_decode($response, true);

   // Перевіряє, чи містить відповідь поле 'price'
   if (isset($data['price'])) {
      // Відправляє курс обміну у форматі JSON
      echo json_encode(["price" => $data['price']]);
   } else {
      // Відправляє повідомлення про помилку у форматі JSON
      echo json_encode(["error" => "Не вдалося отримати курс обміну валют"]);
   }
} else {
   // Відправляє повідомлення про помилку у форматі JSON, якщо параметр 'symbol' відсутній
   echo json_encode(["error" => "Відсутні параметри"]);
}
