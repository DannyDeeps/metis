var ready= (callback) => {
    if (document.readyState != 'loading') callback();
    else document.addEventListener("DOMContentLoaded", callback);
}

ready(() => {
    var toastElList = [].slice.call(document.querySelectorAll('.toast'))
    var toastList = toastElList.map(function (toastEl) {
        return new bootstrap.Toast(toastEl, { autohide: false })
    })

    toastList.forEach(toast => {
        toast.show();
    });


});