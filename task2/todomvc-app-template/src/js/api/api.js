export const API_PATH = 'http://localhost/api';

export function getToken() {
	let name = 'token';
	let matches = document.cookie.match(new RegExp(
		"(?:^|; )" + name.replace(/([\.$?*|{}\(\)\[\]\\\/\+^])/g, '\\$1') + "=([^;]*)"
	));
	return matches ? decodeURIComponent(matches[1]) : undefined;
}

export function setToken(value) {
	document.cookie = encodeURIComponent('token') + "=" + encodeURIComponent(value);
}
