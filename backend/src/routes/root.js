const KRouter = require('koa-router');
const router = new KRouter();

const Config = require('config');


router.get('/',async (ctx, next) => {
  ctx.body = 'Hello oSoc17 World';
  return next();
});



router.get('/zen',async (ctx, next) => {
  ctx.body = 'Wait for the joke ... It\'s coming  ';
});


router.get('/zen', (ctx, next) => {
    const jokes = Config.zen;
    ctx.body = jokes[Math.floor(Math.random() * (jokes.length))];
    return next();
});




// -------------------------------------------------------------------
// Exports


module.exports = router;