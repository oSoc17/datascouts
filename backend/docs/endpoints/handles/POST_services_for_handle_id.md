# Handle Resource

    POST /handles/:handle_id/services/:service_id

## Description

Associate a service to a handle.

## Parameters

The handle and service IDs must be provided in the request URL.
The following parameters are recognized in the query.

## Return format

**Status 2oo** — OK

A JSON Object filled with an handle following the **[handle format][]**.

## Errors

- **Status 4o4** — Not Found. The handle or service specified are not found in the DB.
- **Status 422** — Unprocessable Entity. The request name/link/logo is already token.

## Example

### **Request**

``` json
    POST /handles/11/services/4
```

### **Return**

``` json
[
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
        "service" : {
            "id": 4,
            "name": "petbook",
            "link": "https://petbook.org",
            "logo": null,
            "color": "SandyBrown"
        }
    }

    
]
```

[handle format]: ../../formats.md#short-format-handle
