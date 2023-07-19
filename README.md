
  <h1 style="top: -6px" >Epic MovieQuotes Project</h1>


---
"MovieQuotes" is a platform that allows users to register, log in, and explore a vast collection of quotes from movies. It provides a seamless experience for movie enthusiasts to discover and appreciate memorable lines and dialogues from their favorite films.

#
### Table of Contents
* [Prerequisites](#prerequisites)
* [Tech Stack](#tech-stack)
* [Getting Started](#getting-started)
* [Migrations](#migration)
* [Development](#development)
* [Project Structure](#project-structure)

#
### Prerequisites

* <img src="readme/assets/php.svg" width="35" style="position: relative; top: 4px" /> *PHP@7.2 and up*
* <img src="readme/assets/mysql.png" width="35" style="position: relative; top: 4px" /> *MYSQL@8 and up*
* <img src="readme/assets/npm.png" width="35" style="position: relative; top: 4px" /> *npm@6 and up*
* <img src="readme/assets/composer.png" width="35" style="position: relative; top: 6px" /> *composer@2 and up*


#
### Tech Stack

* <img src="readme/assets/laravel.png" height="18" style="position: relative; top: 4px" /> [Laravel@6.x](https://laravel.com/docs/10.x) - back-end framework
* <img src="readme/assets/spatie.png" height="19" style="position: relative; top: 4px" /> [Spatie Translatable](https://github.com/spatie/laravel-translatable) - package for translation
* <img src="readme/assets/pusher.png" height="19" style="position: relative; top: 4px" /> [Pusher](https://pusher.com/) - package for real-time notifications
* <img src="readme/assets/sanctum.jpg" height="19" style="position: relative; top: 4px" /> [Laravel Sanctum](https://laravel.com/docs/8.x/sanctum) - package for API authentication
* <img src="readme/assets/socialite.jpg" height="19" style="position: relative; top: 4px" /> [Laravel Socialite](https://laravel.com/docs/10.x/socialite) - package for social authentication

#
### Getting Started
1\. First of all you need to clone E Space repository from github:
```sh
git clone https://github.com/RedberryInternship/dato-papismedovi-epic-movie-quotes-api.git
```

2\. Next step requires you to run *composer install* in order to install all the dependencies.
```sh
composer install
```

3\. after you have installed all the PHP dependencies, it's time to install all the JS dependencies:
```sh
npm install
```

and also:
```sh
npm run dev
```
in order to build your JS/SaaS resources.

4\. Now we need to set our env file. Go to the root of your project and execute this command.
```sh
cp .env.example .env
```
And now you should provide **.env** file all the necessary environment variables:

#
**MYSQL:**
>DB_CONNECTION=mysql
>DB_HOST=127.0.0.1
>DB_PORT=3306
>DB_DATABASE=*****
>DB_USERNAME=*****
>DB_PASSWORD=*****

#
**Pusher:**
>PUSHER_APP_ID=*****
>PUSHER_APP_KEY=*****
>PUSHER_APP_SECRET=*****
>PUSHER_APP_CLUSTER=*****

#
**Sanctum:**
>SANCTUM_STATEFUL_DOMAINS=yourdomain.com
>FRONT_URL=yourdomain.com
>SESSION_DOMAIN=yourdomain.com
#
**SMTP:**
>MAIL_DRIVER=smtp
>MAIL_HOST=smtp.gmail.com
>MAIL_PORT=587
>MAIL_USERNAME=your_email@gmail.com
>MAIL_PASSWORD=your_email_password
>MAIL_ENCRYPTION=tls


after setting up **.env** file, execute:
```sh
php artisan config:cache
```
in order to cache environment variables.

5\. Now execute in the root of you project following:
```sh
  php artisan key:generate
```
Which generates auth key.

6\. Execute in the root of you project following:
```sh
  php artisan storage:link
```
Which creates the symbolic link.

##### Now, you should be good to go!


#
### Migration
if you've completed getting started section, then migrating database if fairly simple process, just execute:
```sh
php artisan migrate
```

#
### Development

You can run Laravel's built-in development server by executing:

```sh
  php artisan serve
```

when working on JS you may run:

```sh
  npm run dev
```
it builds your js files into executable scripts.


#
### Project Structure

```bash
├─── app
|   ├─── Broadcasting
│   ├─── Console
│   ├─── Events
│   ├─── Exceptions
│   ├─── Http
│   ├─── Models
│   ├─── Providers
├─── bootstrap
├─── config
├─── database
├─── lang
├─── node-modules
├─── public
├─── resources
├─── routes
├─── storage
├─── tests
- .env
- artisan
- composer.json
- package.json
- phpunit.xml
```

Project structure is fairly straitforward(at least for laravel developers)...

For more information about project standards, take a look at these docs:
* [Laravel](https://laravel.com/docs/10.x)

[DrawSQL link](https://drawsql.app/teams/datos-team-2/diagrams/epic-movie-quotes)

<img src="readme/assets/drawSql.png" style="position: relative; top: 4px" />