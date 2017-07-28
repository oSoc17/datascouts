# Project DATAScouts

> This part concerns the visual presentation of the data retrievied from the backend. 

## Requirements

In order to build this project, you will need Node.JS updated to the version _v7.10.0_ and npm to _v4.2.0_. To make sure of that, run those commands below.

    $ node --version
    v7.10.0

    $ npm --version
    4.2.0

## Before started

The second part of the whole project, the **backend API** must be launched and accessible.

## Getting started

``` bash

# Grab the repository
$ git clone https://github.com/oSoc17/datascouts.git

# Move to the datascouts/frontend directory
$ cd datascouts/frontend

# Install dependencies
$ npm install

```

### Configure app

The API Url must be set in the config file. This file is in `frontend/src/config/index.js`.

**This step is required to continue.**

### Run

``` bash

# serve the applcation at localhost:8082
$ npm run serve
# The application is build and running on http://localhost:8082

```

## Simple build for production

``` bash
    # Instead of npm run serve
    npm run build
```

## Languages & tools

### JavaScript

- [Browserify](http://browserify.org/) to handle allow us to write our client-side scripts with [es6 syntax](http://es6.github.io/).
- [BabelJS](https://github.com/babel/babel) is a compiler for writing next generation JavaScript.
- [Vue.JS](https://github.com/vuejs/vue) is used for web UI.

### CSS

- [GULP-SASS](https://github.com/dlmanning/gulp-sass) is used to write futureproof CSS for CSS vendor prefix under the hood).
