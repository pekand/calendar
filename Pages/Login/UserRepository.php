<?php

namespace Pages\Login;

use Core\Service;

/*
    User sql repository
*/
class UserRepository extends Service
{
    function getUserById($id) {
        if (empty($id)) {
            return null;
        }

        $db = $this->container->get('Database');
        $result = $db->query(
            "SELECT * FROM users WHERE id = :id",
            array(
                ":id"=>$id
            )
        );

        if (empty($result) ) {
            return null;
        }

        $user = $result[0];

        return $user;
    }

    function getUserByUsername($username) {
        if (empty($username)) {
            return null;
        }

        $db = $this->container->get('Database');
        $result = $db->query(
            "SELECT * FROM users WHERE username = :username",
            array(
                ":username"=>$username
            )
        );

        if (empty($result) ) {
            return null;
        }

        $user = $result[0];
        return $user;
    }
}
