<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'PHP MVC Framework' ?></title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
            line-height: 1.6;
            color: #333;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }

        header {
            background: rgba(255, 255, 255, 0.95);
            padding: 20px 0;
            margin-bottom: 40px;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        nav {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        nav h1 {
            color: #667eea;
            font-size: 24px;
        }

        nav ul {
            list-style: none;
            display: flex;
            gap: 20px;
        }

        nav a {
            color: #333;
            text-decoration: none;
            padding: 8px 16px;
            border-radius: 5px;
            transition: background 0.3s;
        }

        nav a:hover {
            background: #667eea;
            color: white;
        }

        .content {
            background: white;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        footer {
            text-align: center;
            padding: 20px;
            color: white;
            margin-top: 40px;
        }
    </style>
</head>
<body>
    <div class="container">
        <header>
            <nav>
                <h1>PHP MVC Framework</h1>
                <ul>
                    <li><a href="/">Home</a></li>
                    <li><a href="/about">About</a></li>
                    <li><a href="/api">API</a></li>
                </ul>
            </nav>
        </header>

        <main class="content">
            <?= $content ?? '' ?>
        </main>

        <footer>
            <p>&copy; <?= date('Y') ?> PHP MVC Framework. Built with dependency injection and robust routing.</p>
        </footer>
    </div>
</body>
</html>
