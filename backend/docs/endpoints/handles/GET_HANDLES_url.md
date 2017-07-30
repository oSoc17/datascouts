# Handle Resource

    GET /handles/{url}

## Description

Returns a specified **[handle format][]**.

## Parameters

- **url** — [string] The url of the specified **[handle format][]**.

## Return format

A JSON Object filled with an handle following the **[handle format][]**.

## Errors

All errors return an HTTP error response with a JSON Object as keys ``message`` about the error, ``request.method`` the method of the received request, ``request.path`` the path used to send the request, ``request.input`` an array containing the parameters sent.

- **404 Not Found** — An handle with the specified url does not exist.

## Example

### **Request**

``` json
    GET /handles/23_twitter_datascouts
```

### **Return**

``` json
    {
        "id": 9,
        "name": "DataScouts",
        "url": "23_twitter_datascouts",
        "created_at": "2017-07-20 15:10:27",
        "updated_at": "2017-07-27 15:10:27",
        "entity_id": 23,
        "service_id": 1,
        "is_fetching": 0,
        "fetched_at": "2017-07-27 15:10:27"
    }

```

### **Wrong Request**

``` json
    GET /handles/abc
```

### **Return**

``` json
{
    "message": "The requested object is not valid",
    "request": {
    "method": "GET",
    "path": "api/v1/handles/abc",
    "parameters": [ ]
    },
    "data": [ ]
}
```

[handle format]: ../../formats.md#short-format-handle
