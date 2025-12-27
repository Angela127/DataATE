// Booking Confirmation JavaScript

document.addEventListener('DOMContentLoaded', function () {
    console.log('=== CONFIRM PAGE LOADED ===');
    initializePaymentOptions();
<<<<<<< Updated upstream
    
    // Calculate surcharge after page loads
    setTimeout(() => {
        const surcharge = calculateLocationSurcharge();
        if (surcharge > 0) {
            showNotification(`Additional location charge: RM${surcharge.toFixed(2)}`, 'info');
        }
    }, 100);
=======

    const surcharge = calculateLocationSurcharge();

    if (surcharge > 0) {
        showNotification(`Additional location charge: RM${surcharge}`, 'info');
    }
>>>>>>> Stashed changes
});


// Initialize payment options
function initializePaymentOptions() {
    const options = document.querySelectorAll('.payment-option');

    options.forEach(option => {
        const input = option.querySelector('input[type="radio"]');

        option.addEventListener('click', function () {
            options.forEach(opt => opt.classList.remove('selected'));
            this.classList.add('selected');
            input.checked = true;
        });
    });
}


// Go back
function goBack() {
   window.location.href = "{{ route('booking.calendar') }}";
}

// Edit booking - go back to calendar with all parameters
function editBooking() {
<<<<<<< Updated upstream
    const urlParams = new URLSearchParams(window.location.search);
    
=======
    // Get all the booking data from the current page
    const urlParams = new URLSearchParams(window.location.search);
    
    // Build the URL with all booking parameters
>>>>>>> Stashed changes
    const params = new URLSearchParams({
        car: urlParams.get('car') || '',
        destination: urlParams.get('destination') || '',
        Pickup: urlParams.get('Pickup') || '',
        Return: urlParams.get('Return') || '',
        start_time: urlParams.get('start_time') || '',
        end_time: urlParams.get('end_time') || '',
        pickup_lat: urlParams.get('pickup_lat') || '',
        pickup_lng: urlParams.get('pickup_lng') || '',
        return_lat: urlParams.get('return_lat') || '',
        return_lng: urlParams.get('return_lng') || '',
        destination_lat: urlParams.get('destination_lat') || '',
        destination_lng: urlParams.get('destination_lng') || ''
    });
    
    // Remove empty parameters
    for (let [key, value] of [...params.entries()]) {
        if (!value) {
            params.delete(key);
        }
    }
    
<<<<<<< Updated upstream
    console.log('Editing with params:', Object.fromEntries(params));
    window.location.href = '/booking/calendar?' + params.toString();
}

// Calculate location surcharge and update total
function calculateLocationSurcharge() {
    const urlParams = new URLSearchParams(window.location.search);
    
    const pickup = (urlParams.get('Pickup') || '').toLowerCase().trim();
    const dropoff = (urlParams.get('Return') || '').toLowerCase().trim();
    
    console.log('=== CALCULATING SURCHARGE ===');
    console.log('Pickup:', pickup);
    console.log('Return:', dropoff);
    
    let surcharge = 0;
    
    // Check pickup location
    if (pickup && pickup !== 'student mall') {
        surcharge += 10;
        console.log('Pickup surcharge: +RM10');
    }
    
    // Check return location
    if (dropoff && dropoff !== 'student mall') {
        surcharge += 10;
        console.log('Return surcharge: +RM10');
    }
    
    console.log('Total surcharge: RM' + surcharge);
    
    // Get current prices from data attributes
    const bookingPriceEl = document.getElementById('bookingPrice');
    const depositEl = document.getElementById('depositAmount');
    
    if (!bookingPriceEl || !depositEl) {
        console.error('Price elements not found!');
        return surcharge;
    }
    
    const bookingPrice = parseFloat(bookingPriceEl.dataset.value) || 0;
    const deposit = parseFloat(depositEl.dataset.value) || 0;
    
    console.log('Booking Price:', bookingPrice);
    console.log('Deposit:', deposit);
    
    // Update Add-ons field
    const addonsEl = document.getElementById('addonsAmount');
    if (addonsEl) {
        addonsEl.textContent = 'RM' + surcharge.toFixed(2);
        console.log('✓ Add-ons updated to: RM' + surcharge.toFixed(2));
    } else {
        console.error('Add-ons element not found!');
    }
    
    // Calculate new total
    const newTotal = bookingPrice + deposit + surcharge;
    console.log('Calculation: ' + bookingPrice + ' + ' + deposit + ' + ' + surcharge + ' = ' + newTotal);
    
    // Update Total field
    const totalEl = document.getElementById('totalAmount');
    if (totalEl) {
        totalEl.textContent = 'RM' + newTotal.toFixed(2);
        console.log('✓ Total updated to: RM' + newTotal.toFixed(2));
    } else {
        console.error('Total element not found!');
    }
    
    return surcharge;
=======
    console.log('Editing booking with params:', Object.fromEntries(params));
    
    // Navigate back to calendar with data
    window.location.href = '/booking/calendar?' + params.toString();
>>>>>>> Stashed changes
}

function calculateLocationSurcharge() {
    const urlParams = new URLSearchParams(window.location.search);

    const pickup = (urlParams.get('Pickup') || '').toLowerCase().trim();
    const dropoff = (urlParams.get('Return') || '').toLowerCase().trim();

    let surcharge = 0;

    if (pickup && pickup !== 'student mall') {
        surcharge += 10;
    }

    if (dropoff && dropoff !== 'student mall') {
        surcharge += 10;
    }

    console.log('📍 Pickup:', pickup);
    console.log('📍 Return:', dropoff);
    console.log('💰 Location surcharge: RM' + surcharge);

    return surcharge;
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