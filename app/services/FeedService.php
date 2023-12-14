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


    public function list($id)
    {
        $method = $this->getMethod();

        $result = [];
        $feed_model = new Feed();
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
                        $feedExists = $feed_model->list_for_user($id[0],$userId->user_id);

                        if ($feedExists) {
                            $result['data'] = $feedExists;
                        } else {
                            http_response_code(401);
                            $result['error'] = "Feed dosen't exist";
                        }
                    } else {
                        http_response_code(401);
                        $result['error'] = "Unauthorized, user dosen't exist";
                    }
                } else {
                    http_response_code(401);
                    $result['error'] = "Unauthorized, please, verify your token";
                }
            } else {
                $feedExists = $feed_model->list($id[0]);
                // var_dump($feedExists);
                if ($feedExists) {
                    $result['data'] = $feedExists;
                } else {
                    http_response_code(401);
                    $result['error'] = "Feed dosen't exist";
                }
            }
        } else {
            http_response_code(405);
            $result['error'] = "HTTP Method not allowed";
        }

        echo json_encode($result);
    }

    public function post()
    {
        $method = $this->getMethod();
        $body = $this->parseBodyInput();

        $result = [];

        $user_model = new Feed();
        $feed_model = new Feed();
        $jwt = new JWT();
        $authorization = new Authorization();

        if ($method === 'POST') {

            $token = $authorization->getAuthorization();
            if ($token) {
                $user = $jwt->validateJWT($token);

                if ($user->id) {

                    $userId = $user->id;

                    $userExists = $user_model->list($userId->user_id);

                    if ($userExists) {

                        if (!empty($body['title']) && !empty($body['description']) && !empty($body['media'])) {

                            $title = $body['title'];
                            $description = $body['description'];
                            $media = $body['media'];

                            $create_user = $feed_model->makepost([$title, $description, $media, $userId->user_id]);
                            if ($create_user) {
                                http_response_code(200);
                                $result = [
                                    "message" => "Created",
                                    "login" => BASE_URL . "users/login"
                                ];
                            } else {
                                http_response_code(406);
                                $result['error'] = "Sorry, something went wrong, try again";
                            }
                        } else {
                            http_response_code(406);
                            $result['error'] = "Input fields are empty";
                        }
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
