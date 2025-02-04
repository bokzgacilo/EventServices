<?php 
    include("dbconnect.php");

    // Check if form was submitted
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // Capture form data
        $firstName = $_POST['first-name'];
        $lastName = $_POST['last-name'];
        $email = $_POST['email'];
        $phone = $_POST['phone'];
        $theme = $_POST['theme'];
        $start = $_POST['start-time'];
        $end = $_POST['end-time'];
        $package = $_POST['package'];



        // Insert data into database
        $sql = "INSERT INTO tbl_info (first_name, last_name, email, phone, theme, start_time, end_time, package) 
                VALUES ('$firstName', '$lastName', '$email', '$phone', '$theme', '$start', '$end', '$package' )";

        if (mysqli_query($con, $sql)) {
            echo "<script type='text/javascript'>alert('Reservation submitted successfully!');</script>";
        } else {
            echo "Error: " . mysqli_error($con);
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../STYLES/index.css?v=<?php echo time(); ?>">
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display&display=swap" rel="stylesheet">
    <title>Reservation Form</title>
</head>
<body>
    <!-- <div class="reservation-form-container">
        <div class="back-Button">
            <a href="CustomerPage.html"><img src="../Pictures/backButton.png" alt="backButton"></a>
        </div>
        <div class="reservation-form">
            <h1>Reserve Now!</h1>
            
            <div class="separator"></div>
            <p>here at Queen and Knight event services</p>

            <form method="POST" action="index.php">
                <div class="form-group">
                    <label for="first-name">First Name:</label>
                    <input type="text" id="first-name" name="first-name" placeholder="Enter your first name" required>
                </div>
                <div class="form-group">
                    <label for="last-name">Last Name:</label>
                    <input type="text" id="last-name" name="last-name" placeholder="Enter your last name" required>
                </div>
                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" placeholder="Enter your email address" required>
                </div>
                <div class="form-group">
                    <label for="phone">Phone Number:</label>
                    <input type="text" id="phone" name="phone" placeholder="Enter your phone number" required>
                </div>

                <div class="form-group">
                    <label for="theme">Theme:</label>
                    <select id="theme" name="theme">
                        <option value="wedding">Wedding</option>
                        <option value="birthday">Birthday</option>
                        <option value="corporate">Debuts</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="start-time">Start Time:</label>
                    <input type="datetime-local" id="start-time" name="start-time" required>

                    <label for="end-time">End Time:</label>
                    <input type="datetime-local" id="end-time" name="end-time" required>
                </div>

                <div class="form-group">
                    <label for="package">Package:</label>
                    <select id="package" name="package">
                        <option value="" disabled selected>Select a package</option>
                        <option value="small">Small (1-50 pax)</option>
                        <option value="medium">Medium (50-200 pax)</option>
                        <option value="large">Large (200-1000 pax)</option>
                    </select>
                </div>


                <div class="form-group">
                    <label for="design">Upload Your Preferred Designs:</label>
                    <input type="file" id="design" name="design">
                </div>
                <button type="submit">Submit</button>
            </form>






            <div id="popup" class="popup-container">
                <div class="popup-content">
                    <img src="../Pictures/logo.png" alt="No Refund Reminder">
                    <button id="closePopup">Submit</button>
                </div>
            </div>

                <-- JAVA SCRIPT-->

            <script>
                document.querySelector('form').addEventListener('submit', function(event) {
                    event.preventDefault(); // Prevent form submission for now
                    document.getElementById('popup').style.display = 'flex'; // Show the pop-up
                });

                document.getElementById('closePopup').addEventListener('click', function() {
                    document.getElementById('popup').style.display = 'none'; // Close the pop-up
                });
            </script>

        </div>


    <div class="reservation-form-container">
        <form action="index.php" method="post">
            <div class="details">
                <h1>RESERVE NOW!</h1>
                <p>here at Queen and Knight event services</p>

                <div class="form-group">
                    <label for="first-name">First Name:</label><br>
                    <input type="text" id="first-name" name="first-name" placeholder="Enter your first name" required>
                </div>

                <div class="form-group">
                    <label for="last-name">Last Name:</label><br>
                    <input type="text" id="last-name" name="last-name" placeholder="Enter your last name" required>
                </div>
                
                <div class="form-group">
                    <label for="email">Email:</label><br>
                    <input type="email" id="email" name="email" placeholder="Enter your email address" required>
                </div>
                
                <div class="form-group">
                    <label for="phone">Phone Number:</label><br>
                    <input type="text" id="phone" name="phone" placeholder="Enter your phone number" required>
                </div><br>
                
                <div class="form-group">
                    <label for="theme">Theme</label><br>
                    <select id="theme" name="theme">
                        <option value="wedding">Wedding</option>
                        <option value="birthday">Birthday</option>
                        <option value="corporate">Debuts</option>
                    </select>
                </div>
                

                <!-- TIME START AND END TIME-->
                <div class="form-group">
                    <label for="start-time">Start Time:</label>
                    <input type="datetime-local" id="start-time" name="start-time" required>

                    <label for="end-time">End Time:</label>
                    <input type="datetime-local" id="end-time" name="end-time" required>
                </div>
                



                
                <div class="form-group">
                    <label for="package">Package</label><br>
                    <select id="package" name="package">
                        <option value="small_event">package 1</option>
                        <option value="medium_event">package 2</option>
                        <option value="medium_event">package 3</option>
                    </select>
                </div>
            </div>

            <div class="designs">
                

                <div class="prev-events">
                    <div class="events-slider">
                        <img src="../Pictures/PrevEvent1.jpg" alt="PrevEvent1.jpg">
                        <img src="../Pictures/PrevEvent2.jpg" alt="PrevEvent2.jpg">
                        <img src="../Pictures/PrevEvent3.jpg" alt="PrevEvent3.jpg">
                        <img src="../Pictures/PrevEvent4.jpg" alt="PrevEvent4.jpg">
                        <img src="../Pictures/PrevEvent5.jpg" alt="PrevEvent5.jpg">
                        <img src="../Pictures/PrevEvent6.jpg" alt="PrevEvent6.jpg">
                    </div>
                </div>
                
            </div>
            <div class="date">
                <div class="calendar">
                    <h2>January</h2>
                    <table>
                        <thead>
                            <tr>
                                <th>Sun</th>
                                <th>Mon</th>
                                <th>Tue</th>
                                <th>Wed</th>
                                <th>Thu</th>
                                <th>Fri</th>
                                <th>Sat</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>1</td>
                                <td>2</td>
                                <td>3</td>
                                <td>4</td>
                                <td>5</td>
                                <td>6</td>
                                <td>7</td>
                            </tr>
                            <tr>
                                <td>8</td>
                                <td>9</td>
                                <td>10</td>
                                <td>11</td>
                                <td>12</td>
                                <td>13</td>
                                <td>14</td>
                            </tr>
                            <tr>
                                <td>15</td>
                                <td>16</td>
                                <td>17</td>
                                <td>18</td>
                                <td>19</td>
                                <td>20</td>
                                <td>21</td>
                            </tr>
                            <tr>
                                <td>22</td>
                                <td>23</td>
                                <td>24</td>
                                <td>25</td>
                                <td>26</td>
                                <td>27</td>
                                <td>28</td>
                            </tr>
                            <tr>
                                <td>29</td>
                                <td>30</td>
                                <td>31</td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class= "separator"></div>

            <div class="announcement-container">
                <h2>Announcements</h2>
                <ul>
                    <li>Event booking for the next month is now open!</li>
                    <li>Special discounts available for early bird reservations.</li>
                    <li>New themes and designs coming soon. Stay tuned!</li>
                </ul>
            </div>

            <div class= "separator"></div>


                <div class="button-container">
                    <input class="button" type="reset" value="Cancel">
                    <input class="button" type="submit" value="Submit">
                </div>
                
            </div>
        </form>
    </div>
</body>
</html>
