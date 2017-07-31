# Service Resource

    PUT /services/:id

## Description

Update some data on a specified service.

## Parameters

The ID of the service must be provided in the URL of the request.
The following parameters are recognized in the PUT request body.

- **name** — [string] The new name of the service.
- **link** — [string] The new link to service homepage.
- **logo** — [string] The new path for the service logo.
- **color** — [string] The new primary color of the service.

## Return format

**Status 2oo** — OK

A JSON Object filled with an service following the **[service format][]**.

## Errors

- **4o4** — Not Found. The specified service by this ID is not in the DB.
- **422** — Unprocessable Entity. The new name/link/logo is already token.

## Example

### **Request**

``` json

    PUT /services/4
    {
        "name": "petbook",
        "link": "https://petbook.org",
        "color": "SandyBrown"
    }

```

### **Return**

``` json
{
    "id": 4,
    "name": "petbook",
    "link": "https://petbook.org",
    "logo": null,
    "color": "SandyBrown"
}

```

[service format]: ../../formats.md#service-format
