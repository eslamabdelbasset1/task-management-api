<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>هات الفلوس اللي عليكم</title>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@700;900&family=Montserrat:wght@700;900&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Cairo', sans-serif;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #0f0c29 0%, #302b63 50%, #24243e 100%);
            overflow: hidden;
            position: relative;
        }

        .background-animation {
            position: absolute;
            width: 100%;
            height: 100%;
            overflow: hidden;
            z-index: 0;
        }

        .circle {
            position: absolute;
            border-radius: 50%;
            background: rgba(255, 215, 0, 0.1);
            animation: float 20s infinite ease-in-out;
        }

        .circle:nth-child(1) {
            width: 300px;
            height: 300px;
            top: -100px;
            left: -100px;
            animation-delay: 0s;
        }

        .circle:nth-child(2) {
            width: 200px;
            height: 200px;
            bottom: -50px;
            right: -50px;
            animation-delay: 5s;
        }

        .circle:nth-child(3) {
            width: 400px;
            height: 400px;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            animation-delay: 10s;
        }

        @keyframes float {
            0%, 100% {
                transform: translate(0, 0) scale(1);
                opacity: 0.1;
            }
            50% {
                transform: translate(50px, -50px) scale(1.2);
                opacity: 0.2;
            }
        }

        .container {
            position: relative;
            z-index: 1;
            text-align: center;
            padding: 40px;
            max-width: 900px;
            width: 90%;
        }

        .main-text {
            font-size: clamp(2.5rem, 8vw, 5rem);
            font-weight: 900;
            color: #FFD700;
            text-shadow: 
                0 0 20px rgba(255, 215, 0, 0.8),
                0 0 40px rgba(255, 215, 0, 0.5),
                0 0 60px rgba(255, 215, 0, 0.3),
                4px 4px 8px rgba(0, 0, 0, 0.5);
            margin-bottom: 30px;
            animation: glow 2s ease-in-out infinite alternate;
            letter-spacing: 2px;
            line-height: 1.2;
        }

        @keyframes glow {
            from {
                text-shadow: 
                    0 0 20px rgba(255, 215, 0, 0.8),
                    0 0 40px rgba(255, 215, 0, 0.5),
                    0 0 60px rgba(255, 215, 0, 0.3),
                    4px 4px 8px rgba(0, 0, 0, 0.5);
            }
            to {
                text-shadow: 
                    0 0 30px rgba(255, 215, 0, 1),
                    0 0 60px rgba(255, 215, 0, 0.8),
                    0 0 80px rgba(255, 215, 0, 0.5),
                    4px 4px 8px rgba(0, 0, 0, 0.5);
            }
        }

        .english-text {
            font-family: 'Montserrat', sans-serif;
            font-size: clamp(1.5rem, 4vw, 2.5rem);
            font-weight: 700;
            color: #ffffff;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.7);
            margin-top: 20px;
            opacity: 0;
            animation: fadeInUp 1s ease-out 0.5s forwards;
            letter-spacing: 1px;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .money-icon {
            font-size: clamp(3rem, 10vw, 6rem);
            margin-bottom: 30px;
            display: inline-block;
            animation: bounce 2s infinite;
            filter: drop-shadow(0 0 20px rgba(255, 215, 0, 0.8));
        }

        @keyframes bounce {
            0%, 100% {
                transform: translateY(0);
            }
            50% {
                transform: translateY(-20px);
            }
        }

        .accent-line {
            width: 200px;
            height: 4px;
            background: linear-gradient(90deg, transparent, #FFD700, transparent);
            margin: 30px auto;
            animation: expand 2s ease-in-out infinite;
        }

        @keyframes expand {
            0%, 100% {
                width: 200px;
                opacity: 0.5;
            }
            50% {
                width: 300px;
                opacity: 1;
            }
        }

        .pulse-ring {
            position: absolute;
            width: 400px;
            height: 400px;
            border: 3px solid rgba(255, 215, 0, 0.3);
            border-radius: 50%;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            animation: pulse 3s ease-out infinite;
        }

        @keyframes pulse {
            0% {
                transform: translate(-50%, -50%) scale(0.5);
                opacity: 1;
            }
            100% {
                transform: translate(-50%, -50%) scale(1.5);
                opacity: 0;
            }
        }

        @media (max-width: 768px) {
            .container {
                padding: 20px;
            }
            
            .main-text {
                margin-bottom: 20px;
            }
        }
    </style>
</head>
<body>
    <div class="background-animation">
        <div class="circle"></div>
        <div class="circle"></div>
        <div class="circle"></div>
    </div>

    <div class="pulse-ring"></div>

    <div class="container">
        <div class="money-icon">💰</div>
        <h1 class="main-text">هات الفلوس اللي عليكم</h1>
        <div class="accent-line"></div>
        <p class="english-text">Give me the money you owe me.</p>
    </div>
</body>
</html>