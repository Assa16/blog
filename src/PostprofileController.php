<?php
class PostprofileController
{
    public static function show($id)
    {
        $post_id=["id"=>$id];
        $array_post=Flight::db()->find("posts",$post_id);
        if(isset($_SESSION["user"]))
        {
            Flight::render("post.html.twig",["POSTS"=>$array_post]);
        }
        else{
            Flight::redirect("/connection");
        } 
    }
}
?>