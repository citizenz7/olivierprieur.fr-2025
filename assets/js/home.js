import '../styles/home.css';

const anchor = "{{ anchor|default('') }}";
if (anchor) {
    document.getElementById(anchor).scrollIntoView();
}