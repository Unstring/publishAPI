<?php
class HomeService extends Requests
{
  public function index()
  {
    $method = $this->getMethod();
    $result = [];

    if ($method == 'GET') {
      http_response_code(200);
      $result = [
        "message" => "hello, There welcome!",
        "guide" => "https://apiforcode.dailywith.me/",
        "author" => "Amit Anand"
      ];
    } else {
      http_response_code(405);
      $result['error'] = "HTTP Method not allowed";
    }

    echo json_encode($result, JSON_UNESCAPED_SLASHES);
  }
}