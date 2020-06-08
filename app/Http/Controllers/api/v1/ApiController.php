<?php

namespace App\Http\Controllers\Api\V1;

use App\Like;
use DB;
use Auth;
use Illuminate\Http\Request;


/**
 * Class ApiController
 *
 * @package App\Http\Controllers\Api\V1
 *
 * @SWG\Swagger(
 *      basePath="/api",
 *      host="127.0.0.1:8000",
 *      schemes={"http", "https"},
 *
 *      @SWG\SecurityScheme(
 *          securityDefinition="Bearer",
 *          type="apiKey",
 *          name="Authorization",
 *          in="header"
 *      ),
 *      @SWG\Info(
 *          description="xlarge laravel api Documentation",
 *          version="1.0.0",
 *          title="Xlarge Api",
 *          @SWG\Contact(
 *              name="github",
 *              url="https://github.com/menaemg/xlarge"
 *          ),
 *     ),
 **********************************************
 *     @SWG\Tag(
 *         name="Auth",
 *         description="login and register",
 *     ),
 ***********************************************
 *     @SWG\Tag(
 *         name="public posts",
 *         description="get public posts",
 *     ),
 *     @SWG\Tag(
 *         name="public categories",
 *         description="get public categories",
 *     ),
 *     @SWG\Tag(
 *         name="public users",
 *         description="get public users",
 *     ),
************************************************
 *     @SWG\Tag(
 *         name="user profile",
 *         description="show , edit and logout user",
 *     ),
 *     @SWG\Tag(
 *         name="user like",
 *         description="like , unlike and get likes for posts",
 *     ),
 *     @SWG\Tag(
 *         name="user comments",
 *         description="get , add , edit and delete user comments",
 *     ),
 *     @SWG\Tag(
 *         name="user replies",
 *         description="get , add , edit and delete user replies",
 *     ),
************************************************
 *     @SWG\Tag(
 *         name="editor posts",
 *         description="get public posts",
 *     ),
 *     @SWG\Tag(
 *         name="editor categories",
 *         description="get public categories",
 *     ),
 *     @SWG\Tag(
 *         name="editor comments",
 *         description="get public users",
 *     ),
 *     @SWG\Tag(
 *         name="editor replies",
 *         description="get public users",
 *     ),
 ***********************************************
 *     @SWG\Tag(
 *         name="admin users",
 *         description="get public users",
 *     ),
 ************************************************
*     @SWG\Tag(
 *         name="users trash",
 *         description="get , restore or delete trash users",
 *     ),
 *     @SWG\Tag(
 *         name="posts trash",
 *         description="get , restore or delete trash posts",
 *     ),
 *     @SWG\Tag(
 *         name="categories trash",
 *         description="get , restore or delete trash categories",
 *     ),
 *     @SWG\Tag(
 *         name="comments trash",
 *         description="get , restore or delete trash comments",
 *     ),
 *     @SWG\Tag(
 *         name="replies trash",
 *         description="get , restore or delete trash replies",
 *     ),
 * ),
 */

class ApiController extends Controller
{
    /**
    ****************************************************************
    *###################### Start Auth Data ########################
    ****************************************************************
    * @SWG\Post(
    *      path="/login",
    *      tags={"Auth"},
    *      summary="login and get access token",
    *      description="login and get access token",
    *      operationId="login",
    *      @SWG\Parameter(
    *          name="email",
    *          in="formData",
    *          type="string",
    *          format="email",
    *          description="user email",
    *          required=true,
    *      ),
    *      @SWG\Parameter(
    *          name="password",
    *          in="formData",
    *          type="string",
    *          format="password",
    *          description="password for email",
    *          required=true,
    *      ),
    *      @SWG\Response(
    *          response=200,
    *          description="successful operation",
    *       ),
    *       @SWG\Response(response=400, description="Bad request"),
    *     )
    ****************************************************************
    * @SWG\Post(
    *      path="/register",
    *      tags={"Auth"},
    *      summary="register new user",
    *      description="register new user",
    *      operationId="register",
    *      @SWG\Parameter(
    *          name="name",
    *          in="formData",
    *          type="string",
    *          format="string",
    *          description="full name",
    *          required=true,
    *      ),
    *      @SWG\Parameter(
    *          name="email",
    *          in="formData",
    *          type="string",
    *          format="email",
    *          description="user email",
    *          required=true,
    *      ),
    *      @SWG\Parameter(
    *          name="password",
    *          in="formData",
    *          type="string",
    *          format="password",
    *          description="password for email",
    *          required=true,
    *      ),
    *      @SWG\Parameter(
    *          name="password_confirmation",
    *          in="formData",
    *          type="string",
    *          format="password",
    *          description="password confirmation for email",
    *          required=true,
    *      ),
    *      @SWG\Response(
    *          response=200,
    *          description="successful operation",
    *       ),
    *       @SWG\Response(response=400, description="Bad request"),
    *     )
    ****************************************************************
    *###################### Start public Data ######################
    ****************************************************************
    * @SWG\Get(
    *      path="/posts",
    *      tags={"public posts"},
    *      summary="get public posts",
    *      description="get public posts",
    *      operationId="posts",
    *      security={{"Bearer":{}}},
    *      @SWG\Response(
    *          response=200,
    *          description="successful operation",
    *       ),
    *       @SWG\Response(response=400, description="Bad request"),
    *     )
    ****************************************************************
    * @SWG\Get(
    *      path="/posts/show/{id}",
    *      tags={"public posts"},
    *      summary="show single post",
    *      description="show single post",
    *      operationId="post",
    *      security={{"Bearer":{}}},
    *      @SWG\Parameter(
    *          name="id",
    *          in="path",
    *          type="string",
    *          format="string",
    *          description="post id",
    *          required=true,
    *      ),
    *      @SWG\Response(
    *          response=200,
    *          description="successful operation",
    *       ),
    *       @SWG\Response(response=400, description="Bad request"),
    *     )
    ****************************************************************
    * @SWG\Get(
    *      path="/categories",
    *      tags={"public categories"},
    *      summary="get public categories",
    *      description="get public categories",
    *      operationId="categories",
    *      @SWG\Response(
    *          response=200,
    *          description="successful operation",
    *       ),
    *       @SWG\Response(response=400, description="Bad request"),
    *     )
    ****************************************************************
    * @SWG\Get(
    *      path="/categories/show/{id}",
    *      tags={"public categories"},
    *      summary="show single category",
    *      description="show single category",
    *      operationId="post",
    *      @SWG\Parameter(
    *          name="id",
    *          in="path",
    *          type="string",
    *          format="string",
    *          description="post id",
    *          required=true,
    *      ),
    *      @SWG\Response(
    *          response=200,
    *          description="successful operation",
    *       ),
    *       @SWG\Response(response=400, description="Bad request"),
    *     )
    ****************************************************************
    * @SWG\Get(
    *      path="/users",
    *      tags={"public users"},
    *      summary="get public users",
    *      description="get public users",
    *      operationId="users",
    *      @SWG\Response(
    *          response=200,
    *          description="successful operation",
    *       ),
    *       @SWG\Response(response=400, description="Bad request"),
    *     )
    ****************************************************************
    * @SWG\Get(
    *      path="/users/show/{id}",
    *      tags={"public users"},
    *      summary="show single user",
    *      description="show single user",
    *      operationId="user",
    *      @SWG\Parameter(
    *          name="id",
    *          in="path",
    *          type="string",
    *          format="string",
    *          description="post id",
    *          required=true,
    *      ),
    *      @SWG\Response(
    *          response=200,
    *          description="successful operation",
    *       ),
    *       @SWG\Response(response=400, description="Bad request"),
    *     )
    ****************************************************************
    *###################### Start user Data ########################
    ****************************************************************
    * @SWG\Get(
    *      path="/user/profile/me",
    *      tags={"user profile"},
    *      summary="get user profile",
    *      description="get public users",
    *      operationId="profile.me",
    *      security={{"Bearer":{}}},
    *      @SWG\Response(
    *          response=200,
    *          description="successful operation",
    *       ),
    *       @SWG\Response(response=400, description="Bad request"),
    *     )
    ****************************************************************
    * @SWG\Post(
    *      path="/user/profile/edit",
    *      tags={"user profile"},
    *      summary="edit user profile",
    *      description="edit user profile",
    *      operationId="profile.edit",
    *      security={{"Bearer":{}}},
    *      @SWG\Parameter(
    *          name="name",
    *          in="formData",
    *          type="string",
    *          format="string",
    *          description="full name",
    *          required=true,
    *      ),
    *      @SWG\Parameter(
    *          name="email",
    *          in="formData",
    *          type="string",
    *          format="email",
    *          description="user email",
    *          required=true,
    *      ),
    *      @SWG\Parameter(
    *          name="password",
    *          in="formData",
    *          type="string",
    *          format="password",
    *          description="password for email",
    *          required=false,
    *      ),
    *      @SWG\Parameter(
    *          name="password_confirmation",
    *          in="formData",
    *          type="string",
    *          format="password",
    *          description="password confirmation for email",
    *          required=false,
    *      ),
    *      @SWG\Parameter(
    *          name="image",
    *          in="formData",
    *          type="file",
    *          format="image",
    *          description="user image",
    *          required=false,
    *      ),
    *      @SWG\Response(
    *          response=200,
    *          description="successful operation",
    *       ),
    *       @SWG\Response(response=400, description="Bad request"),
    *     )
    ****************************************************************
    * @SWG\Post(
    *      path="/user/logout",
    *      tags={"user profile"},
    *      summary="logout from your account",
    *      description="logout from your account",
    *      operationId="profile.logout",
    *      security={{"Bearer":{}}},
    *      @SWG\Response(
    *          response=200,
    *          description="successful operation",
    *       ),
    *       @SWG\Response(response=400, description="Bad request"),
    *     )
    ****************************************************************
    * @SWG\Post(
    *      path="/user/like/add/{id}",
    *      tags={"user like"},
    *      summary="like or unlike post",
    *      description="like or unlike post",
    *      operationId="user.like",
    *      security={{"Bearer":{}}},
    *      @SWG\Parameter(
    *          name="id",
    *          in="path",
    *          type="string",
    *          format="string",
    *          description="post id",
    *          required=true,
    *      ),
    *      @SWG\Response(
    *          response=200,
    *          description="successful operation",
    *       ),
    *       @SWG\Response(response=400, description="Bad request"),
    *     )
    ****************************************************************
        * @SWG\Get(
    *      path="/user/like/posts",
    *      tags={"user like"},
    *      summary="get user likes for all posts",
    *      description="get user likes for all posts",
    *      operationId="user.likes",
    *      security={{"Bearer":{}}},
    *      @SWG\Response(
    *          response=200,
    *          description="successful operation",
    *       ),
    *       @SWG\Response(response=400, description="Bad request"),
    *     )
    ****************************************************************
    * @SWG\Get(
    *      path="/user/like/status/{id}",
    *      tags={"user like"},
    *      summary="check if user like this post",
    *      description="check if user like this post",
    *      operationId="user.like.status",
    *      security={{"Bearer":{}}},
    *      @SWG\Parameter(
    *          name="id",
    *          in="path",
    *          type="string",
    *          format="string",
    *          description="post id",
    *          required=true,
    *      ),
    *      @SWG\Response(
    *          response=200,
    *          description="successful operation",
    *       ),
    *       @SWG\Response(response=400, description="Bad request"),
    *     )
    ****************************************************************
    * @SWG\Get(
    *      path="/user/comments",
    *      tags={"user comments"},
    *      summary="get all user comments",
    *      description="get all user comments",
    *      operationId="user.comments",
    *      security={{"Bearer":{}}},
    *      @SWG\Response(
    *          response=200,
    *          description="successful operation",
    *       ),
    *       @SWG\Response(response=400, description="Bad request"),
    *     )
    ****************************************************************
    * @SWG\Post(
    *      path="/user/comments/create",
    *      tags={"user comments"},
    *      summary="add new comment",
    *      description="get all user comments",
    *      operationId="user.comments.create",
    *      security={{"Bearer":{}}},
    *      @SWG\Parameter(
    *          name="post_id",
    *          in="formData",
    *          type="string",
    *          format="string",
    *          description="post id",
    *          required=true,
    *      ),
    *      @SWG\Parameter(
    *          name="content",
    *          in="formData",
    *          type="string",
    *          format="string",
    *          description="comment content",
    *          required=true,
    *      ),
    *      @SWG\Response(
    *          response=200,
    *          description="successful operation",
    *       ),
    *       @SWG\Response(response=400, description="Bad request"),
    *     )
    ****************************************************************
    * @SWG\Put(
    *      path="/user/comments/edit/{id}",
    *      tags={"user comments"},
    *      summary="edit comment",
    *      description="edit comment",
    *      operationId="user.comments.edit",
    *      security={{"Bearer":{}}},
    *      @SWG\Parameter(
    *          name="id",
    *          in="path",
    *          type="string",
    *          format="string",
    *          description="comment id",
    *          required=true,
    *      ),
    *      @SWG\Parameter(
    *          name="content",
    *          in="formData",
    *          type="string",
    *          format="string",
    *          description="comment content",
    *          required=true,
    *      ),
    *      @SWG\Response(
    *          response=200,
    *          description="successful operation",
    *       ),
    *       @SWG\Response(response=400, description="Bad request"),
    *     )
    ****************************************************************
    * @SWG\Delete(
    *      path="/user/comments/delete/{id}",
    *      tags={"user comments"},
    *      summary="delete comment",
    *      description="delete comment",
    *      operationId="user.comments.delete",
    *      security={{"Bearer":{}}},
    *      @SWG\Parameter(
    *          name="id",
    *          in="path",
    *          type="string",
    *          format="string",
    *          description="comment id",
    *          required=true,
    *      ),
    *      @SWG\Response(
    *          response=200,
    *          description="successful operation",
    *       ),
    *       @SWG\Response(response=400, description="Bad request"),
    *     )
    ****************************************************************
    * @SWG\Get(
    *      path="/user/replies",
    *      tags={"user replies"},
    *      summary="get all user replies",
    *      description="get all user replies",
    *      operationId="user.replies",
    *      security={{"Bearer":{}}},
    *      @SWG\Response(
    *          response=200,
    *          description="successful operation",
    *       ),
    *       @SWG\Response(response=400, description="Bad request"),
    *     )
    ****************************************************************
    * @SWG\Post(
    *      path="/user/replies/create",
    *      tags={"user replies"},
    *      summary="add new replies",
    *      description="get all user replies",
    *      operationId="user.replies.create",
    *      security={{"Bearer":{}}},
    *      @SWG\Parameter(
    *          name="comment_id",
    *          in="formData",
    *          type="string",
    *          format="string",
    *          description="comment id",
    *          required=true,
    *      ),
    *      @SWG\Parameter(
    *          name="content",
    *          in="formData",
    *          type="string",
    *          format="string",
    *          description="replay content",
    *          required=true,
    *      ),
    *      @SWG\Response(
    *          response=200,
    *          description="successful operation",
    *       ),
    *       @SWG\Response(response=400, description="Bad request"),
    *     )
    ****************************************************************
    * @SWG\Put(
    *      path="/user/replies/edit/{id}",
    *      tags={"user replies"},
    *      summary="edit replies",
    *      description="edit replies",
    *      operationId="user.replies.edit",
    *      security={{"Bearer":{}}},
    *      @SWG\Parameter(
    *          name="id",
    *          in="path",
    *          type="string",
    *          format="string",
    *          description="replay id",
    *          required=true,
    *      ),
    *      @SWG\Parameter(
    *          name="content",
    *          in="formData",
    *          type="string",
    *          format="string",
    *          description="replay content",
    *          required=true,
    *      ),
    *      @SWG\Response(
    *          response=200,
    *          description="successful operation",
    *       ),
    *       @SWG\Response(response=400, description="Bad request"),
    *     )
    ****************************************************************
    * @SWG\Delete(
    *      path="/user/replies/delete/{id}",
    *      tags={"user replies"},
    *      summary="delete replies",
    *      description="delete replies",
    *      operationId="user.replies.delete",
    *      security={{"Bearer":{}}},
    *      @SWG\Parameter(
    *          name="id",
    *          in="path",
    *          type="string",
    *          format="string",
    *          description="replay id",
    *          required=true,
    *      ),
    *      @SWG\Response(
    *          response=200,
    *          description="successful operation",
    *       ),
    *       @SWG\Response(response=400, description="Bad request"),
    *     )
    ****************************************************************
    *#################### Start Editor Data ########################
    ****************************************************************
    * @SWG\Get(
    *      path="/editor/posts",
    *      tags={"editor posts"},
    *      summary="get all posts",
    *      description="get all posts",
    *      operationId="editor.posts",
    *      security={{"Bearer":{}}},
    *      @SWG\Response(
    *          response=200,
    *          description="successful operation",
    *       ),
    *       @SWG\Response(response=400, description="Bad request"),
    *     )
    ****************************************************************
    * @SWG\Get(
    *      path="/editor/posts/show/{id}",
    *      tags={"editor posts"},
    *      summary="get one post",
    *      description="edit one post",
    *      operationId="editor.posts.show",
    *      security={{"Bearer":{}}},
    *      @SWG\Parameter(
    *          name="id",
    *          in="path",
    *          type="string",
    *          format="string",
    *          description="post id",
    *          required=true,
    *      ),
    *      @SWG\Response(
    *          response=200,
    *          description="successful operation",
    *       ),
    *       @SWG\Response(response=400, description="Bad request"),
    *     )
    ****************************************************************
    * @SWG\Post(
    *      path="/editor/posts/create",
    *      tags={"editor posts"},
    *      summary="create new post",
    *      description="create new post",
    *      operationId="user.replies.create",
    *      security={{"Bearer":{}}},
    *      @SWG\Parameter(
    *          name="title",
    *          in="formData",
    *          type="string",
    *          format="string",
    *          description="post title",
    *          required=true,
    *      ),
    *      @SWG\Parameter(
    *          name="content",
    *          in="formData",
    *          type="string",
    *          format="string",
    *          description="post content",
    *          required=true,
    *      ),
    *      @SWG\Parameter(
    *          name="image",
    *          in="formData",
    *          type="file",
    *          format="image",
    *          description="post image",
    *          required=false,
    *      ),
    *      @SWG\Parameter(
    *          name="user_id",
    *          in="formData",
    *          type="string",
    *          format="string",
    *          description="user id for this post",
    *          required=false,
    *      ),
    *      @SWG\Parameter(
    *          name="status",
    *          in="formData",
    *          type="string",
    *          format="boolean",
    *          description="private or public",
    *          required=false,
    *      ),
    *      @SWG\Response(
    *          response=200,
    *          description="successful operation",
    *       ),
    *       @SWG\Response(response=400, description="Bad request"),
    *     )
    ****************************************************************
    * @SWG\Post(
    *      path="/editor/posts/edit/{id}?_method=put",
    *      tags={"editor posts"},
    *      summary="edit post",
    *      description="edit post",
    *      operationId="editor.post.edit",
    *      security={{"Bearer":{}}},
    *      @SWG\Parameter(
    *          name="id",
    *          in="path",
    *          type="string",
    *          format="string",
    *          description="posts id",
    *          required=true,
    *      ),
    *      @SWG\Parameter(
    *          name="title",
    *          in="formData",
    *          type="string",
    *          format="string",
    *          description="post title",
    *          required=true,
    *      ),
    *      @SWG\Parameter(
    *          name="content",
    *          in="formData",
    *          type="string",
    *          format="string",
    *          description="post content",
    *          required=true,
    *      ),
    *      @SWG\Parameter(
    *          name="image",
    *          in="formData",
    *          type="file",
    *          format="image",
    *          description="post image",
    *          required=false,
    *      ),
    *      @SWG\Parameter(
    *          name="user_id",
    *          in="formData",
    *          type="string",
    *          format="string",
    *          description="user id for this post",
    *          required=false,
    *      ),
    *      @SWG\Parameter(
    *          name="status",
    *          in="formData",
    *          type="string",
    *          format="string",
    *          description="private or public",
    *          required=false,
    *      ),
    *      @SWG\Response(
    *          response=200,
    *          description="successful operation",
    *       ),
    *       @SWG\Response(response=400, description="Bad request"),
    *     )
    ****************************************************************
    * @SWG\Delete(
    *      path="/editor/posts/delete/{id}",
    *      tags={"editor posts"},
    *      summary="delete post",
    *      description="delete post",
    *      operationId="user.posts.delete",
    *      security={{"Bearer":{}}},
    *      @SWG\Parameter(
    *          name="id",
    *          in="path",
    *          type="string",
    *          format="string",
    *          description="post id",
    *          required=true,
    *      ),
    *      @SWG\Response(
    *          response=200,
    *          description="successful operation",
    *       ),
    *       @SWG\Response(response=400, description="Bad request"),
    *     )
    ****************************************************************
    ****************************************************************
    * @SWG\Get(
    *      path="/editor/categories",
    *      tags={"editor categories"},
    *      summary="get all categories",
    *      description="get all categories",
    *      operationId="editor.categories",
    *      security={{"Bearer":{}}},
    *      @SWG\Response(
    *          response=200,
    *          description="successful operation",
    *       ),
    *       @SWG\Response(response=400, description="Bad request"),
    *     )
    ****************************************************************
    * @SWG\Get(
    *      path="/editor/categories/show/{id}",
    *      tags={"editor categories"},
    *      summary="get one category",
    *      description="et one category",
    *      operationId="editor.categories.show",
    *      security={{"Bearer":{}}},
    *      @SWG\Parameter(
    *          name="id",
    *          in="path",
    *          type="string",
    *          format="string",
    *          description="category id",
    *          required=true,
    *      ),
    *      @SWG\Response(
    *          response=200,
    *          description="successful operation",
    *       ),
    *       @SWG\Response(response=400, description="Bad request"),
    *     )
    ****************************************************************
    * @SWG\Post(
    *      path="/editor/categories/create",
    *      tags={"editor categories"},
    *      summary="create new category",
    *      description="create new category",
    *      operationId="user.categories.create",
    *      security={{"Bearer":{}}},
    *      @SWG\Parameter(
    *          name="name",
    *          in="formData",
    *          type="string",
    *          format="string",
    *          description="category name",
    *          required=true,
    *      ),
    *      @SWG\Parameter(
    *          name="description",
    *          in="formData",
    *          type="string",
    *          format="string",
    *          description="category description",
    *          required=false,
    *      ),
    *      @SWG\Parameter(
    *          name="subfrom",
    *          in="formData",
    *          type="string",
    *          format="string",
    *          description="parent category id for this category",
    *          required=false,
    *      ),
    *      @SWG\Response(
    *          response=200,
    *          description="successful operation",
    *       ),
    *       @SWG\Response(response=400, description="Bad request"),
    *     )
    ****************************************************************
    * @SWG\Put(
    *      path="/editor/categories/edit/{id}",
    *      tags={"editor categories"},
    *      summary="edit categories",
    *      description="edit category",
    *      operationId="editor.categories.edit",
    *      security={{"Bearer":{}}},
    *      @SWG\Parameter(
    *          name="id",
    *          in="path",
    *          type="string",
    *          format="string",
    *          description="category id",
    *          required=true,
    *      ),
    *      @SWG\Parameter(
    *          name="name",
    *          in="formData",
    *          type="string",
    *          format="string",
    *          description="category name",
    *          required=true,
    *      ),
    *      @SWG\Parameter(
    *          name="description",
    *          in="formData",
    *          type="string",
    *          format="string",
    *          description="category description",
    *          required=false,
    *      ),
    *      @SWG\Parameter(
    *          name="subfrom",
    *          in="formData",
    *          type="string",
    *          format="string",
    *          description="parent category id for this category",
    *          required=false,
    *      ),
    *      @SWG\Response(
    *          response=200,
    *          description="successful operation",
    *       ),
    *       @SWG\Response(response=400, description="Bad request"),
    *     )
    ****************************************************************
    * @SWG\Delete(
    *      path="/editor/categories/delete/{id}",
    *      tags={"editor categories"},
    *      summary="delete category",
    *      description="delete categories",
    *      operationId="user.categories.delete",
    *      security={{"Bearer":{}}},
    *      @SWG\Parameter(
    *          name="id",
    *          in="path",
    *          type="string",
    *          format="string",
    *          description="category id",
    *          required=true,
    *      ),
    *      @SWG\Response(
    *          response=200,
    *          description="successful operation",
    *       ),
    *       @SWG\Response(response=400, description="Bad request"),
    *     )
    ****************************************************************
    ****************************************************************
    * @SWG\Get(
    *      path="/editor/comments",
    *      tags={"editor comments"},
    *      summary="get all comments",
    *      description="get all comments",
    *      operationId="editor.comments",
    *      security={{"Bearer":{}}},
    *      @SWG\Response(
    *          response=200,
    *          description="successful operation",
    *       ),
    *       @SWG\Response(response=400, description="Bad request"),
    *     )
    ****************************************************************
    * @SWG\Get(
    *      path="/editor/comments/show/{id}",
    *      tags={"editor comments"},
    *      summary="get one comment",
    *      description="et one comment",
    *      operationId="editor.comments.show",
    *      security={{"Bearer":{}}},
    *      @SWG\Parameter(
    *          name="id",
    *          in="path",
    *          type="string",
    *          format="string",
    *          description="comment id",
    *          required=true,
    *      ),
    *      @SWG\Response(
    *          response=200,
    *          description="successful operation",
    *       ),
    *       @SWG\Response(response=400, description="Bad request"),
    *     )
    ****************************************************************
    * @SWG\Post(
    *      path="/editor/comments/create",
    *      tags={"editor comments"},
    *      summary="create new comment",
    *      description="create new comment",
    *      operationId="editor.comments.create",
    *      security={{"Bearer":{}}},
    *      @SWG\Parameter(
    *          name="post_id",
    *          in="formData",
    *          type="string",
    *          format="string",
    *          description="post id",
    *          required=true,
    *      ),
    *      @SWG\Parameter(
    *          name="content",
    *          in="formData",
    *          type="string",
    *          format="string",
    *          description="comment content",
    *          required=true,
    *      ),
    *      @SWG\Parameter(
    *          name="user_id",
    *          in="formData",
    *          type="string",
    *          format="string",
    *          description="user id",
    *          required=false,
    *      ),
    *      @SWG\Response(
    *          response=200,
    *          description="successful operation",
    *       ),
    *       @SWG\Response(response=400, description="Bad request"),
    *     )
    ****************************************************************
    * @SWG\Put(
    *      path="/editor/comments/edit/{id}",
    *      tags={"editor comments"},
    *      summary="edit comment",
    *      description="edit comment",
    *      operationId="editor.comments.edit",
    *      security={{"Bearer":{}}},
    *      @SWG\Parameter(
    *          name="content",
    *          in="formData",
    *          type="string",
    *          format="string",
    *          description="comment content",
    *          required=true,
    *      ),
    *      @SWG\Parameter(
    *          name="id",
    *          in="path",
    *          type="string",
    *          format="string",
    *          description="comment id",
    *          required=true,
    *      ),
    *      @SWG\Parameter(
    *          name="post_id",
    *          in="formData",
    *          type="string",
    *          format="string",
    *          description="post id",
    *          required=false,
    *      ),
    *      @SWG\Parameter(
    *          name="user_id",
    *          in="formData",
    *          type="string",
    *          format="string",
    *          description="user id",
    *          required=false,
    *      ),
    *      @SWG\Response(
    *          response=200,
    *          description="successful operation",
    *       ),
    *       @SWG\Response(response=400, description="Bad request"),
    *     )
    ****************************************************************
    * @SWG\Delete(
    *      path="/editor/comments/delete/{id}",
    *      tags={"editor comments"},
    *      summary="delete comment",
    *      description="delete comment",
    *      operationId="editor.comments.delete",
    *      security={{"Bearer":{}}},
    *      @SWG\Parameter(
    *          name="id",
    *          in="path",
    *          type="string",
    *          format="string",
    *          description="comment id",
    *          required=true,
    *      ),
    *      @SWG\Response(
    *          response=200,
    *          description="successful operation",
    *       ),
    *       @SWG\Response(response=400, description="Bad request"),
    *     )
    * ),
    ****************************************************************
    ****************************************************************
    * @SWG\Get(
    *      path="/editor/replies",
    *      tags={"editor replies"},
    *      summary="get all replies",
    *      description="get all replies",
    *      operationId="editor.replies",
    *      security={{"Bearer":{}}},
    *      @SWG\Response(
    *          response=200,
    *          description="successful operation",
    *       ),
    *       @SWG\Response(response=400, description="Bad request"),
    *     )
    ****************************************************************
    * @SWG\Get(
    *      path="/editor/replies/show/{id}",
    *      tags={"editor replies"},
    *      summary="get one replay",
    *      description="et one replay",
    *      operationId="editor.replies.show",
    *      security={{"Bearer":{}}},
    *      @SWG\Parameter(
    *          name="id",
    *          in="path",
    *          type="string",
    *          format="string",
    *          description="replay id",
    *          required=true,
    *      ),
    *      @SWG\Response(
    *          response=200,
    *          description="successful operation",
    *       ),
    *       @SWG\Response(response=400, description="Bad request"),
    *     )
    ****************************************************************
    * @SWG\Post(
    *      path="/editor/replies/create",
    *      tags={"editor replies"},
    *      summary="create new replay",
    *      description="create new replay",
    *      operationId="editor.replies.create",
    *      security={{"Bearer":{}}},
    *      @SWG\Parameter(
    *          name="content",
    *          in="formData",
    *          type="string",
    *          format="string",
    *          description="replay content",
    *          required=true,
    *      ),
    *      @SWG\Parameter(
    *          name="comment_id",
    *          in="formData",
    *          type="string",
    *          format="string",
    *          description="comment id",
    *          required=true,
    *      ),
    *      @SWG\Parameter(
    *          name="user_id",
    *          in="formData",
    *          type="string",
    *          format="string",
    *          description="user id",
    *          required=false,
    *      ),
    *      @SWG\Response(
    *          response=200,
    *          description="successful operation",
    *       ),
    *       @SWG\Response(response=400, description="Bad request"),
    *     )
    ****************************************************************
    * @SWG\Put(
    *      path="/editor/replies/edit/{id}",
    *      tags={"editor replies"},
    *      summary="edit replay",
    *      description="edit replay",
    *      operationId="editor.replies.edit",
    *      security={{"Bearer":{}}},
    *      @SWG\Parameter(
    *          name="id",
    *          in="path",
    *          type="string",
    *          format="string",
    *          description="replay id",
    *          required=true,
    *      ),
    *      @SWG\Parameter(
    *          name="content",
    *          in="formData",
    *          type="string",
    *          format="string",
    *          description="replay content",
    *          required=true,
    *      ),
    *      @SWG\Parameter(
    *          name="comment_id",
    *          in="formData",
    *          type="string",
    *          format="string",
    *          description="comment id",
    *          required=false,
    *      ),
    *      @SWG\Parameter(
    *          name="user_id",
    *          in="formData",
    *          type="string",
    *          format="string",
    *          description="user id",
    *          required=false,
    *      ),
    *      @SWG\Response(
    *          response=200,
    *          description="successful operation",
    *       ),
    *       @SWG\Response(response=400, description="Bad request"),
    *     )
    ****************************************************************
    * @SWG\Delete(
    *      path="/editor/replies/delete/{id}",
    *      tags={"editor replies"},
    *      summary="delete replay",
    *      description="delete replay",
    *      operationId="editor.replies.delete",
    *      security={{"Bearer":{}}},
    *      @SWG\Parameter(
    *          name="id",
    *          in="path",
    *          type="string",
    *          format="string",
    *          description="replay id",
    *          required=true,
    *      ),
    *      @SWG\Response(
    *          response=200,
    *          description="successful operation",
    *       ),
    *       @SWG\Response(response=400, description="Bad request"),
    *     )
    ****************************************************************
    *##################### Start Admin Data ########################
    ****************************************************************
    * @SWG\Get(
    *      path="/admin/users",
    *      tags={"admin users"},
    *      summary="get all users",
    *      description="get all users",
    *      operationId="admin.users",
    *      security={{"Bearer":{}}},
    *      @SWG\Response(
    *          response=200,
    *          description="successful operation",
    *       ),
    *       @SWG\Response(response=400, description="Bad request"),
    *     )
    ****************************************************************
    * @SWG\Get(
    *      path="/admin/users/show/{id}",
    *      tags={"admin users"},
    *      summary="get one user",
    *      description="et one user",
    *      operationId="admin.users.show",
    *      security={{"Bearer":{}}},
    *      @SWG\Parameter(
    *          name="id",
    *          in="path",
    *          type="string",
    *          format="string",
    *          description="user id",
    *          required=true,
    *      ),
    *      @SWG\Response(
    *          response=200,
    *          description="successful operation",
    *       ),
    *       @SWG\Response(response=400, description="Bad request"),
    *     )
    ****************************************************************
    * @SWG\Post(
    *      path="/admin/users/create",
    *      tags={"admin users"},
    *      summary="create new user",
    *      description="create new user",
    *      operationId="admin.users.create",
    *      security={{"Bearer":{}}},
    *      @SWG\Parameter(
    *          name="name",
    *          in="formData",
    *          type="string",
    *          format="string",
    *          description="full name",
    *          required=true,
    *      ),
    *      @SWG\Parameter(
    *          name="email",
    *          in="formData",
    *          type="string",
    *          format="email",
    *          description="user email",
    *          required=true,
    *      ),
    *      @SWG\Parameter(
    *          name="password",
    *          in="formData",
    *          type="string",
    *          format="password",
    *          description="password for email",
    *          required=true,
    *      ),
    *      @SWG\Parameter(
    *          name="password_confirmation",
    *          in="formData",
    *          type="string",
    *          format="password",
    *          description="password confirmation for email",
    *          required=true,
    *      ),
    *      @SWG\Parameter(
    *          name="image",
    *          in="formData",
    *          type="file",
    *          format="image",
    *          description="user image",
    *          required=false,
    *      ),
    *      @SWG\Parameter(
    *          name="rule",
    *          in="formData",
    *          type="string",
    *          format="image",
    *          description="user rule in (1 , 2, 3) 1 user 2 editor 3 admin",
    *          required=false,
    *      ),
    *      @SWG\Response(
    *          response=200,
    *          description="successful operation",
    *       ),
    *       @SWG\Response(response=400, description="Bad request"),
    *     )
    ****************************************************************
    * @SWG\Post(
    *      path="/admin/users/edit/{id}?_method=put",
    *      tags={"admin users"},
    *      summary="edit user",
    *      description="edit new user",
    *      operationId="admin.users.edit",
    *      security={{"Bearer":{}}},
    *      @SWG\Parameter(
    *          name="id",
    *          in="path",
    *          type="string",
    *          format="string",
    *          description="user id",
    *          required=true,
    *      ),
    *      @SWG\Parameter(
    *          name="name",
    *          in="formData",
    *          type="string",
    *          format="string",
    *          description="full name",
    *          required=true,
    *      ),
    *      @SWG\Parameter(
    *          name="email",
    *          in="formData",
    *          type="string",
    *          format="email",
    *          description="user email",
    *          required=true,
    *      ),
    *      @SWG\Parameter(
    *          name="password",
    *          in="formData",
    *          type="string",
    *          format="password",
    *          description="password for email",
    *          required=false,
    *      ),
    *      @SWG\Parameter(
    *          name="password_confirmation",
    *          in="formData",
    *          type="string",
    *          format="password",
    *          description="password confirmation for email",
    *          required=false,
    *      ),
    *      @SWG\Parameter(
    *          name="image",
    *          in="formData",
    *          type="file",
    *          format="image",
    *          description="user image",
    *          required=false,
    *      ),
    *      @SWG\Parameter(
    *          name="rule",
    *          in="formData",
    *          type="string",
    *          format="image",
    *          description="user rule in (1 , 2, 3) 1 user 2 editor 3 admin",
    *          required=false,
    *      ),
    *      @SWG\Response(
    *          response=200,
    *          description="successful operation",
    *       ),
    *       @SWG\Response(response=400, description="Bad request"),
    *     )
    ****************************************************************
    * @SWG\Delete(
    *      path="/admin/users/delete/{id}",
    *      tags={"admin users"},
    *      summary="delete user",
    *      description="delete user",
    *      operationId="admin.users.delete",
    *      security={{"Bearer":{}}},
    *      @SWG\Parameter(
    *          name="id",
    *          in="path",
    *          type="string",
    *          format="string",
    *          description="user id",
    *          required=true,
    *      ),
    *      @SWG\Response(
    *          response=200,
    *          description="successful operation",
    *       ),
    *       @SWG\Response(response=400, description="Bad request"),
    *     )
    * ),
    ****************************************************************
    *##################### Start Trash Data ########################
    ****************************************************************
    * @SWG\Get(
    *      path="/trash/users",
    *      tags={"users trash"},
    *      summary="get users trash",
    *      description="get users trash",
    *      operationId="users.trash",
    *      security={{"Bearer":{}}},
    *      @SWG\Response(
    *          response=200,
    *          description="successful operation",
    *       ),
    *       @SWG\Response(response=400, description="Bad request"),
    *     )
    * ),
    ****************************************************************
    * @SWG\Post(
    *      path="/trash/users/restore/{id}",
    *      tags={"users trash"},
    *      summary="restore user from trash",
    *      description="restore user from trash",
    *      operationId="users.trash.restore",
    *      security={{"Bearer":{}}},
    *      @SWG\Parameter(
    *          name="id",
    *          in="path",
    *          type="string",
    *          format="string",
    *          description="user id",
    *          required=true,
    *      ),
    *      @SWG\Response(
    *          response=200,
    *          description="successful operation",
    *       ),
    *       @SWG\Response(response=400, description="Bad request"),
    *     )
    * ),
    ****************************************************************
    * @SWG\Delete(
    *      path="/trash/users/delete/{id}",
    *      tags={"users trash"},
    *      summary="delete user from trash",
    *      description="delete user from trash",
    *      operationId="users.trash.delete",
    *      security={{"Bearer":{}}},
    *      @SWG\Parameter(
    *          name="id",
    *          in="path",
    *          type="string",
    *          format="string",
    *          description="user id",
    *          required=true,
    *      ),
    *      @SWG\Response(
    *          response=200,
    *          description="successful operation",
    *       ),
    *       @SWG\Response(response=400, description="Bad request"),
    *     )
    * ),
    ****************************************************************
    ****************************************************************
    * @SWG\Get(
    *      path="/trash/posts",
    *      tags={"posts trash"},
    *      summary="get posts trash",
    *      description="get posts trash",
    *      operationId="posts.trash",
    *      security={{"Bearer":{}}},
    *      @SWG\Response(
    *          response=200,
    *          description="successful operation",
    *       ),
    *       @SWG\Response(response=400, description="Bad request"),
    *     )
    * ),
    ****************************************************************
    * @SWG\Post(
    *      path="/trash/posts/restore/{id}",
    *      tags={"posts trash"},
    *      summary="restore post from trash",
    *      description="restore post from trash",
    *      operationId="post.trash.restore",
    *      security={{"Bearer":{}}},
    *      @SWG\Parameter(
    *          name="id",
    *          in="path",
    *          type="string",
    *          format="string",
    *          description="post id",
    *          required=true,
    *      ),
    *      @SWG\Response(
    *          response=200,
    *          description="successful operation",
    *       ),
    *       @SWG\Response(response=400, description="Bad request"),
    *     )
    * ),
    ****************************************************************
    * @SWG\Delete(
    *      path="/trash/posts/delete/{id}",
    *      tags={"posts trash"},
    *      summary="delete post from trash",
    *      description="delete post from trash",
    *      operationId="posts.trash.delete",
    *      security={{"Bearer":{}}},
    *      @SWG\Parameter(
    *          name="id",
    *          in="path",
    *          type="string",
    *          format="string",
    *          description="post id",
    *          required=true,
    *      ),
    *      @SWG\Response(
    *          response=200,
    *          description="successful operation",
    *       ),
    *       @SWG\Response(response=400, description="Bad request"),
    *     )
    * ),
    ****************************************************************
    ****************************************************************
    * @SWG\Get(
    *      path="/trash/categories",
    *      tags={"categories trash"},
    *      summary="get categories trash",
    *      description="get categories trash",
    *      operationId="categories.trash",
    *      security={{"Bearer":{}}},
    *      @SWG\Response(
    *          response=200,
    *          description="successful operation",
    *       ),
    *       @SWG\Response(response=400, description="Bad request"),
    *     )
    * ),
    ****************************************************************
    * @SWG\Post(
    *      path="/trash/categories/restore/{id}",
    *      tags={"categories trash"},
    *      summary="restore category from trash",
    *      description="restore category from trash",
    *      operationId="categories.trash.restore",
    *      security={{"Bearer":{}}},
    *      @SWG\Parameter(
    *          name="id",
    *          in="path",
    *          type="string",
    *          format="string",
    *          description="category id",
    *          required=true,
    *      ),
    *      @SWG\Response(
    *          response=200,
    *          description="successful operation",
    *       ),
    *       @SWG\Response(response=400, description="Bad request"),
    *     )
    * ),
    ****************************************************************
    * @SWG\Delete(
    *      path="/trash/categories/delete/{id}",
    *      tags={"categories trash"},
    *      summary="delete category from trash",
    *      description="delete category from trash",
    *      operationId="categories.trash.delete",
    *      security={{"Bearer":{}}},
    *      @SWG\Parameter(
    *          name="id",
    *          in="path",
    *          type="string",
    *          format="string",
    *          description="category id",
    *          required=true,
    *      ),
    *      @SWG\Response(
    *          response=200,
    *          description="successful operation",
    *       ),
    *       @SWG\Response(response=400, description="Bad request"),
    *     )
    * ),
    ****************************************************************
    ****************************************************************
    * @SWG\Get(
    *      path="/trash/comments",
    *      tags={"comments trash"},
    *      summary="get comments trash",
    *      description="get comments trash",
    *      operationId="comments.trash",
    *      security={{"Bearer":{}}},
    *      @SWG\Response(
    *          response=200,
    *          description="successful operation",
    *       ),
    *       @SWG\Response(response=400, description="Bad request"),
    *     )
    * ),
    ****************************************************************
    * @SWG\Post(
    *      path="/trash/comments/restore/{id}",
    *      tags={"comments trash"},
    *      summary="restore comment from trash",
    *      description="restore comment from trash",
    *      operationId="comments.trash.restore",
    *      security={{"Bearer":{}}},
    *      @SWG\Parameter(
    *          name="id",
    *          in="path",
    *          type="string",
    *          format="string",
    *          description="comment id",
    *          required=true,
    *      ),
    *      @SWG\Response(
    *          response=200,
    *          description="successful operation",
    *       ),
    *       @SWG\Response(response=400, description="Bad request"),
    *     )
    * ),
    ****************************************************************
    * @SWG\Delete(
    *      path="/trash/comments/delete/{id}",
    *      tags={"comments trash"},
    *      summary="delete comment from trash",
    *      description="delete comment from trash",
    *      operationId="comments.trash.delete",
    *      security={{"Bearer":{}}},
    *      @SWG\Parameter(
    *          name="id",
    *          in="path",
    *          type="string",
    *          format="string",
    *          description="comment id",
    *          required=true,
    *      ),
    *      @SWG\Response(
    *          response=200,
    *          description="successful operation",
    *       ),
    *       @SWG\Response(response=400, description="Bad request"),
    *     )
    * ),
    ****************************************************************
    ****************************************************************
    * @SWG\Get(
    *      path="/trash/replies",
    *      tags={"replies trash"},
    *      summary="get replies trash",
    *      description="get replies trash",
    *      operationId="replies.trash",
    *      security={{"Bearer":{}}},
    *      @SWG\Response(
    *          response=200,
    *          description="successful operation",
    *       ),
    *       @SWG\Response(response=400, description="Bad request"),
    *     )
    * ),
    ****************************************************************
    * @SWG\Post(
    *      path="/trash/replies/restore/{id}",
    *      tags={"replies trash"},
    *      summary="restore replay from trash",
    *      description="restore replay from trash",
    *      operationId="replies.trash.restore",
    *      security={{"Bearer":{}}},
    *      @SWG\Parameter(
    *          name="id",
    *          in="path",
    *          type="string",
    *          format="string",
    *          description="replay id",
    *          required=true,
    *      ),
    *      @SWG\Response(
    *          response=200,
    *          description="successful operation",
    *       ),
    *       @SWG\Response(response=400, description="Bad request"),
    *     )
    * ),
    ****************************************************************
    * @SWG\Delete(
    *      path="/trash/replies/delete/{id}",
    *      tags={"replies trash"},
    *      summary="delete replay from trash",
    *      description="delete replay from trash",
    *      operationId="replies.trash.delete",
    *      security={{"Bearer":{}}},
    *      @SWG\Parameter(
    *          name="id",
    *          in="path",
    *          type="string",
    *          format="string",
    *          description="replay id",
    *          required=true,
    *      ),
    *      @SWG\Response(
    *          response=200,
    *          description="successful operation",
    *       ),
    *       @SWG\Response(response=400, description="Bad request"),
    *     )
    * ),
    */
}
