# Resources Format

This document details all resources retrievable via the API.

## Base

All request for the API must be prefix by ``/api/v1``.


## Error Format

All errors return an HTTP error response with a JSON Object as keys ``message`` about the error, ``request.method`` the method of the received request, ``request.path`` the path used to send the request, ``request.input`` an array containing the parameters sent.

``` json
{
    message: "The requested object is not valid",
    request: {
      method: "GET",
      path: "api/v1/handle/lorem-ipsum",
      parameters: [ ]
    },
    data: [ ]
}
```

## Default Service

List of the default service available.

|ID | Name| Link | Logo |Color
---|----|-------|-------|--------
|1 | Facebook| https://facebook.com| none| Blue
|2 | Twitter | https://twitter.com| none| Cyan
|3 | Youtube | https://youtube.com| none| Red
|4 | Google+ | https://plus.google.com | none | White
|5 | Instagram|https://instagram.com| none| Gray


## User format

A User is

The format of a User object includes the following data:

- **id** — [integer] ID of the user.
- **email** — [string] The email of the user.
- **fullname** — [string] The surname and/or lastname of the user.
- **username** — [string] The username of the user.
- **type** — [enum(admin,**visitor**)] The username of the user.

## Entity format

A Entity is

The format of a Entity object includes the following data:

- **id** — [integer] ID of the entity,
- **name** — [string] Name of the entity
- **url** — [string] URL of the entity
- **image** — [string] The visual represention of the entity. Upload or fetched from the 
- **created_at** — [timestamp] Timestamp of time of entity creation
- **updated_at** — [timestamp] Timestamp of time of entity last update.

## Handle format

A Handle is

The format of a Handle object includes the following data:

- **id** — [integer] ID of the handle,
- **name** — [string] Name of the handle
- **url** — [string] URL of the handle
- **created_at** — [timestamp] Timestamp of time of handle' creation
- **updated_at** — [timestamp] Timestamp of time of handle' last update.
- **fetched_at** — [timestamp] Timestamp of time of handle' last fetch.
- **is_fetching** — [bit] Timestamp of time of handle last update.
- **entity_id** — [integer] The ID of the attached **[Entity][]**.
- **service_id** — [integer] The ID of the attached **[Service][]**:
- **provider_id** — [integer] The ID of the attached **[Provider][]**:

## Service format

A Service is

The format of a Service object includes the following data:

- **id** — [integer] ID of the service.
- **name** — [string] Name of the service.
- **link** — [string] The link to website of the service.
- **logo** — [string] The Link of the representing' logo of the service.
- **color** — [string] The color assigned to this service for the rending. 
- **created_at** — [timestamp] Timestamp of time of service creation

## Provider format

A Provider is

The format of a Provider object includes the following data:

- **id** — [integer] ID of the provider.
- **social_id** — [string] The ID assigned on the social media 
- **email** — [string] The email of the user.
- **fullname** — [string] The surname and/or lastname of the user.
- **username** — [string] The username of the user.

## Fetcher format

A Fetcher is

The format of a Fetcher object includes the following data:

- **id** — [integer] ID of the provider.
- **data** — [json] The Data of the
- **handle_id** — [integer] The ID of the attached **[Handle][]**.




[entity]:[entity-format]
[service]:[service-format]
[handle]:[handle-format]
[provider]:[provider-format]

[Category]: https://github.com/500px/api-documentation/blob/master/basics/formats_and_terms.md#categories
[gallery kind]: https://github.com/500px/api-documentation/blob/master/basics/formats_and_terms.md#gallery-kinds
[License type]: https://github.com/500px/api-documentation/blob/master/basics/formats_and_terms.md#license_types
