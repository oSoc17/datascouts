# Service Resource

    GET /services/{id}

## Description

Returns a specified **[service format][]**.

## Parameters

- **id** — [integer] The id of the specified **[service format][]**.

## Return format

A JSON Object filled with a service following the **[service format][]**.

## Errors

All errors return an HTTP error response with a JSON Object as keys ``message`` about the error, ``request.method`` the method of the received request, ``request.path`` the path used to send the request, ``request.input`` an array containing the parameters sent.

- **404 Not Found** — A service with the specified ID does not exist.

## Example

### **Request**

``` json
    GET /services/3
```

### **Return**

``` json
    {
        id: 3,
        name: "vimeo",
        link: "https://vimeo.com",
        logo: null,
        color: null
    }

```

### **Wrong Request**

``` json
    GET /services/999
```

### **Return**

``` json
{
    message: "The requested object is not valid",
    request: {
    method: "GET",
    path: "api/v1/services/999",
    parameters: [ ]
    },
    data: [ ]
}
```

[service format]: ../../formats.md#short-format-service
