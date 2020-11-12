# Igny Vallee Comestible

Projet MIN 4A de refonte du site web de l'association de Igny vallée comestible
Fonctionnalités techniques :
  
  
 ### Language BackEnd : Php
- Framework Symfony v5.0.7

### Language FrontEnd : HTML/CSS/JS

- Framework Bootstrap v4.4.1

## Serveur VPS
Serveur Epf :

        Login / password : min / igny2020;
        Connexion : ssh -l min -p 2243 min.epf.fr

        URL : https://igny.min.epf.fr/ (redirigé vers le port 80 du serveur)

### Comment se connecter avec Cygwin

        ssh min@min.epf.fr -p 2243
   ensuite rentrer le mdp : 
        
        igny2020;


 ## Installation du projet
    
        git clone
        composer install
        yarn install
        
        symfony serve -d
        
   ## Mettre à jour le build css et js du projet
   
        yarn watch
        
   ### Version des outils
   
   NodeJs
   
        node -v
        v12.16.2
        
   Yarn
       
        yarn -v
        1.22.4
        
     
## Création de la base de données
     
        php bin/console doctrine:database:create
        
## Mise à jour 
        
        php bin/console doctrine:schema:update --force
        
## Créer une migration

        php bin/console make:migration
        
## Déployer la migration       

         php bin/console doctrine:migrations:migrate 