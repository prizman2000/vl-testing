import {API_PATH, getToken} from "./api";

export async function fetchTodos() {
	const params = {
		method: 'GET',
		headers: {
			'Authorization' : `Bearer ${getToken()}`,
			'Accept' : 'application/json',
			'Content-Type': 'application/json'
		}
	};
	const res = await fetch(`${API_PATH}?entity=post&action=get`, {...params});
	return await res.json();
}

export async function fetchAddTodo(data) {
	const params = {
		method: 'POST',
		body: JSON.stringify(data),
		headers: {
			'Authorization' : `Bearer ${getToken()}`,
			'Accept' : 'application/json',
			'Content-Type': 'application/json'
		}
	};
	const res = await fetch(`${API_PATH}?entity=post&action=add`, {...params});
	return await res.json();
}

export async function fetchDeleteTodo(data) {
	const params = {
		method: 'POST',
		body: JSON.stringify(data),
		headers: {
			'Authorization' : `Bearer ${getToken()}`,
			'Accept' : 'application/json',
			'Content-Type': 'application/json'
		}
	};
	const res = await fetch(`${API_PATH}?entity=post&action=delete`, {...params});
	return await res.json();
}

export async function fetchCompleteTodo(data) {
	const params = {
		method: 'POST',
		body: JSON.stringify(data),
		headers: {
			'Authorization' : `Bearer ${getToken()}`,
			'Accept' : 'application/json',
			'Content-Type': 'application/json'
		}
	};
	const res = await fetch(`${API_PATH}?entity=post&action=complete`, {...params});
	return await res.json();
}
