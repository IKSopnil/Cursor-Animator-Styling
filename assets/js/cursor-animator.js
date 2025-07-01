/**
 * Cursor Animator - WordPress Plugin
 * Handles various cursor animation effects
 */

(function () {
    'use strict';

    // Check if settings are available
    if (typeof cursorAnimatorSettings === 'undefined') {
        console.warn('Cursor Animator: Settings not found');
        return;
    }

    // Check if mobile and mobile is disabled
    if (!cursorAnimatorSettings.enableOnMobile && /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent)) {
        return;
    }

    const settings = cursorAnimatorSettings;
    let animationInstance = null;

    // Base Animation Class
    class BaseAnimation {
        constructor(settings) {
            this.settings = settings;
            this.isActive = false;
            this.init();
        }

        init() {
            // Create canvas overlay
            this.createCanvas();
            this.bindEvents();
            this.isActive = true;
        }

        createCanvas() {
            this.canvas = document.createElement('canvas');
            this.ctx = this.canvas.getContext('2d');

            // Style canvas
            this.canvas.style.position = 'fixed';
            this.canvas.style.top = '0';
            this.canvas.style.left = '0';
            this.canvas.style.width = '100%';
            this.canvas.style.height = '100%';
            this.canvas.style.pointerEvents = 'none';
            this.canvas.style.zIndex = '9999';
            this.canvas.style.mixBlendMode = 'multiply';

            // Set canvas size
            this.resizeCanvas();

            // Add to DOM
            document.body.appendChild(this.canvas);

            // Handle resize
            window.addEventListener('resize', () => this.resizeCanvas());
        }

        resizeCanvas() {
            this.canvas.width = window.innerWidth;
            this.canvas.height = window.innerHeight;
        }

        bindEvents() {
            // Mouse events
            document.addEventListener('mousemove', (e) => this.onMouseMove(e));
            document.addEventListener('mouseenter', () => this.onMouseEnter());
            document.addEventListener('mouseleave', () => this.onMouseLeave());

            // Touch events for mobile
            if (this.settings.enableOnMobile) {
                document.addEventListener('touchstart', (e) => this.onTouchStart(e));
                document.addEventListener('touchmove', (e) => this.onTouchMove(e));
                document.addEventListener('touchend', () => this.onTouchEnd());
            }
        }

        onMouseMove(e) {
            // Override in child classes
        }

        onMouseEnter() {
            this.isActive = true;
        }

        onMouseLeave() {
            this.isActive = false;
            this.clearCanvas();
        }

        onTouchStart(e) {
            const touch = e.touches[0];
            this.onMouseMove({
                clientX: touch.clientX,
                clientY: touch.clientY
            });
        }

        onTouchMove(e) {
            const touch = e.touches[0];
            this.onMouseMove({
                clientX: touch.clientX,
                clientY: touch.clientY
            });
        }

        onTouchEnd() {
            this.onMouseLeave();
        }

        clearCanvas() {
            this.ctx.clearRect(0, 0, this.canvas.width, this.canvas.height);
        }

        destroy() {
            if (this.canvas && this.canvas.parentNode) {
                this.canvas.parentNode.removeChild(this.canvas);
            }
            this.isActive = false;
        }
    }

    // Trail Effect
    class TrailEffect extends BaseAnimation {
        constructor(settings) {
            super(settings);
            this.trail = [];
            this.maxTrailLength = parseInt(settings.trailLength) || 20;
        }

        onMouseMove(e) {
            if (!this.isActive) return;

            const x = e.clientX;
            const y = e.clientY;

            // Add new position to trail
            this.trail.push({ x, y, timestamp: Date.now() });

            // Limit trail length
            if (this.trail.length > this.maxTrailLength) {
                this.trail.shift();
            }

            this.drawTrail();
        }

        drawTrail() {
            this.clearCanvas();

            if (this.trail.length < 2) return;

            const ctx = this.ctx;
            const trailSize = parseInt(this.settings.trailSize) || 8;
            const trailColor = this.settings.trailColor || '#ff6b6b';

            ctx.lineCap = 'round';
            ctx.lineJoin = 'round';

            // Draw trail segments
            for (let i = 1; i < this.trail.length; i++) {
                const alpha = i / this.trail.length;
                const size = trailSize * alpha;

                ctx.strokeStyle = trailColor;
                ctx.globalAlpha = alpha;
                ctx.lineWidth = size;

                ctx.beginPath();
                ctx.moveTo(this.trail[i - 1].x, this.trail[i - 1].y);
                ctx.lineTo(this.trail[i].x, this.trail[i].y);
                ctx.stroke();
            }

            ctx.globalAlpha = 1;
        }

        onMouseLeave() {
            super.onMouseLeave();
            this.trail = [];
        }
    }

    // Particle Effect
    class ParticleEffect extends BaseAnimation {
        constructor(settings) {
            super(settings);
            this.particles = [];
            this.maxParticles = 50;
            this.lastParticleTime = 0;
        }

        onMouseMove(e) {
            if (!this.isActive) return;

            const now = Date.now();
            // Create particles more frequently (every 50ms instead of every mouse move)
            if (now - this.lastParticleTime > 50) {
                // Create new particles
                for (let i = 0; i < 2; i++) {
                    this.createParticle(e.clientX, e.clientY);
                }
                this.lastParticleTime = now;
            }

            // Start drawing if not already running
            if (!this.isDrawing) {
                this.isDrawing = true;
                this.drawParticles();
            }
        }

        createParticle(x, y) {
            if (this.particles.length >= this.maxParticles) {
                this.particles.shift();
            }

            const speed = parseFloat(this.settings.animationSpeed) || 0.8;
            const particle = {
                x: x + (Math.random() - 0.5) * 30,
                y: y + (Math.random() - 0.5) * 30,
                vx: (Math.random() - 0.5) * 6 * speed,
                vy: (Math.random() - 0.5) * 6 * speed,
                life: 1.0,
                decay: (0.015 + Math.random() * 0.02) * speed,
                size: Math.random() * 8 + 3,
                color: this.settings.trailColor || '#ff6b6b'
            };

            this.particles.push(particle);
        }

        drawParticles() {
            this.clearCanvas();

            const ctx = this.ctx;

            for (let i = this.particles.length - 1; i >= 0; i--) {
                const particle = this.particles[i];

                // Update particle
                particle.x += particle.vx;
                particle.y += particle.vy;
                particle.life -= particle.decay;

                // Remove dead particles
                if (particle.life <= 0) {
                    this.particles.splice(i, 1);
                    continue;
                }

                // Draw particle
                ctx.globalAlpha = particle.life;
                ctx.fillStyle = particle.color;
                ctx.beginPath();
                ctx.arc(particle.x, particle.y, particle.size * particle.life, 0, Math.PI * 2);
                ctx.fill();
            }

            ctx.globalAlpha = 1;

            // Continue animation
            if (this.isActive && this.particles.length > 0) {
                requestAnimationFrame(() => this.drawParticles());
            } else {
                this.isDrawing = false;
            }
        }

        onMouseLeave() {
            super.onMouseLeave();
            this.particles = [];
            this.isDrawing = false;
        }
    }

    // Ripple Effect
    class RippleEffect extends BaseAnimation {
        constructor(settings) {
            super(settings);
            this.ripples = [];
            this.lastRippleTime = 0;
        }

        onMouseMove(e) {
            if (!this.isActive) return;

            const now = Date.now();
            // Create ripple more frequently (every 200ms instead of random)
            if (now - this.lastRippleTime > 200) {
                this.createRipple(e.clientX, e.clientY);
                this.lastRippleTime = now;
            }

            // Start drawing if not already running
            if (!this.isDrawing) {
                this.isDrawing = true;
                this.drawRipples();
            }
        }

        createRipple(x, y) {
            const speed = parseFloat(this.settings.animationSpeed) || 0.8;
            const ripple = {
                x: x,
                y: y,
                radius: 0,
                maxRadius: 120,
                life: 1.0,
                decay: 0.015 * speed,
                color: this.settings.trailColor || '#ff6b6b'
            };

            this.ripples.push(ripple);
        }

        drawRipples() {
            this.clearCanvas();

            const ctx = this.ctx;
            const speed = parseFloat(this.settings.animationSpeed) || 0.8;

            for (let i = this.ripples.length - 1; i >= 0; i--) {
                const ripple = this.ripples[i];

                // Update ripple
                ripple.radius += 3 * speed;
                ripple.life -= ripple.decay;

                // Remove dead ripples
                if (ripple.life <= 0 || ripple.radius > ripple.maxRadius) {
                    this.ripples.splice(i, 1);
                    continue;
                }

                // Draw ripple
                ctx.globalAlpha = ripple.life;
                ctx.strokeStyle = ripple.color;
                ctx.lineWidth = 3;
                ctx.beginPath();
                ctx.arc(ripple.x, ripple.y, ripple.radius, 0, Math.PI * 2);
                ctx.stroke();
            }

            ctx.globalAlpha = 1;

            // Continue animation
            if (this.isActive && this.ripples.length > 0) {
                requestAnimationFrame(() => this.drawRipples());
            } else {
                this.isDrawing = false;
            }
        }

        onMouseLeave() {
            super.onMouseLeave();
            this.ripples = [];
            this.isDrawing = false;
        }
    }

    // Magnetic Effect
    class MagneticEffect extends BaseAnimation {
        constructor(settings) {
            super(settings);
            this.magneticElements = [];
            this.findMagneticElements();
        }

        findMagneticElements() {
            // Find elements with magnetic class or data attribute
            const elements = document.querySelectorAll('[data-magnetic], .magnetic, a, button, input, textarea');
            this.magneticElements = Array.from(elements);
        }

        onMouseMove(e) {
            if (!this.isActive) return;

            const mouseX = e.clientX;
            const mouseY = e.clientY;

            this.magneticElements.forEach(element => {
                const rect = element.getBoundingClientRect();
                const centerX = rect.left + rect.width / 2;
                const centerY = rect.top + rect.height / 2;

                const distance = Math.sqrt(
                    Math.pow(mouseX - centerX, 2) +
                    Math.pow(mouseY - centerY, 2)
                );

                const maxDistance = 100;

                if (distance < maxDistance) {
                    const strength = (maxDistance - distance) / maxDistance;
                    const moveX = (mouseX - centerX) * strength * 0.3;
                    const moveY = (mouseY - centerY) * strength * 0.3;

                    element.style.transform = `translate(${moveX}px, ${moveY}px)`;
                    element.style.transition = 'transform 0.1s ease-out';
                } else {
                    element.style.transform = 'translate(0px, 0px)';
                }
            });
        }

        onMouseLeave() {
            super.onMouseLeave();

            // Reset all magnetic elements
            this.magneticElements.forEach(element => {
                element.style.transform = 'translate(0px, 0px)';
            });
        }
    }

    // Initialize cursor styles
    function initCursorStyles() {
        const cursorStyle = settings.cursorStyle || 'default';
        const customCursorUrl = settings.customCursorUrl || '';
        const cursorSize = settings.cursorSize || 32;

        // Apply cursor styles to the document
        applyCursorStyle(document.body, cursorStyle, customCursorUrl, cursorSize);

        // Apply specific cursor styles to different elements
        applyElementSpecificCursors();
    }

    // Apply cursor style to an element
    function applyCursorStyle(element, style, customUrl, size) {
        if (style === 'custom' && customUrl) {
            element.style.cursor = `url('${customUrl}') ${size / 2} ${size / 2}, auto`;
        } else if (style === 'hidden') {
            element.style.cursor = 'none';
        } else {
            element.style.cursor = style;
        }
    }

    // Apply element-specific cursor styles
    function applyElementSpecificCursors() {
        const cursorStyle = settings.cursorStyle || 'default';
        const customCursorUrl = settings.customCursorUrl || '';
        const cursorSize = settings.cursorSize || 32;

        // Links and buttons
        const interactiveElements = document.querySelectorAll('a, button, input[type="button"], input[type="submit"], input[type="reset"]');
        interactiveElements.forEach(element => {
            if (cursorStyle !== 'hidden') {
                applyCursorStyle(element, 'pointer', customCursorUrl, cursorSize);
            }
        });

        // Text inputs
        const textElements = document.querySelectorAll('input[type="text"], input[type="email"], input[type="password"], input[type="search"], input[type="url"], input[type="tel"], textarea');
        textElements.forEach(element => {
            if (cursorStyle !== 'hidden') {
                applyCursorStyle(element, 'text', customCursorUrl, cursorSize);
            }
        });

        // Draggable elements
        const draggableElements = document.querySelectorAll('[draggable="true"], .draggable');
        draggableElements.forEach(element => {
            if (cursorStyle !== 'hidden') {
                applyCursorStyle(element, 'grab', customCursorUrl, cursorSize);
            }
        });

        // Magnetic elements (override with pointer for better UX)
        const magneticElements = document.querySelectorAll('.magnetic, [data-magnetic]');
        magneticElements.forEach(element => {
            if (cursorStyle !== 'hidden') {
                applyCursorStyle(element, 'pointer', customCursorUrl, cursorSize);
            }
        });
    }

    // Initialize cursor styles
    initCursorStyles();

    // Initialize based on animation type
    switch (settings.animationType) {
        case 'trail':
            animationInstance = new TrailEffect(settings);
            break;
        case 'particles':
            animationInstance = new ParticleEffect(settings);
            break;
        case 'ripple':
            animationInstance = new RippleEffect(settings);
            break;
        case 'magnetic':
            animationInstance = new MagneticEffect(settings);
            break;
        default:
            animationInstance = new TrailEffect(settings);
    }

    // Handle page visibility changes
    document.addEventListener('visibilitychange', () => {
        if (document.hidden) {
            animationInstance.onMouseLeave();
        } else {
            animationInstance.onMouseEnter();
        }
    });

    // Cleanup on page unload
    window.addEventListener('beforeunload', () => {
        if (animationInstance) {
            animationInstance.destroy();
        }
    });

})(); 