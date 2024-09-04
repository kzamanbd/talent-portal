# Installation Guide for Developers

- **Step 1: Prerequisites**

- Make sure you have the following software installed on your machine:
  - PHP (>= 7.4.0)
  - MySQL (>= 5.0)
  - Composer
  - Node.js (>= 18.x)

- **Step 2: Setup wordpress development environment**

1. Set wordpress debugging mode values in your wordpress directory`wp-config.php`:

```php
define( 'WP_DEBUG', true );
define( 'WP_DEBUG_LOG', true );
```

- **Step 3: Clone the Repository**

1. Open your terminal or command prompt.
2. Change the current working directory to the location where you want to clone the repository.
3. [Fork](https://docs.github.com/en/get-started/quickstart/fork-a-repo) the talent-portal github repository.
4. Run the following command to clone your forked repository:

```bash
git clone https://github.com/YOUR-USERNAME/talent-portal.git
```

- **Step 4: Install Dependencies**

1. Navigate to the cloned repository:

```bash
cd talent-portal
```

1. Install PHP dependencies using Composer:

```bash
composer install && composer du -o
```

1. Install JavaScript dependencies using npm:

```bash
npm install
```

- **Step 5: Build Assets**

1. Build the frontend assets using the following command:

```bash
npm run build
```

1. Build the frontend assets for development (vite watch mode):

```bash
npm run dev
```

## 🎉 Congratulations! You have successfully installed Talent Portal on your development environment

## Talent Portal Guide for Developers

- **All available commands**

1. Build assets ( watch mode )

```bash
npm run dev
```

1. Build assets for production

```bash
npm run build
```

1. Make or regenerate pot file

```bash
npm run make:pot
```
