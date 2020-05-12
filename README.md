# xlarge
Xarge project back-end with Laravel


# Project structure:
## Project will contain 4 models

### 1)	Post
    •	Id
    •	Title			=> string
    •	Content		=> text
    •	Status			=> Boolean  ( private or public )
    •	Image			=> string , image
    •	User_id		=> ones to many relation with User
    •	Category_id		=> one to many relation with Category

2)	User
    •	Id
    •	Name			=> string
    •	Email			=> string , email
    •	Password		=> string
    •	Role			=> in ( 0 , 1 , 2 , 3 ) | 0 = user , 1 = author , 2 = editor , 3 = admin 
    •	Image			=> string , image

3)	Comment
    •	Id
    •	Content		=> text
    •	Post_id		=> one to many relation with Post
    •	User_id		=> one to many relation with User

4)	Category
    •	Id
    •	Name			=> string
    •	Description		=> text
    •	Parent			=> nullable | Category_id  , one to many relation with Category

//Tag can added in future

