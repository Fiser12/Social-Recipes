# This file is part of the Php DDD Standard project.
#
# Copyright (c) 2017 LIN3S <info@lin3s.com>
#
# For the full copyright and license information, please view the LICENSE
# file that was distributed with this source code.
#
# @author Gorka Laucirica <gorka.lauzirika@gmail.com>
# @author Beñat Espiña <benatespina@gmail.com>
# @author Jon Torrado <jontorrado@gmail.com>

######################################################################
# Setup Server
######################################################################
server "192.168.0.29", user: "fiser", roles: %w{web}
set :deploy_to, "/home/fiser/WebSocialRecipes"
set :env,  "dev"

SSHKit.config.command_map[:composer] = "php #{shared_path.join("composer.phar")}"

######################################################################
# Capistrano Symfony - https://github.com/capistrano/symfony/#settings
######################################################################
set :file_permissions_users, ['www-data']
set :webserver_user, "www-data"

######################################################################
# Setup Git
######################################################################
set :branch, "master"

set :symfony_env, "prod"
set :composer_install_flags, '--no-interaction'
set :controllers_to_clear, []
