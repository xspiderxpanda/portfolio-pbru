window.addEventListener('keydown', function(event) {
    if (event.keyCode == 123) { 
        alert('การ Debugging ถูกปิดกั้น');
        event.preventDefault();
    }
});


document.addEventListener('contextmenu', function (event) {
    event.preventDefault();
    Swal.fire({
        icon: 'error',
        title: 'Oops...',
        text: 'Right click is disabled!'
    });
});
document.addEventListener('keydown', function (event) {
    if (event.ctrlKey) {
        event.preventDefault();
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: 'Ctrl key is disabled!'
        });
    }
});
document.addEventListener('keydown', function (event) {
    if (event.metaKey) {
        event.preventDefault();
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: 'Command key is disabled!'
        });
    }
});
function detectDevTools() {
    const devTools = /./;
    devTools.toString = () => {
        debugger;
        return '';
    };
    console.log('%c', devTools);
}
detectDevTools();