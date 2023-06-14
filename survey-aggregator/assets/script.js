document.addEventListener('DOMContentLoaded', function() {
    var addButton = document.querySelector('.btn-add-answer');
    var answerGroup = document.querySelector('.answer-group');

    addButton.addEventListener('click', function() {
        var answerItem = document.createElement('div');
        answerItem.className = 'answer-item';

        var answerInput = document.createElement('input');
        answerInput.type = 'text';
        answerInput.className = 'form-control';
        answerInput.name = 'answer[]';
        answerInput.required = true;

        var voteInput = document.createElement('input');
        voteInput.type = 'number';
        voteInput.className = 'form-control vote-input';
        voteInput.name = 'votes[]';
        voteInput.min = '0';

        answerItem.appendChild(answerInput);
        answerItem.appendChild(voteInput);
        answerGroup.appendChild(answerItem);
    });
});

function updateStatus() {
    var statusField = document.getElementById('statusField');
    var currentValue = statusField.value;

    if (currentValue === "1") {
        statusField.value = "0";
    } else {
        statusField.value = "1";
    }

    var form = document.querySelector('form');
    form.submit();
}

// Очищение адресной строки браузера до "/"
if (window.location.search === "?page=logout") {
    window.addEventListener("popstate", function (event) {
        window.location.href = "/";
    });

    window.history.pushState({ page: 1 }, "", "/");

    if (window.history.replaceState) {
        window.history.replaceState(null, null, window.location.href);
    }
}

var loginForm = document.getElementById("login");

if (loginForm) {
    loginForm.addEventListener("submit", function(event) {
        window.history.replaceState(null, null, "/");
    });
}