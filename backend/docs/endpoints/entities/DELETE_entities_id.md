# Entity Resource

    DELETE /entities/:id

## Description

Delete a specific entity.

## Parameters

The ID of the entity must be provided in the URL of the request.

## Return format

**Status 2o4** — No Content

## Errors

- **4o4** — Not Found. The specified entity by this ID is not in the DB.

## Example

### **Request**

``` json

    DELETE /entities/24

```

### **Return**

None

[entity format]: ../../formats.md#entity-format
