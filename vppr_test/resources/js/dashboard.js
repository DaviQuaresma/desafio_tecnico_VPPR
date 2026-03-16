import { getMe } from './api/auth.js';
import { getServices } from './api/services.js';
import { requireAuth, logout } from './helpers/auth.js';

$(document).ready(async function() {
    if (requireAuth()) return;

    try {
        const user = await getMe();
        $('#user-name').text('Olá, ' + user.name);
    } catch {}

    try {
        const services = await getServices();
        $('#services-count').text(services.length);
    } catch {
        $('#services-count').text('0');
    }

    $('#logout-btn').on('click', logout);
});
