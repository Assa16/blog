<?php
class ProfileController
{
    public static function display()
    {
       if(isset($_SESSION["user"]))
        { 
            $_SESSION["user"];
            Flight::render('profile.html.twig',["nom"=>$_SESSION["user"][0]["pseudo"],"email"=>$_SESSION["user"][0]["email"],'id'=>$_SESSION["user"][0]["id"]]);
        }
        else
        {
            Flight::redirect("/connection");
        }
    }
    public static function update_index()
    {
        if(isset($_SESSION["user"]))
        {
            Flight::render("update.html.twig",[]);
        }
        else
        {
            Flight::redirect("/connection");
        }
    }
    public static function update()
    {
        $update_data=Flight::request()->data;
        if(isset($update_data['email']) && !empty($update_data['email']) && isset($update_data['pseudo']) && !empty($update_data['pseudo']))
        {  
            //$tab matches my where in a sql update request
            $tab=["id"=>$_SESSION["user"][0]["id"]];
            if(isset($_SESSION["user"]))
            {
                $new_array=["email"=>$update_data['email'],"pseudo"=>$update_data['pseudo']];
                $modify=Flight::db()->update('users',$tab,$new_array);
                echo "modification effectuée";
            }
        }
    }
}
?>