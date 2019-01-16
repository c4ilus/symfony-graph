# [POC] Implementation of a GraphQL API with Symfony 4

This project uses the [OverblogGraphQLBundle](https://github.com/overblog/GraphQLBundle) and the [OverblogGraphiQLBundle](https://github.com/overblog/GraphiQLBundle ) symfony bundles !

* First clone the project.
* Rename the root **.env.dist** file into **.env**, and replace the environment variables with your own choices.
* Make sure the symfony **var/cache** and **var/log** directories got the right permissions.
* Build the images and launch the project with the following command: 
~~~
docker-compose up
~~~
* Once the project is launched, you have to create the database tables. Access to the source code container's terminal with the following command:
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
php bin/console doctrine:migrations:migrate
~~~
*Note : you can use the alias **sf** instead of the whole **php bin/console** command (alias provided in the php7-fpm Dockerfile file)*
* Don't forget to add the sfgraph.local adress to your hosts:
~~~
echo "10.5.0.100 sfgraph.local" >> /etc/hosts
~~~

## Congratulations!

You can now access to the web app at **sfgraph.local**.

*Note: The 2 default usable example entities are *Band* and *Music styles**

* Use the administration interface (provided by the **EasyAdminBundle**) at **sfgraph.local/admin** to add entities
* Use the GrapĥiQL interface at **sfgraph.local/graphiql**, and try some queries !

## Try some examples

### Queries

#### Get the music styles or metal bands list

~~~
query GetMusicStylesList {
  styles_list {
    styles {
      id
      name
    }
  }
}
~~~

In this query, the keyword *GetMusicStylesList* is not required. It will be useful to find more easily, and replay this particular query from the History.

The returned result will be an array of items, with the fields that we chose in the query :

~~~
{
  "data": {
    "styles_list": {
      "styles": [
        {
          "id": 22,
          "name": "Sludge"
        },
        {
          "id": 21,
          "name": "Chaotic"
        },
        {
          "id": 20,
          "name": "Scremo"
        },
        {
          "id": 19,
          "name": "Doom"
        },
        {
          "id": 18,
          "name": "Avant-garde"
        },
        {
          "id": 9,
          "name": "Grindcore"
        },
        {
          "id": 8,
          "name": "Death"
        },
        {
          "id": 7,
          "name": "Progressive"
        },
        {
          "id": 6,
          "name": "Atmospheric"
        },
        {
          "id": 5,
          "name": "Rock"
        },
        {
          "id": 4,
          "name": "Hardcore"
        },
        {
          "id": 3,
          "name": "Black"
        },
        {
          "id": 2,
          "name": "Post"
        },
        {
          "id": 1,
          "name": "Metal"
        }
      ]
    }
  }
~~~

We can also make a query to get all the recorded music band in this app:

~~~
query GetMetalBands {
  bands_list {
    bands {
      id
      name
      country
    }
  }
}
~~~

And we can get, for each band, the associated music styles:

~~~
query GetMetalBandsWithAssociatedMusicStyles {
  bands_list {
    bands {
      id
      name
      country
      style {
        id
        name
      }
    }
  }
}
~~~

#### Getting a single object

We want the informations of the band with the ID *10* :

~~~
query {
  band(id: 10) {
    name
    country
    style {
        id
        name
    }
  }
}
~~~

This will return :

~~~
{
  "data": {
    "band": {
      "name": "Dirt Forge",
      "country": "Danemark",
      "style": [
        {
          "id": 1,
          "name": "Metal"
        },
        {
          "id": 22,
          "name": "Sludge"
        }
      ]
    }
  }
}
~~~

### Mutations

#### Add a new style or band

~~~
mutation AddStoner {
  AddStyle(input:{name:"Stoner"}) {
    id
  }
}
~~~

The previous mutation will return the new created object ID:

~~~
{
  "data": {
    "AddStyle": {
      "id": 26
    }
  }
}
~~~

#### Add a new music band

In this case we add a new band:

~~~
mutation {
  AddBand (input: {name: "Hangman's chair", country: "France"}) {
    id
  }
}
~~~

### Update items

The previous band is created (with the ID *36*) but without music styles. So, we gonna update it to add some:

~~~
mutation {
  UpdateBand(input:{id: 36, styles: [26]}) {
    id
  }
}
~~~

And if we query this band we have:

~~~
{
  "data": {
    "band": {
      "id": 36,
      "name": "Hangman's chair",
      "country": "France",
      "style": [
        {
          "id": 26,
          "name": "Stoner"
        }
      ]
    }
  }
}
~~~

Or, you just want to change the country label:

~~~
mutation {
  UpdateBand(input:{id: 36, country: "FR"}) {
    id
  }
}
~~~

The result will be:

~~~
{
  "data": {
    "band": {
      "id": 36,
      "name": "Hangman's chair",
      "country": "FR",
      "style": [
        {
          "id": 26,
          "name": "Stoner"
        }
      ]
    }
  }
}
~~~

### Delete items

I created a new fake style with ID *27*:

~~~
{
  "data": {
    "style": {
      "id": 27,
      "name": "Hypster Progressive Jazz/Black Metal"
    }
  }
}
~~~

To delete this inglorious chimera we do:

~~~
mutation BurnInHell {
  DeleteStyle(input:{id: 27}) {
    id
  }
}
~~~

And ... POOOF ... it's gone !

