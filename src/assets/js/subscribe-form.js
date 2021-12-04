const signUpButton = document.getElementById('sign-up');

signUpButton.addEventListener('click', () => {
    const outerLoader = document.getElementById('outer-loader-id');
    outerLoader.style.display = 'block';
    signUpButton.style.display = 'none';
});