<?php

class ConnectionService extends Requests
{
  public function listConnectionRequests()
  {
    $result = [];
    $authorization = new Authorization();
    $jwt = new JWT();

    $token = $authorization->getAuthorization();
    if ($token) {
      $user = $jwt->validateJWT($token);
      if ($user) {
        $userId = $user->id;

        $connection = new Connection();
        $requests = $connection->listConnectionRequests($userId);

        if ($requests !== false) {
          $result['data'] = $requests;
        } else {
          $result['error'] = "No connection requests found.";
        }
      } else {
        $result['error'] = "Unauthorized, please verify your token.";
      }
    } else {
      $result['error'] = "Unauthorized, can't find token!";
    }

    echo json_encode($result);
  }

  public function listMyConnections()
  {
    $result = [];
    $authorization = new Authorization();
    $jwt = new JWT();

    $token = $authorization->getAuthorization();
    if ($token) {
      $user = $jwt->validateJWT($token);
      if ($user) {
        $userId = $user->id;

        $connection = new Connection();
        $connections = $connection->listMyConnections($userId);

        if ($connections !== false) {
          $result['data'] = $connections;
        } else {
          $result['error'] = "No connections found.";
        }
      } else {
        $result['error'] = "Unauthorized, please verify your token.";
      }
    } else {
      $result['error'] = "Unauthorized, can't find token!";
    }

    echo json_encode($result);
  }

  public function listRejectedRequests()
  {
    $result = [];
    $authorization = new Authorization();
    $jwt = new JWT();

    $token = $authorization->getAuthorization();
    if ($token) {
      $user = $jwt->validateJWT($token);
      if ($user) {
        $userId = $user->id;

        $connection = new Connection();
        $rejected = $connection->listRejectedRequests($userId);

        if ($rejected !== false) {
          $result['data'] = $rejected;
        } else {
          $result['error'] = "No rejected requests found.";
        }
      } else {
        $result['error'] = "Unauthorized, please verify your token.";
      }
    } else {
      $result['error'] = "Unauthorized, can't find token!";
    }

    echo json_encode($result);
  }


  public function sendConnection($id)
  {
    $result = [];
    $authorization = new Authorization();
    $jwt = new JWT();

    $token = $authorization->getAuthorization();
    if ($token) {
      $user = $jwt->validateJWT($token);
      if ($user) {
        $userId = $user->id;

        $connection = new Connection();
        $isSent = $connection->sendConnection($userId, $id);

        if ($isSent) {
          $result['message'] = "Connection request sent to user with ID $id.";
        } else {
          $result['error'] = "Failed to send connection request to user with ID $id.";
        }
      } else {
        $result['error'] = "Unauthorized, please verify your token.";
      }
    } else {
      $result['error'] = "Unauthorized, can't find token!";
    }

    echo json_encode($result);
  }

  public function removeConnection($id)
  {
    $result = [];
    $authorization = new Authorization();
    $jwt = new JWT();

    $token = $authorization->getAuthorization();
    if ($token) {
      $user = $jwt->validateJWT($token);
      if ($user) {
        $connection = new Connection();
        $isRemoved = $connection->removeConnection($id);

        if ($isRemoved) {
          $result['message'] = "Connection removed for connection ID $id.";
        } else {
          $result['error'] = "Failed to remove connection for connection ID $id.";
        }
      } else {
        $result['error'] = "Unauthorized, please verify your token.";
      }
    } else {
      $result['error'] = "Unauthorized, can't find token!";
    }

    echo json_encode($result);
  }

  public function rejectConnection($id)
  {
    $result = [];
    $authorization = new Authorization();
    $jwt = new JWT();

    $token = $authorization->getAuthorization();
    if ($token) {
      $user = $jwt->validateJWT($token);
      if ($user) {
        $connection = new Connection();
        $isRejected = $connection->rejectConnection($id);

        if ($isRejected) {
          $result['message'] = "Connection request rejected for connection ID $id.";
        } else {
          $result['error'] = "Failed to reject connection request for connection ID $id.";
        }
      } else {
        $result['error'] = "Unauthorized, please verify your token.";
      }
    } else {
      $result['error'] = "Unauthorized, can't find token!";
    }

    echo json_encode($result);
  }

  public function acceptConnection($id)
  {
    $result = [];
    $authorization = new Authorization();
    $jwt = new JWT();

    $token = $authorization->getAuthorization();
    if ($token) {
      $user = $jwt->validateJWT($token);
      if ($user) {
        $connection = new Connection();
        $isAccepted = $connection->acceptConnection($id);

        if ($isAccepted) {
          $result['message'] = "Connection request accepted for connection ID $id.";
        } else {
          $result['error'] = "Failed to accept connection request for connection ID $id.";
        }
      } else {
        $result['error'] = "Unauthorized, please verify your token.";
      }
    } else {
      $result['error'] = "Unauthorized, can't find token!";
    }

    echo json_encode($result);
  }
}
