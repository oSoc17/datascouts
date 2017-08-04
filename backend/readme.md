# DataScouts API

API for Social Media Aggregator

## Introduction

Hello, welcome onboard.

<<<<<<< HEAD
This project designed on [#oSoc17](2017.summerofcode.be/) is a little API to fetch data from different social medias for specific handles.
In short words, APi for Social Media Aggregator.

This document purpose is to give an overview about this project and all basic steps before use or work on it.
=======
This project design on [#oSoc17](2017.summerofcode.be/) is a little API to fetch data from different social media for specified handle. In short words, APi for Social Media Aggregator.

This document purpose is to give an orverview about this project and necessary steps before working on it.
>>>>>>> 4bd3f12871579427fa6bb824cbe9dc12a2fcaf55

## Table of contents

- [Introduction](#introduction)
- [Technologies](#technologies)
- [Requirements](#requirements)
- [Installation](#installation)
  - [Get Started](#get-started)
  - [Configure](#configure)
- [Routes](#routes)
  - [Endpoints](#endpoints)
- [Commands](#commands)
- [Development](#development)
  - [Enhancements](#enhancements)

## Technologies

This API exploits the following technologies :

| **Name** | **Description**| **More infos**|
|------------|----------------|---------------|
| [Lumen v5.4](https://lumen.laravel.com/)| Fast micro-framework by Laravel |[Site web](https://lumen.laravel.com/docs/5.4)|
| [PHP Laravel v5.4](https://laravel.com/)| PHP FrameWork for Web Artisans | [Site web](https://laravel.com/docs/5.4/)|
| [Composer v1.5](https://getcomposer.org/)| Dependency Manager for PHP | [Site web](https://getcomposer.org/doc/00-intro.md), [Download](https://getcomposer.org/download/)|

## Requirements

- All technologies, listed above, are necessary.
- This project was build with PHP v7.0, your PHP environment must set to it.
- A connection to a DB to store entities, handles, providers and feeds for further analyse.

## Installation

### Get Started

``` bash

    # Grab the repository
    $ git clone https://github.com/oSoc17/datascouts.git

    # Move to the datascouts/backend directory
    $ cd datascouts/backend

    # Install dependencies
    $ composer install --no-dev

```

### Configure

After installed all dependencies, you need to configure the application before running it. To do so, copy the ``env.example``.

```bash

    # Copy and rename the .env.example
    $ copy .env.example .env

```

Open the .env file.

#### Application key

I strongly recommand to change your ``APP_KEY`` to some random string. Typically, this string should be 32 characters long.
**If the application key is not set, your user encrypted data will not be secure !**

#### Database

All info required to make a sucessful connection to the database have to be input in the config at the corresponding.

```env

    DB_HOST=
    DB_PORT=
    DB_DATABASE=
    DB_USERNAME=
    DB_PASSWORD=
```

Finally, execute the following command to create the tables.

```bash

    # Copy and rename the .env.example
    $ php artisan migrate --force

```

#### Twitter App

You need to create an application and create your access token in the [ Developer Twitter Application Management](https://apps.twitter.com/).

```env

    TWITTER_APP_ID= {Consumer Key (API Key)}
    TWITTER_APP_SECRET= {Consumer Secret (API Secret)}
    TWITTER_APP_ACCESS_TOKEN= {Access Token}
    TWITTER_APP_ACCESS_TOKEN_SECRET= {Access Token Secret}

```

#### Vimeo App

You need to create an application and generate your access token in the [Developer Vimeo Application Management](https://developer.vimeo.com/apps)

```env

    VIMEO_APP_ID= {Client Identifier}
    VIMEO_APP_SECRET= {Client Secrets}
    VIMEO_APP_ACCESS_TOKEN={Generated access token}
    
```

#### Youtube App

In order to get an API Key, you will 

1. Need to create an project on [Google Console Developer](https://console.developers.google.com)
2. Add & Active [Youtube Data API v3](https://console.developers.google.com/apis/api/youtube.googleapis.com/overview).
3. Finally, create credentials and generate API_KEY to access Youtube API 

```env

    YOUTUBE_API_KEY= {APi Key}

```
### Run

```bash

    # Run localy at http://0.0.0.0:8080
    $ php -S 0.0.0.0:8080 -t ./public/
    
    # Now, let's test that API
    # Open this URL in a browser : http://0.0.0.0:8080/api/v1/zen 

    # To run in production :
    # On the Nginx file for the site dedicated to this APi,
    # make sure to redirect to the folder public/index.php

```

## Routes

**Base url** : `/api/v1`

All routes must be prefixed with this base url. 
For instance, to get all entities ``https://example.com/api/v1/entities``

**[Formats of objet send and return by this API](./docs/formats.md)**

### Endpoints

#### Entity Resource

- **[`GET` zen](./docs/endpoints/GET_zen.md)**


#### Entity Resource

- **[`GET` entities](./docs/endpoints/entities/GET_entities.md)**
- **[`GET` entities/:id](./docs/endpoints/entities/GET_entities_id.md)**
- **[`GET` entities/:url](./docs/endpoints/entities/GET_entities_url.md)**
- **[`POST` entities](./docs/endpoints/entities/POST_entities.md)**
- **[`PUT` entities/:id](./docs/endpoints/entities/PUT_entities_id.md)**
- **[`DELETE` entities/:id](./docs/endpoints/entities/DELETE_entities_id.md)**

#### Handle Resource

- **[`GET` handles](./docs/endpoints/handles/GET_handles.md)**
- **[`GET` handles/:id](./docs/endpoints/handles/GET_handles_id.md)**
- **[`GET` handles/:url](./docs/endpoints/handles/GET_handles_url.md)**
- **[`POST` handles/:entity_id](./docs/endpoints/handles/POST_handles_for_entities_id.md)**
- **[`POST` entities/:entity_id/handles](./docs/endpoints/handles/POST_handles_for_entities_id.md)**
- **[`PUT` handles/:id](./docs/endpoints/handles/PUT_handles_id.md)**
- **[`DELETE` handles/:id](./docs/endpoints/handles/DELETE_handles_id.md)**
- **[`POST` /:handle_id/services/:service_id](./docs/endpoints/handles/POST_services_for_handle_id.md)**

#### Service Resource

- **[`GET` services](./docs/endpoints/services/GET_services.md)**
- **[`GET` services/:id](./docs/endpoints/services/GET_services_id.md)**
- **[`POST` services](./docs/endpoints/services/POST_services.md)**
- **[`PUT` services/:id](./docs/endpoints/services/PUT_services_id.md)**
- **[`DELETE` services/:id](./docs/endpoints/services/DELETE_services_id.md)**

#### Feed Resource

- **[`POST` fetch](./docs/endpoints/feeds/POST_fetch.md)**

#### Provider Resource

- **[`GET` providers/:handle_id/login](./docs/endpoints/providers/GET_providers_handles_login.md)**
- **[`GET` providers/:service_name/callback](./docs/endpoints/providers/GET_providers_services_callback.md)**

## Commands

Two commands have been created for this project. They can only be executed on root path of the backend folder.

### DataScoutsAddAdminUser : ``datascouts:add-admin``

This command can be used to create an user with role set to `admin`. It has the following syntax :

```bash

    php artisan datascouts:add-admin fullname [--email=...] [--password=...]

```

- **fullname**:  [REQUIRED] The user fullname, by default 'R00t'
- **email**: [REQUIRED] The user email
- **password** : The user password. If not set, can be auto-generated. Will, in any case, be hashed before store in DB.

### DataScoutsFetchHandles : ``datascouts:fetch-handles``

This command fetches the social media data related to the specific handles. It has the following syntax :

```bash

    php artisan datascouts:fetch-handles [--only=...]

```

- **only**:  [REQUIRED] Will only fetch for the specified handle by it ID

## Development

### Enhancements
