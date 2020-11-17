<?php


namespace App\Model;


use Cassandra\Date;

class ProductManager extends AbstractManager
{

    const TABLE = 'product';

    public function __construct()
    {
        parent::__construct(self::TABLE);
    }

    public function selectAllCategories(): array
    {
        return $this->pdo->query('SELECT * FROM ' . $this->table)->fetchAll();
    }

    public function all()
    {
        return $this->pdo->query('SELECT p.name, c.name AS category FROM product p JOIN category c ON p.category_id=c.id')->fetchAll();

    }

    public function insert(array $item)
    {
        // prepared request
        $statement = $this->pdo->prepare("INSERT INTO " . self::TABLE . " (name, category_id, is_checked, created_at) VALUES (:name, :category, :is_checked, NOW())");
        $statement->bindValue(':name', $item['name'], \PDO::PARAM_STR);
        $statement->bindValue(':category', $item['category'], \PDO::PARAM_INT);
        $statement->bindValue(':is_checked', false, \PDO::PARAM_BOOL);
        $statement->execute();
    }

}