import {fetchAddTodo, fetchCompleteTodo, fetchDeleteTodo, fetchTodos} from "./api/todoFunctions";

const todosContainer = document.querySelector('.todo-list');
const paramLinks = document.querySelectorAll('.param-link');
const mainInput = document.querySelector('.new-todo');
const itemLeft = document.querySelector('.item-left');
const clearCompleted = document.querySelector('.clear-completed');
let todos = null;
let param = 'All';
let itemsCount = 0;

mainInput.addEventListener('keyup', (e) => {
	if ((e.key === 'Enter' || e.keyCode === 13) && e.target.value.trim().length) {
		addTodo(e.target.value);
		e.target.value = '';
	}
});

clearCompleted.addEventListener('click', (e) => {
	e.preventDefault();

	todos.forEach((todo) => {
		if (todo.is_complete) {
			deleteTodo(todo.id);
		}
	});
});

for (let i = 0; i < paramLinks.length; i++) {
	paramLinks[0].classList.add('selected');
	paramLinks[i].addEventListener('click', (e) => {
		e.preventDefault();

		param = e.target.text;
		paramLinks[0].classList.remove('selected');
		paramLinks[1].classList.remove('selected');
		paramLinks[2].classList.remove('selected');
		paramLinks[i].classList.add('selected');
		renderTodos();
	});
}

function createTodoStr(todo) {
	let checked = todo.is_complete ? 'checked' : '';
	let completed = checked ? 'completed' : '';
	let description = todo.description;
	return `<li class="${completed}"><div class="view"><input class="toggle" type="checkbox" ${checked}><label>${description}</label><button class="destroy"></button></div><input class="edit" value="Create a TodoMVC template"></li>`;
}

function createTodoElement(todo) {
	let str = createTodoStr(todo);
	let div = document.createElement('div');
	div.innerHTML = str.trim();
	return div.firstChild;
}

function appendTodo(todo) {
	if (param === 'Active' && !todo.is_complete) {
		todosContainer.appendChild(
			createTodoElement(todo)
		);
	} else if (param === 'Completed' && todo.is_complete) {
		todosContainer.appendChild(
			createTodoElement(todo)
		);
	} else if (param === 'All') {
		todosContainer.appendChild(
			createTodoElement(todo)
		);
	}
	itemsCount += !todo.is_complete;
}

function refreshLinks() {
	let deleteBtn = document.querySelectorAll('.destroy');
	let completeBtn = document.querySelectorAll('.toggle');
	console.log(deleteBtn, 'alo');
	for (let i = 0; i < todos.length; i++) {
		deleteBtn[i].addEventListener('click', (e) => {
			e.preventDefault();
			deleteTodo(todos[i].id);
		});
		completeBtn[i].addEventListener('click', (e) => {
			e.preventDefault();
			completeTodo(todos[i].id, !todos[i].is_complete);
		});
	}
}

function clearTodos() {
	itemsCount = 0;
	todosContainer.innerHTML = '';
}

function addTodo(description) {
	fetchAddTodo({description: description})
		.then((res) => {
			console.log(res);
			getTodos();
		});
}

function deleteTodo(id) {
	fetchDeleteTodo({id: id})
		.then((res) => {
			console.log(res);
			getTodos();
		});
}

function completeTodo(id, complete) {
	fetchCompleteTodo({id: id, complete: complete})
		.then((res) => {
			console.log(res);
			getTodos();
		});
}

function renderTodos() {
	clearTodos();
	todos.forEach((todo) => {
		appendTodo(todo);
	});
	refreshLinks();
	itemLeft.innerText = itemsCount;
}

export function getTodos() {
	fetchTodos()
		.then((res) => {
			todos = res.data;
			renderTodos();
		});
}


