# Entity Resource

    PUT /entities/:id

## Description

Update some data on a specified entity.

## Parameters

The ID of the entity must be provided in the URL of the request.
The following parameters are recognized in the POST request body.

- **name** — [string] The new name of the entity.

## Return format

**Status 2oo** — OK

A JSON Object filled with an entity following the **[entity format][]**.

## Errors

- **4o4** — Entity Not Found. The specified entity by this ID is not in the DB.
- **422** — Unprocessable Entity. The new name is already token.

## Example

### **Request**

``` json

    PUT /entities/24
    {
        name : "Lorem ipsum"
    }

```

### **Return**

``` json
[
    {
        id: 24,
        name: "Lorem ipsum",
        url: "entity_test",
        image: null,
        created_at: "2017-07-29 00:00:00",
        updated_at: "2017-07-29 00:00:00"
    }
]
```

[entity format]: ../../formats.md#short-format-entity
