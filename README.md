# wp-fashion-theme

This project is a fully customizable Fashion template designed for fashion houses or boutiques. It is built using Twig and Timber for clean templating and follows the BEM (Block, Element, Modifier) methodology for scalable and maintainable CSS. The template also leverages Advanced Custom Fields (ACF) to enable flexible content management, allowing full control over the layout and design.

## Features

Integrated with ACF for flexible, dynamic content management
Follows BEM methodology for organized and modular CSS
Built using Twig and Timber to separate logic from presentation
Fully customizable design, tailored for fashion brands and boutiques
Optimized for performance and ease of use within WordPress
This would be a great base for any fashion-related website looking for a modern and structured approach to theme development.

### Installation

1. Standard theme installation: Upload the theme folder to your /wp-content/themes/ directory and activate it through the WordPress admin panel.
2. Required Plugin: This template requires the Advanced Custom Fields (ACF) plugin for proper functionality. Install and activate ACF from the WordPress plugin repository.
3. Ensure that Twig and Timber are installed and properly configured to run the theme.

### Running / Development

To manage assets and run the project in development or production mode, use the following npm commands:

1. **Install dependencies**:
   ```bash
   npm install
   ```
2. **Development build: Compiles assets for development**:
   ```bash
   npm run dev
   ```
3. **Watch for changes: Automatically recompiles assets when files are modified, ideal for active development**:
   ```bash
   npm run watch
   ```
4. **Hot module replacement: Enables hot module replacement for faster development**:
   ```bash
   npm run hot
   ```
5. **Production build: Compiles and optimizes assets for production**:

```bash
   npm run prod
```
