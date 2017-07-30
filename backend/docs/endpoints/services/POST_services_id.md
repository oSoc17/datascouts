# Service Resource

    POST /services

## Description

Create a new service.

## Parameters

The following parameters are recognized in the POST request body.

- **name** (REQUIRED) — [string] The name of the service.
- **link** (REQUIRED) — [string] The link to service homepage.
- **logo** — [string] The path for the service logo.
- **color** — [string] The primary color of the service.

## Return format

**Status 2o1** — Created

A JSON Object filled with an service following the **[service format][]**.

## Errors

- **Status 422** — Unprocessable Entity. The request name/link/logo is already token.

## Example

### **Request**

``` json
    POST /services
    {
        "name": "test",
        "link": "https://test.org",

    }
```

### **Return**

``` json
[
    {
        "id": 4,
        "name": "test",
        "link": "https://test.com",
        "logo": null,
        "color": null
    }
]
```

[service format]: ../../formats.md#short-format-service
