const kioskForm = document.getElementById('kioskForm');
const kioskServiceType = document.getElementById('kioskServiceType');
const kioskPriority = document.getElementById('kioskPriority');
const kioskSubmit = document.getElementById('kioskSubmit');
const kioskResult = document.getElementById('kioskResult');
const kioskQueueNumber = document.getElementById('kioskQueueNumber');
const kioskError = document.getElementById('kioskError');

function showError(message) {
    kioskError.textContent = message;
    kioskError.classList.add('visible');
}

function hideError() {
    kioskError.textContent = '';
    kioskError.classList.remove('visible');
}

function showResult(queueNumber) {
    kioskQueueNumber.textContent = queueNumber;
    kioskResult.classList.add('visible');
}

if (kioskForm) {
    kioskForm.addEventListener('submit', async function (event) {
        event.preventDefault();
        hideError();

        const serviceType = kioskServiceType.value;
        const isPriority = kioskPriority.checked;

        if (!serviceType) {
            showError('Please select a service type.');
            return;
        }

        kioskSubmit.disabled = true;

        try {
            const response = await fetch('api/add_customer.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    service_type: serviceType,
                    is_priority: isPriority,
                }),
            });

            const data = await response.json();

            if (!response.ok || !data.success) {
                showError(data.message || 'Unable to generate queue number.');
                return;
            }

            showResult(data.queue_number || '---');
            kioskServiceType.value = '';
            kioskPriority.checked = false;
        } catch (error) {
            showError('Network error. Please try again.');
        } finally {
            kioskSubmit.disabled = false;
        }
    });
}
