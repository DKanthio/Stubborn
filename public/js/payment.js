// Récupérer les données du formulaire
var cardHolderName = document.getElementById('card-holder-name').value;
var address = document.getElementById('address').value;
var country = document.getElementById('country').value;
var paymentMethod = document.getElementById('payment-method').value;

// Créer un objet avec les données à envoyer
var paymentData = {
    payment_method: paymentMethod, // Utilisez la méthode de paiement récupérée depuis le champ caché
    billing_details: {
        name: cardHolderName,
        address: {
            line1: address,
            country: country
        }
    }
};


// Envoyer la requête au serveur Symfony
fetch('/process_payment', {
    method: 'POST',
    headers: {
        'Content-Type': 'application/json',
    },
    body: JSON.stringify(paymentData),
})
.then(function(response) {
    return response.json();
})
.then(function(data) {
    if (data.clientSecret) {
        // Si la requête est réussie, afficher un message de succès
        document.getElementById('payment-result').innerHTML = 'Paiement réussi !';
    } else {
        // Sinon, afficher un message d'erreur
        document.getElementById('payment-result').innerHTML = 'Erreur lors du paiement : ' + data.error;
    }
})
.catch(function(error) {
    console.error('Erreur lors de la requête : ', error);
});

