const registerForm = document.getElementById('form-register');


registerForm.addEventListener('submit', (event) => {
	const formData = new FormData(registerForm);

	if (
		!formData.get('userFirstName')
		|| !formData.get('userName')
		|| !formData.get('userMail')
		|| !formData.get('userPassword')
		|| !formData.get('userPassword2')
	) {
		event.preventDefault();

		const errorMessage = document.getElementById('not-all-fields-error');
		errorMessage.classList.add('visible');
	} else if (formData.get('userPassword') !== formData.get('userPassword2')) {
		event.preventDefault();

		const passwordMessage = document.getElementById('password-match-error');
		passwordMessage.classList.add('visible');

		for (let passwordInput of document.getElementsByClassName(
			'form-register-password',
		)) {
			passwordInput.oninput = () => {
				passwordMessage.classList.remove('visible');
			}
		}
	}
});

