<?php 

Class Usuario {
    public static function login($username, $senha) {
        global $pdo;

        $sql = "SELECT * FROM usuarios WHERE username = :username AND senha = :senha";
        $sql = $pdo -> prepare($sql);
        $sql -> bindValue("username", $username);
        $sql -> bindValue("senha", md5($senha));
        $sql -> execute();

        if($sql -> rowCount() > 0) {
            $dado = $sql -> fetch();
            
            $_SESSION['userL'] = $dado['username'];
            $_SESSION['userId'] = $dado['id_user'];
            return true;
        } else {
            return false;
        }
    }
    
    public static function isLogged() {
        return isset($_SESSION['userL']);
    }

    public static function userId() {
        return $_SESSION['userId'];
    }
}

?>