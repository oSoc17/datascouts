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
const combineRouters = require('koa-combine-routers');

// Built-in


// Mine
const rootRouter = require('./root');



const router = combineRouters([
  rootRouter,
]);



// -------------------------------------------------------------------
// Exports
module.exports = router;