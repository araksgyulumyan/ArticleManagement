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
  -H 'content-type: multipart/form-data; boundary=----WebKitFormBoundary7MA4YWxkTrZu0gW' \
  -F username={username} \
  -F password={password}
  
#####UserRegistration
  
curl -X POST \
  http://articlemanagement.dev/api/users/register \
  -H 'cache-control: no-cache' \
  -H 'content-type: multipart/form-data; boundary=----WebKitFormBoundary7MA4YWxkTrZu0gW' \
  -F username={username} \
  -F password={password}

#####Get all articles of the logged in user
curl -X GET \
  http://articlemanagement.dev/api/articles/all/ \
  -H 'cache-control: no-cache' \

#####Get article by id
curl -X GET \
  http://articlemanagement.dev/api/articles/{article_id} \
  -H 'cache-control: no-cache' \

#####Create article
ccurl -X POST \
   http://articlemanagement.dev/api/articles \
   -H 'cache-control: no-cache' \
   -H 'content-type: multipart/form-data; boundary=----WebKitFormBoundary7MA4YWxkTrZu0gW' \
   -F 'title={title}' \
   -F 'content={content}'

#####Update article
curl -X PUT \
  http://articlemanagement.dev/api/articles/{article_id} \
  -H 'cache-control: no-cache' \
  -H 'content-type: application/x-www-form-urlencoded' \
  -d 'title={title}&content={content}'

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
  -d 'name={name}&surname={surname}'

#####Update user info

curl -X PUT \
  http://articlemanagement.dev/api/users/info \
  -H 'cache-control: no-cache' \
  -H 'content-type: application/x-www-form-urlencoded' \
  -d 'name={name}&surname={surname}'\
 


