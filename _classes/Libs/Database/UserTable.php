<?php

namespace Libs\Database;

use PDOException;

class UserTable {
    private $db = null;

    public function __construct (Mysql $mysql) {
        $this->db = $mysql->connect();
    }

    public function insert ($data) {
        try{
            $query = "INSERT INTO users (name, email, phone, address, password, role_id, created_at) VALUES (:name, :email, :phone, :address, :password, :role_id, NOW())";

            $statement = $this->db->prepare($query);
            //$data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
            $statement->execute($data);

            return $this->db->lastInsertId();
        } catch (PDOException $e){
            echo $e->getMessage();
            exit();
        }
    }

    public function getAll() {
            try{
                $statement = $this->db->query("SELECT users.*, roles.name AS role, roles.value FROM users LEFT JOIN roles ON users.role_id = roles.id");
            
                return $statement->fetchAll();
            } catch (PDOException $e) {
                echo $e->getMessage();
                exit();
            }
    }

    public function findByEmailAndPassword ($email, $password) {
        $statement = $this->db->prepare("SELECT users.*, roles.name AS role, roles.value FROM users LEFT JOIN roles ON users.role_id = roles.id WHERE users.email= :email AND users.password= :password");

        $statement->execute([
            ':email' => $email,
            ':password' => $password
        ]);

        $row = $statement->fetch();

        return $row ?? false;
    }

    public function suspend ($id) {
        try{
            $statement = $this->db->prepare("UPDATE users SET suspended=1 WHERE id = :id");

            $statement->execute(['id' => $id]);
            return $statement->rowCount();
        } catch (PDOException $e){
            echo $e->getMessage();
            exit();
        }
    }

    public function unsuspend ($id) {
        try{
            $statement = $this->db->prepare("UPDATE users SET suspended=0 WHERE id = :id");

            $statement->execute(['id' => $id]);
            return $statement->rowCount();
        } catch (PDOException $e){
            echo $e->getMessage();
            exit();
        }
    }

    public function changeRole ($id, $role) {
        try{
            $statement = $this->db->prepare("UPDATE users SET role_id = :role WHERE id = :id");
            $statement->execute(['id' => $id, 'role' => $role]);
            return $statement->rowCount();
        } catch (PDOException $e) {
            echo $e->getMessage();
            exit();
        }
    }

    public function delete($id) {
        try{
            $statement = $this->db->prepare("DELETE FROM users WHERE id = :id");
            $statement->execute(['id' => $id]);
            return $statement->rowCount();
        } catch (PDOException $e) {
            echo $e->getMessage();
            exit();
        }
    }

    public function updatePhoto ($name, $id) {
        try{
            $statement = $this->db->prepare("UPDATE users SET photo = :name WHERE id = :id");

            $statement->execute(['name' => $name, 'id' => $id]);

            return $statement->rowCount();
        } catch (PDOException $e) {
            echo $e->getMessage();
            exit();
        }
    }
}