import './bootstrap';
import './script.js';

// phone mask
$('.phone-mask').mask('(00) 00000-0000');

$('.phone-mask').on('change', function() {
    $('.phone-mask').mask('(00) 00000-0000');
});
