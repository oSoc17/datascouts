# Entity Resource

    POST /entities

## Description

Create a new entity.

## Parameters

The following parameters are recognized in the POST request body.

- **name** (REQUIRED) — [string] The name of the entity.

## Return format

**Status 2o1** — Created

A JSON Object filled with an entity following the **[entity format][]**.

## Errors

- **Status 422** — Unprocessable Entity. The request name is already token.

## Example

### **Request**

``` json
    POST /entities
    {
        "name" : "test"
    }
```

### **Return**

``` json
{
    "id": 24,
    "name": "test",
    "url": "entity_test",
    "image": null,
    "created_at": "2017-07-29 00:00:00",
    "updated_at": "2017-07-29 00:00:00"
}
```

[entity format]: ../../formats.md#entity-format
