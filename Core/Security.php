<?php

namespace Core;

/*
    User access validation
*/
class Security extends Service
{

    private $userId = null;

    function init() {
        $this->sessionStart();

        if ($_SESSION['uid']  != 0) {
            $this->checkSession();
        }
    }

    function sessionStart() {
        session_start();

        if (!isset($_SESSION['uid']) ) {
            $this->sessionSetDefaultValues();
        }
    }

    function sessionSetDefaultValues() {
        $this->userId = 0;

        $_SESSION['uid'] = 0;
        $_SESSION['username'] = "";
        $_SESSION['referer'] = "";
    }

    function checkSession() {
        $db = $this->container->get('Database');

        $username =$_SESSION['username'];

        $result = $db->query(
            "SELECT
                *
            FROM
                users
            WHERE
                username = :username
            ",
            array(
                ":username"=>$username,
            )
        );

        if (empty($result) ) {
            $this->sessionSetDefaultValues();
            return false;
        }

        $result = $result[0];
        $this->userId = $result['id'];
        return true;
    }

    function hash($password) {
        return base64_encode(password_hash($password, PASSWORD_BCRYPT));
    }

    function checkPassword($password, $dbPassword) {
        $dbPassword =  base64_decode($dbPassword);
        if (password_verify($password, $dbPassword)) {
            return true;
        }

        return false;
    }

    function login($username, $password) {
        $db = $this->container->get('Database');

        $username = $username;

        $result = $db->query(
            "SELECT * FROM users WHERE username = :username",
            array(
                ":username"=>$username,
            )
        );

        if (empty($result) ) {
            $this->sessionSetDefaultValues();
            return false;
        }

        $dbPassword = $result[0]['password'];
        if (!$this->checkPassword($password, $dbPassword)) {
            return false;
        }

        $user = $result[0];
        $this->userId = $user['id'];
        $_SESSION['uid'] = $user['id'];
        $_SESSION['username'] = $user['username'];

        return true;
    }

    function forceLogin($userId, $username) {
        $this->userId = $userId;
        $_SESSION['uid'] = $userId;
        $_SESSION['username'] = $username;
    }

    function logout() {
        $this->userId = null;
        session_start();
        session_destroy();
    }

    function getUser() {
        if (empty($this->user)) {
            return null;
        }

        $db = $this->container->get('Database');
        $result = $db->query(
            "SELECT * FROM users WHERE id = :id",
            array(
                ":id"=>$this->user
            )
        );

        if (empty($result) ) {
            return null;
        }

        $user = $result[0];
        return $user;
    }

    function createUser($username, $password) {
         $db = $this->container->get('Database');
         $result = $db->query(
            "INSERT INTO
                users (username, password)
            VALUES
                (:username,  :password)",
            array(
                ":username"=>$username,
                ":password"=>$this->hash($password),
            ),
            false
        );

         if ($result) {
            return $db->lastId();
         }

         return null;
    }

    function isLogged() {
        if (empty($this->userId)) {
            throw new AccessForbiddenException;
        }
        return true;
    }

    function isUser($userId) {
        if (empty($this->userId) || $this->userId != $userId) {
            throw new AccessForbiddenException;
        }

        return true;
    }

    function getReferer() {
        return $_SERVER['HTTP_REFERER'];
    }

    function setReferer($referer) {
        $_SESSION['referer'] = $referer;
    }

}
