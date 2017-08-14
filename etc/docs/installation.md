#Local Preparation
1. composer update
2. composer upgrade
3. sudo gem update
4. brew install npm
5. In the src/App/Infraestructure/Ui/Assets 
    - npm install -g stylelint
    - npm install -g eslint-plugin-class-property eslint-plugin-react eslint-plugin-babel babel-eslint
    - sudo npm update
    - sudo npm install
    - sudo npm run-script build
6. sudo gem install capistrano
7. sudo gem install capistrano-symfony
8. brew install yarn

#Server Prepartion

* sudo apt install php7.1 zip unzip php7.1-zip
* sudo a2enmod proxy_fcgi setenvif
* sudo a2enconf php7.0-fpm
* sudo apt-get install php7.0-mysql