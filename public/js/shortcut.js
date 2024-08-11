let typedKeys = '';

document.addEventListener('keydown', function (e) {
    typedKeys += e.key;

    if (typedKeys.toLowerCase().endsWith('admin')) {
        e.preventDefault();
        window.location.href = '/dashboard'; 
        typedKeys = ''; 
    }
    
    if (typedKeys.length > 10) {
        typedKeys = typedKeys.slice(-10);
    }
});
