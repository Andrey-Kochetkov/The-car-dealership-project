<?php


class database
{
    private $db;

    function __construct()
    {
        $this->db = new SQLite3("database.db");
        $this->create();
    }

    private function create()
    {
        $this->db->exec('CREATE TABLE IF NOT EXISTS users (
	id integer PRIMARY KEY AUTOINCREMENT,
	login text unique,
	password text,
	role text default "user"
);

CREATE TABLE IF NOT EXISTS cars (
	id integer PRIMARY KEY AUTOINCREMENT,
	model text,
	price integer,
	mileage integer,
	image text,
	brand text
);
');
    }

    public function getUser($username){
        $username = $this->db->escapeString($username);
        $result = $this->db->query("SELECT * FROM users WHERE login='{$username}';");
        if (!empty($result))
            return $result->fetchArray(SQLITE3_ASSOC);
        return null;
    }

    private function isUserExists($username){
        return !empty($this->db->query("SELECT 1 FROM users WHERE login='{$username}';")->fetchArray(SQLITE3_ASSOC));
    }

    public function getCars(){
        $result = array();
        $pre_res = $this->db->query("SELECT * FROM cars;");
        while ($tmp = $pre_res->fetchArray(SQLITE3_ASSOC)) {
            array_push($result, $tmp);
        }

        return $result;
    }

    public function Auth($username, $password){
        $user = $this->getUser($username);
        if (is_null($user))
            return false;
        return password_verify($password, $user['password']);
    }

    public function addUser($username, $password)
    {
        if ($this->isUserExists($username))
            return 'User exists';

        $username = $this->db->escapeString($username);
        $password = password_hash($password, PASSWORD_BCRYPT);

        $this->db->exec("INSERT INTO users (login, password) VALUES ('{$username}', '{$password}');");

        return 'OK';
    }

    public function removeCar($id){
        $id = $this->db->escapeString($id);
        $this->db->exec("DELETE FROM cars WHERE id={$id};");
    }

    public function addCar($brand, $model, $mileage, $price, $image)
    {
        $brand = $this->db->escapeString($brand);
        $model = $this->db->escapeString($model);
        $mileage = $this->db->escapeString($mileage);
        $price = $this->db->escapeString($price);

        $this->db->exec("INSERT INTO cars (brand, model, mileage, price, image) VALUES ('{$brand}', '${model}', ${mileage}, ${price}, '${image}');");

    }


}