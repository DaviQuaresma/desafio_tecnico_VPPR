import axios from 'axios';
import { getToken, removeToken } from '../helpers/token.js';

const api = axios.create({
    baseURL: '/api',
    headers: {
        'Content-Type': 'application/json',
        'Accept': 'application/json'
    }
});

api.interceptors.request.use(config => {
    const token = getToken();
    if (token) {
        config.headers.Authorization = `Bearer ${token}`;
    }
    return config;
});

api.interceptors.response.use(
    response => response,
    error => {
        if (error.response?.status === 401) {
            removeToken();
            window.location.href = '/login';
        }
        return Promise.reject(error);
    }
);

export function getErrorMessage(error, defaultMsg = 'Erro ao processar requisição.') {
    const response = error.response;
    
    if (!response) return 'Não foi possível conectar ao servidor.';
    if (response.status === 422) {
        const data = response.data;
        if (data?.errors) return Object.values(data.errors).flat().join(' ');
        return data?.message || defaultMsg;
    }
    if (response.status === 404) return 'Recurso não encontrado.';
    if (response.status === 500) return 'Erro interno do servidor.';
    
    return response.data?.message || defaultMsg;
}

export { api };
export default api;
