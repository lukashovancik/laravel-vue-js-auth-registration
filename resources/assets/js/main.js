
var Vue = require('vue');
var VueRouter = require('vue-router');
var VueValidator = require('vue-validator')


//Register the routes with the route
var configureRoutes = require('./routes');


Vue.use(VueRouter);
Vue.use(require('vue-resource'));
Vue.use(VueValidator);

//Create a router instance
var router = new VueRouter();

//Set the routes on the router instance
configureRoutes(router);

//var config = require('./config');
Vue.config.debug = true;
//Register the routes with the route
var configureInterceptors = require('./interceptors');
configureInterceptors(Vue);

//Register the global components
var components = require('./components/register');
components.registerAllGlobalComponents();

var validation = require('./validator/register');
validation.registerAllValidationRules();


var App = require('./app.vue');

router.start(App, '#app');








