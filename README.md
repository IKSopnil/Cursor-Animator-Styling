# Cursor Style & Animation - WordPress Plugin

Transform your website's user experience with beautiful cursor animations and custom cursor styles. This premium-quality WordPress plugin adds engaging mouse cursor effects that enhance interactivity and visual appeal.

**Author:** RoarDev  
**Website:** [roardev.xyz](https://roardev.xyz)  
**Support:** [Buy Me a Coffee](https://buymeacoffee.com/iksopnil)

[![WordPress Plugin Version](https://img.shields.io/wordpress/plugin/v/cursor-style-animation)](https://wordpress.org/plugins/cursor-style-animation/)
[![WordPress Plugin Downloads](https://img.shields.io/wordpress/plugin/dt/cursor-style-animation)](https://wordpress.org/plugins/cursor-style-animation/)
[![WordPress Plugin Rating](https://img.shields.io/wordpress/plugin/r/cursor-style-animation)](https://wordpress.org/plugins/cursor-style-animation/)

## 🎯 Why Choose Cursor Style & Animation?

- **🎨 4 Beautiful Animation Types**: Trail, Particles, Ripple, and Magnetic effects
- **🖱️ 10+ Cursor Styles**: From classic to modern, including custom images
- **📱 Mobile Optimized**: Optional mobile support with performance considerations
- **⚡ Performance Focused**: Smooth 60fps animations with minimal resource usage
- **♿ Accessibility Friendly**: Respects user preferences and accessibility standards
- **🔧 Easy Customization**: Intuitive admin interface with live preview
- **🌐 Modern Web Standards**: Built with vanilla JavaScript and HTML5 Canvas

## ✨ Key Features

### Animation Effects
- **Trail Effect**: Smooth trailing animation that follows your mouse
- **Particle Effect**: Dynamic particle system with physics simulation
- **Ripple Effect**: Expanding circular ripples on mouse movement
- **Magnetic Effect**: Interactive element attraction and repulsion

### Cursor Styles
- **Default**: Standard system cursor
- **Pointer**: Hand pointer for interactive elements
- **Crosshair**: Precise targeting cursor
- **Text**: Text selection cursor
- **Wait**: Loading/waiting cursor
- **Move**: Drag and move cursor
- **Grab**: Grab and drag cursor
- **Zoom In/Out**: Zoom control cursors
- **Custom Image**: Upload your own cursor image
- **Hidden**: Hide the cursor completely

### Advanced Features
- **Custom Cursor Support**: Upload PNG, SVG, or CUR files
- **Responsive Design**: Works perfectly on all screen sizes
- **Performance Optimizations**: Hardware acceleration and efficient rendering
- **Accessibility Compliance**: Respects `prefers-reduced-motion` settings
- **Cross-Browser Compatibility**: Works on all modern browsers
- **SEO Friendly**: No impact on search engine optimization

## 🚀 Quick Installation

### Method 1: WordPress Admin (Recommended)
1. Go to **Plugins > Add New** in your WordPress admin
2. Click **Upload Plugin**
3. Choose the plugin zip file
4. Click "Install Now" and then "Activate"

### Method 2: Manual Installation
1. Download the plugin files
2. Upload the `cursor-style-animation` folder to `/wp-content/plugins/`
3. Activate the plugin through the 'Plugins' menu
4. Go to **Settings > Cursor Style & Animation** to configure

## ⚙️ Configuration Guide

### Accessing Settings
1. Navigate to **Settings > Cursor Style & Animation** in your WordPress admin
2. Configure your preferred animation and cursor settings
3. Use the live preview to see changes in real-time
4. Click "Save Changes" to apply

### Settings Overview

#### General Settings
- **Enable cursor animation**: Toggle the plugin on/off globally
- **Enable on mobile devices**: Show effects on touch devices (optional)

#### Animation Type Selection
Choose from four different effects:
- **Trail Effect**: Smooth trailing animation with customizable length and color
- **Particle Effect**: Dynamic particle system with physics simulation
- **Ripple Effect**: Expanding circular ripples on mouse movement
- **Magnetic Effect**: Interactive element attraction and repulsion

#### Trail Settings (for Trail Effect)
- **Trail Length**: Number of trail segments (5-50)
- **Trail Size**: Width of trail elements (2-20px)
- **Trail Color**: Custom color picker for trail effects

#### Animation Speed
- **Animation Speed**: Control how fast effects animate (0.1-2.0x)

#### Cursor Style Options
- **Cursor Style**: Select from 10+ predefined cursor styles
- **Custom Cursor URL**: Enter the URL of your custom cursor image
- **Cursor Size**: Adjust the size of your custom cursor (16-64px)

## 🎨 Usage Examples

### Basic Implementation
The plugin works automatically once activated. Simply move your mouse around your website to see the beautiful effects.

### HTML Integration
```html
<!-- Elements automatically get appropriate cursor styles -->
<a href="#">Link with pointer cursor</a>
<button>Button with pointer cursor</button>
<input type="text" placeholder="Text input with text cursor">
<div draggable="true">Draggable element with grab cursor</div>
```

### Magnetic Effect Implementation
For the magnetic effect, elements with these classes or attributes will be affected:
- Elements with class `.magnetic`
- Elements with `data-magnetic` attribute
- All links (`<a>` tags)
- All buttons (`<button>` tags)
- Form elements (`<input>`, `<textarea>`, `<select>`)

Example:
```html
<button class="magnetic">Magnetic Button</button>
<div data-magnetic>Magnetic Div</div>
```

### Custom Cursor Setup
To use a custom cursor image:
1. Upload your cursor image to your media library
2. Copy the image URL
3. Select "Custom Image" from cursor style dropdown
4. Paste the URL in the custom cursor field
5. Adjust the cursor size as needed

## 🔧 Advanced Customization

### CSS Customization
You can override plugin styles by adding CSS to your theme:

```css
/* Custom trail color */
.cursor-animator-canvas {
    mix-blend-mode: screen;
}

/* Hide on specific elements */
.no-cursor-animation .cursor-animator-canvas {
    display: none;
}

/* Custom cursor styles */
.cursor-custom {
    cursor: url('your-custom-cursor.png') 16 16, auto;
}
```

### JavaScript Hooks
The plugin provides several JavaScript events for developers:

```javascript
// Listen for animation start
document.addEventListener('cursorAnimatorStart', function() {
    console.log('Cursor animation started');
});

// Listen for animation stop
document.addEventListener('cursorAnimatorStop', function() {
    console.log('Cursor animation stopped');
});
```

## 🚀 Performance Optimization

### Best Practices
1. **Trail Length**: Use lower values (5-15) for better performance
2. **Animation Speed**: Higher values may impact performance on slower devices
3. **Mobile Optimization**: Disable on mobile for better battery life
4. **Custom Cursors**: Use optimized images (PNG/SVG recommended)
5. **Reduce Motion**: Plugin automatically respects user preferences

### Performance Features
- **Hardware Acceleration**: Uses GPU for smooth animations
- **Efficient Rendering**: Optimized canvas rendering
- **Memory Management**: Automatic cleanup and resource management
- **Mobile Optimization**: Reduced effects on touch devices

## 🐛 Troubleshooting

### Common Issues & Solutions

**Q: Animation not showing on my website**
A: Check these common causes:
- Ensure the plugin is enabled in settings
- Verify JavaScript is enabled in your browser
- Check browser console for any errors
- Clear your browser cache and refresh the page

**Q: Custom cursor not displaying correctly**
A: Troubleshooting steps:
- Ensure the image URL is accessible and publicly available
- Verify the image format is supported (PNG, SVG, CUR)
- Try a different image size (16x16 to 64x64 pixels recommended)
- Check that the image URL is correct and doesn't require authentication

**Q: Performance issues on my website**
A: Performance optimization tips:
- Reduce trail length to 5-15 segments
- Lower animation speed to 0.5-1.0
- Disable on mobile devices if not needed
- Use smaller custom cursor images
- Check for conflicts with other plugins

**Q: Conflicts with other plugins or themes**
A: Resolution steps:
- Try changing the z-index in CSS if elements overlap
- Check for JavaScript conflicts in browser console
- Temporarily disable other cursor-related plugins
- Test with a default WordPress theme

**Q: Animation not working on mobile devices**
A: Mobile considerations:
- Ensure "Enable on mobile devices" is checked in settings
- Some mobile browsers have limited canvas support
- Touch events may behave differently than mouse events
- Consider disabling on mobile for better performance

### Browser Compatibility
- ✅ Chrome 60+ (Full support)
- ✅ Firefox 55+ (Full support)
- ✅ Safari 12+ (Full support)
- ✅ Edge 79+ (Full support)
- ⚠️ Internet Explorer 11 (Limited support)
- ⚠️ Older mobile browsers (Limited support)

## 📋 Frequently Asked Questions

**Q: Is this plugin compatible with all WordPress themes?**
A: Yes, the plugin is designed to work with all WordPress themes. It uses standard WordPress hooks and doesn't modify theme files.

**Q: Does the plugin affect my website's SEO?**
A: No, the plugin has no impact on SEO. It only adds visual effects and doesn't modify content or meta tags.

**Q: Can I use multiple animation types at once?**
A: No, you can only use one animation type at a time. This is by design to ensure optimal performance.

**Q: Is the plugin accessible for users with disabilities?**
A: Yes, the plugin respects accessibility standards and automatically disables animations for users who prefer reduced motion.

**Q: Can I customize the colors of the animations?**
A: Yes, you can customize trail colors using the color picker in the admin settings.

**Q: Does the plugin work with page builders like Elementor or Divi?**
A: Yes, the plugin is compatible with all major page builders and works alongside them.

**Q: Can I disable the plugin on specific pages?**
A: Yes, you can add CSS to hide the animation on specific pages or elements.

**Q: Is the plugin translation-ready?**
A: Yes, the plugin includes translation files and supports internationalization.

**Q: Can I use my own custom cursor images?**
A: Yes, you can upload custom cursor images in PNG, SVG, or CUR format.

**Q: Does the plugin work with caching plugins?**
A: Yes, the plugin is compatible with all major caching plugins.

## 📝 Changelog

### Version 1.0.0
- Initial release
- Four animation types (Trail, Particles, Ripple, Magnetic)
- Ten cursor styles with custom cursor support
- Mobile device support
- Performance optimizations
- Accessibility compliance
- Cross-browser compatibility
- SEO-friendly implementation

## 🤝 Contributing

We welcome contributions! Please feel free to:
- Report bugs and issues
- Suggest new features
- Submit pull requests
- Improve documentation

## 📄 License

This plugin is licensed under the GPL v2 or later.

## 🆘 Support

For support and assistance:
1. Check the troubleshooting section above
2. Review the FAQ section
3. Search existing issues
4. Create a new support ticket with detailed information

## ☕ Support the Developer

If you find this plugin helpful, consider supporting its continued development:

[![Buy Me a Coffee](https://img.shields.io/badge/Buy%20Me%20a%20Coffee-ff6b6b?style=for-the-badge&logo=buy-me-a-coffee&logoColor=white)](https://buymeacoffee.com/iksopnil)

Your support helps us maintain and improve the plugin for everyone!

## 🙏 Credits

- Built with vanilla JavaScript for maximum compatibility
- Uses HTML5 Canvas for smooth animations
- Designed with accessibility and performance in mind
- Optimized for modern web standards and best practices

---

**Made with ❤️ by [RoarDev](https://roardev.xyz) for the WordPress community** # Cursor-Animator
# Cursor-Animator-Styling
