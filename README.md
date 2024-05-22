# Car renting backend app

A Restfull API to manage renting cars with different user roles
## Endpoints

No auth Endpoints
```bash
/api/login {POST}
/api/register {POST}
```
auth Endpoints
```bash
/api/me {GET}
/api/logout {POST}
/api/cars {GET}
/api/cars/{id} {GET}
/api/cars {POST}
/api/cars/{id} {PUT}
/api/cars/{id} {DELETE}
/api/reservations {GET}
/api/reservations/{id} {GET}
/api/reservations {POST}
/api/reservations/{id} {PUT}
/api/reservations/{id} {DELETE}
```
## database structure
#### users([id](#), username, name, email, email_verified_at, password, role, telephone, cin, num_permis	, remember_token	, created_at, updated_at)
#### cars([id](#), photo, nom	, carburant, matricule, prix, nombre_place, created_at, updated_at)
#### reservations([id](#), date_debut, date_fin, created_at, updated_at, #car_id, #user_id)	
## How to run this project
### Windows users:
- Download wamp: http://www.wampserver.com/en/
- Download and extract the project
- Update windows environment variable path to point to your php install folder (inside wamp installation dir) (here is how you can do this http://stackoverflow.com/questions/17727436/how-to-properly-set-php-environment-variable-to-run-commands-in-git-bash)
 

cmder will be refered as console

### Mac Os, Ubuntu and windows users continue here:
- Create a database locally named `rentcar` utf8_general_ci (even if you don't it won't be a problem) 
- Download composer https://getcomposer.org/download/
- Pull Laravel/php project from git provider.
- Rename `.env.example` file to `.env`inside your project root and fill the database information.
  (windows wont let you do it, so you have to open your console cd your project root directory and run `mv .env.example .env` )
- Open the console and cd your project root directory
- Run `composer install` or ```php composer.phar install```
- Run `php artisan key:generate` 
- Run `php artisan migrate`
- Run `php artisan db:seed` to run seeders, if any.
- Run `php artisan serve`

##### You can now access your project at localhost:8000 :)

### If for some reason your project stop working do these:
- `composer install`
- `php artisan migrate`