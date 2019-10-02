<?php
class HomeController
{
    public static function index()
    {
        if(isset($_SESSION["user"]))
        {
            $array=[];
            $post1= Flight::db()->find('posts',$array);
            $display1=arsort($post1);
            Flight::render('index.html.twig',['name'=>$_SESSION["user"][0]["pseudo"],'id'=>$_SESSION["user"][0]["id"],'display_post'=>$post1]);
        }
        else
        {
            Flight::redirect("/connection");
        }
    }
}
?>