<?php
include("api/connection.php");

$selected_user;

if (!isset($_GET['id'])) {
  $selected_user = 0;
} else {
  $selected_user = $_GET['id'];
}


$users = [];

$get_all_users = $conn->query("SELECT id, name FROM tbl_users WHERE type='customer'");
if ($get_all_users) {
  while ($row = $get_all_users->fetch_assoc()) {
    $users[] = $row;
  }
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <?php
  include 'reusables/asset_loader.php';
  ?>
  <title>Chats</title>
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

    document.querySelector(".btn-primary").addEventListener("click", async () => {
      let inputField = document.querySelector(".form-control");
      let message = inputField.value.trim();
      let userId = "<?php echo $selected_user; ?>";
      let userType = "admin";

      if (message === "") {
        alert("Message cannot be empty!");
        return;
      }

      // Prepare message data
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
      let messageClass = data.type === "admin" ? "admin-message" : "client-message";
      // Append new message
      document.querySelector(".chat-body").innerHTML += `
        <div class="chat-message ${messageClass}">
          <p>${data.message}</p></div>
      `;
      document.querySelector(".chat-body").scrollTop = document.querySelector(".chat-body").scrollHeight;
    });
  </script>
  <style>
    /* Default chat message styling */
    .chat-message {
      max-width: 70%;
      word-wrap: break-word;
      padding: 0.75rem 1.5rem;
      border-radius: 20px;
      font-size: 1rem;
    }

    /* Client (left-aligned) */
    .client-message {
      align-self: flex-start;
      background-color: #f1f1f1;
      color: #000;
    }

    /* Admin (right-aligned) */
    .admin-message {
      align-self: flex-end;
      background-color: #007bff;
      color: white;
    }

    .chat-body {
      display: flex;
      flex-direction: column;
      gap: 0.5rem;
      padding: 1rem;
      overflow-y: auto;
      height: 100%;
    }

    .list-user-item {
      padding: 1rem 0;
      text-decoration: None;
      color: #000;
      transition: 0.5s;
    }

    .list-user-item:not(.selected):hover {
      background-color: lightgray;
      padding: 1rem;
    }

    .selected {
      background-color: #000;
      color: #fff;
      padding: 1rem;
    }

    .card {
      height: calc(100vh - 2rem);
    }

    .card-body {
      flex: 1;
      display: flex;
      flex-direction: column;
      overflow: hidden;
    }

    .row {
      flex: 1;
      display: flex;
      overflow: hidden;
    }

    .col-4,
    .col-8 {
      height: 100%;
      overflow-y: auto;
      /* Enables scrolling within containers */
    }

    #chat-container {
      display: flex;
      flex-direction: column;
    }
  </style>
</head>

<body class="d-flex flex-row">
  <?php
  include 'reusables/sidebar.php';
  ?>
  <main>
    <div class="card">
      <div class="card-header">
        <h2 class="panel-title">Chats</h2>
      </div>
      <div class="card-body">
        <div class="row">
          <div class="col-4">
            <h4 class="panel-title">LIST</h4>
            <div class="d-flex flex-column pt-2">
              <?php
              if (count($users) === 0) {
                echo "<p>No user list to display</p>";
                exit();
              }

              foreach ($users as $user) {
                echo "
                    <a data-div=" . $user['id'] . " class='list-user-item' href='chats.php?id=" . $user['id'] . "'>" . $user['name'] . "</a>
                  ";
              }
              ?>
            </div>
          </div>
          <div class="col-8" id="chat-container">
            <h4 class="panel-title">CONVERSATION</h4>
            <div class="chat-body">

            </div>
            <div class="d-flex flex-row gap-4 mt-auto">
              <input type="text" class="form-control" placeholder="Message" />
              <button class="btn btn-primary">Send</button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </main>

  <script>
    $(document).ready(function() {
      const selected_user = <?php echo $selected_user; ?>;
      console.log(selected_user);

      if (selected_user === 0) {
        $("#chat-container").html("<p>No selected user.</p>")
      } else {
        $(`a[data-div='${selected_user}']`).addClass("selected");
      }
    });
  </script>
</body>

</html>