"use strict";
document.addEventListener("DOMContentLoaded", function () {
    const questionForm = document.getElementById("questionForm");
    const checkQuestionButton = document.getElementById("checkQuestionButton");
    const radios = questionForm.querySelectorAll('input[type="radio"]'); //Select all radio buttons in the form
    const questionsContainer = document.getElementById('questionsContainer');
    const questions = JSON.parse(questionsContainer.dataset.questions);
    console.log(questions);
    //Initially disable check question button
    if (questionForm.getAttribute("quizState") === "active")
        checkQuestionButton.disabled = true;
    //Enable button when radio button is selected
    radios.forEach((radio) => {
        radio.addEventListener("change", () => checkQuestionButton.disabled = false);
    });
    if (questionForm.getAttribute("quizState") === "active") {
        checkQuestionButton.addEventListener("click", (event) => {
            event.preventDefault();
            checkQuestionButton.disabled = true;
            let answeredCorrectly = false;
            //Find the selected one
            radios.forEach((radio) => {
                radio.setAttribute("disabled", "true"); //disable all radio buttons after selection
                const label = document.querySelector('label[for="' + radio.id + '"]');
                if (radio.checked) {
                    if (radio.getAttribute("data-correct") === "true") {
                        answeredCorrectly = true;
                        label === null || label === void 0 ? void 0 : label.classList.add("bg-success");
                    }
                    else {
                        label === null || label === void 0 ? void 0 : label.classList.add("bg-danger");
                    }
                }
                //Highlight correct answer
                if (radio.getAttribute("data-correct") === "true" && !answeredCorrectly)
                    label === null || label === void 0 ? void 0 : label.classList.add("bg-success");
            });
            if (!document.getElementById("evaluationText")) {
                const evaluationText = document.createElement("div");
                evaluationText.classList.add("alert", "m-2", "text-center");
                evaluationText.classList.add(answeredCorrectly ? "alert-success" : "alert-danger");
                evaluationText.id = "evaluationText";
                evaluationText.innerHTML = answeredCorrectly ? "Richtig beantwortet!" : "Falsch beantwortet!";
                questionForm.appendChild(evaluationText);
            }
            if (!document.getElementById("nextButton")) {
                const nextButton = document.createElement("button");
                nextButton.type = "submit";
                nextButton.className = "btn btn-primary";
                nextButton.name = "next";
                nextButton.value = "1";
                nextButton.id = "nextButton";
                nextButton.innerHTML = "Weiter";
                questionForm.appendChild(nextButton);
                //radios.forEach((radio) => radio.removeAttribute("disabled")); //enable all radio buttons after selection
            }
        });
    }
});
