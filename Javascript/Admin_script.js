// Subscribe form functionality
const subscribeForm = document.getElementById('subscribeForm');
if (subscribeForm) {
    subscribeForm.addEventListener('submit', function (e) {
        e.preventDefault();
        const email = document.getElementById('email').value;
        if (email) {
            alert(`Thank you for subscribing to updates, ${email}!`);
            document.getElementById('email').value = ''; // Clear input
        } else {
            alert('Please enter a valid email address.');
        }
    });
} else {
    console.error('subscribeForm element not found!');
}
