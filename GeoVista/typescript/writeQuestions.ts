interface Question {
    id_question: number,
    q_desc: string,
    answers: {
        id_answer: number,
        a_desc: string,
        isCorrectAnswer: number
    }[],
    image: string
}

let currentQuestionIndex: number = 0;
let countCorrectAnswers: number = 0;

function isQuizFinished(questions: Question[]): boolean {
    return currentQuestionIndex >= questions.length;
}

function updateProgressBar(questions: Question[]): void {
    const progressBar = document.getElementById('progressBar') as HTMLProgressElement;
    progressBar.style.width = `${((currentQuestionIndex + 1) / questions.length) * 100}%`;
}

function createQuestion(questions: Question[]): void {
    updateProgressBar(questions);
    const currentQuestion = questions[currentQuestionIndex];

    const mainContent = document.getElementById('mainContent') as HTMLDivElement;
    mainContent.innerHTML = ""; //Clear the main content

    const form = document.createElement('form');
    form.id = 'questionForm';
    form.action = window.location.href; // Formular-Action, dynamisch gesetzt
    form.method = 'GET';
    form.classList.add('card', 'my-2');

    const hiddenQuizID = document.createElement('input');
    hiddenQuizID.type = 'hidden';
    hiddenQuizID.name = 'quiz';
    const quizID = document.getElementById('quizId')?.getAttribute('data-quizId') as string || '';
    hiddenQuizID.value = quizID;
    form.appendChild(hiddenQuizID);

    //Card Image
    if (currentQuestion.image) {
        const container = document.createElement('div');
        container.className = 'mx-auto w-100 mb-4'; // centers and adds spacing
        container.style.maxWidth = '400px'; // max size like the image
        form.appendChild(container);

        if (quizID === '1' || quizID === '4') {
            const mapContainer = document.createElement('div');
            mapContainer.id = 'map';
            mapContainer.className = 'w-100 rounded border'; // responsive width
            mapContainer.style.height = '300px'; // fixed height to display map properly
            container.appendChild(mapContainer);

            const script = document.createElement('script');
            script.type = 'module';
            script.innerHTML = `
            import { getLeafletModule, loadCountryData } from './res/scripts/map_display.js';

            const map = getLeafletModule(document.getElementById('map'), 
                'https://{s}.basemaps.cartocdn.com/light_nolabels/{z}/{x}/{y}.png', 
                ${quizID === '4' ? 'false' : 'true'});

            loadCountryData(map, "${currentQuestion.image}");
        `;
            form.appendChild(script);

        } else {
            const imageElement = document.createElement('img');
            imageElement.className = 'img-fluid rounded border'; // Bootstrap responsive image
            imageElement.src = currentQuestion.image;
            imageElement.alt = `Bild zu Frage ${currentQuestion.id_question}`;
            container.appendChild(imageElement);
        }
    }


    //Card Body
    const cardBody = document.createElement('div');
    cardBody.classList.add('card-body');

    const questionTitle = document.createElement('h5');
    questionTitle.classList.add('card-title');
    questionTitle.textContent = `Frage ${currentQuestionIndex + 1}`;

    const questionDesc = document.createElement('p');
    questionDesc.classList.add('card-text');
    questionDesc.textContent = currentQuestion.q_desc;

    //Answers
    const answerSection = document.createElement('section');
    currentQuestion.answers.forEach(answer => {
        const radioInput = document.createElement('input');
        radioInput.type = 'radio';
        radioInput.id = answer.id_answer.toString();
        radioInput.name = `question${currentQuestion.id_question}`;
        radioInput.value = answer.a_desc;
        radioInput.setAttribute('data-correct', answer.isCorrectAnswer === 1 ? 'true' : 'false');
        radioInput.required = true;

        const label = document.createElement('label');
        label.setAttribute('for', answer.id_answer.toString());
        label.textContent = answer.a_desc;
        label.classList.add('form-check-label', 'ms-2');

        answerSection.appendChild(radioInput);
        answerSection.appendChild(label);
        answerSection.appendChild(document.createElement('br'));
    });

    cardBody.appendChild(questionTitle);
    cardBody.appendChild(questionDesc);
    cardBody.appendChild(answerSection);

    //Button for checking the question
    const submitButton = document.createElement('button');
    submitButton.id = 'checkQuestionButton';
    submitButton.type = 'submit';
    submitButton.classList.add('btn', 'btn-primary');
    //submitButton.value = '1';
    submitButton.textContent = 'Prüfen';
    evaluateQuestion(submitButton, answerSection, questions);

    form.appendChild(cardBody);
    form.appendChild(submitButton);
    mainContent.appendChild(form);
}

function evaluateQuestion(checkQuestionButton: HTMLButtonElement, answerSection: HTMLElement, questions: Question[]): void {
    const mainContent = document.getElementById('mainContent') as HTMLDivElement;
    const radios = answerSection.querySelectorAll<HTMLInputElement>('input[type="radio"]'); //Select all radio buttons in the form

    checkQuestionButton.addEventListener("click", (event) => {
        event.preventDefault();
        checkQuestionButton.disabled = true;
        let answeredCorrectly = false;

        //Find the selected one
        radios.forEach(radio => {
            radio.setAttribute("disabled", "true"); //disable all radio buttons after selection
            const label = document.querySelector<HTMLLabelElement>('label[for="' + radio.id + '"]');
            if (radio.checked) {
                if (radio.getAttribute("data-correct") === "true") {
                    answeredCorrectly = true;
                    label?.classList.add("bg-success");
                    countCorrectAnswers++;
                } else {
                    label?.classList.add("bg-danger");
                }
            }

            //Highlight correct answer
            if (radio.getAttribute("data-correct") === "true" && !answeredCorrectly) label?.classList.add("bg-success");
        });

        if (!document.getElementById("evaluationText")) {
            const evaluationText = document.createElement("div") as HTMLDivElement;
            evaluationText.classList.add("alert", "m-2", "text-center");
            evaluationText.classList.add(answeredCorrectly ? "alert-success" : "alert-danger");
            evaluationText.id = "evaluationText";
            evaluationText.innerHTML = answeredCorrectly ? "Richtig beantwortet!" : "Falsch beantwortet!";
            mainContent.appendChild(evaluationText);
        }

        if (!document.getElementById("nextButton")) {
            nextQuestion(questions);
        }
    });
}

function nextQuestion(questions: Question[]): void {
    const mainContent = document.getElementById('mainContent') as HTMLDivElement;

    const buttonContainer = document.createElement("div") as HTMLDivElement;
    buttonContainer.classList.add("text-center", "mt-4", "mb-3");

    const nextButton = document.createElement("button") as HTMLButtonElement;
    nextButton.type = "submit";
    nextButton.classList.add("btn", "btn-primary", "px-4");
    nextButton.name = "next";
    //nextButton.value = "1";
    nextButton.id = "nextButton";
    nextButton.innerHTML = "Weiter";
    nextButton.addEventListener("click", () => {
        currentQuestionIndex++;
        handleQuiz(questions);
    });

    buttonContainer.appendChild(nextButton);
    mainContent.appendChild(buttonContainer);
}

function createQuizEvaluation(questions: Question[]): void {
    const mainContent = document.getElementById('mainContent') as HTMLDivElement;
    mainContent.innerHTML = ""; //Clear the main content

    const percentScore: number = (countCorrectAnswers / questions.length) * 100;
    const passingText: string = percentScore >= 50 ? "Gut gemacht, du hast bestanden!" : "Leider hast du nicht bestanden! Nächstes Mal wird es besser!";
    const passingIcon: string = percentScore >= 50 ? "✔" : "✘";
    const passingClass: string = percentScore >= 50 ? "text-success" : "text-danger";

    const evaluationText = document.createElement("div") as HTMLDivElement;
    evaluationText.className = "bg-white text-dark p-5 rounded shadow text-center";
    evaluationText.style.maxWidth = "800px";
    evaluationText.style.minHeight = "50px";
    evaluationText.style.width = "80vw";
    evaluationText.innerHTML = `
      <h2 class="mb-4">Quiz Ergebnisse</h2>
      <div class="display-4 ${passingClass} mb-3">${passingIcon}</div>
      <p class="mb-4">${passingText}</p>
  
      <div class="row mb-4">
        <div class="col-12 col-md-6 mb-3 mb-md-0">
          <div class="border rounded p-3 bg-light">
            <div class="text-muted small">DEIN ERGEBNISS</div>
            <div class="fs-2 fw-bold ${passingClass}">${percentScore.toFixed(2)}%</div>
            <div class="text-muted small">BENÖTIGT: 50%</div>
          </div>
        </div>
        <div class="col-12 col-md-6 mb-3 mb-md-0">
          <div class="border rounded p-3 bg-light">
            <div class="text-muted small">DEINE PUNKTE</div>
            <div class="fs-2 fw-bold ${passingClass}">${countCorrectAnswers}</div>
            <div class="text-muted small">BENÖTIGT: ${(questions.length / 2).toFixed(0)}</div>
          </div>
        </div>
      </div>
      `;
    mainContent.appendChild(evaluationText);
}


function handleQuiz(questions: Question[]): void {
    if (!isQuizFinished(questions)) {
        createQuestion(questions);
    } else {
        createQuizEvaluation(questions);
    }
}

document.addEventListener("DOMContentLoaded", function () {

    //if quiz is reloaded, redirect to index.php
    const reloaded = sessionStorage.getItem("quizReloaded");
    if (performance.navigation.type === performance.navigation.TYPE_RELOAD) {
        //Real Reload:
        if (reloaded) {
            sessionStorage.removeItem("quizReloaded");
            window.location.href = "./index.php";
        }
    } else {
        //Normally laoded after selecting quiz on index.php:
        sessionStorage.setItem("quizReloaded", "true");
    }

    const questionsContainer = document.getElementById('questionsContainer') as HTMLDivElement;
    const questions: Question[] = JSON.parse(questionsContainer.dataset.questions!);
    handleQuiz(questions);
});