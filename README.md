#                   xlarge
####    Xarge project back-end with Laravel
#
#
## Project structure:
### Project will contain 4 models
#
#### 1)	Post
    •	Id
    •	Title           => string|required|min:3|max:255
    •	Content         => string|required|min:3|max:10000
    •	Status          => boolean  ( private or public )
    •	Image           => required|image
    •	User_id         => ones to many relation with User
    •	Category_id     => one to many relation with Category
#
#### 2)	User
    •	Id
    •	Name			=> string|required|max:255|min:3
    •	Email			=> email|required|unique
    •	Password		=> required', 'min:6', 'confirmed'  => password_confirmed
    •	Rule			=> in:0,1,2,3 | 0 = user , 1 = author , 2 = editor , 3 = admin 
    •	Image			=> required|image
#
#### 3)	Comment
    •	Id
    •	Content		    => required|max:1000|min:1
    •	Post_id		    => one to many relation with Post
    •	User_id		    => one to many relation with User
#
#### 4)	Category
    •	Id
    •	Name			=> required|max:255|min:3|unique
    •	Description		=> required|min:3|max:1000
    •	Parent			=> nullable | Category_id  , one to many relation with Category
#
####  //Tag can added in future
#
#
### How To Use
#
#### 1- make sure you have Compuser and Laravel and mysql in you machine
#### 2- Download Project or Clone It
#### 3- rename .env.example to .en and create new database and set DBs name & MySQl user & MySQl password in this file
#### 4- in Project folder run this comands
    •	$ composer install
    •	$ php artisan appkey:genurate
    •	$ php artisan migrate
    •	$ composer dump-autoload
    •	$ php artisan db:seed
    •	$ php artisan serve
#### 5- go to http://127.0.0.1:8000 in your browser you will see wellcome screen
##
## Json Api Services (index and show and delete)
### Posts Api
    •	All posts           /api/posts/                     method:get
    •	One Post            /api/posts/{id}                 method:get
    •	Create Post         /api/posts                      method:post         respond:'success' or array with errors
    •	Edit Post           /api/posts{id}                  method:put          respond:'success' or array with errors
    •	Delete Post         /api/posts/delete/{id}          method:delete
### Users Api
    •	All Users           /api/users                      method:get
    •	One User            /api/users/{id}                 method:get
    •	Create User         /api/users                      method:post         respond:'success' or array with errors
    •	Edit User           /api/users/{id}                 method:put          respond:'success' or array with errors
    •	Delete User         /api/users/delete/{id}          method:delete
### Categories Api
    •	All Categories      /api/categories                 method:get
    •	One Category        /api/categories/{id}            method:get
    •	Create Category     /api/categories                 method:post         respond:'success' or array with errors
    •	Edit Category       /api/categories/{id}            method:put          respond:'success' or array with errors
    •	Delete Cartegory    /api/categories/delete/{id}     method:delete
### Comments Api
    •	All Comments        /api/comments                   method:get
    •	One Comment         /api/comments/{id}              method:get
    •	Create Comment      /api/comments                   method:post         respond:'success' or array with errors
    •	Edit Comment        /api/comments/{id}              method:put          respond:'success' or array with errors
    •	Delete Comment      /api/comments/delete/{id}       method:delete
