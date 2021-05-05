<?php

/**
 * Class Actions
 *
 * Action names only.
 */
class Actions {
    public static string $createPost = "createPost";
    public static string $createComment = "createComment";


    public static string $deletePost = "deletePost";
    public static string $deleteComment = "deleteComment";

    public static string $readPost = 'readPost';
    public static string $like = 'like';
    public static string $dislike = 'dislike';
    public static string $register = 'register';
    public static string $login = 'login';

    /// actions for like deduction. This is for deducting point for voters when they vote.
    public static string $likeDeduction = 'likeDeduction';
    public static string $dislikeDeduction = 'dislikeDeduction';

}

