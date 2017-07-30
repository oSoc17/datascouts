# Entity Resource

    GET /entities

## Description

Returns a listing of all entities.

## Parameters

None

## Return format

A JSON Object filled an array of entity following the **[entity format][]**.

## Errors

None

## Example

### **Request**

``` json

    GET /entities
```

### **Return**

``` json
[
    {
        "id": 12,
        "name": "osoc17",
        "url": "entity_osoc17",
        "image": "http://2017.summerofcode.be/images/squarelogo-LI.png",
        "created_at": "2017-07-16 16:04:10",
        "updated_at": "2017-07-19 20:21:34"
    },
    {
        "id": 23,
        "name": "crypto blockchain",
        "url": "entity_crypto-blockchain",
        "image": null,
        "created_at": "2017-07-01 16:35:18",
        "updated_at": "2017-07-13 09:21:57"
    }
]
```

[entity format]: ../../formats.md#short-format-entity
