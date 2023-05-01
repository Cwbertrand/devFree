     
### INFRA avec DOCKER (ngnix, php, mysql, phpmyadmin)
```   
Si vous voulez utiliser l'infra de docker,         
copier/coller le fichier infra/docker-compose.override.yml à la racine du projet    
le fichier docker-compose.override.yml à la racine du projet est par défaut dans le .gitiginore
                                                                                                                                                 
PhpMyAdmin:
http://127.0.0.1:8080
login: root                                    
mot de passe: root       
```

### MAILCATCHER via DOCKER + SI INFRA           
```
Lancer la commande suivant à la racine du projet:                                                       
$ docker compose up --build               
```  

### Installer les dépendances/vendor    
```
$ composer install  
```

### Installer les dépendances/node_modules    
#### Si vous utilisez npm   
```
$ npm install
```
#### Si vous utilisez yarn   
```
$ yarn install
$ yarn add file-loader@^6.2.0 --dev
```

### Fichier environnement  
Copier et coller le fichier __.env__ à la racine du projet  
Renommer la copie en __.env.local__  

### Configurer le fichier .env.local avec vos identifiants SQL  
```
PhpMyAdmin avec docker                  
DATABASE_URL="mysql://root:root@127.0.0.1:3306/location-domain?serverVersion=8&charset=utf8mb4"         

Avec wamp, xamp, mamp
DATABASE_URL="mysql://root:@127.0.0.1:3306/location-domain?serverVersion=8&charset=utf8mb4" 
```

### Créer la database   
```
$ symfony console doctrine:database:create   
```
    
### Ajouter les entités à la database    
```
$ symfony console make:migration  
$ symfony console doctrine:migrations:migrate  
```
     
### Installer la configuration des tables   
```
$ symfony console doctrine:fixtures:load
```

### Lancer le server  
```
$ symfony server:start  
```             


- make a boilerplate for twig extension : `symfony console make:twig-extension`
- install bundle simgpleimage `composer require claviska/simpleimage`