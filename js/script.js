function getCurrentRate() {
    fetch('/api/rate')
        .then(response => response.text())
        .then(rate => {
            document.getElementById('rateResult').textContent = rate;
        })
        .catch(error => {
            console.error('Failed to get rate:', error);
        });
}

function subscribeEmail() {
    const email = document.getElementById('emailInput').value;

    if (!validateEmail(email)) {
        document.getElementById('subscribeResult').textContent = 'Invalid email address.';
        document.getElementById('subscribeResult').classList.add('error');
        clearNotification('subscribeResult');
        return;
    }

    fetch('/api/subscribe', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({ email: email })
    })
        .then(response => response.text())
        .then(result => {
            document.getElementById('subscribeResult').textContent = result;
            if (result === 'Subscribed successfully.')
                document.getElementById('subscribeResult').classList.add('success');
            else
                document.getElementById('subscribeResult').classList.add('error');
            console.log('Subscribed:', result);
            clearNotification('subscribeResult');
        })
        .catch(error => {
            document.getElementById('subscribeResult').textContent = result;
            document.getElementById('subscribeResult').classList.add('error');
            clearNotification('subscribeResult');
            console.error('Failed to subscribe:', error);
        });
}

function sendRateEmails() {
    fetch('/api/sendEmails', {
        method: 'POST'
    })
        .then(response => response.text())
        .then(result => {
            document.getElementById('sendEmailsResult').textContent = result;
            clearNotification('sendEmailsResult');
        })
        .catch(error => {
            console.error('Failed to send emails:', error);
        });
}

function validateEmail(email) {
    return /\S+@\S+\.\S+/.test(email);
}

function clearNotification(elementId) {
    const notificationElement = document.getElementById(elementId);
    setTimeout(function () {
        notificationElement.textContent = '';
        notificationElement.classList.remove('success');
        notificationElement.classList.remove('error');
    }, 3000);
}