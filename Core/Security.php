<?php

namespace Core;

/*
    User access validation
*/
class Security extends Service
{

    private $userId = null;
    private $user = null;

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
        $this->userId = null;
        $this->user = null;
        $_SESSION['uid'] = null;
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

    function checkCredentials($username, $password) {
        $db = $this->container->get('Database');

        $result = $db->query(
            "SELECT * FROM users WHERE username = :username",
            array(
                ":username"=>$username,
            )
        );

        if (empty($result) ) {
            return false;
        }

        $dbPassword = $result[0]['password'];
        if (!$this->checkPassword($password, $dbPassword)) {
            return false;
        }

        $user = $result[0];
        return $user;
    }

    function login($username, $password) {
        $user = $this->checkCredentials($username, $password);
        if ($user !== false) {
            $this->forceLogin($user['id'], $username);
        }

        return $user;
    }

    function forceLogin($userId, $username) {
        $this->userId = $userId;
        $this->user = null;
        $this->user = $this->getUser();
        $_SESSION['uid'] = $userId;
        $_SESSION['username'] = $username;
    }

    function logout() {
        $this->userId = null;
        $this->user = null;
        session_start();
        session_destroy();
    }

    function getUser() {
        if (empty($this->userId)) {
            return null;
        }

        if (!empty($this->user)) {
            return $this->user;
        }

        $db = $this->container->get('Database');
        $result = $db->query(
            "SELECT * FROM users WHERE id = :id",
            array(
                ":id"=>$this->userId
            )
        );

        if (empty($result) ) {
            return null;
        }

        $user = $result[0];
        $this->user = $user;
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

    function isOwner($userId) {
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
