import axios from 'axios';
window.axios = axios;

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
const token = document.getElementsByName('csrf-token')[0]?.content;
window.csrf_token = token
if (token) {
    window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token
}
