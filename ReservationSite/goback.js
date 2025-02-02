function saveCurrentPage() {
    localStorage.setItem('previousPage', window.location.href);
}

function goBack() {
    const previousPage = localStorage.getItem('previousPage');
    if (previousPage) {
        window.location.href = previousPage;
    } else {
        window.history.back();
    }
}