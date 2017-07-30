# Service Resource

    DELETE /services/:id

## Description

Delete a specific service.

## Parameters

The ID of the service must be provided in the URL of the request.

## Return format

**Status 2o4** — No Content

## Errors

- **4o4** — Not Found. The specified service by this ID is not in the DB.

## Example

### **Request**

``` json

    DELETE /services/4

```

### **Return**

None

[service format]: ../../formats.md#short-format-service
