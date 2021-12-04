const cancelButton = document.getElementById("cancel");
cancelButton.addEventListener("click", (event) => {
    event.stopPropagation();
    event.preventDefault();
    window.location.replace('/');
});