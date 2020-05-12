#                   xlarge
####    Xarge project back-end with Laravel
#

## Project structure:
### Project will contain 4 models
#
#### 1)	Post
    •	Id
    •	Title			=> string
    •	Content		    => text
    •	Status			=> Boolean  ( private or public )
    •	Image			=> string , image
    •	User_id		    => ones to many relation with User
    •	Category_id		=> one to many relation with Category
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
    •	Content		=> text
    •	Post_id		=> one to many relation with Post
    •	User_id		=> one to many relation with User
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
#### 3- setup your .env file for database info and app key
#### 3- in Project folder run this comands
    •	$ php artisan migrate
    •	$ composer dump-autoload
    •	$ php artisan db:seed
    •	$ php artisan serve
#### 4- go to http://127.0.0.1:8000 in your browser you will see wellcome screen
##
## Json Api Services (index and show)
###    Posts Api
####   All posts
#####  http://127.0.0.1:8000/api/posts/       

