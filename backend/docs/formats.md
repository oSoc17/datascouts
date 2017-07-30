# Resources Format

This document details all resources retrievable via the API.

## Base

All requests for the API must be prefix by ``/api/v1``.

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
|1 | twitter | https://twitter.com| none| Cyan
|2 | youtube | https://youtube.com| none| Red
|3 | vimeo | https://vimeo.com | none | White

## User format

A User is visitor connected to the app via a social media account (FAcebook, Twitter, Intagram).

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
- **url** — [string] URL of the entity. Composed with the ``entity_{the entity name}``.
- **image** — [string] The visual represention of the entity. Upload or fetched from the social media.
- **created_at** — [timestamp] Timestamp of time of entity creation.
- **updated_at** — [timestamp] Timestamp of time of entity last update.

## Handle format

A Handle is

The format of a Handle object includes the following data:

- **id** — [integer] ID of the handle,
- **name** — [string] Name of the handle
- **url** — [string] URL of the handle. Composed with the ``{entity ID}_{service name}_{handle name}``.
- **created_at** — [timestamp] Timestamp of time of handle' creation
- **updated_at** — [timestamp] Timestamp of time of handle' last update.
- **fetched_at** — [timestamp] Timestamp of time of handle' last fetch.
- **is_fetching** — [bit] Bool used to determine if this handle is fetched at the moment.
- **entity_id** — [integer] The ID of the attached **[Entity][]**.
- **service_id** — [integer] The ID of the attached **[Service][]**:

## Service format

A Service is the social media handled by the application.

The format of a Service object includes the following data:

- **id** — [integer] ID of the service.
- **name** — [string] Name of the service.
- **link** — [string] The link to website of the service.
- **logo** — [string] The Link of the representing' logo of the service.
- **color** — [string] The color assigned to this service for the rending.
- **created_at** — [timestamp] Timestamp of time of service creation

## Provider format

A Provider is an connection/authorization to the user social media.

The format of a Provider object includes the following data:

- **id** — [integer] ID of the provider.
- **social_id** — [string] The ID assigned on the social media 
- **email** — [string] The email of the user.
- **fullname** — [string] The surname and/or lastname of the user.
- **username** — [string] The username of the user.

## Feed format

A Feed is a social media post. Can be a tweet, a youtube channel, youtube or vimeo video.

The format of a Feed object includes the following data:

- **id** — [integer] ID of the provider.
- **data** — [json] The Data of the feed.
- **handle_id** — [integer] The ID of the attached **[Handle][]**.

[entity]:[entity-format]
[service]:[service-format]
[handle]:[handle-format]
[provider]:[provider-format]

[gallery kind]: https://github.com/500px/api-documentation/blob/master/basics/formats_and_terms.md#gallery-kinds
