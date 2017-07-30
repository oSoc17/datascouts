# Handle Resource

    POST /entities/:entity_id/handles
    POST /handles/:entity_id

## Description

Create a new handle for a specific handle.

## Parameters

The ID of the entity must be provided in the URL of the request.
The following parameters are recognized in the POST request body.

- **name** (REQUIRED) — [string] The name of the handle.
- **service** (REQUIRED) — [integer] The ID of the service associated to this .

## Return format

**Status 2o1** — Created

A JSON Object filled with an handle following the **[handle format][]**.

## Errors

- **Status 4o4** — Not Found. The specified entity by this ID is not in the DB.
- **Status 422** — Unprocessable Entity. The request name is already token.

## Example

### **Request**

``` json
    POST /handles/24
    {
        name : "test",
        service : 1
    }
```

### **Return**

``` json
[
    {
        id: 11,
        name: "test",
        url: "24_twitter_test",
        created_at: "2017-07-29 00:00:00",
        updated_at: "2017-07-29 00:00:00"
        entity_id: 24,
        service_id: 1,
        is_fetching: 0,
        fetched_at: "2017-07-29 00:05:00"
    }
]
```

[handle format]: ../../formats.md#short-format-handle
