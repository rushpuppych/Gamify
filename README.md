# Gamify

The Gamify Application (Framework) was coded because we didnt found something like that on the internet. We wantet do have a powefull motivation tool with full controll over the code. It can be used for research reason or as a business tool.

Gamification is the idea of adapting the concepts of gaming with reallife business cases. It is the technique of extracting the motivators from games (for example: level system, item systems, scoreboards, archievements, challenge) and adding them to business tasks. This application is helping you if you want to add some gamification to your business.

## Getting Started

These instructions will get you a copy of the project up and running on your local machine for development and testing purposes. See deployment for notes on how to deploy the project on a live system.

### Prerequisites

To get Gamify working you need a PHP environment. So first of all you need to install a PHP Webserver and a MySQL Database Server. If you don't have this installed try to install the XAMPP package.

```
PHP Webserver
MySQL Server
```

### Installing

To Install Gamify on your WebServer follow this instructions:

Clone the Gamify Project in your webroot.

```
git clone https://github.com/rushpuppych/Gamify.git
```

Install PHP Vendor

```
composer update
```

Create Database on your MySQL Server and execute install script:

```
Gamify/docs/INSTALL_SCRIPT.sql
```

### Configuration

Now you need to Config the Gamify Application. Open the script Gamify/lib/global.php

First of all set a new salt (keep this secret!).

```
$arrConfig['security']['salt'] = 'ThisShouldBeASecret!';
```

Then set the impressum informations. In some countries this is needet to host a webapp.

```
$arrConfig['page']['impressum_info'] = 'Gamify Portal der Klasse HE16<br>';
$arrConfig['page']['impressum_logo'] = 'http://www.todo-gmbh.ch/wp-content/uploads/Referenzen/referate/hf-ict.png';
$arrConfig['page']['impressum_name'] = 'Höhere Fachschule HF-ICT';
$arrConfig['page']['impressum_street'] = 'Gründenstrasse 46';
$arrConfig['page']['impressum_place'] = 'CH-4132 Muttenz';
$arrConfig['page']['impressum_website'] = 'www.hf-ict.ch';
$arrConfig['page']['impressum_email'] = 'info@hf-ict.ch';
$arrConfig['page']['impressum_phone'] = '+41 (0) 61 552 94 94';
```

Then configurate the MySQL Config.

```
$arrConfig['database']['database'] = 'gamify';
$arrConfig['database']['host'] = 'localhost';
$arrConfig['database']['user'] = 'root';
$arrConfig['database']['password'] = '';
$arrConfig['database']['port'] = 3306;
```

Then set the correct server root (this is very emportant)

```
$arrConfig['server']['root_path'] = 'http://localhost:8080/Gamify';
```

Now you have to configurate the SMTP config.

```
$arrConfig['mail']['host'] = '';
$arrConfig['mail']['smtp_auth'] = true;
$arrConfig['mail']['username'] = '';
$arrConfig['mail']['password'] = '';
$arrConfig['mail']['smtp_secure'] = 'tls';
$arrConfig['mail']['port'] = 587;
$arrConfig['mail']['enable_email_notification'] = true;
```

The next step is to config the Battle behaviour.

```
$arrConfig['game']['create_quests'] = 'all'; // all = All can create ['1','2'] = Only Account 1 and 2 can create quests
$arrConfig['game']['battle_time_from'] = '08:00';
$arrConfig['game']['battle_time_to'] = '17:00';
$arrConfig['game']['battle_days'] = 'xxxxx--'; // x = Battle day, - = No Battle day
```

## Authors & Credits

The Gamify project was developed in 2018 as a schoolar project. The goal behind the Gamify project was to realize a relational database driven application. So we decided to develop something usefull that is still tricky to manage.

* **Mario Bruderer** - *Projectmanager*
* **Andreas Dattilo** - *Database Administrator*
* **Severin Holm** - *Web Developer* - [Rushpuppy](https://github.com/rushpuppych)

* **Marc Löwenthal** - *Database Instructor, Assessment Leader (hf-ict.ch)*
* **Italian John Doe** - *For the invention of Coffe and Pizza (it wouldn't be possible without you)*

## License

This project is licensed under the MIT License - see the [LICENSE.md](LICENSE.md) file for details

## Acknowledgments

* **Text Logos** - *Fraction Logos* - [Logo Generator](https://textcraft.net/">https://textcraft.net/)
* **Sprites** - *Chharacter Sprites* - [Sprite Resource](http://charas-project.net/">http://charas-project.net/)
