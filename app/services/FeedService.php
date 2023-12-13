<?php

class FeedService extends Requests
{

    public function index($id)
    {
        $method = $this->getMethod();

        $result = [];
        $feed_model = new Feed();

        if ($method == 'GET') {

            $feedExists = $feed_model->list($id[0]);

            // var_dump($feedExists);
            if ($feedExists) {
                $result['data'] = $feedExists;
            } else {
                http_response_code(401);
                $result['error'] = "Feed dosen't exist";
            }
        } else {
            http_response_code(405);
            $result['error'] = "HTTP Method not allowed";
        }

        echo json_encode($result);
    }


    public function list()
    {
        $method = $this->getMethod();

        $result = [];

        $user_model = new User();
        $jwt = new JWT();
        $authorization = new Authorization();

        if ($method == 'GET') {

            $token = $authorization->getAuthorization();
            if ($token) {
                $user = $jwt->validateJWT($token);

                if ($user->id) {

                    $userId = $user->id;

                    $userExists = $user_model->list($userId->user_id);

                    if ($userExists) {
                        $result['data'] = $userExists;
                    } else {
                        http_response_code(401);
                        $result['error'] = "Unauthorized, user dosen't exist";
                    }
                } else {
                    http_response_code(401);
                    $result['error'] = "Unauthorized, please, verify your token";
                }
            } else {
                http_response_code(401);
                $result['error'] = "Unauthorized, can't find token!";
            }
        } else {
            http_response_code(405);
            $result['error'] = "HTTP Method not allowed";
        }

        echo json_encode($result);
    }
}
