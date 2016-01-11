symrelia
========

Example creating Symfony REST service and using Aurelia framework to accesing it.It's my starting point for learning Aurelia framework.

This is still work in progress, so it will be updated from time-to-time.


# Installation

First you need to update composer dependencies. In root execute:

```
composer update
```

After that you will need to create virtual host with domain symrelia.vrs or whatever you like. You can change this later in aurelia/src/articles.js.
Test if your REST API is available and working properly. You can do this with cURL or some RESTclient plugin for your prefered browser.After that you
can instal javascript dependencies by navigating to aurelia folder and executing:


```
npm install
jspm install -y
```
After this you can startup gulp server:

```
gulp watch
```

You can navigate to localhost:9000 and try to add/edit/delete articles.