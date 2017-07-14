# DataScouts API

API for Social Media Aggregator

## Introduction

---

Hello, welcome onboard.

This project design on [#oSoc17](2017.summerofcode.be/) is a little API to fetch data from different social media for specified entities. In short words, APi for Social Media Aggregator.

This purpose of this document is to give an orverview about this project and necessary steps before working on it.

## Table Of Contents

---

- [Introduction](#introduction)
- [Technologies](#Technologies)
- [Laravel Packages](#laravel-packages)
- [Requirements](#requirements)
- [Installation](#getting-started)
  - [Before Started](#before-started)
  - [Get Started](#get-started)
- [Routes](#routes)
  - [Endpoints](#endpoints)
- [Development](#dev)
  - [Documentation](#dev-doc)
  - [Hints - Guidelines](#dev-hints)
  - [Enhancements](#dev-more)
- [License](#license)

## Technologies

---

This API exploits the following technologies :

| **Name** | **Description**| **More infos**|
|------------|----------------|---------------|
| [Lumen v5.3](https://lumen.laravel.com/)| Fast micro-framework by Laravel |[Site web](https://lumen.laravel.com/docs/5.4)|
| [PHP Laravel v5.3](https://laravel.com/)| PHP FrameWork for Web Artisans | [Site web](https://laravel.com/docs/5.3/)|
| [Composer v1.5](https://getcomposer.org/)| Dependency Manager for PHP | [Site web](https://getcomposer.org/doc/00-intro.md), [Download](https://getcomposer.org/download/)|

## Laravel Packages

---

| **Name** | **Description**| **More infos**|
|------------|----------------|---------------|
| [Lumen v5.3](https://lumen.laravel.com/)| Fast micro-framework by Laravel |[Site web](https://lumen.laravel.com/docs/5.4)|
| [PHP Laravel v5.3](https://laravel.com/)| PHP FrameWork for Web Artisans | [Site web](https://laravel.com/docs/5.3/)|
| [Composer v1.5](https://getcomposer.org/)| Dependency Manager for PHP | [Site web](https://getcomposer.org/doc/00-intro.md), [Download](https://getcomposer.org/download/)|

## Requirements

---

- All tecnhologies listed before the are necessary.
- This project was build with PHP v7.1, your PHP environnement must set to it.
- A connection to a DB.

## Installation

---

### Before Started

### Get Started

## Routes

---

**Base url** : `/api/v1`

**Short Notice about the routes** : `Yep`

**[Formats of objet send and return by this API](./docs/formats.md)**

### Endpoints

#### [Entity Resources](../../wiki/DB/Entities)

- **[`GET` entities](./docs/endpoints/entities/GET_entities.md)**
- **[`GET` entities/:id](./docs/endpoints/entities/GET_entities_id.md)**

#### [Handle Resources](../../wiki/DB/handles)

- **[`GET` handles](./docs/endpoints/handles/GET_handles.md)**
- **[`GET` handles/:id](./docs/endpoints/handles/GET_handles_id.md)**

## Development

---

### Documentation

### Hints - Guidelines

### Enhancements

## Licence

This project is licensed under the [MIT][info-license] license.

Copyright &copy; 2017, DataScouts Team

[info-license]: LICENSE