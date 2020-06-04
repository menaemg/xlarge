# XLarge API
#### XLarge project back-end with Laravel

-----------------------------------------------
### How To Use
#### 1- make sure you have Compuser and Laravel and mysql in you machine
-   a download and setup [xampp](https://www.apachefriends.org/download.html)
-   download and setup composer [composer](https://getcomposer.org/download/)
       run apachi and mysql in xampp
-   go to http://localhost/phpmyadmin in your browser
-   create new database name [xlarge] with utf-8-genral-c
#### 2- Download Project or Clone It
#### 3- create .env file from .env.example and set database name [xlarge]   and username [root] , with blank password '' .
#### 4- in Project folder run this comands
    •	$ composer install
    •	$ php artisan key:generate
    •	$ php artisan migrate
    •	$ php artisan db:seed
    •	$ php artisan passport:install
    •	$ php artisan storage:link
    •	$ php artisan serve
#### 5- go to http://127.0.0.1:8000 in your browser you will see homepage!
--------------------------------------------------
## Api Documentation
`for all information you need to use api system`

-	go to http://127.0.0.1:8000/api/docs after setup project for Api Documentation
-	get postman json collection [postman.json](public/postman.json)
------------------------------------------------------------------------
## Project structure:
### Project will contain 6 models
#### 1)	Post
    •	Id
    •	Title           => string|required|max:255
    •	Content         => string|required|max:10000
    •	Status          => boolean  ( private or public )
    •	Image           => nullable|image
    •	views           => number
    •	User_id         => one to many relation with User
    •	Category_id     => one to many relation with Category
##### json data
```javascript
    "post": {
        "id": 1 
        "status": "1",  // boolean 0 for private 1 for public | unrequired defualt = 1
        "title": "title", // string | required
        "content": "this is a content", // string | required
        "image": "images/km7rXaP60hQdnH7Uw7l3K5x8LbbqCRhT3R6VX2Ld.jpeg", // image file | unrequired defualt = null
        "user_id": "1", // number | urequired | default user id login
        "category_id": "1", // number | urequired | unrequired defualt = null
        "views": "5",       // post views counter
        "updated_at": "2020-05-15T12:37:13.000000Z",
        "created_at": "2020-05-15T12:37:13.000000Z",
    }
```
#### 2)	User
    •	Id
    •	Name            => string|required|max:255
    •	Email           => email|required|unique
    •	Password        => required', 'min:6', 'confirmed'  => password_confirmed
    •	Rule            => in:0,1,2,3 | 0 = user , 1 = author , 2 = editor , 3 = admin 
    •	Image           => required|image
##### json data
```javascript
    "user": {
        "id": 1
        "name": "abdalomnaem",  // required | max:255
        "email": "menaem@test.com", // required 
        "image": "images/msqyYigGPP9om3ucO24ACfzJXxd3y2iok3PSEZYG.jpeg", // image file | nullable 
        "rule": "3", // unrequired | default = 0
        "updated_at": "2020-05-15T15:11:25.000000Z",
        "created_at": "2020-05-15T15:11:25.000000Z"
    }
```
#### 3)	Comment
    •	Id
    •	Content         => required|max:1000
    •	Post_id         => one to many relation with Post
    •	User_id         => one to many relation with User
##### json data
```javascript
    "comment": {
        "id": 1
        "content": "this is a comment", // Required | string
        "user_id": "9",                 // number | Required
        "post_id": "9",                 // number | Required 
        "updated_at": "2020-05-15T19:34:57.000000Z",
        "created_at": "2020-05-15T19:34:57.000000Z",
    }
```
#### 4)	Category
    •	Id
    •	Name            => required|max:255|unique
    •	Description     => nullable|max:1000
    •	Parent          => nullable | Category_id  , one to many relation with Category
##### json data
```javascript
    "Category": {
        "id": 1,
        "subfrom": null, // id of parent category | nullable
        "name": "html", // string | required | unique
        "description": "description", // string | required | unique
        "updated_at": "2020-05-15T15:46:46.000000Z",
        "created_at": "2020-05-15T15:46:46.000000Z"
    }
```
#### 5)	Replay
    •	Id
    •	Content         => required|max:1000
    •	Comment_id      => one to many relation with Post
    •	User_id         => one to many relation with User
##### json data
```javascript
    "Replay": {
        "id": 1
        "content": "this is a replay to comment",   // Required | string
        "comment_id": "9",                          // number | Required
        "post_id": "9",                             // number | Required 
        "updated_at": "2020-05-15T19:34:57.000000Z",
        "created_at": "2020-05-15T19:34:57.000000Z"
    }
```
#### 6)	Likes
    •	Id
    •	post_id         => one to many relation with Post
    •	User_id         => one to many relation with User
##### json data
```javascript
    "likes": {
        "id": 304
        "user_id": "3",     // number | Required
        "post_id": "3",     // number | Required 
        "updated_at": "2020-05-19T07:58:53.000000Z",
        "created_at": "2020-05-19T07:58:53.000000Z",
    }
```
--------------------------------------------------
####  Tag can added in future
--------------------------------------------------
### Json API Services for public data [Get]
                    
| Action  | Url  | response |
| ------------- | ------------- | ----------- |
| get all posts       | http://127.0.0.1:8000/api/posts                 | json data |
| get single post     | http://127.0.0.1:8000/api/posts/show/{id}       | json data |
| get all users       | http://127.0.0.1:8000/api/users                 | json data |
| get single user     | http://127.0.0.1:8000/api/users/show/{id}       | json data 
| get all categories  | http://127.0.0.1:8000/api/categories            | json data |
| get single category | http://127.0.0.1:8000/api/categories/show/{id}  | json data |
| get all users    | http://127.0.0.1:8000/api/users                    | json data |
| get single user  | http://127.0.0.1:8000/api/users/{id}               | json data |

### Json API action [CRUD] request
`you need to send request with all required model data at least check model info`
`check api Documentation for more information`
### Json API action response
```javascript
{
    "status": 1,        // Boolean 1 for success 0 for fail
    "message": "post created successfully", // message for action
    "data": {           // model data
        "status": "1",
        "user_id": "9",
        "category_id": "9",
        "title": "title",
        "content": "this is a content",
        "image": "images/km7rXaP60hQdnH7Uw7l3K5x8LbbqCRhT3R6VX2Ld.jpeg",
        "updated_at": "2020-05-15T12:37:13.000000Z",
        "created_at": "2020-05-15T12:37:13.000000Z",
        "id": 11
    }
}
```

