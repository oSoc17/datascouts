'use strict';

/**
 * @fileoverview  The booting module for the app.
 * Can only be called by the {@link module:app/main main}.
 *
 * @module app
 * @requires config
 * @requires bluebird
 * @requires components/logger
 * @requires components/server
 *
 * @exports components/boot
 *
 */

// -------------------------------------------------------------------
// Dependencies


// npm
const Config = require('config');
const Koa = require('koa');
const KMorgan  = require("koa-morgan");
const KCORS = require('koa-cors');
// const Promise = require('bluebird');

// Built-in


// Mine
const RootRoute = require("./routes/root");
const TwitterRoute = require("./routes/twitter");

// -------------------------------------------------------------------
// Properties


const app = new Koa()

app.use(RootRoute.routes())
app.use(RootRoute.allowedMethods())

app.use(TwitterRoute.routes())
app.use(TwitterRoute.allowedMethods())


app.use(KMorgan('short'));
app.use(KCORS());

app.listen(Config.api.port);

console.log("API Running on http://localhost:"+Config.api.port);
