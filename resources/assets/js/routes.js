module.exports = function(router){
    router.map({
        '/autentifikacia':{
            component:require('./components/views/auth.vue'),
            subRoutes: {

                '/prihlasit': {
                    component:require('./components/views/auth/login.vue'),
                    guest:true
                },

                '/odhlasit':{
                    component:require('./components/views/auth/logout.vue'),
                    auth:true
                }
            }
        },

        '/domov':{
            component:require('./components/views/domov.vue'),
            auth:true
        },
    }).alias({
        'autentifikacia':'/autentifikacia/prihlasit',
        '': '/autentifikacia/prihlasit',
        'prihlasit':'/autentifikacia/prihlasit',
        'odhlasit-sa': '/autentifikacia/odhlasit'

    }).beforeEach(function(transition) {
        var token = localStorage.getItem('jwt-token')
        if (transition.to.auth) {
            if (!token || token === null) {
                transition.redirect('autentifikacia')
            }
        }
        if (transition.to.guest) {
            if (token) {
                transition.redirect('/domov')
            }
        }
        
        transition.next()
    });

}