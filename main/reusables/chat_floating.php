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
    flex-direction: column;
    gap: 1rem;
  }

  .chat-form {
    display: flex;
    flex-direction: row;
    align-items: center;
    justify-content: space-between;
    gap: 1rem;
  }

  .chat-form  > input {
    flex: 1;
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

  @media (max-width: 700px) {
    .fab-opened {
      width: 100% !important;
      right: 0;
      top: 0;
      height: 100vh !important;
    }
  }

  .chat-image-preview {
    width: 100%;
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(150px, 1fr)); /* Dynamic columns */
    justify-items: center; /* Center items horizontally */
    align-items: center; /* Center items vertically */
    gap: 1rem; /* Space between grid items (images) */
  }


  .chat-image-preview > img {
    width: 100%;
    height: 150px;
    object-fit: cover;
    border-radius: 5px;
  }
</style>

<?php
$selected_user = $_SESSION['userid'];
?>
<script>
  function compressImageToBase64(file, quality = 0.7, maxWidth = 800) {
    return new Promise((resolve, reject) => {
    const reader = new FileReader();

    reader.onload = function (event) {
      const img = new Image();
      img.onload = function () {
        const canvas = document.createElement('canvas');
        let width = img.width;
        let height = img.height;

        if (width > maxWidth) {
          height *= maxWidth / width;
          width = maxWidth;
        }

        canvas.width = width;
        canvas.height = height;

        const ctx = canvas.getContext('2d');
        ctx.drawImage(img, 0, 0, width, height);

        // Get compressed Base64 string
        const base64 = canvas.toDataURL('image/jpeg', quality);
        resolve(base64);
      };

      img.onerror = reject;
      img.src = event.target.result;
    };

    reader.onerror = reject;
    reader.readAsDataURL(file);
  });
}



</script>


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

  document.querySelector("#upload-picture").addEventListener("click", () => {
    document.querySelector('#image-input').click();
  })

  var selectedBase64Images = [];

  document.querySelector('#image-input').addEventListener('change', async function (e) {
    const files = e.target.files;
    const previewContainer = document.querySelector('.preview-container');
    previewContainer.innerHTML = ''; // Clear previous previews
    // const selectedBase64Images = []; // Reset base64 storage

    if (files.length > 3) {
      alert("You can only upload up to 3 images.");
      return;
    }

    for (const file of files) {
      if (!file.type.startsWith('image/')) continue;

      try {
        const base64 = await compressImageToBase64(file, 0.5, 800);
        selectedBase64Images.push(base64);
        const img = document.createElement('img');
        img.src = base64;
        img.style.width = '80px';
        img.style.margin = '5px';
        img.style.borderRadius = '5px';
        previewContainer.appendChild(img);
      } catch (err) {
        console.error('Compression to base64 failed for file:', file.name, err);
      }
    }
  });

  document.querySelector(".fab-content-footer #send-button").addEventListener("click", async () => {
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
      type: userType,
      images: selectedBase64Images
    };

    await push(chatRef, messageData);
    document.querySelector('.preview-container').innerHTML = '';
    inputField.value = "";
  })

  // Listen for new messages in real time
  onChildAdded(chatRef, (snapshot) => {
    let data = snapshot.val();
    let messageClass = data.type === "client" ? "client-message" : "admin-message";
    // Append new message
    document.querySelector(".fab-content-body").innerHTML += `
      <div class="chat-message ${messageClass}">
        <p>${data.message}</p>
      </div>

       ${data.images && data.images.length > 0 ? 
        `<div class="chat-image-preview">
          ${data.images.map(base64Image => 
            `<img src="${base64Image}" />`
          ).join('')}
        </div>` 
        : ''
      }
    `;
    document.querySelector(".fab-content-body").scrollTop = document.querySelector(".fab-content-body").scrollHeight;
  });
</script>

<div class="fab-container">
  <div class="fab-content">
    <div class="fab-content-header">
      <p>Chat With Admin</p>
      <button class="btn btn-primary btn-sm" id="minimize_button">Close</button>
    </div>
    <div class="fab-content-body"></div>
    <div class="fab-content-footer">
      <div class="preview-container">

      </div>
      <div class="chat-form">
       <input type="file" id="image-input" accept="image/*" multiple style="display: none;">
        <button class="btn btn-primary" id="upload-picture">Upload</button>
        <input type="text" class="form-control message-field" placeholder="Message...">
        <button class="btn btn-primary" id="send-button">Send</button>
      </div>
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

