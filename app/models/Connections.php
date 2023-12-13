<?php
class Connection extends Database
{
    private $pdo;

    public function __construct()
    {
        $this->pdo = $this->getConnection();
    }

    public function listConnectionRequests($user_id)
    {
        try {
            $stm = $this->pdo->prepare("SELECT * FROM Connections WHERE user_id = ? AND status = 'requested'");
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

    public function listMyConnections($user_id)
    {
        try {
            $stm = $this->pdo->prepare("SELECT * FROM Connections WHERE user_id = ? AND status = 'accepted'");
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

    public function listRejectedRequests($user_id)
    {
        try {
            $stm = $this->pdo->prepare("SELECT * FROM Connections WHERE user_id = ? AND status = 'rejected'");
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


    public function sendConnection($userId, $connectedUserId)
    {
        try {
            $stm = $this->pdo->prepare("INSERT INTO Connections (user_id, connected_user_id, status, requested_at) VALUES (?, ?, 'requested', NOW())");
            $stm->execute([$userId, $connectedUserId]);

            return $stm->rowCount() > 0;
        } catch (PDOException $err) {
            return false;
        }
    }

    public function removeConnection($id)
    {
        try {
            $stm = $this->pdo->prepare("DELETE FROM Connections WHERE connection_id = ?");
            $stm->execute([$id]);

            return $stm->rowCount() > 0;
        } catch (PDOException $err) {
            return false;
        }
    }

    public function rejectConnection($id)
    {
        try {
            $stm = $this->pdo->prepare("UPDATE Connections SET status = 'rejected' WHERE connection_id = ?");
            $stm->execute([$id]);

            return $stm->rowCount() > 0;
        } catch (PDOException $err) {
            return false;
        }
    }

    public function acceptConnection($id)
    {
        try {
            $stm = $this->pdo->prepare("UPDATE Connections SET status = 'accepted', accepted_at = NOW() WHERE connection_id = ?");
            $stm->execute([$id]);

            return $stm->rowCount() > 0;
        } catch (PDOException $err) {
            return false;
        }
    }
}
