<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../STYLES/DashboardStyle.css">
    <?php
      include 'reusables/asset_loader.php';
    ?>
    <title>Admin Dashboard</title>
</head>
<body>
    <div class="admin-dashboard">
      <div class="d-flex flex-column p-4 text-center">
        <?php
        include 'reusables/sidebar.php';
        ?>
      </div>

        <div class="main-content">
            <div class="bar">
              <h1>Admin Dashboard</h1>
            </div>
            <div class="container">
                <div class="dashboard-sections">
                    <div class="dashboard-card" onclick="location.href='Request.html'" onclick="saveCurrentPage()">
                        <img src="../images/Request2.png" alt="Reservation Icon">
                        <h2>Reservation Request</h2>
                        <button onclick="location.href='Request.html'">View</button>
                    </div>
                    <div class="dashboard-card" onclick="location.href='CustomerRecords.html'" onclick="saveCurrentPage()">
                        <img src="../images/Records.png" alt="Customer Icon">
                        <h2>Customer Records</h2>
                        <button  onclick="location.href='CustomerRecords.html'" onclick="saveCurrentPage()">View</button>
                    </div>
                    <div class="dashboard-card" onclick="location.href='Calendar.html'"  onclick="saveCurrentPage()">
                        <img src="../images/Calendar.png" alt="Calendar Icon" onclick="location.href='Calendar.html'"  onclick="saveCurrentPage()">
                        <h2>Calendar</h2>
                        <button onclick="location.href='Calendar.html'"  onclick="saveCurrentPage()">View</button>
                    </div>
                    <div class="dashboard-card" onclick="location.href='Reports.html'" onclick="saveCurrentPage()">
                        <img src="../images/ReportGen2.jpg" alt="Report Icon" onclick="location.href='Reports.html'" >
                        <h2>Report Generation</h2>
                        <button onclick="location.href='Reports.html'" onclick="saveCurrentPage()">View</button>
                    </div>
                </div>
            </div>
        </div>
        
    </div>
</body>
</html>
