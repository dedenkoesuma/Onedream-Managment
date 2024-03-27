document.addEventListener('DOMContentLoaded', function() {
    new AutoNumeric('.input-mata-uang', {
        decimalPlaces: 2,
        decimalCharacter: ',',
        digitGroupSeparator: '.',
        modifyValueOnWheel: false,
    });
});
