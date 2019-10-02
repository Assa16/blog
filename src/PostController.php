<?php
class PostController{

    public static function index()
    {
        Flight::render('index.html.twig',['blog'=>'Bienvenu','pseudo'=>$_SESSION["user"][0]["pseudo"],'id'=>$_SESSION["user"][0]["id"]]);
    }

    public static function create()
    {
        $post_data=Flight::request()->data;
    
        if(isset($post_data['title']) && !empty($post_data['title'])&& ($post_data['content']) && !empty($post_data['content'])&& isset($post_data['user_id']) && !empty($post_data['user_id']))
        {
            $create=Flight::db()->insert('posts',$post_data->getData());
            if(empty($create))
            {
                echo "information incorrect";
            }
            else
            {
                echo "Votre post a été crée en base de donnée";
            }
        }
        else
        {
            echo "renseigner tous les champs";
        }
    }
}
?>