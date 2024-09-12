<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chatbot</title>

    <style>
        /* Gradient Background Animation */
        @keyframes gradientShift {
            0% { background-position: 0% 0%; }
            50% { background-position: 100% 100%; }
            100% { background-position: 0% 0%; }
        }

        /* Typing Animation */
        @keyframes typing {
            from { width: 0; }
            to { width: 100%; }
        }

        @keyframes blinkCursor {
            0% { border-right: 2px solid rgba(0, 0, 0, 0.75); }
            50% { border-right: 2px solid transparent; }
            100% { border-right: 2px solid rgba(0, 0, 0, 0.75); }
        }

        /* Google Font */
        @import url('https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap');

        body {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            height: 100vh;
            display: flex;
            align-items: flex-end;
            justify-content: flex-end;
            position: relative;
            overflow: hidden; /* Ensure no horizontal overflow */
        }

        /* Background image and semi-transparent black overlay */
        body::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: url('images/jmct.jpeg');
            background-size: cover;
            background-position: center;
            z-index: -1; /* Ensure the pseudo-element is behind other content */
        }

        body::after {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5); /* Black with 50% opacity */
            z-index: -1; /* Ensure the overlay is behind the content */
        }

        /* Styled h1 */
        h1 {
            position: absolute;
            top: 20px;
            left: 20px;
            font-family: 'Roboto', sans-serif;
            font-size: 5em;
            color: White;
            white-space: nowrap;
            overflow: hidden;
            border-right: 2px solid rgba(0, 0, 0, 0.75);
            animation: typing 3s steps(30, end), blinkCursor 0.75s step-end infinite;
            margin: 0;
        }

        .welcome-text {
            color: White;
        }

        .college-name {
            color: #b12525;
        }

        /* Chatbot Container */
        #chatbot {
            width: 350px;
            height: 530px;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
            background-color: #fff;
            display: flex;
            flex-direction: column;
            border: 1px solid #ccc;
            position: relative;
        }

        /* Chat Header */
        #chatHeader {
            background-color: #b12525;
            color: #fff;
            padding: 15px;
            text-align: center;
            font-weight: bold;
            cursor: pointer;
            position: relative;
        }

        #chatHeader img {
            position: absolute;
            top: 15px;
            right: 15px;
            width: 25px;
            height: 25px;
        }

        /* Chatbox */
        #chatbox {
            display: flex;
            flex-direction: column;
            height: 100%; /* Ensure the chatbox takes full height */
            position: relative;
        }

        /* Messages Container */
        #messages {
            flex: 1;
            overflow-y: auto; /* Allow vertical scrolling */
            padding: 10px;
            border-radius: 10px;
            background-color: #fff;
            box-shadow: inset 0 1px 2px rgba(0, 0, 0, 0.1);
            display: flex;
            flex-direction: column;
            max-height: 400px; /* Ensure the messages container stays within bounds */
        }

        /* Message Styles */
        .message {
            border-radius: 10px;
            padding: 10px;
            margin: 5px 0;
            max-width: 75%;
        }

        .message.user {
            background-color: #007bff;
            color: #fff;
            align-self: flex-end;
        }

        .message.bot {
            background-color: #e1e1e1;
            color: #333;
            align-self: flex-start;
        }

        /* Input Area */
        #inputArea {
            padding: 10px;
            background-color: #f1f1f1;
            border-top: 1px solid #ccc;
            box-sizing: border-box;
            display: flex; /* Ensure input and button are inline */
        }

        #userInput {
            width: calc(100% - 80px); /* Adjust width to fit button */
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 20px;
            margin-right: 10px;
        }

        button {
            padding: 10px 15px;
            border: none;
            border-radius: 20px;
            background-color: #b12525;
            color: #fff;
            cursor: pointer;
        }

        button:hover {
            background-color: #0056b3;
        }

        /* Chatbox Hidden Class */
        .hidden {
            display: none;
        }

        /* Smooth Scroll */
        #messages {
            scroll-behavior: smooth;
        }

        /* Go Home Button */
        .go-home-btn {
            margin-top: 20px;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            background-color: #b12525;
            color: #fff;
            font-size: 1.2em;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
            text-align: center;
            margin-bottom: 400px;
            margin-right: 500px;
        }
    </style>
</head>
<body>

    <h1>
        <span class="welcome-text">WELCOME TO</span> 
        <span class="college-name">JMCT POLYTECHNIC</span>
    </h1>
    <a href="index.php" class="go-home-btn">Go Home</a>

    <!-- Chatbot Container -->
    <div id="chatbot">
        <div id="chatHeader" onclick="toggleChat()">
            Chat with us!
            <img src="images/chatbot.png" alt="Chat Icon" />
        </div>
        <div id="chatbox" class="hidden">
            <div id="messages"></div>
            <div id="inputArea">
                <input type="text" id="userInput" placeholder="Type a message..." />
                <button onclick="sendMessage()">Send</button>
            </div>
        </div>
    </div>

    <script>
     function toggleChat() {
    const chatbox = document.getElementById('chatbox');
    chatbox.classList.toggle('hidden');
}

function sendMessage() {
    const userInput = document.getElementById('userInput').value;
    const messagesDiv = document.getElementById('messages');

    // Display user message
    if (userInput.trim() !== '') {
        messagesDiv.innerHTML += `<div class="message user">User: ${userInput}</div>`;
        
        // Simulate bot response
        let responseMessage = '';
        const inputLower = userInput.toLowerCase();
        const greetings = ['hello', 'hi', 'hey', 'good morning', 'good afternoon', 'good evening'];
        
        if (greetings.some(greeting => inputLower.includes(greeting))) {
            responseMessage = 'Hello! How can I assist you today?';
        } else if (inputLower.includes('college name')) {
            responseMessage = 'The name of the college is JMCT Polytechnic.';
        } else if (inputLower.includes('address')) {
            responseMessage = 'The address of the college is Wadala Road, Nashik.';
        } else if (inputLower.includes('branches')) {
            responseMessage = 'Our college has the following branches: Computer, Civil, Mechanical, Automobile, and EJ.';
        } else if (inputLower.includes('timing') || inputLower.includes('hours')) {
            responseMessage = 'The college timing is from 8:30 AM to 3:30 PM.';
        } else if (inputLower.includes('campus')) {
            responseMessage = 'The college campus is great.';
        } else if (inputLower.includes('staff')) {
            responseMessage = 'We have the best and highly qualified teachers.';
        } else if (inputLower.includes('safe') || inputLower.includes('security')) {
            responseMessage = 'Our college is safe, and we have excellent security guards.';
        } else if (inputLower.includes('fees')) {
            responseMessage = 'The fee depends on the year you are enrolling in.';
        } else if (inputLower.includes('1st') || inputLower.includes('first year')) {
            responseMessage = 'The fee for the first year is 30,000, which can be paid in 3 installments.';
        } else if (inputLower.includes('2nd') || inputLower.includes('second year')) {
            responseMessage = 'The fee for the second year is 30,000, which can be paid in 3 installments.';
        } else {
            responseMessage = 'I’m not sure about that. Please visit our help page for more information.';
        }

        setTimeout(() => {
            messagesDiv.innerHTML += `<div class="message bot">Bot: ${responseMessage}</div>`;
            messagesDiv.scrollTop = messagesDiv.scrollHeight; // Scroll to the bottom
        }, 500); // Simulate response delay

        // Clear user input
        document.getElementById('userInput').value = '';
    }
}
</script>
</body>
</html>
