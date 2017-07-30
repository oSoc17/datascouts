# Handle Resource

    GET /handles/{id}

## Description

Returns a specified **[handle format][]**.

## Parameters

- **id** — [integer] The id of the specified **[handle format][]**.

## Return format

A JSON Object filled with an handle following the **[handle format][]**.

## Errors

All errors return an HTTP error response with a JSON Object as keys ``message`` about the error, ``request.method`` the method of the received request, ``request.path`` the path used to send the request, ``request.input`` an array containing the parameters sent.

- **404 Not Found** — An handle with the specified ID does not exist.

## Example

### **Request**

``` json
    GET /handles/7
```

### **Return**

``` json
    {
        id: 7,
        name: "openknowledgebe",
        url: "12_twitter_openknowledgebe",
        created_at: "2017-07-27 12:34:22",
        updated_at: "2017-07-27 15:10:26",
        entity_id: 12,
        service_id: 1,
        is_fetching: 0,
        fetched_at: "2017-07-27 15:10:26"
    }

```

### **Wrong Request**

``` json
    GET /handles/999
```

### **Return**

``` json
{
    message: "The requested object is not valid",
    request: {
    method: "GET",
    path: "api/v1/handles/999",
    parameters: [ ]
    },
    data: [ ]
}
```

[handle format]: ../../formats.md#short-format-handle
