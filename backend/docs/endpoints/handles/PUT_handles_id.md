# Handle Resource

    PUT /handles/:id

## Description

Update some data on a specified handle.

## Parameters

The ID of the handle must be provided in the URL of the request.
The following parameters are recognized in the PUT request body.

- **name** — [string] The new name of the handle.
- **service** — [integer] The new service of the handle.

## Return format

**Status 2oo** — OK

A JSON Object filled with an handle following the **[handle format][]**.

## Errors

- **4o4** — Not Found. The specified handle by this ID is not in the DB.
- **422** — Unprocessable Entity. The new name is already token.

## Example

### **Request**

``` json

    PUT /handles/11
    {
        "name" : "Lorem ipsum"
    }

```

### **Return**

``` json
{
    "id": 11,
    "name": "Lorem ipsum",
    "url": "24_twitter_test",
    "created_at": "2017-07-29 00:00:00",
    "updated_at": "2017-07-29 00:00:00",
    "entity_id": 24,
    "service_id": 1,
    "is_fetching": 0,
    "fetched_at": "2017-07-29 00:05:00"
}
```

[handle format]: ../../formats.md#handle-format
