// FIRST LINE ALWAYS
import { WEBHOOK_URL } from "./config.js";

// 1️⃣ List of books
const books = [
    "Beste mevrouw Eva",
    "De aanslag",
    "Het gouden ei",
    "De gezichtslozen",
    "Het diner",
    "Tirza",
    "Man maakt stuk",
];

// 2️⃣ Get elements
const select = document.getElementById("book-select");
const startBtn = document.getElementById("start-quiz-btn");
const questionsArea = document.getElementById("questions-area");

// 3️⃣ Populate dropdown
books.forEach(book => {
    const opt = document.createElement("option");
    opt.value = book;
    opt.innerText = book;
    select.appendChild(opt);
});

// 4️⃣ Handle quiz start
startBtn.addEventListener("click", async () => {
    const userId = 1;
    const bookName = select.value;

    // Show loading
    questionsArea.innerHTML = "<p>Loading questions...</p>";

    try {
        const response = await fetch(WEBHOOK_URL, {
            method: "POST",
            headers: { "Content-Type": "application/json" },
            body: JSON.stringify({ user_id: userId, book_name: bookName })
        });

        const data = await response.json();
        const questions = data.questions || [];

        if (questions.length === 0) {
            questionsArea.innerHTML = "<p>Geen vragen gevonden voor dit boek.</p>";
            return;
        }

        // Clear old quiz
        questionsArea.innerHTML = "";

        // Build questions
        questions.forEach((q, index) => {
            const div = document.createElement("div");
            div.className = "question";

            // Question text
            const title = document.createElement("p");
            title.innerHTML = `<strong>Vraag ${index + 1}:</strong> ${q.question}`;
            div.appendChild(title);

            // Answer buttons
            q.options.forEach((option, i) => {
                const btn = document.createElement("button");
                btn.innerText = option;

                btn.addEventListener("click", () => {
                    // disable all buttons after first click
                    const buttons = div.querySelectorAll("button");
                    buttons.forEach(b => b.disabled = true);

                    if (i === q.answer) {
                        btn.style.backgroundColor = "lightgreen";
                    } else {
                        btn.style.backgroundColor = "salmon";
                        // show correct answer
                        buttons[q.answer].style.backgroundColor = "lightgreen";
                    }
                });

                div.appendChild(btn);
            });

            questionsArea.appendChild(div);
        });

    } catch (err) {
        console.error(err);
        questionsArea.innerHTML = "<p>Er is iets misgegaan bij het ophalen van de vragen.</p>";
    }
});
