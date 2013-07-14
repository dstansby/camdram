
#node['composer']['install_globally'] = false
#include_recipe "composer"
#execute "install PHP composer for Symfony dependency management" do
#  command "php composer.phar install"
#  action :run
#  cwd node['camdram']['docroot']
#end

node['symfony2']['user'] = 'vagrant'
node['symfony2']['group'] = 'vagrant'
include_recipe "symfony2"
repo_path = '/var/www/camdram/'

symfony2_console "Create schema" do
  action :cmd
  command "doctrine:schema:update --force"
  path repo_path
end
symfony2_console "Load data fixtures" do
  action :cmd
  command "doctrine:fixtures:load"
  path repo_path
end

#Do the same in the test environment
symfony2_console "Create test database schema" do
  action :cmd
  command "doctrine:schema:update --force"
  env 'test'
  path repo_path
end
symfony2_console "Load test database data fixtures" do
  action :cmd
  command "doctrine:fixtures:load"
  env 'test'
  path repo_path
end
