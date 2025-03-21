<style>
  .fab-container {
    display: flex;
    flex-direction: column;
    justify-content: flex-end;
    align-items: center;
    position: fixed;
    bottom: 30px;
    right: 30px;
    z-index: 500;
    background-color: #4ba2ff;
    border-radius: 50%;
    height: 50px;
    width: 50px;
  }

  .fab-content {
    display: none;
    flex-direction: column;
    height: 100%;
    width: 100%;
  }

  .fab-content-header {
    display: flex;
    flex-direction: row;
    align-items: center;
    justify-content: space-between;
    padding: 1rem;
    background: #f1f1f1;
    border-bottom: 1px solid #ddd;
  }

  .fab-content-body {
    flex-grow: 1;
    padding: 1rem;
    background: #fff;

    display: flex;
      flex-direction: column;
      gap: 0.5rem;
      overflow-y: auto;
      height: 100%;
  }

  .fab-content-footer {
    padding: 1rem;
    background: #f1f1f1;
    border-top: 1px solid #ddd;
    display: flex;
    flex-direction: row;
    align-items: center;
    gap: 1rem;
  }

  .fab-opened {
    height: 800px !important;
    width: 500px !important;
    border-radius: 5px !important;
    background-color: #fff !important;
  }

  .fab-content {
    display: none;
  }

  .fab-content.show {
    display: flex;
  }

  .chat-message {
    max-width: 70%;
    word-wrap: break-word;
    padding: 0.75rem 1.5rem;
    border-radius: 20px;
    font-size: 1rem;
  }

  .client-message {
    align-self: flex-end;
    background-color: #007bff;
    color: #fff;
  }

  .admin-message {
    align-self: flex-start;
    background-color: #f1f1f1;
    color: #000;
  }
</style>

<?php
$selected_user = $_SESSION['userid'];
?>

<script type="module">
  import {
    initializeApp
  } from "https://www.gstatic.com/firebasejs/11.4.0/firebase-app.js";
  import {
    getDatabase,
    ref,
    push,
    onChildAdded,
    serverTimestamp
  } from "https://www.gstatic.com/firebasejs/11.4.0/firebase-database.js";

  const firebaseConfig = {
    apiKey: "AIzaSyBFwNVETkSxOwaxb5fhNtnWJzOL3m_3V0E",
    authDomain: "eventservices-f8d9d.firebaseapp.com",
    databaseURL: "https://eventservices-f8d9d-default-rtdb.asia-southeast1.firebasedatabase.app",
    projectId: "eventservices-f8d9d",
    storageBucket: "eventservices-f8d9d.firebasestorage.app",
    messagingSenderId: "9287527457",
    appId: "1:9287527457:web:038f649b3846f2d9304760",
    measurementId: "G-KHMD17GRX1"
  };

  const app = initializeApp(firebaseConfig);
  const db = getDatabase(app)

  const chatRef = ref(db, "chats/<?php echo $selected_user; ?>");

  document.querySelector(".fab-content-footer .btn-primary").addEventListener("click", async () => {
    let inputField = document.querySelector(".fab-content-footer .message-field");
    let message = inputField.value.trim();
    let userId = "<?php echo $selected_user; ?>";
    let userType = "client";

    if (message === "") {
      alert("Message cannot be empty!");
      return;
    }

    let messageData = {
      timestamp: serverTimestamp(),
      message: message,
      user_id: userId,
      type: userType
    };

    // Push message to Firebase
    await push(chatRef, messageData);

    inputField.value = "";
  })

  // Listen for new messages in real time
  onChildAdded(chatRef, (snapshot) => {
    let data = snapshot.val();
    let messageClass = data.type === "client" ? "client-message" : "admin-message";
    // Append new message
    document.querySelector(".fab-content-body").innerHTML += `
        <div class="chat-message ${messageClass}">
          <p>${data.message}</p></div>
      `;
    document.querySelector(".fab-content-body").scrollTop = document.querySelector(".fab-content-body").scrollHeight;
  });
</script>

<div class="fab-container">
  <div class="fab-content">
    <div class="fab-content-header">
      <p>Chat With Admin</p>
      <button class="btn btn-primary btn-sm" id="minimize_button">Minimize</button>
    </div>
    <div class="fab-content-body"></div>
    <div class="fab-content-footer">
      <input type="text" class="form-control message-field" placeholder="Message...">
      <button class="btn btn-primary">Send</button>
    </div>
  </div>
</div>

<script>
  $(".fab-container").on("click", function() {
    $(this).addClass("fab-opened");
    $(".fab-content").addClass("show"); // Toggle visibility class
  });

  $(document).on("click", "#minimize_button", function() {
    $(".fab-container").removeClass("fab-opened");
    $(".fab-content").removeClass("show");
  });
</script>