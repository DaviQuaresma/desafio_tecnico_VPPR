import api from './index.js';

const URL = '/services';

export async function getServices() {
    const response = await api.get(URL);
    const data = response.data;
    return Array.isArray(data) ? data : (data.data || []);
}

export async function getService(id) {
    const response = await api.get(`${URL}/${id}`);
    return response.data.service || response.data;
}

export async function createService(data) {
    const response = await api.post(URL, data);
    return response.data;
}

export async function updateService(id, data) {
    const response = await api.put(`${URL}/${id}`, data);
    return response.data;
}

export async function deleteService(id) {
    const response = await api.delete(`${URL}/${id}`);
    return response.data;
}
