<?php
class Follower extends Database
{
    private $pdo;

    public function __construct()
    {
        $this->pdo = $this->getConnection();
    }

    public function listFollowers($user_id)
    {
        try {
            $stm = $this->pdo->prepare("SELECT * FROM Followers WHERE user_id = ?");
            $stm->execute([$user_id]);

            if ($stm->rowCount() > 0) {
                return $stm->fetchAll(PDO::FETCH_ASSOC);
            } else {
                return false;
            }
        } catch (PDOException $err) {
            return false;
        }
    }

    public function listPeopleIFollow($user_id)
    {
        try {
            $stm = $this->pdo->prepare("SELECT * FROM Followers WHERE follower_user_id = ?");
            $stm->execute([$user_id]);

            if ($stm->rowCount() > 0) {
                return $stm->fetchAll(PDO::FETCH_ASSOC);
            } else {
                return false;
            }
        } catch (PDOException $err) {
            return false;
        }
    }

    public function followById($userId, $id)
    {
        try {
            $stm = $this->pdo->prepare("INSERT INTO Followers (user_id, follower_user_id) VALUES (?, ?)");
            $stm->execute([$id, $userId]);

            return $stm->rowCount() > 0;
        } catch (PDOException $err) {
            return false;
        }
    }

    public function unfollowById($userId, $id)
    {
        try {
            $stm = $this->pdo->prepare("DELETE FROM Followers WHERE user_id = ? AND follower_user_id = ?");
            $stm->execute([$id, $userId]);

            return $stm->rowCount() > 0;
        } catch (PDOException $err) {
            return false;
        }
    }
}
