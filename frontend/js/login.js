document.addEventListener('DOMContentLoaded', () => {
	const togglePasswordVisibility = (passwordField, icon) => {
	  if (passwordField.getAttribute('type') === 'password') {
		passwordField.setAttribute('type', 'text');
		icon.classList.remove('fa-eye');
		icon.classList.add('fa-eye-slash');
	  } else {
		passwordField.setAttribute('type', 'password');
		icon.classList.remove('fa-eye-slash');
		icon.classList.add('fa-eye');
	  }
	};
  
	const pass = document.getElementById('password');
	const icon2 = document.getElementById('pass-icon2');
	const passConfirm = document.getElementById('password-confirm');
	const icon = document.getElementById('pass-icon');

	icon.addEventListener('click', () => {
		togglePasswordVisibility(pass, icon);
	  });
  });