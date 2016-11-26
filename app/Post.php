<?php // File: app/Post.php

namespace App;

use Corcel\Post as Corcel;

class Post extends Corcel
{
    protected $connection = 'wordpress';
}