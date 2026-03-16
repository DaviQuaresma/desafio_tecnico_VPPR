import { logoutApi } from '../api/auth.js';
import { getToken, saveToken, removeToken } from './token.js';

export { getToken, saveToken, removeToken };

export function checkAuthRedirect(redirectTo = '/dashboard') {
    if (getToken()) {
        window.location.href = redirectTo;
        return true;
    }
    return false;
}

export function requireAuth(redirectTo = '/login') {
    if (!getToken()) {
        window.location.href = redirectTo;
        return true;
    }
    return false;
}

export async function logout(redirectTo = '/login') {
    try {
        await logoutApi();
    } catch {}
    removeToken();
    window.location.href = redirectTo;
}
