<?php 

class TaskGateway 
{
    private PDO $conn;

    public function __construct(Database $database)
    {
        $this->conn = $database->getConnection();
    }

    public function getAll(): array
    {
        $query = "SELECT * 
                    FROM `task`
                    WHERE 1 
                    ORDER BY `name`";

        $stmt = $this->conn->query($query);
        $data = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $row["is_completed"] = (bool) $row["is_completed"];
            $data[] = $row;
        }

        return $data;
    }

    public function get($id): array | false
    {
        $query = "SELECT * 
                    FROM `task` 
                    WHERE `id` = :id";

        $stmt = $this->conn->prepare($query);
        $stmt->bindValue(":id", $id, PDO::PARAM_INT);
        $stmt->execute();
        $data = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($data !== false) {
            $data["is_completed"] = (bool) $data["is_completed"];
        }

        return $data;
    }
}

