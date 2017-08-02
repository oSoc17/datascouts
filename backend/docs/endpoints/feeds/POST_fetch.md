# Feed Resource

    POST /fetch

## Description

Returns 

## Parameters

The following parameters are recognized in the POST request body.

- **handles** (REQUIRED) — [array] The list of handles id to fetch for.

## Return format

A JSON Object filled an array of feed following the **[feed format][]**.

## Errors

None

## Example

### **Request**

``` json

    POST /fetch
    {
        "handles" : [9, 10]
    }
```

### **Return**

``` json
[
    [{ "TweetFeed"}, { "TweetFeed"}, {"TweetFeed"}, {"TweetFeed"}, ...],
    [{ "VimeoFeed"}, {"VimeoFeed"}, {"VimeoFeed"}, ...]
]
```

[feed format]: ../../formats.md#feed-format
