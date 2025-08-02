$(() => {
    var toasts= []
    $('toasts').each(function (i, toastElem) {
        toasts.push(new bootstrap.Toast(toastElem))
    })

    $.each(toasts, (i, toast) => {
        toast.show()
    })
});