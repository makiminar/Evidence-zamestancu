document.addEventListener("DOMContentLoaded", function() {
    let deleteLink = document.getElementsByClassName('delete-link')[0];
    deleteLink.addEventListener('click', (e) => {
        let form = deleteLink.parentElement.getElementsByTagName('form')[0];
        form.submit();
    })
});