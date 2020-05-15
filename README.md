# xlarge API
####    Xarge project back-end with Laravel
## Project structure:
### Project will contain 4 models
#### 1)	Post
    •	Id
    •	Title           => string|required|max:255
    •	Content         => string|required|max:10000
    •	Status          => boolean  ( private or public )
    •	Image           => nullable|image
    •	User_id         => one to many relation with User
    •	Category_id     => one to many relation with Category
    
    "post": {
        "id": 1 
        "status": "1",  // boolean 0 for private 1 for public | unrequired defualt = 1
        "title": "title", // string | required
        "content": "this is a content", // string | required
        "image": "images/km7rXaP60hQdnH7Uw7l3K5x8LbbqCRhT3R6VX2Ld.jpeg", // image file | unrequired defualt = null
        "user_id": "1", // number | urequired | default user id login
        "category_id": "1", // number | urequired | unrequired defualt = null
        "updated_at": "2020-05-15T12:37:13.000000Z",
        "created_at": "2020-05-15T12:37:13.000000Z",
    }
    
#### 2)	User
    •	Id
    •	Name            => string|required|max:255|min:3
    •	Email           => email|required|unique
    •	Password        => required', 'min:6', 'confirmed'  => password_confirmed
    •	Rule            => in:0,1,2,3 | 0 = user , 1 = author , 2 = editor , 3 = admin 
    •	Image           => required|image
#### 3)	Comment
    •	Id
    •	Content         => required|max:1000|min:1
    •	Post_id         => one to many relation with Post
    •	User_id         => one to many relation with User
#### 4)	Category
    •	Id
    •	Name            => required|max:255|min:3|unique
    •	Description     => required|min:3|max:1000
    •	Parent          => nullable | Category_id  , one to many relation with Category
####  //Tag can added in future
--------------------------------------------------
### How To Use
#### 1- make sure you have Compuser and Laravel and mysql in you machine
#### 2- Download Project or Clone It
#### 3- rename .env.example to .env and create new database and set DBs name & MySQl user & MySQl password in this file
#### 4- in Project folder run this comands
    •	$ composer install
    •	$ php artisan key:generate
    •	$ php artisan migrate
    •	$ php artisan db:seed
    •	$ php artisan serve
#### 5- go to http://127.0.0.1:8000 in your browser you will see wellcome screen
--------------------------------------------------
### Json API Services [Get]
                    
| Action  | Url  | response |
| ------------- | ------------- | ----------- |
| get all posts       | http://127.0.0.1:8000/api/posts             | json data |
| get single post     | http://127.0.0.1:8000/api/posts/{id}        | json data |
| get all users       | http://127.0.0.1:8000/api/users             | json data |
| get single user     | http://127.0.0.1:8000/api/users /{id}       | json data 
| get all categories  | http://127.0.0.1:8000/api/categories        | json data |
| get single category | http://127.0.0.1:8000/api/categories/{id}   | json data |
| get all comments    | http://127.0.0.1:8000/api/comments          | json data |
| get single comment  | http://127.0.0.1:8000/api/comments/{id}     | json data |

### Json API Services action [CRUD]
                    
| Action  | Url  | method |
| ------------- | ------------- | ---------|
| add post    | http://127.0.0.1:8000/api/posts         | post|  
| edit post   | http://127.0.0.1:8000/api/posts/{id}    | patch |
| delete post | http://127.0.0.1:8000/api/users/{id}    | delete |
| add user    | http://127.0.0.1:8000/api/posts         | post |
| edit user   | http://127.0.0.1:8000/api/posts/{id}    | patch |
| delete user | http://127.0.0.1:8000/api/users/{id}    | delete |
| add category    | http://127.0.0.1:8000/api/posts         | post |  
| edit category   | http://127.0.0.1:8000/api/posts/{id}    | patch |
| delete category | http://127.0.0.1:8000/api/users/{id}    | delete |
| add comment    | http://127.0.0.1:8000/api/posts         | post |
| edit comment   | http://127.0.0.1:8000/api/posts/{id}    | patch |
| delete comment | http://127.0.0.1:8000/api/users/{id}    | delete |

### Json API action [CRUD] request
`you need to send request with all required model data at least check model info`

### Json API action [CRUD] response
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

