####Database config

Database name in config file is "articlemanagement".
In folder root you can find migration script which
you can run for creating tables.

####View paths

I managed to create only login and registration client sides.
To login and register, please enter "/users/login" as broswer
url.

####User login and registration
To test the application please run the following CURLs.

#####Userlogin

curl -X POST \
  http://articlemanagement.dev/api/users/login \
  -H 'cache-control: no-cache' \
  -H 'content-type: application/x-www-form-urlencoded' \
  
#####UserRegistration
  
  curl -X POST \
    http://articlemanagement.dev/api/users/register \
    -H 'cache-control: no-cache' \
    -H 'content-type: application/x-www-form-urlencoded' \

#####Get all articles of the logged in user
curl -X GET \
  http://articlemanagement.dev/api/articles/all/ \
  -H 'cache-control: no-cache' \

#####Get article by id
curl -X GET \
  http://articlemanagement.dev/api/articles/{article_id} \
  -H 'cache-control: no-cache' \

#####Create article
curl -X POST \
  http://articlemanagement.dev/api/articles/ \
  -H 'cache-control: no-cache' \
  -H 'content-type: application/x-www-form-urlencoded' \

#####Update article
curl -X PUT \
  http://articlemanagement.dev/api/articles/{article_id} \
  -H 'cache-control: no-cache' \
  -H 'content-type: application/x-www-form-urlencoded' \

#####Delete article
 curl -X DELETE \
   http://articlemanagement.dev/api/articles/{article_id} \
   -H 'cache-control: no-cache' \
   -H 'content-type: application/x-www-form-urlencoded' \

#####Create user info
curl -X POST \
  http://articlemanagement.dev/api/users/info \
  -H 'cache-control: no-cache' \
  -H 'content-type: application/x-www-form-urlencoded' \

#####Update user info

curl -X PUT \
  http://articlemanagement.dev/api/users/info \
  -H 'cache-control: no-cache' \
  -H 'content-type: application/x-www-form-urlencoded' \
 


