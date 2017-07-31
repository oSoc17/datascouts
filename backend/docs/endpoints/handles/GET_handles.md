# Handle Resource

    GET /handles

## Description

Returns a listing of all handles.

## Parameters

None

## Return format

A JSON Object filled an array of handle following the **[handle format][]**.

## Errors

None

## Example

### **Request**

``` json

    GET /handles
```

### **Return**

``` json
[
    {
        "id": 7,
        "name": "openknowledgebe",
        "url": "12_twitter_openknowledgebe",
        "created_at": "2017-07-27 12:34:22",
        "updated_at": "2017-07-27 15:10:26",
        "entity_id": 12,
        "service_id": 1,
        "is_fetching": 0,
        "fetched_at": "2017-07-27 15:10:29"
    },
    {
        "id": 9,
        "name": "DataScouts",
        "url": "23_twitter_datascouts",
        "created_at": "2017-07-20 15:10:27",
        "updated_at": "2017-07-27 15:10:27",
        "entity_id": 23,
        "service_id": 1,
        "is_fetching": 0,
        "fetched_at": "2017-07-27 15:10:27"
    },
    {
        "id": 10,
        "name": "weconnectdata",
        "url": "23_youtube_openknowledge",
        "created_at": "2017-07-21 19:03:43",
        "updated_at": "2017-07-21 19:05:51",
        "entity_id": 23,
        "service_id": 2,
        "is_fetching": 0,
        "fetched_at": "2017-07-21 21:00:07"
    }
]
```

[handle format]: ../../formats.md#handle-format
