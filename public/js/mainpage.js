// Hero car carousel data
const heroCarouselData = [
    {
        image: "image/hero-car.svg",
        color: "WHITE",
        production: "2020-present",
        maxSpeed: "37km/h",
        engine: "4.0 H0000T"
    },
    {
        image: "image/car-axia-2024-1.png",
        color: "SILVER",
        production: "2024",
        maxSpeed: "160km/h",
        engine: "1.0L DOHC"
    },
    {
        image: "image/car-myvi-2016.png",
        color: "RED",
        production: "2016",
        maxSpeed: "170km/h",
        engine: "1.5L DVVT"
    },
    {
        image: "image/car-bezza-2023-1.png",
        color: "BLUE",
        production: "2023",
        maxSpeed: "175km/h",
        engine: "1.3L Dual VVT-i"
    }
];


// DOM Elements
const carsGrid = document.getElementById('carsGrid');
const heroCarImg = document.querySelector('.hero-car-img');
const colorLabel = document.querySelector('.color-label');
const specValues = document.querySelectorAll('.spec-value');

// Hero carousel state
let currentSlide = 0;
const totalSlides = heroCarouselData.length;
const dots = document.querySelectorAll('.dot');
const prevBtn = document.querySelector('.nav-arrow.prev');
const nextBtn = document.querySelector('.nav-arrow.next');
let autoPlayInterval;

// Update hero car display
function updateHeroCar(index, animate = true) {
    const carData = heroCarouselData[index];

    if (!heroCarImg || !colorLabel || !specValues.length) return;

    if (animate) {
        // Slap the current car up and to the LEFT diagonally with rotation
        heroCarImg.style.transition = 'transform 0.5s cubic-bezier(0.87, 0, 0.13, 1), opacity 0.4s ease';
        heroCarImg.style.transform = 'translate(-120%, calc(-50% - 120%)) rotate(-25deg) scale(0.7)';
        heroCarImg.style.opacity = '0';

        // After the car is slapped away, bring in the next car
        setTimeout(() => {
            // Update image and specs while car is off-screen
            heroCarImg.src = carData.image;
            heroCarImg.alt = `${carData.color} Car`;
            colorLabel.textContent = carData.color;
            specValues[0].textContent = carData.production;
            specValues[1].textContent = carData.maxSpeed;
            specValues[2].textContent = carData.engine;

            // Position new car coming from bottom-RIGHT diagonally
            heroCarImg.style.transition = 'none';
            heroCarImg.style.transform = 'translate(80%, calc(-50% + 80%)) rotate(15deg) scale(0.8)';
            heroCarImg.style.opacity = '0';

            // Slide the new car into position diagonally with speed
            setTimeout(() => {
                heroCarImg.style.transition = 'transform 0.6s cubic-bezier(0.16, 1, 0.3, 1), opacity 0.5s ease';
                heroCarImg.style.transform = 'translate(0, 0) rotate(0deg) scale(1)';
                heroCarImg.style.opacity = '1';
            }, 20);
        }, 450);
    } else {
        // Initial load without animation
        heroCarImg.src = carData.image;
        heroCarImg.alt = `${carData.color} Car`;
        colorLabel.textContent = carData.color;
        specValues[0].textContent = carData.production;
        specValues[1].textContent = carData.maxSpeed;
        specValues[2].textContent = carData.engine;
        heroCarImg.style.transform = 'translate(0, 0) rotate(0deg) scale(1)';
        heroCarImg.style.opacity = '1';
    }
}

// Update navigation dots
function updateDots() {
    dots.forEach((dot, index) => {
        dot.classList.toggle('active', index === currentSlide);
    });
}

// Go to specific slide
function goToSlide(index, animate = true) {
    currentSlide = index;
    if (currentSlide < 0) currentSlide = totalSlides - 1;
    if (currentSlide >= totalSlides) currentSlide = 0;

    updateDots();
    updateHeroCar(currentSlide, animate);

    // Reset autoplay
    resetAutoPlay();
}

// Next slide
function nextSlide() {
    goToSlide(currentSlide + 1);
}

// Previous slide
function prevSlide() {
    goToSlide(currentSlide - 1);
}

// Auto-play functionality
function startAutoPlay() {
    autoPlayInterval = setInterval(() => {
        nextSlide();
    }, 5000);
}

function stopAutoPlay() {
    if (autoPlayInterval) {
        clearInterval(autoPlayInterval);
    }
}

function resetAutoPlay() {
    stopAutoPlay();
    startAutoPlay();
}

// Event listeners for carousel controls
if (prevBtn && nextBtn) {
    prevBtn.addEventListener('click', prevSlide);
    nextBtn.addEventListener('click', nextSlide);
}

dots.forEach((dot, index) => {
    dot.addEventListener('click', () => goToSlide(index));
});

// Pause autoplay on hover
const heroSection = document.querySelector('.hero');
if (heroSection) {
    heroSection.addEventListener('mouseenter', stopAutoPlay);
    heroSection.addEventListener('mouseleave', startAutoPlay);
}

// Keyboard navigation
document.addEventListener('keydown', (e) => {
    if (e.key === 'ArrowLeft') {
        prevSlide();
    } else if (e.key === 'ArrowRight') {
        nextSlide();
    }
});

// Scroll to car models section
function scrollToCarModels() {
    const carModelsSection = document.getElementById('car-rental');
    if (carModelsSection) {
        carModelsSection.scrollIntoView({ behavior: 'smooth' });
    }
}
window.scrollToCarModels = scrollToCarModels;

// Render car cards in grid
/* 
function renderCars() {
    if (!carsGrid) return;
    carsGrid.innerHTML = carsData.map(car => createCarCard(car)).join('');
}

// Create individual car card HTML
function createCarCard(car) {
    const availableButtons = `
        <button class="btn btn-rent" onclick="handleRent(${car.id})">Rent</button>
        <button class="btn btn-details" onclick="handleDetails(${car.id})">Details</button>
    `;

    const unavailableButton = `
        <button class="btn btn-unavailable" disabled>Not Available</button>
    `;

    return `
        <div class="car-card ${!car.available ? 'unavailable' : ''}">
            <div class="car-image">
                <img src="${car.image}" alt="${car.name}" loading="lazy">
            </div>
            <div class="car-info">
                <h3 class="car-name">${car.name}</h3>
                <div class="car-actions">
                    ${car.available ? availableButtons : unavailableButton}
                </div>
            </div>
        </div>
    `;
}

// Handle Rent button click
function handleRent(carId) {
    const car = carsData.find(c => c.id === carId);

    if (!car) return;

    // Redirect ONLY for Perodua Bezza 2023
    if (car.name === "Perodua Bezza 2023") {
        window.location.href = "/booking/calendar";
        return;
    }

    // Default behavior for other cars
    alert(`Renting: ${car.name}\n\nPlease login to continue with the rental process.`);
}

// Handle Details button click
function handleDetails(carId) {
    const car = carsData.find(c => c.id === carId);
    if (car) {
        alert(`${car.name}\n\nDetailed specifications and availability will be shown here.\n\nFeatures:\n• Air Conditioning\n• Bluetooth Audio\n• GPS Navigation\n• Fuel Efficient`);
    }
}
*/

// Scroll to car models section
function scrollToCarModels() {
    const carModelsSection = document.getElementById('car-rental');
    if (carModelsSection) {
        carModelsSection.scrollIntoView({ behavior: 'smooth' });
    }
}

// Smooth scroll for navigation links
function initSmoothScroll() {
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                target.scrollIntoView({ behavior: 'smooth' });
            }
        });
    });
}

// Rent & Details buttons (base DOM)
function initCarButtons() {
    document.querySelectorAll('.btn-rent').forEach(btn => {
        btn.addEventListener('click', () => {
            const name = btn.getAttribute('data-car-name') || 'this car';

            if (name.toLowerCase().includes('bezza') && name.includes('2023')) {
                window.location.href = "/booking/calendar";
            } else {
                alert(`Renting: ${name}\n\nPlease login to continue with the rental process.`);
            }
        });
    });

        document.querySelectorAll('.btn-details').forEach(btn => {
        btn.addEventListener('click', () => {
            const card = btn.closest('.car-card');
            if (!card) return;
            const details = card.querySelector('.car-details');
            if (!details) return;

            const isHidden = getComputedStyle(details).display === 'none';
            details.style.display = isHidden ? 'block' : 'none';
        });
    });
}

// Initialize on page load
document.addEventListener('DOMContentLoaded', () => {
    //renderCars();
    updateHeroCar(0, false); // Initialize first slide without animation
    updateDots();
    startAutoPlay();
    initSmoothScroll();
    initCarButtons();   
});

// Cleanup on page unload
window.addEventListener('beforeunload', () => {
    stopAutoPlay();
});