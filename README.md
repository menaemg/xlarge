#                   xlarge
####    Xarge project back-end with Laravel
#
#
## Project structure:
### Project will contain 4 models
#
#### 1)	Post
    •	Id
    •	Title           => string
    •	Content         => text
    •	Status          => Boolean  ( private or public )
    •	Image           => string , image
    •	User_id         => ones to many relation with User
    •	Category_id     => one to many relation with Category
#
#### 2)	User
    •	Id
    •	Name			=> string
    •	Email			=> string , email
    •	Password		=> string
    •	Role			=> in ( 0 , 1 , 2 , 3 ) | 0 = user , 1 = author , 2 = editor , 3 = admin 
    •	Image			=> string , image
#
#### 3)	Comment
    •	Id
    •	Content		    => text
    •	Post_id		    => one to many relation with Post
    •	User_id		    => one to many relation with User
#
#### 4)	Category
    •	Id
    •	Name			=> string
    •	Description		=> text
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
    •	Delete Post         /api/posts/delete/{id}          method:delete
### Users Api
    •	All Users           /api/users                      method:get
    •	One User            /api/users/{id}                 method:get
    •	Delete User         /api/users/delete/{id}          method:delete
### Categories Api
    •	All Categories      /api/categories                 method:get
    •	One Category        /api/categories/{id}            method:get
    •	Delete Cartegory    /api/categories/delete/{id}     method:delete
### Comments Api
    •	All Comments        /api/comments                   method:get
    •	One Comment         /api/comments/{id}              method:get
    •	Delete Comment      /api/comments/delete/{id}       method:delete
