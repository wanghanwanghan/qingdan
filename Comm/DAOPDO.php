<?php

namespace Comm;

use Traits\Singleton;

class DAOPDO
{
    use Singleton;

    //pdo对象
    private $pdo;

    //该属性保存执行增删改所影响的记录数
    private $affectedRows;

    private function __construct()
    {
        $this->init();
    }

    private function __clone()
    {

    }

    private function init(): bool
    {
        $host = Config::getInstance()->getConf('mysql', 'host');
        $port = Config::getInstance()->getConf('mysql', 'port');
        $dbname = Config::getInstance()->getConf('mysql', 'database');
        $charset = Config::getInstance()->getConf('mysql', 'charset');
        $user = Config::getInstance()->getConf('mysql', 'user');
        $password = Config::getInstance()->getConf('mysql', 'password');

        $str = "mysql:host={$host};port={$port};dbname={$dbname};charset={$charset}";

        $this->pdo = new \PDO($str, $user, $password);

        return true;
    }

    //封装查询sql语句的方法
    function query($sql = '')
    {
        //先判断pdo对象是否初始化
        if (!($this->pdo instanceof \PDO)) {
            return false;
        }

        return $this->pdo->query($sql);
    }

    //封装非查询sql语句的方法(增、删、改)
    function exec($sql = '')
    {
        //先判断pdo对象是否初始化
        if (!($this->pdo instanceof \PDO)) {
            return false;
        }

        $result = $this->pdo->exec($sql);

        $this->affectedRows = $result;

        return $result;
    }

    //封装查询一条记录方法
    function fetchRow($sql = '')
    {
        $pdo_statement = $this->query($sql);

        $result = $pdo_statement->fetch(\PDO::FETCH_ASSOC);

        $pdo_statement->closeCursor();

        return $result;
    }

    //封装查询所有记录方法
    function fetchAll($sql = '')
    {
        $pdo_statement = $this->query($sql);

        $result = $pdo_statement->fetchAll(\PDO::FETCH_ASSOC);

        $pdo_statement->closeCursor();

        return $result;
    }

    //封装查询某条记录的第一个字段的值
    function fetchOne($sql = '')
    {
        $pdo_statement = $this->query($sql);

        $result = $pdo_statement->fetchColumn();

        $pdo_statement->closeCursor();

        return $result;
    }

    //转义、引号包裹数据的方法，防止SQL注入
    function escapeData($data = '')
    {
        return $this->pdo->quote($data);
    }

    //返回受影响的记录数
    function affectedRows()
    {
        return $this->affectedRows;
    }

    //总的记录数
    function resultRows()
    {
        return $this->pdo->columnCount();
    }


}
