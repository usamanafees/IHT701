
window._ = require('lodash');
/**
 * We'll load jQuery and the Bootstrap jQuery plugin which provides support
 * for JavaScript based Bootstrap features such as modals and tabs. This
 * code may be modified to fit the specific needs of your application.
 */
try {
    window.$ = window.jQuery = require('jquery');
    require('bootstrap-sass');
} catch (e) {}

/**
 * We'll load the axios HTTP library which allows us to easily issue requests
 * to our Laravel back-end. This library automatically handles sending the
 * CSRF token as a header based on the value of the "XSRF" token cookie.
 */

window.axios = require('axios');

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

/**
 * Next we will register the CSRF Token as a common header with Axios so that
 * all outgoing HTTP requests automatically have it attached. This is just
 * a simple convenience so we don't have to attach every token manually.
 */
let token = document.head.querySelector('meta[name="csrf-token"]');
if (token) {
    window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
} else {
    console.error('CSRF token not found: https://laravel.com/docs/csrf#csrf-x-csrf-token');
}
/**
 * Echo exposes an expressive API for subscribing to channels and listening
 * for events that are broadcast by Laravel. Echo and event broadcasting
 * allows your team to easily build robust real-time web applications.
 */
import Echo from 'laravel-echo'
window.Pusher = require('pusher-js');
window.Echo = new Echo({
    broadcaster: 'pusher',
    key: 'abcdefg',
    cluster: 'mt1',
    // wsHost:'127.0.0.1',
    wsHost: window.location.hostname,
    wsPort:6001,
    forceTLS: false,
    disableStats: true,
    authEndpoint: 'api/broadcasting/auth',
    // auth: {
        // headers: {
        //     Authorization: 'Bearer ' + 'eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiIsImp0aSI6IjI4ZDlkMzA0OWE5NmRhZTJhZWU2ZGQ5YjM3NjRjOGFiZWEyZmZjMTI2OGZkMjExZGJmZWM5ODE1ODAxZTg3ZmI5ZDQwNzRkYzkzODIyMmQ4In0.eyJhdWQiOiIxMSIsImp0aSI6IjI4ZDlkMzA0OWE5NmRhZTJhZWU2ZGQ5YjM3NjRjOGFiZWEyZmZjMTI2OGZkMjExZGJmZWM5ODE1ODAxZTg3ZmI5ZDQwNzRkYzkzODIyMmQ4IiwiaWF0IjoxNTk1MjMxMTkwLCJuYmYiOjE1OTUyMzExOTAsImV4cCI6MTYyNjc2NzE5MCwic3ViIjoiMSIsInNjb3BlcyI6W119.zQim3aUEAzZERM75udlpVD8FLdD8rOw4-rP4jPOtxa5fI9PonOgjZQ9lrXL9KGMN076rl_cQqJyWar824geN-iw-yC1W-cRom0OvXoVrmKhAelqp3UPijNvEZ_0OSH2rtNa9w3gGiYsm5yUyUYaOFM2TMPSgKeshQ88s3I_PFFxFmuY5XGmr2pjMvK5h2CDRPYsupFrJYDKO1UiTBmCBPVDPYcg3c9wI-4DVrYYl2q7E14PHSfp1qIsEIR2_pcjU8VJu1FY89KryIc9M8LDtZxcy1bRuc8l7sPOtZCUkpOhZPDRVcZ6ClYmRLuYg0Vj9damgDZ-etE-yk6s3R0_U79Tm7zcYxz1fSQv-5NBCb4PJKBJn2coBYsD0CrQXvGGp-xwP6rUU5KjOf-tfo0zPI6x4TdRRV95UDAUDtMv3G_LC_JpIKTPgQqp7TUm3uztuNCYhUF1OWhnCSk2SS7T0C5eagvv8A17lZGu7VgT5GGIzNjbgqqvL18LtFrJAcV9uLhnmToxNlyuHwxFgv1UPSnYy6ViRRt9pEBXe2WUef0_96Ni1Pe22jv56MRmvh8O779bHUn2sUA7dwYbHW-YbzVOZ2DOCOABouFjpabRoE1giEniLoAHbaom6fqjBiArGyxxEQIj8yWRvNyfx8ONMvxbzE-1wo8ZFM352qvydH4M'
        // },
    // },
});