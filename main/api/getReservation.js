async function fetchReservations() {
    try {
        const response = await fetch('api/ReservationData.php'); // Adjusted path
        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }
        const tbl_info = await response.json(); // Parse the JSON data
        console.log(tbl_info); // Log fetched reservations for debugging

        const reservationContainer = document.getElementById('pendingReservations');
        reservationContainer.innerHTML = ''; // Clear any existing content

        tbl_info.forEach(reservation => {
            const reservationBox = `
                <div class="pendingBox" data-id="${reservation.keyId}"> <!-- Ensure this is keyId -->
                    <div class="name"><h2>${reservation.first_name} ${reservation.last_name}</h2></div>
                    <div class="details">
                        <h2>THEME</h2>
                        <h3>${reservation.theme}</h3>
                    </div>
                    <div class="details">
                        <h2>VENUE</h2>
                        <h3>NONE</h3>
                    </div>
                    <div class="date">
                        <h2>DATE:</h2>
                        <h3>NONE</h3>
                    </div>
                    <div class="icons">
                        <div class="circle decline" onclick="deleteReservation(${reservation.keyId})"> <!-- Use keyId here -->
                            <span class="icon">✖</span>
                        </div>
                        <div class="circle accept">
                            <span class="icon">✔</span>
                        </div>
                    </div>
                </div>
            `;

            reservationContainer.insertAdjacentHTML('afterbegin', reservationBox);
        });
    } catch (error) {
        console.error('Error fetching reservation data:', error);
    }
}

async function deleteReservation(reservationId) {
    console.log(`Deleting reservation with ID: ${reservationId}`); // Log the ID
    if (reservationId === undefined) {
        console.error("No reservation ID provided for deletion.");
        return; // Exit the function if ID is undefined
    }

    if (confirm("Are you sure you want to delete this reservation?")) {
        try {
            const response = await fetch('BACK/deleteReservation.php', { // Adjusted path
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: new URLSearchParams({ id: reservationId }) // Pass the reservation ID
            });

            const result = await response.text(); // Change to text to log the response
            console.log(result); // Log the full response text for debugging
            const jsonResult = JSON.parse(result); // Parse it only if it's valid JSON

            if (jsonResult.success) {
                // Remove the reservation box from the DOM
                const reservationBox = document.querySelector(`.pendingBox[data-id="${reservationId}"]`);
                if (reservationBox) {
                    reservationBox.remove(); // Remove the box
                }
            } else {
                alert("Failed to delete the reservation: " + jsonResult.message);
            }
        } catch (error) {
            console.error('Error deleting reservation:', error);
        }
    }
}

fetchReservations();
