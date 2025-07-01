<?php
// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}
?>

<div class="wrap">
    <h1><?php echo esc_html(get_admin_page_title()); ?></h1>
    
    <div class="cursor-animator-admin">
        <div class="cursor-animator-header">
            <h2><?php esc_html_e('Cursor Style & Animation Settings', 'cursor-style-animation'); ?></h2>
            <p><?php esc_html_e('Customize cursor animations and styles to enhance your website\'s user experience.', 'cursor-style-animation'); ?></p>
        </div>
        
        <form method="post" action="options.php">
            <?php
            settings_fields('cursor_animator_options');
            do_settings_sections('cursor_animator_options');
            ?>
            
            <div class="cursor-animator-settings">
                <!-- Enable/Disable -->
                <div class="setting-group">
                    <h3><?php esc_html_e('General Settings', 'cursor-style-animation'); ?></h3>
                    
                    <div class="setting-field">
                        <label for="cursor_animator_enabled">
                            <input type="checkbox" id="cursor_animator_enabled" name="cursor_animator_enabled" value="1" <?php checked(get_option('cursor_animator_enabled', '1'), '1'); ?>>
                            <?php esc_html_e('Enable cursor animation', 'cursor-style-animation'); ?>
                        </label>
                    </div>
                    
                    <div class="setting-field">
                        <label for="cursor_animator_mobile">
                            <input type="checkbox" id="cursor_animator_mobile" name="cursor_animator_mobile" value="1" <?php checked(get_option('cursor_animator_mobile', '0'), '1'); ?>>
                            <?php esc_html_e('Enable on mobile devices', 'cursor-style-animation'); ?>
                        </label>
                        <p class="description"><?php esc_html_e('Note: Mobile devices don\'t have mouse cursors, but this will show touch effects.', 'cursor-style-animation'); ?></p>
                    </div>
                </div>
                
                <!-- Cursor Style Selection -->
                <div class="setting-group">
                    <h3><?php esc_html_e('Cursor Style', 'cursor-style-animation'); ?></h3>
                    
                    <div class="setting-field">
                        <label for="cursor_animator_cursor_style"><?php esc_html_e('Cursor Style:', 'cursor-style-animation'); ?></label>
                        <select id="cursor_animator_cursor_style" name="cursor_animator_cursor_style">
                            <option value="default" <?php selected(get_option('cursor_animator_cursor_style', 'default'), 'default'); ?>><?php esc_html_e('Default Cursor', 'cursor-style-animation'); ?></option>
                            <option value="pointer" <?php selected(get_option('cursor_animator_cursor_style', 'default'), 'pointer'); ?>><?php esc_html_e('Pointer', 'cursor-style-animation'); ?></option>
                            <option value="crosshair" <?php selected(get_option('cursor_animator_cursor_style', 'default'), 'crosshair'); ?>><?php esc_html_e('Crosshair', 'cursor-style-animation'); ?></option>
                            <option value="text" <?php selected(get_option('cursor_animator_cursor_style', 'default'), 'text'); ?>><?php esc_html_e('Text', 'cursor-style-animation'); ?></option>
                            <option value="wait" <?php selected(get_option('cursor_animator_cursor_style', 'default'), 'wait'); ?>><?php esc_html_e('Wait', 'cursor-style-animation'); ?></option>
                            <option value="move" <?php selected(get_option('cursor_animator_cursor_style', 'default'), 'move'); ?>><?php esc_html_e('Move', 'cursor-style-animation'); ?></option>
                            <option value="grab" <?php selected(get_option('cursor_animator_cursor_style', 'default'), 'grab'); ?>><?php esc_html_e('Grab', 'cursor-style-animation'); ?></option>
                            <option value="zoom-in" <?php selected(get_option('cursor_animator_cursor_style', 'default'), 'zoom-in'); ?>><?php esc_html_e('Zoom In', 'cursor-style-animation'); ?></option>
                            <option value="zoom-out" <?php selected(get_option('cursor_animator_cursor_style', 'default'), 'zoom-out'); ?>><?php esc_html_e('Zoom Out', 'cursor-style-animation'); ?></option>
                            <option value="custom" <?php selected(get_option('cursor_animator_cursor_style', 'default'), 'custom'); ?>><?php esc_html_e('Custom Image', 'cursor-style-animation'); ?></option>
                            <option value="hidden" <?php selected(get_option('cursor_animator_cursor_style', 'default'), 'hidden'); ?>><?php esc_html_e('Hidden Cursor', 'cursor-style-animation'); ?></option>
                        </select>
                    </div>
                    
                    <div class="setting-field custom-cursor-field" style="display: none;">
                        <label for="cursor_animator_custom_cursor"><?php esc_html_e('Custom Cursor URL:', 'cursor-style-animation'); ?></label>
                        <input type="url" id="cursor_animator_custom_cursor" name="cursor_animator_custom_cursor" 
                               value="<?php echo esc_attr(get_option('cursor_animator_custom_cursor', '')); ?>" 
                               placeholder="https://example.com/cursor.png" style="width: 100%; max-width: 400px;">
                        <p class="description"><?php esc_html_e('Enter the URL of your custom cursor image (PNG, SVG, or CUR format recommended).', 'cursor-style-animation'); ?></p>
                    </div>
                    
                    <div class="setting-field cursor-size-field" style="display: none;">
                        <label for="cursor_animator_cursor_size"><?php esc_html_e('Cursor Size (px):', 'cursor-style-animation'); ?></label>
                        <input type="range" id="cursor_animator_cursor_size" name="cursor_animator_cursor_size" 
                               min="16" max="64" value="<?php echo esc_attr(get_option('cursor_animator_cursor_size', '32')); ?>">
                        <span class="range-value"><?php echo esc_html(get_option('cursor_animator_cursor_size', '32')); ?></span>
                        <p class="description"><?php esc_html_e('Adjust the size of your custom cursor.', 'cursor-style-animation'); ?></p>
                    </div>
                    
                    <div class="cursor-preview">
                        <h4><?php esc_html_e('Cursor Preview:', 'cursor-style-animation'); ?></h4>
                        <div id="cursor-preview-area">
                            <div class="preview-text"><?php esc_html_e('Hover over this text to see your selected cursor style:', 'cursor-style-animation'); ?></div>
                            <div class="preview-box" id="cursor-preview-box">
                                <?php esc_html_e('Move your mouse here to preview the cursor style', 'cursor-style-animation'); ?>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Animation Type -->
                <div class="setting-group">
                    <h3><?php esc_html_e('Animation Type', 'cursor-style-animation'); ?></h3>
                    
                    <div class="setting-field">
                        <label for="cursor_animator_type"><?php esc_html_e('Animation Style:', 'cursor-style-animation'); ?></label>
                        <select id="cursor_animator_type" name="cursor_animator_type">
                            <option value="trail" <?php selected(get_option('cursor_animator_type', 'trail'), 'trail'); ?>><?php esc_html_e('Trail Effect', 'cursor-style-animation'); ?></option>
                            <option value="particles" <?php selected(get_option('cursor_animator_type', 'trail'), 'particles'); ?>><?php esc_html_e('Particle Effect', 'cursor-style-animation'); ?></option>
                            <option value="ripple" <?php selected(get_option('cursor_animator_type', 'trail'), 'ripple'); ?>><?php esc_html_e('Ripple Effect', 'cursor-style-animation'); ?></option>
                            <option value="magnetic" <?php selected(get_option('cursor_animator_type', 'trail'), 'magnetic'); ?>><?php esc_html_e('Magnetic Effect', 'cursor-style-animation'); ?></option>
                        </select>
                    </div>
                </div>
                
                <!-- Trail Settings -->
                <div class="setting-group trail-settings">
                    <h3><?php esc_html_e('Trail Settings', 'cursor-style-animation'); ?></h3>
                    
                    <div class="setting-field">
                        <label for="cursor_animator_trail_length"><?php esc_html_e('Trail Length:', 'cursor-style-animation'); ?></label>
                        <input type="range" id="cursor_animator_trail_length" name="cursor_animator_trail_length" 
                               min="5" max="50" value="<?php echo esc_attr(get_option('cursor_animator_trail_length', '20')); ?>">
                        <span class="range-value"><?php echo esc_html(get_option('cursor_animator_trail_length', '20')); ?></span>
                    </div>
                    
                    <div class="setting-field">
                        <label for="cursor_animator_trail_size"><?php esc_html_e('Trail Size (px):', 'cursor-style-animation'); ?></label>
                        <input type="range" id="cursor_animator_trail_size" name="cursor_animator_trail_size" 
                               min="2" max="20" value="<?php echo esc_attr(get_option('cursor_animator_trail_size', '8')); ?>">
                        <span class="range-value"><?php echo esc_html(get_option('cursor_animator_trail_size', '8')); ?></span>
                    </div>
                    
                    <div class="setting-field">
                        <label for="cursor_animator_trail_color"><?php esc_html_e('Trail Color:', 'cursor-style-animation'); ?></label>
                        <input type="color" id="cursor_animator_trail_color" name="cursor_animator_trail_color" 
                               value="<?php echo esc_attr(get_option('cursor_animator_trail_color', '#ff6b6b')); ?>">
                    </div>
                </div>
                
                <!-- Animation Speed -->
                <div class="setting-group">
                    <h3><?php esc_html_e('Animation Speed', 'cursor-style-animation'); ?></h3>
                    
                    <div class="setting-field">
                        <label for="cursor_animator_speed"><?php esc_html_e('Animation Speed:', 'cursor-style-animation'); ?></label>
                        <input type="range" id="cursor_animator_speed" name="cursor_animator_speed" 
                               min="0.1" max="2.0" step="0.1" value="<?php echo esc_attr(get_option('cursor_animator_speed', '0.8')); ?>">
                        <span class="range-value"><?php echo esc_html(get_option('cursor_animator_speed', '0.8')); ?></span>
                    </div>
                </div>
            </div>
            
            <p class="submit">
                <input type="submit" name="submit" id="submit" class="button button-primary" value="<?php esc_attr_e('Save Changes', 'cursor-style-animation'); ?>">
            </p>
        </form>
        
        <!-- Donation Section -->
        <div class="donation-section" style="margin-top: 30px; padding: 20px; background: #f9f9f9; border-radius: 8px; border-left: 4px solid #0073aa;">
            <h3 style="margin-top: 0; color: #0073aa;"><?php esc_html_e('Support Cursor Style & Animation', 'cursor-style-animation'); ?></h3>
            <p><?php esc_html_e('If you find this plugin helpful, consider supporting its development with a donation.', 'cursor-style-animation'); ?></p>
            <a href="https://buymeacoffee.com/iksopnil" target="_blank" class="button button-secondary" style="background: #ff6b6b; border-color: #ff6b6b; color: white; text-decoration: none; display: inline-block; margin-top: 10px;">
                <span style="margin-right: 8px;">☕</span><?php esc_html_e('Buy Me a Coffee', 'cursor-style-animation'); ?>
            </a>
            <p style="margin-top: 10px; font-size: 12px; color: #666;">
                <?php esc_html_e('Developed by', 'cursor-style-animation'); ?> <a href="https://roardev.xyz" target="_blank">RoarDev</a>
            </p>
        </div>
    </div>
</div>

<style>
.cursor-animator-admin {
    max-width: 800px;
    margin: 20px 0;
}

.cursor-animator-header {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    padding: 20px;
    border-radius: 8px;
    margin-bottom: 30px;
}

.cursor-animator-header h2 {
    margin: 0 0 10px 0;
    color: white;
}

.cursor-animator-settings {
    display: grid;
    gap: 30px;
}

.setting-group {
    background: #fff;
    border: 1px solid #ddd;
    border-radius: 8px;
    padding: 20px;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.setting-group h3 {
    margin: 0 0 20px 0;
    color: #333;
    border-bottom: 2px solid #667eea;
    padding-bottom: 10px;
}

.setting-field {
    margin-bottom: 20px;
}

.setting-field label {
    display: block;
    margin-bottom: 8px;
    font-weight: 600;
    color: #555;
}

.setting-field input[type="range"] {
    width: 200px;
    margin-right: 10px;
}

.range-value {
    font-weight: bold;
    color: #667eea;
}

.setting-field input[type="color"] {
    width: 60px;
    height: 40px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
}

.setting-field select {
    width: 200px;
    padding: 8px;
    border: 1px solid #ddd;
    border-radius: 4px;
}

.setting-field input[type="url"] {
    padding: 8px;
    border: 1px solid #ddd;
    border-radius: 4px;
}

.setting-field .description {
    margin-top: 5px;
    color: #666;
    font-style: italic;
}

.cursor-preview {
    margin-top: 20px;
    padding: 15px;
    background: #f8f9fa;
    border-radius: 8px;
    border: 1px solid #e9ecef;
}

.cursor-preview h4 {
    margin: 0 0 15px 0;
    color: #333;
}

.preview-text {
    margin-bottom: 10px;
    font-weight: 600;
    color: #555;
}

.preview-box {
    width: 100%;
    height: 100px;
    border: 2px dashed #ddd;
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: #f9f9f9;
    text-align: center;
    color: #666;
    transition: all 0.3s ease;
}

.preview-box:hover {
    border-color: #667eea;
    background: #f0f4ff;
}

.cursor-animator-preview {
    background: #fff;
    border: 1px solid #ddd;
    border-radius: 8px;
    padding: 20px;
    margin-top: 30px;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.preview-instructions {
    margin-bottom: 20px;
    padding: 15px;
    background: #f8f9fa;
    border-radius: 8px;
    border-left: 4px solid #667eea;
}

.preview-instructions p {
    margin: 0 0 15px 0;
    color: #333;
}

.preview-instructions ul {
    margin: 0 0 15px 0;
    padding-left: 20px;
}

.preview-instructions li {
    margin-bottom: 8px;
    color: #555;
    line-height: 1.4;
}

.preview-note {
    background: #fff3cd;
    border: 1px solid #ffeaa7;
    border-radius: 6px;
    padding: 12px;
    margin: 0 !important;
    color: #856404 !important;
    font-style: italic;
}

#preview-box {
    width: 100%;
    height: 200px;
    border: 2px dashed #ddd;
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: #f9f9f9;
    margin-top: 15px;
    position: relative;
    overflow: hidden;
    transition: all 0.3s ease;
}

#preview-box:hover {
    border-color: #667eea;
    background: #f0f4ff;
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(102, 126, 234, 0.2);
}

.preview-content {
    text-align: center;
    padding: 20px;
}

.preview-icon {
    font-size: 3rem;
    margin-bottom: 15px;
    animation: bounce 2s infinite;
}

.preview-text {
    color: #667eea;
    font-size: 1.1rem;
    line-height: 1.5;
}

.preview-subtitle {
    color: #666;
    font-size: 0.9rem;
    font-weight: normal;
    display: block;
    margin-top: 8px;
}

.preview-magnetic-elements {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    pointer-events: none;
    z-index: 2;
}

.magnetic-dot {
    transition: transform 0.1s ease-out;
    pointer-events: none;
}

.magnetic-dot:hover {
    transform: scale(1.2);
}

@keyframes bounce {
    0%, 20%, 50%, 80%, 100% {
        transform: translateY(0);
    }
    40% {
        transform: translateY(-10px);
    }
    60% {
        transform: translateY(-5px);
    }
}

.submit {
    margin-top: 30px;
}

.submit .button-primary {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border: none;
    padding: 12px 24px;
    font-size: 16px;
    border-radius: 6px;
    box-shadow: 0 4px 8px rgba(0,0,0,0.2);
}

.submit .button-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 12px rgba(0,0,0,0.3);
}

/* Cursor style previews */
.cursor-preview-default { cursor: default; }
.cursor-preview-pointer { cursor: pointer; }
.cursor-preview-crosshair { cursor: crosshair; }
.cursor-preview-text { cursor: text; }
.cursor-preview-wait { cursor: wait; }
.cursor-preview-move { cursor: move; }
.cursor-preview-grab { cursor: grab; }
.cursor-preview-zoom-in { cursor: zoom-in; }
.cursor-preview-zoom-out { cursor: zoom-out; }
.cursor-preview-hidden { cursor: none; }
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Update range value displays
    const rangeInputs = document.querySelectorAll('input[type="range"]');
    rangeInputs.forEach(input => {
        const valueDisplay = input.nextElementSibling;
        input.addEventListener('input', function() {
            valueDisplay.textContent = this.value;
        });
    });
    
    // Show/hide trail settings based on animation type
    const animationType = document.getElementById('cursor_animator_type');
    const trailSettings = document.querySelector('.trail-settings');
    
    function toggleTrailSettings() {
        if (animationType.value === 'trail') {
            trailSettings.style.display = 'block';
        } else {
            trailSettings.style.display = 'none';
        }
    }
    
    animationType.addEventListener('change', toggleTrailSettings);
    toggleTrailSettings();
    
    // Show/hide custom cursor fields based on cursor style
    const cursorStyle = document.getElementById('cursor_animator_cursor_style');
    const customCursorField = document.querySelector('.custom-cursor-field');
    const cursorSizeField = document.querySelector('.cursor-size-field');
    const previewBox = document.getElementById('cursor-preview-box');
    
    function toggleCustomCursorFields() {
        if (cursorStyle.value === 'custom') {
            customCursorField.style.display = 'block';
            cursorSizeField.style.display = 'block';
        } else {
            customCursorField.style.display = 'none';
            cursorSizeField.style.display = 'none';
        }
        
        // Update preview box cursor
        updatePreviewCursor();
    }
    
    function updatePreviewCursor() {
        const style = cursorStyle.value;
        const customUrl = document.getElementById('cursor_animator_custom_cursor').value;
        const size = document.getElementById('cursor_animator_cursor_size').value;
        
        // Remove existing cursor classes
        previewBox.className = 'preview-box';
        
        if (style === 'custom' && customUrl) {
            previewBox.style.cursor = `url('${customUrl}') ${size/2} ${size/2}, auto`;
        } else if (style === 'hidden') {
            previewBox.style.cursor = 'none';
        } else {
            previewBox.classList.add(`cursor-preview-${style}`);
            previewBox.style.cursor = '';
        }
    }
    
    cursorStyle.addEventListener('change', toggleCustomCursorFields);
    document.getElementById('cursor_animator_custom_cursor').addEventListener('input', updatePreviewCursor);
    document.getElementById('cursor_animator_cursor_size').addEventListener('input', updatePreviewCursor);
    
    // Initialize
    toggleCustomCursorFields();
});
</script> 