Role Playing Game Based On Symfony
==================
### Requirements for the project
- php7.0 or higher 
- Mysql 5.7 or higher
- Symfony3

### Extra used bundles 
- [LexikJWTAuthenticationBundle](https://github.com/lexik/LexikJWTAuthenticationBundle)
- [FOSRestBundle](http://symfony.com/doc/current/bundles/FOSUserBundle/index.html)
- [DoctrineMigrationsBundle](http://symfony.com/doc/current/bundles/DoctrineMigrationsBundle/index.html)

### Installation
git clone the project first 

```bash
composer install
```

This project uses [Json Web Token](https://jwt.io/introduction/)(JWT) for authentication, so we need to sign the tokens and rsa used for that.

We need to generate a ssh keys : 
 ```bash
 $ mkdir -p var/jwt
 $ openssl genrsa -out var/jwt/private.pem -aes256 4096
 $ openssl rsa -pubout -in var/jwt/private.pem -out var/jwt/public.pem
 ```
And the configuration added in `config.yml`
```yml
lexik_jwt_authentication:
    private_key_path: '%jwt_private_key_path%'
    public_key_path:  '%jwt_public_key_path%'
    pass_phrase:      '%jwt_key_pass_phrase%'
    token_ttl:        '%jwt_token_ttl%'
```
*It's not a good idea to share those keys for security reasons so i removed them from git .* 

Run after that the migrations
```bash
$ ./bin/console doctrine:migrations:migrate  
```
 
### How this work 
The story will be like the following :
- The user should first register to our api and get a valid token. 
- Also if the user is returned user can login and get a valid token also.
- The user then create a role character ( like Batman or Wonder woman etc ) with two paramters attack and defense 
- Every user should have only one character for now, may be implement a feature in the future to let every user to have many characters 
- The user then consume our api to explore to search for the users with ready characters for fight, that leed us to define the main statues for our characters 
- Every character should have four main statuses ( 'ready', 'paused', 'attacked', 'defeated' )
 - `ready` status is when the character is ready for fight 
 - `paused` status is when the user want to save the current status and complete later the fighting 
 - `attacked` this status is applied when the user is attacked from other user and that also will change another column called `turn` to 1 which means that the user is attacked and got the next turn to attack other users.
 - `defeated` is status for the chatacter when his defense is equal to zero, and it's means offcourse that the user is defeated . 
 - Let's return back to the process of exploring for a new characters ready for fighting, so in this case we list the current characters with status ready 
 - After that we consume another api to attack other character, by applying the attack we subtract 2 points from the defense of the character and give other character the turn to attack this attacking character or ignore this character and attack other ready characters .
 - The battle is finished when the character has no other points, so the status changed to `defeated`.
 - Imagine this battle as the famous wrestling match [hell in the cell](https://en.wikipedia.org/wiki/Hell_in_a_Cell), where there is many players in the same cage but any of them have the opportunity to escape from the cage ( by pausing or saving ) :) .

### Code Structure
All files in `src/Oaattia/RoleBaseGameBundle`
- `Command` contain the command console for our application 
- `Controller` contains the controllers 
- `DependencyInjection` Dependency Injection related file that shipped with symfony 
- `Domain Manager` The project orgranized around Domain Manager DDD ( domain driven design ) that split the interaction with the database to external domain 
- `Entity`
- `Exceptions` to add all the exception classes related to our project.
- `Repository` to perform queries to the database 
- `Request` to handle the requests for specific request related to the controller, and see the data before presisting it 
- `Resources`
- `Security`
- `Tests`
- `Transformers` this classes used to map the result for the response to specific values 
- `Validators` this class responsible for handle the validations errors 

 ### Database structure
 - ser 
   * id
   * email
   * password
   * created_at
   * updated_at
- character
   * id
   * user_id
   * title
   * attack
   * defense
   * status 
   * next_turn
   * created_at
   * updated_at
 
### API Documentation

### Tests

### Commands

### FrontEnd App ( ReactJS ) 
