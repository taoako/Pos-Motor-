document.getElementById('saveCustomerButton').addEventListener('click', async () => {
    const customerData = {
        name: document.getElementById('customerName').value,
        email: document.getElementById('customerEmail').value,
        phone: document.getElementById('customerPhone').value,
        // Add other fields as necessary
    };

    try {
        const response = await fetch('/api/customers', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(customerData),
        });

        if (response.ok) {
            alert('Customer information saved successfully!');
        } else {
            alert('Failed to save customer information.');
        }
    } catch (error) {
        console.error('Error saving customer information:', error);
        alert('An error occurred while saving customer information.');
    }
});
