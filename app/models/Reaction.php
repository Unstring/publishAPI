<?php
class Reaction extends Database
{
    private $pdo;

    public function __construct()
    {
        $this->pdo = $this->getConnection();
    }

    public function reactPost($user_id, $reaction_type, $post_id)
    {
        // var_dump(["$user_id", $reaction_type, $post_id]);
        try {
            $stm = $this->pdo->prepare("INSERT INTO `Reactions` (`user_id`, `paper_id`, `reaction_type`) VALUES (?, ?, ?)");
            $stm->execute([$user_id, $post_id, $reaction_type]);
            // var_dump($stm);
            return true;
        } catch (PDOException $err) {
            return false;
        }
    }

    public function checkReacted($user_id, $post_id)
    {
        try {
            $stm = $this->pdo->prepare("SELECT * FROM Reactions WHERE user_id = ? and paper_id = ?");
            $stm->execute([$user_id, $post_id]);

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
