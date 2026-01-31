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


// 2️⃣ Populate dropdown
const select = document.getElementById('book-select');
books.forEach(book => {
    const opt = document.createElement('option');
    opt.value = book;
    opt.innerText = book;
    select.appendChild(opt);
});


// 3️⃣ Handle quiz start
const startBtn = document.getElementById('start-quiz-btn');
const questionsArea = document.getElementById('questions-area');

startBtn.addEventListener('click', async () => {
    const userId = 1;
    const bookName = select.value;

    questionsArea.innerHTML = "<p>Loading questions...</p>";

    try {
        const response = await fetch(WEBHOOK_URL, {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ user_id: userId, book_name: bookName })
        });

        const data = await response.json();
        const questions = data.questions || [];

        if (questions.length === 0) {
            questionsArea.innerHTML = "<p>Geen vragen gevonden voor dit boek.</p>";
        } else {
            questionsArea.innerHTML = "";
            questions.forEach((q, index) => {
                const div = document.createElement('div');
                div.className = "question";
                div.innerHTML = `<p><strong>Vraag ${index + 1}:</strong> ${q}</p>`;
                questionsArea.appendChild(div);
            });
        }

    } catch (err) {
        console.error(err);
        questionsArea.innerHTML = "<p>Er is iets misgegaan bij het ophalen van de vragen.</p>";
    }
});
