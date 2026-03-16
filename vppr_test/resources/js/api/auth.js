import api from './index.js';

export async function login(email, password) {
    const response = await api.post('/auth/login', { email, password });
    return response.data;
}

export async function register(data) {
    const response = await api.post('/auth/register', data);
    return response.data;
}

export async function resetPassword(email, password, password_confirmation) {
    const response = await api.post('/auth/reset-password', { 
        email, password, password_confirmation 
    });
    return response.data;
}

export async function logoutApi() {
    const response = await api.post('/auth/logout');
    return response.data;
}

export async function getMe() {
    const response = await api.get('/auth/me');
    return response.data.user;
}
