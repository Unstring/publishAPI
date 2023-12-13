<?php

use PHPMailer\PHPMailer\PHPMailer;

class UserService extends Requests
{
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

  public function dashboard()
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

        if ($user) {

          $userId = $user->id;

          $userExists = $user_model->dashboard($userId->id);

          if ($userExists) {
            $result['data'] = $userExists;
          } else {
            http_response_code(401);
            $result['error'] = "Unauthorized, user dosent exist";
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

  public function create()
  {
    $method = $this->getMethod();
    $body = $this->parseBodyInput();
    $user_model = new User();
    $result = [];

    if ($method === 'POST') {
      if (!empty($body['full_name']) && !empty($body['email']) && !empty($body['username']) && !empty($body['password'])) {

        $name = $body['full_name'];
        $email = $body['email'];
        $username = $body['username'];
        $password = $body['password'];

        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {

          if (!$user_model->emailAlreadyExists($email)) {

            if (!$user_model->usernameAlreadyExists($username)) {
              // var_dump([$name, $email, $username, $password]);
              $create_user = $user_model->create([$name, $email, $username, $password]);
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
              $result['error'] = "Usernmae already exists";
            }
          } else {
            http_response_code(406);
            $result['error'] = "Email already exists";
          }
        } else {
          http_response_code(406);
          $result['error'] = "Please, enter a valid email";
        }
      } else {
        http_response_code(406);
        $result['error'] = "Name or Email or Password field is empty";
      }
    } else {
      http_response_code(405);
      $result['error'] = "HTTP Method not allowed";
    }

    echo json_encode($result, JSON_UNESCAPED_SLASHES);
  }

  public function login()
  {
    $method = $this->getMethod();
    $body = $this->parseBodyInput();

    $result = [];

    $user_model = new User();
    $jwt = new JWT();

    if ($method == 'POST') {

      if (!empty($body['emailOrUsername']) && !empty($body['password'])) {
        $emailOrUsername = $body['emailOrUsername'];
        $password = $body['password'];

        $user = $user_model->signIn([$emailOrUsername, $password]);

        if ($user) {

          $sanitizedUser = [
            "full_name" => $user['full_name'],
            "username" => $user['username'],
            "avatar" => $user['avatar'],
            "email" => $user['email']
          ];

          $result = [
            "message" => "successfully",
            "token" => $jwt->generateJWT(["id" => $user]),
            "user" => $sanitizedUser
          ];
        } else {
          http_response_code(401);
          $result['error'] = "Unauthorized, email or password dosen't match";
        }
      } else {
        http_response_code(406);
        $result['error'] = "Email or Password field is empty";
      }
    } else {
      http_response_code(405);
      $result['error'] = "HTTP Method not allowed";
    }

    echo json_encode($result);
  }

  public function forgotpassword()
  {
    $method = $this->getMethod();
    $body = $this->parseBodyInput();

    $result = [];

    $user_model = new User();
    $jwt = new JWT();

    if ($method == 'POST') {

      if (!empty($body['email']) && !empty($body['otp'])) {
        $email = $body['email'];
        $otp = $body['otp'];

        $otpVerification = $user_model->verifyOTP($email, $otp);

        if ($otpVerification) {

          $result['message'] = "OTP verified. You can now reset your password.";
        } else {
          http_response_code(401);
          $result['error'] = "Invalid OTP or OTP expired";
        }
      } else {
        http_response_code(406);
        $result['error'] = "Email or OTP field is empty";
      }
    } else {
      http_response_code(405);
      $result['error'] = "HTTP Method not allowed";
    }

    echo json_encode($result);
  }

  public function changepassword()
  {
    $method = $this->getMethod();
    $body = $this->parseBodyInput();


    $result = [];

    $user_model = new User();
    $jwt = new JWT();

    if ($method == 'POST') {

      if (!empty($body['email']) && !empty($body['password']) && !empty($body['otp'])) {
        $email = $body['email'];
        $password = $body['password'];
        $otp = $body['otp'];

        // var_dump($email);
        // var_dump($password);
        // var_dump($otp);
        $passwordReset = $user_model->resetPassword($email, $otp, $password);

        if ($passwordReset) {

          $result['message'] = "Password reset successfully.";
        } else {
          http_response_code(401);
          $result['error'] = "Password reset failed.";
        }
      } else {
        http_response_code(406);
        $result['error'] = "Email or Password or otp field is empty";
      }
    } else {
      http_response_code(405);
      $result['error'] = "HTTP Method not allowed";
    }

    echo json_encode($result);
  }

  public function getotp()
  {
    $method = $this->getMethod();
    $body = $this->parseBodyInput();

    $result = [];

    $user_model = new User();

    if ($method == 'POST') {

      if (!empty($body['email'])) {
        $email = $body['email'];

        if ($user_model->emailAlreadyExists($email)) {
          $otp = rand(1000, 9999);

          $expirationTime = time() + 300;
          $stored = $user_model->storeOTP($email, $otp, $expirationTime);

          if ($stored) {

            $mail = new PHPMailer(true);
            try {
              $mail->isSMTP();
              $mail->Host = 'smtp.hostinger.com';
              $mail->SMTPAuth = true;
              $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
              $mail->Port = 465;

              $mail->Username = 'verify@code.dailywith.me';
              $mail->Password = 'Google$$321';

              $mail->setFrom('verify@code.dailywith.me', 'Amit');
              $mail->addAddress($email);

              $emailTemplate = file_get_contents("./emailTemplate/changePasswordOtp.html");
              // var_dump($emailTemplate);
              $mail->isHTML(true);
              $mail->Subject = 'Your OTP Code';
              $mail->Body = str_replace('{{otp}}', $otp, $emailTemplate);
              // $mail->Body = 'Your OTP code is: ' . $otp;

              $mail->send();

              $result['message'] = 'OTP sent to your email';
            } catch (\Throwable $th) {
              http_response_code(500);
              $result['error'] = 'Failed to send OTP email';
            }
          } else {
            http_response_code(500);
            $result['error'] = 'Failed to generate OTP';
          }
        } else {
          http_response_code(406);
          $result['error'] = 'Email is not registered';
        }
      } else {
        http_response_code(406);
        $result['error'] = 'Email field is empty';
      }
    } else {
      http_response_code(405);
      $result['error'] = 'HTTP Method not allowed';
    }

    echo json_encode($result);
  }

  public function update()
  {
    $method = $this->getMethod();
    $body = $this->parseBodyInput();

    $result = [];

    $user_model = new User();
    $jwt = new JWT();
    $authorization = new Authorization();

    if ($method == 'PUT') {

      $token = $authorization->getAuthorization();

      if ($token) {
        $user = $jwt->validateJWT($token);

        if ($user) {

          $user_id = $user->id;

          if (!empty($body['name']) && !empty($body['password'])) {
            $name = $body['name'];
            $password = $body['password'];

            $update_user = $user_model->update([$name, $password, $user_id]);

            if ($update_user) {
              $result['message'] = "User updated";
            } else {
              http_response_code(401);
              $result['error'] = "Sorry, something went wrong, verify your credentials or fields";
            }
          } else {
            http_response_code(406);
            $result['error'] = "Name or Password field is empty";
          }
        } else {
          http_response_code(401);
          $result['error'] = "Unauthorized, please, verify your token";
        }
      } else {
        http_response_code(401);
        $result['error'] = "Unauthorized, please, verify your token";
      }
    } else {
      http_response_code(405);
      $result['error'] = "HTTP Method not allowed";
    }

    echo json_encode($result);
  }

  public function uploadAvatar()
  {
    $method = $this->getMethod();
    $result = [];

    $user_model = new User();
    $jwt = new JWT();
    $authorization = new Authorization();

    if ($method === 'POST') {
      $token = $authorization->getAuthorization();

      if ($token) {
        $user = $jwt->validateJWT($token);

        if ($user) {
          $userId = $user->id->user_id;
          if (!empty($_FILES['avatar']['name'])) {
            $targetDir = "avatar/";
            $uploadFile = $_FILES['avatar'];

            $fileExtension = strtolower(pathinfo($uploadFile['name'], PATHINFO_EXTENSION));
            $newFileName = bin2hex(random_bytes(10)) . '_' . time() . ".$fileExtension";
            $targetFile = $targetDir . $newFileName;
            $uploadOk = 1;

            if ($uploadOk === 0) {
              $result['error'] = "Avatar file was not uploaded.";
            } else {
              if (move_uploaded_file($uploadFile['tmp_name'], $targetFile)) {
                $avatarSaved = $user_model->saveAvatar($userId, $newFileName);

                if ($avatarSaved) {
                  $result['message'] = "Avatar uploaded successfully.";
                  $result['newFileName'] = $newFileName;
                } else {
                  $result['error'] = "Failed to update avatar.";
                }
              } else {
                $result['error'] = "There was an error uploading your avatar.";
              }
            }
          } else {
            $result['error'] = "No avatar selected.";
          }
        } else {
          http_response_code(401);
          $result['error'] = "Unauthorized, please verify your token";
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
