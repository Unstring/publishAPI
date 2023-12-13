<?php

class FollowerService extends Requests
{
  public function listFollowers()
  {
    $result = [];
    $authorization = new Authorization();
    $jwt = new JWT();

    $token = $authorization->getAuthorization();
    if ($token) {
      $user = $jwt->validateJWT($token);
      if ($user) {
        $userId = $user->id;

        $follower = new Follower();
        $followers = $follower->listFollowers($userId);

        if ($followers !== false) {
          $result['data'] = $followers;
        } else {
          $result['error'] = "No followers found.";
        }
      } else {
        $result['error'] = "Unauthorized, please verify your token.";
      }
    } else {
      $result['error'] = "Unauthorized, can't find token!";
    }

    echo json_encode($result);
  }

  public function listPeopleIFollow()
  {
    $result = [];
    $authorization = new Authorization();
    $jwt = new JWT();

    $token = $authorization->getAuthorization();
    if ($token) {
      $user = $jwt->validateJWT($token);
      if ($user) {
        $userId = $user->id;

        $follower = new Follower();
        $following = $follower->listPeopleIFollow($userId);

        if ($following !== false) {
          $result['data'] = $following;
        } else {
          $result['error'] = "Not following anyone.";
        }
      } else {
        $result['error'] = "Unauthorized, please verify your token.";
      }
    } else {
      $result['error'] = "Unauthorized, can't find token!";
    }

    echo json_encode($result);
  }

  public function followById($id)
  {
    $result = [];
    $authorization = new Authorization();
    $jwt = new JWT();

    $token = $authorization->getAuthorization();
    if ($token) {
      $user = $jwt->validateJWT($token);
      if ($user) {
        $userId = $user->id;

        $follower = new Follower();
        $isFollowing = $follower->followById($userId, $id);

        if ($isFollowing) {
          $result['message'] = "Successfully followed user with ID $id.";
        } else {
          $result['error'] = "Failed to follow user with ID $id.";
        }
      } else {
        $result['error'] = "Unauthorized, please verify your token.";
      }
    } else {
      $result['error'] = "Unauthorized, can't find token!";
    }

    echo json_encode($result);
  }

  public function unfollowById($id)
  {
    $result = [];
    $authorization = new Authorization();
    $jwt = new JWT();

    $token = $authorization->getAuthorization();
    if ($token) {
      $user = $jwt->validateJWT($token);
      if ($user) {
        $userId = $user->id;

        $follower = new Follower();
        $isUnfollowed = $follower->unfollowById($userId, $id);

        if ($isUnfollowed) {
          $result['message'] = "Successfully unfollowed user with ID $id.";
        } else {
          $result['error'] = "Failed to unfollow user with ID $id.";
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
