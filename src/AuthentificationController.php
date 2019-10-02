<?php
require_once('databases/ORM.php');
class AuthentificationController
{
    public static function register_index()
    {
        if(isset($_SESSION["user"]))
        {
            Flight::redirect("/");
        }
        Flight::render('register.html.twig',["title"=>"S'inscrire"]);
    }

    public static function register()
    {
        $data=Flight::request()->data;
       
        if(isset($data['email']) && !empty($data['email']) && isset($data['password']) && !empty($data['password'])&& isset($data['pseudo']) && !empty($data['pseudo']))
        { 
            $hash=password_hash($data['password'],PASSWORD_DEFAULT);
            
                $array_hash1=["email"=>$data['email'],"password"=>$hash,"pseudo"=>$data['pseudo']];
                $register=Flight::db()->insert('users',$array_hash1);
            
            if(empty($register))
            {
                echo" Une erreur s’est produite";
            }
            else
            {
                echo "connect-toi";
                Flight::redirect("/connection");
            }
        }
        else
        {
            echo "veuillez renseigner tous les champs";
        }
    }

    public static function login_index()
    {
        if(isset($_SESSION["user"]))
        {
            Flight::redirect("/");
        }
        else
        {
            Flight::render('login.html.twig',["title"=>"LOGIN"]);
        }
    }

    public static function login()
    {
        $login_data=Flight::request()->data;

        if(isset($login_data['password']) && !empty($login_data['password'])&& isset($login_data['pseudo']) && !empty($login_data['pseudo']))
        {
            $pseudo=["pseudo"=>$login_data['pseudo']];
            $login= Flight::db()->find('users',$pseudo);
        
            if(isset($login)&& !empty($login))
            {
                echo "l'utilisateur existe".PHP_EOL;
                $verify = password_verify($login_data['password'],$login[0]['password']);
                if($verify==true)
                {
                    $_SESSION["user"]=$login;
                    Flight::redirect("/");
                }
                else
                {
                    Flight::redirect("/connection");
                }
            }
            else
            {
                echo "Erreur l'utilisateur n'existe pas";
            }
        }
    }

    public static function logout()
    {
        session_destroy();
        Flight::redirect("/connection"); 
    }
}
?>