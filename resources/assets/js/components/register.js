var Vue = require('vue');

//requires
var errorComponent = require('./general/error-message.vue');
var inputEmail     = require('./general/input-email.vue');
var nav            = require('./general/nav.vue');

module.exports = {

	registerAllGlobalComponents: function() {
		//register vue components
		Vue.component('navigation',nav);
		Vue.component('error',errorComponent);
		Vue.component('i-email',inputEmail);
		
	}

}
