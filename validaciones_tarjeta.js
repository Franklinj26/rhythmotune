document.addEventListener('DOMContentLoaded', () => {
    const tarjetaInput = document.querySelector('input[name="tarjeta"]');
    const fechaInput = document.querySelector('input[name="fecha_caducidad"]');
    const cvvInput = document.querySelector('input[name="cvv"]');

    tarjetaInput.addEventListener('input', () => {
        tarjetaInput.value = tarjetaInput.value.replace(/\D/g, '');
    });

    cvvInput.addEventListener('input', () => {
        cvvInput.value = cvvInput.value.replace(/\D/g, '');
    });

    fechaInput.addEventListener('input', () => {
        let value = fechaInput.value.replace(/\D/g, '');

        if (value.length > 4) {
            value = value.slice(0, 4);
        }

        if (value.length >= 2) {
            value = value.slice(0, 2) + '/' + value.slice(2);
        }

        fechaInput.value = value;
    });

    const form = document.querySelector('form');
    form.addEventListener('submit', (e) => {
        const [mes, anio] = fechaInput.value.split('/');

        const mesNum = parseInt(mes, 10);
        const anioNum = parseInt(anio, 10);
        const currentYear = new Date().getFullYear() % 100;

        if (isNaN(mesNum) || mesNum < 1 || mesNum > 12) {
            e.preventDefault();
            const error = encodeURIComponent('Mes inválido. Debe estar entre 01 y 12.');
            window.location.href = `procesar_pago.php?error=${error}&tarjeta=${tarjeta}&fecha_caducidad=${fecha}&cvv=${cvv}`;
            return;
        }

        if (isNaN(anioNum) || anioNum < currentYear) {
            e.preventDefault();
            const error = encodeURIComponent(`Año inválido. Debe ser igual o mayor a ${currentYear}.`);
            window.location.href = `procesar_pago.php?error=${error}&tarjeta=${tarjeta}&fecha_caducidad=${fecha}&cvv=${cvv}`;
            return;
        }
    });
});
