# Entity Resource

    GET /entities/{id}

## Description

Returns a specified **[entity format][]**.

## Parameters

- **id** — [integer] The id of the specified **[entity format][]**.


## Return format

A JSON Object filled with an entity following the **[entity format][]**.

## Errors

All errors return an HTTP error response with a JSON Object as keys ``message`` about the error, ``request.method`` the method of the received request, ``request.path`` the path used to send the request, ``request.input`` an array containing the parameters sent.

- **404 Not Found** — An Entity with the specified ID does not exist.

## Example

### **Request**

``` json
    GET /entities/12
```

### **Return**

``` json
    {
        id: 12,
        name: "osoc17",
        url: "entities_osoc17",
        image: "http://2017.summerofcode.be/images/squarelogo-LI.png",
        created_at: "2017-07-16 16:04:10",
        updated_at: "2017-07-19 20:21:34"
    }

```

### **Wrong Request**

``` json
    GET /entities/abc
```

### **Return**

``` json
{
    message: "The requested object is not valid",
    request: {
    method: "GET",
    path: "api/v1/entities/abc",
    parameters: [ ]
    },
    data: [ ]
}
```


[entity format]: ../../formats.md#short-format-entity
