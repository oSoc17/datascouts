# DataScouts API

API for Social Media Aggregator

## Introduction

Hello, welcome onboard.

This project design on [#oSoc17](2017.summerofcode.be/) is a little API to fetch data from different social media for specified handles.
In short words, APi for Social Media Aggregator.

This document puppose is to give an orverview about this project and necessary steps before use it or working on it.

## Table Of Contents

- [Introduction](#introduction)
- [Technologies](#technologies)
- [Requirements](#requirements)
- [Installation](#getting-started)
  - [Get Started](#get-started)
  - [Configure](#configure)
- [Routes](#routes)
  - [Endpoints](#endpoints)
- [Commands](#commands)
- [Development](#dev)
  - [Enhancements](#dev-more)

## Technologies

This API exploits the following technologies :

| **Name** | **Description**| **More infos**|
|------------|----------------|---------------|
| [Lumen v5.4](https://lumen.laravel.com/)| Fast micro-framework by Laravel |[Site web](https://lumen.laravel.com/docs/5.4)|
| [PHP Laravel v5.4](https://laravel.com/)| PHP FrameWork for Web Artisans | [Site web](https://laravel.com/docs/5.4/)|
| [Composer v1.5](https://getcomposer.org/)| Dependency Manager for PHP | [Site web](https://getcomposer.org/doc/00-intro.md), [Download](https://getcomposer.org/download/)|

## Requirements

- All technologies, listed above, are necessary.
- This project was build with PHP v7.0, your PHP environnement must set to it.
- A connection to a DB to store th entities, handles, providers and feeds for further analyse.

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

After install all dependencies, you need to configure the application before running it. To do so, copy the ``env.example``.

```bash

    # Copy and rename the .env.example
    $ copy .env.example .env

```

Open the .env file.

#### Application key

I strongly recommand to change your 'APP_KEY' to a random string. Typically, this string should be 32 characters long.  
**If the application key is not set, your user encrypted data will not be secure !**

#### Database

All

Finally, exexcute the following command to create the tables.

```bash
    # Copy and rename the .env.example
    $ php artisan migrate --force

```

#### Twitter App

### Vimeo App

### Youtube App

### Run

## Routes

**Base url** : `/api/v1`

**Short Notice about the routes** : `Yep`

**[Formats of objet send and return by this API](./docs/formats.md)**

### Endpoints

#### [Entity Resources](./docs/resources/entities.md)

- **[`GET` entities](./docs/endpoints/entities/GET_entities.md)**
- **[`GET` entities/:id](./docs/endpoints/entities/GET_entities_id.md)**
- **[`GET` entities/:url](./docs/endpoints/entities/GET_entities_url.md)**
- **[`POST` entities](./docs/endpoints/entities/POST_entities_id.md)**
- **[`PUT` entities/:id](./docs/endpoints/entities/PUT_entities_id.md)**
- **[`DELETE` entities/:id](./docs/endpoints/entities/DELETE_entities_id.md)**

#### [Handle Resources](./docs/resources/handles.md)

- **[`GET` handles](./docs/endpoints/handles/GET_handles.md)**
- **[`GET` handles/:id](./docs/endpoints/handles/GET_handles_id.md)**
- **[`GET` handles/:url](./docs/endpoints/handles/GET_handles_url.md)**
- **[`POST` handles/:entity_id](./docs/endpoints/handles/POST_handles_for_entities_id.md)**
- **[`POST` entities/:entity_id/handles](./docs/endpoints/handles/POST_handles_for_entities_id.md)**
- **[`PUT` handles/:id](./docs/endpoints/handles/PUT_handles_id.md)**
- **[`DELETE` handles/:id](./docs/endpoints/handles/DELETE_handles_id.md)**

#### [Services Resources](./docs/resources/services.md)

- **[`GET` services](./docs/endpoints/services/GET_services.md)**
- **[`GET` services/:id](./docs/endpoints/services/GET_services_id.md)**
- **[`POST` services/:entity_id](./docs/endpoints/services/POST_services_for_entities_id.md)**
- **[`PUT` services/:id](./docs/endpoints/services/PUT_services_id.md)**
- **[`DELETE` services/:id](./docs/endpoints/services/DELETE_services_id.md)**

#### [Feed Resources](./docs/resources/feeds.md)

- **[`POST` feeds](./docs/endpoints/feeds/POST_feeds.md)**

#### [Providers Resources](./docs/resources/provides.md)

- **[`GET` providers/:handle_id/login](./docs/endpoints/providers/GET_providers_login_by_handle.md)**
- **[`GET` providers/:service_name/callback](./docs/endpoints/providers/GET_service_providers_callback.md)**

## Commands

Two commands have been created for this project. All commands are only executabled on root path of the backend folder.

### DataScoutsAddAdminUser : ``datascouts:add-admin``

This command can be used to create an user with role set to `admin`. It has the following syntax :

```bash
    php artisan datascouts:add-admin fullname [--email=...] [--pasword=...]
```

- **name**:  [REQUIRED] The user fullname, by default 'R00t'
- **email**: [REQUIRED] The user email
- **password** : The user password. If not set, can be auto-generated. Will in any case hashed before store in DB.

### DataScoutsFetchHandles : ``datascouts:fetch-handles``

This command fetches the social media data related to the specific handles. It has the following syntax :

```bash
    php artisan datascouts:fetch-handles [--only=...]
```

- **only**:  [REQUIRED] Will only fetch for the specified handle by it ID

## Development

### Enhancements
