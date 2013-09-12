#Booj.com Repo

##Setup GIT repo on the live server.
	To setup the inital GIT repon on the live server you will need to 
	SSH into the live server and run the following commands from your terminal:
	$ git --bare init
	$ git init
	$ git remote add origin git://github.com/ActiveWebsite/booj-website.git
	$ git pull origin master


##To update this repo SSH on the live server:
	SSH to the live server and run the following command from your terminal:
	$ git pull origin master


Whenever we do a push that involves updated css of js files make sure you update the build version so help clear out any cache. Go to application/config/application.php and increment the 'build_version' => 'build-4'.

##Laravel 3 Documentation

[http://three.laravel.com/docs](http://three.laravel.com/docs).

##Forking the Repo

* Create your own github account. 
* Open up the repo on booj and click the fork button. 
* Clone the fork to your computer

