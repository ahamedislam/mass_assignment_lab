// Matrix background effect
function createMatrixBackground() {
    const canvas = document.createElement('canvas');
    canvas.classList.add('matrix-bg');
    document.body.appendChild(canvas);

    const ctx = canvas.getContext('2d');

    // Set canvas dimensions
    canvas.width = window.innerWidth;
    canvas.height = window.innerHeight;

    // Characters to display
    const characters = '01アイウエオカキクケコサシスセソタチツテトナニヌネノハヒフヘホマミムメモヤユヨラリルレロワヲン';
    const columns = Math.floor(canvas.width / 20); // Character width

    // Array to track the y position of each column
    const drops = [];
    for (let i = 0; i < columns; i++) {
        drops[i] = Math.random() * -100;
    }

    // Draw the characters
    function draw() {
        // Black semi-transparent background to create trail effect
        ctx.fillStyle = 'rgba(0, 0, 0, 0.05)';
        ctx.fillRect(0, 0, canvas.width, canvas.height);

        ctx.fillStyle = '#0f0'; // Green text
        ctx.font = '15px Fira Code';

        // Loop through each drop
        for (let i = 0; i < drops.length; i++) {
            // Choose a random character
            const text = characters.charAt(Math.floor(Math.random() * characters.length));

            // Draw the character
            ctx.fillText(text, i * 20, drops[i] * 20);

            // Reset drop position if it's at the bottom or randomly
            if (drops[i] * 20 > canvas.height && Math.random() > 0.975) {
                drops[i] = 0;
            }

            // Move the drop down
            drops[i]++;
        }
    }

    // Run the animation
    setInterval(draw, 50);

    // Resize canvas when window is resized
    window.addEventListener('resize', () => {
        canvas.width = window.innerWidth;
        canvas.height = window.innerHeight;
    });
}

// Typing effect with JavaScript (for elements with class 'js-typing')
function typingEffect(element, text, speed = 50) {
    let i = 0;
    element.innerHTML = '';

    function type() {
        if (i < text.length) {
            element.innerHTML += text.charAt(i);
            i++;
            setTimeout(type, speed);
        }
    }

    type();
}

// Initialize effects when DOM is loaded
document.addEventListener('DOMContentLoaded', () => {
    // Create matrix background
    createMatrixBackground();

    // Apply JavaScript typing effect only to elements with class 'js-typing'
    // (Elements with just 'typing' class will use CSS animation)
    const jsTypingElements = document.querySelectorAll('.js-typing');
    jsTypingElements.forEach(element => {
        const text = element.getAttribute('data-text') || element.textContent;
        typingEffect(element, text);
    });

    // Add glitch effect to success message if present
    const successMessage = document.querySelector('.success-message');
    if (successMessage) {
        setInterval(() => {
            successMessage.style.textShadow = `
                ${Math.random() * 10 - 5}px ${Math.random() * 10 - 5}px ${Math.random() * 10}px rgba(0, 255, 0, 0.7),
                ${Math.random() * 10 - 5}px ${Math.random() * 10 - 5}px ${Math.random() * 10}px rgba(255, 0, 255, 0.7)
            `;
        }, 100);
    }
});
