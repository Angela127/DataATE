// Booking Confirmation JavaScript

document.addEventListener('DOMContentLoaded', function () {
    initializePaymentOptions();
});

// Initialize payment options
function initializePaymentOptions() {
    const options = document.querySelectorAll('.payment-option');

    options.forEach(option => {
        const input = option.querySelector('input[type="radio"]');

        option.addEventListener('click', function () {
            // Remove selected from all
            options.forEach(opt => opt.classList.remove('selected'));
            // Add selected to clicked one
            this.classList.add('selected');
            input.checked = true;
        });
    });
}

// Go back
function goBack() {
    window.history.back();
}

// Edit booking - go back to calendar
function editBooking() {
    window.location.href = '/booking/calendar';
}

function proceedToPayment() {
    if (typeof PICKUP_URL !== 'undefined') {
        window.location.href = PICKUP_URL;
    } else {
        console.error("PICKUP_URL is not defined");
    }
}

// Show notification
function showNotification(message, type = 'info') {
    // Remove existing notifications
    const existingNotification = document.querySelector('.notification');
    if (existingNotification) {
        existingNotification.remove();
    }

    const notification = document.createElement('div');
    notification.className = `notification notification-${type}`;
    notification.textContent = message;
    notification.style.cssText = `
        position: fixed;
        top: 20px;
        left: 50%;
        transform: translateX(-50%);
        padding: 12px 24px;
        border-radius: 8px;
        font-family: 'Sen', sans-serif;
        font-size: 14px;
        z-index: 1000;
        animation: slideDown 0.3s ease-out;
        ${type === 'error' ? 'background: #E75B5B; color: white;' :
            type === 'success' ? 'background: #06D23F; color: white;' :
                'background: #14213D; color: white;'}
    `;

    document.body.appendChild(notification);

    setTimeout(() => {
        notification.style.animation = 'fadeOut 0.3s ease-out';
        setTimeout(() => notification.remove(), 300);
    }, 3000);
}

// Add animation styles
const style = document.createElement('style');
style.textContent = `
    @keyframes slideDown {
        from {
            opacity: 0;
            transform: translate(-50%, -20px);
        }
        to {
            opacity: 1;
            transform: translate(-50%, 0);
        }
    }
    
    @keyframes fadeOut {
        to {
            opacity: 0;
            transform: translate(-50%, -10px);
        }
    }
`;
document.head.appendChild(style);
