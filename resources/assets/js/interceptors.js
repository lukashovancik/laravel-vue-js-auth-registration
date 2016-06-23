module.exports = function(Vue) {

    //Set the base url for accessing the API
    Vue.http.options.root = '/';

    //Define the logic for pre and postprocessing of a request.
    Vue.http.interceptors.push({

        request: function (request) {


            var token = localStorage.getItem('jwt-token')
            if(token !== null && token !== 'undefined') {
                request.headers.Authorization = token
            }
            return request;
        },

        response: function (response) {
            console.log('start response');

            if(response.status === 401) {
                localStorage.removeItem('jwt-token');
            }
            if(response.headers('Authorization')) {
                localStorage.setItem('jwt-token', response.headers('Authorization'));
            }

            if(response.data && response.data.token && response.data.token.length > 10) {
                localStorage.setItem('jwt-token', 'Bearer ' + response.data.token);
            }
            return response;
        }

    });
}