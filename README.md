# symfony-graph
[POC] Implementation of a GraphQL API with Symfony 4

This project uses the [OverblogGraphQLBundle](https://github.com/overblog/GraphQLBundle) and the [OverblogGraphiQLBundle](https://github.com/overblog/GraphiQLBundle ) symfony bundles !

* First clone the project.
* Rename the root **.env.dist** file into **.env**, and replace the environment variables with your own choices.
* Make sure the symfony **var/cache** and **var/log** directories got the right permissions.
* Build the images and launch the project with the following command: 
~~~
docker-compose up
~~~
* One the project is launched, you have to create the database tables. Access to the source code container's terminal with the following command:
~~~
docker-compose exec php bash
~~~
* Then, go to the source code root directory (as defined is the php7-fpm Dockerfile *WORKDIR* instruction).
~~~
cd /var/www/code
~~~
* Use now the [Doctrine migration system](https://symfony.com/doc/current/doctrine.html) to make and apply a database migration as following:
~~~
php bin/console make:migration
php bin/console doctrine/migration/migrate
~~~
*Note : you can use the alias **sf** instead of the whole **php bin/console** command (alias provided in the php7-fpm Dockerfile file)*
* Don't forget to add the sfgraph.local adress to your hosts:
~~~
echo "10.5.0.100 sfgraph.local" >> /etc/hosts
~~~

## Congratulations !

You can now access to the web app at **sfgraph.local**.

At this point, only the **GraphQL queries** are implemented (the **mutations** will come soon).

* Use the administration interface (provided by the **EasyAdminBundle**) at **sfgraph.local/admin** to add entities
* Use the GrapĥiQL interface at **sfgraph.local/graphiql**, and try some queries !

*Note: The 2 default usable example entities are *Band* and *Music styles**


