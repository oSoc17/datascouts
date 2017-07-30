# Handle Resource

    DELETE /handles/:id

## Description

Delete a specific handle.

## Parameters

The ID of the handle must be provided in the URL of the request.

## Return format

**Status 2o4** — No Content

## Errors

- **4o4** — Not Found. The specified handle by this ID is not in the DB.

## Example

### **Request**

``` json

    DELETE /handles/11

```

### **Return**

None

[handle format]: ../../formats.md#short-format-handle
