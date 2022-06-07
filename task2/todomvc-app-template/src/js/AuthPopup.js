import {authenticate, register} from "./api/userFunctions";
import {setToken} from "./api/api";
import {getTodos} from "./MainInfo";

const popupStates = {
	REGISTER : 'Register',
	AUTHENTICATE: 'Authenticate'
};

let submitForm = document.querySelector('.wrapper-container-content-form');
let stateLink = document.querySelector('.state-link');
let errorText = document.querySelector('.wrapper-container-content-form-error__text');
let inputs = document.querySelectorAll('.wrapper-container-content-form-input-field__area');
let popup = document.querySelector('.wrapper');

function changeStateOfPopup(state) {
	let titleText = document.querySelector('.wrapper-container-content-header__text');
	let buttonText = document.querySelector('.wrapper-container-content-form-button__area');
	let footerText = document.querySelector('.wrapper-container-content-footer__text');

	if (state === popupStates.REGISTER) {
		titleText.innerText = 'Welcome!';
		buttonText.innerText = 'Sign up';
		footerText.innerText = 'Been here before?';
		stateLink.innerText = 'Authenticate';
	} else if (state === popupStates.AUTHENTICATE) {
		titleText.innerText = 'You are here again...';
		buttonText.innerText = 'Sign in';
		footerText.innerText = 'First time here?';
		stateLink.innerText = 'Register';
	}
}

for (let i = 0; i < inputs.length; i++) {
	inputs[i].addEventListener('focus', (e) => {
		e.preventDefault();
		errorText.innerText = '';
	});
}

stateLink.addEventListener('click', (e) => {
	e.preventDefault();

	errorText.innerText = '';
	inputs[0].value = '';
	inputs[1].value = '';
	if (e.target.innerText === popupStates.REGISTER) {
		changeStateOfPopup(popupStates.REGISTER);
	} else if (e.target.innerText === popupStates.AUTHENTICATE) {
		changeStateOfPopup(popupStates.AUTHENTICATE);
	}
});

submitForm.addEventListener('submit', (e) => {
	e.preventDefault();

	if (e.target[0].value && e.target[1].value) {
		if (stateLink.innerText === popupStates.REGISTER) {
			authenticate({"login": e.target[0].value, "password" : e.target[1].value})
				.then((res) => {
					if (res.error) {
						errorText.innerText = res.error;
					} else {
						setToken(res.token);
						getTodos();
						popup.style.display = 'none';
					}
				});
		} else {
			register({"login": e.target[0].value, "password" : e.target[1].value})
				.then((res) => {
					if (res.error) {
						errorText.innerText = res.error;
					} else {
						errorText.innerText = 'User successfully registered';
					}
				});
		}
	} else {
		errorText.innerText = 'Invalid login or password'
	}
});


