# Igny Vallee Comestible

Projet MIN 4A de refonte du site web de l'association de Igny vallée comestible. 
Fonctionnalités techniques :
  
 ## Contexte du projet:
 
 Projet réalisé en 2020 au cours de ma quatrième année qui correspond à ma première année en cursus informatique et numérique.  

### Language BackEnd : Php
- Framework Symfony v5.0.7

### Language FrontEnd : HTML/CSS/JS

- Framework Bootstrap v4.4.1

 ## Installation du projet
    
        git clone
        composer install
        yarn install
        
        symfony serve -d
  - Il faut aussi se connecter au serveur VPS avec le mot de passe du serveur qui ne peut pas être divulgué ou via cygwin toujours avec un mdp privé. 
        
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
         
### Equipe : 
 
 Ce projet à été réalisé par les étudiants suivants: 

 - BOUEY Perrine
 - CHARLET Solène
 - DELLA SETA Raphaël
 - DELPECHE Vincent
 - GUICHARD Ingrid (moi-même)
 - ORTEGA COLLADO Elena
