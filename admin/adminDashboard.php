<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Dashboard</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    .content {
      padding: 20px;
      flex-grow: 1;
    }
    .card-header {
      background-color: #202842;
      color: white;
    }
    .dashboard-container {
      margin-left: auto; 
      margin-right: auto;
      max-width: 800px; /* Adjust max width as needed */
    }
  </style>
</head>
<body>
  <div class="d-flex">
    <!-- Sidebar -->
    <?php require 'sidebar.php'; ?>

    <!-- Main Content -->
    <div class="content container mt-4">
      <h2 class="mb-4 text-center">Admin Dashboard</h2>

      <!-- Centered Cards -->
      <div class="dashboard-container">
        <div class="row justify-content-center me-6">
          <!-- Overview of Upcoming Events -->
          <div class="col-md-6">
            <div class="card mb-4">
              <div class="card-header bg-primary text-white">Upcoming Events</div>
              <div class="card-body">
                <ul class="list-group">
                  <li class="list-group-item">Conference on Web Development - Date: 2024-11-05</li>
                  <li class="list-group-item">Marketing Seminar - Date: 2024-11-12</li>
                  <li class="list-group-item">Business Growth Workshop - Date: 2024-12-01</li>
                </ul>
              </div>
            </div>
          </div>

          <!-- Summary of Registrations per Event -->
          <div class="col-md-6">
            <div class="card mb-4">
              <div class="card-header bg-success text-white">Registrations Summary</div>
              <div class="card-body">
                <table class="table">
                  <thead>
                    <tr>
                      <th>Event</th>
                      <th>Registrations</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td>Web Development</td>
                      <td>150</td>
                    </tr>
                    <tr>
                      <td>Marketing Seminar</td>
                      <td>120</td>
                    </tr>
                    <tr>
                      <td>Business Workshop</td>
                      <td>200</td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div> <!-- End of dashboard-container -->
    </div> <!-- End of content container -->
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
