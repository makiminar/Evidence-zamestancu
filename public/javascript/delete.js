function buildMessage(element) {
    let action = element.getAttribute('data-confirm');
    let name = element.getAttribute('data-name');
    return 'Are you sure you want to ' + action + ' ' + name + '?';
}

document.addEventListener("DOMContentLoaded", function() {
    let deleteLink = document.getElementsByClassName('delete-link')[0];
    if (deleteLink) {
        deleteLink.addEventListener('click', (e) => {
            let modal = document.getElementById('delete-modal');
            document.getElementById('delete-modal-message').innerText = buildMessage(deleteLink)
            modal.showModal();
            document.getElementById('delete-modal-cancel').addEventListener('click', () => {
                modal.close();
            });
            document.getElementById('delete-modal-confirm').addEventListener('click', () => {
                modal.close();
                let form = deleteLink.parentElement.getElementsByTagName('form')[0];
                form.submit();
            });
        })
    }
});