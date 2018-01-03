#Previously local Preparation for Mac OS X
##### Update composer and GEM
    - composer update
    - composer upgrade
    - sudo gem update
##### Install homebrew dependencies
    - brew install npm
    - brew install yarn

##### Install in the src/App/Infraestructure/Ui/Assets 
    - npm install -g stylelint
    - npm install -g eslint-plugin-class-property eslint-plugin-react eslint-plugin-babel babel-eslint
    - sudo npm update
    - sudo npm install
    - sudo npm run-script build
##### Prepare dependencies of capistrano
    - sudo gem install capistrano
    - sudo gem install capistrano-symfony

#Server Prepartion
##Install the prerrequisites
#####Install Apache
* sudo add-apt-repository ppa:ondrej/php
* sudo apt update
* sudo apt install php7.1 zip unzip php7.1-zip
#####Enabled dependencies
* sudo a2enmod proxy_fcgi setenvif
* sudo a2enconf php7.0-fpm
#####Install dependencies of php
* sudo apt install php-mysql
* sudo apt-get install php-xml

##Prepare capistrano in the server
* Previusly in local: ssh-add -K ~/.ssh/id_rsa
* Execute for first time the deploy: cap prod deploy --trace
* Create the files in share folder using dist files
    * /home/cloud/WebSocialRecipes/shared/parameters.yml
    * /home/cloud/WebSocialRecipes/shared/src/App/Infrastructure/Ui/Http/Symfony/.htaccess 
    * /home/cloud/WebSocialRecipes/shared/src/App/Infrastructure/Ui/Http/Symfony/robots.txt

##### Conect the database
###### Prepare database
    sudo apt-get install mariadb-server
    mysql -u root -p
        use mysql
        update user set password=PASSWORD("NYhTJTTsXRfWYcrQQ6iRaWae") where User='root';
        CREATE DATABASE social-recipes-bd;
###### Set in parameters.yml in the server this data
    database_host: 127.0.0.1
    database_port: 3306
    database_name: social_recipes_bd
    database_user: root
    database_password: NYhTJTTsXRfWYcrQQ6iRaWae

##### Prepare apache2 in server
    - Agregar fichero /etc/apache2/sites-available/social-recipes.conf
    - sudo a2ensite social-recipes.conf
    - sudo apache restart
    - chmod -R 777 /home/cloud/WebSocialRecipes/shared/var
    

