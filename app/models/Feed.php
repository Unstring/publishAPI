<?php

class Feed extends Database
{

    private $pdo;

    public function __construct()
    {
        $this->pdo = $this->getConnection();
    }

    // SELECT `paper_id`, `title`, `content`, `media_url`, `abstract`, `author_id`, `publication_date` FROM `Papers` LIMIT $id 
    public function list($id)
    {
        try {
            $stm = $this->pdo->prepare("
            SELECT 
                p.paper_id, 
                p.title, 
                p.content, 
                p.media_url, 
                p.abstract, 
                p.author_id, 
                p.publication_date,
                COALESCE(reactions.like, 0) AS `like`,
                COALESCE(reactions.dislike, 0) AS `dislike`,
                COALESCE(reactions.celebrate, 0) AS `celebrate`,
                COALESCE(reactions.insightfull, 0) AS `insightfull`,
                COALESCE(reactions.support, 0) AS `support`
            FROM 
                Papers p
            LEFT JOIN 
                (
                    SELECT 
                        paper_id,
                        SUM(reaction_type = 1) AS `like`,
                        SUM(reaction_type = 2) AS `dislike`,
                        SUM(reaction_type = 3) AS `celebrate`,
                        SUM(reaction_type = 4) AS `insightfull`,
                        SUM(reaction_type = 5) AS `support`
                    FROM 
                        Reactions
                    GROUP BY 
                        paper_id
                ) reactions ON p.paper_id = reactions.paper_id
                ORDER BY 
                p.paper_id DESC
            LIMIT $id
            ");
            $stm->execute();
            // var_dump($stm);
            if ($stm->rowCount() > 0) {
                return $stm->fetchAll(PDO::FETCH_ASSOC);
            } else {
                return false;
            }
        } catch (PDOException $err) {
            return false;
        }
    }

    public function makepost($data){
        try {
            $stm = $this->pdo->prepare("INSERT INTO `Papers`(`title`, `content`, `media_url`, `author_id`, `publication_date`) VALUES (?, ?, ?, ?, ?)");
      
            $title = $data[0];
            $description = $data[1];
            $mediaUrl = $data[2];
            $userId = $data[3];
            $time = time();

            $stm->execute([$title, $description, $mediaUrl, $userId, $time]);
      
            return true;
          } catch (PDOException $err) {
            return false;
          }
    }
}
