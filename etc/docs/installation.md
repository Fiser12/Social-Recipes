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
    * /shared/parameters.yml
    * /shared/src/App/Infrastructure/Ui/Http/Symfony/.htaccess 
    * /home/cloud/WebSocialRecipes/shared/src/App/Infrastructure/Ui/Http/Symfony/robots.txt
