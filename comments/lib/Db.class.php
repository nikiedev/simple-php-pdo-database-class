<?php


//namespace app\lib;

/**
 * Class Db | Класс для работы с БД
 * @package app\lib
 */
class Db
{
    private $dbh;

    /**
     * Db constructor.
     * Соединение с Базой Данных (настройки -> config.php)
     */
    public function __construct()
    {
        require_once __DIR__ . '/config.php';
        $dsn = 'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=utf8';
        $this->dbh = new \PDO(
            $dsn, DB_USER, DB_PASS, [
                \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
                \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC
            ]
        );
    }

    /**
     * @param string $sql
     * @return bool
     */
    public function execute($sql)
    {
        $sth = $this->dbh->prepare($sql);
        return $sth->execute();
    }

    /**
     * @param string $sql
     * @param array $params
     * @return array
     */
    public function query($sql, $params = [])
    {
        $sth = $this->dbh->prepare($sql);
        $res = $sth->execute($params);
        if (false !== $res) {
            return $sth->fetchAll();
        }
        return [];
    }
}
