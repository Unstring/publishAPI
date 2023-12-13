<?php

class User extends Database
{

  private $pdo;

  public function __construct()
  {
    $this->pdo = $this->getConnection();
  }

  public function list($id)
  {
    try {
      $stm = $this->pdo->prepare("SELECT `user_id`, `full_name`, `email`, `username`, `avatar` FROM `Users` WHERE `user_id` = ?");
      $stm->execute([$id]);

      if ($stm->rowCount() > 0) {
        return $stm->fetch(PDO::FETCH_ASSOC);
      } else {
        return false;
      }
    } catch (PDOException $err) {
      return false;
    }
  }

  public function dashboard($id)
  {
    try {
      $stm = $this->pdo->prepare("
      SELECT u.id, u.name, u.email, us.question_id, us.language_id, us.user_code, us.submission_time, us.is_correct 
      FROM users u 
      LEFT JOIN user_solutions us ON u.id = us.user_id 
      WHERE u.id = ?
    ");
      $stm->execute([$id]);

      if ($stm->rowCount() > 0) {
        // Fetch all rows returned by the query
        return $stm->fetchAll(PDO::FETCH_ASSOC);
      } else {
        return false;
      }
    } catch (PDOException $err) {
      return false;
    }
  }


  public function resetPassword($email, $otp, $newPassword)
  {
    try {
      // Check if the OTP exists and is not expired
      $currentTime = time();
      $stm = $this->pdo->prepare("SELECT * FROM otp_tokens WHERE email = ? AND otp = ? AND expiration_time >= ?");
      $stm->execute([$email, $otp, $currentTime]);

      if ($stm->rowCount() > 0) {
        // OTP is valid and not expired, proceed with password reset
        $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
        $updateStm = $this->pdo->prepare("UPDATE users SET passwd = ? WHERE email = ?");
        $updateStm->execute([$hashedPassword, $email]);

        if ($updateStm->rowCount() > 0) {
          // Password reset successful
          return true;
        } else {
          return false;
        }
      } else {
        // OTP is invalid or expired, do nothing
        return false;
      }
    } catch (PDOException $err) {
      return false;
    }
  }

  public function storeOTP($email, $otp, $expirationTime)
  {
    try {
      // Check if the email already exists in the database
      $checkStmt = $this->pdo->prepare("SELECT COUNT(*) FROM otp_tokens WHERE email = ?");
      $checkStmt->execute([$email]);
      $rowCount = $checkStmt->fetchColumn();

      if ($rowCount > 0) {
        // If the email exists, update the existing record
        $updateStmt = $this->pdo->prepare("UPDATE otp_tokens SET otp = ?, expiration_time = ? WHERE email = ?");
        $updateStmt->execute([$otp, $expirationTime, $email]);
      } else {
        // If the email does not exist, insert a new row
        $insertStmt = $this->pdo->prepare("INSERT INTO otp_tokens (email, otp, expiration_time) VALUES (?, ?, ?)");
        $insertStmt->execute([$email, $otp, $expirationTime]);
      }

      return true;
    } catch (PDOException $err) {
      return false;
    }
  }



  public function verifyOTP($email, $otp)
  {
    try {
      // Check if the OTP exists and is not expired
      $currentTime = time();
      $stm = $this->pdo->prepare("SELECT * FROM otp_tokens WHERE email = ? AND otp = ? AND expiration_time >= ?");
      $stm->execute([$email, $otp, $currentTime]);

      if ($stm->rowCount() > 0) {
        // OTP is valid and not expired
        return true;
      } else {
        return false;
      }
    } catch (PDOException $err) {
      return false;
    }
  }

  public function create($data)
  {
    // var_dump($data);
    try {
      $stm = $this->pdo->prepare("INSERT INTO `Users`(`full_name`, `email`, `username`, `password_hash`, `signup_at`) VALUES (?, ?, ?, ?, ?)");

      $name = $data[0];
      $email = $data[1];
      $username = $data[2];
      $hashedPassword = password_hash($data[3], PASSWORD_DEFAULT);
      $signuptime = time();
      // var_dump($stm);

      $stm->execute([$name, $email, $username, $hashedPassword, $signuptime]);

      return true;
    } catch (PDOException $err) {
      return false;
    }
  }

  public function saveAvatar($id, $filename)
  {
    try {
      $stmt = $this->pdo->prepare("UPDATE Users SET avatar = ? WHERE user_id = ?");
      $stmt->execute([$filename, $id]);

      return true;
    } catch (PDOException $err) {
      return false;
    }
  }


  public function signIn($data)
  {
    // var_dump($data);
    try {
      $stm = $this->pdo->prepare("SELECT *
      FROM Users
      WHERE email = ? OR username = ?
      ");

      $stm->execute([$data[0], $data[0]]);

      if ($stm->rowCount() > 0) {
        $user = $stm->fetch(PDO::FETCH_ASSOC);

        if (password_verify($data[1], $user['password_hash'])) {
          return $user;
        } else {
          return false;
        }
      } else {
        return false;
      }
    } catch (PDOException $err) {
      return false;
    }
  }

  public function emailOrUsernameAlreadyExists($email, $username)
  {
    try {
      $stm = $this->pdo->prepare("SELECT COUNT(*) FROM Users WHERE email = ? OR username = ?");
      $stm->execute([$email, $username]);
      $count = $stm->fetchColumn();

      return $count > 0; // Returns true if the count is greater than 0, indicating existence
    } catch (PDOException $err) {
      return false;
    }
  }

  public function emailAlreadyExists($email)
  {
    try {
      $stm = $this->pdo->prepare("SELECT * FROM Users WHERE email = ?");
      $stm->execute([$email]);

      if ($stm->rowCount() > 0) {
        return true;
      } else {
        return false;
      }
    } catch (PDOException $err) {
      return false;
    }
  }

  public function usernameAlreadyExists($username)
  {
    try {
      $stm = $this->pdo->prepare("SELECT * FROM Users WHERE username = ?");
      $stm->execute([$username]);

      if ($stm->rowCount() > 0) {
        return true;
      } else {
        return false;
      }
    } catch (PDOException $err) {
      return false;
    }
  }

  public function update($data)
  {
    try {
      $stm = $this->pdo->prepare("UPDATE users SET name = ?, passwd = ? WHERE id = ?");
      $stm->execute([$data[0], password_hash($data[1], PASSWORD_DEFAULT), $data[2]]);

      if ($stm->rowCount() > 0) {
        return true;
      } else {
        return false;
      }
    } catch (PDOException $err) {
      return false;
    }
  }

  public function isAdmin($id)
  {
    try {
      $stm = $this->pdo->prepare("SELECT * FROM users WHERE id = ? AND `admin` = 1");
      $stm->execute([$id]);

      if ($stm->rowCount() > 0) {
        return $stm->fetch(PDO::FETCH_ASSOC);
      } else {
        return false;
      }
    } catch (PDOException $err) {
      return false;
    }
  }


  public function getUserIdByUsername($username)
    {
        try {
            $stm = $this->pdo->prepare("SELECT user_id FROM Users WHERE username = ?");
            $stm->execute([$username]);

            $userId = $stm->fetchColumn();
            return $userId ? $userId : null;
        } catch (PDOException $err) {
            return null;
        }
    }

  // public function storeOTP($email, $otp, $expirationTime)
  // {
  //   try {
  //     $stm = $this->pdo->prepare("INSERT INTO otp_tokens (email, otp, expiration_time) VALUES (?, ?, ?)");
  //     $stm->execute([$email, $otp, $expirationTime]);

  //     return true;
  //   } catch (PDOException $err) {
  //     return false;
  //   }
  // }
}
