document.addEventListener('DOMContentLoaded', () => {
    const menuButton = document.getElementById('menu-button');
    const sideMenu = document.getElementById('side-menu');
    const closeButton = document.getElementById('close-button');
    const viewResultPopup = document.getElementById('view-result-popup');
    const closePopup = document.getElementById('close-popup');
    const viewResultLink = document.getElementById('view-result-link');

    // Menu functionality
    if (menuButton) {
        menuButton.addEventListener('click', () => {
            sideMenu.classList.toggle('-translate-x-full');
        });
    } else {
        console.error('menuButton element not found!');
    }

    if (closeButton) {
        closeButton.addEventListener('click', () => {
            sideMenu.classList.add('-translate-x-full');
        });
    } else {
        console.error('closeButton element not found!');
    }

    // View result popup functionality
    if (viewResultLink) {
        viewResultLink.addEventListener('click', (event) => {
            event.preventDefault(); // Prevent the default link behavior
            viewResultPopup.style.display = 'flex';
        });
    } else {
        console.error('viewResultLink element not found!');
    }

    if (closePopup) {
        closePopup.addEventListener('click', () => {
            viewResultPopup.style.display = 'none';
        });
    } else {
        console.error('closePopup element not found!');
    }

    if (viewResultPopup) {
        viewResultPopup.addEventListener('click', (event) => {
            if (event.target === viewResultPopup) {
                viewResultPopup.style.display = 'none';
            }
        });
    } else {
        console.error('viewResultPopup element not found!');
    }

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

    // Close the result section
    const closeResultButton = document.getElementById('close-result');
    if (closeResultButton) {
        closeResultButton.addEventListener('click', function () {
            const resultContainer = this.closest('.bg-white.shadow-md'); // Get the closest result container
            if (resultContainer) {
                resultContainer.style.display = 'none'; // Hide the result container
            } else {
                console.error('Result container not found!');
            }
        });
    } else {
        console.error('closeResultButton element not found!');
    }
});
