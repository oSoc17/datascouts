# Service Resource

    GET /services

## Description

Returns a listing of all services.

## Parameters

None

## Return format

A JSON Object filled an array of service following the **[service format][]**.

## Errors

None

## Example

### **Request**

``` json

    GET /services
```

### **Return**

``` json
[
    {
        id: 1,
        name: "twitter",
        link: "https://twitter.com",
        logo: null,
        color: null
    },
    {
        id: 2,
        name: "youtube",
        link: "https://youtube.com",
        logo: null,
        color: null
    },
    {
        id: 3,
        name: "vimeo",
        link: "https://vimeo.com",
        logo: null,
        color: null
    }
]
```

[service format]: ../../formats.md#short-format-service
