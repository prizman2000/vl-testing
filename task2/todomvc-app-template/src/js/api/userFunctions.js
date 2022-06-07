import {API_PATH} from "./api";

export async function authenticate(data) {
	const params = {
		method: 'POST',
		body: JSON.stringify(data),
		headers: {
			'Accept' : 'application/json',
			'Content-Type': 'application/json'
		}
	};
	const res = await fetch(`${API_PATH}?entity=user&action=authenticate`, {...params});
	return await res.json();
}

export async function register(data) {
	const params = {
		method: 'POST',
		body: JSON.stringify(data),
		headers: {
			'Accept' : 'application/json',
			'Content-Type': 'application/json'
		}
	};
	const res = await fetch(`${API_PATH}?entity=user&action=register`, {...params});
	return await res.json();
}
