# Zen

    GET /zen

## Description

Returns an IT Joke. This endpoint is used to test the connectivity of the API.

## Parameters

None

## Return format

A JSON Object filled with: 

* joke — The joke

## Errors

None

## Example

### **Request**

``` json

    GET /api/v1/zen
    
```

### **Return**

``` json
    {
        "joke": "Waiting for the joke. It' comming ...."
    }
```