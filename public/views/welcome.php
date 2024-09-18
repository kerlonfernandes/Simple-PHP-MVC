<?php
// index.php

// Optional: Start a session to store language preference
session_start();

// Check if language is set in session, otherwise default to English
$lang = isset($_SESSION['lang']) ? $_SESSION['lang'] : 'en';

// Function to set language in session
function setLanguage($language) {
    $_SESSION['lang'] = $language;
}

// Handle language change request
if (isset($_GET['lang']) && in_array($_GET['lang'], ['en', 'pt'])) {
    setLanguage($_GET['lang']);
    header("Location: index.php"); // Redirect to refresh page with new language
    exit();
}

// Translations
$translations = [
    'en' => [
        'title' => 'Welcome to Simple PHP MVC',
        'message' => 'Hello, visitor! Welcome to my PHP MVC architecture project. This project provides a basic and flexible structure for you to use and adapt according to your needs. Feel free to explore and customize as you wish.',
        'get_started' => 'Get Started',
        'translate' => 'Translate to Portuguese'
    ],
    'pt' => [
        'title' => 'Bem-vindo ao Simple PHP MVC',
        'message' => 'Olá, visitante! Seja bem-vindo ao meu projeto de arquitetura MVC em PHP. Este projeto é uma estrutura básica e flexível para você usar e adaptar conforme suas necessidades. Sinta-se à vontade para explorar e personalizar como desejar.',
        'get_started' => 'Começar',
        'translate' => 'Translate to English'
    ]
];

?>
<!DOCTYPE html>
<html lang="<?php echo $lang; ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $translations[$lang]['title']; ?></title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            background: linear-gradient(135deg, #f5f7fa, #c3cfe2);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #333;
        }

        .container {
            background-color: rgba(255, 255, 255, 0.9);
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 8px 16px rgba(0,0,0,0.2);
            text-align: center;
            max-width: 600px;
            width: 90%;
        }

        h1 {
            font-size: 2.5em;
            margin-bottom: 20px;
            color: #4a90e2;
        }

        p {
            font-size: 1.2em;
            margin-bottom: 30px;
            line-height: 1.6;
        }

        .btn {
            display: inline-block;
            padding: 12px 24px;
            font-size: 1em;
            color: #fff;
            background-color: #4a90e2;
            border: none;
            border-radius: 5px;
            text-decoration: none;
            transition: background-color 0.3s ease;
        }

        .btn:hover {
            background-color: #357ab8;
        }

        .footer {
            margin-top: 40px;
            font-size: 0.9em;
            color: #777;
        }

        .translate-btn {
            margin-top: 20px;
            display: inline-block;
            padding: 10px 20px;
            font-size: 0.9em;
            color: #fff;
            background-color: #e94e77;
            border: none;
            border-radius: 5px;
            text-decoration: none;
            transition: background-color 0.3s ease;
        }

        .translate-btn:hover {
            background-color: #c43c5b;
        }

        @media (max-width: 600px) {
            .container {
                padding: 20px;
            }

            h1 {
                font-size: 2em;
            }

            p {
                font-size: 1em;
            }

            .btn, .translate-btn {
                padding: 10px 20px;
                font-size: 0.9em;
            }
        }
    </style>
</head>
<body>

    <div class="container">
        <h1><?php echo $translations[$lang]['title']; ?></h1>
        <p><?php echo $translations[$lang]['message']; ?></p>
        <a href="#" class="btn"><?php echo $translations[$lang]['get_started']; ?></a>
        <a href="?lang=<?php echo $lang === 'en' ? 'pt' : 'en'; ?>" class="translate-btn">
            <?php echo $translations[$lang]['translate']; ?>
        </a>

    </div>

</body>
</html>
